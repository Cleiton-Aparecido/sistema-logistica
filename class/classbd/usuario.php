<?php

class usuario{
    private $idusuario;
    private $nome;
    private $ipcomputador;
    private $ipnivel;
    private $setoruser;
    private $sql = array();

    public function __construct()
    {
        $this->sql = new sql();
    }
    public function getidusuario(){
        return $this->idusuario;
    }

    public function setidusuario($value){
        $this->idusuario = $value;
    }

    public function getnome(){
        return $this->nome;
    }
    public function setnome($value){
        $this->nome = $value;
    }

    public function getipcomputador(){
        return $this->ipcomputador;
    }
    public function setipcomputador($value){
        $this->ipcomputador = $value;
    }

    public function getipnivel(){
        return $this->ipnivel;
    }
    public function setipnivel($value){
        $this->ipnivel = $value;
    }

    public function getsetoruser(){
        return $this->setoruser;
    }
    public function setsetoruser($value){
        $this->setoruser = $value;
    }

    private function insertIpNew($ip){
        $this->sql->query("INSERT INTO usuario (nome,ipcomputador,nivel) 
        VALUES ('".$ip."','".$ip."',3);");
    }
    private function searchIp($ip){

        $resultado = $this->sql->select("SELECT * FROM usuario 
        WHERE ipcomputador = :ID",array(
            ":ID"=>$ip
        ));
        return $resultado;
    }
    
    public function loadByIdUsuario($id){
       
        $resultado = $this->searchIp($id);
        // var_dump($resultado);
        if(count($resultado)>0){
            $row = $resultado[0];
            $this->setidusuario($row['idusuario']);
            $this->setnome( $row['nome']);
            $this->setipcomputador( $row['ipcomputador']);
            $this->setipnivel($row['nivel']);
            $this->setsetoruser($row['idsetor']);
        }
        else{
            $this->insertIpNew($id);
            $resultado = $this->searchIp($id);
            $row = $resultado[0];
            $this->setidusuario($row['idusuario']);
            $this->setnome( $row['nome']);
            $this->setipcomputador( $row['ipcomputador']);
            $this->setipnivel($row['nivel']);
            $this->setsetoruser($row['idsetor']);
        }
        
        return array(
            "idusuario"=>$this->getidusuario(),
            "nome"=>$this->getnome(),
            "ipcomputador"=>$this->getipcomputador(),
            "nivel"=>$this->getipnivel(),
            "setor"=>$this->getsetoruser()
        );
    }
    public function level($ip){
       $dados = $this->loadByIdUsuario($ip);
       return $dados['nivel'];

    }
}

?>