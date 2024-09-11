<?php


class PainelAdministrativoController extends Controller {

    public function index() {
        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'administrativo.php');
        require(PATH_VIEW . '_includes/menubar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }

    public function conta() {
        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'perfil.php');
        require(PATH_VIEW . '_includes/menubar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }

    public function empresas() {
        $modelo = self::load_model('Empresa');
        $usuario = self::load_model('Usuario');

        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'empresas.php');
        require(PATH_VIEW . '_includes/menubar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }

}