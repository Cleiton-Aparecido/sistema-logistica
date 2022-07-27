<?php
require_once("config.php");
class interaction_monitor extends interaction
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
    public function monitor(){
        $dadosEntrada = $this->objectRegister->Qtd_Dados_Por_Status();
        $dadosEnvio = $this->RegistroEnvioEncomenda->Qtd_Dados_Por_Status();

        // container com as informações
        echo '<style type="text/css">';
         include('../css/style_monitor.css');  
        echo '</style>';

        echo '<div class="container_informacao">';
        echo '<h1>Entrada de Encomendas</h1>';
            echo '<h2 >';
                echo '<span class="statusQtd entregue">';
                    echo $dadosEntrada[0]['status'].' Setor:';
                        echo '&nbsp';
                    echo $dadosEntrada[0]['qtd'];
                echo '</span>';
               
             
            echo '</h2>';

        echo '<h2 >';
                echo '<span class="statusQtd negado">';
                    echo $dadosEntrada[1]['status'].':';
                    echo '&nbsp';
                    echo $dadosEntrada[1]['qtd'];
                echo '</span>';
                
            echo '</h2>'; 

            echo '<h2 >';
                echo '<span class="statusQtd pendente">';
                    echo $dadosEntrada[2]['status'].':';
                    echo '&nbsp';
                    echo $dadosEntrada[2]['qtd'];
                echo '</span>';
             
            echo '</h2>';

     

        // fim - container com as informações
        echo '</div>';


        echo '<div class="container_informacao" id="envio">';
        echo '<h1>Envio de Encomendas</h1>';
            echo '<h2 >';
                echo '<span class="statusQtd entregue">';
                    echo $dadosEnvio[0]['status'].' Correios:';
                        echo '&nbsp';
                    echo $dadosEnvio[0]['qtd'];
                echo '</span>';
               
             
            echo '</h2>';

        echo '<h2 >';
                echo '<span class="statusQtd negado">';
                    echo $dadosEnvio[1]['status'].':';
                    echo '&nbsp';
                    echo $dadosEnvio[1]['qtd'];
                echo '</span>';
                
            echo '</h2>'; 

            echo '<h2 >';
                echo '<span class="statusQtd pendente">';
                    echo $dadosEnvio[2]['status'].':';
                    echo '&nbsp';
                    echo $dadosEnvio[2]['qtd'];
                echo '</span>';
             
            echo '</h2>';

            echo '<h2 >';
                echo '<span class="statusQtd preparo">';
                    echo $dadosEnvio[3]['status'].':';
                    echo '&nbsp';
                    echo $dadosEnvio[3]['qtd'];
                echo '</span>';
               
            echo '</h2>';


        // fim - container com as informações
        echo '</div>';

    }

    private function imprimirMonitor($dados = array()){
     
    }
    
}
