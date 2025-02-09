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
require_once("../inc_web/config.inc.php");

session_name($usuarios_sesion2);
session_start();
// session_name($usuarios_sesion);
// Destruir todas las variables de sesión.
$_SESSION = array();

// Si se desea destruir la sesión completamente, borre también la cookie de sesión.
// Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión.
session_destroy();

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
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="../temas/<?php echo "$tema_web"; ?>/estilo.css" rel="stylesheet">
    <link href="../temas/<?php echo "$tema_web"; ?>/estilo_login.css" rel="stylesheet">
  </head>
  <body>

 <div class="container">
 
    <!-- cabecera
    ================================================== -->
      <div class="page-header">
      <img src="../temas/<?php echo "$tema_web"; ?>/imagenes/cabecera_votaciones.jpg" class="img-responsive" alt="Logo <?php echo "$nombre_web"; ?>">
        
      </div>
      
    <!-- END cabecera
    ================================================== -->
      
    
  
      <div class="center-block">
        <h1>Sistema de control de interventores DEMOKRATIAN</h1>
        <p><br>
        </p>
        <div class="alert alert-info"><a data-toggle="modal" href="#myModal" class="alert-info">He olvidado mi  contraseña</a><a href="inicio.php"> prueba</a></div>
	  </div>
      
      
     <div class="container"> 

     <form action="inicio.php" method="post" class="form-signin" role="form" >
        <h3 class="form-signin-heading">Tienes que identificarte para acceder</h3>
         <?php 
		  include ("ms_error.php");
            if (isset($_GET['error_login'])){
                $error=$_GET['error_login'];
			?>	
			 <div class="alert alert-danger"> 
             <a class="close" data-dismiss="alert">x</a>
             
             Error: <?php echo $error_login_ms[$error]; ?> <br/>
             <a data-toggle="modal" href="#myModal" >Si no estas registrado puedes hacerlo</a> <br/>
             <a data-toggle="modal" href="#myModal" >No recuerdo mi contraseña</a>
             </div>

			 <?php     }
		?>
		<div class="control-group">
                  <div class="controls">
        <input type="text" id="user"   name="user" class="form-control" placeholder="Usuario" required autofocus/> </div></div>
          <div class="control-group">
                  <div class="controls"></div></div>
                  
	  <div class="control-group">
                  <div class="controls">
					<input type="password" id="pass"  name="pass" class="form-control" placeholder="Password" required />
					<input type="text" class="form-control" placeholder="nº votacion" name="votacion" id="votacion" required  data-validation-required-message="numero de votacion" />
		</div>
	    </div>
        
        <button class="btn btn-ttc btn-lg btn-primary btn-block" type="submit">Entrar</button>
         <p>&nbsp;</p>
      </form>
      
    

    </div> 
   <!--
   ================================= ventana modal
   -->    
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
			<input type="text" class="form-control" 
			   	   placeholder="Su nombre" id="name" required data-validation-required-message="Por favor, ponga su nombre" />
			  <p class="help-block"></p>
		   </div>
	         </div> 	
                <div class="control-group">
                  <div class="controls">
			<input type="email" class="form-control" placeholder="Su correo electronico" id="email" required  data-validation-required-message="Por favor, ponga su correo electronico" />
		</div>
	    </div> 	
        
        
        

               <div class="control-group">
                <span class="help-block">Seleccione la votación</span>
                          
                    
	  <div class="form-group">
            <input type="text" class="form-control"  placeholder="Nº de votacion" id="name" required data-validation-required-message="Por favor, ponga el numero" />
      </div>  </div> 		 
               
               
	     <div id="success"> </div> <!-- mensajes -->
	    <button type="submit" class="btn btn-primary pull-right">Enviar</button><br />
          </form>
                
                
                
                
</fieldset>
			</div>
            
			
             
             </div>
        </div>
</div>
<!--
===========================  fin ventana modal
-->


  <div id="footer" class="row">
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
   
   
   
   
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
     <script src="../js/jquery-1.9.0.min.js"></script>
     <!--<script src="js/jquery.validate.js"></script>-->
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
 	<script src="../js/jqBootstrapValidation.js"></script>
 	<script src="../js/recupera_contrasena.js"></script>

  </body>
</html>