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
       <link href="/<?php echo $nome_progetto ?>/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
       <link rel="stylesheet" href="/<?php echo $nome_progetto ?>/css/site.css" >
 
</head>
    <body>
    <div id="wrapper">
         <?php echo getSideBar(); ?>
    
        <div id="page-wrapper" class="gray-bg">
            
        <?php echo getnewNavBar(); ?>
      <div class="wrapper wrapper-content">
          
          
        <div id="modal_inserisci_cartella_clinica" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document" style="max-width: none;width: 90%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cartella clinica</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
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
                
                
                 <label id="id_anagrafica" style="display: none"></label>
                 
                 
                 
                 
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
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="btn_save_tab_med"> SALVA</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        
          
          
           <div id="modal_inserisci_cartella_inf" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document" style="max-width: none;width: 90%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cartella clinica</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        
                         <div id="modal_inserisci_record_intervento" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuova Intervento</h5>
                         <h3 id="id_rec_interv" style="display:none"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group" id="input_data_interv">
                                <label class="font-normal">Data:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_nome">Diagnosi</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_diagnosi"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="input_nome">Obiettivi</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_obiettivi"></textarea>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="input_nome">Intervento</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_interv"></textarea>
                        </div>
                        
                        
                        <div class="form-group" id="div_new_content">
                            <label for="input_nome">Valutazione/Firma</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_valutazione"></textarea>
                        </div>
                        
                        
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--button type="button" class="btn btn-primary">Save changes</button-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        <button class="btn btn-primary" id="btn_salva_record_interv" data-sfx="">Registra</button>
                    </div>
                </div>
            </div>
        </div>
                
                
                
           <div id="modal_inserisci_record_diario_inf" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuovo</h5>
                        <h3 id="id_rec_diario_inf" style="display:none"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group" id="input_data_diario_inf">
                                <label class="font-normal">Data:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_nome">Turno</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_turno"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="input_nome">Contenuto</label>
                            <textarea class="form-control" rows="5" cols='150' id="content_diario_inf"></textarea>
                        </div>
                        
                         <div class="form-group" id="div_new_content_diario_inf" style="display: none">
                            <label for="input_nome">Nuovo Contenuto</label>
                            <textarea class="form-control" rows="5" cols='150' id="new_content_diario_inf"></textarea>
                        </div>
                        <div class="row">
                            <div class="col col-6">
                               <label for="input_nome">Firma IP</label>
                            <textarea class="form-control" rows="5" cols='150' id="firma"></textarea>
                            </div>
                            
                        </div>
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--button type="button" class="btn btn-primary">Save changes</button-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        <button class="btn btn-primary" id="btn_salva_record_diario_inf">Registra</button>
                    </div>
                </div>
            </div>
        </div>
                
                <label id="id_paziente" style="display: none"><?php echo $_GET['id_paziente'] ?></label>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" onclick="openTab(event, 'generaleinf')">Generale</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" onclick="openTab(event, 'bai')">B.A.I</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" onclick="openTab(event, 'ulcere')">Ulcere</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" onclick="openTab(event, 'mnar')" >MNAR</a>
                    </li>
                    
                    
                    <li class="nav-item">
                      <a class="nav-link" onclick="openTab(event, 'vas')">VAS</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" onclick="openTab(event, 'ulcere-diab')">Ulcere diabetiche</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link"    onclick="openTab(event, 'lesioni-cut')">Lesioni cutanee</a>
                    </li>
                    
                     <li class="nav-item">
                      <a class="nav-link" onclick="openTab(event, 'lesioni-decubito')">Lesioni da decubito</a>
                    </li>
                    
                     <li class="nav-item">
                      <a class="nav-link"  onclick="openTab(event, 'interventi')">Interventi</a>
                    </li>
                    
                     <li class="nav-item">
                      <a class="nav-link" onclick="openTab(event, 'diario')" >Diario</a>
                    </li>
                  </ul>
                
                
                 <!-- GENERALE -->
                <div id="generaleinf" class="tabcontent">

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
                        <label><h5>Medico curante: </h5></label><input type="text" id="medico">
                        <label><h5>Tel: </h5></label><input type="text" id="tel_medico">
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

                            <label>PROVENIENZA</label><input type="text" id="provenienza">
                          </div>

                          <div class="row">
                             <label>STANZA N°: </label><input type="text" id="stanza">
                             <label>LETTO N°</label><input type="text" id="letto"
                             <label>TRASFERIMENTI</label><input type="text" id="traferimenti">
                          </div>

                          <div class="row">
                              <div class="form-group">
                                  <label for="comment"><h3>DIAGNOSI:</h3></label>
                                 <textarea class="form-control" rows="5" cols='150' id="diagnosi"></textarea>
                             </div>
                          </div>


                          <div class="row">
                              <div class="form-group">
                                  <label for="comment"><h3>INTOLLERANZE ALIMENTARI</h3></label>
                                 <textarea class="form-control" rows="5" cols='150' id="intoll-alimentari"></textarea>
                             </div>
                          </div>

                          <div class="row">
                              <div class="form-group">
                                  <label for="comment"><h3>ALLERGIE:</h3></label>
                                 <textarea class="form-control" rows="5" cols='150' id="allergie"></textarea>
                             </div>
                          </div>

                          <div class="row">
                              <div class="form-group">
                                  <label for="comment"><h3>INFEZIONI</h3></label>
                                 <textarea class="form-control" rows="5" cols='150' id="infezioni"></textarea>
                             </div>
                          </div>

                          <div class="row">
                              <div class="form-group">
                                  <label for="comment"><h3>TERAPIA IN ATTO:</h3></label>
                                 <textarea class="form-control" rows="5" cols='150' id="terapia-atto"></textarea>
                             </div>
                          </div>



                      <div class="row">
                        <label>CATETERE VESCICALE</label>
                      <div class="form-check form-check-inline">
                        <input name="vescicale" type="radio" value="false">
                        <label for="radio4">NO</label>
                      </div>
                      <div class="form-check form-check-inline" value="true">
                        <input name="vescicale" type="radio">
                        <label for="radio5">SI</label>
                      </div>
                    </div>

                          <div class="row">
                               <div class="form-group" id="input_data_inserimento">
                                <label class="font-normal">Data di inserimento:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                                </div>
                             
                             
                           
                             <label>Calibro</label><input type="text" id="calibro">
                             <label>Diuresi</label><input type="text" id="diuresi">
                          </div>

                     <div class="row">
                        <label>MEZZI DI CONTENZIONE</label>
                      <div class="form-check form-check-inline">
                        <input name="contenzione" type="radio" value="false" >
                        <label for="radio4">NO</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input name="contenzione" type="radio" value="true">
                        <label for="radio5">SI</label>
                      </div>
                    </div>


                           <div class="row">
                             <div class="form-group" id="input_data_dimissione">
                                <label class="font-normal">DIMISSIONIONE:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                                </div>
                                </div>

                          </div>
