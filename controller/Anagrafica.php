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
    
    if ($_POST['operation'] == 'insertAnagrafica') {
        insertAnagrafica($_POST['nome'], $_POST['cognome'], $_POST['indirizzo'], $_POST['data_nasc'], $_POST['sesso'], $_POST['cap'], $_POST['localita'], $_POST['provincia']);
    }
    if ($_POST['operation'] == 'getListaAnagrafiche') {
        echo getListaAnagrafiche($_POST['func_admin'], $_POST['area']);
    }
    if ($_POST['operation'] == 'retrieveDivSearchPaziente') {
        echo retrieveDivSearchPaziente($_POST['search_text']);
    }
    
    if ($_POST['operation'] == 'getDatiPanelAnagrafica') {
        echo getDatiPanelAnagrafica($_POST['id_paziente']);
    }
    
    if ($_POST['operation'] == 'aggiornaListaAnagraficheAreaSocioPS') {
        echo getListaAnagraficheAreaSocioPS($_POST['func_admin'], $_POST['area']);
    }
    
    
    if ($_POST['operation'] == 'aggiornaListaAnagraficheAreaOSS') {
        echo getListaAnagraficheAreaOSS();
    }
}

function insertAnagrafica($nome, $cognome, $indirizzo, $data_nasc, $sesso, $cap, $localita, $provincia) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_insert_anag = " INSERT INTO t_anagrafica (nome, cognome, indirizzo, data_nasc, sesso, cap, localita, provincia) "
            . " VALUES  "
            . " ('" . $nome . "', '" . $cognome . "','" . $indirizzo . "','" . $data_nasc . "','" . $sesso . "', '" . $cap . "', '" . $localita . "', '" . $provincia . "') ";

    $result_first = mysqli_query($mysqli, $query_insert_anag);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_anag;
    mysqli_close($mysqli);

    echo json_encode($res);
}

function getListaAnagrafiche($function_admin, $area) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select anag.* , cartella_amm.id as id_cartella_amm, cartella_med.id as id_cartella_med, cartella_inf.id as id_cartella_inf 
                from t_anagrafica anag 
                LEFT OUTER JOIN t_cartella_amm_mast cartella_amm ON anag.id = cartella_amm.id_anag
                LEFT OUTER JOIN t_cartella_med_mast cartella_med ON anag.id = cartella_med.id_anag
                LEFT OUTER JOIN t_cartella_inf_mast cartella_inf ON anag.id = cartella_inf.id_anag
                order by anag.cognome, anag.nome ";

    $res_dipendenti = mysqli_query($mysqli, $query);
    
    $data = [];
    while ($row = mysqli_fetch_array($res_dipendenti)) {
        $actions = '';

        $obj = new stdClass();
        $obj->cognome = $row['cognome'];
        $obj->nome = $row['nome'];
        $obj->data_nasc = dataEn2It($row['data_nasc']); 

        $obj->indirizzo = $row['indirizzo'];
        $obj->localita = $row['localita'];
        $obj->provincia = $row['provincia'];

        if ($function_admin == 'SI' && $area == 0) {
            /*if ($row['id_cartella_amm'] == '') {
                $actions .= '<button class="btn btn-info btn_ins_cartella_clinica" 
                    data-nome="' . $row['nome'] . '"
                    data-cognome="' . $row['cognome'] . '"
                    data-id_anag="' . $row['id'] . '" 
                    data-sfx="amm"
                    data-toggle="modal" data-target="#modal_inserisci_cartella_clinica">AM</button>';
            } else {*/
                $actions .= '<button class="btn btn-warning btn_view_area_amm"  
                    data-id_cartella="' . $row['id_cartella_amm'] . '"  data-sfx="amm">AM</button>';
            //}
        }
        
        if ($function_admin == 'SI') {
           /* if ($row['id_cartella_med'] == '') {
                $actions .= '<button class="btn btn-info btn_ins_cartella_clinica" 
                    data-nome="' . $row['nome'] . '"
                    data-cognome="' . $row['cognome'] . '"
                    data-id_anag="' . $row['id'] . '" 
                    data-sfx="med"
                    data-toggle="modal" data-target="#modal_inserisci_cartella_clinica">CC</button>';
            } else {*/
                $actions .= '<button class="btn btn-warning btn_view_cartella_clinica"  
                    data-id_cartella="' . $row['id_cartella_med'] . '" data-id_anag="' . $row['id'] . '" data-sfx="med">CC</button>';
            //}
        }
        if ($function_admin == 'SI') {
           /* if ($row['id_cartella_inf'] == '') {
                $actions .= '<button class="btn btn-info btn_ins_cartella_clinica" 
                    data-nome="' . $row['nome'] . '"
                    data-cognome="' . $row['cognome'] . '"
                    data-id_anag="' . $row['id'] . '" 
                    data-sfx="inf"
                    data-toggle="modal" data-target="#modal_inserisci_cartella_clinica">CI</button>';
            } else {*/
                $actions .= '<button class="btn btn-warning btn_view_cartella_inf" 
                    data-id_cartella="' . $row['id_cartella_inf'] . '" data-id_anag="' . $row['id'] . '" data-sfx="inf">CI</button>';
            //}
        }
        
        
        
        if($area == 0){
        $actions .= '<button class="btn btn-warning btn_view_covid" 
            data-nome="' . $row['nome'] . '"
            data-cognome="' . $row['cognome'] . '"
            data-id_anag="' . $row['id'] . '" 
            data-sfx="amm">AC</button>'; 
        }        
        
            $obj->actions = $actions;
            array_push($data,$obj);
        
    }
    $results = ["sEcho" => 1,
        	"iTotalRecords" => count($data),
        	"iTotalDisplayRecords" => count($data),
        	"aaData" => $data ];


        echo json_encode($results);
}



