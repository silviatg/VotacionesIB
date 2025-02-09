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
      include('../inc_web/seguri.php');  ?>

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
        
        
        <div class="col-md-7"><!--Comiezo-->
     
<?php 
$idvot=fn_filtro_numerico($con,$_POST['id_vot']);
$clave_seg=fn_filtro($con,$_POST['clave_seg']);
$codigo_val = hash("sha512", $clave_seg);
?>


  
      
<h1>Esto ha votado en   "<?php echo  "$nombre_votacion"; ?>"</h1>
         
       
     <div>
     


      <?php 
	  
$sql = "SELECT a.id_candidato, b.nombre_usuario,b.sexo  FROM $tbn10 a, $tbn7 b WHERE (a.id_candidato=b.ID) and  a.id_votacion = '$idvot' and a.codigo_val LIKE '$codigo_val'    ORDER BY a.voto desc ";
$result = mysqli_query($con, $sql);

if ($row = mysqli_fetch_array($result)){

?>
 <h2>Su votación</h2>       
       
     
        <?php

mysqli_field_seek($result,0);

do {

if($row[2]=="H"){
$sexo="capah";
}
else if($row[2]=="M"){
$sexo="capam";	
}
else{
$sexo="capan";	
}	

 ?> 
 <div class="capasexo <?php echo  "$sexo"; ?>" ><?php echo  "$row[1]"; ?> </div>
    
        <?php
}
while ($row = mysqli_fetch_array($result));

} else {


}


?>
   
      </div>
  
 
 
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