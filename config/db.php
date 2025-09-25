<?php

$host = "localhost";
$db = "ticket_fairy";
$user = "root";
$password = "root";

try {
    // Connect
    $pdo = new PDO("mysql:host={$host};dbname={$db}", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Error connecting to {$db} database. Error: {$e->getMessage()} \n");
}