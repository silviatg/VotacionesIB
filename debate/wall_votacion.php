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
session_start();
require_once("../inc_web/config.inc.php");
//include('../inc_web/seguri.php'); 
include('../basicos_php/time_stamp.php');
include('../basicos_php/basico.php');
   
 $idvot= fn_filtro_numerico($con,$_GET['idgr']);
$id_user= fn_filtro_numerico($con,$_GET['grprp']);


$sql3 = "SELECT  fecha_com, fecha_fin  FROM $tbn1 WHERE ID ='$idvot' ";
$resulta3 = mysqli_query($con, $sql3) or die("error: ".mysqli_error());
	
	while( $listrows3 = mysqli_fetch_array($resulta3) ){ 
	$fecha_com  = $listrows3[fecha_com]; 	
	$fecha_fin  = $listrows3[fecha_fin];
}
		  $hoy=strtotime(date('Y-m-d')); 
		  $fecha_ini=strtotime($fecha_com);
		  $fecha_fin=strtotime($fecha_fin);

if( $fecha_ini <=$hoy && $fecha_fin >=$hoy  ){
$estado_votacion="abierto";
}
/*echo	$fecha_com; 	
	echo $fecha_fin; 
	*/
$query_pregunta = mysqli_query($con, "SELECT  ID, pregunta, respuestas , id_votacion  FROM $tbn13  where id_votacion= '$idvot' ");

