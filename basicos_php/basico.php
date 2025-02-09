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
require_once('../modulos/PHPMailer/class.phpmailer.php');
//require_once("../modulos/PHPMailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
set_time_limit(300); //STG

######################### Funciones de seguridad para evitar ataques por XSS #########################
function fn_filtro_editor($conexion,$cadena) {
	if(get_magic_quotes_gpc() != 0) {
		$cadena = stripslashes($cadena);
	}
	$cadena=strip_tags($cadena, '<h1><h2><h3><h4><h5><h6><p><hr><pre><blockquote><ol><ul><li><dl><dt>< dd><div><center><a><basefont><br><em><font><span><strong><table><caption><colgroup><col><tbody><thead><tfoot><tr><td><th><img>');
	return mysqli_real_escape_string($conexion, $cadena);
}


function fn_filtro($conexion,$cadena) {
	if(get_magic_quotes_gpc() != 0) {
		$cadena = stripslashes($cadena);
	}
	$cadena=strip_tags($cadena);
	return mysqli_real_escape_string($conexion,$cadena);
}

function fn_filtro_numerico($conexion,$cadena) {
	if(get_magic_quotes_gpc() != 0) {
		$cadena = stripslashes($cadena);
	}
	
	if(is_numeric($cadena)){
		$cadena=$cadena;
		}else{
		$cadena="";
		 Header ("Location: ../index.php?error_login=4");
		exit;	
		}
	$cadena=strip_tags($cadena);
	return mysqli_real_escape_string($conexion,$cadena);
}


function fn_filtro_nodb($cadena) {
	if(get_magic_quotes_gpc() != 0) {
		$cadena = stripslashes($cadena);
	}
	
	return strip_tags($cadena);
}

function fn_filtro_nodb_numerico($cadena) {
	if(get_magic_quotes_gpc() != 0) {
		$cadena = stripslashes($cadena);
	}
	if(is_numeric($cadena)){
		$cadena=$cadena;
		}else{
		$cadena="";
		 Header ("Location: ../index.php?error_login=4");
		exit;	
		}
	return strip_tags($cadena);
}


###################### FIN de Funciones de seguridad para evitar ataques por XSS #########################



####################################  Funciones de control de errores de inserccion a la BBDD  ##########################################
//$b_debugmode = 1; // 0 || 1


function db_query($conexion, $query,$mensaje_esp){
  global $b_debugmode;
  
  // Perform Query
  $result = mysqli_query($conexion,$query);

  // Check result
  // This shows the actual query sent to MySQL, and the error. Useful for debugging.
  if (!$result) {
	  
	  $message  = '<b>Invalid query:</b><br>' . mysqli_error() . '<br><br>';
      $message .= '<b>Whole query:</b><br>' . $query . '<br><br>';  
	  $message .= 	"\r\n ".$mensaje_esp;
	  
    if($b_debugmode){

      die($message);
    }
			
    raise_error('db_query_error: ' . $message);
	
  }
  
  return $result;
}


############################### FUNCION DE ENVIO DE MESAJE SI HAY ERROR Y AÑADIR A LOGS #######################3
 
  function raise_error( $message ){
    global $email_error_tecnico, $email_sistema,$correo_smtp,$user_mail,$pass_mail;

    $serror=
    "Env:       " . $_SERVER['SERVER_NAME'] . "\r\n" .
    "timestamp: " . Date('m/d/Y H:i:s') . "\r\n" .
    "script:    " . $_SERVER['PHP_SELF'] . "\r\n" .
    "error:     " . $message ."\r\n\r\n";

    // ABRIR EL FICHERO DE LOGS Y ESCRIBIR EL ERROR
    $fhandle = fopen( '../logs/errors'.date('Ymd').'.txt', 'a' );
    if($fhandle){
      fwrite( $fhandle, $serror );
      fclose(( $fhandle ));
     }
  
    // ENVIAR UN CORREO ELECTRONICO
    if(!$b_debugmode){
      //mail($email_error_tecnico, 'error: '.$message, $serror, 'From: ' . $email_sistema );
	  $asunto_mens_error="ERROR SISTEMA VOTACIONES | problema base de datos";
	  $nombre_ref="Sistema";
	  $nombre_eq="tecnico";
	  
	  if ($correo_smtp==true){  //comienzo envio smtp

		$mail = new PHPMailer();
        $mail->ContentType = 'text/plain'; 
        $mail->IsHTML(false);

			if($mail_sendmail==true){
			$mail->IsSendMail();	
			}else{
			$mail->IsSMTP(); 
			}

				//$mail->IsSMTP(); 
				$mail->Host = $host_smtp;
				$mail->SetFrom($email_sistema, $nombre_ref);
				$mail->Subject = $asunto_mens_error;
				
				$mail->MsgHTML($serror);
				
				$mail->AddAddress($email_error_tecnico,$nombre_eq);
				
				$mail->SMTPAuth = true;
				
				$mail->Username = $user_mail;
				$mail->Password = $pass_mail; 

		if(!$mail->Send()) {
		  echo " Error en el envio " . $mail->ErrorInfo;
		} else {
		// echo "Enviado correctamente!";
		}

		}// fin envio por stmp

	if ($correo_smtp==false){ ///correo mediante mail de php
	
	//para el envío en formato HTML 
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
				
				//dirección del remitente 
				$headers .= "From: $nombre_ref <$email_sistema>\r\n"; 
				//ruta del mensaje desde origen a destino 
				$headers .= "Return-path: $email2\r\n"; 
				
				$asunto="$asunto_mens_error";
				mail($email_error_tecnico,$asunto,$serror,$headers) ;
					
				}
		}	  		
	  }
##############################  FIN  de  Funciones de control de errores de inserccion a la BBDD  ##########################################



// Comprueba si es un DNI correcto (entre 5 y 8 letras seguidas de la letra que corresponda).
// Acepta NIEs (Extranjeros con X, Y o Z al principio)
function fn_validar_DNI($dni){

	if(strlen($dni)<9) {
		return "DNI demasiado corto";
	}

	$letra = substr($dni, -1, 1);
	$numero = substr($dni, 0, 8);
 
	// Si es un NIE hay que cambiar la primera letra por 0, 1 ó 2 dependiendo de si es X, Y o Z.
	$numero = str_replace(array('X', 'Y', 'Z'), array(0, 1, 2), $numero);	
 
	$modulo = $numero % 23;
	$letras_validas = "TRWAGMYFPDXBNJZSQVHLCKE";
	$letra_correcta = substr($letras_validas, $modulo, 1);
 
	if($letra_correcta!=$letra) {
		return "El NIF/NIE no es válido";
	}
	else {
		return "OK";
	}
}

// Comprueba si es un teléfono móvil (número de 9 cifras, que empiece por 6 ó 7)
function fn_validar_tfno($tfno){
	if(strlen($tfno)!=9) {
		return "El número de teléfono debe tener 9 cifras numéricas.";
	}	
	$expresion = '/^[6|7][0-9]{8}$/'; 
	
	if(preg_match($expresion, $tfno)){ 
		return "OK"; 
	}
	else{ 
		return "Debe indicar un teléfono MÓVIL válido. Indique las 9 cifras seguidas, sin espacios ni guiones"; 
	}
}
?>