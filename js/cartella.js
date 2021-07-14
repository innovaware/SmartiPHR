/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var nome_progetto = 'SmartiPHR';

function aggiornaListaAnagrafiche() {

    $('.dataTables-lista_anagrafiche').dataTable({
           "bProcessing": true,
            "responsive": true,
            'ajax': {
               url: "/" + nome_progetto + "/controller/Anagrafica.php",
               type: "POST",
               data: {operation: "getListaAnagrafiche", func_admin: 'SI', func_subadmin: 'SI', check: 'NO'},
           },
           "aoColumns": [
                 { mData: 'cognome' },
                 { mData: 'nome' },
                 { mData: 'data_nasc' },
                 { mData: 'indirizzo' } ,
                 { mData: 'localita' },
                 { mData: 'provincia' },
                  { mData: 'actions' }
               ]

         }); 
        
 
}

function aggiornaDettaglio(sfx, id_cartella, id_dett) {
    $.ajax({
        url: "/" + nome_progetto + "/controller/Cartella.php",
        type: "POST",
        data: {operation: "getRiepilogoDettaglio",
            sfx, sfx,
            id_cartella: id_cartella,
            id_dett: id_dett,
        },
        success: function (res) {

            $('#div_riepilogo_' + id_dett).html(res);
        },
        error: function (rese) {
            alert(rese);
        }
    });
}

$('.div_riepilogo_dettaglio').each(function () {
    id_cartella = $('#span_id_cartella').html();
    id_dett = $(this).data('id_dett');
    sfx = $(this).data('sfx');
    aggiornaDettaglio(sfx, id_cartella, id_dett);
})

aggiornaListaAnagrafiche();

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
      if(evt != null)
          evt.currentTarget.className += " active";
      else
          tablinks[0].className+= " active";
    }



$('body').on('click', '.btn_view_cartella_clinica', function () {
    $('#modal_inserisci_cartella_clinica').modal('toggle');
    $('#id_anagrafica').html($(this).data('id_anag'));
        getDatiPanelMedAnagrafica();
        
        getDatiTabsMed();
        
         getListaRowsVisiteSpec();
         getListaRowsDiarioClinico();
        
        
});




$('body').on('click', '.btn_view_cartella_inf', function () {
    $('#modal_inserisci_cartella_inf').modal('toggle');
    $('#id_anagrafica').html($(this).data('id_anag'));
        openTab(null, 'generaleinf');
        
        getDatiPanelInfermAnagrafica();
        
        getListaRowsDiarioInf();
        
        getListaRowsInterventi();
        
        
});



$('#btn_toggle_div_evento').on('click', function(){
    
    $('#div_parametri_evento').toggle();
})

$.getScript( "/" + nome_progetto + "/ext/calendar/calendar.js", function(){
    
})


$('#btn_salva_dettaglio').click(function () {
    var data = new Object();
    
    $(".type_param").each(function() {
        //alert($(this).val());
        //alert($(this).attr('name'));
        var etichetta = $(this).attr('name');
        var valore = $(this).val();
        data[etichetta] = valore;
        
    });
    alert(JSON.stringify(data));
    
    /*
    $('#div_logger').html('Caricamento in corso...');
    id_dett = $(this).data('id_dett');
    sfx = $(this).data('sfx');
    $.ajax({
        url: "/" + nome_progetto + "/controller/Cartella.php",
        type: "POST",
        data: {operation: "insertDettaglioClinico",
            id_cartella: $("#id_cartella").html(),
            id_dett: id_dett,
            sfx: sfx,
            data_diario: $("#input_data_diario").val(),
            descr_diario: $("#input_descr_diario_clinico").val()
        },
        success: function (res) {
            //alert(res);
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Inserimento effettuato correttamente.');
                
                if($('#checkbox_evento').prop('checked')){
                    alert('genero evento');
                    salvaEvento(obj_res.id_dett, obj_res.sfx);
                }
                    
                $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger').html('');
                });
                location.reload();

            } else {
                $('#div_logger').html(res);
            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
    */
})

