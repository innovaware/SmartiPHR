var nome_progetto = 'SmartiPHR';
var id_paziente_scelto = 0;


function getDatiPanelMedAnagrafica(id_paziente) {
    //var id_paziente= $('#id_paziente').text();
    $.ajax({
        url: "/" + nome_progetto + "/controller/Anagrafica.php",
        type: "POST",
        data: {
            operation: "getDatiPanelAnagrafica",
            id_paziente: id_paziente
        },
        success: function(res) {
            var obj = JSON.parse(res);

            console.log(JSON.parse(res));
            var data = obj.data_nasc.split('-')[2] + '/' + obj.data_nasc.split('-')[1] + '/' + obj.data_nasc.split('-')[0];

            $('#input_data_nascita .input-group.date').datepicker('setDate', data);

            if (obj.sesso == 'M')
                $("input:radio[name='sesso']").filter('[value=M]').prop('checked', true);
            else
                $("input:radio[name='sesso']").filter('[value=F]').prop('checked', true);
            $('#fullnome').val(obj.cognome + ' ' + obj.nome);
            $('#luogo_nascita').val(obj.localita);
            $('#residenza').val(obj.localita);
            $('#stato_civile').val(obj.stato_civile);
            $('#figli').val(obj.figli);

            $('#scolarita').val(obj.scolarita);
            $('#situazione_lav').val(obj.situazione_lavorativa);

            $('#rif').val(obj.riferimento);
            $('#tel_rif').val(obj.riferimento_tel);


            $('#dataingresso .input-group.date').datepicker('setDate', obj.dt_ingresso);
            $('#provenienza').val(obj.provenienza);

            $('#panel-gen input').prop('readonly', 'true');


            // $('#div_lista_anagrafiche').html(res);
        },
        error: function(rese) {
            alert(rese);
        }
    });
}

function aggiornaListaAnagrafichePSICO() {

    $('.dataTable-ospiti').dataTable({
        "bProcessing": true,
        "responsive": true,
        ajax: {
            url: "/" + nome_progetto + "/controller/Anagrafica.php",
            type: "POST",
            data: { operation: "aggiornaListaAnagraficheAreaSocioPS", func_admin: 'SI', func_subadmin: 'SI', check: 'NO' }
        },
        //"sAjaxSource": "carica_pazienti.php",
        "aoColumns": [
            { mData: 'cognome' },
            { mData: 'nome' },
            { mData: 'data_nasc' },
            { mData: 'indirizzo' },
            { mData: 'localita' },
            { mData: 'provincia' },
            { mData: 'actions' }
        ]
    });


    /* $.ajax({
         url: "/" + nome_progetto + "/controller/Anagrafica.php",
         type: "POST",
         data: {operation: "getListaAnagrafichePsico", func_admin: 'SI', func_subadmin: 'SI', check: 'NO'},
         success: function (res) {
             $('#div_lista_anagrafiche').html(res);
         },
         error: function (rese) {
             alert(rese);
         }
     });*/
}


function aggiornaListaAnagraficheFatture() {

    $('.dataTable-fatture-ospiti').dataTable({
        "bProcessing": true,
        "responsive": true,
        ajax: {
            url: "/" + nome_progetto + "/controller/Anagrafica.php",
            type: "POST",
            data: { operation: "getListaAnagraficheFatture", func_admin: 'SI', func_subadmin: 'SI', check: 'NO' }
        },
        //"sAjaxSource": "carica_pazienti.php",
        "aoColumns": [
            { mData: 'cognome' },
            { mData: 'nome' },
            { mData: 'data_nasc' },
            { mData: 'indirizzo' },
            { mData: 'localita' },
            { mData: 'provincia' },
            { mData: 'actions' }
        ]
    });

}


aggiornaListaAnagrafichePSICO();



