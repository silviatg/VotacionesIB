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
    <link rel="stylesheet" href="../modulos/themes-jquery-iu/base/jquery.ui.all.css">
    <link rel="stylesheet" href="orden.css">
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
        

        
        
        <div class="col-md-2 sidebar-offcanvas" id="sidebar" role="navigation">
          <div class="list-group">
          <?php  include("../votacion/menu_nav.php"); ?>
            
          </div>
        </div> 
       
        
        
        <div class="col-md-7">
        

                  <!---->
		 
		  <!---->
    
<?php 
//$idvot=$_POST['id_vot'];
$clave_seg=fn_filtro($con,$_POST['clave_seg']);
$codigo_val = hash("sha512", $clave_seg);
/*

  $result_vot=mysqli_query($con,"SELECT id_provincia, activa,nombre_votacion,tipo_votante,activos_resultados, seguridad   FROM $tbn1 where id=$idvot");
  $row_vot=mysqli_fetch_row($result_vot);

$id_provincia=$row_vot[0]; 
$activa=$row_vot[1];
$tipo_votante=$row_vot[3];
$nombre_votacion=$row_vot[2];*/

?>


  
      
<h1>Esto es lo que hay registrado como su voto en la votación   </h1>
  <h2><?php echo  "$nombre_votacion"; ?>      </h2> 
       
     <div>
   <?php 
   	 // Votos en blanco
    $sql = "select vote_id from $tbn10 WHERE id_votacion = '$idvot' and codigo_val LIKE '$codigo_val' and otros=2";  
    $result = mysqli_query($con,$sql);
	if ($row = mysqli_fetch_array($result)){
    //$blancos = mysqli_num_rows($result); // obtenemos el número de filas  
	echo " <ul class=\"candidates_res\"><li class=\"ne\">Voto es en blanco </li></ul>";
	}
    // Votos en nulos
    $sql = "select vote_id from $tbn10 WHERE id_votacion = '$idvot' and  codigo_val LIKE '$codigo_val' and otros=1";  
    $result = mysqli_query($con,$sql);
	if ($row = mysqli_fetch_array($result)){
	echo " <ul class=\"candidates_res\"><li class=\"ne\">Voto es Nulo</li></ul>";
   // $nulos = mysqli_num_rows($result); // obtenemos el número de filas
	}
   ?>  


      <?php 
	  	$sexo ="M";
$sql = "SELECT a.id_candidato, b.nombre_usuario,b.sexo,a.voto, b.imagen_pequena  FROM $tbn10 a, $tbn7 b WHERE (a.id_candidato=b.ID) and  a.id_votacion = '$idvot' and a.codigo_val LIKE '$codigo_val'  and b.sexo='$sexo'    ORDER BY a.voto desc ";
$result = mysqli_query($con, $sql);

if ($row = mysqli_fetch_array($result)){
	$i=1;
	
?>
       
       <h3>Voto Femenino</h3>
      <ul class="candidates_res">  
        <?php

mysqli_field_seek($result,0);
do {
 ?> 
 
 
<li class="fem"><?php echo  "$row[3]" ?> &nbsp; &nbsp;<?php if($row[4]=="" ){?><?php }else{?><img src="<?php echo $upload_cat; ?>/<?php echo $row[4] ;?>" alt="<?php echo $row[1];?> " width="60" height="60"  /> <?php }?>&nbsp; &nbsp;<?php echo  "$row[1]" ?> </li>
 
   
        
        <?php
}
while ($row = mysqli_fetch_array($result));



?>
      </ul>
      
    <?php 
} else {


}


?>
   
      </div>
      <!---->
     <div>
     


      <?php 
	$sexo ="H";
$sql = "SELECT a.id_candidato, b.nombre_usuario,b.sexo, a.voto, b.imagen_pequena  FROM $tbn10 a, $tbn7 b WHERE (a.id_candidato=b.ID) and  a.id_votacion = '$idvot' and a.codigo_val LIKE '$codigo_val'  and b.sexo='$sexo'  ORDER BY a.voto desc ";
$result = mysqli_query($con, $sql);

if ($row = mysqli_fetch_array($result)){
	$i=1;
	
?>
 <h3>Voto masculino</h3>       
       
       <ul class="candidates_res"> 
        <?php

mysqli_field_seek($result,0);

do {


 ?> 
 
 
<li class="mas"><?php echo  "$row[3]" ?> &nbsp; &nbsp;<?php if($row[4]=="" ){?><?php }else{?><img src="<?php echo $upload_cat; ?>/<?php echo $row[4] ;?>" alt="<?php echo $row[1];?> " width="60" height="60"  /> <?php }?>&nbsp; &nbsp;<?php echo  "$row[1]" ?> </li>
 
   
        
        <?php
}
while ($row = mysqli_fetch_array($result));



?>
      </ul>
      
    <?php 
} else {


}


?>
   
      </div>
 <!---->
 
 <div>
     


      <?php 
$sexo ="O";
$sql = "SELECT a.id_candidato, b.nombre_usuario,b.sexo,a.voto, b.imagen_pequena   FROM $tbn10 a, $tbn7 b WHERE (a.id_candidato=b.ID) and  a.id_votacion = '$idvot' and a.codigo_val LIKE '$codigo_val'  and b.sexo='$sexo'  ORDER BY a.voto desc ";
$result = mysqli_query($con, $sql);

if ($row = mysqli_fetch_array($result)){
	$i=1;
	
?>
 <h3>Su voto</h3>       
       
  <ul class="candidates_res">   
        <?php

mysqli_field_seek($result,0);

do {

 ?> 
 
 
      <li class="ne"><?php echo  round("$row[3]",2) ?> puntos  &nbsp; &nbsp;<?php if($row[4]=="" ){?><?php }else{?><img src="<?php echo $upload_cat; ?>/<?php echo $row[4] ;?>" alt="<?php echo $row[1];?> " width="60" height="60"  /> <?php }?>&nbsp; &nbsp;<?php echo  "$row[1]" ?> </li>
 
   
        
        <?php
}
while ($row = mysqli_fetch_array($result));



?>
      </ul>
      
    <?php 
} else {
	echo "<div class=\"alert alert-danger\">La clave introducida no es correcta.</div>";
}


?>
   
      </div>
 
		  <!---->				
        <!---->
        
  
        </div>
        
          <div class="col-md-3">
         
		<?php  // include("../votacion/lateral_derecho.php"); ?>              
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