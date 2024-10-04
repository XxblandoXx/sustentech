<?php


require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Model extends Database {

    private $db;

    public function __construct() {
        $this->db = self::getConn();
    }

    # create row in database
    public function create($sql, $array) {
        $result = $this->db->prepare($sql);
        $result->execute($array);
        return $result->rowCount();
    }

    # read one or more rows in database
    public function read($sql, $single = false) {
        $result = $this->db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        if ($single)
            return $result->fetch();
        
        return $result->fetchAll();
    }

    # update row in database
    public function update($sql, $array) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($array);
        return $stmt->rowCount();
    }

    # delete row in database
    public function delete($tabela, $name, $id) {
        $stmt = $this->db->prepare("DELETE FROM {$tabela} WHERE {$name} = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function send_mail($to, $subject, $body) {
        try {

            $phpmailer = new PHPMailer(true);

            $phpmailer->isSMTP();
            $phpmailer->isHTML(true);

            $phpmailer->CharSet = 'UTF-8';
            $phpmailer->Subject = $subject;
            $phpmailer->Body    = $body;

            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '06152ee1896fd4';
            $phpmailer->Password = '9e0eb6d460fe38';

            $phpmailer->setFrom('contato@sustentech.com.br', 'Sustentech');
            $phpmailer->addAddress($to);

            $phpmailer->send();

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Recebemos sua mensagem com sucesso!'
            ];

            return $response;

        } catch(Exception $e) {
            $response = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Houve um erro ao tentar enviar os dados.',
                'exception' => $e->getMessage()
            ];

            return $response;
        }
    }

    function password_generate($char) {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $char);
    }
}