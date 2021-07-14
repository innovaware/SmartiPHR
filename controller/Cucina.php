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

    if ($_POST['operation'] == 'getListaMenu') {
        echo getListaMenu(5);
    }
    if ($_POST['operation'] == 'deleteMenu') {
        deleteMenu($_POST['id_menu']);
    }
     if ($_POST['operation'] == 'insertMenu') {
        insertMenu($_POST['id_paziente'], $_POST['priorita'], $_POST['descrizione']);
    }
    if ($_POST['operation'] == 'editMenu') {
        editMenu($_POST['id'], $_POST['priorita'], $_POST['descrizione']);
    }
    if ($_POST['operation'] == 'getReportsMenu') {
       echo getListaReportsMenu($_POST['id_paziente']);
    }
    if ($_POST['operation'] == 'getMenuById') {
       echo getMenuById($_POST['id_menu']);
    }
  }

function getListaMenu($id_paziente) {
    
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_menu = " SELECT m.id,m.descrizione,m.priorita,a.nome,a.cognome,a.id as utente FROM t_menu m
                                inner join t_anagrafica a on a.id = m.id_paziente ";
    
    if($id_paziente != 0)
        $query_menu=$query_menu." where m.id_paziente =".$id_paziente;

    $res_menu = mysqli_query($mysqli, $query_menu);
    $str_result = '';
    $str_result .= '<div class="table-responsive">';
    $str_result .= '<table class = "table table-hover">';
    $str_result .= '<thead> <tr>';


    $str_result .= '<th scope = "col">Nome</th>';
    $str_result .= '<th scope = "col">Cognome</th>';
    $str_result .= '<th scope = "col">Priorità</th>';
    $str_result .= '<th scope = "col">Descrizione</th>';
    $str_result .= '<th scope = "col" width="100px"></th>';
    $str_result .= '<th scope = "col" width="100px"></th>';


    $str_result .= '</tr></thead><tbody>';
    while ($row = mysqli_fetch_array($res_menu)) {
        $str_result .= '<tr>';

        $str_result .= '<td scope = "col">' . $row['nome'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['cognome'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['priorita'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['descrizione'] . '</td>';

        $str_result .= '<td scope = "col">';
        $str_result .= '<button class="btn btn-success btn-edit-menu" id_menu="' . $row['id'] . '" priorita="' . $row['priorita'] .'" descrizione="' . $row['descrizione'] .'" id_utente="' . $row['utente'] . '" >Modifica</button>';
        //$str_result .= '<img src="/SmartiPHR/img/ico_' . $stato . '.jpg">';
        $str_result .= '</td>';
        $str_result .= '<td scope = "col">';
        $str_result .= '<button class="btn btn-danger btn_del_menu" id_menu="' . $row['id'] . '">Elimina</button>';
        //$str_result .= '<img src="/SmartiPHR/img/ico_' . $stato . '.jpg">';
        $str_result .= '</td>';
        
        $str_result .= '</tr>';
    }
    mysqli_close($mysqli);
    return $str_result;
}

function getListaReportsMenu($id_paziente) {
    if (!isset($_SESSION)) {
        session_start();
    }   
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_menu = " SELECT m.id,m.descrizione,m.priorita,a.nome,a.cognome,a.id as utente FROM t_menu m
                                inner join t_anagrafica a on a.id = m.id_paziente where priorita = 1 ";
    
    if($id_paziente != 0)
        $query_menu=$query_menu." and m.id_paziente =".$id_paziente;
    
    //return $query_menu;

    $res_menu = mysqli_query($mysqli, $query_menu);
    $str_result = '';
    $str_result .= '<div class="table-responsive">';
    $str_result .= '<table class = "table table-hover">';
    $str_result .= '<thead> <tr>';


    $str_result .= '<th scope = "col">Nome</th>';
    $str_result .= '<th scope = "col">Cognome</th>';
    $str_result .= '<th scope = "col">Priorità</th>';
    $str_result .= '<th scope = "col">Descrizione</th>';
    $str_result .= '<th scope = "col" width="100px"></th>';


    $str_result .= '</tr></thead><tbody>';
    while ($row = mysqli_fetch_array($res_menu)) {
        $str_result .= '<tr>';

        $str_result .= '<td scope = "col">' . $row['nome'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['cognome'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['priorita'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['descrizione'] . '</td>';
        $str_result .= '<td scope = "col">';
        $str_result .= '<button class="btn btn_dettaglio_rep_menu" id_menu="' . $row['id'] . '">Vedi dettaglio</button>';
        $str_result .= '</td>';

       $str_result .= '</tr>';
    }
    mysqli_close($mysqli);
    return $str_result;
}


function getMenuById($id_menu) {
    if (!isset($_SESSION)) {
        session_start();
    }   
    
    $res = array();
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_menu = " SELECT m.descrizione,m.priorita,a.nome,a.cognome FROM t_menu m
                                inner join t_anagrafica a on a.id = m.id_paziente where m.id =".$id_menu;
   
    $res_menu = mysqli_query($mysqli, $query_menu);
    
    while ($row = mysqli_fetch_array($res_menu)) {
        
        $res['menu']=(object) [
                                'nome' => $row['nome'].' '.$row['cognome'],
                                'descrizione' => $row['descrizione'],
                              ];
    }
    
    $res['stato'] = ($res_menu) ? '100' : '-100';
    $res['query'] = $query_menu;
    mysqli_close($mysqli);
     
    echo json_encode($res);
}

function insertMenu($id_paziente, $priorita, $descrizione) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_insert_menu = " insert into t_menu (id_paziente,priorita,descrizione)"
                               . " VALUES  "
                               . " ('" . $id_paziente . "', '" . $priorita . "','" . $descrizione . "') ";

    $result_first = mysqli_query($mysqli, $query_insert_menu);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_menu;
    mysqli_close($mysqli);

    echo json_encode($res);
}

function deleteMenu($id_menu) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_delete_menu = " 
                DELETE FROM t_menu
                WHERE id='" . $id_menu."'";
    
  

    $result_first = mysqli_query($mysqli, $query_delete_menu);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_delete_menu;
    mysqli_close($mysqli);

    echo json_encode($res);
}

function editMenu($id, $priorita, $descrizione) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_upd_menu = " UPDATE t_menu SET priorita=". $priorita ." , descrizione='". $descrizione ."' where id=".$id."";
    $result_first = mysqli_query($mysqli, $query_upd_menu);
    
    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_upd_menu;
    mysqli_close($mysqli);

    echo json_encode($res);
    
}