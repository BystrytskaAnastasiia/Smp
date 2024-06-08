<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collections</title>
</head>
<body>
    <h1>Collections</h1>
    <?php if (!empty($collections)): ?>
    <ul>
        <?php foreach ($collections as $collection): ?>
            <li>
                <?php echo htmlspecialchars($collection['name']); ?>:
                <ul>
                    <?php if (!empty($collection['works'])): ?>
                        <?php foreach ($collection['works'] as $work): ?>
                            <li><?php echo htmlspecialchars($work['title']); ?></li>
                                <?php endforeach; ?>
                                <?php else: ?>
                        <li>Цей збірник порожній.</li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Список збірників порожній.</p>
<?php endif; ?>

    <form action="" method="post">
        <input type="hidden" name="action" value="create_collection">
        <input type="text" name="collection_name" placeholder="Введіть назву збірника" required>
        <button type="submit">Створити збірник</button>
    </form>
</body>
</html>
