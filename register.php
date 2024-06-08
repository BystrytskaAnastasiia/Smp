<?php
session_start();

require_once 'config/Database.php';
require_once 'models/User.php';
require_once 'controllers/UserController.php';

$database = new Database();
$userModel = new UserModel($database);
$userController = new UserController($userModel);

if (isset($_SESSION['user_id']) && isset($_SESSION['user_nickname'])) {
    // Користувач авторизований
    $userId = $_SESSION['user_id'];
    $userNickname = $_SESSION['user_nickname'];
  
    // Відобразити контент для авторизованого користувача
} else {
    // Користувач не авторизований
    
    
    $userController->register();
}