$('body').on('click', '.btn_view_area_cp', function() {
    var id_anag = $(this).data('id_anag');
    id_paziente_scelto = id_anag;
    //window.location.href = '/' + nome_progetto + '/cartella-sociopsicologica/' + id_anag;
    $('#modal_inserisci_cartella_sociopsico').modal('toggle');
    openTab(null, 'generale');
    $('.dataTable-diario_psico').dataTable().fnClearTable();
    $('.dataTable-diario_psico').dataTable().fnDestroy();

    $('.dataTable-diario_edu').dataTable().fnClearTable();
    $('.dataTable-diario_edu').dataTable().fnDestroy();

    $('.dataTable-diario_riab').dataTable().fnClearTable();
    $('.dataTable-diario_riab').dataTable().fnDestroy();

    $('.dataTable-area_riab').dataTable().fnClearTable();
    $('.dataTable-area_riab').dataTable().fnDestroy();

    $('.dataTable-prog3').dataTable().fnClearTable();
    $('.dataTable-prog3').dataTable().fnDestroy();

    $('.dataTable-prog6').dataTable().fnClearTable();
    $('.dataTable-prog6').dataTable().fnDestroy();

    $('.dataTable-prog12').dataTable().fnClearTable();
    $('.dataTable-prog12').dataTable().fnDestroy();



    getDatiPanelMedAnagrafica(id_anag);

    getDatiTabsSocioPsico(id_anag);


    getListaRowsDiarioPsico(id_anag);

    getListaRowsDiarioEducativo(id_anag);

    getListaRowsDiarioRiabilitativo(id_anag);

    getListaRowsAreaRiabilitativa(id_anag);

    getListaRowsProgetto(id_anag);


    $('#input_data_nascita .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'

    });


    $('#data_trasferimento .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });


    $('#dataingresso .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });



    $('#data_dimissione .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });


    $('#data_decesso .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });


    $('#input_data_ingresso .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });


    $('#input_data_richiesta .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#input_data_terapia .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });


    $('#input_data_esecuzione .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#input_data_diario .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });



    $('#input_data_lesione .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#dataingresso .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'

    });

})


function openTab(evt, Name) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("nav-link");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(Name).style.display = "block";
    if (evt != null)
        evt.currentTarget.className += " active";
    else
        tablinks[0].className += " active";
}


/* SEZIONE CARTELLA INFERMIERISTICA */

$('#btn_save_tab_med').click(function() {

    var arr_tab;

    arr_tab = {
        stato_emotivo: $("#stato_emotivo").val(),
        stato_emotivo_altro: $("#stato_emotivo_altro").val(),
        personalita: $('#personalita').val(),
        txt_personalita: $('#txt_personalita').val(),
        linguaggio: $('#linguaggio').val(),
        txt_linguaggio: $('#txt_linguaggio').val(),
        memoria: $('#memoria').val(),
        txt_memoria: $('#txt_memoria').val(),
        orientamento: $('#orientamento').val(),
        txt_orientamento: $('#txt_orientamento').val(),
        abilita_perc: $('#abilita_perc').val(),
        txt_abilita_perc: $('#txt_abilita_perc').val(),
        abilita_esec: $('#abilita_esec').val(),
        txt_abilita_esec: $('#txt_abilita_esec').val(),
        ideazione: $('#ideazione').val(),
        txt_ideazione: $('#txt_ideazione').val(),
        umore: $('#umore').val(),
        txt_umore: $('#txt_umore').val(),
        rb_partecipazioni: $("input[name='rb_partecipazioni']:checked").val(),
        rb_ansia: $("input[name='rb_ansia']:checked").val(),
        rb_test: $("input[name='rb-test']:checked").val(),
        diagnosi: $('#diagnosi').val(),
        rassegna: $('#rassegna').val(),
        valutazione: $('#valutazione').val(),
        interesse: $("#interesse").val(),
        compagnia: $("#compagnia").val(),
        interesse_iniziativa: $("#interesse_iniziativa").val(),
        hobbies: $("#hobbies").val(),
        altro_hobbies: $("#altro_hobbies").val(),
        anam_riab: $("#anam_riab").val(),
        fim: $("#fim").prop('checked'),
        motricity: $("#motricity").prop('checked'),
        test: $("#test").prop('checked'),
        questionario: $("#questionario").prop('checked'),
        scala: $("#scala").prop('checked'),
        altro: $("#altro").prop('checked'),
        altro_test_riab: $('#altro_test_riab').val(),
        diagnosi_riab: $('#diagnosi_riab').val(),
        valutazione_edu: $('#valutazione_edu').val(),
        punteggio_adl: $("#punteggio").val(),
        punteggio_iadl: $("#punteggio_iadl").val(),
        ment_int: $("#ment_int").val(),
        ment_comp: $('#ment_comp').val(),
        sensoriale: $('#sensoriale').val(),
        voce: $('#voce').val(),
        sistema_card: $('#sistema_card').val(),
        sistema_dig: $('#sistema_dig').val(),
        genito: $('#genito').val(),
        neuro_muscolo: $('#neuro_muscolo').val(),
        altre_f: $('#altre_f').val(),
        bar_prod: $("#bar_prod").val(),
        fac_prod: $("#fac_prod").val()

        ,
        bar_amb: $("#bar_amb").val(),
        fac_amb: $('#fac_amb').val(),
        bar_rel: $('#bar_rel').val(),
        fac_rel: $('#fac_rel').val(),
        bar_atteg: $('#bar_atteg').val(),
        fac_atteg: $('#fac_atteg').val(),
        bar_serv: $('#bar_serv').val(),
        fac_serv: $('#fac_serv').val()

        ,
        perf_apprend: $('#perf_apprend').val(),
        capac_apprend: $("#capac_apprend").val(),
        perf_compiti: $("#perf_compiti").val(),
        capac_compiti: $('#capac_compiti').val(),
        perf_com: $('#perf_com').val(),
        capac_com: $('#capac_com').val(),
        perf_mob: $('#perf_mob').val(),
        capac_mob: $("#capac_mob").val(),
        perf_cura: $("#perf_cura").val(),
        capac_cura: $('#capac_cura').val(),
        perf_domestic: $('#perf_domestic').val()

        ,
        capac_domestic: $('#capac_domestic').val(),
        perf_att_pers: $("#perf_att_pers").val(),
        capac_att_pers: $("#capac_att_pers").val(),
        perf_vita: $('#perf_vita').val(),
        capac_vita: $('#capac_vita').val()

        ,
        perf_vita_soc: $("#perf_vita_soc").val(),
        capac_vita_soc: $("#capac_vita_soc").val(),
        psi3: $("#psi3").val(),
        edu3: $('#edu3').val(),
        fisio3: $("#fisio3").val(),
        psi6: $("#psi6").val(),
        edu6: $('#edu6').val(),
        fisio6: $("#fisio6").val(),
        psi12: $("#psi12").val(),
        edu12: $('#edu12').val(),
        fisio12: $("#fisio12").val()
    };

    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {
            operation: "insertOrUpdateTab",
            id_master: 3,
            id_paziente: id_paziente_scelto,
            nome_tab: '',
            json: arr_tab
        },
        success: function(res) {


            var obj_res = JSON.parse(res);
            if (obj_res.stato != 100)
                alert('Errore di autenticazione. Riprovare');
            else {
                alert('Operazione effettuata con successo!');
                $('#modal_inserisci_cartella_sociopsico').modal('toggle');

            }

        },
        error: function(rese) {
            alert(JSON.stringify(rese));
        }
    });
})



function getDatiTabsSocioPsico(id_paziente) {
    //var id_paziente= $('#id_paziente').text();
    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {
            operation: "getListaTab",
            id_master: 3,
            id_paziente: id_paziente
        },
        success: function(res) {
            var obj = JSON.parse(res);

            const json = {};
           

            for (i = 0; i < obj.length; i++) {
                // var nome_tab = obj[i].nome_tab;
                // var data = JSON.parse(obj[i].json);
                // console.log("nome_tab: ", nome_tab);
                // console.log("JSON: ", data);
                var json_inter = JSON.parse(obj[i].json);

                $.extend(json, json_inter);
            }

                console.log("json: ", json);
          


            
                $('#diagnosi').val(json.diagnosi);
                $('#rassegna').val(json.rassegna);


                $('#valutazione').val(json.valutazione);

                $("#stato_emotivo").val(json.stato_emotivo);
                $('#stato_emotivo_altro').val(json.stato_emotivo_altro);
                $('#personalita').val(json.personalita);
                $('#linguaggio').val(json.linguaggio);

                $("#memoria").val(json.memoria);
                $('#orientamento').val(json.orientamento);
                $('#abilita_perc').val(json.abilita_perc);
                $('#abilita_esec').val(json.abilita_esec);

                $("#ideazione").val(json.ideazione);
                $('#umore').val(json.umore);
                if (json.rb_partecipazioni == 'adeguata')
                    $("input:radio[name='rb_partecipazioni']").filter('[value=adeguata]').prop('checked', true);
                else
                    $("input:radio[name='rb_partecipazioni']").filter('[value=noadeguata]').prop('checked', true);


                if (json.rb_ansia == 'assente')
                    $("input:radio[name='rb_ansia']").filter('[value=assente]').prop('checked', true);
                else
                    $("input:radio[name='rb_ansia']").filter('[value=presente]').prop('checked', true);


                if (json.rb_test == 'NO')
                    $("input:radio[name='rb-test']").filter('[value=NO]').prop('checked', true);
                else
                    $("input:radio[name='rb-test']").filter('[value=SI]').prop('checked', true);



                $("#stato_emotivo_altro").val(json.stato_emotivo_altro);
                $('#txt_personalita').val(json.txt_personalita);
                $('#txt_linguaggio').val(json.txt_linguaggio);
                $('#txt_memoria').val(json.txt_memoria);


                $("#txt_orientamento").val(json.txt_orientamento);
                $('#txt_abilita_perc').val(json.txt_abilita_perc);
                $('#txt_abilita_esec').val(json.txt_abilita_esec);
                $('#txt_ideazione').val(json.txt_ideazione);

                $('#txt_umore').val(json.txt_umore);


        },
        error: function(rese) {
            alert(rese);
        }
    });
}




