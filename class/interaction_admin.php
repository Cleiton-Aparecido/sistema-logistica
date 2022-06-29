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
    private function StyleStatus($status){
        if($status == 'Ativo'){
            return 'btn-primary';
        }
        else if($status == 'Desativo'){
            return 'btn-danger';
        }
    }
    private function inserirnovosetor(){

    }
    
    // Imprimir lista menu
    private function impressList($conteudo,$tipoatt){
        if($tipoatt == 'setor'){     
            foreach($conteudo as $key => $value){
                $iddescsetor = str_replace(' ','', $value['Nome']);
                echo "<p class = 'item'>
                        <span class='item_conteudo' >".$value['id']."  - ".$value['Nome']."</span> 
                        <button class = 'btn ".$this->StyleStatus($value['status'])." status_item' name='setor'  
                        value='".$value['Nome']."' id='".$iddescsetor."'  onclick='statusSetor(this.value,this.id);' > ".$value['status']."</button> 
                    </p>";
            }   
        }
    }
    //REquisita informação no banco e manda imprimir no metodos impressList
    public function setor(){
        $listSetores = $this->objectSector->listSector();
        $this->impressList($listSetores,"setor");   
    }
    //configuração de status setor
    public function alteracaoDeStatus($Setor){
        $statusSetor = $this->objectSector->statusSector($Setor);
        if($statusSetor == 'Ativo'){
            $this->objectSector->alterarStatus($Setor,'Desativo');
            echo $this->objectSector->statusSector($Setor);
            
        }
        if($statusSetor == 'Desativo'){
            $this->objectSector->alterarStatus($Setor,'Ativo');
            echo $this->objectSector->statusSector($Setor);
        }
    }
    public function VerificarParaInserir($setor){
        if($setor == '' ||  $setor == ' '){
            echo 'Campa Vazioooo!';
        }
        else{
            if($this->objectSector->VerificarSetorExistente($setor)){
                echo 'Setor já Existente';
            }
            else{
                $this->objectSector->inserirNOvoSetor($setor);
               echo 'Salvo com sucesso';
            }
        }
        
        
    }
    
}
