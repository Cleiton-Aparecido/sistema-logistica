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
    public function acessosContainer(){
        $dadosusuario = $this->objectUser->loadByIdUsuario($_SERVER['REMOTE_ADDR']);
        foreach ($dadosusuario['acessos'] as $key => $value) {
            if($value == 'editar-usuario' ){
                echo '<article id="usuario" class="container_item">';
                    $this->tabelausuario();
                echo '</article>';
            }
            if($value == 'editar-setor' ){
                echo '<article id="setor" class="container_item">';
                    echo '<h4 class="titulo_container">Setor</h4>';
                    echo '<div id="tabelasetor" class="container_item_interno">';
                        $this->setorimprimir();
                    echo '</div>';
                    echo '<Form action="" method="post" id="form_new_setor">
                                <label for="setornew" class="titulo_menu_input">Adicionar Novo Setor</label>
                                <input type="text" class="form-control" id="setornew" name="setornew">
                                <input type="button" value="Salvar" id="salvarsetor" class="btn btn-primary buttons-admin">
                            </Form>';

                    echo '<div id="resultSector" style="color: green; font-size:20px;"></div>';
                echo '</article>';
            }
            if($value == 'editar-encomenda' ){
                echo '<article id="encomenda" class="container_item">';
                    echo '<h4 class="titulo_container">Encomenda</h4>';
                    echo '<div id="tabelaencomenda" class="container_item_interno">';
                        $this->encomendaimprimir();
                    echo '</div>';
                echo '<Form action="" method="post" id="form_new_encomenda">
                <label for="encomendanew" class="titulo_menu_input">Adicionar Novo Tipo de Encomenda</label>
                <input type="text" class="form-control" id="encomendanew" name="encomendanew">
                <input type="button" value="Salvar" id="salvarencomenda" class="btn btn-primary buttons-admin">
                </Form>';
                echo '<div id="resultencomenda" style="color: green; font-size:20px;">
                </div>';

                echo '</article>';
            }
            if($value == 'editar-envio' ){
                echo '<article id="transporte" class="container_item">';
                    echo '<h4 class="titulo_container">transporte</h4>';
                    echo '<div id="tabelatransporte" class="container_item_interno">';
                        $this->tipoenvioimprimir();
                    echo '</div>';
                echo '<Form action="" method="post" id="form_new_transporte">
                <label for="transportenew" class="titulo_menu_input">Adicionar Novo Tipo de transporte</label>
                <input type="text" class="form-control" id="transportenew" name="transportenew">
                <input type="button" value="Salvar" id="salvartransporte" class="btn btn-primary buttons-admin">
                </Form>';
                echo '<div id="resulttransporte" style="color: green; font-size:20px;">
                </div>';
                echo '</article>';
            }
            
        }
    


    }

    // Imprimir lista menu
    private function impressList($conteudo,$tipoatt){
        if($tipoatt == 'setor' || $tipoatt == 'encomenda' || $tipoatt == 'transporte'){     
            foreach($conteudo as $key => $value){
                $iddescconteudo = str_replace(' ','', $value['nome']);
                echo "<p class = 'item'>
                        <span class='item_conteudo' >".$value['id']."  - ".$value['nome']."</span> 
                        <button class = 'btn ". $this->StyleStatus($value['status'])." status_item' name='$tipoatt'  
                        value='".$value['nome']."' id='".$iddescconteudo."'  onclick='status(this.value,this.id,this.name);' > ".$value['status']."</button> 
                    </p>";
            }   
        }
    }
    //Requisita informação no banco e manda imprimir no metodos impressList
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
            echo 'Campo Vazioooo!';
        }
        else{
            $conteudo = strtoupper($conteudo);
            if($item == 'setor'){
                if($this->objectSector->VerificarSetorExistente($conteudo)){
                    echo 'Setor já Existente';
                }
                else{
                    $this->objectSector->inserirNOvoSetor($conteudo);
                    echo 'setor inserido com sucesso!';
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

    public function atualizardadosusuario($dadosUsuarios){
        
        if($this->objectUser->level($_SERVER['REMOTE_ADDR']) == 1){
        $this->objectUser->atualizarusuario($dadosUsuarios);
         echo 'Salvo com Sucesso';
            
        }
        else{
            echo "sem permissão";
        }
    }


    private function impressUsuariodesabilitado($dados){

        echo '<article class="container_item_usuario">
                <span>
                    <h4 class="titulo_container"> Usuario</h4>
                </span>
                <div id="formusuario" class="container_item_interno">
                </div>
        <div id="RetornoSalvarUsuario"></div>';
        

        echo "<div class='grid-container-usuario'>";
                echo "<div class='grid-item-admin cabecalho-grid' >ID</div> ";
                echo "<div class='grid-item-admin cabecalho-grid' >Nome</div> ";
                echo "<div class='grid-item-admin cabecalho-grid' >IP <br> Computador</div>";
                echo "<div class='grid-item-admin cabecalho-grid' >Nivel <br> Acesso</div>";

                echo "<div class='grid-item-admin cabecalho-grid' >Setor</div>";
                
                echo "<div class='grid-item-admin cabecalho-grid' >Salvar</div>";
            
            foreach ($dados as $value) {
                $id = $value['nome'].$value['ipcomputador'];
                    echo "<div class='grid-item-admin' id='id:".$value['id']."' value='".$value['id']."' >".$value['id']."</div> ";

                    echo "<div class='grid-item-admin' >";
                        echo "<input class='form-control' id='nome:".$value['id']."' value='".$value['nome']."'>";
                    echo "</div> ";

                    echo "<div class='grid-item-admin' >";
                        echo "<input class='form-control input_style-admin' id='ipcomputador:".$value['id']."' value='".$value['ipcomputador']."' disabled>";
                    echo "</div> ";


                    echo "<div class='grid-item-admin'>";
                        echo "<input class='form-control input_style-admin' id='nivel:".$value['id']."'  value='".$value['nivel']."'>";
                    echo "</div>";
                    
                    echo "<div class='grid-item-admin'  >";
                        echo "<select class='form-control' id='setor:".$value['id']."'>";
                            echo "<option value='".$value['setor']."'>".$value['setor']."</option>";
                            $x = $this->objectSector->listSectordesc();
                            $this->impressoption($x);
                        echo "</select>";
                    echo "</div>";
                    
                    echo "<div class='grid-item-admin'>";
                        echo " <button class = 'btn btn-success' id='salvar:".$value['id']."' value='".$value['id']."' onclick='salvaralteracaousuario(this.value);'>Salvar</button>";
                    echo "</div>";
            
        }
        echo "</div>";
        echo '</article>';
    }
    
   private function impressUsuario($dados){

        echo '<article class="container_item_usuario">
                <span>
                    <h4 class="titulo_container"> Usuario</h4>
                </span>
                <div id="formusuario" class="container_item_interno">
                </div>
        <div id="RetornoSalvarUsuario"></div>';
        

        echo "<div class='grid-container-usuario'>";
                echo "<div class='grid-item-admin cabecalho-grid' >ID</div> ";
                echo "<div class='grid-item-admin cabecalho-grid' >Nome</div> ";
                echo "<div class='grid-item-admin cabecalho-grid' >IP <br> Computador</div>";
                

                echo "<div class='grid-item-admin cabecalho-grid' >Setor</div>";
                
                echo "<div class='grid-item-admin cabecalho-grid'>Editar Acessos</div>";
            
            foreach ($dados as $value) {
                $id = $value['nome'].$value['ipcomputador'];
                    echo "<div class='grid-item-admin' id='id:".$value['id']."' value='".$value['id']."' >".$value['id']."</div> ";

                    echo "<div class='grid-item-admin' >";
                        echo "<input class='form-control' id='nome:".$value['id']."' value='".$value['nome']."' disabled>";
                    echo "</div> ";

                    echo "<div class='grid-item-admin' >";
                        echo "<input class='form-control input_style-admin' id='ipcomputador:".$value['id']."' value='".$value['ipcomputador']."' disabled>";
                    echo "</div> ";


    
                    
                    echo "<div class='grid-item-admin'  >";
                        echo "<input class='form-control input_style-admin' id='ipcomputador:".$value['setor']."' value='".$value['setor']."' disabled>";
                    echo "</div>";
                    
                    echo "<div class='grid-item-admin'>";
                        echo " <button class = 'btn btn-success' id='salvar:".$value['id']."' value='".$value['id']."' >Editar</button>";
                    echo "</div>";
            
        }
        echo "</div>";
        echo '</article>';
    }
    
    
}
