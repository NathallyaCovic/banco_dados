<?php
session_start();

$host = 'localhost';
$dbname = 'banco_sesi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Falha na Conexão: " . $e->getMessage());
}
?>