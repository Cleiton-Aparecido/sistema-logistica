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
    private $historicoregistro = array();
    private $QtdDadosPorStatus;
    private $objectSector = array();

    public function __construct()
    {
        $this->sql = new sql();
        $this->objectSector = new setor();
    }

    public function gethistoricoregistro(){
        return $this->historicoregistro;
    }
    public function sethistoricoregistro($value){
        $this->historicoregistro =  $value;
    }

    public function getQtdDadosPorStatus(){
        return $this->QtdDadosPorStatus;
    }
    public function setQtdDadosPorStatus($value){
        $this->QtdDadosPorStatus =  $value;
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



    public function requisitarhistorico($id)
    {
        $this->backlogEnvio($id);
        return $this->gethistoricoregistro();
    }

    public function insertRegisterEnvio($dados)
    {
        $comando = ("INSERT INTO
        RegistroEncomendaEnvioCorreio 
        (idtipoEnvio,
        idusuarioNewRegistro,
        idstatusentrega,
        setorRemetente,
        idtipoencomenda,
        Nomefuncionario,
        cep,
        Endereco,
        numero,
        cidade,
        bairro,
        estado,
        complementarend,
        observacaoenvio) 
        VALUES 
        ((SELECT idtipoEnvio FROM tipoEnvio WHERE desctipoEnvio = '" . $dados['tipoenvio'] . "'),
        (SELECT idusuario FROM usuario WHERE ipcomputador = '" . $dados['ipcomputador'] . "'),
        (SELECT idstatusentrega FROM statusentrega WHERE descstatusentrega = 'Pendente'),
        (SELECT idsetor FROM setor WHERE descsetor = '" . $dados['setor'] . "'),
        (SELECT idtipoencomenda FROM tipoencomenda WHERE desctipoencomenda = '" . $dados['encomenda'] . "'),
        '" . $dados['funcionario'] . "',
        '" . $dados['cep'] . "',
        '" . $dados['endereco'] . "',
        '" . $dados['num'] . "',
        '" . $dados['cidade'] . "',
        '" . $dados['bairro'] . "',
        '" . $dados['uf'] . "',
        '" . $dados['complementar'] . "',
        '" . $dados['obs'] . "'
        )");

        

        if(!$this->sql->query($comando)){
            return false;
        }else {
            $idresultado = $this->sql->select("SELECT LAST_INSERT_ID();");
            
            if (count($idresultado) > 0) {
                $row = $idresultado[0];
                $idsalvo = $row["LAST_INSERT_ID()"];
            }   
            return $idsalvo;
        }
    }

    private function backlogEnvio($id)
    {
        $resultado = $this->sql->select("SELECT * FROM BackLogRegisEnvio
        WHERE idRegistroEnvio = '$id'
        ORDER BY `data`;");

        $historico = array();

        if (count($resultado) > 0) {
            foreach ($resultado as $row) {
                $row['data'] = new DateTime($row['data']);
                $row['data'] = $row['data']->format('d/m/Y H:i:s');

                array_push($historico, array(
                    "Datahora" => $row['data'],
                    "campo" => $row['campo'],
                    "dadosantigo" => $row['dados_antigo'],
                    "dadosnovo" => $row['dados_novo']
                ));
            }
        }
        $this->sethistoricoregistro($historico);
    }

    public function listDateQueryRegistroenvio($datestart, $dateend)
    {
        $resultado = $this->sql->select("SELECT RegistroEncomendaEnvioCorreio.idRegistroEncomendaEnvioCorreio AS id,
        RegistroEncomendaEnvioCorreio.dataregistro,
        RegistroEncomendaEnvioCorreio.Nomefuncionario,
        setor.descsetor,
        statusentrega.descstatusentrega,
        tipoencomenda.desctipoencomenda,
        RegistroEncomendaEnvioCorreio.codigopostagem,
        RegistroEncomendaEnvioCorreio.datapostagem
        FROM RegistroEncomendaEnvioCorreio
        INNER JOIN usuario ON usuario.idusuario=RegistroEncomendaEnvioCorreio.idusuarioNewRegistro
        INNER JOIN statusentrega ON statusentrega.idstatusentrega = RegistroEncomendaEnvioCorreio.idstatusentrega
        INNER JOIN tipoencomenda ON tipoencomenda.idtipoencomenda = RegistroEncomendaEnvioCorreio.idtipoencomenda
        INNER JOIN setor ON setor.idsetor=RegistroEncomendaEnvioCorreio.setorRemetente
        WHERE RegistroEncomendaEnvioCorreio.dataregistro 
        BETWEEN '" . $datestart . " 00:00:00' and '" . $dateend . " 23:59:59'");
        return $resultado;
    }
    public function listDateCodeQueryEnvio($search, $datestart, $dateend)
    {

        $resultado = $this->sql->select("SELECT RegistroEncomendaEnvioCorreio.idRegistroEncomendaEnvioCorreio AS id,
        RegistroEncomendaEnvioCorreio.dataregistro,
        RegistroEncomendaEnvioCorreio.Nomefuncionario,
        setor.descsetor,
        statusentrega.descstatusentrega,
        tipoencomenda.desctipoencomenda,
        RegistroEncomendaEnvioCorreio.codigopostagem,
        RegistroEncomendaEnvioCorreio.datapostagem
        FROM RegistroEncomendaEnvioCorreio
        INNER JOIN usuario ON usuario.idusuario=RegistroEncomendaEnvioCorreio.idusuarioNewRegistro
        INNER JOIN statusentrega ON statusentrega.idstatusentrega = RegistroEncomendaEnvioCorreio.idstatusentrega
        INNER JOIN tipoencomenda ON tipoencomenda.idtipoencomenda = RegistroEncomendaEnvioCorreio.idtipoencomenda
        INNER JOIN setor ON setor.idsetor=RegistroEncomendaEnvioCorreio.setorRemetente
        WHERE (RegistroEncomendaEnvioCorreio.dataregistro 
        BETWEEN '" . $datestart . " 00:00:00' 
        AND  '" . $dateend . " 23:59:59')
        AND RegistroEncomendaEnvioCorreio.codigopostagem ='" . $search . "'");

        return $resultado;
    }
    public function listDateSectorQueryEnvio($sector, $datestart, $dateend)
    {
        $resultado = $this->sql->select("SELECT RegistroEncomendaEnvioCorreio.idRegistroEncomendaEnvioCorreio AS id,
        RegistroEncomendaEnvioCorreio.dataregistro,
        RegistroEncomendaEnvioCorreio.Nomefuncionario,
        setor.descsetor,
        statusentrega.descstatusentrega,
        tipoencomenda.desctipoencomenda,
        RegistroEncomendaEnvioCorreio.codigopostagem,
        RegistroEncomendaEnvioCorreio.datapostagem
        FROM RegistroEncomendaEnvioCorreio
        INNER JOIN usuario ON usuario.idusuario=RegistroEncomendaEnvioCorreio.idusuarioNewRegistro
        INNER JOIN statusentrega ON statusentrega.idstatusentrega = RegistroEncomendaEnvioCorreio.idstatusentrega
        INNER JOIN tipoencomenda ON tipoencomenda.idtipoencomenda = RegistroEncomendaEnvioCorreio.idtipoencomenda
        INNER JOIN setor ON setor.idsetor=registroencomendaenviocorreio.setorRemetente
        WHERE (registroencomendaenviocorreio.dataregistro 
        BETWEEN '" . $datestart . " 00:00:00' 
        AND  '" . $dateend . " 23:59:59')
        AND setor.descsetor = '" . $sector . "'");


        return $resultado;
    }
    public function listDateSectorSearchQueryEnvio($sector, $search, $datestart, $dateend)
    {
        $resultado = $this->sql->select("SELECT RegistroEncomendaEnvioCorreio.idRegistroEncomendaEnvioCorreio AS id,
        RegistroEncomendaEnvioCorreio.dataregistro,
        RegistroEncomendaEnvioCorreio.Nomefuncionario,
        setor.descsetor,
        statusentrega.descstatusentrega,
        tipoencomenda.desctipoencomenda,
        RegistroEncomendaEnvioCorreio.codigopostagem,
        RegistroEncomendaEnvioCorreio.datapostagem
        FROM RegistroEncomendaEnvioCorreio
        INNER JOIN usuario ON usuario.idusuario=RegistroEncomendaEnvioCorreio.idusuarioNewRegistro
        INNER JOIN statusentrega ON statusentrega.idstatusentrega = RegistroEncomendaEnvioCorreio.idstatusentrega
        INNER JOIN tipoencomenda ON tipoencomenda.idtipoencomenda = RegistroEncomendaEnvioCorreio.idtipoencomenda
        INNER JOIN setor ON setor.idsetor=RegistroEncomendaEnvioCorreio.setorRemetente
        WHERE (RegistroEncomendaEnvioCorreio.dataregistro 
        BETWEEN '" . $datestart . " 00:00:00' 
        AND  '" . $dateend . " 23:59:59')
        AND setor.descsetor = '" . $sector . "'
        AND RegistroEncomendaEnvioCorreio.codigopostagem = '" . $search . "'");


        return $resultado;
    }
    public function queryregisterenvio($id)
    {
        $resultado = $this->sql->select("SELECT *
        FROM RegistroEncomendaEnvioCorreio
        INNER JOIN usuario ON usuario.idusuario=RegistroEncomendaEnvioCorreio.idusuarioNewRegistro
        INNER JOIN statusentrega ON statusentrega.idstatusentrega = RegistroEncomendaEnvioCorreio.idstatusentrega
        INNER JOIN tipoencomenda ON tipoencomenda.idtipoencomenda = RegistroEncomendaEnvioCorreio.idtipoencomenda
        INNER JOIN setor ON setor.idsetor=RegistroEncomendaEnvioCorreio.setorRemetente          
        WHERE idRegistroEncomendaEnvioCorreio = " . $id . "");

        if (count($resultado) > 0) {

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
            "id" => $this->getidregistro(),
            "DataRegistro" => $this->getdatacadastro(),
            "Ipusuario" => $this->getIdusuario(),
            "status" => $this->getstatus(),
            "SetorRementente" => $this->getsetorRemetente(),
            "Encomenda" => $this->getencomenda(),
            "funcionario" => $this->getfuncinario(),
            "cep" => $this->getcep(),
            "rua" => $this->getendereco(),
            "numero" => $this->getnum(),
            "cidade" => $this->getcidade(),
            "bairro" => $this->getbairro(),
            "estado" => $this->getuf(),
            "complementar" => $this->getcomplementar(),
            "Observacao" => $this->getobs(),
            "CodigoPostagen" => $this->getcodigo(),
            "DataPostagem" => $this->getdatapostagem(),
            "UsuarioQueRealizouAPostagem" => $this->getidusuariocodigo()
        );
    }
    private function formatDateHora($data){
        $data = new DateTime($data);
        return $data = $data->format('d/m/Y H:i:s');
    }
    private function formatDate($data){
        $data = new DateTime($data);
        return $data = $data->format('d/m/Y');
    }
    private function backlogEnvioRegistrarSemDataEntrega($dadosnovos){
        $dadosantigo = $this->queryregisterenvio($dadosnovos['id']);

        $comando = "INSERT INTO BackLogRegisEnvio (idRegistroEnvio,campo,dados_antigo,dados_novo) 
        VALUES (".$dadosnovos['id'].",
        'Status | Codigo',
        '".$dadosantigo['status']." | ".$dadosantigo['CodigoPostagen']."',
        '".$dadosnovos['status']." | ".$dadosnovos['codigo']." ');
        INSERT INTO BackLogRegisEnvio (idRegistroEnvio,campo,dados_antigo,dados_novo) 
        VALUES (".$dadosnovos['id'].",'Observacao','".$dadosantigo['Observacao']."','".$dadosnovos['obs']."');
        ";

        $this->sql->query($comando);   

    }
    private function backlogEnvioRegistrarComDataEntrega($dadosnovos){

        $dadosantigo = $this->queryregisterenvio($dadosnovos['id']);

        $dadosnovos['datapostagem'] = $this->formatDate($dadosnovos['datapostagem']);
        $dadosantigo['DataPostagem'] = $this->formatDate($dadosantigo['DataPostagem']);
         


        $comando = "INSERT INTO BackLogRegisEnvio (idRegistroEnvio,campo,dados_antigo,dados_novo) 
        VALUES (".$dadosnovos['id'].",
        'Status | data | Codigo',
        '".$dadosantigo['status']."| ".$dadosantigo['DataPostagem']." | ".$dadosantigo['CodigoPostagen']."',
        '".$dadosnovos['status']."| ".$dadosnovos['datapostagem']."  | ".$dadosnovos['codigo']."');

        INSERT INTO BackLogRegisEnvio (idRegistroEnvio,campo,dados_antigo,dados_novo)
        VALUES (".$dadosnovos['id'].",'Observacao','".$dadosantigo['Observacao']."','".$dadosnovos['obs']."');
        ";

        $this->sql->query($comando);   

    }
    public function AtualizaCodigoRementeEncomendaData($dados)
    {
        if ($dados['datapostagem'] == "") {

            $this->backlogEnvioRegistrarSemDataEntrega($dados);

            $comando = ("UPDATE RegistroEncomendaEnvioCorreio SET 
            idstatusentrega = (SELECT idstatusentrega FROM statusentrega WHERE descstatusentrega = '" . $dados['status'] . "' ),
            codigopostagem = '" . $dados['codigo'] . "',
            observacaoenvio = '" . $dados['obs'] . "'
            WHERE idRegistroEncomendaEnvioCorreio = '" . $dados['id'] . "';");

        } else {

           

            $this->backlogEnvioRegistrarComDataEntrega($dados);

            $comando = ("UPDATE RegistroEncomendaEnvioCorreio SET 
            idstatusentrega = (SELECT idstatusentrega FROM statusentrega WHERE descstatusentrega = '" . $dados['status'] . "'),
            codigopostagem = '" . $dados['codigo'] . "',
            datapostagem = '" . $dados['datapostagem'] . "',
            observacaoenvio = '" . $dados['obs'] . "'
            WHERE idRegistroEncomendaEnvioCorreio = " . $dados['id'] . ";");
        }
        $this->sql->query($comando);
    }

    private function Requisitar_Qtd_Dados_Por_Status(){

        $ResultadoFormatado = array();

        $resultado = $this->sql->select("SELECT descstatusentrega, COUNT(RegistroEncomendaEnvioCorreio.idRegistroEncomendaEnvioCorreio) AS 'qtd' FROM statusentrega 
        LEFT JOIN RegistroEncomendaEnvioCorreio On RegistroEncomendaEnvioCorreio.idstatusentrega = statusentrega.idstatusentrega
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
