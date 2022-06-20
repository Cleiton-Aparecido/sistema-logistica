<?php
require_once("config.php");
date_default_timezone_set('America/Sao_Paulo');
$interaction = new interaction();
$x = false; 
if ($_POST) {
    if($_POST['tiporegistro'] == 'entrada'){
        $setor = $_POST['setor'];
        $encomenda = $_POST['encomenda'];
        $codigo = $_POST['codigo'];
        $remetente = $_POST['remetente'];
        $observacao = $_POST['obs'];
        $datacoleta = $_POST['datacoleta'];
        $x = $interaction->insertEntrada($setor, $encomenda, $codigo, $remetente, $datacoleta,$observacao);
        if ($x) {
            header('Location: index.php');
        }
    }
    if($_POST['tiporegistro'] == 'envio'){
        $setor = $_POST['setor'];
        $encomenda = $_POST['encomenda'];
        $func = $_POST['func'];
        $rua = $_POST['rua'];
        $cep = $_POST['cep'];
        $num = $_POST['num'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];
        $complementar = $_POST['complementar'];
        $obs = $_POST['obs'];
        $x = $interaction->insertEnvio($setor,$encomenda,$func,$cep,$rua,$num,$bairro,$cidade,$uf,$complementar,$obs);
        if ($x) {
            header('Location: index_envio.php');
        }
    }
}


?>
<!DOCTYPE html>
<html lang="pt-br">


<head>
    <title>Novo Registro</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="icon" href="../img/correios-logo.png">



    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>

    <style type="text/css">
        <?php include('../css/style.css');   ?>
    </style>

    <script>
        <?php include('../js/javascripts.js');   ?>

        	
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>

<body>
    <header id="cabecalho_master">
        <div id="cabecalho">
            <img class="imglogo " src="../img/correios-logo.png" alt="">
            <span class="titulo_cabecalho">Novo Registro</span>
        </div>
    </header>
    <section id="container_master_newregistro">
        <form action="" class="form_new" method="post" name="menu" onsubmit='Registrar'>
            <div class="MenuLogistica">
                <h4>Tipo de Registro</h4>
                <div class="container_menu_logistica">
                    <input type="radio" id="entrada"  onclick="requisitarPagina('entrada.php')" name="tiporegistro" value="entrada">
                    <label for="entrada">Entrada</label><br>
                    <input type="radio" id="envio" onclick="requisitarPagina('envio.php')" name="tiporegistro" value="envio">
                    <label for="envio">Envio</label><br>
                </div>
            </div>
            <div id="form_new_js">
            </div>


        </form>
        <div id="Menu_lateral">
            <article id="container_user">
                <img src="../img/user.png">
                <div id="inf_user"> <?php $interaction->IpSearch(); ?></div>
            </article>
            <article class="buttons">
                <a href="index.php" class="btn btn-primary buttons">Voltar</a>
            </article>
        </div>
    </section>
</body>

</html>