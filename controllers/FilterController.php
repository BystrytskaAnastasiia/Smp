<?php
class FilterController {
    private $filterModel;

    public function __construct($filterModel) {
        $this->filterModel = $filterModel;
    }

    public function filter() {
        // Отримуємо параметри фільтрації з запиту
        $tags = isset($_GET['tags']) ? $_GET['tags'] : [];
        $minLikes = isset($_GET['minLikes']) ? $_GET['minLikes'] : null;
        $status = isset($_GET['status']) ? $_GET['status'] : [];
        $free = isset($_GET['free']) ? $_GET['free'] : null;

        // Викликаємо метод моделі для фільтрації
        $filteredWorks = $this->filterModel->filterWorks($tags, $minLikes, $status, $free);

        // Передаємо результати відображенню
        require 'views/filter_form.php';
    }
}
?>