/* AGGIUNTA O MODIFICA RECORD DIARIO PSICO */


function formatoData(data) {
    var d = data.split('/');

    return d[2] + '-' + d[1] + '-' + d[0];
}

function date(data) {
    var d = data.split('/');

    return d[1] + '/' + d[0] + '/' + d[2];
}


$('#btn_salva_record_diario_psico').click(function() {

    if ($("#input_data_diario .input-group input").val() == "" || $("#content_diario").val() == "") {
        alert('Alcuni campi obbligatori sono mancanti!');
        return;
    }

    var d = new Date(date($("#input_data_diario .input-group input").val()));
    var now = new Date();

    if (d < now) {
        alert('La data non può essere inferiore ad oggi!');
        return;
    }

    $('#div_logger').html('Caricamento in corso...');
    var id_paziente = $('#id_paziente').text();
    var id = $('#id_rec').text();

    var nometab = $('.active').text();

    var tipo = 0;
    if (nometab.includes('Diario Psicologico Clinico'))
        tipo = 1;
    else if (nometab.includes('Diario Educativo'))
        tipo = 2;
    else {
        if ($("#controllo").val() == "") {
            alert('Alcuni campi obbligatori sono mancanti!');
            return;
        }

        tipo = 3;
    }

    console.log('controllo: ' + $('#controllo').val());
    if ($(this).text() == 'Modifica') {
        $.ajax({
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {
                operation: "updateRecordDiarioPsico",
                id: id,
                contenuto: $('#content_diario').val() + ' ' + $('#new_content_diario').val()
            },
            success: function(res) {


                var obj_res = JSON.parse(res);
                console.log(obj_res);
                if (obj_res.stato == 100) {
                    $('#div_logger').html('Inserimento effettuato correttamente.');
                    $('#div_logger').fadeOut("slow", function() {
                        $('#div_logger').html('');
                    });
                    $('#modal_inserisci_record_diario').modal('hide');
                    $('.dataTable-diario_psico').dataTable().fnDestroy();
                    $('.dataTable-diario_edu').dataTable().fnDestroy();
                    $('.dataTable-diario_riab').dataTable().fnDestroy();

                    /*$('#tab_diario_psico tbody tr').remove();
                     $('#tab_diario_edu tbody tr').remove();
                     $('#tab_diario_riab tbody tr').remove();*/

                    $("#input_data_diario .input-group input").val('');
                    $("#content_diario").val('');
                    $('#content_diario_inf').val('');
                    $('#firma').val('');
                    getListaRowsDiarioPsico(id_paziente_scelto);

                    getListaRowsDiarioEducativo(id_paziente_scelto);

                    getListaRowsDiarioRiabilitativo(id_paziente_scelto);
                } else {
                    $('#div_logger').html(res);
                }
            },
            error: function(rese) {
                alert(rese);
            }
        });


    } else {
        $.ajax({
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {
                operation: "insertRecordDiarioPsico",
                id_paziente: id_paziente_scelto,
                data: formatoData($("#input_data_diario .input-group input").val()),
                contenuto: $("#content_diario").val(),
                tipo: tipo,
                controllo: $('#controllo').val(),
                firma: $('#firma').val()
            },
            success: function(res) {

                console.log(res);
                var obj_res = JSON.parse(res);
                console.log(obj_res);
                if (obj_res.stato == 100) {
                    $('#div_logger').html('Inserimento effettuato correttamente.');
                    $('#div_logger').fadeOut("slow", function() {
                        $('#div_logger').html('');
                    });
                    $('#modal_inserisci_record_diario').modal('hide');
                    $('.dataTable-diario_psico').dataTable().fnDestroy();
                    $('.dataTable-diario_edu').dataTable().fnDestroy();
                    $('.dataTable-diario_riab').dataTable().fnDestroy();

                    /*$('#tab_diario_psico tbody tr').remove();
                    $('#tab_diario_edu tbody tr').remove();
                    $('#tab_diario_riab tbody tr').remove();  */

                    $("#input_data_diario .input-group input").val('');
                    $("#content_diario").val('');
                    $('#firma').val('');


                    getListaRowsDiarioPsico(id_paziente_scelto);

                    getListaRowsDiarioEducativo(id_paziente_scelto);

                    getListaRowsDiarioRiabilitativo(id_paziente_scelto);


                } else {
                    $('#div_logger').html(res);
                }
            },
            error: function(rese) {
                alert(rese);
            }
        });
    }
})


