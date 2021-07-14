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

    if ($_POST['operation'] == 'getListaCollaboratori') {
        echo getListaCollaboratori();
    }
    
    if ($_POST['operation'] == 'insertCollaboratore') {
        insertCollaboratore($_POST['nome'], $_POST['cognome'], $_POST['indirizzo'], $_POST['data_nasc'], $_POST['sesso'], $_POST['cap'], $_POST['localita'], $_POST['provincia']);
    }
    
     if ($_POST['operation'] == 'insertAllegatoInMaster') {
        insertAllegatoInMaster($_POST['descrizione'], $_POST['rif_area']);
    }
    
     if ($_POST['operation'] == 'insertAllegatoSicurezza') {
        insertAllegatoSicurezza($_POST['id_mast'], $_POST['documento']);
    }
    
    if ($_POST['operation'] == 'retrieveListaAllegatiSicurezzaByDett') {
        echo retrieveListaAllegatiSicurezzaByDett($_POST['dett']);
    }
  }

function getListaCollaboratori() {
    
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_menu = " SELECT * FROM t_collaboratori ";
    

    $res_menu = mysqli_query($mysqli, $query_menu);
    $str_result = '';
    $str_result .= '<div class="table-responsive">';
    $str_result .= '<table class = "table table-hover">';
    $str_result .= '<thead> <tr>';

    $str_result .= '<th scope = "col">#</th>';
    $str_result .= '<th scope = "col">Cognome</th>';
    $str_result .= '<th scope = "col">Nome</th>';
    $str_result .= '<th scope = "col">Data nasc</th>';
    $str_result .= '<th scope = "col">Indirizzo</th>';
    $str_result .= '<th scope = "col">Località</th>';
    $str_result .= '<th scope = "col">PV</th>';
    $str_result .= '<th scope = "col" width="100px"></th>';


    $str_result .= '</tr></thead><tbody>';
    while ($row = mysqli_fetch_array($res_menu)) {
        $str_result .= '<tr>';
        $str_result .= '<td scope = "col">' . $row['id'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['cognome'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['nome'] . '</td>';        
        $str_result .= '<td scope = "col">' . $row['data_nasc'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['indirizzo'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['localita'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['provincia'] . '</td>';
        

        $str_result .= '<td scope = "col">';
        $str_result .= '<button class="btn btn-success btn-dettaglio-collab" id_collab="' . $row['id'] . '" >Vedi dettaglio</button>';
        $str_result .= '</td>';
        /*$str_result .= '<td scope = "col">';
        $str_result .= '<button class="btn btn-danger btn_certificato_idoneita" id_collab="' . $row['id'] . '">Certificato Idoneità</button>';
        $str_result .= '</td>';
        
         $str_result .= '<td scope = "col">';
        $str_result .= '<button class="btn btn-success btn-giudizio-idoneita" id_collab="' . $row['id'] . '" >Giudizio di idoneità alla mansione specifica</button>';
        $str_result .= '</td>';
        $str_result .= '<td scope = "col">';
        $str_result .= '<button class="btn btn-danger btn_libro_infortuni" id_collab="' . $row['id'] . '">Libro Infortuni</button>';
        $str_result .= '</td>';*/
        
        $str_result .= '</tr>';
    }
    mysqli_close($mysqli);
    return $str_result;
}


function insertCollaboratore($nome, $cognome, $indirizzo, $data_nasc, $sesso, $cap, $localita, $provincia) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_insert_anag = " INSERT INTO t_collaboratori (nome, cognome, indirizzo, data_nasc, sesso, cap, localita, provincia) "
            . " VALUES  "
            . " ('" . $nome . "', '" . $cognome . "','" . $indirizzo . "','" . $data_nasc . "','" . $sesso . "', '" . $cap . "', '" . $localita . "', '" . $provincia . "') ";

    $result_first = mysqli_query($mysqli, $query_insert_anag);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_anag;
    mysqli_close($mysqli);

    echo json_encode($res);
}


function insertAllegatoInMaster($descrizione, $rif_area) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_insert_alleg = " INSERT INTO t_master_doc_sicurezza (descrizione, rif_area) "
            . " VALUES  "
            . " ('" . $descrizione . "','" . $rif_area . "') ";

    $result_first = mysqli_query($mysqli, $query_insert_alleg);
    

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_alleg;
    $res['id'] = mysqli_insert_id($mysqli);
    
    mysqli_close($mysqli);

    echo json_encode($res);
}


function insertAllegatoSicurezza($id_mast, $documento) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();
    
    $data = new DateTime();
    $data_inserimento=$data->format('Y-m-d  H:m:s');
   // echo json_encode($_SERVER['DOCUMENT_ROOT'] . '/SmartiPHR/data/' . $_SESSION['username'] . '/' . $documento);
    
    
    $path_file='C:/xampp/htdocs/SmartiPHR/data/INNOVA/'.$documento;
    $dati_file = file_get_contents($path_file);
    //echo json_encode($dati_file);
    $dati_file = addslashes($dati_file);
    
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_insert_alleg = " INSERT INTO t_dett_doc_sicurezza (id_mast, data_inserimento,documento) "
            . " VALUES  "
            . " (" . $id_mast . ",'" . $data_inserimento . "','". $dati_file."')";
    //echo json_encode($query_insert_alleg);
    

    $result_first = mysqli_query($mysqli, $query_insert_alleg);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_alleg;
    mysqli_close($mysqli);

    echo json_encode($res);
}

function retrieveListaAllegatiSicurezzaByDett($dett) {
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_allegati = " 
                       SELECT s.id as id,s.id_mast,s.data_inserimento as data,s.documento,m.descrizione,m.rif_area FROM t_dett_doc_sicurezza s
                        inner join t_master_doc_sicurezza  m on s.id_mast = m.id
                        where m.descrizione='" . $dett ."'  order by s.data_inserimento";
    $result = mysqli_query($mysqli, $query_allegati);
    
    //echo json_encode($query_allegati);
    $str_result = '';
    $str_result .= '<table class="table table-bordered">';
    while ($row = mysqli_fetch_array($result)) {
         $str_result .= '<tr>';
        $str_result .= '<th scope="row">' . $row['data'] . '</th>';
        $str_result .= '<td>' . $row['rif_area'] . '';
        $str_result .= '</td>';
        $str_result .= '<td>' . '<a href="/SmartiPHR/view/view_allegato?sfx=doc&id_allegato=' . $row['id'] . '" target="_blank">' . $row['descrizione'] . '</a><br>'. '</td>';
        $str_result .= '</tr>';
        //$str_result .= '<a href="/SmartiPHR/view/view_allegato?id_allegato=' . $row['id'] . '" target="_blank">' . $row['rif_area'] . '</a><br>';
    }
    $str_result .= '</table>';
    mysqli_close($mysqli);
    return $str_result;
}


/*
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


    $str_result .= '</tr></thead><tbody>';
    while ($row = mysqli_fetch_array($res_menu)) {
        $str_result .= '<tr>';

        $str_result .= '<td scope = "col">' . $row['nome'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['cognome'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['priorita'] . '</td>';
        $str_result .= '<td scope = "col">' . $row['descrizione'] . '</td>';

       $str_result .= '</tr>';
    }
    mysqli_close($mysqli);
    return $str_result;
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
    
}*/