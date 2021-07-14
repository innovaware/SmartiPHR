<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$nome_progetto = 'SmartiPHR';

require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/db_config_server.php';
//require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/utils.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/bean/AnagraficaBean.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['operation'] == 'insertCartella') {
        insertCartella($_POST['sfx'], $_POST['id_anag'], $_POST['data_ricovero']);
    }

    if ($_POST['operation'] == 'insertDettaglioClinico') {
        insertDettaglioClinico($_POST['sfx'], $_POST['id_cartella'], $_POST['id_dett'], $_POST['data_diario'], $_POST['descr_diario']);
    }

    if ($_POST['operation'] == 'getRiepilogoDettaglio') {
        echo getRiepilogoDettaglio($_POST['sfx'], $_POST['id_cartella'], $_POST['id_dett']);
    }

    if ($_POST['operation'] == 'inserisciAllegato') {
        echo inserisciAllegato($_POST['sfx'], $_POST['id_dett'], $_POST['descrizione'], $_POST['file_name']);
    }
    if ($_POST['operation'] == 'retrieveDettaglioSpec') {
        echo retrieveDettaglioSpec($_POST['sfx'], $_POST['id_dett']);
    }
}

function insertCartella($sfx, $id_anag, $data_ricovero) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_insert_anag = " INSERT INTO t_cartella_" . $sfx . "_mast (id_anag, data_ricovero,operatore) "
            . " VALUES  "
            . " ('" . $id_anag . "','" . $data_ricovero . "','" . $_SESSION['username'] . "') ";

    $result_first = mysqli_query($mysqli, $query_insert_anag);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_anag;
    mysqli_close($mysqli);

    echo json_encode($res);
}

function insertDettaglioClinico($sfx, $id_cartella, $id_dett, $data_diario, $descr_diario) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_insert_diario = " INSERT INTO t_cartella_" . $sfx . "_dett (id_cartella, id_tipo_dett,  data, diario_clinico, operatore) "
            . " VALUES  "
            . " ('" . $id_cartella . "','" . $id_dett . "','" . $data_diario . "','" . $descr_diario . "','" . $_SESSION['username'] . "') ";

    $result_first = mysqli_query($mysqli, $query_insert_diario);

    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_insert_diario;
    $res['id_dett'] = mysqli_insert_id($mysqli);
    $res['sfx'] = $sfx;
    mysqli_close($mysqli);

    echo json_encode($res);
}

function retrieveAnagraficaFromIdCartella($sfx, $id_cartella) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from t_cartella_" . $sfx . "_mast where id ='" . $id_cartella . "' ";
    //echo $query;
    $result_first = mysqli_query($mysqli, $query);

    while ($row = mysqli_fetch_array($result_first)) {
        $anagrafica = retrieveAnagrafica($row['id_anag']);
    }
    mysqli_close($mysqli);
    return $anagrafica;
}


function getBodyCartella($sfx) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from t_tipo_dett where tipo_dett='" . $sfx . "' order by id ";

    $result_first = mysqli_query($mysqli, $query);

    while ($row = mysqli_fetch_array($result_first)) {
        ?>
        <div class="row">
            <div class="col-12 col-md-3 col-lg-3 ">
                <button id="btn_ins_dettaglio_<?php echo $row['id'] ?>" class="btn btn-info btn_ins_dettaglio" 
                        data-toggle="modal" data-target="#modal_inserisci_diario_clinico"
                        data-id_dett="<?php echo $row['id'] ?>" 
                        data-sfx="<?php echo $sfx ?>">
                            <?php echo $row['descrizione'] ?>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 ">
                <div id="div_riepilogo_<?php echo $row['id'] ?>" class="div_riepilogo_dettaglio" data-id_dett="<?php echo $row['id'] ?>" data-sfx="<?php echo $sfx ?>">

                </div>
            </div>

        </div>
        <?php
    }
    mysqli_close($mysqli);
}

function getRiepilogoDettaglio($sfx, $id_cartella, $id_dett) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " SELECT cart.*, tipo.*, cart.id AS id_dett
                FROM t_cartella_" . $sfx . "_dett cart, t_tipo_dett tipo
                WHERE cart.id_tipo_dett = tipo.id
                AND cart.id_cartella = '" . $id_cartella . "'
                AND tipo.id = '" . $id_dett . "'  order by data";
    //echo $query;
    $result_first = mysqli_query($mysqli, $query);
    $str_result = '';
    $str_result .= '<table class="table table-bordered">';
    while ($row = mysqli_fetch_array($result_first)) {
        $str_result .= '<tr>';
        $str_result .= '<th scope="row">' . $row['data'] . '</th>';
        $str_result .= '<td>' . $row['diario_clinico'] . '';
        $str_result .= '<br><button class="btn btn-outline-warning btn-sm btn_allega_modal" data-sfx="' . $sfx . '" data-id_dett="' . $row['id_dett'] . '" data-toggle="modal" data-target="#modal_inserisci_allegato"'
                . '>Allega documento</button>';
        $str_result .= '</td>';
        $str_result .= '<td>' . retrieveListaAllegatiByIdDett($sfx, $row['id_dett']) . '</td>';
        /* $str_result .= '<td><button class="btn btn-outline-warning btn-sm btn_allega_modal" data-sfx="' . $sfx . '" data-id_dett="' . $row['id_dett'] . '" data-toggle="modal" data-target="#modal_inserisci_allegato"'
          . '>Allega documento</button></td>';
         */
        $str_result .= '</tr>';
    }
    $str_result .= '</table>';
    mysqli_close($mysqli);
    return $str_result;
}

