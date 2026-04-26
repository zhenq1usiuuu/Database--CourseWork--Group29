<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "comp1044_database";
//create connection
$conn = new mysqli($servername, $username, $password, $dbname);//The "Database Connector Tool" that comes with PHP
//check connection
if ($conn->connect_error){
    die("connection failed:".$conn->connect_error);
}

?>
