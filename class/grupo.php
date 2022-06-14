<?php

class grupo{
    private $idgrupo;
    private $idsetor;
    private $datacoleta;
    private $idstatusentrega;
    private $dataentregasetor;
    private $objectSector = array();
    private $sql = array();

    public function __construct()
    {
        $this->objectSector = new setor();
        $this->sql = new sql();
    }
    public function getidgrupo(){
        return $this->idgrupo;
    }

    public function setidgrupo($value){
        $this->idgrupo = $value;
    }
    public function getidsetor(){
        return $this->idsetor;
    }
    public function setidsetor($value){
        $this->idsetor = $value;
    }
    public function setdatacoleta($value){
        $this->datacoleta = $value;
    }
    public function getdatacoleta(){
        return $this->datacoleta;
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
    
    public function listQueryGroup($idgruop){
                $resultado = $this->sql->select("SELECT * FROM grupo
                INNER join statusentrega ON grupo.idstatusentrega=statusentrega.idstatusentrega
                INNER JOIN setor ON grupo.idsetor=setor.idsetor
                WHERE idgrupo = ".$idgruop."");

        return $resultado;
    }
    public function searchstatusid($id){
        $resultado = $this->sql->select("SELECT * FROM statusentrega
        where idstatusentrega = ".$id."");
        $resultado = $resultado[0]['descstatusentrega'];
        return $resultado;
    }
    #comando para inserir na tabela de grupo, um individuo pendente
    private function insertgroup($sector,$datecollect){
        $this->sql->query("INSERT INTO grupo (idsetor,datacoleta,idstatusentrega) 
        VALUES (".$sector.",'".$datecollect."',2);");
    }
    private function searchID($sector,$datecollect){

        $resultado = $this->sql->select("SELECT * FROM grupo
        WHERE idsetor = ".$sector."
        AND datacoleta = '".$datecollect."'");
       
        return $resultado;
    }

    public function sectorAndDateSearchid($sector,$datecollect){
        $sector =  $this->objectSector->SearchSector($sector);
        $resultado = $this->searchID($sector,$datecollect);
        if(!isset($resultado[0]['idgrupo'])){
            echo 'não achou o idgrupo';
            $this->insertgroup($sector,$datecollect);
            $resultado = $this->searchID($sector,$datecollect);
        }
        $resultado = $resultado[0]['idgrupo'];

        return $resultado;
    }
    public function idgroupPending(){
        $list = array();
        $resultado = $this->sql->select("SELECT idgrupo FROM grupo
        INNER JOIN statusentrega ON grupo.idstatusentrega = statusentrega.idstatusentrega
        WHERE statusentrega.descstatusentrega = 'Pendente'
        or  statusentrega.descstatusentrega = 'Negado'");
        foreach ($resultado as $row) {
            array_push($list,$row['idgrupo']);
        }
        return $list;

   
    }
    public function listStatus(){
        $resultado = $this->sql->select("SELECT * FROM statusentrega");
        return $resultado;
    }
    public function queryidstatus($nameStatus){
        $resultado = $this->sql->select("SELECT * FROM statusentrega
        where descstatusentrega = '".$nameStatus."'");
        $resultado = $resultado[0]['idstatusentrega'];
        return $resultado;
    }
    public function Savestatus($dataentrega,$idgroup,$status){
        $status = $this->queryidstatus($status);
        echo $status."<br>";
        echo $dataentrega;
        $this->sql->query("UPDATE grupo 
        SET idstatusentrega = ".$status.", dataentregasetor = '".$dataentrega."'
        WHERE idgrupo = ".$idgroup."");   
    }
}
?>