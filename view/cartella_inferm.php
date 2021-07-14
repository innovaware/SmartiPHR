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
                      <a class="nav-link active" onclick="openTab(event, 'generale')">Generale</a>
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

                  
                  <button class="btn btn-primary" id="btn_save_tab_inf"> SALVA</button>

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
    function openTab(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("nav-link");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      if(evt != null)
        evt.currentTarget.className += " active";
      else
        tablinks[0].className+= " active";
    }
    
    
    
    
    $(document).ready(function(){
        
        openTab(null, 'generale');
        
        getDatiPanelInfermAnagrafica();
        
        getListaRowsDiarioInf();
        
        getListaRowsInterventi();
        
        $('#input_data_nascita .input-group.date').datepicker({
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



       $('#input_data_inserimento .input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                });


        $('#input_data_dimissione .input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                });
                
                
                
                
         $('#input_data_diario_inf .input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                });


        $('#input_data_interv .input-group.date').datepicker({
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