</div>
                 
                 
                 
                   <!-- VAS -->
                 <div id="bai" class="tabcontent">

                        <label><h3>BISOGNI ASSISTENZIALI INFERMIERISTICI(B.A.I)</h3></label>
                        <br>
                            <label><h3>OSSIGENAZIONE</h3></label>
                         <div class="row">
                             <label>Apparato Respiratorio:</label>
                              <select class="custom-select" id="app_respiratorio_ossig" >
                                                                            <option selected>Seleziona ...</option>
                                                                            <option value="normale">Normale</option>
                                                                            <option value="cianosi">Cianosi</option>
                                                                            <option value="dispneariposo">Dispnea a riposo</option>
                                                                            <option value="dispneasforzo">Dispnea a sforzo</option>
                                                                            <option value="tosse_secca">Tosse secca </option>
                                                                            <option value="tosse_produttiva">Tosse produttiva </option>
                                                                            <option value="o2">O2 Terapia</option>
                                                                          </select>
                         </div>
                            
                            
                           <div class="row">
                             <label>Apparato Circolatorio:</label>
                              <select class="custom-select" id="app_circolatorio_ossig" >
                                                                            <option selected>Seleziona ...</option>
                                                                            <option value="normale">Normale</option>
                                                                            <option value="gonfiori">Gonfiori</option>
                                                                            <option value="estremita_fredde">Estremità fredde</option>
                                                                            <option value="edemi">Edemi</option>
                                                                            <option value="palpitazioni">Palpitazioni </option>
                                                                            <option value="doloti_prec">Doloti precordiali</option>
                                                                            <option value="aritmia">Aritmia</option>
                                                                             <option value="battiti_reg">battiti regolari</option>
                                                                          </select>
                         </div>
                            
                            
                               <label><h3>STATO DI COSCIENZA</h3></label>
                                <div class="row">
                                     <select class="custom-select" id="coscienza" >
                                                                                   <option selected>Seleziona ...</option>
                                                                                   <option value="cosciente">Cosciente</option>
                                                                                   <option value="disorientamento_temp">Disorientamento temporale</option>
                                                                                    <option value="disorientamento_spaz">Disorientamento spaziale</option>
                                                                                   <option value="sonnolenza">Sonnolenza</option>
                                                                                   <option value="coma">Coma</option>
                                                                                 </select>
                                </div>
                               
                               
                               <label><h3>STATO D'ANIMO</h3></label>
                                <div class="row">
                                     <select class="custom-select" id="stato_animo" >
                                                                                   <option selected>Seleziona ...</option>
                                                                                   <option value="tranquillo">Tranquillo</option>
                                                                                   <option value="ansioso">Ansioso</option>
                                                                                    <option value="triste">Triste</option>
                                                                                   <option value="aggressivo">Aggressivo</option>
                                                                                   <option value="euforico">Euforico</option>
                                                                                 </select>
                                </div>
                               
                               
                               <label><h3>MOBILITA'</h3></label>
                                <div class="row">
                                     <select class="custom-select" id="mobilita" >
                                                                                   <option selected>Seleziona ...</option>
                                                                                   <option value="normale">Normale</option>
                                                                                   <option value="bisogno_sostegno">Bisogno di sostegno</option>
                                                                                    <option value="incoordinazione">Incoordinazione</option>
                                                                                   <option value="protesi">Protesi</option>
                                                                                   <option value="ausili">Ausili</option>
                                                                                   
                                                                                    <option value="allettato">Allettato</option>
                                                                                   <option value="posture_libere">Posture libere</option>
                                                                                      <option value="posture_obbligate">Posture obbligate</option>
                                                                                 </select>
                                </div>
                               
                               
                               <label><h3>ELIMINAZIONE</h3></label>
                                <div class="row">
                                     <label>Apparato Urinario:</label>
                                     <select class="custom-select" id="app_urinario" >
                                                                                   <option selected>Seleziona ...</option>
                                                                                   <option value="normale">Normale</option>
                                                                                   <option value="incontinenza">Incontinenza</option>
                                                                                    <option value="incidenti_occasionali">Incidenti occasionali</option>
                                                                                   <option value="ritenzione">Ritenzione</option>
                                                                                   <option value="catet_vescicale">Catetere vescicale</option>
                                                                                   <option value="catet_interm">Catetere Intermitt.</option>                                                                                
                                                                                    <option value="condom">Condom</option>
                                                                                   <option value="pannolone">Pannolone</option>
                                                                                 </select>
                                </div>
                               
                               <div class="row">
                                     <label>Apparato Intestinale:</label>
                                     <select class="custom-select" id="app_intestinale" >
                                                                                   <option selected>Seleziona ...</option>
                                                                                   <option value="regolare">Regolare</option>
                                                                                   <option value="irregolare">Irregolare</option>
                                                                                    <option value="stitichezza">Stitichezza</option>
                                                                                   <option value="diarrea">Diarrea</option>
                                                                                   <option value="incontinenza">Incontinenza</option>
                                                                                    <option value="pannolone">Pannolone</option>
                                                                                   <option value="svuotamenti">Svuotamenti</option>                                                                                
                                                                                    <option value="clismi">Clismi</option>
                                                                                 </select>
                                </div>
                               
                               
                                <div class="row">
                                     <label>Apparato sessuale:</label>
                                     <select class="custom-select" id="app_sessuale" >
                                                                                   <option selected>Seleziona ...</option>
                                                                                   <option value="normale">Normale</option>
                                                                                   <option value="amonorrea">Amonorrea</option>
                                                                                    <option value="dismenorrea">Dismenorrea</option>
                                                                                 </select>
                                </div>
                               
                               
                               <label><h3>STATO CURE E MUCOSE</h3></label>
                                <div class="row">
                                     <select class="custom-select" id="cure_mucose" >
                                                                                   <option selected>Seleziona ...</option>
                                                                                   <option value="integra">Integra</option>
                                                                                   <option value="rosea">Rosea</option>
                                                                                    <option value="pallida">Pallida</option>
                                                                                   <option value="cianotica">Cianotica</option>
                                                                                   <option value="itterica">Itterica</option>
                                                                                   <option value="disidrata">Disidrata</option>                                                                                
                                                                                    <option value="lesioni">Lesioni</option>
                                                                                   <option value="ulcere">Ulcere</option>
                                                                                 </select>
                                </div>

                               
                                <label><h3>IGIENE PERSONALE</h3></label>
                                <div class="row">
                                     <select class="custom-select" id="igiene" >
                                                                                   <option selected>Seleziona ...</option>
                                                                                   <option value="autonomo">Autonomo/a</option>
                                                                                   <option value="supporto_tot">Necessità di supporto totale</option>
                                                                                    <option value="parziale">Necessità di supporto parziale:</option>

                                    </select>
                                    
                                    <input type="text" id="supp_parziale" placeholder="Supporto parziale"> 
                                </div>
                                
                                
                                <label><h3>VESTIZIONE</h3></label>
                                <div class="row">
                                     <select class="custom-select" id="vestizione" >
                                                                                   <option selected>Seleziona ...</option>
                                                                                   <option value="autonomo">Autonomo/a</option>
                                                                                   <option value="supporto_tot">Necessità di supporto totale</option>
                                                                                    <option value="parziale">Necessità di supporto parziale:</option>

                                    </select>
                                    
                                    <input type="text" id="supp_parziale_vest" placeholder="Supporto parziale"> 
                                </div>
                                
                                
                                
                                <label><h3>ALIMENTAZIONE</h3></label>
                                <div class="row">
                                     <select class="custom-select" id="alimentazione" >
                                                                                   <option selected>Seleziona ...</option>
                                                                                   <option value="os_libera">Per os libera</option>
                                                                                   <option value="os_precauzioni">Per os con precauzioni</option>
                                                                                    <option value="sng">Enterale SNG</option>
                                                                                   <option value="peg">Enterale PEG</option>
                                                                                   <option value="cvc">Parenterale CVC</option>
                                                                                   <option value="agocannula">Parenterale agocannula</option>                                                                                
                                                                                 </select>
                                </div>
                                
                                
                                 <label><h3>RIPOSO</h3></label>
                                <div class="row">
                                     <select class="custom-select" id="riposo" >
                                                                                   <option selected>Seleziona ...</option>
                                                                                   <option value="normale">Normale</option>
                                                                                   <option value="insonnia">Insonnia iniziale</option>
                                                                                    <option value="risvegli">Risvegli frequenti</option>
                                                                                   <option value="farmaci">Uso di farmaci</option>                                                                           
                                                                                 </select>
                                </div>
                 </div>
                   
                   
                 <!-- ULCERE -->
                 <div id="ulcere" class="tabcontent">
    
                    <label><h3>VALUTAZIONE RISCHIO ULCERE DA DECUBITO:INDICE DI NORTON</h3></label>

                     <div class="row">
                     <table class="table">
                         <thead>
                           <tr>
                             <th>Condizioni generai</th>
                             <th></th>
                             <th>Stato mentale</th>       
                              <th></th>
                             <th>Deambulazione</th>    
                              <th></th>
                             <th>Mobilità</th>        
                              <th></th>
                             <th>Incontinenza</th>
                             <th></th>
                           </tr>
                         </thead>
                         <tbody>
                           <tr>
                             <td>Buone</td>
                             <td>4</td>
                             <td>Lucido</td>
                             <td>4</td>
                             <td>Normale</td>
                             <td>4</td>
                             <td>Piena</td>
                             <td>4</td>
                             <td>Assente</td>
                             <td>4</td>

                           </tr>
                           <tr>
                             <td>Discrete</td>
                             <td>3</td>
                             <td>Apatico</td>
                             <td>3</td>
                             <td>Cammina con aiuto</td>
                             <td>3</td>
                             <td>Moderatamente limitata</td>
                             <td>3</td>
                             <td>Occasionale</td>
                             <td>3</td>

                           </tr>
                            <tr>
                             <td>Scadenti</td>
                             <td>2</td>
                             <td>Confuso</td>
                             <td>2</td>
                             <td>Costretto su sedia</td>
                             <td>2</td>
                             <td>Molto limitata</td>
                             <td>2</td>
                             <td>urinaria</td>
                             <td>2</td>

                           </tr>

                            <tr>
                             <td>Pessime</td>
                             <td>1</td>
                             <td>Soporoso</td>
                             <td>1</td>
                             <td>Costretto a letto</td>
                             <td>1</td>
                             <td>Immobile</td>
                             <td>1</td>
                             <td>Doppia</td>
                             <td>1</td>

                           </tr>
                         </tbody>
                       </table>
                     </div>
       
 
                  <div class="row">
                        <label>Interpretazione del punteggio</label> 
                        <label>20 - 15 rischio assente</label>
                        <input name="rischio" type="radio" value="assente" >
                       <label>14 - 13 rischio lieve</label>
                        <input name="rischio" type="radio" value="lieve">
                        <label>12 - 5 rischio elevato</label>
                        <input name="rischio" type="radio" value="elevato">
                        

                  </div>

                    <div class="row">
                         <label>Tot</label><input type="text" id="tot">
                </div>
    
    
   
