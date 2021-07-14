<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$nome_progetto = 'SmartiPHR';

require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/db_config_server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/utils.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['operation'] == 'insertOrUpdateTab') {
        insertOrUpdateTab($_POST['id_master'], $_POST['id_paziente'] , $_POST['nome_tab'], $_POST['json']);
    }
    
    if ($_POST['operation'] == 'getListaTab') {
        echo getListaTab($_POST['id_master'], $_POST['id_paziente']);
    }
    
    
    if ($_POST['operation'] == 'getListaRowsDiarioClinico') {
        echo getListaRowsDiarioClinico($_POST['id_paziente']);
    }
    
    if ($_POST['operation'] == 'getListaRowsVisiteSpec') {
        echo getListaRowsVisiteSpec($_POST['id_paziente']);
    }
    
    
    if ($_POST['operation'] == 'insertRecordVisiteSpec') {
        insertRecordVisiteSpec($_POST['id_paziente'] , $_POST['data_richiesta'],  $_POST['data_esecuzione'], $_POST['contenuto']);
    }
    
    
    if ($_POST['operation'] == 'insertRecordDiario') {
        insertRecordDiario($_POST['id_paziente'] , $_POST['data'],  $_POST['terapia'], $_POST['contenuto']);
    }
    
    
    if ($_POST['operation'] == 'getRecordDiario') {
        getRecordDiario($_POST['id']);
    }
    
     if ($_POST['operation'] == 'getRecordVisite') {
        getRecordVisite($_POST['id']);
    }
    
    
    if ($_POST['operation'] == 'updateRecordDiario') {
        updateRecordDiario($_POST['id'],$_POST['contenuto']);
    }
    
    
    
    
    if ($_POST['operation'] == 'getListaRowsDiarioInf') {
        echo getListaRowsDiarioInf($_POST['id_paziente']);
    }
    
    if ($_POST['operation'] == 'getListaRowsInterventi') {
        echo getListaRowsInterventi($_POST['id_paziente']);
    }
    
    if ($_POST['operation'] == 'insertRecordInterventi') {
        insertRecordInterventi($_POST['id_paziente'] , $_POST['data'],  $_POST['diagnosi'], $_POST['obiettivi'],  $_POST['intervento'], $_POST['valutazione']);
    }
    
    if ($_POST['operation'] == 'insertRecordDiarioInf') {
        insertRecordDiarioInf($_POST['id_paziente'] , $_POST['data'],  $_POST['turno'], $_POST['diario'], $_POST['firma']);
    }
    
    
     if ($_POST['operation'] == 'getRecordDiarioInf') {
        getRecordDiarioInf($_POST['id']);
    }
    
    
    if ($_POST['operation'] == 'updateRecordDiarioInf') {
        updateRecordDiarioInf($_POST['id'],$_POST['contenuto']);
    }
    
}



function insertOrUpdateTab($id_master, $id_paziente, $nome_tab, $json) {
    if (!isset($_SESSION)) {
        session_start();
    }
    //$WEB_SERVER_HOST = getServerHost();
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $query = " select * from t_cart_det where id_master=" . $id_master." and id_paziente=".$id_paziente." and nome_tab='".$nome_tab."'";
    
    $res_tabs = mysqli_query($mysqli, $query);
    $rowcount = mysqli_num_rows($result);
    
    if($rowcount > 0 ){        
        $query_upd_tab = " UPDATE t_cart_det  SET json='" . json_encode($json) . "'  where id_master=" . $id_master." and id_paziente=".$id_paziente." and nome_tab='".$nome_tab."'";


        $result_first = mysqli_query($mysqli, $query_upd_tab);

        $res['stato'] = ($result_first) ? '100' : '-100';
        $res['query'] = $query_upd_tab;
        
    }
    else{
        $query_insert_tab = " INSERT INTO t_cart_det (id_master, id_paziente, nome_tab, json) "
                    . " VALUES  "
                    . " (" . $id_master . ", " . $id_paziente . ",'" . $nome_tab . "','" . json_encode($json) . "') ";


        $result_first = mysqli_query($mysqli, $query_insert_tab);

        $res['stato'] = ($result_first) ? '100' : '-100';
        $res['query'] = $query_insert_tab;
    }

    mysqli_close($mysqli);
    echo json_encode($res);
}


