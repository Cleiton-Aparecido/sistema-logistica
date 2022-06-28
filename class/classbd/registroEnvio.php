<?php

class registroEnvio
{
    private $idregistro;
    private $datacadastro;
    private $Idusuario;
    private $status;
    private $setorRemetente;
    private $encomenda;
    private $funcinario;
    private $cep;
    private $endereco;
    private $num;
    private $cidade;
    private $bairro;
    private $uf;
    private $complementar;
    private $obs;
    private $codigo;
    private $datapostagem;
    private $idusuariocodigo;
    private $sql = array();
    private $objectSector = array();

    public function __construct()
    {
        $this->sql = new sql();
        $this->objectSector = new setor();
    }
    
     #-------- Id registro ---------------
    public function getidregistro()
    {
        return $this->idregistro;
    }

    public function setidregistro($value)
    {
        $this->idregistro = $value;
    }
     #-------- Data cadastro ---------------
    public function getdatacadastro()
    {
        return $this->datacadastro;
    }

    public function setdatacadastro($value)
    {
        $date = new DateTime($value);
        $value = $date->format('d/m/Y H:i:s');
        $this->datacadastro = $value;
    }
     #-------- Id usuario ---------------
    public function getIdusuario()
    {
        return $this->Idusuario;
    }
    public function setIdusuario($value)
    {
        $this->Idusuario = $value;
    }
    #-------- status ---------------
    public function getstatus()
    {
        return $this->status;
    }
    public function setstatus($value)
    {
        $this->status = $value;
    }
    #-------- Setor remetente ---------------
    public function getsetorRemetente()
    {
        return $this->setorRemetente;
    }
    public function setsetorRemetente($value)
    {
        $this->setorRemetente = $value;
    }
    #-------- encomenda ---------------
    public function getencomenda()
    {
        return $this->encomenda;
    }
    public function setencomenda($value)
    {
        $this->encomenda = $value;
    }
    #-------- funcinario ---------------
    public function getfuncinario()
    {
        return $this->funcinario;
    }
    public function setfuncinario($value)
    {
        $this->funcinario = $value;
    }
    #-------- cep ---------------
    public function getcep()
    {
        return $this->cep;
    }
    public function setcep($value)
    {
        $this->cep = $value;
    }
    #-------- endereco ---------------
    public function getendereco()
    {
        return $this->endereco;
    }
    public function setendereco($value)
    {
        $this->endereco = $value;
    }
    #-------- num ---------------
    public function getnum()
    {
        return $this->num;
    }
    public function setnum($value)
    {
        $this->num = $value;
    }
    #-------- cidade ---------------
    public function getcidade()
    {
        return $this->cidade;
    }
    public function setcidade($value)
    {
        $this->cidade = $value;
    }
    #-------- bairro ---------------
    public function getbairro()
    {
        return $this->bairro;
    }
    public function setbairro($value)
    {
        $this->bairro = $value;
    }
    #-------- uf ---------------
    public function getuf()
    {
        return $this->uf;
    }
    public function setuf($value)
    {
        $this->uf = $value;
    }
    #-------- complementar ---------------
    public function getcomplementar()
    {
        return $this->complementar;
    }
    public function setcomplementar($value)
    {
        $this->complementar = $value;
    }
    #-------- obs ---------------
    public function getobs()
    {
        return $this->obs;
    }
    public function setobs($value)
    {
        $this->obs = $value;
    }
    #-------- codigo ---------------
    public function getcodigo()
    {
        return $this->codigo;
    }
    public function setcodigo($value)
    {
        $this->codigo = $value;
    }
    #-------- datapostagem ---------------
    public function getdatapostagem()
    {
        return $this->datapostagem;
    }
    public function setdatapostagem($value)
    {
        $this->datapostagem = $value;
    }
     #-------- idusuariocodigo ---------------
     public function getidusuariocodigo()
     {
         return $this->idusuariocodigo;
     }
     public function setidusuariocodigo($value)
     {
         $this->idusuariocodigo = $value;
     }

