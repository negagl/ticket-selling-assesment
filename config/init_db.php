<?php
$host = "localhost";
$user = "root";
$password = "root";

$pdo = new PDO("mysql:host={$host}", $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = file_get_contents(__DIR__."/../sql/schema.sql");
$pdo->exec($query);

echo "DB initialized";
