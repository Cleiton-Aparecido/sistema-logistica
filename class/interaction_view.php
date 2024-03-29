<?php
require_once("config.php");
class interaction_view extends interaction
{
    private $objectSector = array();
    private $objectUser = array();
    private $objectRegister = array();
    private $encomenda = array();
    private $statusentrega = array();
    private $RegistroEnvioEncomenda = array();
    private $dadosusuario_acesso;

    public function __construct()
    {
        $this->objectSector = new setor();
        $this->objectUser = new usuario();
        $this->objectRegister = new registro();
        $this->encomenda = new encomenda();
        $this->statusentrega = new statusentrega();
        $this->RegistroEnvioEncomenda = new registroEnvio();
        $this->dadosusuario_acesso = $this->objectUser->loadByIpUsuario($_SERVER['REMOTE_ADDR']);
      
    }
    public function getdadosusuario_acesso(){
        return $this->dadosusuario_acesso;
    }
    public function setdadosusuario_acesso($value){
        $this->dadosusuario_acesso = $value;
    }
        
    public function updateregistroentrada($dados){
        $dadosusuario_acesso = $this->getdadosusuario_acesso();
        
        if(in_array("editar-registro-entrada",$dadosusuario_acesso['acessos'])){
            $this->objectRegister->atualizar_informacoes_registro($dados);
        }
        else{
            echo 'sem acesso';
        }
    }

    public function AccessToEditButton(){
        $dadosusuario_acesso = $this->getdadosusuario_acesso();
        if(in_array("editar-registro-entrada",$dadosusuario_acesso['acessos'])){
            return true;
        }
        else{
            return false;
        }
    }

    private function impresshistorico($historico){
        echo "<span class='grid-item cabecalho-grid' style='border-left-radius: 10px;'>";
        echo "Data e Hora Alteração";
        echo "</span>";
        echo "<span class='grid-item cabecalho-grid'>";
            echo "Campos de Alterações";
        echo "</span>";
        echo "<span class='grid-item cabecalho-grid'>";
            echo "Dados Antigos";
        echo "</span>";
        echo "<span class='grid-item cabecalho-grid'>";
            echo "Dados Salvos";
        echo "</span>";
        foreach ($historico as $key => $value) {
            
            echo "<span class='grid-item'>";
                echo  $value['Datahora'];
            echo "</span>";
            echo "<span class='grid-item'>";
                echo $value['campo'];
            echo "</span>";
            echo "<span class='grid-item'>";
                echo $value['dadosantigo'];
            echo "</span>";
            echo "<span class='grid-item'>";
                echo $value['dadosnovo'];
            echo "</span>";
            
        }
    }

    public function historicoentrada($id){
    $historico =  $this->objectRegister->requisitarhistorico($id);
    $this->impresshistorico($historico);
    }    
    public function historicoenvio($id){
    $historico =  $this->RegistroEnvioEncomenda->requisitarhistorico($id);
    $this->impresshistorico($historico);
    }    
    
