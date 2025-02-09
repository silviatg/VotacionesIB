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
    
    
    
    <!—[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]—>
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../js/morris.js-0.4.3/morris.css">

 
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
        <!--Comiezo--><h1><?php echo "$nombre_votacion" ; ?></h1>
        <?php echo "$resumen"; ?>
		<?php 
		
		
			if($activos_resultados=="no") {
				echo " <div class=\"alert alert-danger\">No esta autorizado ver los resultados de esta votacion </div>";
			}
			else
			{
				echo "<b><i>SISTEMA DE SEGURIDAD DE LA VOTACIÓN: </i></b><br/><br/>";
				
				if ($permitir_votar_admin <> ""){
					echo "<i>- RECUENTO DE VOTOS PRESENCIALES:</i><br/>
					Se han introducido todos los votos en la web a medida que se votaban presencialmente, por lo que son contabilizados 
					todos los votos como votos ONLINE";
				}
				else if ($mostrar_todas_opciones == "N"){
					echo "<i>- RECUENTO DE VOTOS PRESENCIALES:</i><br/>
					El recuento de votos presenciales se ha llevado a cabo con todas las garantías democráticas, por el Comité Electoral aprobado
					en asamblea constituyente. El Comité Electoral es un órgano plural, compuesto por todas las organizaciones que forman Imagina Burgos, más
					2 personas del grupo de coordinación, 1 persona del grupo de comunicación y 4 personas elegidas mediante sorteo en 
					la asamblea de 28 de Febrero de 2015. Se ha hecho un doble recuento presencial para confirmar los resultados.";
				}				
				
				//vota_primarias_ver.php => ESTA ES LA PANTALLA PARA COMPROBAR QUE TU VOTO NO HA CAMBIADO (USANDO LA CONTRASEÑA)
				$dir="../vota_orden/vota_primarias_ver.php";	  
				if($seguridad==2 || $seguridad ==4 ){
					echo "<br/><br/><i>- RECUENTO DE VOTOS ONLINE:</i><br/><a href=".$dir."?idvot=".$idvot."  class=modify>Puede comprobar que su voto no ha sido modificado y está correctamente contabilizado</a><br/> <br/> ";
					
					//STG-CORREGIDO: Antes mostraba siempre que se han enviado papeletas, aunque solo hubiera interventores
					// del tipo 2, que no reciben papeletas (son para la inserción del voto presencial en urna).
					if($seguridad==4){
						//STG: Buscamos interventores de tipo "correo-0 o especial-1" (CREO QUE los de tipo 2, correo+especial, no reciben papeleta, son para insertar votos presenciale)
					    $sql = "SELECT nombre, apellidos FROM $tbn11 WHERE id_votacion = '$idvot'  and tipo<=1";
					    $result = mysqli_query($con, $sql);
					    if ($row = mysqli_fetch_array($result)){
							echo "Además esta votación ha enviado una papeleta  anónima con su voto  a los interventores<br/> <br/> ";
						}
					}
				}
				
		?>
				<div>
     
     
				<?php 
	 
				$id_pro=$_GET['id_pro'];
				/* esto si quisieramos saber cuantos votos hay de cada tipo de votante
			
				$sql = "SELECT ID, COUNT(tipo_votante) FROM $tbn2  WHERE id_votacion = '$idvot'   GROUP BY  	id_provincia ";
				$result = mysql_query($sql, $con);*/
			
				//STG: Sacaba también los presenciales, y no cuadraba la suma.
				$sql = "SELECT ID FROM $tbn2  WHERE id_votacion = '$idvot' and forma_votacion <> 'presencial'";		
				$result_num_online = mysqli_query($con,$sql);
				$numero_votantes_online = mysqli_num_rows($result_num_online); // obtenemos el número de filas
			
				//EN LA TABLA DE VOTOS
				// Votos en blanco
				$sql = "select distinct vote_id from $tbn10 WHERE id_votacion = '$idvot' and otros=2";  
				$result = mysqli_query($con,$sql);
				$blancos = mysqli_num_rows($result); // obtenemos el número de filas  

				// Votos en nulos
				$sql = "select distinct vote_id from $tbn10 WHERE id_votacion = '$idvot' and otros=1";  
				$result = mysqli_query($con,$sql);
				$nulos = mysqli_num_rows($result); // obtenemos el número de filas
				// Votos en urna
				$sql = "select distinct vote_id from $tbn10 WHERE id_votacion = '$idvot' and especial=1";  
				$result = mysqli_query($con,$sql);
				$urna = mysqli_num_rows($result); // obtenemos el número de filas

				if ($row = mysqli_fetch_array($result_num_online)){
					
					if ($permitir_votar_admin == ""){
					?>
					<div class="alert alert-danger">
							<strong><h2> RESULTADOS DE LA VOTACIÓN ONLINE </h2>
							<br>Los votos presenciales depositados en urna se contabilizan aparte por el comité electoral.
							<br>Puede consultar los resultados globales incluyendo los votos presenciales en nuestra web, 
							<a href="https://imaginaburgos.es/resultados-de-primarias/" target="_blank">pulsando aquí.</a>						
							</strong>
					</div>
					<?php } ?>
					
					
					<div class="jumbotron">						
					
					<p class="lead">Número de votantes <?php echo  "$numero_votantes_online" ?></p>
					<p class="lead">Votos en blanco: <?php echo  "$blancos" ?></p>
					<p class="lead">Votos nulos: <?php echo  "$nulos" ?></p>
					<?php if ($urna!=0){?>
					<p class="lead">Votos introducidos de urna: <?php echo  "$urna" ?></p>
					<?php }?>
					</div>
		  <?php } 
			
				$sexo="M";
		  
				$sql = "SELECT a.id_candidato, COUNT(a.id_candidato),b.nombre_usuario,sum(a.voto) FROM $tbn10 a, $tbn7 b WHERE (a.id_candidato=b.ID) and  a.id_votacion = '$idvot' and b.sexo LIKE '$sexo'  GROUP BY a.id_candidato  ORDER BY sum(a.voto) desc ";
				$result = mysqli_query($con, $sql);
				
				if ($row = mysqli_fetch_array($result)){
					$i=1;	
	  ?>
					<div class="row">
						<div class="col-md-6" > 
							<h2>Resultado femenino</h2>       
							  
							<table class="table table-striped">
								<tr>
								  <th>P</th>
								  <th>Candidata</th>
								  <th>Puntuación</th>
								  <th>Nº votos</th>
								</tr>     
    <?php 			mysqli_field_seek($result,0);
					do {

						$sexo="capam";	
 ?> 
 
							  <tr>
								<td><?php echo  $i++ ?></td>
								<td><?php echo  $row[2]; ?></td>
								<td><?php echo  $row[3];?></td>
								<td><?php echo  $row[1];?></td>
							  </tr>
          
        <?php
							$array_datos_res.="{label: '$row[2]', value:$row[3] },";
							$array_datos_f.="{label: '$row[2]', value:$row[3] },";
						}
						while ($row = mysqli_fetch_array($result));
?>
							</table>      
						</div>

						<div class="col-md-6" > 
							<div> <h3>Grafica</h3>
								<div id="donut_resultado_f"  class="resultadosDonut"></div>    
								<div id="tabla_resultado_f"  class="resultadosGrafica"></div>
                    
							</div>
						</div>
					</div>
      
    <?php 
				} 
?>
   
			</div>
			<div>
      <?php 	$sexo="H";
				
				$sql = "SELECT a.id_candidato, COUNT(a.id_candidato),b.nombre_usuario,sum(a.voto) FROM $tbn10 a, $tbn7 b WHERE (a.id_candidato=b.ID) and a.id_votacion = '$idvot' and b.sexo LIKE '$sexo'  GROUP BY a.id_candidato  ORDER BY sum(a.voto) desc ";
				$result = mysqli_query($con, $sql);

				if ($row = mysqli_fetch_array($result)){				
					$i=1;
?>
					<div class="row">
						<div class="col-md-6" > 
							<p>&nbsp;</p>
							<h2> Resultado Masculino </h2>     
					 
							<table class="table table-striped">
								<tr>
								  <th>P</th>
								  <th>Candidato</th>
								  <th>Puntuación</th>
								  <th>Nº votos</th>
								</tr> 
        <?php
						mysqli_field_seek($result,0);
						do {
							$sexo="capah";
 ?>
 
						   <tr>
							<td><?php echo  $i++ ?></td>
							<td><?php echo  "$row[2]" ?></td>
							<td><?php echo $row[3]; // echo  number_format($row[3], 0, ",",".") ?></td>
							<td><?php echo $row[1];// echo  number_format($row[1], 0, ",",".") ?></td>
						  </tr>
		  <?php 			$array_datos_res.="{label: '$row[2]', value:$row[3] },";
							$array_datos_m.="{label: '$row[2]', value:$row[3] },";
						}
						while ($row = mysqli_fetch_array($result));
?>

							</table>  
						</div> 
						<div class="col-md-6" > 
		  
							<div> <h3>Grafica</h3>
										<div id="donut_resultado_m"  class="resultadosDonut"></div>    
										<div id="tabla_resultado_m"  class="resultadosGrafica"></div>
										
							</div>
						</div>
					</div> 
    <?php   	}   ?>
   
			</div>
			<div>
	<?php 
				$sexo="O";
				$sql = "SELECT a.id_candidato, COUNT(a.id_candidato),b.nombre_usuario,sum(a.voto) FROM $tbn10 a, $tbn7 b WHERE (a.id_candidato=b.ID) and  a.id_votacion = '$idvot' and b.sexo LIKE '$sexo'  GROUP BY a.id_candidato  ORDER BY sum(a.voto) desc ";
				$result = mysqli_query($con, $sql);
				

				if ($row = mysqli_fetch_array($result)){
					$i=1;
?>
<!--  resultado cuando el sexo es neutro-->
		<h2> Resultados tras aplicar la lista cremallera de género</h2> 
		
		<img src="../temas/<?php echo "$tema_web"; ?>/imagenes/RESULTADOS-PRIMARIAS-IB_CREMALLERA.gif"?>
		
		<h2> Resultados votación ONLINE</h2> 
		
		<?php if ($permitir_votar_admin == ""){ ?> 			
		(Antes de sumar los votos presenciales, y sin aplicar la lista cremallera)
		<?php } ?>
		
			 <?php
				mysqli_field_seek($result,0);
				do {
					$sexo="capan";
			 ?> 
				<div class="capasexo <?php echo  "$sexo" ?>" >
				<?php echo  $i++ ?> &nbsp; &nbsp;| |&nbsp; &nbsp; 
				<?php echo  "$row[2]" ?> <i><br/>&nbsp; &nbsp; Tiene:
				<?php echo  "$row[1]" ?> votos y la suma es <?php echo round("$row[3]",2) ?> puntos.</i>
				</div>
			
			 <?php 	$array_datos_res.="{label: '$row[2]', value:$row[3] },";
				}
				while ($row = mysqli_fetch_array($result));

				$array_datos_r=substr($array_datos_res, 0, -1);

			 ?>
				<script type="text/javascript">
					var array_js = new Array();
					array_js=[
				   <?php  echo "$array_datos_n";?>
				  ];
				</script>  
      
				<?php 
				} else {
				}
			 ?>   
			 </div>
      
	<?php   } //Fin si resultados_Activos="S"?>
	
		  <script type="text/javascript">
			var array_js = new Array();
			array_js=[
				<?php  echo "$array_datos_res";?>
				];
		  </script> 
		  
		  <h2> Resultados Detallados - votación ONLINE</h2>
		<strong>
			Puede consultar los votos depositados para cada persona candidata de forma más detallada <a href="../temas/<?php echo "$tema_web"; ?>/imagenes/RESULTADOS_PRIMARIAS_2019_IB_DETALLADO.pdf" target="_blank">pulsando aquí.</a>						
		</strong>
		<br/>	<br/>
		
		
			<!---->				
			<!---->				
			<div> <h3>Resultado Global - Online</h3>
                    <div id="donut_resultado"></div>    
                    <div id="tabla_resultado"></div>
                    
			</div> 
        
        </div>                
       <!--Final-->
        
        <!--  <div class="col-md-3">
		<?php  // include("lateral_derecho.php"); ?>              
        </div>-->
		<i><br/> * Para cualquier consulta o aclaración adicional, diríjase al email: votaciones@imaginaburgos.es</i>
    </div>

 

	<div id="footer" class="row">
		<?php  include("../votacion/ayuda.php"); ?>
		<?php  include("../temas/$tema_web/pie.php"); ?>
	</div>
