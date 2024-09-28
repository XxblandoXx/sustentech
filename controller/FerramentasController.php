<?php


class FerramentasController extends Controller {

    public function index() {
        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'ferramentas.php');
        require(PATH_VIEW . '_includes/menubar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }

    public function monitoramento() {
        $this->check_permission();

        require(PATH_VIEW . '_includes/header.php');
        $empresa = self::load_model('Empresa');
        $usuario = self::load_model('Usuario');
        $consumo = self::load_model('Consumo');

        $empresa->setUsuario($usuario->getID());

        require(PATH_VIEW . 'monitoramento.php');
        require(PATH_VIEW . '_includes/menubar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }

    public function save_consumption() {
        $consumo = self::load_model('Consumo');

        $consumo->setFile( $_FILES['file'] );
        $consumo->setValor( filter_input(INPUT_POST, 'value') );
        $consumo->setReferencia( filter_input(INPUT_POST, 'reference') );
        $consumo->setEmpresa( filter_input(INPUT_POST, 'company') );
        $consumo->CreateConsumption();
    }
    
}