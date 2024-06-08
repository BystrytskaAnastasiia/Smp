<?php
class WorkModel {
    private $pdo;

    public function __construct($database) {
        $this->pdo = $database->getPdo();
    }

    public function getPopularWorks($limit = 10) {
        $stmt = $this->pdo->prepare('SELECT * FROM work WHERE number_of_likes > 50 ORDER BY number_of_likes DESC LIMIT :limit');
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNewWorks($limit = 10) {
        $stmt = $this->pdo->prepare('SELECT * FROM work ORDER BY date_of_publication DESC LIMIT :limit');
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNewcomersWithPhoto() {
        $stmt = $this->pdo->prepare('SELECT user_id, nick_name, photo_profile FROM users ORDER BY user_id DESC LIMIT 10');
        $stmt->execute();
        $newcomers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Додамо фото за замовчуванням для тих, у кого його немає
        foreach ($newcomers as &$newcomer) {
            if (empty($newcomer['photo_profile'])) {
                $newcomer['photo_profile'] = 'https://i.pinimg.com/564x/40/5c/bb/405cbbffca0c8d144c2c30586ff71cec.jpg';
            }
        }

        return $newcomers;
    }
    
    
    public function getLegends($limit = 10) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE user_id IN (SELECT DISTINCT user_id FROM work WHERE number_of_likes > 50) LIMIT :limit');
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getWorkById($work_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM work WHERE work_id = :work_id');
        $stmt->execute(['work_id' => $work_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getChaptersByWorkId($work_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM chapters WHERE work_id = :work_id ORDER BY chapter_number ASC');
        $stmt->execute(['work_id' => $work_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addLike($work_id, $user_id) {
        try {
            // Перевірка, чи користувач вже поставив лайк до цього твору
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM likes WHERE work_id = :work_id AND user_id = :user_id');
            $stmt->execute(['work_id' => $work_id, 'user_id' => $user_id]);
            $existingLikes = $stmt->fetchColumn();
    
            // Якщо користувач вже поставив лайк, повертаємо false
            if ($existingLikes > 0) {
                return false;
            }
    
            // Якщо користувач ще не поставив лайк, вставляємо новий запис у таблицю лайків
            $stmt = $this->pdo->prepare('INSERT INTO likes (work_id, user_id) VALUES (:work_id, :user_id)');
            $stmt->execute(['work_id' => $work_id, 'user_id' => $user_id]);
            
            return true;
        } catch (PDOException $e) {
            // Обробка помилок, якщо потрібно
            return false;
        }
    }
    
  
// Додамо метод для отримання збірників користувача з бази даних

    
    
}
    

?>
