<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoonRead - Головна</title>
    <link rel="stylesheet" href="999.css">
</head>
<body>
<?php
require_once 'config/Database.php';
require_once 'models/WorkModel.php';
require_once 'classes/WebPage.php';
require_once 'classes/HomePage.php';

$database = new Database();
$workModel = new WorkModel($database);

// Перевіряємо, чи є запит пошуку
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $searchResults = $workModel->searchWorks($query);
} else {
    // Якщо запит пошуку не виконано, встановлюємо порожні результати
    $searchResults = [];
}

// Отримуємо популярні та нові твори
$popularWorks = $workModel->getPopularWorks();
$newWorks = $workModel->getNewWorks();

// Створюємо об'єкт головної сторінки
$homePage = new HomePage('MoonRead - Головна', $database, $popularWorks, $newWorks);

// Встановлюємо результати пошуку для відображення на головній сторінці
$homePage->setSearchResults($searchResults);

// Рендеримо головну сторінку
$homePage->render();
?>


</body>
</html>
