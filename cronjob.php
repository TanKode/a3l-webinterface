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