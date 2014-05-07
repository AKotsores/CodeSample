<?php
//connect to database
$host = '';
$user = '';
$pw = '';
$dbname = '';

$dbc = mysqli_connect($host, $user, $pw, $dbname)
  or die('Error connecting to database.');
?>