<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "guests_organizer";

$mysqli = new mysqli($hostname, $username, $password, $database);

if ($mysqli->connect_errno) {
    echo "Connection failed: $mysqli->connect_error";
    die();
}
