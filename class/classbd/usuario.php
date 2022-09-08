<?php

class usuario
{
    private $idusuario;
    private $listausuario = array();
    private $nome;
    private $ipcomputador;
    private $setoruser;
    private $acessos = array();
    private $ListaDeAcessos = array();
    private $sql = array();

    public function __construct()
    {
        $this->sql = new sql();
    }
    private function getListaDeAcessos()
    {
        return $this->ListaDeAcessos;
    }
    private function setListaDeAcessos($value)
    {
        array_push($this->ListaDeAcessos,$value);
    }
    private function getacessos()
    {
        return $this->acessos;
    }
    private function setacessos($value)
    {
        $this->acessos = $value;
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


    private function getsetoruser()
    {
        return $this->setoruser;
    }
    private function setsetoruser($value)
    {
        $this->setoruser = $value;
    }

    private function insertIpNew($ip){
        $this->sql->query("INSERT INTO usuario (nome,ipcomputador) 
        VALUES ('" . $ip . "','" . $ip . "');");
    }
    private function searchIp($ip){
        $resultado = $this->sql->select("SELECT * FROM usuario 
        LEFT JOIN setor ON setor.idsetor = usuario.idsetor
        LEFT JOIN controlepermissao ON controlepermissao.idusuario=usuario.idusuario
        LEFT JOIN acessos ON acessos.idacessos = controlepermissao.idacessos
        WHERE usuario.ipcomputador = :ID 
        ORDER BY acessos.descacessos DESC", array(
            ":ID" => $ip
        ));
        return $resultado;
    }

    private function searchId($id){

        $resultado = $this->sql->select("SELECT * FROM usuario 
        LEFT JOIN setor ON setor.idsetor = usuario.idsetor
        LEFT JOIN controlepermissao ON controlepermissao.idusuario=usuario.idusuario
        LEFT JOIN acessos ON acessos.idacessos = controlepermissao.idacessos
        WHERE usuario.idusuario = ".$id." 
        ORDER BY acessos.descacessos DESC");
        
        
        return $resultado;
    }

    public function loadByIpUsuario($ip){
        
        $resultado = $this->searchIp($ip);

        if (count($resultado) == 0) {
            $this->insertIpNew($ip);
            $resultado = $this->searchIp($ip);
        }

        $auxacesso = array();

        foreach ($resultado as $row) {
         array_push($auxacesso,$row['descacessos']);  
        }
        
        $row = $resultado[0];
        $this->setidusuario($row['idusuario']);
        $this->setnome($row['nome']);
        $this->setipcomputador($row['ipcomputador']);
        $this->setacessos($auxacesso);
        if(!isset($row['descsetor'])){
            $this->setsetoruser('Sem Setor');
        }else{
            $this->setsetoruser($row['descsetor']);
        }

        return array(
            "idusuario" => $this->getidusuario(),
            "nome" => $this->getnome(),
            "ipcomputador" => $this->getipcomputador(),
            "setor" => $this->getsetoruser(),
            "acessos" => $this->getacessos()
        );
    }


    public function loadByIdUsuario($id){
        $resultado = $this->searchId($id);

        if (count($resultado) == 0) {
            $resultado = $this->searchId($id);
        }

        $auxacesso = array();

        foreach ($resultado as $row) {
         array_push($auxacesso,$row['descacessos']);
           
        }

        $row = $resultado[0];

    

        $this->setidusuario($row['idusuario']);
        $this->setnome($row['nome']);
        $this->setipcomputador($row['ipcomputador']);
        $this->setacessos($auxacesso);
        if(!isset($row['descsetor'])){
            $this->setsetoruser('Sem Setor');
        }else{
            $this->setsetoruser($row['descsetor']);
        }

      
    
        return array(
            "idusuario" => $id,
            "nome" => $this->getnome(),
            "ipcomputador" => $this->getipcomputador(),
            "setor" => $this->getsetoruser(),
            "acessos" => $this->getacessos()
        );
    }


    private function listatodosusuarios(){
        $lista = array();
        $resultado = $this->sql->select("SELECT * FROM usuario 
        LEFT JOIN setor ON setor.idsetor = usuario.idsetor
        ORDER BY usuario.idusuario");

        foreach ($resultado as $row) {
            if(!isset($row['descsetor'])){
                $row['descsetor'] = 'sem setor';
            }else{
                $this->setsetoruser($row['descsetor']);
            }
            array_push($lista,array("id"=>$row['idusuario'],
                                    "nome" => $row['nome'],
                                    "ipcomputador" => $row['ipcomputador'],
                                    "setor" =>  $row['descsetor']
                                    ));
        }
       $this->setlistausuario($lista);
    }

    public function listausuarios(){
        $this->listatodosusuarios();
        return $this->getlistausuario();
    }

    public function atualizarnome($dados){
        $this->sql->query("UPDATE usuario SET nome ='".$dados['nome_novo']."' WHERE idusuario='".$dados['id']."'");  

    }
    public function atualizarsetor($dados){
        $this->sql->query("UPDATE usuario SET idsetor = (SELECT idsetor FROM setor WHERE descsetor = '".$dados['setor_novo']."') WHERE idusuario='".$dados['id']."'");  
    }
    // Configuração de acessos
    public function ListaDeAcessos(){
        $resultado = $this->sql->select("SELECT descacessos FROM acessos");
       if (count($resultado)>0 ) {
            foreach ($resultado as $key => $value) {
                $this->setListaDeAcessos($value['descacessos']);
            }
       }
       return  $this->getListaDeAcessos();

    }
    public function excluir_acessos($acesso_excluir){

        $this->sql->query("DELETE controlepermissao FROM controlepermissao
        INNER JOIN acessos ON acessos.idacessos = controlepermissao.idacessos
        WHERE idusuario = '".$acesso_excluir['id']."' AND acessos.descacessos = '".$acesso_excluir['acesso']."';");  

    }
    public function criar_acessos($acesso_criar){

        $this->sql->query("INSERT INTO controlepermissao (idusuario,idacessos) VALUES ('".$acesso_criar['id']."',(SELECT idacessos FROM acessos WHERE descacessos = '".$acesso_criar['acesso']."'))");   

    }
}
