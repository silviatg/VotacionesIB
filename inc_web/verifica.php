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

$url = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida=$url[0];
$redir=$pag_referida;

if ($_SERVER['HTTP_REFERER'] == ""){
	die ("Error cod.:1 - Incorrect access");
	exit;
}

if (isset($_GET['regedi'])){ //Si venía en la url solicitar_clave_sms=S, lo volvemos a indicar, para que muestre el input de la clave.
	$regedi="&regedi=".$_GET['regedi'];
}

if (isset($_POST['user']) && isset($_POST['pass'])) {
	$db_conexion= mysqli_connect("$host", "$hostu", "$hostp") or die(header ("Location:  $url_vot/index.php?error_login=0$regedi"));
	mysqli_select_db($db_conexion,"$dbn");

    //evitamos el sql inyeccion
    $user1 = mysqli_real_escape_string($db_conexion, $_POST['user']); //escapes special characters in a string for use in an SQL statement
    $pass1 =  mysqli_real_escape_string($db_conexion, $_POST['pass']);	

	$usuario_consulta = mysqli_query($db_conexion,"SELECT ID,usuario,pass,id_provincia,nombre_usuario,apellido_usuario,
		tipo_votante,bloqueo,id_ccaa,nivel_usuario,nivel_acceso,imagen_pequena,fecha_control,id_municipio,
		sms_validation_code,sms_validated 
		FROM $tbn9 WHERE usuario='".$user1."' AND usuario IS NOT NULL") or die(header ("Location:  $redir?error_login=1"));
 
	if (mysqli_num_rows($usuario_consulta) != 0) {   
		$login = stripslashes($user1); 
		$password = md5($pass1);		
	
		$usuario_datos = mysqli_fetch_array($usuario_consulta);
		mysqli_free_result($usuario_consulta);
		mysqli_close($db_conexion);
        
		if ($login != $usuario_datos['usuario']) {
			Header ("Location: $url_vot/index.php?error_login=4$regedi");
			exit;
		}
		if ($password != $usuario_datos['pass']) {
			Header ("Location: $url_vot/index.php?error_login=3$regedi");
			exit;
		}
		$sms_validated=$usuario_datos['sms_validated'];
		$sms_validation_code=$usuario_datos['sms_validation_code'];
		$error_clave_sms="?error_login=8"; //Inicializamos con error, para asegurarnos.
		if ($sms_validated==true){
			//Si ya se validó en su día, no volvemos a pedir la clave_sms
			$error_clave_sms="";
		}
		else{ //Si aún no se ha validado.
			//Si no se ha establecido la clave en la BD, error, debe pulsar "Registrarse".
			if ($sms_validation_code == ""){
				$error_clave_sms="?error_login=10";
			}
			else{
				if (isset($_POST['clave_sms'])){//Si han tecleado la clave, comprobamos que coincida con la clave de la BD.
					$clave_sms = mysqli_real_escape_string($con, $_POST['clave_sms']);					
					if ($clave_sms == $sms_validation_code){ //Si coincide, ok.
						$error_clave_sms="";
						//Actualizamos en la BD que sms_validated="S"
						$insql = "UPDATE $tbn9 SET sms_validated = true WHERE id=".$usuario_datos['ID']." ";
						$inres = @mysqli_query($con, $insql); //Si no conseguimos actualizarlo, no mostramos error, simplemente volverá a pedir la clave si vuelve a entrar.
					}
					else { //Si no coinciden, error, clave incorrecta.
						$error_clave_sms="?error_login=9";
					}
				}
				else{ //Si no han tecleado la clave_sms, error, deben teclearla.
					$error_clave_sms="?error_login=8";
				}
			}		
		}
		//Si ha habido algún error, redirigimos al index,con el texto del error.
		if ($error_clave_sms != "") {
			Header ("Location: $url_vot/index.php$error_clave_sms$regedi");
			exit;
		}
		
		if ($usuario_datos['bloqueo']=="si") {
			Header ("Location: $url_vot/index.php?error_login=7$regedi");
			exit;
		}
    
		unset($login);
		unset ($password);
	
		if ($civi==true){
			/*$datetime1 = $usuario_datos['fecha_control'];
			$datetime2 = date("Y-m-d");
			$interval = date_diff($datetime1, $datetime2);
			$interval->format('%R%a días');
			*/		
		}
  
		session_name($usuarios_sesion);
		session_start(); 
  
		session_cache_limiter('nocache,private');     
    
		$_SESSION['ID']=$usuario_datos['ID'];
		$_SESSION['tipo_votante']=$usuario_datos['tipo_votante'];  
		$_SESSION['usuario_login']=$usuario_datos['usuario'];  
		$_SESSION['usuario_password']=$usuario_datos['pass'];
		$_SESSION['nombre_usu']=$usuario_datos['nombre_usuario'];
		$_SESSION['localidad']=$usuario_datos['id_provincia'];   
		$_SESSION['id_ccaa_usu']=$usuario_datos['id_ccaa'];
		$_SESSION['id_municipio']=$usuario_datos['id_municipio'];
		$_SESSION['id_subgrupo_usu']=$usuario_datos['id_subgrupo'];
		$_SESSION['nivel_usu']=$usuario_datos['nivel_usuario'];  //tipo de usuario (administardor, votante, etc
		$_SESSION['usuario_nivel']=$usuario_datos['nivel_acceso']; //nivel del usuario dentro del tipo
		$_SESSION['imagen']=$usuario_datos['imagen_pequena']; /////imagen del usuario
		
		$_SESSION['CKFinder_UserRole']='admin';// prueba a ver si asi funciona 
	
		///////////////// miramos el codigo de la provincia para meterlo en la sesion
		$options = "select DISTINCT ID,provincia from $tbn8  where ID = ".$usuario_datos['id_provincia']."";
		$resulta = mysqli_query($con, $options) or die("error: ".mysqli_error());
		while( $listrows = mysqli_fetch_array($resulta) ){$provin= $listrows['ID'];	
		$_SESSION['provincia']=utf8_encode($listrows['provincia']);   }
		
		///////////////////////miramos la comunidad autonoma para meterlo tambien en la sesion
		
		$options2 = "select DISTINCT ID,ccaa from $tbn3  where ID = ".$usuario_datos['id_ccaa']." ";
		$resulta2 = mysqli_query($con, $options2) or die("error: ".mysqli_error());
		while( $listrows2 = mysqli_fetch_array($resulta2) ){
			$_SESSION['ccaa']=utf8_encode($listrows2['ccaa']);   
		}
	
		///////////////////////miramos el municipio para meterlo tambien en la sesion
    
		$options2 = "select DISTINCT nombre from $tbn18  where id_municipio = ".$usuario_datos['id_municipio']." ";
		$resulta2 = mysqli_query($con, $options2) or die("error: ".mysqli_error());
		while( $listrows2 = mysqli_fetch_array($resulta2) ){
			$_SESSION['municipio']=utf8_encode($listrows2['nombre']);   
		}
	
		$fecha =date("Y-m-d H:i:s");
		$insql = "UPDATE $tbn9 SET fecha_ultima =\"$fecha\" WHERE id=".$usuario_datos['ID']." ";
		$inres = @mysqli_query($con, $insql);
    
		Header ("Location: $PHP_SELF?");
		exit;
    
    } 
    else {	   
      Header ("Location: $url_vot/index.php?error_login=2$regedi");
      exit;
	}
} 
else { //Si falta usuario o passw
     session_name($usuarios_sesion);
     session_start();

	if (!isset($_SESSION['usuario_login']) && !isset($_SESSION['usuario_password'])){	
		session_destroy();
		//die ("Error cod.: 2 - ¡Acceso incorrecto! <br> <a href=login.php>VOLVER A INTENTARLO</a>");
		Header ("Location: $url_vot/index.php?error_login=6$regedi");
		exit;
	}
}

//añadido para verificar que existe el nivel de usuario
session_name($usuarios_sesion);
session_start();
if (!isset($_SESSION['usuario_nivel'])){	
	session_destroy();
	die ("Error cod.: 3 - ¡Acceso incorrecto! ");
	Header ("Location: $url_vot/interventores/index.php?error_login=6$regedi");
	exit;
}
	
?>