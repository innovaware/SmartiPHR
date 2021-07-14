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


    <!-- CSS Files -->
    <link href="/<?php echo $nome_progetto ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="/<?php echo $nome_progetto ?>/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/<?php echo $nome_progetto ?>/css/animate.css" rel="stylesheet">
    <link href="/<?php echo $nome_progetto ?>/css/style.css" rel="stylesheet">
    <link href="/<?php echo $nome_progetto ?>/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link rel="stylesheet" href="/<?php echo $nome_progetto ?>/css/site.css" >

</head>

<body>
    <div id="wrapper">
        <?php echo getSideBar(); ?>

        <div id="page-wrapper" class="gray-bg">

            <?php echo getnewNavBar(); ?>
            <div class="container">
                
                
                <?php echo getModalNuovomessaggio(); ?>
                
        <div id="modal_inserisci_record_visite_spec" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuova Visita/Esame</h5>
                         <h3 id="id_rec_vis" style="display:none"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group" id="input_data_richiesta">
                                <label class="font-normal">Data Richiesta:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_nome">Contenuto</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_visite"></textarea>
                        </div>
                        
                        
                        <div class="form-group" id="div_new_content">
                            <label for="input_nome">Nuovo Contenuto</label>
                            <textarea class="form-control" rows="5" cols='150' id="new_content_visite"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col col-6">
                                <div class="form-group">
                                   <div class="form-group" id="input_data_esecuzione">
                                <label class="font-normal">Data esecuzione</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                            </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--button type="button" class="btn btn-primary">Save changes</button-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        <button class="btn btn-primary" id="btn_salva_record_vis_spec" data-sfx="">Registra</button>
                    </div>
                </div>
            </div>
        </div>
                
                
                
           <div id="modal_inserisci_record_diario" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuova Terapia</h5>
                        <h3 id="id_rec" style="display:none"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group" id="input_data_terapia">
                                <label class="font-normal">Data:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_nome">Contenuto</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_terapia"></textarea>
                        </div>
                        
                         <div class="form-group" id="div_new_content_diario" style="display: none">
                            <label for="input_nome">Nuovo Contenuto</label>
                            <textarea class="form-control" rows="5" cols='150' id="new_content_terapia"></textarea>
                        </div>
                        <div class="row">
                            <div class="col col-6">
                               <label for="input_nome">Terapia</label>
                            <textarea class="form-control" rows="5" cols='150' id="tipo_terapia"></textarea>
                            </div>
                            
                        </div>
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--button type="button" class="btn btn-primary">Save changes</button-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        <button class="btn btn-primary" id="btn_salva_record_diario" data-sfx="">Registra</button>
                    </div>
                </div>
            </div>
        </div>
                
                
                 <label id="id_paziente" style="display: none"><?php echo $_GET['id_paziente'] ?></label>

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" onclick="openTab(event, 'generale')">Generale</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="openTab(event, 'ana-fam')" >Anamnesi famigliare</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="openTab(event, 'ana-pato')">Anamnesi patologica</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="openTab(event, 'esame-gen')" >Esame Generale</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" onclick="openTab(event, 'esame_neuro')">Esame Neurologico</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="openTab(event, 'mezzi-contenz')">Mezzi di contenzione</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"    onclick="openTab(event, 'val-tecniche')">Valutazione tecniche</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" onclick="openTab(event, 'visite-spec')">Visite specialistiche/Esami paraclinici</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" onclick="openTab(event, 'diario')">Diario</a>
                    </li>
                </ul>


          


                <!-- GENERALE -->
                <div id="generale" class="tabcontent">

                    <div id="panel-gen">
                    <div class="row">
                        <label><h3>COGNOME E NOME: </h3></label><input type="text" id="fullnome">
                        <label>SESSO</label>
                      <div class="form-check form-check-inline">
                        <input name="sesso" type="radio" value="M">
                        <label>M</label>
                      </div>
                      <div class="form-check form-check-inline">
                          <input name="sesso" type="radio" value="F">
                        <label>F</label>
                      </div>
                    </div>

                        <div class="row">
                        <label><h5>Luogo di nascita: </h5></label><input type="text" id="luogo_nascita">
                        
                        <div class="form-group" id="input_data_nascita">
                                <label class="font-normal">Data di nascita:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                                </div>
                    </div>
                      <div class="row">
                        <label><h5>Residenza: </h5></label><input type="text" id="residenza">
                    </div>
                      <div class="row">
                        <label><h5>Stato Civile: </h5></label><input type="text" id="stato_civile">
                        <label><h5>Professione: </h5></label><input type="text" id="professione">
                    </div>
                        <div class="row">
                        <label><h5>COD.SSN: </h5></label><input type="text" id="ssn">
                        <label><h5>ESENZIONE TICKET: </h5></label><input type="text" id="ticket">
                         <label><h5>DEL: </h5></label><input type="text" id="del">
                      </div>
                      <div class="row">
                        <label><h5>Persone di riferimento: </h5></label><input type="text" id="rif">
                        <label><h5>Tel: </h5></label><input type="text" id="tel_rif">
                      </div>
                  </div>

                    
                    

                    <div class="row">
                        <div class="form-group" id="dataingresso">
                                <label class="font-normal">DATA D'INGRESSO:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                            </div>
                        <label>PROVENIENZA</label>
                        <input type="text" id="provenienza">
                    </div>


                    <div class="row">
                        <label><h3>TIPO DI RICOVERO: </h3></label><input type="text" id="ricovero">
                    </div>

                    <div class="row">
                        <label><h3>STANZA N°: </h3></label><input type="text" id="stanza">
                        <label>LETTO N°</label><input type="text" id="letto">
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>DIAGNOSI ALL'INGRESSO</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="diagnosi"></textarea>
                        </div>
                    </div>


                    <div class="row">
                        <label><h3>ALLERGIE: </h3></label><input type="text" id="allergie">
                    </div>

                    <div class="row">
                        <label><h3>TRASFERIMENTI: </h3></label><input type="text" id="trasferimenti">
                        <div class="form-group" id="data_trasferimento">
                                
                                <div class="input-group date">
                                    <label class="font-normal">data:</label><span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                            </div>
                    </div>

                    <div class="row">
                        <label><h3>DIMISSIONE: </h3></label>
                        <div class="form-group" id="data_dimissione">
                              
                                <div class="input-group date">
                                    <label class="font-normal">data:</label>  <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                            </div>
                    </div>

                    <div class="row">
                        <label><h3>DECESSO: </h3></label>
                        <div class="form-group" id="data_decesso">
                               
                                <div class="input-group date">
                               <label class="font-normal">data:</label>      <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                            </div>
                    </div>

                    <div class="row">
                        <label><h3>CAUSA DECESSO: </h3></label><input type="text" id="causa-dec">    
                    </div>

                </div>

                <!-- ANAM FAM -->
                <div id="ana-fam" class="tabcontent">

                   

                    <label><h3>ANAMNESI FAMIGLIARE</h3></label>
                    <div class="row">
                        <label><h3>GENTILIZIO POSITIVO PER: </h3>  
                            <input type="checkbox" id="ipertensione"> Ipertensione
                            <input type="checkbox" id="diabate"> Diabete 
                            <input type="checkbox" id="cardiovascolari"> Malattie Cardiovascolari                           
                            <input type="checkbox" id="cerebrovascolari"> Malattie Cerebrovascolari
                            <input type="checkbox" id="demenza"> Demenza 
                            <input type="checkbox" id="neoplasie"> Neoplasie
                            <br>
                            <input type="checkbox" id="altro"> Altro <br>
                            <textarea class="form-control" rows="5" cols='150' id="content_altro"></textarea>

                    </div>


                    <div class="row">
                        <label><h3>ANAMNESI FISIOLOGICA: </h3></label><br>
                        <textarea class="form-control" rows="5" cols='150' id="anamnesi"></textarea>
                    </div>

                    <div class="row">
                        <label><h3>VACCINAZIONI:</h3></label>
                        <input type="checkbox" id="antitetanica"> Antitetanica<br>
                        <input type="checkbox" id="antiepatite_b"> Antiepatite B<br>
                        <input type="checkbox" id="antinfluenzale"> Antinfluenzale<br>
                        <input type="checkbox" id="altre"> Altre <br>
                        <textarea class="form-control" rows="5" cols='150' id="content_altre"></textarea>
                    </div>

                    <div class="row">
                        <label for="comment"><h5>SCOLARITA':</h5></label><input type="text" id="scolarita">
                    </div>

                    <div class="row">
                        <label for="comment"><h5>ATTIVITA' LAVORATIVA PRINCIPALE':</h5></label><input type="text" id="attivita_lavorativa">
                    </div>

                    <div class="row">
                        <label for="comment"><h5>SERVIZIO MILITARE':</h5></label><input type="text" id="servizio_mil">
                    </div>

                    <div class="row">
                        <label for="comment"><h5>MENARCA:</h5></label><input type="text" id="menarca">
                        <label for="comment"><h5>MENOPAUSA':</h5></label><input type="text" id="menopausa">
                        <div class="form-check form-check-inline">
                            <input name="rb_menopausa" type="radio">
                            <label for="radio4">fisiologica</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="rb_menopausa" type="radio">
                            <label for="radio5">chirurgica</label>
                        </div>
                    </div>

                    <div class="row">
                        <label><h3>ATTIVITA' FISICA: </h3></label><input type="text" id="attivita_fisica">
                    </div>

                    <div class="row">
                        <label><h3>ALIMENTAZIONE: </h3></label><input type="text" id="alimentazione">
                    </div>

                    <div class="row">
                        <label><h3>ALVO: </h3></label><input type="text" id="alvo">
                    </div>

                    <div class="row">
                        <label><h3>DIURESI: </h3></label><input type="text" id="diuresi">
                    </div>

                    <div class="row">
                        <label><h3>ALCOLICI: </h3></label><input type="text" id="alcolici">
                    </div>


                    <div class="row">
                        <label><h3>FUMO: </h3></label><input type="text" id="fumo">
                    </div>

                    <div class="row">
                        <label><h3>SONNO: </h3></label><input type="text" id="sonno">
                    </div>

                </div>

                <!-- ANAM PATOL -->
                <div id="ana-pato" class="tabcontent">

                   

                    <div class="row">
                        <label><h3>ANAMNESI PATOLOGICA REMOTA: </h3></label><br>
                        <textarea class="form-control" rows="5" cols='150' id="ana_patol_remota"></textarea>
                    </div>

                    <div class="row">
                        <label><h3>ANAMNESI PATOLOGICA PROSSIMA: </h3></label><br>
                        <textarea class="form-control" rows="5" cols='150' id="ana_patol_pross"></textarea>
                    </div>

                    <div class="row">
                        <label><h3>TERAPIA IN ATTO A DOMICILIO: </h3></label><br>
                        <textarea class="form-control" rows="5" cols='150' id="terapia"></textarea>
                    </div>

                    <div class="row">
                        <label><h3>REAZIONI AVVERSE DA FARMACI: </h3></label><br>
                        <textarea class="form-control" rows="5" cols='150' id="reazioni_avverse"></textarea>
                    </div>
                </div>

                <!-- ESAME GEN -->
                <div id="esame-gen" class="tabcontent">

                   
                    <label><h3>ESAME OBIETTIVO GENERALE</h3></label>
                    <div class="row">
                        <label><h5>TIPO COSTITUZIONALE: </h5></label> 
                        <select class="custom-select" id="tipo_costituzionale" aria-label="Example select with button addon">
                            <option selected>Seleziona ...</option>
                            <option value="normotipo">normotipo</option>
                             <option value="branchitipo">branchitipo</option>
                              <option value="longitipo">longitipo</option>
                         </select>

                    </div>

                    <div class="row">
                        <label><h5>CONDIZIONI GENERALI: </h5></label> 
                        
                        <select class="custom-select" id="condizioni_gen" aria-label="Example select with button addon">
                            <option selected>Seleziona ...</option>
                            <option value="buone">buone</option>
                             <option value="discrete">discrete</option>
                              <option value="scadute">scadute</option>
                         </select>

                    </div>

                    <div class="row">
                        <label><h5>NUTRIZIONE: </h5></label> 
                        <select class="custom-select" id="nutrizione" aria-label="Example select with button addon">
                            <option selected>Seleziona ...</option>
                            <option value="adeguata">adeguata</option>
                             <option value="insufficiente">insufficiente</option>
                              <option value="obesita">obesità</option>
                               <option value="cachessia">cachessia</option>
                         </select>
                    </div>




                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>CUTE E MUCOSE :</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="cute"></textarea>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>SISTEMA LINFONODALE :</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="linfonodale"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>CAPO E COLLO :</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="capo_collo"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>PROTESI/AUSILI :</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="protesi"></textarea>
                        </div>
                    </div>




                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>APPARATO UROGENITALE :</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="urogemitale"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>APPARATO MUSCOLOSCHELETRICO :</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="muscoloscheletrico"></textarea>
                        </div>
                    </div>



                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>APPARATO CARDIOVASCOLARE :</h3></label>
                            <br>
                            <label for="comment"><h3>Cuore:</h3></label> <textarea class="form-control" rows="5" cols='150' id="cuore"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <label><h5>Freq.Cardiaca: </h5></label><input type="text" name="freq"> <label><h5>/min </h5></label>
                        <label><h5>Pressione arteriosa: </h5></label><input type="text" name="pressione"> 
                    </div>


                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>Polsi arteriosi :</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="polsi"></textarea>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>APPARATO RESPIRATORIO :</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="apparato_resp"></textarea>
                        </div>
                    </div>


                    <label for="comment"><h3>APPARATO DIGERENTE :</h3></label>
                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>Addome </h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="addome"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>Fegato</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="fegato"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>Milza</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="milza"></textarea>
                        </div>
                    </div>


                </div>

                
                <!-- ESAME NEUROLOGICO -->
                <div id="esame_neuro" class="tabcontent">
                    <label><h3>ESAME NEUROLOGICO </h3></label>
                    <br>
                    <label><h3>Facies: </h3></label><input type="text" id="facies">

                                        <div class="row">
                                                    <table class="table">
                                                        <tbody>
                                                          <tr>
                                                              <td>
                                                                  <label>Stato di coscienza</label>
                                                                    <select class="custom-select" id="stato_coscienza" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="adeguata">Vigile</option>
                                                                        <option value="insufficiente">Confuso</option>
                                                                         <option value="obesita">Saporoso</option>
                                                                          <option value="cachessia">Comotoso</option>
                                                                    </select>
                                                              </td>
                                                            <td>
                                                              <label>Stato emotivo</label>
                                                                    <select class="custom-select" id="stato_emotivo" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="adeguata">Adeguato</option>
                                                                        <option value="insufficiente">Ansia</option>
                                                                         <option value="obesita">Depressione</option>
                                                                          <option value="cachessia">Comotoso</option>
                                                                    </select>
                                                            </td>
                                                            <td>
                                                              <label>Comportamento</label>
                                                                    <select class="custom-select" id="comportamento" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="adeguata">Adeguato</option>
                                                                       <option value="albilita">Labilità emotiva</option>
                                                                       <option value="rallentato">Rallentato</option>
                                                                       <option value="apatia">Apatia</option>
                                                                        <option value="psicomotoria">Agit.Psicomotoria</option>
                                                                    </select>
                                                            </td>
                                                             </tr>
                                                             
                                                             
                                                             <tr>
                                                              <td>
                                                                  <label>linguaggio</label>
                                                                    <select class="custom-select" id="linguaggio" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="normale">Normale</option>
                                                                        <option value="afasico">Afasico</option>
                                                                         <option value="disartrico">Disartrico</option>
                                                                          <option value="perseverazioni">Perseverazioni</option>
                                                                          <option value="logorrea">Logorrea</option>
                                                                    </select>
                                                              </td>
                                                            <td>
                                                              <label>Concentrazione</label>
                                                                    <select class="custom-select" id="concentrazione" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="adeguata">Adeguata</option>
                                                                        <option value="distraibile">Facil.Distraibile</option>
                                                                         <option value="inadeguata">Inadeguata</option>
                                                            
                                                                    </select>
                                                            </td>
                                                            <td>
                                                              <label>Disturbi del pensiero</label>
                                                                    <select class="custom-select" id="disturbi_pensiero" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="assenti">Assenti</option>
                                                                       <option value="deliranti">Idee deliranti</option>
                                                                       <option value="allucinazioni">Allucinazioni</option>
                                                                       <option value="confabulazioni">Confabulazioni</option>
                                                                    </select>
                                                            </td>
                                                             </tr>
                                                             
                                                             
                                                               <tr>
                                                              <td>
                                                                  <label>Orientamento personale</label>
                                                                    <select class="custom-select" id="orientamento_personale" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="orientato">Orientato</option>
                                                                        <option value="parzialmente">Parzialmente</option>
                                                                         <option value="disorientatto">Disorientatto</option>
                                                                    </select>
                                                              </td>
                                                             <td>
                                                                  <label>Orientamento temporale</label>
                                                                    <select class="custom-select" id="orientamento_temporale" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="orientato">Orientato</option>
                                                                        <option value="parzialmente">Parzialmente</option>
                                                                         <option value="disorientatto">Disorientatto</option>
                                                                    </select>
                                                              </td>
                                                             <td>
                                                                  <label>Orientamento spaziale</label>
                                                                    <select class="custom-select" id="orientamento_spaziale" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="orientato">Orientato</option>
                                                                        <option value="parzialmente">Parzialmente</option>
                                                                         <option value="disorientatto">Disorientatto</option>
                                                                    </select>
                                                              </td>
                                                             </tr>
                                                             
                                                             
                                                             <tr>
                                                              <td>
                                                                  <label>Stazione eretta</label>
                                                                    <select class="custom-select" id="staz_eretta" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="normale">Normale</option>
                                                                        <option value="no_valutabile">Non valutabile</option>
                                                                         <option value="flessione">Atteggiamento in flessione</option>
                                                                         
                                                                         <option value="lateropulsione">Lateropulsione</option>
                                                                        <option value="retropulsione">Retropulsione</option>
                                                                         <option value="no_possibile">Non possibile</option>
                                                                    </select>
                                                              </td>
                                                             <td>
                                                                  <label>Seduto</label>
                                                                    <select class="custom-select" id="seduto" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                        <option value="normale">Normale</option>
                                                                         <option value="lateropulsione">Lateropulsione</option>
                                                                        <option value="retropulsione">Retropulsione</option>
                                                                        <option value="supporti">Solo con supporti</option>
                                                                         <option value="no_possibile">Non possibile</option>
                                                                    </select>
                                                              </td>
                                                             <td>
                                                                  <label>Altre anomalie posturali</label>
                                                                    <select class="custom-select" id="anomalie_posturali" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="capo">Capo</option>
                                                                        <option value="tronco">Tronco</option>
                                                                         <option value="arti_inf">Arti inf.</option>
                                                                          <option value="arti_sup">Arti sup.</option>
                                                                           <option value="altro">Altro</option>
                                                                    </select>
                                                              </td>
                                                             </tr>
                                                             
                                                             
                                                           </tbody>
                                                      </table>
                                                    </div>
                    
                    <label><h3>Romberg</h3></label>
                    <br>
                     <div class="form-check">
                        <input name="romberg" type="radio" value="si">
                        <label>Positivo</label>
                      </div>
                      <div class="form-check">
                          <input name="romberg" type="radio" value="no">
                        <label>Negativo</label>
                      </div>
                    
                    
                    <div class="row">
                                                    <table class="table">
                                                        <tbody>
                                                          <tr>
                                                              <td>
                                                                  <label>Andatura</label>
                                                                    <select class="custom-select" id="andatura" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="normale">Normale</option>
                                                                        <option value="emiparetica">Emiparetica</option>
                                                                         <option value="paraparetica">Paraparetica</option>
                                                                          <option value="atassica">Atassica</option>
                                                                           <option value="parkinsoniana">Parkinsoniana</option>
                                                                        <option value="anserina">Anserina</option>
                                                                         <option value="steppante">Steppante</option>
                                                                          <option value="claudicante">Claudicante</option>
                                                                           <option value="no_valutabile">Non valutabile</option>
                                                                    </select>
                                                              </td>
                                                            <td>
                                                              <label>Movimenti Involontari</label>
                                                                    <select class="custom-select" id="mov_involontari" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="assenti">Assenti</option>
                                                                        <option value="trem_riposo">Tremore a riposo</option>
                                                                         <option value="trem_posturale">Tremore posturale</option>
                                                                          <option value="mioclonie">Mioclonie</option>
                                                                           <option value="discenesie">Discenesie</option>
                                                                          <option value="coreici">Movi.Coreici</option>
                                                                    </select>
                                                            </td>
                                                            
                                                             </tr>
                                                        </tbody>    
                                                    </table>
                    </div>
                    
                    <div class="row">
                        <h3>Nervi cranici</h3>
                                                    <table class="table">
                                                        <tbody>
                                                          <tr>
                                                              <td>
                                                                  <label>Olfatto</label>
                                                                  <input type="text" id="olfatto">
                                                              </td>
                                                            <td>
                                                              <label>Pupille</label>
                                                                  <input type="text" id="pupille">
                                                            </td>
                                                            
                                                          </tr>
                                                          
                                                           <tr>
                                                              <td>
                                                                  <label>Visus</label>
                                                                  <input type="text" id="visus">
                                                              </td>
                                                            <td>
                                                              <label>Campo visivo</label>
                                                                  <input type="text" id="campo_vis">
                                                            </td>
                                                            
                                                          </tr>
                                                          
                                                           <tr>
                                                              <td>
                                                                  <label>Fondo oculare</label>
                                                                  <input type="text" id="oculare">
                                                              </td>
                                                            <td>
                                                              <label>Movimenti oculari e palpebrali</label>
                                                                  <input type="text" id="mov_oculari">
                                                            </td>
                                                            
                                                          </tr>
                                                          
                                                           <tr>
                                                              <td>
                                                                  <label>Masticazione</label>
                                                                  <input type="text" id="masticazione">
                                                              </td>
                                                            <td>
                                                              <label>Motilità facciale</label>
                                                                  <input type="text" id="mot_facciale">
                                                            </td>
                                                            
                                                          </tr>
                                                          
                                                          
                                                          <tr>
                                                              <td>
                                                                  <label>Funzione uditiva</label>
                                                                  <input type="text" id="funz_uditiva">
                                                              </td>
                                                            <td>
                                                              <label>Funzione vestibolare</label>
                                                                  <input type="text" id="funz_vest">
                                                            </td>
                                                            
                                                          </tr>
                                                          
                                                           <tr>
                                                              <td>
                                                                  <label>Motilità faringea</label>
                                                                  <input type="text" id="mot_faringea">
                                                              </td>
                                                            <td>
                                                              <label>Trofismo e motilità linguale</label>
                                                                  <input type="text" id="trofisma">
                                                            </td>
                                                            
                                                          </tr>
                                                          
                                                          <tr>
                                                              <td>
                                                                  <label>Articolazione della parola</label>
                                                                  <input type="text" id="articolazione">
                                                              </td>
                                                            <td>
                                                              <label>Annotazioni</label>
                                                                  <input type="text" id="annotazioni">
                                                            </td>
                                                            
                                                          </tr>
                                                          
                                                        </tbody>    
                                                    </table>
                    </div>
                    
                    <div class="row">
                                                    <table class="table">
                                                        <tbody>
                                                          <tr>
                                                              <td>
                                                                  <label>Tono</label>
                                                                    <select class="custom-select" id="tono" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="Normale">Normale</option>
                                                                        <option value="ip_spastica">Ipertonia spastica</option>
                                                                         <option value="ip_plastica">Ipertonia plastica</option>
                                                                          <option value="ipotonia">Ipotonia</option>
                                                                          <option value="flaccidita">Flaccidità</option>
                                                                    </select>
                                                              </td>
                                                            <td>
                                                              <label>Forza</label>
                                                                    <select class="custom-select" id="forza" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                     <option value="Normale">Normale</option>
                                                                        <option value="ipostenia">Ipostenia</option>
                                                                         <option value="paresi">Paresi</option>
                                                                          <option value="plegia">Plegia</option>
                                                                    </select>
                                                            </td>
                                                            <td>
                                                              <label>Coordinazione</label>
                                                                    <select class="custom-select" id="coordinazione" aria-label="Example select with button addon">
                                                                       <option selected>Seleziona...</option>
                                                                       <option value="normale">Normale</option>
                                                                       <option value="dismetria">Dismetria</option>
                                                                       <option value="no_valutabile">Non valutabile</option>
                                                                    </select>
                                                            </td>
                                                             </tr>
                                                        </tbody>
                                                    </table>
                       </div>
                    
                    <label><h3>Riflessi osteotendinei </h3></label>
                    <br>
                    
                    <textarea rows="4" cols="50" id="riflessi_osteo">
                        </textarea>
                    
                    <br>
                    
                         <label>Sensibilità superficiale</label>
                        <input type="text" id="sens_sup">
                        <br>
                        
                        <label>Sensibilità profonda</label>
                        <input type="text" id="sens_prof">
                        <br>
                        <label>Funzioni cerebellari</label>
                        <input type="text" id="fun_cereb">
                        <br>
                        <label>Funzioni extrapirabidali</label>
                        <input type="text" id="extrapirabidali">
                        <br>
                        <label>Segni meningei</label>
                        <input type="text" id="meninge">
                        <br>
                        <label>Sfinteri</label>
                        <input type="text" id="sfinteri">
                        <br>
                        <label>Annotazioni</label>
                        <br>
                         <textarea rows="4" cols="50" id="annotazioni_neuro">
                        </textarea>
                   
                </div>

                <!-- MEZZI -->
                <div id="mezzi-contenz" class="tabcontent">

                    
                    <label><h3>USO DEI MEZZI DI CONTENZIONE FISICA</h3></label>
                    <br>
                     <div class="form-check">
                        <input name="mezzi_cont" type="radio" value="no">
                        <label>NO</label>
                      </div>
                      <div class="form-check">
                          <input name="mezzi_cont" type="radio" value="si">
                        <label>SI</label>
                      </div>

                    
                     <table class="table">
                                        <tbody>
                                          <tr>
                                              <td><h3>TIPO:</h3></td>
                                              <td> <input type="checkbox" id="check_spondine_letto"> SPONDINE AL LETTO

                                              <td> <div class="form-check form-check-inline">
                                                    <input name="spondine_letto" type="radio" value="dx">
                                                    <label>DX</label>
                                                  </div>
                                                  <div class="form-check form-check-inline">
                                                      <input name="spondine_letto" type="radio" value="sx">
                                                    <label>SX</label>
                                                  </div>
                                              </td>
                                              </tr>
                                              
                                              <tr>
                                              <td></td>
                                              <td> <input type="checkbox" id="check_contenzione_pelvica"> CONTENZIONE PELVICA

                                              <td></td>
                                              </tr>
                                              
                                              
                                              <tr>
                                              <td></td>
                                              <td> <input type="checkbox" id="check_pettorina"> PETTORINA

                                              <td></td>
                                              </tr>
                                              
                                              
                                              <tr>
                                              <td></td>
                                              <td> <input type="checkbox" id="check_cintura_addom"> CINTURA ADDOMINALE

                                              <td></td>
                                              </tr>
                                              
                                              <tr>
                                              <td></td>
                                              <td> <input type="checkbox" id="check_cintura_letto"> CINTURA A LETTO

                                              <td></td>
                                              </tr>
                                              
                                              
                                              <tr>
                                              <td><h3>TIPO:</h3></td>
                                              <td> <input type="checkbox" id="check_cinghia"> CINGHIA FERMABRACCIO

                                              <td> <div class="form-check form-check-inline">
                                                    <input name="cinghia" type="radio" value="dx">
                                                    <label>DX</label>
                                                  </div>
                                                  <div class="form-check form-check-inline">
                                                      <input name="cinghia" type="radio" value="sx">
                                                    <label>SX</label>
                                                  </div>
                                              </td>
                                              </tr>
                                              
                                              
                                              <tr>
                                              <td></td>
                                              <td> <input type="checkbox" id="check_tav_carrozzina"> TAVOLINO PER CARROZZINA

                                              <td></td>
                                              </tr>
                                        </tbody>
                     </table>
     



                    <div class="row">
                        <label><h5>PRESENZA DI CONSENSO INFORMATO </h5></label> 
                        <div class="form-check form-check-inline">
                            <input name="consenso" type="radio" value="si">
                            <label>SI</label>
                        </div>
                        <div class="form-check form-check-inline">
                              <input name="consenso" type="radio" value="no">
                            <label>NO</label>
                        </div>
                    </div>

                    <div class="row">
                        <label><h5>DATA DI INZIO </h5></label>  
                        <div class="form-check">
                            <input name="inizio" type="radio" value="ingresso">
                            <label>ALL'INGRESSO</label>
                        </div>
                        <div class="form-check">
                          
                            <div class="form-group" id="input_data_ingresso">  
                             
                                <div class="input-group date">
                                    <input name="inizio" type="radio" value="altro"><span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                                </div>
                        </div>
                    </div>

                   
                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>MOTIVO </h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="motivo"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>TEMPI </h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="tempi"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <label><h3>DURATA PREVISTA </h3></label><input type="text" id="durata">
                    </div>

                    <div class="row">
                        <label><h3>INTERRUZIONE </h3></label><input type="text" id="interruzione">
                    </div>



                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>MOTIVO DELL'INTERRUZIONE</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="motivo_interr"></textarea>
                        </div>
                    </div>
                </div>


                <!-- VALUTAZIONI -->
                <div id="val-tecniche" class="tabcontent">
                    
                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>VALUTAZIONE SOCIALE</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="sociale"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>VALUTAZIONE EDUCATIVA</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="educativa"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>VALUTAZIONE PSICOLOGICA</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="psicologica"></textarea>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group">
                            <label for="comment"><h3>VALUTAZIONE MOTORIA</h3></label>
                            <textarea class="form-control" rows="5" cols='150' id="motoria"></textarea>
                        </div>
                    </div>
                </div>

                
                 <!-- VISITE -->
                  <div id="visite-spec" class="tabcontent">


                        <div class="row">
                                    <table class="table" id="tab_vis_spec">
                                        <thead>
                                          <tr>
                                            <th>Data Richiesta</th>
                                            <th>Visite specialistiche/Esami paraclinici</th>       
                                             <th>Data esecuzione</th>
                                             <th></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                      </table>
                                    </div>

