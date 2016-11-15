<?php
namespace App\Console\Commands;

use Carbon\Carbon;
use Symfony\Component\Console\Input\InputOption;

class BackupDatabase extends Command
{
    protected $name = 'db:backup';
    protected $description = 'Creates a backup of the whole database.';

    public function handle()
    {
        $connections = array_filter(array_map('trim', explode(',', $this->input->getOption('connection'))));
        $connections = count($connections) ? $connections : array_keys(config('database.connections'));
        foreach ($connections as $connection) {
            if (array_key_exists($connection, config('database.connections'))) {
                $this->comment('Start backup for DB-Connection [' . $connection . ']');
                $this->createBackup($connection);
                $this->info('Backup for DB-Connection [' . $connection . '] created successfully');
            } else {
                $this->error('DB-Connection [' . $connection . '] does not exist.');
            }
        }
    }

    protected function getOptions()
    {
        return [
            ['connection', null, InputOption::VALUE_OPTIONAL, 'The database connection(s) to use.'],
        ];
    }

    public function createBackup($connection)
    {
        $now = Carbon::now(config('app.timezone'));
        $date = $now->toW3cString();
        $config = config("database.connections.{$connection}");

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

        $tables = \DB::connection($connection)->select('SHOW TABLES');
        foreach ($tables as $table) {
            $table = collect($table)->values()->first();
            $tableData = \DB::connection($connection)->table($table)->get();
            $content .= $this->getComment([
                "table structure for '{$table}'",
            ]);
            $content .= $this->getCommand([
                "DROP TABLE IF EXISTS `{$table}`;",
                \DB::connection($connection)->select("SHOW CREATE TABLE {$table}")[0]->{'Create Table'} . ';',
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

        \Storage::disk('gdrive')->put($filename, $content);
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
        if (is_null($value)) {
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
