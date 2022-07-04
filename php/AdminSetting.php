<?php

use function PHPSTORM_META\type;

    require_once("config.php");
    $interactionadmin = new interaction_admin();
    $interaction= new interaction();
    if(isset($_POST)){
        if($_POST['tipo'] == 'setornovo' ){
            $interactionadmin->VerificarParaInserir($_POST['NewSetor'],'setor');         
        }
        else if( $_POST['tipo'] == 'encomendanovo'){
            $interactionadmin->VerificarParaInserir($_POST['Newencomenda'],'encomenda');   
            
        }
        else if($_POST['tipo'] == 'statussetor'){
            $interactionadmin->alteracaoDeStatusSetor($_POST['value']);
        }
        else if($_POST['tipo'] == 'statusencomenda'){
           $interactionadmin->alteracaoDeStatusEncomenda($_POST['value']);
        }
        else if($_POST['tipo'] == 'atttablesetor'){
            $interactionadmin->setorimprimir();
        }
        else if($_POST['tipo'] == 'atttableencomenda'){
            $interactionadmin->encomendaimprimir();
        }
        else if( $_POST['tipo'] == 'loadtable'){
            echo $interaction->SearchRelatorio($_POST['setor'], $_POST['buscar'],  $_POST['datainicio'], $_POST['datafinal']);
        }
       
       
    }
    else{
        echo "Sem post encaminhado";
    }
