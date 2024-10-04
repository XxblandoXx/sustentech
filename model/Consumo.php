<?php


require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Consumo extends Model {

    private $id;
    private $valor;
    private $referencia;
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

    public function getReferencia() {
        return $this->referencia;
    }

    public function setReferencia($referencia) {
        $this->referencia = $referencia;
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
            $identify = \PhpOffice\PhpSpreadsheet\IOFactory::identify($this->file['tmp_name']);
            $reader   = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($identify);

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
                        $this->valor = $value;
                    }

                    if ($j == 'B') {
                        $value = (int)$value;
                        $timestamp = ($value - 25569) * 86400;
                        $this->referencia = date('Y-m-d', $timestamp);
                    }
                }

                $query = $this->read("SELECT * FROM $this->tabela WHERE valor = '$this->valor' AND referencia = '$this->referencia' AND empresa = '$this->company'");

                if (! $query) {
                    $sql = "INSERT INTO $this->tabela(valor, referencia, empresa) VALUE (:valor, :referencia, :empresa)";

                    $response[] = $this->create($sql, [
                        ':valor' => $this->valor,
                        ':referencia' => $this->referencia,
                        ':empresa' => $this->empresa
                    ]);
                }
                else {
                    $response[] = 1;
                }
            }

        }
        else {
            $sql = "INSERT INTO $this->tabela(valor, referencia, empresa) VALUE (:valor, :referencia, :empresa)";

            $response[] = $this->create($sql, [
                ':valor' => $this->valor,
                ':referencia' => $this->referencia,
                ':empresa' => $this->empresa
            ]);
        }


        if (! in_array(0, $response)) {
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

        die;
    }

    public function UpdateConsumption() {
        $sql = "UPDATE $this->tabela SET referencia = :referencia, valor = :valor, updated = CURRENT_TIMESTAMP() WHERE id = :id";

        $response = $this->update($sql, [
            ':id' => $this->id,
            ':referencia' => $this->referencia,
            ':valor' => $this->valor
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
        $response = $this->update("UPDATE $this->tabela SET is_deleted = 1 WHERE id = :id", [
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
}