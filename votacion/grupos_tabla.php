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
                   
                   <h1>Grupos de trabajo </h1>
       
    	<?php 
		$esta_activa=1;
		$tipo=1;
		
				
				$sql = "select ID, tipo,texto,subgrupo,  acceso from $tbn4 where  tipo_votante<=".$_SESSION['tipo_votante']."  and  (id_ccaa=".$_SESSION['id_ccaa_usu']." or id_ccaa=0)  and (id_provincia=".$_SESSION['localidad']." or id_provincia=0) order by id desc";
			
				?>
				 <?php 
		$result = mysqli_query($con, $sql);
		if ($row = mysqli_fetch_array($result)){

		 ?>
<table id="tabla1" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="73%">Grupo</th>
                        <th width="6%">Tipo</th>
						<th width="21%">&nbsp;</th>
						
						
					</tr>
				</thead>

				<tbody>
        <?php

	mysqli_field_seek($result,0);
		do {
			
		 ?>
		  <tr>
			   <td>
				<h5><?php  echo $row[3]; ?></h5>
                <?php echo $row[2];?>
			   </td>
               
               <td>
				<?php 
				if($row[1]==1){
			echo "Provincial";
				}
				else if($row[1]==2){
			echo "Autonomico";
				}else if($row[1]==3){
			echo "Estatal";
				}
				 ?>
                
			   </td>
               
               <td>
				 <?php 
				 $options_usu = "select  ID,admin,estado from $tbn6 where  id_grupo_trabajo=".$row[0]." and id_usuario=".$_SESSION['ID']."  order by ID";
	$result_cont=mysqli_query($con,$options_usu);
	 
    $quants=mysqli_num_rows($result_cont);
	$row_cont=mysqli_fetch_row($result_cont);
			/////aqui miramos si esta o no en el grupo
			if ($quants!=""){
		if ($row_cont[1]== 0 ){  // si esta apuntado pero no es admin
				if ($row_cont[2]== 0 ){  // si esta esperando aprobacion ?>
					Pendiente de acceso
		<?php			}	else if ($row_cont[2]== 1 ){ //si ya esta aprobado ?>
				<a href="../votacion/votaciones_grupo.php?idgr=<?php echo $row[0]; ?>" class="btn btn-success  pull-right">Acceder </a>
			<?php		}	else if ($row_cont[2]== 3 ){ //si esta bloqueado ?>
					No tiene ecceso, si quiere volver a acceder hable con el administrador
			<?php		}
			}else if ($row_cont[1]== 1 ) { //si es admin?>
		<a href="../votaciones/votacion_grupo.php?idgr=<?php echo $row[0]; ?>" class="btn btn-success  pull-right" >Administrador </a>
	<?php	} }else{  // si se tiene que apuntar ?>
	
	 <a data-toggle="modal"  href="../votacion/grupos_add.php?idgr=<?php echo $row[0];?>" data-target="#apuntarme"  class="btn btn-info  pull-right">Apuntarme</a>
	<?php } ?><br/>
		
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
            echo " ¡No se ha encontrado ningún grupo de trabajo! ";
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
       	 }
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