</div>
                 
                  <!-- MNAR -->
                 <div id="mnar" class="tabcontent">

                       <div class="row">
                        <label><h3>Mini Nutritional Assessment(MNAR)</h3></label>
                          <label>Peso Kg</label><input type="text" id="peso">
                        <label>Statura cm</label><input type="text" id="statura">
                       </div>

                        <div class="row">
                             <label><h3>A) Presenta una perdita dell'appetito?Ha mangiato meno negli ultimi 3 mesi?(perdita d'appetito,problemi digestivi,difficolotà di masticazione o deglutizione)</h3></label>
                        <table class="table">        
                            <tbody>
                              <tr>
                                <td>
                                    <div class="row">
                                        <p>0 = Grave riduzione dell'assunzione di cibo<br>
                                            1 = Moderata riduzione dell'assunzione di cibo<br>
                                            2 = Nessuna riduzione dell'assunzione di cibo</p>
                                    </div>
                                </td>
                                <td><label>Punteggio</label><input type="text" id="punteggioA"></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>


                        <div class="row">
                             <label><h3>B) Perdita di peso recente(< 3 mesi) </h3></label>
                        <table class="table">        
                            <tbody>
                              <tr>
                                <td>
                                    <div class="row">
                                         <p>0 = perdita di peso > 3<br>
                                             1 = non sa <br>
                                             2 = perdita di peso tra 1 e 3 Kg<br>
                                             3 = nessuna perdita di peso</p>
                                    </div>
                                </td>
                                <td><label>Punteggio</label><input type="text" id="punteggioB"></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>


                        <div class="row">
                             <label><h3>C) Motricità </h3></label>
                        <table class="table">        
                            <tbody>
                              <tr>
                                <td>
                                    <div class="row">
                                         <p>0 = dal letto alla poltrona<br>
                                             1 = autonomo a domicilio <br>
                                             2 = esce di casa</p>
                                    </div>
                                </td>
                                <td><label>Punteggio</label><input type="text" id="punteggioC"></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>


                         <div class="row">
                             <label><h3>D) Nell'arco degli utlimi 3 mesi:malattie acute o stress psicologici? </h3></label>
                        <table class="table">        
                            <tbody>
                              <tr>
                                <td>
                                    <div class="row">
                                         <label>0 = si 2 = no</label>
                                    </div>
                                </td>
                                <td><label>Punteggio</label><input type="text" id="punteggioD"></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>


                         <div class="row">
                             <label><h3>E) Problemi neuropsicologici </h3></label>
                        <table class="table">        
                            <tbody>
                              <tr>
                                <td>
                                    <div class="row">
                                         <p>0 = demenza o depressione grave<br>
                                             1 = demenza moderata <br>
                                             2 = nessun problema psicologico</p>
                                    </div>
                                </td>
                                <td><label>Punteggio</label><input type="text" id="punteggioE"></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>

                          <div class="row">
                             <label><h3>F1) Indice di massa corporea (IMC = peso/(altezza)2 in Kg/m2) </h3></label>
                        <table class="table">        
                            <tbody>
                              <tr>
                                <td>
                                    <div class="row">
                                         <p>0 = IMC < 19<br>
                                             1 = 19< IMC < 21 <br>
                                             2 = 21 < IMC < 23<br>
                                             2 = IMC > 23</p>
                                    </div>
                                </td>
                                <td><label>Punteggio</label><input type="text" id="punteggioF1"></td>
                              </tr>
                            </tbody>
                          </table>

                         <label>SE L'IMC NON E' DISPONIBILE,SOSTITUIRE LA DOMANDA F1 CON LA DOMANDA F2.NON RISPONDERE ALLA DOMANDA F2 SE LA DOMANDA F1 E' GIA' STATA COMPLETATA.</label>

                        </div>


                         <div class="row">
                             <label><h3>F2) Circonferenza del polpaccio(CP in cm) </h3></label>
                        <table class="table">        
                            <tbody>
                              <tr>
                                <td>
                                    <div class="row">
                                         <p>0 = CP inferiore a 31<br>
                                             3 = CP 31 o superiore </p>
                                    </div>
                                </td>
                                <td><label>Punteggio</label><input type="text" id="punteggioF2"></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>


                           <div class="row">
                             <label><h3>Valutazione di screening(max 14 punti)</h3></label>
                        <table class="table">        
                            <tbody>
                              <tr>
                                <td>
                                    <div class="row">
                                         <p>12-14 punti: stato nutrizionale normale<br>
                                             8-11 punti: a rischio di malnutrizione<br>
                                             0-714 punti: malnutrito</p>
                                    </div>
                                </td>
                                <td><label>Tot</label><input type="text" id="screening"></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>

    
    
   
