<?php
###############################################################################################################################################################
###############################################################################################################################################################
###                                                                                                                                                         ###
###                                                         DEMOKRATIAN versi�n 2.01                                                                        ###
###                                                         http://demokratian.org                                                                          ###
###                                    Copyright (C) 2014 CARLOS SALGADO WERNER (http://carlos-salgado.es)                                                  ###
###                                         Este programa ha sido creado por Carlos Salgado Werner                                                          ###
###                                                                                                                                                         ###
### Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los t�rminos de la Licencia P�blica General de GNU seg�n es publicada por la ###
### Free Software Foundation, bien de la versi�n 2 de dicha Licencia o bien de cualquier versi�n posterior.                                                 ###
### Este programa se distribuye con la esperanza de que sea �til, pero SIN NINGUNA GARANT�A, incluso sin la garant�a MERCANTIL impl�cita o sin garantizar   ###
### la CONVENIENCIA PARA UN PROP�SITO PARTICULAR. V�ase la Licencia P�blica General de GNU para m�s detalles.                                               ###
### Deber�a haber recibido una copia de la Licencia P�blica General junto con este programa. Si no ha sido as�, puede encontrarla en                        ###
### http://www.gnu.org/licenses/gpl-3.0.html                                                                                                                ###
### Si quieres participar en la mejora de este software ,eres libre de hacerlo,                                                                             ###
### Tambi�n puedes contactar con migo en el correo info@demokratian.org para trabajar en el desarrollo de forma colaborativa                                ###
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
	
	//para el env�o en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//direcci�n del remitente 
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