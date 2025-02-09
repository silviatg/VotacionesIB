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

include("../basicos_php/basico.php") ;


if(ISSET($_POST["inprod12"])){
	
$pass1=fn_filtro($con,$_POST['pass1']);
$pass2=fn_filtro($con,$_POST['pass2']);

	if ($pass1=="" or $pass2=="" ) {
	$texto1= "<div class=\"alert alert-danger\"> 
             <a class=\"close\" data-dismiss=\"alert\">x</a>Faltan datos</div>";
	}
	elseif ($pass1 != $pass2){
	$texto1= "<div class=\"alert alert-danger\"> 
             <a class=\"close\" data-dismiss=\"alert\">x</a>password no coinciden</div>";
	}
		else{
		$passw = md5($pass1);
		$sSQL12="UPDATE $tbn9 SET pass='$passw' WHERE ID='".$_SESSION['ID']."'";
		mysqli_query($con,$sSQL12)or die ("Imposible modificar datos");
		$texto1="<div class=\"alert alert-success\"> 
             <a class=\"close\" data-dismiss=\"alert\">x</a>Realizadas las Modificaciones</div>";
		}
}


		if(ISSET($_POST["modifka_perfil"])){	
		$perfil=fn_filtro($con,$_POST['perfil']);
		$sSQL12="UPDATE $tbn9 SET  perfil='$perfil' WHERE ID='".$_SESSION['ID']."'";
		mysqli_query($con,$sSQL12)or die ("Imposible modificar datos");
		$texto1="<div class=\"alert alert-success\"> 
             <a class=\"close\" data-dismiss=\"alert\">x</a>Realizadas las Modificaciones</div>";
		}


		if(ISSET($_POST["modifika_imagen"])){
			
			/**
 *
 * HTML5 Image uploader with Jcrop
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Script Tutorials
 * http://www.script-tutorials.com/
 */

function uploadImageFile($upload_user) { // Note: GD library is required for this function


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $iWidth = $iHeight = 200; // desired image result dimensions
        $iJpgQuality = 90;

        if ($_FILES) {

            // if no errors and size less than 250kb
            if (! $_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 250 * 1024) {
                if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {

                    // new unique filename
					$name_pic= md5(time().rand());
                    $sTempFileName = $upload_user.'/' . $name_pic;

                    // move uploaded file into cache folder
                    move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);

                    // change file permission to 644
                    @chmod($sTempFileName, 0644);

                    if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
                        $aSize = getimagesize($sTempFileName); // try to obtain image info
                        if (!$aSize) {
                            @unlink($sTempFileName);
                            return;
                        }

                        // check for image type
                        switch($aSize[2]) {
                            case IMAGETYPE_JPEG:
                                $sExt = '.jpg';

                                // create a new image from file 
                                $vImg = @imagecreatefromjpeg($sTempFileName);
                                break;
                            /*case IMAGETYPE_GIF:
                                $sExt = '.gif';

                                // create a new image from file 
                                $vImg = @imagecreatefromgif($sTempFileName);
                                break;*/
                            case IMAGETYPE_PNG:
                                $sExt = '.png';

                                // create a new image from file 
                                $vImg = @imagecreatefrompng($sTempFileName);
                                break;
                            default:
                                @unlink($sTempFileName);
                                return;
                        }

                        // create a new true color image
                        $vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );

                        // copy and resize part of an image with resampling
                        imagecopyresampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth, $iHeight, (int)$_POST['w'], (int)$_POST['h']);

                        // define a result image filename
                        $sResultFileName = $sTempFileName . $sExt;

                        // output image to file
                        imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
                        @unlink($sTempFileName);

                        //return $sResultFileName;
						return $name_pic. $sExt;
                    }
                }
            }
        }
    }
}
////miramos en la BBDD si hay fotos
 $result=mysqli_query($con, "SELECT imagen_pequena FROM $tbn9 WHERE id ='".$_SESSION['ID']."' ");
  $row=mysqli_fetch_row($result);

if($row[0]!="peq_usuario.jpg"){
$thumb_photo_exists=$upload_user."/".$row[0];




$sImage = uploadImageFile($upload_user);

		if (file_exists($thumb_photo_exists)) {
				unlink($thumb_photo_exists);
			}
		}
		$_SESSION['imagen']=$sImage; /////imagen del usuario

