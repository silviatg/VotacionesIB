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
require ("../inc_web/verifica.php");

$nivel_acceso=11; 
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}

include ('../basicos_php/basico.php');
if($_POST['ID_acceso']==1){
	$estado=1;
}
else{
	$estado=0;
}
$IDgr=fn_filtro_numerico($con,$_POST['IDgr']);
//miramos si ya esta en el grupo 
		$result2=mysqli_query($con,"SELECT id FROM $tbn6 where id_usuario=". $_SESSION['ID']." and id_grupo_trabajo=".$IDgr." ");
  		$quants=mysqli_num_rows($result2);
		if($quants!=""){
		echo " 
<div class=\"alert alert-danger\">
    <strong>Ya estas apuntado a este grupo</strong>
	</div>";
		}else{

	$insql = "insert into $tbn6 (id_usuario,id_grupo_trabajo,estado) values ( ". $_SESSION['ID'].",  \"".$IDgr."\",\"$estado\")";
	$inres = @mysqli_query($con,$insql) or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");
		
		$correcto ="ok"; 	
		//$inmsg ="Has sido correctamente incluido, <br/> en breve podras participar";	
echo " 
<div class=\"alert alert-success\">
    <strong>Has sido correctamente incluido, <br/> en breve podras participar
	</div>";
		}
?>