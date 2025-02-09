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
$nivel_acceso=3; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}

require_once('../modulos/PHPMailer/class.phpmailer.php');
include("../modulos/PHPMailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
include ('../basicos_php/basico.php');
$id=fn_filtro_numerico($con,$_GET['id']);
if(ISSET($_POST["add_candidato"])){


$tipo_usuario=fn_filtro($con,$_POST['tipo_usuario']);
$nivel_acceso=fn_filtro($con,$_POST['nivel_acceso']);

$datos_nombre=fn_filtro($con,$_POST['datos_nombre']);
$id_provincia=fn_filtro_numerico($con,$_POST['id_provincia']);

if ($_POST['tipo_usuario']==1 ){
	$nivel_acceso=10; }

////miramos la provincia y cogemos el codigo de ccaa
 if ($_POST['tipo_usuario']>=5 &&$_POST['nivel_acceso']<=5){
	$inmsg1 = "<div class=\"alert alert-danger\">Error, este tipo de usuario no puede tener este nivel de acceso. No se han realizado los cambios</div>"; 
 }
else{

$sSQL="UPDATE $tbn9 SET  nivel_usuario=\"$tipo_usuario\"  ,nivel_acceso=\"$nivel_acceso\"  WHERE id='$id'";

mysqli_query($con,$sSQL)or die ("Imposible modificar pagina");

	
	$inmsg1 ="<div class=\"alert alert-success\">Modificado $datos_nombre en la base de datos</div>";
 
if($tipo_usuario==4 or $tipo_usuario==5 )
{ 

$result2=mysqli_query($con,"SELECT ID,admin FROM $tbn5 where id_usuario=$id and id_provincia=$id_provincia");
//  $result2=mysqli_query($conta,$con);

$quants2=mysqli_num_rows($result2);
$row2=mysqli_fetch_row($result2);

if ($quants2==""){
	if($tipo_usuario==4){
	$admin=1;
	}
	else{
	$admin=2;	
	}

$insql_prov = "insert into $tbn5 (id_usuario,id_provincia,admin ) values (  \"$id\", \"$id_provincia\", \"$admin\")";
	$inres = @mysqli_query($con,$insql_prov) or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");
	
 $enlace_asigna="<div class=\"alert alert-success\"><a data-toggle=\"modal\"  href=\"usuarios_asigna.php?id=".$id."\"  data-target=\"#apuntarme\"  title=\" ".$row[3]." \" >
 ¡¡¡ATENCION!!! Se le ha asignado de forma predeterminada al usuario la provincia a la que pertenece <br/>
  Si desea asignarle mas provincias de su comunidad autonoma o grupos de trabajo, puede hacerlo ahora</a></div>";
}
else{
if ( $tipo_usuario==4 and $row2[1]==2){
	$sSQL2="UPDATE $tbn5 SET  admin='1' WHERE id='$row2[0]'"; //no funciona
	mysqli_query($con,$sSQL2)or die ("Imposible modificar pagina");
//echo "$id y ";
//echo "4";
}else if ( $tipo_usuario==5 and $row2[1]==1){
	$adm=2;
	$sSQL2="UPDATE $tbn5 SET  admin='2' WHERE id='$row2[0]'"; //no funciona
	mysqli_query($con,$sSQL2)or die ("Imposible modificar pagina");

// echo "5 y $id y $row2[1]";
}
}
  $enlace_asigna="<div class=\"alert alert-success\"><a data-toggle=\"modal\"  href=\"usuarios_asigna.php?id=".$id."\"  data-target=\"#apuntarme\"  title=\" ".$row[3]." \" >¡¡¡ATENCION!!!
  Si desea asignarle mas provincias de su comunidad autonoma o grupos de trabajo, puede hacerlo ahora</a></div>";
}
else{
	
	///// borrar todos los registros si cambia de status ¿hay que borarlo?  y si deja de ser administrador pero sigue en el grupo de trabajo? en ese camio habria que cambiar y que dejara de ser administrador ver como lo hacemos
//$borrado = mysqli_query ("DELETE FROM $tbn5 WHERE id_usuario=$id") or die("No puedo ejecutar la instrucción de borrado SQL query");
}
if($tipo_usuario==6 or $tipo_usuario==7 ){
	$enlace_asigna="<div class=\"alert alert-success\"><a data-toggle=\"modal\"  href=\"usuarios_asigna.php?id=".$id."\"  data-target=\"#apuntarme\"  title=\" ".$row[3]." \" >¡¡¡ATENCION!!!
  Si desea asignarle grupos de trabajo, puede hacerlo ahora</a></div>";

}
	
	
	if ($_POST['notificar']=="notificar"){
		$correo_notificar= fn_filtro_nodb($_POST['correo_notificar']);
		if($tipo_usuario==2)
{ $dato_nivel_correo="Administrador <br/> Tenga en cuenta la responsabilidad que implica y sea cuidadoso al hacer las modificaciones. <br/> muchas gracias";
	}
else if($tipo_usuario==3)
{ $dato_nivel_correo="Administrador CCAA <br/> Tenga en cuenta la responsabilidad que implica y sea cuidadoso al hacer las modificaciones. <br/> muchas gracias";	
}
else if($tipo_usuario==4)
{ $dato_nivel_correo="Administrador provincia  <br/> Tenga en cuenta la responsabilidad que implica y sea cuidadoso al hacer las modificaciones. <br/> muchas gracias";
  $enlace_asigna="<br/><a href=\"usuarios_asigna.php?id=".$row[0]."\" class=\"fotos\" title=\" ".$row[3]." \" rel=\"gb_page_center[760, 620]\" >¡¡¡ATENCION!!! tiene que asignarle al usuario provincias o grupos</a>";
}
else if($tipo_usuario==5)
{ $dato_nivel_correo="Administrador Asamblea local o grupo de trabajo provincial  <br/> Tenga en cuenta la responsabilidad que implica y sea cuidadoso al hacer las modificaciones. <br/> muchas gracias";
  $enlace_asigna="<br/><a href=\"usuarios_asigna.php?id=".$row[0]."\" class=\"fotos\" title=\" ".$row[3]." \" rel=\"gb_page_center[760, 620]\" >¡¡¡ATENCION!!! tiene que asignarle al usuario provincias o grupos</a>";
}
else if($tipo_usuario==6)
{ $dato_nivel_correo="Administrador grupo trabajo Estatal  <br/> Tenga en cuenta la responsabilidad que implica y sea cuidadoso al hacer las modificaciones. <br/> muchas gracias";	
}
else 
{ $dato_nivel_correo="Votante";	
}

		
		
		
/////////// Comienzo del envio de correo	
$mensaje = "Este mensaje fue enviado por " . $_SESSION['nombre_usu'] . " \r\n";

$mensaje .= " el " . date('d/m/Y', time());

$mensaje .= "<br /> Mensaje: 
<br /> Hola ".$datos_nombre."<br /> 
Su nivel de usuario en el sistema de votaciones de \" ".$nombre_eq." \" ha sido modificado. <br/>
Su nivel de acceso ahora es de ".$dato_nivel_correo ."
<br/><br/>
Un saludo

\r\n";




//<$mail->IsSendmail(); // telling the class to use SendMail transport

$mensaje=str_replace("\n","<br>",$mensaje);
$mensaje=str_replace("\t","    ",$mensaje);

if ($correo_smtp==true){  //comienzo envio smtp

$mail = new PHPMailer();
        $mail->ContentType = 'text/plain'; 
        $mail->IsHTML(false);


$body = $mensaje;
$asunto="Cambio en el centro de votaciones";
if($mail_sendmail==true){
			$mail->IsSendMail();	
			}else{
			$mail->IsSMTP(); 
			}
//$mail->IsSMTP(); 
$mail->Host = $host_smtp;
$mail->SetFrom($email_env, $from);
$mail->Subject = $asunto;

$mail->MsgHTML($body);
/////$mail->AddAddress($correo_notificar, $nombre_ref);
$mail->AddAddress($correo_notificar); ////ver si funciona sin e $nombre_ref

$mail->SMTPAuth = true;

$mail->Username = $user_mail;
$mail->Password = $pass_mail; 

if(!$mail->Send()) {
  echo " Error en el envio " . $mail->ErrorInfo;
} else {
 echo "Enviado correctamente!";


}

}// fin envio por stmp
		
		
		
		
		$inmsg = "<div class=\"alert alert-success\"> Ha sido enviado un correo para notificarle al usuario su cambio de nivel administrativo</div>";
	}
	else{
		$inmsg = "<div class=\"alert alert-success\"> No se ha notificado por correo</div>";
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
                   
                <h1>MODIFICAR NIVELES ACCESO Y ADMINISTRACIÓN</h1>
           <?php echo "$inmsg1";?> <?php echo "$inmsg";?> 
           
            <?php echo " $enlace_asigna"; ?> 
			<!----> 
           <?php 
			  $result=mysqli_query($con,"SELECT ID, nivel_usuario , nivel_acceso,nombre_usuario ,	apellido_usuario, id_provincia, usuario, 	nif , 	correo_usuario  FROM $tbn9 where id=$id");
			  $row=mysqli_fetch_row($result);
			 ?>
           
		  <p><a href="usuarios_busq.php" >volver</a></p>
			<p>&nbsp; </p>
		  <form action="<?php $_SERVER['PHP_SELF'] ?>" method=post name="frmDatos" id="frmDatos"  class="well form-horizontal">
          
          
		    <h3>Va a modificar el perfil de &quot; <?php echo $row[3];?> <?php echo $row[4];?> &quot; con nombre de usuario &quot; <?php echo $row[6];?> &quot;<br />
	        de la provincia <?php echo $row[5];?> y con NIF &quot; <?php echo $row[7];?> &quot;</h3>
            <p>¿quiere enviarle un correo a su direccion <?php echo $row[8];?> 
              <input name="correo_notificar" type="hidden" id="correo_notificar" value="<?php echo $row[8];?>" />
              notificandole los cambios?
<input name="notificar" type="checkbox" id="notificar" value="notificar" />
              <label for="notificar">Notificar por correo</label>
              <input name="notificar_correo" type="hidden" id="notificar_correo" value="<?php echo $row[8];?>" />
              <input name="datos_nombre" type="hidden" id="datos_nombre" value=" <?php echo $row[3];?> <?php echo $row[4];?>" />
              <br />
            </p>
            <p>&nbsp;</p>
            <table width="100%" >
                <tr>
                  <td width="43%" align="center" valign="middle"><p>Tipo</p>
                  <p> El nivel superior tiene permisos tambien sobre los niveles inferiores</p></td>
                  <td width="57%"  >
				  
				  
				  
				  <?php if ($row[1]==1){
					 $chekeado1="checked=\"checked\" ";
					  
				 }else if ($row[1]==2){
					 $chekeado2="checked=\"checked\" ";
					  
				 }else if ($row[1]==3){
					 $chekeado3="checked=\"checked\" ";
					  
				 }else if ($row[1]==4){
					 $chekeado4="checked=\"checked\" ";
					  
				 }else if ($row[1]==5){
					 $chekeado5="checked=\"checked\" ";
					  
				 }else if ($row[1]==6){
					 $chekeado6="checked=\"checked\" ";
					  
				 }else if ($row[1]==7){
					 $chekeado7="checked=\"checked\" ";
					  
				 }
				;?>
                
                <table width="379">
                   
                 <?php 
					  
					 if ($_SESSION['nivel_usu']==2 && $_SESSION['usuario_nivel']==0)
					 
					 {?>   
                    <tr> <td width="371">  <label>
                      <input type="radio" name="tipo_usuario" value="2" id="tipo_usuario_1" <?php echo "$chekeado2"; ?> />
                      Administrador</label> </td></tr>
                     
                   <?php } else if($row[1]==2){ $bloquea=true; ?>
						 <tr>
                      <td>
                        Administrador, no tiene permisos para modificarlo <input name="tipo_usuario" type="hidden" id="tipo_usuario" value="<?php echo $row[1]; ?>" /></td>
                    </tr>
						
				<?php 	}
					else{
						
						}
						
						if ($bloquea==true){
						}else{
						
						?>
                    
                    <tr>
                      <td><input type="radio" name="tipo_usuario" value="3" id="tipo_usuario_2" <?php echo "$chekeado3"; ?> />
                        Admin CCAA</td>
                    </tr>
                    <tr>
                      <td><input type="radio" name="tipo_usuario" value="4" id="tipo_usuario_3" <?php echo "$chekeado4"; ?> /> 
                        Admin provincia
</td>
                    </tr>
                    <tr>
                      <td><input type="radio" name="tipo_usuario" value="6" id="tipo_usuario_5" <?php echo "$chekeado6"; ?> />
Admin grupo trabajo Estatal<span class="error"> *</span></td>
                    </tr>
                    <tr>
                      <td><input type="radio" name="tipo_usuario" value="7" id="tipo_usuario_7" <?php echo "$chekeado7"; ?> />
Admin grupo trabajo CCAA <span class="error"> *</span></td>
                    </tr>
                    <tr>
                      <td><input type="radio" name="tipo_usuario" value="5" id="tipo_usuario_4" <?php echo "$chekeado5"; ?>  />
Admin Asamblea local o grupo de trabajo provincial <span class="error">*</span></td>
                    </tr>
                    <tr>
                      <td class="error">* Nivel de acceso maximo (6)</td>
                  </tr>
                    <tr>
                      <td>
                        <p>
                        <input name="tipo_usuario" type="radio" id="tipo_usuario_0" value="1" <?php echo "$chekeado1"; ?>  />
                     <label> Votante</label></p></td>
                    </tr> <?php }?>
                  </table></td>
                </tr>
                <tr>
                  <td align="center" valign="middle">&nbsp;</td>
                  <td width="57%"  >&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" valign="middle">Nivel de acceso </td>
                  <td width="57%"><?php 
				 
				
switch ($row[2]) {
    case 0:
        $chekea0 = "selected=\"selected\" ";
        break;
    case 1:
         $chekea1 = "selected=\"selected\" ";
        break;
    case 2:
         $chekea2 = "selected=\"selected\" ";
        break;
	case 3:
        $chekea3 = "selected=\"selected\" ";
        break;
    case 4:
         $chekea4 = "selected=\"selected\" ";
        break;
    case 5:
         $chekea5 = "selected=\"selected\" ";
        break;
	case 6:
        $chekea6 = "selected=\"selected\" ";
        break;
    case 7:
         $chekea7 = "selected=\"selected\" ";
        break;
    case 8:
         $chekea8 = "selected=\"selected\" ";
        break;		
	case 9:
         $chekea9 = "selected=\"selected\" ";
        break;	
}
				
				?>
                    <p>
                      <label for="nivel_acceso"></label>
                      <select name="nivel_acceso" id="nivel_acceso" class="buttons">
                      <?php if ($_SESSION['usuario_nivel']!=0 && $row[2]==0){ ?>		 <option value="0" <?php echo "$chekea0"; ?>> No tiene permiso para modificar el nivel de este usuario</option>  
				<?php } else {?>
                      
                        <option value="9" <?php echo "$chekea9"; ?>>9</option>
                        <option value="8" <?php echo "$chekea8"; ?>>8</option>
                        <option value="7" <?php echo "$chekea7"; ?>>7</option>
                        <option value="6" <?php echo "$chekea6"; ?>>6</option>
                        <option value="5" <?php echo "$chekea5"; ?>>5</option>
                        <option value="4" <?php echo "$chekea4"; ?>>4</option>
                        <option value="3" <?php echo "$chekea3"; ?>>3</option>
                        <option value="2" <?php echo "$chekea2"; ?>>2</option>
                     
                     <?php if ($_SESSION['usuario_nivel']!=0){
						 
					 }else{?>
                        <option value="1" <?php echo "$chekea1"; ?>>1</option>
                        <option value="0" <?php echo "$chekea0"; ?>>0</option><?php } }?>
                      </select>
                    Tiene que ser como minimo admin provincia para tener nivel inferior a 5</p>
                  </td>
                </tr>
                <tr>
                  <td align="center" valign="middle">&nbsp;</td>
                  <td><p>7 - Nivel minimo para poder añadir imagenes </p>
                    <p>5 - Permite crear grupos locales</p>
                    <p>2 - Permite crear administradores locales y modificar direccion de notificación de correo</p>
                    <p>1 - Permite modificar censos</p>
                  <p>0 - Todos los permisos, incluido crear administradores generales</p></td>
                </tr>
                <tr> 
                  <td colspan="3" align="center" valign="middle"><br>
                      <br>
                      <br>
                      
         
                       
                       
                      <input name="add_candidato" type=submit  class="btn btn-primary pull-right" id="add_directorio" value="Actualizar">                  
                      
                        <input name="id_provincia" type="hidden" id="id_provincia" value="<?php echo $row[5];?>" />  </td>    </tr>
              </table>
               
</form>
            
            <p><a href="usuarios_busq.php">volver</a></p>
        
      
    
                    
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