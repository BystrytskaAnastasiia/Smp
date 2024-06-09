<?php
require_once 'models\ReviewManager.php';

// Обробка введених даних
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reviewManager = new ReviewManager();
    $reviewManager->insertReview($_POST['name'], $_POST['email'], $_POST['message']);
}

// Отримання всіх відгуків
$reviewManager = new ReviewManager();
$reviews = $reviewManager->getAllReviews();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вставка та відображення відгуків</title>
</head>
<body>
    <h1>Вставка та відображення відгуків</h1>
    
    <!-- Форма для введення даних -->
    <form action="" method="POST">
        <label for="name">Ім'я:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="message">Повідомлення:</label><br>
        <textarea id="message" name="message" rows="4" required></textarea><br><br>
        
        <button type="submit">Вставити відгук</button>
    </form>

    <hr>

    <!-- Відображення всіх відгуків -->
    <h2>Усі відгуки</h2>
    <table border="1">
        <tr>
            <th>Ім'я</th>
            <th>Email</th>
            <th>Повідомлення</th>
        </tr>
        <?php foreach ($reviews as $review): ?>
            <tr>
                <td><?php echo $review['name']; ?></td>
                <td><?php echo $review['email']; ?></td>
                <td><?php echo $review['message']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
