<?php
class WorkController {
    private $workModel;
    private $userModel;

    public function __construct($workModel, $userModel) {
        $this->workModel = $workModel;
        
    }

    public function index() {
        $popularWorks = $this->workModel->getPopularWorks();
        $newWorks = $this->workModel->getNewWorks();
        $newcomers = $this->workModel->getNewcomersWithPhoto();
        $legends = $this->workModel->getLegends();

        require 'views/work_form.php';
    }
    
}
?>