</div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
	<script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script> 
      
	<script src="../js/raphael-min.js"></script>
	<script src="../js/morris.js-0.4.3/morris.min.js"></script>
    <script type="text/javascript">
	var array_colores = new Array();
	array_colores=[
    
    '#0066CC',
	'#FF8000',
	'#FDF512',
	'#F912FD',
	'#BBD03F',
	'#12DEFD',
	'#9102C6',
	'#39FF08',
	'#0BA462',
    '#990000'
  ];
// Use Morris.Bar
new Morris.Bar({
  element: 'tabla_resultado',
  data: array_js, //array de los datos
  xkey: 'label',
  ykeys: ['value'],
  labels: ['Y'],
  backgroundColor: '#9D9D9D',
 /* barFillColors: [
    '#39FF08 #555',      // from light gray to dark gray (top to bottom)
    '#555 #aaa black' // from dark day, through light gray, to black
  ]*/
 /* */
 barColors:
   function (row, series, type) {
    if (type === 'bar') {
      var blue = Math.ceil(255 * row.y / this.ymax);
      return 'rgb(43,200,' + blue + ')';
    }
    else {
      return '#000';
    }
  }
});
		
		
		
		
		
/*
 * Play with this code and it'll update in the panel opposite.
 *
 * Why not try some of the options above?
 */
