<?php



require_once("config.php");
$interaction = new interaction();
$interactionview = new interaction_view();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title id="title">Monitor</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/correios-logo.png">


    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>





    
    <script >
        <?php include("../js/javascripts_monitor.js") ?>
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</head>

<body>

    <header id="cabecalho_master">
        <div id="cabecalho">
            <img class="imglogo " src="../img/correios-logo.png">
            <span class="titulo_cabecalho" id="titulocabecalho">Monitor -</span>
            <span class="titulo_cabecalho" id="titulocabecalho"><?php echo date('Y');?></span>
        </div>
  
    </header>
    <div id="container_master">
        <section class="container_inf">
            <article class="container">
                
                <div id="enviosmonitor"></div>
               
            </article>



        </section>
              
    </div>
    <?php $interactionview->direito(); ?>
</body>

</html>