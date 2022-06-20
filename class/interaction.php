<?php
class interaction
{
    private $objectSector = array();
    private $objectUser = array();
    private $objectRegister = array();
    private $group = array();
    private $encomenda = array();
    private $statusentrega = array();
    private $RegistroEnvioEncomenda = array();
    
    public function __construct()
    {

        $this->objectSector = new setor();
        $this->objectUser = new usuario();
        $this->objectRegister = new registro();
        $this->group = new grupo();
        $this->encomenda = new encomenda();
        $this->statusentrega = new statusentrega();
        $this->RegistroEnvioEncomenda = new registroEnvio();
    }
    
    
    public function insertEntrada($setor,$encomenda,$code,$remetente,$datacoleta,$obs){
        
        $salva = false;
    
        if (strlen($code) == 0 || strlen($remetente) == 0 || $setor == 'null' || $encomenda == 'null') {
            echo '<script> alert("Contém campo sem preencher");</script>';
            $salva = false;
        }
        else{
            $idgrupo = $this->group->sectorAndDateSearchid($setor,$datacoleta);
            $idusuario = $this->objectUser->loadByIdUsuario($_SERVER['REMOTE_ADDR']);
            $idencomenda = $this->encomenda->Searchcencomenda($encomenda);
     $this->objectRegister->insertregistro($code,$remetente,$idencomenda,$idgrupo,$idusuario['idusuario'],$obs);
            $salva = true;
        }
        return $salva;
    }

    #dados que estão entrando na empresa
    public function insertEnvio($setor,$encomenda,$func,$cep,$rua,$num,$bairro,$cidade,$uf,$complementar,$obs){
        $salva = false;
    
        if (strlen($cidade) == 0 || strlen($bairro) == 0 || strlen($num) == 0 || strlen($func) == 0 || strlen($cep) == 0 || $setor == 'null' || $encomenda == 'null' || $uf == 'null') {
            echo '<script> alert("Contém campo sem preencher");</script>';
            $salva = false;
        }
        else{
            $idusuario = $this->objectUser->loadByIdUsuario($_SERVER['REMOTE_ADDR']);
            $idencomenda = $this->encomenda->Searchcencomenda($encomenda);
            $idsetor = $this->objectSector->SearchSector($setor);
            //$idusuario,$setor,$encomenda,$func,$cep,$num,$bairro,$cidade,$uf,$complementar,$obs
            $this->RegistroEnvioEncomenda->insertRegisterEnvio($idusuario['idusuario'],$idsetor,$idencomenda,$func,$cep,$rua,$num,$bairro,$cidade,$uf,$complementar,$obs);
            $salva = true;
        }
    return $salva;
    }

    #Toda vez que um usuario novo loga no sistema, o ip fica salvo
    public function IpSearch(){
        $x = $this->objectUser->loadByIdUsuario($_SERVER['REMOTE_ADDR']);
        if ($x['nome'] == '') {
            echo 'Não encontrado';
        } else {
            echo '<strong> Usuario:</strong> ' . $x['nome'] . '<br>';
            echo '<strong> IP:</strong> ' . $x['ipcomputador']. '<br>';
            echo '<strong> Setor:</strong> ' . $this->objectSector->searchsectorid($x['setor']);
        }
    }
    
