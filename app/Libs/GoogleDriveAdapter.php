<?php
namespace App\Libs;

use Carbon\Carbon;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;

use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Config;
use League\Flysystem\Util;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FileExistsException;

class GoogleDriveAdapter extends AbstractAdapter
{
    protected $service;
    protected $baseFolderId = null;

    public function __construct(Google_Service_Drive $service, $prefix = null)
    {
        $this->service = $service;

        $this->setPathPrefix($prefix);
    }

    public function setPathPrefix($prefix)
    {
        parent::setPathPrefix($prefix);

        if ($prefix !== null) {
            $this->baseFolderId = $this->getDirectory($prefix);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | File actions
    |--------------------------------------------------------------------------
    */

    public function has($path)
    {
        return $this->getFileId($path) !== null;
    }

    public function write($path, $contents, Config $config)
    {
        $fileName = $this->getFilenameByPath($path);
        $pathInfo = pathinfo($path);

        $parentId = $this->getDirectory($pathInfo['dirname']);

        $file = new Google_Service_Drive_DriveFile();
        $file->setTitle($fileName);
        $file->setParents([
            [
                'kind' => 'drive#fileLink',
                'id' => $parentId
            ]
        ]);

        $result = $this->service->files->insert($file, array(
            'data' => $contents,
            'uploadType' => 'media',
        ));

        return $this->normalizeResponse($result, $path);
    }

    public function writeStream($path, $resource, Config $config)
    {
        // ToDo
    }

    public function update($path, $contents, Config $config)
    {
        if (!$this->has($path)) {
            return false;
        }
        $fileName = $this->getFilenameByPath($path);
        $pathInfo = pathinfo($path);

        $parentId = $this->getDirectory($pathInfo['dirname']);

        $file = new Google_Service_Drive_DriveFile();
        $file->setTitle($fileName);
        $file->setParents([
            [
                'kind' => 'drive#fileLink',
                'id' => $parentId
            ]
        ]);


        $fileId = $this->getFileId($path);
        if (!is_null($fileId)) {
            $result = $this->service->files->update($fileId, $file, array(
                'data' => $contents,
                'uploadType' => 'media',
            ));

            return $this->normalizeResponse($result, $path);
        }
        return false;
    }

    public function updateStream($path, $resource, Config $config)
    {
        // ToDo
    }

    public function delete($path)
    {
        if (!$this->has($path)) {
            return false;
        }

        $fileId = $this->getFileId($path);
        if (!is_null($fileId)) {
            $result = $this->service->files->trash($fileId);
            return $this->normalizeResponse($result->getLabels()->getTrashed(), $path);
        }
        return false;
    }

    public function read($path)
    {
        if ($this->has($path)) {
            $fileId = $this->getFileId($path);
            if (!is_null($fileId)) {
                $response = $this->service->files->get($fileId, [
                    'alt' => 'media'
                ]);
                if ($response->getStatusCode() == 200) {
                    $contents = $response->getBody()->__toString();
                    return compact('contents', 'path');
                }
            }
        }

        return false;
    }

    public function readStream($path)
    {
        // ToDo
    }

    public function rename($path, $newpath)
    {
        // ToDo
    }

    public function copy($path, $newpath)
    {
        // ToDo
    }

    public function getMimetype($path)
    {
        // ToDo
    }

    public function getTimestamp($path)
    {
        // ToDo
    }

    public function setVisibility($path, $visibility)
    {
        // ToDo
    }

    public function getVisibility($path)
    {
        // ToDo
    }

    /*
    |--------------------------------------------------------------------------
    | Folder & Combined actions
    |--------------------------------------------------------------------------
    */

    public function listContents($directory = '', $recursive = false)
    {
        $parentId = null;

        if (!empty($directory)) {
            $parentId = $this->getDirectory($directory, false);
        }

        if (is_null($parentId) && $this->baseFolderId !== null) {
            $parentId = $this->baseFolderId;
        }

        $q = vsprintf('trashed = false and "%s" in parents', [
            $parentId,
        ]);

        $result = $this->service->files->listFiles(array(
            'q' => $q,
        ))->getItems();

        $files = [];
        foreach($result as $file) {
            if($file instanceof Google_Service_Drive_DriveFile) {
                $parents = $file->getParents();
                $folder = '';
                foreach($parents as $parent) {
                    if ($parent instanceof \Google_Service_Drive_ParentReference) {
                        $parent = $this->service->files->get($parent->getId());
                        if($parent instanceof Google_Service_Drive_DriveFile) {
                            $folder .= $parent->getTitle() . '/';
                        }
                    }
                }
                $folder = trim($folder, '/') . '/';
                $files[] = [
                    'type' => 'file',
                    'path' => $folder . $file->getOriginalFilename(),
                    'size' => $file->getFileSize() * 1,
                    'timestamp' => strtotime($file->getModifiedDate()),
                ];
            }
        }
        return $files;
    }

    public function createDir($dirname, Config $config)
    {
        $folderId = $this->getDirectory($dirname, false);

        if ($folderId) {
            throw new FileExistsException($dirname);
        }

        return $this->getDirectory($dirname);
    }

    public function deleteDir($dirname)
    {
        $folderId = $this->getDirectory($dirname, false);

        if (!$folderId) {
            throw new FileNotFoundException($dirname);
        }

        return $this->service->files->trash($folderId);
    }

    public function getMetadata($path)
    {
        // ToDo
    }

    public function getSize($path)
    {
        // ToDo
    }

    /*
    |--------------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------------
    */

    protected function getDirectory($path, $create = true)
    {
        $parts = explode('/', trim($path, '/'));
        $folderId = $this->baseFolderId;
        $parentFolderId = $this->baseFolderId;

        foreach ($parts as $name) {
            $folderId = $this->getDirectoryId($name, $folderId);

            if (!$folderId) {
                if ($create) {
                    $folder = $this->createDirectory($name, $parentFolderId);
                    $folderId = $folder->id;
                } else {
                    return false;
                }
            }

            $parentFolderId = $folderId;
        }

        if (!$folderId) {
            return false;
        }

        return $folderId;
    }

    protected function getDirectoryId($name, $parentId = null)
    {
        if (is_null($parentId) && $this->baseFolderId !== null) {
            $parentId = $this->baseFolderId;
        }

        $q = 'mimeType="application/vnd.google-apps.folder" and title = "' . $name . '" and trashed = false';

        if (!is_null($parentId)) {
            $q .= sprintf(' and "%s" in parents', $parentId);
        }

        $folders = $this->service->files->listFiles(array(
            'q' => $q,
        ))->getItems();

        if (count($folders) == 0) {
            return null;
        } else {
            return $folders[0]->id;
        }
    }

    protected function getFileId($path)
    {
        $parentId = null;
        $fileName = $this->getFilenameByPath($path);
        $pathInfo = pathinfo($path);

        if (!empty($pathInfo['dirname'])) {
            $parentId = $this->getDirectory($pathInfo['dirname'], false);
        }

        if (is_null($parentId) && $this->baseFolderId !== null) {
            $parentId = $this->baseFolderId;
        }

        $q = vsprintf('title = "%s" and trashed = false and "%s" in parents', [
            $fileName,
            $parentId,
        ]);

        try {
            $files = $this->service->files->listFiles(array(
                'q' => $q,
            ))->getItems();
        } catch (\Google_Service_Exception $e) {
            return null;
        }

        if (count($files) == 0) {
            return null;
        } else {
            return $files[0]->id;
        }
    }

    protected function getFilenameByPath($path)
    {
        $paths = explode('/', $path);
        return array_pop($paths);
    }

    protected function createDirectory($name, $parentId = null)
    {
        $file = new Google_Service_Drive_DriveFile();
        $file->setTitle($name);
        $file->setParents([
            [
                'id' => $parentId
            ]
        ]);
        $file->setMimeType('application/vnd.google-apps.folder');

        return $this->service->files->insert($file);
    }

    protected function normalizeResponse($response, $path = null)
    {
        return $response;
    }
}
