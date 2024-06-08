<?php

session_start();

if (isset($_SESSION['user_id'])) {
    require_once 'config/Database.php';
    require_once 'models/WorkModel.php';
    require_once 'models/User.php'; // Додано модель користувача
    require_once 'controllers/WorkController.php';
    require_once 'models/CollectionModel.php';

    $database = new Database();
    $workModel = new WorkModel($database);
    $userModel = new UserModel($database); // Створено екземпляр моделі користувача
    $workController = new WorkController($workModel, $userModel);

    $workController->index();
} else {
    
    exit;
}
?>
