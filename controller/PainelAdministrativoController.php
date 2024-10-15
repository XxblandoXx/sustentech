<?php


class painelAdministrativoController extends Controller {

    public function index() {
        $this->check_permission();
        
        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'administrativo.php');
        require(PATH_VIEW . '_includes/menubar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }

    public function conta() {
        $this->check_permission();

        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'perfil.php');
        require(PATH_VIEW . '_includes/menubar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }

    public function empresas() {
        $this->check_permission();

        require(PATH_VIEW . '_includes/header.php');

        $empresa = self::load_model('Empresa');
        $usuario = self::load_model('Usuario');

        $empresa->setUsuario($usuario->getID());

        require(PATH_VIEW . 'empresas.php');
        require(PATH_VIEW . '_includes/menubar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }

}