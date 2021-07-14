/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var nome_progetto = 'SmartiPHR';

function aggiornaListaAnagrafiche() {
    $.ajax({
        url: "/" + nome_progetto + "/controller/Anagrafica.php",
        type: "POST",
        data: {operation: "getListaAnagrafiche", func_admin: 'NO',func_subadmin: 'NO', check: 'NO'},
        success: function (res) {

            $('#div_lista_anagrafiche').html(res);
        },
        error: function (rese) {
            alert(rese);
        }
    });
}

aggiornaListaAnagrafiche();

/*
 * 
 *$('#select_azienda').change(function () {
 aggiornaListaUtenti();
 });
 */


$('#btn_insert_anagrafica').click(function () {
    $('#div_logger').html('Caricamento in corso...');
    $.ajax({
        url: "/" + nome_progetto + "/controller/Anagrafica.php",
        type: "POST",
        data: {operation: "insertAnagrafica",
            nome: $("#input_nome").val(),
            cognome: $("#input_cognome").val(),
            data_nasc: $("#input_data_nasc").val(),
            indirizzo: $("#input_indirizzo").val(),
            cap: $("#input_cap").val(),
            localita: $("#input_localita").val(),
            provincia: $("#input_provincia").val(),
            sesso: $("#input_sesso").val(),
        },
        success: function (res) {
            
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Inserimento effettuato correttamente.');
                $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger').html('');
                });
                aggiornaListaAnagrafiche();
                $("#input_nome").val('');
                $("#input_cognome").val('');
                $("#input_data_nasc").val('');
                $("#input_indirizzo").val('');
                $("#input_cap").val('');
                $("#input_localita").val('');
                $("#input_provincia").val('');
                $("#input_sesso").val('');



            } else {
                $('#div_logger').html(res);
                //$('#div_logger').html('Errore di inserimento. Riprovare');
            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
})