function getListaTab($id_master, $id_paziente){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $res = array();
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from t_cart_det where id_master=" . $id_master." and id_paziente=".$id_paziente;

    $res_tabs = mysqli_query($mysqli, $query);
    $str_result = '';

    while ($row = mysqli_fetch_array($res_tabs)) {
       array_push($res,$row);
    }
    
    mysqli_close($mysqli);
    echo json_encode($res);
}


function getListaRowsVisiteSpec($id_paziente){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $res = array();
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from t_visite_spec_cart_med where id_paziente=".$id_paziente;

    $res_tabs = mysqli_query($mysqli, $query);
    $str_result = '';

    while ($row = mysqli_fetch_array($res_tabs)) {
       $str_result .= '<tr>';
        $str_result .= '<td>' . date("d/m/Y", strtotime($row['data_richiesta'])). '</td>';
        $str_result .= '<td>' . $row['contenuto'] . '</td>';
        $str_result .= '<td>' . date("d/m/Y", strtotime($row['data_esecuzione'])) . '</td>';
        $str_result .= '<td></td>';
        $str_result .= '</tr>';
    }
    
    $str_result .= '<tr>';
    $str_result .= '<td></td>';
    $str_result .= '<td></td>';
    $str_result .= '<td></td>';
    $str_result .= '<td><button class="btn btn-info" id="btn_new_record_vis_spec"><i class="fa fa-plus"></i></button></td>';
    $str_result .= '</tr>';
    mysqli_close($mysqli);
    return $str_result;
}



function getListaRowsDiarioClinico($id_paziente){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $res = array();
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from t_diario_cart_med where id_paziente=".$id_paziente;

    $res_tabs = mysqli_query($mysqli, $query);
    $str_result = '';

    while ($row = mysqli_fetch_array($res_tabs)) {
       $str_result .= '<tr>';
        $str_result .= '<td>' . date("d/m/Y", strtotime($row['data'])) . '</td>';
        $str_result .= '<td>' . $row['contenuto'] . '</td>';
        $str_result .= '<td>' . $row['terapia'] . '</td>';
        $str_result .= '<td><button class="btn btn-inf btn-modifica-row-diario" 
                        data-id_anag="' . $row['id_paziente'] . '" 
                        data-id="' . $row['id'] . '" ><i class="fa fa-edit"></i></button></td>';
        $str_result .= '</tr>';
    }
    
    $str_result .= '<tr>';
    $str_result .= '<td></td>';
    $str_result .= '<td></td>';
    $str_result .= '<td></td>';
    $str_result .= '<td><button class="btn btn-info" id="btn_new_record_diario"><i class="fa fa-plus"></i></button></td>';
    $str_result .= '</tr>';
    mysqli_close($mysqli);
    return $str_result;
}





function insertRecordVisiteSpec($id_paziente, $data_richiesta, $data_esecuzione,$contenuto) {
    if (!isset($_SESSION)) {
        session_start();
    }
    //$WEB_SERVER_HOST = getServerHost();
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $query_insert_tab = " INSERT INTO t_visite_spec_cart_med (id_paziente, username, attivo , data_richiesta, contenuto , data_esecuzione) "
                . " VALUES  "
                . " (" . $id_paziente . ",'" . $_SESSION['username'] . "','S','" . $data_richiesta . "','".$contenuto."','". $data_esecuzione."') ";
    
    
    $result_first = mysqli_query($mysqli, $query_insert_tab);
    
    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_tab;
    mysqli_close($mysqli);
    echo json_encode($res);
}



