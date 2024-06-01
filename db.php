<?php

$servername = "localhost:3307";
$username = "root";
$password = "";
$db = "database1";

// Create connection
$con = mysqli_connect($servername, $username, $password, $db);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
