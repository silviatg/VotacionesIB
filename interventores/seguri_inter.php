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
include ('../basicos_php/basico.php');
if($_GET['idvot']!=""){
	$idvot=fn_filtro_numerico($con,$_GET['idvot']);
	$activa="si";//Si la votacion esta activa o no
	$sql_vot = "SELECT id_provincia,activa,tipo,tipo_votante,nombre_votacion,texto,resumen,numero_opciones,id_ccaa,id_subzona,id_grupo_trabajo, demarcacion, seguridad,activos_resultados,fecha_com,fecha_fin FROM $tbn1  WHERE ID='$idvot' and activa='$activa' ";
		$res_votacion = mysqli_query($con, $sql_vot);
			$row_vot=mysqli_fetch_row($res_votacion);
			
				$id_provincia = $row_vot[0];
				$activa  = $row_vot[1];
				$tipo = $row_vot[2];
				$tipo_votante = $row_vot[3]; // Tipo de acceso para esta página.
				$nombre_votacion = $row_vot[4];
				$texto = $row_vot[5];
				$resumen = $row_vot[6];
				$numero_opciones = $row_vot[7];
				$id_ccaa = $row_vot[8];
				$id_subzona = $listrows3[9];
				$id_grupo_trabajo = $row_vot[10];
				$demarcacion = $row_vot[11];
				$seguridad  = $row_vot[12];
				$activos_resultados  = $row_vot[13];				
				$fecha_com  = $row_vot[14]; 	
				$fecha_fin  = $row_vot[15];
				
				
			mysqli_free_result($res_votacion);
			
			
			require ("verifica.php");
			//$nivel_acceso=$row_vot[3]; // Tipo de acceso para esta página.
				
				$contar=0;

for($i=0;$i<$_SESSION['numero_inter'];$i++) {
			$id_inter="ID_inter_".$i;
			
    if (isset ($_SESSION[$id_inter])) {
       
		$contar= $contar + 1;
	
	    }
		}

if ($_SESSION['numero_inter']!=$contar){
	header ("Location: $url_vot/index.php?error_login=5");
	
	exit;
}
/*}*/
}
else{
	Header ("Location: $url_vot/index.php?error_login=6");
	session_destroy();
	exit;
}
?>