<?php
class Database {
    private $pdo;

    public function __construct() {
        $dsn = 'sqlite:' . __DIR__ . '/read.db';
        $this->pdo = new PDO($dsn);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPdo() {
        return $this->pdo;
    }
    
    public function __destruct() {
        $this->pdo = null;
    }
}
?>
