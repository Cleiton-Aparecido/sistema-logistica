<?php

class encomenda{
    private $idencomenda;
    private $descencomenda;
    private $status;
    private $listaGEralEncomenda;

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
        $this->descencomenda = $value;
    }

    public function getlistaGEralEncomenda(){
        return $this->listaGEralEncomenda;
    }
    public function setlistaGEralEncomenda($value){
        $this->listaGEralEncomenda = $value;
    }
    // listar todas opções de encomenda
    private function SelectGeral(){
        $resultado = $this->sql->select("SELECT desctipoencomenda FROM tipoencomenda");
        $list = array();
        if (count($resultado)>0) {
            foreach ($resultado as $row) {
                array_push($list,$row['desctipoencomenda']);
            }
        }
        $this->setlistaGEralEncomenda($list);
    }
    // retornar lista de opções de encomendas
    public function listcencomenda(){
        $this->SelectGeral();
        return $this->getlistaGEralEncomenda();
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