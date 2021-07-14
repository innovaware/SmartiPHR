/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var nome_progetto = 'SmartiPHR';

$('#btn_login').click(function () {
    $('#div_auth_logger').html('Login in corso...');
    $.ajax({
        url: "./controller/User.php",
        type: "POST",
		dataType: "json",
        data: {operation: "autenticateUser", username: $("#input_username").val(), password: $("#input_password").val()},
        success: function (res) {
            var obj_res = res;
            if (obj_res.stato == 100)
                window.location.href = '/' + nome_progetto + '/home';
            else {
                $('#div_auth_logger').html('Errore di autenticazione. Riprovare');
            }
        },
        error: function (rese) {
            alert("error: " + rese);
        }
    });
})


$('#btn_logout').click(function () {
    if (confirm('Vuoi uscire dall\'applicazione?'))
        $.ajax({
            url: '/' + nome_progetto + '/logout.php',
            success: function (res) {
                window.location.href = '/' + nome_progetto ;
            }
        })
})

$('.btn-indietro').click(function () {
    window.history.back();
})



$('.btnAddMess').click(function () {
    $('#content_mess').val('');
    $('#sel_utente').val('0');
    $('#sel_tip').val('0');
    
   $('#modal_inserisci_nuovo_mess').modal('show');
})


$('#btn_invia_mess').click(function () { 
    //alert($("#sel_tip").val());
        $.ajax({
        url:  "/" + nome_progetto + "/controller/User.php",
        type: "POST",
        data: {operation: "invioMessaggi",
            testo: $("#content_mess").val(), 
            id_utente: $("#sel_utente").val() == '' ? null : $("#sel_utente").val(),
            id_tipologia: $("#sel_tip").val() == '' ? null : $("#sel_tip").val()
        },
        success: function (res) {
            console.log(res);
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100){
                alert('Messaggi inviati!')
                $('#modal_inserisci_nuovo_mess').modal('hide');
            }
            else {
                 alert('Errore nell\'invio dei messaggi. Riprovare');
            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
})

