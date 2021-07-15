<?php
session_start(); // inizializzo la sessione

$nome_progetto = 'SmartiPHR';

require_once $_SERVER['DOCUMENT_ROOT'] . '/'.$nome_progetto.'/db_config_server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/'.$nome_progetto.'/utils.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/'.$nome_progetto.'/controller/User.php';


if (isset($_SESSION['application'])) {
    if ($_SESSION['application'] == $nome_progetto) {
        if (isset($_SESSION['id_dip']))
            header('location: /'.$nome_progetto.'/home');
    }
}
?>

<!DOCTYPE html>
<head>
 
    <!-- Metadata -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <?php
        echo getPageTitle();
        echo getFavicon();
        ?>	
 
    <link rel="stylesheet" href="/<?php echo $nome_progetto ?>/css/site.css" >

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
 
</head>

    <body>
        <div class="container" id="container-home">
            
            <div class="card-body border">
                    
                <center>
                    <img src="/SmartiPHR/img/logo.jpg">
                </center>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>Bentornato</li>
                    <li>Esegui l'accesso</li>
                </ul>

                <div class="md-form">   
                    <label for="input_username">Username</label>
                    <input type="text" class="form-control" id="input_username" placeholder="Username" required>

                </div>

                <div class="md-form" style="margin-top: 10px;">
                    <label for="input_password">Password</label>
                    <input type="password" class="form-control" id="input_password" placeholder="Password" required>

                </div>

                <!--label for="inputEmail" class="sr-only">Username </label>
                <input type="email" id="input_username" class="form-control" placeholder="Email" required autofocus>

                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="input_password" class="form-control" placeholder="Password" required-->

                <div class="form-group">
                    <button class="btn btn-primary btn-block btn-rounded z-depth-1a" id="btn_login">Login</button>
                </div>
                <!--button id="btn_login" class="btn btn-lg btn-primary btn-block" type="submit">Login</button-->
                <p id="div_auth_logger" class="mt-5 mb-3 text-muted"></p>
                <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>


            </div>

        </div>	
    </div>

        <script src="/<?php echo $nome_progetto ?>/js/jquery-3.1.1.min.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/popper.min.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/bootstrap.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>


    <!-- Peity -->
    <script src="/<?php echo $nome_progetto ?>/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/<?php echo $nome_progetto ?>/js/inspinia.js"></script>
    <script src="/<?php echo $nome_progetto ?>/js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="/<?php echo $nome_progetto ?>/js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/common.js"></script>



</body>


</html>