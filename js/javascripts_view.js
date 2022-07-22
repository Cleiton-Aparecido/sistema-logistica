
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





$(document).ready(function () {
    
    
   
}); 