function horaedata(){
    console.log('teste');
}

function entrada(){
    $.ajax({
        type: "POST",
        url: "AdminSetting.php",
        data: { tipo:"monitorPOS"},
        success: function (result) {
            $('#enviosmonitor').html(result);
        },
        error: function () {
            console.log('Erro ao Atualizar');
        }
    });
}



$(document).ready(function () {

 
    entrada();
  
    setInterval(function (){
        
        entrada();
       

    }, 1000);

}); 