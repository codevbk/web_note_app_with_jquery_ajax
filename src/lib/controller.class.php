<?php
class NoteController {
    private $model;
    private $view;
    public $ajax = false;

    public function __construct($model, $view) {
        $this->model = $model;
        $this->view = $view;
        $this->handleRequest();
    }

    public function handleRequest() {
        $requestArr = array("create","read","update","delete");
        $requestMethodArr = array("POST","GET","PUT","DELETE");
        $requestCheck = false;
        $request = null;

        if(isset($_GET["action"]) && !empty($_GET["action"])){
            $requestCheck = array_search($_GET["action"] , $requestArr);
            $this->ajax = true;
        }

        $response = null;
        if($requestCheck !== false){
            switch ($requestMethodArr[$requestCheck]) {
                case 'GET':
					header("Content-Type: application/json;");
                    $request = $_GET;
                    $response = $this->model->read();
                    break;
                case 'POST':
                    $request = file_get_contents("php://input");
                    $this->model->create($request);
                    break;
                case 'PUT':
                    $request = file_get_contents('php://input');
                    $this->model->update($request);
                    break;
                case 'DELETE':
                    $request = file_get_contents("php://input");
                    $this->model->delete($request);
                    break;
                default:
                    break;
            }
        }

        $this->view->render($response);
    }
}
?>