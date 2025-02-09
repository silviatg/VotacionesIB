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
<?php if ($mostrar_todas_opciones=="S") { //STG: Quitamos esta funcionalidad hasta que introduzcamos los cambios para Imagina. ?>
			<ul><li><a href="censos_add_mas.php">incluir de forma masiva</a></li>
<?php } ?>
            
            <li><a href="censos.php">incluir un votante</a>
            </li></ul>
            <br/>
			<h1>BUSCAR  EN EL CENSO DE VOTANTES</h1>
			<br/>
			<!---->

		<div><i>Para la búsqueda, no es necesario teclear los campos completos. Se encontrarán todas las personas que contengan el valor buscado. </i><br/></div>
			
      <form id="form1" name="form1" method="post" action="censos_busq.php" class="well form-horizontal">
        
        <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Nombre </label>
             
            <div class="col-sm-9">
            <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control"/>
            
            </div></div>
            <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Correo electronico  </label>
             
            <div class="col-sm-9">
            <input type="text" name="correo_electronico" id="correo_electronico" class="form-control"/>
            </div></div>
			
			
            <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Nif</label>
             
            <div class="col-sm-4">
          
            <input type="text" name="nif" id="nif" class="form-control"/>
            </div></div>
			
			
            <div class="form-group">       
				<label for="nombre" class="col-sm-3 control-label">Teléfono</label>             
				<div class="col-sm-4">          
				<input type="number" name="tfno" id="tfno" class="form-control"/>
            </div></div>			
			
			
            <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label"> Tipo usuario </label>
             
            <div class="col-sm-9">
          
            <input name="tipo_usuario" type="radio" id="tipo_usuario_3" checked="checked" /> 
                  todos <br/>

			<input name="tipo_usuario" type="radio" id="tipo_usuario_0" value="1" />
solo socios (1) <br/>

				 
                  <input type="radio" name="tipo_usuario" value="2" id="tipo_usuario_1" />
                  socios y simpatizantes verificados (2) <br/>
                  
                  <input type="radio" name="tipo_usuario" value="3" id="tipo_usuario_4" />
socios y simpatizantes (3)<br/>

				<input type="radio" name="tipo_usuario" value="4" id="tipo_usuario_2" />
                  Abierta (3) 
                  
                  </div></div>
                  <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Provincia</label>
             
            <div class="col-sm-9">
                  
                  
				  <?php 
				  
				 if($_SESSION['id_provincia']==00){ 
				  
				  
							 
							 // listar para meter en una lista del cuestionario buscador


	$options = "select DISTINCT id, provincia from $tbn8  order by ID";
	$resulta = mysqli_query($con, $options) or die("error: ".mysqli_error($con));
	
	while( $listrows = mysqli_fetch_array($resulta) ){ 
	$id_pro = $listrows[id];
	$name1 =utf8_encode($listrows[provincia]);
	$lista1 .="<option value=\"$id_pro\"> $name1</option>"; 
	
}
							 ?>
                    <div align="left">
     <select name="id_provincia" class="form-control"id="id_provincia" >
	 <option value="">Escoja una provincia</option>
	 
	 <?php echo "$lista1";?></select>
                    </div>
                    
                    <?php }
		  else {
			  ?>
              <input name="id_provincia" type="hidden" id="id_provincia" value="<?php echo "$ids_provincia"; ?>" /><?php echo "$ids_provincia"; ?><?php 	  
		  }?>
          
          </div></div>
          <input type="submit" name="buscar" id="buscar" value="Buscar"  class="btn btn-primary pull-right"  />
         <br/><br/>
      </form>
      
                
    
                    
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
  
  </body>
</html>