    public function dadosViewEntrada($id){
        $x = $this->objectRegister->queryRegistro($id);
        echo '<script>document.getElementById("voltar").</script>';
        foreach ($x as $key => $value) {
            if ($key == 'Status') {
               
                if ($value == 'Pendente') {
                    echo '<p><strong> ' . $key . ': </strong><span class="badge badge-danger status">' .  $value . '</span></p>';
                } else if ($value == 'Entregue') {
                    echo '<p><strong> ' . $key . ': </strong><span class="badge badge-success status">' . $value . '</span></p>';
                } else if ($value == 'Negado') {
                    echo '<p><strong> ' . $key . ': </strong><span class="badge badge-warning status">' . $value . '</span></p>';
                }
            } else if ($key == 'Data Registro') {
                $date = new DateTime($value);
                $value = $date->format('d/m/Y H:i:s');
                echo '<p><strong> ' . $key . ':</strong> ' . $value . '</p>';
            } else if ($key == 'Data Coleta') {
                $date = new DateTime($value);
                $value = $date->format('d/m/Y');
                echo '<p><strong> ' . $key . ':</strong> ' . $value . '</p>';
            } else if ($key == 'Data Entrega Setor') {
                if ($value == '') {
                } else {
                    $date = new DateTime($value);
                    $value = $date->format('d/m/Y H:i:s');
                    echo '<p><strong> ' . $key . ':</strong> ' . $value . '</p>';
                }
            }  else {
                echo '<p><strong> ' . $key . ':</strong> ' . $value . '</p>';
            }
        }
    }
    public function SalvaRegistroEnvio($dados)
    {
        $dadosusuario_acesso = $this->getdadosusuario_acesso();
        if (in_array("editar-registro-envio",$dadosusuario_acesso['acessos']) ) {
            $this->RegistroEnvioEncomenda->AtualizaCodigoRementeEncomendaData($dados);
        } else {
            echo 'sem autorização';
        }
    }
    public function dadosViewEnvio($id, $tipo)
    {
        
        if ($tipo == 's') {
            echo "<script> document.getElementById('title').innerHTML='Registro do Envio' </script>";
            echo "<script> document.getElementById('titulocabecalho').innerHTML='Registro do Envio' </script>";
            $date =  $this->RegistroEnvioEncomenda->queryregisterenvio($id);
            $this->viewandconfiguration($date,$tipo);
        }
        if ($tipo == 'e') {
            echo "<script> document.getElementById('title').innerHTML='Registro de entrada' </script>";
            echo "<script> document.getElementById('titulocabecalho').innerHTML='Registro de entrada' </script>";
            $dados = $this->objectRegister->queryRegistro($id);
            $this->viewandconfiguration($dados,$tipo);
        }
    }
    

