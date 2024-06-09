<?php
require_once 'config\Database.php';

class ReviewManager {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function insertReview($name, $email, $message) {
        $pdo = $this->db->getPdo();
        
        // Підготовлений запит для вставки відгуку
        $stmt = $pdo->prepare("INSERT INTO reviews (name, email, message) VALUES (:name, :email, :message)");
        
        // Параметри запиту
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);
        
        // Виконання запиту
        $stmt->execute();
    }

    public function getAllReviews() {
        $pdo = $this->db->getPdo();
        
        // Підготовлений запит для отримання всіх відгуків
        $stmt = $pdo->prepare("SELECT * FROM reviews");
        
        // Виконання запиту
        $stmt->execute();
        
        // Повертаємо результат
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
