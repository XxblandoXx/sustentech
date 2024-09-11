<?php


class Usuario extends Model {

    private $id;
    private $nome;
    private $email;
    private $senha;

    protected $tabela = 'usuario';

    // function __construct() {}

    // function __construct() {
    //     $site = new System();
    //     $site->session_init();

    //     if ($site->verify_session()) {
    //         $this->id = $_SESSION['user']['id'];
    //         $this->nome = $_SESSION['user']['nome'];
    //         $this->email = $_SESSION['user']['email'];
    //     }

    // }

    function getID() {
        return $this->id;
    }

    public function setID($id) {
        $this->id = $id;
    }

    function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = md5($senha);
    }

    function CadastrarUsuario() {

        $query = $this->read("SELECT * FROM usuario WHERE email = '$this->email' and senha = '$this->senha'", true);

        if (! $query) {
            $sql = "INSERT INTO usuario(nome, email, senha) VALUE (:nome, :email, :senha)";

            $response = $this->create($sql, [
                ':nome' => $this->nome,
                ':email' => $this->email,
                ':senha' => $this->senha
            ]);

            if ($response) {
                $site = new System();
                $site->session_init();

                $_SESSION['user'] = [
                    'id' => $this->id,
                    'nome' => $this->nome,
                    'email' => $this->email,
                ];

                header('Location: ../painel-informativo');
            }
            else {
                header('Location: ../?error=nocreate');
            }
        }
        else {
            header('Location: ../?error=duplicate');
        }
    }

    function AtualizarUsuario() {

        if (! empty($this->senha)) {
            $sql = "UPDATE $this->tabela SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
        }
        else {
            $sql = "UPDATE $this->tabela SET nome = :nome, email = :email WHERE id = :id";
        }

        $response = $this->update($sql, [
            ':id' => $this->id, 
            ':nome' => $this->nome, 
            ':email' => $this->email, 
            ':senha' => $this->senha
        ]);

        if ($response) {
            $site = new System();
            $site->session_init();

            $_SESSION['user'] = [
                'id' => $this->id,
                'nome' => $this->nome,
                'email' => $this->email,
            ];

            header('Location: ../painel-administrativo/conta?update=success');
        }
        else {
            header('Location: ../painel-administrativo/conta?update=failed');
        }

    }

    public function Conectar() {

        $query = $this->read("SELECT * FROM $this->tabela WHERE email = '$this->email' AND senha = '$this->senha'", true);

        if ($query) {
            $site = new System();
            $site->session_init();
            
            $_SESSION['user'] = [
                'id' => $query['id'],
                'nome' => $query['nome'],
                'email' => $query['email'],
            ];
            header('Location: ../painel-informativo');
        }
        else {
            header('Location: ../?error=failed');
        }

    }

    public function Desconectar() {

        $site = new System();
        $site->session_init();

        unset($_SESSION['user']);
        session_destroy();

        header('Location: ../');

    }

}