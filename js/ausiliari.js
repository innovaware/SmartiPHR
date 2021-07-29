var nome_progetto = 'SmartiPHR';

function aggiornaListaStanze() {

    $('.dataTables-stanze').dataTable({
           "bProcessing": true,
            "responsive": true,
            'ajax': {
               url: "/" + nome_progetto + "/controller/Stanza.php",
               type: "POST",
               data: {operation: "getListaAreaAusiliari"},
           },
           "aoColumns": [
                 { mData: 'numero' },
                 { mData: 'descrizione' },
                 { mData: 'piano' },
                  { mData: 'actions' }
               ],
                   "columnDefs" : [
                    { targets: 0, sortable: false},
                ],
                              dom: '<"html5buttons"B>lTfgitp'

                     }); 
        
 
}


