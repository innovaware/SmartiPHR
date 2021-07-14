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
         <div class="row">
            <div class="col-sm-2">
              <button id="btn_carica_item_modal" class="btn btn-primary" data-toggle="modal" data-target="#modal_mov_carsca">Inserisci carico</button>
            </div>
             <div class="col-sm-3">
               <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="select_magaz"><span id="testo_select_magaz"></span></label>
                </div>
                <select class="custom-select" id="select_magaz">
                  <option selected>Seleziona...</option>
                </select>
              </div>  
             </div>
         </div>
        
        
        <div id="modal_mov_carsca" class="modal fade modal_div" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Carico</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label for="input_data_mov">Data</label>
                            <input type="datetime-local" class="form-control" id="input_data_mov" value="<?php echo date('Y-m-d') . 'T' . date('H:i'); ?>" >
                        </div>
                        <div class="form-group">
                            <span id="id_mag" id_mag=""></span>
                            <label for="input_item_mov">Descrizione</label>
                            <input type="text" class="form-control" id="input_item_mov" placeholder="Descrizione" >
                        </div>
                        <div class="form-group">
                            <label for="input_qta_mov">Qta</label>
                            <input type="number" class="form-control" id="input_qta_mov" placeholder="Qta" >
                        </div>
                        
                        <label for="input_search">Assegnatario</label>
                                <input type="text" id="input_search" class="form-control input_search" name="input_search" 
                                       valselezionato="0"
                                       data-url="/SmartiPHR/controller/Anagrafica.php" 
                                       data-metodo="retrieveDivSearchPaziente"
                                       >
                        <div id="div_input_search_result" style=" padding: 10px; display: none  "></div>
                        

                        <button class="btn btn-primary" id="btn_carsca_item">Registra</button>
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
            <h4 id="tipo_mag" tipo_mag="<?php echo $_GET['tipo_mag']; ?>"></h4>
                
            <div id="div_lista_item_magazzino">
                
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


    <!-- Peity -->
    <script src="/<?php echo $nome_progetto ?>/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/<?php echo $nome_progetto ?>/js/inspinia.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="/<?php echo $nome_progetto ?>/js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/autocomplete.js"></script>
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/common.js"></script>
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/magazzino.js"></script>
    

</body>


</html>