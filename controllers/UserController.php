<?php
require_once 'models/User.php';
require_once 'classes\WebPage.php';
class UserController
{
    private $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function login() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if (empty($email)) {
                $errors[] = "Email не може бути порожнім";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Невірний формат email";
            }

            if (empty($password)) {
                $errors[] = "Пароль не може бути порожнім";
            }

            if (empty($errors)) {
                $user = $this->userModel->login($email, $password);
                if ($user) {
                    session_start();
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['email'] = $user['email'];  // Додати email до сесії
                    header('Location: profile.php');
                    exit;
                } else {
                    $errors[] = "Невірний email або пароль";
                }
            }
        }

        require_once 'views/login_form.php';
    }
    public function show($user_id) {
        $user = $this->userModel->getUserById($user_id);
        if ($user) {
            $works = $this->userModel->getWorksByUserId($user_id);
            require 'views/profile_form.php';
        } else {
            header('Location: login.php');
            exit;
        }
    }
    public function deleteProfile($user_id) {
        if ($_SESSION['user_id'] === $user_id) {
            if ($this->userModel->deleteUser($user_id)) {
               
                $_SESSION = array();
                
                session_destroy();
                
                echo "<script>window.location.replace('index.php');</script>";
                exit();
            } else {
                echo "Помилка під час видалення профілю.";
            }
        } else {
            echo "Ви не маєте прав для видалення цього профілю.";
        }
    }
    
    
    public function register() {
        $errors = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nickName = trim($_POST['nickName']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
    
            if (empty($nickName)) {
                $errors[] = "Нікнейм не може бути порожнім";
            } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $nickName)) {
                $errors[] = "Нікнейм може містити лише літери, цифри та підкреслення";
            }
    
            if (empty($email)) {
                $errors[] = "Email не може бути порожнім";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Невірний формат email";
            }
    
            if (empty($password)) {
                $errors[] = "Пароль не може бути порожнім";
            } elseif (strlen($password) < 6) {
                $errors[] = "Пароль має бути не менше 6 символів";
            }
    
            if (empty($errors)) {
                try {
                    if ($this->userModel->register($nickName, $email, $password)) {
                        session_start();
                        $user = $this->userModel->login($email, $password); // Використовуємо login для отримання user_id
                        $_SESSION['user_id'] = $user['user_id'];
                        $_SESSION['email'] = $user['email'];  // Додати email до сесії
                        header('Location: profile.php');
                        exit;
                    } else {
                        $errors[] = "Помилка реєстрації. Спробуйте ще раз.";
                    }
                } catch (PDOException $e) {
                    $errors[] = "Помилка бази даних: " . $e->getMessage();
                }
            }
        }
    
        require 'views/register_form.php';
    }
    
   
    public function edit($user_id)
    {
        $user = $this->userModel->getUserById($user_id);
        require 'views/edit_form.php';
    }

    public function update($user_id)
    {
        $errors = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nickName = trim($_POST['nickName']);
            $autobiography = trim($_POST['autobiography']);
            $currentPassword = $_POST['currentPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];
    
            if (empty($nickName)) {
                $errors[] = "Нікнейм не може бути порожнім";
            } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $nickName)) {
                $errors[] = "Нікнейм може містити лише літери, цифри та підкреслення";
            }
    
            if (isset($_FILES['photoProfile']) && $_FILES['photoProfile']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['photoProfile']['tmp_name'];
                $fileName = $_FILES['photoProfile']['name'];
                $fileSize = $_FILES['photoProfile']['size'];
                $fileType = $_FILES['photoProfile']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
    
                $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $uploadFileDir = './uploaded_files/';
                    $dest_path = $uploadFileDir . $fileName;
    
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $photoProfile = $dest_path;
                    } else {
                        $errors[] = "Помилка при завантаженні файлу.";
                    }
                } else {
                    $errors[] = "Невірний формат файлу. Дозволені формати: " . implode(', ', $allowedfileExtensions);
                }
            } else {
                $photoProfile = null;
            }
    
            if (!empty($currentPassword) && !empty($newPassword) && !empty($confirmPassword)) {
                // Перевірка, чи існує ключ "currentPassword" в масиві $_POST
                if (isset($_POST['currentPassword'])) {
                    $user = $this->userModel->getUserById($user_id);
                    if (!password_verify($currentPassword, $user['password'])) {
                        $errors[] = "Неправильний поточний пароль.";
                    } elseif ($newPassword !== $confirmPassword) {
                        $errors[] = "Нові паролі не співпадають.";
                    } elseif (strlen($newPassword) < 6) {
                        $errors[] = "Новий пароль має бути не менше 6 символів.";
                    } else {
                        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    }
                } else {
                    
                    $errors[] = "Поточний пароль не був введений.";
                }
            }
            
            if (empty($errors)) {
                if ($this->userModel->updateUser($user_id, $nickName, $photoProfile, $autobiography, $hashedNewPassword ?? null)) {
                    header('Location: profile.php');
                    exit;
                } else {
                    $errors[] = "Помилка оновлення. Спробуйте ще раз.";
                }
            }
        }
    
        $user = $this->userModel->getUserById($user_id);
        require 'views/edit_form.php';
    }
    

}
?>
