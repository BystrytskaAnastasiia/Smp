<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Керування Відгуками</title>
</head>
<body>
    <div class="container">
        <h1>Керування Відгуками</h1>
        
        <form action="" method="post">
            <label for="work_id">ID Твору:</label><br>
            <input type="number" id="work_id" name="work_id" required><br><br>

            <label for="user_id">ID Користувача:</label><br>
            <input type="number" id="user_id" name="user_id" required><br><br>

            <label for="review_text">Текст Відгуку:</label><br>
            <textarea id="review_text" name="review_text" rows="4" required></textarea><br><br>

            <label for="review_date">Дата Відгуку:</label><br>
            <input type="date" id="review_date" name="review_date" required><br><br>

            <button type="submit" name="insert">Додати Відгук</button>
        </form>

        <?php
        require_once 'models\ReviewDatabase.php';

        $db = new ReviewDatabase('reviews.db');

        if (isset($_POST['insert'])) {
            $workId = $_POST['work_id'];
            $userId = $_POST['user_id'];
            $reviewText = $_POST['review_text'];
            $reviewDate = $_POST['review_date'];

            $db->insertReview($workId, $userId, $reviewText, $reviewDate);
        }

        $reviews = $db->getReviews();
        ?>

        <h2>Список Відгуків</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>ID Твору</th>
                <th>ID Користувача</th>
                <th>Текст Відгуку</th>
                <th>Дата Відгуку</th>
            </tr>
            <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?php echo htmlspecialchars($review['id']); ?></td>
                    <td><?php echo htmlspecialchars($review['work_id']); ?></td>
                    <td><?php echo htmlspecialchars($review['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($review['review_text']); ?></td>
                    <td><?php echo htmlspecialchars($review['review_date']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