new Morris.Donut({
  element: 'donut_resultado',
  data: array_js, //array de los datos
   backgroundColor: '#9D9D9D',
  labelColor: '#060',
  colors: array_colores 
  /*formatter: function (x) { return x + "%"} // da la funcion en porcentajes y no en absolutos
  */
});



</script>

   <script type="text/javascript">
	var array_js = new Array();
	array_m=[
   <?php  echo "$array_datos_m";?>
  ];
  </script>    
            
      <script type="text/javascript">          
new Morris.Bar({
  element: 'tabla_resultado_m',
  data: array_m, //array de los datos
  xkey: 'label',
  ykeys: ['value'],
  labels: ['Y'],
  backgroundColor: '#9D9D9D',
 /* barFillColors: [
    '#39FF08 #555',      // from light gray to dark gray (top to bottom)
    '#555 #aaa black' // from dark day, through light gray, to black
  ]*/
 /* */
 barColors:
   function (row, series, type) {
    if (type === 'bar') {
      var blue = Math.ceil(255 * row.y / this.ymax);
      return 'rgb(43,200,' + blue + ')';
    }
    else {
      return '#000';
    }
  }
});
		
		
		
		
		
/*
 * Play with this code and it'll update in the panel opposite.
 *
 * Why not try some of the options above?
 */
