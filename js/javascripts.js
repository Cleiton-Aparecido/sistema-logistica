
function requisitarPagina(url) {
    let ajax = new XMLHttpRequest();
    var url = "../php/pacote/" + url
    ajax.open('GET', url)
    ajax.onreadystatechange = () => {

        if (ajax.readyState == 4 && ajax.status == 200) {

            document.getElementById('form_new_js').innerHTML = ajax.responseText


        } else if (ajax.readyState == 4 && ajax.status == 404) {
            callbackErro();
        }
    }
    ajax.send()

}

var callbackErro = function () {
    document.getElementById('form_new_js').innerHTML = 'A requisição realizada não foi encontrada no servidor. <br> <strong> Erro: 404'
}

function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('endereco').value = ("");
    document.getElementById('bairro').value = ("");
    document.getElementById('cidade').value = ("");
    document.getElementById('uf').value = ("");

}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('endereco').value = (conteudo.logradouro);
        document.getElementById('bairro').value = (conteudo.bairro);
        document.getElementById('cidade').value = (conteudo.localidade);
        document.getElementById('uf').value = (conteudo.uf);

        // if(conteudo.logradouro.length != 0){
        //     document.getElementById('endereco').disabled=true;
        //      var asd = document.querySelector('#endereco').value
        //      document.getElementById('endereco').disabled=true;
        // }
        // if(conteudo.bairro.length != 0){
        //     document.getElementById('bairro').disabled=true;

        // }
        // if(conteudo.localidade.length != 0){
        //     document.getElementById('cidade').disabled=true;
        //     console.log(document.querySelector('#cidade').value)
        // }
        // if(conteudo.uf.length != 0){
        //     document.getElementById('uf').disabled=1;
        // }
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function pesquisacep(valor) {
    
    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');


    var cepformatado = '';
    if (cep.length == 8) {
        console.log('caracteres ok')
        for (let index = 0; index < cep.length; index++) {
            cepformatado = cepformatado.concat(cep[index]);
            if (index == 4) {
                cepformatado = cepformatado.concat('-');
            }

        }
        document.getElementById("cepenvio").value = cepformatado
    }

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {
            alertainputclear('cepenvio');
            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('endereco').value = "Aguarde...";
            document.getElementById('bairro').value = "Aguarde...";
            document.getElementById('cidade').value = "Aguarde...";
            document.getElementById('uf').value = "Aguarde...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
        document.getElementById('endereco').disabled = false;
        document.getElementById('bairro').disabled = false;
        document.getElementById('cidade').disabled = false;
        document.getElementById('uf').disabled = false;
    }
};

function submitformentrega(){
    
    if(document.getElementById('status').value == 'null' || document.getElementById('dataentrega').value == "" ){
        alert('A campos vazios');
    }
    else{
        document.getElementById("formealterarstatusentrega").submit();
    }
};


function submitnewenvio(){
    if(document.getElementById("setor").value == "null"){
        alertainput("setor");
    }
    else if(document.getElementById("encomenda").value == "null"){
        alertainput("encomenda");
    }
    else if(document.getElementById("tipoenvio").value == "null"){
        alertainput("tipoenvio");
    }
    else if(document.getElementById("func").value == ""){
        alertainput("func");
    }
    else if(document.getElementById("cepenvio").value == ""){
        alertainput("cepenvio");
    }
    else if(document.getElementById("endereco").value == ""){
        alertainput("endereco");
    }
    else if(document.getElementById("num").value == ""){
        alertainput("num");
    }
    else if(document.getElementById("bairro").value == ""){
        alertainput("bairro");
    }
    else if(document.getElementById("cidade").value == ""){
        alertainput("cidade");
    }
    else if(document.getElementById("uf").value == "null"){
        alertainput("uf");
    }
    else{
        document.getElementById("FormEntrega").submit();
        // alert("enviar");
    }
};

function alertainput(opcao){
    document.getElementById(opcao).style.border = "2px solid red"
    document.getElementById(opcao + "alerta").innerHTML = "Campo Vazio!!"
    document.getElementById(opcao + "alerta").style.color = "red"
};
function alertainputclear(opcao){
    document.getElementById(opcao + "alerta").innerHTML = ''
    document.getElementById(opcao).style.borderColor = ""
    document.getElementById(opcao).style.borderWidth = "1px"
};
function loadingtble(){
    

    if(!document.getElementById('loading')) {
        let imgLoading = document.createElement('img')
        imgLoading.id = 'loading';
        imgLoading.src = '../img/loading.gif';
        imgLoading.className = 'rounded mx-auto d-block'
        imgLoading.style.columnSpan = '10'
        imgLoading.style.width= '70px';
        document.getElementById('tabledados').appendChild(imgLoading)
        document.getElementById('setor').disabled = true 
        document.getElementById('buscar').disabled = true 
        document.getElementById('datainicio').disabled = true 
        document.getElementById('datafinal').disabled = true 
        
    }
}
function formantacaojquery() {
    
}

function buscaBando(){
    var setor = document.getElementById('setor').value
    var buscar = document.getElementById('buscar').value
    var datainicio = document.getElementById('datainicio').value
    var datafinal = document.getElementById('datafinal').value

    $.ajax({
        type: "POST",
        url: "AdminSetting.php",
        data: { tipo: 'loadtable',setor:setor, buscar:buscar, datainicio:datainicio, datafinal:datafinal},
        success: function (result) {
            
           
            $('#tabledados').html(result);
            document.getElementById('setor').disabled = false 
            document.getElementById('buscar').disabled = false 
            document.getElementById('datainicio').disabled = false 
            document.getElementById('datafinal').disabled = false 
                  
            
        },
        error: function () {
            console.log('Erro ao Atualizar');
            document.getElementById('setor').disabled = false 
            document.getElementById('buscar').disabled = false 
            document.getElementById('datainicio').disabled = false 
            document.getElementById('datafinal').disabled = false 
        }
        

    });
    loadingtble();
    

}

$(document).ready(function () {

    $('#table_master').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
    });
   

}); 