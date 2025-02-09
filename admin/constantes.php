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
include('../inc_web/seguri_nivel.php');
$nivel_acceso=0; if ($nivel_acceso = $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
include("../basicos_php/modifika_config.php") ;
include ('../basicos_php/basico.php');

$file="../inc_web/config.inc.php";

if(ISSET($_POST["modifika_general"])){
$com_string="email_env=\"";	
$find=$com_string.fn_filtro_nodb($_POST['valor']);	
$replace=$com_string.fn_filtro_nodb($_POST['direccion_general']);	
	find_replace($find, $replace, $file, $case_insensitive = true);
}
if(ISSET($_POST["modifika_error"])){
$com_string="email_error=\"";	
$find=$com_string.fn_filtro_nodb($_POST['valor']);	
$replace=$com_string.fn_filtro_nodb($_POST['direccion_general']);	
	find_replace($find, $replace, $file, $case_insensitive = true);
}
if(ISSET($_POST["modifika_control"])){
$com_string="email_control=\"";	
$find=$com_string.fn_filtro_nodb($_POST['valor']);	
$replace=$com_string.fn_filtro_nodb($_POST['direccion_general']);	
	find_replace($find, $replace, $file, $case_insensitive = true);
}
if(ISSET($_POST["modifika_tecnico"])){
$com_string="email_error_tecnico=\"";	
$find=$com_string.fn_filtro_nodb($_POST['valor']);	
$replace=$com_string.fn_filtro_nodb($_POST['direccion_general']);	
	find_replace($find, $replace, $file, $case_insensitive = true);
}
if(ISSET($_POST["modifika_sistema"])){
$com_string="email_sistema=\"";	
$find=$com_string.fn_filtro_nodb($_POST['valor']);	
$replace=$com_string.fn_filtro_nodb($_POST['direccion_general']);	
	find_replace($find, $replace, $file, $case_insensitive = true);
}
if(ISSET($_POST["modifika_url"])){
$com_string="url_de_la_web=\"";	
$find=$com_string.fn_filtro_nodb($_POST['valor']);	
$replace=$com_string.fn_filtro_nodb($_POST['direccion_general']);	
	find_replace($find, $replace, $file, $case_insensitive = true);
}

if(ISSET($_POST["modifika_nombre"])){
$com_string="nombre_sistema=\"";	
$find=$com_string.fn_filtro_nodb($_POST['valor']);	
$replace=$com_string.fn_filtro_nodb($_POST['direccion_general']);	
	find_replace($find, $replace, $file, $case_insensitive = true);
}

if(ISSET($_POST["modifika_asunto"])){
$com_string="asunto=\"";	
$find=$com_string.fn_filtro_nodb($_POST['valor']);	
$replace=$com_string.fn_filtro_nodb($_POST['direccion_general']);	
	find_replace($find, $replace, $file, $case_insensitive = true);
}
if(ISSET($_POST["modifika_mens_error"])){
$com_string="asunto_mens_error=\"";	
$find=$com_string.fn_filtro_nodb($_POST['valor']);	
$replace=$com_string.fn_filtro_nodb($_POST['direccion_general']);	
	find_replace($find, $replace, $file, $case_insensitive = true);
}
if(ISSET($_POST["modifika_web"])){
$com_string="nombre_web=\"";	
$find=$com_string.fn_filtro_nodb($_POST['valor']);	
$replace=$com_string.fn_filtro_nodb($_POST['direccion_general']);	
	find_replace($find, $replace, $file, $case_insensitive = true);
}
if(ISSET($_POST["modifika_tema"])){
$com_string="tema_web=\"";	
$find=$com_string.fn_filtro_nodb($_POST['valor']);	
$replace=$com_string.fn_filtro_nodb($_POST['direccion_general']);	
	find_replace($find, $replace, $file, $case_insensitive = true);
}


include('../inc_web/config.inc.php');
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
        
        
        
        <div class="col-md-10">
        

                   
                   <!--Comiezo-->
          <h2>Constantes de configuración </h2>
                   <table width="100%" border="0"  class="table table-striped">
                     <tr>
                       <th width="34%" scope="row">&nbsp;</th>
                       <td width="8%">&nbsp;</td>
                       <td width="25%">&nbsp;</td>
                       <td width="33%">&nbsp;</td>
                     </tr>
                     <tr>
                       <th scope="row">Direccion de correo general</th>
                       <td width="8%">&nbsp;</td>
                       <td width="25%"><?php echo $email_env; ?></td>
                       <td width="33%">
                         <form name="form1" method="post" action=""> 
                         <input name="direccion_general" type="email" autofocus required class="form-control" id="direccion_general"  placeholder="Direccion de correo" value="<?php echo $email_env; ?>" >
                         <input name="valor" type="hidden" id="valor" value="<?php echo $email_env; ?>" >
                         <input type="submit" name="modifika_general" id="modifika_general" value="modificar" class="btn btn-primary pull-right" >
						 </form></td>
                     </tr>
                     <tr>
                       <th scope="row">Sitio al que enviamos los correos de los que tienen problemas y no estan en la bbdd, este correo es el usado si no hay datos en la bbdd de los contactos por provincias</th>
                       <td>&nbsp;</td>
                       <td><?php echo $email_error; ?></td>
                       <td><form name="form1" method="post" action=""> 
                         <input name="direccion_general" type="email" autofocus required class="form-control" id="direccion_general"  placeholder="Direccion de correo" value="<?php echo $email_error; ?>" >
                         <input name="valor" type="hidden" id="valor" value="<?php echo $email_error; ?>" >
                         <input type="submit" name="modifika_error" id="modifika_error" value="modificar" class="btn btn-primary pull-right" >
						 </form></td>
                     </tr>
                     <tr>
                       <th scope="row">Direccion que envia el correo para el control con interventores</th>
                       <td>&nbsp;</td>
                       <td><?php echo $email_control; ?></td>
                       <td><form name="form1" method="post" action=""> 
                         <input name="direccion_general" type="email" autofocus required class="form-control" id="direccion_general"  placeholder="Direccion de correo" value="<?php echo $email_control; ?>" >
                         <input name="valor" type="hidden" id="valor" value="<?php echo $email_control; ?>" >
                         <input type="submit" name="modifika_control" id="modifika_control" value="modificar" class="btn btn-primary pull-right" >
						 </form></td>
                     </tr>
                     <tr>
                       <th scope="row">Correo electronico del responsable tecnico</th>
                       <td>&nbsp;</td>
                       <td><?php echo $email_error_tecnico; ?></td>
                       <td><form name="form1" method="post" action=""> 
                         <input name="direccion_general" type="email" autofocus required class="form-control" id="direccion_general"  placeholder="Direccion de correo" value="<?php echo $email_error_tecnico; ?>" >
                         <input name="valor" type="hidden" id="valor" value="<?php echo $email_error_tecnico; ?>" >
                         <input type="submit" name="modifika_tecnico" id="modifika_tecnico" value="modificar" class="btn btn-primary pull-right" >
						 </form></td>
                     </tr>
                     <tr>
                       <th scope="row">Correo electronico del sistema, demomento incluido en el envio de errores de la bbdd</th>
                       <td>&nbsp;</td>
                       <td><?php echo $email_sistema; ?></td>
                       <td><form name="form1" method="post" action=""> 
                         <input name="direccion_general" type="email" autofocus required class="form-control" id="direccion_general"  placeholder="Direccion de correo" value="<?php echo $email_sistema; ?>" >
                         <input name="valor" type="hidden" id="valor" value="<?php echo $email_env; ?>" >
                         <input type="submit" name="modifika_sistema" id="modifika_sistema" value="modificar" class="btn btn-primary pull-right" >
						 </form></td>
                     </tr>
                     <tr>
                       <th scope="row">&nbsp;</th>
                       <td>&nbsp;</td>
                       <td>&nbsp; </td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <th scope="row">Tipo de envio de correo</th>
                       <td>&nbsp;</td>
                       <td><?php 
						if($correo_smtp==true){
							echo " SMTP";
						}else{
							echo "Mail";
						} ?></td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <th scope="row">Usuario de correo </th>
                       <td>&nbsp;</td>
                       <td><?php echo $user_mail; ?></td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <th scope="row"> Host del correo</th>
                       <td>&nbsp;</td>
                       <td><?php echo $host_smtp; ?></td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <th scope="row">&nbsp;</th>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <th scope="row">url de la web de la votacion,(ojo  barra final)</th>
                       <td>&nbsp;</td>
                       <td><?php echo $url_vot; ?></td>
                       <td><form name="form1" method="post" action=""> 
                         <input name="direccion_general" type="text" autofocus required class="form-control" id="direccion_general"  value="<?php echo $url_vot; ?>" >
                         <input name="valor" type="hidden" id="valor" value="<?php echo $url_vot; ?>" >
                         <input type="submit" name="modifika_url" id="modifika_url" value="modificar" class="btn btn-primary pull-right" >
						 </form></td>
                     </tr>
                     <tr>
                       <th scope="row"> Nombre del sistema cuando se envia el correo de recupercion de clave</th>
                       <td>&nbsp;</td>
                       <td><?php echo $nombre_sistema; ?></td>
                       <td><form name="form1" method="post" action=""> 
                         <input name="direccion_general" type="text" autofocus required class="form-control" id="direccion_general"  value="<?php echo $nombre_sistema; ?>" >
                         <input name="valor" type="hidden" id="valor" value="<?php echo $nombre_sistema; ?>" >
                         <input type="submit" name="modifika_nombre" id="modifika_nombre" value="modificar" class="btn btn-primary pull-right" >
						 </form></td>
                     </tr>
                     <tr>
                       <th scope="row">Asunto del correo para recuperar la contraseña</th>
                       <td>&nbsp;</td>
                       <td><?php echo $asunto; ?></td>
                       <td><form name="form1" method="post" action=""> 
                         <input name="direccion_general" type="text" autofocus required class="form-control" id="direccion_general"  value="<?php echo $asunto; ?>" >
                         <input name="valor" type="hidden" id="valor" value="<?php echo $asunto; ?>" >
                         <input type="submit" name="modifika_asunto" id="modifika_asunto" value="modificar" class="btn btn-primary pull-right" >
						 </form></td>
                     </tr>
                     <tr>
                       <th scope="row">asunto del mensaje de correo cuando hay problemas de acceso</th>
                       <td>&nbsp;</td>
                       <td><?php echo $asunto_mens_error; ?></td>
                       <td><form name="form1" method="post" action=""> 
                         <input name="direccion_general" type="text" autofocus required class="form-control" id="direccion_general"  value="<?php echo $asunto_mens_error; ?>" >
                         <input name="valor" type="hidden" id="valor" value="<?php echo $asunto_mens_error; ?>" >
                         <input type="submit" name="modifika_mens_error" id="modifika_mens_error" value="modificar" class="btn btn-primary pull-right" >
						 </form></td>
                     </tr>
                     <tr>
                       <th scope="row">Nombre del sitio web</th>
                       <td>&nbsp;</td>
                       <td><?php echo $nombre_web; ?></td>
                       <td><form name="form1" method="post" action=""> 
                         <input name="direccion_general" type="text" autofocus required class="form-control" id="direccion_general"  value="<?php echo $nombre_web; ?>" >
                         <input name="valor" type="hidden" id="valor" value="<?php echo $nombre_web; ?>" >
                         <input type="submit" name="modifika_web" id="modifika_web" value="modificar" class="btn btn-primary pull-right" >
						 </form></td>
                     </tr>
                     <tr>
                       <th scope="row"> Nombre del tema (carpeta donde se encuentra)</th>
                       <td>&nbsp;</td>
                       <td><?php echo $tema_web; ?></td>
                       <td><form name="form1" method="post" action=""> 
                         <input name="direccion_general" type="text" autofocus required class="form-control" id="direccion_general"  value="<?php echo $tema_web; ?>" >
                         <input name="valor" type="hidden" id="valor" value="<?php echo $tema_web; ?>" >
                         <input type="submit" name="modifika_tema" id="modifika_tema" value="modificar" class="btn btn-primary pull-right" >
						 </form></td>
                     </tr>
                     
                   </table>
                   
                   
                   <!--Final-->
        
  
        </div>      
  </div>
 

  <div id="footer" class="row">
   <?php  include("../votacion/ayuda.php"); ?>
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
<script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
   
  </body>
</html>