
$('body').on('click', '.cal_event', function () {
    $(this).children('.event_subdescription').toggle();
})

$('body').on('click', '.label_day', function () {
    $('#input_data_evento').val($(this).data('data_evento') + 'T00:00');
})

$('body').on('click', '.label_day_sett', function () {
    $('#input_data_evento').val($(this).data('data_evento') + 'T00:00');
})

$('body').on('click', '.btn_sel_mese', function () {
    var anno = $(this).data('anno');
    var incdec = $(this).data('incdec');
    var mese = $(this).data('mese');
    var nuovoMese = parseInt(mese) + parseInt(incdec);
    if (nuovoMese < 10) {
        if (nuovoMese > 0)
            nuovoMese = '0' + nuovoMese;
        if (nuovoMese == 0) {
            nuovoMese = 12;
            anno = parseInt(anno) - 1;
        }
    }
    if (nuovoMese == 13) {
        nuovoMese = '01';
        anno = parseInt(anno) + 1;
    }
    aggiornaVistaMese(anno + '-' + (nuovoMese) + '-01');
})

$('body').on('click', '.btn_sel_sett', function () {
    var data_arrivo = $(this).data('data_arrivo');
    aggiornaVistaSettimana(data_arrivo);
})

$('#btn_salva_evento').click(function () {
    tipo_vista = $(this).attr('tipo_vista');
    $.ajax({
        url: '/SmartiPHR/ext/calendar/Calendar.php',
        type: 'POST',
        data: {operation: 'inserisciEvento', data_evento: $('#input_data_evento').val(), descrizione: $('#input_descrizione').val()},
        success: function (res) {
            alert(res);
            if (tipo_vista == 'mese')
                aggiornaVistaMese(getInizioMeseCorrente());
            if (tipo_vista == 'settimana')
                aggiornaVistaSettimana(getInizioMeseCorrente());
            

        },
        error: function (res) {

        }

    });
})

$('body').on('click', '#btn_settimana', function () {
    $('#btn_salva_evento').attr('tipo_vista', 'settimana');
    aggiornaVistaSettimana($(this).data('inizio_mese'));
})

$('body').on('click', '#btn_mese', function () {
    $('#btn_salva_evento').attr('tipo_vista', 'mese');
    aggiornaVistaMese($(this).data('inizio_mese'));
})


/// personalizzazioni
function salvaEvento(id_dett, rif) {
    $.ajax({
        url: '/SmartiPHR/ext/calendar/Calendar.php',
        type: 'POST',
        data: {operation: 'inserisciEvento', 
                data_evento: $('#input_data_evento').val(), 
                descrizione: $('#input_descrizione').val(),
                id_dett: id_dett,
                rif: sfx
        }, 
        success: function (res) {
            //alert(res);
        },
        error: function (res) {

        }

    });
}


function aggiornaVistaMese(inizioMese) {
    $.ajax({
        url: '/SmartiPHR/ext/calendar/Calendar.php',
        type: 'POST',
        data: {operation: 'retrieveVistaMese', inizio_mese: inizioMese},
        success: function (res) {
            $('#cal_container').html(res);
        },
        error: function (res) {

        }

    });
}


function aggiornaVistaSettimana(data) {

    $.ajax({
        url: '/SmartiPHR/ext/calendar/Calendar.php',
        type: 'POST',
        data: {operation: 'retrieveVistaSettimana', inizio_mese: data},
        success: function (res) {

            $('#cal_container').html(res);
        },
        error: function (res) {

        }

    });
}


function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var tipo_cont;
    if ($(ev.target).hasClass("droppable")) {           //Only allow drop inside the 2 divs
        ev.target.appendChild(document.getElementById(data));
        var nuova_data = $('#' + ev.target.id).attr('data_evento');
        var nuova_ora = $('#' + ev.target.id).attr('ora_evento');
        tipo_cont = $('#' + ev.target.id).attr('tipo_cont');
    }
    if ($(ev.target).hasClass("draggable")) {           //put in parent when dropped on draggable
        /*
         $(ev.target).parent()[0].appendChild(document.getElementById(data));
         var nuova_data = $('#'+$(ev.target).parent()[0].id).attr('data_evento');
         var nuova_ora  = $('#'+$(ev.target).parent()[0].id).attr('ora_evento'); 
         */
    }
    $.ajax({

        url: '/SmartiPHR/ext/calendar/Calendar.php',
        type: 'POST',
        data: {operation: 'aggiornaEvento', id_evento: data, nuova_data: nuova_data, nuova_ora: nuova_ora},
        success: function (res) {
            var data_inizio_mese = nuova_data.substring(0, 7) + '-01';

            if (tipo_cont == "mese")
                aggiornaVistaMese(data_inizio_mese);
            if (tipo_cont == "settimana")
                aggiornaVistaSettimana(nuova_data);
        },
        error: function (res) {

        }

    });

}


function getInizioMeseCorrente() {
    var today = new Date();
    var dd = '01';
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    return today = yyyy + '-' + mm + '-' + dd;
}


/*
 function handleDragEnter(e) {
 this.classList.add('over');
 }
 
 function handleDragLeave(e) {
 this.classList.remove('over');  
 }
 
 function handleDragEnd(e) {
 [].forEach.call(cols, function (col) {
 col.classList.remove('over');
 });
 }
 
 var cols = document.querySelectorAll('.droppable');
 
 [].forEach.call(cols, function(col) {
 //col.addEventListener('dragstart', handleDragStart, false);
 col.addEventListener('dragenter', handleDragEnter, false);
 //col.addEventListener('dragover', handleDragOver, false);
 col.addEventListener('dragleave', handleDragLeave, false);
 col.addEventListener('dragend', handleDragEnd, false);
 
 });
 
 */