$('#btn_salva_cartella').click(function () {
    $('#div_logger').html('Caricamento in corso...');
    var sfx = $(this).data('sfx');
    $.ajax({
        url: "/" + nome_progetto + "/controller/Cartella.php",
        type: "POST",
        data: {operation: "insertCartella",
            sfx: sfx,
            id_anag: $("#id_anagrafica").html(),
            data_ricovero: $("#input_data_ricovero").val()
        },
        success: function (res) {
            var obj_res = JSON.parse(res);
            
            if (obj_res.stato == 100) {
                $('#div_logger').html('Inserimento effettuato correttamente.');
                $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger').html('');
                });
                aggiornaListaAnagrafiche();
            } else {
                $('#div_logger').html(res);
            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
})


$('body').on('click', '.btn_gestione_menu', function () {
    var id_anag = $(this).data('id_anag');
    alert(id_anag);
    var sfx = $(this).data('sfx');
    alert('/' + nome_progetto + '/menu_ospiti/'+ id_anag);
    window.location.href = '/' + nome_progetto + '/menu_ospiti';
    /*if(sfx=='inf')
        window.location.href = '/' + nome_progetto + '/menu_ospiti/' + id_anag;
    else
        window.location.href = '/' + nome_progetto + '/menu_ospiti/' + sfx + '/' + id_anag;*/
})

/*
$('body').on('click', '.btn_view_cartella_clinica', function () {
    var id_cart = $(this).data('id_cartella');
    var id_anag = $(this).data('id_anag');
    var sfx = $(this).data('sfx');
    if(sfx=='inf')
        window.location.href = '/' + nome_progetto + '/cartella-infermieristica/' + id_anag;
    else
        window.location.href = '/' + nome_progetto + '/cartella-clinica/' + sfx + '/' + id_anag;
})*/


$('body').on('click', '.btn_ins_dettaglio', function () {
    var id_dett = $(this).data('id_dett');
    var sfx = $(this).data('sfx');
    $('#btn_salva_dettaglio').attr('data-id_dett', id_dett);
    $('#btn_salva_dettaglio').attr('data-sfx', sfx);
    
    $.ajax({
        url: "/" + nome_progetto + "/controller/Cartella.php",
        type: "POST",
        data: {operation: "retrieveDettaglioSpec",
            sfx: sfx,
            id_dett: id_dett
            
        },
        success: function (res) {
            $("#div_dati_dettaglio_spec").html(res);
        }
    })
    

})

$(".btn_preview_pdf").click(function(){
    $("#input_nome_file").val($(this).data('file'));
    $('.div_preview_pdf').hide();
    $('#'+$(this).data('id_preview')).show();
})


$('body').on('click', ".btn_allega_modal", function(){
    
    $("#btn_carica_allegato").attr("data-sfx", $(this).data('sfx'));
    $("#btn_carica_allegato").attr("data-id_dett", $(this).data('id_dett'));
})


$("#btn_carica_allegato").click(function(){
    sfx = $(this).data('sfx');
    id_dett = $(this).data('id_dett');
    
    $.ajax({
        url: "/" + nome_progetto + "/controller/Cartella.php",
        type: "POST",
        data: {operation: "inserisciAllegato" ,
                sfx: sfx,
                id_dett: id_dett,
                descrizione : $("#input_descr_allegato").val(),
                file_name: $("#input_nome_file").val()
                },
        
        success: function (res) {
            location.reload();
        },
        error: function (resx) {

        }
    });
})


/* GESTIONE CARTELLE */

$('#btn_save_tab_inf').click(function () {
    var nometab= $('.active').text();
    alert(nometab);
   
    var arr_tab;
    var tab = "";
    if(nometab.includes('Generale')){
        tab='Generale';
        
       arr_tab =  { 
                 dt_ingresso : $("#dataingresso .input-group input").val()     
                , provenienza: $('#provenienza').val()
                , stanza: $('#stanza').val()
                , letto: $('#letto').val()
                , traferimenti: $('#traferimenti').val()
                , diagnosi: $('#diagnosi').val()
                ,intolleranze_alimentari :$('#intoll-alimentari').val()
                ,allergie :$('#allergie').val()
                , infezioni: $('#infezioni').val()
                , terapia_atto: $('#terapia-atto').val()
                , carattere_vescicale: $("input[name='vescicale']:checked").val()
                , dt_inserimento: $('#input_data_inserimento .input-group input').val()
                , calibro: $('#calibro').val()
                , diuresi: $('#diuresi').val()
                
                , mezzi_contenzione: $("input[name='contenzione']:checked").val()
                , dimissione: $('#input_data_dimissione .input-group input').val()

                };
            }
        
    
        if(nometab.includes('B.A.I')){
            tab = 'B.A.I';

           arr_tab =  { 
                     app_respiratorio_ossig : $("#app_respiratorio_ossig").val()     
                    , app_circolatorio_ossig: $('#app_circolatorio_ossig').val()
                    , coscienza: $('#coscienza').val()
                    , stato_animo: $('#stato_animo').val()
                    , mobilita: $('#mobilita').val()
                    , app_urinario: $('#app_urinario').val()
                    , app_intestinale :$('#app_intestinale').val()
                    , app_sessuale :$('#app_sessuale').val()
                    , cure_mucose: $('#cure_mucose').val()
                    , igiene: $('#igiene').val()
                    , supp_parziale: $("supp_parziale").val()
                    , vestizione: $('#vestizione').val()
                    , supp_parziale_vest: $('#supp_parziale_vest').val()
                    , alimentazione: $('#alimentazione').val()
                    , riposo: $('#riposo').val()

                };
            }
            
            
            
   if(nometab.includes('Ulcere')){
       
        tab='Ulcere';
                arr_tab = 
                        { rischio : $("input[name='rischio']:checked").val()              
                        , tot: $('#tot').val()
                    };

          }


    if(nometab.includes('MNAR')){
         tab='MNAR';
                arr_tab = 
                        { peso: $('#peso').val()
                         ,statura:$('#statura').val()
                        , punteggioA : $("#punteggioA").val()              
                        , punteggioB: $('#punteggioB').val()
                        , punteggioC: $('#punteggioC').val()
                        , punteggioD: $('#punteggioD').val()
                        , punteggioE: $('#punteggioE').val()
                        , punteggioF1: $('#punteggioF1').val()
                        , punteggioF2: $('#punteggioF2').val()
                        , screening: $('#screening').val()
                    };

          }


    if(nometab.includes('VAS')){
         tab='VAS';
                arr_tab = 
                        { liv_dolore : $("#liv_dolore").val()              
                    };

          }
  
  
    if(nometab.includes('Ulcere diabetiche')){
        
         tab='Ulcere diabetiche';
                     arr_tab =  
                             { descrizione_ulc_diab : $("#descrizione_ulc_diab").val()              
                             , valutazione: $('#valutazione').val()
                             , conclusione: $('#conclusione').val()
                         };

               }
               
               
    if(nometab.includes('Lesioni da decubito')){
            
             tab='Lesioni da decubito';
                arr_tab = 
                        { 
                         medicazione : $("#medicazioneI-II").val()              
                        , medicazione_flittene: $('#medicazione_flittene').val()
                        , medicazione_escara: $('#medicazione_escara').val()
                        , medicazione_emorragica: $('#medicazione_emorragica').val()
                        , medicazione_essudativa: $('#medicazione_essudativa').val()
                        , medicazione_cavitaria: $('#medicazione_cavitaria').val()
                        , medicazione_granullegiante: $('#medicazione_granullegiante').val()
                        , medicazione_infetta: $('#medicazione_infetta').val()
                    };

          }
          
          
          
    if(nometab.includes('Lesioni cutanee')){
            
             tab='Lesioni cutanee';
                arr_tab = 
                        { 
                            stadioI:$('#stadioI').prop("checked"),
                            stadioII:$('#stadioII').prop("checked"),
                            stadioIII:$('#stadioIII').prop("checked"),
                            stadioIV:$('#stadioIV').prop("checked"),
                            
                            escara:$('#escara').prop("checked"),
                            emoraggia:$('#emoraggia').prop("checked"),
                            essudativa:$('#essudativa').prop("checked"),
                            necrotica:$('#necrotica').prop("checked"),
                            fibrinosa:$('#fibrinosa').prop("checked"),
                            cavitaria:$('#cavitaria').prop("checked"),
                            granulleggiante:$('#granulleggiante').prop("checked"),
                            infetta:$('#infetta').prop("checked"),
                            occipite: $('#occipite').val(),
                            sterno: $('#sterno').val(),
                            prominenze: $('#prominenze').val(),
                            sacro: $('#sacro').val(),
                            pube: $('#pube').val(),
                            
                            dx_orecchio: $('#dx_orecchio').prop("checked"),
                            sx_orecchio: $('#sx_orecchio').prop("checked"),
                            grado_orecchio: $('#grado-orecchio').val(),
                            
                            
                            dx_zigomi: $('#dx_zigomi').prop("checked"),
                            sx_zigomi: $('#sx_zigomi').prop("checked"),
                            grado_zigomi: $('#grado-zigomi').val(),
                            
                            dx_clavicole: $('#dx_clavicole').prop("checked"),
                            sx_clavicole: $('#sx_clavicole').prop("checked"),
                            grado_clavicole: $('#grado-clavicole').val(),
                            
                            
                            dx_spalla: $('#dx_spalla').prop("checked"),
                            sx_spalla: $('#sx_spalla').prop("checked"),
                            grado_spalla: $('#grado-spalla').val(),
                            
                            
                            dx_scapole: $('#dx_scapole').prop("checked"),
                            sx_scapole: $('#sx_scapole').prop("checked"),
                            grado_scapole: $('#grado-scapole').val(),
                            
                            dx_costato: $('#dx_costato').prop("checked"),
                            sx_costato: $('#sx_costato').prop("checked"),
                            grado_costato: $('#grado-costato').val(),
                            
                            
                            dx_creste: $('#dx_creste').prop("checked"),
                            sx_creste: $('#sx_creste').prop("checked"),
                            grado_creste: $('#grado-creste').val(),
                            
                            
                            
                            
                            dx_trocantieri: $('#dx_trocantieri').prop("checked"),
                            sx_trocantieri: $('#sx_trocantieri').prop("checked"),
                            grado_trocantieri: $('#grado-trocantieri').val(),
                            
                            
                            dx_prominenze: $('#dx_prominenze').prop("checked"),
                            sx_prominenze: $('#sx_prominenze').prop("checked"),
                            grado_prominenze: $('#grado-prominenze').val(),
                            
                            dx_ginocchio: $('#dx_ginocchio').prop("checked"),
                            sx_ginocchio: $('#sx_ginocchio').prop("checked"),
                            grado_ginocchio: $('#grado-ginocchio').val(),
                            
                            
                            dx_tibia_med: $('#dx_tibia_med').prop("checked"),
                            sx_tibia_med: $('#sx_tibia_med').prop("checked"),
                            grado_tibia_med: $('#grado-tibia_med').val(),
                            
                            
                            dx_tibia_lat: $('#dx_tibia_lat').prop("checked"),
                            sx_tibia_lat: $('#sx_tibia_lat').prop("checked"),
                            grado_tibia_lat: $('#grado-tibia_lat').val(),
                            
                            
                            dx_piede: $('#dx_piede').prop("checked"),
                            sx_piede: $('#sx_piede').prop("checked"),
                            grado_piede: $('#grado-piede').val(),
                            
                            
                            dx_talloni: $('#dx_talloni').prop("checked"),
                            sx_talloni: $('#sx_talloni').prop("checked"),
                            grado_talloni: $('#grado-talloni').val(),
                            
                            
                            descrizione_les_cutanee: $('#descrizione-les-cutanee').val()

                    };

          }
          
    if(nometab.includes('Esame Neurologico')){
            
             tab='Esame Neurologico';
                arr_tab = 
                        { 
                            facies:$('#facies').val(),
                            stato_coscienza:$('#stato_coscienza').val(),
                            stato_emotivo:$('#stato_emotivo').val(),
                            comportamento:$('#comportamento').val(),
                            
                            linguaggio:$('#linguaggio').val(),
                            concentrazione:$('#concentrazione').val(),
                            disturbi_pensiero:$('#disturbi_pensiero').val(),
                            orientamento_personale:$('#orientamento_personale').val(),
                            orientamento_temporale:$('#orientamento_temporale').val(),
                            orientamento_spaziale:$('#orientamento_spaziale').val(),
                            staz_eretta:$('#staz_eretta').val(),
                            seduto:$('#seduto').val(),
                            anomalie_posturali: $('#anomalie_posturali').val(),
                            
                            romberg : $("input:radio[name='romberg']:checked").val(),
                            andatura: $('#andatura').val(),
                            mov_involontari: $('#mov_involontari').val(),
                            olfatto: $('#olfatto').val(),
                            pupille: $('#pupille').val(),
                            
                            visus: $('#visus').val(),                          
                            campo_vis: $('#campo_vis').val(),
                            oculare:$('#oculare').val(),
                            
                            mov_oculari: $('#mov_oculari').val(),                          
                            masticazione: $('#masticazione').val(),
                            mot_facciale:$('#mot_facciale').val(),
                            funz_uditiva: $('#funz_uditiva').val(),                          
                            funz_vest: $('#funz_vest').val(),
                            mot_faringea:$('#mot_faringea').val(),
                            trofisma: $('#trofisma').val(),                          
                            articolazione: $('#articolazione').val(),
                            annotazioni:$('#annotazioni').val(),
                            
                            tono: $('#tono').val(),                          
                            forza: $('#forza').val(),
                            coordinazione:$('#coordinazione').val(),
                            
                             riflessi_osteo: $('#riflessi_osteo').val(),                          
                            sens_sup: $('#sens_sup').val(),
                            sens_prof:$('#sens_prof').val(),
                             fun_cereb: $('#fun_cereb').val(),                          
                            extrapirabidali: $('#extrapirabidali').val(),
                            meninge:$('#meninge').val(),
                            sfinteri:$('#sfinteri').val(),
                            
                            descrizione_les_cutanee: $('#annotazioni_neuro').val()

                    };

          }
 
 
 alert(JSON.stringify(arr_tab))
var id_paziente= $('#id_paziente').text();
        $.ajax({
         url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {operation: "insertOrUpdateTab", 
            id_master: 2, 
            id_paziente : id_paziente,
            nome_tab:tab,
            json: arr_tab
        },
        success: function (res) {
           
            console.log(res);
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100)
                window.location.href = '/' + nome_progetto + '/home';
            else {
                $('#div_auth_logger').html('Errore di autenticazione. Riprovare');
            }
        },
        error: function (rese) {
            alert(JSON.stringify(rese));
        }
    });
})



function getDatiPanelInfermAnagrafica() {
    var id_paziente= $('#id_paziente').text();
    $.ajax({
        url: "/" + nome_progetto + "/controller/Anagrafica.php",
        type: "POST",
        data: {
             operation: "getDatiPanelAnagrafica"
            ,id_paziente : id_paziente
        },
        success: function (res) {
            var obj=JSON.parse(res);
          
            console.log(JSON.parse(res));
            var data=obj.data_nasc.split('-')[2] +'/' + obj.data_nasc.split('-')[1] + '/'+obj.data_nasc.split('-')[0];
            
            $('#input_data_nascita .input-group.date').datepicker('setDate',data);
             
            if(obj.sesso == 'M')
                $("input:radio[name='sesso']").filter('[value=M]').prop('checked', true);
            else
                 $("input:radio[name='sesso']").filter('[value=F]').prop('checked', true);
            $('#fullnome').val(obj.cognome+' ' + obj.nome);
            $('#luogo_nascita').val(obj.localita);
            $('#residenza').val(obj.residenza);
            $('#stato_civile').val(obj.stato_civile);
            $('#professione').val(obj.professione);
            
            $('#medico').val(obj.medico_curante);
            $('#tel_medico').val(obj.medico_curante_tel);
            
            $('#rif').val(obj.riferimento);
            $('#tel_rif').val(obj.riferimento_tel);
            
            
            $('#rif').val(obj.riferimento);
            $('#tel_rif').val(obj.riferimento_tel);
            
            $('#panel-gen input').prop('readonly','true');
            
            
           // $('#div_lista_anagrafiche').html(res);
        },
        error: function (rese) {
            alert(rese);
        }
    });
}


function getDatiPanelMedAnagrafica() {
    var id_paziente= $('#id_anagrafica').text();
    $.ajax({
        url: "/" + nome_progetto + "/controller/Anagrafica.php",
        type: "POST",
        data: {
             operation: "getDatiPanelAnagrafica"
            ,id_paziente : id_paziente
        },
        success: function (res) {
            var obj=JSON.parse(res);
          
            console.log(JSON.parse(res));
            var data=obj.data_nasc.split('-')[2] +'/' + obj.data_nasc.split('-')[1] + '/'+obj.data_nasc.split('-')[0];
            
            $('#input_data_nascita .input-group.date').datepicker('setDate',data);
             
            if(obj.sesso == 'M')
                $("input:radio[name='sesso']").filter('[value=M]').prop('checked', true);
            else
                 $("input:radio[name='sesso']").filter('[value=F]').prop('checked', true);
            $('#fullnome').val(obj.cognome+' ' + obj.nome);
            $('#luogo_nascita').val(obj.localita);
            $('#residenza').val(obj.residenza);
            $('#stato_civile').val(obj.stato_civile);
            $('#professione').val(obj.professione);
            
            $('#ssn').val(obj.ssn);
            $('#ticket').val(obj.ticket);
            $('#del').val(obj.del);
            
            $('#rif').val(obj.riferimento);
            $('#tel_rif').val(obj.riferimento_tel);
            
            
            $('#rif').val(obj.riferimento);
            $('#tel_rif').val(obj.riferimento_tel);
            
            $('#panel-gen input').prop('readonly','true');
            
            
           // $('#div_lista_anagrafiche').html(res);
        },
        error: function (rese) {
            alert(rese);
        }
    });
}



function getDatiTabsInf() {
    var id_paziente= $('#id_paziente').text();
    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {
             operation: "getListaTab"
            ,id_master: 2
            ,id_paziente : id_paziente
        },
        success: function (res) {
            var obj=JSON.parse(res);
          
          for(i = 0 ; i < obj.length; i++){
              
            if(obj[i].nome_tab == 'Generale'){
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);

                
                    $("#dataingresso .input-group input").val(json.dataingresso);     
                    $('#provenienza').val(json.provenienza);    
                    $('#traferimenti').val(json.dataingresso);    
                    $('#stanza').val(json.stanza);    
                    $('#letto').val(json.letto);    
                    $('#diagnosi').val(json.diagnosi);       
                    $('#trasferimenti').val(json.trasferimenti); 
                    $('#intoll-alimentari').val(json.intolleranze_alimentari);
                    
                    $('#intoll-alimentari').val(json.intolleranze_alimentari);
                    $('#allergie').val(json.allergie);
                    $('#terapia-atto').val(json.terapia_atto);
                    
                    if(json.carattere_vescicale == 'si')
                        $("input:radio[name='vescicale']").filter('[value=si]').prop('checked', true);
                    else
                         $("input:radio[name='vescicale']").filter('[value=no]').prop('checked', true);

                    
                    $('#input_data_inserimento .input-group input').val(json.dt_inserimento);
                    $('#calibro').val(json.calibro);
                    $('#diuresi').val(json.diuresi);
                    
                     if(json.mezzi_contenzione == 'si')
                        $("input:radio[name='contenzione']").filter('[value=si]').prop('checked', true);
                    else
                         $("input:radio[name='contenzione']").filter('[value=no]').prop('checked', true);
                    $('#input_data_dimissione .input-group input').val(json.dimissione);

            }
            
            
            
            if(obj[i].nome_tab == 'B.A.I'){
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);

                
                    $("#app_respiratorio_ossig").val(json.app_respiratorio_ossig);    
                    $('#app_circolatorio_ossig').val(json.app_circolatorio_ossig);
                    $('#coscienza').val(json.coscienza);
                    $('#stato_animo').val(json.stato_animo);
                    $('#mobilita').val(json.mobilita);
                    $('#app_urinario').val(json.app_urinario);
                    $('#app_intestinale').val(json.app_intestinale);
                    $('#app_sessuale').val(json.app_sessuale);
                    $('#cure_mucose').val(json.cure_mucose);
                    $('#igiene').val(json.igiene);
                    $("supp_parziale").val(json.supp_parziale);
                    $('#vestizione').val(json.vestizione);
                    $('#supp_parziale_vest').val(json.supp_parziale_vest);
                    $('#alimentazione').val(json.alimentazione);
                    $('#riposo').val(json.riposo);

            }
            
            
            if(obj[i].nome_tab == 'Ulcere'){
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);
                  $("input[name=rischio][value=" + json.rischio + "]").attr('checked', 'checked');            
                  $('#tot').val(json.tot);
            }
            
            if(obj[i].nome_tab == 'MNAR'){
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);
                        $('#peso').val(json.peso);
                        $('#statura').val(jso.statura);
                        $("#punteggioA").val(json.punteggioA);              
                        $('#punteggioB').val(json.punteggioB);
                        $('#punteggioC').val(json.punteggioC);
                        $('#punteggioD').val(json.punteggioD);
                        $('#punteggioE').val(json.punteggioE);
                        $('#punteggioF1').val(json.punteggioF1);
                        $('#punteggioF2').val(json.punteggioF2);
                        $('#screening').val(json.screening);
                    }
                          
            if(obj[i].nome_tab == 'VAS'){
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);
                  $("#liv_dolore").val(json.liv_dolore);      
            }
            
            
            if(obj[i].nome_tab == 'Ulcere diabetiche'){
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);
                    $("#descrizione_ulc_diab").val(json.descrizione_ulc_diab);              
                    $('#valutazione').val(json.valutazione);
                    $('#conclusione').val(json.conclusione);
            }
            
            
            if(obj[i].nome_tab == 'Lesioni da decubito'){
                
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);
                    $("#medicazioneI-II").val(json.medicazione);       
                    $('#medicazione_flittene').val(json.medicazione_flittene);
                    $('#medicazione_escara').val(json.medicazione_escara); 
                    $('#medicazione_emorragica').val(json.medicazione_emorragica);
                    $('#medicazione_essudativa').val(json.medicazione_essudativa);
                    $('#medicazione_cavitaria').val(json.medicazione_cavitaria);
                    $('#medicazione_granullegiante').val(json.medicazione_granullegiante);
                    $('#medicazione_infetta').val(json.medicazione_infetta);
            }
            
            
            if(obj[i].nome_tab == 'Lesioni cutanee'){
                
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);
                  
                   $('#stadioI').prop("checked",json.stadioI =='true');
                   $('#stadioII').prop("checked",json.stadioII =='true');
                   $('#stadioIII').prop("checked",json.stadioIII =='true');
                   $('#stadioIV').prop("checked",json.stadioIV =='true');
                            
                   $('#escara').prop("checked",json.escara =='true');
                   $('#emoraggia').prop("checked",json.emoraggia =='true');
                   $('#essudativa').prop("checked",json.essudativa =='true');
                   $('#necrotica').prop("checked",json.necrotica =='true');
                   $('#fibrinosa').prop("checked",json.fibrinosa =='true');
                   $('#cavitaria').prop("checked",json.cavitaria =='true');
                   $('#granulleggiante').prop("checked",json.granulleggiante =='true');
                   $('#infetta').prop("checked",json.infetta =='true');
                   $('#occipite').val(json.occipite);
                   $('#sterno').val(json.sterno);
                   $('#prominenze').val(json.prominenze);
                   $('#sacro').val(json.sacro);
                   $('#pube').val(json.pube);
                            
                   $('#dx_orecchio').prop("checked",json.dx_orecchio =='true');
                   $('#sx_orecchio').prop("checked",json.sx_orecchio =='true');
                   $('#grado-orecchio').val(json.grado_orecchio);
                            
                            
                            $('#dx_zigomi').prop("checked",json.dx_zigomi =='true');
                            $('#sx_zigomi').prop("checked",json.sx_zigomi =='true');
                            $('#grado-zigomi').val(json.grado_zigomi);
                            
                            $('#dx_clavicole').prop("checked",json.dx_clavicole =='true');
                            $('#sx_clavicole').prop("checked",json.sx_clavicole =='true');
                            $('#grado-clavicole').val(json.grado_clavicole);
                            
                            
                            $('#dx_spalla').prop("checked",json.dx_spalla =='true');
                            $('#sx_spalla').prop("checked",json.sx_spalla =='true');
                            $('#grado-spalla').val(json.grado_spalla);
                            
                            
                            $('#dx_scapole').prop("checked",json.dx_scapole =='true');
                            $('#sx_scapole').prop("checked",json.sx_scapole =='true');
                            $('#grado-scapole').val(json.grado_scapole);
                            
                            $('#dx_costato').prop("checked",json.dx_costato =='true');
                            $('#sx_costato').prop("checked",json.sx_costato =='true');
                            $('#grado-costato').val(json.grado_costato);
                            
                            
                            $('#dx_creste').prop("checked",json.dx_creste =='true');
                            $('#sx_creste').prop("checked",json.sx_creste =='true');
                            $('#grado-creste').val(json.grado_creste);
                            
                            
                            
                            
                            $('#dx_trocantieri').prop("checked",json.dx_trocantieri =='true');
                            $('#sx_trocantieri').prop("checked",json.sx_trocantieri =='true');
                            $('#grado-trocantieri').val(json.grado_trocantieri);
                            
                            
                            $('#dx_prominenze').prop("checked",json.dx_prominenze =='true');
                            $('#sx_prominenze').prop("checked",json.sx_prominenze =='true');
                            $('#grado-prominenze').val(json.grado_prominenze);
                            
                            $('#dx_ginocchio').prop("checked",json.dx_ginocchio =='true');
                            $('#sx_ginocchio').prop("checked",json.sx_ginocchio =='true');
                            $('#grado-ginocchio').val(json.grado_ginocchio);
                            
                            
                            $('#dx_tibia_med').prop("checked",json.dx_tibia_med =='true');
                            $('#sx_tibia_med').prop("checked",json.sx_tibia_med =='true');
                            $('#grado-tibia_med').val(json.grado_tibia_med);
                            
                            
                            $('#dx_tibia_lat').prop("checked",json.dx_tibia_lat =='true');
                            $('#sx_tibia_lat').prop("checked",json.sx_tibia_lat =='true');
                            $('#grado-tibia_lat').val(json.grado_tibia_lat);
                            
                            
                            $('#dx_piede').prop("checked",json.dx_piede =='true');
                            $('#sx_piede').prop("checked",json.sx_piede =='true');
                            $('#grado-piede').val(json.grado_piede);
                            
                            
                           $('#dx_talloni').prop("checked",json.dx_talloni =='true');
                           $('#sx_talloni').prop("checked",json.sx_talloni =='true');
                           $('#grado-talloni').val(json.grado_talloni);
                            
                            
                           $('#descrizione-les-cutanee').val(json.descrizione-les-cutanee); 
            }
         
          }
      },

        error: function (rese) {
            alert(rese);
        }
    
    });
}


