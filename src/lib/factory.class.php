<?php
// Factory Method
class NoteFactory {
	public $model;
	public $view;
	public $controller;
    public function __construct() {
        $this->model = new NoteModel();
        $this->view = new NoteView($this->model);
        $this->controller = new NoteController($this->model, $this->view);
	}
	
	public function getNoteModel() {
		return $this->model;
	}
	
	public function getNoteView() {
		return $this->view;
	}
	
	public function getNoteController() {
		return $this->controller;
	}
}


?>