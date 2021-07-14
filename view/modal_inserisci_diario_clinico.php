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