    public function insertRegisterEnvio($tipoenvio,$status,$idusuario,$setor,$encomenda,$func,$cep,$rua,$num,$bairro,$cidade,$uf,$complementar,$obs){
        $comando = ("INSERT INTO
         registroencomendaenviocorreio 
         (idtipoEnvio,idusuarioNewRegistro,idstatusentrega,setorRemetente,idtipoencomenda,Nomefuncionario,cep,Endereco,numero,cidade,bairro,estado,complementarend,observacaoenvio) 
         VALUES 
        (".$tipoenvio.",".$idusuario.",$status,".$setor.",".$encomenda.",'".$func."','".$cep."','".$rua."','".$num."','".$cidade."','".$bairro."','".$uf."','".$complementar."','".$obs."')"); 
        var_dump($comando);
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
        WHERE registroencomendaenviocorreio.dataregistro 
        BETWEEN '".$datestart." 00:00:00' and '".$dateend." 23:59:59'");
        return $resultado;
    }
    public function listDateCodeQueryEnvio($search,$datestart,$dateend){
        
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
        WHERE (registroencomendaenviocorreio.dataregistro 
        BETWEEN '".$datestart." 00:00:00' 
        AND  '".$dateend." 23:59:59')
        AND registroencomendaenviocorreio.codigopostagem ='".$search."'");

        return $resultado;
    }
    public function listDateSectorQueryEnvio($sector,$datestart,$dateend){
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
        WHERE (registroencomendaenviocorreio.dataregistro 
        BETWEEN '".$datestart." 00:00:00' 
        AND  '".$dateend." 23:59:59')
        AND setor.descsetor = '".$sector."'");
       

        return $resultado;
    }
    public function listDateSectorSearchQueryEnvio($sector,$search,$datestart,$dateend){
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
        WHERE (registroencomendaenviocorreio.dataregistro 
        BETWEEN '".$datestart." 00:00:00' 
        AND  '".$dateend." 23:59:59')
        AND setor.descsetor = '".$sector."'
        AND registroencomendaenviocorreio.codigopostagem = '".$search."'");
       

        return $resultado;
    }
    public function queryregisterenvio($id){    
        $resultado = $this->sql->select("SELECT *
        FROM registroencomendaenviocorreio
        INNER JOIN usuario ON usuario.idusuario=registroencomendaenviocorreio.idusuarioNewRegistro
        INNER JOIN statusentrega ON statusentrega.idstatusentrega = registroencomendaenviocorreio.idstatusentrega
        INNER JOIN tipoencomenda ON tipoencomenda.idtipoencomenda = registroencomendaenviocorreio.idtipoencomenda
        INNER JOIN setor ON setor.idsetor=registroencomendaenviocorreio.setorRemetente          
        WHERE idRegistroEncomendaEnvioCorreio = ".$id."");

        if(count($resultado)>0){
            
            $row = $resultado[0];
            $this->setidregistro($row['idRegistroEncomendaEnvioCorreio']);
            $this->setdatacadastro($row['dataregistro']);
            $this->setIdusuario($row['ipcomputador']);
            $this->setstatus($row['descstatusentrega']);
            $this->setsetorRemetente($row['descsetor']);
            $this->setencomenda($row['desctipoencomenda']);
            $this->setfuncinario($row['Nomefuncionario']);
            $this->setcep($row['cep']);
            $this->setendereco($row['Endereco']);
            $this->setnum($row['numero']);
            $this->setcidade($row['cidade']);
            $this->setbairro($row['bairro']);
            $this->setuf($row['estado']);
            $this->setcomplementar($row['complementarend']);
            $this->setobs($row['observacaoenvio']);
            $this->setcodigo($row['codigopostagem']);
            $this->setdatapostagem($row['datapostagem']);
            $this->setidusuariocodigo($row['idusuarioalteracao']);
        }


        return array(
            "id"=>$this->getidregistro(),
            "DataRegistro"=>$this->getdatacadastro(),
            "Ipusuario"=>$this->getIdusuario(),
            "status"=>$this->getstatus(),
            "SetorRementente"=>$this->getsetorRemetente(),
            "Encomenda"=>$this->getencomenda(),
            "funcionario"=>$this->getfuncinario(),
            "cep"=>$this->getcep(),
            "rua"=>$this->getendereco(),
            "numero"=>$this->getnum(),
            "cidade"=>$this->getcidade(),
            "bairro"=>$this->getbairro(),
            "estado"=>$this->getuf(),
            "complementar"=>$this->getcomplementar(),
            "Observacao"=>$this->getobs(),
            "CodigoPostagen"=>$this->getcodigo(),
            "DataPostagem"=>$this->getdatapostagem(),
            "UsuarioQueRealizouAPostagem"=>$this->getidusuariocodigo()
        );
    }
    public function AtualizaCodigoRementeEncomendaData($id,$status,$codigo,$data,$obs){
        $comando = ("UPDATE registroencomendaenviocorreio SET 
        idstatusentrega = '$status',
        codigopostagem = '$codigo',
        datapostagem = '$data',
        observacaoenvio = '$obs'
        WHERE idRegistroEncomendaEnvioCorreio = $id"); 
       $this->sql->query($comando);
   }

}

