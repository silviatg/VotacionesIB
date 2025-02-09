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
//$id_provincia=$_SESSION['localidad'];
//$tipo_user=$_SESSION['tipo_votante'];

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
        <h2> Mis grupos de trabajo</h2>


				<?php 
                $sql="SELECT a.ID ,a.subgrupo,a.tipo_votante, a.id_provincia, a.tipo, b.estado, b.admin, a.texto,a.id_ccaa FROM $tbn4 a,$tbn6 b where (a.ID= b.id_grupo_trabajo) and b.id_usuario=".$_SESSION['ID']." order by a.tipo";
                $result = mysqli_query($con,$sql);
                if ($row = mysqli_fetch_array($result)){
                ?>
                   <div class="panel-group" id="accordion">

				<?php
                mysqli_field_seek($result,0);
                do {
                ?>      
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo  "$row[0]" ?>">
                              <?php echo  "$row[1]" ?>
                            </a>
                          </h4>
                        </div>
                        <div id="<?php echo  "$row[0]" ?>" class="panel-collapse collapse ">
                          <div class="panel-body">
                           
          <?php if($row[4]==2){
			  $optiones2=mysqli_query($con,"SELECT  ccaa FROM $tbn3 where ID=$row[8]");
     			$row_prov2=mysqli_fetch_row($optiones2);
		 		 echo "Grupo CCAA -" .utf8_encode($row_prov2[0]);
					}
		 		else if($row[4]==3){
			 echo "Grupo Estatal";
				 }
		 else{
			 $optiones2=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$row[3]");
     		$row_prov2=mysqli_fetch_row($optiones2);
		  echo "Grupo provincial -". utf8_encode($row_prov2[0]);}
		  ?>
                        <div class="derecha">
                        <?php  if ($row[6]== 0 ){  // si esta apuntado pero no es admin
                            if ($row[5]== 0 ){  // si esta esperando aprobacion ?>
                        Pendiente de acceso
                        <?php			}	else if ($row[5]== 1 ){ //si ya esta aprobado ?>
                        <a href="../votacion/votaciones_grupo.php?idgr=<?php echo $row[0] ; ?>" >	Acceder </a>
                        <?php		}	else if ($row[5]== 3 ){ //si esta bloqueado ?>
                        No tiene ecceso, si quiere volver a acceder hable con el administrador
                        <?php		}
                        }else if ($row[6]== 1 ) { //si es admin?>
                      <a href="../votacion/votaciones_grupo.php?idgr=<?php echo $row[0] ; ?>" > Accede  Administrador </a>
                        <?php	} ?>
                        <br /> </div>
                        
            <?php echo  "$row[7]" ?>
            
            
                          </div>
                        </div>
                      </div>
                      
    
					<?php
                    }
                    while ($row = mysqli_fetch_array($result));
                    ?>                    
                 </div>
                    <?php 
                    } else {
                    echo " ¡No se ha encontrado ningún grupo! ";
                    }
                    ?>       
        
        
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        
       </div>
      
  </div>
 

  <div id="footer" class="row">
   <?php  include("../votacion/ayuda.php"); ?>
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>   
   
    <script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
  </body>
</html>