/* SEZIONE CARTELLA MEDICA */

$('#btn_save_tab_med').click(function () {
    var nometab= $('.active').text();
    alert(nometab);
   
    var arr_tab;
    var tab = "";
    if(nometab.includes('Generale')){
        tab='Generale';
        
       arr_tab =  { 
                 dt_ingresso : $("#dataingresso .input-group input").val()     
                , provenienza: $('#provenienza').val()
                , ricovero:$('#ricovero').val()
                , stanza: $('#stanza').val()
                , letto: $('#letto').val()
                , diagnosi: $('#diagnosi').val()
                , allergie :$('#allergie').val()
                , trasferimenti :$('#trasferimenti').val()
                , data_trasferimento: $('#data_trasferimento .input-group input').val()
                , data_dimissione: $('#data_dimissione .input-group input').val()
                , data_decesso: $('#data_decesso .input-group input').val()
                , causa_dec: $('#causa-dec').val()

                };
            }
            
            
   if(nometab.includes('Anamnesi famigliare')){
       
        tab='Anamnesi famigliare';
                arr_tab = 
                        { 
                            ipertensione: $('#ipertensione').prop('checked')
                            ,diabate: $('#diabate').prop('checked')
                            ,cardiovascolari: $('#cardiovascolari').prop('checked')
                            ,cerebrovascolari: $('#cerebrovascolari').prop('checked')
                            ,demenza: $('#demenza').prop('checked')
                            ,neoplasie: $('#neoplasie').prop('checked')
                            ,altro: $('#altro').prop('checked')
                            ,content_altro: $('#content_altro').val()
                            ,anamnesi:$('#anamnesi').val()
                            
                            ,antitetanica: $('#antitetanica').prop('checked')
                            ,antiepatite_b: $('#antiepatite_b').prop('checked')
                            ,antinfluenzale: $('#antinfluenzale').prop('checked')
                            ,altre: $('#altre').prop('checked')
                            ,content_altre: $('#content_altre').val()
                            , scolarita: $('#scolarita').val()
                            
                            , attivita_lavorativa: $('#attivita_lavorativa').val()
                            , servizio_mil: $('#servizio_mil').val()
                            , menarca: $('#menarca').val()
                            , menopausa: $('#menopausa').val()
                            , rb_menopausa: $("input:radio[name='rb_menopausa']:checked").val()
                            , attivita_fisica: $('#attivita_fisica').val()
                            , alimentazione: $('#alimentazione').val()
                            , alvo: $('#alvo').val()
                            , diuresi: $('#diuresi').val() 
                            , alcolici: $('#alcolici').val()
                            , fumo: $('#fumo').val()
                            , sonno: $('#sonno').val()
                    };

          }


    if(nometab.includes('Anamnesi patologica')){
         tab='Anamnesi patologica';
                arr_tab = 
                        { ana_patol_remota: $('#ana_patol_remota').val()
                         ,ana_patol_pross:$('#ana_patol_pross').val()
                        , terapia : $("#terapia").val()              
                        , reazioni_avverse: $('#reazioni_avverse').val()
                    };

          }


    if(nometab.includes('Esame Generale')){
         tab='Esame Generale';
                arr_tab = 
                        { tipo_costituzionale : $("#tipo_costituzionale").val() 
                          ,condizioni_gen:$("#condizioni_gen").val()
                          ,nutrizione:$("#nutrizione").val()
                          ,cute:$("#cute").val()
                          ,linfonodale:$("#linfonodale").val()
                          ,capo_collo:$("#capo_collo").val()
                          ,protesi:$("#protesi").val()
                          ,urogemitale:$("#urogemitale").val()
                          
                          ,muscoloscheletrico:$("#muscoloscheletrico").val()
                          ,cuore:$("#cuore").val()
                          ,freq:$("#freq").val()
                          
                          
                          ,pressione:$("#pressione").val()
                          ,polsi:$("#polsi").val()
                          ,apparato_resp:$("#apparato_resp").val()
                          
                          
                            ,addome:$("#addome").val()
                          ,fegato:$("#fegato").val()
                          ,milza:$("#milza").val()
                    };

          }
  
    if(nometab.includes('Esame Neurologico')){
            
             tab='Esame Neurologico';
                arr_tab = 
                        { 
                            facies:$('#facies').val(),
                            stato_coscienza:$('#stato_coscienza').val(),
                            stato_emotivo:$('#stato_emotivo').val(),
                            comportamento:$('#comportamento').val(),
                            
                            linguaggio:$('#linguaggio').val(),
                            concentrazione:$('#concentrazione').val(),
                            disturbi_pensiero:$('#disturbi_pensiero').val(),
                            orientamento_personale:$('#orientamento_personale').val(),
                            orientamento_temporale:$('#orientamento_temporale').val(),
                            orientamento_spaziale:$('#orientamento_spaziale').val(),
                            staz_eretta:$('#staz_eretta').val(),
                            seduto:$('#seduto').val(),
                            anomalie_posturali: $('#anomalie_posturali').val(),
                            
                            romberg : $("input:radio[name='romberg']:checked").val(),
                            andatura: $('#andatura').val(),
                            mov_involontari: $('#mov_involontari').val(),
                            olfatto: $('#olfatto').val(),
                            pupille: $('#pupille').val(),
                            
                            visus: $('#visus').val(),                          
                            campo_vis: $('#campo_vis').val(),
                            oculare:$('#oculare').val(),
                            
                            mov_oculari: $('#mov_oculari').val(),                          
                            masticazione: $('#masticazione').val(),
                            mot_facciale:$('#mot_facciale').val(),
                            funz_uditiva: $('#funz_uditiva').val(),                          
                            funz_vest: $('#funz_vest').val(),
                            mot_faringea:$('#mot_faringea').val(),
                            trofisma: $('#trofisma').val(),                          
                            articolazione: $('#articolazione').val(),
                            annotazioni:$('#annotazioni').val(),
                            
                            tono: $('#tono').val(),                          
                            forza: $('#forza').val(),
                            coordinazione:$('#coordinazione').val(),
                            
                             riflessi_osteo: $('#riflessi_osteo').val(),                          
                            sens_sup: $('#sens_sup').val(),
                            sens_prof:$('#sens_prof').val(),
                             fun_cereb: $('#fun_cereb').val(),                          
                            extrapirabidali: $('#extrapirabidali').val(),
                            meninge:$('#meninge').val(),
                            sfinteri:$('#sfinteri').val(),
                            
                            annotazioni_neuro: $('#annotazioni_neuro').val()

                    };

          }
          
    if(nometab.includes('Valutazione tecniche')){
        
         tab='Valutazione tecniche';
                     arr_tab =  
                             { sociale : $("#sociale").val()              
                             , educativa: $('#educativa').val()
                             , psicologica: $('#psicologica').val()
                             , motoria: $('#motoria').val()
                         };

               }
               
               
    if(nometab.includes('Mezzi di contenzione')){
            
             tab='Mezzi di contenzione';
                arr_tab = 
                        { 
                         mezzi_cont :  $("input:radio[name='mezzi_cont']:checked").val()               
                        , check_spondine_letto: $('#check_spondine_letto').prop('checked')      
                        , spondine_letto: $("input:radio[name='spondine_letto']:checked").val()
                        , check_contenzione_pelvica: $('#check_contenzione_pelvica').prop('checked')
                        , check_pettorina: $('#check_pettorina').prop('checked')
                        , check_cintura_addom: $('#check_cintura_addom').prop('checked')
                        , check_cintura_letto: $('#check_cintura_letto').prop('checked')
                        , check_cinghia: $('#check_cinghia').prop('checked')      
                        , cinghia: $("input:radio[name='cinghia']:checked").val()
                        , check_tav_carrozzina: $('#check_tav_carrozzina').val()
                        , consenso: $("input:radio[name='consenso']:checked").val()
                        , inizio: $("input:radio[name='inizio']:checked").val()
                        , motivo: $('#motivo').val()
                        , tempi: $('#tempi').val()
                        , durata: $('#durata').val()
                        , interruzione: $('#interruzione').val()
                        , motivo_interr: $('#motivo_interr').val()
                    };

          }
 
 
 alert(JSON.stringify(arr_tab))
var id_paziente= $('#id_paziente').text();
        $.ajax({
         url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {operation: "insertOrUpdateTab", 
            id_master: 1, 
            id_paziente : id_paziente,
            nome_tab:tab,
            json: arr_tab
        },
        success: function (res) {
           
            console.log(res);
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100)
                window.location.href = '/' + nome_progetto + '/home';
            else {
                $('#div_auth_logger').html('Errore di autenticazione. Riprovare');
            }
        },
        error: function (rese) {
            alert(JSON.stringify(rese));
        }
    });
})



