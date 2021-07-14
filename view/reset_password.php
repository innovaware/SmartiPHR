<?php
if (!isset($_SESSION)) {
    session_start();
}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$nome_progetto = 'SmartiPHR';

require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/db_config_server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/utils.php';
?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php
echo getPageTitle();
echo getFavicon();
?>	
         <link rel="stylesheet" href="/<?php echo $nome_progetto ?>/css/site.css" >

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" >
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        
        <link rel="stylesheet" href="./styles/form.css">
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">
                <img src="/<?php echo $_SESSION['application'] ?>/img/android-icon-36x36.png" width="30" height="30" class="d-inline-block align-top" alt="">
            </a>
        </nav>

        <div class="container">

            <div>

                <div class="form-group">
                    <label for="input_user">User</label>
                    <input type="text" class="form-control" id="input_user" placeholder="">
                </div>
                <div class="form-group">
                    <label for="input_password">Password</label>
                    <input type="password" class="form-control" id="input_password" placeholder="">
                </div>
                <div class="form-group">
                    <label for="input_conferma_password">Conferma Password</label>
                    <input type="password" class="form-control" id="input_conferma_password" placeholder="">
                </div>
                <input type="hidden" id="input_sec_token" value="<?php echo $_GET['sec_token']; ?>">
                <button class="btn btn-danger" id="btn_reset_password">Registra</button>

                <div id="div_logger">
                </div>
            </div>



        </div>	


        <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" ></script>

        <script type="text/javascript" src="/<?php echo $_SESSION['application']  ?>/js/user.js"></script>

    </body>


</html>