$('body').on('click', '#btn_new_record_diario_psico', function() {

    $('#modal_inserisci_record_diario').modal('show');
    $("#input_data_diario .input-group input").val('');
    $("#input_data_diario .input-group input").prop('readonly', false);
    $("#content_diario").val('');
    $("#content_diario").prop('readonly', false);
    var nometab = $('.active').text();
    if (nometab.includes('Diario Riabilitativo')) {
        $("#sel_controllo").val('');
        $("#sel_controllo").css('display', 'inline');
    }




    $("#firma").val('');
    $("#firma").prop('readonly', false);


    $('#btn_salva_record_diario_psico').text('Salva');
    $('.modal-title').text('Nuovo');

    $('#div_new_content_diario').css('display', 'none');

})


$('body').on('click', '.btn-modifica-row-diario-psico', function() {

    $('#div_logger').html('Caricamento in corso...');
    var id = $(this).data('id');
    var tipo = $(this).data('tipo');

    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {
            operation: "getRecordDiarioPsico",
            id: id
        },
        success: function(res) {

            //console.log(res);
            var obj_res = JSON.parse(res);
            console.log(obj_res);

            $('#modal_inserisci_record_diario').modal('show');
            $('#id_rec').text(id);
            $('#div_new_content_diario').css('display', 'inline');
            $("#input_data_diario .input-group input").val(obj_res[0].data);
            $("#input_data_diario .input-group input").prop('readonly', true);
            $("#content_diario").val(obj_res[0].contenuto);
            $("#content_diario").prop('readonly', true);
            $('#firma').val(obj_res[0].firma);
            $('#firma').prop('readonly', true);
            $('#btn_salva_record_diario_psico').text('Modifica');
            $('.modal-title').text('Modifica');
            $('#new_content_diario').val('');
            var nometab = $('.active').text();
            if (nometab.includes('Diario Riabilitativo')) {
                $("#controllo").val(obj_res[0].controllo);
                $("#controllo").prop('disabled', 'true');
                $("#sel_controllo").css('display', 'inline');
            }
        },
        error: function(rese) {
            alert(rese);
        }
    });
})




