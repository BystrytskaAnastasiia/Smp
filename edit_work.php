<?php
session_start();

if (isset($_SESSION['user_id'])) {
    require_once 'config/Database.php';
    require_once 'models/AuthorModel.php';
    require_once 'controllers/EditWorkController.php';

    // Ініціалізуємо базу даних та модель автора
    $database = new Database();
    $authorModel = new AuthorModel($database);

    // Ініціалізуємо контролер для редагування твору
    $editWorkController = new EditWorkController($authorModel);

    // Перевіряємо метод запиту і викликаємо відповідний метод контролера
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $editWorkController->editWork();
    } else {
        // Отримуємо ID твору з параметрів запиту
        $workId = isset($_GET['work_id']) ? $_GET['work_id'] : null;
        if ($workId) {
            // Відображаємо форму редагування твору
            $editWorkController->showEditWorkForm($workId);
        } else {
            echo "Не вказано ID твору для редагування.";
        }
    }
} else {
    // Перенаправлення на сторінку входу, якщо користувач не авторизований
    header('Location: login.php');
    exit;
}
?>
