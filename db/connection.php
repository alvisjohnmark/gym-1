<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "gymdb";

if (!$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname)) {
    die("Connection error!");
}