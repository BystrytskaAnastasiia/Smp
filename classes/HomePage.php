<?php
require_once 'classes/WebPage.php';

class HomePage extends WebPage {
    private $popularWorks;
    private $newWorks;

    public function __construct($title, $popularWorks, $newWorks) {
        parent::__construct($title);
        $this->popularWorks = $popularWorks;
        $this->newWorks = $newWorks;
    }

    protected function renderContent() {
        $this->renderGreeting();
        $this->renderSearchForm();
        $this->renderPopularWorksSection();
        $this->renderNewWorksSection();
    }

    private function renderGreeting() {
        echo '<h1>Вітаємо на MoonRead!</h1>';
        echo '<p>Тут ви можете читати та завантажувати твори різних жанрів.</p>';
    }

    private function renderSearchForm() {
        echo '<div class="search-form">';
        echo '<form action="search.php" method="get">';
        echo '<input type="text" name="query" placeholder="Пошук творів..." class="search-input">';
        echo '<button type="submit" class="search-button">Пошук</button>';
        echo '</form>';
        echo '</div>';
    }

    private function renderPopularWorksSection() {
        echo '<section>';
        echo '<h2>Популярні твори</h2>';
        foreach ($this->popularWorks as $work) {
            $this->renderWork($work);
        }
        echo '</section>';
    }

    private function renderNewWorksSection() {
        echo '<section>';
        echo '<h2>Нові твори</h2>';
        foreach ($this->newWorks as $work) {
            $this->renderWork($work);
        }
        echo '</section>';
    }

    private function renderWork($work) {
        echo '<div class="work">';
        echo '<h3>' . htmlspecialchars($work['title']) . '</h3>';
        echo '<p>Рейтинг: ' . htmlspecialchars($work['age_rating']) . '</p>';
        echo '<p>' . htmlspecialchars($work['description']) . '</p>';
        echo '<p><img src="' . htmlspecialchars($work['cover']) . '" alt="' . htmlspecialchars($work['title']) . '" width="150"></p>';
        echo '<p>Статус: ' . htmlspecialchars($work['status']) . '</p>';
        echo '<p>Дата публікації: ' . htmlspecialchars($work['date_of_publication']) . '</p>';
        echo '<p>Кількість лайків: ' . htmlspecialchars($work['number_of_likes']) . '</p>';
        echo '<p>' . ($work['free'] ? 'Безкоштовно' : 'Платно') . '</p>';
        
        
        echo '<p><a href="profile.php?user_id=' . $work['user_id'] . '">Переглянути профіль користувача</a></p>';
        
        echo '</div>';
    }
    
}
?>
