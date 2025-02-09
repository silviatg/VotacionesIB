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
include('verifica.php');
//$nivel_acceso=11; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
	if(empty ($_SESSION['numero_vot'])){
header ("Location: $redir?error_login=5");
exit;
}
?>
<?php 
$contar=0;

for($i=0;$i<$_SESSION['numero_inter'];$i++) {
			$id_inter="ID_inter_".$i;			
    if (isset ($_SESSION[$id_inter])) {
		$contar= $contar + 1;
	    }
	}


if ($_SESSION['numero_inter']==$contar){
		echo "Ya estan validados todos los interventores para esta votación<br/>";
		
		if($_SESSION['tipo']==1){
			 $dir="voto_primarias.php";
			 $texto1_activo="Introducir votos manualmente ";
			 $image_activo="<span class=\"glyphicon glyphicon-thumbs-up  text-success\"></span>";
			 
		  }
		  else if($_SESSION['tipo']==2){
			  $dir="vut.php";
			 $texto1_activo="Introducir votos manualmente ";
			 $image_activo="<span class=\"glyphicon glyphicon-thumbs-up  text-success\"></span>";
		  }
		  else if($_SESSION['tipo']==3){
			  $dir="vota_encuesta.php";
			  $texto1_activo="Introducir votos manualmente ";
			 $texto2_activo="Votacion NO activa";
			 $image_activo="<span class=\"glyphicon glyphicon-thumbs-up  text-success\"></span>";
		  }else {
			  
			  }
		  
	$activo="<a href='".$dir."?idvot=".$_SESSION['numero_vot']."' >".$texto1_activo."". $image_activo."</a>";
		echo "<div class=\"alert alert-info\">".$activo."</div>";
	}else {
		$dif=$_SESSION['numero_inter'] - $contar;
		if ($dif!=1){ $plural ="es";}
		echo"<br/><br/><p> Aun tiene que validar ".$dif." interventor".$plural." para poder acceder a introducir datos </p>";
	}
?>
<p>&nbsp;</p>
<p>&nbsp;</p>

