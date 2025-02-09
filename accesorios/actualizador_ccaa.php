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

require ("../inc_web/config.inc.php");
 
echo "actualizador";

	$options = "select DISTINCT id, id_ccaa from $tbn8  order by ID";
	$resulta = mysqli_query($con, $options) or die("error: ".mysql_error());
	
	while( $listrows = mysqli_fetch_array($resulta) ){ 
	$id_provincia = $listrows[id];
	$id_ccaa = utf8_encode($listrows[id_ccaa]);
	
echo "$id_provincia -";
echo "$id_ccaa <br/>";

$sSQL="UPDATE $tbn9 SET  id_ccaa=\"$id_ccaa\" WHERE id_provincia ='$id_provincia'";

mysqli_query($con,$sSQL)or die ("Imposible modificar pagina");

}


?>