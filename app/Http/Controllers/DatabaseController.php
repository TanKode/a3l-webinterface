<?php namespace A3LWebInterface\Http\Controllers;

use A3LWebInterface\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DatabaseController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['backup', 'backup_database']]);
        $this->middleware('curl', ['only' => ['backup', 'backup_database']]);
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
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

    public function backup()
    {
        $database = \Config::get('database.connections.mysql');
        if ($database['driver'] == 'mysql') {
            $return = $this->backup_database($database['host'], $database['username'], $database['password'], $database['database']);
            if ($return != false) {
                \Event::fire(new \A3LWebInterface\Events\BackupCreated($return));
            }
        }
    }

    private function backup_database($host, $user, $pass, $name)
    {
        $mysqli = new \mysqli($host, $user, $pass, $name);
        if ($mysqli->connect_errno) {
            return false;
        }

        $tables = array();
        $result = $mysqli->query('SHOW TABLES');
        while ($row = $result->fetch_array()) {
            $tables[] = $row[0];
        }
        sort($tables);

        $return = '';
        foreach ($tables as $table) {
            $result = $mysqli->query('SELECT * FROM ' . $table);
            $num_fields = $result->field_count;
            $return .= '-- ----------------------------' . "\n" .
                '-- Table structure and data for `' . $table . '`' . "\n" .
                '-- ----------------------------' . "\n";
            $return .= 'DROP TABLE ' . $table . ';';

            $result2 = $mysqli->query('SHOW CREATE TABLE ' . $table);
            $row2 = $result2->fetch_row();
            $return .= "\n\n" . $row2[1] . ';';

            if ($num_fields > 0) {
                for ($i = 0; $i < $num_fields; $i++) {
                    if ($i == 0) {
                        $return .= "\n\n";
                    }
                    while ($row = $result->fetch_row()) {
                        $return .= 'INSERT INTO ' . $table . ' VALUES(';
                        for ($j = 0; $j < $num_fields; $j++) {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = str_replace("\n", "\\n", $row[$j]);
                            if (isset($row[$j])) {
                                $return .= '"' . $row[$j] . '"';
                            } else {
                                $return .= '""';
                            }
                            if ($j < ($num_fields - 1)) {
                                $return .= ',';
                            }
                        }
                        $return .= ');' . "\n";
                    }
                }
            }
            $return .= "\n\n\n";
        }
        $mysqli->close();
        $return = utf8_encode(trim($return));

        $filename = 'backups\db_-_' . $name . '_-_' . md5(implode(',', $tables)) . '_-_' . date('Y-m-d_-_H-i-s') . '.sql';

        \Storage::disk('local')->put($filename, $return);
        return $filename;
    }

}