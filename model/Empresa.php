<?php


class Empresa extends Model {

    private $id;
    private $nome;
    private $segmento;
    private $custo_manutencao;
    private $periodo_manutencao;
    private $tipo_reuso;
    private $origem;
    private $tratamento;
    private $escoamento;
    private $usuario;

    protected $tabela = 'empresa';


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

    public function getSegmento() {
        return $this->segmento;
    }

    public function setSegmento($segmento) {
        $this->segmento = $segmento;
    }

    public function getCustoManutencao() {
        return $this->custo_manutencao;
    }

    public function setCustoManutencao($custo_manutencao) {
        $this->custo_manutencao = $custo_manutencao;
    }

    public function getPeriodoManutencao() {
        return $this->periodo_manutencao;
    }

    public function setPeriodoManutencao($periodo_manutencao) {
        $this->periodo_manutencao = $periodo_manutencao;
    }

    public function getTipoReuso() {
        return $this->tipo_reuso;
    }

    public function setTipoReuso($tipo_reuso) {
        $this->tipo_reuso = $tipo_reuso;
    }

    public function getOrigem() {
        return $this->origem;
    }

    public function setOrigem($origem) {
        $this->origem = $origem;
    }

    public function getTratamento() {
        return $this->tratamento;
    }

    public function setTratamento($tratamento) {
        $this->tratamento = $tratamento;
    }

    public function getEscoamento() {
        return $this->escoamento;
    }

    public function setEscoamento($escoamento) {
        $this->escoamento = $escoamento;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }


    function CadastrarEmpresa() {
        $query = $this->read("SELECT * FROM $this->tabela WHERE nome LIKE '$this->nome' AND usuario = '$this->usuario'", true);

        if (! $query) {
            $sql = "INSERT INTO $this->tabela(nome, segmento, custo_manutencao, periodo_manutencao, tipo_reuso, origem, tratamento, escoamento, usuario) VALUE (:nome, :segmento, :custo_manutencao, :periodo_manutencao, :tipo_reuso, :origem, :tratamento, :escoamento, :usuario)";

            $response = $this->create($sql, [
                ':nome' => $this->nome,
                ':segmento' => $this->segmento,
                ':custo_manutencao' => $this->custo_manutencao,
                ':periodo_manutencao' => $this->periodo_manutencao,
                ':tipo_reuso' => $this->tipo_reuso,
                ':origem' => $this->origem,
                ':tratamento' => $this->tratamento,
                ':escoamento' => $this->escoamento,
                ':usuario' => $this->usuario,
            ]);

            if ($response) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Cadastro realizado com sucesso'
                ]);
                die;
            }
            else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Falha ao tentar cadastrar empresa'
                ]);
                die;
            }
        }
        else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Empresa já está cadastrada'
            ]);
            die;
        }
    }

    function AtualizarEmpresa() {        
        $sql = "UPDATE $this->tabela SET nome = :nome, segmento = :segmento, custo_manutencao = :custo_manutencao, periodo_manutencao = :periodo_manutencao, tipo_reuso = :tipo_reuso, origem = :origem, tratamento = :tratamento, escoamento = :escoamento WHERE id = :id";

        $response = $this->update($sql, [
            ':id' => $this->id, 
            ':nome' => $this->nome,
            ':segmento' => $this->segmento,
            ':custo_manutencao' => $this->custo_manutencao,
            ':periodo_manutencao' => $this->periodo_manutencao,
            ':tipo_reuso' => $this->tipo_reuso,
            ':origem' => $this->origem,
            ':tratamento' => $this->tratamento,
            ':escoamento' => $this->escoamento,
        ]);

        if ($response) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Atualização concluída com sucesso',
                'response' => $response
            ]);
        }
        else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Falha ao tentar atualizar dados da empresa',
                'response' => $response
            ]);
        }

        die;
    }

    function ListarEmpresas() {
        return $this->read("SELECT * FROM $this->tabela WHERE usuario = '$this->usuario'");
    }
}