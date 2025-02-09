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
?>
<div id="control_seg">
<?php // sistema para incluir internventores o clave voto seguro


if($seguridad==2 or $seguridad==4){?>
 
	<div class="alert alert-danger">
		<strong><i>GARANTÍAS DE LA VOTACIÓN:</i></strong><br/><br/>
		- <b>CONTROL DE ACCESO</b>: Se han habilitado los sistemas de control adecuados y proporcionados para garantizar que 
		  los y las electores emitan un único voto, mediante comprobación de email y DNI. 
		  Por tanto, tiene usted la garantía de que otra persona no podrá realizar una votación usando sus datos personales.
		<br/></br>
		- <b>SEGURIDAD DE LA VOTACIÓN</b>: El sistema le permitirá la comprobación de su votación en todo momento, 
		para que tenga la seguridad de que nadie puede modificar su voto.
		<br/></br>
		- <b>CONFIDENCIALIDAD DEL VOTO</b>: Sólo usted podrá saber lo que ha votado.
		El voto se guardará encriptado en nuestra base de datos, usando una clave de seguridad que sólo usted conoce.
		Esta clave no será almacenada en el sistema, lo que hace imposible que nadie pueda saber qué ha votado,
		ni siquiera los administradores de la base de datos.		
		<br/><br/>
		Por favor, <strong>memorice bien su clave de votación</strong> para que le sea posible comprobar su voto posteriormente.<br/><br/>

		<div class="form-group">       
			<label for="clave_seg" class="col-sm-3 control-label"><b>Invéntese y memorice su Clave de seguridad</b>:</label>
			<div class="col-sm-3">
				<input type="password" name="clave_seg" id="clave_seg" value="" placeholder="Introduzca su clave" autofocus required class="form-control"/>
			</div>
		</div>
		<br/><br/><i>*Tenga en cuenta que esta clave sólo sirve para comprobar su voto, y no es la misma que la clave utilizada para entrar en esta web.</i>
		<p>&nbsp;</p>
		
	</div>
   

<?php }else{ ?>
    <input name="clave_seg" type="hidden" id="clave_seg" value="non_use" /> 
<?php } ?> 


<?php 
if($seguridad==4 or $seguridad==3){?>
   
   <?php 
   //STG: Buscamos interventores de tipo "correo-0 o especial-1" (CREO QUE los de tipo 2, correo+especial, no reciben papeleta, son para insertar votos presenciale)
   $sql = "SELECT nombre, apellidos FROM $tbn11 WHERE id_votacion = '$idvot'  and tipo<=1  ORDER BY 'nombre'";
   $result = mysqli_query($con, $sql);
   if ($row = mysqli_fetch_array($result)){
   ?>
	<div class="alert alert-success">  
		Esta votación tiene interventores que recibiran su papeleta de voto de forma anónima y son:
   
     <ul>   
	 <?php
      mysqli_field_seek($result,0);
      do {
      ?>
        <li> <?php echo  "$row[0]" ?> <?php echo  "$row[1]" ?></li>
          
        <?php
		}
		while ($row = mysqli_fetch_array($result));
		?>
      </ul></div>
	</div>
   <?php
	}
}
?>