</div>

               <!-- DIARIO -->
                  <div id="diario" class="tabcontent">


                        <div class="row">
                                    <table class="table" id="tab_diario">
                                        <thead>
                                          <tr>
                                            <th>Data</th>
                                            <th>Diario Clinico</th>       
                                             <th>Terapia</th>
                                              <th></th>
                                          </tr>
                                        </thead>
                                        <tbody>                                        
                                        </tbody>
                                      </table>
                                    </div>

                        </div>
               
            </div>

<button class="btn btn-primary" id="btn_save_tab_med"> SALVA</button>
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

    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/common.js"></script>
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/cartella.js"></script>
    
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/plugins/datapicker/bootstrap-datepicker.js"></script>

        <script>
              function openTab(evt, Name) {
                    var i, tabcontent, tablinks;
                    tabcontent = document.getElementsByClassName("tabcontent");
                    for (i = 0; i < tabcontent.length; i++) {
                      tabcontent[i].style.display = "none";
                    }
                    tablinks = document.getElementsByClassName("nav-link");
                    for (i = 0; i < tablinks.length; i++) {
                      tablinks[i].className = tablinks[i].className.replace(" active", "");
                    }
                    document.getElementById(Name).style.display = "block";
                    if(evt != null)
                        evt.currentTarget.className += " active";
                    else
                        tablinks[0].className+= " active";
                  }
                 
               
                  
 $(document).ready(function(){
                       
        openTab(null, 'generale');
        
        getDatiPanelMedAnagrafica();
        
        getDatiTabsMed();
        
         getListaRowsVisiteSpec();
         getListaRowsDiarioClinico();
        
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

</body>


</html>