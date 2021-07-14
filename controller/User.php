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
    if ($_POST['operation'] == 'autenticateUser') {
        autenticateUser($_POST['username'], $_POST['password']);
    }
    if ($_POST['operation'] == 'insertUser') {
        insertUser($_POST['nome'], $_POST['cognome'], $_POST['mail'], $_POST['tipo_utente'], $_POST['descr_utente']);
    }
    if ($_POST['operation'] == 'resetPassword') {
        resetPassword($_POST['user'], $_POST['password'], $_POST['sec_token']);
    }
    if ($_POST['operation'] == 'inviaResetPassword') {
        inviaResetPassword($_POST['username']);
    }
    if ($_POST['operation'] == 'getListaUtenti') {
        echo getListaUtenti($_POST['funzione'], $_POST['check']);
    }
    
    
    if ($_POST['operation'] == 'invioMessaggi') {
        echo invioMessaggi($_POST['testo'], $_POST['id_utente'], $_POST['id_tipologia']);
    }
       
    if ($_POST['operation'] == 'getListaMessaggi') {
        echo getListaMessaggi();
    }
    
    
     if ($_POST['operation'] == 'letturaMessaggi') {
        echo letturaMessaggi();
    }
}

function autenticateUser($username, $password) {

    if (!isset($_SESSION)) {
        session_start();
    }

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $username = trim(addslashes($username)); /* evito SQL-Injection */
    $password = trim(addslashes($password));

    $password_codificata = cryptoPassword($password);

    $controllo = mysqli_query($mysqli, "SELECT * FROM z_utentiweb WHERE username='$username' AND pass='$password_codificata' ") or die(mysqli_error($mysqli));

    $quantiutenti = mysqli_num_rows($controllo);
    /* se ho un riscontro positivo */
    if ($quantiutenti == 1) {
        if ($row = mysqli_fetch_array($controllo)) {
            $_SESSION["application"] = 'SmartiPHR';

            $id_dip = $row["id_utente"];

            $_SESSION["username"] = strtoupper($username);
            $_SESSION["id_dip"] = $id_dip;
            $_SESSION["nome"] = $row["nome"];
            $_SESSION["cognome"] = $row["cognome"];
            $_SESSION["livello"] = $row["livello"];
            $_SESSION["sede"] = $row["sede"];
            $_SESSION["mail"] = $row["mail"];

            $_SESSION['sec_token'] = cryptoPassword($row["nome"] . $row["id_utente"] . $row["cognome"]);
            //setcookie("id", $id, time() + (86400 * 30), "/");

            $_SESSION['perm_opt'] = array();

            $query_funz_opt = "
                    SELECT perm.id as id_perm, livello, descrizione FROM z_permessi perm, z_perm_user permus
                    WHERE perm.id = permus.id_permesso
                    AND permus.id_dip = '" . $id_dip . "' 
                    AND perm.livello = 0
                    order by posizione";
            $res_funz_opt = mysqli_query($mysqli, $query_funz_opt);
            $string_result = '';
            while ($row_funz_opt = mysqli_fetch_array($res_funz_opt)) {

                $query_dett = " 
                    SELECT * 
                    FROM z_permessi perm, z_perm_user permus
                    WHERE perm.id = permus.id_permesso
                    AND permus.id_dip = '" . $id_dip . "' 
						  AND perm.livello = 1
						  AND id_padre = '" . $row_funz_opt['id_perm'] . "' 
						  
                    order by posizione ";
                
                //echo json_encode($query_dett);
                $res_dett = mysqli_query($mysqli, $query_dett);
                $array_dett = array();
                while ($row_dett = mysqli_fetch_array($res_dett)) {
                    $array_dett[$row_dett['descrizione']] = $row_dett['url'];
                }


                $array_temp = array();
                $array_temp [$row_funz_opt['descrizione']] = $array_dett;
                $_SESSION['perm_opt'][$row_funz_opt['descrizione']] = $array_dett;
                //array_push($_SESSION['perm_opt'], $array_temp);
            }

            $ip = get_client_ip_env();
            $message = 'Accesso riuscito al portale Smart iPHR<br> Indirizzo IP di collegamento: ' . $ip;
            sendMail('info@smartiphr.it', 'Smart iPHR - InnovaWare', $_SESSION["mail"], $_SESSION["nome"] . ' ' . $_SESSION["cognome"], 'Accesso al portale Smart iPHR', $message);

            $res = array();
            $res['stato'] = '100';
            echo json_encode($res);
        }
        mysqli_free_result($controllo);
    } else {

        $res = array();
        $res['stato'] = '-100';
        echo json_encode($res);
    }
    mysqli_close($mysqli);
}

