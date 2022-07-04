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
    private $infbanco;

    public function __construct()
    {
        $this->sql = new sql();
        $this->objectSector = new setor();
        $this->infbancogeral = 'SELECT 
                            registroencomenda.idregistroenc AS id,
                            registroencomenda.dataregistro,
                            usuario.nome,
                            registroencomenda.codigo,
                            registroencomenda.remetente,
                            registroencomenda.datacoleta,   
                            tipoencomenda.desctipoencomenda,
                            statusentrega.descstatusentrega, 
                            registroencomenda.dataentregasetor, 
                            setor.descsetor
                            FROM registroencomenda
                            INNER JOIN statusentrega ON registroencomenda.idstatusentrega = statusentrega.idstatusentrega
                            INNER JOIN setor ON registroencomenda.idsetor=setor.idsetor
                            INNER JOIN usuario ON registroencomenda.idusuario=usuario.idusuario
                            INNER JOIN tipoencomenda ON registroencomenda.idtipoencomenda=tipoencomenda.idtipoencomenda';
        
    }
    public function getinfbanco(){
        return $this->infbancogeral;
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
    private function inserirNovoRegistro($dados){
        $this->sql->query("INSERT INTO registroencomenda SET
        codigo = '".$dados['codigo']."',
        remetente = '".$dados['remetente']."' ,
        idtipoencomenda =  (SELECT idtipoencomenda FROM tipoencomenda WHERE desctipoencomenda = '".$dados['encomenda']."'), 
        idusuario = (SELECT idusuario FROM usuario WHERE ipcomputador = '".$dados['ipcomputador']."' ) , 
        registroObservacao = '".$dados['observacao']."', 
        datacoleta ='".$dados['dcoleta']."',
        idstatusentrega = (SELECT idstatusentrega FROM statusentrega WHERE descstatusentrega = 'Pendente'),
        idsetor = (SELECT idsetor FROM setor WHERE descsetor = '".$dados['setor']."');");
    }
    private function updatestatusentrega($dados){
        $this->sql->query("UPDATE registroencomenda SET 
        dataentregasetor = '".$dados['dataentrega']."',
        idstatusentrega = (SELECT idstatusentrega FROM statusentrega WHERE descstatusentrega = '".$dados['status']."')
        WHERE idregistroenc = '".$dados['id']."';");
    }
    public function updateregistro($dados){
        $this->updatestatusentrega($dados);
    }
    public function listGroupPendente(){
        $resultado = $this->sql->select($this->getinfbanco()."
        WHERE statusentrega.descstatusentrega = 'Pendente' or statusentrega.descstatusentrega = 'Negado'");
        return $resultado;
    }
    public function insertregistro($dados){
        $this->inserirNovoRegistro($dados);
    }

    public function queryRegistro($id){
        $resultado = $this->sql->select("SELECT *, 
        registroencomenda.idregistroenc AS id
        FROM registroencomenda
        INNER JOIN statusentrega ON registroencomenda.idstatusentrega = statusentrega.idstatusentrega
        INNER JOIN setor ON registroencomenda.idsetor=setor.idsetor
        INNER JOIN usuario ON registroencomenda.idusuario=usuario.idusuario
        INNER JOIN tipoencomenda ON registroencomenda.idtipoencomenda=tipoencomenda.idtipoencomenda
        WHERE idregistroenc = " . $id . "");

        if (count($resultado) > 0) {
            $row = $resultado[0];
           
            $resultado = array(
                "id" => $row['id'],
                "ipcomputador"=>$row['ipcomputador'],
                "Usuario Registro" => $row['nome'],
                "Codigo" => $row['codigo'],
                "Remetente" => $row['remetente'],
                "Tipo da Encomenda" => $row['desctipoencomenda'],
                "Data Registro" => $row['dataregistro'],
                "Data Coleta" => $row['datacoleta'],
                "Status" => $row['descstatusentrega'],
                "Setor" => $row['descsetor'],
                "Data Entrega Setor" => $row['dataentregasetor'],
                "Observação do registro" => $row['registroObservacao'],
                "Ip que realizou ultima alteração" =>$row['Idusuarioaltera']
            );
        }

        return $resultado;
    }
    public function listDateQueryRegistro($datestart, $dateend){

        $resultado = $this->sql->select($this->getinfbanco()."
        WHERE registroencomenda.dataregistro 
        BETWEEN '" . $datestart . " 00:00:00' and '" . $dateend . " 23:59:59'");

        return $resultado;
    }
    public function listDateCodeQuery($search, $datestart, $dateend)
    {

        $resultado = $this->sql->select($this->getinfbanco()."
        WHERE (registroencomenda.dataregistro 
        BETWEEN '" . $datestart . " 00:00:00' 
        AND  '" . $dateend . " 23:59:59')
        AND registroencomenda.codigo ='" . $search . "'");

        return $resultado;
    }
    public function listDateSectorQuery($sector, $datestart, $dateend)
    {
        $resultado = $this->sql->select($this->getinfbanco()."
        WHERE (registroencomenda.dataregistro 
        BETWEEN '" . $datestart . " 00:00:00' 
        AND  '" . $dateend . " 23:59:59')
        AND setor.descsetor ='" . $sector . "'");

        return $resultado;
    }
    public function listDateSectorSearchQuery($sector, $search, $datestart, $dateend)
    {
        $resultado = $this->sql->select($this->getinfbanco()."
        WHERE (registroencomenda.dataregistro 
        BETWEEN '" . $datestart . " 00:00:00' 
        AND  '" . $dateend . " 23:59:59')
        AND setor.descsetor ='" . $sector . "'
        AND registroencomenda.codigo = '" . $search . "'");
        return $resultado;
    }
    
    

}
