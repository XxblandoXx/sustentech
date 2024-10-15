<?php 


class contaController extends Controller {

    public function index() {
        $modelo = self::load_model('Usuario');

        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . '_includes/footer.php');
    }

    public function registre_se() {
        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'cadastrar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }

    public function redefinir_senha() {
        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'redefinir.php');
        require(PATH_VIEW . '_includes/footer.php');
    }

    public function conectar() {
        $modelo = $this->load_model('Usuario');

        $modelo->setEmail(filter_input(INPUT_POST, 'username'));
        $modelo->setSenha(filter_input(INPUT_POST, 'password'));

        $modelo->Conectar();
    }

    public function cadastrar() {
        $modelo = self::load_model('Usuario');

        $modelo->setNome(filter_input(INPUT_POST, 'username'));
        $modelo->setEmail(filter_input(INPUT_POST, 'usermail'));
        $modelo->setSenha(filter_input(INPUT_POST, 'password'));

        $modelo->CadastrarUsuario();
    }

    public function cadastrar_empresa() {
        $usuario = self::load_model('Usuario');
        $modelo = self::load_model('Empresa');

        $modelo->setNome( filter_input(INPUT_POST, 'company-name') );
        $modelo->setSegmento( filter_input(INPUT_POST, 'company-segment') );
        $modelo->setCustoManutencao( filter_input(INPUT_POST, 'company-maintenance-cost') );
        $modelo->setPeriodoManutencao( filter_input(INPUT_POST, 'company-maintenance-period') );
        $modelo->setTipoReuso( filter_input(INPUT_POST, 'company-reuse') );
        $modelo->setOrigem( filter_input(INPUT_POST, 'company-water-origin') );
        $modelo->setTratamento( filter_input(INPUT_POST, 'company-processing') );
        $modelo->setEscoamento( filter_input(INPUT_POST, 'company-escoamento') );
        $modelo->setUsuario( $usuario->getID() );
        
        $modelo->CadastrarEmpresa();
    }

    public function editar() {
        $modelo = self::load_model('Usuario');

        $modelo->setNome(filter_input(INPUT_POST, 'username'));
        $modelo->setEmail(filter_input(INPUT_POST, 'usermail'));
        $modelo->setSenha(filter_input(INPUT_POST, 'password'));

        $modelo->AtualizarUsuario();
    }

    public function editar_empresa() {
        $usuario = self::load_model('Usuario');
        $modelo = self::load_model('Empresa');

        $modelo->setID( filter_input(INPUT_POST, 'company-id') );
        $modelo->setNome( filter_input(INPUT_POST, 'company-name') );
        $modelo->setSegmento( filter_input(INPUT_POST, 'company-segment') );
        $modelo->setCustoManutencao( filter_input(INPUT_POST, 'company-maintenance-cost') );
        $modelo->setPeriodoManutencao( filter_input(INPUT_POST, 'company-maintenance-period') );
        $modelo->setTipoReuso( filter_input(INPUT_POST, 'company-reuse') );
        $modelo->setOrigem( filter_input(INPUT_POST, 'company-water-origin') );
        $modelo->setTratamento( filter_input(INPUT_POST, 'company-processing') );
        $modelo->setEscoamento( filter_input(INPUT_POST, 'company-escoamento') );
        $modelo->setUsuario( $usuario->getID() );
        
        $modelo->AtualizarEmpresa();
    }

    public function deletar_empresa() {
        $modelo = self::load_model('Empresa');

        $modelo->setID( filter_input(INPUT_POST, 'delete-company-id') );
        
        $modelo->DeletarEmpresa();
    }

    public function redefinir() {
        $modelo = self::load_model('Usuario');
        $modelo->VerifyEmailRegister( filter_input(INPUT_POST, 'usermail') );
    }

    public function logout() {
        $usuario = $this->load_model('Usuario');
        $usuario->Desconectar();
    }

}