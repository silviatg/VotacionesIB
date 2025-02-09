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
$nivel_acceso=11; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
include("../basicos_php/basico.php") ;


$fecha_ver =date("d-m-Y ");
$fecha =date("Y-m-d");	  
 
 if ($_GET['id']!=""){
 $id=fn_filtro_numerico($con,$_GET['id']); 
 $acc=fn_filtro_nodb($_GET['acc']);
 }
 
 

if(ISSET($_POST["add_votacion"])){

$tipo=fn_filtro($con,$_POST['tipo']);
$tipo_votante=fn_filtro($con,$_POST['tipo_usuario']);
$numero_opciones=fn_filtro($con,$_POST['numero_opciones']);
$comunidad_autonoma=fn_filtro_numerico($con,$_POST['comunidad_autonoma']);
$subgrupo=fn_filtro($con,$_POST['subgrupo']);
$demarcacion=fn_filtro($con,$_POST['demarcacion']);
$tipo_seg=fn_filtro_numerico($con,$_POST['tipo_seg']);
$provincia=fn_filtro_numerico($con,$_POST['provincia']);
$estado=fn_filtro($con,$_POST['estado']);
$nombre=fn_filtro($con,$_POST['nombre']);
$resumen=fn_filtro_editor($con,$_POST['resumen']);
$texto=fn_filtro_editor($con,$_POST['texto']);

$fecha_in=$_POST['fecha_ini']." ". $_POST['hora_ini'].":".$_POST['min_ini'];
$fecha_ini=date("Y-m-d H:i",strtotime($fecha_in));
$fecha_fi=$_POST['fecha_fin']." ". $_POST['hora_fin'].":".$_POST['min_fin'];
$fecha_fin=date("Y-m-d H:i",strtotime($fecha_fi));

$anadido=$_SESSION['ID'];
$fecha_anadido=$_POST['fecha'];

$recuento=fn_filtro($con,$_POST['tipo_recuento']);

if($_POST['si_interventores']=="permitir"){
$n_interventores=fn_filtro_numerico($con,$_POST['numero_interventores']);
$interventor="si";
if($n_interventores==0){
	$error = "error";
	$inmsg_error ="Hay algun  error,  no se puede poner 0 en el numero de opciones ya que ha indicado que quiere interventores especiales, verifique el dato <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";	
	}	
}else{
	$n_interventores=0;
	$interventor="no";	
	}


if($tipo==1 or $tipo==2){
	if($numero_opciones==0){
	$error = "error";
	$inmsg_error ="Hay algun  error, en las votaciones tipo VUT o PRIMARIAS no se puede poner 0 en el numero de opciones , verifique el dato <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";	
	}	
}

if ($_POST['demarcacion']==""){ //Autonomica
	$error = "error";
	$inmsg_error ="no ha indicado la demarcación de la votación";	
	
}
elseif ($_POST['demarcacion']==2){ //Autonomica
	$provincia=100;
}
else if ($_POST['demarcacion']==3){ //provincial
	$comunidad_autonoma=0;
	if($_POST['provincia']==""){
	$error = "error";
	$inmsg_error ="Hay algun tipo de error, por alguna causa no ha llegado el dato de provincia, verifique que la ha indicado <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";
	}
	else{
	$provincia=$_POST['provincia'];	
	}
}else { //grupo provincial
	$provincia=00;
	$comunidad_autonoma=0;
}

/**/

if ($_POST['demarcacion']==4){  
if($_POST['grupo_trabajo_prov']==""){
	$error = "error";
	$inmsg_error ="Hay algun tipo de error, por alguna causa no ha llegado el dato de grupo de trabajo, verifique que la ha indicado <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";
}else{
$id_grupo_trabajo=$_POST['grupo_trabajo_prov'];	 }
}
else if ($_POST['demarcacion']==5){  
if($_POST['grupo_trabajo_aut']==""){
	$error = "error";
	$inmsg_error ="Hay algun tipo de error, por alguna causa no ha llegado el dato de grupo de trabajo, verifique que la ha indicado <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";
}else{
$id_grupo_trabajo=$_POST['grupo_trabajo_aut']; 	 }

}else if ($_POST['demarcacion']==6){ 
if($_POST['grupo_trabajo_gen']==""){
	$error = "error";
	$inmsg_error ="Hay algun tipo de error, por alguna causa no ha llegado el dato de grupo de trabajo, verifique que la ha indicado <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";
}else{
$id_grupo_trabajo=$_POST['grupo_trabajo_gen'];	 }
} 
 
 else if ($_POST['demarcacion']==7){ 
		$comunidad_autonoma=0;
		if($_POST['provincia2']==""){
		$error = "error";
		$inmsg_error ="Hay algun tipo de error, por alguna causa no ha llegado el dato de provincia, verifique que la ha indicado <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";
		}
		else{
		$provincia=$_POST['provincia2'];	
		}
		
		if($_POST['municipio2']!=""){ //STG.
			$municipio=fn_filtro($con,$_POST['municipio2']);
		}
		else if($_POST['municipio']==""){
			$error = "error";
			$inmsg_error ="Hay algun tipo de error, por alguna causa no ha llegado el dato de municipio, verifique que la ha indicado <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";
		}
		else{
			$municipio=fn_filtro($con,$_POST['municipio']);	
		}
	}

 
 
 if(!$error) {
			                                                            		                 		
	$insql = "insert into $tbn1 (nombre_votacion, 	id_provincia, 	texto, tipo, 	tipo_votante, resumen,numero_opciones,anadido,fecha_anadido,id_ccaa,id_subzona,demarcacion,fecha_com,fecha_fin,id_grupo_trabajo,seguridad,activa, interventores,interventor, recuento,id_municipio ) values (  \"$nombre\",  \"$provincia\", \"$texto\", \"$tipo\", \"$tipo_votante\", \"$resumen\", \"$numero_opciones\", \"$anadido\", \"$fecha_anadido\", \"$comunidad_autonoma\", \"$subgrupo\", \"$demarcacion\", \"$fecha_ini\", \"$fecha_fin\", \"$id_grupo_trabajo\", \"$tipo_seg\", \"$estado\", \"$n_interventores\",\"$interventor\", \"$recuento\", \"$municipio\")";
	$inres = @mysqli_query($con,$insql) or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");
	
	
	$idvot = mysqli_insert_id($con);
	$idvot = str_pad($idvot, 6, "0", STR_PAD_LEFT);
	if ($tipo==2){
	
	
  $fp=fopen($FilePath.$idvot."_tally.txt","w+");
  fputs($fp,"Ballots   |0");
  fclose($fp);
  chmod($FilePath.$idvot."_tally.txt",0700);
  
  
  
  $fp=fopen($FilePath.$idvot."_ballots.txt","w+");
  fclose($fp);
  chmod($FilePath.$idvot."_ballots.txt",0700);
	
	}
	
	$inmsg ="<div class=\"alert alert-success\"> 
            Añadida la votacion \" ".$nombre." \" la base de datos			
             </div>";
	
	 if($tipo==4 ){
		$inmsg.= "<div class=\"alert alert-success\"> 
		<a href=\"preguntas.php?idvot=".$idvot." \" >Para terminar de crear el debate puede formular la pregunta o preguntas</a>
	 </div>";
	 }
	 else{
	$inmsg.= "
	<div class=\"alert alert-success\"> 
             
			 <a href=\"candidatos.php?idvot=".$idvot." \" >Para terminar de crear la encuesta /votación tiene que incluir las opciones o candidatos</a>
             </div>";
	 }
	
	if($tipo_seg==3 or $tipo_seg==4){
	$inmsg.= "<div class=\"alert alert-success\"> <a href=\"interventor.php?idvot=".$idvot." \" >¡¡¡RECUERDA QUE!!! para terminar de crear esta encuesta /votación tiene que incluir los interventores</a>
	</div>";
	}
 }

}


