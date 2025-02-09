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
include('../inc_web/config.inc.php');
require_once('../modulos/PHPMailer/class.phpmailer.php');
include("../modulos/PHPMailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mensaje = "";

$mensaje = "Este mensaje fue enviado de forma automatica por el sistema de votaciones \r\n";

$mensaje .= " el " . date('d/m/Y', time());

$mensaje .= "<br /> el usuario ha votado lo siguiente: 
<br />

".
 $datos_votado.";


\r\n";


$asunto_mens_ref= "Nuevo voto ".microtime()." de la encuesta $nombre_votacion";

//<$mail->IsSendmail(); // telling the class to use SendMail transport

$mensaje=str_replace("\n","<br>",$mensaje);
$mensaje=str_replace("\t","    ",$mensaje);

if ($correo_smtp==true){  //comienzo envio smtp

	$mail = new PHPMailer();
    $mail->ContentType = 'text/plain'; 
    $mail->IsHTML(false);

	$body = $mensaje;

	if($mail_sendmail==true){
		$mail->IsSendMail();	
	}else{
		$mail->IsSMTP(); 
	}

	$mail->Host = $host_smtp;
	$mail->SetFrom($email_control, $nombre_eq);
	$mail->Subject = $asunto_mens_ref;

	$mail->MsgHTML($body);

	///miramos las direcciones de correo a la que hay que enviar el correo	

	$sql = "SELECT nombre, apellidos,correo FROM $tbn11 WHERE id_votacion = '$idvot' and tipo<=1 ";
	$result = mysqli_query($con, $sql);

	if ($row = mysqli_fetch_array($result)){
		mysqli_field_seek($result,0);
		do {
			$correo_interventor= "$row[2]" ;
			$nombre_interventor="$row[0] $row[1]" ;
			$mail->AddAddress($correo_interventor, $nombre_interventor);
		}
		while ($row = mysqli_fetch_array($result));
		
		//fin del bucle para enviar el correo
		$mail->SMTPAuth = true;
		$mail->Username = $user_mail;
		$mail->Password = $pass_mail; 

		if(!$mail->Send()) {
			echo " Error en el envio " . $mail->ErrorInfo;
	  
			$process_result = "ERROR";
			$msg_result.= " Error en el envio " . $mail->ErrorInfo;
		} else {
			// echo "Enviado correctamente!";
		}
	}	
	
}// fin envio por stmp

if ($correo_smtp==false){ ///correo mediante mail de php
	
	//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//dirección del remitente 
$headers .= "From: $nombre_ref <$email2>\r\n"; 


//ruta del mensaje desde origen a destino 
$headers .= "Return-path: $email2\r\n"; 

$asunto="$asunto_mens_error";

 	///miramos las direcciones de correo a la que hay que enviar el correo 
	

$sql = "SELECT nombre, apellidos,correo FROM $tbn11 WHERE id_votacion = '$idvot' and tipo<=1 ";
$result = mysqli_query($con, $sql);

if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
do {

$correo_inter.= $row[2]."," ;
 
}
while ($row = mysqli_fetch_array($result));
}	
//fin del bucle para enviar el correo	

mail($correo_inter,$asunto,$asunto_mens_ref,$headers) ;

	
}


?>