<?php
$host = 'localhost:3307';
$dbname = 'devshelf';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=localhost;dbname=devshelf", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

