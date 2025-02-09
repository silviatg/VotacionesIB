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
include('../inc_web/config.inc.php');
include ('../basicos_php/basico.php');
$id=fn_filtro_numerico($con,$_GET['id']);
  $result=mysqli_query($con,"SELECT ID, id_provincia ,nombre_usuario,apellido_usuario ,nivel_usuario,nivel_acceso,correo_usuario,	nif ,id_ccaa,tipo_votante ,usuario ,fecha_ultima ,bloqueo ,razon_bloqueo, imagen_pequena FROM $tbn9 where id=$id");
  $row=mysqli_fetch_row($result);

 
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Ayuda</title>  
</head>
<body>
  
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" >x</a>
                            <!--    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                               <h4 class="modal-title">Ficha del usuario <?php echo $row[2];?></h4>
                 
            </div>            <!-- /modal-header -->
            <div class="modal-body">

<table width="100%" border="0">
  <tr>
    <td><table width="100%" border="0" class="letra_verde_bold">
      <tr>
        <td width="34%">Nombre y Apellidos: </td>
        <td><?php echo $row[2];?> <?php echo $row[3];?></td>
        <td colspan="2" rowspan="4" align="center"><?php if($row[14]=="peq_usuario.jpg" or $row[14]=="" ){?><img src="../temas/<?php echo "$tema_web"; ?>/imagenes/avatar_sin_imagen.jpg" width="70" height="70" /><?php }else{?><img src="<?php echo $upload_user; ?>/<?php echo"$row[14]";?>" alt="<?php echo"$row[1]";?> <?php echo"$row[4]";?>" width="70" height="70"  /> <?php }?> </td>
        </tr>
      <tr>
        <td>Correp eletronico</td>
        <td><?php echo $row[6];?></td>
        </tr>
      <tr>
        <td>Usuario</td>
        <td><?php echo $row[10];?></td>
        </tr>
      <tr>
        <td>NIF</td>
        <td><?php echo $row[7];?></td>
        </tr>
      <tr>
        <td>ID CCAA :</td>
        <td width="22%"><?php echo $row[8];?></td>
        <td width="23%">Provincia :</td>
        <td width="21%"><?php echo $row[1];?></td>
        </tr>
      <tr>
        <td>Nivel del usuario</td>
        <td><?php echo $row[4];?></td>
        <td>Nivel de acceso </td>
        <td><?php echo $row[5];?></td>
        </tr>
      <tr>
        <td>Tipo Votante</td>
        <td>
          <?php 
		if($row[9]==1){
			echo "Afiliado";
		}elseif($row[9]==2){
			echo "Simpatizante Verifciado";
		}elseif($row[9]==3){
			echo "Simpatizante";
		};?>
          </td>
        <td>Ultimo acceso</td>
        <td rowspan="2"><?php echo $row[11];?></td>
        </tr>
      <tr>
        <td>Bloqueado</td>
        <td><?php echo $row[12];?></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4">Razon bloqueo :<?php echo $row[13];?></td>
        </tr>
      </table>
      </td>
  </tr>
</table>
              
    <!--
===========================  fin texto ayuda
-->             </div>            <!-- /modal-body -->
                       <!-- /modal-footer -->
        </div>         <!-- /modal-content -->
    
</body>
</html>