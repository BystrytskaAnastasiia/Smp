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

    
    
    

    public function addWork() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $title = $_POST['title'] ?? null;
                $ageRating = $_POST['age_rating'] ?? null;
                $description = $_POST['description'] ?? null;
                $status = $_POST['status'] ?? null;
                $free = $_POST['free'] ?? null;
                $chapterNumber = $_POST['chapter_number'] ?? null;
                $publishDate = $_POST['publish_date'] ?? null;
                $content = $_POST['content'] ?? null;
                $tags = $_POST['tags'] ?? [];

                $userId = $_SESSION['user_id'] ?? null;
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
                            throw new Exception("Помилка при завантаженні обкладинки.");
                        }
                    } else {
                        throw new Exception("Непідтримуваний формат файлу. Дозволені формати: " . implode(', ', $allowedfileExtensions));
                    }
                }

                $workId = $this->authorModel->addWork($title, $ageRating, $description, $photoProfile, $status, $free, $userId, $publishDate);

                $this->authorModel->addChapter($workId, $chapterNumber, $status, $content, $publishDate);

                $this->authorModel->addWorkTags($workId, $tags);

                // Перенаправлення на головну сторінку після успішної публікації
                header("Location: index.php");
                exit;
            } catch (PDOException $e) {
                echo "Помилка бази даних: " . $e->getMessage() . "<br>";
                echo "Код помилки: " . $e->getCode() . "<br>";
                echo "Додаткова інформація: " . implode(', ', $this->authorModel->getPdo()->errorInfo());
            } catch (Exception $e) {
                echo "Загальна помилка: " . $e->getMessage();
            }
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
