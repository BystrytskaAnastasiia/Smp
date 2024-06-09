<!-- <!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Додати главу</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php">
                <h1>MoonRead</h1>
            </a>
        </div>
    </header>
    <div class="container">
        <h2>Додати нову главу</h2>
        <form action="addchapter.php?action=add_chapter" method="post">
            <input type="hidden" name="work_id" value="<?php echo htmlspecialchars($_GET['work_id']); ?>">
            <label for="chapter_number">Номер глави:</label>
            <input type="number" id="chapter_number" name="chapter_number" required><br>

            <label for="status">Статус:</label>
            <select id="status" name="status" required>
                <option value="draft">Чернетка</option>
                <option value="published">Опубліковано</option>
            </select><br>

            <label for="content">Зміст:</label>
            <textarea id="content" name="content" rows="10" cols="50" required></textarea><br>

            <label for="publish_date">Дата публікації:</label>
            <input type="date" id="publish_date" name="publish_date" required><br>

            <input type="submit" value="Додати главу">
        </form>
    </div>
</body>
</html> -->