$sSQL12="UPDATE $tbn9 SET  imagen_pequena='$sImage' WHERE ID='".$_SESSION['ID']."'";
	mysqli_query($con,$sSQL12)or die ("Imposible modificar datos");			
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
       
        
        
        <div class="col-md-7">
        <h3>MODIFICAR DATOS PERSONALES</h3>
			<?php 
				unset($_SESSION["user_file_ext"]); ///borramos la sesion que se ha generado en upload_crop.php para que no de problemas si se ha añadido mal el tumbail 
		
			  $result=mysqli_query($con,"SELECT ID,nombre_usuario, correo_usuario,usuario,apellido_usuario, 
						imagen_pequena, perfil,imagen,nif,telefono FROM $tbn9 WHERE id ='".$_SESSION['ID']."' ");
			  $row=mysqli_fetch_row($result);
			
		  
			  ////pequeño scrip por si el usuario ha añadido solo la imagen grande pero no le ha dado al boton de generar tumbail para borrarla
			  if($row[7]!="usuario.jpg" && $row[5]=="peq_usuario.jpg"){	
			$large_image_location = $upload_path.$row[7];
			if (file_exists($large_image_location)) {
				unlink($large_image_location);
			}
				$image="usuario.jpg";
				$sSQL12="UPDATE $tbn9 SET  imagen='$image' WHERE ID='".$_SESSION['ID']."'";
				mysqli_query($con,$sSQL12)or die ("Imposible modificar datos");
			}
	  
 ?>


		<?php echo"$texto1";?>
        
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method=post class="well" >
        <table width="95%" border="0"  >
          <tr>
            <td >Usuario:<strong> <?php echo"$row[3]";?></strong></td>
          </tr>
          <tr>
            <td>Nombre: <strong><?php echo $_SESSION['nombre_usu'];?> </strong></td>
          </tr>
          <tr>
            <td width="27%">NIF: <strong><?php echo"$row[8]";?></strong></td>
          </tr>
          <tr>
            <td width="27%">Correo electronico: <strong><?php echo"$row[2]";?></strong></td>
          </tr>
          <tr>
            <td width="27%">Teléfono: <strong><?php echo"$row[9]";?></strong></td>
          </tr>		
          <tr>
            <td width="27%"><br/><i>* Sus datos personales se necesitan para su identificación como votante. Si necesita cambiar su teléfono de contacto o correo electrónico, puede solicitarlo desde el apartado "Notificar un problema".</i></td>
          </tr>			  
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>Modificar contraseña:</strong></td>
          </tr>		  
          <tr>
            <td > 
              Password  <div class="control-group">
                    <div class="controls">
                <input name="pass1" type="password" id="pass1" value="" class="form-control" />         
              <p class="help-block"></p>
		   </div>
	         </div> 	
                <div class="control-group">
                  <div class="controls">
           Password (repitalo)             
              <input name="pass2" type="password" id="pass2" value=""class="form-control" / > 
               <p class="help-block"></p>
		   </div>
	         </div> 
               <input name="inprod12" type="submit" id="inprod12" value="modificar password" class="btn btn-primary pull-right" />          </td>
          </tr>
		  
		  <?php if ($mostrar_todas_opciones=="S") {  //STG: De momento no funcionan los grupos, así que no sirve de nada el perfil público. Quito la foto, porque no funcionaba la subida.?>
          <tr>
            <td colspan="2"> </td>
          </tr>
          <tr>
            <td colspan="2" >Foto
            <?php if($row[5]=="peq_usuario.jpg" or $row[5]=="" ){?><img src="../temas/<?php echo "$tema_web"; ?>/imagenes/avatar_sin_imagen.jpg" width="70" height="70" /><?php }else{?><img src="<?php echo $upload_user; ?>/<?php echo"$row[5]";?>" alt="<?php echo"$row[1]";?> <?php echo"$row[4]";?>" width="70" height="70"  /> <?php }?>             
            <p>&nbsp;</p>
          <a  href="user_crop.php?id=<?php echo  "$row[0]" ?>" title="Imagen de <?php echo  "$row[1]" ?>" data-target="#imagen_contacta"  class="btn btn-primary " >Modificar imagen</a>
          
          
          </td></tr>
          <tr>
            <td>
            <label for="perfil"></label></td>
          </tr>
          <tr>
            <td colspan="2">
            <div class="control-group">
                  <div class="controls">
              Perfil publico
              <textarea name="perfil"  id="perfil"  rows="10" cols="100" class="form-control" ><?php echo"$row[6]";?></textarea> 
             <p class="help-block"></p>
            </div>
            </div>
            <input name="modifka_perfil" type="submit"  id="modifka_perfil" value="modificar texto perfil" class="btn btn-primary pull-right" /></td>
              </tr>
			  
			  
			<?php } ?>
          </table>

      </form>
       
  
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
<!--
========================== segunda ventana modal 
-->


 <div class="modal fade" id="imagen">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                        <a class="close" data-dismiss="modal" >x</a>
                            <!--    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                               <h4 class="modal-title">Contactar</h4>
                        </div>
                        
              <div class="modal-body">
				<p> Si quieres contactar, completa este formulario y en breve te contestaremos</p>
                <p> Asegurate de que escribes bien tu direccion de correo </p> 
             
             
             
                <?php // include("upload_crop.php") ;?>
                
			</div>
            
			
             
             </div>
        </div>
</div>
<!--
===========================  fin segunda ventana modal
-->



  <div id="footer" class="row">
   <?php  include("ayuda.php"); ?>
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
<script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
   
  </body>
</html>