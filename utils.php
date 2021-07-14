<?php
$anno_corrente = date('Y');
define('ANNO_CORRENTE', $anno_corrente);
define('EURO', chr(128));



define('WEB_SERVER_HOST', 'localhost');

define('NOME_DITTA', 'SmartiPHR');

define('APPLICATIVO', 'SmartiPHR');

function getPageTitle() {
    return '<title>' . NOME_DITTA . '</title>';
}


// MODAL NUOVO MESS
function getModalNuovomessaggio(){
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $str="";
    // LISTA UTENTI
    $query = " select * from z_utentiweb order by cognome, nome ";

    $res_dipendenti = mysqli_query($mysqli, $query);
    $str_select_utente = '<select multiple="multiple" class="custom-select" id="sel_utente">
                            <option value="0" selected>Seleziona ...</option>';
            
    while ($row = mysqli_fetch_array($res_dipendenti)) {
       $str_select_utente.='<option value="'.$row['id_utente'].'">'.$row['nome'] .' ' . $row['cognome'].'</option>';
       
    }
        $str_select_utente.='</select>';
      
        
    // LISTA TIPOLOGIE UTENTI
    $query_tip = " select * from z_tipo_utente";

    $res_tip = mysqli_query($mysqli, $query_tip);
    $str_select_tip = '<select multiple="multiple" class="custom-select" id="sel_tip">
                            <option value="0" selected>Seleziona ...</option>';
            
    while ($row = mysqli_fetch_array($res_tip)) {
       $str_select_tip.='<option value="'.$row['id'].'">'.$row['descrizione'] .'</option>';
       
    }
        $str_select_tip.='</select>';
    
    $str='<div id="modal_inserisci_nuovo_mess" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuova Messaggio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="input_nome">Testo</label>
                            <textarea class="form-control" rows="5" cols="150" id="content_mess"></textarea>
                        </div>                                       
                        <div class="form-group" id="div_new_content">
                            <label for="input_nome">Seleziona Utente</label>'
                            .$str_select_utente.
                        '</div>
                            
                        <div class="form-group" id="div_new_content">
                            <label for="input_nome">Seleziona Tipologia</label>'
                            .$str_select_tip.
                        '</div>                  
                        
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--button type="button" class="btn btn-primary">Save changes</button-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        <button class="btn btn-primary" id="btn_invia_mess" data-sfx="">Invia</button>
                    </div>
                </div>
            </div>
        </div>';
    
    mysqli_close($mysqli);
    return $str;
}



function getnewNavBar(){
    $str='<div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Cerca qualcosa..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
              <li>
                    <a TITLE="Nuovo Messaggio"   class="btnAddMess"> Nuovo Messaggio</a>
                </li>
                <li>
                    <span class="m-r-sm text-muted welcome-message">Benvenuto in SmartiPHR</span>
                </li>
                <li>
                    <a id="btn_logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>

        </nav>
        </div>';
    
    return $str;
}

function getSideBar() {
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " SELECT descrizione FROM z_tipo_utente where id = ".$_SESSION["id_dip"];
    //echo $query;
    $result_first = mysqli_query($mysqli, $query);
    $descr="";
    $str="";
    while ($row = mysqli_fetch_array($result_first)) {
        $descr = $row['descrizione'];
    }
    
    $str='<nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                         <a class="navbar-brand" href="/SmartiPHR/">
                            <img src="/'.$_SESSION['application'].'/img/android-icon-36x36_1.png" width="35" height="3" class="d-inline-block align-top" alt="">
                        </a>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold">'.$_SESSION['nome'] . ' ' . $_SESSION['cognome'].'</span>
                            <span class="text-muted text-xs block">'.$descr.'<b class="caret"></b></span>
                        </a>

                    </div>
                </li>
                <li>
                    <a href="/SmartiPHR/home"><i class="fa fa-diamond"></i> <span class="nav-label">Home</span></a>
                </li>
                <li class="active">
                   '. getMenuDinamico().'
                </li>
                

        </div>
    </nav>';
	
    
    mysqli_close($mysqli);
    return $str;
    
}

