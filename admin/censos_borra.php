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
$nivel_acceso=2; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
include ('../basicos_php/basico.php');

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
                   
          <h1>BORRARDO AFILIADOS/SIMPATIZANTE</h1>
            <p>&nbsp;</p>
			<!----> 
           <?php 
  $result=mysqli_query($con,"SELECT ID, 	id_provincia, 	nombre_usuario, 	apellido_usuario, 	nivel_usuario, 	nivel_acceso, 	correo_usuario, 	nif, 	id_ccaa, 	pass, 	tipo_votante ,	usuario, 	
bloqueo, 	razon_bloqueo  FROM $tbn9 where id=$id");
  $row=mysqli_fetch_row($result);

 ?>  <form  class="well form-horizontal" >
          

              <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Nombre y apellidos</label>
             
            <div class="col-sm-9">   
                  <?php echo "$row[2]";?>
                  </div></div>
                
                 <div class="form-group">       
               <label for="correo" class="col-sm-3 control-label">Correo electronico</label>
             
            <div class="col-sm-9"> <?php echo "$row[6]";?>
			</div></div>
                   
                   <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label"> Nif </label>
             
            <div class="col-sm-4">    <?php echo "$row[7]";?>
                   </div></div>
                
                
              <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">provincia: </label>
             
            <div class="col-sm-9"> 
                
				  <?php 
						$options = "select DISTINCT id, provincia from $tbn8  order by ID";
						$resulta = mysqli_query($con, $options) or die("error: ".mysql_error($con));
						
						while( $listrows = mysqli_fetch_array($resulta) ){ 
						$id_pro = $listrows[id];
						$name1 = utf8_encode($listrows[provincia]);
						
						if ($id_pro==$row[1]){
						echo "$row[1]";
						}
							}
					 ?>
                    
                  </div></div>
                  
                 
              <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Tipo </label>
             
            <div class="col-sm-9"> 

                        <?php if ($row[10]==1){
				echo "socio";
					  
				 }else if ($row[10]==2){
			echo "	simpatizante verificado	";
					  
				 }else{
				echo" simpatizante";  
				 }
				?>
                     
                  </div></div>
                  
                  
           
              <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Bloqueado </label>
             
            <div class="col-sm-9">     
                  
                  
                        <?php if ($row[12]=="si"){
					 		echo " SI  ";
						 }else {
						 echo  "NO";  			  
						 } 
						?>
                        
                        
                     </div></div>
                   <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Razón Bloqueo </label>
            
            <div class="col-sm-9"><?php echo "$row[13]";?>
             </div></div> 
                  <p>&nbsp;</p>    
             </form>
               
               
   
<?php 
$borrado = mysqli_query ($con,"DELETE FROM $tbn9 WHERE id=".$_GET[id]."") or die("No puedo ejecutar la instrucción de borrado SQL query");
echo "<div class=\"alert alert-danger\">El registro ha sido borrado</div>";

?>
            <p>&nbsp;</p>
              
    
                    
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
  </body>
</html>