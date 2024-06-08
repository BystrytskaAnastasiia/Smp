<?php
require_once 'config/Database.php';
require_once 'models/User.php';
require_once 'controllers/UserController.php';
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_nickname'])) {
    // Користувач авторизований
    $userId = $_SESSION['user_id'];
    $userNickname = $_SESSION['user_nickname'];
    
    // Відобразити контент для авторизованого користувача
} else {
    
    echo "Ви не авторизовані.";
    // Відобразити контент для неавторизованого користувача
}
$database = new Database();
$userModel = new UserModel($database);
$userController = new UserController($userModel);

$userController->login();
?>