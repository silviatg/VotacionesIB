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
require_once('../modulos/PHPMailer/class.phpmailer.php');
include("../modulos/PHPMailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
include ('../basicos_php/basico.php');


if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['provincia'])	||
   empty($_POST['nif'])	||
   empty($_POST['tfno'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "¡No se han enviado argumentos!";
	return false;
   }

   
$name = fn_filtro_nodb($_POST['name']);
$email = fn_filtro_nodb($_POST['email']);
$provincia = fn_filtro_numerico($con,$_POST['provincia']);
$nif = fn_filtro_nodb($_POST['nif']);
$tfno = fn_filtro_nodb($_POST['tfno']);
$name= utf8_decode($name);
$asunto= utf8_decode($asunto);


//validación de NIF del lado del servidor.
$nif = str_replace(array(' ', '-'), array('', ''), $nif);
$nif = strtoupper($nif); //Pasamos a mayúsculas.
$DNIvalido = fn_validar_DNI($nif);
$continuar=false; //Inicializamos a false para asegurar validaciones.
if ($DNIvalido != "OK"){
	$textoError="$DNIvalido. Revisa si has tecleado el NIF/NIE correctamente. Si es así, ";
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
		$textoError="$TFNOvalido. Revisa si has tecleado el teléfono móvil correctamente. Si es así, ";
	}
	else{
		$continuar = true;
	}
}

