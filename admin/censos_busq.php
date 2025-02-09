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
include('../inc_web/seguri_nivel.php');
$nivel_acceso=11; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
////////////////Borrado multible/////////////////////////	 
if(isset($_POST["delete_multi"])){ 
			 
	foreach ($_POST as  $k => $v) $a[] = $v;
	$datos=count ($a)-7;
	$i = 0;

	while ( $i < $datos) {
		$val = $a[$i];
		$borrado = mysqli_query ($con,"DELETE FROM $tbn9 WHERE id=$val") or die("No puedo ejecutar la instrucción de borrado SQL query");	 
		$i++;
		$borrado= "Borrados correctamente $datos usuarios";
		
	}	 
}

$id_provincia=$_POST['id_provincia'];
$nombre_usuario=$_POST['nombre_usuario'];
$correo_usuario=$_POST['correo_electronico'];
$nif=$_POST['nif'];
$tfno=$_POST['tfno'];
$tipo_votante=$_POST['tipo_votante'];
$usuario=$_POST['usuario'];

//STG: Los campos email, usuario y tfno ahora pueden ser nulos, así que controlamos eso en las búsquedas.
$sql = "SELECT ID, id_provincia,  nombre_usuario, correo_usuario, nif, tipo_votante, usuario,bloqueo, telefono, apellido_usuario 
	FROM $tbn9 
	WHERE id_provincia like '%$id_provincia%' 
	and nombre_usuario like '%$nombre_usuario%'
	and tipo_votante like '%$tipo_votante%' 	
	and nif like '%$nif%' ";
	
if (isset($correo_usuario) && $correo_usuario != "") 
	$sql.=" and correo_usuario like '%$correo_usuario%'"; //STG
if (isset($tfno) && $tfno != "") 
	$sql.=" and telefono like '%$tfno%'";
if (isset($usuario) && $usuario != "") 
	$sql.=" and usuario like '%$usuario%'";

$sql.= " ORDER BY nombre_usuario ";

//echo "$sql";
$result = mysqli_query($con, $sql);


?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title><?php echo "$nombre_web"; ?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=" ">
    <meta name="author" content=" ">
    <link rel="icon"  type="image/png"  href="../temas/<?php echo "$tema_web"; ?>/imagenes/icono.png"> 
    
    
    
    <!—[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]—>
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="../modulos/DataTables-1.10.3/media/css/jquery.dataTables.css" rel="stylesheet">
    <link href="../temas/<?php echo "$tema_web"; ?>/estilo.css" rel="stylesheet">
  
  </head>
  <body>
  <!-- NAVBAR
================================================== -->
 <?php  include("../admin/menu_admin.php"); ?>
    
<!-- END NAVBAR
================================================== -->

 <div class="container">
 
    <!-- cabecera
    ================================================== -->
      <div class="page-header">
      <img src="../temas/<?php echo "$tema_web"; ?>/imagenes/cabecera_votaciones.jpg" class="img-responsive" alt="Logo <?php echo "$nombre_web"; ?>">
	  </div>
      
    <!-- END cabecera
    ================================================== -->
      <?php  include("../votacion/caja_mensajes_1.php"); ?>

       <div class="row">
        

        
        
        <div class="col-md-2" >             
          
          <?php  include("../votacion/menu_nav.php"); ?>
            
        </div>
       
        
        
        <div class="col-md-10">
     
                   <!--Comiezo-->
                   
                  <h1>CENSO </h1>
            <p>&nbsp;</p>
             <?php
		echo "$borrado";	 
		
?>
     <p>&nbsp;</p>       
            
		  <form name="formulario" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
	<?php

