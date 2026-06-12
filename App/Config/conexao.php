<?php
$host = 'localhost';
$dbname = 'devshelf';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=localhost;dbname=devshelf", "root", "root");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

