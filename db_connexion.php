<?php
$db = "mysql:host=localhost;dbname=blogProject";
$user = "root";
$password = '';

try {
    $pdo = new PDO($db, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}