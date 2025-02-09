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


$result=mysqli_query($con,"SELECT  correo_usuario FROM $tbn9 WHERE id ='".$_SESSION['ID']."' ");
$row=mysqli_fetch_row($result);
$email2  = $row[0];
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
                               <h4 class="modal-title">Notificar un  problema</h4>
                 
            </div>            <!-- /modal-header -->
            <div class="modal-body">
 <h3>  Si crees que hay un error o tienes algun problema, rellena este formulario:</h3>
   
      
  
 <form method="post" name="formulario_Contacto" class="well" id="formulario_Contacto" >
     <p>Hola soy <?php echo $_SESSION['nombre_usu'];?>, de la provincia de <?php echo $_SESSION['provincia']; ?> y mi direccion de Email es:&nbsp; <?php echo $email2; ?></p>
       <input name="nombre2" id="nombre2"  type="hidden" value="<?php echo $_SESSION['nombre_usu'];?>">
       <input name="email2" id="email2" type="hidden" value=" <?php echo $email2; ?>">
       <input name="provincia2" id="provincia2" type="hidden" value="<?php echo $_SESSION['localidad']; ?>">
        Quiero contactar con
        
        <div class="control-group">
                    <div class="controls">
          <label>
            <input name="contacto" type="radio" id="contacto_0" value="admin" checked>
            Administrador provincial</label>
          <br>
          <label>
            <input type="radio" name="contacto"  id="contacto_1" value="tecni">
          </label>
            Responsable tecnico      
             <p class="help-block"></p>
		   </div>
	         </div> 	
             
             
                <div class="control-group">
                  <div class="controls">
                 
                    <label for="asunto"> Asunto: </label>
                    <input type="text" class="form-control" placeholder="Asunto a tratar" id="asunto" required data-validation-required-message="Por favor, complete este campo" />
                     <p class="help-block"></p>
		   		 </div>
	          </div> 
             
             
             
                <div class="control-group">
                  <div class="controls">
                  
              <textarea rows="10" cols="100" class="form-control" 
                       placeholder="Cuentanos el problema" id="texto" required
		       data-validation-required-message="Cuentanos el problema" minlength="5" 
                       data-validation-minlength-message="Min 5 characteres" 
                        maxlength="999" style="resize:none"></textarea>    
               <p class="help-block"></p>
                   </div>
                 </div> 
             
             
             	<p class="letra_pequeña">Por favor, si has encontrado algún error, intenta darnos  todos los detalles y datos para intentar localizarlo, si puedes hacer una  captura de pantalla del error, indícanoslo por si necesitamos contactar contigo  para recabar más información</p>
                 <div id="success2"> </div> 
				  <button type="submit" class="btn btn-primary pull-right">Enviar</button>
    <br/>   
  		 </form>
 
 
 
               
    <!--
===========================  fin texto ayuda
-->             </div>            <!-- /modal-body -->
                       <!-- /modal-footer -->
        </div>         <!-- /modal-content -->
   
    <script src="../js/jquery-1.9.0.min.js"></script>
    <script src="../js/jqBootstrapValidation.js"></script>
     <script src="../js/contact_error.js"></script>
    
</body>
</html>