$('#btn_salva_record_area_riab').click(function() {

    if ($("#input_data_lesione .input-group input").val() == "" || $("#content_lesione").val() == "" || $("#parte_affetta").val() == "") {
        alert('Alcuni campi obbligatori sono mancanti!');
        return;
    }


    $('#div_logger').html('Caricamento in corso...');

    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {
            operation: "insertRecordAreaRiabilitativa",
            id_paziente: id_paziente_scelto,
            data: formatoData($("#input_data_lesione .input-group input").val()),
            descrizione: $("#content_lesione").val(),
            parte: $("#parte_affetta").val()

        },
        success: function(res) {

            console.log(res);
            var obj_res = JSON.parse(res);
            console.log(obj_res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Inserimento effettuato correttamente.');
                $('#div_logger').fadeOut("slow", function() {
                    $('#div_logger').html('');
                });
                $('#modal_inserisci_record_area_riab').modal('hide');
                $('.dataTable-area_riab').dataTable().fnDestroy();

                $("#input_data_lesione .input-group input").val('');
                $("#content_lesione").val('');
                $('#parte_affetta').val('');

                getListaRowsAreaRiabilitativa(id_paziente_scelto);
            } else {
                $('#div_logger').html(res);
            }
        },
        error: function(rese) {
            alert(rese);
        }
    });

})

