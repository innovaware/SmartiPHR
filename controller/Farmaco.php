<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$nome_progetto = 'SmartiPHR';

require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/db_config_server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/utils.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/ext/calendar/Calendar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['operation'] == 'getListaFarmaci') {
        if ($_POST['testo'] <> '')
            echo getListaFarmaci($_POST['testo']);
        else
            echo getListaFarmaci();
    }
    if ($_POST['operation'] == 'insertFarmaco') {
        echo insertFarmaco($_POST['nome'], $_POST['descrizione'], $_POST['formato'], $_POST['dose'], $_POST['confezione'], $_POST['codice_interno']);
    }
    if ($_POST['operation'] == 'insertCariscoScarico') {
        echo insertCaricoScarico($_POST['id_farmaco'], $_POST['id_paziente'], $_POST['qta'], $_POST['note'], $_POST['data_scadenza']);
    }
    if ($_POST['operation'] == 'retrieveFarmaciInScadenza') {
        echo retrieveFarmaciInScadenza($_POST['giorni_anticipo']);
    }
}

function getListaFarmaci($testo = '') {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_farmaci = " SELECT * 
                FROM t_farmaco WHERE nome like '%" . $testo . "%' 
                OR descrizione like '%" . $testo . "%' 
                OR formato like '%" . $testo . "%'
                OR codice_interno like '%" . $testo . "%'
                    ";

    $res_farmaci = mysqli_query($mysqli, $query_farmaci);
    $str_result = '';
    $str_result .= '<div class="table-responsive">';
    $str_result .= '<table class = "table table-hover">';
    $str_result .= '<thead> <tr>';


    $str_result .= '<th scope = "col">Nome</th>';
    $str_result .= '<th scope = "col">Descrizione</th>';
    $str_result .= '<th scope = "col">Formato</th>';
    $str_result .= '<th scope = "col">Dose</th>';
    $str_result .= '<th scope = "col">Qta Conf.</th>';
    $str_result .= '<th scope = "col">Codice interno</th>';

    $str_result .= '</tr></thead><tbody>';
    while ($row = mysqli_fetch_array($res_farmaci)) {
        $str_result .= '<tr>';

        $str_result .= '<td scope = "col">' . $row['nome'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['descrizione'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['formato'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['dose'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['confezione'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['codice_interno'] . '</td>';
        $str_result .= '<td scope = "col">';
        $str_result .= '<button id="btn_modal_carsca" class="btn btn-danger" '
                . ' data-nome="' . $row['nome'] . '" data-descrizione="' . $row['descrizione'] . '" data-confezione="' . $row['confezione'] . '" data-id_farmaco="' . $row['id'] . '" '
                . ' data-toggle="modal" data-target="#modal_inserisci_carsca" >Carichi e scarichi</button>';
        $str_result .= '</td>';
        $str_result .= '</tr>';
    }
    return $str_result;
}

function insertFarmaco($nome, $descrizione, $formato, $dose, $confezione, $codice_interno, $data_scadenza) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_insert_farmaco = " INSERT INTO t_farmaco (nome, descrizione, formato, dose, confezione, codice_interno, data_scadenza) "
            . " VALUES  "
            . " ('" . $nome . "', '" . $descrizione . "','" . $formato . "','" . $dose . "','" . $confezione . "', '" . $codice_interno . "', '" . $data_scadenza . "') ";

    $result_first = mysqli_query($mysqli, $query_insert_farmaco);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_farmaco;
    mysqli_close($mysqli);

    echo json_encode($res);
}

function insertCaricoScarico($id_farmaco, $id_paziente, $qta, $note, $data_scadenza) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_insert_farmaco = " INSERT INTO t_magazzino_farmaci (id_farmaco, id_paziente, qta, note, data_scadenza, operatore) "
            . " VALUES  "
            . " ('" . $id_farmaco . "','" . $id_paziente . "', '" . $qta . "', '" . $note . "', '" . $data_scadenza . "', '" . $_SESSION['username'] . "' ) ";

    $result_first = mysqli_query($mysqli, $query_insert_farmaco);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_farmaco;

    inserisciEvento($data_scadenza, 'Scadenza Farmaco', mysqli_insert_id($mysqli), 'farm', '2');
    mysqli_close($mysqli);
    echo json_encode($res);
}

function retrieveFarmaciInScadenza($giorni_anticipo = '15') {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $str_result = '';
    $str_result .= '<div class="table-responsive">';
    $str_result .= '<table class = "table table-hover">';
    $str_result .= '<thead> <tr>';


    $str_result .= '<th scope = "col">Farmaco</th>';
    $str_result .= '<th scope = "col">Dose</th>';
    $str_result .= '<th scope = "col">Formato</th>';
    $str_result .= '<th scope = "col">Assegnatario</th>';
    $str_result .= '<th scope = "col">Residui</th>';
    $str_result .= '<th scope = "col">gg alla scadenza</th>';
    $str_result .= '<th scope = "col">Scadenza</th>';

    $query_farmaci_scadenza = " 
            SELECT f.nome as nome_farmaco, f.descrizione, f.dose, f.formato, DATEDIFF( fs.data_scadenza, DATE(NOW())) AS gg_rimasti, anag.id AS id_paziente, anag.nome, anag.cognome,
            (SELECT SUM(qta) FROM t_magazzino_farmaci mag WHERE mag.id_farmaco = f.id AND mag.id_paziente = fs.id_paziente AND mag.data_scadenza = fs.data_scadenza) AS residuo,
            fs.data_scadenza
            FROM t_farmaco f, t_magazzino_farmaci fs
            LEFT OUTER JOIN t_anagrafica anag ON anag.id = fs.id_paziente
            WHERE f.id = fs.id_farmaco
            AND  DATEDIFF( fs.data_scadenza, DATE(NOW())) <=" . $giorni_anticipo . "   
                GROUP BY f.nome, fs.id_paziente, fs.data_scadenza  
                ORDER by fs.data_scadenza asc"
    ;

    $result_first = mysqli_query($mysqli, $query_farmaci_scadenza);

    while ($row = mysqli_fetch_array($result_first)) {
        $str_result .= '<tr>';
        $str_result .= '<td>' . $row['nome_farmaco'] . '</td>';
        $str_result .= '<td>' . $row['dose'] . '</td>';
        $str_result .= '<td>' . $row['formato'] . '</td>';
        $str_result .= '<td>' . $row['nome'] . ' ' . $row['cognome'] . '</td>';
        $str_result .= '<td>' . $row['residuo'] . '</td>';
        $str_result .= '<td>' . $row['gg_rimasti'] . '</td>';
        $str_result .= '<td>' . $row['data_scadenza'] . '</td>';
        $str_result .= '</tr>';
    }
    $str_result .= '</table>';

    return $str_result;
}
