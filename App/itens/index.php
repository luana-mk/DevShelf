<?php
// index.php

require_once 'controllers/HomeController.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$controller = new ItemController();
$action = $_GET['action'] ?? 'listar';

switch ($action) {
    case 'cadastrar':
        $controller->cadastrar();
        break;
    case 'editar':
        $controller->editar();
        break;
    case 'excluir':
        $controller->excluir();
        break;
    case 'listar':
    default:
        $controller->index();
        break;
}