<?php

$nome_progetto = 'SmartiPHR';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/db_config_server.php';

$sfx = $_GET['sfx'];
$id_allegato = $_GET['id_allegato'];

$mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

$query_allegati = " 
            SELECT *
            FROM t_allegati_" . $sfx . "  
            WHERE id = '" . $id_allegato . "' ";

if($sfx == 'doc')
    $query_allegati = " 
            SELECT *
            FROM t_dett_doc_sicurezza  
            WHERE id = '" . $id_allegato . "' ";

//echo $query_allegati;


$result = mysqli_query($mysqli, $query_allegati);



$tmp = mysqli_fetch_array($result);



// invio una intestazione contenente il tipo MIME
//header('Content-Type: ' . $tmp['f_tipo']);
//header('Content-Type: '.'image/jpeg');
header('Content-Type: '.'application/pdf');
// invio il contenuto del file
echo $tmp['documento'];

?>

