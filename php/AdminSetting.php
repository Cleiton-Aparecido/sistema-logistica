<?php



require_once("config.php");
$interactionadmin = new interaction_admin();
$interaction = new interaction();
$interactionview = new interaction_view();
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
    } else if ($_POST['tipo'] == 'atualizarusuario') {
        $verificacao = 0;
        foreach ($_POST as $key => $value) {

            $value = str_replace(' ', '', $value);

            if (strlen($value) == 0) {
                $verificacao++;
            }
        }
        if ($verificacao == 0) {
                $dadosusuario = array(
                    "id" => $_POST['id'],
                    "nome" => $_POST['nome'],
                    "ipcomputador" => $_POST['ipcomputador'],
                    "nivel" => $_POST['nivel'],
                    "setor" => $_POST['setor']
            );
            if ($dadosusuario['nivel'] != 0 && $dadosusuario['id'] != 0 && $dadosusuario['nome'] != '') {
                $interactionadmin->atualizardadosusuario($dadosusuario);
            }
        } else {
            echo 'Campos Vazios';
        }
    } else if($_POST['tipo'] == 'historico'){
        if($_POST['tiporegistro']=='e'){

            $interactionview->historicoentrada( $_POST['id']);
        }
        else if ($_POST['tiporegistro']=='s') {
            $interactionview->historicoenvio($_POST['id']);
        }
      
    }else if($_POST['tipo'] == 'edicao_view'){
        echo $interactionview->ControleDeAcesso();
    }
    
} else {
    echo "Sem post encaminhado";
}

?>