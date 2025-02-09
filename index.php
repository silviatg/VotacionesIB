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

// Inicializar la sesión.
// Si está usando session_name("algo"), ¡no lo olvide ahora!
require_once("inc_web/config.inc.php");
require_once('basicos_php/crypt.php'); //STG: Lo añado, para usar la funcion "desencriptar", para la url. 

session_start();
session_name($usuarios_sesion);
// session_name($usuarios_sesion);
// Destruir todas las variables de sesión.
$_SESSION = array();

// Si se desea destruir la sesión completamente, borre también la cookie de sesión.
// Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name($usuarios_sesion), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión.
session_destroy();

?>
<?php
require ("inc_web/config.inc.php");
?>
<!DOCTYPE html>
<html lang="es"><head>
    <meta charset="utf-8">
    <title><?php echo "$nombre_web"; ?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=" ">
    <meta name="author" content=" ">
   <link rel="icon"  type="image/png"  href="temas/<?php echo "$tema_web"; ?>/imagenes/icono.png"> 
        

    
    
    <!—[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]—>
    <link href="temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!--    <link href="temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">-->
    <link href="temas/<?php echo "$tema_web"; ?>/estilo.css" rel="stylesheet">
    <!--<link href="temas/<?php echo "$tema_web"; ?>/estilo_login.css" rel="stylesheet">-->
  </head>
  
  <body>

 <div class="container">
 
    <!-- cabecera
    ================================================== -->
      <div class="page-header">
      <p>&nbsp;</p>
      <img src="temas/<?php echo "$tema_web"; ?>/imagenes/cabecera_votaciones.jpg" class="img-responsive" alt="Logo <?php echo "$nombre_web"; ?>">
        
      </div>
      
    <!-- END cabecera
    ================================================== -->
	
<?php if ($mensaje_login=="S"){ ?>
	<div class="alert alert-success">
		<!--<b>El periodo de votación</b> sobre la integración del PCAS en Imagina Burgos, finalizará el <b>Domingo 10 de febrero</b> a las <b>22h</b>.-->
		<img src="temas/<?php echo "$tema_web"; ?>/imagenes/votaciones_Primarias.png" class="img-responsive">
	</div>				
<?php } ?>	
	
<div class="row">    
	<div class="col-lg-6">
		<div class="jumbotron">
		  <h2>Bienvenid@ al sistema de votaciones <?php echo "$nombre_web"; ?></h2>

		<?php if ($bloquear_registro!="S"){ ?>
			<p>Si es la primera vez que accedes deberás generar tu clave y usuario usando tu dirección de correo electrónico.</p>
			<p>			
			<a data-toggle="modal" href="#myModal" class="btn btn-primary btn-lg">Registrarme</a> </p>
		 <?php } ?>
		 </div>
	</div>
    
    <div class="col-lg-6">   
		<?php if ($bloquear_login!="S"){ ?>
				
		<div class="well">
			<form action="votacion/inicio.php?regedi=<?php echo $_GET[regedi]; ?>" method="post"  class="form-horizontal" role="form" >
				<h3 class="form-signin-heading">Tienes que identificarte para acceder</h3>
				<?php 
					include ("inc_web/ms_error.php");
					if (isset($_GET['error_login'])){
						$error=$_GET['error_login'];					
						
				?>	
				 <div class="alert alert-danger"> 
				 <a class="close" data-dismiss="alert">x</a>
				 <?php 
						if ($error != "8") {echo "Error: ";} //El aviso de "debe introducir la clave, no lo consideramos Error"
						echo $error_login_ms[$error]; 			
					
						if ($error = "2" || $error = "3"){
							echo "<center><span font-size='8px'><em>*Revisa si las mayúsculas/minúsculas son las correctas</em></span></center>";
						}			
				?>
				 
				  <?php if ($bloquear_registro!="S" && $error != "8" && $error != "9" ){ //Errores 8 y 9 los tratamos más abajo. ?>
							 <br/>
							 <a data-toggle="modal" href="#myModal" >Si no estás registrado puedes hacerlo</a> <br/>
							 <a data-toggle="modal" href="#myModal" >He olvidado mi contraseña</a>
					<?php } ?>
				 </div>

			<?php  }   ?>
				<div class="form-group">
					<label for="user" class="col-sm-4 control-label">Usuario</label>
						<div class="col-sm-6">
							<input type="text" id="user"   name="user" class="form-control" placeholder="Usuario" required autofocus/>
						</div>
				</div>				
				<div class="form-group">
					<label for="pass" class="col-sm-4 control-label">Contraseña</label>
					<div class="col-sm-6">
					  <input type="password" id="pass"  name="pass" class="form-control" placeholder="Password" required />
					</div>
				</div>
				
				<?php 
				//echo "REGISTRO:" ;
				//echo $_GET['regedi'];
					if ((isset($_GET['regedi']) || $error=="8" || $error=="9" )){
						$clave_encriptada=$_GET['regedi'];						
						$cadena_desencriptada = desencriptar ($clave_encriptada,$clave_encriptacion2);
						if ($cadena_desencriptada=="solicitar_clave_sms" || $error=="8" || $error=="9"){
							/* STG+-; 10-02-2019 Ya no se envía clave al móvil, así que no mostramos este input.
				 ?>	
					<div class="form-group">
						<label for="clave_sms" class="col-sm-4 control-label">Clave enviada al móvil:</label>
						<div class="col-sm-6">
						  <input type="number" class="form-control" placeholder="Clave enviada a su móvil" id="clave_sms" name="clave_sms" minlength=5 data-validation-minlength-message="Indique todas las cifras seguidas (sin espacios) de la clave enviada a su móvil" data-validation-number-message="Indique todas las cifras seguidas (sin espacios) de la clave enviada a su móvil" data-validation-required-message="Por favor, indique la clave enviada a su teléfono móvil"/>
						</div>					
					</div>					
				<?php		
				*/
						}
					}			
				?>			
				
				<div class="form-group">
				  <div class="col-sm-offset-4 col-sm-6">					
					<button class="btn btn-ttc btn-lg btn-primary btn-block" type="submit">Entrar</button>					
				  </div>
				</div>
				
				<center><a data-toggle="modal" href="#myModal">He olvidado mi contraseña <br/>Quiero generar mi nuevo usuario/contraseña</a>
				<br/><i>(sólo para inscrit@s antes del 27 de febrero de 2019)</i></center>
				
				<br/><em>* Consulta la ayuda si tienes cualquier duda ;-)</em></a>
				
				<?php if ($bloquear_registro!="S" && ($error=="8" || $error=="9" )){ ?>
					<div class="alert alert-danger"> 
						<a class="close" data-dismiss="alert">x</a>		
						- Si no ha recibido la clave en su móvil <a data-toggle="modal" href="#myModal" >vuelva a intentar registrarse.</a><br/><br/>
						- Si ya ha intentado registrarse de nuevo y sigue teniendo problemas para entrar, contacte con nosotros <a data-toggle="modal" href="#contacta"  data-dismiss=\"modal\" >rellenando nuestro formulario.</a> <br/>					
					</div>
				<?php } ?>
			</form> 	
		</div>
		<?php } ?>		
