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
require_once('../basicos_php/crypt.php'); //STG: Lo añado, para usar la funcion "desencriptar", para la url. 
$errores="";

//STG: añado nif y tfno
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['pass'])	||
   empty($_POST['pass2'])	||
   empty($_POST['nif'])	||
   empty($_POST['tfno'])	||      
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "¡No se han enviado argumentos!";
	return false;
   }
 
 if(empty($_POST['npdr'])  		||
   empty($_POST['idrec']) 	
  )
 {
	echo "Algo esta haciendo mal!!<br/> acceda mediante el enlace que le hemos enviado al correo electronico";
	return false;
 }

$name = fn_filtro($con,$_POST['name']);
$email = fn_filtro($con,$_POST['email']);
$pass = fn_filtro($con,$_POST['pass']);
$pass2 = fn_filtro($con,$_POST['pass2']);
$nif = fn_filtro($con,$_POST['nif']); //STG
$tfno = fn_filtro($con,$_POST['tfno']); //STG
//$npdr = $_POST['npdr'];
$idrec = $_POST['idrec'];

//validación de NIF del lado del servidor.
$nif = str_replace(array(' ', '-'), array('', ''), $nif);
$nif = strtoupper($nif); //Pasamos a mayúsculas.
$DNIvalido = fn_validar_DNI($nif);
$continuar=false; //Inicializamos a false para asegurar validaciones.
$errorContacta="";
if ($DNIvalido != "OK"){
	$errores="$DNIvalido. Revisa si has tecleado el NIF/NIE correctamente.";
	//$errorContacta .=$errores." Si es así, ";
}
else{
	$continuar = true;
}

//validación de TFNO del lado del servidor.
if ($continuar==true){	
	$tfno = str_replace(array(' ', '-', '+'), array('', '', ''), $tfno);
	$TFNOvalido = fn_validar_tfno($tfno);
	$continuar=false; //Inicializamos a false para asegurar validaciones.
	if ($TFNOvalido != "OK"){
		$errores="$TFNOvalido. Revisa si has tecleado el teléfono móvil correctamente. ";
		//$errorContacta .=$errores."Si es así, ";
	}
	else{
		$continuar = true;
	}
}

function comprobar_nombre_usuario($nombre_usuario){ 
   //compruebo que el tamaño del string sea válido. 
   if (strlen($nombre_usuario)<5 || strlen($nombre_usuario)>20){ 
      $error="error1"; 
      return $error; 
   } 

   //compruebo que los caracteres sean los permitidos 
   $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_"; 
   for ($i=0; $i<strlen($nombre_usuario); $i++){ 
      if (strpos($permitidos, substr($nombre_usuario,$i,1))===false){ 
        $error="error2"; 
		return $error;		 
      } 
   } 
  //echo $nombre_usuario . " es válido<br>"; 
   return $nombre_usuario; 
} 

