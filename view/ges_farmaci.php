<?php
if (!isset($_SESSION)) {
    session_start();
}

$nome_progetto = 'SmartiPHR';

require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/db_config_server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/utils.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/controller/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/controller/Farmaco.php';
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
        <div id="modal_inserisci_farmaco" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Farmaco</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input_nome">Nome</label>
                                    <input type="text" class="form-control" id="input_nome" placeholder="Nome" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input_descrizione">Descrizione</label>
                                    <input type="text" class="form-control" id="input_descrizione" placeholder="Descrizione" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="select_formato">Formato</label>
                                    <select class="form-control" id="select_formato">
                                        <option value="Compresse">Compresse</option>
                                        <option value="Fiale">Fiale</option>
                                        <option value="Bustine">Bustine</option>
                                        <option value="Gocce">Gocce</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="input_dose">Dose</label>
                                    <input type="text" class="form-control" id="input_dose" placeholder="Dose" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="input_confezione">Pezzi confezione:</label>
                                    <input type="number" class="form-control" id="input_confezione" placeholder="Pezzi confezione" >
                                </div>
                            </div>
                        
                            
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input_codice_interno">Codice interno:</label>
                                    <input type="text" class="form-control" id="input_codice_interno" placeholder="Codice interno" >
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" id="btn_registra_farmaco" data-sfx="">Registra Farmaco</button>
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

        <div id="modal_inserisci_carsca" class="modal fade modal_div" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Magazzino farmaci</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input_nome">Nome</label>
                                    <input type="text" class="form-control" id="input_nome_cs" placeholder="Nome" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input_descrizione">Descrizione</label>
                                    <input type="text" class="form-control" id="input_descrizione_cs" placeholder="Descrizione" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="input_confezione_cs">Qta confezione</label>
                                    <input type="number" class="form-control" id="input_confezione_cs" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="input_num_confezioni_cs">Numero Confezioni</label>
                                    <input type="number" class="form-control" id="input_num_confezioni_cs" placeholder="Num. confezioni" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <label for="input_search">Ospite</label>
                                <input type="text" id="input_search" class="form-control input_search" name="input_search" 

                                       data-url="/SmartiPHR/controller/Anagrafica.php" 
                                       data-metodo="retrieveDivSearchPaziente"
                                       >
                                <div id="div_input_search_result" style=" padding: 10px; display: none  "></div>



                            </div>
                            <div class="col-4">
                                <span id="id_paziente"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="input_data_scadenza">Data scadenza:</label>
                                    <input type="date" class="form-control" id="input_data_scadenza" >
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input_note_cs">Note:</label>
                                    <input type="text" class="form-control" id="input_note_cs" placeholder="Note" >
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" id="btn_registra_carsca" data-sfx="">Registra Carico</button>
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
            <span id="input_delete"></span>
            <div class="row">
                <div class="col-4">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal_inserisci_farmaco">Inserisci Farmaco</button>

                </div>
                <div class="col-4">
                    <div class="form-group">
                        <input type="text" class="form-control" id="input_testo" placeholder="Inserisci nome farmaco o descrizione" >
                        <button class="btn btn-outline-success" id="btn_ricerca_farmaco">Ricerca</button>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 border">
                    <div id="div_lista_farmaci_scadenza">
                        <?php
                        echo retrieveFarmaciInScadenza(15);
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 border">
                    <div id="div_lista_farmaci">

                    </div>
                </div>
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
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/farmaco.js"></script>

</body>


</html>