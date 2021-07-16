<?php
if (!isset($_SESSION)) {
    session_start();
}

$nome_progetto = 'SmartiPHR';

require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/db_config_server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/utils.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/controller/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/view/utils_view.php';



if (isset($_SESSION['application'])) {
    if ($_SESSION['application'] == $nome_progetto) {
        if (!isset($_SESSION['id_dip'])) {
            header('location: /' . $nome_progetto . '/home');
        }
    }
}
if (!checkPermission()) {
    header("location: /" . $nome_progetto);
}
?>

<!DOCTYPE html>
<head>
 
    <!-- Metadata -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <?php
        echo getPageTitle();
        echo getFavicon();
        ?>	
 
    <link rel="stylesheet" href="/<?php echo $nome_progetto ?>/css/site.css" >
    <!-- CSS Files -->
    <link href="/<?php echo $nome_progetto ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="/<?php echo $nome_progetto ?>/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/<?php echo $nome_progetto ?>/css/animate.css" rel="stylesheet">
    <link href="/<?php echo $nome_progetto ?>/css/style.css" rel="stylesheet">
       <link href="/<?php echo $nome_progetto ?>/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
       <link href="/<?php echo $nome_progetto ?>/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
       <link rel="stylesheet" href="/<?php echo $nome_progetto ?>/css/site.css" >
 