function insertUser($nome, $cognome, $mail, $tipo_utente, $descr_utente) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $WEB_SERVER_HOST = getServerHost();
    $res = array();

    $username = strtolower(replaceAccenti($cognome) . '' . substr($nome, 0, 1));

    $password = 'Temp.2019';
    $hashedPassword = cryptoPassword($password);
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_verifica_utente = "SELECT * FROM z_utentiweb WHERE username = '" . $username . "' ";
    $result = mysqli_query($mysqli, $query_verifica_utente);

    if (mysqli_num_rows($result) > 0) {
        $query_update_user = " UPDATE z_utentiweb SET pass = '" . $hashedPassword . "' WHERE username = '" . $username . "'  ";
        $result_first = mysqli_query($mysqli, $query_update_user);
        $res['stato'] = '200';
    } else {
        $sec_token = cryptoPassword($nome . $cognome . $mail);
        $query_insert_user = " INSERT INTO z_utentiweb (username, pass, nome, cognome, mail, sec_token, tipo_utente, descr_utente) "
                . " VALUES  "
                . " ('" . $username . "', '" . $hashedPassword . "','" . $nome . "','" . $cognome . "','" . $mail . "', '" . $sec_token . "', '" . $tipo_utente . "', '" . $descr_utente . "') ";
        $result_first = mysqli_query($mysqli, $query_insert_user);

        $message = '<div>Username per accesso al portale:' . $username . '</div>
                    <div> Il portale è accessibile al seguente indirizzo <a href="http://' . $WEB_SERVER_HOST['server'] . '/SmartiPHR/">http://' . $WEB_SERVER_HOST['server'] . '/SmartiPHR/</a></div>
                    <div>Effettuare il primo accesso per selezionare la password al seguente link: 
                 <a href="http://' . $WEB_SERVER_HOST['server'] . '/SmartiPHR/reset-password/' . $sec_token . '">Primo Accesso</a></div>';

        sendMail('dataevolution19@gmail.com', 'Smart iPHR - InnovaWare', $mail, $nome . ' ' . $cognome, 'Attivazione account portale', $message);

        
     
        $res['stato'] = ($result_first) ? '100' : '-100';
    }
    mysqli_close($mysqli);

    echo json_encode($res);
}

function resetPassword($user, $password, $sec_token) {
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);

    $query = " UPDATE z_utentiweb 
               SET pass = '" . cryptoPassword($password) . "', sec_token=''
               WHERE username= '" . $user . "'
               and sec_token = '" . $sec_token . "' 
                ";

    $result = mysqli_query($mysqli, $query);

    $res = array();
    $res['query'] = $query;
    $res['stato'] = mysqli_affected_rows($mysqli) == 1 ? '100' : '-100';
    mysqli_close($mysqli);
    echo json_encode($res);
}

