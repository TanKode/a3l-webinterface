<?php
namespace App\Http\Controllers\App;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use League\Flysystem\Filesystem;

class DashboardController extends Controller
{
    public function getIndex()
    {
        return view('app.dashboard.index')->with([
            'dynmarket' => collect(json_decode(\DB::connection('arma')->table('dynmarket')->first()->prices))->unique(0)->sortByDesc(1),
        ]);
    }

    public function getTest()
    {
        \Config::set('app.debug', true);

//        $client = new \Google_Client();
//        $credentials = $client->loadServiceAccountJson(storage_path('app/A3L-Backup-474d4bbe7ac8.json'), 'https://www.googleapis.com/auth/drive');
//        $client->setAssertionCredentials($credentials);
//
//        $service = new \Google_Service_Drive($client);
//        dd($service->about->get());
//        $adapter = new \Ignited\Flysystem\GoogleDrive\GoogleDriveAdapter($service);
//
//        $filesystem = new Filesystem($adapter);
//
//        dd($filesystem->read('/test/test.txt'));
//        dd($filesystem->write('/test/test.txt', 'Hallo Welt'));

        abort(403);
    }
}