<!--
		<div class="well">
			  <a data-toggle="modal" href="#myModal">He olvidado mi contraseña</a>
		</div>
		 <div class="well">
			<a href="https://youtu.be/SSL5xljlbx4" target="_blank">Pulse aquí para visualizar el vídeo-tutorial de ayuda</a>			
		</div>
 -->
    </div>
</div>
<?php if ($mensaje_login=="S"){ ?>
	<div class="alert alert-success">
		<b>* Podrán participar en la votación de primarias:</b> todas las personas que hayan <b> solicitado su inscripción en el censo hasta el 27 de febrero de 2019 (incluidas todas aquellas que hayan estado inscritas desde las primarias de 2015).</b><br/>
		Si aún no has enviado tu DNI para verificarte, aún puedes hacerlo. Abajo tienes las formas de contacto.</br>		
		</br>
		<b>* AYUDA:</b><br/>
		<b>Si es la primera vez que entras a la plataforma</b>, tendrás que hacer algún paso más para poder validarte y garantizar que cada voto es secreto y único. Las próximas veces sólo tienes que introducir tu usuario y contraseña. ;-) <br/><br/>
		<b>1. Para votar por primera vez primero debes inscribirte en el Censo</b> <a href="https://imaginaburgos.es/censo/" target="_blank">desde este enlace</a>. Te responderemos por mail en cuanto esté tu DNI verificado. Después vuelve a esta plataforma para establecer tu usuario y contraseña.
		<br/>
		<b>2. Si es la primera vez que entras en la plataforma</b>, o si olvidaste tu usuario/contraseña: Pulsa en "He olvidado mi contraseña" y rellena el formulario. Recibirás un email con un enlace que debes pulsar. Es necesario rellenar de nuevo el formulario, porque ahora te permitirá re-establecer el nuevo usuario y contraseña que desees. Después, pulsa en “Acceder al sistema de votaciones” y comprueba que ya puedes entrar a la plataforma.<br/>	
		<br/>	
		
		<b>* SI TIENES DUDAS, CONTACTA:</b> Enviando un whatsapp al teléfono 694 474 800 o escribiendo a <a href="mailto:votaciones@imaginaburgos.es">votaciones@imaginaburgos.es</a><br/>
		Te responderemos lo antes posible.<br/>		
	</div>				
