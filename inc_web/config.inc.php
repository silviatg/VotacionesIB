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

###############################################################################################################################################################
###############################################################################################################################################################
##########                                                                                                                                           ##########
##########                                                 CONFIGURACIÓN del la PLATAFORMA DE VOTACIONES                                             ##########  
##########                                                   Software creado por Carlos Salgado                                                      ##########  
##########                                                                                                                                           ##########
###############################################################################################################################################################
###################################################################################################################################

# SMSMailer conf
//require_once("./basicos_php/AltiriaSMSMailer.php");
$sms_user="imaginabur";
$sms_passwd="imaginabur201503ntp";
$sms_domain="imaginabur";
$sms_sender="ImaginaBur";
//if (! isset($sms_mailer))
	//$sms_mailer = new AltiriaSMSMailer($sms_user, $sms_passwd, $sms_domain);

$sitio_web_PRUEBAS="N"; //Si es el sitio web de pruebas, en la página de Inicio.php sólo dejará a ciertos usuarios ver las votaciones.

$hostu = "dbo568789363";                              // Usario de la BBDD
$hostp = "BD.imagina.25";         // Contraseña de la BBDD
$dbn = "db568789363";          // Nombre de la BBDD
$host="db568789363.db.1and1.com";  // Host de la BBDD       

           		  					 
					 
$extension=""; // prefijo de las tablas de la base de datos. Antes: "pruebas_" => lo quito

$nombre_web="ImaginaBurgos | Centro de votaciones";    // Nombre del sitio web
$tema_web="ImaginaBurgos";                       // Nombre del tema (carpeta donde se encuentra)

$mensaje_login="S"; //Nuevo campo, si tiene "S" mostraremos el texto de aviso de la pantalla de login.
$mostrar_todas_opciones="N"; //Nuevo campo. Dejar a "N", para ocultar aquellas opciones de los menús que no ha habido tiempo de probar y no aplican para esta campaña. En el futuro, revisarlas y abrirlas.
$bloquear_registro="S"; //Nuevo campo, si tiene "S" no mostraremos los enlaces para registrar nuevos usuarios.
$bloquear_login="N"; //Nuevo campo, si tiene "S" no permitiremos hacer login a nadie.
$Cancelar_Envio_SMS="S"; //En PROD siempre a "N", para que envíe los sms. En local ponemos SI para no gastar saldo de sms.
$voto_primarias_Imagina="S"; //En las votaciones de primarias de Imagina pusimos "S", para da valor 20-16 en lugar de 1/N a cada voto.
							 //Lo cambiamos para votar las propuestas, ponemos "N" y ponemos los valores normales: 1/N.
//$campotexto_adicional_voto="Otras propuestas que consideres importantes y eches en falta en el programa (opcional):"; //Si añadimos un campo de texto adicional en las votaciones
$campotexto_adicional_voto=""; //En PRO no conseguimos que funcione, así que al final no añadimos el campo.
$permitir_votar_admin="3"; //Variable que permite votar a un usuario admin por un usuario censado. En esta variable indicamos el número de la votación en la que permitimos votar.
$texto_votar_admin="Votar Presencial"; //Texto que aparecerá en la pantalla de voto presencial,para que el admin vote por un censado.


$textoLOPD="<p style=\"font-size:14px\"><br><i><b>LOPD:</b> Los datos recabados serán utilizados únicamente por Imagina Burgos para el normal 
funcionamiento de su página web, y en ningún caso serán cedidos a terceros.
Con la presente inscripción da su conformidad para que los datos personales contenidos en ella,
sean incluidos en el fichero de datos de carácter personal \"votaciones imagina Burgos\", 
conforme lo previsto en la Ley Orgánica 15/1999, de 13 de diciembre, de Protección de datos 
de carácter personal, pudiendo ejercer los derechos de acceso, rectificación, cancelación y 
oposición, dirigiéndose para ello al correo electrónico lopd@imaginaburgos.es</i></p>";


###################################################################################################################################
##########                          Direcciones de correo para los distintos tipos de envios                             ##########  
###################################################################################################################################
$email_env="votaciones@imaginaburgos.es"; //direccion de correo general
$email_error="votaciones@imaginaburgos.es"; //sitio al que enviamos los correos de los que tienen problemas y no estan en la bbdd, 
                                     //este correo es el usado si no hay datos en la bbdd de los contactos por provincias
$email_control="votaciones@imaginaburgos.es"; //Direccion que envia el correo para el control con interventores

$email_error_tecnico="votaciones@imaginaburgos.es";//correo electronico del responsable tecnico
$email_sistema="votaciones@imaginaburgos.es"; //correo electronico del sistema, de momento incluido en el envio de errores de la bbdd

