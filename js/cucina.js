var nome_progetto = 'SmartiPHR';

function getListaMenu(id_paziente) {
    if (id_paziente === undefined)
        id_paziente = 0;
  
    $.ajax({
        url: "/" + nome_progetto + "/controller/Cucina.php",
        type: "POST",
        data: {operation: "getListaMenu",
             id_paziente: id_paziente
        },
        success: function (res) {
            $('#div_lista_menu').html(res);
        },
        error: function (rese) {
            //alert(rese);
        }
    });
}

function getListaReportMenu(id_paziente) {
    if (id_paziente === undefined)
        id_paziente = 0;
    $.ajax({
        url: "/" + nome_progetto + "/controller/Cucina.php",
        type: "POST",
        data: {operation: "getReportsMenu",
                id_paziente: id_paziente
        },
        success: function (res) {
            console.log(JSON.stringify(res));
            $('#div_lista_report_menu').html(res);
        },
        error: function (rese) {
            //alert(rese);
        }
    });
}

//getListaMenu(5);
//getListaReportMenu(5);

$('body').on('click', '.btn_del_menu', function () {
    if (confirm("Procedere con l'operazione?")) {
        id_menu = $(this).attr('id_menu');
            deleteMenu(id_menu);      
    }

})

$('body').on('click', '.btn-edit-menu', function () {
   
    var prior= $(this).attr('priorita') == 0 ? false : true;
    $("#checkbox-priorita-edit").prop("checked",prior);
    $('#txt-descrizione-edit').val($(this).attr('descrizione'));
    $("#input_data_utente-edit").val($(this).attr('id_utente'));
     $('#modal_modifica_menu').modal('show');
     $('#menu').text($(this).attr('id_menu'));
    //$(this).attr('id_menu');
    /*if (confirm("Procedere con l'operazione?")) {
        id_menu = $(this).attr('id_menu');
            deleteMenu(id_menu);      
    }
*/
})


function deleteMenu(id_menu) {
    $.ajax({
        url: "/" + nome_progetto + "/controller/Cucina.php",
        type: "POST",
        data: {operation: "deleteMenu",
            id_menu: id_menu
        },
        success: function (res) {
            console.log(res);
            getListaMenu(5);
            //alert(res);

        }
    });
}


$('#btn_registra_menu').click(function () {
    
    //alert('id ut: ' + $("#input_data_utente").val());
    var prior= $("#checkbox-priorita").prop("checked") == false ? 0 : 1;
    //alert('descr: ' + $("#txt-descrizione").val());

    $('#div_logger').html('Caricamento in corso...');
    $.ajax({
        url: "/" + nome_progetto + "/controller/Cucina.php",
        type: "POST",
        data: {operation: "insertMenu",
            id_paziente: $("#input_data_utente").val(),
            descrizione: $("#txt-descrizione").val(),
            priorita: prior
        },
        success: function (res) {

            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Registrazione effettuata correttamente.');
                $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger').html('');
                });
                getListaMenu(5);
                $("#input_data_utente").val('');
                $("#txt-descrizione").val('');

            } else {
                $('#div_logger').html(res);

            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
})


$('#btn_modifica_menu').click(function () {
    
    //alert('id ut: ' + $("#input_data_utente").val());
    var prior= $("#checkbox-priorita-edit").prop("checked") == false ? 0 : 1;
    //alert('descr: ' + $("#txt-descrizione-edit").val());
    //$("#input_data_utente-edit").val();

    $('#div_logger1').html('Caricamento in corso...');
    $.ajax({
        url: "/" + nome_progetto + "/controller/Cucina.php",
        type: "POST",
        data: {operation: "editMenu",
            id: $('#menu').text(),
            descrizione: $("#txt-descrizione-edit").val(),
            priorita: prior
        },
        success: function (res) {
            console.log(res);
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100) {
                $('#div_logger1').html('Registrazione effettuata correttamente.');
                $('#div_logger1').fadeOut("slow", function () {
                    $('#div_logger1').html('');
                });
                getListaMenu(5);
                $("#checkbox-priorita").prop("checked",false);
                $("#input_descrizione").val('');

            } else {
                $('#div_logger1').html(res);

            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
})

$('body').on('click', '.btn_dettaglio_rep_menu', function () {
     $.ajax({
        url: "/" + nome_progetto + "/controller/Cucina.php",
        type: "POST",
        data: {operation: "getMenuById",
            id_menu: $(this).attr('id_menu')
        },
        success: function (res) {
            console.log(res);
             var obj_res = JSON.parse(res);
             $('#txt-ospite').val(obj_res.menu.nome);
             $('#txt-descrizione').val(obj_res.menu.descrizione);
             $('#modal_preview_menu').modal('show');
            //getListaMenu(5);
            //alert(res);

        }
    });
})