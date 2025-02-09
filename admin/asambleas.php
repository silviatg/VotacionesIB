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


if ($_GET['idvas']!=""){
 $idvas=fn_filtro_numerico($con,$_GET['idvas']); 
 $acc=fn_filtro($con,$_GET['acc']);
 }
      
$fecha_ver =date("d-m-Y ");
$fecha =date("Y-m-d h:i:s");	  

if(ISSET($_POST["add_asamblea"])){
$creado= $_SESSION['ID'];
 
$nombre=fn_filtro($con,$_POST['nombre']);
$provincia=fn_filtro_numerico($con,$_POST['provincia']);
$id_ccaa=fn_filtro_numerico($con,$_POST['comunidad_autonoma']);
$texto=fn_filtro_editor($con,$_POST['texto']);
$tipo=fn_filtro($con,$_POST['tipo']);
$acceso=fn_filtro($con,$_POST['acceso']);
$activo=fn_filtro($con,$_POST['activo']);
$tipo_usuario=fn_filtro($con,$_POST['tipo_usuario']);

if($_POST['tipo']==3){
$provincia=0;
$id_ccaa=0;
}
else if($_POST['tipo']==2){
$provincia=0;
}
else{
$result_ccaa=mysqli_query($con,"SELECT  id_ccaa  FROM $tbn8 where id=$provincia");
  $row_ccaa=mysqli_fetch_row($result_ccaa);

$id_ccaa=$row_ccaa[0];	
}

  $insql = "insert into $tbn4 (subgrupo, 	id_provincia, 	texto, id_ccaa,tipo, acceso,	activo , creado, tipo_votante) values (  \"$nombre\",  \"$provincia\", \"$texto\", \"$id_ccaa\", \"$tipo\", \"$acceso\", \"$activo\", \"$creado\" , \"$tipo_usuario\")";
  $inres = @mysqli_query($con,$insql) or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");
	
	$inmsg ="<div class=\"alert alert-success\"> Añadido nuevo grupo con nombre <br/><strong>
	$nombre </strong><br/>a la base de datos</div>";
}

 if(ISSET($_POST["modifika_asamblea"])){
$creado= $_SESSION['ID'];
$nombre =fn_filtro($con,$_POST['nombre']);
$nombre=fn_filtro($con,$nombre);
$texto=fn_filtro_editor($con,$_POST['texto']);
$acceso=fn_filtro($con,$_POST['acceso']);
$activo=fn_filtro($con,$_POST['activo']);
$tipo_usuario=fn_filtro($con,$_POST['tipo_usuario']);


$sSQL="UPDATE $tbn4 SET subgrupo=\"$nombre\",texto=\"$texto\", acceso=\"$acceso\",	activo=\"$activo\" , creado=\"$creado\", tipo_votante=\"$tipo_usuario\" WHERE ID='$idvas'";
mysqli_query($con,$sSQL)or die ("Imposible modificar pagina");

	
	$inmsg ="<div class=\"alert alert-success\"> Modificado  grupo con nombre <br/><strong>
	$nombre </strong><br/>a la base de datos</div>";

	 
	
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
       
        
        
        <div class="col-md-10">
     
                   <!--Comiezo-->
          <?php if($acc =="modifika"){
			  
  $result=mysqli_query($con,"SELECT * FROM $tbn4 where ID=$idvas");
  $row=mysqli_fetch_row($result);
		  }
			  
			  ?>         
          
<h1> <?php  if($acc =="modifika"){ echo"MODIFICAR ASAMBLEA O GRUPO DE TRABAJO"; }else{ echo "INCLUIR NUEVA ASAMBLEA O GRUPO DE TRABAJO";}?></h1>
		  
   
            <p>&nbsp;</p>
			
            
             <?php echo "$inmsg";?> 
              
          <form action="<?php $_SERVER['PHP_SELF'] ?>" method=post name="frmDatos" id="frmDatos" class="well form-horizontal">
            
            
              <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Nombre </label>
             
            <div class="col-sm-9">
                      <input name="nombre" type="text" autofocus required class="form-control" id="nombre" placeholder="Nombre de la asamblea o grupo de trabajo" value="<?php echo "$row[2]";?>" data-validation-required-message="El nombre de la votación es un dato requerido">
                  </div>
            </div>
                  
				  
				  
				
                
                 <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">TIPO</label>
             
            <div class="col-sm-9">
             <?php 
			 
			  if($acc =="modifika"){ 
				  if ($row[1]==1){
					  
					  echo "Provincial  |   $row[4]";
				 }else if ($row[1]==2){
					  
					  echo " Autonomico |  $row[5]";
				 }else if ($row[1]==3) {
					 echo "Estatal";
					   
				 }
				 
				
				 ?>
            
            
                  <?php 
				  
			  }else {
				  /////si no es administrador general con nivel 0 miramos a ver que es
				  if ($_SESSION['usuario_nivel']<=6 and $_SESSION['usuario_nivel'] !=0 ){
					if ($_SESSION['nivel_usu']==6){
							 //administrador estatal
						 ?>	
                         <input name="tipo" type="hidden" id="tipo" value="3" />
                 
							Estatal
					<?php	 }  
					  else if ($_SESSION['nivel_usu']==4 or $_SESSION['nivel_usu']==5){
					 ?>  
                     <input name="tipo" type="hidden" id="tipo" value="1" />
                     Provincial
					 <?php }
					  else if ($_SESSION['nivel_usu']==3){ 
					  ?>
                  
                     <label>
                        <input name="tipo" type="radio" id="tipo_1" value="1"  onClick="habilita_provincial()"  />
                        Provincial</label>
                     |
                      <label>
                        <input type="radio" name="tipo" value="2" id="tipo_2" onClick="habilita_autonomico()"/>
                        Autonomico</label>
                  
                  <?php }
				  }?>
                  	
					<?php 
///si es siperadministrador le dejamos que acceda a todo
				  if ($_SESSION['usuario_nivel']==0){?>  <p> 
                <label>
                        <input name="tipo" type="radio" id="tipo_1" value="1"  onClick="habilita_provincial()"  />
                        Provincial</label>
                     |
                      <label>
                        <input type="radio" name="tipo" value="2" id="tipo_2" onClick="habilita_autonomico()"/>
                        Autonomico</label>
                     |
                      <label>
                        <input name="tipo" type="radio" id="tipo_3" value="3" checked="checked"  onClick="habilita_estatal()"  />
                        Estatal</label>
                      
                    </p>
                    <?php }?>
                    
                    </div></div>
                     <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label"> </label>
             
            <div class="col-sm-9">
                    
                    
				     <?php if ($_SESSION['usuario_nivel']<=6 and $_SESSION['usuario_nivel'] !=0 ){
						 if($_SESSION['nivel_usu']==4 or $_SESSION['nivel_usu']==5){
$result2=mysqli_query($con,"SELECT id_provincia FROM $tbn5 where id_usuario=".$_SESSION['ID']);
$quants2=mysqli_num_rows($result2);
//$row2=mysqli_fetch_row($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	
	$name2= utf8_encode($listrows2[id_provincia]);
	 $optiones=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$name2");
     $row_prov=mysqli_fetch_row($optiones);
    $lista1 .="    <label><input  type=\"radio\" name=\"provincia\" value=\"$name2\"  checked=\"checked\"  id=\"provincia\" /> ". utf8_encode($row_prov[0])."</label> <br/>";
	 }
				 
}


?> <?php echo "$lista1";?> <br/>
<?php
						 }
						 else if ($_SESSION['nivel_usu']==3){
							// si es administrador autonomico 
							
						?>	
 <div id="autonomico" class="caja_de_display" style="display:none">
                  <div align="left">
                  <?php 
				echo $_SESSION['id_ccaa_usu'] ;
				 
				 
				  ?>
                  
                  </div>
                  </div>                       
				
                
                <div id="provincial"   class="caja_de_display"  style="display:none" > 
          
          <div align="left">
          <?php 
		  $ids_ccaa=$_SESSION['id_ccaa_usu'];	

$result2=mysqli_query($con,"SELECT  id, provincia FROM $tbn8 where id_ccaa=".$_SESSION['id_ccaa_usu']);


 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	
	$name2= utf8_encode($listrows2[provincia]);
    $id2= $listrows2[id];
    $lista1 .="    <label><input  type=\"radio\" name=\"provincia\" value=\"$id2\"  checked=\"checked\"  id=\"provincia\" /> ".$name2."</label> <br/>";
	 }
				 



?> <?php echo "$lista1";?> <br/>
		  
		  
          
          </div>
          </div>
                			
							
<?php 	}

 } else {?>
  <div id="autonomico" class="caja_de_display" style="display:none">
                  <div align="left">


       <p> Escoja una Comunidad Autonoma <br />si desea que la demarcacion sea Autonomica</p>
                  <?php 
					
$options_ccaa = "select DISTINCT ID, ccaa from $tbn3  order by ID";
	$resulta_ccaa = mysqli_query( $con,$options_ccaa) or die("error: ".mysqli_error($con));
	
	while( $listrows_ccaa = mysqli_fetch_array($resulta_ccaa) ){ 
	$id_ccaa = $listrows_ccaa[ID];
	$name_ccaa= utf8_encode($listrows_ccaa[ccaa]);
	$lista_ccaa .="<option value=\"$id_ccaa\"> $name_ccaa</option>"; 
	
}
 ?>
 <select name="comunidad_autonoma" class="form-control" id="comunidad_autonoma" >
	 
	 <?php echo "$lista_ccaa";?>
     </select>
     

                </div>   
                 </div>
                
                
                          
<div id="provincial"  class="caja_de_display"   style="display:none" > 
          
          <div align="left">
               <?php 


	$options = "select DISTINCT id, provincia from $tbn8  where especial=0 order by ID";
	$resulta = mysqli_query($con, $options) or die("error: ".mysqli_error($con));
	
	while( $listrows = mysqli_fetch_array($resulta) ){ 
	$id_pro = $listrows[id];
	$name1= utf8_encode($listrows[provincia]);
	$lista1 .="<option value=\"$id_pro\"> $name1</option>"; 
}		
	?>
     <p> Escoja una Provincia <br />si desea que la demarcacion sea Provincial</p>
    
				      <select name="provincia" class="form-control" id="provincia" ><?php echo "$lista1";?></select>
                      <br/>
                  	  

                    </div>
                </div>
               <?php }
			  }
			  ?> 
                   
                   </div></div>
                   
                    <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Forma de acceso al grupo</label>
             
            <div class="col-sm-9">
                   <?php if ($row[7]==1){
					 $chekeado11="checked=\"checked\" ";
					  
				 }else {
					 
					  $chekeado12="checked=\"checked\" ";
				 }
				 
				
				 ?>
                      <input name="acceso" type="radio" id="acceso_0" value="1"  <?php echo "$chekeado11"; ?> />
                    Abierto (no necesita validación para suscribirse)
                    <br />
                    
                      <input name="acceso" type="radio" id="acceso_1" value="2"  <?php echo "$chekeado12"; ?> />
                      Cerrado (necesita que los administradores validen el acceso
                    )
                   </div></div>
                    <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Activo  </label>
             
            <div class="col-sm-9">
                   <?php if ($row[8]==2){
					 $chekeado32="checked=\"checked\" ";
					  
				 }else {
					 
					  $chekeado31="checked=\"checked\" ";
				 }
				 
				
				 ?>
                   
                   
                      <input name="activo" type="radio" id="activo_0" value="1" <?php echo "$chekeado31"; ?>  />
                      Si 
                    <br />
                     
                      <input type="radio" name="activo" value="2" id="activo_1" <?php echo "$chekeado32"; ?> />
                      No 
                    </div></div>
                
                
                   
                   
                   
                   <div class="form-group">       
             <label for="Sexo" class="col-sm-3 control-label">TIPO DE VOTANTE</label>
             <div class="col-sm-9">
              <?php if ($row[10]==5){
					 $chekeado45="checked=\"checked\" ";			  
				 }else if ($row[10]==2){
					 $chekeado42="checked=\"checked\" ";
				 }else if ($row[10]==3){
					 $chekeado43="checked=\"checked\" ";		  
				 }else { 
					  $chekeado41="checked=\"checked\" ";
				 } ?>
             
             <label>
                   <input name="tipo_usuario" type="radio" id="tipo_usuario_0" value="1" <?php echo "$chekeado41"; ?> />
                   Solo socios (1)</label><br/>
                   <label>
                   <input type="radio" name="tipo_usuario" value="2" id="tipo_usuario_1" <?php echo "$chekeado42"; ?>/>
                   Socios y simpatizantes verificados(2)</label><br/>
                   <input type="radio" name="tipo_usuario" value="3" id="tipo_usuario_3" <?php echo "$chekeado43"; ?>/>
                   Socios y simpatizantes (3)<br/>
                   <input type="radio" name="tipo_usuario" value="5" id="tipo_usuario_2" <?php echo "$chekeado45"; ?>/>
                   Abierta (5) 
             </div></div>
                    
                    <div class="form-group">   
               <div class="col-sm-12">         
             <label for="nombre" >Texto</label>
             
            
                  
   <script src="../modulos/ckeditor/ckeditor.js"></script>              
       
	<textarea cols="80" id="texto" name="texto" rows="10"><?php echo "$row[6]"; ?></textarea>
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
                   
              <p>&nbsp;</p>      
                     
                      <input name="fecha" type="hidden" id="fecha" value="<?php echo"$fecha";?>" />
                      <input name="id_vot" type="hidden" id="id_vot" value="<?php echo"$idvot";?>">
                      <?php  if($acc =="modifika"){ ?>
                      <input name="modifika_asamblea" type=submit  class="btn btn-primary pull-right"  id="add_asamblea" value="MODIFICAR esta  asamblea o grupo" />
                      <?php }else{ ?>
                      <input name="add_asamblea" type=submit class="btn btn-primary pull-right"  id="add_asamblea" value="CREAR una nueva asamblea o grupo" />
                      <?php }?>
    </form>
            
            
      
      
      </div>
		</div>
	  
      
    
                    
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
  
	  
  </body>
</html>