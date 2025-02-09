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
$id_provincia=$_SESSION['localidad'];
$tipo_user=$_SESSION['tipo_votante'];

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
        

        
        
        <div class="col-md-2 sidebar-offcanvas" id="sidebar" role="navigation">
          <div class="list-group">
          <?php  include("../votacion/menu_nav.php"); ?>
            
          </div>
        </div> 
       
        
        
        <div class="col-md-10">
       <?php


 $sql_grupo=mysqli_query($con,"SELECT subgrupo,texto FROM $tbn4 where ID=".$_GET['idgr']." ");
	 $row_grupo=mysqli_fetch_row($sql_grupo);?>
     
    

    
  	<h3>   <?php echo $row_grupo[0]; ?> </h3>
    <p>   <?php echo $row_grupo[1]; ?> </p>
    
      <p><a data-toggle="modal"  href="../votacion/ver_grupo.php?idgr=<?php echo $_GET['idgr']?>" data-target="#apuntarme"  class="btn btn-info pull-right">ver miembros de este grupo</a></p>
      <p>&nbsp;</p><p>&nbsp;</p>
        <?php 
/////hay que sacar datos del grupo
$esta_activa="si";
$sql = "SELECT * FROM $tbn1 where id_grupo_trabajo =".$_GET['idgr']." and tipo_votante >=".$_SESSION['tipo_votante']." and activa like '$esta_activa' ORDER BY  ID  DESC ";
$result = mysqli_query($con, $sql);
if ($row = mysqli_fetch_array($result)){
	
	
?>
      
      <div class="panel-group" id="accordion">

		<?php
                mysqli_field_seek($result,0);
                do {
                ?>      <?php
		  
		  $hoy=strtotime(date('Y-m-d')); 
		  $fecha_ini=strtotime($row[13]);
		  $fecha_fin=strtotime($row[14]);
		  $fecha_ini_ver=date("d-m-Y", strtotime($row[13]));
		  $fecha_fin_ver=date("d-m-Y", strtotime($row[14]));
		  $hoy=strtotime(date('Y-m-d H:i')); 
		  $hora_ini_ver=date("H:i", strtotime($row[13]));
		  $hora_fin_ver=date("H:i", strtotime($row[14]));
		 
		  
          if($row[2]=="no"){
	$activo="Votacion NO activa";
	}
	else  if($fecha_ini <=$hoy && $fecha_fin >=$hoy   ){
		$id_votante=$_SESSION['ID'];
	$id_votacion=$row[0];	
		$conta_vot="SELECT id FROM $tbn2 WHERE id_votacion like \"$id_votacion\" and id_votante='$id_votante' ";

$result_cont_vot=mysqli_query($con,$conta_vot);
$quants_vot=mysqli_num_rows($result_cont_vot);
	
	if ($quants_vot != ""){
$activo="Ya ha votado ";
         
}
	else{
		
		
		 if($row[6]==1){
			 $dir="../vota_orden/voto_primarias.php";
			  $texto1_activo="Votacion ABIERTA";
			 $texto2_activo="Votacion CERRADA";
			 $image_activo="comments.png";
		  }
		  else if($row[6]==2){
			  $dir="../vota_vut/vut.php";
			   $texto1_activo="Votacion ABIERTA";
			 $texto2_activo="Votacion CERRADA";
			 $image_activo="comments.png";
		  }
		  else if($row[6]==3){
			  $dir="../vota_encuesta/vota_encuesta.php";
			   $texto1_activo="DEBATE ABIERTO";
			 $texto2_activo="Votacion CERRADA";
			 $image_activo="comments.png";
		  }else if($row[6]==4){
			  $dir="../debate/debate.php";
			  $texto1_activo="DEBATE ABIERTO";
			 $texto2_activo="Votacion CERRADA";
			 $image_activo="comments.png";
		  }
		  
		 
	$activo1="$texto1_activo <img src=\"../imagenes/$image_activo\" width=\"20\" height=\"20\" alt=\"Votacion activa\" />";	
	$activo="<a href='$dir?idvot=$row[0]'  class=modify>$texto1_activo</a>";
    
	
	}
	}else{
		if($row[4]==1){			 
			 $texto1_activo="Votacion NO activa";
			 $texto2_activo="Votacion NO activa";
		  }
		  else if($row[4]==2){
			 $texto1_activo="Votacion NO activa";
			 $texto2_activo="Votacion NO activa";
		  }
		  else if($row[4]==3){
			 $texto1_activo="Votacion NO activa";
			  $texto2_activo="Votacion NO activa";
		  }else if($row[4]==4){
			  $dir="../debate/debate.php";
			 $texto1_activo="DEBATE CERRADO <img src=\"../imagenes/comments.png\" width=\"20\" height=\"20\" alt=\"Votacion activa\" />";
			  $texto2_activo="<a href='$dir?idvot=$row[0]'  class=modify>DEBATE CERRADO</a>";
		
		  }
		
	$activo1=$texto1_activo;
	$activo=$texto2_activo;		
	}
		 ?>
         <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo  "$row[0]" ?>">
                              <?php echo  $row[3] ?>
                            </a> 
                            <div class="derecha"> <?php echo  "$activo"; ?></div> 
                          </h4>
                        </div>
                        <div id="<?php echo  "$row[0]" ?>" class="panel-collapse collapse ">
                          <div class="panel-body">
                           
          Tipo de votacion : 
      <?php if($row[6]==1){
			  echo"primarias";
		  }
		  else if($row[6]==2){
			  echo"VUT";
		  }
		  else if($row[6]==3){
			  echo"encuesta";
		  }
		  
		  ?>
            <div class="derecha">
		 Estado de la votación :
		  <?php echo  "$activo";
		 ?></div>
                        
             <?php
		  
          if($row[15]=="si"){	
		 if($row[6]==1){
			 $dir_a_1="../vota_orden/resultados_primarias.php";
		  }
		  else if($row[6]==2){
			  $dir_a_1="../vota_vut/dcresults.php";
		  }
		  else if($row[6]==3){
			  $dir_a_1="../vota_encuesta/resultados_encuesta.php";
		  }
		  	 
		
	$activo_a_1="<li><a href='$dir_a_1?idvot=$row[0]'  class=modify>Resultados</a></li>";
	
	
	}
	else{
		$activo_a_1="&nbsp;";
		}
		echo  "$activo_a_1"; ?>
        
       <br/> 
 Comienzo de la votación :Desde las <?php echo $hora_ini_ver; ?> del dia <?php echo $fecha_ini_ver;?> 
<br/> Final de la votación :Hasta las <?php echo $hora_fin_ver; ?> del dia <?php echo $fecha_fin_ver;?>  
<br/>
<?php echo $row[5] ?>
            
            
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
                    echo " ¡No se ha encontrado ninguna votación! ";
                    }
                    ?>       
        
        
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        
       </div>
      
  </div>
     <!--
===========================  modal para ver quien esta en el grupo
-->
<div class="modal fade" id="apuntarme" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           
            <div class="modal-body"></div>
            
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

 <!--
===========================  FIN modal para ver quien esta en el grupo
-->

  <div id="footer" class="row">
   <?php  include("../votacion/ayuda.php"); ?>
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>   
   
    <script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
  </body>
</html>