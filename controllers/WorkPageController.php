<?php
require_once 'models/CollectionModel.php';

class WorkPageController {
    private $workModel;
    private $database;

    public function __construct($workModel, $database) {
        $this->workModel = $workModel;
        $this->database = $database;
    }
    // У вашому контролері WorkPageController.php
    public function show($work_id) {
        // Отримання твору
        $work = $this->workModel->getWorkById($work_id);

        
        $chapters = $this->workModel->getChaptersByWorkId($work_id);


        // Передача змінних у представлення (view)
        require 'views/work_page.php';
    }

    public function handleLike($work_id, $user_id) {
        if ($this->workModel->addLike($work_id, $user_id)) {
            return 'Лайк успішно додано!';
        } else {
            return 'Помилка: не вдалося додати лайк.';
        }
    }
}
?>