<?php } ?>	



 <!--    
 =============================================================================
 ================================= ventana modal 1ª ==========================
=============================================================================  -->    
 <div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" >x</a>
                <!--    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                <h4 class="modal-title">Complete para registrarse o recuperar su contraseña</h4>
            </div>
                        
            <div class="modal-body">
				<fieldset>				
                <form name="sentMessage" class="well" id="contactForm" >      
               <!-- <form name="sentMessage" class="well" id="contactForm"  novalidate>-->
	       <!--<legend>Contact me</legend>-->
		 <div class="control-group">
                    <div class="controls">
					<label for="name" class="col-sm-4 control-label">Nombre y Apellidos:</label>
			<input type="text" class="form-control" 
			   	   placeholder="Su nombre" id="name" required data-validation-required-message="Por favor, indique su nombre y apellidos" />
			  <p class="help-block"></p>
		   </div>
	         </div> 	
                
		
		<div class="control-group">
                  <div class="controls">
				  <label for="email" class="col-sm-4 control-label">Email:</label>
			<input type="email" class="form-control" placeholder="Su correo electrónico" id="email"  required  data-validation-required-message="Por favor, indique su correo electrónico" />
		</div>
	    </div> 	
		
		
		<!-- ============  STG: Añadimos móvil y NIF  ============ -->
		<div class="control-group">
            <div class="controls">
				<label for="nif" class="col-sm-4 control-label">NIF:</label>
				<input type="text" class="form-control" placeholder="Su NIF/NIE" id="nif" minlength=9 maxlength=9 required data-validation-minlength-message="Indique las 9 cifras y letras de su NIF/NIE seguidas (sin guiones ni espacios)"  data-validation-required-message="Por favor, indique su NIF/NIE" />
			</div>
	    </div>
		 <div class="control-group">
            <div class="controls">
				<label for="tfno" class="col-sm-4 control-label">Móvil:</label>
				<input type="number" class="form-control" placeholder="Su teléfono móvil" id="tfno" maxlength=9 minlength=9 required data-validation-minlength-message="Indique las 9 cifras seguidas (sin espacios) de su teléfono móvil" data-validation-number-message="Indique las 9 cifras seguidas (sin espacios) de su teléfono móvil" data-validation-required-message="Por favor, indique su teléfono móvil"/>				
			</div>
			<div class="alert alert-danger">                          
					Asegúrese de <b>introducir sus datos corréctamente</b>, o no podrá realizar su votación por internet (sí presencialmente).<br>
			</div>
	    </div> 
		<!-- ============================== -->		
        
               <div class="control-group">
                <span class="help-block">Seleccione la provincia donde está censado:</span>
                <?php 			  

					// listar para meter en una lista del tipo enlace
					$activo=0;

					$options = "select DISTINCT ID,provincia from $tbn8 where especial ='$especial' order by id  ";
					$resulta = mysqli_query( $con, $options) or die("error: ".mysqli_error());
					while( $listrows = mysqli_fetch_array($resulta) ){ 
						$name= utf8_encode($listrows[provincia]);
						$id_pro=$listrows[ID];
						$lista .="<option value=\"$id_pro\"> $name</option>";
					}
				  ?>
                    
				<div class="form-group">
                    <select class="form-control"  name="provincia" id="provincia" >
                     <!-- <option value=""> Escoje una provincia</option>-->
         				 <?php echo "$lista";?>
                    </select>
				</div>
      
			</div> 		 
			
			<div>
				<span class="help-block"><?php echo "$textoLOPD";?></span>
			</div>
                              
			<div id="success"> </div> <!-- mensajes -->			 
			<button type="submit" class="btn btn-primary pull-right">Enviar</button><br />
			</form>             
  
			</fieldset>
			</div> 	
             
        </div>
    </div>
</div>
<!-- ===========================  fin ventana modal 1ª ======================================== -->


<!--

-->
<?php 
/**************************************************************************************************************
								segunda ventana modal: Contacta 
	=> STG: ESTABA VISIBLE si no encuentra el mail en la BD. Ahora no es obligatorio que exista el mail previamente.
	Pero la mostramos por si el usuario desea contactar porque hay algún problema en el registro (no introdujo bien el mail, o el tfno, etc.)
*********************************************************************************************************************/
require("./basicos_php/contacta.php");
/******************* fin segunda ventana modal *************************/
?> 

  <div id="footer" class="row">
  <?php  include("temas/$tema_web/pie_com.php"); ?>
   </div>
   
   
   
   
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
     <script src="js/jquery-1.9.0.min.js"></script>
     <!--<script src="js/jquery.validate.js"></script>-->
	<script src="modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
 	<script src="js/jqBootstrapValidation.js"></script>
 	<script src="js/recupera_contrasena.js"></script>
    <script src="js/contact_me.js"></script>

  </body>
</html>