$('body').on('click', '#btn_new_record_area-riab', function() {

    $('#modal_inserisci_record_area_riab').modal('show');
    $("#input_data_lesione .input-group input").val('');
    $("#input_data_lesione .input-group input").prop('readonly', false);
    $("#content_lesione").val('');
    $("#content_lesione").prop('readonly', false);

    $("#parte_affetta").val('');
    $("#parte_affetta").prop('readonly', false);

    $('#btn_salva_record_area_riab').text('Salva');
    $('.modal-title').text('Nuova Lesione/Evento');


})



$('body').on('click', '#btn_new_record_progetto3', function() {

    $('#modal_inserisci_record_progetto').modal('show');
    $("#content_obiettivo").val('');
    $("#content_obiettivo").prop('readonly', false);

    $("#termine").val(3);
    $("#termine").prop('disabled', 'true');
    $("#modalita").val('');
    $("#modalita").prop('readonly', false);
    $("#indice_val").val('');
    $("#indice_val").prop('readonly', false);


    $('#btn_salva_record_progetto').text('Salva');
    $('.modal-title').text('Nuovo Obiettivo');


})


$('body').on('click', '#btn_new_record_progetto6', function() {

    $('#modal_inserisci_record_progetto').modal('show');
    $("#content_obiettivo").val('');
    $("#content_obiettivo").prop('readonly', false);

    $("#termine").val(6);
    $("#termine").prop('disabled', 'true');
    $("#modalita").val('');
    $("#modalita").prop('readonly', false);
    $("#indice_val").val('');
    $("#indice_val").prop('readonly', false);


    $('#btn_salva_record_progetto').text('Salva');
    $('.modal-title').text('Nuovo Obiettivo');


})

$('body').on('click', '#btn_new_record_progetto12', function() {

    $('#modal_inserisci_record_progetto').modal('show');
    $("#content_obiettivo").val('');
    $("#content_obiettivo").prop('readonly', false);

    $("#termine").val(12);
    $("#termine").prop('disabled', 'true');
    $("#modalita").val('');
    $("#modalita").prop('readonly', false);
    $("#indice_val").val('');
    $("#indice_val").prop('readonly', false);


    $('#btn_salva_record_progetto').text('Salva');
    $('.modal-title').text('Nuovo Obiettivo');


})


