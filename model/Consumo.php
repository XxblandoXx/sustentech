<?php


require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Consumo extends Model {

    private $id;
    private $valor;
    private $custo;
    private $referencia;
    private $reuso;
    private $empresa;
    private $created;
    private $updated;
    private $file;

    protected $tabela = 'consumo';


    public function getID() {
        return $this->id;
    }

    public function setID($id) {
        $this->id = $id;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function getCusto() {
        return $this->custo;
    }

    public function setCusto($custo) {
        $this->custo = $custo;
    }

    public function getReferencia() {
        return $this->referencia;
    }

    public function setReferencia($referencia) {
        $this->referencia = $referencia;
    }

    public function getReuso() {
        return $this->reuso;
    }

    public function setReuso($reuso) {
        $this->reuso = $reuso;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function getUpdated() {
        return $this->updated;
    }

    public function setUpdated($updated) {
        $this->updated = $updated;
    }

    public function getFile() {
        return $this->file;
    }

    public function setFile($file) {
        $this->file = $file;
    }

    public function getAllConsumption($company) {
        return $this->read("SELECT * FROM $this->tabela WHERE empresa = '$company' AND is_deleted = 0 ORDER BY referencia");
    }

    public function CreateConsumption() {

        $response = [];

        if ($this->file) {
            $identify = IOFactory::identify($this->file['tmp_name']);
            $reader   = IOFactory::createReader($identify);
            $reader->setReadDataOnly(false);

            $spreadsheet = $reader->load($this->file['tmp_name']);
            $sheet = $spreadsheet->getActiveSheet();

            foreach($sheet->getRowIterator() as $i => $row) {
                if ($i == 1) continue;

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                foreach ($cellIterator as $j => $cell) {
                    if (! $cell->getValue()) continue;

                    $value = trim(strip_tags($cell->getValue()));

                    if ($j == 'A') {
                        $value = (int)$value;
                        $timestamp = ($value - 25569) * 86400;
                        $this->referencia = date('Y-m-d', $timestamp);
                    }

                    if ($j == 'B') {
                        $this->valor = $value;
                    }

                    if ($j == 'C') {
                        $this->reuso = $value;
                    }

                    if ($j == 'D') {
                        $this->custo = number_format($value, 2, ',', '.');
                    }
                }


                $query = $this->read("SELECT * FROM $this->tabela WHERE MONTH(referencia) = MONTH('$this->referencia') AND empresa = $this->empresa");

                if (! $query) {
                    $sql = "INSERT INTO $this->tabela(valor, custo, referencia, reuso, empresa) VALUE (:valor, :custo, :referencia, :reuso, :empresa)";

                    $response[] = $this->create($sql, [
                        ':valor' => $this->valor,
                        ':custo' => $this->custo,
                        ':referencia' => $this->referencia,
                        ':reuso' => $this->reuso,
                        ':empresa' => $this->empresa
                    ]);
                }
                else {
                    $response[] = 2;
                }
            }

        }
        else {
            $query = $this->read("SELECT * FROM $this->tabela WHERE MONTH(referencia) = MONTH('$this->referencia') AND empresa = $this->empresa");
            if (! $query) {
                $sql = "INSERT INTO $this->tabela(valor, custo, referencia, reuso, empresa) VALUE (:valor, :custo, :referencia, :reuso, :empresa)";

                $response[] = $this->create($sql, [
                    ':valor' => $this->valor,
                    ':custo' => $this->custo,
                    ':referencia' => $this->referencia,
                    ':reuso' => $this->reuso,
                    ':empresa' => $this->empresa
                ]);
            }
            else {
                $response[] = 3;
            }
        }


        if (in_array(2, $response)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Cadastro concluído mas os meses duplicados foram ignorados',
                'response' => $response
            ]);
        }
        else if (in_array(3, $response)) {
            echo json_encode([
                'status' => 'warning',
                'message' => 'Tentativa de cadastro de mês já existente bloqueado, atualize o consumo do mês referente',
                'response' => $response
            ]);
        }
        else if (! in_array(0, $response)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Ação concluída com sucesso',
                'response' => $response
            ]);
        }
        else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Falha ao tentar processar cadastro',
                'response' => $response
            ]);
        }

        die();
    }

    public function UpdateConsumption() {
        $sql = "UPDATE $this->tabela SET valor = :valor, custo = :custo, referencia = :referencia, reuso = :reuso, updated = CURRENT_TIMESTAMP() WHERE id = :id";

        $response = $this->update($sql, [
            ':id' => $this->id,
            ':valor' => $this->valor,
            ':custo' => $this->custo,
            ':referencia' => $this->referencia,
            ':reuso' => $this->reuso,
        ]);

        if ($response) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Consumo atualizado com sucesso',
                'response' => $response
            ]);
        }
        else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Falha ao tentar atualizar dados de consumo',
                'response' => $response
            ]);
        }

        die;
    }

    public function DeleteConsumption() {
        $response = $this->update("UPDATE $this->tabela SET updated = CURRENT_TIMESTAMP(), is_deleted = 1 WHERE id = :id", [
            ':id' => $this->id
        ]);

        if ($response) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Consumo removido com sucesso',
                'response' => $response
            ]);
        }
        else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Falha ao tentar apagar dados de consumo',
                'response' => $response
            ]);
        }

        die;
    }

    public function TotalReuseCompany($company) {
        $response = $this->read("SELECT SUM(reuso) AS total FROM $this->tabela WHERE empresa = $company and is_deleted = 0", true);
        return $response['total'];
    }

    public function getProjections($company) {
        $valor_litro = 0;
        $valor_reuso = 0;
        $valor_consumo = 0;

        $query = $this->read(
           "SELECT valor AS consumo, custo, reuso
              FROM $this->tabela
             WHERE empresa = $company and is_deleted = 0"
        );


        $query_empresa = $this->read(
           "SELECT custo_manutencao, periodo_manutencao
              FROM empresa
             WHERE id = $company and is_deleted = 0",
        true);

        $total = count($query);

        foreach ($query as $res) {
            $valor_litro += (float)$res['reuso'] / (float)$res['custo'];
            $valor_reuso += $res['reuso'];
            $valor_consumo += $res['consumo'];
        }

        $media_litro = round($valor_litro) / $total;
        $media_reuso = $valor_reuso / $total;
        $media_consumo = $valor_consumo / $total;

        $periods = [3, 6, 12];

        $chart[] = ["0", 0, 0, 0, 0];

        foreach ($periods as $period) {
            if ($query_empresa['periodo_manutencao'] == 'Mensal') {
                $manutencao = (float)$query_empresa['custo_manutencao'] * $period;
            }
            elseif ($query_empresa['periodo_manutencao'] == 'Semestral') {
                $manutencao = (float)$query_empresa['custo_manutencao'] * floor($period / 6);
            }
            else {
                $manutencao = (float)$query_empresa['custo_manutencao'] * floor($period / 12);
            }

            $chart[] = [
                $period . ' meses', 
                $media_reuso * $period, 
                $media_consumo * $period,
                $manutencao,
                round(($media_litro * $media_consumo) * $period) - $manutencao
            ];
        }

        return json_encode($chart);
    }
}