</head>
    <body>
    <div id="wrapper">
         <?php echo getSideBar(); ?>
    
        <div id="page-wrapper" class="gray-bg">
            
        <?php echo getnewNavBar(); ?>
      <div class="wrapper wrapper-content">
          
  
          
        <div id="modal_ingresso" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document" style="max-width: none;width: 90%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titleingresso"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        
       <div id="modal_inserisci_record_intervento" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuova Intervento</h5>
                         <h3 id="id_rec_interv" style="display:none"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group" id="input_data_interv">
                                <label class="font-normal">Data:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_nome">Diagnosi</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_diagnosi"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="input_nome">Obiettivi</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_obiettivi"></textarea>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="input_nome">Intervento</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_interv"></textarea>
                        </div>
                        
                        
                        <div class="form-group" id="div_new_content">
                            <label for="input_nome">Valutazione/Firma</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_valutazione"></textarea>
                        </div>
                        
                        
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--button type="button" class="btn btn-primary">Save changes</button-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        <button class="btn btn-primary" id="btn_salva_record_interv" data-sfx="">Registra</button>
                    </div>
                </div>
            </div>
        </div>
                
                
                
           <div id="modal_inserisci_record_diario_inf" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuovo</h5>
                        <h3 id="id_rec_diario_inf" style="display:none"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group" id="input_data_diario_inf">
                                <label class="font-normal">Data:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_nome">Turno</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_turno"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="input_nome">Contenuto</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_diario_inf"></textarea>
                        </div>
                        
                         <div class="form-group" id="div_new_content_diario_inf" style="display: none">
                            <label for="input_nome">Nuovo Contenuto</label>
                            <textarea class="form-control" rows="5" cols='150' id="new_content_diario_inf"></textarea>
                        </div>
                        <div class="row">
                            <div class="col col-6">
                               <label for="input_nome">Firma IP</label>
                            <textarea class="form-control" rows="5" cols='150' id="firma"></textarea>
                            </div>
                            
                        </div>
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--button type="button" class="btn btn-primary">Save changes</button-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        <button class="btn btn-primary" id="btn_salva_record_diario_inf">Registra</button>
                    </div>
                </div>
            </div>
        </div>
                        
                        
                        
                
                <label id="id_paziente" style="display: none"></label>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" onclick="openTab(event, 'checklist')">Check List</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" onclick="openTab(event, 'trattamento')">Trattamento igienico</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" onclick="openTab(event, 'stanze')">Stanze</a>
                    </li>

                  </ul>
                
                
                  <!-- CHECKLIST -->
                  <div id="checklist" class="tabcontent">


                        <div class="row">
                            
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-checklist">

                                         <thead>
                                         <tr>
                                             <th>Descrizione</th>
                                             <th>Quantità</th>                                                        
                                             <th>Mancante</th>
                                         </tr>
                                         </thead>
                                    </table>
                                </div>	

                        </div>


                 </div>
                  
                  
                  <!-- TRATTAMENTO -->
                  <div id="trattamento" class="tabcontent">

                      
                      <label  style="word-wrap:break-word">
                            <input id="cbeffettuato"  type="checkbox" /> Effettuato
                        </label>

                   </div>

                   

                   <!-- STANZE -->
                  <div id="stanze" class="tabcontent">


                        <div class="row">
                            
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-lista_stanze">

                                         <thead>
                                         <tr>
                                             <th>Numero</th>
                                             <th>Descrizione</th>                                                        
                                             <th>Piano</th>
                                             <th>Assegna</th>
                                         </tr>
                                         </thead>
                                    </table>
                                </div>	

                        </div>


                 </div>
                  
                        
                        
                        
                       </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-green" id="btn_save_tab_ingresso"> SALVA</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
  
        
          
          
          
         <div id="modal_attivitaquotidiane" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document" style="max-width: none;width: 90%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titleattivitaquotidiane"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        
       <div id="modal_inserisci_record_intervento" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuova Intervento</h5>
                         <h3 id="id_rec_interv" style="display:none"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group" id="input_data_interv">
                                <label class="font-normal">Data:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_nome">Diagnosi</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_diagnosi"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="input_nome">Obiettivi</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_obiettivi"></textarea>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="input_nome">Intervento</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_interv"></textarea>
                        </div>
                        
                        
                        <div class="form-group" id="div_new_content">
                            <label for="input_nome">Valutazione/Firma</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_valutazione"></textarea>
                        </div>
                        
                        
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--button type="button" class="btn btn-primary">Save changes</button-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        <button class="btn btn-primary" id="btn_salva_record_interv" data-sfx="">Registra</button>
                    </div>
                </div>
            </div>
        </div>
                
                
                
           <div id="modal_inserisci_record_diario_inf" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuovo</h5>
                        <h3 id="id_rec_diario_inf" style="display:none"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group" id="input_data_diario_inf">
                                <label class="font-normal">Data:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_nome">Turno</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_turno"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="input_nome">Contenuto</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_diario_inf"></textarea>
                        </div>
                        
                         <div class="form-group" id="div_new_content_diario_inf" style="display: none">
                            <label for="input_nome">Nuovo Contenuto</label>
                            <textarea class="form-control" rows="5" cols='150' id="new_content_diario_inf"></textarea>
                        </div>
                        <div class="row">
                            <div class="col col-6">
                               <label for="input_nome">Firma IP</label>
                            <textarea class="form-control" rows="5" cols='150' id="firma"></textarea>
                            </div>
                            
                        </div>
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--button type="button" class="btn btn-primary">Save changes</button-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        <button class="btn btn-primary" id="btn_salva_record_diario_inf">Registra</button>
                    </div>
                </div>
            </div>
        </div>
                        
                        
                        
                
                <label id="id_paziente_attivitaquotidiane" style="display: none"></label>

                  <!-- ATTIVITA -->
                  <div id="attivitaquotidiane" class="tabcontent">


                        <div class="row">
                            
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-attivitaquotidiane">

                                         <thead>
                                         <tr>
                                             <th>Descrizione</th>
                                             <th>Eseguita</th>                                                        
                                             <th>Data</th>
                                         </tr>
                                         </thead>
                                    </table>
                                </div>	

                        </div>


                 </div>
                  

                       </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-green" id="btn_save_tab_ingresso"> SALVA</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
  
       
          
           <div id="modal_registro" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document" style="max-width: none;width: 90%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title_registro"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                <label id="id_paziente_registro" style="display: none"></label>

                  <!-- ATTIVITA -->
                  <div id="registro">


                            
                        <label  style="word-wrap:break-word">
                            <input id="cbletto"  type="checkbox" /> G.Letto
                        </label>
                         <br>
                        <label  style="word-wrap:break-word">
                            <input id="cbdiuresi"  type="checkbox" /> Diuresi
                        </label>
                         <br>
                         <label  style="word-wrap:break-word">
                            <input id="cbevacuazione"  type="checkbox" /> Evacuazione
                        </label>
                         <br>
                        <label  style="word-wrap:break-word">
                            <input id="cbigiene"  type="checkbox"  /> Igiene
                        </label>
                         
                         <br>
                         <label  style="word-wrap:break-word">
                            <input id="cbdoccia"  type="checkbox" /> Doccia
                        </label>
                         <br>
                        <label  style="word-wrap:break-word">
                            <input id="cbbarba"  type="checkbox" /> Barba
                        </label>
                         <br>
                         <label  style="word-wrap:break-word">
                            <input id="cbtagliocapelli"  type="checkbox" /> Taglio capelli
                        </label>
                         <br>
                        <label  style="word-wrap:break-word">
                            <input id="cbtagliounghie"  type="checkbox"  /> Taglio unghie
                        </label>
                        <br>
                         <label  style="word-wrap:break-word">
                            <input id="cblenzuola"  type="checkbox" /> C.Lenzuola
                        </label>
                        <br>
                        
                        <h3>Note:</h3>
                        <br>
                        <textarea id="txtnote"></textarea>
                       


                 </div>
                  

                       </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-green" id="btn_save_tab_ingresso"> SALVA</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
          
          
          
        <div class="container">
           <div class="row">
                <div class="col-sm-6">
                    <h3><b>AREA O.S.S</b></h3>
                </div>
               
            </div>
            

            
            <div class="table-responsive">
                   <table class="table table-striped table-bordered table-hover dataTables-lista_anagrafiche">
              
                        <thead>
                        <tr>
                            <th>Cognome</th>
                            <th>Nome</th>                                   
                            <th>Data di nascita</th>                         
                            <th></th>
                            
                        </tr>
                        </thead>
              </table>
               </div>	
            


        </div>	
      </div>
   </div>
            
</div>
   <!-- Mainly scripts -->
    <script src="/<?php echo $nome_progetto ?>/js/jquery-3.1.1.min.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/popper.min.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/bootstrap.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="js/plugins/dataTables/datatables.min.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
    <!-- Peity -->
    <script src="/<?php echo $nome_progetto ?>/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/<?php echo $nome_progetto ?>/js/inspinia.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="/<?php echo $nome_progetto ?>/js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/common.js"></script>
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/cartella.js"></script>
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/oss.js"></script>
    
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    
    

</body>

<script>
                
 $(document).ready(function(){
                       
        aggiornaListaAnagraficheAreaOss();
        $('#data_trasferimento .input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                });
                
                
$('#dataingresso .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });



$('#data_dimissione .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });


$('#data_decesso .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });


$('#input_data_ingresso .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });


$('#input_data_richiesta .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        }); 

$('#input_data_terapia .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });      


 $('#input_data_esecuzione .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });    

 });
 

        </script>



</html>