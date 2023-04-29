<?php
include "config.php";
require ROOT."/vendor/autoload.php";
$urlHost = "/".PROJECT_NAME;

if($_SERVER['HTTP_HOST'] == COMPOSER_WEBSERVER){
    $urlHost = "";
}

$noteFactory = new NoteFactory();
$noteModel = $noteFactory->getNoteModel();
$noteController = $noteFactory->getNoteController();
if($noteController->ajax == false){
    $noteModel->clear();
}
include DOCUMENT_PUBLIC."/home.php";
?>