function getListaAnagraficheAreaSocioPS($function_admin, $area) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select anag.* , cartella_amm.id as id_cartella_amm, cartella_med.id as id_cartella_med, cartella_inf.id as id_cartella_inf 
                from t_anagrafica anag 
                LEFT OUTER JOIN t_cartella_amm_mast cartella_amm ON anag.id = cartella_amm.id_anag
                LEFT OUTER JOIN t_cartella_med_mast cartella_med ON anag.id = cartella_med.id_anag
                LEFT OUTER JOIN t_cartella_inf_mast cartella_inf ON anag.id = cartella_inf.id_anag
                order by anag.cognome, anag.nome ";

    $res_dipendenti = mysqli_query($mysqli, $query);
    
    $data = [];
    while ($row = mysqli_fetch_array($res_dipendenti)) {
        $actions = '';

        $obj = new stdClass();
        $obj->cognome = $row['cognome'];
        $obj->nome = $row['nome'];
        $obj->data_nasc = dataEn2It($row['data_nasc']); 

        $obj->indirizzo = $row['indirizzo'];
        $obj->localita = $row['localita'];
        $obj->provincia = $row['provincia'];

        if ($area == 0) {
            $actions .= '<button class="btn btn-warning btn_view_area_cp"  
                data-id_cartella="' . $row['id_cartella_amm'] . '"   data-id_anag="' . $row['id'] . '">CP</button>';

        }
        
        else if ($area == 1) {

            $actions .= '<button class="btn btn-warning btn_view_area_ce"  
                  data-id_cartella="' . $row['id_cartella_med'] . '" data-id_anag="' . $row['id'] . '" data-sfx="med">CE</button>';

        }
        else{
            $actions .= '<button class="btn btn-warning btn_view_area_ce"  
                  data-id_cartella="' . $row['id_cartella_med'] . '" data-id_anag="' . $row['id'] . '" data-sfx="med">CFR</button>';
        }
        
        $obj->actions = $actions;
        array_push($data,$obj);
        
    }
    $results = ["sEcho" => 1,
        	"iTotalRecords" => count($data),
        	"iTotalDisplayRecords" => count($data),
        	"aaData" => $data ];


        echo json_encode($results);
}


