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
                   <h1><h1>MODIFICACIONES O BAJAS DE AFILIADOS/ SIMPATIZANTES DE FORMA MASIVA</h1></h1>
           <?php  
		   
		   if ($inmsg!=""){
		  echo "<div class=\"alert alert-success\"> ¡¡¡Error!!!  No se han  registrado estos usuarios.</div>";
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

					if (!isset($emailarray1[0])){
						$mensaje1="Falta correo";
					/*else if (!isset($emailarray1[1]))
					$mensaje1="Faltan nombre";*/
					}
						
						else
							{
/////miramos si el usaurio ya existe								
$usuarios_consulta = mysqli_query($con,"SELECT ID FROM $tbn9 WHERE nif='".trim($emailarray1[2])."' or correo_usuario='".trim($emailarray1[0])."' ") or die(mysql_error());

$total_encontrados = mysqli_num_rows ($usuarios_consulta);
$row=mysqli_fetch_row($usuarios_consulta);

mysqli_free_result($usuarios_consulta);

if ($total_encontrados != 0){
	
	if($_POST['tipo_usuario']==5){
		$borrado = mysqli_query ($con,"DELETE FROM $tbn9 WHERE id=".$row[0]." ") or die("No puedo ejecutar la instrucción de borrado SQL query");
	$mensaje1.=" -> Usuario: ".trim($emailarray1[1])." . Correo: ".trim($emailarray1[0])." NIF: ".trim($emailarray1[2])." ¡¡¡ELIMINADO!!!<br/>";	

		// borrado
	}else{  ///modifciamos
		
		$sSQL="UPDATE $tbn9 SET   tipo_votante=".$_POST['tipo_usuario']."  WHERE id=".$row[0]."";

mysqli_query($con,$sSQL)or die ("Imposible modificar pagina");

				$mensaje1.=" -> Usuario: ".trim($emailarray1[1])." . Correo: ".trim($emailarray1[0])." NIF: ".trim($emailarray1[2])." Convertido en usario tipo --> ".$_POST['tipo_usuario']."<br/>";	
	}
}


else{
								
		$inmsg.= " El Usuario ".trim($emailarray1[1])." con correo ".trim($emailarray1[0])."  y nif ".trim($emailarray1[2])." NO está registrado.";
							
							
								}
					}

				//$mensaje1a.="<br /><p>Estos usuarios han sido modificados:</p><br/>";
				}
			
				}

			?>
           
            Para dar de bajas asuscriptores a su lista escriba  la dirección de correo, el nombre y  el nif separadas por una coma (,) Use una linea para cada suscriptor , si desconoce el nombre ponga algo como, miembro, usuario..etc  ya que este dato no se puede quedar vacio. La direccion de correo es imprescindible.<br />
            <br/>
Ejemplo: <br/>
<ul>
  carlos@yahoo.es, carlos, 384955l <br/>
  juan@iespana.es, juan erez, 384752z <br/>
  etc
</ul>
<?php  if($inmsg!=""){?> <br/><div class="alert alert-warning"> <?php  echo "$inmsg";?> </div> <?php }?>
                
                <?php  if($mensaje1!=""){?>
				<br/><div class="alert alert-success"> Estos usuarios han sido moificados:</div>
				<div class="alert alert-success">         
				<?php  echo "$mensaje1";?></div><?php }?>
                
				<?php  if($mensaje1a!=""){?>
				<br/><div class="alert alert-success"> Estos usuarios han sido añadidos:</div>
				<div class="alert alert-success">         
				<?php  echo "$mensaje1a";?></div><?php }?>
				
		  <form Action="<?php $_SERVER['PHP_SELF']?>" Method=POST class="well form-horizontal">	
			

	<p>¿Que dessea hacer?, dar de baja o convertir en simpatizante si son afiliados</p>
    <p>Convertir en </p>
    <table width="522">
      <tr>
        <td width="111" height="29">
          <input name="tipo_usuario" type="radio" id="tipo_usuario_0" value="1" /></td>
        <td width="160"><input name="tipo_usuario" type="radio" id="tipo_usuario_1" value="2" checked="checked" />
          (2)</td>
        <td width="130"><input name="tipo_usuario" type="radio" id="tipo_usuario_3" value="3" />
          (3)</td>
        <td width="101"><input name="tipo_usuario" type="radio" id="tipo_usuario_2" value="5" /></td>
      </tr>
      <tr>
        <td height="22">afiliado</td>
        <td>simpatizante verificado </td>
        <td> simpatizantes </td>
        <td>Dar de Baja</td>
      </tr>
    </table>
    <p>
      <label for="emails"></label>
      <textarea name="emails" cols="80" rows="30" id="emails" class="form-control" ></textarea>
    </p>
	<p>&nbsp;</p>   <input type="submit" value="Modificar/borrar votantes de la lista"  class="btn btn-primary pull-right" > <p>&nbsp;</p>
			
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