<?php
class FilterModel {
    private $pdo;

    public function __construct($database) {
        $this->pdo = $database->getPdo();
    }

    public function filterWorks($tags, $minLikes, $status, $free = 1) {
        // Начальный SQL-запрос
        $sql = 'SELECT * FROM work WHERE 1';

        // Условие для фильтрации по тегам
        if (!empty($tags)) {
            $tagsList = implode(',', array_map(function($tag) {
                return $this->pdo->quote($tag);
            }, $tags));
            $sql .= " AND work_id IN (SELECT work_id FROM work_tags WHERE tags_id IN (SELECT tags_id FROM tags WHERE tags_text IN ($tagsList)))";
        }

        // Условие для фильтрации по количеству лайков
        if ($minLikes !== null) {
            $sql .= " AND number_of_likes >= " . (int)$minLikes;
        }

        // Условие для фильтрации по статусу
        if (!empty($status)) { // Check if $status is not empty
            $status = $this->pdo->quote($status); // Quote the status value
            $sql .= " AND status = $status";
        }

        // Условие для фильтрации по типу (платный / бесплатный)
        $free = (int)$free; // Ensure $free is an integer
        $sql .= " AND free = $free";

        // echo $sql; // Uncomment for debugging

        // Выполнение запроса
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
