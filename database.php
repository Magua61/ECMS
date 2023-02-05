<?php
// // <!-- create connection to database -->
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=db_evac_management_syss', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>