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
    private $historicoregistro = array();
    private $QtdDadosPorStatus;

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
    public function getQtdDadosPorStatus(){
        return $this->QtdDadosPorStatus;
    }
    public function setQtdDadosPorStatus($value){
        $this->QtdDadosPorStatus =  $value;
    }

    public function gethistoricoregistro(){
        return $this->historicoregistro;
    }
    public function sethistoricoregistro($value){
        $this->historicoregistro =  $value;
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
    private function formatDateHora($data){
        $data = new DateTime($data);
        return $data = $data->format('d/m/Y H:i:s');
    }
    private function formatDate($data){
        $data = new DateTime($data);
        return $data = $data->format('d/m/Y');
    }
    public function backloghistorico($id,$obsantiga = "",$obsnova){

        $this->sql->query("INSERT INTO backlogregisentrada (idRegistroEnvio,campo,dados_antigo,dados_novo) 
        VALUES ('$id', 'Observacao',
        '$obsantiga',
        '$obsnova');");
    }
    private function atualizar_informacoes_registro_backlog($dados){

        $dadosantigo = $this->queryRegistro($dados['id']);
        $dados['dataentrega'] = $this->formatDateHora($dados['dataentrega']);
        $dados['dataentrega'] = str_replace('T',' ', $dados['dataentrega']);



        $comando = "INSERT INTO backlogregisentrada (idRegistroEnvio,campo,dados_antigo,dados_novo) 
        VALUES ('".$dados['id']."',
        'Codigo | Remetente | Data Entrega Setor | Data Coleta | Status entrega | Setor | Encomenda',
        '".$dadosantigo['Codigo']." | ".$dadosantigo['Remetente']." | ".$dadosantigo['Data Entrega Setor']." | ".$this->formatDate( $dadosantigo['Data Coleta'])." | ".$dadosantigo['Status']." | ".$dadosantigo['Setor']." | ".$dadosantigo['Tipo da Encomenda']." ',
        '".$dados['codigo']." | ".$dados['rementente']." | ".$dados['dataentrega']." | ".$this->formatDate( $dados['DataColeta'])." | ".$dados['status']." | ".$dados['setor']." | ".$dados['encomenda']."');";

        $this->sql->query("$comando");
        
        $this->backloghistorico($dados['id'],$dadosantigo['Observação do registro'],$dados['obs']);
        // echo $comando;
    }
    function atualizar_informacoes_registro($dados){

        $dadosantigo = $this->queryRegistro($dados['id']);

        $this->atualizar_informacoes_registro_backlog($dados);
        
        $this->sql->query("UPDATE registroencomenda 
        SET codigo = '".$dados['codigo']."',
        remetente = '".$dados['rementente']."' ,
        dataentregasetor = '".$dados['dataentrega']."' ,
        datacoleta = '".$dados['DataColeta']."' ,
        registroObservacao = '".$dados['obs']."',
        idstatusentrega = (SELECT idstatusentrega FROM statusentrega WHERE descstatusentrega = '".$dados['status']."'),
        idtipoencomenda = (SELECT idtipoencomenda FROM tipoencomenda WHERE desctipoencomenda = '".$dados['encomenda']."'),
        idsetor = (SELECT idsetor FROM setor WHERE descsetor = '".$dados['setor']."')
        WHERE idregistroenc = '".$dados['id']."'");
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
    private function backlogEntrada($Registro){
        
        $dadosantigo = $this->queryRegistro($Registro['id']);

        $Registro['dataentrega'] = $this->formatDateHora($Registro['dataentrega']);

        $Registro['dataentrega'] = str_replace('T',' ', $Registro['dataentrega']);

        $this->sql->query("INSERT INTO backlogregisentrada (idRegistroEnvio,campo,dados_antigo,dados_novo) 
        VALUES (".$Registro['id'].",
        'Status | Data Entrega',
        '".$dadosantigo['Status']." | ".$dadosantigo['Data Entrega Setor']."',
        '".$Registro['status']." | ".$Registro['dataentrega']."')
        ");
    }
    public function updateregistro($dados){
        $this->backlogEntrada($dados);
        $this->updatestatusentrega($dados);

    }
    public function listGroupPendente(){
        $resultado = $this->sql->select($this->getinfbanco()."
        WHERE statusentrega.descstatusentrega = 'Pendente' or statusentrega.descstatusentrega = 'Negado' or statusentrega.descstatusentrega = 'Preparo' ");
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
                "Data Registro" => $this->formatDateHora($row['dataregistro']),
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
    public function listDateCodeQuery($search, $datestart, $dateend){

        $resultado = $this->sql->select($this->getinfbanco()."
        WHERE (registroencomenda.dataregistro 
        BETWEEN '" . $datestart . " 00:00:00' 
        AND  '" . $dateend . " 23:59:59')
        AND registroencomenda.codigo ='" . $search . "'");

        return $resultado;
    }
    public function listDateSectorQuery($sector, $datestart, $dateend){
        $resultado = $this->sql->select($this->getinfbanco()."
        WHERE (registroencomenda.dataregistro 
        BETWEEN '" . $datestart . " 00:00:00' 
        AND  '" . $dateend . " 23:59:59')
        AND setor.descsetor ='" . $sector . "'");

        return $resultado;
    }
    public function listDateSectorSearchQuery($sector, $search, $datestart, $dateend){
        $resultado = $this->sql->select($this->getinfbanco()."
        WHERE (registroencomenda.dataregistro 
        BETWEEN '" . $datestart . " 00:00:00' 
        AND  '" . $dateend . " 23:59:59')
        AND setor.descsetor ='" . $sector . "'
        AND registroencomenda.codigo = '" . $search . "'");
        return $resultado;
    }
    private function historicoRegistroEntrada($id){
        $resultado = $this->sql->select("SELECT * FROM backlogregisentrada
        WHERE idRegistroEnvio = $id
        ORDER BY `data`;");

        

        $historico = array();
        
        if(count($resultado)>0){
            foreach ($resultado as $row) {
                $row['data'] = new DateTime($row['data']);
                $row['data'] = $row['data']->format('d/m/Y H:i:s');

                array_push($historico,array("Datahora"=>$row['data'],
                                            "campo"=>$row['campo'],
                                            "dadosantigo"=>$row['dados_antigo'],
                                            "dadosnovo"=>$row['dados_novo']));
            }
        }
        $this->sethistoricoregistro($historico);
    }
    public function requisitarhistorico($id){
        $this->historicoRegistroEntrada($id);
        return $this->gethistoricoregistro();
    }
    private function Requisitar_Qtd_Dados_Por_Status(){

        $ResultadoFormatado = array();

        $resultado = $this->sql->select("SELECT descstatusentrega, COUNT(registroencomenda.idregistroenc) AS 'qtd' FROM statusentrega 
        LEFT JOIN registroencomenda On registroencomenda.idstatusentrega = statusentrega.idstatusentrega
        GROUP BY statusentrega.descstatusentrega;");
        
        foreach ($resultado as $row) {
            
            array_push($ResultadoFormatado,array("status"=>$row['descstatusentrega'],
                                                 "qtd"=>$row['qtd']));

        }
        
        $this->setQtdDadosPorStatus($ResultadoFormatado);
    }
    public function Qtd_Dados_Por_Status(){
        $this->Requisitar_Qtd_Dados_Por_Status();
    return $this->getQtdDadosPorStatus();
    }
}
