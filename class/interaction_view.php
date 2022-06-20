<?php
require_once("config.php");
class interaction_view  extends interaction
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
    private function AccessToEdit()
    {
        $level = $this->objectUser->level($_SERVER['REMOTE_ADDR']);
        if ($level == 1 || $level == 2) {
            return true;
        } else {
            return false;
        }
    }
    public function dadosViewEntrada($id)
    {
        $x = $this->objectRegister->queryRegistro($id);
        echo '<script>document.getElementById("voltar").</script>';
        foreach ($x as $key => $value) {
            if ($key == 'Status') {
                $value = $this->group->searchstatusid($value);
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
            } else if ($key == 'Setor') {
                $value = $this->objectSector->searchsectorid($value);
                echo '<p><strong> ' . $key . ':</strong> ' . $value . '</p>';
            } else {
                echo '<p><strong> ' . $key . ':</strong> ' . $value . '</p>';
            }
        }
    }
    public function dadosViewEnvio($id, $tipo)
    {
        if ($tipo == 's') {
            echo "<script> document.getElementById('title').innerHTML='Registro do Envio' </script>";
            echo "<script> document.getElementById('titulocabecalho').innerHTML='Registro do Envio' </script>";
            echo "<script> document.getElementById('voltar').href = '/index_envio.php'</script>";
            $date =  $this->RegistroEnvioEncomenda->queryregisterenvio($id);
            $this->viewandconfiguration($date,$tipo);
        }
        if ($tipo == 'e') {
            echo " <script> document.getElementById('title').innerHTML='Registro de entrada' </script>";
            echo " <script> document.getElementById('titulocabecalho').innerHTML='Registro de entrada' </script>";
        }
    }
    

    private function viewandconfiguration($date,$type)
    {

        // var_dump($status);
        

        if(!isset($date['id'])){
            echo '<div class="container_view">
                   <h1> Não encontrado na base de dados </h1>   
                    ';
    
    
            echo '</div>';
        }
        else {
            
            
    
    
            $disabled = '';
            
    
    
            echo '<div class="container_view">
                    <label for="idregistro">ID Registro:</label>
                    <input type="text" id="idregistro" name="idregistro" class="form-control" value="' . $date['id'] . '"disabled>
    
                    <label for="dataregistro">Data do Registro:</label>
                    <input type="text" id="dataregistro" name="dataregistro" class="form-control" value="' . $date['DataRegistro'] . '" disabled>
    
                    <label for="Ipusuario">IP Computador:</label>
                    <input type="text" id="Ipusuario" name="Ipusuario" class="form-control" value="' . $date['Ipusuario'] . '" disabled>
    
                    <label for="status">Status De Envio:</label>
                                      
                    <select id="status" name="status" class="form-control" ' . $disabled . '>
                        <option value="'.$date['status'].'">'.$date['status'].'</option>';

                    #imprimir lista de status utilizando objeito da class interaction
                    $this->impressoption( $this->statusentrega->listcstatusentrega());
                    echo '</select>

                    <label for="codigo">Codigo de Postagem:</label>
                    <input type="text" id="codigo" name="codigo" class="form-control" value="' . $date['codigo'] . '" ' . $disabled . '>

                    <label for="datapostagem">Data de Postagem:</label>
                    <input type="date" id="datapostagem" name="datapostagem" class="form-control" value="' . $date['codigo'] . '" ' . $disabled . '>

                    <label for="obs">Observação:</label>
                    <textarea id="obs" name="obs" class="form-control" ' . $disabled . '>' . $date['Observacao'] . '</textarea>

                    ';
    
    
            echo '</div>';
    
            echo '<div class="container_view">
                    <label for="rua">Endereço:</label>
                    <input type="text" id="rua" name="rua" class="form-control" value="' . $date['rua'] . '"' . $disabled . '>
    
                    <label for="Numero">Número:</label>
                    <input type="text" id="Numero" name="Numero" class="form-control" value="' . $date['numero'] . '"' . $disabled . '>
    
                    <label for="bairro">Bairro:</label>
                    <input type="text" id="bairro" name="bairro" class="form-control" value="' . $date['bairro'] . '"' . $disabled . '>
    
                    <label for="uf">Estado:</label>
                    <select class="form-control" name="uf" id="uf" '. $disabled .'>
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
                    <input type="text" id="cidade" name="cidade" class="form-control" value="' . $date['cidade'] . '"' . $disabled . '>

                    <label for="cep">Cep:</label>
                    <input type="text" id="cep"  name="cep" class="form-control" value="' . $date['cep'] . '"' . $disabled . '>

                    <label for="complementar">Informações Complementares Endereço:</label>
                    <input type="text" id="complementar"  name="complementar" class="form-control" value="' . $date['complementar'] . '"' . $disabled . '>

                    

                ';
    
                echo '</div>';
                if ($this->AccessToEdit()) {
                    echo '<input type="button" value="Salvar" class="btn btn-success">';
                }
        }
    }
}
