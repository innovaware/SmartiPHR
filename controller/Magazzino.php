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

    if ($_POST['operation'] == 'insertMov') {
        insertMov($_POST['tipo_mag'], $_POST['item'], $_POST['qta'], $_POST['data_mov'], $_POST['id_assegnatario'],$_POST['id_mag']);
    }
    if ($_POST['operation'] == 'getMagazzino') {
        echo getMagazzino($_POST['tipo_mag']);
    }
    if ($_POST['operation'] == 'switchValue') {
        echo switchValue($_POST['tipo_mag'], $_POST['id_mag'], $_POST['field'], $_POST['valore_attuale']);
    }

    if ($_POST['operation'] == 'filtroSelectMagazzino') {
        echo filtroValoriMagazzino($_POST['tipo_mag'], $_POST['selezionato']);
    }
     if ($_POST['operation'] == 'getListaAssegnatari') {
        echo getListaAssegnatari();
    }
    if ($_POST['operation'] == 'getListaItemMagazzinoSelect') {
        echo getListaItemMagazzinoSelect($_POST['tipo_mag'],$_POST['id_assegn']);
    }
    
}

function insertMov($tipo_mag, $item, $qta, $data_mov, $id_assegnatario = '', $id_mag = '') {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    if ($id_mag == '') {
        /*
        $query_insert_mov = " INSERT INTO t_magazzino_" . $tipo_mag . " (item, qta, id_assegnatario, data_mov, operatore) "
                . " VALUES  "
                . " ('" . $item . "', '" . $qta . "','" . $id_assegnatario . "', '" . $data_mov . "', '" . $_SESSION['username'] . "' ) ";
        echo $query_insert_mov;
         * 
         */
        
    } else {
        $item = retrieveDatiFromCarico($tipo_mag, $id_mag)['item'];
        $id_assegnatario = retrieveDatiFromCarico($tipo_mag, $id_mag)['id_assegnatario'];
        
        /*$query_insert_mov = " INSERT INTO t_magazzino_" . $tipo_mag . " (item, qta, id_assegnatario, data_mov, operatore) "
                . " VALUES  "
                . " ('" . $item . "', '" . $qta . "','" . $id_assegnatario . "', '" . $data_mov . "', '" . $_SESSION['username'] . "'  ) ";
        echo $query_insert_mov;

         */
    }
    
    $query_insert_mov = " INSERT INTO t_magazzino_" . $tipo_mag . " (item, qta, id_assegnatario, data_mov, operatore) "
                . " VALUES  "
                . " ('" . $item . "', '" . $qta . "','" . $id_assegnatario . "', '" . $data_mov . "', '" . $_SESSION['username'] . "'  ) ";
    
    $result_first = mysqli_query($mysqli, $query_insert_mov);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_mov;
    mysqli_close($mysqli);

    echo json_encode($res);
    //commento delete
}

function getMagazzino($tipo_mag) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $query_tipo_mag = " SELECT t_mag.flag_libero_1
               FROM t_tipo_mag t_mag
               WHERE t_mag.descrizione = '" . $tipo_mag . "'
            "
    ;
    //echo $query_tipo_mag;
    $res_tipo_mag = mysqli_query($mysqli, $query_tipo_mag);
    $nome_flag_1 = '';
    while ($row_tipo_mag = mysqli_fetch_array($res_tipo_mag)) {
        $nome_flag_1 = $row_tipo_mag['flag_libero_1'];
    }

    $query = " SELECT mag.id as id_mag, mag.item, sum(mag.qta) as qta_reale, anag.nome, anag.cognome, mag.flag_libero_1
               FROM t_tipo_mag t_mag, t_magazzino_" . $tipo_mag . " mag
               LEFT OUTER JOIN t_anagrafica anag ON anag.id = mag.id_assegnatario
               WHERE t_mag.descrizione = '" . $tipo_mag . "'
               group by mag.item, anag.id
            "    ;
    //echo $query;

    $res_magazzino = mysqli_query($mysqli, $query);
    $str_result = '';
    $str_result .= '<div class="table-responsive">';
    $str_result .= '<table class = "table table-hover">';
    $str_result .= '<thead> <tr>';


    $str_result .= '<th scope = "col">Descrizione</th>';
    $str_result .= '<th scope = "col">Qta</th>';
    $str_result .= '<th scope = "col">Assegnatario</th>';
    $str_result .= '<th scope = "col"></th>';
    $str_result .= '<th scope = "col">' . $nome_flag_1 . '</th>';


    $str_result .= '</tr></thead><tbody>';

    while ($row = mysqli_fetch_array($res_magazzino)) {
        $class = $row['flag_libero_1'] == 'S' ? 'btn-info' : 'btn-warning';
        $str_result .= '<tr>';

        $str_result .= '<td>' . $row['item'] . '</td>';
        $str_result .= '<td>' . $row['qta_reale'] . '</td>';
        $str_result .= '<td>' . $row['nome'] . ' ' . $row['cognome'] . '</td>';
        $str_result .= '<td><button class="btn  btn-danger btn_scarica_item_modal" data-toggle="modal" data-target="#modal_mov_carsca"
                 id_mag = "' . $row['id_mag'] . '"  
                 ospite = "' . $row['nome'] . ' ' . $row['cognome'] . '"    
                 item = "' . $row['item'] . '"
                > Scarica</button></td>';
        if($nome_flag_1<>'')
            $str_result .= '<td><button class="btn ' . $class . ' btn_flag_libero_1" style="width:50px" '
                . ' id_mag="' . $row['id_mag'] . '" valselezionato="' . $row['flag_libero_1'] . '">' . $row['flag_libero_1'] . '</button></td>';

        $str_result .= '</tr>';
    }
    $str_result .= '
                </tbody>
        </table>
        </div>';
    return $str_result;
}

