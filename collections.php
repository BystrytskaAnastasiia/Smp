<?php
session_start();

if (isset($_SESSION['user_id'])) {
    require_once 'config/Database.php';
    require_once 'models/CollectionModel.php'; // Додано модель для збірників
    require_once 'controllers/CollectionController.php';

    $database = new Database();
    $collectionModel = new CollectionModel($database);
    $collectionController = new CollectionController($collectionModel);

    // Перевіряємо, чи був відправлений запит на створення збірника
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "create_collection") {
        // Викликаємо метод контролера для створення збірника
        $message = $collectionController->createCollection($_SESSION['user_id'], $_POST['collection_name']);
        
        // Перенаправлення користувача на сторінку зі списком збірників
        header("Location: collections.php");
        exit;
    }

    // Відображаємо список збірників
    $collections = $collectionController->showCollections($_SESSION['user_id']);

    // Вивід повідомлення про успішне створення збірника
    if (!empty($message)) {
        echo $message;
    }

    
} else {
    exit;
}
?>
