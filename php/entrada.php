<?php 
require_once("config.php");
date_default_timezone_set('America/Sao_Paulo');
$interaction = new interaction();


?>


<div  class="container_from">
        <h3 class="titulo_menu" style="text-align: center;">Entrada de encomenda</h3>    
</div>
<div class="container_from ">
    <label for="setor">Setor Destinatário:</label>
    <select class="form-control input_style" name="setor" id="setor">
        <option value="null">Escolha </option>
        <?php $interaction->listasetoropcoes();?>
    </select>
</div>
<div class="container_from ">
    <label for="encomenda">Tipo de encomenda:</label>
    <select class="form-control input_style" name="encomenda" id="encomenda">
        <option value="null">Escolha </option>
        <?php $interaction->listaencomenda(); ?>
    </select>
</div>
<div class="container_from">
    <label for="codigo">Codigo rastreio:</label>
    <input class="form-control input_style " type="text" name="codigo" id="codigo">
</div>
<div class="container_from">
    <label for="remetente">Remetente:</label>
    <input class="form-control input_style " type="text" name="remetente" id="remetente">
</div>
<div class="container_from">
    <label for="obs">Observação:</label>
    <input class="form-control input_style " type="text" name="obs" id="obs">
</div>
<div class="container_from">
    <label for="datacoleta">Data coleta:</label>
    <input class="form-control input_style " type="date" name="datacoleta" id="datacoleta" value=<?php echo date("Y-m-d"); ?>>
</div>
<div class="container_from">
    <input type="submit" value="Registrar" class="btn btn-primary" style="margin:auto;">
</div>