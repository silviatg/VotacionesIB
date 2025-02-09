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
$nivel_acceso=2; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
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
        

        
        
        <div class="col-md-2" >             
          
          <?php  include("../votacion/menu_nav.php"); ?>
            
        </div>
       
        
        
        <div class="col-md-10">
     
                   <!--Comiezo-->
                   <h1>AÑADIR VOTANTES DE FORMA MASIVA</h1>
           <?php  
		   
		   if ($inmsg!=""){
		  echo "<div class=\"alert alert-success\"> ¡¡¡Error!!!  No se han  registrado estos usuarios.</div>";
		   echo "$inmsg";}?>
			  <?php  echo "$mensaje1";?>
			
            
            <?php 
			
			if ($_POST['emails'] != '')
				{
					if ($_POST['provincia'] != '00'){
							
						
	$optiones = "select  id_ccaa from $tbn8 where ID ='".$_POST['provincia']."'";
	$resultas = mysqli_query($con, $optiones) or die("error: ".mysqli_error($con));
	
	while( $listrowes = mysqli_fetch_array($resultas) ){ 	
	$id_ccaa = $listrowes[id_ccaa];

}
}
          
		       $emails =strip_tags($_POST['emails'], '<\n><br/>');
				$emailarray = explode("\n", $emails);

				$numrows = count($emailarray);
				for ($i = 0; $i < $numrows; $i++)
					{
					$emailarray1 = explode(',', $emailarray[$i]);
						$mail_expr = "/^[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*"
."@[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*$/";
	if (!isset($emailarray1[0])){
						$inmsg.="Falta correo <br/>";
					}
					elseif(!preg_match($mail_expr,$emailarray1[0]))
					{
						$error = "error";
					$inmsg.="<div class=\"alert alert-warning\"> la direccion ". $emailarray1[0]." es erronea</div>";

}  
						else if ($_POST['provincia'] == '00'){
							$mensaje2="<div class=\"alert alert-warning\"> error ¡¡escoja una provincia!!</div>";
						}
						
						else
							{
								
	$nif_val=  fn_filtro($con,trim($emailarray1[2]));		
	$user_val= fn_filtro($con,trim($emailarray1[1]));	
	$municipio_val=  fn_filtro($con,trim($emailarray1[3]));			
/////miramos si el usaurio ya existe								
$usuarios_consulta = mysqli_query($con, "SELECT ID FROM $tbn9 WHERE nif='".$nif_val."' or correo_usuario='".trim($emailarray1[0])."' ") or die(mysqli_error($con));

$total_encontrados = mysqli_num_rows ($usuarios_consulta);

mysqli_free_result($usuarios_consulta);



if ($total_encontrados != 0){

$inmsg.= " El Usuario ".trim($emailarray1[1])." con correo ".trim($emailarray1[0])."  y nif ".trim($emailarray1[2])." ya está registrado.<br/>";

}


else{
							
								
							$query = "	insert into $tbn9  (ID,correo_usuario, nombre_usuario, nif, tipo_votante, id_provincia,id_ccaa,id_municipio )	values	 ('', '".trim($emailarray1[0])."', '".$user_val."', '".$nif_val."', '".$_POST['tipo_usuario']."', '".$_POST['provincia']."', '".$id_ccaa."', '".$municipio_val."')";

							$result = @mysqli_query($con,$query) or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");
							
							
						$mensaje1.="  Usuario: ".trim($emailarray1[1])." . Correo: ".trim($emailarray1[0])." NIF: ".trim($emailarray1[2])." Idenitifcador municipio : ".$municipio_val."<br/>";	
							}
							
					}

				
				}
			
				}

			?>
		
		
				Para añadir nuevos suscriptores a su lista escriba  la dirección de correo, el nombre ,  el nif y el identificador del municipio separadas por una coma (,) Use una linea para cada suscriptor , si desconoce el nombre ponga algo como, miembro, usuario..etc  ya que este dato no se puede quedar vacio. La direccion de correo es imprescindible.<br />
				<br/>
                Ejemplo: <br/>
                <ul>
                 carlos@yahoo.es, carlos, 384955l 
               ,3305<br/> 
               juan@iespana.es, juan erez, 384752z
                ,220<br/>etc</ul>
                Recuerde elegir el tipo de usuario , añada primero los de un tipo y luego los del otro, no se pueden mezclar.   
			  
                <?php  if($inmsg!=""){?> <br/><div class="alert alert-warning"> <?php  echo "$inmsg";?> </div> <?php }?>
                <?php  echo "$mensaje2";?>
                <?php  if($mensaje1!=""){?>
				<br/><div class="alert alert-success"> Estos usuarios han sido añadidos:</div>
				<div class="alert alert-success">  
				<?php  echo "$mensaje1";?></div><?php }?>
				
		  <form Action="<?php $_SERVER['PHP_SELF']?>" Method=POST class="well form-horizontal">	
			
                <?php 	
                  
                    
					  if ($_SESSION['nivel_usu']==2){   
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
	<?php 
	
	
}else  if ($_SESSION['nivel_usu']==3){
	
	$options = "select DISTINCT id, provincia from $tbn8  where id_ccaa=$ids_ccaa  order by ID";
	$resulta = mysqli_query($con, $options) or die("error: ".mysqli_error($con));
	
	while( $listrows = mysqli_fetch_array($resulta) ){ 
	$id_pro = $listrows[id];
	$name1= utf8_encode($listrows[provincia]);
	$lista1 .="<option value=\"$id_pro\"> $name1</option>";
	}?>
    
    <h2> Escoja una Provincia </h2><div class="col-sm-9">
				      <select name="provincia" class="form-control"  id="provincia" ><?php echo "$lista1";?></select>
                    </div>
	<?php 
}
		else{		
				
$result2=mysqli_query($con,"SELECT id_provincia FROM $tbn5 where id_usuario=".$_SESSION['ID']);
$quants2=mysqli_num_rows($result2);
//$row2=mysqli_fetch_row($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	
	$name2= utf8_encode($listrows2[id_provincia]);
	 $optiones=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$name2");
     $row_prov=mysqli_fetch_row($optiones);
    $lista1 .="<label><input  type=\"radio\" name=\"provincia\" value=\"$name2\"  checked=\"checked\"  id=\"provincia\" /> ". utf8_encode($row_prov[0])."</label> <br/>";
	 }
				echo "$lista1"; 
}
 else{
echo " No tiene asignadas provincias, no podra crear votación";	
}
 }	
?> 
 <div class="col-sm-8">               
<input name="tipo_usuario" type="radio" id="tipo_usuario_0" value="1" /> socios (1)
<input name="tipo_usuario" type="radio" id="tipo_usuario_1" value="2" checked="checked" /> 
simpatizantes verificado(2)
<input name="tipo_usuario" type="radio" id="tipo_usuario_2" value="3" checked="checked" /> 
simpatizantes (3)
		    
            </div>
            <label for="emails"></label>
            <textarea name="emails" cols="80" rows="30" id="emails" class="form-control" ></textarea>
           <p>&nbsp;</p>   <input type="submit" value="Añadir votantes de la lista"  class="btn btn-primary pull-right" > <p>&nbsp;</p>
			
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
  
  </body>
</html>