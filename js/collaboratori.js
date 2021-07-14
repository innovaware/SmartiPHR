/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var nome_progetto = 'SmartiPHR';

$('body').on('click', '#btn_view_ges_collaboratori', function () {
    window.location.href = '/' + nome_progetto + '/ges_collaboratori/';
 
})


$('#btn_insert_collaboratore').click(function () {
    $('#div_logger').html('Caricamento in corso...');
    $.ajax({
        url: "/" + nome_progetto + "/controller/Collaboratore.php",
        type: "POST",
        data: {operation: "insertCollaboratore",
            nome: $("#input_nome").val(),
            cognome: $("#input_cognome").val(),
            data_nasc: $("#input_data_nasc").val(),
            indirizzo: $("#input_indirizzo").val(),
            cap: $("#input_cap").val(),
            localita: $("#input_localita").val(),
            provincia: $("#input_provincia").val(),
            sesso: $("#input_sesso").val(),
        },
        success: function (res) {
            
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100) {
                $('#div_logger').html('Inserimento effettuato correttamente.');
                $('#div_logger').fadeOut("slow", function () {
                    $('#div_logger').html('');
                });
                getListaCollaboratori();
                $("#input_nome").val('');
                $("#input_cognome").val('');
                $("#input_data_nasc").val('');
                $("#input_indirizzo").val('');
                $("#input_cap").val('');
                $("#input_localita").val('');
                $("#input_provincia").val('');
                $("#input_sesso").val('');



            } else {
                $('#div_logger').html(res);
                //$('#div_logger').html('Errore di inserimento. Riprovare');
            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
})


function getListaCollaboratori() {
    $.ajax({
        url: "/" + nome_progetto + "/controller/Collaboratore.php",
        type: "POST",
        data: {operation: "getListaCollaboratori"
        },
        success: function (res) {
            console.log(JSON.stringify(res));
            $('#div_lista_collaboratori').html(res);
        },
        error: function (rese) {
            //alert(rese);
        }
    });
}


function insertAllegatoSicurezza(id_mast) {
    //alert(id_mast+','+ $("#input_nome_file").val());
    $.ajax({
        url: "/" + nome_progetto + "/controller/Collaboratore.php",
        type: "POST",
        data: {operation: "insertAllegatoSicurezza",
            id_mast:id_mast,
            documento:$("#input_nome_file").val()
        },
        success: function (res) {
            console.log(res);
             $('#modal_inserisci_allegato').modal('hide');
             loadTable();
        },
        error: function (rese) {
            //alert(rese);
        }
    });
}


$('body').on('click', '.btn_ins_dettaglio', function () {
  var context= $(this).text(); 
  var descr="";
  $('#input_nome_file').val('');
  if(context=='Medico del lavoro'){
       $('#input_descr_allegato').append("<option value=\"Modello di nomina MEDICO\">Modello di nomina MEDICO</option>"); 
      descr='Modello di nomina MEDICO';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
   if(context=='RLS'){
       $('#input_descr_allegato').append("<option value=\"Modello di nomina RLS\">Modello di nomina RLS</option>"); 
       $('#input_descr_allegato').append("<option value=\"Ultimo corso frequentato\">Ultimo corso frequentato</option>"); 
      descr='Modello di nomina RLS';
      //$('#input_descr_allegato').attr('readonly',true);
  }
  
   if(context=='RSPP'){
       $('#input_descr_allegato').append("<option value=\"Modello di nomina RSPP\">Modello di nomina RSPP</option>"); 
        $('#input_descr_allegato').append("<option value=\"Ultima Formazione\">Ultima Formazione</option>"); 
         $('#input_descr_allegato').append("<option value=\"Verbale di riunione RLS e RSPP\">Verbale di riunione RLS e RSPP</option>"); 
         
      descr='Modello di nomina RSPP';
      //$('#input_descr_allegato').attr('readonly',true);
  }
  
  if(context=='Procedura Sanitaria in caso di ferite'){
       $('#input_descr_allegato').append("<option value=\"Modello da allegare\">Modello da allegare</option>"); 
      descr='Modello da allegare';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
  
  if(context=='Apparecchiature ed impianti'){
       $('#input_descr_allegato').append("<option value=\"Allegare documenti\">Allegare documenti</option>"); 
      descr='Allegare documenti';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
  
  if(context=='Controllo sicurezza antincendio'){
       $('#input_descr_allegato').append("<option value=\"Allegare documenti\">Allegare documenti</option>"); 
      descr='Allegare documenti';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
  if(context=='Derattizzazione'){
       $('#input_descr_allegato').append("<option value=\"Modello da allegare\">Modello da allegare</option>"); 
      descr='Modello da allegare';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
  
  if(context=='Verifica serbatorio GPL'){
       $('#input_descr_allegato').append("<option value=\"Allegare documenti\">Allegare documenti</option>"); 
      descr='Allegare documenti';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
  
  if(context=='Verifica ascensori'){
       $('#input_descr_allegato').append("<option value=\"Allegare documenti\">Allegare documenti</option>"); 
      descr='Allegare documenti';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
  
    if(context=='Prevenzione dei rischi'){
       $('#input_descr_allegato').append("<option value=\"Modello da allegare\">Modello da allegare</option>"); 
      descr='Modello da allegare';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
  
  if(context=='Controllo Legionellosi'){
       $('#input_descr_allegato').append("<option value=\"Allegare documenti\">Allegare documenti</option>"); 
      descr='Allegare documenti';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
  
  if(context=='Gestione emergenze'){
       $('#input_descr_allegato').append("<option value=\"Allegare documenti\">Allegare documenti</option>"); 
      descr='Allegare documenti';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
   if(context=='Certificazioni'){
       $('#input_descr_allegato').append("<option value=\"Certificazioni\">Certificazioni</option>"); 
      descr='Certificazioni';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
  
    if(context=='Autocertificazioni'){
       $('#input_descr_allegato').append("<option value=\"Autocertificazioni\">Autocertificazioni</option>"); 
      descr='Autocertificazioni';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
  
  if(context=='Smaltimento rifiuti'){
       $('#input_descr_allegato').append("<option value=\"Smaltimento rifiuti\">Smaltimento rifiuti</option>"); 
      descr='Smaltimento rifiuti';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
  
  if(context=='Servizi Lavanderia Esterna Interna (Contratto)'){
       $('#input_descr_allegato').append("<option value=\"Servizi Lavanderia Esterna Interna (Contratto)\">Servizi Lavanderia Esterna Interna (Contratto)</option>"); 
      descr='Servizi Lavanderia Esterna Interna (Contratto)';
      $('#input_descr_allegato').attr('readonly',true);
  }
  
   $.ajax({
        url: "/" + nome_progetto + "/controller/Collaboratore.php",
        type: "POST",
        data: {operation: "insertAllegatoInMaster",
            descrizione:context,
            rif_area:descr
        },
        success: function (res) {
            console.log(JSON.parse(res).id);
            $('#btn_carica_allegato_sicurezza').attr('id-doc',JSON.parse(res).id);
        },
        error: function (rese) {
            //alert(rese);
        }
    });

     $('#input_descr_allegato').val(descr);
     
     $('#modal_inserisci_allegato').modal('show');

})


$("#btn_carica_allegato_sicurezza").click(function(){
    id_mast = $(this).attr('id-doc');
    insertAllegatoSicurezza(id_mast)
   
})


function loadTable(){
    
    //var array=['medico-lavoro','rls','rspp','procedura-sanitaria','apparecchiature','sicurezza-antincendio','deratizzazione','verifica-serbatoio','verifica-ascensori','prev-rischi','legionellosi','ges-emergenze'];
    var array=['medico-lavoro','rls','rspp','procedura-sanitaria',
                'apparecchiature','controllo-sicurezza','derattizzazione',
                'verifica-serbatotio','verifica-ascensori','prevenzione-rischi',
                'legionellosi','ges-emergenze','certificazioni','autocertificazioni','smaltimento','lavanderia']; 
    
     $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Medico del lavoro'
            },
            success: function (res) {
                console.log('#div-' + array[0]);
                console.log(res);
                
                $('#div-' + array[0]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
         $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'RLS'
            },
            success: function (res) {
                console.log('#div-' + array[1]);
                console.log(res);
                
                $('#div-' + array[1]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
        $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'RSPP'
            },
            success: function (res) {
                console.log('#div-' + array[2]);
                console.log(res);
                
                $('#div-' + array[2]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
         $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Procedura Sanitaria in caso di ferite'
            },
            success: function (res) {
                console.log('#div-' + array[3]);
                console.log(res);
                
                $('#div-' + array[3]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
        
        
         $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Apparecchiature ed impianti'
            },
            success: function (res) {
                console.log('#div-' + array[4]);
                console.log(res);
                
                $('#div-' + array[4]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
         $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Controllo sicurezza antincendio'
            },
            success: function (res) {
                console.log('#div-' + array[5]);
                console.log(res);
                
                $('#div-' + array[5]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
        
        $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Derattizzazione'
            },
            success: function (res) {
                console.log('#div-' + array[6]);
                console.log(res);
                
                $('#div-' + array[6]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
         $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Verifica serbatorio GPL'
            },
            success: function (res) {
                console.log('#div-' + array[7]);
                console.log(res);
                
                $('#div-' + array[7]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
        
        $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Verifica ascensori'
            },
            success: function (res) {
                console.log('#div-' + array[8]);
                console.log(res);
                
                $('#div-' + array[8]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
         $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Prevenzione dei rischi'
            },
            success: function (res) {
                console.log('#div-' + array[9]);
                console.log(res);
                
                $('#div-' + array[9]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
       
          $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Controllo Legionellosi'
            },
            success: function (res) {
                console.log('#div-' + array[10]);
                console.log(res);
                
                $('#div-' + array[10]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
         $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Gestione emergenze'
            },
            success: function (res) {
                console.log('#div-' + array[11]);
                console.log(res);
                
                $('#div-' + array[11]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
       
        $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Certificazioni'
            },
            success: function (res) {
                console.log('#div-' + array[12]);
                console.log(res);
                
                $('#div-' + array[12]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
         $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Autocertificazioni'
            },
            success: function (res) {
                console.log('#div-' + array[13]);
                console.log(res);
                
                $('#div-' + array[13]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
         $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Smaltimento rifiuti'
            },
            success: function (res) {
                console.log('#div-' + array[14]);
                console.log(res);
                
                $('#div-' + array[14]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
         $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Servizi Lavanderia Esterna Interna (Contratto)'
            },
            success: function (res) {
                console.log('#div-' + array[15]);
                console.log(res);
                
                $('#div-' + array[15]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
        
    /*var i;
     for(i = 0;i <array.length; i++){
         var nome="";

         var dett="";
         switch(i) {
            case 0:
              dett="Medico del lavoro";
              nome=array[0];
              break;
            case 1:
              dett="RLS";
               nome=array[1];
              break;
            default:
              // code block
          }
         
        $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:dett
            },
            success: function (res) {
                console.log('#div-' + array[i]);
                console.log(res);
                
                $('#div-' + array[i]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
    }*/
}


function loadTableDettaglio(){
    
    //var array=['medico-lavoro','rls','rspp','procedura-sanitaria','apparecchiature','sicurezza-antincendio','deratizzazione','verifica-serbatoio','verifica-ascensori','prev-rischi','legionellosi','ges-emergenze'];
    var array=['esami-lab','div-certificato-idoneita','div-giudizio-idoneita','div-libro-infortuni']; 
    
     $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Esami di laboratorio'
            },
            success: function (res) {
                console.log('#div-' + array[0]);
                console.log(res);
                
                $('#div-' + array[0]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
         $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Certificato Idoneità'
            },
            success: function (res) {
                console.log('#div-' + array[1]);
                console.log(res);
                
                $('#div-' + array[1]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Giudizio di idoneità alla mansione specifica'
            },
            success: function (res) {
                console.log('#div-' + array[2]);
                console.log(res);
                
                $('#div-' + array[2]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });
        
        $.ajax({
            url: "/" + nome_progetto + "/controller/Collaboratore.php",
            type: "POST",
            data: {operation: "retrieveListaAllegatiSicurezzaByDett",
                dett:'Libro Infortuni'
            },
            success: function (res) {
                console.log('#div-' + array[3]);
                console.log(res);
                
                $('#div-' + array[3]).html(res);
            },
            error: function (rese) {
                //alert(rese);
            }
        });


}


$('body').on('click', '.btn-dettaglio-collab', function () {
  id_collab = $(this).attr('id_collab');
   window.location.href = '/' + nome_progetto + '/preview_collaboratore';
})

$('body').on('click', '.btn_ins_allegato_dettaglio', function () {
  var descr= $(this).text(); 
  //$('#input_descr_allegato').val(descr);
   //$('#input_descr_allegato').attr('readonly',true);
 
   $.ajax({
        url: "/" + nome_progetto + "/controller/Collaboratore.php",
        type: "POST",
        data: {operation: "insertAllegatoInMaster",
            descrizione:descr,
            rif_area:descr
        },
        success: function (res) {
            console.log(JSON.parse(res).id);
            $('#btn_carica_allegato_sicurezza').attr('id-doc',JSON.parse(res).id);
        },
        error: function (rese) {
            //alert(rese);
        }
    });

     $('#input_descr_allegato').val(descr);
     
     $('#modal_inserisci_allegato').modal('show');

})