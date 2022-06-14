<?php

class datacorreio{
    private $iddatacorreio;
    private $descdata;

    public function getiddatacorreio(){
        return $this->iddatacorreio;
    }

    public function setiddatacorreio($value){
        $this->iddatacorreio = $value;
    }
    public function getdescdata(){
        return $this->descdata;
    }
    public function setdescdata($value){
        $this->descdata = $value;
    }
    

    public function insertdatecolumn($data){
        $sql = new sql();

        $resultado = $sql->select("INSERT INTO datacorreio (descdata) VALUES ('".$data."')");
        return 'data inserida';
    }

    public function ConsultDateColumn($data){
        $sql = new sql();

        $resultado = $sql->select("SELECT * from datacorreio
        WHERE descdata = '".$data."'");
        return $resultado;
    }
    
 

}

?>