function getFavicon() {
    ?>
    <link rel="apple-touch-icon" sizes="57x57" href="/<?php echo APPLICATIVO; ?>/img/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/<?php echo APPLICATIVO; ?>/img/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/<?php echo APPLICATIVO; ?>/img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/<?php echo APPLICATIVO; ?>/img/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/<?php echo APPLICATIVO; ?>/img/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/<?php echo APPLICATIVO; ?>/img/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/<?php echo APPLICATIVO; ?>/img/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/<?php echo APPLICATIVO; ?>/img/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/<?php echo APPLICATIVO; ?>/img/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/<?php echo APPLICATIVO; ?>/img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/<?php echo APPLICATIVO; ?>/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/<?php echo APPLICATIVO; ?>/img/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/<?php echo APPLICATIVO; ?>/img/favicon-16x16.png">
    <link rel="manifest" href="/<?php echo APPLICATIVO; ?>/img/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/<?php echo APPLICATIVO; ?>/img/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <?php
}

function arrotonda($valore) {
    return number_format($valore, 2, ',', '.');
}

function arrotondaconCifre($valore, $cifre) {
    return number_format($valore, $cifre, ',', '.');
}

function arrotonda2Int($valore) {
    return number_format($valore);
}

function arrotondaColore($symbol, $valore) {
    if ($valore < 0)
        return '<div style="color:red;text-align:right"><b>' . $symbol . ' ' . number_format($valore, 2, ',', '.') . '</b></div>';
    else
        return '<div style="text-align:right"><b>' . $symbol . ' ' . number_format($valore, 2, ',', '.') . '</b></div>';
}

function coloreInt($symbol, $valore) {
    if ($valore < 0)
        return '<div style="color:red"><b>' . $symbol . ' ' . $valore . '</b></div>';
    else
        return '<div ><b>' . $symbol . ' ' . $valore . '</b></div>';
}

function colore($symbol, $valore) {
    if ($valore < 0)
        return '<div style="color:red;text-align:right"><b>' . $symbol . ' ' . $valore . '</b></div>';
    else
        return '<div style="text-align:right"><b>' . $symbol . ' ' . $valore . '</b></div>';
}

function g($valore) {
    return '<b>' . $valore . '</b>';
}

function dataIt2DB($dataIt) {
    $originalDate = substr($dataIt, -4, 4) . "-" . substr($dataIt, 3, 2) . "-" . substr($dataIt, 0, 2);
    $americanDate = date("Y-m-d", strtotime($originalDate));
    return $americanDate;
}

function replaceAccenti($stringa) {
    $res_string = str_replace('è', 'e', $stringa);
    $res_string = str_replace('é', 'e', $res_string);
    $res_string = str_replace('à', 'a', $res_string);
    $res_string = str_replace('ò', 'o', $res_string);
    $res_string = str_replace('ì', 'i', $res_string);
    $res_string = str_replace('ù', 'u', $res_string);
    return $res_string;
}

function dataEn2It($dataEn) {
    $date = new DateTime($dataEn);
    return $date->format('d-m-Y');
}

function dataIt2En($dataEn) {
    $date = new DateTime($dataEn);
    return $date->format('Y-m-d');
}

function dataEn2Day($dataEn) {
    $date = new DateTime($dataEn);
    return $date->format('d');
}

function dateEn2Month($dataEn) {
    $date = new DateTime($dataEn);
    return $date->format('m');
}

function dataForDB($data) {
    $originalDate = $data;
    $americanDate = date("Y-m-d", strtotime($originalDate));
    $dataAttuale = date("Y-m-d");
    return $dataAttuale;
}

function formattaValuta($valuta) {
    return number_format($valuta, 2, ',', '.');
}

function formattaValutaConE($valuta) {
    return '<span >€ ' . number_format($valuta, 2, ',', '.').'<span>';
}

function retrieveNumeroSettimanaOggi() {
    return date("W") - date("W", strtotime(date("Y-m-01", time()))) + 1;
}

function retrieveNumeroSettimana($giorno) {
    $datagiorno = strtotime($giorno);
    return date("W", $datagiorno) - date("W", strtotime(date("Y-m-01", time()))) + 1;
}

