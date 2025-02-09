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
$nivel_acceso=7; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}

$id=$_GET['id'];
$idvot=$_GET['idvot'];



///////////////////////  fin de la subida de imagenes


  $result=mysqli_query($con,"SELECT * FROM $tbn7 where id=$id");
  $row=mysqli_fetch_row($result);


//////////////////// miramos si se puede borrar y la borramos ene se caso
$sql3 = "SELECT tipo FROM $tbn1 WHERE ID='$idvot'";
$resulta3 = mysqli_query($con, $sql3) or die("error: ".mysqli_error());
	while( $listrows3 = mysqli_fetch_array($resulta3) ){ 	
	$tipo = $listrows3[tipo];
} 

if ($tipo !=2){
$borrado = mysqli_query ($con,"DELETE FROM $tbn7 WHERE id=$_GET[id]") or die("No puedo ejecutar la instrucción de borrado SQL query");

$inmsg="<div class=\"alert alert-danger \"> ¡¡El registro ha sido borrado!!</div>";
}
else{
	
$inmsg= "<div class=\"alert alert-danger \"> Este candidato esta en una votacion tipo VUT y no puede ser borrado</div>";
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
                   <a href="candidatos_busq1.php?idvot=<?php echo "$idvot"; ?>" class="btn btn-primary pull-right">Buscar en el directorio para modificar o borrar candiatos en esta encuesta</a>   
                    
        <?php if ($row_vot[2]==3 or $row_vot[2]==4 ){?> 
         <a href="interventor.php?idvot=<?php echo "$idvot"; ?>"  class="btn btn-primary pull-right"> Incluir  interventores</a>  
        <?php   }?>
      <p>&nbsp;</p><p>&nbsp;</p>
      
              <h1>BORRADO de OPCION O CANDIDATO</h1>
            <p>&nbsp;</p>
			<!---->
            
            
    


<?php echo "$inmsg";?> 


 
<form action="<?php $_SERVER['PHP_SELF'] ?>" method=post   name="frmDatos" id="frmDatos"  class="well form-horizontal">
 

  <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Nombre </label>
             
            <div class="col-sm-9">
			<?php echo "$row[3]";?>
				
                </div>
                </div>
                
                
                 <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Sexo</label>
             
            <div class="col-sm-9">
                   
                   <?php if ($row[4]=="H"){
					echo "Neutro ( sin opcion de sexo) ";		  
				 }else if ($row[4]=="M"){
					echo "Hombre ";	  
				 }else {
					echo "Mujer ";
				 }
				 ?>
                   
                </div>
                </div>
                
             <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Imagen </label>
             
            <div class="col-sm-9">    
            
            
               <?php if($row[12]=="" ){
				   echo " No tiene imagen asociada";
				   }else{ 
             ////si en la BBDD si hay fotos
		$thumb_photo_exists=$upload_cat."/".$row[12];

		if (file_exists($thumb_photo_exists)) {
				unlink($thumb_photo_exists);
				}
				echo "Borrada imagen : ".$row[12]." ";
			}?>
             
               
              </div>
              </div>     
                
 <div class="form-group">  
  <label for="nombre" class="col-sm-3 control-label">Texto</label>
               <div class="col-sm-19">          
			 <?php echo "$row[2]"; ?>


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