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
  
    
    // Imprimir lista menu
    private function impressList($conteudo,$tipoatt){
        if($tipoatt == 'setor' || $tipoatt == 'encomenda'){     
            foreach($conteudo as $key => $value){
                $iddescconteudo = str_replace(' ','', $value['nome']);
                echo "<p class = 'item'>
                        <span class='item_conteudo' >".$value['id']."  - ".$value['nome']."</span> 
                        <button class = 'btn ".$this->StyleStatus($value['status'])." status_item' name='$tipoatt'  
                        value='".$value['nome']."' id='".$iddescconteudo."'  onclick='status(this.value,this.id,this.name);' > ".$value['status']."</button> 
                    </p>";
            }   
        }
    }

    //REquisita informação no banco e manda imprimir no metodos impressList
    public function setorimprimir(){
        $listSetores = $this->objectSector->listSector();
        $this->impressList($listSetores,"setor");   
    }
    public function encomendaimprimir(){
        $listSetores = $this->encomenda->listatotal();
        $this->impressList($listSetores,"encomenda");   
    }
    //configuração de status setor
    public function alteracaoDeStatusSetor($Setor){

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

    //configuração de status encomenda
    public function alteracaoDeStatusEncomenda($encomenda){
        $statusencomenda = $this->encomenda->statusencomenda($encomenda);
        if($statusencomenda == 'Ativo'){
            $this->encomenda->alterarStatusEncomenda($encomenda,'Desativo');
            echo $this->encomenda->statusencomenda($encomenda);
            
        }
        if($statusencomenda == 'Desativo'){
            $this->encomenda->alterarStatusEncomenda($encomenda,'Ativo');
            echo $this->encomenda->statusencomenda($encomenda);
        }
    }

    public function VerificarParaInserir($conteudo,$item){
        if($conteudo == '' ||  $conteudo == ' '){
            echo 'Campa Vazioooo!';
        }
        else{
            $conteudo = strtoupper($conteudo);
            if($item == 'setor'){
                if($this->objectSector->VerificarSetorExistente($conteudo)){
                    echo 'Setor já Existente';
                }
                else{
                    $this->objectSector->inserirNOvoSetor($conteudo);
                   echo 'Salvo com sucesso';           
                }
            }

            if($item == 'encomenda'){
                if($this->encomenda->verificarEncomendaExiste($conteudo)){
                    echo 'Setor já Existente';
                }
                else{
                    $this->encomenda->inserirNovaEncomenda($conteudo);
                   echo 'Salvo com sucesso';           
                }
            }

        }
        
        
    }

    

    
    
}
