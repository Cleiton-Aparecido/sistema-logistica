<?php

use function PHPSTORM_META\type;

    require_once("config.php");
    $interactionadmin = new interaction_admin();
    
    if(isset($_POST)){
        if($_POST['tipo'] == 'setornovo' ){
            $interactionadmin->VerificarParaInserir($_POST['NewSetor']);         
        }
        else if($_POST['tipo'] == 'statusSetor'){
            $interactionadmin->alteracaoDeStatus($_POST['setor']);
        }
        else if($_POST['tipo'] == 'atttablesetor'){
            $interactionadmin->setor();
        }
    }
    else{
        echo "Sem post encaminhado";
    }
    

?>