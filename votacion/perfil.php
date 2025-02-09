<?php
###############################################################################################################################################################
###############################################################################################################################################################
###                                                                                                                                                         ###
###                                                         DEMOKRATIAN versión 2.01                                                                        ###
###                                                         http://demokratian.org                                                                          ###
###                                    Copyright (C) 2014 CARLOS SALGADO WERNER (http://carlos-salgado.es)                                                  ###
###                                         Este programa ha sido creado por Carlos Salgado Werner                                                          ###
###                                                                                                                                                         ###
### Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia Pública General de GNU según es publicada por la ###
### Free Software Foundation, bien de la versión 2 de dicha Licencia o bien de cualquier versión posterior.                                                 ###
### Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin la garantía MERCANTIL implícita o sin garantizar   ###
### la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la Licencia Pública General de GNU para más detalles.                                               ###
### Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así, puede encontrarla en                        ###
### http://www.gnu.org/licenses/gpl-3.0.html                                                                                                                ###
### Si quieres participar en la mejora de este software ,eres libre de hacerlo,                                                                             ###
### También puedes contactar con migo en el correo info@demokratian.org para trabajar en el desarrollo de forma colaborativa                                ###
###                                                                                                                                                         ###
###                                          Por favor, no elimines este aviso de licencia                                                                  ###
###                                                                                                                                                         ###
###############################################################################################################################################################
###############################################################################################################################################################
require ("../inc_web/verifica.php");

$nivel_acceso=11; 
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
include ('../basicos_php/basico.php');
$id=fn_filtro_numerico($con,$_GET['idgr']);

  $result=mysqli_query($con,"SELECT * FROM $tbn7 where id=$id");
  $row=mysqli_fetch_row($result);

 
 ?>


<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Ayuda</title>  
</head>
<body>
   
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" >x</a>
                            <!--    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                               <h4 class="modal-title"><?php echo $row[3];?></h4>
                 
            </div>            <!-- /modal-header -->
            <div class="modal-body">
  
  <?php if ($row[13] != "") { ?>
	<a href="<?php echo "$row[13]";?> " target="_blank">Ver vídeo de presentación</a><br/>
  <?php } ?>
  

 <?php echo $row[2];?>
 
 
               
    <!--
===========================  fin texto ayuda
-->             </div>            <!-- /modal-body -->
                       <!-- /modal-footer -->
        </div>         <!-- /modal-content -->
     
   <!-- <script src="../js/jquery-1.9.0.min.js"></script>
    <script src="../js/jqBootstrapValidation.js"></script>
     <script src="../js/contact_error.js"></script>-->
    
</body>
</html>