<?php
namespace App\Providers;

use Storage;
use Google_Client;
use Google_Cache_File;
use Google_Service_Drive;
use League\Flysystem\Filesystem;
use App\Libs\GoogleDriveAdapter;
use Illuminate\Support\ServiceProvider;

class GoogleDriveServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('gdrive', function($app, $config) {
            $client = new Google_Client();
            $client->setAuthConfig($config['authfile']);
            $client->addScope('https://www.googleapis.com/auth/drive');
            $client->setSubject($config['subject']);
            $client->setCache(new Google_Cache_File($config['cachepath']));

            return new Filesystem(new GoogleDriveAdapter(new Google_Service_Drive($client)));
        });
    }

    public function register()
    {
        //
    }
}
