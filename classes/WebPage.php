<?php
abstract class WebPage {
    private $title;

    public function __construct($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

    public function render() {
        $this->renderHeader();
        $this->renderContent();
        $this->renderFooter();
    }

    protected function renderHeader() {
        $this->startSession();

        $loginText = $this->generateLoginText();

        echo "
        <header>
            <div class='container'>
                <div class='logo'>
                    <h1>MoonRead</h1>
                </div>
                <nav>
                    <ul>
                        <li><a href='index.php'>Головна</a></li>
                        <li><a href='work.php'>Твори</a></li>
                   

                        $loginText
                    </ul>
                </nav>
            </div>
        </header>";
    }

    private function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
            session_regenerate_id(true); 
        }
    }

    private function generateLoginText() {
        if (isset($_SESSION['user_id'])) { 
            return '
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Профіль <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php">Переглянути профіль</a></li>
                        <li><a href="edit_profile.php">Редагувати профіль</a></li>
                        <li><a href="logout.php">Вийти</a></li>
                    </ul>
                </li>';
        } else {
            return '
                <li><a href="login.php">Увійти</a></li>
                <li><a href="register.php">Зареєструватися</a></li>';
        }
    }

    protected abstract function renderContent();

    protected function renderFooter() {
        echo "
        <footer>
            <div class='container footer-container'>
                <p><a href='about.php' class='footer-link'>Про нас</a></p>
                <p><a href='privacy.php' class='footer-link'>Правила конфідеційності</a></p>
                <p><a href='contact.php' class='footer-link'>Зворотній зв'язок</a></p>
                <p><a href='terms.php' class='footer-link'>Користувацькі правила</a></p>
                <p><a href='publication_rules.php' class='footer-link'>Правила публікації контента</a></p>
            </div>
        </footer>";
    }
}
?>
