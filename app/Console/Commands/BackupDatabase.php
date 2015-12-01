<?php
namespace A3LWebInterface\Console\Commands;

use A3LWebInterface\Events\BackupCreated;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $name = 'db:backup';
    protected $description = 'Creates a backup of the whole database.';

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $now = Carbon::now(config('app.timezone'));
        $date = $now->toW3cString();
        $default = \DB::getDefaultConnection();
        $config = config("database.connections.{$default}");

        $content = $this->getComment([
            'DB-Backup',
            $config['database'] . ' @ ' . $config['host'],
            $config['charset'] . ' / ' . $config['collation'],
            $date,
        ]);
        $content .= $this->getCommand([
            "SET foreign_key_checks = 0;",
        ]);
        $content .= $this->getCommand([
            "DROP DATABASE IF EXISTS `{$config['database']}`;",
            "CREATE DATABASE IF NOT EXISTS `{$config['database']}`",
            "DEFAULT CHARACTER SET = '{$config['charset']}'",
            "DEFAULT COLLATE '{$config['collation']}';",
            "USE `{$config['database']}`;",
        ]);

        $tables = \DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $table = collect($table)->values()->first();
            $tableData = \DB::table($table)->get();
            $content .= $this->getComment([
                "table structure for '{$table}'",
            ]);
            $content .= $this->getCommand([
                "DROP TABLE IF EXISTS `{$table}`;",
                \DB::select("SHOW CREATE TABLE {$table}")[0]->{'Create Table'} . ';',
            ]);
            $content .= $this->getComment([
                "table data for '{$table}'",
            ]);
            foreach ($tableData as $row) {
                $content .= $this->getInput($table, $row);
            }
        }
        $content .= $this->getCommand([
            "SET foreign_key_checks = 1;",
        ]);
        $content = utf8_encode(trim($content));

        $filename = "backups/db_-_{$config['database']}_-_{$date}.sql";

        \Storage::put($filename, $content);
        \Event::fire(new BackupCreated($filename));
    }

    protected function getComment(array $comments)
    {
        $out = PHP_EOL;
        $out .= '-- ----------------------------' . PHP_EOL;
        foreach ($comments as $comment) {
            $out .= '-- ' . $comment . PHP_EOL;
        }
        $out .= '-- ----------------------------' . PHP_EOL;
        return $out;
    }

    protected function getCommand($commands)
    {
        $out = '';
        foreach ($commands as $command) {
            $out .= $command . PHP_EOL;
        }
        return $out . PHP_EOL;
    }

    protected function getInput($table, $data)
    {
        $keys = [];
        $values = [];
        foreach ($data as $key => $value) {
            $keys[] = "`{$key}`";
            $values[] = $this->getValue($value);
        }
        $keys = implode(',', $keys);
        $values = implode(',', $values);
        $out = "INSERT INTO `{$table}` ({$keys})" . PHP_EOL;
        $out .= "VALUES({$values});" . PHP_EOL;
        return $out;
    }

    protected function getValue($value)
    {
        if(is_null($value)) {
            return 'null';
        }
        $value = str_replace("\n", "\\n", addslashes($value));
        if (isset($value)) {
            return '"' . $value . '"';
        } else {
            return '""';
        }
    }
}
