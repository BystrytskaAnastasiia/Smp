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

$popularWorks = $workModel->getPopularWorks();
$newWorks = $workModel->getNewWorks();


$homePage = new HomePage('MoonRead - Головна', $popularWorks, $newWorks);
$homePage->render();
?>

</body>
</html>
