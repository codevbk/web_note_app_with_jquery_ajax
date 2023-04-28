<?php
include "config.php";
require ROOT."/vendor/autoload.php";
$urlHost = "/".PROJECT_NAME;

if($_SERVER['HTTP_HOST'] == COMPOSER_WEBSERVER){
    $urlHost = "";
}
$ajax = false;
include DOCUMENT_ROOT."/data.php";
if($ajax == false){
    clearNotes();
}
include DOCUMENT_PUBLIC."/home.php";
?>
