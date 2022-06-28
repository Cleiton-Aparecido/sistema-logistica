<?php
require_once("config.php");
class interaction_admin  extends interaction
{


    public function __construct()
    {
        $this->objectSector = new setor();
        $this->objectUser = new usuario();
        $this->objectRegister = new registro();
        $this->encomenda = new encomenda();
        $this->statusentrega = new statusentrega();
        $this->RegistroEnvioEncomenda = new registroEnvio();
    }

    
    private function impressList($conteudo,$tipoatt){
        if($tipoatt == 'setor'){     
            foreach($conteudo as $key => $value){
                if($value['statusAtivo'] == 0){
                    $value['statusAtivo'] = 'Desativo';
                }else if ($value['statusAtivo'] == 1){
                    $value['statusAtivo'] = 'Ativo';
                }
                  
                $iddescsetor = str_replace(' ','', $value['descsetor']);

                echo "<p class = 'item'> <span class='item_conteudo' >".$value['idsetor']."  - ".$value['descsetor']."</span> 
                <button class = 'btn btn-primary status_item' name='setor'  
                value='".$value['descsetor']."' id='".$iddescsetor."'  onclick='statusSetor(this.value,this.id);' > ".$value['statusAtivo']."</button> </p>";
               
            }
        }
    }
    public function setor(){
        $listSetores = $this->objectSector->listSector();
        echo "<div id='FormSetor' class = 'container_item_interno'>";
        $this->impressList($listSetores,"setor");   
    }
    //configuração de status setor
    public function alteracaoDeStatus($Setor){
        $statusSetor = $this->objectSector->statusSector($Setor);
        if($statusSetor){
            $this->objectSector->alterarStatus($Setor,'0');
            echo 'Desativado';
            
        }
        if(!$statusSetor){
            echo 'ativa';
        }
    }
    
}
