<?php
require_once("config.php");
class interaction_admin  extends interaction
{
    private $dadosusuario_acesso;
    private $dadosusuario;
    public function __construct()
    {
        
        $this->objectEnvio = new tipoEnvio();
        $this->objectSector = new setor();
        $this->objectUser = new usuario();
        $this->objectRegister = new registro();
        $this->encomenda = new encomenda();
        $this->statusentrega = new statusentrega();
        $this->RegistroEnvioEncomenda = new registroEnvio();
        $this->dadosusuario_acesso = $this->objectUser->loadByIpUsuario($_SERVER['REMOTE_ADDR']);

    }

    private function getdadosusuario()
    {
        return $this->dadosusuario;
    }
    private function setdadosusuario($value)
    {
        $this->dadosusuario = $value;
    }

    private function StyleStatus($status){
        if($status == 'Ativo'){
            return 'btn-primary';
        }
        else if($status == 'Desativo'){
            return 'btn-danger';
        }
    }   
    public function AcessoNaAbaParaEditarUsuario(){
        if(in_array("editar-usuario",$this->dadosusuario_acesso['acessos'])){
        }
        else{
            header('Location: index.php');
        }
    }

    public function acessosContainer(){

        foreach ($this->dadosusuario_acesso['acessos'] as $key => $value) {
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
                

                echo "<div class='grid-item-admin cabecalho-grid' >Setor</div>";
                
                echo "<div class='grid-item-admin cabecalho-grid'>Editar Acessos</div>";
            
            foreach ($dados as $value) {
                $id = $value['nome'].$value['ipcomputador'];
                    echo "<div class='grid-item-admin' id='id:".$value['id']."' value='".$value['id']."' >".$value['id']."</div> ";

                    echo "<div class='grid-item-admin' >";
                        echo "<input class='form-control' id='nome:".$value['id']."' value='".$value['nome']."' disabled>";
                    echo "</div> ";

                    echo "<div class='grid-item-admin'  >";
                        echo "<input class='form-control input_style-admin' id='ipcomputador:".$value['setor']."' value='".$value['setor']."' disabled>";
                    echo "</div>";
                    
                    echo "<div class='grid-item-admin'>";
                        echo " <a href='editar_usuario.php?usuario=".$value['id']."'  class = 'btn btn-success' id='salvar:".$value['id']."' value='".$value['id']."' >Editar</a>";
                    echo "</div>";
            
        }
        echo "</div>";
        echo '</article>';
    }
    
    // editar acessos de usuarios

    public function acessos_usuario($acessos){
      foreach ($this->objectUser->ListaDeAcessos() as $key => $value) {
        echo "<input class='style_checkbox' type='checkbox' id='$value' name='$value'";
            if(in_array($value,$acessos)){
                echo 'checked';
            }
        echo ">";
        echo "<label class='style_checkbox_label' for='$value'>$value</label><br>";
      }

    }
    public function alterar_acessos($acessos_novos){

        $dados_antigos = $this->getdadosusuario();
       

        
        foreach ($acessos_novos as $value) {
            
            if(!in_array($value,$dados_antigos['acessos'])){
                $this->objectUser->criar_acessos(array("id"=>$dados_antigos['idusuario'],
                "acesso"=>$value));
            }   
        }
        foreach ($dados_antigos['acessos'] as $value) {
          
            if(!in_array($value,$acessos_novos)){
                $this->objectUser->excluir_acessos(array("id"=>$dados_antigos['idusuario'],
                                                        "acesso"=>$value));
            }
        }


    }

    public function SalvarAlteracao($dados_novos){

        
        $this->alterar_acessos($dados_novos['acessos']); 

        $dados_antigos = $this->getdadosusuario();


        if($dados_novos['nome'] != $dados_antigos['nome']){

            $this->objectUser->atualizarnome(array("id"=>$dados_antigos['idusuario'],"nome_novo"=>$dados_novos['nome']));

        }
        if($dados_novos['setor'] != $dados_antigos['setor']){
            $this->objectUser->atualizarsetor(array("id"=>$dados_antigos['idusuario'],"setor_novo"=>$dados_novos['setor']));
        }
        
        

        header('Location: index_Admin.php');

    }
 
    public function dadosusuario($idusuario){
        $this->setdadosusuario($this->objectUser->loadByIdUsuario($idusuario));
        return $this->getdadosusuario();
         

    }
}
