<?php
class FilterModel {
    private $pdo;

    public function __construct($database) {
        $this->pdo = $database->getPdo();
    }

    public function filterWorks($tags, $minLikes, $status, $free) {
        // Будуємо SQL-запит залежно від переданих параметрів
        $sql = 'SELECT * FROM work WHERE 1';

        // Додаємо умову для фільтрації за тегами
        if (!empty($tags)) {
            $sql .= ' AND work_id IN (SELECT work_id FROM work_tags WHERE tags_id IN (SELECT tags_id FROM tags WHERE tags_text IN (' . implode(',', array_fill(0, count($tags), '?')) . ')))';
        }

        // Додаємо умову для фільтрації за кількістю лайків
        if ($minLikes !== null) {
            $sql .= ' AND number_of_likes >= ?';
        }

        // Додаємо умову для фільтрації за статусом
        if (!empty($status)) {
            $sql .= ' AND status IN (' . implode(',', array_fill(0, count($status), '?')) . ')';
        }

        // Додаємо умову для фільтрації за типом (платний / безкоштовний)
        if (!empty($free)) {
            $sql .= ' AND free = ?';
        }

        // Підготовлюємо запит до виконання
        $stmt = $this->pdo->prepare($sql);

        // Задаємо значення параметрів та виконуємо запит
        $index = 1;
        foreach ($tags as $tag) {
            $stmt->bindValue($index++, $tag);
        }
        if ($minLikes !== null) {
            $stmt->bindValue($index++, $minLikes, PDO::PARAM_INT);
        }
        if (!empty($status)) {
            foreach ($status as $s) {
                $stmt->bindValue($index++, $s);
            }
        }
        if (!empty($free)) {
            $stmt->bindValue($index++, $free);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
