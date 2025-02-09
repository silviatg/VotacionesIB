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
require ("inc_web/config.inc.php");

// Inicializar la sesión.
// Si está usando session_name("algo"), ¡no lo olvide ahora!
 session_name($usuarios_sesion);
session_start();
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
    <link href="temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="temas/<?php echo "$tema_web"; ?>/estilo.css" rel="stylesheet">
    <link href="temas/<?php echo "$tema_web"; ?>/estilo_login.css" rel="stylesheet">
  </head>
  <body>

 <div class="container">
 
    <!-- cabecera
    ================================================== -->
      <div class="page-header">
      <img src="temas/<?php echo "$tema_web"; ?>/imagenes/cabecera_votaciones.jpg" class="img-responsive" alt="Logo <?php echo "$nombre_web"; ?>">
        
      </div>
      
    <!-- END cabecera
    ================================================== -->
      
    
  
      <div class="center-block">
        <h1>Sistema de votaciones de <?php echo "$nombre_web"; ?></h1>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        
        <div class="container tamano_medio" > 
        <div class="alert alert-info"><p>
        Ha salido correctamente de la zona de Votacion <?php echo "$nombre_sitio"; ?> </p>
        
        <p><a href="index.php" >Puede VOLVER A CONECTARSE</a></p></div>
	  </div>
      

    </div>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
       <div id="footer" class="row">
  <?php  include("temas/$tema_web/pie_com.php"); ?>
   </div>
   
   
   
   
   
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
     <script src="js/jquery-1.9.0.min.js"></script>
     <!--<script src="js/jquery.validate.js"></script>-->
	<script src="modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>

  </body>
</html>