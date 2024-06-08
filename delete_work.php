<?php

require_once 'config/Database.php';


if (isset($_POST['work_id'])) {
   
    $work_id = $_POST['work_id'];

    
    $database = new Database();
    $pdo = $database->getPdo();

    
    $query = "DELETE FROM works WHERE work_id = :work_id";

    
    $statement = $pdo->prepare($query);
    $statement->bindParam(':work_id', $work_id, PDO::PARAM_INT);
    
    
    if ($statement->execute()) {
        
        header('Location: index.php'); 
        exit();
    } else {
        
        echo "Помилка видалення твору";
    }
} else {
    
    echo "Ідентифікатор твору не передано";
}
?>
