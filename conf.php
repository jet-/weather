<?php


$hostName = "localhost";
$userName = "weather";
$password = "password";
$dbName = "weather";

// make connection to database
$mysqli = new mysqli($hostName, $userName, $password, $dbName) or die("Unable to connect to host $hostName");


date_default_timezone_set("America/New_York");
?>
