<?php


class ferramentasController extends Controller {

    public function index()
    {
        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'ferramentas.php');
        require(PATH_VIEW . '_includes/menubar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }

    public function monitoramento()
    {
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

    public function save_consumption()
    {
        $consumo = self::load_model('Consumo');

        if (isset($_FILES['new-line-file'])) $consumo->setFile($_FILES['new-line-file'] ?: '');
        $consumo->setEmpresa(filter_input(INPUT_POST, 'new-line-company'));
        $consumo->setValor(filter_input(INPUT_POST, 'new-line-value'));
        $consumo->setCusto(filter_input(INPUT_POST, 'new-line-cost'));
        $consumo->setReuso(filter_input(INPUT_POST, 'new-line-reuse'));
        $consumo->setReferencia(filter_input(INPUT_POST, 'new-line-reference'));

        $consumo->CreateConsumption();
    }

    public function delete_consumption()
    {
        $consumo = self::load_model('Consumo');
        $consumo->setID( filter_input(INPUT_POST, 'delete-consumption-id') );
        $consumo->DeleteConsumption();
    }

    public function update_consumption()
    {
        $consumo = self::load_model('Consumo');
        $consumo->setID(filter_input(INPUT_POST, 'edit-consumption-id'));
        $consumo->setCusto(filter_input(INPUT_POST, 'edit-line-cost'));
        $consumo->setValor(filter_input(INPUT_POST, 'edit-line-value'));
        $consumo->setReuso(filter_input(INPUT_POST, 'edit-line-reuse'));
        $consumo->setReferencia(filter_input(INPUT_POST, 'edit-line-reference'));
        $consumo->UpdateConsumption();
    }
    
}