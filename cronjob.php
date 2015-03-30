<?php
$mysql = array(
    'host'      => 'localhost',
    'database'  => 'arma3life',
    'username'  => 'username',
    'password'  => 'password'
);

$connection = mysqli_connect($mysql['host'],$mysql['username'],$mysql['password'],$mysql['database']) or die(mysqli_connect_error());

$query = 'SELECT COUNT(*) FROM players';
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_row($result);
$players = $row[0];
mysqli_free_result($result);

$query = 'SELECT COUNT(*) FROM vehicles WHERE alive = 1';
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_row($result);
$vehicles = $row[0];
mysqli_free_result($result);

$query = 'SELECT SUM(cash) FROM players';
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_row($result);
$cash = $row[0];
mysqli_free_result($result);

$query = 'SELECT SUM(bankacc) FROM players';
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_row($result);
$bankacc = $row[0];
mysqli_free_result($result);

$query = "SELECT COUNT(*) FROM players WHERE donatorlvl <> '0'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_row($result);
$donator = $row[0];
mysqli_free_result($result);

$query = 'SELECT COUNT(*) FROM houses WHERE owned = 1';
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_row($result);
$houses = $row[0];
mysqli_free_result($result);

$query = 'SELECT COUNT(*) FROM gangs WHERE active = 1';
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_row($result);
$gangs = $row[0];
mysqli_free_result($result);

$query = 'INSERT INTO statistics (players,donator,vehicles,houses,gangs,cash,bankacc) VALUES ('.$players.','.$donator.','.$vehicles.','.$houses.','.$gangs.','.$cash.','.$bankacc.')';
$result = mysqli_query($connection, $query);
mysqli_free_result($result);

mysqli_close($connection);

backup_tables($mysql['host'],$mysql['username'],$mysql['password'],$mysql['database']);

function backup_tables($host,$user,$pass,$name,$tables = '*')
{
    $link = mysql_connect($host,$user,$pass);
    mysql_select_db($name,$link);

    if($tables == '*') {
        $tables = array();
        $result = mysql_query('SHOW TABLES');
        while($row = mysql_fetch_row($result)) {
            $tables[] = $row[0];
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }

    $return = '';
    foreach($tables as $table):
        $result = mysql_query('SELECT * FROM '.$table);
        $num_fields = mysql_num_fields($result);

        $return .= 'DROP TABLE '.$table.';';
        $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";

        for ($i = 0; $i < $num_fields; $i++):
            while($row = mysql_fetch_row($result)):
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j<$num_fields; $j++):
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                    if(isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if($j<($num_fields-1)) { $return.= ','; }
                endfor;
                $return.= ");\n";
            endwhile;
        endfor;
        $return.="\n\n\n";
    endforeach;

    $handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
    fwrite($handle,$return);
    fclose($handle);
}