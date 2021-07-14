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

    if ($_POST['operation'] == 'getListaStanze') {
        echo getListaStanze();
    }
    if ($_POST['operation'] == 'insertStanza') {
        insertStanza($_POST['numero'], $_POST['descrizione'], $_POST['piano']);
    }
    if ($_POST['operation'] == 'insertIntervento') {
        insertIntervento($_POST['id_stanza'], $_POST['tipo_intervento'], $_POST['descrizione']);
    }
    if ($_POST['operation'] == 'deleteIntervento') {
        deleteIntervento($_POST['id_stanza'], $_POST['tipo_intervento']);
    }
}

function getListaStanze() {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_farmaci = " SELECT * 
                FROM t_stanza ORDER BY numero
                    ";

    $res_farmaci = mysqli_query($mysqli, $query_farmaci);
    $str_result = '';
    $str_result .= '<div class="table-responsive">';
    $str_result .= '<table class = "table table-hover">';
    $str_result .= '<thead> <tr>';


    $str_result .= '<th scope = "col">Numero</th>';
    $str_result .= '<th scope = "col">Descrizione</th>';
    $str_result .= '<th scope = "col">Piano</th>';
    $str_result .= '<th scope = "col" width="100px">Sanif.</th>';
    $str_result .= '<th scope = "col" width="100px">Letti</th>';
    $str_result .= '<th scope = "col" width="100px">Armadio</th>';
    $str_result .= '<th scope = "col" width="100px">Igiene</th>';

    $str_result .= '</tr></thead><tbody>';
    while ($row = mysqli_fetch_array($res_farmaci)) {
        $str_result .= '<tr>';

        $str_result .= '<td scope = "col">' . $row['numero'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['descrizione'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['piano'] . '</td>';

        $str_result .= '<td scope = "col">';
        $stato = retrieveEsecuzioneIntervento($row['id'], 1);
        $class = $stato == 'ok' ? 'btn-success' : 'btn-danger';
        $str_result .= '<button class="btn ' . $class . ' btn_change_state_stanza" id_stanza="' . $row['id'] . '" tipo_intervento="1" stato="' . $stato . '">' . $stato . '</button>';
        //$str_result .= '<img src="/SmartiPHR/img/ico_' . $stato . '.jpg">';
        $str_result .= '</td>';
        $str_result .= '<td scope = "col">';
        $stato = retrieveEsecuzioneIntervento($row['id'], 2);
        $class = $stato == 'ok' ? 'btn-success' : 'btn-danger';
        $str_result .= '<button class="btn ' . $class . ' btn_change_state_stanza" id_stanza="' . $row['id'] . '" tipo_intervento="2" stato="' . $stato . '">' . $stato . '</button>';
        //$str_result .= '<img src="/SmartiPHR/img/ico_' . $stato . '.jpg">';
        $str_result .= '</td>';
        $str_result .= '<td scope = "col">';
        $stato = retrieveEsecuzioneIntervento($row['id'], 3);
        $class = $stato == 'ok' ? 'btn-success' : 'btn-danger';
        $str_result .= '<button class="btn ' . $class . ' btn_change_state_stanza" id_stanza="' . $row['id'] . '" tipo_intervento="3" stato="' . $stato . '">' . $stato . '</button>';
        //$str_result .= '<img src="/SmartiPHR/img/ico_' . $stato . '.jpg">';
        $str_result .= '</td>';
        $str_result .= '<td scope = "col">';
        $stato = retrieveEsecuzioneIntervento($row['id'], 4);
        $class = $stato == 'ok' ? 'btn-success' : 'btn-danger';
        $str_result .= '<button class="btn ' . $class . ' btn_change_state_stanza" id_stanza="' . $row['id'] . '" tipo_intervento="4" stato="' . $stato . '">' . $stato . '</button>';
        //$str_result .= '<img src="/SmartiPHR/img/ico_' . $stato . '.jpg">';
        $str_result .= '</td>';

        /* $str_result .= '<td scope = "col">';
          $str_result .= '<button class="btn btn-info btn_gestisci_stanza" '
          . ' data-id_stanza="' . $row['id'] . '" '
          . ' data-toggle="modal" data-target="#modal_gestisci_stanza" >Gestisci stanza</button>';
          $str_result .= '</td>';
         * 
         */
        $str_result .= '</tr>';
    }
    mysqli_close($mysqli);
    return $str_result;
}

function insertIntervento($id_stanza, $tipo_intervento, $descrizione) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_insert_intervento = " INSERT INTO t_stanza_intervento (id_stanza, id_tipo_int, descrizione, operatore) "
            . " VALUES  "
            . " ('" . $id_stanza . "', '" . $tipo_intervento . "','" . $descrizione . "', '" . $_SESSION['username'] . "' ) ";

    $result_first = mysqli_query($mysqli, $query_insert_intervento);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_intervento;
    mysqli_close($mysqli);

    echo json_encode($res);
}

function deleteIntervento($id_stanza, $tipo_intervento) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_delete_intervento = " 
                DELETE FROM t_stanza_intervento
                WHERE id_stanza='" . $id_stanza . "' AND id_tipo_int='" . $tipo_intervento . "'
                order by id desc limit 1
             ";

    $result_first = mysqli_query($mysqli, $query_delete_intervento);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_delete_intervento;
    mysqli_close($mysqli);

    echo json_encode($res);
}

function insertStanza($numero, $descrizione, $piano = '') {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_insert_stanza = " INSERT INTO t_stanza (numero, descrizione, piano) "
            . " VALUES  "
            . " ('" . $numero . "', '" . $descrizione . "','" . $piano . "' ) ";

    $result_first = mysqli_query($mysqli, $query_insert_stanza);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_stanza;
    mysqli_close($mysqli);

    echo json_encode($res);
}

function retrieveEsecuzioneIntervento($id_stanza, $id_tipo_int) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_last_intervento = " SELECT stanza.*, stanza_i.*, stanza_ti.*, DATE(stanza_i.data_intervento) AS data_ultimo_intervento 
        FROM t_stanza stanza, t_stanza_intervento stanza_i, t_stanza_tipo_int stanza_ti
        WHERE stanza.id = stanza_i.id_stanza
        AND stanza_i.id_tipo_int = stanza_ti.id
        AND stanza.id = '" . $id_stanza . "'
        AND stanza_ti.id = '" . $id_tipo_int . "'
        ORDER BY data_intervento desc
        LIMIT 1 
        ";
    $result = mysqli_query($mysqli, $query_last_intervento);
    if (mysqli_num_rows($result) <= 0) {
        return 'ko';
    }
    while ($row = mysqli_fetch_array($result)) {

        $validita = $row['validita'];
        $ultimo_intervento = $row['data_ultimo_intervento'];
        $oggi = date('Y-m-d');

        if (date('Y-m-d', strtotime($ultimo_intervento . ' + ' . ($validita) . ' days')) < $oggi) {
            return 'ko';
        } else {
            return 'ok';
        }
    }
    mysqli_close($mysqli);
}

/*

function insertCaricoScarico($id_farmaco, $id_paziente, $qta, $note) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_insert_farmaco = " INSERT INTO t_magazzino_farmaci (id_farmaco, id_paziente, qta, note, operatore) "
            . " VALUES  "
            . " ('" . $id_farmaco . "','" . $id_paziente . "', '" . $qta . "', '" . $note . "', '" . $_SESSION['username'] . "' ) ";

    $result_first = mysqli_query($mysqli, $query_insert_farmaco);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_farmaco;
    mysqli_close($mysqli);

    echo json_encode($res);
}
*/