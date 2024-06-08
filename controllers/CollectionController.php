<?php
class CollectionController {
    private $collectionModel;

    public function __construct($collectionModel) {
        $this->collectionModel = $collectionModel;
    }

    public function showCollections($user_id) {
        $collections = $this->collectionModel->getCollectionsByUserId($user_id);
        require 'views/collections_form.php';
    }

    public function createCollection($user_id, $collection_name) {
        $collection_id = $this->collectionModel->createCollection($user_id, $collection_name);
        if ($collection_id) {
            echo 'Збірник успішно створено!';
        } else {
            echo 'Помилка: не вдалося створити збірник.';
        }
    }
    
}
?>
