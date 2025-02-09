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
       
        
        
        <div class="col-md-7">
        

                  <!---->
                  <form action="../votacion/buscar_votaciones_res.php" method=post name="frmDatos" id="frmDatos" class="well">
 <table width="100%">
   <tr>
     <td><label>
       <input name="votaciones" type="radio" id="votaciones_0" value="todas" checked="CHECKED" />
       Todas</label></td>
   </tr>
   <tr>
     <td><label>
       <input type="radio" name="votaciones" value="1_estatal" id="votaciones_1" />
       Estatales</label></td>
   </tr>
   <tr>
     <td><label>
       <input type="radio" name="votaciones" value="2_<?php echo $_SESSION['id_ccaa_usu']; ?>"  id="votaciones_2" />
       <?php echo $_SESSION['ccaa']; ?></label></td>
   </tr>
   <tr>
     <td><label>
       <input type="radio" name="votaciones" value="3_<?php echo $_SESSION['localidad']; ?>"  id="votaciones_3" />
       Provincia de <?php echo $_SESSION['provincia']; ?></label></td>
   </tr>

 
 

 
<?php 
		  $result2=mysqli_query($con,"SELECT a.ID ,a.subgrupo,a.tipo_votante, a.id_provincia, a.tipo FROM $tbn4 a,$tbn6 b where (a.ID= b.id_grupo_trabajo) and b.id_usuario=".$_SESSION['ID']." and b.estado=1 order by a.tipo");
$quants2=mysqli_num_rows($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	$id_grupo= $listrows2[ID];	
	
	$id_prov= $listrows2[id_provincia];
	$subgrupo= $listrows2[subgrupo];
		?> 
   <tr>
     <td>
     
    <label>
    					<?php  if($listrows2[tipo]==1){$pre="4"; $tipo_asamblea= "Grupo provincial ";}
						else if($listrows2[tipo]==2)  {$pre="5";$tipo_asamblea="Grupo autonomico ";}
						else if($listrows2[tipo]==3)  {$pre="6";$tipo_asamblea= "Grupo estatal ";} ?>
    <input  type="radio"  name="votaciones"  value="<?php echo "$pre"; ?>_<?php echo "$id_grupo"; ?>" id="votaciones_<?php echo "$id_grupo"; ?>" > <?php echo utf8_encode($subgrupo); ?> (<?php echo "$tipo_asamblea"; ?>) </label>
  
       </td>
   </tr>
	<?php
	
	 }
				 
}
		  ?>
    </table>      

	<p>&nbsp;  </p>
	<table width="100%" border="0" align="center" class="text">
	  <tr>
	    <td width="20%" >
         Entre el 
          
	      </td>
	    <td width="80%" ><div class="control-group">
                    <div class="controls">
          <label></label>
	      <input  name="fecha_ini"  id="fecha_ini" type="text"  />  
          <p class="help-block"></p>
		   		 </div>
	          </div> </td>
      </tr>
	  <tr>
	    <td width="20%" >y el</td>
	    <td ><div class="control-group">
                    <div class="controls">
          <label></label>
          <input name="fecha_fin" id="fecha_fin" type="text" />
            <p class="help-block"></p>
		   		 </div>
	          </div></td>
	    </tr>
    </table>
	<p>
	  <button type="submit" class="btn btn-primary pull-right">Buscar</button>
  </p>
	<p>&nbsp;</p>
   
 </form>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  <!---->
        
  
        </div>
        
          <div class="col-md-3">
         
		<?php  // include("../votacion/lateral_derecho.php"); ?>              
        </div>
      
  </div>
 

  <div id="footer" class="row">
   <?php  include("ayuda.php"); ?>
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
<script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
   <script src="../modulos/ui/jquery-ui.custom.js"></script>
   
   <script  type='text/javascript' >
	$(function() {
		
		$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '&#x3c;Ant',
		nextText: 'Sig&#x3e;',
		currentText: 'Hoy',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
		'Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
		dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
		weekHeader: 'Sm',
		dateFormat: 'dd-mm-yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
		
		
	$.datepicker.setDefaults($.datepicker.regional['es']);
		$( "#fecha_ini" ).datepicker({
			 
			minDate: -2140,
			maxDate: 92,
			numberOfMonths: 1,
			showButtonPanel: true,
			changeMonth:true,
			changeYear:true,
			onClose: function( selectedDate ) {
				$( "#fecha_fin" ).datepicker( "option", "minDate", selectedDate );
			}
			
		});
		$( "#fecha_fin" ).datepicker({
			minDate: -2140,
			maxDate: 92,
			numberOfMonths: 1,
			showButtonPanel: true,
			changeMonth:true,
			changeYear:true,
			onClose: function( selectedDate ) {
				$( "#fecha_ini" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
		
		
	});
	</script>
  </body>
</html>