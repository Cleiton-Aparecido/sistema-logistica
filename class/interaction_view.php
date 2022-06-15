<?php

class interaction_view{
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
    public function dadosViewEntrada($id){
        $x= $this->objectRegister->queryRegistro($id);
        foreach ($x as $key => $value) {
            if ($key == 'Status') {
                $value = $this->group->searchstatusid($value);
                if($value == 'Pendente'){
                    echo '<p><strong> '.$key.': </strong><span class="badge badge-danger status">' .  $value . '</span></p>';
                }
                else if($value == 'Entregue'){
                    echo '<p><strong> '.$key.': </strong><span class="badge badge-success status">' . $value . '</span></p>';
                }
                else if($value == 'Negado'){
                    echo '<p><strong> '.$key.': </strong><span class="badge badge-warning status">' . $value . '</span></p>';
                }
            }
            else if ($key == 'Data Registro') {
                $date = new DateTime($value);
                $value = $date->format('d/m/Y H:i:s');
                echo '<p><strong> '.$key.':</strong> ' . $value . '</p>';
            }
            else if ($key == 'Data Coleta') {
                $date = new DateTime($value);
                $value = $date->format('d/m/Y');
                echo '<p><strong> '.$key.':</strong> ' . $value . '</p>';
            }
            else if ($key == 'Data Entrega Setor') {
                if($value==''){

                }else {
                    $date = new DateTime($value);
                    $value = $date->format('d/m/Y H:i:s');
                    echo '<p><strong> '.$key.':</strong> ' . $value . '</p>';
                }
            }
            else if ($key == 'Setor') {
                $value = $this->objectSector->searchsectorid($value);
                echo '<p><strong> '.$key.':</strong> '. $value . '</p>';
            }
            else {
                echo '<p><strong> '.$key.':</strong> '.$value.'</p>';    
            }
        }
    }
    public function dadosViewEnvio($id,$tipo){
        if($tipo == 's'){
            echo "<script> document.getElementById('title').innerHTML='Registro do Envio' </script>";
            echo "<script> document.getElementById('titulocabecalho').innerHTML='Registro do Envio' </script>";

        }
        if($tipo == 'e'){
            echo " <script> document.getElementById('title').innerHTML='Registro de entrada' </script>";
            echo " <script> document.getElementById('titulocabecalho').innerHTML='Registro de entrada' </script>";
        }
    }

}