if(ISSET($_POST["modifika_votacion"])){

$nombre=fn_filtro($con,$_POST['nombre']);
$provincia=fn_filtro_numerico($con,$_POST['provincia']);
$texto=fn_filtro_editor($con,$_POST['texto']);
//$tipo=$_POST['tipo'];
$resumen=fn_filtro_editor($con,$_POST['resumen']);
$tipo_votante=fn_filtro($con,$_POST['tipo_usuario']);
$numero_opciones=fn_filtro_numerico($con,$_POST['numero_opciones']);
$comunidad_autonoma=fn_filtro_numerico($con,$_POST['comunidad_autonoma']);
$subgrupo=fn_filtro($con,$_POST['subgrupo']);
$demarcacion=fn_filtro($con,$_POST['demarcacion']);
$tipo_seg=fn_filtro($con,$_POST['tipo_seg']);
$estado=fn_filtro($con,$_POST['estado']);
$tipo=fn_filtro($con,$_POST['tipo']);
$fecha_in=$_POST['fecha_ini']." ". $_POST['hora_ini'].":".$_POST['min_ini'];
$fecha_ini=date("Y-m-d H:i",strtotime($fecha_in));
$fecha_fi=$_POST['fecha_fin']." ". $_POST['hora_fin'].":".$_POST['min_fin'];
$fecha_fin=date("Y-m-d H:i",strtotime($fecha_fi));

$recuento=fn_filtro($con,$_POST['tipo_recuento']);
if($_POST['si_interventores']=="permitir"){
$n_interventores=fn_filtro_numerico($con,$_POST['numero_interventores']);
$interventor="si";	
		if($n_interventores==0){
			$error = "error";
			$inmsg_error ="Hay algun  error,  no se puede poner 0 en el numero de opciones ya que ha indicado que quiere interventores especiales, verifique el dato <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";	
			}
}else{
	$n_interventores=0;
	$interventor="no";	
	}
	
$anadido=fn_filtro($con,$_POST['anadido']);
$fecha_anadido=fn_filtro($con,$_POST['fecha']);

if($tipo==1 or $tipo==2){
	if($numero_opciones==0){
	$error = "error";
	$inmsg_error ="Hay algun  error, en las votaciones tipo VUT o PRIMARIAS no se puede poner 0 en el numero de opciones , verifique el dato <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";	
	}	
}

if ($_POST['demarcacion']==""){ //Autonomica
	$error = "error";
	$inmsg_error ="no ha indicado la demarcación de la votación";	
	
}
elseif ($_POST['demarcacion']==2){ //Autonomica
	$provincia=100;
}
else if ($_POST['demarcacion']==3){ //provincial
	$comunidad_autonoma=0;
	if($_POST['provincia']==""){
	$error = "error";
	$inmsg_error ="Hay algun tipo de error, por alguna causa no ha llegado el dato de provincia, verifique que la ha indicado <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";
	}
	else{
	$provincia=$_POST['provincia'];	
	}
}else { //grupo provincial
	$provincia=00;
	$comunidad_autonoma=0;
}

/**/

if ($_POST['demarcacion']==4){  
if($_POST['grupo_trabajo_prov']==""){
	$error = "error";
	$inmsg_error ="Hay algun tipo de error, por alguna causa no ha llegado el dato de grupo de trabajo, verifique que la ha indicado <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";
}else{
$id_grupo_trabajo=$_POST['grupo_trabajo_prov'];	 }
}
else if ($_POST['demarcacion']==5){  
if($_POST['grupo_trabajo_aut']==""){
	$error = "error";
	$inmsg_error ="Hay algun tipo de error, por alguna causa no ha llegado el dato de grupo de trabajo, verifique que la ha indicado <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";
}else{
$id_grupo_trabajo=$_POST['grupo_trabajo_aut']; 	 }

}else if ($_POST['demarcacion']==6){ 
if($_POST['grupo_trabajo_gen']==""){
	$error = "error";
	$inmsg_error ="Hay algun tipo de error, por alguna causa no ha llegado el dato de grupo de trabajo, verifique que la ha indicado <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";
}else{
$id_grupo_trabajo=$_POST['grupo_trabajo_gen'];	 }
} 
 else if ($_POST['demarcacion']==7){ 
		$comunidad_autonoma=0;
		if($_POST['provincia2']==""){
		$error = "error";
		$inmsg_error ="Hay algun tipo de error, por alguna causa no ha llegado el dato de provincia, verifique que la ha indicado <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";
		}
		else{
		$provincia=$_POST['provincia2'];	
		}
		
		if($_POST['municipio2']!=""){ //STG.
			$municipio=fn_filtro($con,$_POST['municipio2']);
		}
		else if($_POST['municipio']==""){
			$error = "error";
			$inmsg_error ="Hay algun tipo de error, por alguna causa no ha llegado el dato de municipio, verifique que la ha indicado <br/> ¡¡¡OJO!!!Hay algunos datos que debera volver a indicarlos";
		}
		else{
			$municipio=fn_filtro($con,$_POST['municipio']);	
		}
	}

 if($_GET['id']==""){
	$error = "error";
	$inmsg_error ="Hay algun tipo de error, por alguna causa no ha llegado datos";
 }
 
 
 if(!$error) {
 
 
$sSQL="UPDATE $tbn1 SET nombre_votacion=\"$nombre\",id_provincia=\"$provincia\", texto=\"$texto\", tipo_votante=\"$tipo_votante\", resumen=\"$resumen\" , numero_opciones=\"$numero_opciones\",id_ccaa=\"$comunidad_autonoma\", id_subzona=\"$subgrupo\" , fecha_com=\"$fecha_ini\",fecha_fin=\"$fecha_fin\", demarcacion=\"$demarcacion\", seguridad=\"$tipo_seg\" , activa=\"$estado\", interventores=\"$n_interventores\",interventor=\"$interventor\", id_municipio=\"$municipio\" WHERE id='$id'";

mysqli_query($con,$sSQL)or die ("Imposible modificar pagina");


	
	$inmsg =" <div class=\"alert alert-success\"> Realizadas las Modificaciones <br>Asi ha quedado la votacion:\" ". $nombre ." \"</div>";
	
	 if($tipo==4 ){
		$inmsg.= "<div class=\"alert alert-success\"> <a href=\"preguntas.php?idvot=".$id." \" >Para terminar de crear el debate tiene que formular la pregunta o preguntas</a></div>";
	 
	 }
	 else{
	$inmsg.= "<div class=\"alert alert-success\"> <a href=\"candidatos.php?idvot=".$id." \" >Para terminar de crear la encuesta /votación tiene que incluir las opciones o candidatos</a></div>";
	 }
	
	if($tipo_seg==3 or $tipo_seg==4){
	$inmsg.= "<div class=\"alert alert-success\"> <a href=\"interventor.php?idvot=".$id." \" class=\"modify\">¡¡¡RECUERDA QUE!!! para terminar de crear la encuesta /votación tiene que incluir los interventores</a></div>";
	}
 }

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
       
        
        
        <div class="col-md-10">
     
                   <!--Comiezo-->
  	 
           <?php echo "$inmsg";?>      
           <?php if($inmsg_error!=""){;?>
  <div class="alert alert-danger"> 
             <a class="close" data-dismiss="alert">x</a>
             <?php echo "$inmsg_error";?>
             </div>
 			<?php }?>   
            
              <?php 
if($acc =="modifika"){
  $result=mysqli_query($con,"SELECT * FROM $tbn1 where id=$id");
  $row=mysqli_fetch_row($result);
 
}
 
 ?>
  <h1> <?php  if($acc =="modifika"){ echo"MODIFICAR ESTA VOTACION"; }else{ echo "CREAR UNA NUEVA VOTACION";}?></h1>
              
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method=post name="frmDatos" id="frmDatos"  class="well form-horizontal" >
        
         <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Nombre votación</label>
             
            <div class="col-sm-9">  
            <input name="nombre" type="text"  id="nombre" value="<?php echo "$row[3]";?>" class="form-control" placeholder="Nombre de la votación" required autofocus data-validation-required-message="El nombre de la votación es un dato requerido"/>
            </div>
         </div>       
    
    
    <div class="form-group">
    <label for="demarcacion" class="col-sm-3 control-label">Demarcación</label>
    <div class="col-sm-9">
                
                  <?php 
				  if($acc =="modifika"){
				  if ($row[20]==1){
					 $chek_dem1="checked=\"checked\" ";
					     $display2="  style=\"display:none\"";
					     $display3="  style=\"display:none\"";
						 $display4="  style=\"display:none\"";
						 $display5="  style=\"display:none\"";
						 $display6="  style=\"display:none\"";	
						 $display7="  style=\"display:none\"";
					 	 
				 }else if ($row[20]==2){
					 $chek_dem2="checked=\"checked\" ";
					 	
						 $display3="  style=\"display:none\"";
						 $display4="  style=\"display:none\"";
						 $display5="  style=\"display:none\"";
						 $display6="  style=\"display:none\"";	
						  $display7="  style=\"display:none\"";				  
				 }else if ($row[20]==3){
					 
					     $chek_dem3="checked=\"checked\" ";
					 	 
						 $display2="  style=\"display:none\"";
						 
						 $display4="  style=\"display:none\"";
						 $display5="  style=\"display:none\"";	
						 $display6="  style=\"display:none\"";	
						  $display7="  style=\"display:none\"";				  
				 }else if ($row[20]==4){
					 
					     $chek_dem4="checked=\"checked\" ";
					 	
						 $display2="  style=\"display:none\"";
						 $display3="  style=\"display:none\"";
						 
						 $display5="  style=\"display:none\"";	
						 $display6="  style=\"display:none\"";	
						 $display7="  style=\"display:none\"";				  
				 }else if ($row[20]==5){
					 
					  $chek_dem5="checked=\"checked\" ";
					 	  
						 $display2="  style=\"display:none\"";
						 $display3="  style=\"display:none\"";
						 $display4="  style=\"display:none\"";
						 $display6="  style=\"display:none\"";	
						 $display7="  style=\"display:none\"";
						 			  
				 }
				 
				 else if ($row[20]==6){
					 
					  $chek_dem6="checked=\"checked\" ";
					 	  
						 $display2="  style=\"display:none\"";
						 $display3="  style=\"display:none\"";
						 $display4="  style=\"display:none\"";
						 $display5="  style=\"display:none\"";	
						  $display7="  style=\"display:none\"";
						 			  
				 }else if ($row[20]==7){
					 
					  $chek_dem7="checked=\"checked\" ";
					 	  
						 $display2="  style=\"display:none\"";
						 $display3="  style=\"display:none\"";
						 $display4="  style=\"display:none\"";
						 $display5="  style=\"display:none\"";	
						 $display6="  style=\"display:none\"";
						 			  
				 };
				  
				  }
				  else{
					  if ($_SESSION['nivel_usu']==2){
						  $chek_dem1="checked=\"checked\" ";
						  $display1="  style=\"display:none\"";
					  	 $display2="  style=\"display:none\"";
						 $display3="  style=\"display:none\"";
						 $display4="  style=\"display:none\"";
						 $display5="  style=\"display:none\"";
						 $display6="  style=\"display:none\"";
						 $display7="  style=\"display:none\"";
					  }else if ($_SESSION['nivel_usu']==3){
						  $chek_dem2="checked=\"checked\" ";
						  $display1="  style=\"display:none\"";
					  	 $display2="  style=\"display:none\"";
						 $display3="  style=\"display:none\"";
						 $display4="  style=\"display:none\"";
						 $display5="  style=\"display:none\"";
						 $display6="  style=\"display:none\"";
						 $display7="  style=\"display:none\"";
					  }else if ($_SESSION['nivel_usu']==4){
						  $chek_dem3="checked=\"checked\" ";
						  $display1="  style=\"display:none\"";
					  	 $display2="  style=\"display:none\"";
						 
						 $display4="  style=\"display:none\"";
						 $display5="  style=\"display:none\"";
						 $display6="  style=\"display:none\"";
						 $display7="  style=\"display:none\"";
					  }else if ($_SESSION['nivel_usu']==5){
						  $chek_dem6="checked=\"checked\" ";
						   $display1="  style=\"display:none\"";
					  	 $display2="  style=\"display:none\"";
						 $display3="  style=\"display:none\"";
						 $display4="  style=\"display:none\"";
						 $display5="  style=\"display:none\"";
						 $display6="  style=\"display:none\"";
						 $display7="  style=\"display:none\"";
					  }else if ($_SESSION['nivel_usu']==6){
						  $chek_dem5="checked=\"checked\" ";
						   $display1="  style=\"display:none\"";
					  	 $display2="  style=\"display:none\"";
						 $display3="  style=\"display:none\"";
						 $display4="  style=\"display:none\"";
						 $display5="  style=\"display:none\"";
						 $display6="  style=\"display:none\"";
						 $display7="  style=\"display:none\"";
					  }else if ($_SESSION['nivel_usu']==7){
						  $chek_dem4="checked=\"checked\" ";
						   $display1="  style=\"display:none\"";
					  	 $display2="  style=\"display:none\"";
						 $display3="  style=\"display:none\"";
						 $display4="  style=\"display:none\"";
						 $display5="  style=\"display:none\"";
						 $display6="  style=\"display:none\"";
						 $display7="  style=\"display:none\"";
					  }
					  
					  
				  }
				  
				?>
                
                    <?php if ($_SESSION['nivel_usu']==2){?>
                    <label>
                      <input name="demarcacion" type="radio" id="demarcacion_0" value="1" onClick="habilita_estatal()"<?php echo "$chek_dem1"; ?> />
                      Estatal</label>
                    <br />
                    <?php }
					 
					  if ($_SESSION['nivel_usu']<=3){?>
                    <label>
                      <input type="radio" name="demarcacion" value="2" id="demarcacion_1"  onclick="habilita_autonomico()" <?php echo "$chek_dem2"; ?>/>
                      Autonomica</label>
                    <br />
  <?php }
					 
					  if ($_SESSION['nivel_usu']<=4){?>
  <label>
    <input type="radio" name="demarcacion" value="3" id="demarcacion_2" onClick="habilita_provincial()" <?php echo "$chek_dem3"; ?>/>
    Provincial</label>
  <br />
  <label>
    <input type="radio" name="demarcacion" value="7" id="demarcacion_7" onClick="habilita_municipal()" <?php echo "$chek_dem7"; ?>/>
   Municipal</label>
  <br />
  <label>
    <input type="radio" name="demarcacion" value="4" id="demarcacion_3" onClick="habilita_local()" <?php echo "$chek_dem4"; ?>/>
    Grupo provincial</label>
  <br />
  <?php }
					 
					  if ($_SESSION['nivel_usu']<=3){?>
  <label>
    <input type="radio" name="demarcacion" value="5" id="demarcacion_4" onClick="habilita_g_trabajo()" <?php echo "$chek_dem5"; ?> />
    Grupo Autonomico</label>
  <br />
  <?php }
					 
					  if ($_SESSION['nivel_usu']<=2){?>
  <label>
    <input type="radio" name="demarcacion" value="6" id="demarcacion_5" onClick="habilita_g_trabajo_general()" <?php echo "$chek_dem6"; ?>/>
    Grupo Estatal</label>
  <br />
  <?php }?>
  <?php 
				   if ($_SESSION['nivel_usu']==6){
					  //  demarcacion grupos estatales 
					   ?>
                    Estatal
  <?php   }?>
  <?php 
				   if ($_SESSION['nivel_usu']==7){
					   // demmarcacion grupos autonomicos 
					    ?>
  <label>
    <input type="radio" name="demarcacion" value="5" id="demarcacion_4" onClick="habilita_g_trabajo()" <?php echo "$chek_dem5"; ?>/>
    Grupo Autonomico</label>
  <br />
  <label>
    <input type="radio" name="demarcacion" value="4" id="demarcacion_3" onClick="habilita_local()" <?php echo "$chek_dem4"; ?>/>
    Grupo provincial</label>
  <br />
  <?php  }?>
  <?php 
				   if ($_SESSION['nivel_usu']==5){
					   //demarcacion grupos provincial
					 ?>
                    Provincial
  <?php  }?>
                  </div>
               </div> 
                  
                  
                  <!--                  -->
                  
   <div class="form-group">
    <label for="fecha_ini" class="col-sm-3 control-label"> </label>
    <div class="col-sm-9">               
                  
      <div id="autonomico"  class="caja_de_display"  <?php echo "$display2"; ?> >
          <div align="left">
                        <?php 
				  
				 if ($_SESSION['nivel_usu']==2){ 
				  	 
	
							 ?>
                        <h3> Escoja una Comunidad Autonoma </h3>
                        <?php 
					
					$options_ccaa = "select DISTINCT ID, ccaa from $tbn3  order by ID";
	$resulta_ccaa = mysqli_query($con, $options_ccaa) or die("error: ".mysqli_error());
	
	while( $listrows_ccaa = mysqli_fetch_array($resulta_ccaa) ){ 
	$id_ccaa = $listrows_ccaa[ID];
	if ($id_ccaa==$row[17]){
	$check="selected=\"selected\" ";
	}
	else{
		$check="";
	}
	$name_ccaa= utf8_encode($listrows_ccaa[ccaa]);
	$lista_ccaa .="<option value=\"$id_ccaa\" $check> $name_ccaa</option>"; 
	
}
 ?>
                        <select name="comunidad_autonoma" class="form-control" id="comunidad_autonoma" >
                          <?php echo "$lista_ccaa";?>
                        </select>
                        <?php
				 }
				 else{
				
	$ids_ccaa=$_SESSION['id_ccaa_usu'];			  
 $options_ccaa = "select DISTINCT  ID, ccaa from $tbn3  where id=$ids_ccaa";
	$resulta_ccaa = mysqli_query($con, $options_ccaa) or die("error: ".mysqli_error());
	
	while( $listrows_ccaa = mysqli_fetch_array($resulta_ccaa) ){ 
	$ccaa = $listrows_ccaa[ccaa];
	
}

				  
				  ?>
                        <p>Comunidad autonoma de :
                          <input name="comunidad_autonoma" type="hidden" id="comunidad_autonoma" value="<?php echo "$ids_ccaa"; ?>" />
                          <?php echo "$ccaa";     
				 }
				 
							 ?></p>
                      </div>
                    </div>
                    
                    
                    
                    <div id="provincial"  class="caja_de_display"   <?php echo "$display3"; ?> >
                      <div align="left">
                        <?php 
		
					 
					  if ($_SESSION['nivel_usu']==2){   
								 // listar para meter en una lista del cuestionario buscador


	$options = "select DISTINCT id, provincia from $tbn8  where especial=0 order by ID";
	$resulta = mysqli_query($con, $options) or die("error: ".mysqli_error());
	
	while( $listrows = mysqli_fetch_array($resulta) ){ 
	$id_pro = $listrows[id];
	$name1= utf8_encode($listrows[provincia]);
	if ($id_pro==$row[1]){
	$check="selected=\"selected\" ";
	}
	else{
		$check="";
	}
	$lista1 .="<option value=\"$id_pro\"  $check> $name1</option>"; 
}		
	?>
                        <h3> Escoja una Provincia </h3>
                        <select name="provincia" class="form-control" id="provincia" >
                          <?php echo "$lista1";?>
                        </select>
                        <?php 
	
	
}else  if ($_SESSION['nivel_usu']==3){
	
	$options = "select DISTINCT id, provincia from $tbn8  where id_ccaa=$ids_ccaa  order by ID";
	$resulta = mysqli_query($con, $options) or die("error: ".mysqli_error());
	
	while( $listrows = mysqli_fetch_array($resulta) ){ 
	$id_pro = $listrows[id];
	$name1= utf8_encode($listrows[provincia]);
	if ($id_pro==$row[1]){
	$check="selected=\"selected\" ";
	}
	else{
		$check="";
	}
	$lista1 .="<option value=\"$id_pro\"  $check> $name1</option>";
	}?>
                        <h3> Escoja una Provincia </h3>
                        <select name="provincia" class="form-control" id="provincia" >
                          <?php echo "$lista1";?>
                        </select>
                        <?php 
}
		else{		
				
$result2=mysqli_query($con,"SELECT id_provincia FROM $tbn5 where id_usuario=".$_SESSION['ID']);
$quants2=mysqli_num_rows($result2);
//$row2=mysqli_fetch_row($result2);

if($quants2!=0){	

 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	
	$name2= $listrows2[id_provincia];
	 $optiones=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$name2");
     $row_prov=mysqli_fetch_row($optiones);
		if($acc =="modifika"){
			 if ($name2==$row[1]){
			$check="checked=\"checked\" ";
			}
			else{
				$check="";
			}
		}else{
			$check="checked=\"checked\" ";
		}
	 
    $lista1 .="    <label><input  type=\"radio\" name=\"provincia\" value=\"$name2\"   $check id=\"provincia\" /> ". utf8_encode($row_prov[0])."</label> <br/>";
	 }
				echo "$lista1"; 
}
 else{
echo " No tiene asignadas provincias, no podra crear votación";	
}
 }	
