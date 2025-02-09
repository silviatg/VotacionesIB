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
include ('../basicos_php/basico.php');

 if(ISSET($_POST["buscar_ccaa"])){  
    ///////////////////////miramos la comunidad autonoma para meterlo tambien en la sesion
    
    $options2 = "select DISTINCT ccaa from $tbn3  where ID = ".$_POST['id_ccaa']." ";
	$resulta2 = mysqli_query($con, $options2) or die("error: ".mysqli_error());
	while( $listrows2 = mysqli_fetch_array($resulta2) ){
    $nombre_zona=utf8_encode($listrows2['ccaa']);   }
 }
		 elseif(ISSET($_POST["buscar_prov"])){
///////////////// miramos el codigo de la provincia para meterlo en la sesion
    $options = "select DISTINCT provincia from $tbn8  where ID = ".$_POST['id_provincia']."";
	$resulta = mysqli_query($con, $options) or die("error: ".mysqli_error());
	while( $listrows = mysqli_fetch_array($resulta) ){	
    $nombre_zona=utf8_encode($listrows['provincia']);   }
	
 }
		elseif(ISSET($_POST["buscar_municipio"])){
	
	///////////////////////miramos el municipio para meterlo tambien en la sesion
    
    $options2 = "select DISTINCT nombre from $tbn18  where id_municipio = ".$_POST['municipio']." ";
	$resulta2 = mysqli_query($con, $options2) or die("error: ".mysqli_error());
	while( $listrows2 = mysqli_fetch_array($resulta2) ){
    $nombre_zona=utf8_encode($listrows2['nombre']);   }
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
	  
	   if ($_SESSION['nivel_usu']==2){
		
		 if(ISSET($_POST["buscar_ccaa"])){  
		 $id_ccaa= fn_filtro_numerico($con,$_POST['id_ccaa']);
		 $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados, demarcacion  FROM $tbn1 where demarcacion=2 AND id_ccaa=".$id_ccaa." ORDER BY 'ID' ";
		$tipos_buscado=" AUTONOMICA -  ".$id_ccaa."";
		
		 }
		 elseif(ISSET($_POST["buscar_prov"])){
			 $id_provincia= fn_filtro_numerico($con,$_POST['id_provincia']);
			 $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados, demarcacion  FROM $tbn1 where demarcacion=3 AND id_provincia=".$id_provincia." ORDER BY 'ID' ";
		$tipos_buscado=" PROVINCIA - ".$id_provincia.""; 
			 
			}
		 elseif(ISSET($_POST["buscar_sub"])){
			 $id_sub= fn_filtro_numerico($con,$_POST['id_sub']);
			  $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados, demarcacion  FROM $tbn1 where id_grupo_trabajo=".$id_sub." ORDER BY 'ID' ";
		$tipos_buscado=" GRUPO DE TRABAJO"; 
			 }
			 elseif(ISSET($_POST["buscar_municipio"])){
			  $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados, demarcacion,seguridad ,interventor FROM $tbn1 where id_municipio=".$_POST['municipio']." ORDER BY 'ID' DESC ";
		$tipos_buscado=" Municipio de ".$nombre_zona. ""; 
			 }
		 else{
		$sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados, demarcacion   FROM $tbn1 where demarcacion=1 ORDER BY 'ID' ";
		$tipos_buscado=" ESTATALES";
			 
		 }
		   

	 
	   }  
	   else  if ($_SESSION['nivel_usu']==3){ //administrador de ccaa -> demarcacion 2
	   
	   if(ISSET($_POST["buscar_prov"])){
		    $id_provincia= fn_filtro_numerico($con,$_POST['id_provincia']);
			 $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados, demarcacion  FROM $tbn1 where demarcacion=3 AND id_provincia=".$id_provincia." ORDER BY 'ID' ";
		$tipos_buscado=" PROVINCIA - ".$id_provincia.""; 
			 
			}
		 elseif(ISSET($_POST["buscar_sub"])){
			 $id_sub= fn_filtro_numerico($con,$_POST['id_sub']);
			 $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados , demarcacion FROM $tbn1 where id_grupo_trabajo=".$id_sub." ORDER BY 'ID' ";
		$tipos_buscado=" GRUPO DE TRABAJO"; 
			 
			 }
		elseif(ISSET($_POST["buscar_municipio"])){
		   $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados, demarcacion,seguridad ,interventor FROM $tbn1 where id_municipio=".$_POST['municipio']." ORDER BY 'ID' DESC ";
		$tipos_buscado=" Municipio ".$nombre_zona. " "; 
			 }
	   else{
		   $id_ccaa= fn_filtro_numerico($con,$_POST['id_ccaa']);
		 $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados, demarcacion  FROM $tbn1 where id_ccaa = ".$_SESSION['id_ccaa_usu']." and demarcacion = 2 ORDER BY 'ID' ";  
	   $tipos_buscado=" AUTONOMICA  -  ".$id_ccaa."";
	   }
		  
		   }
	   else  if ($_SESSION['nivel_usu']==4){ //administardor provincial -> demarcacion  3
		 
		   if(ISSET($_POST["buscar_sub"])){
			   $id_sub= fn_filtro_numerico($con,$_POST['id_sub']);
			  $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados , demarcacion FROM $tbn1 where id_grupo_trabajo=".$id_sub." ORDER BY 'ID' ";
		$tipos_buscado=" GRUPO DE TRABAJO"; 
			 }
			 
			elseif(ISSET($_POST["buscar_municipio"])){
			  $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados, demarcacion,seguridad ,interventor FROM $tbn1 where id_municipio=".$_POST['municipio']." ORDER BY 'ID' DESC ";
		$tipos_buscado=" Municipio ".$nombre_zona. " "; 
			 }
		 else{
			  $id_provincia= fn_filtro_numerico($con,$_POST['id_provincia']);
		$sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados , demarcacion FROM $tbn1 where demarcacion=3 AND id_provincia=".$id_provincia." ORDER BY 'ID' ";
		$tipos_buscado=" PROVINCIA - ".$id_provincia."";
			 
		 }
		   }
		   
	   else {
		   $id_sub= fn_filtro_numerico($con,$_POST['id_sub']);
		   $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados, demarcacion  FROM $tbn1 where id_grupo_trabajo=".$id_sub." ORDER BY 'ID' ";
		$tipos_buscado=" GRUPO DE TRABAJO"; 
		 //  echo $_POST['id_sub'];
		   }
	  
	  
		  ?> 
		 <h1>Votaciones  existentes <?php echo "$tipos_buscado"; ?></h1><br/> 
		 <?php 
//$sql = "SELECT * FROM $tbn1 where id_provincia like '%$ids_provincia%' ORDER BY 'id_provincia' ";
 
$result = mysqli_query($con, $sql);
if ($row = mysqli_fetch_array($result)){
	
	
?>
         
        
<table id="tabla1" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
                        <th width="3%">ID</th>
						<th width="45%">TUTULO</th>
                        <th width="7%">Tipo</th>
						<th width="10%">Tipo votante</th>
                        <th width="10%">presencial/congreso</th>
						<th width="10%">censo completo</th>
						
                        <th width="10%">faltan<br/>votar</th>
                        <th width="10%">Ya han votado</th>
                        <th width="10%">RESULTADS</th>
					</tr>
				</thead>

				<tbody>
            
        <?php

mysqli_field_seek($result,0);

do {

 ?>
		  <tr>
			   <td><?php echo  "$row[0]" ?></td>              
               <td><?php echo  "$row[1]" ?></td>             
               <td><?php //echo  "$row[6]" ?>
               <?php if($row[2]==1){
			  echo"primarias";
		  }
		  else if($row[2]==2){
			  echo"VUT";
		  }
		  else if($row[2]==3){
			  echo"encuesta";
		  }else if($row[2]==4){
			  echo"Debate";
		  }
		  
		  ?></td>
               <td><?php //echo  "$row[7]" ?>
               <?php if($row[3]==1){
			  echo"solo socio";
		  }
		  else if($row[3]==2){
			  echo"socio y simpatizante verificado";
		  }
		  else if($row[3]==3){
			  echo"socio y simpatizante";
		  }else if($row[3]==5){
			  echo"abierta";
		  }
		  
		  ?></td>     
          
          <td><?php 
		 
		 if ($row[6]=="1")
		 
		 {?>
                 <a href="votantes_listado_cong.php?idvot=<?php echo  "$row[0]" ?>&cen=com&lit=si" class="btn btn-primary btn-xs">presencial/congreso</a>
                 <?php }
		  
		  else {?>
                 <a href="votantes_listado_cong.php?idvot=<?php echo  "$row[0]" ?>&cen=com&lit=no" class="btn btn-primary btn-xs">presencial/congreso</a>
               <?php }?></td>             
               
               
          
                   
               <td><?php 
		 
		 if ($row[6]=="1")
		 
		 {?>
                 <a href="votantes_listado_multi.php?idvot=<?php echo  "$row[0]" ?>&cen=com&lit=si" class="btn btn-primary btn-xs">Censo completo</a>
                 <?php }
		  
		  else {?>
                 <a href="votantes_listado_multi.php?idvot=<?php echo  "$row[0]" ?>&cen=com&lit=no" class="btn btn-primary btn-xs">Censo completo</a>
               <?php }?></td>             
               
               <td><?php    if ($row[6]=="1")
		 
		 {?>
                 <a href="votantes_listado_multi.php?idvot=<?php echo  "$row[0]" ?>&cen=fal&lit=si" class="btn btn-primary btn-xs  pull-right">Faltan</a>
                 <?php }
		  
		  else {?>
                 <a href="votantes_listado_multi.php?idvot=<?php echo  "$row[0]" ?>&cen=fal&lit=no" class="btn btn-primary btn-xs  pull-right">Faltan</a>
               <?php }?></td>              
               <td><?php    if ($row[6]=="1")
		 
		 {?>
                 <a href="votantes_listado_multi.php?idvot=<?php echo  "$row[0]" ?>&cen=stn&lit=si" class="btn btn-primary btn-xs">Ya ha votado</a>
                 <?php }
		  
		  else {?>
                 <a href="votantes_listado_multi.php?idvot=<?php echo  "$row[0]" ?>&cen=stn&lit=no" class="btn btn-primary btn-xs">Ya ha votado</a>
               <?php }?></td>

              <td>
              <a href="participacion.php?idvot=<?php echo  "$row[0]" ?>" class= "btn btn-success btn-xs ">participación</a>    
			  <?php
		  
          if($row[5]=="si"){
			 if($row[2]==1){
			 $dir3="../vota_orden/resultados_primarias.php";
		  }
		  else if($row[2]==2){
			  $dir3="../vota_vut/resultados.php";
		  }
		  else if($row[2]==3){
			  $dir3="../vota_encuesta/resultados_encuesta.php";
		  }
		  	 
		
	$activo2="<a href=\"".$dir3."?idvot=".$row[0]."\"  class=\"btn btn-primary btn-xs\">Resultados</a>";
	}
	else{
		$activo2="&nbsp;";
		}
		echo  "$activo2"; ?></td>
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