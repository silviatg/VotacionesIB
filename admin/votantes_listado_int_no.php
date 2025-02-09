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

///// este scrip se usa en varias paginas

if($var_carga==true){
	
	$contar=0;
	
	///// cogemos los datos de la encuesta
	$result_vot=mysqli_query($con,"SELECT id_provincia, activa,nombre_votacion,tipo_votante, id_grupo_trabajo, demarcacion,id_ccaa, id_municipio  FROM $tbn1 where id=$idvot");
	$row_vot=mysqli_fetch_row($result_vot);

	$id_provincia_vot=$row_vot[0];
	$id_ccaa_vot=$row_vot[6]; 
	$activa=$row_vot[1];
	$tipo_votante=$row_vot[3];
	$id_grupo_trabajo=$row_vot[4];
	$id_municipio=$row_vot[7];

	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    elseif (isset($_SERVER['HTTP_VIA'])) {
       $ip = $_SERVER['HTTP_VIA'];
    }
    elseif (isset($_SERVER['REMOTE_ADDR'])) {
       $ip = $_SERVER['REMOTE_ADDR'];
    }
	
	$ip=$ip."+".$nombre."+".$_SESSION['ID'] ;  //añadimos la ip y quien ha realizado la votacion presencial

	////si vota presencial metemos el registro

	if ($_GET['votacion']=="ok"){
		$tipo_voto="presencial";
		$id =$_GET['id'];
	
		$usuarios_consulta = mysqli_query($con,"SELECT ID FROM $tbn2 where id_votante='$id' and id_votacion='$idvot'") or die(mysqli_error());
		$total_encontrados = mysqli_num_rows ($usuarios_consulta);
		mysqli_free_result($usuarios_consulta);

		if ($total_encontrados != 0){
			$mensa="<div class=\"alert alert-warning\">¡¡¡Error!!! <br>El Usuario ya está registrado  o ha votado, operacion incorrecta.</div>";
		}
		else {
			$result_votante=mysqli_query($con,"SELECT correo_usuario,tipo_votante,id_provincia FROM $tbn9 where id=$id");
			$row_votante=mysqli_fetch_row($result_votante);

			$correo_usuario=$row_votante[0]; 
			$tipo_usuario=$row_votante[1];
			$id_provincia_usu=$row_votante[2];
			$fecha_presencial=date("Y-m-d H:i:s"); //STG: Nuevo campo añadido porque en presencial no guardaba la fecha. Por si afecta al recuento, guardo la fecha de voto, pero en otro campo.

			$insql_votacion = "insert into $tbn2 (id_provincia, 	id_votante, 	id_votacion, 	tipo_votante, 	fecha, 	correo_usuario, forma_votacion,ip, fecha_presencial ) values (  \"$id_provincia_usu\",  \"$id\", \"$idvot\", \"$tipo_votante\", \"$fecha\", \"$correo_usuario\", \"$tipo_voto\",\"$ip\", \"$fecha_presencial\")";
			$inres = @mysqli_query($con,$insql_votacion) or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");
		}
	}
			 
	//permite impedir el voto forma temporal  para  congresos o eventos donde se vaya a votar de forma presencial 
	if(isset($_POST["modificar_multi"])){ 
		$tipo_voto="congreso";  
		$id =$_GET['id'];
		foreach ($_POST as  $k => $v) $a[] = $v;
		$datos=count ($a)-1;
		$i = 1;

		while ( $i < $datos) {
			$val = $a[$i];
	
			$usuarios_consulta = mysqli_query($con,"SELECT ID,correo_usuario FROM $tbn2 where id_votante='$val' and id_votacion='$idvot'") or die(mysqli_error());

			$total_encontrados = mysqli_num_rows ($usuarios_consulta);
			$row_error=mysqli_fetch_row($usuarios_consulta);
			mysqli_free_result($usuarios_consulta);

			if ($total_encontrados != 0){
				$mensa.="<div class=\"alert alert-warning\">¡¡¡Error!!! El Usuario ".$row_error[1]." ya está registrado en el congreso o ha votado, operacion incorrecta.</div>";
			}
			else {
				$result_votante=mysqli_query($con,"SELECT correo_usuario,tipo_votante,id_provincia  FROM $tbn9 where id=$val");
				$row_votante=mysqli_fetch_row($result_votante);

				$correo_usuario=$row_votante[0]; 
				$tipo_usuario=$row_votante[1];
				$id_provincia_usu=$row_votante[2];

				$insql_votacion = "insert into $tbn2 (id_provincia, 	id_votante, 	id_votacion, 	tipo_votante, 	fecha, 	correo_usuario, forma_votacion,ip ) values (  \"$id_provincia_usu\",  \"$val\", \"$idvot\", \"$tipo_votante\", \"$fecha\", \"$correo_usuario\", \"$tipo_voto\",\"$ip\")";

				$inres = @mysqli_query($con,$insql_votacion) or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");
				$mensa.= "<div class=\"alert alert-success\">Actualizados correctamente  $correo_usuario  </div>";	 
			}	
			$i++;
		}	 
	}
			
	//aqui termina el scrip de bloqueo de voto			
	if ($row_vot[5]==1){ //Demarcacion=1
		$id_provincia_url=$_GET['id_nprov'];
		$sql = "SELECT ID,nombre_usuario , correo_usuario,tipo_votante
		 FROM $tbn9 a
		 WHERE  NOT EXISTS (
			 SELECT * 
			 FROM $tbn2 b
			 WHERE a.id=b.id_votante and b.id_votacion=$idvot 
		 ) and a.tipo_votante <=$tipo_votante and a.id_provincia = '$id_provincia_url' ";
	}
	else if ($row_vot[5]==2){
		$sql = "SELECT ID,nombre_usuario , correo_usuario,tipo_votante
			 FROM $tbn9 a
			 WHERE  NOT EXISTS (
				 SELECT * 
				 FROM $tbn2 b
				 WHERE a.id=b.id_votante and b.id_votacion=$idvot 
			 ) and a.tipo_votante <=$tipo_votante and a.id_ccaa = '$id_ccaa_vot' ";
	}
	else if ($row_vot[5]==3){
		$sql = "SELECT ID,nombre_usuario , correo_usuario,tipo_votante
			 FROM $tbn9 a
			 WHERE  NOT EXISTS (
				 SELECT * 
				 FROM $tbn2 b
				 WHERE a.id=b.id_votante and b.id_votacion=$idvot 
			 ) and a.tipo_votante <=$tipo_votante and a.id_provincia = '$id_provincia_vot' ";
	}
	else if ($row_vot[5]==7){
		$sql = "SELECT ID,nombre_usuario , correo_usuario,tipo_votante
		 FROM $tbn9 a
		 WHERE  NOT EXISTS (
			 SELECT * 
			 FROM $tbn2 b
			 WHERE a.id=b.id_votante and b.id_votacion=$idvot 
		 ) and a.tipo_votante <=$tipo_votante and a.id_municipio = '$id_municipio' ";
	}
	else {
		///falta los grupos    $sql = "SELECT a.ID, a.nombre_usuario , a.correo_usuario,a.tipo_votante FROM $tbn9 a,$tbn6 b  WHERE (a.ID= b.id_usuario) and id_grupo_trabajo='$id_grupo_trabajo' and a.tipo_votante <='$tipo_votante' ";	
		$sql = "SELECT a.ID, a.nombre_usuario , a.correo_usuario,a.tipo_votante
		 FROM $tbn9 a,$tbn6 c
		 WHERE  NOT EXISTS (
			 SELECT * 
			 FROM $tbn2 b
			 WHERE a.id=b.id_votante  and b.id_votacion=$idvot 
		 ) and (a.ID=c.id_usuario) and a.tipo_votante <=$tipo_votante and c.id_grupo_trabajo='$id_grupo_trabajo' ";
	}
			
	$result = mysqli_query($con, $sql);
?>

<h1>Votación de <?php echo "$row_vot[2]" ?> </h1>
<p><?php echo "$mensa"; ?>&nbsp;</p>
<h3>Listado del censo que NO ha votado <?php if ($row_vot[5]==1 and $_GET['id_nprov']!=""){	?>
          para la provincia <strong> <?php echo $_GET['id_nprov']; ?></strong> y tipo de votacion 
          <?php } else if ($row_vot[5]==2){?>
		  para la comunidad autonoma <strong><?php echo $row_vot[6]; ?></strong> y tipo de votacion 
		  <?php } else if ($row_vot[5]==3){?>
		    para la provincia <strong><?php echo $row_vot[0]; ?></strong> y tipo de votacion 
          <?php }else{ ?>
          . Tipo de votacion  <?php }?>
            
            <?php if($row_vot[3]==1){
			  echo"solo para socios";
		  }
		  else if($row_vot[3]==2){
			  echo"solo pata socios y simpatizantes";
		  }
		  else if($row_vot[3]==3){
			  echo " abierta";
		  }
		  
		  ?> </h3> 
          
          

	<?php

if ($row = mysqli_fetch_array($result)){

 ?>
	<form name="form1" method="post" action="<?php $_SERVER['PHP_SELF'] ?>"> 
		  
		   
      <table id="tabla1<?php echo $_GET['cen']; ?>"  cellspacing="0" >
				<thead>
					<tr>
                        <th width="3%">ID</th>
						<th width="40%">NOMBRE</th>
                        <th width="30%">CORREO</th>
						<th width="5%">TIPO</th>
						<th width="10%">VOTA PRESENCIAL</th>
						<th width="10%">CONGRESO</th>
                     
					</tr>
				</thead>

				<tbody>
        <?php

mysqli_field_seek($result,0);
do {
 ?>
        <tr>
          <td><?php echo  "$contar" ?></td>
          <td><?php echo  "$row[1]" ?></td>
          <td><?php echo  "$row[2]" ?></td>
          <td><?php if($row[3]==1){
			  echo"socios";
		  }
		  else if($row[3]==2){
			  echo"simpatizante verificado";
		  }else if($row[3]==3){
			  echo"simpatizante";
		  }
		  else if($row[3]==5){
			  echo "Aqui hay un error";
		  }
		  
		  ?></td>

		
		<?php if ($permitir_votar_admin <> "") { ?>
		<td>
            <a href="../vota_orden/voto_primarias.php?idvot=<?php echo  "$idvot" ?>&idVotante=<?php echo "$row[0]" ?>"  class=delete><?php echo  "$texto_votar_admin" ?></a>    
		</td>
		<?php } else {?>	
		<td>
            <a href="votantes_listado_multi.php?idvot=<?php echo  "$idvot" ?>&votacion=ok&id=<?php echo  "$row[0]" ?>&id_nprov=<?php echo $_GET['id_nprov']; ?>&cen=<?php echo $_GET['cen']; ?>&lit=<?php echo $_GET['lit']; ?>"  class=delete>Vota de forma presencial </a>    
		</td>		
		<?php } ?>
		
          <td align="center"  bgcolor="<?php echo  "$color" ?>"  ><input name="modificar_congreso<?php echo  "$row[0]" ?>" type="checkbox" id="modificar_congreso" value="<?php echo  "$row[0]" ?>" /></td>
        </tr>
        <?php
}
while ($row = mysqli_fetch_array($result));



?>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><a href="votantes_list_votaciones_mis.php"> MIS VOTACIONES </a></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>
<input name="modificar_multi" type="submit" class="btn btn-primary pull-right" id="modificar_multi" value="Modificar  multiples" />
</td>
      </tbody>
</table>

     </form>
         
   <?php 
} else {
if($id_provincia== ""){
echo "<div class=\"alert alert-success\"> Escoja la provincia para la que quiere ver el censo</div>";	
}else{
echo "<div class=\"alert alert-success\"> ¡No se ha encontrado votantes para esta encuesta!</div> ";
}

}

}
else{
echo "error acceso";	
}
?>


