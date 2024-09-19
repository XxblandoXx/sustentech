<?php


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

}