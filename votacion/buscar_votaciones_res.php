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
    <link rel="icon"  type="image/png"  href="<?php echo "../votacion/$url_vot";?>/temas/<?php echo "$tema_web"; ?>/imagenes/icono.png"> 
    
    
    
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
      <div class="page-header"><img src="../temas/<?php echo "$tema_web"; ?>/imagenes/cabecera_votaciones.jpg" class="img-responsive" alt="Logo <?php echo "$nombre_web"; ?>">
       
      </div>
      
    <!-- END cabecera
    ================================================== -->
  
 <?php  include("../votacion/caja_mensajes_1.php"); ?>
       <div class="row">
        

        
        
        <div class="col-md-2" >             
          
          <?php  include("../votacion/menu_nav.php"); ?>
            
        </div>
       
        
        
        <div class="col-md-10"><!--comienzo accordion-->
            <?php 
			 $esta_activa="si";
$id_provincia=$_SESSION['localidad'];
$tipo_user=$_SESSION['tipo_votante'];
$id_ccaa=$_SESSION['id_ccaa_usu'];

/**/
				if($_POST['fecha_ini']==""){
	 
					$fecha_com=date("Y-m-d",strtotime("1970-01-01"));
					$dato_com=" inicio de los tiempos ";
				}else{
				$fecha_com=date("Y-m-d",strtotime($_POST['fecha_ini']));
				$dato_com= $_POST['fecha_ini'] ;
				}
				if($_POST['fecha_fin']==""){
					$fecha_fin=date("Y-m-d",strtotime("2030-01-01"));
					$dato_fin=" final de los tiempos ";
				}else{
				$fecha_fin=date("Y-m-d",strtotime($_POST['fecha_fin']));
				$dato_fin=$_POST['fecha_fin'];
				}
				
		

echo "Se han encotrado las siguientes votaciones entre el ".$dato_com ." y el ".$dato_fin ;


