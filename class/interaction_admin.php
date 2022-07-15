<?php
require_once("config.php");
class interaction_admin  extends interaction
{
    

    public function __construct()
    {
        $this->objectEnvio = new tipoEnvio();
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
        if($tipoatt == 'setor' || $tipoatt == 'encomenda' || $tipoatt == 'transporte'){     
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
    public function tipoenvioimprimir(){
        $listSetores =  $this->objectEnvio->listaltipoenvio();
        $this->impressList($listSetores,"transporte");   
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
    public function alteracaoDeStatusTransporte($tipoenvio){
        $statustipoenvio = $this->objectEnvio->statustipoenvio($tipoenvio);
        

        if($statustipoenvio == 'Ativo'){
            $this->objectEnvio->alterarStatus($tipoenvio,'Desativo');
            echo $this->objectEnvio->statustipoenvio($tipoenvio);
            
        }
        if($statustipoenvio == 'Desativo'){
            $this->objectEnvio->alterarStatus($tipoenvio,'Ativo');
            echo $this->objectEnvio->statustipoenvio($tipoenvio);
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

            if($item == 'transporte'){

                $this->objectEnvio->verificarTransporteExiste($conteudo);

                if($this->objectEnvio->verificarTransporteExiste($conteudo)){
                    echo 'Setor já Existente';
                }
                else{
                   $this->objectEnvio->inserirNovoTipoEnvio($conteudo); 
                   echo 'Salvo com sucesso';           
                }
            }

        }
        
        
    }
    public function tabelausuario(){
       $lista = $this->objectUser->listausuarios();
    //    var_dump($lista);
        $this->impressUsuario($lista);
    }


    private function impressUsuario($dados){

        echo "<div class='grid-container'>";
                echo "<div class='grid-item cabecalho-grid' >ID</div> ";
                echo "<div class='grid-item cabecalho-grid' >Nome</div> ";
                echo "<div class='grid-item cabecalho-grid' >IP <br> Computador</div>";
                echo "<div class='grid-item cabecalho-grid' >Nivel <br> Acesso</div>";

                echo "<div class='grid-item cabecalho-grid' >Setor</div>";
                
                echo "<div class='grid-item cabecalho-grid' >Salvar</div>";
            
            foreach ($dados as $value) {
                $id = $value['nome'].$value['ipcomputador'];
                $iddescconteudo = str_replace(' ','',$id);
                    echo "<div class='grid-item' id='id:".$value['id']."' value='".$value['id']."' >".$value['id']."</div> ";

                    echo "<div class='grid-item' >";
                        echo "<input class='form-control' id='nome:".$value['id']."' value='".$value['nome']."'>";
                    echo "</div> ";

                    echo "<div class='grid-item' >";
                        echo "<input class='form-control input_style' id='ipcomputador:".$value['id']."' value='".$value['ipcomputador']."' disabled>";
                    echo "</div> ";


                    echo "<div class='grid-item'>";
                        echo "<input class='form-control input_style' id='nivel:".$value['id']."'  value='".$value['nivel']."'>";
                    echo "</div>";
                    
                    echo "<div class='grid-item'  >";
                        echo "<select class='form-control' id='setor:".$value['id']."'>";
                            echo "<option value='".$value['setor']."'>".$value['setor']."</option>";
                            $x = $this->objectSector->listSectordesc();
                            $this->impressoption($x);
                        echo "</select>";
                    echo "</div>";
                    
                    echo "<div class='grid-item'>";
                        echo " <button class = 'btn btn-success' id='salvar:".$value['id']."' value='".$value['id']."' onclick='salvaralteracaousuario(this.value);'>Salvar</button>";
                    echo "</div>";
            
        }
        echo "</div>";

    }
    
    public function atualizardadosusuario($dadosUsuarios){
        
        if($this->objectUser->level($_SERVER['REMOTE_ADDR']) == 1){
        $this->objectUser->atualizarusuario($dadosUsuarios);
         echo 'Salvo com Sucesso';
            
        }
        else{
            echo "sem permissão";
        }
    }
    
    
}
