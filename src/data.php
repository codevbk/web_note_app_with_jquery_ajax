<?php

$requestArr = array("create","read","update","delete");
$requestMethodArr = array("POST","GET","PUT","DELETE");
$requestCheck = false;
$request = null;

if(isset($_GET["action"]) && !empty($_GET["action"])){
    $requestCheck = array_search($_GET["action"] , $requestArr);
    $ajax = true;
}

$response = null;
if($requestCheck !== false){
    switch ($requestMethodArr[$requestCheck]) {
        case 'GET':
            $request = $_GET;
			$response = readNote();
            break;
        case 'POST':
            $request = file_get_contents("php://input");
			createNote($request);
            break;
        case 'PUT':
            $request = file_get_contents('php://input');
			updateNote($request);
            break;
        case 'DELETE':
            $request = file_get_contents("php://input");
            break;
        default:
            break;
    }
}

echo $response;

function createNote($data) {
    $fileHandler = new FileHandler();
    $jsonData = json_decode($data,true);
    $fileLocation = DOCUMENT_ROOT."/data/".$jsonData["id"].".json";
    $fileHandler->open($fileLocation);
    $fileHandler->write($data);
    $fileHandler->close();
    chmod($fileLocation, 0777);
}

function readNote() {
    $filesNotes = glob(DOCUMENT_ROOT."/data/*");
    $noteArr = array();
    if(isset($filesNotes) && !empty($filesNotes) && count($filesNotes) > 0){
        foreach($filesNotes as $fileNote){
            $fileHandler = new FileHandler();
            $fileLocation = $fileNote;
            $fileHandler->open($fileLocation);
            $noteArr[] = $fileHandler->read($fileLocation);
            $fileHandler->close();
        }
    }
    return json_encode($noteArr);
}

function updateNote($data) {
    $fileHandler = new FileHandler();
    $jsonData = json_decode($data,true);
    $fileLocation = DOCUMENT_ROOT."/data/".$jsonData["id"].".json";
    $fileHandler->open($fileLocation);
    $fileHandler->write($data);
    $fileHandler->close();
}
?>