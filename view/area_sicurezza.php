<?php
if (!isset($_SESSION)) {
    session_start();
}

$nome_progetto = 'SmartiPHR';

require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/db_config_server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/utils.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/controller/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/controller/Cartella.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/view/utils_view.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/bean/AnagraficaBean.php';



if (isset($_SESSION['application'])) {
    if ($_SESSION['application'] == $nome_progetto) {
        if (!isset($_SESSION['id_dip'])) {
            header('location: /' . $nome_progetto . '/home');
        }
    }
}
/*
  if (!checkPermission()) {
  header("location: /" . $nome_progetto);
  }
 * 
 */
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
 
</head>


    <body>
    <div id="wrapper">
         <?php echo getSideBar(); ?>
    
        <div id="page-wrapper" class="gray-bg">
            
        <?php echo getnewNavBar(); ?>
      <div class="wrapper wrapper-content">
         <div id="modal_inserisci_diario_clinico" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Diario clinico</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4>Cartella #<span id="id_cartella"><?php echo $_GET['id_cartella'] ?></span></h4>
                        <div id="div_dati_dettaglio_gen">
                            <div class="form-group">
                                <label for="input_data_diario">Data</label>
                                <input type="datetime-local" class="form-control" id="input_data_diario" value="<?php echo date('Y-m-d') . 'T' . date('H:i'); ?>" >
                            </div>
                            <div class="form-group">
                                <label for="input_descr_diario">Descrizione</label>
                                <input type="text" class="form-control" id="input_descr_diario_clinico" placeholder="Descrizione" >
                            </div>
                            <div id="div_dati_dettaglio_spec">
                                
                            </div>
                        </div>
                        <div id="div_generazione_evento">
                            <div class="form-group">
                                <button id="btn_toggle_div_evento" type="button" class="btn btn-outline-info" data-toggle="button" aria-pressed="false" autocomplete="off">
                                    Genera evento
                                </button>
                            </div>
                            <div id="div_parametri_evento" style="display:none" class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="checkbox" class="form-check-input" id="checkbox_evento">
                                        <label class="form-check-label" for="checkbox_evento">Genera evento</label>
                                    </div>

                                    <div class="form-group">
                                        <label for="input_data_evento">Data evento</label>
                                        <input type="datetime-local" class="form-control" id="input_data_evento" value="<?php echo date('Y-m-d') . 'T' . date('H:i'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="input_descrizione">Descrizione</label>
                                        <input type="text" class="form-control" id="input_descrizione" placeholder="Descrizione" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" id="btn_salva_dettaglio">Registra</button>
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal_inserisci_allegato" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Allegato</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="input_descr_diario">Descrizione</label>
                             <select class="form-control" id="input_descr_allegato"> 
                            </select> 
                           
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" id="input_nome_file" placeholder="File" disabled >
                        </div>

                        <?php
                        echo retrieveListaAllegati();
                        ?>

                        <button class="btn btn-primary" id-doc="" id="btn_carica_allegato_sicurezza">Carica</button>
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        

         <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <h3>AREA SICUREZZA</h3>
                </div>
               
            </div>
             <br>
            
           <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button id="btn_view_ges_collaboratori" class="btn btn-info btn_ins_dettaglio" >
                            Gestione Collaboratori
                </button>
            </div>
            </div>
             <br>
            <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <button class="btn btn-info btn_ins_dettaglio" >Medico del lavoro</button>
                </div>
            </div>
              <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-medico-lavoro" class="div-tab" ></div>
                </div>
            </div>
             <br>
            <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_dettaglio" >RLS</button>
            </div>
            </div>
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-rls" class="div-tab"></div>
                </div>
            </div>
             <br>
            <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_dettaglio" >RSPP</button>
            </div>
            </div>
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-rspp" class="div-tab" ></div>
                </div>
            </div>
             <br>
            
            <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_dettaglio" >Procedura Sanitaria in caso di ferite</button>
            </div>
            </div>
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-procedura-sanitaria" class="div-tab" ></div>
                </div>
            </div>
             <br>
            
            
            <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_dettaglio" >Apparecchiature ed impianti</button>
            </div>
            </div>
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-apparecchiature" class="div-tab" ></div>
                </div>
            </div>
             <br>
            
            <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_dettaglio" >Controllo sicurezza antincendio</button>
            </div>
            </div>
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-controllo-sicurezza" class="div-tab" ></div>
                </div>
            </div>
             <br>
            
            <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_dettaglio" >Derattizzazione</button>
            </div>
            </div>
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-derattizzazione" class="div-tab" ></div>
                </div>
            </div>
             <br>
            
            <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_dettaglio" >Verifica serbatorio GPL</button>
            </div>
            </div>
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-verifica-serbatotio" class="div-tab" ></div>
                </div>
            </div>
             <br>
            <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_dettaglio" >Verifica ascensori</button>
            </div>
            </div>
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-verifica-ascensori" class="div-tab" ></div>
                </div>
            </div>
             <br>
            
            <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_dettaglio" >Prevenzione dei rischi</button>
            </div>
            </div>
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-prevenzione-rischi" class="div-tab" ></div>
                </div>
            </div>
             <br>
            <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_dettaglio" >Controllo Legionellosi</button>
            </div>
            </div>
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-legionellosi" class="div-tab" ></div>
                </div>
            </div>
             <br>
            <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_dettaglio" >Gestione emergenze</button>
            </div>
            </div>
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-ges-emergenze" class="div-tab" ></div>
                </div>
            </div>
 <br>
 
            <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <button class="btn btn-info btn_ins_dettaglio" >Certificazioni</button>
                </div>
            </div>
              <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-certificazioni" class="div-tab" ></div>
                </div>
            </div>
             <br>
             
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <button class="btn btn-info btn_ins_dettaglio" >Autocertificazioni</button>
                </div>
            </div>
              <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-autocertificazioni" class="div-tab" ></div>
                </div>
            </div>
             <br>
             
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <button class="btn btn-info btn_ins_dettaglio" >Smaltimento rifiuti</button>
                </div>
            </div>
              <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-smaltimento" class="div-tab" ></div>
                </div>
            </div>
             <br>
             
             
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <button class="btn btn-info btn_ins_dettaglio" >Servizi Lavanderia Esterna Interna (Contratto)</button>
                </div>
            </div>
              <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-lavanderia" class="div-tab" ></div>
                </div>
            </div>
             <br>
             
             
        </div>	
    </div>
        </div>
     <!-- Mainly scripts -->
    <script src="/<?php echo $nome_progetto ?>/js/jquery-3.1.1.min.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/popper.min.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/bootstrap.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>


    <!-- Peity -->
    <script src="/<?php echo $nome_progetto ?>/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/<?php echo $nome_progetto ?>/js/inspinia.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="/<?php echo $nome_progetto ?>/js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/ext/calendar/calendar.js"></script>
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/common.js"></script>
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/cartella.js"></script>
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/collaboratori.js"></script>
        <!-- Jvectormap -->
    <script src="js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- EayPIE -->
    <script src="js/plugins/easypiechart/jquery.easypiechart.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="js/demo/sparkline-demo.js"></script>
    <script type="text/javascript">
        loadTable();
    </script>

</body>


</html>
