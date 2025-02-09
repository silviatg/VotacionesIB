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
include ('../basicos_php/basico.php');


$url = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida=$url[0];
$redir=$pag_referida;
/*
$url2 = explode("?",'login.php');
$pag_referida2=$url2[0];
$redir2=$pag_referida2;
*/
/*  ojo esto hay que ver si para temas de suguridad se puede quitar*/
if ($_SERVER['HTTP_REFERER'] == ""){
die ("Error cod.:1 - Incorrect access");
exit;
}



if (isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['votacion'])) {

//$db_conexion= mysqli_connect("$host", "$hostu", "$hostp") or die(header ("Location:  $url_vot/index.php?error_login=0"));
//mysqli_select_db($db_conexion,"$dbn");

    //evitamos el sql inyeccion
    $user1 = mysqli_real_escape_string($con, $_POST['user']);
    $pass1 =  mysqli_real_escape_string($con, $_POST['pass']);
	$votacion1 =  fn_filtro_numerico($con, $_POST['votacion']);
	
	//miramos si la votacion esta activa y tiene opcion de interventores especiales
	 $result=mysqli_query($con,"SELECT activa,nombre_votacion,tipo_votante,interventores,interventor,tipo,ID FROM $tbn1 where ID=$votacion1");
    if (mysqli_num_rows($result) == 0) {    
      Header ("Location: $url_vot/interventores/index.php?error_login=7");
      exit;}
	  
	  
	    //  else {	
	 $row=mysqli_fetch_row($result);
	 
	 if ($row[0]=="si" && $row[4]=="si" && $row[3]!=0 ){
		 

$usuario_consulta = mysqli_query($con,"SELECT 	ID, nombre, apellidos, pass, usuario FROM $tbn11 WHERE usuario='".$user1."'  and tipo>=1  and id_votacion='".$votacion1."'") or die(header ("Location:  $redir?error_login=1"));

 	 		
 
 if (mysqli_num_rows($usuario_consulta) != 0) {   
    $login = stripslashes($user1); 
    $password = md5($pass1);

 
 	$usuario_datos = mysqli_fetch_array($usuario_consulta);
    mysqli_free_result($usuario_consulta);

    //mysqli_close($db_conexion); //STG: no estaba abierta la conexion
    
    
    if ($login != $usuario_datos['usuario']) {
       	Header ("Location: $url_vot/interventores/index.php?error_login=4");
		exit;}


    if ($password != $usuario_datos['pass']) {
        Header ("Location: $url_vot/interventores/index.php?error_login=3");
	    exit;}
		
		
	
    unset($login);
    unset ($password);
	
		/* establecer el limitador de caché a 'private' */

		session_cache_limiter('private');
		/* establecer la caducidad de la caché a 30 minutos */
		session_cache_expire(30);
	
      session_name($usuarios_sesion2);
      session_start();
 

  
    session_cache_limiter('nocache,private');
    
   
    
    $_SESSION['ID_inter_0']=$usuario_datos['ID'];
    $_SESSION['usuario_0']=$usuario_datos['usuario'];
	$_SESSION['nombre_inter_0']=$usuario_datos['nombre'];
	$_SESSION['apellidos_inter_0']=$usuario_datos['apellidos'];  
	
    $_SESSION['numero_vot']=$_POST['votacion'];
	$_SESSION['numero_id_vot']=$row[6];
	$_SESSION['activa']=$row[0];
	$_SESSION['nombre_votacion']=$row[1];
	$_SESSION['tipo_votante']=$row[2];
	$_SESSION['numero_inter']=$row[3];
	$_SESSION['tipo']=$row[5];
	 
	
	 
    $fecha =date("Y-m-d H:i:s");
    $insql = "UPDATE $tbn11 SET fecha_ultimo =\"$fecha\" WHERE id=".$usuario_datos['ID']." ";
    $inres = @mysqli_query($con, $insql);
  
  
    Header ("Location: $PHP_SELF?");
    exit;

   } 
   else {	   
      Header ("Location: $url_vot/interventores/index.php?error_login=2");
      exit;
	  }
   } else {

		Header ("Location: $url_vot/interventores/index.php?error_login=8");
      exit;	
		}
	session_name($usuarios_sesion2);
	session_start();
	if (!isset($_SESSION['usuario_login']) && !isset($_SESSION['usuario_password'])){	
	session_destroy();
	die ("Error cod.: 2 - ¡Acceso incorrecto! <br> <a href=login.php>VOLVER A INTENTARLO</a>");
	Header ("Location: $url_vot/interventores/index.php?error_login=6");
	exit;
		}
}
/* establecer el limitador de caché a 'private' */

session_cache_limiter('private');

/* establecer la caducidad de la caché a 30 minutos */
session_cache_expire(30);


		session_name($usuarios_sesion2);
		session_start();
	if (!isset($_SESSION['numero_inter'])){	
	session_destroy();
	die ("Error cod.: 3 - ¡Acceso incorrecto! ");
	Header ("Location: $url_vot/interventores/index.php?error_login=6");
	exit;}/**/
	
?>