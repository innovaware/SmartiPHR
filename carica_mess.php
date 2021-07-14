<?php

require('db_config_server.php');

if (!isset($_SESSION)) {
    session_start();
}

 $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
 
$sql = "SELECT m.username as mittente,m.testo as testo ,m.letto as letto FROM z_utentiweb z
                        inner join t_messaggi m on m.id_dest = z.id_utente
                        where z.username= '" .$_SESSION['username']."'  or m.username= '" .$_SESSION['username']."'";

$result = $mysqli->query($sql);


while($row = $result->fetch_array(MYSQLI_ASSOC)){
  $data[] = $row;
}


$results = ["sEcho" => 1,
        	"iTotalRecords" => count($data),
        	"iTotalDisplayRecords" => count($data),
        	"aaData" => $data ];


echo json_encode($results);

 
?>