function getDatiTabsMed() {
    var id_paziente= $('#id_paziente').text();
    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {
             operation: "getListaTab"
            ,id_master: 1
            ,id_paziente : id_paziente
        },
        success: function (res) {
            var obj=JSON.parse(res);
          
          for(i = 0 ; i < obj.length; i++){
              
            if(obj[i].nome_tab == 'Anamnesi famigliare'){
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);
                  console.log(json.ipertensione);
                $('#ipertensione').prop('checked',json.ipertensione == 'true');
                $('#diabate').prop('checked',json.diabate == 'true');
                $('#cardiovascolari').prop('checked',json.cardiovascolari == 'true');
                $('#cerebrovascolari').prop('checked',json.cerebrovascolari == 'true');
                $('#demenza').prop('checked',json.demenza == 'true');
                $('#neoplasie').prop('checked',json.neoplasie == 'true');
                $('#altro').prop('checked',json.altro == 'true');
                $('#content_altro').val(json.content_altro);
                $('#anamnesi').val(json.anamnesi );

                $('#antitetanica').prop('checked',json.antitetanica == 'true');
                $('#antiepatite_b').prop('checked',json.antiepatite_b == 'true');
                $('#antinfluenzale').prop('checked',json.antinfluenzale == 'true');
                $('#altre').prop('checked',json.altre == 'true');
                $('#content_altre').val(json.content_altre);
                $('#scolarita').val(json.scolarita);

                $('#attivita_lavorativa').val(json.attivita_lavorativa);
                $('#servizio_mil').val(json.servizio_mil);
                $('#menarca').val(json.menarca);
                $('#menopausa').val(json.menopausa);
                $("input:radio[name='rb_menopausa']:checked").val(json.rb_menopausa);
                $('#attivita_fisica').val(json.attivita_fisica);
                $('#alimentazione').val(json.alimentazione);
                $('#alvo').val(json.alvo);
                $('#diuresi').val(json.diuresi);
                $('#alcolici').val(json.alcolici);
                $('#fumo').val(json.fumo);
                $('#sonno').val(json.sonno);
            }
            
            if(obj[i].nome_tab == 'Anamnesi patologica'){
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);
                  $('#ana_patol_remota').val(json.ana_patol_remota);
                  $('#ana_patol_pross').val(json.ana_patol_pross);
                  $("#terapia").val(json.terapia);              
                  $('#reazioni_avverse').val(json.reazioni_avverse);
            }
                          
            if(obj[i].nome_tab == 'Generale'){
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);
                    $("#dataingresso .input-group input").val(json.dataingresso);     
                    $('#provenienza').val(json.provenienza);    
                    $('#ricovero').val(json.dataingresso);    
                    $('#stanza').val(json.ricovero);    
                    $('#letto').val(json.letto);    
                    $('#diagnosi').val(json.diagnosi);    
                    $('#allergie').val(json.allergie);    
                    $('#trasferimenti').val(json.trasferimenti);    
                    $('#data_trasferimento .input-group input').val(json.data_trasferimento);    
                    $('#data_dimissione .input-group input').val(json.data_dimissione);    
                    $('#data_decesso .input-group input').val(json.data_decesso);    
                    $('#causa-dec').val(json.causa-dec);    
            }
            
            
            if(obj[i].nome_tab == 'Esame Generale'){
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);
                    $("#tipo_costituzionale").val(json.tipo_costituzionale);
                    $("#condizioni_gen").val(json.condizioni_gen);
                    $("#nutrizione").val(json.nutrizione);
                    $("#cute").val(json.cute);
                    $("#linfonodale").val(json.linfonodale);
                    $("#capo_collo").val(json.capo_collo);
                    $("#protesi").val(json.protesi);
                    $("#urogemitale").val(json.urogemitale);
                          
                    $("#muscoloscheletrico").val(json.muscoloscheletrico);
                    $("#cuore").val(json.cuore);
                    $("#freq").val(json.freq);
                          
                          
                    $("#pressione").val(json.pressione);
                    $("#polsi").val(json.polsi);
                    $("#apparato_resp").val(json.apparato_resp);
                          
                          
                    $("#addome").val(json.addome);
                    $("#fegato").val(json.fegato);
                    $("#milza").val(json.milza);
            }
            if(obj[i].nome_tab == 'Esame Neurologico'){
                console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);
                            $('#facies').val(json.facies);
                            $('#stato_coscienza').val(json.stato_coscienza);
                            $('#stato_emotivo').val(json.stato_emotivo);
                            $('#comportamento').val(json.comportamento);
                            
                            $('#linguaggio').val(json.linguaggio);
                            $('#concentrazione').val(json.concentrazione);
                            $('#disturbi_pensiero').val(json.disturbi_pensiero);
                            $('#orientamento_personale').val(json.orientamento_personale);
                            $('#orientamento_temporale').val(json.orientamento_temporale);
                            $('#orientamento_spaziale').val(json.orientamento_spaziale);
                            $('#staz_eretta').val(json.staz_eretta);
                            $('#seduto').val(json.seduto);
                            $('#anomalie_posturali').val(json.anomalie_posturali);
                            
                            $("input:radio[name='romberg']:checked").val(json.romberg);
                            $('#andatura').val(json.andatura);
                            $('#mov_involontari').val(json.mov_involontari);
                            $('#olfatto').val(json.olfatto);
                            $('#pupille').val(json.pupille);
                            
                            $('#visus').val(json.visus);                         
                            $('#campo_vis').val(json.campo_vis);
                            $('#oculare').val(json.oculare);
                            
                            $('#mov_oculari').val(json.mov_oculari);                          
                            $('#masticazione').val(json.masticazione);
                            $('#mot_facciale').val(json.mot_facciale);
                            $('#funz_uditiva').val(json.funz_uditiva);                          
                            $('#funz_vest').val(json.funz_vest);
                            $('#mot_faringea').val(json.mot_faringea);
                            $('#trofisma').val(json.trofisma);                          
                            $('#articolazione').val(json.articolazione);
                            $('#annotazioni').val(json.annotazioni);
                            
                            $('#tono').val(json.tono);                         
                            $('#forza').val(json.forza);
                            $('#coordinazione').val(json.coordinazione);
                            
                            $('#riflessi_osteo').val(json.riflessi_osteo);                          
                            $('#sens_sup').val(json.sens_sup);
                            $('#sens_prof').val(json.sens_prof);
                            $('#fun_cereb').val(json.fun_cereb);                          
                            $('#extrapirabidali').val(json.extrapirabidali);
                            $('#meninge').val(json.meninge);
                            $('#sfinteri').val(json.sfinteri);
                            
                            $('#annotazioni_neuro').val(json.annotazioni_neuro);
            }
            
            if(obj[i].nome_tab == 'Valutazione tecniche'){
                
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);
                   $("#sociale").val(json.sociale);              
                   $('#educativa').val(json.educativa); 
                   $('#psicologica').val(json.psicologica); 
                   $('#motoria').val(json.motoria); 
            }
            
            
            if(obj[i].nome_tab == 'Mezzi di contenzione'){
                
                  console.log(obj[i].nome_tab);
                  var json = JSON.parse(obj[i].json);
                  
                  console.log(json.mezzi_cont);
                  
                  
                    if(json.mezzi_cont == 'si')
                        $("input:radio[name='mezzi_cont']").filter('[value=si]').prop('checked', true);
                    else
                         $("input:radio[name='mezzi_cont']").filter('[value=no]').prop('checked', true);
             
            
                    $('#check_spondine_letto').prop('checked',json.check_spondine_letto == 'true');  
                    
                    if(json.spondine_letto == 'dx')
                        $("input:radio[name='spondine_letto']").filter('[value=dx]').prop('checked', true);
                    else
                         $("input:radio[name='spondine_letto']").filter('[value=sx]').prop('checked', true);
             

                    
                    
                    $('#check_contenzione_pelvica').prop('checked',json.check_contenzione_pelvica == 'true');
                    $('#check_pettorina').prop('checked',json.check_pettorina == 'true');
                    $('#check_cintura_addom').prop('checked',json.check_cintura_addom == 'true');
                    $('#check_cintura_letto').prop('checked',json.check_cintura_letto == 'true');
                    $('#check_cinghia').prop('checked',json.check_cinghia == 'true'); 
                    
                    if(json.cinghia == 'dx')
                        $("input:radio[name='cinghia']").filter('[value=dx]').prop('checked', true);
                    else
                         $("input:radio[name='cinghia']").filter('[value=sx]').prop('checked', true);
                     
                    $('#check_tav_carrozzina').val(json.check_tav_carrozzina);  
                    
                     if(json.consenso == 'si')
                        $("input:radio[name='consenso']").filter('[value=si]').prop('checked', true);
                    else
                         $("input:radio[name='consenso']").filter('[value=no]').prop('checked', true);
                     
                     
                     if(json.inizio == 'ingresso')
                        $("input:radio[name='inizio']").filter('[value=ingresso]').prop('checked', true);
                    else
                         $("input:radio[name='inizio']").filter('[value=input_data_ingresso]').prop('checked', true);
                      
                    $('#motivo').val(json.motivo);    
                    $('#tempi').val(json.tempi);    
                    $('#durata').val(json.durata);    
                    $('#interruzione').val(json.interruzione);    
                    $('#motivo_interr').val(json.motivo_interr);    
            }
             }

        },
        error: function (rese) {
            alert(rese);
        }
    });
}





