<br/>
<table width="100%" border="0">
  <tr>
    <th scope="row"><p>municipio</p>
    <p>&nbsp;</p></th>
    <td><p>codigo</p>
    <p>&nbsp;</p></td>
  </tr>
  

<?php
include('../inc_web/config.inc.php');

$consulta = "SELECT * from $tbn18 WHERE id_provincia = ".$_GET['id_provincia'];
$query = mysqli_query($con,$consulta)or die("error: ".mysql_error($con));
while ($fila = mysqli_fetch_array($query)) {
	
echo '<tr>
    <th scope=\"row\"> ' .utf8_encode($fila['nombre']).' </th>
    <td> '.$fila['id_municipio'].' </td>
  </tr>';
};
?>

</table>

 <p>&nbsp;</p> <p>&nbsp;</p> <p>&nbsp;</p>