//Si la consulta es verdadera
if($query_pregunta == true){
   //Recorro todos los campos de la tabla y los muestro
  $quants=mysqli_num_rows($query_pregunta);
 ?>
  <script type="text/javascript">
 $(document).ready(function(){
   var elem4=$('#botonvergrafica');
   var elem=$('.resultados_donut');
	elem.hide();
	elem4.hide(); 
 });
 </script>
 
 <h4> Este debate tiene <?php echo $quants; ?> pregunta<?php if($quants>1){echo "s";} ?></h4>

 <?php
   while ($row_pregunta = mysqli_fetch_array($query_pregunta)){
//////////////////// limpiamos variables del loop anterior si lo hay
$chekea1="";
$chekea2="";
$chekea3="";
$chekea4="";
$chekea5="";
$ha_votado1="";
$ha_votado2="";
$ha_votado3="";
$ha_votado4="";
$ha_votado5="";
$clase_votado1="";
$clase_votado2="";
$clase_votado3="";
$clase_votado4="";
$clase_votado5="";	
$boton_voto="";	
	 
	 ////////////miramos si ha votado y el que para indcarlos
$query_votoa = mysqli_query($con, "SELECT  voto   FROM $tbn14  where id_pregunta = '".$row_pregunta['ID']."' and id_votante ='".$id_user."' ");

//Si la consulta es verdadera
if ($row_votoa = mysqli_fetch_array($query_votoa))
{
mysqli_field_seek($query_votoa,0);

do { 

				if($row_votoa['voto']==1){
					 $boton_voto="modificar";
						$chekea1="checked=\"checked\" ";
						$ha_votado1="Su voto actual";
						$clase_votado1="class=\"marca_votado\"";
				 }
				else if($row_votoa['voto']==2){
					$boton_voto="modificar";
						$chekea2="checked=\"checked\" ";
						$ha_votado2="Su voto actual";
						$clase_votado2="class=\"marca_votado\"";
						 }
				else if($row_votoa['voto']==3){
					$boton_voto="modificar";
						$chekea3="checked=\"checked\" ";
						$ha_votado3="Su voto actual";
						$clase_votado3="class=\"marca_votado\"";
						 }
				else if($row_votoa['voto']==4){
					$boton_voto="modificar";
						$chekea4="checked=\"checked\" ";
						$ha_votado4="Su voto actual";
						$clase_votado4="class=\"marca_votado\"";
						 }
				else if($row_votoa['voto']==5){
					$boton_voto="modificar";
						$chekea5="checked=\"checked\" ";
						$ha_votado5="Su voto actual";
						$clase_votado5="class=\"marca_votado\"";
						
					}
		}

while ($row_votoa = mysqli_fetch_array($query_votoa));
}
else{
$chekea1="";
$chekea2="";
$chekea3="checked=\"checked\" ";
$chekea4="";
$chekea5="";
$ha_votado1="";
$ha_votado2="";
$ha_votado3="";
$ha_votado4="";
$ha_votado5="";
$clase_votado1="";
$clase_votado2="";
$clase_votado3="";
$clase_votado4="";
$clase_votado5="";
$boton_voto="";
}

  
	   ?>  
    



<div class="fondo_voto">

<div class="titular-voto contenido-comentario">
	<?php echo $row_pregunta['pregunta'];
	
	?>
	
  </div>
  
  <?php 

		  $hoy=strtotime(date('Y-m-d')); 
		  $fecha_ini=strtotime($fecha_com);
		  $fecha_fin=strtotime($fecha_fin);


if( $estado_votacion=="abierto" ){  ?>
  
  
  
  
	<div class="texto_mensaje">
	<form id="form<?php echo $row_pregunta['ID'] ;?>" name="form<?php echo $row_pregunta['ID'] ;?>" method="post" action="javascript: addVoto_<?php echo $row_pregunta['ID'] ;?>();">
	 
     
     <?php 
	 $respuestas=$row_pregunta['respuestas'];
	 
	 switch($row_pregunta['respuestas']){
		case 2:
			echo "Tienes 2 posibles respuestas";?>
			
            
        <p>&nbsp;</p>
            
            <table width="100%" border="0">
              <tr>
                <td>
                <div  <?php echo $clase_votado1 ;?>  ><label class="nik_debate">
	        <input name="voto<?php echo $row_pregunta['ID'] ;?>" type="radio"  id="voto_0" value="1"  checked="checked"  />
	        Me gusta</label> 
                  <div class="info_voto"><?php echo $ha_votado1; ?></div></div>
            </td></tr><tr><td>
	   <div  <?php echo $clase_votado2 ;?>  >
	      <label class="nik_debate" >
	        <input type="radio" name="voto<?php echo $row_pregunta['ID'] ;?>" value="2" id="voto_1"  <?php echo $chekea2; ?>/>
	        No me gusta</label> 
	      <div class="info_voto"><?php echo $ha_votado2; ?></div></div>
            
            </td></tr></table>
			
			
            
            
	  <?php 
			break;
		case 3:
			echo "Tienes 3 posibles respuestas";?>
			
         <p>&nbsp;</p>
            
            <table width="100%" border="0">
              <tr>
                <td>
                <div  <?php echo $clase_votado1 ;?>  ><label class="nik_debate">
	        <input name="voto<?php echo $row_pregunta['ID'] ;?>" type="radio"  id="voto_0" value="1"   <?php echo $chekea1; ?>/>
	        Me gusta</label> 
                  <div class="info_voto"><?php echo $ha_votado1; ?></div></div>
	   </td></tr><tr><td>
       <div  <?php echo $clase_votado3 ;?>  >
	      <label class="nik_debate" >
	        <input type="radio" name="voto<?php echo $row_pregunta['ID'] ;?>" value="3" id="voto_2"   <?php echo $chekea3; ?>/>
	        No lo tengo claro</label> 
	      <div class="info_voto"><?php echo $ha_votado3; ?></div></div>
            </td></tr><tr><td>
            <div  <?php echo $clase_votado2 ;?>  >
	      <label class="nik_debate" >
	        <input type="radio" name="voto<?php echo $row_pregunta['ID'] ;?>" value="2" id="voto_1" <?php echo $chekea2; ?> />
	        No me gusta</label> 
	      <div class="info_voto"><?php echo $ha_votado2; ?></div></div>
	   </td></tr></table>
            
            
            
            
			<?php 
			break; 
		case 4:
			echo "Tienes 4 posibles respuestas";?>
            
          <p>&nbsp;</p>
            
            <table width="100%" border="0">
              <tr>
                <td>
                <div  <?php echo $clase_votado1 ;?>  >
			<label class="nik_debate">
	        <input name="voto<?php echo $row_pregunta['ID'] ;?>" type="radio"  id="voto_0" value="1"  <?php echo $chekea1; ?>/>
	        Me gusta</label> 
			<div class="info_voto"><?php echo $ha_votado1; ?></div></div>
            </td></tr><tr><td>
            <div  <?php echo $clase_votado3 ;?>  >
	   		<label class="nik_debate" >
	        <input type="radio" name="voto<?php echo $row_pregunta['ID'] ;?>" value="3" id="voto_2"  <?php echo $chekea3; ?> />
	        No lo tengo claro</label> 
	   		<div class="info_voto"><?php echo $ha_votado3; ?></div></div>
            </td></tr><tr><td>
            <div  <?php echo $clase_votado2 ;?>  >
	      	<label class="nik_debate" >
	        <input type="radio" name="voto<?php echo $row_pregunta['ID'] ;?>" value="2" id="voto_1"  <?php echo $chekea2; ?>/>
	        No me gusta</label> 
	      	<div class="info_voto"><?php echo $ha_votado2; ?></div></div>
	      </td></tr><tr><td>
          <div  <?php echo $clase_votado4 ;?>  >
            <label class="nik_debate" >
	        <input type="radio" name="voto<?php echo $row_pregunta['ID'] ;?>" value="4" id="voto_3"  <?php echo $chekea4; ?>/>
	        No me gusta nada. Bloqueo</label> <div class="info_voto"><?php echo $ha_votado4; ?> </div></div>
            </td></tr></table>
            
            
            
            
			<?php 
			break ;	
		case 5:
			echo "Tienes 5 posibles respuestas";?>
            
            <p>&nbsp;</p>
            
            <table width="100%" border="0">
              <tr>
                <td>
                <div  <?php echo $clase_votado5 ;?>  >
            <label class="nik_debate" >
	        <input type="radio" name="voto<?php echo $row_pregunta['ID'] ;?>" value="5" id="voto_4"  <?php echo $chekea5; ?>/>
	        Me gusta mucho.</label> <div class="info_voto"><?php echo $ha_votado5; ?></div></div>
            </td></tr><tr><td>
            <div  <?php echo $clase_votado1 ;?>  >
            
			<label class="nik_debate">
	        <input name="voto<?php echo $row_pregunta['ID'] ;?>" type="radio"  id="voto_0" value="1"  <?php echo $chekea1; ?>/>
	        Me gusta</label> <div class="info_voto"><?php echo $ha_votado1; ?></div></div>
            </td></tr><tr><td>
	       <div  <?php echo $clase_votado3 ;?>  >
           <label class="nik_debate" >
	        <input type="radio" name="voto<?php echo $row_pregunta['ID'] ;?>" value="3" id="voto_2"   <?php echo $chekea3; ?> />
	        No lo tengo claro</label> <div class="info_voto"><?php echo $ha_votado3; ?></div></div>
            </td></tr><tr><td>   
            <div  <?php echo $clase_votado2 ;?>  >
	      	
            <label class="nik_debate" >
	        <input type="radio" name="voto<?php echo $row_pregunta['ID'] ;?>" value="2" id="voto_1"  <?php echo $chekea2; ?>/>
	        No me gusta</label> <div class="info_voto"><?php echo $ha_votado2; ?></div></div>
            </td></tr><tr><td>
	   

            <div  <?php echo $clase_votado4 ;?>  >
            <label class="nik_debate" >
	        <input type="radio" name="voto<?php echo $row_pregunta['ID'] ;?>" value="4" id="voto_3"  <?php echo $chekea4; ?> />
	        No me gusta nada.</label> <div class="info_voto"><?php echo $ha_votado4; ?></div></div>
            </td></tr></table>
            
			<?php 
			break ;
	 
	 }
	 
	  ?>

     
	    <input name="IDST" type="hidden" id="IDST" value="<?php echo  $id_user; ?>" /> 
	   <input name="id_votacion" type="hidden" id="id_votacion" value="<?php echo $row_pregunta['id_votacion'] ;?>" />

<input name="id_pregunta<?php echo $row_pregunta['ID'] ;?>" type="hidden" id="id_pregunta<?php echo $row_pregunta['ID'] ;?>" value="<?php echo $row_pregunta['ID'] ;?>" />
       <p>
	    <input type="submit" name="enviar_voto<?php echo $row_pregunta['ID'] ;?>" id="enviar_voto<?php echo $row_pregunta['ID'] ;?>" value="<?php  if($boton_voto=="modificar"){?> Modificar mi voto <?php }else{?>Enviar mi voto<?php }?>" class="btn btn-primary pull-right">
      </form> </p> 
  </div>
  
  
  
  
  
  <?php  } //else { //echo "<h2>El debate esta cerrado</h2>"; 
  //}?>
  
  
  
  
  <?php 
	  
	  
//$id_pro=$_GET['id_pro']; id_pregunta 	voto 	id_votacion
$sql = "SELECT COUNT(voto),voto  FROM $tbn14  WHERE  id_pregunta = '".$row_pregunta['ID']."'  GROUP BY voto  ORDER BY voto ";
$result = mysqli_query($con, $sql);

if ($row = mysqli_fetch_array($result)){
	//$i=1;
	
?>
     
        <?php

mysqli_field_seek($result,0);

do {

if($row[1]==1){
	$nombre_dato="Me gusta";
}else if($row[1]==2){
	$nombre_dato="No me gusta";
}else if($row[1]==3){
	$nombre_dato="No lo tengo claro";
}else if($row[1]==4){
	$nombre_dato="No me gusta nada";
}else if($row[1]==5){
	$nombre_dato="me gusta mucho";
}
//echo "<br/>Hay votos".$row[0]."<br> de la opcion -".$nombre_dato;

		$array_datos_res.="{label: '$nombre_dato', value:$row[0] },";
		
}
while ($row = mysqli_fetch_array($result));

$array_datos_r=substr($array_datos_res, 0, -1);

?>
     
      
    <?php 
}
 else {

$array_datos_r="{label: 'votos', value:0 }";

}

?> 
<script type="text/javascript">
	var array_js = new Array();
	array_js=[
   <?php  echo "$array_datos_r";?>
  ];
  
  
  </script>
<?php 

//vacio los datos para la siguiente consulta 
$array_datos_res="";
?>


<div >
  <div id="donut_resultado<?php echo $row_pregunta['ID'] ;?>" class="resultados_donut"></div>
        
        <div id="tabla_resultado<?php echo $row_pregunta['ID'] ;?>"  class="resultados_grafica"></div>
</div>
</div>
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
  element: 'tabla_resultado<?php echo $row_pregunta['ID'] ;?>',
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
  element: 'donut_resultado<?php echo $row_pregunta['ID'] ;?>',
  data: array_js, //array de los datos
   backgroundColor: '#9D9D9D',
  labelColor: '#060',
  
  colors: array_colores 
  /*formatter: function (x) { return x + "%"} // da la funcion en porcentajes y no en absolutos
  */
});

