<?php
class NoteView {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function render($data) {
        echo $data;
    }
}
?>