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
  

    public function insertEntrada($setor, $encomenda, $code, $remetente, $datacoleta, $obs)
    {

        $salva = false;

        if (strlen($code) == 0 || strlen($remetente) == 0 || $setor == 'null' || $encomenda == 'null') {
            echo '<script> alert("Contém campo sem preencher");</script>';
            $salva = false;
        } else {
            // $idgrupo = $this->group->sectorAndDateSearchid($setor,$datacoleta);
            $idsetor = $this->objectSector->SearchSector($setor);
            $idusuario = $this->objectUser->loadByIdUsuario($_SERVER['REMOTE_ADDR']);
            $idusuario['idusuario'];
            $idencomenda = $this->encomenda->Searchcencomenda($encomenda);
            $idstatus =  $this->statusentrega->Searchcstatusentrega('Pendente');

            $this->objectRegister->insertregistro($code, $remetente, $idencomenda, $idusuario['idusuario'], $idsetor, $idstatus, $obs, $datacoleta);
            $salva = true;
        }
        return $salva;
    }

    #dados que estão entrando na empresa
    public function insertEnvio($setor, $encomenda,$tipoenvio, $func, $cep, $rua, $num, $bairro, $cidade, $uf, $complementar, $obs)
    {
        $salva = false;

        if (strlen($rua) == 0 || strlen($cidade) == 0 || strlen($bairro) == 0 || strlen($num) == 0 || strlen($func) == 0 || strlen($cep) == 0 || $setor == 'null' || $encomenda == 'null' || $uf == 'null' || $tipoenvio == 'null') {
            echo '<script> alert("Contém campo sem preencher");</script>';
            $salva = false;
        } else {
            $idusuario = $this->objectUser->loadByIdUsuario($_SERVER['REMOTE_ADDR']);
            $idencomenda = $this->encomenda->Searchcencomenda($encomenda);
            $idsetor = $this->objectSector->SearchSector($setor);
            $status = $this->statusentrega->Searchcstatusentrega("Pendente");
            $tipoenvio = $this->objectEnvio->Searchctipoenvio($tipoenvio);
            //$idusuario,$setor,$encomenda,$func,$cep,$num,$bairro,$cidade,$uf,$complementar,$obs
            $this->RegistroEnvioEncomenda->insertRegisterEnvio($tipoenvio,$status,$idusuario['idusuario'], $idsetor, $idencomenda, $func, $cep, $rua, $num, $bairro, $cidade, $uf, $complementar, $obs);
            $salva = true;
        }
        return $salva;
    }

    #Toda vez que um usuario novo loga no sistema, o ip fica salvo
    public function IpSearch()
    {
        $x = $this->objectUser->loadByIdUsuario($_SERVER['REMOTE_ADDR']);
        if ($x['nome'] == '') {
            echo 'Não encontrado';
        } else {
            echo '<strong> Usuario:</strong> ' . $x['nome'] . '<br>';
            echo '<strong> IP:</strong> ' . $x['ipcomputador'] . '<br>';
            echo '<strong> Setor:</strong> ' . $this->objectSector->searchsectorid($x['setor']);
        }
    }

    #print a listga de setores na tag option
    public function listasetoropcoes(){
        $x = $this->objectSector->listSectordesc();
        $this->impressoption($x);
    }
    public function listatipodeenvio(){
        $x = $this->objectEnvio->listctipoenvio();
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
    public function listaencomenda(){
        $lista = $this->encomenda->listcencomenda();
        $this->impressoption($lista);
    }
    public function impressoption($x){
        foreach ($x as $row) {
            echo '<option value="' . $row . '">' . $row . '</option>';
        }
    }
    #imprime a lista de registros
    public function impress($x, $s)
    {
        if (count($x) == 0) {
            echo '<tr>
            
            <td colspan="11" style="text-align:center;">Sem informação</td>
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
                            echo '<td ><span class="badge badge-danger status">' .  $value . '</span></td>';
                        } else if ($value == 'Entregue') {
                            echo '<td ><span class="badge badge-success status">' . $value . '</span></td>';
                        } else if ($value == 'Negado') {
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
    #Faz a busca no banco
    public function SearchRelatorio($sector, $busca, $DateStart, $DateEnd)
    {
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
        $this->impress($x, 'e');
    }

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

    public function listagrupopendente()
    {
        $listaPendente = $this->objectRegister->listGroupPendente();
        $this->impress($listaPendente, 'ee');
    }
    public function buttonadmin(){
        $x = $this->objectUser->loadByIdUsuario($_SERVER['REMOTE_ADDR']);
        if ($x['nivel'] == 1) {
            echo '<a href="index_Admin.php" class="btn btn-light buttons">Administrador</a>';
        }
    }
   
    public function alterarstatusentrega($dados){
        $idregistro = array();


        foreach ($dados as $key => $value) {
            if ($key == 'status') {
                $status = $this->statusentrega->Searchcstatusentrega($value);
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
        else if($this->nivelusuario == 1 || $this->nivelusuario == 2 || $this->nivelusuario == 3){
            echo '<script>alert("Sem Autorização")</script>';
        }
        else{
            
            foreach ($idregistro as $value) {
                echo '<br>'.$value;
                $this->objectRegister->updateregistro($status,$dataentrega,$value);
            }
        }

      
    }

    public function SalvaRegistroEnvio($id,$status,$codigo,$data,$obs){
        $status = $this->statusentrega->Searchcstatusentrega($status);
        // echo $id . '<br>';
        // echo $status . '<br>';
        // echo $codigo . '<br>';
        // echo $data . '<br>';
        // echo $encomenda . '<br>';
        // echo $obs . '<br>';

        if($this->nivelusuario == 1 || $this->nivelusuario == 2  || $this->nivelusuario == 3 ){
            $this->RegistroEnvioEncomenda->AtualizaCodigoRementeEncomendaData($id,$status,$codigo,$data,$obs);

        }
        else{
            echo 'sem autorização';
        }
    }
}
