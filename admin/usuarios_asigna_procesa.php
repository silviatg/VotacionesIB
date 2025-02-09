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
$nivel_acceso=3; 
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
include ('../basicos_php/basico.php');

if($_POST["tipo"]=="provincias"){
	
$id=fn_filtro_numerico($con,$_POST['id']);
	
$borrado = mysqli_query ($con,"DELETE FROM $tbn5 WHERE id_usuario=".$id." ") or die("No puedo ejecutar la instrucción de borrado SQL query");


$admin=1;

if( isset( $_POST['myCheckboxes'] ) )
{
    for ( $i=0; $i < count( $_POST['myCheckboxes'] ); $i++ )
    {
		//echo $_POST['myCheckboxes'][$i];
		
       $val= $_POST['myCheckboxes'][$i];
   
	$insql = "insert into $tbn5 (id_usuario,id_provincia,admin) values (  ".$id.",  \"$val\", \"$admin\")";
	$inres = @mysqli_query($con,$insql) or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");
	 }
}	
	echo "<div class=\"alert alert-success\">Los datos de provincia han sido correctamente incluidos</div>";

		
	}

/*SI AÑADIMOS UN GRUPO DE TRABAJO O ASAMBLEA*/

if($_POST["tipo"]=="grupos"){
	$id=fn_filtro_numerico($con,$_POST['id']);
$borrado = mysqli_query ($con, "DELETE FROM $tbn6 WHERE id_usuario=".$id."") or die("No puedo ejecutar la instrucción de borrado SQL query");

$admin=1;
$estado=1;
if( isset( $_POST['myCheckboxes'] ) )
{
    for ( $i=0; $i < count( $_POST['myCheckboxes'] ); $i++ )
    {
		echo $_POST['myCheckboxes'][$i];
		
       $val= $_POST['myCheckboxes'][$i];
	$insql = "insert into $tbn6 (id_usuario,id_grupo_trabajo,admin,estado) values ( ".$id.",  \"$val\", \"$admin\",\"$estado\")";
	$inres = @mysqli_query($con,$insql) or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");
		}
}	
	echo " <div class=\"alert alert-success\">Los datos de los grupos sido correctamente incluidos</div>";
		
	}

?>