function getListaAssegnatari() {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $query_lista_assegnatari = " select * from t_anagrafica";
    //echo $query_tipo_mag;
    $res_lista_assegnatari = mysqli_query($mysqli, $query_lista_assegnatari);

     $str_result = '';
    while ($row = mysqli_fetch_array($res_lista_assegnatari)) {
       $str_result.='<option value="'.$row[id].'">'.$row[nome].' '.$row[cognome].'</option>';
    }


    return $str_result;
}

function getListaItemMagazzinoSelect($tipo_mag,$id_assegn) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $query_tipo_mag = " SELECT t_mag.flag_libero_1
               FROM t_tipo_mag t_mag
               WHERE t_mag.descrizione = '" . $tipo_mag . "'
            "
    ;
    //echo $query_tipo_mag;
    $res_tipo_mag = mysqli_query($mysqli, $query_tipo_mag);
    $nome_flag_1 = '';
    while ($row_tipo_mag = mysqli_fetch_array($res_tipo_mag)) {
        $nome_flag_1 = $row_tipo_mag['flag_libero_1'];
    }

    $query = " SELECT mag.id as id_mag, mag.item, sum(mag.qta) as qta_reale, anag.nome, anag.cognome, mag.flag_libero_1
               FROM t_tipo_mag t_mag, t_magazzino_" . $tipo_mag . " mag
               LEFT OUTER JOIN t_anagrafica anag ON anag.id = mag.id_assegnatario
               WHERE t_mag.descrizione = '" . $tipo_mag . "' and mag.id_assegnatario =".$id_assegn."
               group by mag.item, anag.id
            "    ;
    //echo $query;

    $res_magazzino = mysqli_query($mysqli, $query);
    $str_result = '';
    $str_result .= '<div class="table-responsive">';
    $str_result .= '<table class = "table table-hover">';
    $str_result .= '<thead> <tr>';


    $str_result .= '<th scope = "col">Descrizione</th>';
    $str_result .= '<th scope = "col">Qta</th>';
    $str_result .= '<th scope = "col">Assegnatario</th>';
    $str_result .= '<th scope = "col"></th>';
    $str_result .= '<th scope = "col">' . $nome_flag_1 . '</th>';


    $str_result .= '</tr></thead><tbody>';

    while ($row = mysqli_fetch_array($res_magazzino)) {
        $class = $row['flag_libero_1'] == 'S' ? 'btn-info' : 'btn-warning';
        $str_result .= '<tr>';

        $str_result .= '<td>' . $row['item'] . '</td>';
        $str_result .= '<td>' . $row['qta_reale'] . '</td>';
        $str_result .= '<td>' . $row['nome'] . ' ' . $row['cognome'] . '</td>';
        $str_result .= '<td><button class="btn  btn-danger btn_scarica_item_modal" data-toggle="modal" data-target="#modal_mov_carsca"
                 id_mag = "' . $row['id_mag'] . '"  
                 ospite = "' . $row['nome'] . ' ' . $row['cognome'] . '"    
                 item = "' . $row['item'] . '"
                > Scarica</button></td>';
        if($nome_flag_1<>'')
            $str_result .= '<td><button class="btn ' . $class . ' btn_flag_libero_1" style="width:50px" '
                . ' id_mag="' . $row['id_mag'] . '" valselezionato="' . $row['flag_libero_1'] . '">' . $row['flag_libero_1'] . '</button></td>';

        $str_result .= '</tr>';
    }
    $str_result .= '
                </tbody>
        </table>
        </div>';
    return $str_result;
}


