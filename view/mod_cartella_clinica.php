di<?php
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

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php
        echo getPageTitle();
        echo getFavicon();
        ?>	
        <link rel="stylesheet" href="/<?php echo $nome_progetto ?>/css/site.css" >

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" >
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        
    </head>
    <body>

        <?php
        echo getNavBar();
        ?>
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
                            <input type="text" class="form-control" id="input_descr_allegato" placeholder="Descrizione" >
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" id="input_nome_file" placeholder="File" disabled >
                        </div>

                        <?php
                        echo retrieveListaAllegati();
                        ?>

                        <button class="btn btn-primary" id="btn_carica_allegato">Carica</button>
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        
        <a href="#" class="btn btn-info btn-indietro">
          <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </a>
       

        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-3 ">
                    <h6>Cartella #<span id="span_id_cartella"><?php echo $_GET['id_cartella'] ?></span></h6>

                    <?php
                    $anag = retrieveAnagraficaFromIdCartella($_GET['sfx'], $_GET['id_cartella']);
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
            <?php
            getBodyCartella($_GET['sfx']);
            ?>

        </div>	
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" ></script>

    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/ext/calendar/calendar.js"></script>
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/common.js"></script>
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/cartella.js"></script>

</body>


</html>