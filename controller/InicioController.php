<?php


class inicioController extends Controller {

    public function index() {
        $this->check_permission();

        $usuario = self::load_model('Usuario');
        $empresa = self::load_model('Empresa');
        $consumo = self::load_model('Consumo');

        $empresa->setUsuario($usuario->getID());

        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'inicio.php');
        require(PATH_VIEW . '_includes/menubar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }
    
}