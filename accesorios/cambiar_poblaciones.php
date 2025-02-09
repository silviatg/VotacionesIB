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
  <div class="col-md-6" > 
      <!--Comiezo-->
                   <h1>&nbsp;</h1>
                   <h1>&nbsp;</h1>
      <h1>CAMBIAR POBLACIONES DE FORMA MASIVA</h1>
           <?php  
		   
		   if ($inmsg!=""){
		  echo "<div class=\"alert alert-success\"> ¡¡¡Error!!!</div>";
		   echo "$inmsg";}?>
			  <?php  echo "$mensaje1";?>
			
            
            <?php 
			
			if ($_POST['emails'] != '')
				{
					
		       $emails =strip_tags($_POST['emails'], '<\n><br/>');
				$emailarray = explode("\n", $emails);

				$numrows = count($emailarray);
				for ($i = 0; $i < $numrows; $i++)
					{
					$emailarray1 = explode(',', $emailarray[$i]);

					 if ($_POST['provincia'] == '00'){
							$mensaje2="<div class=\"alert alert-warning\"> error ¡¡escoja una provincia!!</div>";
						}
						
						else
							{
								
						$nif_val=  fn_filtro($con,trim($emailarray1[2]));		
						$user_val= fn_filtro($con,trim($emailarray1[1]));	
						$municipio_val=  fn_filtro($con,trim($emailarray1[3]));			
						$id_provincia=	$_POST['provincia'];
						$poblacion_consulta = mysqli_query($con, "SELECT id_municipio FROM $tbn18 WHERE nombre='".$municipio_val."' and id_provincia='".$id_provincia."' ") or die(mysqli_error($con));						
					
						$listrowes = mysqli_fetch_array($poblacion_consulta);
						$id_municipio = $listrowes['id_municipio'];
						$total_encontrados = mysqli_num_rows ($poblacion_consulta);							
						mysqli_free_result($poblacion_consulta);						
							
							
							if ($total_encontrados == 0){
							$inmsg.= trim($emailarray1[0])." , ".$user_val.", ".trim($emailarray1[2]).", ".$municipio_val;
							}
							else{
							$mensaje1.= trim($emailarray1[0])." , ".$user_val.", ".trim($emailarray1[2]).", ".$id_municipio." <br/>";	
							}
		
					  }
					}
				  }

			?>
		
		
				Para añadir nuevos suscriptores a su lista escriba  la dirección de correo, el nombre ,  el nif y el identificador del municipi separadas por una coma (,) Use una linea para cada suscriptor , si desconoce el nombre ponga algo como, miembro, usuario..etc  ya que este dato no se puede quedar vacio. La direccion de correo es imprescindible.<br />
				<br/>
                Ejemplo: <br/>
                <ul> carlos@yahoo.es, carlos, 384955l 
               <br/> juan@iespana.es, juan erez, 384752z
                <br/>etc</ul>
                Recuerde elegir el tipo de usuario , añada primero los de un tipo y luego los del otro, no se pueden mezclar.   
			  
                <?php  if($inmsg!=""){?> <br/><div class="alert alert-warning">errores <br/> <?php  echo "$inmsg";?> </div> <?php }?>
                <?php  echo "$mensaje2";?>
                <?php  if($mensaje1!=""){?>
				<br/><div class="alert alert-success"> LISTA modificada
           </div>
				<div class="alert alert-success">  
				<?php  echo "$mensaje1";?></div><?php }?>
				
		  <form Action="<?php $_SERVER['PHP_SELF']?>" Method=POST class="well form-horizontal">	
			
                <?php 	
                  
                    		 // listar para meter en una lista del cuestionario buscador


	$options = "select DISTINCT id, provincia from $tbn8  where especial=0 order by ID";
	$resulta = mysqli_query($con, $options) or die("error: ".mysqli_error($con));
	
	while( $listrows = mysqli_fetch_array($resulta) ){ 
	$id_pro = $listrows[id];
	$name1= utf8_encode($listrows[provincia]);
	$lista1 .="<option value=\"$id_pro\"> $name1</option>"; 
	}
	?>
     <h2> Escoja una Provincia </h2>
    
				<div class="col-sm-4">  <select name="provincia" class="form-control"  id="provincia" ><?php echo "$lista1";?></select>
       	    </div>
	

            <label for="emails"></label>
            <textarea name="emails" cols="80" rows="30" id="emails" class="form-control" ></textarea>
           <p>&nbsp;</p>   <input type="submit" value="cambiar poblaciones"  class="btn btn-primary pull-right" > <p>&nbsp;</p>
			
		  </form>
            
       </div>
       
        <div class="col-md-4" > 
            <h1>&nbsp;</h1>
                   <h1>&nbsp;</h1>
      <h1>consultar poblaciones</h1>
        
        <?php 
		 
						$options = "select DISTINCT id, provincia from $tbn8  order by ID";
						$resulta = mysqli_query($con, $options) or die("error: ".mysql_error($con));
						
						while( $listrows = mysqli_fetch_array($resulta) ){ 
						$id_pro = $listrows[id];
						$name1 = utf8_encode($listrows[provincia]);
						
						if ($id_pro==$row[1]){
						$check="selected=\"selected\" ";
						}
						else{
							$check="";
						}
						$lista .="<option value=\"$id_pro\" $check> $name1</option>";
					}
					 ?>
                   
                      <select name="provincia_2" class="form-control"  id="provincia_2" >
                        <?php echo "$lista";?>
                      </select>
                      
                      <div id="municipio">  </div>
	
        </div>
        
        
        </div>
            
                
    
                    
  					<!--Final-->
  
    
      
 

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
  
        <script type="text/javascript">
			$(document).ready(function(){
				$('#provincia_2').change(function(){
					
				var id_provincia=$('#provincia_2').val();
				$('#municipio').load('genera_select.php?id_provincia='+id_provincia);
				$("#municipio").html(data);
				
				});
			});		
	   </script>
	  
  </body>
</html>