function insertRecordDiario($id_paziente, $data, $terapia,$contenuto) {
    if (!isset($_SESSION)) {
        session_start();
    }
    //$WEB_SERVER_HOST = getServerHost();
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $query_insert_tab = " INSERT INTO t_diario_cart_med (id_paziente, username, attivo , data, contenuto , terapia) "
                . " VALUES  "
                . " (" . $id_paziente . ",'" . $_SESSION['username'] . "','S','" . $data . "','".$contenuto."','". $terapia."') ";
    
    
    
       // echo $query_insert_tab;
    $result_first = mysqli_query($mysqli, $query_insert_tab);
    
    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_tab;
    mysqli_close($mysqli);
    echo json_encode($res);
}




function getRecordDiario($id){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $res = array();
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from t_diario_cart_med where id=" . $id;

    $res_tabs = mysqli_query($mysqli, $query);
    $str_result = '';

    while ($row = mysqli_fetch_array($res_tabs)) {
       array_push($res,$row);
    }
    
    mysqli_close($mysqli);
    echo json_encode($res);
}




function getRecordVisite($id){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $res = array();
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from t_visite_spec_cart_med where id=" . $id;

    $res_tabs = mysqli_query($mysqli, $query);
    $str_result = '';

    while ($row = mysqli_fetch_array($res_tabs)) {
       array_push($res,$row);
    }
    
    mysqli_close($mysqli);
    echo json_encode($res);
}




function updateRecordDiario($id , $contenuto) {
    if (!isset($_SESSION)) {
        session_start();
    }
    //$WEB_SERVER_HOST = getServerHost();
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $query_upd_rec_diario = " update t_diario_cart_med set contenuto ='".$contenuto."',username='".$_SESSION['username']."' where id=".$id;
    
    
    
       // echo $query_insert_tab;
    $result_first = mysqli_query($mysqli, $query_upd_rec_diario);
    
    
   // echo $result_first;
    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_upd_rec_diario;
    mysqli_close($mysqli);
    echo json_encode($res);
   
}



/*function updateRecordVisite($id , $contenuto) {
    if (!isset($_SESSION)) {
        session_start();
    }
    //$WEB_SERVER_HOST = getServerHost();
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $query_upd_rec_vis = " update t_visite_spec_cart_med set contenuto ='".$contenuto."',username='".$_SESSION['username']."' where id=".$id;
    
    
    
       // echo $query_insert_tab;
    $result_first = mysqli_query($mysqli, $query_upd_rec_vis);
    
    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_upd_rec_vis;
    mysqli_close($mysqli);
    echo json_encode($res);
}*/






/* SEZIONE CARTELLA INFERMIERISTICA */

function getListaRowsInterventi($id_paziente){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $res = array();
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from t_interventi_cart_inf where id_paziente=".$id_paziente;

    $res_tabs = mysqli_query($mysqli, $query);
    $str_result = '';

    while ($row = mysqli_fetch_array($res_tabs)) {
       $str_result .= '<tr>';
        $str_result .= '<td>' . date("d/m/Y", strtotime($row['data'])). '</td>';
        $str_result .= '<td>' . $row['diagnosi'] . '</td>';
        $str_result .= '<td>' . $row['obiettivi'] . '</td>';
        $str_result .= '<td>' . $row['intervento'] . '</td>';
        $str_result .= '<td>' . $row['valutazione'] . '</td>';
        $str_result .= '<td></td>';
        $str_result .= '</tr>';
    }
    
    $str_result .= '<tr>';
    $str_result .= '<td></td>';
    $str_result .= '<td></td>';
    $str_result .= '<td></td>';
    $str_result .= '<td></td>';
    $str_result .= '<td></td>';
    $str_result .= '<td><button class="btn btn-info" id="btn_new_record_interveneti"><i class="fa fa-plus"></i></button></td>';
    $str_result .= '</tr>';
    mysqli_close($mysqli);
    return $str_result;
}