?>
                      </div>
                    </div>
                    
                    <!---->
                    
                     <div id="g_municipal"  class="caja_de_display"   <?php echo "$display7"; ?> >
                      <div align="left">
                        <?php 
		
					 
if ($_SESSION['nivel_usu']==2){   
	// listar para meter en una lista del cuestionario buscador

	//STG: Al crear una votación por Municipio, el desplegable sale vacío, y no me dejaba seleccionar un valor. 
	//    => Cargo los municipios de la primera provincia.
	$options = "select DISTINCT id, provincia from $tbn8  where especial=0 order by ID";
	$resulta = mysqli_query($con, $options) or die("error: ".mysqli_error());
	
	$id_prov_seleccionada = ""; //STG
	$id_prov_primera = ""; //STG
	$nFila=0;//STG
	while( $listrows = mysqli_fetch_array($resulta) ){ 
		$nFila++;
		$id_pro = $listrows[id];
		$mifila=$row[1];
		$name1= utf8_encode($listrows[provincia]);
		if ($nFila==1){ //STG
			$id_prov_primera=$id_pro;			
		}
		if ($id_pro==$row[1]){
			$check="selected=\"selected\" ";
			$id_prov_seleccionada = $id_pro; //STG
		}
		else{
			$check="";
		}
		if ($nFila==1 && $row[1] == ""){ //STG
			$check="selected=\"selected\" ";
		}
		$lista2 .="<option value=\"$id_pro\"  $check> $name1</option>"; 
	}
	
	//STG
	if ($id_prov_seleccionada == ""){
		$id_prov_seleccionada = $id_prov_primera;
	}

	/*****************************/
	//STG:	
	$options_muni = "select DISTINCT id_municipio, nombre from $tbn18  where id_provincia=$id_prov_seleccionada order by id_municipio";
	$resulta_muni = mysqli_query($con, $options_muni) or die("error: ".mysqli_error());	
	while( $listrows_muni = mysqli_fetch_array($resulta_muni) ){ 
		$id_munic = $listrows_muni[id_municipio];
		$nameMuni= utf8_encode($listrows_muni[nombre]);
		$checkMuni="selected=\"selected\" ";
		$listaMuni .="<option value=\"$id_munic\" $checkMuni> $nameMuni</option>";
	}	
	/***************************************/
	
	?>
                        <h4> Escoja una Provincia </4>
                        <select name="provincia2" class="form-control" id="provincia2" >
                          <?php echo "$lista2";?>
                        </select>
                        
                   <h3>Escoja Municipio </h3>
             
				  <!-- STG: Por alguna razón, no se cargaban los datos en el combo cuando el campo se llamaba "municipio", 
				  he tenido que llamarlo "municipio2". -->
                  <select name="municipio2" class="form-control" id="municipio2"> 
					<?php echo "$listaMuni";?>
				  </select>                                          
                        
                        <?php 
	
	
}else  if ($_SESSION['nivel_usu']==3){
	
	$options = "select DISTINCT id, provincia from $tbn8  where id_ccaa=$ids_ccaa  order by ID";
	$resulta = mysqli_query($con, $options) or die("error: ".mysqli_error());
	
	while( $listrows = mysqli_fetch_array($resulta) ){ 
	$id_pro = $listrows[id];
	$name1= utf8_encode($listrows[provincia]);
	$name = $listrows[id];
	 if($acc =="modifika"){
			if ($id_pro==$row[1]){
			$check="selected=\"selected\" ";
			}
			else{
				$check="";
			}
	 }else{
		 $check="selected=\"selected\" ";
	 }
	$lista2 .="<option value=\"$id_pro\"  $check> $name1</option>";
	}?>
                        <h4> Escoja una Provincia </h4>
                        <select name="provincia2" class="form-control" id="provincia2" >
                          <?php echo "$lista2";?>
                        </select>
                                
                   <h3>Escoja Municipio </h3>
             
                  <select name="municipio" id="municipio" class="form-control" > </select>
                  
                   
                        
                        
                        <?php 
}
		else{		
				
$result2=mysqli_query($con,"SELECT id_provincia FROM $tbn5 where id_usuario=".$_SESSION['ID']);
$quants2=mysqli_num_rows($result2);
//$row2=mysqli_fetch_row($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	
	$name2= $listrows2[id_provincia];
	$name= $listrows2[id_provincia];
	 $optiones=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$name2");
     $row_prov=mysqli_fetch_row($optiones);
	 
	 if($acc =="modifika"){
			if ($name2==$row[1]){
			$check="checked=\"checked\" ";
			}
			else{
				$check="";
			}
	 }else{
		 $check="checked=\"checked\" ";
	 }
	 
    $lista2 .="    <label><input  type=\"radio\" name=\"provincia2\" value=\"$name2\"   $check id=\"provincia2\" /> ". utf8_encode($row_prov[0])."</label> <br/>";
	 }
				echo "$lista2"; 
				
				        
                  echo" <h3>Escoja Municipio </h3>
             
                  <select name=\"municipio\" id=\"municipio\" class=\"form-control\" > </select>";
                  
                   
}
 else{
echo " No tiene asignadas provincias, no podra crear votación";	
}
 }	
