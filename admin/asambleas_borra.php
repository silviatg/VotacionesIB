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

include("../basicos_php/basico.php") ;

$idvas=fn_filtro_numerico($con,$_GET['idvas']); 

 
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
          <?php 
			  
  $result=mysqli_query($con,"SELECT * FROM $tbn4 where ID=$idvas");
  $row=mysqli_fetch_row($result);
			  
			  ?>         
          
<h1> BORRADA ASAMBLEA O GRUPO DE TRABAJO</h1>
		  
 <form class="well form-horizontal">
              <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Nombre </label>
             
            <div class="col-sm-9"><?php echo "$row[2]";?>
              
              </div></div>
      
             <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">TIPO</label>
             
            <div class="col-sm-9">
             <?php
				  if ($row[1]==1){
					  
					  echo "Provincial  |   $row[4]";
				 }else if ($row[1]==2){
					  
					  echo " Autonomico |  $row[5]";
				 }else if ($row[1]==3) {
					 echo "Estatal";
					   
				 }
				 
				
				 ?>
		   </div></div>
                   
             <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Forma de acceso al grupo</label>
             
            <div class="col-sm-9">
                   <?php if ($row[7]==1){
					 echo" Abierto (no necesita validación para suscribirse) ";
					  
				 }else {
					 
					  echo" Cerrado (necesita que los administradores validen el acceso) ";
				 }
				 
				
				 ?>
                      
                   </div></div>
                   
              <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Activo  </label>
             
            <div class="col-sm-9">
                   <?php if ($row[8]==2){
					 echo" No ";
					  
				 }else {
					 
					  echo" Si  ";
				 }
				 
				
				 ?>
                   
                   
                    </div></div>
                
                
                   
                   
                   
                   <div class="form-group">       
             <label for="Sexo" class="col-sm-3 control-label">TIPO DE VOTANTE</label>
             <div class="col-sm-9">
              <?php if ($row[10]==5){
					 echo" Abierta (5)  ";			  
				 }else if ($row[10]==2){
					 echo"Socios y simpatizantes verificados(2) ";
				 }else if ($row[10]==3){
					 echo" Socios y simpatizantes (3) ";		  
				 }else { 
					echo" Solo socios (1) ";
				 } ?>
            
             </div></div>
                    
                    <div class="form-group">   
                    
             <label for="nombre" class="col-sm-3 control-label" >Texto</label>
               <div class="col-sm-9">  
            
                  <?php echo "$row[6]"; ?>
   
                   </div></div>
              <p>&nbsp;</p>     
              
               <?php 
$borrado1 = mysqli_query ($con,"DELETE FROM $tbn4 WHERE id=".$_GET[idvas]."") or die("No puedo ejecutar la instrucción de borrado SQL query");
if (! $borrado1) {
  echo "<div class=\"alert alert-warning\">Error en el borrado asamblea o grupo de trabajo</div>";
} elseif (mysqli_affected_rows($con) == 0) {
  echo "<div class=\"alert alert-warning\">Error en el borrado asamblea o grupo de trabajo</div>";
} else {
 echo "<div class=\"alert alert-success\">Borrada asamblea o grupo de trabajo</div>"; 
}



$borrado2 = mysqli_query ($con,"DELETE FROM $tbn6 WHERE id_grupo_trabajo=$_GET[idvas]") or die("No puedo ejecutar la instrucción de borrado SQL query");

if (! $borrado2) {
  echo "<div class=\"alert alert-warning\">No se ha podido borrar relacion de usuarios de esta asamblea o grupo de trabajo.</div>";
} elseif (mysqli_affected_rows($con) == 0) {
  echo "<div class=\"alert alert-warning\">No se ha podido borrar a relacion de usuarios de esta asamblea o grupo de trabajo</div>";
} else {
 echo "<div class=\"alert alert-success\">Borrada relacion de usuarios de esta asamblea o grupo de trabajo</div>"; 
}


$borrado3 = mysqli_query ($con,"DELETE FROM $tbn1 WHERE id_grupo_trabajo=$_GET[idvas]") or die("No puedo ejecutar la instrucción de borrado SQL query");
if (! $borrado3) {
  echo "<div class=\"alert alert-warning\">No se han podido borrar  votaciones de esta asamblea o grupo de trabajo</div>";
} elseif (mysqli_affected_rows($con) == 0) {
  echo "<div class=\"alert alert-warning\">No se han podido borrar  votaciones de esta asamblea o grupo de trabajo</div>";
} else {
 echo "<div class=\"alert alert-success\">Borradas votaciones de esta asamblea o grupo de trabajo</div>";
}


/*faltaria borrar los candidatos de esta votacion y ademas todos los votos y otras cosas relacionadas */
 ?>   
                    </form> 
                   
      
      
      </div>
		</div>
	  
  
    
                    
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
       <script src="../modulos/ui/jquery-ui.custom.js"></script>
   <script src="../js/jqBootstrapValidation.js"></script>
	<script type='text/javascript' src='../js/admin_funciones.js'></script>
  
	  
  </body>
</html>