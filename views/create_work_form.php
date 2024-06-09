
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Додати новий твір</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Constantia&display=swap');

        body {
            font-family: 'Constantia', serif;
            margin: 0;
            padding: 0;
            background-color: #F3E5F5;
            color: #8A2BE2;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #D8BFD8;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #8A2BE2;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        button[type="submit"] {
            background-color: #8A2BE2;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #BDA0CB;
        }
        .author-info {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        perspective: 500px;
    }

    .author-info label {
        font-family: 'Constantia', serif;
        font-size: 18px;
        color: #8A2BE2;
        margin-right: 10px;
        transform: rotateY(20deg);
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }

    .author-info h2 {
        margin: 0;
        font-family: 'Brush Script MT', cursive;
        font-size: 36px;
        color: #6A5ACD;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        transform: rotateY(-20deg);
    }

    .author-info h2::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotateY(90deg);
        width: 100%;
        height: 20px;
        background-color: #D8BFD8;
        z-index: -1;
        transition: transform 0.5s ease;
    }

    .author-info:hover h2::before {
        transform: translate(-50%, -50%) rotateY(0deg);
    }
    .editor-functions {
    background-color: #f2f2f2;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    z-index: 999;
}

.editor-functions label {
    margin-bottom: 5px;
    font-weight: bold;
}

.editor-functions select,
.editor-functions input[type="button"] {
    margin-bottom: 10px;
    padding: 5px 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    background-color: #fff;
    cursor: pointer;
}

.editor-functions input[type="button"] {
    background-color: #4CAF50;
    color: white;
    border: none;
}

.editor-functions input[type="button"]:hover {
    background-color: #45a049;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Додати новий твір</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="author-info">
                <label for="nick_name">Автор:</label><br>
                <h2><?php echo htmlspecialchars($user['nick_name']); ?></h2>
            </div>

            <label for="title">Назва:</label><br>
            <input type="text" id="title" name="title" required><br><br>

            <label for="age_rating">Віковий рейтинг:</label><br>
            <select name="age_rating" id="age_rating" required>
                <option value="0">0+</option>
                <option value="6">6+</option>
                <option value="12">12+</option>
                <option value="16">16+</option>
                <option value="18">18+</option>
            </select><br><br>

            <label for="description">Опис:</label><br>
            <textarea id="description" name="description" rows="4" required></textarea><br><br>

            <label for="tags">Теги:</label><br>
            <select name="tags[]" id="tags" multiple required>
                <?php foreach ($tags as $tag): ?>
                    <option value="<?php echo $tag['tags_id']; ?>"><?php echo $tag['tags_text']; ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="cover">Обкладинка:</label><br>
            <input type="file" id="cover" name="cover" accept="image/*" required><br><br>

            <label for="status">Статус:</label><br>
            <select name="status" id="status" required>
                <option value="в процесі">В процесі</option>
                <option value="заморожений">Заморожений</option>
                <option value="закінчений">Закінчений</option>
            </select><br><br>

            <label for="free">Доступ:</label><br>
            <select name="free" id="free" required>
                <option value="1">Безкоштовний</option>
                <option value="0">Платний</option>
            </select><br><br>

            <label for="chapter_number">Нумерація глави:</label><br>
            <input type="text" id="chapter_number" name="chapter_number" required><br><br>

            <label for="publish_date">Дата публікації:</label><br>
            <input type="date" id="publish_date" name="publish_date" required><br><br>

            <label for="content">Вміст твору:</label><br>
            <textarea id="content" name="content" rows="8" required></textarea><br><br>

            <button type="submit">Додати твір</button>
        </form>
    </div>
    <div class="editor-functions">
        <label for="font_size">Розмір шрифта:</label>
        <select name="font_size" id="font_size" onchange="applyFontStyles()">
            <option value="10px">10px</option>
            <option value="12px">12px</option>
            <option value="14px">14px</option>
            <!-- Додайте інші розміри шрифту за потреби -->
        </select>

        <label for="font_family">Шрифт:</label>
        <select name="font_family" id="font_family" onchange="applyFontStyles()">
            <option value="Arial">Arial</option>
            <option value="Helvetica">Helvetica</option>
            <option value="Times New Roman">Times New Roman</option>
            <option value="Courier New">Courier New</option>
            <option value="Verdana">Verdana</option>
            <option value="Georgia">Georgia</option>
            <option value="Palatino">Palatino</option>
            <option value="Garamond">Garamond</option>
            <option value="Comic Sans MS">Comic Sans MS</option>
            <option value="Impact">Impact</option>
            <!-- Додайте інші шрифти за потреби -->
        </select>

        <input type="button" value="Ліве вирівнювання" onclick="applyTextAlignment('left');">
        <input type="button" value="Центральне вирівнювання" onclick="applyTextAlignment('center');">
        <input type="button" value="Праве вирівнювання" onclick="applyTextAlignment('right');">

        <input type="button" value="Підкреслений" onclick="document.getElementById('content').style.textDecoration = 'underline';">
        <input type="button" value="Курсив" onclick="document.getElementById('content').style.fontStyle = 'italic';">
        <input type="button" value="Жирний" onclick="document.getElementById('content').style.fontWeight = 'bold';">
    </div>
</body>

</html>
<script>
        // Функція, яка застосовує обрані параметри шрифту до текстового поля
        function applyFontStyles() {
            var fontSize = document.getElementById("font_size").value;
            var fontFamily = document.getElementById("font_family").value;
            document.getElementById("content").style.fontSize = fontSize;
            document.getElementById("content").style.fontFamily = fontFamily;
        }

        function applyTextAlignment(align) {
            document.getElementById("content").style.textAlign = align;
        }
    </script>