<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "rsa_portal";
$link = mysqli_connect($host, $user, $pass, $db);
if (!$link)
{
die("Database Connection Failed: " . mysqli_connect_error());
}

?>