function getListaRowsDiarioClinico() {
    var id_paziente= $('#id_paziente').text();
    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {
             operation: "getListaRowsDiarioClinico"
            ,id_paziente : id_paziente
        },
        success: function (res) {
          
            console.log(res);
            $("#tab_diario tbody").append(res);
            
        },
        error: function (rese) {
            alert(rese);
        }
    });
}



function getListaRowsVisiteSpec() {
    var id_paziente= $('#id_paziente').text();
    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {
             operation: "getListaRowsVisiteSpec"
            ,id_paziente : id_paziente
        },
        success: function (res) {
          
            console.log(res);
            
            $("#tab_vis_spec tbody").append(res);
            
        },
        error: function (rese) {
            alert(rese);
        }
    });
}



$('#btn_salva_record_vis_spec').click(function () {
    $('#div_logger').html('Caricamento in corso...');
    var id_paziente= $('#id_paziente').text();
    var id = $('#id_rec_vis').text();
        if($(this).text()=='Modifica'){
          $.ajax({
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {operation: "updateRecordVisite",
                id: id,
                contenuto:$('#content_visite').val() + ' ' + $('#new_content_visite').val()
            },
            success: function (res) {

               
                var obj_res = JSON.parse(res);
                console.log(obj_res);
                if (obj_res.stato == 100) {
                    $('#div_logger').html('Inserimento effettuato correttamente.');
                    $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger').html('');
                    });
                    $('#modal_inserisci_record_visite_spec').modal('hide');
                   $('#tab_vis_spec tbody tr').remove();
                   $("#input_data_richiesta .input-group input").val('');
                   $("#input_data_esecuzione .input-group input").val('');
                   $('#content_visite').val('');
                    getListaRowsVisiteSpec();

                } else {
                    $('#div_logger').html(res);
                }
            },
            error: function (rese) {
                alert(rese);
            }
        }); 
        
        
    }
    else{
    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {operation: "insertRecordVisiteSpec",
            id_paziente: id_paziente,
            data_richiesta: formatoData($("#input_data_richiesta .input-group input").val()),
            data_esecuzione: formatoData($("#input_data_esecuzione .input-group input").val()),
            contenuto:$('#content_visite').val()
        },
        success: function (res) {
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Inserimento effettuato correttamente.');
                $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger').html('');
                });
                 $('#modal_inserisci_record_visite_spec').modal('hide');
               $('#tab_vis_spec tbody tr').remove();
                getListaRowsVisiteSpec();
            } else {
                $('#div_logger').html(res);
            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
}
})

