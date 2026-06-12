<?php
$host = 'localhost';
$dbname = 'devshelf';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=localhost;dbname=devshelf", "root", "123456");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

