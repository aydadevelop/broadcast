<?php
$dbhost = "127.0.0.1";
$dbuser = COUPLE_DB_USER;
$dbpass = COUPLE_DB_PW;
$db     = "couple";

$dbConn = @mysqli_connect($dbhost, $dbuser, $dbpass,$db) or die("The site database is down. Please try logging on later.");
mysqli_set_charset($dbConn,"utf8mb4");
if ($db!="" && !@mysqli_select_db($dbConn,$db)) die("The site database is unavailable. Please try logging on later.");
$dbconnected=1;
?>
