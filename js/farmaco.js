/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var nome_progetto = 'SmartiPHR';

function aggiornaListaFarmaci(testo) {
    $.ajax({
        url: "/" + nome_progetto + "/controller/Farmaco.php",
        type: "POST",
        data: {operation: "getListaFarmaci",
                testo: testo},
        success: function (res) {
            $('#div_lista_farmaci').html(res);
        },
        error: function (rese) {
            alert(rese);
        }
    });
}

aggiornaListaFarmaci('');


$('#btn_registra_farmaco').click(function () {
    $('#div_logger').html('Caricamento in corso...');
    $.ajax({
        url: "/" + nome_progetto + "/controller/Farmaco.php",
        type: "POST",
        data: {operation: "insertFarmaco",
            nome: $("#input_nome").val(),
            descrizione: $("#input_descrizione").val(),
            dose: $("#input_dose").val(),
            confezione: $("#input_confezione").val(),
            codice_interno: $("#input_codice_interno").val(),
            formato: $("#select_formato").val()
            
        },
        success: function (res) {
            alert(res);
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Inserimento effettuato correttamente.');
                $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger').html('');
                });
                aggiornaListaFarmaci('');
                $("#input_nome").val('');
                $("#input_descrizione").val('');
                $("#input_dose").val('');
                $("#input_confezione").val('');
                $("#input_codice_interno").val('');
                $("#formato").val('');
                $("#input_data_scadenza").val('');
                
            } else {
                $('#div_logger').html(res);
                
            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
})

$('#btn_ricerca_farmaco').click(function(){
    aggiornaListaFarmaci($('#input_testo').val());
})


$('body').on('click','#btn_modal_carsca', function(){
    
    $("#input_nome_cs").val($(this).data('nome'));
    $("#input_descrizione_cs").val($(this).data('descrizione'));
    $("#input_confezione_cs").val($(this).data('confezione'));
    $("#input_search").val('');
    $('#btn_registra_carsca').attr('data-id_farmaco', $(this).data('id_farmaco'));

})

$('#btn_registra_carsca').click(function(){
    id_farmaco = $(this).data('id_farmaco');
    //alert( $("#input_search").attr('valselezionato') );
    if($("#input_search").attr('valselezionato')<=0){
        alert('Selazionare un ospite a cui assegnare il farmaco');
        return;
    }
    if (typeof $("#input_search").attr('valselezionato') == 'undefined'){
        alert('Selazionare un ospite a cui assegnare il farmaco');
        return;
    }
        
    $('#div_logger').html('Caricamento in corso...');
    $.ajax({
        url: "/" + nome_progetto + "/controller/Farmaco.php",
        type: "POST",
        data: {operation: "insertCariscoScarico",
            id_farmaco: id_farmaco,
            id_paziente: $("#input_search").attr('valselezionato') ,
            qta: $("#input_num_confezioni_cs").val(),
            note: $("#input_note_cs").val(),
            data_scadenza: $('#input_data_scadenza').val()
        },
        success: function (res) {
            alert(res);
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Inserimento effettuato correttamente.');
                $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger').html('');
                });
                aggiornaListaFarmaci('');
                
                $("#input_num_confezioni_cs").val('');
                $("#input_search").removeAttr( 'valselezionato' ); 
                
                
            } else {
                $('#div_logger').html(res);
                
            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
    
})

