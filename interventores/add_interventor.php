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
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		
		header("Cache-Control: no-cache, must-revalidate");           
		header("Pragma: no-cache");                                   
include('verifica.php');
if(empty ($_SESSION['numero_vot'])){
header ("Location: $redir?error_login=5");
exit;
}

//require_once("../inc_web/config.inc.php");

include ('../basicos_php/basico.php');

if (isset($_POST['usuario']) && isset($_POST['password'])) {
 		
    $user1 = mysqli_real_escape_string($con, $_POST['usuario']);
    $pass1 =  mysqli_real_escape_string($con, $_POST['password']);
	$votacion2 =  fn_filtro_numerico($con, $_POST['votacion1']);
	$n_interventor= mysqli_real_escape_string($con,$_POST['n_interventor']);
	// $votacion1 =  000017;
	// echo "id votacion". $votacion1;
	//miramos si la votacion esta activa y tiene opcion de interventores especiales
	 $result=mysqli_query($con,"SELECT activa,nombre_votacion,tipo_votante,interventores,interventor,tipo FROM $tbn1 where ID=".$votacion2." and interventor='si' and activa ='si'");

		if (mysqli_num_rows($result) == 0) {    
		  echo "Error4";
		  exit;
		  }
		  
	 
	 $row=mysqli_fetch_row($result);
	 
	$usuario_consulta = mysqli_query($con,"SELECT 	ID, nombre, apellidos, pass, usuario FROM $tbn11 WHERE usuario='".$user1."'   and tipo>=1  and id_votacion='".$votacion2."'") or die(header ("Location:  $redir?error_login=1"));

 	  	
 
 if (mysqli_num_rows($usuario_consulta) != 0) {   
    $login = stripslashes($user1); 
    $password = md5($pass1);

 
 	$usuario_datos = mysqli_fetch_array($usuario_consulta);
    mysqli_free_result($usuario_consulta);

    //mysqli_close($con);
   
    
    if ($login != $usuario_datos['usuario']) {
		//$response_array['status'] = 'error'; 
      // echo "Error cod 1. - Usuario o password no existen";
	  echo "Error1";
		exit;}


    if ($password != $usuario_datos['pass']) {
		//$response_array['status'] = 'error'; 
        echo "Error1";
	    exit;}
		
	
    unset($usuario);
    unset ($password);

	  /* establecer el limitador de caché a 'private' */
	  session_cache_limiter('nocache,private');
	  /* establecer la caducidad de la caché a 30 minutos */
	  session_cache_expire(30);
      session_name($usuarios_sesion2);
      session_start();
	 /*miramos si este interventor ya esta loguedo*/ 
    for($i=0;$i<$_SESSION['numero_inter'];$i++) {
			$id_inter="ID_inter_".$i;
			
    if ($usuario_datos['ID']==$_SESSION[$id_inter]) {
        echo "Error2";
	    exit;
		}
 	}
	
    
    $id_inter="ID_inter_".$n_interventor;
    $usuario="usuario_".$n_interventor;
	$nombre_inter="nombre_inter_".$n_interventor;
	$apellidos_inter="apellidos_inter_".$n_interventor;
	
    $_SESSION[$id_inter]=$usuario_datos['ID'];
    $_SESSION[$usuario]=$usuario_datos['usuario'];
	$_SESSION[$nombre_inter]=$usuario_datos['nombre'];
	$_SESSION[$apellidos_inter]=$usuario_datos['apellidos'];  
    

	 
    $fecha =date("Y-m-d H:i:s");
    $insql = "UPDATE $tbn11 SET fecha_ultimo =\"$fecha\" WHERE id=".$usuario_datos['ID']." ";
    $inres = @mysqli_query($con, $insql);
  
    echo "<div class=\"alert alert-success\"> Ha sido correctamente logueado el interventor" .$_SESSION[$nombre_inter]. "  " .$_SESSION[$apellidos_inter] ."</div>";
    //Header ("Location: $PHP_SELF?");
    exit;

   } else{
	   echo "Error1";
      exit;
   }
} 
else { 
	  echo "Error3";
      exit;
}
//echo $_POST['usuario'];
?>