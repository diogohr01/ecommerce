<?php

namespace Hcode\DB;

use PDO;

class Sql extends PDO {

    private $conn;

    public function __construct() {
        // Chame o construtor da classe pai (PDO) passando os parâmetros de conexão
        parent::__construct("mysql:host=localhost;dbname=db_ecommerce", "root", "");
        // Atribua a conexão à propriedade $conn
        $this->conn = $this;
    }

    private function setParams($statement, $parameters = array()) {
        foreach ($parameters as $key => $value) {
            $this->setParam($statement, $key, $value);
        }
    }

    private function setParam($statement, $key, $value){
        $statement->bindParam($key, $value);
    }

    public function PDO($rawQuery, $params = array()) {
        $stmt = $this->conn->prepare($rawQuery);
        $this->setParams($stmt, $params);
        $stmt->execute();
        return $stmt;
    }

    public function select($rawQuery, $params = array()): array {
        $stmt = $this->PDO($rawQuery, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


