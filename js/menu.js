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
               data: {operation: "getListaAnagraficheMenu"},
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
        
 
}/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


