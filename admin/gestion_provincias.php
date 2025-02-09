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
$nivel_acceso=11; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}


if(ISSET($_POST["modifika_correo"])){
	
$id_provincia_mody= fn_filtro($con,$_POST['id_provincia_mody']);

$mail_expr = "/^[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*"
."@[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*$/";


if(empty($_POST['correo_error']))
{
$error = "error";
$mensaje = "<div class=\"alert alert-warning\">El e-mail del usuario es un dato requerido</div>";
}
elseif(!preg_match($mail_expr,$_POST['correo_error']))
{
$error = "error";
$mensaje="<div class=\"alert alert-warning\">la direccion es erronea</div>";
}  
else{

$correo_error= fn_filtro($con,$_POST[correo_error]);
$sSQL="UPDATE $tbn8 SET correo_notificaciones=\"$correo_error\" WHERE id='$id_provincia_mody'";
mysqli_query($con,$sSQL)or die ("Imposible modificar");
$mensaje="<div class=\"alert alert-success\">Modificado correo ".$correo_error." de la provincia numero ".$id_provincia_mody."</div>";
}
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
              <h1>Correos notificaciones Provincias</h1>
			
          
            <?php 


if($_SESSION['nivel_usu']==2){ 
$sql = "select DISTINCT id, provincia,correo_notificaciones from $tbn8  order by ID";

}
else if ($_SESSION['nivel_usu']==3){
	$ids_ccaa=$_SESSION['id_ccaa_usu'];	
	$sql = "SELECT  id, provincia,correo_notificaciones FROM $tbn8 where id_ccaa=$ids_ccaa";

}
else if ($_SESSION['nivel_usu']==4){
	$id_usu= $_SESSION['ID'];
	$sql = "SELECT  a.id, a.provincia,a.correo_notificaciones FROM $tbn8 a, $tbn5 b  where (a.id=b.id_provincia) and b.id_usuario='$id_usu'";

}
$result = mysqli_query($con, $sql);
if ($row = mysqli_fetch_array($result)){
	
	
?>
          </p>
         <?php echo $mensaje; ?>
            <form id="form1" name="form1" method="post" action="">

            <table width=99%   class="table table-striped" cellspacing="0" >
          
				<thead>
          <tr>
          <th width=5% align=center >Id</th>
          <th width=20% align=left >provincia</th>
          <th width=65% align=center >Correo para notificaciones de error</td>
          <th width=10% align=center >&nbsp;</th>
        </tr></thead>

				<tbody>
        
        <?php

mysqli_field_seek($result,0);

do {

 ?>
 
  <tr>
        <form id="<?php echo  "$row[1]" ?>" name="<?php echo  "$row[1]" ?>" method="post" action="">   
        <td><?php echo  "$row[0]" ?>
            </td>
          <td> <?php echo  utf8_encode($row[1]) ?> </td>
          <td> 
          <?php if ($row[0]=="000")
		  {
			 
			  include ("../inc_web/verifica.php");
			  echo"correo errores: $email_error <br/>";
			  echo"correo notificaciones: $email_env";
		  }
		  else{
		  
		  ?>
            
            <input name="correo_error" type="text"  class="form-control"  id="correo_error" value="<?php echo  "$row[2]" ?>" maxlength="200" />
            </td>
            
            <?php }?>
          <td> <?php if ($row[0]=="000")
		  {echo"&nbsp;";
			 }
		  else{
		  
		  ?> <input name="id_provincia_mody" type="hidden" id="id_provincia_mody" value="<?php echo  "$row[0]" ?>" /> <input name="modifika_correo" type="submit"  class="btn btn-primary btn-xs" id="modifika_correo" value="Modificar" /> <?php }?></td>
   </form>     </tr>
 
 
        
        <?php
}
while ($row = mysqli_fetch_array($result));



?>
  </tbody>
</table>
    <?php 
}

?>     
                
    
                    
  <!--Final-->
  <p>&nbsp;</p>
        </div>
        
         
      
  </div>
 

  <div id="footer" class="row">
    <!--
===========================  modal para apuntarse
-->
<div class="modal fade" id="apuntarme" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           
            <div class="modal-body"></div>
            
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

 <!--
===========================  FIN modal apuntarse
-->
   <?php  include("../votacion/ayuda.php"); ?>
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
<script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
  
  </body>
</html>