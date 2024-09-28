<?php


class System {

    public $params;
    public $actions;
    public $controller;

    private $url;
    private $explode;
    private $pageDafault = 'Index';
    private $actionDafault = 'index';


    public function __construct() {
        $this->setUrl();
        $this->explodeUrl();
        $this->setController();
        $this->setActions();
        $this->setParams();
    }

    public function getParams() {
        return $this->params;
    }

    public function getPage() {

        $inst_controller = str_replace('-','',$this->controller.'Controller');
        $path_controller = PATH_CONTROLLER . $inst_controller.'.php';

        if(! file_exists($path_controller)) {
            die('Ocorreu um erro. Controller não existe');
        }

        require_once($path_controller);

        $app = new $inst_controller();

        if($this->actions != 'index') {
            $action = str_replace('-', '_', $this->actions);

            if ($this->controller == 'painel-informativo') {
                $action = 'single';
            }
        } else {
            if(! method_exists($app, $this->actions)) {
                die('Ocorreu um erro. A action não existe ' . $this->actions);
            }
            $action = $this->actions;
        }

        $app->$action();

    }

    public function getController() {
        return $this->controller;
    }

    public function getDebug() {
        echo 'Url: ' . $this->url;
        echo '<br>';
        echo 'Explode URL:<br>';
        echo '<pre>';
        var_dump($this->explode);
        echo '</pre>';
        echo '<br>';
        echo 'Controller: ' . $this->controller;
        echo '<br>';
        echo 'Action: ' . $this->actions;
        echo '<br>';
        echo 'Parâmetros:<br>';
        echo '<pre>';
        var_dump($this->params);
        echo '</pre>';
        echo '<br>';
        echo PATH_CONTROLLER . $this->controller . 'Controller.php';
        echo '<br>';
        echo '<br>';
    }

    private function setUrl() {
        $this->url = (isset($_GET['url'])) ? $_GET['url'] : $this->pageDafault;
    }

    private function explodeUrl() {
        $this->explode = explode('/', $this->url);
    }

    private function setController() {
        $this->controller = $this->explode[0];
    }

    private function setActions() {

        if(count($this->explode) > 2) {
            $uri = end($this->explode);
            $ac = (!isset($uri) || $uri == NULL) ? $this->actionDafault : $uri;
        } else {
            $ac = (!isset($this->explode[1]) || $this->explode[1] == NULL) ? $this->actionDafault : $this->explode[1];
        }

        $this->actions = $ac;
    }

    private function setParams() {
        $request = $_SERVER['REQUEST_URI'];
        $query = parse_url($request, PHP_URL_QUERY);
        parse_str($query, $this->params);
    }

    # start session
    public function session_init () {
        if (session_id() == '') {
            session_name(SESSION_ID);
            session_start();
        }
    }

    public function verify_session () {
        $this->session_init();
        return isset($_SESSION['user']);
    }

}