function formatoData(data){
    var d=data.split('/');
    
    return d[2] + '-' + d[0] + '-' + d[1];
}


$('#btn_salva_record_diario').click(function () {
    $('#div_logger').html('Caricamento in corso...');
    var id_paziente= $('#id_paziente').text();
    var id = $('#id_rec').text();
    
    if($(this).text()=='Modifica'){
       $.ajax({
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {operation: "updateRecordDiario",
                id: id,
                contenuto:$('#content_terapia').val() + ' ' + $('#new_content_terapia').val()
            },
            success: function (res) {

               
                var obj_res = JSON.parse(res);
                console.log(obj_res);
                if (obj_res.stato == 100) {
                    $('#div_logger').html('Inserimento effettuato correttamente.');
                    $('#div_logger').fadeOut("slow", function () {
                        $('#div_logger').html('');
                    });
                    $('#modal_inserisci_record_diario').modal('hide');
                   $('#tab_diario tbody tr').remove();
                   $("#input_data_terapia .input-group input").val('');
                   $("#tipo_terapia").val('');
                   $('#content_terapia').val('');
                    getListaRowsDiarioClinico();

                } else {
                    $('#div_logger').html(res);
                }
            },
            error: function (rese) {
                alert(rese);
            }
        }); 
        
        
    }
    else{
        $.ajax({
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {operation: "insertRecordDiario",
                id_paziente: id_paziente,
                data: formatoData($("#input_data_terapia .input-group input").val()),
                terapia: $("#tipo_terapia").val(),
                contenuto:$('#content_terapia').val()
            },
            success: function (res) {

                //console.log(res);
                var obj_res = JSON.parse(res);
                console.log(obj_res);
                if (obj_res.stato == 100) {
                    $('#div_logger').html('Inserimento effettuato correttamente.');
                    $('#div_logger').fadeOut("slow", function () {
                        $('#div_logger').html('');
                    });
                    $('#modal_inserisci_record_diario').modal('hide');
                   $('#tab_diario tbody tr').remove();
                   $("#input_data_terapia .input-group input").val('');
                   $("#tipo_terapia").val('');
                   $('#content_terapia').val('');
                    getListaRowsDiarioClinico();

                } else {
                    $('#div_logger').html(res);
                }
            },
            error: function (rese) {
                alert(rese);
            }
        });
    }
})


