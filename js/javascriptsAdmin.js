function statusSetor(setor,idsetor){
    console.log('#'+setor);
    $.ajax({
        type: "POST",
        url: "AdminSetting.php",
        data: {setor:setor,tipo:'statusSetor'},
        success: function(result){
            $('#'+idsetor).html(result);
        },
        error: function(){
            console.log('Erro ao Atualizar');
        }

    });
    
}

$(document).ready(function(){
        $("#salvarSetor").on("click",function(){
            var NewSetor = $('#setornew').val();
            var type = $('#type').val();
            $("#resultSector");
            $.ajax({
                type: "POST",
                url: "AdminSetting.php",
                data: {NewSetor : NewSetor,tipo:type}, 
                success: function(result){
                    $("#resultSector").html(result);
                    $('#form_new_setor').trigger("reset");
                    setTimeout(function(){
                        $("#resultSector").html('');
                    },4000);
                },
                error: function(){
                    $("#resultSector").html('Deu ruim');
                    
                }
            });
        });

    
}); 