function inviaResetPassword($user) {
    $WEB_SERVER_HOST = getServerHost();
    
    
    $password = '1nn0v4.2019';
    $hashedPassword = cryptoPassword($password);

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query_verifica_utente = "SELECT * FROM z_utentiweb WHERE username = '" . $user . "' ";
    $result = mysqli_query($mysqli, $query_verifica_utente);
    while ($row = mysqli_fetch_array($result)) {
        $sec_token = cryptoPassword($row['nome'] . $row['cognome'] . $row['mail']);
        $update_token = " UPDATE z_utentiweb SET sec_token = '" . $row['pass'] . "' where username = '" . $user . "' ";
        $res_update_token = mysqli_query($mysqli, $update_token);

        $message = '<div>Username per accesso al portale:' . $user . '</div>
                    <div> Il portale è accessibile al seguente indirizzo <a href="http://' . $WEB_SERVER_HOST['server'] . '/SmartiPHR">http://' . $WEB_SERVER_HOST['server'] . '/SmartiPHR</a></div>
                    <div>Effettuare il primo accesso per resettare la password al seguente link: 
                    <a href="http://' . $WEB_SERVER_HOST['server'] . '/SmartiPHR/reset-password/' . $row['pass'] . '">Primo Accesso</a></div>';

       
        sendMail('dataevolution19@gmail.com', 'Smart iPHR - InnovaWare', $row['mail'], $row['nome'] . ' ' . $row['cognome'], 'Attivazione account portale', $message);
    }
    return 'Reset inviato';

}

function checkPermission() {
    $path = substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * 
             from z_perm_user permu, z_permessi p 
             where permu.id_permesso = p.id
             and permu.id_dip = '" . $_SESSION['id_dip'] . "'
             and p.url = '" . $path . "'  ";
    $result = mysqli_query($mysqli, $query);
    $result = (mysqli_num_rows($result) > 0) ? true : false;
    mysqli_close($mysqli);
    return $result;
}

function getFunzioni() {
    if (!isset($_SESSION)) {
        session_start();
    }
    $string_result = '';
    foreach ($_SESSION['perm_opt'] as $value) {
        $string_result .= '<a class="dropdown-item" href="' . $value['url'] . '">' . $value['descrizione'] . '</a>';
    }

    return $string_result;
}

function getMenuDinamico() {
    if (!isset($_SESSION)) {
        session_start();
    }
    $string_result = '';
    foreach ($_SESSION['perm_opt'] as $key => $value) {
        $url="#";
        if($key == 'Ospiti'){
            $url='ges-pazienti';
             $string_result .= '<li><a  href="/' . 'SmartiPHR' . '/' . $url . '">Ospiti</a></li>';
        }else{
            
        $string_result .= '<li>
                    <a href="'.$url.'"><i class="fa fa-home"></i> <span class="nav-label">
                        ' . $key . '
                   </span> <span class="fa arrow"></span></a> <ul class="nav nav-second-level">';
            foreach ($value as $menu_item_key => $menu_item_val) {
                $string_result .= '<li><a  href="/' . 'SmartiPHR' . '/' . $menu_item_val . '">' . $menu_item_key . '</a></li>';
            }
            
             $string_result .= ' </ul>
                </li>';
        }
       
    }



    return $string_result;
}

function cryptoPassword($password) {
    /* $options = [
      'cost' => 11,
      ];
      // Get the password from post
      $passwordFromPost = $password;
      $hashedPassword = password_hash($passwordFromPost, PASSWORD_BCRYPT, $options);
      return $hashedPassword;
     */
    return hash('sha512', $password);
}

