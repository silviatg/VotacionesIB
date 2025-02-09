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

?>
<?php require ("../basicos_php/funcion_control_votacion.php");
require ("../basicos_php/basico.php");
?>

<?php 

$process_result = 'OK';
$msg_result = '';

$idvot=fn_filtro_numerico($con,$_POST['id_vot']);
if (isset($_POST['id_votante'])){
	$idvotante=fn_filtro_numerico($con,$_POST['id_votante']); //STG	
}
$id_provincia=fn_filtro_numerico($con,$_POST['id_provincia']);
$id_ccaa=fn_filtro($con,$_SESSION['id_ccaa_usu']);  // o este
$valores=fn_filtro($con,$_POST['valores']);
$id_ccaa = fn_filtro($con,$_POST['id_ccaa']); // o este sobran
$id_subzona = fn_filtro($con,$_POST['id_subzona']);
$id_grupo_trabajo = fn_filtro($con,$_POST['id_grupo_trabajo']);
//$id_municipio= fn_filtro($con,$_POST['id_municipio']);
$demarcacion = fn_filtro($con,$_POST['demarcacion']);
$clave_seg = fn_filtro($con,$_POST['clave_seg']);
$recuento = fn_filtro($con,$_POST['recuento']);
$mixto = fn_filtro($con,$_POST['mixto']);
//$campotexto_adicional = fn_filtro($con,$_POST['campotexto_adicional']);

if (isset($_POST['blanco'])){
	$blanco = true;
}else{
	$blanco = false;
}
if (isset($_POST['nulo'])){
	$nulo = true;
}else{
	$nulo = false;
}

	
$sql3 = "SELECT seguridad, nombre_votacion, numero_opciones,id_municipio,id_grupo_trabajo FROM $tbn1 WHERE ID='$idvot' ";
$resulta3 = mysqli_query($con, $sql3) or die("error: ".mysqli_error());

while( $listrows3 = mysqli_fetch_array($resulta3) ){ 
	$seguridad = $listrows3[seguridad];
	$nombre_votacion = utf8_encode($listrows3[nombre_votacion]);
	$numero_opciones = $listrows3[numero_opciones];
	$id_municipio = $listrows3[id_municipio];
	$id_grupo_trabajo = $listrows3[id_grupo_trabajo];
	
}

if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
   $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
elseif (isset($_SERVER['HTTP_VIA'])) {
   $ip = $_SERVER['HTTP_VIA'];
}
elseif (isset($_SERVER['REMOTE_ADDR'])) {
   $ip = $_SERVER['REMOTE_ADDR'];
}

if($seguridad==2 or $seguridad==4){
	if($clave_seg==""){
		$process_result = "ERROR";
		$msg_result = "No ha indicado clave de seguridad para recuperar su voto";
		//break;	
	}else{
		$codi = hash("sha512", $clave_seg);
		$sql_seg = "SELECT ID FROM $tbn10 WHERE id_votacion='$idvot'and codigo_val='$codi' ";
		$resulta_seg = mysqli_query($con, $sql_seg) or die("error: ".mysqli_error());
		$quants_seg=mysqli_num_rows($resulta_seg);
		if ($quants_seg != ""){  
			$process_result = "ERROR";
			$msg_result = "Esa clave ya esta siendo usada, por favor, cambie por otra";
		}
	}
}
$array_valores = explode(";", $valores);

//STG. En situaciones normales, quien vota es el usuario logueado, pero si hacemos voto presencial, 
//permitiendo que el administrador vote por el usuario presencial, guardamos que quien vota es el usuario presencial,
//que nos llega en la variable IdVotante desde la pantalla de voto presencial.
//echo "idVotante:".$idVotante;

if ($idvotante == ""){ 
	$idvotanteBD=$_SESSION['ID'];
	$forma_votacion=1;
}
else{
	$idvotanteBD=$idvotante;
	$forma_votacion="presencial";
}
	
list ($estado, $razon,$tipo_votante)=fn_mira_si_puede_votar($demarcacion,$idvotanteBD,$idvot,$id_ccaa,$id_provincia,$id_grupo_trabajo,$id_municipio);