if ($continuar==true){
	$textoError = "Error no especificado"; //Inicializamos error para forzar validaciones.
	
	//STG: Compruebo si existe el mail, da igual la provincia. Quito: and id_provincia='$provincia' 
	$conta="SELECT id,pass,nif,telefono, sms_validation_code  FROM $tbn9 WHERE correo_usuario = '$email'"; 
	$result_cont=mysqli_query($con,$conta);
	$quants=mysqli_num_rows($result_cont);


	if ($quants == ""){ //Si no ha encontrado el mail	

		//STG: Se va a permitir que los usuarios se den de alta online. 
		//     Por tanto, si el email no existe en la BD, en lugar de mostrar error, daremos de alta un usuario con ese mail,nif y tfno.
		/* ANTES:
			echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">x</a>";
			echo "<strong>¡¡¡ERROR!!!</strong><br/> Esta direccion de correo no la tenemos registrada para esta provincia, quizas sea un error de nuestra base de datos , si consideras que tienes derecho a votar haz <a data-toggle=\"modal\" href=\"#contacta\"  data-dismiss=\"modal\" > click aqui para enviarnos tus datos a traves de nuestro formulario</a>.";
		*/
			
		/*NUEVO: Si no existe ese mail, pero sí que existe el NIF o el tfno, puede que esté intentando entrar con distinto mail la
		misma persona, para votar dos veces => Mensaje de error, y le obligamos a contactar si quiere entrar.
		*/
		$contaRepet="SELECT id,pass,nif,telefono,correo_usuario FROM $tbn9 WHERE nif = '$nif' or telefono = $tfno";
		$result_cont_Repet=mysqli_query($con,$contaRepet);
		$quantsRepet=mysqli_num_rows($result_cont_Repet);
		if ($quantsRepet != ""){ //Si ha encontrado alguno, mostramos el error.
			//Si el correo está vacío, es porque se le ha dado de alta desde el censo de votantes (votaría presencialmente)
			//y no indicó mail en ese momento. Si ahora quiere entrar al sistema porque ya tiene email, obligarle a contactar,
			//para evitar que use el nif de alguien que ha votado con su email. (al obligarle a contactar, tendríamos su correo)
			$row=mysqli_fetch_row($result_cont_Repet);
			if ($row[correo_usuario] == "" || $row[telefono] == ""){
				$textoError = "Parece ser que ya estás registrado en nuestro sistema, pero no nos indicaste todos los datos de validación (email y teléfono). Para que podamos asegurar que nadie suplanta tu identidad, ";
			}
			else {
				$textoError = "El NIF o el teléfono están asociados a otro email. Revisa si el email introducido es correcto. Si es así, ";	
			}			
		}
		else{   //Si no, es un usuario nuevo. => Alta en BD.
			
			$optiones = "select DISTINCT id_ccaa from $tbn8 where ID ='$provincia' ";
			$resultas = mysqli_query($con, $optiones) or die("error: ".mysql_error($con));		
			while( $listrowes = mysqli_fetch_array($resultas) ){ 	
				$id_ccaa = $listrowes[id_ccaa];
			}
			
			$tipo_votante=3; //Simpatizante sin verificar. (Verificado lo dejamos para los que han estado en algún evento físico).
			$id_municipio=1; //TO-DO. Pongo a pelo el municipio=1 (Burgos Capital) => solicitarlo al usuario si abrimos la aplicación a más municipios.
			
			$insql = "insert into $tbn9 (nombre_usuario, id_provincia, correo_usuario, nif, telefono, tipo_votante,id_ccaa,id_municipio )"
					."values ( \"$name\", \"$provincia\", \"$email\", \"$nif\",  \"$tfno\", \"$tipo_votante\", \"$id_ccaa\", \"$id_municipio\" )";
			$inres = @mysqli_query($con,$insql);
			if ($inres===false){ //Si hubo error al insertar, lo muestro.
				$textoError = "Compruebe que los datos son correctos. Si el error persiste, ";
			}
			else{
				$id_votante = mysqli_insert_id($con); //El IdVotante es autonumérico, lo recuperamos.
				$textoError = "";
				
				/* metemos un control para saber quien ha incluido este votante*/
				$accion="1"; //uno , incluir nuevo votante
				$fecha =date("Y-m-d H:i:s");
				$insql = "insert into $tbn17 (id_votante,id_admin,accion,fecha ) values (  \"$id_votante\",\"".$_SESSION['ID']."\",   \"$accion\", \"$fecha\" )";
				$inres = @mysqli_query($con,$insql); //Si falla esto, continuamos //or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");			
			}
		}
	}
	else { //Si sí que ha encontrado el mail en la BD.

		$row = mysqli_fetch_array($result_cont);
		$id_votante=$row[0];
		if($row[1] != ""){ //Tiene relleno el campo pass en la BD.
			$ya_clave = "ya_tiene_clave";
		}		
		//STG+-; 10-02-19. Actualizamos la BD para que todo el mundo tenga ese campo relleno con un 1, y cuando insertemos nuevos, también.
		if($row[4] != ""){ //Tiene relleno el campo sms_validation_code en la BD. 
			$ya_sms = "ya_tiene_sms";
		}	
		$nifBD=$row[2];
		$tfnoBD=$row[3];
		
		//echo "nifBD:$nifBD nif:$nif tfnoBD:$tfnoBD tfno:$tfno";
		//El NIF no puede ser nulo en la BD, pero el tfno puede que aún no esté relleno.
		//Si el NIF introducido no coincide con el de la BD, hay un error. Deberán escribir al admin si quieren solucionarlo.
		if ($nifBD != $nif){
			$textoError = "El NIF introducido no se corresponde con el que ha registrado anteriormente para este correo electrónico. Revisa si todos los datos son correctos. Si es así, ";
		} 
		else {
			//Si en la BD no teníamos su tfno, y ahora lo ha introducido, deberemos actualizarlo.		
			if ($tfnoBD == ""){		
				//Si tenía el tfno vacío, y hay otro usuario con ese tfno, mostraremos error.
				$contaRepet="SELECT telefono FROM $tbn9 WHERE telefono = $tfno";
				$result_cont_Repet=mysqli_query($con,$contaRepet);
				$quantsRepet=mysqli_num_rows($result_cont_Repet);
				if ($quantsRepet != ""){ //Si ha encontrado alguno, mostramos el error.
					$textoError = "El teléfono está asociado a otro email. Si ha registrado su teléfono previamente con otro email, indique 
						el email que introdujo anteriormente. Si no es así, por favor contacte con nosotros. Para ello, ";
				}
				else{
					$sSQL="UPDATE $tbn9 SET telefono=$tfno WHERE ID='$id_votante'";
					mysqli_query($con,$sSQL); //or die ("Imposible modificar teléfono del usuario"); //STG: Quito "or die" para poder gestionar el error...
					$textoError = mysqli_error($con);				
					if ($textoError != ""){
						$textoError = "Imposible modificar teléfono del usuario";
						/*STG: metemos un control para saber quien ha modificado este votante*/
						$accion="2"; //dos , modifiicar votante
						$fecha= date("Y-m-d H:i:s");
						//Como aún no estamos validados en la sesión, en idAdmin se guarda 0.
						$insql = "insert into $tbn17 (id_votante,id_admin,accion,fecha ) values (  \"$id_votante\",\"".$_SESSION['ID']."\", \"$accion\", \"$fecha\" )";
						$inres = @mysqli_query($con,$insql); //Si falla esto, continuamos				
					}
				}				
			}
			else{
				if ($tfnoBD != $tfno){
					//Si el tfno introducido no coincide con el de la BD, hay un error. Deberán escribir al admin si quieren solucionarlo.
					$textoError = "El teléfono introducido no se corresponde con el que ha registrado anteriormente para este correo electrónico. Revisa si todos los datos son correctos. Si es así, ";
				}
				else{
					$textoError = "";
				}
			}
		}
	}
}
//echo "textoError:$textoError";
//exit;

