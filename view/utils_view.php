<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!isset($_SESSION)) {
    session_start();
}

function getNavBar() {
    ?>
    <nav class="navbar navbar-expand-lg navbar-light " style="background-color: #F3F3F3">
        <a class="navbar-brand" href="/SmartiPHR/">
            <img src="/<?php echo $_SESSION['application'] ?>/img/android-icon-36x36.png" width="30" height="30" class="d-inline-block align-top" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link " href="#" tabindex="-1" aria-disabled="true"><?php echo $_SESSION['nome'] . ' ' . $_SESSION['cognome']; ?></a>
                </li>
                <!--li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li-->
                <!--li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Archivi
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="ges-user">Aggiungi utenti</a>
                        
                        
                        <div class="dropdown-divider"></div>
                        
                        
                       
                    </div>
                </li-->




                <!-- Menu dinamico in base ai permessi-->
                <?php
                echo getMenuDinamico();
                ?>






                <li class="nav-item" id="btn_logout">
                    <a class="nav-link" href="#">Disconnetti</a>
                </li>

            </ul>
            <!--form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form-->
        </div>
    </nav>
    <?php
}
