<?php namespace A3LWebInterface\Http\Controllers;

use Illuminate\Http\Response;

class DatabaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['backup', 'backup_database']]);
        if (!\Auth::User()->isAllowed('view_database')) {
            return redirect('/');
        }
    }

    public function index()
    {
        return view('database.list');
    }

    public function download($filename)
    {
        return (new Response(\Storage::get('backups/' . $filename), 200))->header('Content-Type', 'application/octet-stream');
    }

    public function delete($filename)
    {
        \Storage::delete('backups/' . $filename);
        return redirect()->route('db.list');
    }
}
