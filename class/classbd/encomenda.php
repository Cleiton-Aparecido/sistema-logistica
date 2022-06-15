<?php

class encomenda{
    private $idencomenda;
    private $descencomenda;
    private $sql = array();

    public function __construct()
    {
        $this->sql = new sql();
    }

    public function getidencomenda(){
        return $this->idencomenda;
    }
    public function setidencomenda($value){
        $this->idencomenda = $value;
    }
    public function getdescencomenda(){
        return $this->descencomenda;
    }
    public function setdescencomenda($value){
        $this->iddescencomenda = $value;
    }

    public function listcencomenda(){
        $list = array();
        $resultado = $this->sql->select("SELECT desctipoencomenda FROM tipoencomenda");
        foreach ($resultado as $row) {
            array_push($list,$row['desctipoencomenda']);
        }

        return $list;
    }
    public function Searchcencomenda($cencomenda){
        $resultado = $this->sql->select("SELECT * FROM tipoencomenda
        where desctipoencomenda= '".$cencomenda."'");
        $x = $resultado[0]['idtipoencomenda'];
        return $x;
    }
    public function searchcencomendaid($id){
        $resultado = $this->sql->select("SELECT * FROM tipoencomenda
        where idtipoencomenda = ".$id."");
        if(!isset($resultado[0]['desctipoencomenda'])){
            $resultado = 'Sem info';
        }
        else{
            $resultado = $resultado[0]['desctipoencomenda'];
        }
        return $resultado;
    }
}

?>