    #print a listga de setores na tag option
    public function listasetoropcoes(){
        $x = $this->objectSector->listSector();
        foreach ($x as $row) {
            echo '<option value="'.$row['descsetor'].'">'.$row['descsetor'].'</option>';
        }
    }
    public function grupopendente(){
        $pendente = $this->group->idgroupPending();
        $this->impressoption($pendente);
    }
    public function listaDeStatus(){
        $lista = $this->statusentrega->listcstatusentrega();
        $this->impressoption($lista);
        
    }
    public function listaencomenda(){
        $lista = $this->encomenda->listcencomenda();
        $this->impressoption($lista);
    }
    public function impressoption($x){
        foreach ($x as $row) {
            echo '<option value="'.$row.'">'.$row.'</option>';
        }
    }
    #imprime a lista de registros
    public function impress($x,$s){
        if (count($x) == 0) {
            echo '<tr>
            <script>alert("Busca Não Encontrada")</script>
            <td colspan="10" style="text-align:center;">Sem informação</td>
            </tr>';
        } else {
          
            foreach ($x as $row) {
                echo '<tr>'; 
                foreach ($row as $key => $value) {
                    if ($key == 'dataregistro') {
                        $date = new DateTime($value);
                        $value = $date->format('d/m/Y H:i:s');
                        echo '<td>' . $value . '</td>';
                    }
                    
                    else if ($key == 'dataentregasetor') {
                        if($value == ''){
                            echo '<td></td>';
                        }
                        else{
                            $date = new DateTime($value);
                            $value = $date->format('d/m/Y H:i:s');
                            echo '<td>' . $value . '</td>';
                        }
                    }
                    else if ($key == 'datacoleta' || $key == 'datapostagem') {
                        if($value == ''){
                            echo '<td></td>';
                        }
                        else{
                            $date = new DateTime($value);
                            $value = $date->format('d/m/Y');
                            echo '<td>' . $value . '</td>';
                        }
                    }
                    
                    
                    else if ($key == 'descstatusentrega') {
                        if($value == 'Pendente'){
                            echo '<td ><span class="badge badge-danger status">' .  $value . '</span></td>';
                        }
                        else if($value == 'Entregue'){
                            echo '<td ><span class="badge badge-success status">' . $value . '</span></td>';
                        }
                        else if($value == 'Negado'){
                            echo '<td ><span class="badge badge-warning status">' . $value . '</span></td>';
                        }
                    }

                    else{
                        echo '<td style="align-text:center;">'.$value.'</td>';
                    }

                }
                
                
            
                if($s == 'e'){

                    echo '<td>
                    <a class="btn btn-outline-primary" href="index_viewCorreio.php?type=e&cod='.$row['id'].'">View</a>
                    </td>';
                }
                if($s == 's'){

                    echo '<td>
                    <a class="btn btn-outline-primary" href="index_view.php?type=s&cod='.$row['id'].'">View</a>
                    </td>';
                }
                if($s == 'ee'){

                    echo '<td>
                    <a class="btn btn-outline-primary" href="index_viewCorreio.php?type=ee&cod='.$row['id'].'">View</a>
                    </td>';
                }
                echo '</tr>';
            }
        }
    }
    #Faz a busca no banco
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
        } else if (($sector != 'all') && (strlen($busca) != 0)) {
            $x = $this->objectRegister->listDateSectorSearchQuery($sector, $busca, $DateStart, $DateEnd);
        }
        $this->impress($x,'e');
    }

    public function SearchRelatorioEnvio($sector, $busca, $DateStart, $DateEnd){
        if (($sector == 'all') && (strlen($busca) > 0)) {
            $x = $this->RegistroEnvioEncomenda->listDateCodeQueryEnvio($busca, $DateStart, $DateEnd);
        }
        #Busca sem setor e codigo, somente data
        else if ((($sector) == 'all') && (strlen($busca) == 0)) {
            $x = $this->RegistroEnvioEncomenda->listDateQueryRegistroenvio($DateStart,$DateEnd);
        }
        #busca somente de setores e data
        else if (($sector != 'all') && (strlen($busca) == 0)) {
            $x = $this->RegistroEnvioEncomenda->listDateSectorQueryEnvio($sector, $DateStart, $DateEnd);
        } else if (($sector != 'all') && (strlen($busca) != 0)) {
            $x = $this->RegistroEnvioEncomenda->listDateSectorSearchQueryEnvio($sector, $busca, $DateStart, $DateEnd);
        }
        $this->impress($x,'s');
    }
    # responsavel por imprimir os dados em na tela view

    #responsavel por inserir as informações no banco de dados e criar grupos
    public function listagrupopendente(){
        $listaPendente = $this->objectRegister->listGroupPendente();
        $this->impress($listaPendente,'ee');
    }
    
    public function alterarStatus($dataentrega,$idgroup,$status){
        $this->group->Savestatus($dataentrega,$idgroup,$status);
        header('Location: index.php');
    }
    public function buttonadmin(){
        $x = $this->objectUser->loadByIdUsuario($_SERVER['REMOTE_ADDR']);
        if($x['nivel']==1){
            echo '<a href="index_Admin.php" class="btn btn-light buttons">Administrador</a>';
        }
    }

}
