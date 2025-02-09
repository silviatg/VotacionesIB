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
$nivel_acceso=6; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
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
                 <h1>Mis Grupos de trabajo</h1>   
                   <?php 
	
	  if($_SESSION['nivel_usu']==1){  // por seguridad si tiene el nivel 1, no puede ver nada
	  }
	 else if($_SESSION['nivel_usu']==2){
     $sql="SELECT ID ,subgrupo,tipo_votante, id_provincia, tipo,  texto, id_ccaa FROM $tbn4   order by tipo";
   	}
	else if($_SESSION['nivel_usu']==3){
       $sql="SELECT ID ,subgrupo,tipo_votante, id_provincia, tipo,  texto, id_ccaa FROM $tbn4 where id_ccaa=".$_SESSION['id_ccaa_usu']."  order by tipo";
  
	 	}
	else if($_SESSION['nivel_usu']==4){
     $sql="SELECT a.ID ,a.subgrupo,a.tipo_votante, a.id_provincia, a.tipo, a.texto,a.id_ccaa FROM $tbn4 a,$tbn5 b where (a.id_provincia= b.id_provincia) and b.id_usuario=".$_SESSION['ID']." order by a.tipo";
		}else{
     $sql="SELECT a.ID ,a.subgrupo,a.tipo_votante, a.id_provincia, a.tipo, a.texto,a.id_ccaa,  b.estado, b.admin FROM $tbn4 a,$tbn6 b where (a.ID= b.id_grupo_trabajo) and b.id_usuario=".$_SESSION['ID']." and b.admin=1 order by a.tipo";
   	}
	
$result = mysqli_query($con, $sql); 
if ($row = mysqli_fetch_array($result)){
?>
         
        
<table id="tabla1" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
                        <th width="50%">GRUPOS</th>
						<th width="10%">&nbsp;</th>
                        <th width="15%">&nbsp;</th>
						<th width="15%">&nbsp;</th>
					</tr>
				</thead>

				<tbody>
            
        <?php

mysqli_field_seek($result,0);

do {

 ?>
		  <tr>
			   <td><?php echo  "$row[1]" ?></td>              
               <td><?php if($row[4]==2){
			  $optiones2=mysqli_query($con,"SELECT  ccaa FROM $tbn3 where ID=$row[6]");
              $row_prov2=mysqli_fetch_row($optiones2);
		  echo "CCAA -" .utf8_encode($row_prov2[0]);
}
		 else if($row[4]==3){
			 echo "Estatal";
		 }
		 else{
			 $optiones2=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$row[3]");
   $row_prov2=mysqli_fetch_row($optiones2);
		  echo utf8_encode($row_prov2[0]);}
		  ?></td>             
               <td><a href="../admin/mis_grupos_user.php?idgr=<?php echo $row[0] ; ?>" > Ver/gestonar usuarios del grupo </a></td>
               <td>
		  
		  <?php 
		  
		
$sql_cont = "SELECT a.ID  FROM $tbn9 a,$tbn6 b where (a.ID= b.id_usuario) and b.id_grupo_trabajo=".$row[0]." and b.estado = 0 ";
  $result_cont=mysqli_query($con,$sql_cont);

$quants_cont=mysqli_num_rows($result_cont);
if($quants_cont==0){
	echo "&nbsp;";
}else{ ?>
	<a href="../admin/mis_grupos_pendiente.php?idgr=<?php echo $row[0] ; ?>" > Ver usuarios pendientes grupo <spam  class="text-danger"><?php echo "$quants_cont";  ?></spam></a> 
		<?php  }
		  ?>  </td>
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