if ($continuar==true){	
	$nombre_usuario_new=comprobar_nombre_usuario($name);

	if($nombre_usuario_new=="error1"){
		$errores= "El nombre de usuario". $nombre_usuario . " no es válido<br/> Tiene que tener entre 5 y 20 caracteres <br/>"; 
		//return false;
	}
	elseif($nombre_usuario_new=="error2"){
		$errores= "El nombre de usuario". $nombre_usuario . " no es válido, esta mal formado, no puede tener espacios en blanco, acentos, ñ ...<br/>";     
	}
	else{

		function decrypt ($string, $key) { 
			$result = ''; 
			$string = str_replace(array('-', '_'), array('+', '/'), $string);
			$string = base64_decode ($string); 
			for ($i=0; $i<strlen ($string); $i++) { 
				$char = substr ($string, $i, 1); 
				$keychar = substr ($key, ($i % strlen ($key))-1, 1); 
				$char = chr (ord ($char)-ord ($keychar)); 
				$result.=$char; 
			} 
			return $result; 
		}

		$clave_encriptada=$_POST['npdr'];
		$cadena_desencriptada = decrypt ($clave_encriptada,$clave_encriptacion); 
		$array_cadena = explode('_', $cadena_desencriptada);

		$id_provincia="$array_cadena[0]";
		$id_usuario1="$array_cadena[1]";
		$clave_necesaria="$array_cadena[2]";


		$clave_encriptada2=$_POST['idrec'];
		//$clave_encriptada2 = str_replace(array('-', '_'), array('+', '/'), $clave_encriptada2);
		$cadena_desencriptada2 = decrypt ($clave_encriptada2,$clave_encriptacion2); 
		$array_cadena2 = explode('-', $cadena_desencriptada2);
		$clavecilla="$array_cadena2[0]";
		$id_usuario2="$array_cadena2[1]";

		//echo "<br>clavecilla:$clavecilla usuario2:$id_usuario2";
		
		if($clavecilla=="nwt"){
			if($id_usuario1==$id_usuario2){
				$result = mysqli_query($con,"SELECT id_provincia,correo_usuario,nif,telefono,sms_validation_code,sms_validated
							FROM $tbn9 WHERE ID=$id_usuario1 and codigo_rec='$clave_necesaria'") or die("No se pudo realizar la consulta a la Base de datos");
			
				if ($row = mysqli_fetch_array($result)){
					mysqli_field_seek($result,0);
					do {
						
						//STG: Comprobamos que el tfno y nif de la BD coinciden con los introducidos por pantalla.
						$nifBD=$row[nif];
						$tfnoBD=$row[telefono];
						$sms_validation_code_BD=$row[sms_validation_code];
						$sms_validated_BD=$row[sms_validated];																
						
						//Si el NIF introducido no coincide con el de la BD, hay un error. 
						//Deberán escribir al admin si quieren solucionarlo.
						if ($nifBD != $nif){
							$errorContacta = "El NIF introducido no se corresponde con el que ha registrado anteriormente para este correo electrónico. <br><br>Revisa si todos los datos son correctos. Si es así, ";
						} 
						elseif ($tfnoBD != $tfno){							
							//Si el tfno introducido no coincide con el de la BD, hay un error. Deberán escribir al admin si quieren solucionarlo.
							$errorContacta = "El teléfono introducido no se corresponde con el que ha registrado anteriormente para este correo electrónico.<br><br>Revisa si todos los datos son correctos. Si es así,  ";
						}
						else{							
							/*STG. CORREGIMOS BUG: 
							Antes no comprobábamos si el nick introducido ya existe para otro usuario, así que podía poner un usuario existente, 
							y luego entrar a votar por él.
							*/
							$contaRepet="SELECT id FROM $tbn9 WHERE usuario = '$nombre_usuario_new' and ID <>'$id_usuario1'";
							$result_cont_Repet=mysqli_query($con,$contaRepet);
							$quantsRepet=mysqli_num_rows($result_cont_Repet);
							if ($quantsRepet != ""){ //Si ha encontrado alguno, mostramos el error.
								$errores = "El nombre de usuario no es válido, ya está usado por otra persona.";
							}
							else{
								if($id_provincia==$row[0] and $email==$row[1]){								
									$passw = md5($pass);
									$sms_validation_code_new=null;
									$correcto= "Su usuario y contraseña han sido registrados.";	//Inicializamos.
									if ($sms_validation_code_BD==""){										
										$sms_validation_code_new =  strval(mt_rand(100000000,999999999));										
										try {
											require_once("../basicos_php/AltiriaSMSMailer.php");
											if (!isset($sms_mailer)){
												$sms_mailer = new AltiriaSMSMailer($sms_user, $sms_passwd, $sms_domain);
											}
											//echo "sms_user:$sms_user sms_passwd:$sms_passwd sms_domain:$sms_domain tfno:$tfno sms_validation_code_new:$sms_validation_code_new sms_sender:$sms_sender";
											$tfno="34".$tfno; //Añadimos el prefijo de España.
											if ($Cancelar_Envio_SMS == "S"){
												$correcto .= " <BR/><BR/>Se ha cancelado temporalmente el envio de SMS. Contacte con $email_error indicando su email, para que le diga la clave que deberá introducir para acceder por primera vez al sistema.";
											} else{											
												$sms_mailer->send_sms($tfno, "Tu codigo de activacion es ".$sms_validation_code_new, $sms_sender);												
												$correcto .= " <BR/><BR/>En breve <b>recibirá un sms</b> con la clave que deberá introducir para acceder por primera vez al sistema.";
											}							
											
											//Si mandamos sms correctamente, guardamos en BD el código generado.
											$sSQL12="UPDATE $tbn9 SET pass='$passw', usuario='$nombre_usuario_new' ";
											$sSQL12 .= ", sms_validation_code='$sms_validation_code_new'";	
											$sSQL12 .= " WHERE ID='$id_usuario1'";
											mysqli_query($con,$sSQL12)or die ("Imposible modificar datos");
										
										} catch (Exception $e) {											
											$errorContacta = "No ha sido posible enviar un SMS de confirmación en estos momentos. Inténtelo de nuevo, y si el error persiste, ";
											$errorDetallado = $e->getMessage() . "\n";
											$errorContacta .= $errorDetallado;
										}																			
									}
									else{//Si no mandamos sms porque ya se mandó en su día, actualizamos sólo usuario y contraseña.
										$sSQL12="UPDATE $tbn9 SET pass='$passw', usuario='$nombre_usuario_new' ";
										$sSQL12 .= " WHERE ID='$id_usuario1'";
										mysqli_query($con,$sSQL12)or die ("Imposible modificar datos");
										
										$correcto .= " <BR/><BR/>Ya puede acceder al sistema de votaciones.";
									}	
								}
								else{
									$errores= "El correo introducido no es el correcto, revíselo, por favor.";
								}												
							}							
						}					
					}
					while ($row = mysqli_fetch_array($result));
				}		
				else {
					$errores= " Ups, parece que estás intentando recuperar tu contraseña desde un correo anterior. Si ha intentado recuperarla varias veces, revise que la fecha/hora del correo desde el que está intentando recuperarlo coincida con el último intento realizado. Quizás también deba revisar su carpeta de spam. Si no es el caso o sigue teniendo problemas para acceder, contacta con Imagina, indicando el código de error número '$clave_necesaria' y su clave de usuario  $id_usuario1."; //STG: 13-3-19
				}
				//aqui
			}
			else{
				$errores= "Upsss, algo esta pasando y hay un error.  Por favor, contacta con Imagina y diles el código de error número 001.";	//STG: 13-3-19
			}
		}	
		else{
			$errores= "Upsss, algo esta pasando y hay un error. Por favor, contacta con Imagina, indicando el código de error número 002.";	//STG: 13-3-19
		}
	}
} //Fin, $continuar

//STG: Aunque no tenga que mostrar mensaje, tengo que pintar el div, porque si no, no mostraba otros mensajes de error.
if ($errorContacta!=""){
	echo "<br><div class=\"alert alert-danger\"> 
		 <a class=\"close\" data-dismiss=\"alert\">x</a>".$errorContacta."<a data-toggle=\"modal\" href=\"#contacta\"  data-dismiss=\"modal\" > haz click aquí para enviarnos tus datos a traves de nuestro formulario</a>.
		 </div>";	
}
elseif($errores!=""){
	echo "<br><div class=\"alert alert-danger\"> 
             <a class=\"close\" data-dismiss=\"alert\">x</a>".$errores."
             </div>";
	//return false;
}else{
	//Indicamos que en la página de index, debe mostrar input para solicitar la clave.	
	if ($sms_validated_BD == false){
		$cadena_para_encriptar="solicitar_clave_sms";
		$cadena_encriptada = encriptar ($cadena_para_encriptar,$clave_encriptacion2);
		$url="?regedi=$cadena_encriptada";
	}						
	echo "<br><div class=\"alert alert-success\"> 
             <a class=\"close\" data-dismiss=\"alert\">x</a>".$correcto."
			 <br><br/><a  href=\"index.php$url\">Acceder al sistema de votaciones</a>
             </div>";
	//return true;
}

return true;


			
?>