if($_POST['votaciones']!="todas"){
			//echo "duda";
			$parte = explode("_",$_POST['votaciones']);
			//echo $parte[0]; // piece1
			//echo $parte[1]; // piece2
			$cuenta=$parte[0];
			$cuenta_fin=$parte[0];
			$dato_votacion=$parte[1];
			
		}
		else{
			$cuenta=1;
			$cuenta_fin=6;
			
		}
		
			//$cuenta=1;
			while ( $cuenta <= $cuenta_fin) {
		
		

	if ($cuenta==1){
		$sql = "SELECT ID ,activa, nombre_votacion ,resumen, tipo  ,fecha_com, fecha_fin ,activos_resultados, fin_resultados 	FROM $tbn1  where demarcacion=1 and tipo_votante >=".$_SESSION['tipo_votante']."  and activa like '$esta_activa' and  fecha_com>'$fecha_com' and  fecha_fin<'$fecha_fin'  ORDER BY  ID  DESC";
$que_votacion="Estatales";
	}
	if ($cuenta==2){
		 
		$sql = "SELECT ID ,activa, nombre_votacion ,resumen, tipo  ,fecha_com, fecha_fin ,activos_resultados, fin_resultados 	 FROM $tbn1 where demarcacion=2 and id_ccaa=".$_SESSION['id_ccaa_usu']." and tipo_votante >=".$_SESSION['tipo_votante']."   and activa like '$esta_activa' and  fecha_com>'$fecha_com'  and  fecha_fin<'$fecha_fin'  ORDER BY  ID DESC";
$que_votacion=" en  ".$_SESSION['ccaa']."";
	}
	if ($cuenta==3){
		
		$sql = "SELECT ID ,activa, nombre_votacion ,resumen, tipo  ,fecha_com, fecha_fin ,activos_resultados, fin_resultados 	 FROM $tbn1 where demarcacion=3 and id_provincia =".$_SESSION['localidad']." and tipo_votante >=".$_SESSION['tipo_votante']."  and activa like '$esta_activa'   and  fecha_com>'$fecha_com' and  fecha_fin<'$fecha_fin' ORDER BY  ID DESC";
$que_votacion=" en la provincia de ". $_SESSION['provincia']."";
	}
	
	if ($cuenta==4){
		if($dato_votacion!=""){
			$sql = "SELECT ID ,activa, 	nombre_votacion ,resumen, tipo  ,fecha_com, fecha_fin ,activos_resultados,fin_resultados,id_grupo_trabajo 	FROM $tbn1  where id_grupo_trabajo =".$dato_votacion." and demarcacion=4 and tipo_votante >=".$_SESSION['tipo_votante']."   and activa like '$esta_activa'   and  fecha_fin<'$fecha_fin' and  fecha_com>'$fecha_com' ORDER BY  ID DESC";
					$result2=mysqli_query($con,"SELECT subgrupo,tipo_votante, id_provincia, tipo FROM $tbn4  where ID=".$dato_votacion."");
					$quants2=mysqli_num_rows($result2);
					if($quants2!=0){	
					while( $listrows2 = mysqli_fetch_array($result2) ){ 
					$id_grupo= $listrows2[ID];	
					$id_prov= $listrows2[id_provincia];
					$que_votacion= "del \"".$listrows2[subgrupo]."\"";
					}}
	
		}else{
	$sql = "SELECT a.ID ,a.activa, 	a.nombre_votacion ,	a.resumen, a.tipo  ,a.fecha_com, a.fecha_fin ,a.activos_resultados, a.fin_resultados,a.id_grupo_trabajo 	FROM $tbn1 a,$tbn6 b where (a.id_grupo_trabajo = b.id_grupo_trabajo) and b.id_usuario=".$_SESSION['ID']." and a.demarcacion=4 and a.tipo_votante >=".$_SESSION['tipo_votante']."   and a.activa like '$esta_activa' and b.estado=1   and  a.fecha_fin<'$fecha_fin' and  a.fecha_com>'$fecha_com' ORDER BY  ID DESC";
	$que_votacion="Grupo provincial";
		}
	}
	
    if ($cuenta==5){
		if($dato_votacion!=""){
			$sql = "SELECT ID ,activa, 	nombre_votacion ,resumen, tipo  ,fecha_com, fecha_fin ,activos_resultados,fin_resultados,id_grupo_trabajo 	FROM $tbn1  where id_grupo_trabajo =".$dato_votacion." and demarcacion=4 and tipo_votante >=".$_SESSION['tipo_votante']."   and activa like '$esta_activa'   and  fecha_fin<'$fecha_fin' and  fecha_com>'$fecha_com' ORDER BY  ID DESC";
					$result2=mysqli_query($con,"SELECT subgrupo,tipo_votante, id_provincia, tipo FROM $tbn4  where ID=".$dato_votacion."");
					$quants2=mysqli_num_rows($result2);
					if($quants2!=0){	
					while( $listrows2 = mysqli_fetch_array($result2) ){ 
					$id_grupo= $listrows2[ID];	
					$id_prov= $listrows2[id_provincia];
					$que_votacion= "del \"".$listrows2[subgrupo]."\"";
					}}
	
		}else{
    $sql = "SELECT a.ID ,a.activa, 	a.nombre_votacion ,	a.resumen, a.tipo  ,a.fecha_com, a.fecha_fin ,a.activos_resultados, a.fin_resultados,a.id_grupo_trabajo 	FROM $tbn1 a,$tbn6 b where (a.id_grupo_trabajo = b.id_grupo_trabajo) and b.id_usuario=".$_SESSION['ID']." and a.demarcacion=5 and a.tipo_votante >=".$_SESSION['tipo_votante']."   and a.activa like '$esta_activa' and b.estado=1  and  a.fecha_fin<'$fecha_fin' and  a.fecha_com>'$fecha_com' ORDER BY  a.ID DESC";
	$que_votacion="Grupo autonomico";
		}
	}
	if ($cuenta==6){
		if($dato_votacion!=""){
			$sql = "SELECT ID ,activa, 	nombre_votacion ,resumen, tipo  ,fecha_com, fecha_fin ,activos_resultados,fin_resultados,id_grupo_trabajo 	FROM $tbn1  where id_grupo_trabajo =".$dato_votacion." and demarcacion=4 and tipo_votante >=".$_SESSION['tipo_votante']."   and activa like '$esta_activa'   and  fecha_fin<'$fecha_fin' and  fecha_com>'$fecha_com' ORDER BY  ID DESC";
					$result2=mysqli_query($con,"SELECT subgrupo,tipo_votante, id_provincia, tipo FROM $tbn4  where ID=".$dato_votacion."");
					$quants2=mysqli_num_rows($result2);
					if($quants2!=0){	
					while( $listrows2 = mysqli_fetch_array($result2) ){ 
					$id_grupo= $listrows2[ID];	
					$id_prov= $listrows2[id_provincia];
					$que_votacion= "del \"".$listrows2[subgrupo]."\"";
					}}
	
		}else{
    $sql = "SELECT a.ID ,a.activa, 	a.nombre_votacion ,	a.resumen, a.tipo  ,a.fecha_com, a.fecha_fin ,a.activos_resultados, a.fin_resultados ,a.id_grupo_trabajo	FROM $tbn1 a,$tbn6 b where (a.id_grupo_trabajo = b.id_grupo_trabajo) and b.id_usuario=".$_SESSION['ID']." and a.demarcacion=6 and a.tipo_votante >=".$_SESSION['tipo_votante']."   and a.activa like '$esta_activa' and b.estado=1  and  a.fecha_fin<'$fecha_fin' and  a.fecha_com>'$fecha_com' ORDER BY  a.ID DESC";
	$que_votacion="grupo Estatal";
		}
	}



$result = mysqli_query($con, $sql);
if ($row = mysqli_fetch_array($result)){
	
	
?>
        

            <h3>Listado de votaciones   <?php echo "$que_votacion"  ?> </h3>   


                   <div class="panel-group" id="accordion_<?php echo $cuenta; ?>">
						 <?php
                    
                    mysqli_field_seek($result,0);
                    
                    do {
                     ?>               
                    <?php
		  $hoy=strtotime(date('Y-m-d H:i')); 
		  $fecha_ini=strtotime($row[5]);
		  $fecha_final=strtotime($row[6]);
		  $fecha_ini_ver=date("d-m-Y", strtotime($row[5]));
		  $fecha_fin_ver=date("d-m-Y", strtotime($row[6]));
		  $hora_ini_ver=date("H:i", strtotime($row[5]));
		  $hora_fin_ver=date("H:i", strtotime($row[6]));
		 

		  
          if($row[1]=="no"){
	$activo="Votacion NO activa";
	}
	else  if($fecha_ini <=$hoy && $fecha_final >=$hoy   ){
		//$activo="Votacion NO activa";
		
	/*}
	else {*/
		$id_votante=$_SESSION['ID'];
	$id_votacion=$row[0];	
		$conta_vot="SELECT id FROM $tbn2 WHERE id_votacion like \"$id_votacion\" and id_votante='$id_votante' ";

$result_cont_vot=mysqli_query($con,$conta_vot);
$quants_vot=mysqli_num_rows($result_cont_vot);
	
	if ($quants_vot != ""){
$activo="Ya ha votado ";
$activo1="Ya ha votado ";

}
	else{

		 if($row[4]==1){
			 $dir="../vota_orden/voto_primarias.php";
			 $texto1_activo="VOTAR";
			 
			 $texto2_activo="Votacion NO activa";
			 $image_activo="<span class=\"glyphicon glyphicon-thumbs-up  text-success\"></span>";
			 
		  }
		  else if($row[4]==2){
			  $dir="../vota_vut/vut.php";
			 $texto1_activo="VOTAR";
			 $texto2_activo="Votacion NO activa";
			 $image_activo="<span class=\"glyphicon glyphicon-thumbs-up  text-success\"></span>";
		  }
		  else if($row[4]==3){
			  $dir="../vota_encuesta/vota_encuesta.php";
			  $texto1_activo="VOTAR";
			 $texto2_activo="Votacion NO activa";
			 $image_activo="<span class=\"glyphicon glyphicon-thumbs-up  text-success\"></span>";
		  }else if($row[4]==4){
			  $dir="../debate/debate.php";
			  $texto1_activo="DEBATE ABIERTO";
			 $texto2_activo="Debate cerrado";
			 $image_activo=" <span class=\"glyphicon glyphicon-comment  text-success\"></span>";
		  }
		  
	$activo1="$texto1_activo $image_activo";	
	$activo="<a href='$dir?idvot=$row[0]'  class=modify>$texto1_activo</a>";
    	}
	} else{
		
		if($row[4]==1){	
			if($fecha_final <=$hoy){
			 $texto1_activo="Votacion finalizada";
			 $texto2_activo="Votacion finalizada";
			 }else{
			 $texto1_activo="Votacion sin iniciar"; 
			 $texto2_activo="Votacion sin iniciar";
			 }		 
			 
		  }
		  else if($row[4]==2){
			 if($fecha_final <=$hoy){
			 $texto1_activo="Votacion finalizada";
			 $texto2_activo="Votacion finalizada";
			 }else{
			 $texto1_activo="Votacion sin iniciar"; 
			 $texto2_activo="Votacion sin iniciar";
			 }	
		  }
		  else if($row[4]==3){
			 if($fecha_final <=$hoy){
			 $texto1_activo="Votacion finalizada";
			 $texto2_activo="Votacion finalizada";
			 }else{
			 $texto1_activo="Votacion sin iniciar"; 
			 $texto2_activo="Votacion sin iniciar";
			 }	
		  }else if($row[4]==4){
			  $dir="../debate/debate.php";
			  if($fecha_final <=$hoy){ 
			 $texto1_activo="Debate finalizado  <span class=\"glyphicon glyphicon-comment  text-success\"></span>";
			 $texto2_activo="<a href='$dir?idvot=$row[0]' >Debate finalizado</a>";
		
			 }else{
			 $texto1_activo="Debate sin iniciar  <span class=\"glyphicon glyphicon-comment  text-success\"></span>";
			 $texto2_activo="<a href='$dir?idvot=$row[0]' >Debate sin iniciar</a>";
		
			 }	
		  }
		
	$activo1=$texto1_activo;
	$activo=$texto2_activo;	
	}
		 ?>
 <!-- comienzo votacion-->
                   
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion_<?php echo $cuenta; ?>" href="#<?php echo $row[0]; ?>">
                               <?php echo $row[2] ?>
                               </a>
                              
                               <?php if ($cuenta==4 or $cuenta==5 or $cuenta==6 ){
								$sql_grupo=mysqli_query($con,"SELECT subgrupo FROM $tbn4 where ID=".$row[9]." ");
								 $row_grupo=mysqli_fetch_row($sql_grupo);
								?>
                               	 Grupo : <?php echo $row_grupo[0]; ?> | 
								 <?php }?> 
									<a data-toggle="collapse" data-parent="#accordion_<?php echo $cuenta; ?>" href="#<?php echo $row[0]; ?>" class="pull-right" >
                                
                               <?php echo  "$activo1"; ?> </a>
                            
                          </h4>
                        </div>
                        <div id="<?php echo $row[0]; ?>" class="panel-collapse collapse ">
                          <div class="panel-body">
                          <div class="row"><div class="col-md-5">
                                Estado de la votación : <?php echo  "$activo"; ?>
                               <br/> Fechas votación: desde las <?php echo $hora_ini_ver; ?> del  <?php echo $fecha_ini_ver ;?> a las <?php echo $hora_fin_ver; ?> del 
                                <?php echo $fecha_fin_ver;?> 
                               <br/>   Tipo de votacion : <?php if($row[4]==1){
                                      echo"primarias";
                                  }
                                  else if($row[4]==2){
                                      echo"VUT";
                                  }
                                  else if($row[4]==3){
                                      echo"encuesta";
                                  }else if($row[4]==4){
                                      echo"Debate";
                                  }
                                  
                                  ?>
                                
                                  
                               <?php  if($row[7]=="si"){
                        
                                         if($row[4]==1){
                                             $dir_a_1="../vota_orden/resultados_primarias.php";
                                          }
                                          else if($row[4]==2){
                                              $dir_a_1="../vota_vut/resultados.php";
                                          }
                                          else if($row[4]==3){
                                              $dir_a_1="../vota_encuesta/resultados_encuesta.php";
                                          }	  	 else if($row[4]==3){
                                              $dir_a_1="../debate/resultados_debate.php";
                                          } 
                                
                            $activo_a_1="<br/><a href='$dir_a_1?idvot=$row[0]'  class=modify>Resultados</a>";
                                }
                            else{
                                $activo_a_1="";
                                }
                                echo  "$activo_a_1"; ?>
                                </div>
                                <div class="col-md-7">
                               <?php echo $row[3] ?>
                                </div>
                                
                         </div>
                          </div>
                        </div>
                      </div> <!--fin votacion-->
                            <?php
							}
							while ($row = mysqli_fetch_array($result));
							?>
				</div> 
				<?php 
				} 
				?>
                <?php 
				
				$cuenta++;
				}
			
				?>
      
        
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        
  
        </div>
         <!--fin acordion --> 
         
         
      
  </div>
 
 
  <div id="footer" class="row">
  <?php  include("ayuda.php"); ?>
  <?php  include("../temas/$tema_web/pie.php"); ?>
     </div>
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
<script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
   <script src="../js/jqBootstrapValidation.js"></script>
  </body>
</html>