if ($row = mysqli_fetch_array($result)){

 ?>
      
      <table id="tabla1" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
          <th width=29%>Nombre y Apellidos</th>
		  <th width=29%>correo</th>
          <th width=3%>NIF</th>		
          <th width=3%>teléfono</th>				  
		  <th width=22%>usuario</th>
          <th width=3%>Tipo<br>Votante</th>
          <th width=7%>provincia</th>
          <th width=8%>bloqueado</th>
          <th width=8%>modificar<br>datos</th>
          <th width=6% align=center>borrar<br>datos</th>
          <th width=14% align=center>borrado<br />multiple</th>
        </tr>
        </thead>
        <tbody>
        <?php

	mysqli_field_seek($result,0);
	//echo "</tr> \n";
	//$var_bol=true;
	do {
 ?>
        <tr>
          <td><?php echo  "$row[2] $row[9]" ?></td>
		  <td><?php echo  "$row[3]" ?></td>
          <td><?php echo  "$row[4]" ?></td>
		  <td><?php echo  "$row[8]" ?></td>
          <td><?php echo  "$row[6]" ?></td>
          <td><?php echo  "$row[5]" ?></td>
          <td><?php echo  "$row[1]" ?></td>
          <td><?php echo  "$row[7]" ?></td>
          <td><a href="censos.php?id=<?php echo  "$row[0]" ?>&acc=modifika" >modificar<br>
          </a></td>
          <td>
			<?php if ($_SESSION['usuario_nivel'] == 0) { //Si es super-administrador ?>
				<a href="censos_borra.php?id=<?php echo  "$row[0]" ?>&idvot=<?php echo  "$row[2]" ?>" onClick="return borrarevento()" >Borrar </a>
			<?php } else {?>
				Borrado (admin)
			<?php } ?>
					
		  </td>
          <td>
          <input name="borrar_multiples<?php echo  "$row[0]" ?>" type="checkbox" id="borrar_multiples" value="<?php echo  "$row[0]" ?>">        
			</td>
        </tr>
        <?php
	}
	while ($row = mysqli_fetch_array($result));
?>

          </tbody>
	<tfoot>
		<tr>		
		  <th width=29%>nombre y apellidos</th>
          <th width=29%>correo</th>
		  <th width=3%>NIF</th>
		  <th width=3%>Teléfono</th>
		  <th width=22%>Usuario</th>
          <th width=3%>Tipo<br>Votante</th>		  
          <th width=7%>provincia</th>
          <th width=8%>bloqueado</th>
          <th width=8%>modificar<br>datos</th>
          <th width=6% align=center>borrar<br>datos</th>
          <th width=14% align=center>borrado<br />multiple</th>	  
		</tr>
	</tfoot>
    
      </table>
	  
       <input name="id_provincia" type="hidden" value="<?php echo "$id_provincia"; ?>">
      <input name="nombre_usuario" type="hidden" value="<?php echo "$nombre_usuario"; ?>">
      <input name="correo_electronico" type="hidden" value="<?php echo "$correo_usuario"; ?>">
      <input name="nif" type="hidden" value="<?php echo "$nif"; ?>">
	  <input name="tfno" type="hidden" value="<?php echo "$tfno"; ?>">
      <input name="tipo_votante" type="hidden" value="<?php echo "$tipo_votant"; ?>">
      <input name="usuario" type="hidden" value="<?php echo "$usuario"; ?>">
      <p>&nbsp;</p>
      <div class="derecha">
		<?php if ($_SESSION['usuario_nivel'] == 0) { //Si es super-administrador ?>
		<input name="delete_multi" type="submit" class="btn btn-primary pull-right"   id="delete_multi" value="Borrar multiples" />
		<?php } ?>
      </div>
		  </form>
   
    <?php 
} else {

echo " ¡No se ha encontrado ningún votante que cumpla todos los criterios de búsqueda! ";


}


?><!---->				
                    
  <!--Final-->
        </div>
        
         
      
  </div>
 

  <div id="footer" class="row">
    <!--
===========================  modal para apuntarse
-->
<div class="modal fade" id="apuntarme" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           
            <div class="modal-body"></div>
            
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

 <!--
===========================  FIN modal apuntarse
-->
   <?php  include("../votacion/ayuda.php"); ?>
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
	<script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
    <script src="../modulos/DataTables-1.10.3/media/js/jquery.dataTables.min.js"></script>
  	<script src="../js/admin_borrarevento.js"></script>
	<script type="text/javascript" language="javascript" class="init">
	
	$(document).ready(function() {
    $('#tabla1').dataTable( {
        "language": {
            "lengthMenu": "Ver _MENU_  resultados por pagina",
            "zeroRecords": "No se han encontrado resultados - perdone",
            "info": "Mostrando _PAGE_ de _PAGES_ paginas",
            "infoEmpty": "No se han encitrado resultados",
            "infoFiltered": "(filtered from _MAX_ total records)",
			"loadingRecords": "Cargando...",
    		 "processing":     "Procesando...",
   			 "search":         "Buscar:",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
			"aria": {
				"sortAscending":  ": activate to sort column ascending",
				"sortDescending": ": activate to sort column descending"
			}
       	 },
			"order":[0,"asc"] 
   	  } );
	} );
	//STG: Cambio order "desc" por "asc", para ordenar por nombre.
	</script>
    <script type="text/javascript">
			<!-- limpiamos la carga de modal para que no vuelva a cargar lo mismo -->
			$('#apuntarme').on('hidden.bs.modal', function () {
			  $(this).removeData('bs.modal');
			});
   </script>
  </body>
</html>