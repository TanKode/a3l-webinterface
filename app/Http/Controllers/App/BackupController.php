<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class BackupController extends Controller
{
    public function __construct()
    {
        if(\Auth::check() && !\Auth::User()->can('manage-backup')) {
            abort(403);
        }
    }

    public function getIndex()
    {
        $backups = collect(\File::files(storage_path('app/dbackups')));
        $backups = $backups->map(function($item) {
            $fileName = basename($item);
            $info = explode('-', $fileName);
            $info[4] = str_split(explode('.', $info[4])[0], 2);
            return [
                'file' => $fileName,
                'database' => $info[0],
                'date' => Carbon::create($info[1], $info[2], $info[3], $info[4][0], $info[4][1], $info[4][2]),
            ];
        });
        return view('app.backup.index')->with([
            'backups' => $backups,
        ]);
    }

    public function getDownload($file)
    {
        $filePath = storage_path('app/dbackups/'.$file);
        if(\File::exists($filePath)) {
            return response()->download($filePath);
        } else {
            return back();
        }
    }
}