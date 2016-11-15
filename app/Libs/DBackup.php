<?php
namespace App\Libs;

use Carbon\Carbon;
use DB;
use Storage;

class DBackup
{
    public static function tables($connection, $save = true)
    {
        try {
            $dbName = DB::connection($connection)->getDatabaseName();
            $charset = DB::connection($connection)->getConfig('charset');
            $collation = DB::connection($connection)->getConfig('collation');

            $tables = array();
            $result = DB::connection($connection)->select('SHOW TABLES');
            foreach ($result as $table) {
                $tables[] = $table->{'Tables_in_' . $dbName};
            }
            $sql = '-- DATABASE: ' . $dbName;
            $sql .= 'CREATE DATABASE IF NOT EXISTS ' . $dbName . ' CHARACTER SET ' . $charset . ' COLLATE ' . $collation . ';' . PHP_EOL;
            $sql .= 'USE ' . $dbName . ';' . PHP_EOL . PHP_EOL;

            foreach ($tables as $table) {
                $data = DB::connection($connection)->table($table)->get();
                $sql .= '-- TABLE: ' . $table . PHP_EOL;
                $sql .= 'DROP TABLE IF EXISTS ' . $table . ';' . PHP_EOL;
                $sql .= DB::connection($connection)->select('SHOW CREATE TABLE ' . $table)[0]->{'Create Table'} . ';' . PHP_EOL;

                foreach ($data as $row) {
                    $row = collect($row)->toArray();
                    $sql .= 'INSERT INTO ' . $table . ' (' . implode(',', array_keys($row)) . ')' . PHP_EOL;
                    $sql .= 'VALUES(';
                    foreach ($row as &$value) {
                        $value = addslashes(str_replace(["\r", "\n"], ["\\r", "\\n"], $value));
                        if (!empty($value)) {
                            $value = '"' . $value . '"';
                        } elseif (is_null($value)) {
                            $value = 'NULL';
                        } else {
                            $value = '""';
                        }
                    }
                    $sql .= implode(',', $row);
                    $sql .= ');' . PHP_EOL;
                }

                $sql .= PHP_EOL;
            }

            if ($save) {
                $fileName = str_slug($dbName . ' ' . Carbon::now()->setTimezone('Europe/Berlin')->toDateTimeString());
                Storage::put('dbackups/' . $fileName . '.sql', $sql);
            } else {
                return $sql;
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
}