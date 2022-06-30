<?php

use function PHPSTORM_META\type;

    require_once("config.php");
    $interactionadmin = new interaction_admin();
    $interaction= new interaction();
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
        else if( $_POST['tipo'] == 'loadtable'){
             
        echo $interaction->SearchRelatorio($_POST['setor'], $_POST['buscar'],  $_POST['datainicio'], $_POST['datafinal']);
                 
        }
    }
    else{
        echo "Sem post encaminhado";
    }
    

?>