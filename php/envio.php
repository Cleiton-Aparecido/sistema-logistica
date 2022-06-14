<?php
require_once("config.php");
date_default_timezone_set('America/Sao_Paulo');
$interaction = new interaction();
?>
<script>
     <?php include('../js/javascripts.js');   ?>
    $cep = document.getElementById('cep')
     
</script>
<div  class="container_from">
        <h3 class="titulo_menu" style="text-align: center;">Envio de Encomenda</h3>    
</div>
<div class="container_from ">
    <label for="setor">Setor:</label>
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
    <label for="func">Funcionario Responsável:</label>
    <input class="form-control input_style" placeholder="Nome Completo" type="text" name="func" id="func">
</div>
<div class="container_from">
    <label for="cep">Cep:</label>
    <input class="form-control input_style "  type="text" name="cep" id="cep" placeholder="Ex: 00000-000" size="2" data-mask-selectonfocus="true"
    onblur="pesquisacep(this.value)"
    >
</div>
<div class="container_from">
    <label for="rua">Rua</label>
    <input class="form-control input_style"  placeholder="Ex: Rua ou Avenida" type="text" name="rua" id="rua">
</div>
<div class="container_from">
    <label for="num">Número</label>
    <input class="form-control input_style" placeholder=" Ex: Numero da casa" type="text" name="num" id="num">
</div>
<div class="container_from">
    <label for="bairro">Bairro:</label>
    <input class="form-control input_style " type="text" name="bairro" placeholder="Ex: Bairro Destinatario" id="bairro">
</div>
<div class="container_from">
    <label for="cidade">Cidade</label>
    <input class="form-control input_style " type="text" name="cidade" placeholder="Ex: Cidade" id="cidade">
    
</div>
<div class="container_from">
    <label for="uf">Estado</label>
        <select class="form-control input_style " type="text" name="uf" id="uf">
            <option value="null">Selecione</option>
            <option value="AC">AC</option>
            <option value="AL">AL</option>
            <option value="AP">AP</option>
            <option value="AM">AM</option>
            <option value="BA">BA</option>
            <option value="CE">CE</option>
            <option value="DF">DF</option>
            <option value="ES">ES</option>
            <option value="GO">GO</option>
            <option value="MA">MA</option>
            <option value="MS">MS</option>
            <option value="MT">MT</option>
            <option value="MG">MG</option>
            <option value="PA">PA</option>
            <option value="PB">PB</option>
            <option value="PR">PR</option>
            <option value="PE">PE</option>
            <option value="PI">PI</option>
            <option value="RJ">RJ</option>
            <option value="RN">RN</option>
            <option value="RS">RS</option>
            <option value="RO">RO</option>
            <option value="RR">RR</option>
            <option value="SC">SC</option>
            <option value="SP">SP</option>
            <option value="SE">SE</option>
            <option value="TO">TO</option>
    </select>
</div>
<div class="container_from">
    <label for="complementar">complementar</label>
    <input class="form-control input_style " type="text" name="complementar" placeholder="Ex: Casa dos Fundos" id="complementar">
</div>
<div class="container_from">
    <label for="obs">Observação</label>
    <input class="form-control input_style " type="text" name="obs" placeholder="Observação" id="obs">
</div>


<div class="container_from">
    <input type="submit" value="Registrar" class="btn btn-primary" style="margin:auto;">
</div>
