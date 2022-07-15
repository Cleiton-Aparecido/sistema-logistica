<?php
require_once("config.php");
date_default_timezone_set('America/Sao_Paulo');
$interaction = new interaction();

$dados = $interaction->comprovante($_GET['id']);
// var_dump($dados);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovante</title>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script>
        $(document).ready(function() {

            window.print();
        });
    </script>

    <style>
        #titulo_cabecalho {
            text-align: center;
            font-size: 3.0em;
            font-weight: bold;
        }

        #container_itens {
            border: 1px solid black;
            padding: 5px;
        }

        #container_itens h3 {
            text-align: center;
        }

        .destaque_id {
            font-size: 1.2em;
            text-decoration: underline;
        }

        .itens {
            border: 1px solid black;
            padding: 5px;
            font-size: 1.3em;
            white-space: wrap;

        }

        .itens p {
            border-bottom: 1px solid black;
            white-space: nowrap;
            width: 100;
        }

        .itens span {
            font-weight: bold;
        }
        #assinaturas{
            padding: 10px;
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
            font-size: 1.5em;
        }
        .assinatura_unitario{
            margin: 15px;
            width: 45%;
            text-align: center;

        }
       
    </style>
</head>

<body>
<button class="btn btn-success" onclick="window.print();">imprimir</button>
        <a class="btn btn-primary" href="index_envio.php">Sair</a>
    <header>
        <h1 id="titulo_cabecalho">
            Comprovante para Envio
        </h1>
    </header>
    <section id="container_itens">
        <h3>Identificação Interna da Encomenda: <span class="destaque_id"> <?php echo $dados["id"]; ?> </span></h3>
        <article class="itens">
            <p> <span> Data do Registro: </span> <?php echo $dados['DataRegistro'] ?> </p>
            <p> <span> Ip Computador: </span> <?php echo $dados['Ipusuario'] ?> </p>
            <p> <span> status: </span> <?php echo $dados['status'] ?> </p>
            <p> <span> Setor: </span> <?php echo $dados['SetorRementente'] ?> </p>
            <p> <span> Encomenda </span> <?php echo $dados['Encomenda'] ?> </p>
            <p> <span> funcionario: </span> <?php echo $dados['funcionario'] ?> </p>
            <p> <span> cep: </span> <?php echo $dados['cep'] ?> </p>
            <p> <span> Rua/Avenida: </span> <?php echo $dados['rua'] ?> </p>
            <p> <span> numero: </span> <?php echo $dados['numero'] ?> </p>
            <p> <span> cidade: </span> <?php echo $dados['cidade'] ?> </p>
            <p> <span> bairro: </span> <?php echo $dados['bairro'] ?> </p>
            <p> <span> estado: </span> <?php echo $dados['estado'] ?> </p>
            <p> <span> complementar: </span> <?php echo $dados['complementar'] ?> </p>
            <div id="container_obs" style="border: none;">

                <p style="border: none;"><span> Observação: </span></p>
                <textarea name="" id="" cols="95%" rows="8"><?php echo $dados['Observacao'] ?></textarea>
            </div>


        </article>

        <article id="assinaturas">
            <div class="assinatura_unitario"> 
                <span> Assinatura Solicitante:</span> 
                <span class="campo_assinatura"> ____________________________</span>
            </div>
            <div class="assinatura_unitario">
                <span>Assinatura Preparo:</span> 
                 <span class="campo_assinatura"> ____________________________</span>
            </div>
            <div class="assinatura_unitario">
                <span>Assinatura Postagem:</span> 
                 <span class="campo_assinatura"> ____________________________</span>
            </div>
        </article>


    </section>
        
</body>

</html>