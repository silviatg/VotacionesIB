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
$nivel_acceso=3; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
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
                   
                   <?php 
				   include ('../basicos_php/basico.php');
				   
$id_provincia=fn_filtro_numerico($con,$_POST['id_provincia']);
$nombre_usuario=fn_filtro($con,$_POST['nombre_usuario']);
$correo_usuario=fn_filtro($con,$_POST['correo_electronico']);
$nif=fn_filtro($con,$_POST['nif']);
//$tipo_votante=$_POST['tipo_votante'];
$usuario=fn_filtro($con,$_POST['usuario']);

if ($_POST['nivel_admin']=="vacio"){
	$sent_sql="and nivel_usuario != '1'"; 
}
else{
	$sent_sql="and nivel_usuario = '$nivel_admin'";  
}

$sql = "SELECT ID, id_provincia, nombre_usuario, correo_usuario, nif FROM $tbn9 
			WHERE id_provincia like '%$id_provincia%' and nombre_usuario like '%$nombre_usuario%' and correo_usuario like '%$correo_usuario%' and nif like '%$nif%'  and (usuario like '%$usuario%' or usuario IS NULL) $sent_sql ORDER BY 'nombre_usuario' ";

$result = mysqli_query($con, $sql);

	  
	  
		  ?> 
		 <h1>DIRECTORIO CANDIDATOS/OPCIONES</h1><br/> 
		 <?php 
//$sql = "SELECT * FROM $tbn1 where id_provincia like '%$ids_provincia%' ORDER BY 'id_provincia' ";
 
//$result = mysqli_query($con, $sql);
if ($row = mysqli_fetch_array($result)){
	
	
?>
         
        
<table id="tabla1" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
                        <th width="3%">ID</th>
						<th width="30%">NOMBRE</th>
                        <th width="30%">Correo</th>
						<th width="10%">Provincia</th>
						<th width="10%">DNI</th>
						<th width="10%">censos por votación</th>
					
                        <th width="10%">Ver votaciones modificar</th>
					</tr>
				</thead>

				<tbody>
            
        <?php

mysqli_field_seek($result,0);

do {

 ?>
		  <tr>
			   <td><a data-toggle="modal"  href="usuario_datos.php?id=<?php echo  "$row[0]" ?>" data-target="#apuntarme" title="<?php echo  "$row[3]" ?>"><span class="glyphicon glyphicon-user  text-success" aria-hidden="true"></span></a></td>              
               <td><?php echo  "$row[2]" ?></td>             
               <td><?php echo  "$row[3]" ?></td>
               <td><?php echo  "$row[1]" ?></td>              
               <td><?php echo  "$row[4]" ?></td>             
               <td>
                <form id="form1" name="form1" method="post" action="votantes_list_votaciones_mis.php">
        <input name="id_usurio_vot" type="hidden" id="id_usurio_vot" value="<?php echo "$row[0]"; ?>" />
         <input type="submit" name="ver" id="ver" value="Ver censos votaciones" class="btn btn-primary btn-xs"/>
           </form>
               
               </td>
                           
              <td>
              <form id="form1" name="form1" method="post" action="gestion_votaciones_mis.php">
        <input name="id_usurio_vot" type="hidden" id="id_usurio_vot" value="<?php echo "$row[0]"; ?>" />
         <input type="submit" name="ver" id="ver" value="Ver votaciones"  class="btn btn-primary btn-xs"/>
           </form>
              
              
              </td>
		  </tr>
          
		 
				<?php
		}
	while ($row = mysqli_fetch_array($result));
	?>
</tbody>
</table>
              <?php 
            } else {
            echo " ¡No se ha encontrado ningún resultado! ";
            }
            
         ?>
    
                    
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
			"order":[0,"desc"]
   	  } );
	} );
	</script>
    <script type="text/javascript">
			<!-- limpiamos la carga de modal para que no vuelva a cargar lo mismo -->
			$('#apuntarme').on('hidden.bs.modal', function () {
			  $(this).removeData('bs.modal');
			});
   </script>
  </body>
</html>