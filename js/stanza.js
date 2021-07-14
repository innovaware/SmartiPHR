/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var nome_progetto = 'SmartiPHR';

function aggiornaListaStanze() {
    $.ajax({
        url: "/" + nome_progetto + "/controller/Stanza.php",
        type: "POST",
        data: {operation: "getListaStanze"
        },
        success: function (res) {
            $('#div_lista_stanze').html(res);
        },
        error: function (rese) {
            //alert(rese);
        }
    });
}

aggiornaListaStanze();

function registraIntervento(id_stanza, tipo_intervento, descrizione) {
    $.ajax({
        url: "/" + nome_progetto + "/controller/Stanza.php",
        type: "POST",
        data: {operation: "insertIntervento",
            id_stanza: id_stanza,
            tipo_intervento: tipo_intervento,
            descrizione: descrizione
        },
        success: function (res) {
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Registrazione effettuata correttamente.');
                $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger_gestione_stanza').html('');
                });
                aggiornaListaStanze('');
                $("#input_tipo_descrizione").val('');
                //TO-DO ricaricare select tipo_intervento
            } else {
                $('#div_logger_gestione_stanza').html(res);

            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
}

function deleteIntervento(id_stanza, tipo_intervento) {
    $.ajax({
        url: "/" + nome_progetto + "/controller/Stanza.php",
        type: "POST",
        data: {operation: "deleteIntervento",
            id_stanza: id_stanza,
            tipo_intervento: tipo_intervento,
        },
        success: function (res) {
            aggiornaListaStanze('');
            //alert(res);

        }
    });
}

/*
 $('#btn_registra_intervento').click(function () {
 
 id_stanza = $(this).attr('id_stanza');
 tipo_intervento = $("#select_tipo_intervento").val();
 descrizione = $("#input_tipo_descrizione").val();
 
 
 $('#div_logger').html('Caricamento in corso...');
 registraIntervento(id_stanza, tipo_intervento, descrizione);
 
 
 })
 */

$('#btn_registra_stanza').click(function () {

    $('#div_logger').html('Caricamento in corso...');
    $.ajax({
        url: "/" + nome_progetto + "/controller/Stanza.php",
        type: "POST",
        data: {operation: "insertStanza",
            numero: $("#input_numero").val(),
            descrizione: $("#input_descrizione").val(),
            piano: $("#select_piano").val()
        },
        success: function (res) {

            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Registrazione effettuata correttamente.');
                $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger').html('');
                });
                aggiornaListaStanze('');
                $("#input_numero").val('');
                $("#input_descrizione").val('');

            } else {
                $('#div_logger').html(res);

            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
})

$('body').on('click', '.btn_gestisci_stanza', function () {
    $('#btn_registra_intervento').attr('id_stanza', $(this).data('id_stanza'))
})


$('body').on('click', '.btn_change_state_stanza', function () {
    if (confirm("Procedere con l'operazione?")) {
        id_stanza = $(this).attr('id_stanza');
        tipo_intervento = $(this).attr('tipo_intervento');
        stato = $(this).attr('stato');
        if (stato == 'ko') {
            registraIntervento(id_stanza, tipo_intervento, '');
        }
        if (stato == 'ok') {
            deleteIntervento(id_stanza, tipo_intervento);
        }
    }

})

