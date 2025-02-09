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
?>
<?php 
include ('../basicos_php/basico.php');
if(ISSET($_POST["desactivar"])){
	
$activo="no";
$id=fn_filtro_numerico($con,$_POST["id"]);
$sSQL="UPDATE $tbn1 SET activa=\"$activo\" WHERE id=".$id."";
mysqli_query($con,$sSQL)or die ("Imposible modificar");
}

if(ISSET($_POST["activar"])){
$activo="si";	
$id=fn_filtro_numerico($con,$_POST["id"]);
$sSQL="UPDATE $tbn1 SET activa=\"$activo\" WHERE id=".$id."";
                              
mysqli_query($con,$sSQL)or die ("Imposible modificar");
}

//////////////////////////////
if(ISSET($_POST["desactivar_resultados"])){
$activar="no";
$id=fn_filtro_numerico($con,$_POST["id"]);
$sSQL="UPDATE $tbn1 SET activos_resultados=\"$activar\" WHERE id=".$id."";
mysqli_query($con,$sSQL)or die ("Imposible modificar");
}

if(ISSET($_POST["activar_resultados"])){
$activar="si";
$id=fn_filtro_numerico($con,$_POST["id"]);
$sSQL="UPDATE $tbn1 SET activos_resultados=\"$activar\" WHERE id=".$id."";                        
mysqli_query($con,$sSQL)or die ("Imposible modificar");
}

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
		 $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados,seguridad,interventor  FROM $tbn1 where demarcacion=2 AND id_ccaa=".$_POST['id_ccaa']." ORDER BY 'ID' DESC ";
		$tipos_buscado=" AUTONOMICA  -  ".$nombre_zona."";
		
		 }
		 elseif(ISSET($_POST["buscar_prov"])){
			 $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados,seguridad,interventor  FROM $tbn1 where demarcacion=3 AND id_provincia=".$_POST['id_provincia']." ORDER BY 'ID' DESC";
		$tipos_buscado=" PROVINCIA -  ".$nombre_zona.""; 
			 
			}
		 elseif(ISSET($_POST["buscar_sub"])){
			  $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados,seguridad ,interventor FROM $tbn1 where id_grupo_trabajo=".$_POST['id_sub']." ORDER BY 'ID' DESC ";
		$tipos_buscado=" GRUPO DE TRABAJO"; 
			 }
		elseif(ISSET($_POST["buscar_municipio"])){
			  $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados,seguridad ,interventor FROM $tbn1 where id_municipio=".$_POST['municipio']." ORDER BY 'ID' DESC ";
		$tipos_buscado=" Municipio de ".$nombre_zona. ""; 
			 }
		 else{
		$sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados,seguridad,interventor   FROM $tbn1 where demarcacion=1 ORDER BY tipo  DESC ";
		$tipos_buscado=" ESTATALES";
			 
		 }
		   

	 
	   }  
	   else  if ($_SESSION['nivel_usu']==3){ //administrador de ccaa -> demarcacion 2
	   
	   if(ISSET($_POST["buscar_prov"])){
			 $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados,seguridad  FROM $tbn1 where demarcacion=3 AND id_provincia=".$_POST['id_provincia']." ORDER BY 'ID' ";
		$tipos_buscado=" PROVINCIA  - ".$nombre_zona.""; 
			 
			}
		 elseif(ISSET($_POST["buscar_sub"])){
			 $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados,seguridad  FROM $tbn1 where id_grupo_trabajo=".$_POST['id_sub']." ORDER BY 'ID' ";
		$tipos_buscado=" GRUPO DE TRABAJO"; 
			 
			 }
		elseif(ISSET($_POST["buscar_municipio"])){
			  $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados,seguridad ,interventor FROM $tbn1 where id_municipio=".$_POST['municipio']." ORDER BY 'ID' DESC ";
		$tipos_buscado=" Municipio ".$nombre_zona. " "; 
			 }
	   else{
		 $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados,seguridad  FROM $tbn1 where id_ccaa = ".$_SESSION['id_ccaa_usu']." and demarcacion = 2 ORDER BY 'ID' ";  
	  $tipos_buscado=" AUTONOMICA  -  ".$nombre_zona."";
	   }
		  
		   }
	   else  if ($_SESSION['nivel_usu']==4){ //administardor provincial -> demarcacion  3
		 
		   if(ISSET($_POST["buscar_sub"])){
			  $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados,seguridad  FROM $tbn1 where id_grupo_trabajo=".$_POST['id_sub']." ORDER BY 'ID' ";
		$tipos_buscado=" GRUPO DE TRABAJO"; 
			 }
		elseif(ISSET($_POST["buscar_municipio"])){
			  $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados,seguridad ,interventor FROM $tbn1 where id_municipio=".$_POST['municipio']." ORDER BY 'ID' DESC ";
		$tipos_buscado=" Municipio ".$nombre_zona. " "; 
			 }
		 else{
		$sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados,seguridad  FROM $tbn1 where demarcacion=3 AND id_provincia=".$_POST['id_provincia']." ORDER BY 'ID' ";
		$tipos_buscado=" PROVINCIA - ".$nombre_zona."";
			 
		 }
		   }
		   
	   else {
		   $sql = "SELECT  ID , nombre_votacion,tipo, tipo_votante, activa, activos_resultados,seguridad  FROM $tbn1 where id_grupo_trabajo=".$_POST['id_sub']." ORDER BY 'ID'  ";
		$tipos_buscado=" GRUPO DE TRABAJO"; 
		  // echo $_POST['id_sub'];
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
						<th width="10%">estado</th>
						
                        <th width="15%">candidatos</th>
                        <th width="10%">&nbsp;</th>
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
			 
			  if($_SESSION['usuario_nivel']==0){
			    echo "<br/><a href=\"preguntas_busq1.php?idvot=".$row[0]."\"  class=\"btn btn-warning btn-xs\">Relanzar recuento</a>";
			  }
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
               <td>
              
         
          <form id="form_<?php echo $row[0]; ?>" name="form_<?php echo $row[0]; ?>" method="post" action="">
         
         
            <?php
		  
          if($row[4]=="no"){?>
          <input type="submit" name="activar" id="activar" value="activar" class="btn btn-primary btn-xs"/>
			<?php }
				else { ?>
	 <input type="submit" name="desactivar" id="desactivar" value="desactivar"  class="btn btn-success btn-xs" />
		
	<?php }
		 ?> 
         
         
         
         <?php ////metemos dependiendo de el tipo de votacion un campo oculto 
		 
		  if(ISSET($_POST["buscar_ccaa"])){  
		echo "<input name=\"buscar_ccaa\" type=\"hidden\" id=\"buscar_ccaa\" value=\"buscar\" />";
		 }
		 elseif(ISSET($_POST["buscar_prov"])){
		echo "<input name=\"buscar_prov\" type=\"hidden\" id=\"buscar_prov\" value=\"buscar\" />";	 
			}
		 elseif(ISSET($_POST["buscar_sub"])){
		echo "<input name=\"buscar_sub\" type=\"hidden\" id=\"buscar_sub\" value=\"buscar\" />";
		 }
		  elseif(ISSET($_POST["buscar_municipio"])){
		echo "<input name=\"buscar_municipio\" type=\"hidden\" id=\"buscar_municipio\" value=\"buscar\" />";
		 }
		 else{
			 
		 } 
		 ?>
            
			<input name="id_ccaa" type="hidden" id="id_ccaa" value="<?php echo $_POST['id_provincia']; ?>" />
            <input name="id_ccaa" type="hidden" id="id_ccaa" value="<?php echo $_POST["id_ccaa"]; ?>" />
            <input name="id_sub" type="hidden" id="id_sub" value="<?php echo $_POST["id_sub"]; ?>" />
            <input name="municipio" type="hidden" id="id_sub" value="<?php echo $_POST["municipio"]; ?>" />
            <input name="id" type="hidden" id="id" value="<?php echo $row[0]; ?>" />

 
 
 
 

		  <?php
		   if($row[2]==4){ echo " <br/> <span class=\"label label-warning\">debate<spam>"; }
		   else{
		  
          if($row[5]=="no"){?>
	 <input type="submit" name="activar_resultados" id="activar_resultados" class="btn btn-primary btn-xs" value="activar resultados" />
	<?php }
	else { ?>
	 <input type="submit" name="desactivar_resultados" id="desactivar_resultados"class="btn btn-success btn-xs" value="desactivar resultados" />
	
	<?php }
		   }
		 ?> 
          </form>
    
   
               
               
            </td>             
               
               <td>
               
               
<table width="100%" border="0">
  <tr>
    <th scope="row"><?php if($row[2]==4){ ?>
      <a href="preguntas.php?idvot=<?php echo  "$row[0]" ?>" class="btn btn-primary btn-xs">Añadir preguntas</a>
      <?php  } else {?>
      <a href="candidatos.php?idvot=<?php echo  "$row[0]" ?>" class="btn btn-primary btn-xs" >añadir candidatos</a>
    <?php }?></th>
  </tr>
  <tr>
    <th scope="row"><?php if($row[2]==4){ ?>
      <a href="preguntas_busq1.php?idvot=<?php echo  "$row[0]" ?>"  class="btn btn-primary btn-xs">Modificar preguntas</a>
      <?php  } else {?>
      <a href="candidatos_busq1.php?idvot=<?php echo  "$row[0]" ?>" class="btn btn-primary btn-xs">gestionar candidatos</a>
      <?php }?>    </th>
  </tr>
</table>
               
               </td>              
               <td>
               
               <table width="100%" border="0">
  <tr>
    <th scope="row">
    <a href="votacion.php?id=<?php echo  "$row[0]" ?>&acc=modifika" class="btn btn-primary btn-xs">modificar</a>
    
    </th>
  </tr>
  <tr>
    <th scope="row">
      
		  <a href=votacion_borrar.php?id=<?php echo"$row[0]"; ?> class="btn btn-danger btn-xs" onClick="return borrarevento()">borrar</a>
    
    </th>
  </tr>
  <?php  if($row[6]==3 or $row[6]==4 or $row[7]=="si"){
			 ?> 
			  <tr>
    <th scope="row">
			  <a href="interventor_busq1.php?idvot=<?php echo"$row[0]"; ?>" class="btn btn-primary btn-xs">Gestionar interventores</a>
			  </th>
  </tr>
			<?php
            }
            ?>
    
</table>
               
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