function filtroValoriMagazzino($tipo_mag, $selezionato) {
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $magazArmadi = "arm";
    $magazPresidiInfer = "presinf";
    $magazPresidiOss = "presoss";

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $query_tipo_mag = " SELECT t_mag.flag_libero_1
               FROM t_tipo_mag t_mag
               WHERE t_mag.descrizione = '" . $tipo_mag . "'
            "
    ;
    //echo $query_tipo_mag;
    $res_tipo_mag = mysqli_query($mysqli, $query_tipo_mag);
    $nome_flag_1 = '';
    while ($row_tipo_mag = mysqli_fetch_array($res_tipo_mag)) {
        $nome_flag_1 = $row_tipo_mag['flag_libero_1'];
    }

    $selezionato = trim($selezionato);
    $fullName = "";
    $andClause = "";
    //cambio la clausola di AND in base al tipo di magazzino - per adesso vanno bene due casi anche se i magazzini sono di più
  
    $query = " SELECT mag.id as id_mag, mag.item, sum(mag.qta) as qta_reale, anag.nome, anag.cognome, mag.flag_libero_1
               FROM t_tipo_mag t_mag, t_magazzino_" . $tipo_mag . " mag
               LEFT OUTER JOIN t_anagrafica anag ON anag.id = mag.id_assegnatario
               WHERE t_mag.descrizione = '".$tipo_mag."' and mag.id_assegnatario =".$selezionato."
               group by mag.item, anag.id
            "
    ;
    //echo $query;

    $res_magazzino = mysqli_query($mysqli, $query);
    $str_result = '';
    $str_result .= '<div class="table-responsive">';
    $str_result .= '<table class = "table table-hover">';
    $str_result .= '<thead> <tr>';


    $str_result .= '<th scope = "col">Descrizione</th>';
    $str_result .= '<th scope = "col">Qta</th>';
    $str_result .= '<th scope = "col">Assegnatario</th>';
    $str_result .= '<th scope = "col"></th>';
    $str_result .= '<th scope = "col">' . $nome_flag_1 . '</th>';


    $str_result .= '</tr></thead><tbody>';

    while ($row = mysqli_fetch_array($res_magazzino)) {
        $class = $row['flag_libero_1'] == 'S' ? 'btn-info' : 'btn-warning';
        $str_result .= '<tr>';

        $str_result .= '<td>' . $row['item'] . '</td>';
        $str_result .= '<td>' . $row['qta_reale'] . '</td>';
        $str_result .= '<td>' . $row['nome'] . ' ' . $row['cognome'] . '</td>';
        $str_result .= '<td><button class="btn  btn-danger btn_scarica_item_modal" data-toggle="modal" data-target="#modal_mov_carsca"
                 id_mag = "' . $row['id_mag'] . '"  
                 ospite = "' . $row['nome'] . ' ' . $row['cognome'] . '"    
                 item = "' . $row['item'] . '"
                > Scarica</button></td>';
        if($nome_flag_1<>''){
            $str_result .= '<td><button class="btn ' . $class . ' btn_flag_libero_1" style="width:50px" '
                . ' id_mag="' . $row['id_mag'] . '" valselezionato="' . $row['flag_libero_1'] . '">' . $row['flag_libero_1'] . '</button></td>';
        }
        $str_result .= '</tr>';
    }
    $str_result .= '
                </tbody>
        </table>
        </div>';
    return $str_result;
}





function switchValue($tipo_mag, $id_mag, $field, $valore_attuale) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $new_valore = ($valore_attuale == 'S') ? 'N' : 'S';

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_update_flag = " UPDATE t_magazzino_" . $tipo_mag . " SET " . $field . " = '" . $new_valore . "' where id='" . $id_mag . "' ";

    $result_first = mysqli_query($mysqli, $query_update_flag);
}

function retrieveDatiFromCarico($tipo_mag, $id_mag) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = "SELECT id_assegnatario, item from t_magazzino_" . $tipo_mag . " WHERE id='" . $id_mag . "' ";
    
    $res = mysqli_query($mysqli, $query);
    $array_res = array();
    while ($row = mysqli_fetch_array($res)) {
        $array_res['item'] = $row['item'];
        $array_res['id_assegnatario'] = $row['id_assegnatario'];
    }
    return $array_res;
}
