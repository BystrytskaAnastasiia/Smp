<?php
class ReviewDatabase {
    private $pdo;

    public function __construct($dbName) {
        $dsn = 'sqlite:' . __DIR__ . '/' . $dbName;
        $this->pdo = new PDO($dsn);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            $this->pdo->beginTransaction();

            $this->createTables();
            $this->populateTables();

            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo "Помилка створення бази даних: " . $e->getMessage() . "<br>";
            echo "Код помилки: " . $e->getCode() . "<br>";
            echo "Додаткова інформація: " . implode(', ', $this->pdo->errorInfo());
        }
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function __destruct() {
        $this->pdo = null;
    }

    private function createTables() {
        $createReviewsTable = "
            CREATE TABLE IF NOT EXISTS reviews (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                work_id INTEGER NOT NULL,
                user_id INTEGER NOT NULL,
                review_text TEXT NOT NULL,
                review_date DATE NOT NULL
            );
        ";

        $this->pdo->exec($createReviewsTable);
    }

    private function populateTables() {
        $insertReview = "
            INSERT INTO reviews (work_id, user_id, review_text, review_date) VALUES
            (1, 1, 'Відмінний твір!', '2024-01-01'),
            (2, 2, 'Дуже сподобалось!', '2024-02-01'),
            (3, 3, 'Непогано, але є куди рости.', '2024-03-01');
        ";

        $this->pdo->exec($insertReview);
    }

    public function insertReview($workId, $userId, $reviewText, $reviewDate) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO reviews (work_id, user_id, review_text, review_date) VALUES (?, ?, ?, ?)");
            $stmt->execute([$workId, $userId, $reviewText, $reviewDate]);
        } catch (PDOException $e) {
            echo "Помилка вставки відгуку: " . $e->getMessage() . "<br>";
            echo "Код помилки: " . $e->getCode() . "<br>";
            echo "Додаткова інформація: " . implode(', ', $this->pdo->errorInfo());
        }
    }

    public function getReviews() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM reviews");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Помилка отримання відгуків: " . $e->getMessage() . "<br>";
            echo "Код помилки: " . $e->getCode() . "<br>";
            echo "Додаткова інформація: " . implode(', ', $this->pdo->errorInfo());
        }
        return [];
    }
}
?>
