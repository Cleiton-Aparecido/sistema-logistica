<?php
class interaction
{
    private $objectSector = array();
    private $objectUser = array();
    private $objectRegister = array();
    private $objectEnvio = array();
    private $encomenda = array();
    private $statusentrega = array();
    private $RegistroEnvioEncomenda = array();
    private $nivelusuario;

    public function __construct()
    {
        $this->objectEnvio = new tipoEnvio();
        $this->objectSector = new setor();
        $this->objectUser = new usuario();
        $this->objectRegister = new registro();
        $this->encomenda = new encomenda();
        $this->statusentrega = new statusentrega();
        $this->RegistroEnvioEncomenda = new registroEnvio();
        $this->nivelusuario = $this->objectUser->level($_SERVER['REMOTE_ADDR']);
    }
    private function acessoAdmin(){
        if($this->nivelusuario == 1){
            
            return true;
        }else{
            return false;
        }
    }
    public function acessos($typeAcess){
        if($typeAcess == 'admin'){
            if(!$this->acessoAdmin()){
                echo $this->nivelusuario;
                header('Location: index.php');
            }
        }  
    }
    public function insertEntrada($dados){

        $salva = false;
        
        if ( strlen($dados['codigo']) == 0 || strlen($dados['remetente']) == 0 || $dados['setor'] == 'null' || $dados['encomenda'] == 'null') {
            echo '<script> alert("Contém campo sem preencher");</script>';
            $salva = false;
        } 
        else if($this->nivelusuario == 1  || $this->nivelusuario == 2 || $this->nivelusuario == 3 || $this->nivelusuario == 5){
            echo 'passou acesso';
            var_dump($dados);
            $this->objectRegister->insertregistro($dados);
            $salva = true;
        }
        else {
            echo '<script>alert("Acesso Negado") </script>';
            $salva = false;
        }
        return $salva;
    }
    #dados que estão entrando na empresa
    public function insertEnvio($dados){
        $salva = false;

        if (strlen($dados['endereco']) == 0 || strlen($dados['cidade']) == 0 || strlen($dados['bairro']) == 0 || strlen($dados['num']) == 0 || strlen($dados['funcionario']) == 0 || strlen($dados['cep']) == 0 || $dados['setor'] == 'null' || $dados['encomenda'] == 'null' || $dados['uf'] == 'null' || $dados['tipoenvio'] == 'null') {
            echo '<script> alert("Contém campo sem preencher");</script>';
            $salva = false;
        } else {            
            $idsalvo = $this->RegistroEnvioEncomenda->insertRegisterEnvio($dados);
            $salva = true;
        }
        return $idsalvo;
    }
    #Toda vez que um usuario novo loga no sistema, o ip fica salvo
    public function IpSearch(){
        $x = $this->objectUser->loadByIdUsuario($_SERVER['REMOTE_ADDR']);
        if ($x['nome'] == '') {
            echo 'Não encontrado';
        } else {
            echo '<strong> Usuario:</strong> ' . $x['nome'] . '<br>';
            echo '<strong> IP:</strong> ' . $x['ipcomputador'] . '<br>';
            echo '<strong> Setor:</strong> ' .  $x['setor'];
        }
    }
    #print a listga de setores na tag option
    public function listasetoropcoes($type){
        $x = array();
        if($type == 'ativo'){
            $x = $this->objectSector->listSectordescAtivo();
        }else if($type == 'geral'){
            $x = $this->objectSector->listSectordesc();
        }
        $this->impressoption($x);
    }
    public function listatipodeenvio($status){

        if($status == 'ativo'){
            $x = $this->objectEnvio->listctipoenvioAtivo();
        }else if($status == 'Geral'){
            $x = $this->objectEnvio->listctipoenvio();
        }
        

        $this->impressoption($x);
    }
    public function grupopendente(){
        $pendente = $this->group->idgroupPending();
        $this->impressoption($pendente);
    }
    public function listaDeStatus(){
        $lista = $this->statusentrega->listcstatusentrega();
        $this->impressoption($lista);
    }
    public function listaencomenda($type){
        if ($type == 'ativo') {
            $lista = $this->encomenda->listcencomendaAtivo();
        }
        else if($type == "Geral"){
            $lista = $this->encomenda->listcencomenda();
        
        }
        
        $this->impressoption($lista);
    }
    public function impressoption($x){
        foreach ($x as $row){
            echo '<option value="' . $row . '">' . $row . '</option>';
            // echo $row;
        }
    }
    #imprime a lista de registros
    public function impress($x, $s){
        if (count($x) == 0) {
            echo '<tr>
            
            <td colspan="12" style="text-align:center;">Sem informação</td>
            </tr>';
        } else {

            foreach ($x as $row) {
                echo '<tr>';
                if ($s == 'ee') {
                    echo "<td style='align-items: center;'>
                    <input type='checkbox' name='id:" . $row['id'] . "' value='" . $row['id'] . "' class='input_checkbox'>
                    </td>";
                }
                foreach ($row as $key => $value) {

                    if ($key == 'dataregistro') {
                        $date = new DateTime($value);
                        $value = $date->format('d/m/Y H:i:s');
                        echo '<td>' . $value . '</td>';
                    } else if ($key == 'dataentregasetor') {
                        if ($value == '') {
                            echo '<td></td>';
                        } else {
                            $date = new DateTime($value);
                            $value = $date->format('d/m/Y H:i:s');
                            echo '<td>' . $value . '</td>';
                        }
                    } else if ($key == 'datacoleta' || $key == 'datapostagem') {
                        if ($value == '') {
                            echo '<td></td>';
                        } else {
                            $date = new DateTime($value);
                            $value = $date->format('d/m/Y');
                            echo '<td>' . $value . '</td>';
                        }
                    } else if ($key == 'descstatusentrega') {
                        if ($value == 'Pendente') {
                            echo '<td ><span class="badge badge-info status">' .  $value . '</span></td>';
                        } else if ($value == 'Entregue') {
                            echo '<td ><span class="badge badge-success status">' . $value . '</span></td>';
                        } else if ($value == 'Negado') {
                            echo '<td ><span class="badge badge-danger status">' . $value . '</span></td>';
                        }
                        else{
                            echo '<td ><span class="badge badge-warning status">' . $value . '</span></td>';
                        }
                    } else {
                        echo '<td style="align-text:center;">' . $value . '</td>';
                    }
                }



                if ($s == 'e') {

                    echo '<td>
                    <a class="btn btn-outline-primary" href="index_view.php?type=e&cod=' . $row['id'] . '">View</a>
                    </td>';
                }
                if ($s == 's') {

                    echo '<td>
                    <a class="btn btn-outline-primary" href="index_view.php?type=s&cod=' . $row['id'] . '">View</a>
                    </td>';
                }
                if ($s == 'ee') {

                    echo '<td>
                    <a class="btn btn-outline-primary" href="index_viewCorreio.php?type=ee&cod=' . $row['id'] . '">View</a>
                    </td>';
                }
                echo '</tr>';
            }
        }
    }
    #consultar lista de coleta de item
    public function SearchRelatorio($sector, $busca, $DateStart, $DateEnd){
       
        #Busca para todos setores e com codigo expecifico
        if (($sector == 'all') && (strlen($busca) > 0)) {
            $x = $this->objectRegister->listDateCodeQuery($busca, $DateStart, $DateEnd);
        }
        #Busca sem setor e codigo, somente data
        else if ((($sector) == 'all') && (strlen($busca) == 0)) {
            $x = $this->objectRegister->listDateQueryRegistro($DateStart, $DateEnd);
        }
        #busca somente de setores e data
        else if (($sector != 'all') && (strlen($busca) == 0)) {
            $x = $this->objectRegister->listDateSectorQuery($sector, $DateStart, $DateEnd);
        } 
        else if (($sector != 'all') && (strlen($busca) != 0)) {
            $x = $this->objectRegister->listDateSectorSearchQuery($sector, $busca, $DateStart, $DateEnd);
        }
        $this->impress($x, 'e');
    }
    #consultar lista de envio
    public function SearchRelatorioEnvio($sector, $busca, $DateStart, $DateEnd){
    

        if (($sector == 'all') && (strlen($busca) > 0)) {
            $x = $this->RegistroEnvioEncomenda->listDateCodeQueryEnvio($busca, $DateStart, $DateEnd);
        }
        #Busca sem setor e codigo, somente data
        else if ((($sector) == 'all') && (strlen($busca) == 0)) {
            $x = $this->RegistroEnvioEncomenda->listDateQueryRegistroenvio($DateStart, $DateEnd);
        }
        #busca somente de setores e data
        else if (($sector != 'all') && (strlen($busca) == 0)) {
            $x = $this->RegistroEnvioEncomenda->listDateSectorQueryEnvio($sector, $DateStart, $DateEnd);
        } else if (($sector != 'all') && (strlen($busca) != 0)) {
            $x = $this->RegistroEnvioEncomenda->listDateSectorSearchQueryEnvio($sector, $busca, $DateStart, $DateEnd);
        }
        $this->impress($x, 's');
    }
    public function listagrupopendente(){
        $listaPendente = $this->objectRegister->listGroupPendente();
        $this->impress($listaPendente, 'ee');
    }
    public function buttonadmin(){
        $x = $this->objectUser->loadByIdUsuario($_SERVER['REMOTE_ADDR']);
        if ($x['nivel'] == 1) {
            echo '<a href="index_Admin.php" class="btn btn-light buttons">Administrador</a>';
        }
    }
    // Alterar status de POS que chegou do ROSARIO para os Setores
    public function alterarstatusentrega($dados){
        $idregistro = array();

        // Organizando informações em variaveis
        foreach ($dados as $key => $value) {
            if ($key == 'status') {
                $status = $value;
            } elseif ($key == 'dataentrega') {
                $dataentrega = $value;
            } else {
                array_push($idregistro, $value);
            }
        }
        if($status == 'Pendente' || count($idregistro) == 0 ){
            echo '<script>alert("Parametros Invalidoa")</script>';
        }
        // $_SERVER['REMOTE_ADDR']
        else if( $this->nivelusuario == 2 || $this->nivelusuario == 3){
            echo '<script>alert("Sem Autorização")</script>';
        }
        else{
                       
            foreach ($idregistro as $value) {
                $dados = array(
                    "dataentrega"=>$dataentrega,
                    "status"=>$status,
                    "id"=>$value
                );
                $this->objectRegister->updateregistro($dados);
            }
        }

      
    }
    //Alterar informações do registro das encomendas que foi enviada para setor de correios para realizar o envio
    public function SalvaRegistroEnvio($dados){
            if($this->nivelusuario == 1 || $this->nivelusuario == 2  || $this->nivelusuario == 3 ){
            $this->RegistroEnvioEncomenda->AtualizaCodigoRementeEncomendaData($dados);

        }
        else{
            echo 'sem autorização';
        }
    }

    public function comprovante($id){
       return  $this->RegistroEnvioEncomenda->queryregisterenvio($id);
    }
}
