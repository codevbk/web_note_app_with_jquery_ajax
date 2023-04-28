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
            break;
        case 'POST':
            $request = file_get_contents("php://input");
            break;
        case 'PUT':
            $request = file_get_contents('php://input');
            break;
        case 'DELETE':
            $request = file_get_contents("php://input");
            break;
        default:
            break;
    }
}

echo $response;

?>