function getListaUtenti($function_admin, $check = 'NO') {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from z_utentiweb order by cognome, nome ";

    $res_dipendenti = mysqli_query($mysqli, $query);
    $str_result = '';
    $str_result .= '<div class="table-responsive">';
    $str_result .= '<table class = "table table-hover">';
    $str_result .= '<thead> <tr>';
    $str_result .= $check == 'SI' ? '<th scope = "col">' . '<input id="seleziona_tutti_check" type="checkbox"> ' . '</th>' : '';
    $str_result .= '<th scope = "col">Cognome</th>';
    $str_result .= '<th scope = "col">Nome</th>';
    $str_result .= '<th scope = "col">e-mail</th>';
    if ($function_admin == 'SI')
        $str_result .= '<th scope = "col">user</th>';
    $str_result .= '</tr></thead><tbody>';

    while ($row = mysqli_fetch_array($res_dipendenti)) {
        $str_result .= '<tr>';

        $str_result .= $check == 'SI' ? '<th scope = "col">' . '<input class="lista_check" name="valoriSelezionati" type="checkbox" value="' . $row["mail"] . '"/>' . '</th>' : '';
        $str_result .= '<td>' . $row['cognome'] . '</td>';
        $str_result .= '<td>' . $row['nome'] . '</td>';
        $str_result .= '<td>' . $row['mail'] . '</td>';
        if ($function_admin == 'SI') {
            $str_result .= '<td>' . $row['username'] . '</td>';
            $str_result .= '<td><button class="btn btn-danger btn_ges_permission" data-username="' . $row['username'] . '">Permessi</button</td>';
            $str_result .= '<td><button class="btn btn-danger btn_invia_reset" data-username="' . $row['username'] . '">Reset password</button</td>';
            
        }
        $str_result .= '</tr>';
    }
    $str_result .= '
                </tbody>
        </table>
        </div>';
    mysqli_close($mysqli);
    return $str_result;
}

function getTipoUser() {
    if (!isset($_SESSION)) {
        session_start();
    }
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from z_tipo_utente order by id";
    $res_tipo_utente = mysqli_query($mysqli, $query);
    $str_result = '<label for = "input_tipo_utente">Tipologia Utente</label>';
    $str_result .= '<select class = "form-control" id = "input_tipo_utente">';
    
    while ($row = mysqli_fetch_array($res_tipo_utente)) {
        $str_result .='<option value = "'.$row['id'].'">'.$row['descrizione'].'</option>';
    }
    $str_result .= '</select>';
    mysqli_close($mysqli);
    return $str_result;
}


function getDataUser(){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from t_anagrafica ";

    $result_utenti = mysqli_query($mysqli, $query);
    $str_result = '<label for = "input_data_utente">Ospite</label>';
    $str_result .= '<select class = "form-control" id="input_data_utente">';

    
    while ($row = mysqli_fetch_array($result_utenti)) {
        $str_result .='<option value = "'.$row['id'].'">'.$row['nome'].' '.$row['cognome'].'</option>';
    }
    $str_result .= '</select>';
    mysqli_close($mysqli);
    return $str_result;
}


function getDataUserEdit(){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    
    if (!isset($_SESSION)) {
        session_start();
    }
    $res = array();

    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
    $query = " select * from t_anagrafica ";

    $result_utenti = mysqli_query($mysqli, $query);
    $str_result = '<label for = "input_data_utente">Ospite</label>';
    $str_result .= '<select class = "form-control" id= "input_data_utente-edit" readonly>';

    
    while ($row = mysqli_fetch_array($result_utenti)) {
        $str_result .='<option value = "'.$row['id'].'">'.$row['nome'].' '.$row['cognome'].'</option>';
    }
    $str_result .= '</select>';
    mysqli_close($mysqli);
    return $str_result;
}



function invioMessaggi($testo,$id_utente,$id_tipologia){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
   
    $query_invio_mess="";
    
    $query_invio_mess = " INSERT INTO t_messaggi (username, testo, id_dest) "
                . " VALUES  ";
    if($id_utente != null){
        for($i = 0; $i < count($id_utente); $i++ ){
             $query_invio_mess.=" ('" . $_SESSION['username']. "', '" . $testo. "',".$id_utente[$i]."),";
     }
}
    
  
    
    if($id_tipologia != null){
        $str_id_tip = implode(",", $id_tipologia);
        $query_utenti = " SELECT * FROM `smartiphr`.`z_utentiweb` where tipo_utente in (".$str_id_tip.")";
        
        $result_utenti = mysqli_query($mysqli, $query_utenti);
         
       
        while ($row = mysqli_fetch_array($result_utenti)) {
            $query_invio_mess.=" ('" . $_SESSION['username']. "', '" . $testo. "',".$row['id_utente']."),";
        }
     }
    
    
     $query_invio_mess=substr($query_invio_mess,0,strlen($query_invio_mess) - 1);
    
    //return $query_invio_mess;
    $result_first = mysqli_query($mysqli, $query_invio_mess);
    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_invio_mess;
    mysqli_close($mysqli);

    echo json_encode($res);
    
    
}



