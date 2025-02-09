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
/*    Funcion para comprobar si un usuario tiene derecho a votar o no */

function fn_mira_si_puede_votar ($demarcacion,$sesionId_usuario,$idvot,$ccaa,$provincia,$id_grupo_trabajo,$municipio){
	///// definimos las variables de las tablas como globales
	global $tbn9, $tbn6, $tbn2,$con;
	
	////// miramos si puede votar en esta votacion como seguridad	
		$bloqueo="no";	
		if ($demarcacion==1){	
				$conta="SELECT id,nombre_usuario,tipo_votante,id_provincia  FROM $tbn9 WHERE ID = $sesionId_usuario and bloqueo= \"$bloqueo\" ";
		}
		else if ($demarcacion==2){ // demarcacion ccaa
				$conta="SELECT id,nombre_usuario,tipo_votante,id_provincia  FROM $tbn9 WHERE ID = $sesionId_usuario and id_ccaa=\"$ccaa\"  and bloqueo= \"$bloqueo\"";
		} 
		else if ($demarcacion==3){
				$conta="SELECT id,nombre_usuario,tipo_votante,id_provincia  FROM $tbn9 WHERE ID = $sesionId_usuario and id_provincia='$provincia' and bloqueo= \"$bloqueo\" ";
		}
		else if ($demarcacion==7){
				$conta="SELECT id,nombre_usuario,tipo_votante,id_provincia  FROM $tbn9 WHERE ID = $sesionId_usuario and id_municipio='$municipio' and bloqueo= \"$bloqueo\" ";
		}
		else {
				$conta="SELECT a.id, a.nombre_usuario, a.tipo_votante, a.id_provincia  FROM $tbn9 a,$tbn6 b where (a.ID= b.id_usuario)  and a.ID= $sesionId_usuario and b.id_grupo_trabajo=$id_grupo_trabajo and bloqueo= \"$bloqueo\" ";
		}

		$result_cont=mysqli_query($con,$conta);
		$quants=mysqli_num_rows($result_cont);
		//miramos si hay resultados y el usuario pude votar en este tipo de votaion y si esta inscrito
				if ($quants == ""){
				return array ( "error","direccion_no_existe") ;
				}
				else{
					$row = mysqli_fetch_array($result_cont);
					$nombre=$row[1]; //ver si sobra
					$tipo_votante=$row[2];
					$id_provincia_usu=$row[3];//ver si sobra
					  ///// miramos si el usuario ya ha votado
						$conta_vot="SELECT id,id_votacion,id_votante FROM $tbn2 WHERE id_votacion like \"$idvot\" and id_votante=$sesionId_usuario ";
					
					$result_cont_vot=mysqli_query($con,$conta_vot);
					$quants_vot=mysqli_num_rows($result_cont_vot);
						
						if ($quants_vot != ""){  
					return array ( "error","ya_ha_votado") ;
					}
						else {
							return array ( "TRUE","usuario_ok",$tipo_votante) ;
						}
			}
	}

/////// si puede votar dara un array con "TRUE","usuario_ok"  si no puede votar dara "error " y la razon;
// para sacar el arry usar     list ($estado, $razon,$tipo_votante)=fn_mira_si_puede_votar ($demarca, $usu_pr,$id_vot_pr);


?> 