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
require_once("../inc_web/config.inc.php");
//include('../inc_web/seguri.php');
include("../basicos_php/basico.php") ;

//Defino mi variable mensaje

//$msg =strip_tags($_POST['msg']);
$msg = fn_filtro($con,$_POST['msg']);

$idvot=fn_filtro_numerico($con,$_POST['idvot']);
$id_user=fn_filtro_numerico($con,$_POST['IDST']);
$mi_estado=fn_filtro($con,$_POST['mi_estado']);
//$idvot=18;
//$msg = "vaya";
if(!empty($msg)){
   
   //Inserto el mensaje al tabla
   $time=time();
   $insql = "INSERT INTO $tbn12 (comentario,fecha,id_usuario,id_votacion,estado) VALUES ('".$msg."','".$time."','".$id_user."','".$idvot."','".$mi_estado."')";
	$mens="UPSSS!!!!<br/>esto es embarazoso, hay un error al incluir su comentario en este debate";
	$resulta =db_query($con, $insql,$mens);
	/*if(!$result){
	echo "<strong><font color=#FF0000 siz<br/> UPSSS!!!!<br/>esto es embarazoso, hay un error y su votacion no ha sido registrada </font></strong>";
		
	}
	if($result){ echo " terminado";
	}
	*/
	
}
//echo $idvot;
?>