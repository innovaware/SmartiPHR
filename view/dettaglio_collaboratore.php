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
                            <input type="text" class="form-control" id="input_descr_allegato" placeholder="File" disabled >
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
                    <h3>Collaboratore </h3>
                </div>
               
            </div>
             <br>
            
           <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_allegato_dettaglio" >Esami di laboratorio</button>
            </div>
            </div>
              <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-esami-lab" class="div-tab" ></div>
                </div>
            </div>
             <br>
            <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <button class="btn btn-info btn_ins_allegato_dettaglio" >Certificato Idoneità</button>
                </div>
            </div>
              <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-certificato-idoneita" class="div-tab" ></div>
                </div>
            </div>
             <br>
            <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_allegato_dettaglio" >Giudizio di idoneità alla mansione specifica</button>
            </div>
            </div>
             <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-giudizio-idoneita" class="div-tab"></div>
                </div>
            </div>
             <br>
            <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button class="btn btn-info btn_ins_allegato_dettaglio" >Libro Infortuni</button>
            </div>
            </div>
              <div class="row">
                <div class="col-12 col-md-3 col-lg-3 ">
                    <div id="div-libro-infortuni" class="div-tab"></div>
                </div>
            </div>
             <br>
            
            
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
    <script type="text/javascript">
        loadTableDettaglio();
    </script>

</body>


</html>