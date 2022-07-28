function loading(typetable) {
    if (!document.getElementById('loading')) {
        let imgLoading = document.createElement('img')
        imgLoading.id = 'loading';
        imgLoading.src = '../img/loading.gif';
        imgLoading.className = 'rounded mx-auto d-block'
        imgLoading.style.width = '70px';
        document.getElementById('form' + typetable).appendChild(imgLoading);
        document.getElementById(typetable + 'new').disabled = true;
        document.getElementById('salvar' + typetable).disabled = true;
    }
}

function salvaralteracaousuario(id){
    var nome = document.getElementById("nome:"+id).value;
    var ipcomputador = document.getElementById("ipcomputador:"+id).value;
    var nivel = document.getElementById("nivel:"+id).value;
    var setor = document.getElementById("setor:"+id).value;
    
    $.ajax({
        type: "POST",
        url: "AdminSetting.php",
        data: { tipo: 'atualizarusuario',id:id,nome:nome,ipcomputador:ipcomputador,nivel:nivel,setor:setor },
        success: function (result) {
            $('#RetornoSalvarUsuario').html(result);
            loadtableUsuario('usuario');
            setTimeout(function () {
                $("#RetornoSalvarUsuario").html('');
            }, 4000);
        },
        error: function () {
            console.log('Erro ao Atualizar');
            setTimeout(function () {
                $("#RetornoSalvarUsuario").html('erro inseperado');
            }, 4000);
           
        },
    });
    


}

function loadtable(typetable) {

    let imgLoading = document.createElement('img')
    imgLoading.id = 'loading';
    imgLoading.src = '../img/loading.gif';
    imgLoading.className = 'rounded mx-auto d-block'
    imgLoading.style.width = '70px';
    document.getElementById('form' + typetable).appendChild(imgLoading);
    
    $.ajax({
        type: "POST",
        url: "AdminSetting.php",
        data: { tipo: 'atttable' + typetable },
        success: function (result) {
            $('#form' + typetable).html(result);
            document.getElementById(typetable + 'new').disabled = false
            document.getElementById('salvar' + typetable).disabled = false
        },
        error: function () {
            console.log('Erro ao Atualizar');
            document.getElementById(typetable + 'new').disabled = false
            document.getElementById('salvar' + typetable).disabled = false
        },
    });
    
}

function loadtableUsuario(typetable) {

    let imgLoading = document.createElement('img')
    imgLoading.id = 'loading';
    imgLoading.src = '../img/loading.gif';
    imgLoading.className = 'rounded mx-auto d-block'
    imgLoading.style.width = '70px';
    document.getElementById('usuario').appendChild(imgLoading);
    
    $.ajax({
        type: "POST",
        url: "AdminSetting.php",
        data: { tipo: 'atttableusuario' },
        success: function (result) {
            $('#usuario').html(result);
            
        },
        error: function () {
            console.log('Erro ao Atualizar');
    
        },
    });
    
}

function status(value, id,type) {
    var item = "status" + type;
    $.ajax({
        type: "POST",
        url: "AdminSetting.php",
        data: { value: value, tipo: item },
        success: function (result) {
            $('#' + id).html(result);
            loadtable(type);

        },
        error: function () {
            console.log('Erro ao Atualizar');
        }
    });
};

$(document).ready(function () {
    loadtable('encomenda');
    loadtable('setor');
    loadtable('transporte');
    loadtableUsuario('usuario');

    // Adicionar novo setor
    $("#salvarsetor").on("click", function () {
        var NewSetor = $('#setornew').val();
        var type = 'setornovo';
        if (NewSetor == '' || NewSetor == ' ') {
            $("#resultSector").html('Campo Vazioo');
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
                    loadtable('setor');
                    setTimeout(function () {
                        $("#resultSector").html('');

                    }, 4000);
                },
                error: function () {
                    $("#resultSector").html('Erro inesperado ao inserir!');
                    loadtable('setor');
                    setTimeout(function () {
                        $("#resultSector").html('');

                    }, 4000);

                }
            });
        }

    });

    // Adicionar nova encomenda
    $("#salvarencomenda").on("click", function () {
        var Newencomenda = $('#encomendanew').val();
        var type = 'encomendanovo';
        if (Newencomenda == '' || Newencomenda == ' ') {
            $("#resultencomenda").html('Campo Vazio');
            setTimeout(function () {
                $("#resultencomenda").html('');
            }, 3000);
        }
        else {
            $.ajax({
                type: "POST",
                url: "AdminSetting.php",
                data: { Newencomenda: Newencomenda, tipo: type },
                success: function (result) {
                    $("#resultencomenda").html(result);
                    $('#form_new_encomenda').trigger("reset");
                    loadtable('encomenda');
                    setTimeout(function () {
                        $("#resultencomenda").html('');

                    }, 4000);
                },
                error: function () {
                    $("#resultencomenda").html('Erro inesperado ao inserir!');
                    loadtable('encomenda');
                    setTimeout(function () {
                        $("#resultSector").html('');

                    }, 4000);

                }
            });
        }
    });

     // Adicionar nova transporte
     $("#salvartransporte").on("click", function () {
        var Newtransporte = $('#transportenew').val();
        var type = 'transportenovo';
        console.log(Newtransporte,'/n',type)
        if (Newtransporte == '' || Newtransporte == ' ') {
            $("#resulttransporte").html('Campo Vazio');
            setTimeout(function () {
                $("#resulttransporte").html('');
            }, 3000);
        }
        else {
            $.ajax({
                type: "POST",
                url: "AdminSetting.php",
                data: { Newtransporte: Newtransporte, tipo: type },
                success: function (result) {
                    $("#resulttransporte").html(result);
                    $('#form_new_transporte').trigger("reset");
                    loadtable('transporte');
                    setTimeout(function () {
                        $("#resulttransporte").html('');

                    }, 4000);
                },
                error: function () {
                    $("#resulttransporte").html('Erro inesperado ao inserir!');
                    loadtable('transporte');
                    setTimeout(function () {
                        $("#resulttransporte").html('');

                    }, 4000);

                }
            });
        }
    });


}); 