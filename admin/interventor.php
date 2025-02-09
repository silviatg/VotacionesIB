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
$nivel_acceso=7; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}




//include("fckeditor/fckeditor.php") ;
include("../basicos_php/basico.php") ;


$idvot=fn_filtro_numerico($con,$_GET['idvot']);
$fecha =date("Y-m-d H:i:s");	  
  
 if ($_GET['id']!=""){
 $id=fn_filtro_numerico($con,$_GET['id']); 
 $acc=fn_filtro_nodb($_GET['acc']);
 }



if(ISSET($_POST["modifika_interventor"])){

$nombre=fn_filtro($con,$_POST['nombre']);
$apellido=fn_filtro($con,$_POST['apellido']);
$tipo=fn_filtro($con,$_POST['tipo']);

$mail_expr = "/^[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*"
."@[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*$/";

if (empty($_POST['correo'])){
$texto1="<div class=\"alert alert-danger\">¡¡¡ERROR!!! La direccion de correo es un dato necesario</div>";
} elseif(!preg_match($mail_expr,$_POST['correo']))
{

$texto1="<div class=\"alert alert-danger\">¡¡¡ERROR!!! <br/>la direccion es erronea</div>";
} else{
$correo=fn_filtro($con,$_POST['correo']);
$nombre_usuario=$_SESSION['nombre_usu'];

$sSQL="UPDATE $tbn11 SET nombre=\"$nombre\",apellidos=\"$apellido\",  correo=\"$correo\" ,fecha_modif=\"$fecha\",  modif=\"$nombre_usuario\" ,  tipo=\"$tipo\" WHERE id='$id'";

mysqli_query($con,$sSQL)or die ("Imposible modificar pagina");

$texto1="<div class=\"alert alert-success\">Realizadas las Modificaciones <br>Asi ha quedado el interventor $nombre $apellido</div>";
}
}

if(ISSET($_POST["add_interventor"])){

$nombre=fn_filtro($con,$_POST['nombre']);
$apellido=fn_filtro($con,$_POST['apellido']);
$tipo=fn_filtro($con,$_POST['tipo']);
$provincia=fn_filtro($con,$_POST['provincia']);
$id_votacion=fn_filtro_numerico($con,$_POST['id_vot']);

$mail_expr = "/^[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*"
."@[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*$/";

if (empty($_POST['correo'])){
$texto1="<div class=\"alert alert-danger\">¡¡¡ERROR!!! La direccion de correo es un dato necesario</div>";
} elseif(!preg_match($mail_expr,$_POST['correo']))
{

$texto1="<div class=\"alert alert-danger\">¡¡¡ERROR!!! <br/>la direccion es erronea</div>";
} else{
$correo=fn_filtro($con,$_POST['correo']);
$usuario=$_SESSION['ID'];
	$insql = "insert into $tbn11 (nombre, 	id_provincia, 	apellidos, correo,id_votacion,anadido, fecha_anadido,tipo) values (  \"$nombre\",  \"$provincia\", \"$apellido\", \"$correo\", \"$id_votacion\", \"$usuario\", \"$fecha\", \"$tipo\")";
	$inres = @mysqli_query($con,$insql) or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");
	$texto1 ="<div class=\"alert alert-success\">Añadido interventor <br/> $nombre $apellido con correo  $correo <br/> a la base de datos</div> ";
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
   
    <link href="../temas/<?php echo "$tema_web"; ?>/estilo.css" rel="stylesheet">
  
  </head>
  <body>
  <p><!-- NAVBAR
================================================== -->
  </p>
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
  <?php $result_vot=mysqli_query($con,"SELECT nombre_votacion,seguridad,interventor, interventores FROM $tbn1 where id=$idvot");
 		 $row_vot=mysqli_fetch_row($result_vot);
                   ?>
                   
<h1> <?php  if($acc =="modifika"){?>
<?php 
  $result=mysqli_query($con,"SELECT * FROM $tbn11 where id=$id");
  $row=mysqli_fetch_row($result);
?>
 MODIFICAR INTERVENTOR/INTERVENTORA
 <?php }else{?>
 INCLUIR INTERVENTOR/INTERVENTORA <?php }?></h1>
     <h3>   en la votación   <?php echo $row_vot[0]; ?></h3>

<p><?php echo"$texto1";?></p>
<p><a href="interventor_busq1.php?idvot=<?php echo $idvot; ?>">Ver interventores de esta votación </a></p>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method=post   name="frmDatos" id="frmDatos"  class="well form-horizontal" >
 
            <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Nombre</label>
             
            <div class="col-sm-9">   
                  
                <input name="nombre" type="text"  id="nombre" value="<?php echo "$row[2]";?>"   class="form-control" placeholder="Nombre" required autofocus data-validation-required-message="El nombre  es un dato requerido" />
			  </div></div>
 <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Apellidos</label>
             
            <div class="col-sm-9">   
			<input name="apellido" type="text"  id="apellido" value="<?php echo "$row[3]";?>" class="form-control" placeholder="Apellidos" required autofocus data-validation-required-message="El apellido  es un dato requerido" />
            </div></div>
             <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Correo</label>
             
            <div class="col-sm-9">   
            <input name="correo" type="email"  id="correo" value="<?php echo "$row[4]";?>"   class="form-control" placeholder="Correo electronico" required  data-validation-required-message="Por favor, ponga un correo electronico"  />
            </div></div>
            
            <?php if($row_vot[1]==3 or $row_vot[1]==4){
				if($row_vot[2]=="si"){
				?>
               <?php if ($row[12]==0){
					 $chekeado0="checked=\"checked\" ";			  
				 }else if ($row[12]==1){
					 $chekeado1="checked=\"checked\" ";
				 }else if ($row[12]==2){
					 $chekeado2="checked=\"checked\" ";		  
				 } ?>
             <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Tipo de interventor</label>
             
            <div class="col-sm-9">
               <label>
                 <input type="radio" name="tipo" value="0" id="tipo_0"  <?php echo "$chekeado0"; ?> >
                 correo</label>
               <br>
               <label>
                 <input type="radio" name="tipo" value="2" id="tipo_1"  <?php echo "$chekeado1"; ?> >
                 Especial</label>
               <br>
               <label>
                 <input type="radio" name="tipo" value="1" id="tipo_2"  <?php echo "$chekeado2"; ?> >
                 correo + especial</label>
              </div></div>
              <?php }
			  else {?>
              <input name="tipo" type="hidden" id="tipo" value="0" />
              <?php } 
			}else if($row_vot[2]=="si"){?>
            <input name="tipo" type="hidden" id="tipo" value="1" />
              <?php }?>
              
              
              
        <input name="incluido" type="hidden" id="incluido" value="<?php echo $_SESSION['ID'];?>" />
                   <input name="id_vot" type="hidden" id="id_vot" value="<?php echo"$idvot";?>">
                   <input name="fecha" type="hidden" id="fecha" value="<?php echo"$fecha";?>" />
                  
                 <?php  if($acc =="modifika"){ ?>
                 <input name="modifika_interventor" type=submit  class="btn btn-primary pull-right"  id="modifika_interventor" value="ACTUALIZAR  interventor" />
                      <?php }else{ ?>
                 <input name="add_interventor" type=submit class="btn btn-primary pull-right"  id="add_interventor" value="AÑADIR  interventor" />
                      <?php }?>
             <p>&nbsp;</p>
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