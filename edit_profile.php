<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    require_once 'config/Database.php';
    require_once 'models/User.php';
    require_once 'controllers/UserController.php';

    $database = new Database();
    $userModel = new UserModel($database);
    $userController = new UserController($userModel);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController->update($user_id);
    } else {
        $userController->edit($user_id);
    }
} else {
    header('Location: login.php');
    exit;
}
?>
