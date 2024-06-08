<?php
class CollectionModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }


    public function getCollectionsByUserId($user_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM collections WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCollectionById($collection_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM collections WHERE collection_id = :collection_id');
        $stmt->execute(['collection_id' => $collection_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCollection($user_id, $collection_name) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO collections (user_id, name) VALUES (?, ?)');
            $stmt->execute([$user_id, $collection_name]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            // Обробка помилок, якщо потрібно
            return false;
        }
    }
    

    public function addWorkToCollection($collection_id, $work_id) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO collection_works (collection_id, work_id) VALUES (:collection_id, :work_id)');
            $stmt->execute(['collection_id' => $collection_id, 'work_id' => $work_id]);
            return true;
        } catch (PDOException $e) {
            // Обробка помилок, якщо потрібно
            return false;
        }
    }
    public function getUserCollections($user_id) {
        $query = "SELECT * FROM collections WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
