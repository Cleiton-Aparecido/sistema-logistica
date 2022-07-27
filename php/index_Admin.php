<?php
require_once("config.php");
$interaction = new interaction();
$interactionAdmin = new interaction_admin();

$interaction->acessos('admin');


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Administrador</title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/jquery-form/form@4.3.0/dist/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>




    <style type="text/css">
        <?php include('../css/style_admin.css');   ?>
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
    <script>
        <?php include('../js/javascriptsAdmin.js');   ?>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>

<body>

    <header id="cabecalho_master">
        
        <div id="cabecalho">
            <span class="titulo_cabecalho">Configurações</span>
        </div>

    </header>
    <div id="container_master_newregistro">
        <div id="Menu_lateral">
            <article id="container_user">
                <img src="../img/user.png">
                <div id="inf_user"> <?php $interaction->IpSearch(); ?></div>
            </article>
            <article class="buttons">
                <a href="index.php" class="btn btn-primary buttons">Sair</a>
            </article>
        </div>

        <section id="container_inf">

            <article class="container_item_usuario">
                <span>
                <a class="btn btn-primary" href="https://docs.google.com/spreadsheets/d/1G_nxggR-Hd49r34unuUZlEZV-lQIiYNfy3Rg5am19hk/edit?usp=sharing">Lista Acessos</a>
                    <h4 class="titulo_container"> Usuario</h4>
                </span>
                    <div id='formusuario' class='container_item_interno'>
                    </div>
                <div id='RetornoSalvarUsuario'></div>
            </article>

            <article class="container_item">
                <h4 class="titulo_container">Setores</h4>
                <div id='formsetor' class='container_item_interno'>
                </div>
                <Form action="" method="post" id='form_new_setor'>
                    <label for="setornew" class="titulo_menu_input">Adicionar Novo Setor</label>
                    <input type="text" class="form-control" id="setornew" name="setornew">
                    <input type="hidden" name="type" id="type" value="setor">
                    <input type="button" value="Salvar" id="salvarsetor" class="btn btn-primary buttons">
                </Form>
                <div id="resultSector" style="color: green; font-size:20px;">

                </div>

            </article>

            <article class="container_item">
                <h4 class="titulo_container">Tipo de Encomenda</h4>
                <div id='formencomenda' class='container_item_interno'>
                </div>
                <Form action="" method="post" id='form_new_encomenda'>
                    <label for="encomendanew" class="titulo_menu_input">Adicionar Novo Tipo de Encomenda</label>
                    <input type="text" class="form-control" id="encomendanew" name="encomendanew">
                    <input type="hidden" name="type" id="type" value="encomenda">
                    <input type="button" value="Salvar" id="salvarencomenda" class="btn btn-primary buttons">
                </Form>

                <div id="resultencomenda" style="color: green; font-size:20px;">
                </div>
            </article>
            <article class="container_item">
                <h4 class="titulo_container">Tipo de Transporte</h4>
                <div id='formtransporte' class='container_item_interno'>
                </div>
                <Form action="" method="post" id='form_new_transporte'>
                    <label for="transportenew" class="titulo_menu_input">Adicionar Novo Tipo de transporte</label>
                    <input type="text" class="form-control" id="transportenew" name="transportenew">
                    <input type="hidden" name="type" id="type" value="transporte">
                    <input type="button" value="Salvar" id="salvartransporte" class="btn btn-primary buttons">
                </Form>

                <div id="resulttransporte" style="color: green; font-size:20px;">
                </div>

            </article>



        </section>


    </div>
    <footer style="text-align: center; color:cadetblue;">&copyCleiton Fonseca Versão 1.0</footer>
</body>

</html>