function getListaAnagraficheAreaOSS() {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select anag.* , cartella_amm.id as id_cartella_amm, cartella_med.id as id_cartella_med, cartella_inf.id as id_cartella_inf 
                from t_anagrafica anag 
                LEFT OUTER JOIN t_cartella_amm_mast cartella_amm ON anag.id = cartella_amm.id_anag
                LEFT OUTER JOIN t_cartella_med_mast cartella_med ON anag.id = cartella_med.id_anag
                LEFT OUTER JOIN t_cartella_inf_mast cartella_inf ON anag.id = cartella_inf.id_anag
                order by anag.cognome, anag.nome ";

    $res_dipendenti = mysqli_query($mysqli, $query);
    
    $data = [];
    while ($row = mysqli_fetch_array($res_dipendenti)) {
        $actions = '';

        $obj = new stdClass();
        $obj->cognome = $row['cognome'];
        $obj->nome = $row['nome'];
        $obj->data_nasc = dataEn2It($row['data_nasc']); 

        
        $actions .= '<button class="btn btn-warning btn_view_area_cp"  
            data-id_cartella="' . $row['id_cartella_amm'] . '"   data-id_anag="' . $row['id'] . '">Ingresso</button>';


        $actions .= '<button class="btn btn-warning btn_view_area_ce"  
              data-id_cartella="' . $row['id_cartella_med'] . '" data-id_anag="' . $row['id'] . '" data-sfx="med">Attività quotidiane</button>';

        $actions .= '<button class="btn btn-warning btn_view_area_ce"  
              data-id_cartella="' . $row['id_cartella_med'] . '" data-id_anag="' . $row['id'] . '" data-sfx="med">Registro Consegne</button>';
        
        
        $obj->actions = $actions;
        array_push($data,$obj);
        
    }
    $results = ["sEcho" => 1,
        	"iTotalRecords" => count($data),
        	"iTotalDisplayRecords" => count($data),
        	"aaData" => $data ];


        echo json_encode($results);
}

function retrieveDivSearchPaziente($testo) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query =  "select id as codice, concat (nome, ' ', cognome) as descrizione from t_anagrafica where cognome like '%".$testo."%' OR nome like '%".$testo."%' ";

    $res_pazienti = mysqli_query($mysqli, $query);
    
    
    $string_result = '';
    $idtemp = 'select';
    $idn = 1;
    $selected = 'ac_selected';
    $marked = 'style="background-color:#b3e0ff"';
    while($row = mysqli_fetch_array($res_pazienti)){
        //$string_result .= '<div '.$marked.' class="ac_item_select ' . $selected . '" id="' . $idtemp . $idn . '" data-valore="' . $row['codice'] . '" data-position="' . $idn . '" data-selectlist="true" data-prev="' . $idtemp . ($idn - 1) . '" data-next="' . $idtemp . ($idn + 1) . '" data-desc_search="' . $row['descrizione']. '" data-id_is="' . $_POST['id_is'] . '" >' . $row['codice'] . ' ' . $row['descrizione']. '</div>';
        $string_result .= '<div '.$marked.' class="ac_item_select ' . $selected . '" id="' . $idtemp . $idn . '" data-valore="' . $row['codice'] . '" data-position="' . $idn . '" data-selectlist="true" data-prev="' . $idtemp . ($idn - 1) . '" data-next="' . $idtemp . ($idn + 1) . '" data-desc_search="' . $row['descrizione']. '" data-id_is="' . $_POST['id_is'] . '" >' . $row['descrizione']. '</div>';
        $idn++;
        $selected = '';
        $marked = '';
    }
    return $string_result;
}




function getDatiPanelAnagrafica($id_paziente) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query =  "select * from t_anagrafica where id=".$id_paziente;

    $res_paziente = mysqli_query($mysqli, $query);
    
    
    $result;

    while($row = mysqli_fetch_array($res_paziente)){
        //$string_result .= '<div '.$marked.' class="ac_item_select ' . $selected . '" id="' . $idtemp . $idn . '" data-valore="' . $row['codice'] . '" data-position="' . $idn . '" data-selectlist="true" data-prev="' . $idtemp . ($idn - 1) . '" data-next="' . $idtemp . ($idn + 1) . '" data-desc_search="' . $row['descrizione']. '" data-id_is="' . $_POST['id_is'] . '" >' . $row['codice'] . ' ' . $row['descrizione']. '</div>';
        $result = $row;
   }
    return json_encode($result);
}

