<?php

class registro
{
    private $idregistro;
    private $Idusuario;
    private $idsetor;
    private $codigo;
    private $remetente;
    private $datacadastro;
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
    public function queryRegistro($id){
        $resultado = $this->sql->select( "SELECT *
        FROM registroencomenda
        INNER JOIN usuario ON registroencomenda.idusuario=usuario.idusuario
        INNER JOIN statusentrega on statusentrega.idstatusentrega = registroencomenda.idtipoencomenda
        INNER JOIN tipoencomenda ON registroencomenda.idtipoencomenda=tipoencomenda.idtipoencomenda
        INNER JOIN grupo ON grupo.idgrupo = registroencomenda.idgrupo
        WHERE idregistroenc = ".$id."");
        
        if(count($resultado)>0){
            $row = $resultado[0];
            if($row['dataentregasetor']==null){
                $row['dataentregasetor'] == 'asd';
            }

            $resultado = array(
                "ID"=>$row['idregistroenc'],
                "Usuario Registro"=>$row['nome'],
                "Codigo"=>$row['codigo'],
                "Remetente"=>$row['remetente'],
                "Tipo da Encomenda"=>$row['desctipoencomenda'],
                "Data Registro"=>$row['dataregistro'],
                "Grupo"=>$row['idgrupo'],
                "Data Coleta"=>$row['datacoleta'],
                "Status"=>$row['idstatusentrega'],
                "Data Entrega Setor"=>$row['dataentregasetor'],
                "Setor"=>$row['idsetor'],
                "Observação do registro"=>$row['registroObservacao']
            );
        }

        return $resultado;
    }


    public function listDateQueryRegistro($datestart,$dateend){
        
        $resultado = $this->sql->select("SELECT 
        registroencomenda.idregistroenc AS id,
        usuario.nome,
        registroencomenda.codigo,
        registroencomenda.remetente,
        registroencomenda.dataregistro,
        registroencomenda.idgrupo,
        statusentrega.descstatusentrega,  
        grupo.dataentregasetor,
        setor.descsetor
        FROM registroencomenda
        INNER JOIN usuario ON registroencomenda.idusuario=usuario.idusuario
        INNER JOIN grupo ON grupo.idgrupo = registroencomenda.idgrupo
        INNER JOIN statusentrega ON grupo.idstatusentrega=statusentrega.idstatusentrega
        INNER JOIN setor ON grupo.idsetor=setor.idsetor
        INNER JOIN tipoencomenda on tipoencomenda.idtipoencomenda=registroencomenda.idtipoencomenda
        WHERE registroencomenda.dataregistro 
        BETWEEN '".$datestart." 00:00:00' and '".$dateend." 23:59:59'");

        return $resultado;
    }
    public function listDateCodeQuery($search,$datestart,$dateend){
        
        $resultado = $this->sql->select( "SELECT 
        registroencomenda.idregistroenc AS id,
        usuario.nome,
        registroencomenda.codigo,
        registroencomenda.remetente,
        registroencomenda.dataregistro,
        registroencomenda.idgrupo,
        statusentrega.descstatusentrega,  
        grupo.dataentregasetor,
        setor.descsetor
        FROM registroencomenda
        INNER JOIN usuario ON registroencomenda.idusuario=usuario.idusuario
        INNER JOIN grupo ON grupo.idgrupo = registroencomenda.idgrupo
        INNER JOIN statusentrega ON grupo.idstatusentrega=statusentrega.idstatusentrega
        INNER JOIN setor ON grupo.idsetor=setor.idsetor
        INNER JOIN tipoencomenda on tipoencomenda.idtipoencomenda=registroencomenda.idtipoencomenda
        WHERE (registroencomenda.dataregistro 
        BETWEEN '".$datestart." 00:00:00' 
        AND  '".$dateend." 23:59:59')
        AND registroencomenda.codigo ='".$search."'");

        return $resultado;
    }
    public function listDateSectorQuery($sector,$datestart,$dateend){
        $sector= $this->objectSector->SearchSector($sector);
        $resultado = $this->sql->select( "SELECT 
        registroencomenda.idregistroenc AS id,
        usuario.nome,
        registroencomenda.codigo,
        registroencomenda.remetente,
        registroencomenda.dataregistro,
        registroencomenda.idgrupo,
        statusentrega.descstatusentrega,  
        grupo.dataentregasetor,
        setor.descsetor
        FROM registroencomenda
        INNER JOIN usuario ON registroencomenda.idusuario=usuario.idusuario
        INNER JOIN grupo ON grupo.idgrupo = registroencomenda.idgrupo
        INNER JOIN statusentrega ON grupo.idstatusentrega=statusentrega.idstatusentrega
        INNER JOIN setor ON grupo.idsetor=setor.idsetor
        INNER JOIN tipoencomenda on tipoencomenda.idtipoencomenda=registroencomenda.idtipoencomenda
        WHERE (registroencomenda.dataregistro 
        BETWEEN '".$datestart." 00:00:00' 
        AND  '".$dateend." 23:59:59')
        AND grupo.idsetor ='".$sector."'");

        return $resultado;
    }
    public function listDateSectorSearchQuery($sector,$search,$datestart,$dateend){
        $sector = $this->objectSector->SearchSector($sector);
        $resultado = $this->sql->select( "SELECT 
        registroencomenda.idregistroenc AS id ,
        usuario.nome,
        registroencomenda.codigo,
        registroencomenda.remetente,
        registroencomenda.dataregistro,
        registroencomenda.idgrupo,
        statusentrega.descstatusentrega,  
        grupo.dataentregasetor,
        setor.descsetor
        FROM registroencomenda
        INNER JOIN usuario ON registroencomenda.idusuario=usuario.idusuario
        INNER JOIN grupo ON grupo.idgrupo = registroencomenda.idgrupo
        INNER JOIN statusentrega ON grupo.idstatusentrega=statusentrega.idstatusentrega
        INNER JOIN setor ON grupo.idsetor=setor.idsetor
        INNER JOIN tipoencomenda on tipoencomenda.idtipoencomenda=registroencomenda.idtipoencomenda
        WHERE (registroencomenda.dataregistro 
        BETWEEN '".$datestart." 00:00:00' 
        AND  '".$dateend." 23:59:59')
        AND grupo.idsetor ='".$sector."'
        AND registroencomenda.codigo = '".$search."'");
        return $resultado;
    }
    public function listGroupPendente(){
      
        $resultado = $this->sql->select( "SELECT 
        registroencomenda.idregistroenc AS id,
        registroencomenda.codigo,
        registroencomenda.remetente,
        registroencomenda.idgrupo,
        statusentrega.descstatusentrega,  
        grupo.datacoleta,
        setor.descsetor
        FROM registroencomenda
        INNER JOIN usuario ON registroencomenda.idusuario=usuario.idusuario
        INNER JOIN grupo ON grupo.idgrupo = registroencomenda.idgrupo
        INNER JOIN statusentrega ON grupo.idstatusentrega=statusentrega.idstatusentrega
        INNER JOIN setor ON grupo.idsetor=setor.idsetor
        INNER JOIN tipoencomenda on tipoencomenda.idtipoencomenda=registroencomenda.idtipoencomenda
        WHERE grupo.idstatusentrega = 2 or grupo.idstatusentrega = 1
        ");
        return $resultado;
    }


    public function insertregistro($code,$remetente,$idencomenda,$group,$usuario,$obs){
        $this->sql->query("INSERT INTO registroencomenda (codigo,remetente,idtipoencomenda,idgrupo,idusuario,registroObservacao)
        VALUES ('".$code."','".$remetente."',".$idencomenda.",".$group.",".$usuario.",'".$obs."');");
    }
   
}