?>
                      </div>
                    </div>
                    
                    
                    
                    
                    <!---->
                    
                    <div id="local"  class="caja_de_display"  <?php echo "$display4"; ?>>
                      <h3> Escoja la asamblea provincial</h3>
                      <?php 
				    
					 
					  if ($_SESSION['nivel_usu']==2){		
				
$result2=mysqli_query($con,"SELECT ID ,subgrupo,tipo_votante, id_provincia FROM $tbn4  where tipo=1 order by id_provincia");
$quants2=mysqli_num_rows($result2);
//$row2=mysqli_fetch_row($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
		$id_grupo= $listrows2[ID];
	$id_prov= $listrows2[id_provincia];
	$subgrupo= $listrows2[subgrupo];
	
	if ($id_grupo==$row[19]){
	$check="selected=\"selected\" ";
	}
	else{
		$check="";
	}
	
	 $optiones=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$id_prov");
     $row_prov=mysqli_fetch_row($optiones);
	 $lista2 .="<option value=\"$id_grupo\" $check> ". utf8_encode($row_prov[0])." - ".utf8_encode($subgrupo)." </option>";
   // $lista2 .="    <label><input  type=\"radio\" name=\"grupo_trabajo\" value=\"$name2\"  checked=\"checked\"  id=\"grupo_trabajo\" /> ".$subgrupo." - ". utf8_encode($row_prov[0])."</label> <br/>";
	 }
	echo " <select name=\"grupo_trabajo_prov\" class=\"form-control\" id=\"grupo_trabajo_prov\" > $lista2 </select>";	  
			 
}  else{
echo " No tiene asignado grupos, no podra crear votación";	
}
 }
 
					 
					           
               //  admin CCAA, meter los que tiene asignados en su ccaa
               
			else   if ($_SESSION['nivel_usu']==3 ){		
			echo $_SESSION['id_ccaa_usu'];	
$result2=mysqli_query($con,"SELECT ID ,subgrupo,tipo_votante, id_provincia FROM $tbn4  where tipo=1 and id_ccaa=".$_SESSION['id_ccaa_usu']." order by id_provincia");
$quants2=mysqli_num_rows($result2);
//$row2=mysqli_fetch_row($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
		$id_grupo= $listrows2[ID];
	$id_prov= $listrows2[id_provincia];
	$subgrupo= $listrows2[subgrupo];
	if ($id_grupo==$row[19]){
	$check="checked=\"checked\" ";
	}
	else{
		$check="";
	}
	
	 $optiones=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$id_prov");
     $row_prov=mysqli_fetch_row($optiones);
    $lista2 .="    <label><input  type=\"radio\" name=\"grupo_trabajo_prov\" value=\"$id_grupo\"  $check id=\"grupo_trabajo_prov\" /> ".$subgrupo." - ". utf8_encode($row_prov[0])."</label> <br/>";
	 }
		echo "$lista2";		 
} else{
echo " No tiene asignado grupos provinciales, no podra crear votación";	
}
			   }
 

				
				
				
               //  provincial, meter los que tiene asignado
               
			else   if ($_SESSION['nivel_usu']==4 or $_SESSION['nivel_usu']==7){		
				
$result2=mysqli_query($con,"SELECT a.ID ,a.subgrupo,a.tipo_votante, a.id_provincia FROM $tbn4 a,$tbn6 b where (a.ID= b.id_grupo_trabajo) and b.id_usuario=".$_SESSION['ID']." and a.tipo=1 order by a.id_provincia");
$quants2=mysqli_num_rows($result2);
//$row2=mysqli_fetch_row($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	$id_grupo= $listrows2[ID];	
	
	$id_prov= $listrows2[id_provincia];
	$subgrupo= $listrows2[subgrupo];
	if ($id_grupo==$row[19]){
	$check="checked=\"checked\" ";
	}
	else{
		$check="";
	}
	
	 $optiones=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$id_prov");
     $row_prov=mysqli_fetch_row($optiones);
    $lista2 .="    <label><input  type=\"radio\" name=\"grupo_trabajo_prov\" value=\"$id_grupo\"  $check  id=\"grupo_trabajo_prov\" /> ".$subgrupo." - ". utf8_encode($row_prov[0])."</label> <br/>";
	 }
		echo "$lista2";			 
}
	 else{
echo " No tiene asignado grupos provinciales, no podra crear votación";	
}
	   }
 
