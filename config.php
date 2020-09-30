<?php
require_once 'contact.php';

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'blue';
$charset = 'utf8';
$conn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {
    $PDO = new PDO($conn, $username, $password);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}




