      
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="/SmartiPHR/ext/calendar/styles/styles.css">


<?php

$nome_progetto = 'SmartiPHR';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/db_config_server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/utils.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/' . $nome_progetto . '/ext/calendar/CalendarBean.php';


?>

<div id="modal_inserisci_evento" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inserisci evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col col-6">
                        <div class="form-group">
                            <label for="input_data_evento">Data evento</label>
                            <input type="datetime-local" class="form-control" id="input_data_evento" >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_descrizione">Descrizione</label>
                    <input type="text" class="form-control" id="input_descrizione" placeholder="Descrizione" >
                </div>

                <button class="btn btn-primary" id="btn_salva_evento" tipo_vista="mese">Registra Evento</button>
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


<div id="cal_container">
</div>



<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" ></script>



<script src ="/SmartiPHR/ext/calendar/calendar.js"></script>

<script type="text/javascript">
	aggiornaVistaMese('2019-06-01');
	//aggiornaVistaSettimana('2019-06-01');
</script>