?>
                    </div>
                    <?php 
////////si es un administrador de grupo local provincial metemos sus datos pero 
 if ($_SESSION['nivel_usu']==5){		
				
$result2=mysqli_query($con,"SELECT a.ID ,a.subgrupo,a.tipo_votante, a.id_provincia FROM $tbn4 a,$tbn6 b where (a.ID= b.id_grupo_trabajo) and a.tipo=1 and b.id_usuario=".$_SESSION['ID']." order by a.id_provincia");
$quants2=mysqli_num_rows($result2);
//$row2=mysqli_fetch_row($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	$id_grupo= $listrows2[ID];
	$id_prov= $listrows2[id_provincia];
	$subgrupo= $listrows2[subgrupo];
	if ($id_grupo==$row[19]){
	$check="checked=\"checked\" ";
	}
	else{
		$check="";
	}
	
	 $optiones=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$id_prov");
     $row_prov=mysqli_fetch_row($optiones);
    $lista2 .="    <label><input  type=\"radio\" name=\"grupo_trabajo_prov\" value=\"$id_grupo\"  $check  id=\"grupo_trabajo_prov\" /> ".$subgrupo." - ". utf8_encode($row_prov[0])."</label> <br/>";
	 }
		echo "$lista2";			 
}
		 else{
echo " No tiene asignado grupos, no podra crear votación";	
}   }
 
