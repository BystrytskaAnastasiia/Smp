<?php
require_once 'models/AuthorModel.php';

class AuthorController {
    private $authorModel;

    public function __construct() {
        $this->authorModel = new AuthorModel();
    }

    public function showCreateWorkForm() {
        $tags = $this->authorModel->getAllTags();
        $userId = $_SESSION['user_id'];
        $user = $this->authorModel->getUserById($userId);
        require 'views/create_work_form.php';
    }

    
    public function showAddChapterForm($workId) {
        require 'views/add_chapter_form.php';
    }

    public function addChapter() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $workId = $_POST['work_id'];
            $chapterNumber = $_POST['chapter_number'];
            $status = $_POST['status'];
            $content = $_POST['content'];
            $publishDate = $_POST['publish_date'];

            $this->authorModel->addChapter($workId, $chapterNumber, $status, $content, $publishDate);

            // Перенаправлення на сторінку твору після успішного додавання глави
            header("Location: work_p.php?work_id=" . $workId);
            exit;
        } else {
            echo "Невірний метод запиту!";
        }
    }
    

    public function addWork() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $ageRating = $_POST['age_rating'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $free = $_POST['free'];
            $chapterNumber = $_POST['chapter_number'];
            $publishDate = $_POST['publish_date'];
            $content = $_POST['content'];
            $tags = $_POST['tags'];

            $userId = $_SESSION['user_id'];
            if (!$userId) {
                echo "Користувач не авторизований!";
                return;
            }

            // Обробка завантаження обкладинки
            $photoProfile = null;
            if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
                $fileName = $_FILES['cover']['name'];
                $fileTmpPath = $_FILES['cover']['tmp_name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $uploadFileDir = './uploaded_files/';
                    $dest_path = $uploadFileDir . $fileName;

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $photoProfile = $dest_path;
                    } else {
                        echo "Помилка при завантаженні обкладинки.";
                        return;
                    }
                } else {
                    echo "Непідтримуваний формат файлу. Дозволені формати: " . implode(', ', $allowedfileExtensions);
                    return;
                }
            }

            $workId = $this->authorModel->addWork($title, $ageRating, $description, $photoProfile, $status, $free, $userId, $publishDate);

            $this->authorModel->addChapter($workId, $chapterNumber, $status, $content, $publishDate);

            $this->authorModel->addWorkTags($workId, $tags);

            // Перенаправлення на головну сторінку після успішної публікації
            header("Location: index.php");
            exit;
        } else {
            echo "Невірний метод запиту!";
        }
    }
    
   
    
    
    
}

// Ініціалізація контролера і виклик відповідного методу
$controller = new AuthorController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->addWork();
} else {
    // Інші можливі операції, які потрібно виконати при GET-запиті
}
?>
