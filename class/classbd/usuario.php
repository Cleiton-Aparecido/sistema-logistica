<?php

class usuario
{
    private $listausuario = array();
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
    private function getlistausuario()
    {
        return $this->listausuario;
    }
    private function setlistausuario($value)
    {
        $this->listausuario = $value;
    }

    private function getidusuario()
    {
        return $this->idusuario;
    }
    private function setidusuario($value)
    {
        $this->idusuario = $value;
    }

    private function getnome()
    {
        return $this->nome;
    }
    private function setnome($value)
    {
        $this->nome = $value;
    }

    private function getipcomputador()
    {
        return $this->ipcomputador;
    }
    private function setipcomputador($value)
    {
        $this->ipcomputador = $value;
    }

    private function getipnivel()
    {
        return $this->ipnivel;
    }
    private function setipnivel($value)
    {
        $this->ipnivel = $value;
    }

    private function getsetoruser()
    {
        return $this->setoruser;
    }
    private function setsetoruser($value)
    {
        $this->setoruser = $value;
    }

    private function insertIpNew($ip){
        $this->sql->query("INSERT INTO usuario (nome,ipcomputador,nivel) 
        VALUES ('" . $ip . "','" . $ip . "',3);");
    }
    private function searchIp($ip){

        $resultado = $this->sql->select("SELECT * FROM usuario 
        LEFT JOIN setor ON setor.idsetor = usuario.idsetor
        WHERE usuario.ipcomputador = :ID", array(
            ":ID" => $ip
        ));
        return $resultado;
    }

    public function loadByIdUsuario($ip){
        $resultado = $this->searchIp($ip);

        if (count($resultado) == 0) {
            $this->insertIpNew($ip);
            $resultado = $this->searchIp($ip);
        }

        $row = $resultado[0];
        $this->setidusuario($row['idusuario']);
        $this->setnome($row['nome']);
        $this->setipcomputador($row['ipcomputador']);
        $this->setipnivel($row['nivel']);
        if(!isset($row['descsetor'])){
            $this->setsetoruser('Sem Setor');
        }else{
            $this->setsetoruser($row['descsetor']);
        }
      
        return array(
            "idusuario" => $this->getidusuario(),
            "nome" => $this->getnome(),
            "ipcomputador" => $this->getipcomputador(),
            "nivel" => $this->getipnivel(),
            "setor" => $this->getsetoruser()
        );
    }
    public function level($ip){
        $dados = $this->loadByIdUsuario($ip);
        return $dados['nivel'];
    }

    private function listatodosusuarios(){
        $lista = array();
        $resultado = $this->sql->select("SELECT * FROM usuario 
        LEFT JOIN setor ON setor.idsetor = usuario.idsetor");

        foreach ($resultado as $row) {
            if(!isset($row['descsetor'])){
                $row['descsetor'] = 'sem setor';
            }else{
                $this->setsetoruser($row['descsetor']);
            }
            array_push($lista,array("id"=>$row['idusuario'],
                                    "nome" => $row['nome'],
                                    "ipcomputador" => $row['ipcomputador'],
                                    "nivel" =>  $row['nivel'],
                                    "setor" =>  $row['descsetor']
                                    ));
        }
       $this->setlistausuario($lista);
    }

    public function listausuarios(){
        $this->listatodosusuarios();
        return $this->getlistausuario();
    }

    private function AtualizaNameSetorNivelUsuario($usuarioDados){
        $comando ="UPDATE usuario SET nome = '".$usuarioDados['nome']."',nivel = '".$usuarioDados['nivel']."', idsetor = (SELECT idsetor FROM setor WHERE descsetor = '".$usuarioDados['setor']."') WHERE idusuario = '".$usuarioDados['id']."'";
        $this->sql->query($comando);
    }
    public function atualizarusuario($dadosUsuario){
        $this->AtualizaNameSetorNivelUsuario($dadosUsuario);
    }
}
