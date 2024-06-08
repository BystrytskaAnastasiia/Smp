<?php
session_start();

if (isset($_SESSION['user_id'])) {
    require_once 'config/Database.php';
    require_once 'models/AuthorModel.php';
    require_once 'controllers/AuthorController.php';

    $database = new Database();
    $authorModel = new AuthorModel($database);
    $authorController = new AuthorController($authorModel);

    // Відобразити сторінку кабінету автора
    $authorController->showCreateWorkForm();
} else {
    header('Location: login.php');
    exit;
}
?>
