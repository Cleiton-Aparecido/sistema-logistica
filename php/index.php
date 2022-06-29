<?php
date_default_timezone_set('America/Sao_Paulo');
require_once("config.php");
$interaction = new interaction();
if (isset($_POST['setor']) && isset($_POST['datainicio']) && isset($_POST['datafinal']) && isset($_POST['busca'])) {
    $busca = $_POST['busca'];
    $setor = $_POST['setor'];
    $datainicial = $_POST['datainicio'];
    $datafinal = $_POST['datafinal'];
}
if ((!isset($_POST['datainicio'])) && (!isset($_POST['datafinal'])) && (!isset($_POST['setor'])) && !isset($_POST['busca'])) {
    $datainicial = date('Y-m-d');
    $datafinal = date('Y-m-d');
    $setor = 'all';
    $busca = '';
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title id="title">Logística Reversa</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <link rel="icon" href="../img/correios-logo.png">

    <script>
        <?php include('../js/javascripts.js');   ?>
    </script>

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
            <img class="imglogo " src="../img/correios-logo.png" alt="">
            <span class="titulo_cabecalho" id="titulo_principal_cabeçalho">Logística Reversa</span>
        </div>

    </header>
    <section id="container_master">
        <article id="container_menu_usuario">
            <article id="container_primary">
                <section id="menu_busca">
                    <h5 style="text-align: center;">MENU BUSCA</h5>
                    <form class="container_menu" method="POST" name="menu" onsubmit=''>
                        <label for="setor">Setor</label>
                        <select class="form-control" name="setor" id="setor">
                            <option value="all">Todos</option>
                            <?php $interaction->listasetoropcoes() ?>
                        </select>
                        <label for="buscar">Buscar Codigo:</label>
                        <input name="busca" type="text" id="buscar" class="form-control" placeholder=" <?php echo $busca; ?>">
                        <label for="datainicio">Data Inicio:</label>
                        <input name="datainicio" type="date" id="datainicio" class="form-control" value="<?php echo $datainicial; ?>">
                        <label for="datafinal">Data Final:</label>
                        <input name="datafinal" type="date" id="datafinal" class="form-control" value="<?php echo $datafinal; ?>">

                        <input class="btn btn-primary" type="submit" value="Buscar">
                    </form>
                </section>


            </article>

            <div id="Menu_lateral" >
                <article id="container_user">
                    <img src="../img/user.png">
                    <div id="inf_user"> <?php $interaction->IpSearch(); ?></div>
                </article>

                <article class="buttons">
                    <a href="index_newRegister.php" class="btn btn-success buttons">Novo Registro</a>
                    <a href="index_entrega.php" class="btn btn-primary buttons">Entregas</a>
                    <a href="index_envio.php" class="btn btn-secondary buttons">Enviadas</a>
                    <?php
                    $interaction->buttonadmin();
                    ?>
                </article>
            </div>
            
        </article>
        <article id="container_table">
            <table id="table_master" class="table display" style="width:100%">
                <thead class="thead-dark">
                    <tr class="table_title">
                        <th style="border-top-left-radius: 10px;" class="align-text-bottom">ID</th>
                        <th class="align-text-bottom">Registro</th>
                        <th class="align-text-bottom">Usuario</th>
                        <th class="align-text-bottom">Codigo</th>
                        <th class="align-text-bottom">Remetente</th>
                        <th class="align-text-bottom">DataColeta</th>
                        <th class="align-text-bottom">Status</th>
                        <th class="align-text-bottom">Item</th>
                        <th class="align-text-bottom">Data entrega</th>
                        <th class="align-text-bottom">Setor</th>
                        <th style="border-top-right-radius: 10px;" class="align-text-bottom">View</th>
                    </tr>
                </thead>
                <tbody >
                    <?php
                    if (isset($_POST['datainicio'])) {
                        echo  $interaction->SearchRelatorio($setor, $busca, $datainicial, $datafinal);
                    } else {
                        echo  $interaction->SearchRelatorio('all', '', date('Y-m-d'), date('Y-m-d'));
                    }
                    ?>

                </tbody>
            </table>
        </article>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


</body>

</html>