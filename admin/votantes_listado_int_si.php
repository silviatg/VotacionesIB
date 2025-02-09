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


////////¡¡¡ojo!!! sin terminar //////////////////////

///// este scrip se usa en varias paginas

if($var_carga==true){
$contar=0;
 $result_vot=mysqli_query($con,"SELECT id_provincia, activa,nombre_votacion,tipo_votante, id_grupo_trabajo, demarcacion,id_ccaa, id_municipio  FROM $tbn1 where id=$idvot");
  $row_vot=mysqli_fetch_row($result_vot);

$id_provincia=$row_vot[0]; 
$id_ccaa=$row_vot[6];
$activa=$row_vot[1];
$tipo_votante=$row_vot[3];
$id_grupo_trabajo=$row_vot[4];
$id_municipio=$row_vot[7];

/*if($id_provincia=="00"){
	$id_provincia=$_GET['id_nprov'];
}
*/

$sql = "SELECT a.ID, 	a.nombre_usuario , a.correo_usuario, b.fecha, b.forma_votacion,a.tipo_votante FROM $tbn9 a,  $tbn2 b where (a.id=b.id_votante) and a.id_provincia = '$id_provincia' and a.tipo_votante <='$tipo_votante' and b.id_votacion=$idvot ";
if ($row_vot[5]==1){
	$id_provincia=$_GET['id_nprov'];
$sql = "SELECT a.ID, 	a.nombre_usuario , a.correo_usuario, b.fecha, b.forma_votacion,a.tipo_votante  FROM $tbn9 a,  $tbn2 b where (a.id=b.id_votante) and a.id_provincia = '$id_provincia' and a.tipo_votante <='$tipo_votante' and b.id_votacion=$idvot ";

}
else if ($row_vot[5]==2){
$sql = "SELECT a.ID, 	a.nombre_usuario , a.correo_usuario, b.fecha, b.forma_votacion,a.tipo_votante  FROM $tbn9 a,  $tbn2 b where (a.id=b.id_votante) and a.id_ccaa = '$id_ccaa' and a.tipo_votante <='$tipo_votante' and b.id_votacion=$idvot ";
	
}
else if ($row_vot[5]==3){
$sql = "SELECT a.ID, 	a.nombre_usuario , a.correo_usuario, b.fecha, b.forma_votacion,a.tipo_votante  FROM $tbn9 a,  $tbn2 b where (a.id=b.id_votante) and a.id_provincia = '$id_provincia' and a.tipo_votante <='$tipo_votante' and b.id_votacion=$idvot ";

}
else if ($row_vot[5]==7){
$sql = "SELECT a.ID, 	a.nombre_usuario , a.correo_usuario, b.fecha, b.forma_votacion,a.tipo_votante  FROM $tbn9 a,  $tbn2 b where (a.id=b.id_votante) and a.id_municipio = '$id_municipio' and a.tipo_votante <='$tipo_votante' and b.id_votacion=$idvot ";

}
else {
	//falta los grupos   $sql = "SELECT a.ID, a.nombre_usuario , a.correo_usuario,a.tipo_votante FROM $tbn9 a,$tbn6 b  WHERE (a.ID= b.id_usuario) and id_grupo_trabajo='$id_grupo_trabajo' and a.tipo_votante <='$tipo_votante' ";	

//$sql = "SELECT a.ID, 	a.nombre_usuario , a.correo_usuario, b.fecha, b.forma_votacion FROM $tbn9 a,  $tbn2 b, $tbn6 c  where (a.id=b.id_votante) and (a.id=c.id_votante)  and c.id_grupo_trabajo='$id_grupo_trabajo' and a.tipo_votante <='$tipo_votante' and b.id_votacion=$idvot ";
$sql = "SELECT a.ID, a.nombre_usuario , a.correo_usuario 
 FROM $tbn9 a,$tbn6 c
 WHERE  EXISTS (
	 SELECT  * 
	 FROM $tbn2 b
	 WHERE a.id=b.id_votante  and b.id_votacion=$idvot 
 ) and (a.ID=c.id_usuario) and a.tipo_votante <=$tipo_votante and c.id_grupo_trabajo='$id_grupo_trabajo' ";
	//////sin terminar
}


$result = mysqli_query($con, $sql);


 


?>

<h1>Votacion de <?php echo "$row_vot[2]" ?></h1>
          
          <h3>Listado del censo que SI ha votado <?php if ($row_vot[5]==1 and $_GET['id_nprov']!=""){	?>
          para la provincia <strong> <?php echo $_GET['id_nprov']; ?></strong> y tipo de votacion 
          <?php } else if ($row_vot[5]==2){?>
		  para la comunidad autonoma <strong> <?php echo $row_vot[6]; ?></strong> y tipo de votacion 
		  <?php } else if ($row_vot[5]==3){?>
		    para la provincia <strong><?php echo $row_vot[0]; ?> </strong>y tipo de votacion 
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
   

      <table id="tabla1<?php echo $_GET['cen']; ?>" cellspacing="0">
				<thead>
					<tr>
                        <th width="3%">ID</th>
						<th width="30%">NOMBRE</th>
                        <th width="20%">CORREO</th>
						<th width="10%">FECHA VOTACION</th>
						<th width="10%">TIPO VOTACION</th>
						<th width="5%">TIPO VOTANTE</th>
                     
					</tr>
				</thead>

				<tbody>
        <?php

mysqli_field_seek($result,0);
do {
 ?>
        <tr>
          <td><?php echo  "$contar"; ?></td>
          <td><?php echo  "$row[1]"; ?></td>
          <td><?php echo  "$row[2]" ;?></td>
          <td><?php echo  "$row[3]"; ?></td>
          <td><?php echo  "$row[4]"; ?></td>
          <td><?php echo  "$row[5]"; ?></td>
        </tr>
        <?php
}
while ($row = mysqli_fetch_array($result));


?>
    </tbody>
</table>
     
         
 <?php 
} else {
if($id_provincia== ""){
echo "<div class=\"alert alert-success\"> Escoja la provincia para la que quiere ver el censo</div>";	
}else{
echo "<div class=\"alert alert-success\"> ¡No se ha encontrado votantes para esta encuesta! </div> ";
}

}

}
else{
echo "error acceso";	
}
?>		



