<?php
// Interface for NoteView
interface NoteViewInterface {
    public function render($data);
}

class NoteView implements NoteViewInterface{
    private $model;

    public function __construct(NoteModelInterface $model) {
        $this->model = $model;
    }

    public function render($data) {
        echo $data;
    }
}
?>