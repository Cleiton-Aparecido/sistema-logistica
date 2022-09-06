<?php
require_once("config.php");
$interaction = new interaction();
$interactionAdmin = new interaction_admin();

$interaction->acessos('administrador');

$interactionAdmin->AcessoNaAbaParaEditarUsuario();


if(isset($_GET['usuario'])){
    $dadosusuario = $interactionAdmin->dadosusuario($_GET['usuario']);
}


if (isset($_POST['nome']) && isset($_POST['setor'])) {
    $acessos = array();
    $dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);
    foreach ($dados as $key => $value) {
        if($key == 'nome' || $key == 'setor'){
            $nome = $dados['nome'];
            $setor = $dados['setor'];
        }else if($value == 'on') {
            array_push($acessos, $key);
        }
    }
    $dadosformatado = array("id"=>$_GET['usuario'],
                            "nome"=>$nome,
                            "setor"=>$setor,
                            "acessos"=>$acessos);


    $interactionAdmin->SalvarAlteracao($dadosformatado);
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Editar Usuario: <?php echo $_GET['usuario'];?></title>
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
        
        #container_editar_usuario{
            margin: 10px;
            width:10%;
            min-width: 600px;
            display: flex;
            justify-content:space-around;
            border: 1px solid rgb(9, 216, 220);
            border-radius: 10px;
        }
        .opcoesformulario {
            border-radius: 10px;
            width: 90%;
            min-width: 500px;
            margin: 10px;
            padding: 5px;
        }
        .style_lista_acessos{
            font-size: 1.5em;
        }
        .style_checkbox{
            cursor: pointer;
            height: 20px;
            width: 20px;
            margin:5px ;
        }
        .style_checkbox_label{
            cursor: pointer;
        }
        .input_save{
            /* display: flex;
            justify-content: space-around; */
            text-align: center;

        }
        .input_save input{
           margin: 2px;
            
        }
        
        
    </style>

    <script>
        <?php include('../js/javascriptsAdmin.js');   ?>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>

<body>

    <header id="cabecalho_master">
        <?php $interaction->menulateral(); ?>
        <div id="cabecalho">
            <span class="titulo_cabecalho">Configurar Usuário</span>
        </div>

    </header>
    <div id="container_master_newregistro_editar_usuario">
        <section id="container_editar_usuario">
            <form action="" method="POST">

                <div class="opcoesformulario">
                    <label for="ipcomputador">Ip do Computador:</label>
                    <input type="text" id="ipcomputador" name="ipcomputador" class="form-control input_style-admin" value='<?php echo $dadosusuario['ipcomputador'] ?>' disabled>
                </div>

                <div class="opcoesformulario">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" class="form-control input_style-admin" value='<?php echo $dadosusuario['nome'] ?>'  >
                </div>

                <div class="opcoesformulario">
                    <label for="setor">Setor:</label>
                    <select class="form-control" name="setor" id="setor">
                        <option all="<?php echo $dadosusuario['setor'] ?>"> <?php echo $dadosusuario['setor'] ?> </option>
                        <?php $interaction->listasetoropcoes('Geral') ?>

                    </select>
                </div>

                <div class="opcoesformulario style_lista_acessos">
                    <?php 
                        $interactionAdmin->acessos_usuario($dadosusuario['acessos']);
                    ?>
                </div>

                <div class="opcoesformulario input_save">
                    <input type="submit" class="btn btn-success" value="Salvar"><br>
                    <input type="button" onclick="window.history.back();" class="btn btn-primary" value="Voltar">
                </div>
                
            </form>


        </section>

    </div>

    <footer style="text-align: center; color:cadetblue;">&copyCleiton Fonseca Versão 1.0</footer>
</body>

</html>