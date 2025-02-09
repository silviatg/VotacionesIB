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

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title><?php echo "$nombre_web"; ?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=" ">
    <meta name="author" content=" ">
    <link rel="icon"  type="image/png"  href="../temas/<?php echo "$tema_web"; ?>/imagenes/icono.png"> 
    
    
    
    <!—[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]—>
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
   <link href="../temas/<?php echo "$tema_web"; ?>/Jcrop/main.css" rel="stylesheet" type="text/css" /><!-- -->
    <link href="../temas/<?php echo "$tema_web"; ?>/Jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
    <link href="../temas/<?php echo "$tema_web"; ?>/estilo.css" rel="stylesheet">
  
  </head>
  <body>
  <!-- NAVBAR
================================================== -->
 <?php  include("../admin/menu_admin.php"); ?>
    
<!-- END NAVBAR
================================================== -->

 <div class="container">
 
    <!-- cabecera
    ================================================== -->
      <div class="page-header">
      <img src="../temas/<?php echo "$tema_web"; ?>/imagenes/cabecera_votaciones.jpg" class="img-responsive" alt="Logo <?php echo "$nombre_web"; ?>">
	  </div>
      
    <!-- END cabecera
    ================================================== -->
      <?php  include("../votacion/caja_mensajes_1.php"); ?>

       <div class="row">

        <div class="col-md-2" >             
          
          <?php  include("../votacion/menu_nav.php"); ?>
            
        </div>
       
        
        
        <div class="col-md-7">
        <h3>MODIFICAR IMAGEN  PERSONAL</h3>
			
            
            <div class="demo">
            
            <div class="bbody">

                <!-- upload form -->
                <form id="upload_form" enctype="multipart/form-data" method="post" action="user.php" onsubmit="return checkForm()" class="well">
                    <!-- hidden crop params -->
                    <input type="hidden" id="x1" name="x1" />
                    <input type="hidden" id="y1" name="y1" />
                    <input type="hidden" id="x2" name="x2" />
                    <input type="hidden" id="y2" name="y2" />

                    <h3>PASO 1: Por favor, seleccione una imagen</h3>
                    <div>
                      <p>
                        <input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" class="btn btn-primary "/>
                      </p>
                      <p>&nbsp; </p>
                    </div>

                    <div class="error"></div>

                    <div class="step2">
                      <p>&nbsp;</p>
                      <h3>PASO 2: Seleccione la zona de la imagen que desea recortar para usar como imagen personal</h3>
                        <img id="preview" />

                        <div class="info">
                            <label>Peso </label> <input type="text" id="filesize" name="filesize" />
                            <label>Tipo</label> <input type="text" id="filetype" name="filetype" />
                            <label>Tamaño</label> <input type="text" id="filedim" name="filedim" />
                            <label>Alto</label> <input type="text" id="w" name="w" />
                            <label>Ancho</label> <input type="text" id="h" name="h" />
                        </div>

                        <input name="modifika_imagen" type="submit" class="btn btn-primary pull-right" id="modifika_imagen" value="Modifica tu imagen"/>
                    </div>
                </form>
            </div>
        </div>
            
            
            
            
            
            
  
        </div>
        
          <div class="col-md-3">
         
		<?php  // include("../votacion/lateral_derecho.php"); ?>              
        </div>
      
  </div>
 

  <!--
===========================  modal para cambiar la imagen
-->
<div class="modal fade" id="imagen_contacta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          
            <div class="modal-body"></div>
            
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

 <!--
===========================  FIN modal para cambiar la imagen
-->



  <div id="footer" class="row">
   <?php  include("ayuda.php"); ?>
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
	<script src="../js/jquery-1.9.0.min.js"></script>
    <script src="../js/jquery-migrate-1.2.1.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
    <script src="../js/jquery.Jcrop.min.js"></script>
    <script src="../js/user_crop.js"></script>
  </body>
</html>