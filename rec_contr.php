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
        <h1>Pagina de validación de usuario del sistema de votaciones <?php echo "$nombre_web"; ?></h1>
	</div>
      
      
    <div class="container"> 
	
		<fieldset>
				
        <form method="post" name="sentMessage"  class="form-signin" id="contactForm"  role="form" >                
               <!-- <form name="sentMessage" class="well" id="contactForm"  novalidate>-->
	       <!--<legend>Contact me</legend>--> 
		   
		<!-- STG: Quito este div, porque cuando daba error, se ocultaba todo este div, y no podía revisar los datos introducidos.
		<div id="caja_contrasena"> -->
           <?php 
		   if ($_GET['regedi']!=""){

				function decrypt ($string, $key) { 
					$result = ''; 
					$string = str_replace(array('-', '_'), array('+', '/'), $string);
					$string = base64_decode ($string); 
						for ($i=0; $i<strlen ($string); $i++) { 
							$char = substr ($string, $i, 1); 
							$keychar = substr ($key, ($i % strlen ($key))-1, 1); 
							$char = chr (ord ($char)-ord ($keychar)); 
							$result.=$char; 
						} 
					return $result; 
				}
				
				$clave_encriptada=$_GET['regedi'];
				
				//$clave_encriptada = str_replace(array('-', '_'), array('+', '/'), $clave_encriptada);
				$cadena_desencriptada = decrypt ($clave_encriptada,$clave_encriptacion2); 
				
				$array_cadena = explode('-', $cadena_desencriptada);
				$clavecilla="$array_cadena[0]";
				$id_usuario="$array_cadena[1]";
		   }
		  

		   ?>
		   <?php if ($clavecilla=="nwt"){?>
                <input name="idrec" type="hidden" id="idrec" value="<?php echo $_GET['regedi']; ?>">
                <?php $usuario_consulta = mysqli_query($con,"SELECT ID,usuario,sms_validation_code FROM $tbn9 WHERE ID='$id_usuario' ") or die("No se pudo realizar la consulta a la Base de datos");

				while( $listrows = mysqli_fetch_array($usuario_consulta) ){
					$ID=$listrows[ID];
					$usuario=$listrows[usuario];
					$sms_validation_code=$listrows[sms_validation_code];					
				}
			}
			if ($_GET['idpr']!=""){?>
                <input name="npdr" type="hidden" id="npdr" value="<?php echo $_GET['idpr']; ?>">
                <?php }?>
            
			<div class="alert alert-danger">                          
					Asegúrese de <b>introducir sus datos corréctamente</b>, o no podrá realizar su votación por internet.<br>					
			</div>
			
            <div class="control-group">
                <div class="controls">
						<label for="email" class="col-sm-4 control-label">Email</label>
						<input type="email" class="form-control" placeholder="Su correo electrónico" id="email" required  data-validation-required-message="Indique su correo electrónico" />
				</div>
			</div> 	
		
			<!-- ============  STG: Añadimos móvil y NIF  ============ -->
			<div class="control-group">
				<div class="controls">
					<label for="nif" class="col-sm-4 control-label">NIF:</label>
					<input type="text" class="form-control" placeholder="Su NIF/NIE" id="nif" maxlength=9 minlength=9 required data-validation-minlength-message="Indique las 9 cifras y letras de su NIF/NIE seguidas (sin guiones ni espacios)"  data-validation-required-message="Por favor, indique su NIF/NIE" />
				</div>
			</div> 
			 <div class="control-group">
				<div class="controls">
					<label for="tfno" class="col-sm-4 control-label">Móvil:</label>
					<input type="number" class="form-control" placeholder="Su teléfono móvil" id="tfno" maxlength=9 minlength=9 required data-validation-minlength-message="Indique las 9 cifras seguidas (sin espacios) de su teléfono móvil" data-validation-number-message="Indique las 9 cifras seguidas (sin espacios) de su teléfono móvil" data-validation-required-message="Por favor, indique su teléfono móvil"/>				
				</div>
			</div>
			<!-- ============================== -->
		
			<?php if ($usuario!=""){?>
           <div class="control-group">
            <div class="controls">
                <label for="usuario">Su nombre de usuario es:</label>
				<input type="text" required class="form-control" id="name" value="<?php echo "$usuario"; ?>" /> <!-- No estaba requerido, lo añado-->			 
			</div>
	       </div> 
			<?php 
			} 
			else {?> 
			<div class="control-group">
				<div class="controls">
					<label for="usuario">Ponga el nombre de usuario que quiere usar</label>
					<input type="text" required class="form-control" id="name"  placeholder="Ponga el nombre de usuario que quiere usar"  data-validation-required-message="Su usuario" />
					<p class="help-block">* Debe usar números o letras y no dejar espacios en blanco. Recuerde si ha puesto mayúsculas o minúsculas. </p>
              </div>
	         </div> 	
			<?php }?>
			<div class="control-group">
			  <div class="controls">
				<label for="pass">Contraseña:</label>
				<input type="password" class="form-control" placeholder="Escoja su password" id="pass" name="pass" required  data-validation-required-message="El password es un dato requerido" />
				<p class="help-block"></p>
				</div>
			</div> 	
        
        
			<div class="control-group">
			  <div class="controls">
				<input type="password" class="form-control" placeholder="Repita su password" id="pass2"  name="pass2"  data-validation-match-match="pass" required  data-validation-required-message="El password es un dato requerido" data-validation-match-message="El password tiene que ser igual" />
				<p class="help-block"></p>
				</div>
			</div> 	
       

		
			<button type="submit" class="btn btn-primary pull-right">Enviar</button><br />
        <!-- </div> Comento el div de "caja_contrasena"-->
         
        <div id="success"> </div> <!-- mensajes -->   
        </form>      
                
                
      </fieldset>


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
				ventana modal
				</div>			 
			</div>
		</div>
	</div>
	<!--
	===========================  fin ventana modal
	-->

	<!--
	=======================================================================
	========================== segunda ventana modal: Contacta 
	======  => STG: ESTABA VISIBLE si no encuentra el mail en la BD. Ahora no es obligatorio que exista el mail previamente.
	======          Pero la mostramos por si el usuario desea contactar porque hay algún problema en el registro (no introdujo bien el mail, o el tfno, etc.)
	=======================================================================
	-->
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
	<?php require("./basicos_php/contacta.php");?> 
	<!--  ===========================  fin segunda ventana modal -->


   <div id="footer" class="row">
  <?php  include("temas/$tema_web/pie_com.php"); ?>
   </div>
   
   
   
   
   
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
     <script src="js/jquery-1.9.0.min.js"></script>
     <!--<script src="js/jquery.validate.js"></script>-->
	<script src="modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
 	<script src="js/jqBootstrapValidation.js"></script>
 	<script src="js/crea_contrasena.js"></script>
	<script src="js/contact_me.js"></script>
    
  </body>
</html>