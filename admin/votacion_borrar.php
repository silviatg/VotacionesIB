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
 $id=fn_filtro_numerico($con,$_GET['id']); 
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
    <link rel="stylesheet" href="../modulos/themes-jquery-iu/base/jquery.ui.all.css">
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
  	 
          
  <div class="alert alert-danger"> 
             <a class="close" data-dismiss="alert">x</a>
             ¡¡¡ATENCION!!! <br/>
             Esta funcion esta no esta activada y 
             no se borraran los datos de condidatos opciones, ni los votos ni la votación
             </div>
 			
              <?php 

  $result=mysqli_query($con,"SELECT * FROM $tbn1 where id=$id");
  $row=mysqli_fetch_row($result);

 ?>
  <h1> VOTACION BORRADA</h1>
              
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method=post name="frmDatos" id="frmDatos"  class="well form-horizontal" >
        
         <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Nombre votación</label>
             
            <div class="col-sm-9">  <?php echo "$row[3]";?>
            </div>
         </div>       
    
    
    <div class="form-group">
    <label for="demarcacion" class="col-sm-3 control-label">Demarcación</label>
    <div class="col-sm-9">
                
                  <?php 
				  
				  if ($row[20]==1){
					 echo "Estatal";
				 }else if ($row[20]==2){
					 echo "Autonomica";					  
				 }else if ($row[20]==3){
					 echo "Provincial";						  
				 }else if ($row[20]==4){				 
					 echo "Grupo Provincial";					  
				 }else if ($row[20]==5){
					 echo "Grupo Autonomico";	
				 }else if ($row[20]==6){
					echo "Grupo provincial";				
				 };		  
				?>

   				 </div>
               </div> 
                  
             
   <div class="form-group">
    <label for="fecha_ini" class="col-sm-3 control-label"> Fecha comienzo</label>
    <div class="col-sm-4">
				  
				  <?php 
				 $fecha_i=date("d-m-Y",strtotime($row[13]));
				  echo "$fecha_i "; ?> -

				<?php 
				
				$hora_i=date("H",strtotime($row[13]));
				echo " $hora_i ";
				  ?>
                  : 
                  <?php $min_i=date("i",strtotime($row[13]));
				 echo " $min_i ";
				  ?>
                  
                  
      		
            </div>
            
          </div>
          
          
                 
               <div class="form-group">
    <label for="fecha_final" class="col-sm-3 control-label">Fecha final </label>
    <div class="col-sm-4"> 
				  
				  <?php
				  $fecha_f=date("d-m-Y",strtotime($row[14]));
				   echo "$fecha_f "; ?>
                  
                  -
                 
					<?php  $hora_f=date("H",strtotime($row[14]));
					echo " $hora_f ";
				  ?> :
                  <?php $min_f=date("i",strtotime($row[14]));
					 echo " $min_f ";
				  ?>
                  </div>
                  </div>
				 
                  
               <div class="form-group">
    <label for="tipo" class="col-sm-3 control-label">Tipo de votación </label>
    <div class="col-sm-9">
               
               
                    <?php   echo "$row[6] | "; 
						
					  if($row[6]==1){
						  echo "PRIMARIAS";
					  }
					  else if($row[6]==2){
						  echo "VUT";
					  }
					  else if($row[6]==3){
						  echo "ENCUESTA";
					  }else if($row[6]==4){
						  echo "DEBATE";
						 
					  } ?>
                              
                     </div>
                   </div>
                   
                   
                   <div class="form-group">
    <label for="tipo_usuario_0" class="col-sm-3 control-label"> Tipo de votante </label>
    <div class="col-sm-9">
                  
                   
                         <?php 
						 
						 
						 if ($row[7]==1){
					 echo " Solo socios (1)";
				 }else if ($row[7]==2){
					 echo"  Socios y simpatizantes verificados (2) ";
					
				 }else if ($row[7]==3){
					  echo " Socios y simpatizantes (3)";
					   
				 }else if ($row[7]==5){
					 echo"Abierta (5) ";
				 } 
				 
				 ?>
                        
                      
                  </div>
                  </div>  
                    
                    
    <div class="form-group">
    <label for="tipo_usuario_0" class="col-sm-3 control-label">Estado</label>
    <div class="col-sm-9">
    
    
                      <?php if ($row[2]=="si"){
					  echo "Activado";
				 }else {
					echo "Desactivado";
				 };?>
                    
                    
                    
                    
                    
                 
                  
                  </div>
                  </div>
                   <div id="accion_opciones" <?php echo "$display_debate"; ?> > 
                  
                  
                  <div class="form-group">
    <label for="tipo_seg" class="col-sm-3 control-label">Seguridad de control de voto</label>
    <div class="col-sm-9">
    
    
                   <?php
					
					 if ($row[21]==1){
					 echo" Sin trazabilidad ni interventores(1)";
					 }else if ($row[21]==2){
						echo"  comprobacion de voto(2)";
					 }else if ($row[21]==3){
						echo " Con interventores (3)";	
					 }
					 else if ($row[21]==4){
						 echo "Con comprobacion de voto e interventores (4)";
					 }			 
				 ?>
                         
                          
                          </div>
                        </div>
                          
                          
                          <div class="form-group">
    <label for="numero_opciones" class="col-sm-3 control-label">Numero de opciones que se pueden votar </label>
    <div class="col-sm-9">
                  
                 <?php echo "$row[8]";?>
                        
                  </div>  
                    </div>
                    
                    <div class="form-group">
    <label for="resumen" class="col-sm-3 control-label">Resumen</label>
    <div class="col-sm-9">
    
    <?php echo "$row[5]"; ?>

		
                    </div>
                  </div>
                    
                    <div class="form-group">
    <label for="texto" class="col-sm-3 control-label">Texto</label>
    <div class="col-sm-9">
     
        <?php echo "$row[4]"; ?>
	
		
                      <br />
                      <br />
                    
                                       </div>
                                       </div>
                                       
               
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
--><?php 
//$borrado = mysql_query ("DELETE FROM $tbn1 WHERE id='$_GET[id]' ") or die("No puedo ejecutar la instrucción de borrado SQL query");
?>
   <?php  include("../votacion/ayuda.php"); ?>
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
   <script src="../js/jquery-1.9.0.min.js"></script>
	
    <script type='text/javascript' src='../js/admin_funciones.js'></script>

  </body>
</html>