<?php
namespace App\Http\Controllers\App;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BackupController extends Controller
{
    public function getIndex()
    {
        $this->authorize('view-backups');

        return view('app.backup.index')->with([
            'backups' => $this->getDetailsForBackups(\Storage::disk('gdrive')->listContents('backups')),
        ]);
    }

    public function getDownload(Request $request)
    {
        $this->authorize('download-backups');

        $filename = str_replace(' ', '+', $request->get('filename'));
        $fielpath = 'backups/'.$filename;
        if(\Storage::disk('gdrive')->has($fielpath)) {
            $response = new StreamedResponse();

            $response->setCallBack(function() use ($fielpath) {
                echo \Storage::disk('gdrive')->get($fielpath);
            });

            $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);
            $response->headers->set('Content-Disposition', $disposition);

            return $response;
        } else {
            abort(404);
        }
    }

    public function getDelete(Request $request)
    {
        $this->authorize('delete-backups');

        $filename = str_replace(' ', '+', $request->get('filename'));
        $fielpath = 'backups/'.$filename;
        if(\Storage::disk('gdrive')->has($fielpath)) {
            \Storage::disk('gdrive')->delete($fielpath);

            return back();
        } else {
            abort(404);
        }
    }

    protected function getDetailsForBackups($backups)
    {
        foreach($backups as &$backup) {
            $backup['carbon'] = Carbon::createFromTimestampUTC($backup['timestamp']);
            $backup['display_size'] = \Formatter::getMBbyB($backup['size']);
        }
        return $backups;
    }
}
