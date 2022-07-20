<?php

class tipoEnvio{
    private $idtipoEnvio;
    private $desctipoEnvio;
    private $status;
    private $listageral = array();
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
        $this->desctipoEnvio = $value;
    }
    public function setstatus($value){
        $this->status = $value;
    }
    public function getstatus(){
        return $this->status;
    }
    public function setlistageral($value){
        $this->listageral = $value;
    }
    public function getlistageral(){
        return $this->listageral;
    }
   
    private function listaGeralEnvio(){
        $list = array();
        $resultado = $this->sql->select("SELECT * FROM tipoenvio
        INNER JOIN statusativacao ON  statusativacao.idStatusAtivacao=tipoenvio.statusAtivo;");
        foreach ($resultado as $row) {
            array_push($list,array("id"=> $row['idtipoEnvio'],
                                    "nome"=> $row['desctipoEnvio'],
                                    "status"=> $row['descStatus']));
        }
        $this->setlistageral($list);
    }
    private function searchtipoenvio($tipoenvio){
        $comando = "SELECT * FROM tipoenvio
        INNER JOIN statusativacao ON  statusativacao.idStatusAtivacao=tipoenvio.statusAtivo
        where desctipoEnvio = '$tipoenvio'";

        $resultado = $this->sql->select($comando);

        if(count($resultado)>0){
            
            $row = $resultado[0];
            $this->setidtipoEnvio($row['idtipoEnvio']);
            $this->setdesctipoEnvio($row['desctipoEnvio']);
            $this->setstatus($row['descStatus']);
        }
       
    }

    public function alterarStatus($transporte,$status){
        $comando = "UPDATE tipoenvio SET statusAtivo =  (SELECT idStatusAtivacao FROM statusativacao WHERE descStatus = '$status')  WHERE desctipoEnvio = '$transporte';";
        $this->sql->query($comando);
    }
    public function listctipoenvio(){
        $list = array();
       $this->listaGeralEnvio();
        foreach ($this->getlistageral() as $row) {
            array_push($list,$row['nome']);
        }
        return $list;
    }
    public function listctipoenvioAtivo(){
        $list = array();
       $this->listaGeralEnvio();
        foreach ($this->getlistageral() as $row) {
            if($row['status'] == 'Ativo'){
                array_push($list,$row['nome']);
            }
        }
        return $list;
    }

    public function listaltipoenvio(){
        $this->listaGeralEnvio();
        return $this->getlistageral();
    }

    public function statustipoenvio($tipoenvio){
        $this->searchtipoenvio($tipoenvio);
        return $this->getstatus();
    }

    public function verificarTransporteExiste($tipoenvio){

        $this->searchtipoenvio($tipoenvio);

        if ($this->getdesctipoEnvio() == "") {
            return false;
        }
        else{
            return true;

         }
        
    }
    public function inserirNovoTipoEnvio($tipoenvio){
        $comando = "INSERT INTO tipoenvio (desctipoEnvio,statusAtivo)
        VALUES ('$tipoenvio', (SELECT idStatusAtivacao FROM statusativacao WHERE descStatus = 'Ativo'))";
        $this->sql->query($comando);
    }
    
   
}