function retrieveAnagrafica($id_anag) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from t_anagrafica where id ='" . $id_anag . "' ";

    $result_first = mysqli_query($mysqli, $query);

    while ($row = mysqli_fetch_array($result_first)) {
        $anagrafica = new AnagraficaBean($row['nome'], $row['cognome'], $row['data_nasc'], $row['sesso'], $row['indirizzo'], $row['cap'], $row['localita'], $row['provincia'], $row['tel'], $row['riferimento']);
    }
    mysqli_close($mysqli);
    return $anagrafica;
}

function retrieveListaAllegati() {
    if (!isset($_SESSION)) {
        session_start();
    }
    $files = array();
    $str_result = '';
    if ($handle = opendir($_SERVER['DOCUMENT_ROOT'] . '/SmartiPHR/data/' . $_SESSION['username'])) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                //echo '<a href="/SmartiPHR/data/' . $_SESSION['username'] . '/' . $file . '" target="_blank">' . $file . '</a><br>';
                $str_result .= '<div><button class="btn btn-warning btn-sm btn_preview_pdf" data-file="' . $file . '" data-id_preview="id_' . str_replace('.', '', $file) . '">' . $file . '</button></div>';
                $str_result .= '<div id="id_' . str_replace('.', '', $file) . '" class="div_preview_pdf" style="display:none">';
                $str_result .= '<object data="/SmartiPHR/data/' . $_SESSION['username'] . '/' . $file . '" type="application/pdf" width="450" height="200">
                                    alt : <a href="/SmartiPHR/data/' . $_SESSION['username'] . '/' . $file . '">test.pdf</a>
                                </object> ';
                $str_result .= '</div>';
            }
        }
        closedir($handle);
    }
    return $str_result;
}

function inserisciAllegato($sfx, $id_dett, $descrizione, $file) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $dati_file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/SmartiPHR/data/' . $_SESSION['username'] . '/' . $file);
    $dati_file = addslashes($dati_file);
    echo $file;
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_insert_doc = " INSERT into t_allegati_" . $sfx . " (id_dett, descrizione, documento) "
            . " VALUES "
            . " ('" . $id_dett . "','" . $descrizione . "','" . ($dati_file) . "' )";
    echo $query_insert_doc;
    $result = mysqli_query($mysqli, $query_insert_doc);

    mysqli_close($mysqli);
}

function retrieveDettaglioSpec($sfx, $id_dett) {
    $tipo_subdett = retrieveTipoSubDett($id_dett);
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_spec_mast = " 
            SELECT distinct(nome_var)as nome_var, etichetta 
            FROM t_tipo_dett_spec WHERE id_tipo_dett= '" . $id_dett . "' GROUP BY nome_var";
    $result = mysqli_query($mysqli, $query_spec_mast);
    $str_result = '';
    while ($row = mysqli_fetch_array($result)) {
        $query_spec_dett = " SELECT * FROM t_tipo_dett_spec WHERE nome_var='".$row['nome_var']."' ";
        $res_dett = mysqli_query($mysqli, $query_spec_dett);
        $str_result .= $row['etichetta'];
        $str_result .= '<select name="'.$row['nome_var'].'" id="'.$row['nome_var'].'" class="form-control type_param" data-tipo_par="'.$tipo_subdett.'">';
        while ($row_dett = mysqli_fetch_array($res_dett)) {
            $str_result .= '<option value="'.$row_dett['chiave_par'].'"  >'.$row_dett['value_par'].'</option>'; 
        }
        $str_result .= '</select>';
        if($tipo_subdett == "TYPE_KEY_VALUE")
            $str_result .= '<input type="text" id="input_'.$row['nome_var'].'" class="form-control">';
    }
    mysqli_close($mysqli);
    return $str_result;
}

function retrieveTipoSubDett($id_dett) {
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_spec_mast = " 
            SELECT tipo_subdett  
            FROM t_tipo_dett WHERE id= '" . $id_dett . "' ";
    $result = mysqli_query($mysqli, $query_spec_mast);
    $str_result = '';
    while ($row = mysqli_fetch_array($result)) {
        $str_result = $row['tipo_subdett'];
    }
    mysqli_close($mysqli);
    return $str_result;
}

function retrieveListaAllegatiByIdDett($sfx, $id_dett) {
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_allegati = " 
            SELECT *
            FROM t_allegati_" . $sfx . "  
            WHERE id_dett = '" . $id_dett . "' ";
    $result = mysqli_query($mysqli, $query_allegati);
    $str_result = '';
    while ($row = mysqli_fetch_array($result)) {
        $str_result .= '<a href="/SmartiPHR/view/view_allegato?sfx=' . $sfx . '&id_allegato=' . $row['id'] . '" target="_blank">' . $row['descrizione'] . '</a><br>';
    }
    return $str_result;
}
