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
<?php 
$Seats=$numero_opciones;
$Ballotname= $idvot ;
$Pollname= $idvot ;
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
                   
                          
<p>Esto es lo que ha votado en</p>
<h1><?php  echo"$nombre_votacion"; ?></h1>

<p>&nbsp;</p>

<?php

if(ISSET($_POST["submit"])){
	$datos_votacion=each ($_POST);
	//echo $datos_votacion[1];
if ($datos_votacion[1]=="--"){

$errores= " No ha votado nada <br> vuelva a realizar la votación";

}
else if($_POST['clave_seg']==""){
$errores= " Falta la clave de seguridad <br> vuelva a realizar la votación";
}
else{
?>



<?php 
$id_votante = $_SESSION['usuario_id'];
//$idvot=fn_filtro_numerico($con,$_POST['id_vot']);
$id_ccaa=$_SESSION['id_ccaa_usu'];
$clave_seg = fn_filtro($con,$_POST['clave_seg']);

$Cands=fn_filtro_numerico($con,$_POST['Cands']);


if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    elseif (isset($_SERVER['HTTP_VIA'])) {
       $ip = $_SERVER['HTTP_VIA'];
    }
    elseif (isset($_SERVER['REMOTE_ADDR'])) {
       $ip = $_SERVER['REMOTE_ADDR'];
    }
	
$forma_votacion=2;


list ($estado, $razon,$tipo_votante)=fn_mira_si_puede_votar($demarcacion,$_SESSION['ID'],$idvot,$id_ccaa,$id_provincia,$id_grupo_trabajo,$id_municipio);


//if(!$error) {

		if($estado=="error") {
			if($razon=="direccion_no_existe"){
				$errores= "<br/>Esta direccion de correo no la tenemos registrada para esta provincia, quizas sea un error de nuestra base de datos , si consideras que tienes derecho a votar haz <a href=\"../votaciones/voto_contacto.php\"> click aqui para enviarnos tus datos a traves de nuestro formulario</a><br/>";
			}
			if($razon=="ya_ha_votado"){
				$errores= "<br/>Ya ha votado en esta votación<br/>";
			}
		  }
		else if($estado=="TRUE" and $razon=="usuario_ok"){
	/////////////////////////// si podemos procesar el formulario		
$codi = hash("sha512", $clave_seg);


?>

<?php 
reset ($_POST);
unset($_POST['id_vot']); //borramos la variable del post
unset($_POST['clave_seg']); ///borramos la otra variable para dejar solo los datos de votos
unset($_POST['Cands']); ///borramos la otra variable para dejar solo los datos de votos
$cuenta =1;
while (list ($clave, $val) = each ($_POST)) {
   // echo "$clave - $val +; ";
	 $array_id = explode ('__', $clave);
	if ($clave=="submit"){
		
	}
	else{
		
		if($val=="--"){
			
		}
		else{
	 ?>

     
     <?php 
	 
	 $valores.="$array_id[1]".","; ///montamos una cadena separada por comas con los id de los candidatos para meterlos en la hoja de recuento

	
	$datos_votado.="Orden $voto  | Identificador candidato --> $array_id[1] |  Orden del voto ---  $cuenta"."<br/>";
	

		}
	}
	$cuenta++;
}

?>

  <?php 
$valores = trim($valores, ','); ///quitamos la ultima coma de la cadena
$valores_fin=$valores. "\n";

 $fecha_env = date("Y-m-d H:i:s");
	  
	  
$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
$cad = "";
for($i=0;$i<4;$i++) {
$cad .= substr($str,rand(0,62),1);
}

	  
$time = microtime(true);
$timecad=$time.$cad;
$res_id = hash("sha256", $timecad);
	  
	  
    $insql = "insert into $tbn15 (ID,voto,id_candidato,id_provincia, id_votacion,codigo_val) values (\"$res_id\",\"$valores_fin\",\"0\",".$_SESSION['localidad'].", \"$idvot\",\"$codi\")";
	$mens="mensaje añadido";
	$result =db_query($con, $insql,$mens);

	if(!$result){
		echo "<strong><font color=#FF0000 siz<br/> UPSSS!!!!<br/>esto es embarazoso, hay un error y su votacion no ha sido registrada </font></strong>";
		
	}
	if($result){
		//si hay resultado del proceso anterior ejecutamos el resto				
				
				// abrimos el fichero y escribmos los datos
				   $fp=fopen($FilePath.$Ballotname."_ballots.txt","a+");
				  // fputs($fp,$NuBallot.$cr);
				   if (fwrite($fp, $valores_fin) === FALSE) {
					   $errores= "No se puede escribir al archivo ($nombre_archivo)";
					   exit;
					}	
				   fclose($fp);
				   
				 
				$insql = "insert into $tbn2 (id_provincia,id_votacion,id_votante,fecha,tipo_votante,ip,forma_votacion) values (".$_SESSION['localidad'].",\"$idvot\",".$_SESSION['ID'].",\" $fecha_env\",\" $tipo_votante\",\" $ip\",\" $forma_votacion\")";
				$mens="<br/>¡¡¡ATENCION!!!!, el voto ha sido registrado , pero el usuario no ha sido bloqueado <br> el ID de usuario es:".$_SESSION[ID];
				$resulta =db_query( $con,$insql,$mens);
				
					
					
							//////////////////////metemos la seguridad del envio de correos a interventores
							
							if($seguridad==3 or $seguridad==4){
							include('../basicos_php/envio_interventores.php'); 
							}
							///////// fin envio a interventores 
			
			
			
				
				//----------------------------------------- corremos el script
				
						/*function getmicrotime() ///  si quitamos el calculo  de recuento de votos podemos quitarlo
						{ 
						 list($usec, $sec) = explode(" ",microtime()); 
						 return ((float)$usec + (float)$sec); 
						}*/
						
						// echo "Realizando recuento de votos... ";
						// $time_start=getmicrotime();
						 
						 require("dctally.php");
						 $Ballots=NULL;
						// $time_end=getmicrotime();
						// echo "Hecho en ".round($time_end-$time_start,2)." seg.<br/>";
				
				
				 ?> 
					 <div class="table-responsive">
				<table width="90" class="table table-striped"">
                <thead>
        <tr>
            <th width="17%">
              Orden</th>
                <th width="83%">Candidato - Opción</th> </tr>
				<?php 
						$valoresarray = explode(',', $valores);
						$numrows = count($valoresarray);
				for ($i = 0; $i < $numrows; $i++)
					{
				
					 ?>
				 <tr><td> 
				 <?php 
				 $cuenta=$i+1;
				 echo "$cuenta"; ?> 
				  
				 </td ><td>
				 <?php 
				 $result2=mysqli_query($con, "SELECT nombre_usuario,imagen_pequena FROM $tbn7 WHERE id_vut = '$valoresarray[$i]' and id_votacion='$idvot'"); 
				 $linea =mysqli_fetch_row ($result2);
				 if($linea[1]=="" ){?><?php }else{?><img src="<?php echo $upload_cat; ?>/<?php echo $linea[1] ;?>" alt="<?php echo $linea[0];?> " width="60" height="60"  /> <?php }
				 echo $linea[0];   
				 ?>
				 </td></tr>
				<?php }  ?>

				</table></div>
<!--si todo va bien damos las gracisa por participar-->
    <div class="alert alert-success">  
     <h3  align="center">Gracias por participar</h3>    
   <strong>En  breve estaran los resultados </strong></div>


	<?php 
	}

}
}
}else{
	
$errores=" no ha accedido de forma correcta a esta votacion";	
}
?>
<?php if($errores!=""){?>
<div class="alert alert-danger">
   <strong> <?php echo $errores; ?></strong>
 </div>
              <?php }?>     
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