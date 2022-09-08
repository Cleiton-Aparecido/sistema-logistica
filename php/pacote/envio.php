<?php
require_once("config.php");
date_default_timezone_set('America/Sao_Paulo');
$interaction = new interaction();

?>
<script>
    <?php include('../js/javascripts.js');   ?>
    $cep = document.getElementById('cep')
</script>
<div class="container_from">
    <h3 class="titulo_menu" style="text-align: center;">Envio de Encomenda</h3>
</div>

<div class="container_from ">
    <label for="setor">Setor:</label>
    <span id="setoralerta"></span>
    <select class="form-control input_style" name="setor" id="setor" onblur="alertainputclear(this.name)">
        <option value="null">Escolha </option>
        <?php $interaction->listasetoropcoes('ativo'); ?>
    </select>
</div>
<div class="container_from ">
    <label for="encomenda">Tipo de encomenda:</label>
    <span id="encomendaalerta"></span>
    <select class="form-control input_style" name="encomenda" id="encomenda" onblur="alertainputclear(this.name)">
        <option value="null">Escolha </option>
        <?php $interaction->listaencomenda('ativo'); ?>
    </select>
</div>
<div class="container_from ">
    <label for="tipoenvio">Tipo de Envio:</label>
    <span id="tipoenvioalerta"></span>
    <select class="form-control input_style" name="tipoenvio" id="tipoenvio" onblur="alertainputclear(this.name)">
        <option value="null">Escolha </option>
        <?php $interaction->listatipodeenvio('ativo'); ?>
    </select>
</div>
<div class="container_from">
    <label for="func">Funcionario Responsável:</label>
    <span id="funcalerta"></span>
    <input class="form-control input_style" placeholder="Nome Completo" type="text" name="func" id="func" onblur="alertainputclear(this.name)">
</div>
<div class="container_from">
    <label for="cepenvio">Cep:</label>
    <span id="cepenvioalerta"></span>
    <input class="form-control input_style " type="text" name="cepenvio" id="cepenvio" placeholder="Ex: 00000-000"  data-mask-selectonfocus="true" onblur="pesquisacep(this.value);">
</div>
<div class="container_from">
    <label for="endereco">Rua</label>
    <span id="enderecoalerta"></span>
    <input class="form-control input_style" placeholder="Ex: Rua ou Avenida" type="text" name="endereco" id="endereco" onblur="alertainputclear(this.name)">
</div>
<div class="container_from">
    <label for="num">Número</label>
    <span id="numalerta"></span>
    <input class="form-control input_style" placeholder=" Ex: Numero da casa" type="text" name="num" id="num" onblur="alertainputclear(this.name)">
</div>
<div class="container_from">
    <label for="bairro">Bairro:</label>
    <span id="bairroalerta"></span>
    <input class="form-control input_style " type="text" name="bairro" placeholder="Ex: Bairro Destinatario" id="bairro" onblur="alertainputclear(this.name)">
</div>
<div class="container_from">
    <label for="cidade">Cidade</label>
    <span id="cidadealerta"></span>
    <input class="form-control input_style " type="text" name="cidade" placeholder="Ex: Cidade" id="cidade" onblur="alertainputclear(this.name)">

</div>
<div class="container_from">
    <label for="uf">Estado</label>
    <span id="ufalerta"></span>
    <select class="form-control input_style " type="text" name="uf" id="uf" onblur="alertainputclear(this.name)">
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
    
    <input class="form-control input_style " type="text" name="complementar" placeholder="Ex: Casa dos Fundos" id="complementar" >
</div>
<div class="container_from">
    <label for="obs">Observação</label>
   
    <textarea class="form-control input_style " type="text" name="obs" placeholder="Observação" id="obs"></textarea>
</div>


<div class="container_from">
    <input type="button" onclick="submitnewenvio();" value="Registrar" class="btn btn-primary" style="margin:auto;">
</div>