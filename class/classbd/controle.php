<?php
require_once("config.php");

class controle{
    private $idcontrole;
    private $idsetor;
    private $iddatacoleta;
    private $idstatusentrega;
    private $dataentregasetor;
    private $usuario;

    public function getidcontrole(){
        return $this->idcontrole;
    }

    public function setidcontrole($value){
        $this->idcontrole = $value;
    }
    public function getidsetor(){
        return $this->idsetor;
    }
    public function setidsetor($value){
        $this->idsetor = $value;
    }
    public function getipcomputador(){
        return $this->ipcomputador;
    }

    public function setipcomputador($value){
        $this->ipcomputador = $value;
    }
    public function getiddatacoleta(){
        return $this->iddatacoleta;
    }

    public function setidstatusentrega($value){
        $this->idstatusentrega = $value;
    }
    public function getidstatusentrega(){
        return $this->idstatusentrega;
    }

    public function setdataentregasetor($value){
        $this->dataentregasetor = $value;
    }
    public function getdataentregasetor(){
        return $this->dataentregasetor;
    }

    public function setusuario($value){
        $this->usuario = $value;
    }
    public function getusuario(){
        return $this->usuario;
    }




    public function searchidcontrole($sector,$datecoleta){
        $sql = new sql();

        $resultado = $sql->select("SELECT idcontrole FROM controle
        INNER JOIN setor ON setor.idsetor = controle.idsetor
        INNER JOIN statusentrega ON statusentrega.idstatusentrega = controle.idstatusentrega
        INNER JOIN datacorreio ON datacorreio.iddatacorreio = controle.iddatacoleta 
        WHERE datacorreio.descdata ='".$datecoleta."' AND setor.descsetor = '".$sector."'");

        return $resultado;

    }
    public function searchcontrole($sector){
        $sql = new sql();

        $resultado = $sql->select("SELECT * FROM controle
        INNER JOIN setor ON setor.idsetor = controle.idsetor
        INNER JOIN statusentrega ON statusentrega.idstatusentrega = controle.idstatusentrega
        INNER JOIN datacorreio ON datacorreio.iddatacorreio = controle.iddatacoleta 
        WHERE setor.descsetor = '".$sector."' and controle.idstatusentrega = 1");

        return $resultado;

    }
    public function insertcontrole($idsector,$iddatecoleta,$idusuario){
        $sql = new sql();

        $resultado = $sql->select("INSERT INTO 
        `logisticareversa`.`controle` 
        (`idsetor`, `iddatacoleta`, `idstatusentrega`, `usuario`) 
        VALUES (".$idsector.",".$iddatecoleta.", 1, ".$idusuario.");");

        return $resultado;

    }
    
    
 

}

?>