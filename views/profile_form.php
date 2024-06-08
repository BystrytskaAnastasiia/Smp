
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
                @import url('https://fonts.googleapis.com/css2?family=Constantia&display=swap');

body {
    font-family: 'Constantia', serif;
    background-color: #F3E5F5;
    color: #8A2BE2;
    margin: 0;
    padding: 0;
}

header {
    background-color: #D8BFD8;
    padding: 20px;
    text-align: center;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px;
    display: flex;
    align-items: flex-start;
}

.main-content {
    flex: 1;
}

img {
    max-width: 200px;
    border-radius: 50%;
    margin-bottom: 20px;
}

.profile-info h1 {
    margin-top: 0;
    color: #8A2BE2;
}

.profile-info p {
    line-height: 1.5;
}

.edit-profile-btn {
    display: inline-block;
    background-color: #D8BFD8;
    color: #8A2BE2;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 20px;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

.edit-profile-btn:hover {
    background-color: #BDA0CB;
}

.works-panel {
    background-color: #D8BFD8;
    padding: 20px;
    border-radius: 10px;
    margin-top: 40px;
    width: 100%;
    box-sizing: border-box;
}

.works-panel h2 {
    margin-top: 0;
    color: #8A2BE2;
}

.works-panel ul {
    list-style-type: none;
    padding: 0;
}

.works-panel li {
    margin-bottom: 10px;
}

.sidebar {
    width: 200px;
    background-color: #D8BFD8;
    padding: 20px;
    border-radius: 10px;
    margin-left: 40px;
}

.sidebar h3 {
    margin-top: 0;
    color: #8A2BE2;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar li {
    margin-bottom: 10px;
}

.sidebar a {
    color: #8A2BE2;
    text-decoration: none;
    transition: color 0.3s ease;
}

.sidebar a:hover {
    color: #BDA0CB;
}
.profile-card {
    display: flex;
    align-items: center;
    background-color: #D8BFD8;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.profile-photo {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin-right: 20px;
}

.profile-details {
    flex: 1;
}

.profile-details h2 {
    margin: 0;
    color: #8A2BE2;
}

.profile-details .autobiography {
    margin-top: 10px;
    line-height: 1.5;
}
.works-panel ul {
    list-style-type: none;
    padding: 0;
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    gap: 10px; /* Додано проміжок між картками */
}

.works-panel li {
    width: calc(33.33% - 60px); /* Зменшено ширину картки для компенсації проміжку */
    background-color: #f2f2f2;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.works-panel h3 {
    margin-top: 0;
}

.works-panel img {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
}

    </style>
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
        <div class="main-content">
            <div class="profile-card">
                <img src="<?php echo htmlspecialchars($user['photo_profile']); ?>" alt="Profile Photo" class="profile-photo">
                <div class="profile-details">
                    <h2><?php echo htmlspecialchars($user['nick_name']); ?></h2>
                    <p class="autobiography"><?php echo nl2br(htmlspecialchars($user['autobiography'])); ?></p>
                </div>
            </div>
            <div class="works-panel">
                <h2>Твори</h2>
                <ul>
                    <?php foreach ($works as $work): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($work['title']); ?></h3>
                            <!-- Додана кнопка "Редагувати твір" -->
                            <a href="view/  edit_work_form.php?work_id=<?php echo $work['work_id']; ?>">Редагувати твір</a>
                            <p>Age Rating: <?php echo htmlspecialchars($work['age_rating']); ?></p>
                            <p>Description: <?php echo nl2br(htmlspecialchars($work['description'])); ?></p>
                            <img src="<?php echo htmlspecialchars($work['cover']); ?>" alt="Cover Image" width="150">
                            <p>Status: <?php echo htmlspecialchars($work['status']); ?></p>
                            <p>Date of Publication: <?php echo htmlspecialchars($work['date_of_publication']); ?></p>
                            <p>Number of Likes: <?php echo htmlspecialchars($work['number_of_likes']); ?></p>
                            <p>Free: <?php echo $work['free'] ? 'Yes' : 'No'; ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php if ($_SESSION['user_id'] === $user['user_id']): ?>
            <div class="sidebar">
                <h3>Додаткові функції</h3>
                <ul>
                    <li><a href="collections.php">Збірники</a></li>
                    <li><a href="create_work.php">Кабінет автора</a></li>
                    <li><a href="logout.php">Вихід</a></li>
                    <li><a href="edit_profile.php">Редагувати профіль</a></li>
                </ul>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="submit" name="delete" value="Видалити профіль">
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>