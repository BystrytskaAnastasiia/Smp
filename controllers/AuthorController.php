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
    public function showEditWorkForm($workId) {
        // Отримуємо інформацію про твір за його ідентифікатором
        $work = $this->authorModel->getWorkById($workId);
        if (!$work) {
            echo "Такого твору не існує.";
            return;
        }
        
        // Отримуємо всі теги
        $tags = $this->authorModel->getAllTags();
        
        // Отримуємо інформацію про поточного користувача
        $userId = $_SESSION['user_id'];
        $user = $this->authorModel->getUserById($userId);
        
        // Передаємо отримані дані в шаблон для відображення форми редагування твору
        require 'views/edit_work_form.php';
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
    public function editWork() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $workId = $_POST['work_id'];
            $title = $_POST['title'];
            $ageRating = $_POST['age_rating'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $free = $_POST['free'];
            $chapterNumber = $_POST['chapter_number'];
            $publishDate = $_POST['publish_date'];
            $content = $_POST['content'];
            $tags = $_POST['tags'];
    
            // Перевірка наявності користувача
            $userId = $_SESSION['user_id'];
            if (!$userId) {
                echo "Користувач не авторизований!";
                return;
            }
    
            // Обробка завантаження обкладинки
            $cover = null;
            if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
                $fileName = $_FILES['cover']['name'];
                $fileTmpPath = $_FILES['cover']['tmp_name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
    
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $uploadFileDir = './uploaded_files/';
                    $dest_path = $uploadFileDir . $fileName;
    
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $cover = $dest_path;
                    } else {
                        echo "Помилка при завантаженні обкладинки.";
                        return;
                    }
                } else {
                    echo "Непідтримуваний формат файлу. Дозволені формати: " . implode(', ', $allowedfileExtensions);
                    return;
                }
            }
    
            // Оновлення інформації про твір
            $result = $this->authorModel->updateWork($workId, $title, $ageRating, $description, $cover, $status, $publishDate, $free);
            if (!$result) {
                echo "Помилка під час оновлення інформації про твір.";
                return;
            }
    
            // Оновлення глави
            $result = $this->authorModel->updateChapter($workId, $chapterNumber, $status, $content, $publishDate);
            if (!$result) {
                echo "Помилка під час оновлення глави.";
                return;
            }
    
            // Оновлення тегів
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

// Ініціалізація контролера і виклик відповідного методу
$controller = new AuthorController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->addWork();
} else {
    // Інші можливі операції, які потрібно виконати при GET-запиті
}
?>
