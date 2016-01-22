<?php
namespace App\Http\Controllers\App;

use App\Libs\GoogleDriveAdapter;
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

        $client = new \Google_Client();
//        $client->setAuthConfig(storage_path('app/A3L-Backup-01fd4f2e57e4.json'));
        $client->setAuthConfig(storage_path('app/A3L-Backup-474d4bbe7ac8.json'));
        $client->addScope('https://www.googleapis.com/auth/drive');
        $client->setSubject('a3lwebinterface@gmail.com');

        $service = new \Google_Service_Drive($client);
        $adapter = new GoogleDriveAdapter($service);

        $filesystem = new Filesystem($adapter);

        dump(\Storage::disk('local')->listContents());

        dump($filesystem->listContents('test'));

        dump($filesystem->has('/test/test.txt'));
        dump($filesystem->read('/test/test.txt'));
        dump($filesystem->delete('/test/test.txt'));
        dump($filesystem->put('/test/test.txt', 'updated_at: ' . date('Y-m-d H:i:s')));

        dump($filesystem->put('/test/'.time().'.txt', 'created_at: ' . date('Y-m-d H:i:s')));


        dump($filesystem->deleteDir('new_dir'));
        dump($filesystem->createDir('new_dir'));
        dump($filesystem->put('/new_dir/'.time().'.txt', 'created_at: ' . date('Y-m-d H:i:s')));
        dd('end');

        abort(403);
    }
}
