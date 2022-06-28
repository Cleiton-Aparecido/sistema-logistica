<?php
    require_once("config.php");
    $interactionadmin = new interaction_admin();
    // var_dump($_POST);
    
    if(isset($_POST)){
        if($_POST['tipo'] == 'setor' ){
            echo $_POST['NewSetor'];
            // echo "salvo com sucesso"
        }
        else if($_POST['tipo'] == 'statusSetor'){
            // echo $_POST['setor'];
            // chamando a classe interaction admin para alterar status
            $interactionadmin->alteracaoDeStatus($_POST['setor']);
        }
    }
    else{
        echo "Sem post encaminhado";
    }
    

?>