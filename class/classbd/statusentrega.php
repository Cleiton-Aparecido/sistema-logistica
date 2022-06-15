<?php

class statusentrega{
    private $idstatusentrega;
    private $descstatusentrega;
    private $sql = array();

    public function __construct()
    {
        $this->sql = new sql();
    }

    public function getidstatusentrega(){
        return $this->idstatusentrega;
    }
    public function setidstatusentrega($value){
        $this->idstatusentrega = $value;
    }
    public function getdescstatusentrega(){
        return $this->descstatusentrega;
    }
    public function setdescstatusentrega($value){
        $this->iddescstatusentrega = $value;
    }

    public function listcstatusentrega(){
        $list = array();
        $resultado = $this->sql->select("SELECT descstatusentrega FROM statusentrega");
        foreach ($resultado as $row) {
            array_push($list,$row['descstatusentrega']);
        }

        return $list;
    }
    public function Searchcstatusentrega($cstatusentrega){
        $resultado = $this->sql->select("SELECT * FROM statusentrega
        where descstatusentrega= '".$cstatusentrega."'");
        $x = $resultado[0]['idstatusentrega'];
        return $x;
    }
    public function searchcstatusentregaid($id){
        $resultado = $this->sql->select("SELECT * FROM statusentrega
        where idstatusentrega = ".$id."");
        if(!isset($resultado[0]['descstatusentrega'])){
            $resultado = 'Sem inf';
        }
        else{
            $resultado = $resultado[0]['descstatusentrega'];
        }
        return $resultado;
    }
}

?>