$('#btn_salva_record_progetto').click(function() {

    if ($("#content_obiettivo").val() == "" || $("#modalita").val() == "" || $("#indice_val").val() == "") {
        alert('Alcuni campi obbligatori sono mancanti!');
        return;
    }
    $('#div_logger').html('Caricamento in corso...');
    var id_paziente = $('#id_paziente').text();
    var termine = $("#termine").val();

    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {
            operation: "insertRecordProgetto",
            id_paziente: id_paziente_scelto,
            termine: termine,
            descrizione: $("#content_obiettivo").val(),
            modalita: $("#modalita").val(),
            indice_val: $("#indice_val").val()

        },
        success: function(res) {

            console.log(res);
            var obj_res = JSON.parse(res);
            console.log(obj_res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Inserimento effettuato correttamente.');
                $('#div_logger').fadeOut("slow", function() {
                    $('#div_logger').html('');
                });
                $('#modal_inserisci_record_progetto').modal('hide');

                //$('.dataTable-prog3').dataTable().fnClearTable();
                $('.dataTable-prog3').dataTable().fnDestroy();
                //$('.dataTable-prog6').dataTable().fnClearTable();
                $('.dataTable-prog6').dataTable().fnDestroy();
                //$('.dataTable-prog12').dataTable().fnClearTable();
                $('.dataTable-prog12').dataTable().fnDestroy();

                //location.reload();
                /*$('#tab_prog3  tbody tr').remove();
                    $('#tab_prog6  tbody tr').remove();
                     $('#tab_prog12  tbody tr').remove();
*/
                $("#content_obiettivo").val('');
                $('#modalita').val('');
                $("#indice_val").val('');

                getListaRowsProgetto(id_paziente_scelto);
            } else {
                $('#div_logger').html(res);
            }
        },
        error: function(rese) {
            alert(rese);
        }
    });

})





function getListaRowsDiarioPsico(id_paziente) {
    //var id_paziente= $('#id_paziente').text();

    $('.dataTable-diario_psico').dataTable({
        "bProcessing": true,
        "responsive": true,
        ajax: {
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {
                operation: "getListaRowsDiarioPsico",
                id_paziente: id_paziente,
                tipo: 1
            }
        },
        //"sAjaxSource": "carica_pazienti.php",
        "aoColumns": [
            { mData: 'data' },
            { mData: 'contenuto' },
            { mData: 'firma' },
            { mData: 'actions' }

        ]
    });
}

function getListaRowsDiarioEducativo(id_paziente) {
    //var id_paziente= $('#id_paziente').text();

    $('.dataTable-diario_edu').dataTable({
        "bProcessing": true,
        "responsive": true,
        ajax: {
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {
                operation: "getListaRowsDiarioPsico",
                id_paziente: id_paziente,
                tipo: 2
            }
        },
        //"sAjaxSource": "carica_pazienti.php",
        "aoColumns": [
            { mData: 'data' },
            { mData: 'contenuto' },
            { mData: 'firma' },
            { mData: 'actions' }

        ]
    });


    /*$.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {
             operation: "getListaRowsDiarioPsico"
            ,id_paziente : id_paziente
            ,tipo : 2
        },
        success: function (res) {
          
            console.log(res);
            $("#tab_diario_edu tbody").append(res);
            
        },
        error: function (rese) {
            alert(rese);
        }
    });*/
}

