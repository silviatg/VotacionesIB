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
require ("../basicos_php/funcion_control_votacion.php");
//require ("../basicos_php/basico.php");
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
        

                   
                   <!--Comiezo-->
                   <?php 

 
if(ISSET($_POST["add_voto"])){
	
$id_votante = $_SESSION['ID'];///ver si se puede borrar
$idvot=fn_filtro_numerico($con,$_POST['id_vot']); ///ver si se puede borrar y meter el post directamente
$id_provincia=fn_filtro_numerico($con,$_POST['id_provincia']);
$id_ccaa=$_SESSION['id_ccaa_usu'];/// este esta mal??
$valores=fn_filtro($con,$_POST['valores']);
$id_ccaa = fn_filtro_numerico($con,$_POST['id_ccaa']);   ///o este esta mal??
$id_subzona = fn_filtro($con,$_POST['id_subzona']);
$id_grupo_trabajo = fn_filtro($con,$_POST['id_grupo_trabajo']);
$demarcacion = fn_filtro($con,$_POST['demarcacion']); //necesario
$clave_seg = fn_filtro($con,$_POST['clave_seg']);	

			reset ($_POST);
			foreach ($_POST as  $k => $v) $a[] = $v;
			$datos=count ($a)-8;
			
	if($datos==0){
	echo "<div class=\"alert alert-danger\">
   <strong>Hay un error, no ha seleccionado ninguna opción <a href=\"vota_encuesta.php?idvot=$idvot\">volver</a></strong></div>";
	}
	else{
			


$sql3 = "SELECT  seguridad,nombre_votacion FROM $tbn1 WHERE ID ='$idvot' ";
$resulta3 = mysqli_query($con, $sql3) or die("error: ".mysqli_error());
	
	while( $listrows3 = mysqli_fetch_array($resulta3) ){ 
	$seguridad  = $listrows3[seguridad];
	$nombre_votacion = utf8_encode($listrows3[nombre_votacion]);
}



if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    elseif (isset($_SERVER['HTTP_VIA'])) {
       $ip = $_SERVER['HTTP_VIA'];
    }
    elseif (isset($_SERVER['REMOTE_ADDR'])) {
       $ip = $_SERVER['REMOTE_ADDR'];
    }
	
$forma_votacion=3;

//$error = FALSE;


if($_POST['clave_seg']==""){
echo " <div class=\"alert alert-danger\">
   <strong>Falta la clave de seguridad <br> vuelva a realizar la votación</strong></div>";
}
else{



list ($estado, $razon,$tipo_votante)=fn_mira_si_puede_votar($demarcacion,$_SESSION['ID'],$id_vot,$id_ccaa,$id_provincia,$id_grupo_trabajo,$id_municipio);

/////////////////////////// si podemos procesar el formulario
//if(!$error) {
		if($estado=="error") {
			if($razon=="direccion_no_existe"){
				echo "<div class=\"alert alert-danger\">
   <strong>Esta direccion de correo no la tenemos registrada para esta provincia, quizas sea un error de nuestra base de datos , si consideras que tienes derecho a votar haz  enviarnos tus datos a traves de nuestro formulario</a></strong></div>";
			}
			if($razon=="ya_ha_votado"){
				echo "<div class=\"alert alert-danger\">
   <strong>Ya ha votado en esta votación</strong></div>";
			}
		  }


		else if($estado=="TRUE" and $razon=="usuario_ok"){
		$codi = hash("sha512", $clave_seg);
		
		
/*			reset ($_POST);
			foreach ($_POST as  $k => $v) $a[] = $v;
			$datos=count ($a)-8;*/
			$i = 0;
		
			while ($i < $datos) {
			$val = $a[$i];
			
 			$vot=1;
				
				//////	identofocador unico		
			$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
			$cad = "";
			for($b=0;$b<4;$b++) {
			$cad .= substr($str,rand(0,62),1);
			}
				$time = microtime(true);
				$timecad=$time.$cad;
				$res_id = hash("sha256", $timecad);
			/// finidentificador unico		
					
						 
					$fecha_env = date("Y-m-d H:i:s");
					$insql = "insert into $tbn10 (ID,voto,id_candidato,id_provincia,id_votacion,codigo_val) values (\"$res_id\",\"$vot\",\"$val\",".$_SESSION['localidad'].",\"$idvot\",\"$codi\")";
						$mens="mensaje añadido";
						$result =db_query($con, $insql,$mens);			
					
					
						$datos_votado.="Orden $voto  | Identificador candidato -->  $val |  Valor voto ---  $vot"."<br/>"; //cojemos el array de votos para enviar por correo si es necesario
		 	
			
			$i++;
		}	 
			
		if(!$result){
		echo "<div class=\"alert alert-danger\">
   <strong> UPSSS!!!!<br/>esto es embarazoso, hay un error y su votacion no ha sido registrada  </strong> </div><strong>";
		
		}
		if($result){   
		   echo "Ha sido recogido el voto de:".$_SESSION['nombre_usu']."<br/>";

				$insql = "insert into $tbn2 (id_provincia,id_votacion,id_votante,fecha,tipo_votante,ip,forma_votacion) values (".$_SESSION['localidad'].",\"$idvot\",".$_SESSION['ID'].",\" $fecha_env\",\" $tipo_votante\",\" $ip\",\" $forma_votacion\")";
				$mens="<br/>¡¡¡ATENCION!!!!, el voto ha sido registrado , pero el usuario no ha sido bloqueado <br> el ID de usuario es:".$_SESSION[ID];
				$resulta =db_query($con,$insql,$mens);
				
				
			  //////////////////////metemos la seguridad del envio de correos a interventores
							
		  if($seguridad==3 or $seguridad==4){
				include('../basicos_php/envio_interventores.php'); 
			}
		   ///////// fin envio a interventores 
							
				?><!--si todo va bien damos las gracisa por participar-->
    <div class="alert alert-success">  
     <h3  align="center">Gracias por participar</h3>    
   <strong>En  breve estaran los resultados </strong></div>
				<?php 
			}
		}
  	}
  }
}
	?>
                   
                   
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
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
   
  </body>
</html>