if ($textoError!=""){
		echo "<div class=\"alert alert-warning\" id=\"with-error\">";
		echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">x</a>";
		echo "<strong>¡Se ha producido un error!.</strong><br/> $textoError <a data-toggle=\"modal\" href=\"#contacta\"  data-dismiss=\"modal\" > haz click aquí para enviarnos tus datos a traves de nuestro formulario</a>";
		echo "</div>";
		return false;
}
else {
	//echo "<div class=\"alert alert-warning\" id=\"with-error\">"; //STG: Aunque no tenga que mostrar mensaje, tengo que pintar el div, porque si no, no mostraba otros mensajes de error.
	//echo "</div>"; //STG. Cerramos el div	

	//Si todos los datos introducidos concuerdan con la BD: mail, tfno, nif, continuamos => Se mandará el mail para registrase.
	
	////////////////////////////incluimos en la base de datos los datos del envio
	$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	$cad = "";
	for($i=0;$i<12;$i++) {
		$cad .= substr($str,rand(0,62),1);
	}	
	$sSQL="UPDATE $tbn9 SET codigo_rec=\"$cad\"  WHERE ID='$id_votante'";
	mysqli_query($con,$sSQL)or die ("Imposible modificar clave del usuario");
	
	/*STG: metemos un control para saber quien ha modificado este votante*/
	$accion="2"; //dos , modifiicar votante
	$fecha= date("Y-m-d H:i:s");
	//Como aún no estamos validados en la sesión, en idAdmin se guarda 0.
	$insql = "insert into $tbn17 (id_votante,id_admin,accion,fecha ) values (  \"$id_votante\",\"".$_SESSION['ID']."\", \"$accion\", \"$fecha\" )";
	$inres = @mysqli_query($con,$insql); //Si falla esto, continuamos
	
	///////////////////enviamos un correo 
	function encrypt ($string, $key) { 
		$result = ''; 
		for ($i=0; $i<strlen ($string); $i++) { 
			$char = substr ($string, $i, 1); 
			$keychar = substr ($key, ($i % strlen ($key))-1, 1); 
			$char = chr (ord ($char)+ord ($keychar)); 
			$result.=$char; 
		} 
		return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode ($result)); 
	}

	$cadena_para_encriptar=$_POST['provincia']."_"."$id_votante"."_"."$cad";
	$cadena_encriptada = encrypt ($cadena_para_encriptar,$clave_encriptacion);

	$cadena_para_encriptar2="nwt-".$id_votante;
	$cadena_encriptada2 = encrypt ($cadena_para_encriptar2,$clave_encriptacion2);

	$mensaje = "Hola " . $name . " \r\n \r\n";

	$mensaje .= "Este mensaje ha sido enviado por el sistema de votaciones ".$nombre_web."  el " . date('d/m/Y', time());
	/*
	if($ya_clave == "ya_tiene_clave"){
		$mensaje .= "\n
		Te enviamos un enlace para recuperar tu contrase&ntilde;a.\n\n";
	}
	else{
		$mensaje .= "\n
		Te enviamos un enlace para finalizar tu registro.\n\n";
	}
	*/

	$mensaje .="\n\nPor su seguridad, y s&oacute;lo la primera vez que entre en la web de votaciones, deber&aacute; completar varios pasos para el registro.
	Todos ellos son absolutamente necesarios para garantizar que nadie puede votar por usted, y asegurar as&iacute; unas votaciones realmente democr&aacute;ticas. \nLas próximas veces sólo tendras que utilizar tu usuario y contraseña. ;-)
	\n\nPASOS:
	\n 1. En primer lugar, deber&aacute; acceder a la siguiente direcci&oacute;n web. P&eacute;guela en su navegador si no le aparece el enlace: \n ".$url_vot."/rec_contr.php?regedi=".$cadena_encriptada2."&idpr=".$cadena_encriptada." 
	\n 2. Por favor, vuelva a introducir all&iacute; sus datos personales y establezca una contrase&ntilde;a que debe memorizar.
	\n 3. Pulse el bot&oacute;n Enviar y obtendr&aacute; un aviso que le indicar&aacute; que su usuario y contrase&ntilde;a han sido registrados.";	
	if ($ya_sms == ""){
		$mensaje .=" Le indicar&aacute; tambi&eacute;n que se le ha enviado un sms al m&oacute;vil.";
	}
	$mensaje .= " \n\n 4. Pulse el enlace para acceder al sistema de votaciones.";
	if ($ya_sms == ""){
		$mensaje .=" Espere a recibir el sms en su m&oacute;vil, que puede tardar varios minutos, dependiendo del tr&aacute;fico en la red.";
	}	
	$mensaje .= "\n\n 5. Introduzca el usuario y la contrase&ntilde;a elegida por usted";
	if ($ya_sms == ""){
		$mensaje .= ", adem&aacute;s de la clave enviada por sms";		
	}	
	$mensaje .= ". Ya podr&aacute; realizar su votaci&oacute;n. \n\n(Si no ha verificado su DNI anteriormente, en la plataforma le dirá cómo hacerlo).";
	$mensaje .= "\n\n Si tiene cualquier duda, puede contactar con el soporte técnico, por cualquiera de las vías que se indican en la página de votaciones.";
	//$mensaje .= "\n\n Si lo desea, puede visualizar el v&iacute;deo-tutorial que explica el proceso de registro y de votaci&oacute;n: https://youtu.be/SSL5xljlbx4";
    $mensaje .= "\n\n * Si no has solicitado la contrase&ntilde;a, alguien que conoce tu direcci&oacute;n de correo lo ha hecho, pero puedes obviar este correo ya que el sistema no permite modificar tu contrase&ntilde;a a otro usuario desde otro email. \n\n Muchas gracias por participar en las votaciones de Imagina Burgos. Tu opinión cuenta.";

	$mensaje=str_replace("\n","<br>",$mensaje);
	$mensaje=str_replace("\t","    ",$mensaje);
	$mensaje=str_replace("\r\n","<br>",$mensaje);

	if ($correo_smtp==true){  //comienzo envio smtp
		$mail = new PHPMailer();//OK
        //$mail->ContentType = 'text/plain'; //STG: lo quito
        $mail->IsHTML(true); //STG: Cambio de false a true, porque no se veían bien las tildes, ni ñs en el mail.

		$body = $mensaje;		
		
		if($mail_sendmail==true){
			$mail->IsSendMail();	
		}else{
			$mail->IsSMTP(); //OK
		}			
		
		//$mail­>Encoding = 'quoted­printable';		
		//$mail->SMTPSecure = 'ssl'; //STG: tsl, ssl.

		$mail->Host = $host_smtp; //OK
		$mail->CharSet = 'iso-8859-1';
		$mail->SetFrom($email_env, $nombre_sistema); //OK
		$mail->Subject = $asunto; //OK
		$mail->MsgHTML($body); //OK
		$mail->AddAddress($email, $name);//OK
		$mail->SMTPAuth = true; //OK
		$mail->Username = $user_mail; //OK
		$mail->Password = $pass_mail;  //OK
		$mail->Port = $puerto_mail; //OK  // Puerto a utilizar, normalmente es el 25
		


		if(!$mail->Send()) {
		  echo " Error en el envio " . $mail->ErrorInfo;
		} 
		else {
		 // echo "Enviado correctamente!";
			echo "<div class=\"alert alert-success\">
				<strong>Se ha enviado un email a su direcci&oacute;n de correo para validar su cuenta y as&iacute; poder participar en las votaciones.</strong><br/> 
				Revise su correo y siga las instrucciones para completar su registro.<br>
				Si no recibe el correo compruebe su carpeta de spam por si est&aacute; all&iacute;. <br/>
				Si a&uacute;n as&iacute; no lo recibe, vuelva a intentar registrarse, asegur&aacute;ndose de que introduce su correo corr&eacute;ctamente.<br/>
				Si el mail es correcto y continúa teniendo algún problema, contáctenos (datos de contacto en la página de inicio) 
				<a href=\"index.php\">Por favor, cierre esta ventana</a>
				</div>";
		}
	}

	if ($correo_smtp==false){ ///correo mediante mail de php
		//para el envío en formato HTML 
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

		//dirección del remitente 
		$headers .= "From: $nombre_sistema <$email_env>\r\n"; 

		//ruta del mensaje desde origen a destino 
		$headers .= "Return-path: $email_env\r\n"; 

		//$asunto="$asunto_mens_error";	  
		mail($email,$asunto,$mensaje,$headers) ;

		echo "enviad correo por mail";
	}
	return true;		
}

		
?>