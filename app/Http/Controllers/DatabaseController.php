<?php namespace A3LWebInterface\Http\Controllers;

use A3LWebInterface\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DatabaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['backup', 'backup_database']]);
    }

    public function index()
    {
        if (!\Auth::User()->isAllowed('view_database')) {
            return Redirect::to('/');
        }

        return view('database.list');
    }

    public function download($filename)
    {
        if (!\Auth::User()->isAllowed('view_database')) {
            return Redirect::to('/');
        }

        $file = \Storage::disk('local')->get('backups/' . $filename);
        return (new \Illuminate\Http\Response($file, 200))->header('Content-Type', 'application/octet-stream');
    }

    public function delete($filename)
    {
        if (!\Auth::User()->isAllowed('view_database')) {
            return Redirect::to('/');
        }

        $file = \Storage::disk('local')->delete('backups/' . $filename);
        return redirect()->route('db.list');
    }

}