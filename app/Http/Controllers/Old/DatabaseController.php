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
        return view('database.list')->with([
            'tables' => \DB::select('SELECT table_name, table_rows, Round((data_length + index_length) / 1024, 1) "table_size" FROM information_schema.tables WHERE table_schema = "' . \Config::get('database.connections.mysql.database') . '";'),
            'backups' => \Storage::disk('local')->allFiles('backups'),
        ]);
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
