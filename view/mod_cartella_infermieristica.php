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
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-3 ">
                    <h6>Cartella #<span id="span_id_cartella"><?php echo $_GET['id_cartella'] ?></span></h6>

                    <?php
                    $anag = retrieveAnagraficaFromIdCartella('inf', $_GET['id_cartella']);
                    echo $anag->nome . ' ' . $anag->cognome;
                    ?>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 ">
                    <button class="btn btn-secondary  btn-sm" type="button" data-toggle="collapse" data-target="#div_dettagli_anagrafica" aria-expanded="false" aria-controls="div_dettagli_anagrafica">
                        Dettagli
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="collapse" id="div_dettagli_anagrafica">
                        <div class="card card-body">
                            <?php
                            echo dataEn2It($anag->data_nascita) . '<br>';
                            echo ($anag->indirizzo) . '<br>';
                            echo $anag->cap . ' ' . $anag->localita . ' ' . $anag->provincia;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    Diagnosi
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <input type="text" id="input_diagnosi" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    Intolleranze alimentari  
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <input type="text" id="input_intolleranze" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    Allergie
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <input type="text" id="input_allergie" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    Infezioni
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <input type="text" id="input_infezioni" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    Terapia in atto
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <input type="text" id="input_infezioni" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    Catetere vescicale
                </div>
                <div class="col-sm-12 col-md3 col-lg-3">
                    Inserimento
                    <select id="select_catetere_sn" class="form-control">
                        <option value="N">No</option>
                        <option value="S">Si</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md3 col-lg-3">
                    Data inserimento
                    <input type="date" id="input_catetere_data" class="form-control">
                </div>
                <div class="col-sm-12 col-md3 col-lg-3">
                    Diametro
                    <input type="text" id="input_catetere_diam" class="form-control">
                </div>

            </div>
            <?php
            getBodyCartella('inf');
            ?>


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
    

</body>


</html>
