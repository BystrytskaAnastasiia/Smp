<?php
session_start();

require_once 'config/Database.php';
require_once 'models/User.php';
require_once 'controllers/UserController.php';

// Перевірка, чи передано user_id через параметр URL або в сесії
if (isset($_GET['user_id']) || isset($_SESSION['user_id'])) {
    $user_id = $_GET['user_id'] ?? $_SESSION['user_id'];

    $database = new Database();
    $userModel = new UserModel($database);
    $userController = new UserController($userModel);

    
    $userController->show($user_id);

    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
        $userController->deleteProfile($user_id);
    }
} else {
    
    header('Location: login.php');
    exit;
}
?>
