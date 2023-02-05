<?php
// // <!-- create connection to database -->
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=db_evac_management_sys', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_evac_management_sys";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn2 = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>