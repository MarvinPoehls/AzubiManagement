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
        $viewPath = __DIR__."/../Views/".$this->view.".php";

        $controller = $this;

        include __DIR__."/../Views/header.php";
        try {
            include $viewPath;
        } catch (Exception $exception) {
            include __DIR__."/../Views/error.php";
        }
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