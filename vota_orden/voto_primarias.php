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
require_once("../inc_web/config.inc.php");
include('../inc_web/seguri.php'); 

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
    <!--  mirar si se puede poner al final-->
      
      <!-- FIN  mirar si se puede poner al final-->
    <!—[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]—>
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../modulos/themes-jquery-iu/base/jquery.ui.all.css">
    <link rel="stylesheet" href="orden.css">
    <link href="../temas/<?php echo "$tema_web"; ?>/estilo.css" rel="stylesheet">
    <!--<link href="../temas/demokratia/estilo.css" rel="stylesheet" type="text/css">-->
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
        

                  <!---->
			<h1><?php echo "$nombre_votacion" ; ?></h1>
       
			<form id="form2" name="form2" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" >
				<input name="id_vot" type="hidden" id="id_vot" value="<?php echo "$idvot"; ?>" />
				<input name="id_votante" type="hidden" id="id_votante" value="<?php echo "$idVotante"; ?>" />
				
     
   
			<p>
			  <!-- Campo oculto que almacenará los valores votados y su ordenación -->
			  <input type="hidden" id="hfIDS" name="hfIDS" value="" /> 
			</p>

			<div class="well">

				<!-- Contenedor general -->
				<div class="contenedor">
					<!-- tabla1 , lado izquierdo, candidatos-->

					<div id="respuestaOK" class="well" style="display:none;">
					  <div></div>
					  <button class="btn btn-lg btn-block btn-primary" id="backlist">Volver a la lista de votaciones</button>
					</div>
					
			
					<div id="votacion">

						<?php require('../basicos_php/control_voto.php'); // sistema para incluir internventores o clave voto seguro ?>
						<div id="selection">
							<?php 
							  $sql = "SELECT * FROM $tbn7 WHERE id_votacion = '$idvot'  and sexo = 'H'  ORDER BY rand(" . time() . " * " . time() . ")  ";
							  $result = mysqli_query($con, $sql);
							  $numero_fem = mysqli_num_rows($result); // obtenemos el número de filas
							  if ($row = mysqli_fetch_array($result)){
								mysqli_field_seek($result,0);
							?>
		
									  <div class="row">
										<div id="table-men-c" class="col-md-6">
										  <h3>Lista de opciones</h3>
										  <ul class="candidates men unselected">
										  <?php 
											  do {   
										  ?>
											<li data-id="<?php echo  "$row[0]" ?>" data-type="men"> 
											  
											  <span class="name"><?php if($row[imagen_pequena]=="" ){?><?php }else{?><img src="<?php echo $upload_cat; ?>/<?php echo $row['imagen_pequena'] ;?>" alt="<?php echo $row['nombre_usuario'];?> " width="60" height="60"  /> <?php }?><?php echo  "$row[3]" ?></span>
											  <span class="profile"><a data-toggle="modal"  href="../votacion/perfil.php?idgr=<?php echo $row[0]; ?>" data-target="#ayuda_contacta" title="<?php echo $row['nombre_usuario']; ?>"  >más información</a> </span>
											  <button class="add-candidate btn btn-primary">Posición <span class="position">1</span> <i class="glyphicon glyphicon-circle-arrow-right"></i></button>
											  <div class="clearfix"></div>
											</li>
										  <?php
											  } while ($row = mysqli_fetch_array($result));    
										  ?>
										  </ul>
										</div>

										<div id="table-men-v" class="col-md-6">
										  <h3>Selección por orden de preferencia de candidatos</h3>
										  <ul class="candidates men selected">
										  <?php for ($i = 1; $i <= $numero_opciones; $i++) {?>    
											<li data-position="<?php echo "$i"; ?>"  data-id="0" class="empty">
											  <span class="position"><?php echo "$i"; ?></span>
											  <span class="name"></span>
											  <div class="pull-right">
												<button class="del-candidate btn btn-danger" title="Elimina"><i class="glyphicon glyphicon-remove-circle"></i></button>
												<?php if ($i > 1) {?>    
												<button class="up-candidate btn btn-primary" title="Sube"><i class="glyphicon glyphicon-circle-arrow-up"></i></button>
												<?php } ?>
												<?php if ($i < $numero_opciones) {?>    
												<button class="down-candidate btn btn-primary" title="Baja"><i class="glyphicon glyphicon-circle-arrow-down"></i></button>
												<?php } ?>
											  </div>
											  <div class="clearfix"></div>      
											</li>  
										  <?php } ?>
										  </ul>
										</div>
									  </div>
								  <?php
									  } 
								  ?>

								<div class="clearfix"></div>
	  
		
							  <?php 
								$sql = "SELECT * FROM $tbn7 WHERE id_votacion = '$idvot' and sexo = 'M'  ORDER BY rand(" . time() . " * " . time() . ")  ";
								$result = mysqli_query($con, $sql);
								 $numero_mas = mysqli_num_rows($result); // obtenemos el número de filas
								if ($row = mysqli_fetch_array($result)){
								  mysqli_field_seek($result,0);
							  ?>
								<div class="row">      
									<div id="table-women-c" class="col-md-6">
									  <h3>Lista de candidatas</h3>
									  <ul class="candidates women unselected">
									  <?php 
										  do {   
									  ?>
										<li data-id="<?php echo  "$row[0]" ?>"  data-type="women">
										  <span class="name"><?php if($row[imagen_pequena]=="" ){?><?php }else{?><img src="<?php echo $upload_cat; ?>/<?php echo $row['imagen_pequena'] ;?>" alt="<?php echo $row['nombre_usuario'];?> " width="60" height="60"  /> <?php }?><?php echo  "$row[3]" ?></span>
										  <span class="profile"><a data-toggle="modal"  href="../votacion/perfil.php?idgr=<?php echo $row[0]; ?>" data-target="#ayuda_contacta" title="<?php echo $row['nombre_usuario']; ?>"  >más información</a> </span>
										  <button class="add-candidate btn btn-primary">Posición <span class="position">1</span> <i class="glyphicon glyphicon-circle-arrow-right"></i></button>
										  <div class="clearfix"></div>
										</li>
									  <?php
										  } while ($row = mysqli_fetch_array($result));
									  ?>  
									  </ul>
									</div>

									<div id="table-women-v" class="col-md-6">
									  <h3>Selección por orden de preferencia de candidatas</h3> 
									  <ul class="candidates women selected">
									  <?php for ($i = 1; $i <= $numero_opciones; $i++) {?>    
										<li data-position="<?php echo "$i"; ?>" data-id="0" class="empty">
										  <span class="position"><?php echo "$i"; ?></span>
										  <span class="name"></span>
										  <div class="pull-right">
											<button class="del-candidate btn btn-danger" title="Elimina"><i class="glyphicon glyphicon-remove-circle"></i></button>
											<?php if ($i > 1) {?>    
											<button class="up-candidate btn btn-primary" title="Sube"><i class="glyphicon glyphicon-circle-arrow-up"></i></button>
											<?php } ?>
											<?php if ($i < $numero_opciones) {?>    
											<button class="down-candidate btn btn-primary" title="Baja"><i class="glyphicon glyphicon-circle-arrow-down"></i></button>
											<?php } ?>
										  </div>  
										  <div class="clearfix"></div>
										</li>  
									  <?php } ?>
									  </ul>
									</div>
								</div>
							  <?php
								  } 
							  ?>  
							<!---->
							 <div class="clearfix"></div>
							<?php if ($numero_mas== 0 or $numero_fem== 0){ ?>

							  <?php 
								$sql = "SELECT * FROM $tbn7 WHERE id_votacion = '$idvot' and sexo = 'O'  ORDER BY rand(" . time() . " * " . time() . ")  ";
								$result = mysqli_query($con, $sql);
								 $numero_mas = mysqli_num_rows($result); // obtenemos el número de filas
								if ($row = mysqli_fetch_array($result)){
								  mysqli_field_seek($result,0);
							  ?>
								<div class="row">      
		
										<!-- STG: 10-03-2019 (a partir de las primarias de 2019)
										Cambio el orden en pantalla de los textos, para que quede más cercano a la votación. Así queda:
										- Lo de las garantías de la votación (include "control_voto.php")
										- El número de propuestas a elegir.
										- El "resumen" que damos de alta al crear la votación.
										-->		
		
									 <div style="padding:10px 10px;">
										<div style="background:#ffffff;border:1px solid #ccc;padding:5px 10px;">
										<p style="text-align:justify"><?php echo "$resumen"; ?></p>
										</div>
									</div>

									<div style="padding:20px 20px;">			
										<div id="voto">
										<h3>El número de propuestas que se pueden elegir es un máximo de: <?php echo "$numero_opciones"; ?> </h3>
										</div>
									</div>			
									<br/>			
									
									<div id="table-neutro-c" class="col-md-6">
									  <h3>Lista de OPCIONES</h3>
									  (por orden aleatorio)
									  <ul class="candidates neutro unselected">
									  <?php 
										  do {   
									  ?>
										<li data-id="<?php echo  "$row[0]" ?>"  data-type="neutro">
										  <span class="name">
												<?php if($row[imagen_pequena]=="" ){?>
												<?php }
													else { ?>
														<img src="<?php echo $upload_cat; ?>/<?php echo $row['imagen_pequena'] ;?>" alt="<?php echo $row['nombre_usuario'];?> " width="60" height="60"  /> 
												<?php }?><?php echo  "$row[3]" ?></span>
										  <span class="profile"><a data-toggle="modal"  href="../votacion/perfil.php?idgr=<?php echo $row[0]; ?>" data-target="#ayuda_contacta" title="<?php echo $row['nombre_usuario']; ?>"  >más información</a> </span>
										  <button class="add-candidate btn btn-primary">Posición <span class="position">1</span> <i class="glyphicon glyphicon-circle-arrow-right"></i></button>
										  <div class="clearfix"></div>
										</li>
									  <?php
										  } while ($row = mysqli_fetch_array($result));
									  ?>  
									  </ul>
									</div>

									<div id="table-neutro-v" class="col-md-6">
									  <h3>Selección por orden de preferencia de opciones</h3> 
									  <ul class="candidates women selected">
									  <?php for ($i = 1; $i <= $numero_opciones; $i++) {?>    
										<li data-position="<?php echo "$i"; ?>" data-id="0" class="empty">
										  <span class="position"><?php echo "$i"; ?></span>
										  <span class="name"></span>
										  <div class="pull-right">
											<button class="del-candidate btn btn-danger" title="Elimina"><i class="glyphicon glyphicon-remove-circle"></i></button>
											<?php if ($i > 1) {?>    
											<button class="up-candidate btn btn-primary" title="Sube"><i class="glyphicon glyphicon-circle-arrow-up"></i></button>
											<?php } ?>
											<?php if ($i < $numero_opciones) {?>    
											<button class="down-candidate btn btn-primary" title="Baja"><i class="glyphicon glyphicon-circle-arrow-down"></i></button>
											<?php } ?>
										  </div>  
										  <div class="clearfix"></div>
										</li>  
									  <?php } ?>
									  </ul>
									</div>
								</div>
								
								<?php if ($campotexto_adicional_voto <> "") { ?>
								<div class="row">										
									<h4>&nbsp;&nbsp;<?php echo $campotexto_adicional_voto;?></h4> 
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<textarea name="campotexto_adicional" cols="80" rows="3" id="campotexto_adicional"><?php echo $campotexto_adicional; ?></textarea>
									&nbsp;&nbsp;&nbsp;&nbsp;
								</div>
								<?php } ?>
								
							  <?php
								  } 
							  ?>  

							<?php }?>
							 <!---->
	 
	 
	 
							<?php if ($numero_mas== 0 or $numero_fem== 0){ ?>
								<input name="mixto" type="hidden" id="mixto" value="NOesMixto" /> 
							<?php }else{?>
								<input name="mixto" type="hidden" id="mixto" value="SIesMixto" />
							<?php }?>
								   <input name="id_provincia" type="hidden" id="id_provincia" value="<?php echo "$id_provincia" ?>" />
								   <input name="id_ccaa" type="hidden" id="id_ccaa" value="<?php echo "$id_ccaa" ?>" />
								   <input name="id_subzona" type="hidden" id="id_subzona" value="<?php echo "$id_subzona" ?>" />
								   <input name="id_grupo_trabajo" type="hidden" id="id_grupo_trabajo" value="<?php echo "$id_grupo_trabajo" ?>" />
								   <input name="demarcacion" type="hidden" id="demarcacion" value="<?php echo "$demarcacion" ?>" />
								  <input name="recuento" type="hidden" id="recuento" value="<?php echo "$recuento" ?>" />
								  <input name="id_municipio" type="hidden" id="id_municipio" value="<?php echo "$id_municipio" ?>" />  
								  
								  
								  <!-- -->
									<div class="clear"></div>
									<div class="row">      

										<div class="row">
											<div class="col-xs-12">
										   <?php echo "$texto"; ?>
										   <br/>
										   </div>
									   </div>
									   
										<div class="col-xs-6">
											<button class="btn btn-lg btn-block btn-primary" id="vote">VOTA (Previsualizar)</button>
										</div>
										<div class="col-xs-6">
											<button class="btn btn-lg btn-block btn-default" id="cancelvote">Cancela (votar más tarde)</button>
										</div>        
									</div>
								</div>
	  
	 
								<div id="confirm" style="display:none">
									<div class="row">
									  <div class="col-xs-12">
										<h2>Confirme la votación</h2>
									  </div>

									  <div id="confirm-men" class="col-xs-6">
										<h3>Hombres</h3>
										<ul class="list-group">
										</ul>
									  </div>
									  <div id="confirm-women" class="col-xs-6">
										<h3>Mujeres</h3>
										<ul class="list-group">
										</ul>
									  </div>
									  <div id="confirm-neutro" class="col-xs-12">
										<h3>Su selección</h3>
										<ul class="list-group">
										</ul>
									  </div>								 
									</div>
									<div class="row">
									  <div id="alert-vot-nul" class="col-xs-12" style="display:none">
										<div class="alert alert-info">
										 Tu voto no es paritario, por lo cual no es valido. Has indicado un <span class="men"></span>% de hobres y un <span class="women"></span>% de mujeres<br />
										  Marca la casilla para confirmarlo, o usa el boton de '<b>Volver (modifica el voto)</b>'.
										</div>
										<div class="checkbox">
										  <label>
											<input type="checkbox" id="confirm-nul" name="confirm-nul"> Confirmar que quiere hacer un <b>voto nulo</b>
										  </label>
										</div>        
									  </div>
									  <div id="alert-vot-blanc" class="col-xs-12" style="display:none">
										<div class="alert alert-info">
										  Tu voto es en blanco.<br/> 
										 Marca la casilla para confirmar, o usa el boton de '<b>Volver (modifica el voto)</b>'.
										</div>
										<div class="checkbox">
										  <label>
											<input type="checkbox" id="confirm-blanc" name="confirm-blanc"> Confirmar que quiere  <b>votar en blanco</b>
										  </label>
										</div>        
									  </div>
									</div>

									<div class="row">
										<div class="col-xs-12">
									   <?php echo "$texto"; ?>
									   <br/>
									   </div>
									</div>
									
									<div id="alert-error" class="col-xs-12" style="display:none">
										<div class="alert alert-danger">
										</div>
									</div>
									  
									<div class="row">      
										<div class="col-xs-6">
										  <button class="btn btn-lg btn-block btn-primary" id="confirmvote">CONFIRMAR VOTO</button>
										</div>
										<div class="col-xs-6">
											<button class="btn btn-lg btn-block btn-default" id="backtovote">VOLVER (modificar el voto)</button>
										</div>
									</div>
								</div>							
								
						</form>

					</div>
     
				</div>
     
     
			</div>
     
                  <!---->
        
  
        </div>
        
       <!--   <div class="col-md-2">
         
		<?php  // include("../votacion/lateral_derecho.php"); ?>              
        </div>-->
      
	</div>
 

	<div id="footer" class="row">
	<?php  include("../votacion/ayuda.php"); ?>
	<?php  include("../temas/$tema_web/pie.php"); ?>
	</div>
 </div>  
    <script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
    <script src="../modulos/ui/jquery-ui.custom.js"></script>
		<?php if ($numero_mas== 0 or $numero_fem== 0){ ?>
			<script src="vot_orden_2.js" type="text/javascript" ></script>
        <?php
		}else{?>
  			<script src="vot_orden.js" type="text/javascript" ></script> 
 		<?php }?>
  
  
  <script type="text/javascript">
			<!-- limpiamos la carga de modal para que no vuelva a cargar lo mismo -->
			$('#ayuda_contacta').on('hidden.bs.modal', function () {
			  $(this).removeData('bs.modal');
			});
   </script>
  </body>
</html>