<?php

if (!isset($_SESSION)) {
    session_start();
}

$nome_progetto = 'SmartiPHR';

require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/db_config_server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/utils.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/view/utils_view.php';
//require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/controller/Dipendente.php';


if (!isset($_SESSION['application']))
    header("location: /'.$nome_progetto.'");

if (!isset($_SESSION["id_dip"]))
    header("location: /'.$nome_progetto.'");
/*
 * if (!isset($_SESSION) == $nome_progetto)
  header("location: /'.$nome_progetto.'");
 * 
 */
?>




<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta charset="utf-8">

<?php
echo getPageTitle();
echo getFavicon();
?>	
       <link rel="stylesheet" href="/<?php echo $nome_progetto ?>/css/site.css" >

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" >
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    </head>
    <body>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/controller/User.php';
echo getNavBar();
?>

        <div class="container">
            <button class="btn btn-primary" id="btn_blocco_amministrativo" >Blocco Amministrativo</button>
            <button class="btn btn-primary" id="btn_blocco_sanitario" >Blocco Sanitario</button>

        </div>	
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" ></script>

    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/common.js"></script>
    

</body>


</html>