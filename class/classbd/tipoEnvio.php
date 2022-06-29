<?php

class tipoEnvio{
    private $idtipoEnvio;
    private $desctipoEnvio;
    private $status;
    private $sql = array();

    public function __construct()
    {
        $this->sql = new sql();
    }

    public function getidtipoEnvio(){
        return $this->idtipoEnvio;
    }
    public function setidtipoEnvio($value){
        $this->idtipoEnvio = $value;
    }
    public function getdesctipoEnvio(){
        return $this->desctipoEnvio;
    }
    public function setdesctipoEnvio($value){
        $this->iddesctipoEnvio = $value;
    }
    public function getstatus(){
        return $this->status;
    }
    public function setstatus($value){
        $this->idstatus = $value;
    }



    public function listctipoenvio(){
        $list = array();
        $resultado = $this->sql->select("SELECT desctipoEnvio FROM tipoenvio");
        foreach ($resultado as $row) {
            array_push($list,$row['desctipoEnvio']);
        }

        return $list;
    }
    public function Searchctipoenvio($ctipoenvio){
        $resultado = $this->sql->select("SELECT * FROM tipoenvio
        where desctipoEnvio= '".$ctipoenvio."'");
        $x = $resultado[0]['idtipoEnvio'];
        return $x;
    }
    public function searchctipoenvioid($id){
        $resultado = $this->sql->select("SELECT * FROM tipoenvio
        where idtipoEnvio = ".$id."");
        if(!isset($resultado[0]['desctipoEnvio'])){
            $resultado = 'Sem inf';
        }
        else{
            $resultado = $resultado[0]['desctipoEnvio'];
        }
        return $resultado;
    }
}

?>