?>





                    <div id="g_trabajo"  class="caja_de_display"   <?php echo "$display5"; ?>>
                      <h3> Escoja la asamblea Autonomico </h3>
                      <?php 	  if ($_SESSION['nivel_usu']==2){		
				
$result2=mysqli_query($con,"SELECT ID ,subgrupo,tipo_votante, id_ccaa FROM $tbn4  where tipo=2 order by id_ccaa");
$quants2=mysqli_num_rows($result2);
//$row2=mysqli_fetch_row($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	$id_grupo= $listrows2[ID];	
	$id_ccaa= $listrows2[id_ccaa];
	$subgrupo= $listrows2[subgrupo];
	if ($id_grupo==$row[19]){
	$check="selected=\"selected\" ";
	}
	else{
		$check="";
	}
	
	 $optiones=mysqli_query($con,"SELECT ccaa FROM $tbn3 where ID=$id_ccaa");
     $row_prov=mysqli_fetch_row($optiones);
	 $lista3 .="<option value=\"$id_grupo\" $check> ". utf8_encode($row_prov[0])." - ".utf8_encode($subgrupo)." </option>";
   // $lista2 .="    <label><input  type=\"radio\" name=\"grupo_trabajo\" value=\"$name2\"  checked=\"checked\"  id=\"grupo_trabajo\" /> ".$subgrupo." - ". utf8_encode($row_prov[0])."</label> <br/>";
	 }
	echo " <select name=\"grupo_trabajo_aut\" class=\"form-control\" id=\"grupo_trabajo_aut\" $check > $lista3 </select>";				 
}  else{
echo "No hay grupos Autonomicos, no podra crear votación";
		}
  }
 
					 
				           
               //  admin CCAA, meter los que tiene asignados en su ccaa
               
			else   if ($_SESSION['nivel_usu']==3){		
			
$result2=mysqli_query($con,"SELECT ID ,subgrupo,tipo_votante, id_ccaa FROM $tbn4  where tipo=2 and id_ccaa=".$_SESSION['id_ccaa_usu']." order by id_ccaa");
$quants2=mysqli_num_rows($result2);
//$row2=mysqli_fetch_row($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	$id_grupo= $listrows2[ID];
	$id_ccaa= $listrows2[id_ccaa];
	$subgrupo= $listrows2[subgrupo];
	if ($id_grupo==$row[19]){
	$check="checked=\"checked\" ";
	}
	else{
		$check="";
	}
	
	 $optiones=mysqli_query($con,"SELECT  ccaa FROM $tbn3 where ID=$id_ccaa");
     $row_prov=mysqli_fetch_row($optiones);
    $lista3 .="    <label><input  type=\"radio\" name=\"grupo_trabajo_aut\" value=\"$id_grupo\"  $check  id=\"grupo_trabajo_aut\" /> ".$subgrupo." - ". utf8_encode($row_prov[0])."</label> <br/>";
	 }
		echo "$lista3";	 		 
} else{
echo " No tiene asignado grupos autonomicos, no podra crear votación";	
}
		  }
 	else   if ( $_SESSION['nivel_usu']==7){		
			
$result2=mysqli_query($con,"SELECT a.ID ,a.subgrupo,a.tipo_votante, a.id_ccaa FROM $tbn4 a ,$tbn6 b where (a.ID= b.id_grupo_trabajo) and a.tipo=2 and b.id_usuario=".$_SESSION['ID']." order by a.id_ccaa");
$quants2=mysqli_num_rows($result2);
//$row2=mysqli_fetch_row($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	$id_grupo= $listrows2[ID];
	$id_ccaa= $listrows2[id_ccaa];
	$subgrupo= $listrows2[subgrupo];
	if ($id_grupo==$row[19]){
	$check="checked=\"checked\" ";
	}
	else{
		$check="";
	}
	
	 $optiones=mysqli_query($con,"SELECT  ccaa FROM $tbn3 where ID=$id_ccaa");
     $row_prov=mysqli_fetch_row($optiones);
    $lista3 .="    <label><input  type=\"radio\" name=\"grupo_trabajo_aut\" value=\"$id_grupo\"  $check  id=\"grupo_trabajo_aut\" /> ".$subgrupo." - ". utf8_encode($row_prov[0])."</label> <br/>";
	 }
		echo "$lista3";	 		 
} else{
echo " No tiene asignado grupos Autonomicos, no podra crear votación";	
}
		  }
 	