function getListaMessaggi(){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
   
    $str_result="";
    
    $query_mess = " SELECT m.* FROM z_utentiweb z
                        inner join t_messaggi m on m.id_dest = z.id_utente
                        where z.username= '" .$_SESSION['username']."'  and m.letto='N'";
        
    $result_mess = mysqli_query($mysqli, $query_mess);
         
    if(mysqli_num_rows($result_mess) > 0){ 
        while ($row = mysqli_fetch_array($result_mess)) {
            $str_result .= '<tr>';
             $str_result .= '<td>' . $row['username'] . '</td>';
             $str_result .= '<td>' . $row['testo'] . '</td>';
             $str_result .= '<td><input type="checkbox" class="cb-mess-letti"  onclick="functionCheck('.$row['id'].')" id="'.$row['id'].'"></td>';
             $str_result .= '</tr>';
         }
         mysqli_close($mysqli);
         return $str_result;
    }
    else 
       return 0;   
}



function letturaMessaggi(){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
   
    $query_invio_mess="";
    $res = array();
    
    $d = new DateTime();
    
    $query_lettura_mess = " UPDATE t_messaggi set letto='S',"
                         . "data_lettura='".$d->format('Y-m-d')."'  "
                         . "where id_dest=( select id_utente FROM z_utentiweb where username='".$_SESSION['username']."')";
    
    
    
    $result_first = mysqli_query($mysqli, $query_lettura_mess);
    $res['stato'] = ($result_first) ? '100' : '-100';
    $res['query'] = $query_lettura_mess;
    mysqli_close($mysqli);

    echo json_encode($res);
}



function getListaAllMessaggi(){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $mysqli = new mysqli(DB_SERVER_FMAG, DB_USER_FMAG, DB_PASSWORD_FMAG, DB_DATABASE_FMAG);
   
    $str_result="";
    
    $query_mess = " SELECT m.* FROM z_utentiweb z
                        inner join t_messaggi m on m.id_dest = z.id_utente
                        where z.username= '" .$_SESSION['username']."'  or m.username= '" .$_SESSION['username']."'";
        
    $result_mess = mysqli_query($mysqli, $query_mess);
         
    if(mysqli_num_rows($result_mess) > 0){ 
        
        $str_result .= '<table id="tab-mess">
                        <thead>
                        <tr>
                            <th width="20%">Mittente</th>
                            <th width="78%">Testo</th>                                   
                            <th width="2%">letto</th>
                        </tr>
                        <tbody>';
        
        while ($row = mysqli_fetch_array($result_mess)) {
            $str_result .= '<tr>';
             $str_result .= '<td>' . $row['username'] . '</td>';
             $str_result .= '<td>' . $row['testo'] . '</td>';
             if($row['letto']  == 'S')
                $str_result .= '<td><input type="checkbox" class="cb-mess-letti"   id="'.$row['id'].'" checked disabled></td>';
             else
                $str_result .= '<td><input type="checkbox" class="cb-mess-letti"   id="'.$row['id'].'" disabled></td>';
             
             $str_result .= '</tr>';
         }
         
          $str_result .= '</tbody>
                        </table>';
          
         mysqli_close($mysqli);
         return $str_result;
    }
    else {
        $str_result .= '<h3> Non ci sono messaggi</h3>';
        
    }
       return $str_result;   
}