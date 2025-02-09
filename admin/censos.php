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
include('../inc_web/seguri_nivel.php');
$nivel_acceso=2; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
include("../basicos_php/basico.php") ;
     
$fecha_ver =date("d-m-Y ");
$fecha =date("Y-m-d H:i:s");	  
 
if ($_GET['id']!=""){
	$id=fn_filtro_numerico($con,$_GET['id']); 
	$acc=fn_filtro_nodb($_GET['acc']); 
}

//Puden llamar desde fuera con acc=modifika&id=idUsuario => Consultamos los datos de ese usuario para modificarlos.
//O llamar con acc="" => Alta de nuevo usuario.
//O llamarse desde esta página, al hacer submit de los datos rellenos, con "add_votante" o "modifika_votante", segun sea alta o modificacion.

//Si es la primera vez que entramos, y vamos a modificar usuario existente, consultamos sus datos a la BD
if($acc == "modifika"){ 
	$result=mysqli_query($con,"SELECT ID, 	id_provincia, 	nombre_usuario, 	apellido_usuario, 	nivel_usuario, 	
		nivel_acceso, 	correo_usuario, nif, id_ccaa, 	pass, 	tipo_votante ,	usuario, 	
			bloqueo, 	razon_bloqueo,id_municipio,telefono  FROM $tbn9 where id=$id");
					
	$row=mysqli_fetch_row($result);
	
	$nombre=$row[2];
	$nif=$row[7];
	$correo=$row[6];
	$tfno=$row[15];
	$id_provincia=$row[1];
	$id_municipio=$row[14];		
	$tipo_votante=$row[10];	
	//$id_ccaa=$row[8]; //La ccaa la saca de la provincia luego.
	$bloqueado=$row[12]; //add: no lo tenia.
	$razon_bloqueo=$row[13];
	
	
	$resultFecha=mysqli_query($con,"SELECT fecha FROM $tbn17 WHERE id_votante = '$id' and accion = 1");			
	$rowFecha=mysqli_fetch_row($resultFecha);
	$fechaAlta=$rowFecha[0];

}


if(ISSET($_POST["modifika_votante"]) || ISSET($_POST["add_votante"])) {
	
	//Nombre
	if(empty($_POST['nombre'])){
		$error = "error";
		$inmsg="<div class=\"alert alert-danger\">El nombre es obligatorio</div>";
	}
	else{
		$nombre =fn_filtro($con,$_POST['nombre']);	
	}

	//if ($error == ""){
		//Apellido
		if(!empty($_POST['apellido']))
			$apellido =fn_filtro($con,$_POST['apellido']);
		//NIF
		if(empty($_POST['nif'])){
			$error = "error";
			$inmsg="<div class=\"alert alert-danger\">El NIF es obligatorio</div>";
		}
		else {
			$nif =strip_tags($_POST['nif']);
			$nif = str_replace(array(' ', '-'), array('', ''), $nif);
			$nif = strtoupper($nif); //Pasamos a mayúsculas.
			$DNIvalido = fn_validar_DNI($nif);
			if ($DNIvalido != "OK"){
				$error = "error";
				$inmsg="<div class=\"alert alert-danger\">El NIF/NIE $nif no es correcto, revísalo, por favor.</div>";
			}	
		}		
	//}
	//if ($error == ""){
		//EMAIL:			
		/*STG: Permitimos dejar el correo en blanco, para personas mayores que votan presencialmente. Esas personas no podrán entrar en la web, al no darnos un email.*/
		//* Tfno también puede estar vacío. Insertamos null,ya que no puede haber repetidos.
		if(empty($_POST['correo'])) {
			//$error = "error";
			//$inmsg = "<div class=\"alert alert-danger\">El e-mail del usuario es un dato requerido</div>";
			$correo="";
			$correoBD="NULL";
		}
		else {
			$mail_expr = "/^[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*"
				."@[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*$/";			
			if(!preg_match($mail_expr,$_POST['correo'])) {
				$error = "error";
				$inmsg="<div class=\"alert alert-danger\">La dirección de correo ·".$_POST['correo']." es err&oacute;nea</div>";
			}
			else{
				$correo=strip_tags($_POST['correo']);
				$correoBD="'$correo'";
			}
		}			
	//}
	//if ($error == ""){
		//TFNO:	
		if (empty($_POST['tfno'])){
			$tfno="";
			$tfnoBD="NULL";
		}
		else{
			$tfno=strip_tags($_POST['tfno']);
			$tfno = str_replace(array(' ', '-', '+'), array('', '', ''), $tfno);
			$TFNOvalido = fn_validar_tfno($tfno);
			if ($TFNOvalido != "OK"){
				$error = "error";
				$inmsg="<div class=\"alert alert-danger\">$TFNOvalido. Teléfono: $tfno. Revisa si has tecleado el teléfono móvil correctamente.</div>";	
			}
			else{
				$tfnoBD=$tfno; //El teléfono es numérico.		
			}			
		}
	//}
	//if ($error == ""){
		//REsto de campos son radios y combos, no necesario validar.
		$id_provincia=fn_filtro_numerico($con,$_POST['provincia']); //add: $id_provincia=$_POST['provincia'];	
		$id_municipio=fn_filtro($con,$_POST['municipio']);		
		$tipo_votante=fn_filtro_numerico($con,$_POST['tipo_usuario']); //add: $tipo_votante=$_POST['tipo_usuario'];
		// ----- miramos la provincia y cogemos el codigo de ccaa ---------------
		//$id_ccaa=$_POST['id_ccaa'];
		$optiones = "select DISTINCT id_ccaa from $tbn8 where ID ='$id_provincia' ";
		$resultas = mysqli_query($con, $optiones) or die("error: ".mysql_error($con));	
		while( $listrowes = mysqli_fetch_array($resultas) ){ 	
			$id_ccaa = $listrowes[id_ccaa];
		}
		//------------------------------------------------------------------------
		$id_subgrupo=fn_filtro($con,$_POST['id_subgrupo']); //add: $id_subgrupo=$_POST['id_subgrupo'];	//STG: creo que no se utiliza
		if(ISSET($_POST["modifika_votante"])){ //add: no lo tenia!. Insertamos siempre bloqueado vacío (por defecto tiene "no" en la BD)
			$bloqueado=fn_filtro($con,$_POST['bloqueado']); 
			$razon_bloqueo=fn_filtro($con,$_POST['razon_bloqueo']);
		}
		//echo "entro-$sql<Br>";		
	//}
}

if ($error == ""){	
	if( ISSET($_POST["modifika_votante"]) || ISSET($_POST["add_votante"])){
		///// REVISAMOS QUE OTRO USUARIO NO TENGA ALGUNO DE LOS DATOS INTRODUCIDOS.
		$sql="SELECT ID,nombre_usuario FROM $tbn9 WHERE (nif='$nif' ";
		if ($correo != ""){
			$sql.=" or correo_usuario='$correo'";	
		}
		if ($tfno != ""){
			$sql.=" or telefono = $tfno";	
		}
		$sql.=" ) AND id <> '$id'";
		//echo "$sql";
		
		$usuarios_consulta = mysqli_query($con,$sql) or die(mysql_error($con));
		$row_usuario=mysqli_fetch_row($usuarios_consulta);		
		$total_encontrados = mysqli_num_rows ($usuarios_consulta);
		mysqli_free_result($usuarios_consulta);			
		
		if ($total_encontrados != 0){
			$error="error";
			$inmsg= "<div class=\"alert alert-danger\"> ¡¡¡Error!!! <br>Existe otro usuario con alguno de estos datos: <br/> nombre: <strong>'". $nombre ."' </strong>, correo:<strong>'"
					.$correo."'</strong> o nif: <strong>".$nif."</strong> o teléfono: <strong>'".$tfno."'</strong>
					<br/>Puede comprobar/modificar los datos del otro usuario <a href=\"censos.php?id=".$row_usuario[0]."&acc=modifika\">pulsando aquí<br></a></div>";
		}		
	}		
}
if ($error==""){
	if(ISSET($_POST["modifika_votante"])){	
		//echo "entro-modifika. id: $id";
		
		$sSQL="UPDATE $tbn9 SET nombre_usuario=\"$nombre\", apellido_usuario=\"$apellido\",id_provincia=\"$id_provincia\",  correo_usuario=$correoBD ,nif=\"$nif\", telefono=$tfnoBD, tipo_votante=\"$tipo_votante\"  ,id_ccaa=\"$id_ccaa\", bloqueo=\"$bloqueado\", razon_bloqueo=\"$razon_bloqueo\" ,id_municipio=\"$id_municipio\" , sms_validated = 1 WHERE id='$id'";
		//STG+; Ya no se valida el SMS sino el DNI, así que podemos actualizar la marca a "1" para que a nadie le de al entrar el problema del sms.
		//09-02-19: Saltaba el error "Debe introducir la clave que se ha enviado a su teléfono móvil por sms".
		//Pasaba en los usuarios que insertábamos como nuevos, porque les ponía esa marca a 0. Se arreglaba al actualizar. 
		//Pero ya no es necesario que tenga esa marca a 0, porque sólo dejamos votar a los simpatizantes verificados.
		//Así que cuando hagamos un INSERT de nuevo votante, ya la pondremos directamente a 1. (Y actualizamo la BD, poniendo un 1
		//en los 22 usuarios que tienen en el campo "sms_Validated_PCAS" (hacemos backup de como estaba sms_validated en ese momento por si acaso.
		

		mysqli_query($con,$sSQL)or die ("Imposible modificar $tbn9. ".mysqli_error());

		/* metemos un control para saber quien ha modificado este votante*/
		$accion="2"; //dos , modifiicar votante
		$insql = "insert into $tbn17 (id_votante,id_admin,accion,fecha ) values (  \"$id\",\"".$_SESSION['ID']."\",   \"$accion\", \"$fecha\" )";
		$inres = @mysqli_query($con,$insql) or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");
			
		$inmsg =" <div class=\"alert alert-success\">¡CORRECTO! MODIFICADO <strong> $nombre</strong> a la base de datos </div>";
	}	
	else if(ISSET($_POST["add_votante"])){			 
		$insql = "insert into $tbn9 (nombre_usuario, apellido_usuario,	id_provincia, 	correo_usuario, nif, telefono, tipo_votante,id_ccaa,id_municipio, sms_validated, sms_validation_code) 
			values (  \"$nombre\",\"$apellidos\", \"$id_provincia\", $correoBD, \"$nif\", $tfnoBD, \"$tipo_votante\", \"$id_ccaa\", \"$id_municipio\" , 1 , '0000000001')";
		//STG+-: 9-2-19. Ponemos sms_validated = 1 al insertarlo en la BD, para que no de error luego de que no tiene sms.
		// También ponemos sms_validation_code a "00000001", porque influye en los mensajes al mail de la página procesar.php
		//No hay problema, porque en tipo_votante lo damos de alta con un 3 (no verificado)	
		$inres = @mysqli_query($con,$insql) or die ("<strong><font color=#FF0000 size=3>  Imposible a&ntildeadir. Cambie los datos e intentelo de nuevo.</font></strong> <br/>Error: ".mysqli_error());
		$id_nuevo = mysqli_insert_id($con);
		$inmsg =" <div class=\"alert alert-success\">¡CORRECTO! AÑADIDO votante <strong> $nombre</strong>, con NIF: $nif, a la base de datos.<br/>
			Puede comprobar/modificar los datos de este votante <a href=\"censos.php?id=$id_nuevo&acc=modifika\">pulsando aquí<br></a></div> ";
		$idvot = mysqli_insert_id($con);
		$accion="1"; //uno , incluir nuevo votante
		/* metemos un control para saber quien ha incluido este votante*/
		$insql = "insert into $tbn17 (id_votante,id_admin,accion,fecha ) values (  \"$idvot\",\"".$_SESSION['ID']."\",   \"$accion\", \"$fecha\" )";
		$inres = @mysqli_query($con,$insql) or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");
		
		//Si se ha insertado correctamente, borramos los campos del form, para empezar de cero con otro votante.
		$nombre="";
		$nif="";
		$correo="";
		$tfno="";
		//$id_provincia=""; //STG: Esto, pendiente de arreglarlo cuando haya más municipios/provincias
		//$id_municipio="";		
		$tipo_votante="";	
		//$id_ccaa=$row[8]; //La ccaa la saca de la provincia luego.
		$bloqueado=""; //add: no lo tenia.
		$razon_bloqueo="";
	}
}



?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title><?php echo "$nombre_web"; ?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=" ">
    <meta name="author" content=" ">
    <link rel="icon"  type="image/png"  href="../temas/<?php echo "$tema_web"; ?>/imagenes/icono.png"> 
    
    
    
    <!—[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]—>
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
       <link rel="stylesheet" href="../modulos/themes-jquery-iu/base/jquery.ui.all.css">
    <link href="../temas/<?php echo "$tema_web"; ?>/estilo.css" rel="stylesheet">
  
  </head>
  <body>
  <!-- NAVBAR
================================================== -->
 <?php  include("../admin/menu_admin.php"); ?>
    
<!-- END NAVBAR
================================================== -->

 <div class="container">
 
    <!-- cabecera
    ================================================== -->
	<div class="page-header">
		<img src="../temas/<?php echo "$tema_web"; ?>/imagenes/cabecera_votaciones.jpg" class="img-responsive" alt="Logo <?php echo "$nombre_web"; ?>">
	</div>
      
    <!-- END cabecera
    ================================================== -->
    <?php  include("../votacion/caja_mensajes_1.php"); ?>

    <div class="row">
        <div class="col-md-2" >             
          
          <?php  include("../votacion/menu_nav.php"); ?>
            
        </div>
        <div class="col-md-10">
     
                   <!--Comiezo-->
                   
        <h1> <?php  if($acc =="modifika"){ echo"MODIFICAR ESTE AFILIADO/SIMPATIZANTE"; }else{ echo "AÑADIR UN NUEVO AFILIADO/SIMPATIZANTE";}?></h1>
        <p>&nbsp;</p>
			<!----> 
        
			<?php echo "$inmsg";?> 
              
			<form action="<?php $_SERVER['PHP_SELF'] ?>" method=post name="frmDatos" id="frmDatos"  class="well form-horizontal" >			 
			 
										
				<div class="form-group">       
					<label for="nombre" class="col-sm-3 control-label">Fecha Alta Censo (*): </label>
					<div class="col-sm-9">   
						<?php echo "$fechaAlta";?>
					</div>
				</div>
				
				<div class="form-group">       
					<label for="nombre" class="col-sm-3 control-label">Nombre y apellidos (*)</label>
					<div class="col-sm-9">   
						<input name="nombre" type="text" id="nombre" value="<?php echo "$nombre";?>" class="form-control" placeholder="Nombre y apellidos" required autofocus data-validation-required-message="El nombre  es un dato requerido">
					</div>
				</div>
				
				<div class="form-group">       
					<label for="nif" class="col-sm-3 control-label"> Nif (*)</label>
					<div class="col-sm-4">    
						<input name="nif" type="text" id="nif" value="<?php echo "$nif";?>" class="form-control" placeholder="NIF" required autofocus data-validation-required-message="El NIF  es un dato requerido" />
					</div>
				</div>				
				
				<div class="form-group">       
					<label for="nombre" class="col-sm-3 control-label">Correo electronico </label>
					<div class="col-sm-9"> 
						<div class="controls">
							<input name="correo" type="email"  id="correo" value="<?php echo "$correo";?>"  class="form-control" placeholder="Correo electronico" />
							<p class="help-block"></p>
						</div>
					</div>
				</div>                  

				 
				<div class="form-group">       
					<label for="tfno" class="col-sm-3 control-label"> Teléfono Móvil</label>
					<div class="col-sm-4">    
						<input name="tfno" type="number" id="tfno" value="<?php echo "$tfno";?>" class="form-control" placeholder="Teléfono móvil" maxlength=9 minlength=9 data-validation-minlength-message="Indique las 9 cifras seguidas (sin espacios) de su teléfono móvil" data-validation-number-message="Indique las 9 cifras seguidas (sin espacios) de su teléfono móvil"/>
					</div>
				</div>			
				
				
				<div class="form-group">
					<label for="provincia" class="col-sm-3 control-label">Provincia: (*)</label> 
					<div class="col-sm-4"> 
				
				<?php 
				if($_SESSION['id_provincia']==00){ 
					$options = "select DISTINCT id, provincia from $tbn8  order by ID";
					$resulta = mysqli_query($con, $options) or die("error: ".mysql_error($con));
					while( $listrows = mysqli_fetch_array($resulta) ){ 
						$nFila++;
						$id_pro = $listrows[id];
						$name1 = utf8_encode($listrows[provincia]);
						
						if ($id_pro==$id_provincia){
							$check="selected=\"selected\" ";		
						}
						else{
							$check="";
						}
						$lista .="<option value=\"$id_pro\" $check> $name1</option>";
					}
				?>
				   
						<select name="provincia" class="form-control"  id="provincia" >
						<?php echo "$lista";?>
						</select>
				   
			<?php }
				  else{ 	?>
						<input name="provincia" type="hidden" id="provincia" value="<?php echo "$ids_provincia"; ?>" />
						<?php echo "$ids_provincia"; ?> | <?php echo "$asamblea"; ?> falta
			<?php }?>
					</div>
				</div>
				  
				  
				 <div class="form-group">       
					<label for="nombre" class="col-sm-3 control-label">Municipio (*)</label>
					<div class="col-sm-4">   
						<select name="municipio" id="municipio" class="form-control" > 

						</select>	
					</div>
				</div>
				
				<div class="form-group">       
					<label for="nombre" class="col-sm-3 control-label">Tipo </label>
					<div class="col-sm-9"> 
						<?php if ($tipo_votante==1){
							$chekeado1="checked=\"checked\" ";
						}else if ($tipo_votante==2){
							$chekeado2="checked=\"checked\" ";
						}else{
							$chekeado3="checked=\"checked\" ";
						}
				;?>
							<input name="tipo_usuario" type="radio" id="tipo_usuario_0" value="1" <?php echo "$chekeado1"; ?>  />
					  socio <br/>
							<input type="radio" name="tipo_usuario" value="2" id="tipo_usuario_1" <?php echo "$chekeado2"; ?> />
			simpatizante verificado<br/>
							<input type="radio" name="tipo_usuario" value="3" id="tipo_usuario_2" <?php echo "$chekeado3"; ?> />
			simpatizante
					</div>
				</div>
				  
				<?php  if($acc =="modifika"){  ?>     
				<div class="form-group">       
					<label for="nombre" class="col-sm-3 control-label">Bloqueado </label>
					<div class="col-sm-9">	  	  
						<?php if ($bloqueado=="si"){
							$chekeado3="checked=\"checked\" ";  
						 }else {
							 $chekeado4="checked=\"checked\" ";			  
						 } 
						;?>
						<input name="bloqueado" type="radio" id="bloqueado_0" value="si" <?php echo "$chekeado3"; ?>  />
						SI<br/>
						<input type="radio" name="bloqueado" value="no" id="bloqueado_1" <?php echo "$chekeado4"; ?> />
						NO
					</div>
					<div class="form-group">       
						<label for="nombre" class="col-sm-3 control-label">Razón Bloqueo </label>
						<div class="col-sm-9">
							<textarea name="razon_bloqueo"  class="form-control"  id="razon_bloqueo"><?php echo "$razon_bloqueo";?></textarea>
						</div>
					</div> 
				<?php } //Solo para modificación, alta no?>
					  
					<input name="incluido" type="hidden" id="incluido" value="<?php echo"$nombre_usuario";?>">
					<input name="fecha" type="hidden" id="fecha" value="<?php echo"$fecha";?>" />
					<!-- </td> STG: sobraba!-->
			  
			   <?php  if($acc =="modifika"){ ?>
					<input name="modifika_votante" type=submit  class="btn btn-primary pull-right"  id="modifika_votante" value="ACTUALIZAR  afiliado o simpatizante" />
					  <?php }else{ ?>
					<input name="add_votante" type=submit class="btn btn-primary pull-right"  id="add_votanteo" value="AÑADIR  afiliado o simpatizante" />
				<?php }?>
			  
			   <p>&nbsp;</p>
			   <br/>
				<div class="alert alert-danger">
					Instrucciones:<br>
						- <b>Solicite al votante que le muestre el DNI</b> siempre que sea posible para comprobar la identidad del votante. 
						  Si le ha mostraro el DNI, márquelo como <b>simpatizante "verificado"</b>.<br>
						- Asegúrese de <b>introducir los datos corréctamente</b>, para que pueda realizar posteriores votaciones por internet.<br>
						- Es posible dar de alta votantes sin email o teléfono móvil, pero luego no podrán entrar a votar por internet. 
						Incluye estos datos siempre que sea posible. Sólo en caso de no disponer de móvil, guarda el teléfono fijo.
				</div>	
			   
			</form>    

			<!-- STG: ?? Quitar????-->			
            <p>&nbsp;</p>   
			<!--Final-->
        </div>
	</div>
 

	<div id="footer" class="row">
		<!--
		===========================  modal para apuntarse
		-->
		<div class="modal fade" id="apuntarme" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
				   
					<div class="modal-body"></div>
					
				</div> <!-- /.modal-content -->
			</div> <!-- /.modal-dialog -->
		</div> <!-- /.modal -->

		<!-- ==========================  FIN modal apuntarse -->
		<?php  include("../votacion/ayuda.php"); ?>
		<?php  include("../temas/$tema_web/pie.php"); ?>
	</div>
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
   <script src="../js/jquery-1.9.0.min.js"></script>
   <script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
   <script src="../modulos/ui/jquery-ui.custom.js"></script>
   <script src="../js/jqBootstrapValidation.js"></script>
  
        <script type="text/javascript">
			$(document).ready(function(){
				$('#provincia').change(function(){
					
				var id_provincia=$('#provincia').val();
				$('#municipio').load('../basicos_php/genera_select.php?id_provincia='+id_provincia);
				$("#municipio").html(data);
				});
			});		
	   </script>
       <?php if($acc =="modifika"){ ?>
       	<script type="text/javascript">
		  function loadPoblacion(){
			 //Funcion para cargar poblacion si estamos modificando
	//		 $("#wall").load('wall.php?idgr=<?php echo $row[1];?>');
			 $('#municipio').load('../basicos_php/genera_select.php?id_provincia=<?php echo "$id_provincia";?>&id_municipio=<?php echo "$id_municipio";?>');
			 $("#municipio").html(data);
		  }
		  
		
		    $(document).ready(function(){  
		     loadPoblacion(); 
		    });
		 </script>
         <?php }else{?>
         <script type="text/javascript">
		  function loadPoblacion(){
			 //Funcion para cargar poblacion si estamos modificando
	//		 $("#wall").load('wall.php?idgr=<?php echo $row[1];?>');
			 $('#municipio').load('../basicos_php/genera_select.php?id_provincia=9'); //STG: Tenia a pelo un 1, le pongo un 9, que es Burgos. Habría que corregirlo.
			 $("#municipio").html(data);
		  }
		  
		
		    $(document).ready(function(){  
		     loadPoblacion(); 
		    });
		 </script>
         <?php }?>
  </body>
</html>