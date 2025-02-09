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
                
        <div class="col-md-10"><!--comienzo accordion-->
		<?php 
			$esta_activa="si";
			$id_provincia=$_SESSION['localidad'];
			$tipo_user=$_SESSION['tipo_votante'];
			$id_ccaa=$_SESSION['id_ccaa_usu'];

			$fecha=date("Y-m-d",strtotime("-3 month"));

			echo "<br/>Esta plataforma se usará para futuras votaciones, encuestas y debates de ImaginaBurgos en las que esperamos que participes.<br/><br/>";
			//echo "La votación se abrirá el martes 27 a partir de las 18:30h y finalizará el jueves 5 de abril a las 14h. Los resultados se presentarán, tras ser confirmados por el Consejo de Coordinación, ese mismo jueves a las 19:30h.";
			//echo "Se muestran las votaciones con una antigüedad de menos de 3 meses<br/><br/>";
			echo "<br/>";

			if ($_SESSION['tipo_votante']==3){ //STG+, Si NO está verificado, le decimos cómo hacerlo.
				echo "<BR>
				<font size='3' color='red'>USUARIO PENDIENTE DE VERIFICAR.</font><BR/>
				</br>
				Para poder asegurar las máximas garantías en la votación, debemos verificar el cumplimiento de los únicos requisitos para poder participar: residir habitualmente en Burgos o provincia y ser mayor de 16 años. Lamentamos las molestias.<br/><br/>
				<b>Para que podamos verificarte</b>:</br>
				Puedes acudir con tu DNI presencialmente (en los lugares/horarios abajo indicados) o enviarnos una foto de tu DNI por ambas caras al correo votaciones@imaginaburgos.es.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;* Si en tu DNI no figura Burgos como lugar de residencia, deberás aportar además cualquier otro documento que acredite que resides en Burgos o provincia (incluidos certificados públicos, contratos de alquiler, recibos de suministros, matrículas de centros de estudios, etc.).<br/><br/>
				<b>* Podrán participar en la votación de primarias</b>: todas las personas que hayan solicitado su inscripción en el censo hasta el 27 de febrero de 2019 (incluidas todas aquellas que hayan estado inscritas desde las primarias de 2015).<br/>
				- Si has solicitado el alta en esta plataforma después del 27 de febrero, no podrás participar en esta votación de primarias, pero sí en futuras votaciones.<br/>
				";		
			}
			
			echo "<br/>			
				<b>Si tienes cualquier duda, puedes contactarnos de las siguientes formas</b>:<br/>				
				- Puedes pasar por la oficina de Imagina Burgos los días laborables en horario de 9 a 14 horas. (C/ Diego Porcelos nº 4 / 1º planta).<br/>
				- Llamando al teléfono 947 25 86 00 en horario de 9h a 14h.<br/>
				- Enviando un whatsapp al teléfono 694 474 800 si tienes cualquier duda.<br/>
				- Escribiendo a votaciones@imaginaburgos.es<br/><br/>";
			
			$cuenta=1; //Inicializamos, y si es el sitio de PRUEBAS, CAMBIARÁ.			
			//STG+ USUARIOS DE PRUEBAS : || $_SESSION['ID'] == "0000000004"
			if (isset($sitio_web_PRUEBAS) && $sitio_web_PRUEBAS == "S"){
				if ($_SESSION['ID'] == "0000000002" || $_SESSION['ID'] == "0000000001"){  // Quito otro usuario de pruebas: || $_SESSION['ID'] == "0000000520" 
					$cuenta=1;
				}
				else{
					$cuenta = 8; //Para que no entre si es otro usuario.
				}
				echo "<br/>¡¡ ESTE ES UN SITIO WEB DE PRUEBAS!!. ACCEDA AL SITIO OFICIAL DE <a href='https://votaciones.imaginaburgos.es'>la web de votaciones</a><br/><br/>";					
			}
			
			while ( $cuenta <= 7) {
				if ($cuenta==1){
					$sql = "SELECT ID ,activa, nombre_votacion ,resumen, tipo  ,fecha_com, fecha_fin ,activos_resultados, fin_resultados ,recuento, seguridad	FROM $tbn1  where demarcacion=1 and tipo_votante >=".$_SESSION['tipo_votante']."  and activa like '$esta_activa' and  fecha_fin>'$fecha' ORDER BY  ID  DESC";
					$que_votacion="Estatales";
				}
				if ($cuenta==2){
					$sql = "SELECT ID ,activa, nombre_votacion ,resumen, tipo  ,fecha_com, fecha_fin ,activos_resultados, fin_resultados,recuento, seguridad 	 FROM $tbn1 where demarcacion=2 and id_ccaa=".$_SESSION['id_ccaa_usu']." and tipo_votante >= ".$_SESSION['tipo_votante']."   and activa like '$esta_activa'  and  fecha_fin>'$fecha' ORDER BY  ID DESC";
					$que_votacion=" en la comunidad autonoma de ".$_SESSION['ccaa']."";
				}
				if ($cuenta==3){
					$sql = "SELECT ID ,activa, nombre_votacion ,resumen, tipo  ,fecha_com, fecha_fin ,activos_resultados, fin_resultados ,recuento, seguridad	 FROM $tbn1 where demarcacion=3 and id_provincia =".$_SESSION['localidad']." and tipo_votante >= ".$_SESSION['tipo_votante']."  and activa like '$esta_activa'  and  fecha_fin>'$fecha' ORDER BY  ID DESC";
					$que_votacion=" en la provincia de ". $_SESSION['provincia']."";
				}
				if ($cuenta==4){ /// municipal
					$sql = "SELECT ID ,activa, nombre_votacion ,resumen, tipo  ,fecha_com, fecha_fin ,activos_resultados, fin_resultados, recuento, seguridad	 FROM $tbn1 where demarcacion=7 and id_municipio =".$_SESSION['id_municipio']." and tipo_votante >= ".$_SESSION['tipo_votante']."  and activa like '$esta_activa'  and  fecha_fin>'$fecha' ORDER BY  ID DESC";
					$que_votacion="Municipales de ".$_SESSION['municipio']."";
				}
				if ($cuenta==5){
					$sql = "SELECT a.ID ,a.activa, 	a.nombre_votacion ,	a.resumen, a.tipo  ,a.fecha_com, a.fecha_fin ,a.activos_resultados, a.fin_resultados,a.id_grupo_trabajo, a.recuento, a.seguridad 	FROM $tbn1 a,$tbn6 b where (a.id_grupo_trabajo = b.id_grupo_trabajo) and b.id_usuario=".$_SESSION['ID']." and a.demarcacion=4 and a.tipo_votante >=".$_SESSION['tipo_votante']."   and a.activa like '$esta_activa' and b.estado=1  and  a.fecha_fin>'$fecha' ORDER BY  ID DESC";
					$que_votacion="Grupo provincial";
				}
				if ($cuenta==6){
					$sql = "SELECT a.ID ,a.activa, 	a.nombre_votacion ,	a.resumen, a.tipo  ,a.fecha_com, a.fecha_fin ,a.activos_resultados, a.fin_resultados,a.id_grupo_trabajo ,a.recuento, a.seguridad	FROM $tbn1 a,$tbn6 b where (a.id_grupo_trabajo = b.id_grupo_trabajo) and b.id_usuario=".$_SESSION['ID']." and a.demarcacion=5 and a.tipo_votante >=".$_SESSION['tipo_votante']."   and a.activa like '$esta_activa' and b.estado=1 and  a.fecha_fin>'$fecha' ORDER BY  a.ID DESC";
					$que_votacion="Grupo autonomico";
				}
				if ($cuenta==7){
					$sql = "SELECT a.ID ,a.activa, 	a.nombre_votacion ,	a.resumen, a.tipo  ,a.fecha_com, a.fecha_fin ,a.activos_resultados, a.fin_resultados ,a.id_grupo_trabajo, a.recuento, a.seguridad	FROM $tbn1 a,$tbn6 b where (a.id_grupo_trabajo = b.id_grupo_trabajo) and b.id_usuario=".$_SESSION['ID']." and a.demarcacion=6 and a.tipo_votante >=".$_SESSION['tipo_votante']."   and a.activa like '$esta_activa' and b.estado=1 and  a.fecha_fin>'$fecha' ORDER BY  a.ID DESC";
					$que_votacion="grupo Estatal";
				}	
				$result = mysqli_query($con, $sql);
				if ($row = mysqli_fetch_array($result)){		
?>
            <h3>Listado de votaciones   <?php echo "$que_votacion"  ?> </h3>   
			<div class="panel-group" id="accordion_<?php echo $cuenta; ?>">
<?php
				mysqli_field_seek($result,0);
                    
                do {
                    $hoy=strtotime(date('Y-m-d H:i')); 
					$fecha_ini=strtotime($row[5]);
					$fecha_fin=strtotime($row[6]);
					$fecha_ini_ver=date("d-m-Y", strtotime($row[5]));
					$fecha_fin_ver=date("d-m-Y", strtotime($row[6]));
					$hora_ini_ver=date("H:i", strtotime($row[5]));
					$hora_fin_ver=date("H:i", strtotime($row[6]));
					$seguridad=$row[10]; //STG+; Añado el campo seguridad en todas las consultas, para ver si se puede comprobar el voto.
	  
					if($row[1]=="no"){
						$activo="Votacion NO activa";
					}
					else  if($fecha_ini <=$hoy && $fecha_fin >=$hoy   ){
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
								 $image_activo="<span class=\"glyphicon glyphicon-comment  text-success\"></span>";
							}
		  
							$activo1="$texto1_activo $image_activo";	
							$activo="<font size='16px'><a href='$dir?idvot=$row[0]'>$texto1_activo</a></font>";
						}
					} else {
		
						if($row[4]==1){	
							if($fecha_fin <=$hoy){
								 $texto1_activo="Votacion finalizada";
								 $texto2_activo="Votacion finalizada";
							}else{
							 $texto1_activo="Votacion sin iniciar"; 
							 $texto2_activo="Votacion sin iniciar";
							}		 
						}
						else if($row[4]==2){
							if($fecha_fin <=$hoy){
								 $texto1_activo="Votacion finalizada";
								 $texto2_activo="Votacion finalizada";
							}else{
								 $texto1_activo="Votacion sin iniciar"; 
								 $texto2_activo="Votacion sin iniciar";
							}	
						}
						else if($row[4]==3){
							 if($fecha_fin <=$hoy){
								 $texto1_activo="Votacion finalizada";
								 $texto2_activo="Votacion finalizada";
							 }else{
								 $texto1_activo="Votacion sin iniciar"; 
								 $texto2_activo="Votacion sin iniciar";
							 }	
						}else if($row[4]==4){
							$dir="../debate/debate.php";
							if($fecha_fin <=$hoy){ 
								$texto1_activo="Debate finalizado <span class=\"glyphicon glyphicon-comment  text-success\"></span>";
								$texto2_activo="<a href='$dir?idvot=$row[0]'>Debate finalizado</a>";
							}else{
								 $texto1_activo="Debate sin iniciar <span class=\"glyphicon glyphicon-comment  text-success\"></span>";
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
                              
                               <?php if ($cuenta==5 or $cuenta==6 or $cuenta==7 ){
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
								
								<?php
								//STG+: Añadimos la posibilidad de comprobar lo que has votado en todo momento durante la votación.
								if ($quants_vot != ""){ //Si "Ya ha votado ";								
									//echo "</BR>SEGURIDAD:".$seguridad."-votacion:".$id_votacion;									
									// => ESTA ES LA PANTALLA PARA COMPROBAR QUE TU VOTO NO HA CAMBIADO (USANDO LA CONTRASEÑA)
									$dirComprobar="../vota_orden/vota_primarias_ver.php";	  
									if($seguridad==2 || $seguridad ==4 ){
										echo "<br/><a href=".$dirComprobar."?idvot=".$id_votacion."  class=modify>Comprobar mi voto</a>";
									}									
								}
								?>
								
								
                               <br/> Fechas votación: desde las <?php echo $hora_ini_ver; ?> del  <?php echo $fecha_ini_ver ;?> a las <?php echo $hora_fin_ver; ?> del 
                                <?php echo $fecha_fin_ver;?> 
                               <br/> Tipo de votación : <?php if($row[4]==1){
                                     echo"primarias";

									if ($mostrar_todas_opciones=="S") {  
										//STG: De momento ocultamos el tipo de recuento, ya que no es exactamente ninguno de los dos.
										if ($row[9]==0){ 
											echo " con recuento BORDA";
										}
										else if($row[9]==1){
											echo " con recuento DOWDALL";
										}
									}
									else {
										echo " con recuento ponderado";
									}
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
                                              $dir_a_1="..//debate/resultados_debate.php";
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
					  
<?php 			} while ($row = mysqli_fetch_array($result)); ?>
			</div> 
<?php 		} 
			$cuenta++;
		}
?>
      
        <p>&nbsp;</p>
        <p>&nbsp;</p>
     
		</div> <!--fin acordion -->  
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