    private function viewandconfiguration($date,$type)
    {
        $dadosusuario_acesso = $this->getdadosusuario_acesso();
        $editar_registro = null;

        if (!in_array("editar-registro-envio",$dadosusuario_acesso['acessos'])) { 
            $editar_registro = "disabled"; 
        }
        
        if(!isset($date['id'])){
            echo '<div class="container_view">
                   <h1> Não encontrado na base de dados </h1>   
                    ';
    
    
            echo '</div>';
        }
        else {
            
            
            
    
            if($type == 's'){
                echo '<div class="container_view">';
               
                echo '
                        
                        <label for="idregistro">ID Registro:</label>
                        <input type="text" id="idregistro" name="idregistro" class="form-control input_view" value="' . $date['id'] . '"disabled>
        
                        
        
                        <label for="Ipusuario">IP Computador:</label>
                        <input type="text" id="Ipusuario" name="Ipusuario" class="form-control input_view" value="' . $date['Ipusuario'] . '" disabled>

                        <label for="funcionario">Funcionário que Solicitou:</label>
                        <input type="text" id="funcionario" name="funcionario" class="form-control input_view" value="' . $date['funcionario'] . '" disabled>
    

                        <label for="setor">Setor Que Solicitou:</label>
                        <input type="text" id="setor" name="setor" class="form-control input_view" value="' . $date['SetorRementente'] . '" disabled>
                    ';
                echo '
                        <label for="encomenda">Encomenda:</label>
                        <select id="encomenda" name="encomenda" class="form-control input_view"  disabled>
                            <option value="'.$date['Encomenda'].'">'.$date['Encomenda'].'</option>
                     ';

                     
                     $this->impressoption( $this->encomenda->listcencomenda());
                echo '
                        </select>
                        <label for="status">Status De Envio:</label>
                                          
                        <select id="status" name="status" class="form-control input_view" '.$editar_registro.'>
                            <option value="'.$date['status'].'">'.$date['status'].'</option>';
    
                        #imprimir lista de status utilizando objeito da class interaction
                        $this->impressoption( $this->statusentrega->listcstatusentrega());
                        echo '</select>
    
                        <label for="codigo">Codigo de Postagem:</label>
                        <input type="text" id="codigo" name="codigo" class="form-control input_view" value="' . $date['CodigoPostagen'] . '" '.$editar_registro.'>
    
                        <label for="datapostagem">Data de Postagem:</label>
                        <input type="date" id="datapostagem" name="datapostagem" class="form-control input_view" value="' . $date['DataPostagem'] . '" '.$editar_registro.'>

                      
                        <label for="obs">Observação:</label>
                        <textarea id="obs" name="obs" class="form-control input_view" '.$editar_registro.'>' . $date['Observacao'] . '</textarea>
    
                        ';
        
        
                echo '</div>';
        

                // abrir container container_view
                echo '<div class="container_view">

                <label for="dataregistro">Data do Registro:</label>
                <input type="text" id="dataregistro" name="dataregistro" class="form-control input_view" value="' . $date['DataRegistro'] . '" disabled>



                        <label for="rua">Endereço:</label>
                    <input type="text" id="rua" name="rua" class="form-control input_view" value="' . $date['rua'] . '"disabled>
        
                        <label for="Numero">Número:</label>
                        <input type="text" id="Numero" name="Numero" class="form-control input_view" value="' . $date['numero'] . '"disabled>
        
                        <label for="bairro">Bairro:</label>
                        <input type="text" id="bairro" name="bairro" class="form-control input_view" value="' . $date['bairro'] . '"disabled>
        
                        <label for="uf">Estado:</label>
                        <select class="form-control input_view" name="uf" id="uf" disabled>
                                <option value="'.$date['estado'].'">'.$date['estado'].'</option>
                                <option value="AC">AC</option>
                                <option value="AL">AL</option>
                                <option value="AP">AP</option>
                                <option value="AM">AM</option>
                                <option value="BA">BA</option>
                                <option value="CE">CE</option>
                                <option value="DF">DF</option>
                                <option value="ES">ES</option>
                                <option value="GO">GO</option>
                                <option value="MA">MA</option>
                                <option value="MS">MS</option>
                                <option value="MT">MT</option>
                                <option value="MG">MG</option>
                                <option value="PA">PA</option>
                                <option value="PB">PB</option>
                                <option value="PR">PR</option>
                                <option value="PE">PE</option>
                                <option value="PI">PI</option>
                                <option value="RJ">RJ</option>
                                <option value="RN">RN</option>
                                <option value="RS">RS</option>
                                <option value="RO">RO</option>
                                <option value="RR">RR</option>
                                <option value="SC">SC</option>
                                <option value="SP">SP</option>
                                <option value="SE">SE</option>
                                <option value="TO">TO</option>
                        </select>
        
                        <label for="cidade">Cidade:</label>
                        <input type="text" id="cidade" name="cidade" class="form-control input_view" value="' . $date['cidade'] . '" disabled>
    
                        <label for="cep">Cep:</label>
                        <input type="text" id="cep"  name="cep" class="form-control input_view" value="' . $date['cep'] . '"disabled>
    
                        <label for="complementar">Informações Complementares Endereço:</label>
                        <input type="text" id="complementar"  name="complementar" class="form-control input_view" value="' . $date['complementar'] . '"disabled>
    
                        
    
                    ';
                    echo '</div>'; // fechar container container_view
                                        
            }

            if($type == 'e'){
                echo '<div class="container_view">';
                
                    echo ' <label for="idregistro">ID Registro:</label>
                    <input type="text" id="idregistro" name="idregistro" class="form-control input_view" value="' . $date['id'] . '"disabled>

                    <label for="dataregistro">Data de registro:</label>
                    <input type="text" id="dataregistro" name="dataregistro" class="form-control input_view" value="' . $date['Data Registro'] . '" disabled>

                    <label for="datacoleta">Data coleta:</label>
                    <input type="date" id="datacoleta" name="datacoleta" class="form-control input_view" value="' . $date['Data Coleta'] . '" disabled>';

                    echo '<label for="status">Status:</label>
                    <select  id="status" name="status" class="form-control input_view"  disabled>';
                        echo '<option value="' . $date['Status'] . '">'.$date['Status'].'</option>';
                        $this->impressoption( $this->statusentrega->listcstatusentrega());
                    echo '</select>';
                    

                   echo '<label for="Ipusuario">IP de registro:</label>
                    <input type="text" id="Ipusuario" name="Ipusuario" class="form-control input_view" value="' . $date['ipcomputador'] . '" disabled>

                    ';
                
                echo '</div>';

                echo '<div class="container_view">';
                
                    echo '<label for="Codigo">Codigo de Rastreio:</label>
                    <input type="text" id="Codigo" name="Codigo" class="form-control input_view" value="' . $date['Codigo'] . '"disabled>

                    <label for="remetente">Remetente:</label>
                    <input type="text" id="remetente" name="remetente" class="form-control input_view" value="' . $date['Remetente'] . '"disabled>

                    ';
                    echo '
                        <label for="encomenda">Encomenda:</label>
                        <select id="encomenda" name="encomenda" class="form-control input_view" disabled  >
                            <option value="'.$date['Tipo da Encomenda'].'">'.$date['Tipo da Encomenda'].'</option>
                            
                        ';
                        $this->impressoption( $this->encomenda->listcencomenda());

                        echo '</select>';

                
                
                    echo '
                        <label for="setor">Setor destinatário:</label>
                        <select id="setor" name="setor" class="form-control input_view" disabled>
                            <option value="'.$date['Setor'].'">'.$date['Setor'].'</option>
                        ';

                        $this->impressoption( $this->objectSector->listSectordescAtivo());

                         echo '</select>';   
                    echo '
                        <label for="DataEntrega">Data Entrega Setor:</label>
                        <input type="datetime-local" id="DataEntrega" name="DataEntrega" class="form-control input_view" value="' . $date['Data Entrega Setor'] . '"disabled>

                        <label for="obs">Observação do registro:</label>
                        <textarea  id="obs" name="obs" class="form-control input_view" disabled>' . $date['Observação do registro'] . '</textarea>

                
                ';

                echo '</div>';
                
            }
                echo "<div style = 'width:100%; text-align:center;' >";
                    if($type == 's'){
                        if (in_array("editar-registro-envio",$dadosusuario_acesso['acessos']) ) {
                        
                            echo '<input type="submit" style="margin:5px;" value="Salvar" class="btn btn-success">';
                        }
                        echo "<a class='btn btn-primary' style='margin:5px;' href='index_comprovante.php?&id=".$date['id']."'>Imprimir</a>";
                        
                    }
                    if($type == 'e'){
                        if (in_array("editar-registro-entrada",$dadosusuario_acesso['acessos'])) {
                        
                            echo '<input id="salvar" style="margin:5px;" type="submit" value="Salvar" class="btn btn-success">';

                            echo '<button style="margin:5px;" onclick="editar_informacoes('."'".$_GET['type']."'".')" class="btn btn-info" type="button">Editar</button>'; 
                            
                            echo '<script>';
                            echo 'function editar_informacoes(type){
    
                                $.ajax({
                                    type: "POST",
                                    url: "AdminSetting.php",
                                    data: { tipo:"edicao_view"},
                                    success: function (result) {
                                        console.log(result);
                                        if(result == true){
                                            document.getElementById("Codigo").disabled = false;
                                            document.getElementById("remetente").disabled = false;
                                            document.getElementById("encomenda").disabled = false;
                                            document.getElementById("setor").disabled = false;
                                            document.getElementById("DataEntrega").disabled = false;
                                            document.getElementById("obs").disabled = false;
                                            document.getElementById("datacoleta").disabled = false;
                                            document.getElementById("status").disabled = false;
                                            document.getElementById("salvar").classList.remove("btn-danger");
                                            document.getElementById("salvar").classList.add("btn-success");
                                        }
                                },
                                    error: function () {
                                        console.log("Erro ao Atualizar");
                                    }
                                });
                            }';
                           
                            echo '</script>';
                        }
                        else if(in_array("editar-registro-entrada",$dadosusuario_acesso['acessos'])){
                            echo '<input id="salvar" style="margin:5px;" type="submit" value="Salvar" class="btn btn-success">';

                            echo '<button style="margin:5px;" onclick="editar_informacoes_obs('."'".$_GET['type']."'".')" class="btn btn-info" type="button">Editar Observações</button>'; 
                            
                            echo '<script>';
                           
                            echo '</script>';
                        }                   
                    }


                    echo "<button style='margin:5px;' onclick='historico(".$_GET['cod'].",".'"'.$_GET['type'].'"'.")' class='btn btn-primary' type='button'>Historico</button>"; 
                    
                    echo "<div id='historico' class='grid-container style_historico'>";
                    echo "</div>";

            echo "</div>";
        }
    }
}
