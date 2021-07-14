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
    
    <link rel="stylesheet" type="text/css" href="/SmartiPHR/ext/calendar/styles/styles.css">
    <link rel="stylesheet" href="/<?php echo $nome_progetto ?>/css/site.css" >
    <!-- CSS Files -->
    <link href="/<?php echo $nome_progetto ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="/<?php echo $nome_progetto ?>/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/<?php echo $nome_progetto ?>/css/animate.css" rel="stylesheet">
    <link href="/<?php echo $nome_progetto ?>/css/style.css" rel="stylesheet">
 
</head>
<body>

<div id="wrapper">
         <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nome_progetto . '/controller/User.php';
         echo getSideBar(); ?>
    
        <div id="page-wrapper" class="gray-bg">
            
        <?php echo getnewNavBar(); ?>
      <div class="wrapper wrapper-content">
          
          
           <?php echo getModalNuovomessaggio(); ?>
          
          <div id="modal_lista_mess" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-width" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Benvenuto.Hai dei nuovi messaggi da leggere!</h3>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <table id="tab-mess">
                                <thead>
                                <tr>
                                    <th width="20%">Mittente</th>
                                    <th width="78%">Testo</th>                                   
                                    <th width="2%"></th>
                                </tr>
                                <tbody>
                                </tbody>
                             </table>
                        </div>
                        
                        
                     
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="btn_conferma_lettura" data-sfx="" disabled>Conferma</button>
                    </div>
                </div>
            </div>
        </div>
          
        
        <div id="modal_inserisci_evento" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserisci evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col col-6">
                                <div class="form-group">
                                    <label for="input_data_evento">Data evento</label>
                                    <input type="datetime-local" class="form-control" id="input_data_evento" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_descrizione">Descrizione</label>
                            <input type="text" class="form-control" id="input_descrizione" placeholder="Descrizione" >
                        </div>

                        <button class="btn btn-primary" id="btn_salva_evento" tipo_vista="mese">Registra Evento</button>
                        <div id="div_logger">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--button type="button" class="btn btn-primary">Save changes</button-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        <!--div class="container"-->
        <div id="cal_container">
        </div>
        <!--/div-->	
      </div>
 
  </div>
            
</div>


    <!-- Mainly scripts -->
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
    <script type="text/javascript" src="/<?php echo $nome_progetto ?>/js/home.js"></script>
    <script type="text/javascript" src ="/SmartiPHR/ext/calendar/calendar.js"></script>



    <script type="text/javascript">
        aggiornaVistaMese('<?php echo date('Y-m-01'); ?>');
        //aggiornaVistaSettimana('2019-06-01');
        
   function functionCheck(id) {
       //alert($('#'+id).prop('checked'));
        if($('#'+id).prop('checked') == true) {          
            var allCk = true;
            $('.cb-mess-letti').each (function() {
                 if(!this.checked) 
                     allCk = false;
                // do your cool stuff
              }); 
              $('#btn_conferma_lettura').prop('disabled',true); 
              if(allCk == true)
                 $('#btn_conferma_lettura').prop('disabled',false); 
        }
        else
           $('#btn_conferma_lettura').prop('disabled',true); 
    }
    
    
    $('#btn_conferma_lettura').click(function () { 
    //alert($("#sel_tip").val());
        $.ajax({
        url:  "/" + nome_progetto + "/controller/User.php",
        type: "POST",
        data: {operation: "letturaMessaggi"
        },
        success: function (res) {
            console.log(res);
            var obj_res = JSON.parse(res);
            if (obj_res.stato == 100){
                $('#modal_lista_mess').modal('hide');
            }
            else {
                 alert('Errore nell\a conferma lettura dei messaggi. Riprovare');
            }
        },
        error: function (rese) {
            alert(rese);
        }
    });
}) 
    
    
    
    $( document ).ready(function() {
            console.log( "ready!" );
            
             $.ajax({
                url:  "/" + nome_progetto + "/controller/User.php",
                type: "POST",
                data: {operation: "getListaMessaggi"
                },
                success: function (res) {
                    console.log(res == 0);
                    if(res != 0){
                    $("#tab-mess tbody").append(res);
                    $('#modal_lista_mess').modal('show');
                }
                },
                error: function (rese) {
                    alert(rese);
                }
            });
       
    

            
        });
        
        
    </script>

</body>


</html>