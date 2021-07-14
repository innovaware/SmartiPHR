/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var nome_progetto = 'SmartiPHR';

function aggiornaListaUtenti() {
    $.ajax({
        url: "/" + nome_progetto + "/controller/User.php",
        type: "POST",
        data: {operation: "getListaUtenti", azienda: $('#select_azienda').val(), funzione: 'SI', check: 'NO'},
        success: function (res) {

            $('#div_lista_utenti').html(res);
        },
        error: function (rese) {
            alert(rese);
        }
    });
}

aggiornaListaUtenti();

/*
 * 
 *$('#select_azienda').change(function () {
 aggiornaListaUtenti();
 });
 */


$('#btn_insert_user').click(function () {
    $('#div_logger').html('Caricamento in corso...');
    $.ajax({
        url: "/" + nome_progetto + "/controller/User.php",
        type: "POST",
        data: {operation: "insertUser",
            nome: $("#input_nome").val(),
            cognome: $("#input_cognome").val(),
            mail: $("#input_mail").val(),
            tipo_utente: $("#input_tipo_utente").val(),
            descr_utente: $("#input_descr_utente").val()
        },
        success: function (res) {
            alert(res);
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Inserimento effettuato correttamente.');
                $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger').html('');
                });
                aggiornaListaUtenti();
                $("#input_nome").val('');
                $("#input_cognome").val('');
                $("#input_mail").val('');
                $("#input_tipo_utente").val('');
                $("#input_descr_utente").val('');



            } else {
                $('#div_logger').html('Errore di inserimento. Riprovare');
            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
})

$('#btn_reset_password').click(function () {

    if ($("#input_password").val() != $("#input_conferma_password").val()) {
        alert('Attenzione! Le password non coincidono');
        return;
    }

    $.ajax({
        url: "/" + nome_progetto + "/controller/User.php",
        type: "POST",
        data: {operation: "resetPassword", user: $("#input_user").val(), password: $("#input_password").val(), sec_token: $("#input_sec_token").val()},
        success: function (res) {
            
            var obj_res = JSON.parse(res);
            
            if (obj_res.stato == 100) {
                $('#div_logger').html('Reset effettuato correttamente.');
            } else {
                $('#div_logger').html('Errore durante il reset. Riprovare');
                $('#div_logger').html(obj_res.query);
            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
})


$("body").on("click", ".btn_invia_reset", function () {

    if (confirm("Vuoi inviare il reset della password?")) {

        $.ajax({
            url: "/" + nome_progetto + "/controller/User.php",
            type: "POST",
            data: {operation: "inviaResetPassword", username: $(this).data("username")},
            success: function (res) {
                alert(res);
            },
            error: function (rese) {
                alert(rese);
            }
        });
    }


})