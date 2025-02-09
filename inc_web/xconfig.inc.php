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



/*  para servidor local 
$hostu = "root";                              // Usario de la BBDD
$hostp = "";                                  // Contraseña de la BBDD
$dbn = "votaciones_demokratian_2.1";          // Nombre de la BBDD
$host="localhost";                            // Host de la BBDD
  */                  
   
	/*		*/			 
$hostu = "c1votaciones"; //  usuario base datos
$hostp = "EQUO_vt13";//  clave 
$dbn = "c1votaciones"; // nombre de la base de datos
$host="localhost";
		  					 
					 
$extension="votaciones_";                        // prefijo de las tablas de la base de datos

$nombre_web="Espacio de votaciones EQUO";    // Nombre del sitio web
$tema_web="equo";                       // Nombre del tema (carpeta donde se encuentra)

###################################################################################################################################
##########                          Direcciones de correo para los distintos tipos de envios                             ##########  
###################################################################################################################################
$email_env="votacionesasamblea@partidoequo.es"; //direccion de correo general
$email_error="votacionesasamblea@partidoequo.es"; //sitio al que enviamos los correos de los que tienen problemas y no estan en la bbdd, 
                                     //este correo es el usado si no hay datos en la bbdd de los contactos por provincias
$email_control="votacionesasamblea@partidoequo.es"; //Direccion que envia el correo para el control con interventores

$email_error_tecnico="csalgadow@gmail.com";//correo electronico del responsable tecnico
$email_sistema="votacionesasamblea@partidoequo.es"; //correo electronico del sistema, demomento incluido en el envio de errores de la bbdd

$asunto_mens_error="Usuario votaciones con problemas contraseña"; //asunto del mensaje de correo cuando hay problemas de acceso
$nombre_eq="Votaciones EQUO"; //asunto del correo
$url_vot="https://votaciones.partidoequo.es";

$nombre_sistema="Sistema de  votaciones"; // Nombre del sistema cuando se envia el correo de recupercion de clave
$asunto="Recuperar tu contraseña en Votaciones EQUO";// asunto para recuperar la contraseña



###################################################################################################################################
#############         Configuracion del correo smtp , solo si es tenemos como true la variable $correo_smtp           #############
###################################################################################################################################
$correo_smtp=true;                   //poner en false si queremos que el envio se realice con phpmail() y true si es por smtp

$user_mail="news_partidoe42";        // Usuario de correo
$pass_mail="123alesconditeruso456";  // Password de correo
$host_smtp ="partidoequo.es";        // Host del correo  smtp.1and1.es
$puerto_mail=25;
$mail_sendmail=false; // en algunos sevidores como 1¬1 hay que usar IsSendMail() en vez de IsSMTP() por defecto dejar en false



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
