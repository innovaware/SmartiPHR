<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/SmartiPHR/db_config_server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/SmartiPHR/utils.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Administrator
    if ($_POST['operation'] == 'inviaMail') {
        echo inviaMail($_POST['azienda'], $_POST['oggetto'], $_POST['testo_mail'], $_POST['valoriSelezionati']);
    }
}

/*
 * 
 
function inviaMail($azienda, $oggetto, $testo_mail, $valoriSelezionati) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from z_utentiweb where livello <'" . $_SESSION['livello'] . "' and azienda = '" . $azienda . "' order by cognome, nome ";
    $res_dipendenti = mysqli_query($mysqli, $query);
    $str_result = '';
    $bccs = array();
    while ($row = mysqli_fetch_array($res_dipendenti)) {
        //$str_result .= $row['mail'] . ',';
        array_push($bccs, $row['mail']);
    }
    foreach ($valoriSelezionati as $valore){
        $str_result .= $valore . ' ';
    }

    return $str_result;
    
    //sendMailCcBccwAttaches('personale@dical.it', 'Dical Srl - HR', 'personale@dical.it', 'Dical Srl - HR', $oggetto, $testo_mail, '', '', $bccs); 
    //return 'Mail inviata.';
}
*/

function inviaMail($azienda, $oggetto, $testo_mail, $valoriSelezionati) {
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $str_result = '';
    $bccs = array();
    
    
    foreach ($valoriSelezionati as $valore){
        array_push($bccs, $valore );
        //$str_result .= $valore . ' ';
    }

    //return $str_result;
    $testo_mail .= '<br><br><br><a href="http://dical.ns0.it/SmartiPHR">SmartiPHR</a>';
    
    //sendMailCcBccwAttaches('personale@dical.it', 'Dical Srl - HR', 'personale@dical.it', 'Dical Srl - HR', $oggetto, $testo_mail, '', '', $bccs); 
    return 'Mail inviata.';
}
