<?php


class Usuario extends Model {

    private $id;
    private $nome;
    private $email;
    private $senha;

    protected $tabela = 'usuario';

    public function __construct() {
        parent::__construct();

        $site = new System();
        
        if ($site->verify_session()) {
            $this->id = $_SESSION['user']['id'];
            $this->nome = $_SESSION['user']['nome'];
            $this->email = $_SESSION['user']['email'];
        }
    }

    public function getID() {
        return $this->id;
    }

    public function setID($id) {
        $this->id = $id;
    }

    public function getNome() {
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

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = md5($senha);
    }

    public function CadastrarUsuario() {

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
            $sql = "UPDATE $this->tabela SET nome = :nome, email = :email, senha = :senha, updated = CURRENT_TIMESTAMP() WHERE id = :id";
        }
        else {
            $sql = "UPDATE $this->tabela SET nome = :nome, email = :email, updated = CURRENT_TIMESTAMP() WHERE id = :id";
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

    public function VerifyEmailRegister($email) {
        $query = $this->read("SELECT * FROM $this->tabela WHERE email = '$email'", true);

        if ($query) {
            $password = $this->password_generate(8);

            $body = '
                <table border="0" style="width: 700px; background: #45B583;">
                    <tr>
                        <td colspan="2" style="padding: 20px 10px; text-align: center; color: #ffffff; font-weight: bold">
                            REDEFINIR SENHA - SUSTENTECH
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 20px;">
                            <table border="0" style="width: 660px; background: #ffffff;">
                                <tr>
                                    <td colspan="2" style="padding: 20px;">
                                        <div style="margin: 5px 0px; text-align: center">Nova senha: <strong>'.$password.'</strong></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            ';

            $this->setSenha($password);

            $this->update("UPDATE $this->tabela SET senha = :senha WHERE id = :id", [
                ':id' => $query['id'], 
                ':senha' => $this->getSenha()
            ]);

            $this->send_mail($email, 'Redefinição de Senha', $body);
            header('Location: ' . BASE_URL . 'conta/redefinir-senha?success=1');
        }
        else {
            header('Location: ' . BASE_URL . 'conta/redefinir-senha?error=1');
        }
    }

    public function Conectar() {

        $query = $this->read("SELECT * FROM $this->tabela WHERE email = '$this->email' AND senha = '$this->senha' AND is_deleted = 0", true);

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