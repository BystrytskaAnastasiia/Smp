<?php
require_once 'models/AuthorModel.php';

class EditWorkController {
    private $authorModel;

    public function __construct($authorModel) {
        $this->authorModel = $authorModel;
    }

    public function showEditWorkForm($workId) {
        // Отримуємо інформацію про твір за його ідентифікатором
        $work = $this->authorModel->getWorkById($workId);
        if (!$work) {
            echo "Такого твору не існує.";
            return;
        }
        
        // Отримуємо інформацію про поточного користувача
        $userId = $_SESSION['user_id'];
        $user = $this->authorModel->getUserById($userId);
        $tags = $this->authorModel->getAllTags();
        
        // Отримуємо теги, пов'язані з твором
        $workTags = $this->authorModel->getWorkTags($workId);
        
        // Отримуємо дані про глави
        $chapters = $this->authorModel->getChaptersByWorkId($workId);
        
        // Передаємо отримані дані в шаблон для відображення форми редагування твору
        require 'views/edit_work_form.php';
    }
    

    public function editWork() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Отримання даних з форми редагування твору
            $workId = $_POST['work_id'];
            $title = $_POST['title'];
            $ageRating = $_POST['age_rating'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $free = $_POST['free'];
            $publishDate = $_POST['publish_date'];
            $tags = $_POST['tags'];
    
            // Перевірка наявності користувача
            $userId = $_SESSION['user_id'];
            if (!$userId) {
                echo "Користувач не авторизований!";
                return;
            }
    
            // Обробка завантаження обкладинки (якщо потрібно)
            $cover = null;
            if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
                $coverTmpPath = $_FILES['cover']['tmp_name'];
                $coverName = basename($_FILES['cover']['name']);
                $coverDir = 'uploaded_files';
                $coverPath = $coverDir . $coverName;
                if (move_uploaded_file($coverTmpPath, $coverPath)) {
                    $cover = $coverPath;
                }
            } else {
                // Залишаємо стару обкладинку, якщо нову не завантажено
                $cover = $this->authorModel->getWorkById($workId)['cover'];
            }
    
            // Виклик методу моделі для оновлення твору
            $result = $this->authorModel->updateWork($workId, $title, $ageRating, $description, $cover, $status, $publishDate, $free);
            if (!$result) {
                echo "Помилка під час оновлення інформації про твір.";
                return;
            }
    
            // Оновлення глав
            $chapterIds = $_POST['chapter_id'];
            $chapterNumbers = $_POST['chapter_number'];
            $chapterContents = $_POST['content'];
            foreach ($chapterIds as $index => $chapterId) {
                $chapterNumber = $chapterNumbers[$index];
                $content = $chapterContents[$index];
                $result = $this->authorModel->updateChapter($chapterId, $chapterNumber, $status, $content, $publishDate);
                if (!$result) {
                    echo "Помилка під час оновлення глави.";
                    return;
                }
            }
    
            // Оновлення тегів (якщо потрібно)
            $result = $this->authorModel->updateWorkTags($workId, $tags);
            if (!$result) {
                echo "Помилка під час оновлення тегів.";
                return;
            }
    
            // Перенаправлення на головну сторінку після успішного редагування
            header("Location: index.php");
            exit;
        } else {
            echo "Невірний метод запиту!";
        }
    }
    
}
?>