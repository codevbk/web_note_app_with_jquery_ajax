<?php
// Abstract Factory Interface
interface NoteFactoryInterface {
    public function createNoteModel();
    public function getNoteModel();
    public function createNoteView();
    public function getNoteView();
    public function createNoteController();
    public function getNoteController();
}


// Concrete Factory Method
class NoteFactory implements NoteFactoryInterface{
	public $model;
	public $view;
	public $controller;
    public function __construct() {
        $this->model = $this->createNoteModel();
        $this->view = $this->createNoteView();
        $this->controller = $this->createNoteController();
	}
	
	public function createNoteModel() {
		return new NoteModel();
	}
	
	public function getNoteModel() {
		return $this->model;
	}
	
	public function createNoteView() {
		return new NoteView($this->model);
	}
	
	public function getNoteView() {
		return $this->view;
	}
	
	public function createNoteController() {
		return new NoteController($this->model, $this->view);
	}
	
	public function getNoteController() {
		return $this->controller;
	}
}


?>