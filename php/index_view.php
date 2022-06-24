<?php
require_once("config.php");
$interaction = new interaction();
$interactionview = new interaction_view();

if ($_POST) {

    if($_GET['type'] = 's'){
        $dados = array(
            "id"=>$_GET['cod'],
            "Status"=>$_POST['status'],
            "codigo"=>$_POST['codigo'],
            "datapostagem"=>$_POST['datapostagem'],
            "obs"=>$_POST['obs']
        );
        var_dump($dados);   
        $interaction->SalvaRegistroEnvio($_GET['cod'],$_POST['status'],$_POST['codigo'],$_POST['datapostagem'],$_POST['obs']);
        // header('Location: index_envio.php');
    }
}




?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title id="title">View Registro</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="icon" href="../img/correios-logo.png">

    <script src="../js/javascripts.js"></script>

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


    <style type="text/css">
        <?php include('../css/style.css');   ?>
    </style>
    <script>
        $(document).ready(function() {
            $('#table_master').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>

<body>

    <header id="cabecalho_master">
        <div id="cabecalho">
            <img class="imglogo " src="../img/correios-logo.png">
            <span class="titulo_cabecalho" id="titulocabecalho"></span>
        </div>

    </header>
    <div id="container_master_newregistro">
        <section id="container_inf">
            <article class="">
                <h3>Dados do Registro</h3>
                <form id="container_inf2" method="POST">
                    
                    <?php

                    if ($_GET) {
                        if ($_GET['type'] == 's') {
                            $interactionview->dadosViewEnvio($_GET['cod'], $_GET['type']);
                        } elseif ($_GET['type'] == 'e') {
                            $interactionview->dadosViewEnvio($_GET['cod'], $_GET['type']);
                        } elseif ($_GET['type'] == 'ee') {
                            # code...
                        }
                    }


                    ?>
                </form>
            </article>


        </section>
        <div id="Menu_lateral">
            <article id="container_user">
                <img src="../img/user.png">
                <div id="inf_user"> <?php $interaction->IpSearch(); ?></div>
            </article>
            <article class="buttons">
                <a href="index.php" id="voltar" class="btn btn-primary buttons">Voltar</a>
            </article>
        </div>
    </div>
</body>

</html>