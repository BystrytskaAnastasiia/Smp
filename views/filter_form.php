<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фільтрація Творів</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Constantia&display=swap');

        body {
            font-family: 'Constantia', serif;
            background-color: #F3E5F5;
            color: #8A2BE2;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        h1 {
            margin-bottom: 30px;
        }

        form {
            background-color: #D8BFD8;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin-bottom: 30px;
        }

        div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select,
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #8A2BE2;
            border-radius: 5px;
            box-sizing: border-box;
            font-family: 'Constantia', serif;
            color: #8A2BE2;
        }

        button[type="submit"] {
            background-color: #8A2BE2;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Constantia', serif;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #BDA0CB;
        }

        .works-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-gap: 20px;
            width: 100%;
            max-width: 1200px;
        }

        .work-card {
            background-color: #D8BFD8;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .work-card h2 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <h1>Фільтрація Творів</h1>
    <form action="filter.php" method="GET">
        <div>
            <label for="tags">Теги:</label>
            <select name="tags[]" id="tags" multiple>
                <option value="романтика">Романтика</option>
                <option value="жахи">Жахи</option>
                <option value="комедія">Комедія</option>
                <!-- Додайте інші теги за необхідністю -->
            </select>
        </div>
        <div>
            <label for="minLikes">Мінімальна Кількість Лайків:</label>
            <input type="number" id="minLikes" name="minLikes" min="0">
        </div>
        <div>
            <label for="status">Статус:</label>
            <select name="status[]" id="status" multiple>
                <option value="заморожений">Заморожений</option>
                <option value="в процесі">В процесі</option>
                <option value="завершений">Завершений</option>
            </select>
        </div>
        <div>
            <label for="free">Безкоштовно:</label>
            <select name="free" id="free">
                <option value="1">Так</option>
                <option value="0">Ні</option>
            </select>
        </div>
        <button type="submit">Фільтрувати</button>
    </form>
    <div class="works-container">
    <?php if (!empty($filteredWorks)): ?>
        <?php foreach ($filteredWorks as $work): ?>
            <div class="work-card">
                <h2><?php echo htmlspecialchars($work['title']); ?></h2>
                <p><?php echo htmlspecialchars($work['description']); ?></p>
                <!-- Додайте інші дані твору за необхідністю -->
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Немає творів, що відповідають вибраним критеріям фільтрації.</p>
    <?php endif; ?>
</div>
</body>
</html>