?>
                    </div>
                    
                    
                    
                    
                    
                    
                    <div id="g_trabajo_general"  class="caja_de_display"  <?php echo "$display6"; ?>>
                    <h3> Escoja grupo  Estatal </h3>
                     
                      <?php 
				 if ($_SESSION['nivel_usu']==2){		
				
$result2=mysqli_query($con,"SELECT ID ,subgrupo,tipo_votante FROM $tbn4  where tipo=3 order by subgrupo");
$quants2=mysqli_num_rows($result2);
//$row2=mysqli_fetch_row($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	
	$id_grupo= $listrows2[ID];
	$subgrupo= $listrows2[subgrupo];
	if ($id_grupo==$row[19]){
	$check="selected=\"selected\" ";
	}
	else{
		$check="";
	}
	 
	 $lista4 .="<option value=\"$id_grupo\" $check>  ".utf8_encode($subgrupo)." </option>";
   // $lista2 .="    <label><input  type=\"radio\" name=\"grupo_trabajo\" value=\"$name2\"  checked=\"checked\"  id=\"grupo_trabajo\" /> ".$subgrupo." - ". utf8_encode($row_prov[0])."</label> <br/>";
	 }
	echo " <select name=\"grupo_trabajo_gen\" class=\"form-control\" id=\"grupo_trabajo_gen\" $check > $lista4 </select>";				 
}  else{
echo "No hay grupos, no podra crear votación";
		}
  }
 
				
				
				
				?>
                    </div>
                  <?php
  
  		 if ($_SESSION['nivel_usu']==6){		
				
$result2=mysqli_query($con,"SELECT a.ID ,a.subgrupo,a.tipo_votante FROM $tbn4 a,$tbn6 b where (a.ID= b.id_grupo_trabajo)  and a.tipo=3 order by a.subgrupo");
$quants2=mysqli_num_rows($result2);
//$row2=mysqli_fetch_row($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	
	$id_grupo= $listrows2[ID];
	$subgrupo= $listrows2[subgrupo];
	if ($id_grupo==$row[19]){
	$check="selected=\"selected\" ";
	}
	else{
		$check="";
	}
	 
	 $lista4 .="<option value=\"$id_grupo\" $check>  ".utf8_encode($subgrupo)." </option>";
   // $lista2 .="    <label><input  type=\"radio\" name=\"grupo_trabajo\" value=\"$name2\"  checked=\"checked\"  id=\"grupo_trabajo\" /> ".$subgrupo." - ". utf8_encode($row_prov[0])."</label> <br/>";
	 }
	echo " <select name=\"grupo_trabajo_gen\" class=\"form-control\" id=\"grupo_trabajo_gen\" > $lista4 </select>";				 
}  else{
echo "No hay grupos, no podra crear votación";

		}
  }
 
   ?>
   
 		 </div>
 	 </div>
  
  <!--fin de grupos-->
   
   <div class="form-group">
    <label for="fecha_ini" class="col-sm-3 control-label"> Fecha comienzo</label>
    <div class="col-sm-3">
				  
				  <?php 
				  if($acc =="modifika"){
				  
				  $fecha_i=date("d-m-Y",strtotime($row[13]));}?>
                  
                  
                    <input  name="fecha_ini" type="text" class="form-control" id="fecha_ini" value="<?php echo "$fecha_i"; ?>" placeholder="Fecha  dd-mm-aaaa" required>
 </div>
 
 
 <label for="hora_ini" class="col-sm-2 control-label"> Horas y minutos</label>
  <div class="col-sm-3">
                    
					
                   
                  <select name="hora_ini" id="hora_ini"  >
				<?php 
				if($acc =="modifika"){
				$hora_i=date("H",strtotime($row[13]));
				}else{
					$hora_i=8;
				}
				  for($i=0 ; $i<24; $i++){
					  if($i==$hora_i){
					  $selecionado="selected=\"selected\"";
					  }else{
						   $selecionado="";
					  }
				  echo "<option value=\"".$i."\" ".$selecionado.">".$i."</option>";
				  }
				  
				  ?>
                  </select>
                 
                  
                    :
                  
                  <?php $min_i=date("i",strtotime($row[13]));?>
                  <select name="min_ini" id="min_ini" >
                    <option value="00" <?php if ($min_i==00){?>selected="selected"<?php }?>>00</option>
                    <option value="30" <?php if ($min_i==30){?>selected="selected"<?php }?>>30</option>
                  </select> 
      		
            </div>
            
          </div>
          
          
                 
               <div class="form-group">
    <label for="fecha_final" class="col-sm-3 control-label">Fecha final </label>
    
                  
                 
                 
                <div class="col-sm-3"> 
				  
				  <?php if($acc =="modifika"){
				  $fecha_f=date("d-m-Y",strtotime($row[14]));}?><input name="fecha_fin" type="text" class="form-control" id="fecha_fin" value="<?php echo "$fecha_f"; ?>" placeholder="Fecha  dd-mm-aaaa"  required >
                  </div>
                  
                  <label for="hora_fin" class="col-sm-2 control-label"> Horas y minutos</label>
  <div class="col-sm-3">
                  
                  <select name="hora_fin" id="hora_fin">
					<?php if($acc =="modifika"){ $hora_f=date("H",strtotime($row[14]));
					}else {
					$hora_f=23;
					}
				  for($i=1 ; $i<24; $i++){
					  if($i==$hora_f){
					  $selecionado1="selected=\"selected\"";
					  }else{
						   $selecionado1="";
					  }
				  echo "<option value=\"".$i."\" ".$selecionado1.">".$i."</option>";
				  }
				  
				  ?>
                  </select>
                  :<?php if($acc =="modifika"){ $min_f=date("i",strtotime($row[14]));
				  }else{
					  $min_f=59;
				  }?>
                  
                   
                  <label for="min_fin"></label>
                  <select name="min_fin" id="min_fin">
                    <option value="00" <?php if ($min_f==00){?>selected="selected"<?php }?>>00</option>
                    <option value="30" <?php if ($min_f==30){?>selected="selected"<?php }?>>30</option>
                    <option value="59" <?php if ($min_f==59){?>selected="selected"<?php }?>>59</option>
                  </select> 
                  </div>
                  
                 
               </div> 
                  
               <div class="form-group">
    <label for="tipo" class="col-sm-3 control-label">Tipo de votación </label>
    <div class="col-sm-9">
               
               
                    <?php 
					  
					  if($acc =="modifika"){
						  echo "$row[6] | "; 
						 ?>  <input name="tipo" type="hidden" id="tipo" value="<?php echo "$row[6]"; ?>" />  <?php 
					  if($row[6]==1){
						  echo "PRIMARIAS";
						   if($row[24]==0){
							   echo " con recuento BORDA ";
						   } else if($row[24]==1){
							   echo " con recuento DOWDALL ";
						   }
					  }
					  else if($row[6]==2){
						  echo "VUT";
					  }
					  else if($row[6]==3){
						  echo "ENCUESTA";
					  }else if($row[6]==4){
						  echo "DEBATE";
						  $display_debate="  style=\"display:none\"";
					  }
					  
					   
					  }
					  else{
						   ?>
                           <label>
                      <input name="tipo" type="radio" id="tipo_0" value="1" checked="checked"  onClick="pon_opciones1()"/>
            Primarias / orden(1)</label>
                      <div id="recuento"  class="caja_de_display_b"  <?php echo "$recuento"; ?>>
                    <h5> Tipo de recuento</h5>
                    <p>
                      <label>
                        <input name="tipo_recuento" type="radio" id="tipo_recuento_0" value="0" checked="CHECKED">
                        BORDA</label>
                      <br>
                      <label>
                        <input type="radio" name="tipo_recuento" value="1" id="tipo_recuento_1">
                      DOWDALL                      </label>
                      <br>
                    </p>
                    
                    </div>
            <br />
                    <label>
                      <input type="radio" name="tipo" value="2" id="tipo_1" onClick="pon_opciones()" />
                      VUT 
                    (2)</label><br />
                      <label>
                        
                        <input type="radio" name="tipo" value="3" id="tipo_2" onClick="pon_opciones()" />
                        Encuesta (3)</label><br />
                        <input type="radio" name="tipo" value="4" id="tipo_3" onClick="quita_opciones()" />
                        Debate (4)</label><br />
                           
					<?php  }
					  ?>
                                    
                     </div>
                   </div>
                   
                   
                   <div class="form-group">
    <label for="tipo_usuario_0" class="col-sm-3 control-label"> Tipo de votante </label>
    <div class="col-sm-9">
                  
                   
                         <?php 
						 
						 
						 if ($row[7]==1){
					 $chekeado1="checked=\"checked\" ";
					  
				 }else if ($row[7]==2){
					 $chekeado2="checked=\"checked\" ";
					  
				 }else if ($row[7]==3){
					 
					  $chekeado3="checked=\"checked\" ";
				 }else if ($row[7]==5){
					 
					  $chekeado5="checked=\"checked\" ";
				 } 
				 else{ //// si estamos creando indicamos por defecto la primera opcion
					 $chekeado1="checked=\"checked\" ";
				 }
				 ?>
                        
                        <label>
                          <input name="tipo_usuario" type="radio" id="tipo_usuario_0" value="1" <?php echo "$chekeado1"; ?>  />
                          Solo socios (1)</label>
                          
                          <br/>
                          <label>
                          <input type="radio" name="tipo_usuario" value="2" id="tipo_usuario_1" <?php echo "$chekeado2"; ?>  />
                          Socios y simpatizantes verificados (2)</label>
                          
                          <br/>
                          
                          <input type="radio" name="tipo_usuario" value="3" id="tipo_usuario_2" <?php echo "$chekeado3"; ?> /> 
                          Socios y simpatizantes (3)

							<br/>

						<!--<input type="radio" name="tipo_usuario" value="5" id="tipo_usuario_3" <?php echo "$chekeado5"; ?> />