$('body').on('click', '.btn-modifica-row-diario', function () {
   
    $('#div_logger').html('Caricamento in corso...');
    var id = $(this).data('id');
    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {operation: "getRecordDiario",
            id: id
        },
        success: function (res) {
            
            //console.log(res);
            var obj_res = JSON.parse(res);
            console.log(obj_res);
            
               $('#modal_inserisci_record_diario').modal('show');
               $('#id_rec').text(id);
               $('#div_new_content_diario').css('display','inline');
               $("#input_data_terapia .input-group input").val(obj_res[0].data);
               $("#input_data_terapia .input-group input").prop('readonly',true);
               $("#tipo_terapia").val(obj_res[0].terapia);
               $("#tipo_terapia").prop('readonly',true);
               $('#content_terapia').val(obj_res[0].contenuto);
                $('#content_terapia').prop('readonly',true);
                $('#btn_salva_record_diario').text('Modifica');
                $('.modal-title').text('Modifica Terapia');
                $('#new_content_terapia').val('');
        },
        error: function (rese) {
            alert(rese);
        }
    });
   })
   
   
   
 $('body').on('click', '#btn_new_record_diario', function () {  

       $('#modal_inserisci_record_diario').modal('show');
        $('#div_new_content_diario').css('display','none');
        $("#input_data_terapia .input-group input").val('');
        $("#input_data_terapia .input-group input").prop('readonly',false);
        $("#tipo_terapia").val('');
        $("#tipo_terapia").prop('readonly',false);
        $('#content_terapia').val('');
       $('#content_terapia').prop('readonly',false);

})



