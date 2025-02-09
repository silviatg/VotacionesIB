<?php 
include('verifica.php');
//$nivel_acceso=11; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
	if(empty ($_SESSION['numero_vot'])){
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
 
 <div class="container">
 
    <!-- cabecera
    ================================================== -->
      <div class="page-header">
      <img src="../temas/<?php echo "$tema_web"; ?>/imagenes/cabecera_votaciones.jpg" class="img-responsive" alt="Logo <?php echo "$nombre_web"; ?>">
	  </div>
      
    <!-- END cabecera
    ================================================== -->
     

       <div class="row">
        

        
        
        <div class="col-md-2" >             
          
         <a href="log_out.php">SALIR</a>
         
         </div>
       
        
        
        <div class="col-md-10">
     
                   <!--Comiezo-->
                   
                <h1> Ha accedido a la votación <strong>" <?php echo $_SESSION['nombre_votacion'];?> "</strong> como interventor.</h1>
               <h3><span class="label label-warning"> Recuerde que quedara registrado en todos los votos que incluya los interventores que lo estan haciendo</span></h3>
                
              <h3> Esta votacion necesita la validacion de<strong> <?php echo $_SESSION['numero_inter'];?></strong> interventores para permitir incluir datos de las votaciones en urna </h3>
    
    
    <?php if ($_SESSION['numero_inter']!=1){
		        echo " <div class=\"alert alert-success\"> Se registrado el primer interventor que ejerce las funciones de presidente de mesa y su nombre es ". $_SESSION['nombre_inter_0']." " . $_SESSION['apellidos_inter_0']." </div> ";
		$faltan_validar =$_SESSION['numero_inter'];
		//empezamos con el 1, ya que el primero lo tenemos ya egistrado en la sesison
		$contador=1;
		for($i=1;$i<$faltan_validar;$i++) {
			
$ID_inter ="ID_inter_".$i;
if(isset ($_SESSION[$ID_inter])){
	
    $usuario="usuario_".$i;
	$nombre_inter="nombre_inter_".$i;
	$apellidos_inter="apellidos_inter_".$i;
	
   echo "<div class=\"alert alert-success\"> registrado el Interventor".$_SESSION[$nombre_inter]." ". $_SESSION[$apellidos_inter] ." con nombre de usuario ". $_SESSION[$usuario] ."<br/> </div>";

	$contador= $contador + 1;
	
	
}else{
			 ?>


<div id="caja_<?php echo $i; ?>">
Registro del interventor <?php echo $i+1; ?> de <?php echo $_SESSION['numero_inter'];?>

<!--<form name="form1" method="post" action="add_interventor.php"  class="well form-horizontal"> -->

 <form name="form1" method="post" action=""  class="well form-horizontal" onSubmit="GrabarInterventor_<?php echo $i; ?>(); return false">
 
  <div class="form-group">         
            
  <label for="usuario"  class="col-sm-3 control-label">Usuario Interventor <?php echo $i+1; ?></label>
  <div class="col-sm-5">
  <input type="text" name="usuario_<?php echo $i; ?>" id="usuario_<?php echo $i; ?>"  class="form-control"> 
  </div></div>
  <div class="form-group">        
  <label for="passwordx"  class="col-sm-3 control-label" >Password interventor <?php echo $i+1; ?></label>
  <div class="col-sm-5">
  <input type="password" name="password_<?php echo $i; ?>" id="password_<?php echo $i; ?>"  class="form-control">
  </div>
  <div class="col-sm-4">
  <input type="submit" name="regsitrar" id="regsitrar" value="Validar interventor  <?php echo $i +1; ?> " class="btn btn-primary pull-right"  >

  </div></div>
  <input name="n_interventor" type="hidden" id="n_interventor" value="<?php echo $i; ?>"> 

</form>
			<script type="text/javascript">
				function GrabarInterventor_<?php echo $i; ?>(){
					
					  //Tomas el valor del campo msg      
					  var usuario = $("#usuario_<?php echo $i; ?>").val();
					  var password = $("#password_<?php echo $i; ?>").val();
					  var n_interventor = <?php echo $i; ?>;
					  var votacion1 = <?php echo $_SESSION['numero_vot']; ?>;
					  
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
						 url: 'add_interventor.php',
						 data: 'usuario='+ usuario+'&password='+password+'&votacion1='+votacion1+'&n_interventor='+n_interventor,
						 type: 'post',
						 error: function(obj, msg, obj2){
							alert(msg);
						 },
						 success: function(data){ 					
						 //$(".datos_BBDD").html('' + data +' ');	 
							 if(data == 'Error1'){
       							 
								  $(".datos_BBDD_<?php echo $i; ?>").html('<div class="alert alert-warning"> ¡¡' + data +'!!<br/> hay un error tipo 1, usuario, password o tipo de interventor incorrectos </div>');// Incluimos el dato que nos devuelve el php con el nombre del lo que se ha incluido correctamente (no funciona)
							 }else if(data == 'Error2'){
       							  $(".datos_BBDD_<?php echo $i; ?>").html('<div class="alert alert-warning"> ¡¡' + data +'!!<br/>Este usuario ya esta autentificado como interventor, introduzca otro </div>');// Incluimos el dato que nos devuelve el php con el nombre del lo que se ha incluido correctamente (no funciona)
							 }else if(data == 'Error3'){
       							  $(".datos_BBDD_<?php echo $i; ?>").html('<div class="alert alert-warning"> ¡¡' + data +'!!<br/>Faltan datos</div>');// Incluimos el dato que nos devuelve el php con el nombre del lo que se ha incluido correctamente (no funciona)
							 }else if(data == 'Error4'){
       							  $(".datos_BBDD_<?php echo $i; ?>").html('<div class="alert alert-warning"> ¡¡' + data +'!!<br/>Esta votacion no admite interventores</div>');// Incluimos el dato que nos devuelve el php con el nombre del lo que se ha incluido correctamente (no funciona)
							 }
							 else{
      			 				
								 $(".loading").hide("slow"); //escondemos el efecto de cargando (no funciona)
								 $("#caja_<?php echo $i; ?>").hide("slow");	///escondemos donde pone lo de votar
								 $(".datos_BBDD_<?php echo $i; ?>").html('' + data +' ');// Incluimos el dato que nos devuelve el php con el nombre del lo que se ha incluido correctamente (no funciona)
								loadAcceso();
  					 		 }
						  }
					  });      
				   };
			</script>
</div>
<div class="datos_BBDD_<?php echo $i; ?>"> </div>
<?php } 
}
		
		
	}else if ($_SESSION['numero_inter']==1){
		echo "<br/><br/>";
		echo "en esta votacion puede acceder con un solo interventor para añadir papeletas <br/><br/><br/>";
		
		if($_SESSION['tipo']==1){
			 $dir="../vota_orden/voto_primarias.php";
			 $texto1_activo="Introducir votos manualmente ";
			 $image_activo="<span class=\"glyphicon glyphicon-thumbs-up  text-success\"></span>";
			 
		  }
		  else if($_SESSION['tipo']==2){
			  $dir="../vota_vut/vut.php";
			 $texto1_activo="Introducir votos manualmente ";
			 $image_activo="<span class=\"glyphicon glyphicon-thumbs-up  text-success\"></span>";
		  }
		  else if($_SESSION['tipo']==3){
			  $dir="../vota_encuesta/vota_encuesta.php";
			  $texto1_activo="Introducir votos manualmente ";
			 $texto2_activo="Votacion NO activa";
			 $image_activo="<span class=\"glyphicon glyphicon-thumbs-up  text-success\"></span>";
		  }else {
			  
			  }
		  
	$activo1="$texto1_activo $image_activo";	
	$activo="<a href='$dir?idvot=$row[0]' >$texto1_activo</a>";
		echo $activo;
	}else {
		echo"<p>Ups!!! algo raro esta pasando, vuelva a acceder</p>";
	}
	echo "<br/><br/><br/><br/>";?>
    
    <div id="acceso"></div>
    <?php
//echo "<pre>"; 
//print_r($_SESSION); 
//echo "</pre>"; 
?>
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
  
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>  
 
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
<script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
  function loadAcceso(){
     //Funcion para cargar el muro
     $("#acceso").load('acceso.php?idvot=<?php echo ($_SESSION['numero_vot']); ?>');
     //Devuelve el campo message a vacio
    // $("#msg").val("")
	  //var idvot = $("#idvot").val();
  }
  
</script>

<?php 

if ($_SESSION['numero_inter']==$contador){
		//echo "Ya estan validados todos los interventores para esta votación<br/>";
		 ?>
		 <script type="text/javascript">
				$(document).ready(function(){
        		loadAcceso(); 
	   			 });
				 </script>
		 <?php
	}
?>

				<!--<script type="text/javascript">
				$(document).ready(function(){
        		loadAcceso(); 
	   			 });
				 </script>-->
  
  </body>
</html>