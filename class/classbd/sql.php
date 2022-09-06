<?php


class Sql extends PDO {

    private $conn;

    public function __construct() {

        $this->conn = new PDO("mysql:dbname=lgreversa1;host=localhost","root","");

    }


    
    private function setParams($statment, $parameters = array()) {

        foreach ($parameters as $key => $value) {

            $this->setParam($statment,$key, $value);
        }

    }

    private function setParam($statment, $key, $value){

        $statment->bindParam($key, $value);

    }

    public function query($rawQuery, $params = array()) {

        $stmt = $this->conn->prepare($rawQuery);

        $this->setParams($stmt, $params);

        if ($stmt->execute()) {
            return $stmt;
        }else{
            http_response_code(500);
            return false;
        }
         


    }

    public function select($rawQuery, $params = array()) {

        $stmt = $this->query($rawQuery, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

}

?>