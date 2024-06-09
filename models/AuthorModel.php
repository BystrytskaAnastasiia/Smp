<?php
require_once 'config/Database.php';

class AuthorModel {
    private $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->getPdo();
    }
    public function getPdo() {
        return $this->pdo;
    }
    public function getAllTags() {
        $stmt = $this->pdo->query('SELECT * FROM tags');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addWork($title, $ageRating, $description, $cover, $status, $free, $userId, $publishDate) {
        $stmt = $this->pdo->prepare('INSERT INTO work (title, age_rating, description, cover, status, date_of_publication, free, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$title, $ageRating, $description, $cover, $status, $publishDate, $free, $userId]);
      
        // Отримуємо ID новоствореного твору
        $workId = $this->pdo->lastInsertId();
        
        // Оновлюємо поле work_id у таблиці користувачів
        $stmt = $this->pdo->prepare('UPDATE users SET work_id = ? WHERE user_id = ?');
        $stmt->execute([$workId, $userId]);
    
        return $workId;
    }
    

    public function addChapter($workId, $chapterNumber, $status, $content, $publishDate) {
        $stmt = $this->pdo->prepare('INSERT INTO chapters (chapter_number, status, content, date_of_publication, work_id) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$chapterNumber, $status, $content, $publishDate, $workId]);
    }

    public function addWorkTags($workId, $tags) {
        foreach ($tags as $tagId) {
            $stmt = $this->pdo->prepare('INSERT INTO work_tags (work_id, tags_id) VALUES (?, ?)');
            $stmt->execute([$workId, $tagId]);
        }
    }
    public function updateWork($workId, $title, $ageRating, $description, $cover, $status, $publishDate, $free) {
        $stmt = $this->pdo->prepare('UPDATE work SET title = ?, age_rating = ?, description = ?, cover = ?, status = ?, date_of_publication = ?, free = ? WHERE work_id = ?');
        $stmt->execute([$title, $ageRating, $description, $cover, $status, $publishDate, $free, $workId]);
        // Поверніть true, якщо оновлення пройшло успішно, інакше поверніть false
        return $stmt->rowCount() > 0;
    }
    
    public function updateChapter($chapterId, $chapterNumber, $status, $content, $publishDate) {
        $stmt = $this->pdo->prepare('UPDATE chapters SET chapter_number = ?, status = ?, content = ?, date_of_publication = ? WHERE chapter_id = ?');
        $stmt->execute([$chapterNumber, $status, $content, $publishDate, $chapterId]);
        // Поверніть true, якщо оновлення пройшло успішно, інакше поверніть false
        return $stmt->rowCount() > 0;
    }
    
    public function updateWorkTags($workId, $tags) {
        // Спочатку видаліть старі теги для цього твору
        $stmt = $this->pdo->prepare('DELETE FROM work_tags WHERE work_id = ?');
        $stmt->execute([$workId]);
    
        // Потім додайте нові теги
        foreach ($tags as $tagId) {
            $stmt = $this->pdo->prepare('INSERT INTO work_tags (work_id, tags_id) VALUES (?, ?)');
            $stmt->execute([$workId, $tagId]);
        }
        // Поверніть true, якщо оновлення пройшло успішно, інакше поверніть false
        return true;
    }
    
    public function getUserById($userId) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getWorksByUserId($user_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM work WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getChaptersByWorkId($workId) {
        $stmt = $this->pdo->prepare('SELECT * FROM chapters WHERE work_id = ?');
        $stmt->execute([$workId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getWorkTags($workId) {
        $stmt = $this->pdo->prepare('SELECT tags_id FROM work_tags WHERE work_id = ?');
        $stmt->execute([$workId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
