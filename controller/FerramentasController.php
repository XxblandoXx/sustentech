<?php


class FerramentasController extends Controller {

    public function index() {
        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'ferramentas.php');
        require(PATH_VIEW . '_includes/menubar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }

    public function monitoramento() {
        require(PATH_VIEW . '_includes/header.php');
        
        $empresa = self::load_model('Empresa');
        $usuario = self::load_model('Usuario');

        $empresa->setUsuario($usuario->getID());

        require(PATH_VIEW . 'monitoramento.php');
        require(PATH_VIEW . '_includes/menubar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }
    
}