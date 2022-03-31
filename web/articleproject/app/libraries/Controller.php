<?php

class Controller {
    public function model($modelName)
    {
        $path = '../app/models/' . $modelName . '.php';
        if (file_exists($path))
        {
            require_once($path);

            return new $modelName;
        }
        else
        {
            die("مدل یافت نشد");
        }
    }

    public function view($view, $data = [])
    {
        $path = '../app/views/' . $view . '.php';
        if (file_exists($path))
        {
            require_once($path);
        }
        else
        {
            die("ویو یافت نشد");
        }
    }
}

?>