function getListaRowsDiarioRiabilitativo(id_paziente) {
    //var id_paziente= $('#id_paziente').text();

    $('.dataTable-diario_riab').dataTable({
        "bProcessing": true,
        "responsive": true,
        ajax: {
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {
                operation: "getListaRowsDiarioPsicoRiabilitativo",
                id_paziente: id_paziente,
                tipo: 3
            }
        },
        //"sAjaxSource": "carica_pazienti.php",
        "aoColumns": [
            { mData: 'data' },
            { mData: 'controllo' },
            { mData: 'diario' },
            { mData: 'firma' },
            { mData: 'actions' }

        ]
    });

    /*   $.ajax({
           url: "/" + nome_progetto + "/controller/Tab.php",
           type: "POST",
           data: {
                operation: "getListaRowsDiarioPsicoRiabilitativo"
               ,id_paziente : id_paziente
               ,tipo : 3
           },
           success: function (res) {
             
               console.log(res);
               $("#tab_diario_riab tbody").append(res);
               
           },
           error: function (rese) {
               alert(rese);
           }
       });  */
}



function getListaRowsAreaRiabilitativa(id_paziente) {
    //var id_paziente= $('#id_paziente').text();


    $('.dataTable-area_riab').dataTable({
        "bProcessing": true,
        "responsive": true,
        ajax: {
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {
                operation: "getListaRowsAreaRiab",
                id_paziente: id_paziente
            }
        },
        //"sAjaxSource": "carica_pazienti.php",
        "aoColumns": [
            { mData: 'data' },
            { mData: 'tipologia' },
            { mData: 'parte' }

        ]
    });


    /*$.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {
             operation: "getListaRowsAreaRiab"
            ,id_paziente : id_paziente
        },
        success: function (res) {
          
            console.log(res);
            $("#tab_area_riab tbody").append(res);
            
        },
        error: function (rese) {
            alert(rese);
        }
    });*/
}


function getListaRowsProgetto(id_paziente) {
    //var id_paziente= $('#id_paziente').text();

    $('.dataTable-prog3').dataTable({
        "bProcessing": true,
        "responsive": true,
        ajax: {
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {
                operation: "getListaRowsProgetto",
                id_paziente: id_paziente,
                termine: 3
            }
        },
        //"sAjaxSource": "carica_pazienti.php",
        "aoColumns": [
            { mData: 'obiettivi' },
            { mData: 'modalita' },
            { mData: 'indice' }

        ]
    });



    $('.dataTable-prog6').dataTable({
        "bProcessing": true,
        "responsive": true,
        ajax: {
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {
                operation: "getListaRowsProgetto",
                id_paziente: id_paziente,
                termine: 6
            }
        },
        //"sAjaxSource": "carica_pazienti.php",
        "aoColumns": [
            { mData: 'obiettivi' },
            { mData: 'modalita' },
            { mData: 'indice' }

        ]
    });



    $('.dataTable-prog12').dataTable({
        "bProcessing": true,
        "responsive": true,
        ajax: {
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {
                operation: "getListaRowsProgetto",
                id_paziente: id_paziente,
                termine: 12
            }
        },
        //"sAjaxSource": "carica_pazienti.php",
        "aoColumns": [
            { mData: 'obiettivi' },
            { mData: 'modalita' },
            { mData: 'indice' }

        ]
    });




    /*$.ajax({
         url: "/" + nome_progetto + "/controller/Tab.php",
         type: "POST",
         data: {
              operation: "getListaRowsProgetto"
             ,id_paziente : id_paziente
             ,termine : 3
         },
         success: function (res) {
           
             console.log(res);
             $("#tab_prog3 tbody").append(res);
             
         },
         error: function (rese) {
             alert(rese);
         }
     });
     
     
       $.ajax({
         url: "/" + nome_progetto + "/controller/Tab.php",
         type: "POST",
         data: {
              operation: "getListaRowsProgetto"
             ,id_paziente : id_paziente
             ,termine : 6
         },
         success: function (res) {
           
             console.log(res);
             $("#tab_prog6 tbody").append(res);
             
         },
         error: function (rese) {
             alert(rese);
         }
     });
     
     
     
       $.ajax({
         url: "/" + nome_progetto + "/controller/Tab.php",
         type: "POST",
         data: {
              operation: "getListaRowsProgetto"
             ,id_paziente : id_paziente
             ,termine : 12
         },
         success: function (res) {
           
             console.log(res);
             $("#tab_prog12 tbody").append(res);
             
         },
         error: function (rese) {
             alert(rese);
         }
     });*/
}