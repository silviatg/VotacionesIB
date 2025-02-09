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
require_once("../inc_web/config.inc.php");
include('../basicos_php/time_stamp.php');
include('../basicos_php/basico.php');
//$idvot= 000001 ;	
$idvot= fn_filtro_numerico($con,$_GET['idgr']);
//Realizo la consulta de la tabla y ordeno por fecha (El ultimo mensaje de primero)

$query = mysqli_query($con, "SELECT a.nombre_usuario, a.apellido_usuario, a.imagen_pequena,a.usuario, b.fecha, b.comentario, b.estado FROM $tbn9 a, $tbn12 b where (a.ID= b.id_usuario) and id_votacion= '$idvot' ORDER BY fecha DESC");

//Si la consulta es verdadera
if($query == true){
   //Recorro todos los campos de la tabla y los muestro
  
   while ($row = mysqli_fetch_array($query)){
	   
	   ?>  
    

<div class="fondo_mensaje esquinas">
<div class="imagen_wall">
<?php if($row['imagen_pequena']=="peq_usuario.jpg" or $row['imagen_pequena']=="" ){?><img src="../temas/<?php echo "$tema_web"; ?>/imagenes/avatar_sin_imagen.jpg" width="50" height="50" /><?php }else{?><img src="<?php echo $upload_user; ?>/<?php echo $row['imagen_pequena'] ;?>"  alt="<?php echo $row['nombre_usuario']; ?> <?php echo $row['apellido_usuario']; ?>" width="50px" height="50px" border="0" /> <?php }?>

</div>

<div class="titular-comentario contenido-comentario">
	
		<div class="nik_debate"	><?php echo $row['usuario']; ?> </div> <span class="fecha_debate"><?php 
	  $fecha=$row['fecha'];	  time_stamp($fecha);?> </span> <?php if ($row['estado']!="") {?> <div class="imagen_estado" ><img src="../debate/emoticonos/<?php echo $row['estado'];?>" width="32" height="32" /></div> <?php }?>  <br/> <span class="nombre_debate"> (<?php echo $row['nombre_usuario']; ?> <?php echo $row['apellido_usuario']; ?>) </span>
   
	</div><div class="pico_caja">&nbsp;</div>
	<div class="texto_mensaje"> <?php echo $row['comentario']; ?> </div>
</div>



 <?php  }
}
?>
