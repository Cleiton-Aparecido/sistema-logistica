
function requisitarPagina(url) {
    let ajax = new XMLHttpRequest();
   
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

var callbackErro = function() {
    document.getElementById('form_new_js').innerHTML = 'A requisição realizada não foi encontrada no servidor. <br> <strong> Erro: 404'
}



    
function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('rua').value=("");
    document.getElementById('bairro').value=("");
    document.getElementById('cidade').value=("");
    document.getElementById('uf').value=("");

}

function meu_callback(conteudo) {
if (!("erro" in conteudo)) {
    //Atualiza os campos com os valores.
    document.getElementById('rua').value=(conteudo.logradouro);
    document.getElementById('bairro').value=(conteudo.bairro);
    document.getElementById('cidade').value=(conteudo.localidade);
    document.getElementById('uf').value=(conteudo.uf);

    // if(conteudo.logradouro.length != 0){
    //     document.getElementById('rua').disabled=true;
    // }
    // if(conteudo.bairro.length != 0){
    //     document.getElementById('bairro').disabled=true;
    // }
    // if(conteudo.localidade.length != 0){
    //     document.getElementById('cidade').disabled=true;
    // }
    // if(conteudo.uf.length != 0){
    //     document.getElementById('uf').disabled=true;
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
if(cep.length == 8){
    console.log('caracteres ok')
    for (let index = 0; index < cep.length; index++) {
        cepformatado = cepformatado.concat(cep[index]);
        if(index == 4){
            cepformatado = cepformatado.concat('-');
        }

    }
document.getElementById("cep").value=cepformatado
}

//Verifica se campo cep possui valor informado.
if (cep != "") {

    //Expressão regular para validar o CEP.
    var validacep = /^[0-9]{8}$/;

    //Valida o formato do CEP.
    if(validacep.test(cep)) {

        //Preenche os campos com "..." enquanto consulta webservice.
        document.getElementById('rua').value="Aguarde...";
        document.getElementById('bairro').value="Aguarde...";
        document.getElementById('cidade').value="Aguarde...";
        document.getElementById('uf').value="Aguarde...";

        //Cria um elemento javascript.
        var script = document.createElement('script');

        //Sincroniza com o callback.
        script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

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
    document.getElementById('rua').disabled=false;
    document.getElementById('bairro').disabled=false;
    document.getElementById('cidade').disabled=false;
    document.getElementById('uf').disabled=false;
}
};