$asunto_mens_error="Usuario votaciones con problemas contraseña"; //asunto del mensaje de correo cuando hay problemas de acceso
$nombre_eq="Sistema de  votaciones ImaginaBurgos"; //asunto del correo
$url_vot="http://www.votaciones.imaginaburgos.es";

$nombre_sistema="Sistema de  votaciones ImaginaBurgos"; // Nombre del sistema cuando se envia el correo de recupercion de clave
$asunto="Recuperar tu contraseña en ImaginaBurgos";// asunto para recuperar la contraseña



###################################################################################################################################
#############         Configuracion del correo smtp , solo si es tenemos como true la variable $correo_smtp           #############
###################################################################################################################################
$correo_smtp=true;                   //poner en false si queremos que el envio se realice con phpmail() y true si es por smtp

$user_mail="info";        // Usuario de correo
$pass_mail="imagina.25.mailvotos";  // Password de correo
$host_smtp ="smtp.1and1.es";        // Host del correo 
$puerto_mail=587; //Puerto de 1and1 con SSL habilitado: 995
$mail_sendmail=true; // en algunos sevidores como 1and1 hay que usar IsSendMail() en vez de IsSMTP() por defecto dejar en false



###################################################################################################################################
#############                CONFIGURACIÓN para la conexion con el CIVICRM para gestion de  usuarios                  #############
#############                                      No funciona aun, en construccion                                   #############
###################################################################################################################################

//$civi=true;  ////poner false si no queremos que conecte  con civicrm


###################################################################################################################################
#############                       Todo este grupo de variables no tienen porque ser modificadas.                    #############
#############                                 hacerlo solo si se tiene conocimientos                                  #############
###################################################################################################################################

$b_debugmode = 0; // 0 || 1  Forma de errores cuando hay problemas con la base de datos

###################################################################################################################################
############################################## Nombres de las tablas en la BBDD####################################################

$tbn1=$extension."votacion"; // nombre votacion y caracteristicas
$tbn2=$extension."usuario_x_votacion";  /////tabla que dice quien ha votado en una votacion especifica
$tbn3=$extension."ccaa";
$tbn4=$extension."grupo_trabajo";
$tbn5=$extension."usuario_admin_x_provincia";
$tbn6=$extension."usuario_x_g_trabajo";
$tbn7=$extension."candidatos ";
$tbn8=$extension."provincia";
$tbn9=$extension."votantes";
$tbn10=$extension."votos";  //
$tbn11=$extension."interventores";
$tbn12=$extension."debate_comentario";
$tbn13=$extension."debate_preguntas";
$tbn14=$extension."debate_votos";
$tbn15=$extension."elvoto";  //para el VUT  -- sutituye a $tbn10
$tbn16=$extension."paginas";
$tbn17=$extension."votantes_x_admin";
$tbn18=$extension."municipios";

##################################################################################################################################
###############                                        configuración de carpetas                                   ###############
###############                    Ojo, darle permisos de escritura en el servidor si corre en Linux               ###############
##################################################################################################################################

$FilePath="../data_vut/";                  //   carpeta donde se generan los archivos del vut
$path_bakup_bbdd="backup";                 // Carpeta donde se guardan los back-up de la bbdd

##################################################################################################################################
#####################                 Otras viariables del sistema, no son necesario cambiarlas              #####################
##################################################################################################################################


$usuarios_sesion="aut_usu_ad"; // nombre de la sesion 
$usuarios_sesion2="ses_inter_admi"; // nombre de la sesion de los interventores
$clave_encriptacion="aoleequo33892";// 
$clave_encriptacion2="aoleequo33892";



##################################################################################################################################
###############     variables del sistema de subida y/o redimension de imagenes de los candidatos y usuarios       ###############
###############                    Ojo, darle permisos de escritura en el servidor si corre en Linux               ###############
##################################################################################################################################

$upload_cat = "../upload_pic"; //carpeta donde se guardan las imagenes de los candidatos
$upload_user = "../upload_user"; //carpeta donde se guardan las imagenes de los usuarios
$baseUrl = $url_vot.'/userfile/';//   carpeta donde se guardan las imagenes y archivos de gestor ckfinder



##################################################################################################################################
##################################################################################################################################
##################                                                                                              ##################
##################                   FIN DE CONFIGURACIÓN Y VARIABLES, NO MODIFCIAR A PARTIR DE AQUI            ##################
##################                                                                                              ##################
##################################################################################################################################
##################################################################################################################################

$con= @mysqli_connect("$host","$hostu","$hostp") or die ("no se puede conectar"); 
$db = @mysqli_select_db($con, "$dbn") or die ("no se puede acceder a la tabla"); 


?>
