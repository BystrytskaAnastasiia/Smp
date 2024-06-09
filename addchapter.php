<?php
require_once 'controllers/AuthorController.php';

$controller = new AuthorController();

if (isset($_GET['action']) && $_GET['action'] === 'add_chapter_form' && isset($_GET['work_id'])) {
    $controller->showAddChapterForm($_GET['work_id']);
} elseif (isset($_GET['action']) && $_GET['action'] === 'add_chapter') {
    $controller->addChapter();
} else {
    // Інші можливі операції
}
?>