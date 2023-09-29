<?php
class ControllerBase {

    public $view;
    protected $model;
    protected $isPublic;

    function __construct($view = new ViewBase)
    {
        $this->view = $view;
    }

    function loadModel($model){
        $url = "models/{$model}Model.php";

        if(file_exists($url))
        {
            require $url;

            $modelName = $model.'Model';
            $this->model = new $modelName();
        }
    }

    function redirect($url){
        header('location: '.constant('URL').$url);
    }

}
?>