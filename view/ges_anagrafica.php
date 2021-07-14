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
 
</head>
    <body>
 <div id="wrapper">
         <?php echo getSideBar(); ?>
    
        <div id="page-wrapper" class="gray-bg">
            
        <?php echo getnewNavBar(); ?>
        <div class="wrapper wrapper-content">
        
        <button class="btn btn-primary" data-toggle="modal" data-target="#modal_inserisci_utente">Inserisci Anagrafica</button>
        
        
        <div id="modal_inserisci_utente" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserisci anagrafica</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="input_nome">Nome</label>
                            <input type="text" class="form-control" id="input_nome" placeholder="Nome">
                        </div>
                        <div class="form-group">
                            <label for="input_nome">Cognome</label>
                            <input type="text" class="form-control" id="input_cognome" placeholder="Cognome">
                        </div>
                        <div class="row">
                            <div class="col col-6">
                                <div class="form-group">
                                    <label for="input_data_nasc">Data nascita</label>
                                    <input type="date" class="form-control" id="input_data_nasc" >
                                </div>
                            </div>
                            <div class="col col-6">
                                <div class="form-group">
                                    <label for="input_sesso">Sesso</label>
                                    <select class="form-control" id="input_sesso">
                                        <option value="M">Uomo</option>
                                        <option value="F">Donna</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_indirizzo">Indirizzo</label>
                            <input type="text" class="form-control" id="input_indirizzo" placeholder="Indirizzo">
                        </div>
                        <div class="form-group">
                            <label for="input_localita">Località</label>
                            <input type="text" class="form-control" id="input_localita" placeholder="Località">
                        </div>
                        <div class="row">
                            <div class="col col-6">
                                <div class="form-group">
                                    <label for="input_cap">cap</label>
                                    <input type="text" class="form-control" id="input_cap" placeholder="cap">
                                </div>
                            </div>
                            <div class="col col-6">
                                <div class="form-group">
                                    <label for="input_provincia">Provincia</label>
                                    <input type="text" class="form-control" id="input_provincia" placeholder="Provincia">
                                </div>
                            </div>
                        </div>




                        <button class="btn btn-primary" id="btn_insert_anagrafica">Registra anagrafica</button>
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--button type="button" class="btn btn-primary">Save changes</button-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 border">
                    <div id="div_lista_anagrafiche">
                        <?php
                        ?>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-12">


                </div>
            </div>

        </div>	
        </div>
            
        </div>
            
 </div>

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
    <script src="/<?php echo $nome_progetto ?>/js/plugins/jquery-ui/jquery-ui.min.js"></script>t>

    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/common.js"></script>
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/anagrafica.js"></script>

</body>


</html>