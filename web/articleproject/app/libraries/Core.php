<?php

class Core {
    protected $currentController = "Pages";
    protected $currentMethod = "index";
    protected $params = [];

    public function __construct()
    {
        $arr_url = $this->getUrl();
        if (isset($arr_url[0]))
        {
            $tController = ucwords($arr_url[0]);
            if (file_exists('../app/controllers/' . $tController . '.php'))
            {
                $this->currentController = $tController;

                unset($arr_url[0]);
            }
        }

        require_once('../app/controllers/' . $this->currentController . '.php');
        $this->currentController = new $this->currentController;

        
        if (isset($arr_url[1]))
        {
            if (method_exists($this->currentController, $arr_url[1]))
            {
                $this->currentMethod = $arr_url[1];

                unset($arr_url[1]);
            }
        }


        $this->params = $arr_url ? array_values($arr_url) : [];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url']))
        {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $arr_url = explode('/', $url);
            return $arr_url;
        }
        else
        {
            return [];
        }
    }
}

?>