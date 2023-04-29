<?php
include "config.php";
require ROOT."/vendor/autoload.php";
$urlHost = "/".PROJECT_NAME;

if($_SERVER['HTTP_HOST'] == COMPOSER_WEBSERVER){
    $urlHost = "";
}

$noteModel = new NoteModel();
$noteView = new NoteView($noteModel);
$noteController = new NoteController($noteModel, $noteView);
if($noteController->ajax == false){
    $noteModel->clear();
}
include DOCUMENT_PUBLIC."/home.php";
?>
