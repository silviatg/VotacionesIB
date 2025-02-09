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
include('../inc_web/seguri.php'); 
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
        
        <div class="col-md-7"><!--Comiezo--><h1><?php echo "$nombre_votacion" ; ?></h1>

<?php echo "$resumen"; ?>
         <?php 

////// y sacamos los candidatos de esa provincia
$sql = "SELECT * FROM $tbn7 WHERE id_votacion = '$idvot' ORDER BY rand(" . time() . " * " . time() . ")  ";

?>
<form id="numeroOpciones" name="numeroOpciones" class="well" action="emite_voto_encuesta.php?idvot=<?php echo "$idvot"; ?>" method="post">

  <!-- Contenedor general -->
<div class="contenedor">

<div class="datos_BBDD"><!--Incluimos la informacion--></div> 


<div  id="tabla1" >Lista de opciones para esta votación <br />
  
  Puede escoger <?php echo "$numero_opciones"; ?> opciones

  <div id="formulario">
 <?php 

////// y sacamos los candidatos de esa provincia

$result = mysqli_query($con, $sql);
if ($row = mysqli_fetch_array($result)){

 ?>
 <div data-toggle="checkboxes"  data-max="<?php echo "$numero_opciones"; ?>">
     <table border="0">
        <?php

	mysqli_field_seek($result,0);
		do {
		 ?>
		  <tr>
			<td align="left">
				 <label><input type="checkbox" name="encuesta_<?php echo  "$row[0]" ?>" value="<?php echo  "$row[0]"; ?>" id="encuesta_<?php echo  "$row[0]"; ?>" /> 
				 <?php if($row[12]=="" ){?><?php }else{?><img src="<?php echo $upload_cat; ?>/<?php echo  "$row[12]"; ?>" alt="<?php echo  "$row[3]"; ?> " width="70" height="70"  /> <?php }?>		 
				 <?php echo  "$row[3]" ?> | <a data-toggle="modal"  href="../votacion/perfil.php?idgr=<?php echo  "$row[0]"; ?>" data-target="#ayuda_contacta" title="<?php echo  "$row[3]"; ?>"  >más información</a></label>
		
			   </td>
		  </tr>
		 
				<?php
		}
	while ($row = mysqli_fetch_array($result));
	?>
</table>
</div>
</div>
            
            <p>
              <?php 
            } else {
            echo " ¡No se ha encontrado ningún candidato! ";
            }
            ?>
              <?php require('../basicos_php/control_voto.php'); // sistema para incluir internventores o clave voto seguro ?>
              
              <input name="id_vot" type="hidden" id="id_vot" value="<?php echo "$idvot"; ?>" />
              <input name="add_voto" type="submit" class="btn btn-lg btn-primary pull-right" id="add_voto" value="VOTA" />
              <input name="id_provincia" type="hidden" id="id_provincia" value="<?php echo "$id_provincia"; ?>" />
              <input name="id_ccaa" type="hidden" id="id_ccaa" value="<?php echo "$id_ccaa" ?>" />
              <input name="id_subzona" type="hidden" id="id_subzona" value="<?php echo "$id_subzona" ?>" />
              <input name="id_grupo_trabajo" type="hidden" id="id_grupo_trabajo" value="<?php echo "$id_grupo_trabajo" ?>" />
              <input name="demarcacion" type="hidden" id="demarcacion" value="<?php echo "$demarcacion" ?>" />
            </p>
            <p>&nbsp;</p>
</div>
  
	</div>
<!-- -->




</form>
		<script type="text/javascript">       
        //Syntax: checkboxlimit(checkbox_reference, limit)
        checkboxlimit(document.forms.numeroOpciones, <?php echo "$numero_opciones"; ?>)      
        </script>
                           
                   
                   <?php echo "$texto"; ?>	
                   
                   
                   <!--Final-->
        
  
        </div>
        
          <div class="col-md-3">
         
		<?php  // include("lateral_derecho.php"); ?>              
        </div>
      
  </div>
 

  <div id="footer" class="row">
   <?php  include("../votacion/ayuda.php"); ?>
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
	<script src="../js/jquery-1.9.0.min.js"></script>
	<script type='text/javascript' src='../js/jquery.checkboxes.min.js'></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
			<!-- limpiamos la carga de modal para que no vuelva a cargar lo mismo -->
			$('#ayuda_contacta').on('hidden.bs.modal', function () {
			  $(this).removeData('bs.modal');
			});
   </script>
  </body>
</html>