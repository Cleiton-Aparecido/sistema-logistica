<?php
require_once("config.php");
class interaction_monitor  extends interaction
{
    private $objectSector = array();
    private $objectUser = array();
    private $objectRegister = array();
    private $encomenda = array();
    private $statusentrega = array();
    private $RegistroEnvioEncomenda = array();


    public function __construct()
    {
        $this->objectSector = new setor();
        $this->objectUser = new usuario();
        $this->objectRegister = new registro();
        $this->encomenda = new encomenda();
        $this->statusentrega = new statusentrega();
        $this->RegistroEnvioEncomenda = new registroEnvio();
      
    }
    public function monitorEntrada(){
        $dadosEntrada = $this->objectRegister->Qtd_Dados_Por_Status();
        $this->imprimirMonitor($dadosEntrada);
    }
    public function monitorEnvio(){
        $dadosEntrada = $this->RegistroEnvioEncomenda->Qtd_Dados_Por_Status();
        $this->imprimirMonitor($dadosEntrada);
    }

    private function imprimirMonitor($dados = array()){
        echo '<style type="text/css">
        include("../css/style_monitor.css"); 
    </style>';
        // container com as informações
        echo '<div class="container_informacao">';
            echo '<h2 class="statusQtd entregue">';
                echo '<span>';
                    echo $dados[0]['status'];
                echo ' </span>';
                echo '<span>';
                    echo $dados[0]['qtd'];
                echo '</span>';
            echo '</h2>';
            echo '<h2 class="statusQtd negado">';
                echo '<span>';
                    echo $dados[1]['status'];
                echo ' </span>';
                echo '<span>';
                    echo $dados[1]['qtd'];
                echo '</span>';
            echo '</h2>';
            echo '<h2 class="statusQtd pendente">';
                echo '<span>';
                    echo $dados[2]['status'];
                echo ' </span>';
                echo '<span>';
                    echo $dados[2]['qtd'];
                echo '</span>';
            echo '</h2>';
            echo '<h2 class="statusQtd preparo">';
                echo '<span>';
                    echo $dados[3]['status'];
                echo ' </span>';
                echo '<span>';
                    echo $dados[3]['qtd'];
                echo '</span>';
            echo '</h2>';

        // fim - container com as informações
        echo '</div>';
    }
    
}