$('body').on('click', '.btn-modifica-row-visite', function () {
   
    $('#div_logger').html('Caricamento in corso...');
    var id = $(this).data('id');
    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {operation: "getRecordVisite",
            id: id
        },
        success: function (res) {
            
            //console.log(res);
            var obj_res = JSON.parse(res);
            console.log(obj_res);
            
               $('#modal_inserisci_record_visite_spec').modal('show');
               $('#div_new_content').css('display','inline');
               $("#input_data_richiesta .input-group input").val(obj_res[0].data_richiesta);
               $("#input_data_richiesta .input-group input").prop('readonly',true);
               $("#content_visite").val(obj_res[0].contenuto);
               $("#content_visite").prop('readonly',true);
               $('#new_content_visite').val('');
               $('#input_data_esecuzione .input-group input').val(obj_res[0].data_esecuzione);
                $('#input_data_esecuzione .input-group input').prop('readonly',true);
                $('#id_rec_vis').text(id);
                $('#btn_salva_record_vis_spec').text('Modifica');
                $('.modal-title').text('Modifica Terapia');
        },
        error: function (rese) {
            alert(rese);
        }
    });
   })
   
   
   
 $('body').on('click', '#btn_new_record_vis_spec', function () {  

       $('#modal_inserisci_record_visite_spec').modal('show');
        $('#div_new_content').css('display','none');
        $("#input_data_richiesta .input-group input").val('');
        $("#input_data_richiesta .input-group input").prop('readonly',false);
        $("#content_visite").val('');
        $("#content_visite").prop('readonly',false);
        $('#input_data_esecuzione .input-group input').val('');
        $('#input_data_esecuzione .input-group input').prop('readonly',false);
       
        $('#btn_salva_record_vis_spec').text('Registra');
        $('.modal-title').text('Nuova Visita/Esame');

})





/* SEZIONE CARTELLA MEDICA */








function getListaRowsDiarioInf() {
    var id_paziente= $('#id_paziente').text();
    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {
             operation: "getListaRowsDiarioInf"
            ,id_paziente : id_paziente
        },
        success: function (res) {
          
            console.log(res);
            $("#tab_diario_inf tbody").append(res);
            
        },
        error: function (rese) {
            alert(rese);
        }
    });
}



function getListaRowsInterventi() {
    var id_paziente= $('#id_paziente').text();
    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {
             operation: "getListaRowsInterventi"
            ,id_paziente : id_paziente
        },
        success: function (res) {
          
            console.log(res);
            
            $("#tab_interventi tbody").append(res);
            
        },
        error: function (rese) {
            alert(rese);
        }
    });
}



 $('body').on('click', '#btn_new_record_interveneti', function () {  

       $('#modal_inserisci_record_intervento').modal('show');
        $("#input_data_interv .input-group input").val('');
        $("#input_data_interv .input-group input").prop('readonly',false);
        $("#content_diagnosi").val('');
        $("#content_diagnosi").prop('readonly',false);
        $('#content_obiettivi').val('');
        $('#content_obiettivi').prop('readonly',false);
     
     
        $("#content_interv").val('');
        $("#content_interv").prop('readonly',false);
        $('#content_valutazione').val('');
        $('#content_valutazione').prop('readonly',false);
       
        $('#btn_salva_record_interv').text('Registra');
        $('.modal-title').text('Nuovo Intervento');

})

 $('body').on('click', '#btn_new_record_diario_inf', function () {  

       $('#modal_inserisci_record_diario_inf').modal('show');
        $("#input_data_diario_inf .input-group input").val('');
        $("#input_data_diario_inf .input-group input").prop('readonly',false);
        $("#content_turno").val('');
        $("#content_turno").prop('readonly',false);
        $('#content_diario_inf').val('');
        $('#content_diario_inf').prop('readonly',false);
     
     
        $("#firma").val('');
        $("#firma").prop('readonly',false);

       
        $('#btn_salva_record_diario_inf').text('Registra');
        $('.modal-title').text('Nuovo Turno');
        
        $('#div_new_content_diario_inf').css('display','none');

})



$('#btn_salva_record_interv').click(function () {
    $('#div_logger').html('Caricamento in corso...');
    var id_paziente= $('#id_paziente').text();

    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {operation: "insertRecordInterventi",
            id_paziente: id_paziente,
            data: formatoData($("#input_data_interv .input-group input").val()),
            diagnosi: $("#content_diagnosi").val(),
            obiettivi:$('#content_obiettivi').val(),
            intervento: $("#content_interv").val(),
            valutazione:$('#content_valutazione').val()
        },
        success: function (res) {
            
            //console.log(res);
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Inserimento effettuato correttamente.');
                $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger').html('');
                });
                 $('#modal_inserisci_record_intervento').modal('hide');
               $('#tab_interventi tbody tr').remove();
                getListaRowsInterventi();
            } else {
                $('#div_logger').html(res);
            } 
        },
        error: function (rese) {
            alert(rese);
        }
    });

})



$('#btn_salva_record_diario_inf').click(function () {
    $('#div_logger').html('Caricamento in corso...');
    var id_paziente= $('#id_paziente').text();
    var id = $('#id_rec_diario_inf').text();
    
    if($(this).text()=='Modifica'){
       $.ajax({
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {operation: "updateRecordDiarioInf",
                id: id,
                contenuto:$('#content_diario_inf').val() + ' ' + $('#new_content_diario_inf').val()
            },
            success: function (res) {

               
                var obj_res = JSON.parse(res);
                console.log(obj_res);
                if (obj_res.stato == 100) {
                    $('#div_logger').html('Inserimento effettuato correttamente.');
                    $('#div_logger').fadeOut("slow", function () {
                        $('#div_logger').html('');
                    });
                   $('#modal_inserisci_record_diario_inf').modal('hide');
                   $('#tab_diario_inf tbody tr').remove();
                   $("#input_data_diario_inf .input-group input").val('');
                   $("#content_turno").val('');
                   $('#content_diario_inf').val('');
                   $('#firma').val('');
                    getListaRowsDiarioInf();

                } else {
                    $('#div_logger').html(res);
                }
            },
            error: function (rese) {
                alert(rese);
            }
        }); 
        
        
    }
    else{
        $.ajax({
            url: "/" + nome_progetto + "/controller/Tab.php",
            type: "POST",
            data: {operation: "insertRecordDiarioInf",
                id_paziente: id_paziente,
                data: formatoData($("#input_data_diario_inf .input-group input").val()),
                turno: $("#content_turno").val(),
                diario:$('#content_diario_inf').val(),
                firma:$('#firma').val()
            },
            success: function (res) {

                //console.log(res);
                var obj_res = JSON.parse(res);
                console.log(obj_res);
                if (obj_res.stato == 100) {
                    $('#div_logger').html('Inserimento effettuato correttamente.');
                    $('#div_logger').fadeOut("slow", function () {
                        $('#div_logger').html('');
                    });
                    $('#modal_inserisci_record_diario_inf').modal('hide');
                   $('#tab_diario_inf tbody tr').remove();
                   $("#input_data_diario_inf .input-group input").val('');
                   $("#content_turno").val('');
                   $('#content_diario_inf').val('');
                   $('#firma').val('');
                    getListaRowsDiarioInf();

                } else {
                    $('#div_logger').html(res);
                }
            },
            error: function (rese) {
                alert(rese);
            }
        });
    }
})



$('body').on('click', '.btn-modifica-row-diario-inf', function () {
   
    $('#div_logger').html('Caricamento in corso...');
    var id = $(this).data('id');
    $.ajax({
        url: "/" + nome_progetto + "/controller/Tab.php",
        type: "POST",
        data: {operation: "getRecordDiarioInf",
            id: id
        },
        success: function (res) {
            
            //console.log(res);
            var obj_res = JSON.parse(res);
            console.log(obj_res);
            
               $('#modal_inserisci_record_diario_inf').modal('show');
               $('#id_rec_diario_inf').text(id);
               $('#div_new_content_diario_inf').css('display','inline');
               $("#input_data_diario_inf .input-group input").val(obj_res[0].data);
               $("#input_data_diario_inf .input-group input").prop('readonly',true);
               $("#content_turno").val(obj_res[0].turno);
               $("#content_turno").prop('readonly',true);
               $('#content_diario_inf').val(obj_res[0].diario);
               $('#content_diario_inf').prop('readonly',true);
               $('#firma').val(obj_res[0].firma);
               $('#firma').prop('readonly',true);
               
               
                $('#btn_salva_record_diario_inf').text('Modifica');
                $('.modal-title').text('Modifica Turno');
                $('#new_content_diario_inf').val('');
        },
        error: function (rese) {
            alert(rese);
        }
    });
   })


