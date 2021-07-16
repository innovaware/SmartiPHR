$('body').on('click', '.btn_view_ingresso', function () {
    $('#modal_ingresso').modal('toggle');
    $('#id_paziente').html($(this).data('id_anag'));
     $('#titleingresso').text('Ingresso ospite: ' + $(this).data('paziente'));
        //getListaRowsChecklist();
        
        //SgetListaRowsStanze();
        
});


$('body').on('click', '.btn_view_attivita', function () {
    $('#modal_attivitaquotidiane').modal('toggle');
    $('#id_paziente_attivitaquotidiane').html($(this).data('id_anag'));
     $('#titleattivitaquotidiane').text('Attività quotidiane ospite: ' + $(this).data('paziente'));
        //getListaRowsChecklist();
        
        //SgetListaRowsStanze();
        
});



$('body').on('click', '.btn_view_consegne', function () {
    $('#modal_registro').modal('toggle');
    $('#id_paziente_registro').html($(this).data('id_anag'));
     $('#title_registro').text('Registro consegne ospite: ' + $(this).data('paziente'));
        //getListaRowsChecklist();
        
        //SgetListaRowsStanze();
        
});

function getListaRowsChecklist() {
    var id_paziente= $('#id_paziente').text();
    $('.dataTables-checklist').dataTable({
           "bProcessing": true,
            "responsive": true,
            'ajax': {
               url: "/" + nome_progetto + "/controller/OSS.php",
               type: "POST",
               data: {operation: "getListaRowsChecklist"},
           },
           "aoColumns": [
                 { mData: 'descrizione' },
                 { mData: 'quantita' },
                 { mData: 'nome' }
               ]

         }); 

}



function getListaRowsStanze() {
    var id_paziente= $('#id_paziente').text();
    $('.dataTables-lista_stanze').dataTable({
           "bProcessing": true,
            "responsive": true,
            'ajax': {
               url: "/" + nome_progetto + "/controller/OSS.php",
               type: "POST",
               data: {operation: "getListaRowsStanze"},
           },
           "aoColumns": [
                { mData: 'numero' },
                 { mData: 'descrizione' },
                 { mData: 'piano' },
                 { mData: 'actions' }
               ]

         }); 

}



function getListaRowsAttivitaQuotidiane() {
    var id_paziente= $('#id_paziente_attivitaquotidiane').text();
    $('.dataTables-attivitaquotidiane').dataTable({
           "bProcessing": true,
            "responsive": true,
            'ajax': {
               url: "/" + nome_progetto + "/controller/OSS.php",
               type: "POST",
               data: {operation: "getListaRowsAttivitaQuotidiane"},
           },
           "aoColumns": [
                 { mData: 'descrizione' },
                 { mData: 'eseguita' },
                 { mData: 'data' }
               ]

         }); 

}