function DayWeekIT($date) {
    //Eseguo l'explode perchè mktime ha bisogno di ricere i parametri in un 
    //determinato modo
    list($yyyy, $mm, $dd) = explode('-', $date);
    //Tramite questa istruzione ricavo il numero del giorno della settimana
    $numbrdayweek = date("w", mktime(0, 0, 0, $mm, $dd, $yyyy));
    $days = array("Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì",
        "Venerdì", "Sabato");
    $nameday = $days[$numbrdayweek];
    return $nameday;
}

function LastDayOfThisMonth($a_date) {
    return date("Y-m-t", strtotime($a_date));
}

function aggiornaNumeroSettimane() {
    $mese = $_POST['mese_selezionato'];
    $data = '2015-' . mese_selezionato . '-01';
    $data = "now()";
    retrieveNumeroSettimana(LastMonthOfthisMonth($data));
}

// to delete
function build_calendar($month, $year, $dateArray) {

    // Create array containing abbreviations of days of week.
    $daysOfWeek = array('D', 'L', 'M', 'M', 'G', 'V', 'S');

    // What is the first day of the month in question?
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

    // How many days does this month contain?
    $numberDays = date('t', $firstDayOfMonth);

    // Retrieve some information about the first day of the
    // month in question.
    $dateComponents = getdate($firstDayOfMonth);

    // What is the name of the month in question?
    $monthName = $dateComponents['month'];

    // What is the index value (0-6) of the first day of the
    // month in question.
    $dayOfWeek = $dateComponents['wday'];

    // Create the table tag opener and day headers

    $calendar = "<table class='calendar'>";
    $calendar .= "<caption>$monthName $year</caption>";
    $calendar .= "<tr>";

    // Create the calendar headers

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }

    // Create the rest of the calendar
    // Initiate the day counter, starting with the 1st.

    $currentDay = 1;

    $calendar .= "</tr><tr>";

    // The variable $dayOfWeek is used to
    // ensure that the calendar
    // display consists of exactly 7 columns.

    if ($dayOfWeek > 0) {
        $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {

        // Seventh column (Saturday) reached. Start a new row.

        if ($dayOfWeek == 7) {

            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);

        $date = "$year-$month-$currentDayRel";

        $calendar .= "<td class='day' rel='$date'>$currentDay</td>";

        // Increment counters

        $currentDay++;
        $dayOfWeek++;
    }



    // Complete the row of the last week in month, if necessary

    if ($dayOfWeek != 7) {

        $remainingDays = 7 - $dayOfWeek;
        $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
    }

    $calendar .= "</tr>";

    $calendar .= "</table>";

    return $calendar;
}

function giornoData($g, $m, $a) {
    $gShort = array('Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab');
    $ts = mktime(0, 0, 0, $m, $g, $a);
    $gd = getdate($ts);

    return $gShort[$gd['wday']];
}

function giornoDataIndice($g, $m, $a) {
    $gShort = array('Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab');
    $ts = mktime(0, 0, 0, $m, $g, $a);
    $gd = getdate($ts);
    return $gd['wday']; //ritorna l’indice del giorno compreso tra 0 e 6
}

function array2SqlCondition($elementi) {
    $result = "";
    foreach ($elementi as $elemento) {
        $result .= "'" . $elemento . "',";
    }
    return substr($result, 0, -1);
}

function getDateFromTimestampDB($DbRow) {
    $timestamp = strtotime($DbRow);
    $date = date('d-m-Y', $timestamp);
    $time = date('Gi.s', $timestamp);
    return $date;
}

function delta_tempo($data_iniziale, $data_finale, $unita) {

    $data1 = strtotime($data_iniziale);
    $data2 = strtotime($data_finale);

    switch ($unita) {
        case "m": $unita = 1 / 60;
            break;   //MINUTI
        case "h": $unita = 1;
            break;    //ORE
        case "g": $unita = 24;
            break;   //GIORNI
        case "a": $unita = 8760;
            break;         //ANNI
    }

    $differenza = (($data2 - $data1) / 3600) / $unita;
    return $differenza;
}

function generateEAN($number) {
    $code = '200' . str_pad($number, 9, '0');
    $weightflag = true;
    $sum = 0;
    // Weight for a digit in the checksum is 3, 1, 3.. starting from the last digit. 
    // loop backwards to make the loop length-agnostic. The same basic functionality 
    // will work for codes of different lengths.
    for ($i = strlen($code) - 1; $i >= 0; $i--) {
        $sum += (int) $code[$i] * ($weightflag ? 3 : 1);
        $weightflag = !$weightflag;
    }
    $code .= (10 - ($sum % 10)) % 10;
    return $code;
}

