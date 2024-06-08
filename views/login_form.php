<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Constantia&display=swap');

        body {
            font-family: 'Constantia', serif;
            background-color: #F3E5F5;
            color: #8A2BE2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            margin-bottom: 30px;
        }

        form {
            background-color: #D8BFD8;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #8A2BE2;
            border-radius: 5px;
            margin-bottom: 15px;
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

        ul {
            list-style-type: none;
            padding: 0;
            margin-top: 20px;
        }

        li {
            color: #FF0000;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>Login</h1>
    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Login</button>
    </form>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>