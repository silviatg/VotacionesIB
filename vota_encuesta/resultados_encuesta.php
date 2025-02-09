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
    <link rel="stylesheet" href="../js/morris.js-0.4.3/morris.css">

 
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
        <!--Comiezo--><h1><?php echo "$nombre_votacion" ; ?></h1>
        <?php echo "$resumen"; ?>
                   <?php 
		 
if($activos_resultados=="no")
{
	echo " <div class=\"alert alert-danger\">No esta autorizado ver los resultados de esta votacion </div>";
}
else{
if($activos_resultados=="si")
{
	//echo "<div class=\"alert alert-info\">Esta votacion aun se esta realizando, los resultados pueden variar </div>";
}
?>

 <?php 
	  $dir="../vota_encuesta/vota_encuesta_ver.php";
	  
	   if($seguridad==2 ){
			 echo "<br/> <br/>  Sistema de seguridad de la votación <br/><a href=".$dir."?idvot=".$idvot." >Puede comprobar que su voto no ha sido modificado y esta correctamente contabilizado</a><br/> <br/> ";}
		   if($seguridad==4){
			echo "<br/> <br/>  Sistema de seguridad de la votación <br/><a href=".$dir."?idvot=".$idvot." >Puede comprobar que su voto no ha sido modificado y esta correctamente contabilizado</a> <br /> Ademas esta votacion ha enviado una papeleta con su voto de forma anonima a los interventores<br/> <br/> ";	 		   
		  }
	  ?>
        
       <div>
      <?php 
//$id_pro=$_GET['id_pro'];
$sql = "SELECT a.id_candidato, COUNT(a.id_candidato),b.nombre_usuario,sum(a.voto),b.sexo FROM $tbn10 a, $tbn7 b WHERE (a.id_candidato=b.ID) and a.id_votacion = '$idvot'  GROUP BY a.id_candidato  ORDER BY sum(a.voto) desc ";
$result = mysqli_query($con, $sql);

if ($row = mysqli_fetch_array($result)){
	$i=1;
?>
  <?php

mysqli_field_seek($result,0);

do {
if($row[4] =="H"){

$sexo="capah";
}
else if($row[4] =="M"){
$sexo="capam";	
}
else {
$sexo="capan";	
	
}
 ?>
      <div class="capasexo <?php echo  "$sexo" ?>" ><?php echo  $i++ ?> &nbsp; &nbsp;| |&nbsp; &nbsp;<?php echo  "$row[2]" ?> tiene : <?php echo  "$row[1]" ?> votos <!--y la suma  es <?php echo  "$row[3]" ?> -->.
          </div>
        
        <?php
		$array_datos_res.="{label: '$row[2]', value:$row[1] },";
		
}
while ($row = mysqli_fetch_array($result));

$array_datos_r=substr($array_datos_res, 0, -1);

?>
      <script type="text/javascript">
	var array_js = new Array();
	array_js=[
   <?php  echo "$array_datos_r";?>
  ];
  </script>
      
    <?php 
} else {

echo " ¡No hay resultados! ";
}
?>
   
   
      </div>
  <?php }?>
 <!---->				
		<div>
                    <div id="donut_resultado"></div>    
                    <div id="tabla_resultado"></div>
                    
            </div> 
        
        </div>                
       <!--Final-->
        
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
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script> 
      
	<script src="../js/raphael-min.js"></script>
	<script src="../js/morris.js-0.4.3/morris.min.js"></script>
    <script type="text/javascript">
	var array_colores = new Array();
	array_colores=[
    
    '#0066CC',
	'#FF8000',
	'#FDF512',
	'#F912FD',
	'#BBD03F',
	'#12DEFD',
	'#9102C6',
	'#39FF08',
	'#0BA462',
    '#990000'
  ];
// Use Morris.Bar
new Morris.Bar({
  element: 'tabla_resultado',
  data: array_js, //array de los datos
  xkey: 'label',
  ykeys: ['value'],
  labels: ['Y'],
  backgroundColor: '#9D9D9D',
 /* barFillColors: [
    '#39FF08 #555',      // from light gray to dark gray (top to bottom)
    '#555 #aaa black' // from dark day, through light gray, to black
  ]*/
 /* */
 barColors:
   function (row, series, type) {
    if (type === 'bar') {
      var blue = Math.ceil(255 * row.y / this.ymax);
      return 'rgb(43,200,' + blue + ')';
    }
    else {
      return '#000';
    }
  }
});
		
		
		
		
		
/*
 * Play with this code and it'll update in the panel opposite.
 *
 * Why not try some of the options above?
 */
new Morris.Donut({
  element: 'donut_resultado',
  data: array_js, //array de los datos
   backgroundColor: '#9D9D9D',
  labelColor: '#060',
  colors: array_colores 
  /*formatter: function (x) { return x + "%"} // da la funcion en porcentajes y no en absolutos
  */
});



</script>
  </body>
</html>