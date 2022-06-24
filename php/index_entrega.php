<?php
require_once("config.php");
date_default_timezone_set('America/Sao_Paulo');
$interaction = new interaction();
if (!isset($_POST['dataentrega'])) {
    // echo '<script>alert("Paramentros inválidos")</script>';
    echo '';
} else if (isset($_POST['dataentrega'])) {
        // $interaction->alterarStatus($_POST['dataentrega'], $_POST['listagrupo'], $_POST['status']);
        $dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);
        $interaction->alterarstatusentrega($dados);
        header('Location: index.php');
    
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

    <script src="../js/javascripts.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script> -->
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
        <?php include('../js/javascripts.js');   ?>

        	
    </script>
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
            <img class="imglogo " src="../img/correios-logo.png" alt="">
            <span class="titulo_cabecalho">Entrega de Encomenda</span>
        </div>
    </header>
    <section id="container_master">
        <form class="container_menu" method="POST" name="menu" id="formealterarstatusentrega">
            <article id="container_menu_usuario">
                <article id="container_primary">
                    <section id="menu_busca">
                        <h5 style="text-align: center;">MENU DE ENTREGA</h5>
                        <label for="listagrupo">Status de Entrega:</label>
                        <select class="form-control" name="status" id="status">
                            <option value="null">Escolher</option>
                            <?php $interaction->listaDeStatus(); ?>
                        </select>
                        <label for="Dataentrega">Data Entrega:</label>
                        <input name="dataentrega" type="datetime-local" id="dataentrega" class="form-control">
                        <input class="btn btn-primary" type="button" value="Salvar" onclick=" submitformentrega();">
                    </section>

                </article>

                <div id="Menu_lateral">
                    <article id="container_user">
                        <img src="../img/user.png">
                        <div id="inf_user"> <?php $interaction->IpSearch(); ?></div>
                    </article>

                    <article class="buttons">
                        <a href="index.php" class="btn btn-primary buttons">Voltar</a>
                    </article>
                </div>
            </article>
            <article id="container_table">
                <table id="table_master" class="table display" style="width:100%">
                    <thead class="thead-dark">
                        <tr class="table_title">
                        <th style="border-top-left-radius: 10px;" class="align-text-bottom">Seleção</th>
                        <th class="align-text-bottom">ID</th>
                        <th class="align-text-bottom">Registro</th>
                        <th class="align-text-bottom">Usuario</th>
                        <th class="align-text-bottom">Codigo</th>
                        <th class="align-text-bottom">Remetente</th>
                        <th class="align-text-bottom">DataColeta</th>
                        <th class="align-text-bottom">Item</th>
                        <th class="align-text-bottom">Status</th>
                        <th class="align-text-bottom">Data entrega</th>
                        <th class="align-text-bottom">Setor</th>
                        <th style="border-top-right-radius: 10px;" class="align-text-bottom">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        #informa conteudo
                        $interaction->listagrupopendente();
                        ?>
                    </tbody>
                </table>
            </article>
        </form>
    </section>
</body>

</html>