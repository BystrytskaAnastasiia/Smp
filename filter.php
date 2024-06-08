<?php
session_start();

require_once 'config/Database.php';
require_once 'models/FilterModel.php';
require_once 'controllers/FilterController.php';

$database = new Database();
$filterModel = new FilterModel($database);
$filterController = new FilterController($filterModel);

// Відображення сторінки фільтрації
$filterController->filter();

?>