Abierta (5) -->
                    
                  </div>
                  </div>  
                    
                    
    <div class="form-group">
    <label for="tipo_usuario_0" class="col-sm-3 control-label">Estado</label>
    <div class="col-sm-9">
    
    
                      <?php if ($row[2]=="si"){
					 $chekeado_estado1="checked=\"checked\" ";
					  
				 }else {
					 $chekeado_estado2="checked=\"checked\" ";
					  
				 };?>
                      <br />
                      <input name="estado" type="radio" id="estado_0" value="si" <?php echo "$chekeado_estado1"; ?> />
                      Activado</label>
                      <br />
                      <label>
                        <input name="estado" type="radio" id="estado_1" value="no" <?php echo "$chekeado_estado2"; ?> />
                    Desactivado</label>
                    
                    
                    
                    
                 
                  
                  </div>
                  </div>
                  
                       
                          <div class="form-group">
    <label for="numero_opciones" class="col-sm-3 control-label">Numero de opciones que se pueden votar </label>
    <div class="col-sm-9">
                   <div class="col-sm-2">
                 
                        <input name="numero_opciones" type="number" class="form-control" id="numero_opciones" value="<?php echo "$row[8]";?>" min="0" required /> 
                       </div>
                       Solo para opcion encuesta, si no hay limite ponga un &quot;0&quot;
                      <br />
                      <span class="label label-warning">¡¡atención!! Si usa VUT o PRIMARIAS es necesario indicar un numero de opciones que se cogeran </span><br />
                    </div>
                  </div>
                  
                  
                   <div id="accion_opciones" <?php echo "$display_debate"; ?> > 
                  
                  
                  <div class="form-group">
    <label for="tipo_seg" class="col-sm-3 control-label">Seguridad de control de voto</label>
    <div class="col-sm-9">
    
    
                          <?php
						   if($acc =="modifika"){
						   if ($row[21]==1){
					 $chekeado21="checked=\"checked\" ";
					  
				 }else if ($row[21]==2){
					 $chekeado22="checked=\"checked\" ";
					  
				 }else if ($row[21]==3){
					 
					  $chekeado23="checked=\"checked\" ";
				 }
				 else if ($row[21]==4){
					 
					  $chekeado24="checked=\"checked\" ";
				 };
						   }else{
							   $chekeado21="checked=\"checked\" ";
						   }
				 ?>
                          <input name="tipo_seg" type="radio" id="tipo_seg_3" value="1" <?php echo "$chekeado21"; ?>  />
                          Sin trazabilidad ni interventores(1)</label>
                          
                          <br/>
                          <input type="radio" name="tipo_seg" value="2" id="tipo_seg_4" <?php echo "$chekeado22"; ?> />
                          comprobacion de voto(2)<span class="label label-warning"> No funciona en VUT </span>
                          <br/>
                          
                          <input type="radio" name="tipo_seg" value="3" id="tipo_seg_5" <?php echo "$chekeado23"; ?> />
                          Con interventores (3)
                          
                          <br/>
                          <input type="radio" name="tipo_seg" value="4" id="tipo_seg_6" <?php echo "$chekeado24"; ?> />
                          Con comprobacion de voto e interventores (4) <span class="label label-warning">No funciona en VUT </span>
                          
                          </div>
                        </div>
                          
                     
                    <?php if($_SESSION['usuario_nivel']==0){?>
                     <div class="form-group">
    <label for="numero_opciones" class="col-sm-3 control-label">Permitir interventores especiales</label>
    <div class="col-sm-9">
    <span class="col-sm-2">
    
    <?php 
	if($row[23]=="si"){
	$valor_chek="checked=\"CHECKED\"";
	}?>
                   <input name="si_interventores" type="checkbox" value="permitir" <?php echo $valor_chek ?>> 
                   Permitir
                 </span> 
                   <span class="col-sm-2">
                   <?php 
				     if($acc =="modifika"){
				   $valor_inter=$row[22];
					 }else{
					$valor_inter=0;	 
					 }
				   ?>
                   <input name="numero_interventores" type="number" class="form-control" id="numero_interventores" value="<?php echo "$valor_inter";?>" min="0" required />
                   </span><span class="col-sm-4">Numero de interventores necesarios para incluir datos </span>
                     <h4><span class="label label-warning">¡¡atención!!, permitira quelos interventores puedan meter votos en el sistema</span></h4>
                   
                    </div>
                  </div>
                    
                    <?php }?>
                    </div>
                    
                    <div class="form-group">
    <label for="resumen" class="col-sm-12 control-label">Resumen</label>
    <div class="col-sm-12">
    
    
<script src="../modulos/ckeditor/ckeditor.js"></script>              
       
	<textarea cols="80" id="resumen" name="resumen" rows="10"><?php echo "$row[5]"; ?></textarea>
		<script>


			CKEDITOR.replace( 'resumen', {
				toolbarGroups: [
	{ name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
	{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
    { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
	{ name: 'tools' },
	'/',
    { name: 'links' },
    { name: 'insert' },  
    { name: 'others' },  
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	'/',
    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
    { name: 'styles' },
    { name: 'colors' },
	],
    filebrowserBrowseUrl: '../modulos/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl: '../modulos/ckfinder/ckfinder.html?Type=Images',
    filebrowserFlashBrowseUrl: '../modulos/ckfinder/ckfinder.html?Type=Flash',
    filebrowserUploadUrl: '../modulos/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl: '../modulos/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl: '../modulos/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});

		</script>
                    </div>
                  </div>
                    
                    <div class="form-group">
    <label for="texto" class="col-sm-12 control-label">Texto</label>
    <div class="col-sm-12">
     
        
	<textarea cols="80" id="texto" name="texto" rows="10"><?php echo "$row[4]"; ?></textarea>
		<script>


			CKEDITOR.replace( 'texto', {
				toolbarGroups: [
	{ name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
	{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
    { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
	{ name: 'tools' },
	'/',
    { name: 'links' },
    { name: 'insert' },  
    { name: 'others' },  
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	'/',
    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
    { name: 'styles' },
    { name: 'colors' },
	],
    filebrowserBrowseUrl: '../modulos/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl: '../modulos/ckfinder/ckfinder.html?Type=Images',
    filebrowserFlashBrowseUrl: '../modulos/ckfinder/ckfinder.html?Type=Flash',
    filebrowserUploadUrl: '../modulos/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl: '../modulos/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl: '../modulos/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});

		</script>
                      <br />
                      <br />
                      <input name="anadido" type="hidden" id="anadido" value="<?php echo"$nombre_usuario";?>" />
                      <input name="fecha" type="hidden" id="fecha" value="<?php echo"$fecha";?>" />
                      <input name="asamblea" type="hidden" id="asamblea" value="<?php echo"$asamblea";?>" />
					  <?php  if($acc =="modifika"){ ?>
                      <input name="modifika_votacion" type=submit  class="btn btn-primary pull-right"  id="add_directorio" value="MODIFICAR esta  votacion" />
                      <?php }else{ ?>
                      <input name="add_votacion" type=submit class="btn btn-primary pull-right"  id="add_directorio" value="CREAR una nueva votacion" />
                      <?php }?>
                                       </div>
                                       </div>
                                       
               
</form>
                             
                
    
                    
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
			minDate: 0,
			numberOfMonths: 3,
			showButtonPanel: true,
			onClose: function( selectedDate ) {
				$( "#fecha_fin" ).datepicker( "option", "minDate", selectedDate );
			}
			
		});
		$( "#fecha_fin" ).datepicker({
			minDate: 0,
			numberOfMonths: 3,
			showButtonPanel: true,
			onClose: function( selectedDate ) {
				$( "#fecha_ini" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
		
		
	});
	</script>
    
      <script type="text/javascript">
			$(document).ready(function(){
				$('#provincia2').change(function(){
					
				var id_provincia=$('#provincia2').val();
				$('#municipio').load('../basicos_php/genera_select.php?id_provincia='+id_provincia);
				$("#municipio").html(data);
				});
			});		
	   </script>
       
      
       <?php if($acc =="modifika"){ ?>
       	<script type="text/javascript">
		  function loadPoblacion(){
	
			 $('#municipio').load('../basicos_php/genera_select.php?id_provincia=<?php echo $row[1];?>&id_municipio=<?php echo $row[25];?>');
			 $("#municipio").html(data);
		  }
		  
		
		    $(document).ready(function(){  
		     loadPoblacion(); 
		    });
		 </script>
         <?php }else{?>
			 <?php  if ($_SESSION['nivel_usu']<=2){?>
             <script type="text/javascript">
              function loadPoblacion(){
    
                 $('#municipio').load('../basicos_php/genera_select.php?id_provincia=1');
                 $("#municipio").html(data);
              }
              
            
                $(document).ready(function(){  
                 loadPoblacion(); 
                });
             </script>
         
        	 <?php }else {?>
       			  <script type="text/javascript">
					  function loadPoblacion(){
			
						 $('#municipio').load('../basicos_php/genera_select.php?id_provincia=<?php echo $name;?>');
						 $("#municipio").html(data);
					  }
					  
					
						$(document).ready(function(){  
						 loadPoblacion(); 
						});
					 </script>
         
        	 <?php }?>
         <?php }?>
    
  </body>
</html>