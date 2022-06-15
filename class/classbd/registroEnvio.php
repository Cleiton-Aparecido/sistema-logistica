<?php

class registroEnvio
{
    private $idregistro;
    private $Idusuario;
    private $idsetor;
    private $codigo;
    private $remetente;
    private $datacadastro;
    private $encomenda;
    private $func;
    private $cep;
    private $num;
    private $bairro;
    private $cidade;
    private $uf;
    private $complementar;
    private $obs;
    private $sql = array();
    private $objectSector = array();

    public function __construct()
    {
        $this->sql = new sql();
        $this->objectSector = new setor();
    }
    

    public function getidregistro()
    {
        return $this->idregistro;
    }

    public function setidregistro($value)
    {
        $this->Idusuario = $value;
    }
    public function getIdusuario()
    {
        return $this->Idusuario;
    }
    public function setIdusuario($value)
    {
        $this->Idusuario = $value;
    }

    public function getidsetor()
    {
        return $this->idsetor;
    }

    public function setidsetor($value)
    {
        $this->idsetor = $value;
    }

    public function getcodigo()
    {
        return $this->codigo;
    }

    public function setcodigo($value)
    {
        $this->codigo = $value;
    }

    public function getremetente()
    {
        return $this->remetente;
    }

    public function setremetente($value)
    {
        $this->remetente = $value;
    }

    public function getdatacadastro()
    {
        return $this->datacadastro;
    }

    public function setdatacadastro($value)
    {
        $this->datacadastro = $value;
    }

    public function getaberto()
    {
        return $this->aberto;
    }

    public function setaberto($value)
    {
        $this->aberto = $value;
    }
    public function gettabelaregistro()
    {
        return $this->tabelaRegistro;
    }

    public function insertRegisterEnvio($idusuario,$setor,$encomenda,$func,$cep,$rua,$num,$bairro,$cidade,$uf,$complementar,$obs){
        $comando = ("INSERT INTO
         registroencomendaenviocorreio 
         (idusuarioNewRegistro,idstatusentrega,setorRemetente,idtipoencomenda,Nomefuncionario,cep,Endereco,numero,cidade,bairro,estado,complementarend,observacaoenvio) 
         VALUES 
        (".$idusuario.",2,".$setor.",".$encomenda.",'".$func."','".$cep."','".$rua."','".$num."','".$cidade."','".$bairro."','".$uf."','".$complementar."','".$obs."')"); 
        $this->sql->query($comando);
    }
    public function listDateQueryRegistroenvio($datestart,$dateend){
        $resultado = $this->sql->select("SELECT registroencomendaenviocorreio.idRegistroEncomendaEnvioCorreio AS id,
        registroencomendaenviocorreio.dataregistro,
        registroencomendaenviocorreio.Nomefuncionario,
        setor.descsetor,
        statusentrega.descstatusentrega,
        tipoencomenda.desctipoencomenda,
        registroencomendaenviocorreio.codigopostagem,
        registroencomendaenviocorreio.datapostagem
        FROM registroencomendaenviocorreio
        INNER JOIN usuario ON usuario.idusuario=registroencomendaenviocorreio.idusuarioNewRegistro
        INNER JOIN statusentrega ON statusentrega.idstatusentrega = registroencomendaenviocorreio.idstatusentrega
        INNER JOIN tipoencomenda ON tipoencomenda.idtipoencomenda = registroencomendaenviocorreio.idtipoencomenda
        INNER JOIN setor ON setor.idsetor=registroencomendaenviocorreio.setorRemetente
        ");

        return $resultado;
    }
   
}
