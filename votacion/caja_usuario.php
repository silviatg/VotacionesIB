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
?><div id="usuario"> 
  <div class="imagen_avatar">
  <?php if($_SESSION['imagen']=="peq_usuario.jpg" or $_SESSION['imagen']=="" ){?><img src="../temas/<?php echo "$tema_web"; ?>/imagenes/avatar_sin_imagen.jpg" width="60" height="60" /><?php }else{?><img src="<?php echo $upload_user; ?>/<?php echo $_SESSION['imagen'];?>" alt="<?php echo"$row[1]";?> <?php echo"$row[4]";?>" width="60" height="60"  /> <?php }?>
  </div>
  
  <span class="letra_c_user">Usuario:</span> <span class="letra2_c_user"><?php echo $_SESSION['nombre_usu']; ?></span>
    <br /><span class="letra_c_user">Provincia:</span> <span class="letra2_c_user"><?php echo $_SESSION['provincia']; ?></span>
    <br /> 
	
	<span class="letra_c_user">CCAA: </span><span class="letra2_c_user"><?php echo $_SESSION['ccaa']; ?></span>
    <br/>
    <?php 
	if($_SESSION['id_municipio'] !=0){ ?>
		<span class="letra_c_user">Municipio: </span><span class="letra2_c_user"><?php echo $_SESSION['municipio']; ?></span> <br/> 
		<?php
	}
		
	?>
	 <span class="letra_c_user_red"> 
  <?php 
	
	if($_SESSION['tipo_votante']==1){
		echo " Afiliado";
		}
		elseif ($_SESSION['tipo_votante']==2){
			echo "Simpatizante Verificado"; //STG+: Sólo contemplaba el caso 2 y ponía simpatizante.
		}
		//STG+: Añadimos este caso, para los simpatizantes no validados aún.
		elseif ($_SESSION['tipo_votante']==3){
			echo "Pendiente de Verificación.";
		}
	
	 ?>
      <?php 

	if($_SESSION['nivel_usu']==2){
		echo" <br />Administrador General";
		}
		
		elseif($_SESSION['nivel_usu']==3){
		echo" <br />
Administrador CCAA";
		}
		
		elseif($_SESSION['nivel_usu']==4){
		echo" <br />Administrador provincia
";
		}
		
		elseif($_SESSION['nivel_usu']==5){
		echo" <br />Administrador Grupo  provincial";
		}
		
		elseif($_SESSION['nivel_usu']==6){
		echo" <br />Administrador Grupo Estatal";
		}
		elseif($_SESSION['nivel_usu']==7){
		echo" <br />Administrador Grupo CCAA";
		}
		
	 ?>
     </span>
     
    <br />
  </div>