new Morris.Donut({
  element: 'donut_resultado_m',
  data: array_m, //array de los datos
   backgroundColor: '#9D9D9D',
  labelColor: '#060',
  colors: array_colores 
  /*formatter: function (x) { return x + "%"} // da la funcion en porcentajes y no en absolutos
  */
});



</script>

   <script type="text/javascript">
	var array_js = new Array();
	array_f=[
   <?php  echo "$array_datos_f";?>
  ];
  </script>    
            
      <script type="text/javascript">          
new Morris.Bar({
  element: 'tabla_resultado_f',
  data: array_f, //array de los datos
  xkey: 'label',
  ykeys: ['value'],
  labels: ['Y'],
  backgroundColor: '#9D9D9D',
 /* barFillColors: [
    '#39FF08 #555',      // from light gray to dark gray (top to bottom)
    '#555 #aaa black' // from dark day, through light gray, to black
  ]*/
 /* */
 barColors:
   function (row, series, type) {
    if (type === 'bar') {
      var blue = Math.ceil(255 * row.y / this.ymax);
      return 'rgb(43,200,' + blue + ')';
    }
    else {
      return '#000';
    }
  }
});
		
		
		
		
		
/*
 * Play with this code and it'll update in the panel opposite.
 *
 * Why not try some of the options above?
 */
new Morris.Donut({
  element: 'donut_resultado_f',
  data: array_f, //array de los datos
   backgroundColor: '#9D9D9D',
  labelColor: '#060',
  colors: array_colores 
  /*formatter: function (x) { return x + "%"} // da la funcion en porcentajes y no en absolutos
  */
});



</script>
  </body>
</html>