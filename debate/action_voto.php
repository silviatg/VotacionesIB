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



if(ISSET($_POST["enviar_voto"])){
	
$id_votacion=fn_filtro_numerico($con,$_POST['id_votacion']);
$id_pregunta=fn_filtro_numerico($con,$_POST['id_pregunta']);
$voto=fn_filtro($con,$_POST['voto']);
$id_usuario=fn_filtro($con,$_POST['IDST']);

$query_votoa = mysqli_query($con, "SELECT  ID  FROM $tbn14  where id_pregunta = '".$id_pregunta."' and id_votante ='".$id_usuario."' ");
if ($row_votoa = mysqli_fetch_array($query_votoa))
{
mysqli_field_seek($query_votoa,0);

do { 
$id_voto=$row_votoa['ID'];
$sSQL="UPDATE $tbn14 SET  voto=\"$voto\" WHERE ID='$id_voto'";
mysqli_query($con,$sSQL)or die ("Imposible modificar pagina");

}

while ($row_votoa = mysqli_fetch_array($query_votoa));
}
else{

	$insql = "insert into $tbn14 (id_votante, 	id_pregunta, 	id_votacion, voto) values (  \"$id_usuario\",  \"$id_pregunta\", \"$id_votacion\", \"$voto\")";
	 $mens="";
	$resulta =db_query($con, $insql,$mens);
}

}

?>