<?php



require_once("config.php");
$interactionadmin = new interaction_admin();
$interaction = new interaction();
$interactionview = new interaction_view();
$interactionmonitor = new interaction_monitor();

if (isset($_POST)) {
    if ($_POST['tipo'] == 'setornovo') {
        $interactionadmin->VerificarParaInserir($_POST['NewSetor'], 'setor');
        
    } else if ($_POST['tipo'] == 'encomendanovo') {
        $interactionadmin->VerificarParaInserir($_POST['Newencomenda'], 'encomenda');
    } else if ($_POST['tipo'] == 'transportenovo') {
        $interactionadmin->VerificarParaInserir($_POST['Newtransporte'], 'transporte');
    } else if ($_POST['tipo'] == 'statussetor') {
        $interactionadmin->alteracaoDeStatusSetor($_POST['value']);
    } else if ($_POST['tipo'] == 'statusencomenda') {
        $interactionadmin->alteracaoDeStatusEncomenda($_POST['value']);
    } else if ($_POST['tipo'] == 'statustransporte') {
        $interactionadmin->alteracaoDeStatustransporte($_POST['value']);
    } else if ($_POST['tipo'] == 'atttablesetor') {
        $interactionadmin->setorimprimir();
    } else if ($_POST['tipo'] == 'atttableencomenda') {
        $interactionadmin->encomendaimprimir();
    } else if ($_POST['tipo'] == 'atttabletransporte') {
        $interactionadmin->tipoenvioimprimir();
    } else if ($_POST['tipo'] == 'atttableusuario') {
        $interactionadmin->tabelausuario();
    } else if($_POST['tipo'] == 'historico'){
        if($_POST['tiporegistro']=='e'){

            $interactionview->historicoentrada( $_POST['id']);
        }
        else if ($_POST['tiporegistro']=='s') {
            $interactionview->historicoenvio($_POST['id']);
        }
      
    } else if($_POST['tipo'] == 'edicao_view'){
        echo $interactionview->AccessToEditButton();
    } else if ($_POST['tipo'] == 'monitorPOS') {
        $interactionmonitor->monitor();
    }
   
    
} else {
    echo "Sem post encaminhado";
}

?>