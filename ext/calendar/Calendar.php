<?php

$nome_progetto = 'SmartiPHR';

require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/db_config_server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/utils.php';

require_once $_SERVER['DOCUMENT_ROOT'].'/' . $nome_progetto . '/ext/calendar/CalendarBean.php';


if($_SERVER['REQUEST_METHOD']=='POST'){
	
	

	if($_POST['operation']=='aggiornaEvento'){
		
		echo aggiornaEvento($_POST['id_evento'], $_POST['nuova_data'], $_POST['nuova_ora']);
	}

	if($_POST['operation']=='retrieveVistaMese'){

		echo retrieveVistaMese($_POST['inizio_mese']);
	}

	if($_POST['operation']=='inserisciEvento'){
		
		echo inserisciEvento($_POST['data_evento'], $_POST['descrizione'],$_POST['id_dett'],$_POST['rif']);
	}

	if($_POST['operation']=='retrieveVistaSettimana'){
		echo retrieveVistaSettimana($_POST['inizio_mese']);	
	}

}
	




	function retrieveVistaMese($inizioMese){
		$mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);	
		//$inizioMese = "2019-06-01";
		$cal = new Calendar($mysqli);
		return $cal->retrieveVistaMese($inizioMese);

	}

	function retrieveVistaSettimana($inizioMese){
		$mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);	
		//$inizioMese = "2019-06-01";
		$cal = new Calendar($mysqli);
		return $cal->retrieveVistaSettimana($inizioMese);

	}

	function aggiornaEvento ($id_evento, $nuova_data, $nuova_ora){
		$mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
		if(isset($nuova_data)){
			if( $nuova_data<>'0000-00-00'){
				if($nuova_ora <>'99:99')
					$res = mysqli_query($mysqli, "UPDATE t_evento set data_evento = CONCAT('". $nuova_data." ', '".$nuova_ora."') where id='".$id_evento."' ");
				else
					$res = mysqli_query($mysqli, "UPDATE t_evento set data_evento = CONCAT('". $nuova_data." ', TIME(data_evento)) where id='".$id_evento."' ");
			}
			//echo "UPDATE t_evento set data_evento = CONCAT('".$_POST['nuova_data']." ', TIME(data_evento)) where id='".$_POST['id_evento']."' ";
		}

	}
	function inserisciEvento($data_evento, $descrizione, $id_dett='', $rif='', $tipo_evento='1'){
		$mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
		
		if($descrizione=='')
			return 'Inserire una descrizione';
		else if(substr($data_evento,11,5)=='00:00')
			return 'Inserire un orario';
		else{
			$res = mysqli_query($mysqli, "INSERT INTO t_evento (data_evento, descrizione, tipo_evento, rif_dett, rif_table) "
                                . " VALUES ('".$data_evento."','".$descrizione."','".$tipo_evento."','".$id_dett."','".$rif."')");
			if($res)
				return 'Inserimento effettuato con successo.';
			else
				return 'Errore nell\'inserimento.';
		}

	}






?>