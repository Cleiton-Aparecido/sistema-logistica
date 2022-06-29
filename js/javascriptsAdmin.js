function loading(){
    if(!document.getElementById('loading')) {
        let imgLoading = document.createElement('img')
        imgLoading.id = 'loading';
        imgLoading.src = '../img/loading.gif';
        imgLoading.className = 'rounded mx-auto d-block'
        imgLoading.style.width= '70px';
        document.getElementById('formsetor').appendChild(imgLoading)
        document.getElementById('setornew').disabled = true 
        document.getElementById('salvarSetor').disabled = true 
        
    }
}

function statusSetor(setor, idsetor) {
    $.ajax({
        type: "POST",
        url: "AdminSetting.php",
        data: { setor: setor, tipo: 'statusSetor' },
        success: function (result) {
            $('#' + idsetor).html(result);
            loadtable();

        },
        error: function () {
            console.log('Erro ao Atualizar');
        }

    });


}

function loadtable() {
    $.ajax({
        type: "POST",
        url: "AdminSetting.php",
        data: { tipo: 'atttablesetor' },
        success: function (result) {
            $('#formsetor').html(result);
            document.getElementById('setornew').disabled = false 
            document.getElementById('salvarSetor').disabled = false 
        },
        error: function () {
            console.log('Erro ao Atualizar');
            document.getElementById('setornew').disabled = false 
            document.getElementById('salvarSetor').disabled = false 
        }
    });
    loading();
    
}

$(document).ready(function () {
    loadtable();
    $("#salvarSetor").on("click", function () {
        var NewSetor = $('#setornew').val();
        var type = 'setornovo';
        if (NewSetor == '' || NewSetor == ' ') {
            $("#resultSector").html('Campo Vazio');
            setTimeout(function () {
                $("#resultSector").html('');
            }, 3000);
        }
        else {
            $("#resultSector");
            $.ajax({
                type: "POST",
                url: "AdminSetting.php",
                data: { NewSetor: NewSetor, tipo: type },
                success: function (result) {
                    $("#resultSector").html(result);
                    $('#form_new_setor').trigger("reset");
                    loadtable();
                    setTimeout(function () {
                        $("#resultSector").html('');

                    }, 4000);
                },
                error: function () {
                    $("#resultSector").html('Deu ruim');

                }
            });
        }
    });


}); 