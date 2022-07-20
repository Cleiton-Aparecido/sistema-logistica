
function historico(idregistro,tiporegistro){
        let imgLoading = document.createElement('img')
        imgLoading.id = 'loading';
        imgLoading.src = '../img/loading.gif';
        imgLoading.className = 'rounded mx-auto d-block'
        imgLoading.style.width = '70px';
        document.getElementById('historico').style.border = "1px solid black";
        document.getElementById('historico').appendChild(imgLoading);
        
        
        $.ajax({
            type: "POST",
            url: "AdminSetting.php",
            data: { tipo:"historico", id:idregistro,tiporegistro:tiporegistro },
            success: function (result) {
                $('#historico').html(result);
        },
        error: function () {
            console.log('Erro ao Atualizar');
        }
    });
}

function editar_informacoes(type){
    
    $.ajax({
        type: "POST",
        url: "AdminSetting.php",
        data: { tipo:"edicao_view"},
        success: function (result) {
            console.log(result);
            if(result == true){
                document.getElementById("Codigo").disabled = false;
                document.getElementById("remetente").disabled = false;
                document.getElementById("encomenda").disabled = false;
                document.getElementById("setor").disabled = false;
                document.getElementById("DataEntrega").disabled = false;
                document.getElementById("obs").disabled = false;
                document.getElementById("datacoleta").disabled = false;
                document.getElementById("status").disabled = false;
                document.getElementById("salvar").classList.remove("btn-danger");
                document.getElementById("salvar").classList.add("btn-success");
            }
    },
    error: function () {
        console.log("Erro ao Atualizar");
    }
});
}


$(document).ready(function () {
    
    
   
}); 