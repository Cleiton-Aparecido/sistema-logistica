<?php

class setor{
    private $idsetor;
    private $dessetor;
    private $sql = array();

    public function __construct()
    {
        $this->sql = new sql();
    }

    public function getidsetor(){
        return $this->idsetor;
    }
    public function setidsetor($value){
        $this->idsetor = $value;
    }
    public function getdessetor(){
        return $this->dessetor;
    }
    public function setdessetor($value){
        $this->iddessetor = $value;
    }
    public function listSectordesc(){
        $resultado = $this->sql->select("SELECT * FROM setor");
        $list = array();
        foreach ($resultado as $row) {
            array_push($list,$row['descsetor']);
        }

        return $list;
    }

    public function listSector(){
        $resultado = $this->sql->select("SELECT * FROM setor");
        return $resultado;
    }
    public function SearchSector($sector){
        $resultado = $this->sql->select("SELECT * FROM setor
        where descsetor= '".$sector."'");
        $x = $resultado[0]['idsetor'];
        return $x;
    }
    public function searchsectorid($id){
        $resultado = $this->sql->select("SELECT * FROM setor
        where idsetor = ".$id."");
        if(!isset($resultado[0]['descsetor'])){
            $resultado = 'Sem Setor';
        }
        else{
            $resultado = $resultado[0]['descsetor'];
        }
        return $resultado;
    }
}

?>