function getListaRowsDiarioInf($id_paziente){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $res = array();
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from t_diario_cart_inf where id_paziente=".$id_paziente;

    $res_tabs = mysqli_query($mysqli, $query);
    $str_result = '';

    while ($row = mysqli_fetch_array($res_tabs)) {
       $str_result .= '<tr>';
        $str_result .= '<td>' . date("d/m/Y", strtotime($row['data'])) . '</td>';
        $str_result .= '<td>' . $row['turno'] . '</td>';
        $str_result .= '<td>' . $row['diario'] . '</td>';
         $str_result .= '<td>' . $row['firma'] . '</td>';
        $str_result .= '<td><button class="btn btn-inf btn-modifica-row-diario-inf" 
                        data-id_anag="' . $row['id_paziente'] . '" 
                        data-id="' . $row['id'] . '" ><i class="fa fa-edit"></i></button></td>';
        $str_result .= '</tr>';
    }
    
    $str_result .= '<tr>';
    $str_result .= '<td></td>';
    $str_result .= '<td></td>';
    $str_result .= '<td></td>';
     $str_result .= '<td></td>';
    $str_result .= '<td><button class="btn btn-info" id="btn_new_record_diario_inf"><i class="fa fa-plus"></i></button></td>';
    $str_result .= '</tr>';
    mysqli_close($mysqli);
    return $str_result;
}


function insertRecordInterventi($id_paziente, $data, $diagnosi,$obiettivi,$intervento,$valutazione) {
    if (!isset($_SESSION)) {
        session_start();
    }
    //$WEB_SERVER_HOST = getServerHost();
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $query_insert_tab = " INSERT INTO t_interventi_cart_inf (id_paziente, username, attivo , data, diagnosi , obiettivi , intervento,valutazione) "
                . " VALUES  "
                . " (" . $id_paziente . ",'" . $_SESSION['username'] . "','S','" . $data . "','".$diagnosi."','". $obiettivi."','".$intervento."','". $valutazione."') ";
    
    
    $result_first = mysqli_query($mysqli, $query_insert_tab);
    
    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_tab;
    mysqli_close($mysqli);
    echo json_encode($res);
}



function insertRecordDiarioInf($id_paziente, $data, $turno,$diario,$firma) {
    if (!isset($_SESSION)) {
        session_start();
    }
    //$WEB_SERVER_HOST = getServerHost();
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $query_insert_tab = " INSERT INTO t_diario_cart_inf (id_paziente, username, attivo , data, turno, diario,firma) "
                . " VALUES  "
                . " (" . $id_paziente . ",'" . $_SESSION['username'] . "','S','" . $data . "','".$turno."','". $diario."','". $firma."') ";
    
    
    
       // echo $query_insert_tab;
    $result_first = mysqli_query($mysqli, $query_insert_tab);
    
    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_tab;
    mysqli_close($mysqli);
    echo json_encode($res);
}


function getRecordDiarioInf($id){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $res = array();
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from t_diario_cart_inf where id=" . $id;

    $res_tabs = mysqli_query($mysqli, $query);
    $str_result = '';

    while ($row = mysqli_fetch_array($res_tabs)) {
       array_push($res,$row);
    }
    
    mysqli_close($mysqli);
    echo json_encode($res);
}

function updateRecordDiarioInf($id , $contenuto) {
    if (!isset($_SESSION)) {
        session_start();
    }
    //$WEB_SERVER_HOST = getServerHost();
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $query_upd_rec_diario = " update t_diario_cart_inf set diario ='".$contenuto."',username='".$_SESSION['username']."' where id=".$id;
    
    
    
       // echo $query_insert_tab;
    $result_first = mysqli_query($mysqli, $query_upd_rec_diario);
    
    
   // echo $result_first;
    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_upd_rec_diario;
    mysqli_close($mysqli);
    echo json_encode($res);
   
}