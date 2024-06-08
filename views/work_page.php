<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($work['title']) ? htmlspecialchars($work['title']) : 'Title not found'; ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Constantia&display=swap');

        body {
            font-family: 'Constantia', serif;
            background-color: #F3E5F5;
            color: #8A2BE2;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .container {
            background-color: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            padding: 30px;
            width: 100%;
        }

        h1 {
            margin-top: 0;
        }

        .work-info {
            margin-bottom: 30px;
        }

        .work-info p {
            margin: 10px 0;
        }

        .work-info img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }

        .chapters {
            margin-top: 30px;
        }

        .chapters ul {
            padding: 0;
            list-style-type: none;
        }

        .chapters li {
            margin-bottom: 20px;
        }

        .chapters h3 {
            margin-top: 0;
        }

        .add-to-collection {
            margin-top: 30px;
        }

        .add-to-collection select {
            width: 100%;
            padding: 10px;
            border: 1px solid #8A2BE2;
            border-radius: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
            font-family: 'Constantia', serif;
            color: #8A2BE2;
        }

        .add-to-collection button {
            background-color: #8A2BE2;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Constantia', serif;
            transition: background-color 0.3s ease;
        }

        .add-to-collection button:hover {
            background-color: #BDA0CB;
        }
    </style>
</head>
<body>
<div class="container">
    <?php if ($work && is_array($work)) : ?>
        <h1><?php echo htmlspecialchars($work['title']); ?></h1>
        <div class="work-info">
            
            <p><strong>Рейтинг:</strong> <?php echo htmlspecialchars($work['age_rating']); ?></p>
            <p><strong>Опис:</strong> <?php echo htmlspecialchars($work['description']); ?></p>
            <img src="<?php echo htmlspecialchars($work['cover']); ?>" alt="<?php echo htmlspecialchars($work['title']); ?>">
            <p><strong>Статус:</strong> <?php echo htmlspecialchars($work['status']); ?></p>
            <p><strong>Дата публікації:</strong> <?php echo htmlspecialchars($work['date_of_publication']); ?></p>
            <p><strong>Кількість лайків:</strong> <?php echo htmlspecialchars($work['number_of_likes']); ?></p>
            <form class="like-form" action="" method="post">
                <input type="hidden" name="action" value="like">
                <input type="hidden" name="work_id" value="<?php echo $work['work_id']; ?>">
                <button type="submit">Лайк</button>
            </form>
            <p><strong>Доступ:</strong> <?php echo $work['free'] ? 'Безкоштовно' : 'Платно'; ?></p>
        </div>

        <div class="chapters">
            <h2>Розділи</h2>
            <ul>
                <?php foreach ($chapters as $chapter): ?>
                    <li>
                        <h3>Розділ <?php echo htmlspecialchars($chapter['chapter_number']); ?>: <?php echo htmlspecialchars($chapter['title']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($chapter['content'])); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="add-to-collection">
            <h2>Додати у збірник</h2>
            <form action="" method="post">
                <input type="hidden" name="action" value="add_to_collection">
                <input type="hidden" name="work_id" value="<?php echo $work['work_id']; ?>">
                <select name="collection_id">
                    <?php foreach ($collections as $collection): ?>
                        <option value="<?php echo $collection['collection_id']; ?>"><?php echo htmlspecialchars($collection['name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Додати у збірник</button>
            </form>
        </div>

    <?php else: ?>
        <p>Дані про твір не були знайдені.</p>
    <?php endif; ?>
</div>
</body>
</html>

