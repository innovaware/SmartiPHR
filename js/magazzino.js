/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var nome_progetto = 'SmartiPHR';
const magazzinoArmadi = 'arm';
const magazPresidiInfermieri = 'presinf';
const magazPresidiOss = 'presoss';

//cambia il nome della select in base al magazzino
function cambiaNomeSelect() {
    if($('#tipo_mag').attr('tipo_mag') === magazzinoArmadi){
        $('#testo_select_magaz').html('Assegnatario');
    }
    else {
        $('#testo_select_magaz').html('Presidi');
    }
}

cambiaNomeSelect();


function popolaSelectMagazzino() {

    $.ajax({
        url: "/" + nome_progetto + "/controller/Magazzino.php",
        type: "POST",
        data: {operation: "getListaAssegnatari"},
        success: function (res) {
            console.log(res);
           $('#select_magaz').append(res)
        },
        error: function (rese) {
            alert(rese);
        }
    });
}


function aggiornaListaItemMagazzino() {

    $.ajax({
        url: "/" + nome_progetto + "/controller/Magazzino.php",
        type: "POST",
        data: {operation: "getMagazzino", tipo_mag: $('#tipo_mag').attr('tipo_mag')},
        success: function (res) {
            //alert(res);
            $('#div_lista_item_magazzino').html(res);
            popolaSelectMagazzino();
        },
        error: function (rese) {
            alert(rese);
        }
    });
}

function getListaItemMagazzinoSelect() {

    $.ajax({
        url: "/" + nome_progetto + "/controller/Magazzino.php",
        type: "POST",
        data: {operation: "getListaItemMagazzinoSelect", 
            tipo_mag: $('#tipo_mag').attr('tipo_mag'),
            id_assegn:$('#select_magaz').val()
        },
        success: function (res) {
            //alert(res);
            $('#div_lista_item_magazzino').html(res);
            //popolaSelectMagazzino();
        },
        error: function (rese) {
            alert(rese);
        }
    });
}

aggiornaListaItemMagazzino();

//handler che scatta al change della select magazzino
$(document).on('change','#select_magaz', function(){
    
    console.log($(this).find('option:selected').text());
    var selezionato = $(this).find('option:selected').val();
    
    //alert(selezionato);

    //se non c'è l'attributo value allora è stata selezionata la voce 'Seleziona'
    if(!$('#select_magaz option:selected').attr('value')){
        aggiornaListaItemMagazzino();
        return;
    }

    $.ajax({
        url: "/" + nome_progetto + "/controller/Magazzino.php",
        type: "POST",
        data: {operation: "filtroSelectMagazzino", tipo_mag: $('#tipo_mag').attr('tipo_mag'), selezionato: selezionato},
        success: function (res) {
           // alert(res);
            $('#div_lista_item_magazzino').html(res);
        },
        error: function (rese) {
            alert(rese);
        }
    });
    
});


function inserisciCarScaMag(tipo_mag, item, qta, data_mov, id_assegnatario, id_mag) {
    $.ajax({
        url: "/" + nome_progetto + "/controller/Magazzino.php",
        type: "POST",
        data: {operation: "insertMov",
            tipo_mag: tipo_mag,
            item: item,
            qta: qta,
            data_mov: data_mov,
            id_assegnatario: id_assegnatario,
            id_mag: id_mag
        },
        success: function (res) {
            alert(res);
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Inserimento effettuato correttamente.');
                $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger').html('');
                });
                aggiornaListaItemMagazzino();
                /*$("#input_item_mov").val('');
                 $("#input_qta_mov").val('');
                 $("#input_search").val('');
                 */

            } else {
                $('#div_logger').html(res);

            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
}


$('#btn_carsca_item').click(function () {
    
    tipo_mag = $('#tipo_mag').attr('tipo_mag');
    item = $("#input_item_mov").val();
    qta = $("#input_qta_mov").val();
    data_mov = $("#input_data_mov").val();
    id_assegnatario = $("#input_search").attr('valselezionato');
    id_mag = $('#id_mag').attr('id_mag');
    $('#div_logger').html('Caricamento in corso...');
    
    if($("#modal_title").html()=='Carico')
        inserisciCarScaMag(tipo_mag, item, qta, data_mov, id_assegnatario, '');
    else
        inserisciCarScaMag(tipo_mag, item, -qta, data_mov, '', id_mag);
})



$('#btn_carica_item_modal').click( function () {
    
    $("#modal_title").html('Carico');
    $("#id_mag").attr('id_mag','');
    $("#input_search").removeAttr("disabled");
    $("#input_search").val('');
    $("#input_item_mov").removeAttr("disabled");
    $("#input_item_mov").val('');
})

$('body').on('click', '.btn_scarica_item_modal', function () {
    
    $("#modal_title").html('Scarico');
    
    $("#input_search").val($(this).attr('ospite'));
    $("#input_search").attr("disabled", "disabled");
    
    $("#input_item_mov").val($(this).attr('item'));
    $("#input_item_mov").attr("disabled", "disabled");
    
    $("#id_mag").attr('id_mag', $(this).attr('id_mag'));
})


$('body').on('click', '.btn_flag_libero_1', function () {
    valore_attuale = $(this).attr('valselezionato');
    tipo_mag = $('#tipo_mag').attr('tipo_mag');
    id_mag = $(this).attr('id_mag');
    $.ajax({
        url: "/" + nome_progetto + "/controller/Magazzino.php",
        type: "POST",
        data: {operation: "switchValue",
            tipo_mag: tipo_mag,
            id_mag: id_mag,
            field: 'flag_libero_1',
            valore_attuale: valore_attuale
        },
        success: function (res) {
            getListaItemMagazzinoSelect();
        },
        error: function (rese) {
            alert(rese);
        }
    });
})