function retrieveNomeMeseFromNumer($numero) {
    $nome = '';
    switch ($numero) {
        case "1":
            $nome = "Gennaio";
            break;
        case "2":
            $nome = "Febbraio";
            break;
        case "3":
            $nome = "Marzo";
            break;
        case "4":
            $nome = "Aprile";
            break;
        case "5":
            $nome = "Maggio";
            break;
        case "6":
            $nome = "Giugno";
            break;
        case "7":
            $nome = "Luglio";
            break;
        case "8":
            $nome = "Agosto";
            break;
        case "9":
            $nome = "Settembre";
            break;
        case "10":
            $nome = "Ottobre";
            break;
        case "11":
            $nome = "Novembre";
            break;
        case "12":
            $nome = "Dicembre";
            break;
        default:
            $nome = "";
    }
    return $nome;
}

///////// MAIL FUNCTION
function sendMail($fromAddress, $fromName, $toAddress, $toName, $subject, $message) {
    return sendMailCcBccwAttaches($fromAddress, $fromName, $toAddress, $toName, $subject, $message, $attaches = '', $ccs = '', $bccs = '');
}


function getMailParameter($applicativo) {
    $array_res = array();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/SmartiPHR/db_config_server.php';
    $conn = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_mail_param = " select * from  t_mail_params where app = '" . $applicativo . "' and attivo = 'SI' ";
    $res = mysqli_query($conn, $query_mail_param);
    while ($row = mysqli_fetch_array($res)) {
        $array_res['smtp_user'] = $row['smtp_user'];
        $array_res['smtp_pass'] = $row['smtp_pass'];
        $array_res['smtp_server'] = $row['smtp_server'];
        $array_res['smtp_encryption'] = $row['smtp_encryption'];
        $array_res['smtp_port'] = $row['smtp_port'];
    }
    return $array_res;
    mysqli_close($conn);
}

function getServerHost() {
    $array_res = array();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/SmartiPHR/db_config_server.php';
    $conn = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_mail_param = " select * from t_params where attivo ='S' ";
    $res = mysqli_query($conn, $query_mail_param);
    while ($row = mysqli_fetch_array($res)) {
        
        $array_res['server'] = $row['server'];
    }
    return $array_res;
    mysqli_close($conn);
}

function sendMailCcBccwAttaches($fromAddress, $fromName, $toAddress, $toName, $subject, $message, $attaches = '', $ccs = '', $bccs = '') {

    require_once $_SERVER['DOCUMENT_ROOT'] . '/SmartiPHR/ext/PHPMailer_5.2.4/class.phpmailer.php';

    $mail = new PHPMailer();
    $params = getMailParameter('SmartiPHR');

    try {
        $body = $message;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = $params['smtp_server'];
        $mail->Port = $params['smtp_port'];
        $mail->Username = $params['smtp_user'];
        $mail->Password = $params['smtp_pass'];
        $mail->SMTPSecure = $params['smtp_encryption'];

        $mail->SetFrom($params['smtp_user'], 'Smart iPHR - InnovaWare');
        

        if ($ccs <> '') {
            foreach ($ccs as $bccer) {
                $mail->AddCC($bccer);
            }
        }

        if ($bccs <> '') {
            foreach ($bccs as $bccers) {
                $mail->AddBCC($bccers);
            }
        }

        $mail->Subject = $subject;
        $mail->AltBody = "Any message.";
        $mail->MsgHTML($body);

        $mail->AddAddress($toAddress, $toName);

        if ($attaches <> '') {
            foreach ($attaches as $key => $value) {
                $mail->AddAttachment($value);
            }
        }

        if (!$mail->Send()) {
            return $mail->ErrorInfo . ' ' . 'Send mail code: 0';
        } else {
            return 1;
        }
    } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
    }
}

function get_client_ip_env() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

// Function to get the client ip address
function get_client_ip_server() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if ($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if ($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if ($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if ($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if ($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $_SERVER['REMOTE_ADDR'];
}

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
?> 




