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

include("../basicos_php/basico.php") ;
$idgr=$_GET['idgr'];
if(isset($_POST["update_multi"])){  
$razon_bloqueo=$_POST["razon_bloqueo"];			 
foreach ($_POST as  $k => $v) $a[] = $v;
 $datos=count ($a)-1;
$i = 0;

while ( $i < $datos) {
$val = $a[$i];
$desbloqueo =1;  //codigo  o

	$update = mysqli_query ($con,"UPDATE $tbn6 SET estado=\"$desbloqueo\",razon_bloqueo=\"$razon_bloqueo\"  WHERE id_usuario=$val and id_grupo_trabajo=".$_GET['idgr']." ") or die("No puedo ejecutar la instrucción de borrado SQL query");
	 
$i++;


}	

			}


$sql = "SELECT a.ID,  a.nombre_usuario, a.correo_usuario,  a.tipo_votante, a.usuario, b.razon_bloqueo,b.estado, a.nif FROM $tbn9 a,$tbn6 b where (a.ID= b.id_usuario) and b.id_grupo_trabajo=".$_GET['idgr']." and  b.estado = 0   order by a.nombre_usuario ";
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
       
        
        
        <span class="form-group">
        <?php
		  if ($bloqueado=="si"){
			echo "Desbloqueo";  
		  }
		  if ($bloqueado=="no"){
			echo "Bloqueo";  
		  }?>
        </span>
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
          <th width=12%>Nombre</th>
          <th width=10%>correo</th>
          <th width=6%>Tipo</th>
          <th width=7%>NICK</th>
          <th width=14%>NIF</th>

         
          <th width=4% >&nbsp;</th>
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
          <td><?php echo  "$row[1]" ?></td>
          <td><?php echo  "$row[2]" ?></td>
          <td><?php echo  "$row[3]" ?></td>
          <td><?php echo  "$row[4]" ?></td>
          <td><?php echo  "$row[7]" ?></td>
         
         <td>
          <input name="borrar_multiples<?php echo  "$row[0]" ?>" type="checkbox" id="borrar_multiples" value="<?php echo  "$row[0]" ?>" />
        
        </td>
        </tr>
        <?php
}
while ($row = mysqli_fetch_array($result));


?>

          </tbody>
	<tfoot>
		<tr>
		<th width=12%>Nombre</th>
          <th width=10%>correo</th>
          <th width=6%>Tipo</th>
          <th width=7%>NICK</th>
          <th width=14%>NIF</th>
           <th width=4% >&nbsp;</th>
		</tr>
	</tfoot>
    
      </table><p>&nbsp;</p>
       
      <p>&nbsp;</p>
    <input name="update_multi" type="submit"  class="btn btn-primary pull-right"   id="update_multi" value="Incluir" />
     
		  </form>
   
    <?php 
} else {

echo " ¡No se ha encontrado ningún registro! ";


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