if($estado=="error") {
	$process_result = "ERROR";
	
	if($razon=="direccion_no_existe"){
		$msg_result = "Esta direcci&oacute;n no est&aacute; registrada para esta votaci&oacute;n en nuestra base de datos.";
	}
	if($razon=="ya_ha_votado"){
		$msg_result = "ya has votado en esta votaci&oacute;n";
	}
}else if($estado=="TRUE" and $razon=="usuario_ok"){
	// CHECK VOTACIO
	$men = array();
	$women = array();
	$total = 0;
	foreach($array_valores as $v) {
		$array_valor = explode(",", $v);
		$position = $array_valor[0];
		$candi = $array_valor[1];

		if ($position == ""){
			continue;
		}
		$total = $total + 1;

		if ($position < 1 || $position > $numero_opciones){
			$process_result = "ERROR";
			$msg_result = "Posici&oacute;n erronea en la lista: $v";
			break;				
		}
		$sql = "SELECT sexo FROM $tbn7 WHERE id_votacion = '$idvot' and ID = '$candi'";
		$result = mysqli_query($con, $sql);
		if ($row = mysqli_fetch_array($result)){
			if ($row[0] == "H"){
				if (array_key_exists($position, $men)){
					$process_result = "ERROR";
					$msg_result = "Posici&oacute;n repetida en la lista de hombres: $position";
					break;
				}
				$men[$position] = $candi;
			}else{    				
				if (array_key_exists($position, $women)){
					$process_result = "ERROR";
					$msg_result = "Posici&oacute;n repetida en la lista de mujeres: $position";
					break;
				}
				$women[$position] = $candi;
			}
		}else{
			// candidat no trobat
			$process_result = "ERROR";
			$msg_result = "Candidato no existe en la base de datos ($candi). Notifica el error a la  Comisi&oacute;n de Primarias";
			break;
		}    		
	}
	// Check blanc
	if ($total == 0){
		if (!$blanco){
			$process_result = "ERROR";
			$msg_result = "No se ha seleccionado candidato  no ha indicado que el voto sea en blanco.";
		}
	}else{
		// Check ratio...
		// ugly hack. Check ratio only if numero_opciones > 2
		if($mixto="NOesMixto"){
		}
		else{
			if ($numero_opciones > 2){
				$ratio_men = count($men)/$total;
				if ($ratio_men > 0.6 || $ratio_men < 0.4 ){
					if (!$nulo){
						$process_result = "ERROR";
						$msg_result = "El voto es nulo y no se ha indicado como tal";
					}
				}
			}    		
		}
	}
		
		
	if ($process_result != "ERROR"){
			
		$codi = hash("sha512", $clave_seg);
		$okVot = true;
		
		$text = '';
		for ($i=0; $i<6; $i++) {
			$d=rand(1,30)%2;
			$text .= $d ? chr(rand(65,90)) : chr(rand(48,57));
		} 


		$transactionid = "INSVOT".$text;
		mysqli_query($con,'BEGIN '.$transactionid);
		// GET RANDOM ID FOR THE WHOLE VOTE
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$cad = "";
		for($i=0;$i<4;$i++) {
			$cad .= substr($str,rand(0,62),1);
		}
		$time = microtime(true);
		$timecad = $time.$cad;
		$vote_id = hash("sha256", $timecad);
		$total = 0;
		foreach($array_valores as $v) {
			$array_valor = explode(",", $v);
			$position=$array_valor[0];
			$candi=$array_valor[1];	
			
			if ($position == ""){
				continue;
			}
			$total = $total + 1;
			if($position > 0 && $position <= $numero_opciones){ 
				if ($nulo){
					$vot = 0;						
				}else{
					/////introduce el tipo de recuento					
					if ($recuento== 0){
							$vot = $numero_opciones + 1 - $position;	/////introduce valor del voto recuento borda							
					}else if ($recuento== 1){
						if ($voto_primarias_Imagina == "N") {
							$vot = 1/$position;// mete el recuento DOWDALL	
						}
						else{ //STG: provisionalmente, para las primarias de ImaginaBurgos, no usamos el recuendo Dowdall, sino que damos los valores 20 a 16
							if ($idvot==2){ //Si es para alcalde
								$vot = 1;
							}
							else{
								switch ($position) {
								case 1:
									$vot = 10;
									break;
								case 2:
									$vot = 7;
									break;
								case 3:
									$vot = 6;
									break;
								case 4:
									$vot = 5;
									break;
								case 5:
									$vot = 4;
									break;									
								}							
							}							
						}						
					}				
				}
				$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
				$cad = "";
				for($i=0;$i<4;$i++) {
					$cad .= substr($str,rand(0,62),1);
				}
				$time = microtime(true);
				$timecad = $time.$cad;
				$res_id = hash("sha256", $timecad);			  
				$fecha_env = date("Y-m-d H:i:s");
				$insql = "insert into $tbn10 (ID,voto,id_candidato,id_provincia,id_votacion,codigo_val,vote_id,position,otros) values (\"$res_id\",\"$vot\",\"$candi\",".$_SESSION['localidad'].",\"$idvot\",\"$codi\",\"$vote_id\",\"$position\",\"$nulo\")";
				$mens = "mensaje añadido";
				$result = db_query($con,  $insql,$mens);			 		
				if (!$result){
					$okVot = false;					
					break;
				}
			$datos_votado.="Orden $voto  | Identificador candidato -->  $candi |  Valor voto ---  $vot"."<br/>";
			}
		}
		
		
		if ($total == 0){
			// ALTA VOT BLANC
			$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";				
			$cad = "";
			for($i=0;$i<4;$i++) {
				$cad .= substr($str,rand(0,62),1);
			}
			$time = microtime(true);
			$timecad = $time.$cad;
			$res_id = hash("sha256", $timecad);			  
			$fecha_env = date("Y-m-d H:i:s");
			$n_blanco=2;
			$insql = "insert into $tbn10 (ID,id_provincia,id_votacion,codigo_val,vote_id,position,otros) values (\"$res_id\",".$_SESSION['localidad'].",\"$idvot\",\"$codi\",\"$vote_id\",\"$position\",\"$n_blanco\")";//insert into $tbn17 (ID, id_votacion) values (\"$res_id\",\"$idvot\")
			$mens = "mensaje añadido";
			$result = db_query($con, $insql,$mens);			 		
			if (!$result){
				$okVot = false;					
			}
		}

		if (!$okVot){
			mysqli_query($con,'');
			$process_result = "ERROR";
			$msg_result = "ERROR al introducir su voto en la base de datos.<br/> Intentelo en unos minutos o contacte con el administrador del sitio.";				
		}else{
			// ALTA A TAULA VOTACIO-USUARI				
			//$insql = "insert into $tbn2 (id_provincia,id_votacion,id_votante,fecha,tipo_votante,ip,forma_votacion,campotexto_adicional_voto) values (".$_SESSION['localidad'].",\"$idvot\",".$idVotanteBD.",\" $fecha_env\",\" $tipo_votante\",\" $ip\",\" $forma_votacion\", \"$campotexto_adicional\")";
			$insql = "insert into $tbn2 (id_provincia,id_votacion,id_votante,fecha,tipo_votante,ip,forma_votacion) values (".$_SESSION['localidad'].",\"$idvot\",".$idvotanteBD.",\" $fecha_env\",\" $tipo_votante\",\" $ip\",\" $forma_votacion\")";
			$mens = "<br/>???ATENCION!!!!, el voto ha sido registrado , pero el usuario no ha sido bloqueado <br> el ID de usuario es:".$_SESSION[ID];
			$result = db_query($con,  $insql,$mens);			 
			if (!$result){
				mysqli_query($con,'ROLLBACK');
				$process_result = "ERROR";
				$msg_result = "Error en la marca de su voto en la base de datos.<br/> Intentelo en unos minutos o contacte con el administrador del sitio";
			}else{
				mysqli_query($con,'COMMIT');
				if($seguridad==3 or $seguridad==4){
					require ("../basicos_php/envio_interventores.php"); 
				}
				$process_result="OK";
				$msg_result = "<div class='alert alert-success'>El voto se ha guardado en la base de datos de forma correcta.<br />Gracias por participar en esta votaci&oacute;n.</div>";
				
			}
		}
	}
}

mysqli_close($con);

echo $process_result."#".$msg_result;								

?>
