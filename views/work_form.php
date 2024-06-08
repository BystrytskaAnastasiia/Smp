<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Works Page</title>
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
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
            color: #8A2BE2;
        }

        .panel {
            background-color: #D8BFD8;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .work-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .work-list li {
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .work-list li:hover {
            transform: translateY(-5px);
        }

        .form-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group input[type="range"] {
            width: 100%;
        }

        .form-group input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .author-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .author-nickname {
            font-size: 14px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo a {
            text-decoration: none;
            color: #8A2BE2;
        }

        .filter-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #8A2BE2;
            color: #FFFFFF;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .filter-link:hover {
            background-color: #BDA0CB;
        }
    </style>
</head>
<body>
    <div class="logo">
        <a href="index.php">
            <h1>MoonRead</h1>
        </a>
    </div>

    <div class="container">
        <a href="filter.php" class="filter-link">Фільтрувати</a>

        
        <div class="panel">
    <h2>Популярні твори</h2>
    <ul class="work-list">
        <?php foreach ($popularWorks as $work): ?>
            <li>
                <div class="work">
                    <h3><a href="work_p.php?work_id=<?php echo htmlspecialchars($work['work_id']); ?>"><?php echo htmlspecialchars($work['title']); ?></a></h3>
                    <p>Рейтинг: <?php echo htmlspecialchars($work['age_rating']); ?></p>
                    <p><?php echo htmlspecialchars($work['description']); ?></p>
                    <p><img src="<?php echo htmlspecialchars($work['cover']); ?>" alt="<?php echo htmlspecialchars($work['title']); ?>" width="150"></p>
                    <p>Статус: <?php echo htmlspecialchars($work['status']); ?></p>
                    <p>Дата публікації: <?php echo htmlspecialchars($work['date_of_publication']); ?></p>
                    <p>Кількість лайків: <?php echo htmlspecialchars($work['number_of_likes']); ?></p>
                    <p><?php echo $work['free'] ? 'Безкоштовно' : 'Платно'; ?></p>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>


        <<div class="panel">
    <h2>Нові твори</h2>
    <ul class="work-list">
        <?php foreach ($newWorks as $work): ?>
            <li>
                <div class="work">
                    <!-- Змініть наступний рядок для додавання посилання -->
                    <h3><a href="work_p.php?work_id=<?php echo htmlspecialchars($work['work_id']); ?>"><?php echo htmlspecialchars($work['title']); ?></a></h3>
                    <p>Рейтинг: <?php echo htmlspecialchars($work['age_rating']); ?></p>
                    <p><?php echo htmlspecialchars($work['description']); ?></p>
                    <p><img src="<?php echo htmlspecialchars($work['cover']); ?>" alt="<?php echo htmlspecialchars($work['title']); ?>" width="150"></p>
                    <p>Статус: <?php echo htmlspecialchars($work['status']); ?></p>
                    <p>Дата публікації: <?php echo htmlspecialchars($work['date_of_publication']); ?></p>
                    <p>Кількість лайків: <?php echo htmlspecialchars($work['number_of_likes']); ?></p>
                    <p><?php echo $work['free'] ? 'Безкоштовно' : 'Платно'; ?></p>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>


        <div class="panel">
            <h2>Новачки автори</h2>
            <ul class="work-list">
                <?php foreach ($newcomers as $newcomer): ?>
                    <li>
                        <div class="author-card">
                            <a href="profile.php?user_id=<?php echo htmlspecialchars($newcomer['user_id']); ?>">
                                <div class="author-avatar">
                                    <img src="<?php echo htmlspecialchars($newcomer['photo_profile']); ?>" alt="<?php echo htmlspecialchars($newcomer['nick_name']); ?>" width="50" height="50">
                                </div>
                                <span class="author-nickname"><?php echo htmlspecialchars($newcomer['nick_name']); ?></span>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="panel">
            <h2>Легендарні автори</h2>
            <ul class="work-list">
                <?php foreach ($legends as $legend): ?>
                    <li>
                        <div class="author-card">
                            <a href="profile.php?user_id=<?php echo htmlspecialchars($legend['user_id']); ?>">
                                <div class="author-avatar">
                                    <img src="<?php echo htmlspecialchars($legend['photo_profile']); ?>" alt="<?php echo htmlspecialchars($legend['nick_name']); ?>" width="50" height="50">
                                </div>
                                <span class="author-nickname"><?php echo htmlspecialchars($legend['nick_name']); ?></span>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>