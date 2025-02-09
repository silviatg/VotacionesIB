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
$idvot=$_GET['idvot'];

$sql = "SELECT id,nombre, apellidos,correo,tipo FROM $tbn11 WHERE id_votacion = '$idvot'  ORDER BY 'nombre'";

$result = mysqli_query($con,$sql );

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
                   
                  <h1>Interventores de esta votacion</h1>
            <p>&nbsp;</p>
            <h3><a href="interventor.php?idvot=<?php echo  "$idvot" ?>" >Añadir Interventores </a></h3>
           
     <p>&nbsp;</p>       
            
		  <form name="formulario" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
	<?php

if ($row = mysqli_fetch_array($result)){

 ?>
      <table id="tabla1" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
        <th width=10%>ID</th>
          <th width=41%>Nombre</th>
          <th width=29%>correo</th>
          <th width=10%>tipo</th>
          <th width=12%>modificar<br>
            datos</th>
          <th width=8% align=center>borrar<br>
      datos</th>
          
        </tr>
        </thead>
        <tbody>
        <?php

mysqli_field_seek($result,0);

do {

 ?>
        <tr>
        <td><?php echo  "$row[0]" ?></td>
          <td><?php echo  "$row[1]" ?><?php echo  "$row[2]" ?></td>
          <td><?php echo  "$row[3]" ?></td>
          <td><?php 
		  if($row[4]==0){
		  echo  "correo";
		  }else if ($row[4]==1){
			   echo  "Especial";
		  }else if ($row[4]==2){
			  echo  "Especial + correo";
		  }?></td>
          <td><a href="interventor.php?id=<?php echo  "$row[0]" ?>&idvot=<?php echo  "$idvot" ?>&acc=modifika" >modificar<br>
          </a></td>
          <td><a href="interventor_borra.php?id=<?php echo  "$row[0]" ?>&idvot=<?php echo  "$idvot" ?>" onClick="return borrarevento()" >Borrar </a></td>

        </tr>
        <?php
}
while ($row = mysqli_fetch_array($result));


?>

          </tbody>
	<tfoot>
		<tr>
			<th width=10%>ID</th>
          <th width=41%>Nombre</th>
          <th width=29%>correo</th>
          <th width=10%>tipo</th>
          <th width=12%>modificar<br>
            datos</th>
          <th width=8% align=center>borrar<br>
      datos</th>
          <
		</tr>
	</tfoot>
    
      </table>
      <p>&nbsp;</p>
      <div class="derecha">
      <input name="delete_multi" type="submit" class="button medium red" id="delete_multi" value="Borrar multiples" />
      </div>
		  </form>
   
    <?php 
} else {

echo " ¡No se ha encontrado ningún interventor! ";


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