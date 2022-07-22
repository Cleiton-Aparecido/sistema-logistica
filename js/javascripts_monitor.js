function horaedata(){
    console.log('teste');
}

function entrada(){
    $.ajax({
        type: "POST",
        url: "AdminSetting.php",
        data: { tipo:"monitorPOSEntrada"},
        success: function (result) {
            $('#enviosmonitor').html(result);
        },
        error: function () {
            console.log('Erro ao Atualizar');
        }
    });
}

function envio(){
    $.ajax({
        type: "POST",
        url: "AdminSetting.php",
        data: { tipo:"monitorPOSEnvio"},
        success: function (result) {
            $('#entradamonitor').html(result);
        },
        error: function () {
            console.log('Erro ao Atualizar');
        }
    });
}


$(document).ready(function () {

 
    entrada();
    envio();
    setInterval(function (){
        
        entrada();
        envio();

    }, 5000);

}); 