array_js=null;	

</script>


 <?php  
 }
 
 ?>
 
 <button id="botonvergrafica" class="btn btn-primary pull-right" >Ver grafica barras</button>
<button  id="botonverdonut" class="btn btn-primary pull-right" >Ver grafica circular</button>
 <p>&nbsp;</p>
 <?php 
} else {
 ?>	<h1> No hay ninguna pregunta planteada para este debate<?php
}
?>
<script type="text/javascript">
$('#botonvergrafica').click(function(){
	var elem=$('.resultados_donut');
	var elem2=$('.resultados_grafica');
	var elem3=$('#botonverdonut');
	var elem4=$('#botonvergrafica');
	
	<!--elem.hide ("blind", { direction: "vertical" }, 1000); -->
	<!--elem2.show("blind", { direction: "vertical" }, 1000); -->
	<!--elem4.hide("blind", { direction: "vertical" }, 1000);--> 
	<!--elem3.show("blind", { direction: "vertical" }, 1000);-->
	elem.hide (); 
	elem2.show(); 
	elem4.hide(); 
	elem3.show();
 });
 
 $('#botonverdonut').click(function(){
	var elem=$('.resultados_donut');
	var elem2=$('.resultados_grafica');
	var elem3=$('#botonverdonut');
	var elem4=$('#botonvergrafica');	
	<!--elem.show ("blind", { direction: "vertical" }, 1000); -->
	<!--elem2.hide("blind", { direction: "vertical" }, 1000); -->
	<!--elem3.hide ("blind", { direction: "vertical" }, 1000);--> 
	<!--elem4.show ("blind", { direction: "vertical" }, 1000);-->
	elem.show (); 
	elem2.hide(); 
	elem3.hide (); 
	elem4.show ();
	 
 });
 </script>