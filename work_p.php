<?php
session_start();

require_once 'config/Database.php';
require_once 'models/WorkModel.php';
require_once 'controllers/WorkPageController.php';

$database = new Database();
$pdo = $database->getPdo(); // Отримання об'єкту PDO з методу getPdo()

$workModel = new WorkModel($database); // Передача об'єкту Database в конструктор WorkModel
$workPageController = new WorkPageController($workModel, $database); // Передача об'єкту Database в конструктор WorkPageController

// Отримуємо ідентифікатор твору з параметрів URL
$work_id = $_GET['work_id'] ?? null;

// Перевірка наявності об'єкта контролера
if ($workPageController) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "like") {
        // Перевірка наявності ідентифікатора твору
        if (isset($_GET['work_id'])) {
            // Отримання ідентифікатора твору з параметрів URL
            $work_id = $_GET['work_id'];

            // Обробка лайку за допомогою методу контролера
            $message = $workPageController->handleLike($work_id, $_SESSION['user_id']);
        } else {
            // Якщо ідентифікатор твору не знайдено в параметрах URL, виведення помилки
            $message = 'Ідентифікатор твору не знайдено.';
        }
    }

    // Виклик методу show() для відображення сторінки з інформацією про твір
    $workPageController->show($work_id);
}
?>
