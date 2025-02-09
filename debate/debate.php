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
include('../basicos_php/time_stamp.php');
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
    <link rel="stylesheet" type="text/css" href="estilos_debate.css" />
	<link rel="stylesheet" type="text/css" href="../modulos/msdropdown/css/dd.css" />
	<link rel="stylesheet" href="../js/morris.js-0.4.3/morris.css">
	<link rel="stylesheet" href="../modulos/themes-jquery-iu/base/jquery.ui.all.css">
  

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
        
            <h1> Debate <?php echo "$nombre_votacion" ; ?></h1>
            
            <?php echo "$texto"; ?>
            </div>
            
            
        <div class="col-md-5">
            
                  <!---->
            <div  class="caja_refrescar"> <a href="#" onclick="recargar()"> <span class="glyphicon glyphicon-refresh"></span>&nbsp; Actualizar</a></div>
     <!--columna de comentarios-->   
<div id="wrapper">

<div id="success2"></div>
<?php 

		  $hoy=strtotime(date('Y-m-d')); 
		  $fecha_ini=strtotime($fecha_com);
		  $fecha_fin=strtotime($fecha_fin);


if( $fecha_ini <=$hoy && $fecha_fin >=$hoy  ){  ?>



    
       <form action="javascript: addMessage();" method="post"  class="well"  id="form_wall">
        <div class="etiqueta_debate"> Tu comenatrio ...</div> 
        
        <div class="etiqueta_estado">
        
         <label> 
            <select name="mi_estado" id="mi_estado" accesskey="m" style="width:100px;" >
              
        <option value="">Mi estado </option>
        <option value="angel_32x32.png" data-image="../debate/emoticonos/angel_32x32.png" > </option>
<!--        <option value="angry_32x32.png" data-image="../debate/emoticonos/angry_32x32.png">2</option>-->
        <option value="batman_32x32.png" data-image="../debate/emoticonos/batman_32x32.png" > </option>
        <option value="clown_32x32.png" data-image="../debate/emoticonos/clown_32x32.png"> </option>
        <option value="cool_32x32.png" data-image="../debate/emoticonos/cool_32x32.png"> </option>
        <option value="crying_32x32.png" data-image="../debate/emoticonos/crying_32x32.png"> </option>
    <!--    <option value="devil_32x32.png" data-image="../debate/emoticonos/devil_32x32.png" >7</option>-->
        <option value="displeased_32x32.png" data-image="../debate/emoticonos/displeased_32x32.png"> </option>
        <option value="happy_32x32.png" data-image="../debate/emoticonos/happy_32x32.png" > </option>
        <option value="harrypotter_32x32.png" data-image="../debate/emoticonos/harrypotter_32x32.png"> </option>
        <option value="hypnotize_32x32.png" data-image="../debate/emoticonos/hypnotize_32x32.png"> </option>
        <option value="hypnotized_32x32.png" data-image="../debate/emoticonos/hypnotized_32x32.png"> </option>        
        <option value="inlove_32x32.png" data-image="../debate/emoticonos/inlove_32x32.png" > </option>
        <option value="kiss_32x32.png" data-image="../debate/emoticonos/kiss_32x32.png"> </option>
        <option value="kissed_32x32.png" data-image="../debate/emoticonos/kissed_32x32.png" > </option>
        <option value="laughtingoutloud_32x32.png" data-image="../debate/emoticonos/laughtingoutloud_32x32.png"> </option>
        <option value="money_32x32.png" data-image="../debate/emoticonos/money_32x32.png"> </option>
        <option value="party_32x32.png" data-image="../debate/emoticonos/party_32x32.png"> </option>         
        <option value="pirate_32x32.png" data-image="../debate/emoticonos/pirate_32x32.png" > </option>
        <option value="question_32x32.png" data-image="../debate/emoticonos/question_32x32.png"> </option>
        <option value="sad_32x32.png" data-image="../debate/emoticonos/sad_32x32.png" > </option>
        <option value="sleeping_32x32.png" data-image="../debate/emoticonos/sleeping_32x32.png"> </option>
        <option value="surprised_32x32.png" data-image="../debate/emoticonos/surprised_32x32.png"> </option>
        <option value="terminator_32x32.png" data-image="../debate/emoticonos/terminator_32x32.png"> </option>         
        <option value="tongue_32x32.png" data-image="../debate/emoticonos/tongue_32x32.png" > </option>
        <option value="vomited_32x32.png" data-image="../debate/emoticonos/vomited_32x32.png"> </option>
        <option value="watermelon_32x32.png" data-image="../debate/emoticonos/watermelon_32x32.png" > </option>
        <option value="wink_32x32.png" data-image="../debate/emoticonos/wink_32x32.png"> </option>
            </select>
          </label>
          </div>
         <br />
          <textarea name="msg"  rows="4" id="msg" class="form-control"></textarea>
          <input name="idvot" type="hidden" id="idvot" value="<?php echo  $_GET['idvot'] ; ?>" />
          <input name="IDST" type="hidden" id="IDST" value="<?php echo  $_SESSION['ID']; ?>" />
<input type="submit" name="submit" id="submit" value="comentar" class="btn btn-primary pull-right"/><p>&nbsp;</p>
       </form>
      
    <div id="loading"><img src="../imagenes/cargando.gif" /></div>
    </div>
    
    
    
    <?php }else { echo "<h2>El debate esta cerrado</h2>"; }?>
     <div  class="caja_refrescar"> <a href="#" onclick="recargar()"> <span class="glyphicon glyphicon-refresh"></span>&nbsp; Actualizar</a>
    
    <div id="wall"></div>
    
 </div>       
                  
                  
                  
                  
                  <!---->
        
  
        </div>
        
          <div class="col-md-5">
         <!--columna votaciones-->
 
 <div id="wrapper_votacion">

 
 
    <div id="form"> 
	
       
    <div id="loading_2"><img src="../temas/<?php echo "$tema_web"; ?>/imagenes/cargando.gif" /></div>
    
    <div id="wall_votacion"></div>
    </div>
    
    
    
 </div>

 
 <!--Fin columna votaciones-->
            
        </div>
      
  </div>
 

  <div id="footer" class="row">
   <?php  include("../votacion/ayuda.php"); ?>
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
	<script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
 
	<script src="../modulos/ui/jquery.ui.core.js"></script>
    <script src="../js/raphael-min.js"></script>
    <script src="../js/morris.js-0.4.3/morris.min.js"></script>
    <script src="../modulos/msdropdown/jquery.dd.min.js"></script>
    
    <!--bajar esta libreria y mirar si hace falta-->
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>


	<script type="text/javascript">
	   function addMessage(){
		  
		  //Tomas el valor del campo msg      
		  var msg = $("#msg").val();
		  var idvot = $("#idvot").val();
		  var IDST = $("#IDST").val();
		  var mi_estado = $("#mi_estado").val();
		 // alert(mi_estado);
		  //Si empieza el ajax muestro el loading
		  $("#loading").ajaxStart(function(){
			 $("#loading").show();
		  });
		  
		  //Cuando termina el ajax oculta el loading
		  $("#loading").ajaxStop(function(){
			 $("#loading").hide();
		  });
		  
		  //Se envian los datos a url y al completarse se recarga el muro
		  //con la nueva informacion
		  $.ajax({
			 url: 'action.php',
			 data: 'msg='+ msg+'&idvot='+idvot+'&IDST='+IDST+'&mi_estado='+mi_estado,
			 type: 'post',
			// error: function(obj, msg, obj2){
//			 alert(msg);
//			 },
			 error: function() {		
 				// Fail message
 		 			$('#success2').html("<div class='alert alert-danger'>");
            		$('#success2 > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            	      .append( "</button>");
            		$('#success2 > .alert-danger').append("<strong>Sorry "+ data +" uppps! el servidor no esta respondiendo...</strong> Intetelo despues. Perdone por las molestias!");
 	       		    $('#success2 > .alert-danger').append('</div>');
 		//clear all fields
 					$('#contactForm').trigger("reset");
 	   			 },
			 success: function(data){
				loadWall();
			 }
		  });      
	   };
	   
	   
	</script>
	<script type="text/javascript">
  function loadWall(){
     //Funcion para cargar el muro
     $("#wall").load('wall.php?idgr=<?php echo $_GET['idvot'];?>');
     //Devuelve el campo message a vacio
     $("#msg").val("")
	  var idvot = $("#idvot").val();
  }
  

 
 ////////////////////// script para parte votacion
 function loadWall_votacion(){
     //Funcion para cargar el muro
     $("#wall_votacion").load('wall_votacion.php?idgr=<?php echo $_GET['idvot'];?>&grprp=<?php echo$_SESSION['ID'];?>');
     //Devuelve el campo message a vacio

	 $("#id_pregunta").val("");
	 $("#voto").val("");
	 $("#enviar_voto").val("");
	 
  }
  
  function recargar(){
	$("#wall").fadeOut(1000); 
   $("#wall_votacion").fadeOut(1000);
   loadWall_votacion();
   loadWall(); 
   <!--$(“#contenido”).load(pagina);-->
   $("#wall_votacion").fadeIn(1000);
   $("#wall").fadeIn(1000);
   
 }
  
  //Cuando el documento esta listo carga el muro
 $(document).ready(function(){
   
   loadWall(); 
   
   loadWall_votacion();
   
 });
 
 </script>
<script type="text/javascript">
			<!--scrip para el combobox-->
			$(document).ready(function(e) {
				$("#mi_estado").msDropdown({visibleRows:5});
				<!--$("#tech").msDropdown();-->
			});
        </script>
		<script type="text/javascript">
			<?php 
			  
			  //////miramos si hay preguntas para el loop del addVoto()
			$query_pregunta = mysqli_query($con,"SELECT  ID, pregunta, respuestas , id_votacion  FROM $tbn13  where id_votacion= '$idvot' ");
			//Si la consulta es verdadera
			if($query_pregunta == true){
			   //Recorro todos los campos de la tabla y los muestro
			
			   while ($row_pregunta = mysqli_fetch_array($query_pregunta)){
			
				?> 
					function addVoto_<?php echo $row_pregunta['ID'] ;?>(){
					
					  //Tomas el valor del campo msg      
					  var id_usuario = $("#id_usuario").val();
					  var id_votacion = $("#id_votacion").val();
					  var id_pregunta = $("#id_pregunta<?php echo $row_pregunta['ID'] ;?>").val();
					  var voto = $("[name='voto<?php echo $row_pregunta['ID'] ;?>']:checked").val();
					  var enviar_voto = $("#enviar_voto").val();
					  var IDST = $("#IDST").val();
					  
					  //Si empieza el ajax muestro el loading
					  $("#loading_2").ajaxStart(function(){
						 $("#loading_2").show();
					  });
					  
					  //Cuando termina el ajax oculta el loading
					  $("#loading_2").ajaxStop(function(){
						 $("#loading_2").hide();
					  });
					  
					  //Se envian los datos a url y al completarse se recarga el muro
					  //con la nueva informacion
					  $.ajax({
						 url: 'action_voto.php',
						 data: 'id_votacion='+ id_votacion+'&id_pregunta='+id_pregunta+'&voto='+voto+'&id_usuario='+id_usuario+'&enviar_voto='+enviar_voto+'&IDST='+IDST,
						 type: 'post',
						 error: function(obj, msg, obj2){
							alert(msg);
						 },
						 success: function(data){
							loadWall_votacion();
						 }
					  });      
				   };
				   
			  <?php 
			 	 }
				}
				?>
      
    </script>
  </body>
</html>