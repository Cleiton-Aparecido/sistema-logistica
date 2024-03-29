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
    private $dadosusuario_acesso;

    public function __construct()
    {
        $this->objectEnvio = new tipoEnvio();
        $this->objectSector = new setor();
        $this->objectUser = new usuario();
        $this->objectRegister = new registro();
        $this->encomenda = new encomenda();
        $this->statusentrega = new statusentrega();
        $this->RegistroEnvioEncomenda = new registroEnvio();
        $this->dadosusuario_acesso = $this->objectUser->loadByIpUsuario($_SERVER['REMOTE_ADDR']);
    }
    public function getdadosusuario_acesso()
    {
        return $this->dadosusuario_acesso;
    }
    public function setdadosusuario_acesso($value)
    {
        $this->dadosusuario_acesso = $value;
    }
    public function buttonadmin()
    {
        $dadosusuario_acesso = $this->getdadosusuario_acesso();

        if (in_array("administrador", $dadosusuario_acesso['acessos'])) {
            echo '<a href="index_Admin.php" class="buttons">Administrador</a>';
        }
    }
    public function direito()
    {
        echo '<footer style="text-align: center; color:cadetblue;">&copyCleiton Fonseca - Versão Para Teste</footer>';
    }

    public function acessos($tipo_de_acesso)
    {
        $dadosusuario_acesso = $this->getdadosusuario_acesso();

        if ($tipo_de_acesso == 'administrador') {
            if (!in_array("administrador", $dadosusuario_acesso['acessos'])) {

                header('Location: index.php');
            }
        } else if ($tipo_de_acesso == 'entrega-setor') {
            if (!in_array("entrega-setor", $dadosusuario_acesso['acessos'])) {

                header('Location: index.php');
            }
        } else if ($tipo_de_acesso == 'novo-registro') {
            if (!in_array("novo-envio", $dadosusuario_acesso['acessos']) && !in_array("novo-entrada", $dadosusuario_acesso['acessos'])) {
                header('Location: index.php');
            }
        }
    }

    public function menulateral()
    {
        $dadosusuario_acesso = $this->getdadosusuario_acesso();
        echo '<style type="text/css">';
        include('../css/style.css');
        echo '</style>';

        echo '<div id="mySidenav" class="sidenav">';
        echo '<h3 class="titulo_menulateral">Usuario</h3>';
        echo '<article id="container_user">';
        echo '<div id="inf_user">';
        $this->IpSearch();
        echo '</div>';
        echo '</article>';

        echo '<h3 style="margin-top:40px;" class="titulo_menulateral">Menu Opções</h3>';

        echo '<span href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</span>';

        echo '<a href="index.php" class="buttons"><img src="../img/simbolo_entrada.svg">Entrada de Encomendas</a>';

        echo '<a href="index_envio.php" class="buttons"><img src="../img/simbolo_envio.svg">Envio de Encomendas</a>';

        if (in_array("entrega-setor", $dadosusuario_acesso['acessos'])) {
            echo '<a href="index_entrega.php" class="buttons"><img src="../img/simbolo_entregue_setor.png">Entregue aos Setores</a>';
        }
        if (in_array("novo-envio", $dadosusuario_acesso['acessos']) || in_array("novo-entrada", $dadosusuario_acesso['acessos'])) {
            echo '<a href="index_newRegister.php" class="buttons"><img style="margin-left:1px;" src="../img/533864.png">Novo Registro</a>';
        }

        echo '<a href="monitorLogistica.php" class="buttons"><img style="margin-left:1px;" src="../img/television.webp">Monitor</a>';

        $this->buttonadmin();
        echo '</div>';

        echo '<span class="opcaomenulateral" onclick="openNav()">&#9776; Menu Opções</span>';


        echo '<script>';


        echo 'function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("mySidenav").style.border = "5px solid rgba(0, 0, 0, 0.159)";
            document.getElementById("mySidenav").style.borderRadius = "0px 20px 20px 0px";


          }
          
          function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("mySidenav").style.border = "0px solid rgba(0, 0, 0, 0.159)";
          }';
        echo '</script>';
    }
    #Toda vez que um usuario novo loga no sistema, o ip fica salvo
    public function IpSearch()
    {

        $dadosusuario_acesso = $this->getdadosusuario_acesso();
        if ($dadosusuario_acesso['nome'] == '') {
            echo 'Não encontrado';
        } else {
            echo '<strong> Usuario:</strong> ' . $dadosusuario_acesso['nome'] . '<br>';
            echo '<strong> IP:</strong> ' . $dadosusuario_acesso['ipcomputador'] . '<br>';
            echo '<strong> Setor:</strong> ' .  $dadosusuario_acesso['setor'];
        }
    }


    public function insertEntrada($dados)
    {
        $dadosusuario_acesso = $this->getdadosusuario_acesso();
        $salva = false;

        if (strlen($dados['codigo']) == 0 || strlen($dados['remetente']) == 0 || $dados['setor'] == 'null' || $dados['encomenda'] == 'null') {
            echo '<script> alert("Contém campo sem preencher");</script>';
            $salva = false;
        } else if (in_array("novo-entrada", $dadosusuario_acesso['acessos'])) {
            $salva =  $this->objectRegister->insertregistro($dados);
        } else {
            echo '<script>alert("Acesso Negado") </script>';
            $salva = false;
        }
        return $salva;
    }

    #dados que estão entrando na empresa
    public function insertEnvio($dados)
    {
        $dadosusuario_acesso = $this->getdadosusuario_acesso();

        if (strlen($dados['endereco']) == 0 || strlen($dados['cidade']) == 0 || strlen($dados['bairro']) == 0 || strlen($dados['num']) == 0 || strlen($dados['funcionario']) == 0 || strlen($dados['cep']) == 0 || $dados['setor'] == 'null' || $dados['encomenda'] == 'null' || $dados['uf'] == 'null' || $dados['tipoenvio'] == 'null') {

            echo '<script> alert("Contém campo sem preencher");</script>';

        } else if (in_array("novo-envio", $dadosusuario_acesso['acessos'])) {

            $retornoinsert = $this->RegistroEnvioEncomenda->insertRegisterEnvio($dados);

            if (!$retornoinsert) {
                return false;
            } else {
                return $retornoinsert;
            }
        } 
    }

    #print a listga de setores na tag option
    public function listasetoropcoes($type)
    {
        $x = array();
        if ($type == 'ativo') {
            $x = $this->objectSector->listSectordescAtivo();
        } else if ($type == 'Geral') {
            $x = $this->objectSector->listSectordesc();
        }
        $this->impressoption($x);
    }
    public function listatipodeenvio($status)
    {

        if ($status == 'ativo') {
            $x = $this->objectEnvio->listctipoenvioAtivo();
        } else if ($status == 'Geral') {
            $x = $this->objectEnvio->listctipoenvio();
        }


        $this->impressoption($x);
    }
    public function grupopendente()
    {
        $pendente = $this->group->idgroupPending();
        $this->impressoption($pendente);
    }
    public function listaDeStatus()
    {
        $lista = $this->statusentrega->listcstatusentrega();
        $this->impressoption($lista);
    }
    public function listaencomenda($type)
    {
        if ($type == 'ativo') {
            $lista = $this->encomenda->listcencomendaAtivo();
        } else if ($type == "Geral") {
            $lista = $this->encomenda->listcencomenda();
        }

        $this->impressoption($lista);
    }
    public function impressoption($x)
    {
        foreach ($x as $row) {
            echo '<option value="' . $row . '">' . $row . '</option>';
        }
    }
    #imprime a lista de registros
    public function impress($x, $s)
    {
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
                        } else {
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
                    <a class="btn btn-outline-primary" href="index_view.php?type=e&cod=' . $row['id'] . '">View</a>
                    </td>';
                }
                echo '</tr>';
            }
        }
    }
    #consultar lista de coleta de item
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
    #consultar lista de envio
    public function SearchRelatorioEnvio($sector, $busca, $DateStart, $DateEnd)
    {


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

    // Alterar status de POS que chegou do ROSARIO para os Setores
    public function alterarstatusentrega($dados)
    {
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
        if ($status == 'Pendente' || $status == 'Preparo' || count($idregistro) == 0) {
            echo '<script>alert("Parametros Invalidoa")</script>';
        } else if ($this->nivelusuario == 2 || $this->nivelusuario == 3) {
            echo '<script>alert("Sem Autorização")</script>';
        } else {

            foreach ($idregistro as $value) {
                $dados = array(
                    "dataentrega" => $dataentrega,
                    "status" => $status,
                    "id" => $value
                );
                $this->objectRegister->updateregistro($dados);
            }
            header('Location: index.php');
        }
    }
    //Alterar informações do registro das encomendas que foi enviada para setor de correios para realizar o envio


    public function comprovante($id)
    {
        return  $this->RegistroEnvioEncomenda->queryregisterenvio($id);
    }

    public function acesso_novo_registro()
    {

        $dadosusuario_acesso = $this->getdadosusuario_acesso();

        if (in_array("novo-envio", $dadosusuario_acesso['acessos'])) {

            echo "<input type='radio' id='envio' onclick='requisitarPaginaenvio()' name='tiporegistro' value='envio'>
            <label for='envio'>Envio de Encomenda</label><br>";

            echo " 
            <script>
            function requisitarPaginaenvio() {
                document.getElementById('form_new_js').innerHTML = ''
                let imgLoading = document.createElement('img')
                imgLoading.id = 'loading';
                imgLoading.src = '../img/loading.gif';
                imgLoading.className = 'rounded mx-auto d-block'
                imgLoading.style.width = '70px';
                document.getElementById('form_new_js').appendChild(imgLoading);
                let ajax = new XMLHttpRequest();
                var url = '../php/pacote/envio.php'
                ajax.open('GET', url)
                ajax.onreadystatechange = () => {
            
                    if (ajax.readyState == 4 && ajax.status == 200) {
            
                        document.getElementById('form_new_js').innerHTML = ajax.responseText
            
            
                    } else if (ajax.readyState == 4 && ajax.status == 404) {
                        callbackErro();
                    }
                }
                ajax.send()
        
        } </script>";
        }
        if (in_array("novo-entrada", $dadosusuario_acesso['acessos'])) {

            echo "<input type='radio' id='entrada'  onclick='requisitarPaginaentrada()' name='tiporegistro' value='entrada'>
            <label for='entrada'>Entrada de Encomenda</label><br>";

            echo " 
            <script>
            function requisitarPaginaentrada() {
                document.getElementById('form_new_js').innerHTML = ''
                let imgLoading = document.createElement('img')
                    imgLoading.id = 'loading';
                    imgLoading.src = '../img/loading.gif';
                    imgLoading.className = 'rounded mx-auto d-block'
                    imgLoading.style.width = '70px';
                    document.getElementById('form_new_js').appendChild(imgLoading);
            
                let ajax = new XMLHttpRequest();
                var url = '../php/pacote/entrada.php'
                ajax.open('GET', url)
                ajax.onreadystatechange = () => {
            
                    if (ajax.readyState == 4 && ajax.status == 200) {
            
                        document.getElementById('form_new_js').innerHTML = ajax.responseText
            
            
                    } else if (ajax.readyState == 4 && ajax.status == 404) {
                        callbackErro();
                    }
                }
                ajax.send()
            
            } </script>";
        }
    }
}
