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
$nivel_acceso=7; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
include("../basicos_php/basico.php") ;

$id=fn_filtro_numerico($con,$_GET['id']);
$idvot=fn_filtro_numerico($con,$_GET['idvot']);

$ids_provincia= $_SESSION['localidad'];

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

function uploadImageFile($upload_cat) { // Note: GD library is required for this function

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $iWidth = $iHeight = 200; // desired image result dimensions
        $iJpgQuality = 90;

        if ($_FILES) {

            // if no errors and size less than 250kb
            if (! $_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 250 * 1024) {
                if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {

                    // new unique filename
					$name_pic= md5(time().rand());
                    $sTempFileName = $upload_cat.'/' . $name_pic;

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
 $result_img=mysqli_query($con, "SELECT imagen_pequena FROM $tbn7 WHERE id ='".$id."' ");
  $row_img=mysqli_fetch_row($result_img);
  $quants_img=mysqli_num_rows($result_img);
if($quants_img!=0){

if($row_img[0]!=""){
$thumb_photo_exists=$upload_cat."/".$row_img[0];
}



$sImage = uploadImageFile($upload_cat);

		if (file_exists($thumb_photo_exists)) {
				unlink($thumb_photo_exists);
			}
		}
		

$sSQL12="UPDATE $tbn7 SET  imagen_pequena='$sImage' WHERE ID='".$id."'";
	mysqli_query($con,$sSQL12)or die ("Imposible modificar datos");	
	$texto1="<div class=\"alert alert-success\"> Realizadas las Modificacion de la imagen</div>";
		
		}

///////////////////////  fin de la subida de imagenes


$fecha =date("Y-m-d h:i:s");
 $fecha_ver =date("d-m-Y ");


if(ISSET($_POST["modifika_paginas"])){
 
$nombre_cand=fn_filtro($con,$_POST['nombre_cand']);
$texto=fn_filtro_editor($con,$_POST['texto']);
$provincia=fn_filtro($con,$_POST['provincia']);
$sexo=fn_filtro($con,$_POST['sexo']);
$URLVideo=fn_filtro($con,$_POST['URLVideo']); //STG: nuevo

$sSQL="UPDATE $tbn7 SET nombre_usuario=\"$nombre_cand\",texto=\"$texto\",  sexo=\"$sexo\" ,fecha_modif=\"$fecha\",  modif=\"$nombre_usuario\",  URLVideo=\"$URLVideo\" WHERE id='$id'";

mysqli_query($con,$sSQL)or die ("Imposible modificar pagina");

$texto1="<div class=\"alert alert-success\"> Realizadas las Modificaciones <br>Asi ha quedado el candidato $nombre_cand</div>";

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
                   <a href="candidatos_busq1.php?idvot=<?php echo "$idvot"; ?>" class="btn btn-primary pull-right">Buscar en el directorio para modificar o borrar candiatos en esta encuesta</a>   
                    <a href="candidatos.php?idvot=<?php echo $_GET['idvot']; ?>" class="btn btn-primary pull-right">Añadir otra opcion o candidato en esta votacion</a>
        <?php if ($row_vot[2]==3 or $row_vot[2]==4 ){?> 
         <a href="interventor.php?idvot=<?php echo "$idvot"; ?>"  class="btn btn-primary pull-right"> Incluir  interventores</a>  
        <?php   }?>
       <a data-toggle="modal"  href="../votacion/perfil.php?idgr=<?php echo  "$id"; ?>" data-target="#ayuda_contacta" title="<?php echo  "$row[3]"; ?>" class="btn btn-success" >Vista previa</a>
      <p>&nbsp;</p><p>&nbsp;</p>
      
              <h1>MODIFICAR OPCION O CANDIDATO</h1>
            
			<!---->
            
            
    
<?php 

  $result=mysqli_query($con,"SELECT * FROM $tbn7 where id=$id");
  $row=mysqli_fetch_row($result);

 
 ?>

<?php echo"$texto1";?>
<p><?php echo "$inmsg";?> <?php echo "$inmsg1";?> <?php echo "$inmsg2";?>           </p>


 
<form action="<?php $_SERVER['PHP_SELF'] ?>" method=post   name="frmDatos" id="frmDatos"  class="well form-horizontal">
 

  <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Nombre </label>
             
            <div class="col-sm-9">
				<input name="nombre_cand" type="text"  id="nombre_cand" value="<?php echo "$row[3]";?>"  class="form-control"  required autofocus />
                </div>
                </div>
                
                
                 <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Sexo</label>
             
            <div class="col-sm-9">
                   
                   <?php if ($row[4]=="H"){
					 $chekeado1="checked=\"checked\" ";
					  
				 }else if ($row[4]=="M"){
					 $chekeado2="checked=\"checked\" ";
					  
				 }else {
					 
					  $chekeado3="checked=\"checked\" ";
				 }
				 
				
				 ?>
                   
                   <input type="radio" name="sexo" value="O" id="sexo_2" <?php echo "$chekeado3"; ?> />
                  <label> Neutro ( sin opcion de sexo)</label>
                <span class="label label-warning"> ¡¡¡ojo, no indicar sexo, o aparecerán separados hombres y mujeres en la votación!!!</span>
                 <br/>
  <label>
    <input name="sexo" type="radio" id="sexo_0" value="H"  <?php echo "$chekeado1"; ?> />
    Hombre</label>
                   <br />
                   <label>
                     <input type="radio" name="sexo" value="M" id="sexo_1" <?php echo "$chekeado2"; ?> />
                     Mujer</label>
                </div>
                </div>
                
             <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Imagen </label>
             
            <div class="col-sm-9">    
               <?php if($row[12]=="" ){?><?php }else{?><img src="<?php echo $upload_cat; ?>/<?php echo"$row[12]";?>" alt="<?php echo"$row[3]";?> " width="70" height="70"  /> <?php }?> <a href="candidatos_crop.php?idcat=<?php echo  "$row[0]" ?>&idvot=<?php echo $_GET['idvot']; ?>" title="Imagen de <?php echo  "$row[3]" ?>" class="btn btn-success" >Modificar imagen</a>
               
              </div>
              </div>     
			  
			<div class="form-group">       
				<label for="URLVideo" class="col-sm-3 control-label">Vídeo del candidato<br/>(URL externa)</label>
				<div class="col-sm-9">
					<input type="text"  name="URLVideo" id="URLVideo" value="<?php echo "$row[13]";?>"  class="form-control"  autofocus />
                </div>
            </div>
                
 <div class="form-group">   
               <div class="col-sm-12">         
             <label for="nombre" >Texto</label>

<script src="../modulos/ckeditor/ckeditor.js"></script>              
       
	<textarea cols="80" id="texto" name="texto" rows="10"><?php echo "$row[2]"; ?></textarea>
		<script>


			CKEDITOR.replace( 'texto', {
				toolbarGroups: [
	{ name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
	{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
    { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
	{ name: 'tools' },
	'/',
    { name: 'links' },
    { name: 'insert' },  
    { name: 'others' },  
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	'/',
    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
    { name: 'styles' },
    { name: 'colors' },
	],
    filebrowserBrowseUrl: '../modulos/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl: '../modulos/ckfinder/ckfinder.html?Type=Images',
    filebrowserFlashBrowseUrl: '../modulos/ckfinder/ckfinder.html?Type=Flash',
    filebrowserUploadUrl: '../modulos/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl: '../modulos/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl: '../modulos/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});

		</script>
</div>
</div>
  
  
 
                 
           
             <input name="incluido" type="hidden" id="incluido" value="<?php echo"$nombre_usuario";?>" />
                   <input name="fecha" type="hidden" id="fecha" value="<?php echo"$fecha";?>" />
                   <input name="modifika_paginas" type="submit" class="btn btn-primary pull-right" id="modifika_paginas" value="Modificar candidato" />                   </td>
             <p>&nbsp;</p>    <p>&nbsp;</p>
</form>
  
    
                    
  <!--Final-->
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
  <script type="text/javascript">
			<!-- limpiamos la carga de modal para que no vuelva a cargar lo mismo -->
			$('#ayuda_contacta').on('hidden.bs.modal', function () {
			  $(this).removeData('bs.modal');
			});
   </script>
  </body>
</html>