</div>
                
                  <!-- VAS -->
                 <div id="vas" class="tabcontent">

                        <label><h3>SCALA VALUTAZONE DEL DOLORE VAS(Visual Analogic Scale)</h3></label>

                         <div class="row">
                             <label>Indicare qual'è la quantità di dolore che si sta sperimentando partendo da 0 (nessun dolore) a 10 (massimo dolore)</label>
                              <select class="custom-select" id="liv_dolore" >
                                                                            <option selected>Seleziona ...</option>
                                                                            <option value="0 - 1">0 - 1 </option>
                                                                            <option value="1 - 2">1 - 2 </option>
                                                                            <option value="2 - 3">2 - 3 </option>
                                                                            
                                                                            <option value="3 - 4">3 - 4 </option>
                                                                            <option value="4 - 5">4 - 5 </option>
                                                                            <option value="5 - 6">5 - 6 </option>
                                                                            
                                                                            <option value="6 - 7">6 - 7 </option>
                                                                            <option value="7 -8">7 -8 </option>
                                                                            <option value="8 - 9">8 - 9 </option>
                                                                            <option value="9 - 10">9 - 10 </option>
                                                                          </select>
                         </div>

                 </div>
                  
                  <!-- ULCERE DIABETICHE -->
                  <div id="ulcere-diab" class="tabcontent">

                        <label><h3>SCALA VALUTAZONE DULCERE DIABETICHE</h3></label>

                         <div class="row">
                             <label>Descrizione</label>
                              <textarea class="form-control" rows="5" cols='150' id="descrizione_ulc_diab"></textarea>
                         </div>
                        
                        
                        <label>Il Sistema di Classificazione per il Piede secondo la Texas University</label>
       
                                <div class="row">
                                <table class="table">
                                    <thead>
                                      <tr>
                                        <th>Stadio/Grado</th>
                                        <th>0</th>       
                                         <th>1</th>
                                        <th>2</th>    
                                         <th>3</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>A</td>
                                        <td>Lesione pre o post ulcerativa completamente riepitelizzata</td>
                                        <td>Ulcera superficiale tendini o capsule</td>
                                        <td>Ulcera penetrante osso e articolazioni</td>
                                        <td>Ulcera penetrante</td>
                                      </tr>
                                      <tr>
                                        <td>B</td>
                                        <td>Con infezione</td>
                                       <td>Con infezione</td>
                                       <td>Con infezione</td>
                                       <td>Con infezione</td>
                                        
                                      </tr>
                                       <tr>
                                        <td>C</td>
                                        <td>Con ischemia</td>
                                        <td>Con ischemia</td>
                                        <td>Con ischemia</td>
                                        <td>Con ischemia</td>
                                      
                                      </tr>

                                       <tr>
                                        <td>D</td>
                                        <td>Con infezione ed ischemia</td>
                                        <td>Con infezione ed ischemia</td>
                                       <td>Con infezione ed ischemia</td>
                                        <td>Con infezione ed ischemia</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                        
                        <div class="row">
                            <label>Valutazione: </label><input type="text" id="valutazione" placeholder="  /  ">
                        </div>
                        
                         <div class="row">
                             <label>Conclusione</label>
                              <textarea class="form-control" rows="5" cols='150' id="conclusione"></textarea>
                         </div>

                 </div>
                  
                  
                  <!-- LESIONI CUTANEE -->
                  <div id="lesioni-cut" class="tabcontent">

                        <label><h3>SCALA VALUTAZONE DELLE LESIONI CUTANEE</h3></label>
                        
                        
                        <label>STADIAZIONE</label>
                            <div class="row">
                                <input type="checkbox" id="stadioI"> Stadio I arrossamento della cute intatta,eritema irreversibile
                            </div>
                         <div class="row">
                                    <input type="checkbox" id="stadioII"> Stadio II lesione superficiale,abrasione,flittene,lieve cavità
                         </div>
                         <div class="row">
                                    <input type="checkbox" id="stadioIII"> Stadio III profonda cavità nel tessuno sottocutaneo con estensione fino alla fascia muscolare
                         </div>
                         <div class="row">
                                    <input type="checkbox" id="stadioIV"> Stadio IV profonda cavità con interessamento di muscoli,ossa,tendini,articolazioni
                         </div>
                                    
                                    <label>Varianti: </label>
                                    <input type="checkbox" id="escara" > Escara 
                                    <input type="checkbox"  id="emoraggia"> Emoraggia
                                     <input type="checkbox" id="essudativa"> Essudativa
                                    <input type="checkbox" id="necrotica"> Necrotica 
                                    <input type="checkbox" id="fibrinosa"> Fibrinosa
                                    <input type="checkbox" id="cavitaria"> Cavitaria 
                                    <input type="checkbox" id="granulleggiante"> Granulleggiante
                                    <input type="checkbox" id="infetta"> Infetta 
                                    
                                    
                                    
                                    <h4>SEDE E GRADO:</h4>
                                    
                                     <div class="row">
                                        <table class="table">
                                            <tbody>
                                              <tr>
                                                <td>OCCIPITE</td>
                                                <td>
                                                    <select class="custom-select" id="occipite" aria-label="Example select with button addon">
                                                                                <option selected>Seleziona ...</option>
                                                                                <option value="1">I</option>
                                                                                <option value="2">II</option>
                                                                                <option value="3">III</option>
                                                                                <option value="4">IV</option>
                                                                                 <option value="4">E</option>
                                                                              </select>
                                                </td>

                                              </tr>
                                              
                                              <tr>
                                                <td>STERNO</td>
                                                <td>
                                                    <select class="custom-select" id="sterno" aria-label="Example select with button addon">
                                                                                <option selected>Seleziona ...</option>
                                                                                <option value="1">I</option>
                                                                                <option value="2">II</option>
                                                                                <option value="3">III</option>
                                                                                <option value="4">IV</option>
                                                                                 <option value="4">E</option>
                                                                              </select>
                                                </td>

                                              </tr>
                                              
                                              <tr>
                                                <td>PROMINENZE VERTEBRALI</td>
                                                <td>
                                                    <select class="custom-select" id="prominenze" aria-label="Example select with button addon">
                                                                                <option selected>Seleziona ...</option>
                                                                                <option value="1">I</option>
                                                                                <option value="2">II</option>
                                                                                <option value="3">III</option>
                                                                                <option value="4">IV</option>
                                                                                 <option value="4">E</option>
                                                                              </select>
                                                </td>

                                              </tr>
                                              
                                              <tr>
                                                <td>SACRO</td>
                                                <td>
                                                    <select class="custom-select" id="sacro" aria-label="Example select with button addon">
                                                                                <option selected>Seleziona ...</option>
                                                                                <option value="1">I</option>
                                                                                <option value="2">II</option>
                                                                                <option value="3">III</option>
                                                                                <option value="4">IV</option>
                                                                                 <option value="4">E</option>
                                                                              </select>
                                                </td>

                                              </tr>
                                              
                                              <tr>
                                                <td>PUBE</td>
                                                <td>
                                                    <select class="custom-select" id="pube" aria-label="Example select with button addon">
                                                                                <option selected>Seleziona ...</option>
                                                                                <option value="I">I</option>
                                                                                <option value="II">II</option>
                                                                                <option value="III">III</option>
                                                                                <option value="IV">IV</option>
                                                                                 <option value="E">E</option>
                                                                              </select>
                                                </td>

                                              </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="row">
                                       <table class="table">
                                           <thead>
                                               <tr>
                                                   <td></td>
                                                   <td>DX</td>
                                                   <td>SX</td>
                                                   <td>GRADO</td>
                                               </tr>
                                           </thead>
                                        <tbody>
                                          <tr>
                                            <td>ORECCHIO</td>
                                             <td>
                                                <input type="checkbox" value="dx_orecchio"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_orecchio">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-orecchio" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                          
                                          
                                          <tr>
                                            <td>ZIGOMI</td>
                                             <td>
                                                <input type="checkbox" value="dx_zigomi"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_zigomi">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-zigomi" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                          
                                          
                                          
                                          <tr>
                                            <td>CLAVICOLE</td>
                                             <td>
                                                <input type="checkbox" value="dx_clavicole"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_clavicole">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-clavicole" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                          
                                          
                                          
                                          <tr>
                                            <td>SPALLA</td>
                                             <td>
                                                <input type="checkbox" value="dx_spalla"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_spalla">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-spalla" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                          
                                          
                                          
                                          
                                          <tr>
                                            <td>SCAPOLE</td>
                                             <td>
                                                <input type="checkbox" value="dx_scapole"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_scapole">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-scapole" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                          
                                          
                                          
                                          
                                          
                                          <tr>
                                            <td>COSTATO</td>
                                             <td>
                                                <input type="checkbox" value="dx_costato"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_costato">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-costato" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                          
                                          
                                          
                                          
                                          <tr>
                                            <td>CRESTE ILIACHE</td>
                                             <td>
                                                <input type="checkbox" value="dx_creste"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_creste">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-creste" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                          
                                          
                                           <tr>
                                            <td>TROCANTIERI</td>
                                             <td>
                                                <input type="checkbox" value="dx_trocantieri"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_trocantieri">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-trocantieri" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                          
                                          
                                          
                                           <tr>
                                            <td>PROMINENZE ISCHIATRICHE</td>
                                             <td>
                                                <input type="checkbox" value="dx_prominenze"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_prominenze">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-prominenze" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                          
                                          
                                           <tr>
                                            <td>GINOCCHIO</td>
                                             <td>
                                                <input type="checkbox" value="dx_ginocchio"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_ginocchio">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-ginocchio" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                          
                                           <tr>
                                            <td>MALLEOLI TIBIALI MEDIALI</td>
                                             <td>
                                                <input type="checkbox" value="dx_tibia_med"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_tibia_med">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-tibia_med" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                          
                                          <tr>
                                            <td>MALLEOLI TIBIALI LATERALI</td>
                                             <td>
                                                <input type="checkbox" value="dx_tibia_lat"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_tibia_lat">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-tibia_lat" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                          
                                           <tr>
                                            <td>DORSO PIEDE</td>
                                             <td>
                                                <input type="checkbox" value="dx_piede"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_piede">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-piede" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                           <tr>
                                            <td>TALLONI</td>
                                             <td>
                                                <input type="checkbox" value="dx_talloni"> 
                                            </td>
                                             <td>
                                                 <input type="checkbox" value="sx_talloni">  
                                            </td>
                                            <td>
                                                <select class="custom-select" id="grado-talloni" aria-label="Example select with button addon">
                                                                           <option selected>Seleziona ...</option>
                                                                                <option value="I">I Variante</option>
                                                                                <option value="II">II Variante</option>
                                                                                <option value="III">III Variante</option>
                                                                                <option value="IV">IV Variante</option>
                                                                                 <option value="E">E Variante</option>
                                                                          </select>
                                            </td>

                                          </tr>
                                          
                                          
                                        </tbody>
                                      </table>
                                    </div>
                                    
                                    
                                    <label>DESCRIZIONE</label>
                                    <textarea id="descrizione-les-cutanee"></textarea>
                   </div>
                   <!-- LESIONI DECUBITO -->
                  <div id="lesioni-decubito" class="tabcontent">


                        <label><h3>PROTOCOLLO MEDICAZIONE INIZIALE LESIONI DA DECUBITO</h3></label>

                        <div class="row">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th>STADIO</th>
                                            <th>DETERSIONE</th>       
                                             <th>MEDICAZIONE</th>
                                            <th>CADENZA</th>   
                                            <th>AREA CIRCOSTANTE</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td>I-II</td>
                                            <td>
                                                Soluzione fisiologica o Ringer Lattato
                                            </td>
                                            <td>
                                                <select class="custom-select" id="medicazioneI-II" aria-label="Example select with button addon">
                                                                            <option selected>Seleziona ...</option>
                                                                            <option value="1">Pellicola semipermeabile trasparente di poliuretano(I)</option>
                                                                            <option value="2">Idrocolloidi ultrasottili(I-II)</option>
                                                                            <option value="3">Schiuma di pliuretano(II)</option>
                                                                          </select>
                                            </td>
                                            <td>
                                                1 volta alla settimana oppure SO
                                            </td>

                                            <td>
                                                Crema base o emolliente all'acqua o allo zinco
                                            </td>
                                          </tr>
                                          
                                          <tr>
                                            <td>FLITTENE</td>
                                            <td>
                                                Idem
                                            </td>
                                            <td>
                                                <select class="custom-select" id="medicazione_flittene" aria-label="Example select with button addon">
                                                                            <option selected>Seleziona ...</option>
                                                                            <option value="1">Forare senza rimuovere il tetto</option>
                                                                            <option value="3">Schiuma di pliuretano</option>
                                                                          </select>
                                            </td>
                                            <td>
                                                1 volta alla settimana oppure SO
                                            </td>

                                            <td>
                                                Idem
                                            </td>
                                          </tr>
                                          
                                           <tr>
                                            <td>III-IV</td>
                                            <td>
                                                Idem
                                            </td>
                                            <td>
                                                Vedi specifiche
                                            </td>
                                            <td>
                                              
                                            </td>

                                            <td>
                                                Idem
                                            </td>
                                          </tr>

                                        
                                        </tbody>
                                      </table>
                                    </div>

                        
                         <label><h3>SPECIFICHE</h3></label>

                        <div class="row">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th>VARIANTE LESIONE</th>     
                                             <th>MEDICAZIONE</th>
                                            <th>CADENZA</th>   
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td>Escara</td>
                                            <td>
                                                <select class="custom-select" id="medicazione_escara" aria-label="Example select with button addon">
                                                                            <option selected>Seleziona ...</option>
                                                                            <option value="1">Pomate enzimatiche + garze</option>
                                                                            <option value="2">Idrogeli + schiuma pliuretano</option>
                                                                            <option value="3">Rimozione chirurgica graduale</option>
                                                                             <option value="4">Rimozione chirurgica totale</option>
                                                                          </select>
                                            </td>
                                            <td>
                                                Ogni 24-72 ore Rinnovo pomate enzimatiche ogni 8 ore
                                            </td>

                                          </tr>
                                          
                                          
                                          
                                          <tr>
                                            <td>Emorragica</td>
                                            <td>
                                                <select class="custom-select" id="medicazione_emorragica" aria-label="Example select with button addon">
                                                                            <option selected>Seleziona ...</option>
                                                                            <option value="1">Alginati + garze sterili</option>
                                                                          </select>
                                            </td>
                                            <td>
                                                Ogni 8-24 ore 
                                            </td>

                                          </tr>
                                          
                                           <tr>
                                            <td>Essudativa/Necrotica/Fibrinosa</td>
                                            <td>
                                                <select class="custom-select" id="medicazione_essudativa" aria-label="Example select with button addon">
                                                                            <option selected>Seleziona ...</option>
                                                                            <option value="1">Idrogeli + schiuma di poliuretano o placca idrocolloidale</option>
                                                                             <option value="1">fibra idrocolloidale + placca </option>
                                                                          </select>
                                            </td>
                                            <td>
                                                Ogni 24-72 ore 
                                            </td>

                                          </tr>
                                          
                                          
                                           <tr>
                                            <td>Cavitaria e/o con abbondante essudato</td>
                                            <td>
                                                <select class="custom-select" id="medicazione_cavitaria" aria-label="Example select with button addon">
                                                                            <option selected>Seleziona ...</option>
                                                                            <option value="1">tampone schiuma di poliuretano + schiuma di poliuretano</option>
                                                                             <option value="1">fibra idrocolloidale + placca </option>
                                                                          </select>
                                            </td>
                                            <td>
                                                Da giorni alterni a ogni 3 giorni
                                            </td>

                                          </tr>
                                          
                                          <tr>
                                            <td>Granuleggiante</td>
                                            <td>
                                                <select class="custom-select" id="medicazione_granullegiante" aria-label="Example select with button addon">
                                                                            <option selected>Seleziona ...</option>
                                                                            <option value="1">schiuma di poliuretano</option>
                                                                             <option value="1">placca idrocolloidale</option>
                                                                          </select>
                                            </td>
                                            <td>
                                                1 volta alla settimana o SO
                                            </td>

                                          </tr>
                                          
                                          <tr>
                                            <td>Infetta</td>
                                            <td>
                                                <select class="custom-select" id="medicazione_infetta" aria-label="Example select with button addon">
                                                                            <option selected>Seleziona ...</option>
                                                                            <option value="1">fibra idrocolloidale + garza(Evitare l'occlusione)</option>
                                                                          </select>
                                            </td>
                                            <td>
                                                Ogni 24 ore
                                            </td>

                                          </tr>
                                          
                                          
                                          
                                        </tbody>
                                      </table>
                        </div>
                  
                  
                        
                        
                        

                 </div>
                   
                   <!-- INTERVENTI -->
                  <div id="interventi" class="tabcontent">


                        <label><h3>SCHEDA PIANIFICAZIONE INTERVENTI</h3></label>

                        <div class="row">
                                    <table class="table" id="tab_interventi">
                                        <thead>
                                          <tr>
                                            <th>Data</th>
                                            <th>Diagnosi Infermieristica</th>       
                                             <th>Obiettivi</th>
                                            <th>Intervento</th>   
                                            <th>Valutazione/Firma</th>
                                            <th></th>
                                          </tr>
                                        </thead>
                                        <tbody></tbody>
                                      </table>
                                    </div>

                        
                        
                  
                  
                        
                        
                        

                 </div>
                   
                    <!-- DIARIO -->
                  <div id="diario" class="tabcontent">


                        <div class="row">
                                    <table class="table" id="tab_diario_inf">
                                        <thead>
                                          <tr>
                                            <th>Data</th>
                                            <th>Turno</th>       
                                             <th>Diario Infermieristico</th>
                                            <th>Firma IP</th> 
                                             <th></th> 
                                          </tr>
                                        </thead>
                                        <tbody> </tbody>
                                      </table>
                                    </div>

                        
                        
                  
                  
                        
                        
                        

                 </div>
                        
                        
                        
                       </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="btn_save_tab_med"> SALVA</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
  
        
        <div class="container">
           <div class="row">
                <div class="col-sm-6">
                    <h3><b>AREA FISIOTERAPICA/RIABILITATIVA</b></h3>
                </div>
               
            </div>
            

            <p>CFR = Cartella fisioterapica/riabilitativa</p>
            
            
            
           
            
    
            
            <div class="table-responsive">
                   <table class="table table-striped table-bordered table-hover dataTables-lista_anagrafiche">
              
                        <thead>
                        <tr>
                            <th>Cognome</th>
                            <th>Nome</th>                                   
                            <th>Data di nascita</th>                         
                            <th>Indirizzo</th>
                            <th>Località</th>                                   
                            <th>Provincia</th>
                            <th></th>
                            
                        </tr>
                        </thead>
              </table>
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

    <script src="js/plugins/dataTables/datatables.min.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
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
    
    

</body>

<script>
                
 $(document).ready(function(){
                       
        aggiornaListaAnagraficheAreaSocioPS(2);
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



</html>