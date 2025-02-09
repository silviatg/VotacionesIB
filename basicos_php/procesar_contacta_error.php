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
include("../basicos_php/basico.php") ;


if( empty($_POST['texto'])	)
   {
	echo "No se han enviado argmentos!";
	return false;
   }
   
$name = fn_filtro_nodb($_POST['name']);
$email = fn_filtro_nodb($_POST['email']);
$provincia = fn_filtro_numerico($con,$_POST['provincia']);
$texto = fn_filtro_nodb($_POST['texto']);
$asunto = fn_filtro_nodb($_POST["asunto"]);

$nombre_cod=utf8_decode ( $name );

if($_POST['contacto_1']=="tecni"){
	$correo_error=$email_error_tecnico;
}
else{

	///miramos la direccion de correo a la que hay que enviar el correo segun la provincia
	
	$options2 = "select provincia,  correo_notificaciones from $tbn8 where id ='$provincia' ";
	$resulta2 = mysqli_query($con,$options2) or die("error: ".mysqli_error());
	
	//$nombre_provincia= mysqli_result($resulta2,0,'provincia'); 
	$linea =mysqli_fetch_row ($resulta2);
	$nombre_provincia= $linea[0];
		//if(mysqli_result($resulta2,0,'correo_notificaciones')!=""){
		if($linea[1]!=""){
		$correo_error= $linea[1]; 
		}
		else{
			$correo_error=$email_error; //si no hay resultados metemos el de configuracion general
		}
}

$texto = htmlentities($texto, ENT_NOQUOTES, 'UTF-8');//STG: Lo añado. PENDIENTE DE PROBAR
$name = htmlentities($name, ENT_NOQUOTES, 'UTF-8');//STG: Lo añado. PENDIENTE DE PROBAR
$asunto = htmlentities($asunto, ENT_NOQUOTES, 'UTF-8');//STG: Lo añado. PENDIENTE DE PROBAR

$mensaje = "Este mensaje fue enviado por : " . $name. " \r\n";
$mensaje .="con la direccion de correo: ".$email."<br />";
$mensaje .="y la provincia : ". $nombre_provincia."<br />";
$mensaje .= " el : " . date('d/m/Y', time());
$mensaje .= "<br /> Asunto : " . $asunto;
$mensaje .= "
<br />
y el con el siguiente texto  ; <br/><br/> " .$texto."<br />

\r\n";

//<$mail->IsSendmail(); // telling the class to use SendMail transport

$mensaje=str_replace("\n","<br>",$mensaje);
$mensaje=str_replace("\t","    ",$mensaje);
$mensaje=str_replace("\r\n","<br>",$mensaje); //STG: Lo añado
//$mensaje = htmlentities($mensaje, ENT_NOQUOTES, 'UTF-8'); // STG: Convertir caracteres especiales a entidades
//$mensaje = htmlspecialchars_decode($mensaje, ENT_NOQUOTES); // STG: Dejar <, & y > como estaban

//echo "mensaje:$mensaje";

if ($correo_smtp==true){  //comienzo envio smtp

	$mail = new PHPMailer();
	//$mail->ContentType = 'text/html'; //STG: Lo comento, para enviar el texto como html.
	$mail->IsHTML(true); //STG: Lo cambio a true, porque enviaba mal las tildes, ñs, etc.

	$asunto_="Contacto registro | ".$nombre_web."";
	$body = $mensaje;

	if($mail_sendmail==true){
		$mail->IsSendMail();	
	}else{
		$mail->IsSMTP(); 
	}

	$mail->Host = $host_smtp;
	$mail->SetFrom($email, $name);
	$mail->Subject = "CONTACTO Sistema votaciones - ". $asunto;

	$mail->MsgHTML($body);

	$mail->AddAddress($correo_error, $nombre_web);

	$mail->SMTPAuth = true;

	$mail->Username = $user_mail;
	$mail->Password = $pass_mail;  
	$mail->Port = $puerto_mail; // Puerto a utilizar, normalmente es el 25

	if(!$mail->Send()) {
	  echo " Error en el envio " . $mail->ErrorInfo;
	} else {
	 // echo "Enviado correctamente!";
		echo " 
		<div class=\"alert alert-success\">
			<strong>Se ha enviado su mensaje </strong><br/> 
			En breve le contestaremos <br/>
			Muchas gracias por contactar con nosotros.
			</div>";
	}
}


if ($correo_smtp==false){ ///correo mediante mail de php
	
	//para el envío en formato HTML 
	$headers = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

	//dirección del remitente 
	$headers .= "From: $name<$email>\r\n"; 


	//ruta del mensaje desde origen a destino 
	$headers .= "Return-path: $email\r\n"; 

	//$asunto="$asunto_mens_error";

  
	mail($correo_error,$asunto_,$mensaje,$headers) ;

	echo "<div class=\"alert alert-success\">
		<strong>Se ha enviado su mensaje </strong><br/> 
		En breve le contestaremos <br/>
		Muchas gracias por contactar con nosotros. 
		</div>";
}

return true;			
?>