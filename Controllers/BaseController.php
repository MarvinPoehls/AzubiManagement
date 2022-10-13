<?php

class BaseController
{
    protected $title = "Azubi Portal";
    protected $view = false;

    public function getView()
    {
        return $this->view;
    }

    public function render()
    {
        if ($this->view === false) {
            die("NO VIEW FOUND");
        }

        $viewPath = __DIR__."/../Views/".$this->view.".php";
        if (!file_exists($viewPath)) {
            die("VIEW FILE NOT FOUND");
        }

        $controller = $this;

        include __DIR__."/../Views/header.php";
        include $viewPath;
        include __DIR__."/../Views/footer.php";
    }

    public function getRequestParameter($key, $default = false)
    {
        if (isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        }
        return $default;
    }

    public function redirect($location)
    {
        header("Location: " . $location);
        exit();
    }

    public function getUrl($data)
    {
        return Configuration::getConfigParameter("path") . $data;
    }

    public function getTitle()
    {
        return $this->title;
    }
}