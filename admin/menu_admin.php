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
 if($_SESSION['nivel_usu']!="1"){	 ?>

<div class="navbar-wrapper">
      <div class="container">

        <div class="navbar navbar-inverse navbar-static-top" role="navigation">
          <div class="container">
          
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#"><?php echo "$nombre_web"; ?></a>
            </div>
            
            
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">

<?php if($_SESSION['usuario_nivel']=="0") { //STG: Quitamos esta funcionalidad a otros administradores, de momento. ?>	              
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Votaciones <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="../admin/votacion.php">Crear votacion</a></li>
                    <li><a href="../admin/gestion_zonas.php">Gestion / modificación de votaciones</a></li>
                    
                    <?php if ($_SESSION['nivel_usu']==2){?>
                    <li><a href="../admin/candidatos_buscador.php">Buscador candidatos / opciones</a></li>
                    <?php }?>
				   <li><a href="../admin/gestion_zonas_resultados.php">Resultados /censos por votacion <br/> Voto presencial</a></li>                   
                  </ul>
                </li>
                <!---->
<?php } ?>	

                <!---->
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mis votaciones<b class="caret"></b></a>
                  <ul class="dropdown-menu">
<?php if($_SESSION['usuario_nivel']=="0") { //STG: Quitamos esta funcionalidad a otros administradores, de momento. ?>							  
                    <li><a href="../admin/gestion_votaciones_mis.php">Gestion / modificación de votaciones</a></li>
<?php } ?>			
					<?php if($_SESSION['usuario_nivel']<="2"){ ?>
                    <li><a href="../admin/votantes_list_votaciones_mis.php">RESULTADOS censos por votación <br/> Voto presencial</a></li>
                    <?php }?>
                  </ul>
                </li>
                
                 <!---->
                <?php if($_SESSION['usuario_nivel']<="2"){ ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Censos<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="../admin/censos_buscador.php">Buscar / modificar votantes</a></li>
                    <li><a href="../admin/censos.php">Incluir un votante</a></li>
<?php if ($_SESSION['usuario_nivel']=="0") { //STG: Quitamos esta funcionalidad a otros administradores hasta que introduzcamos los cambios para Imagina. ?>					
                    <li><a href="../admin/censos_add_mas.php">Añadir votantes de foma masiva</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Bajas -modificaciones</li>
                    <li><a href="../admin/bloquear_censos_buscador.php">Bloquear / desbloquear votantes</a></li>
                    <?php if($_SESSION['usuario_nivel']<="1"){ ?>
					<li><a href="../admin/censos_out_mas.php">Bajas de votantes de foma masiva</a></li><?php }?>
                    <?php if($_SESSION['usuario_nivel']<="1"){ ?>
					<li><a href="../accesorios/censos_out_mas.php">Actualizar municipios de foma masiva</a></li><?php }?>
                    <?php if($_SESSION['usuario_nivel']<="1"){ ?>
					<li><a href="../accesorios/cambiar_poblaciones.php">Buscar municipios de foma masiva</a></li><?php }?>
<?php } ?>				
                   
                   </ul>
               	</li>
              	   <?php }?>
                
                <!---->
 
<?php if($_SESSION['usuario_nivel']=="0") { //STG: Quitamos esta funcionalidad a otros administradores, de momento. ?>	
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  
             <?php 
			$sql_cont = "SELECT a.ID  FROM $tbn9 a,$tbn6 b where (a.ID= b.id_usuario) and b.estado = 0 ";
			  $result_cont=mysqli_query($con,$sql_cont);
			
			$quants_cont=mysqli_num_rows($result_cont);
			if($quants_cont==0){
				
			}else{ ?>
				<span class="badge"> <?php echo "$quants_cont";  ?></span> 
		<?php  }
		  ?> Asambleas 
                  
               <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <?php if($_SESSION['usuario_nivel']<="2"){ ?>
					<li><a href="../admin/asambleas.php" class="menu">Crear asambleas</a>
</li><?php }?>
 					<?php if($_SESSION['usuario_nivel']<="6"){ ?>
					<li><a href="../admin/asambleas_list.php" class="menu">Modificar Asambleas</a></li><?php }?>
					<li><a href="../admin/mis_grupos_list.php " class="menu">Gestionar usuarios <span class="badge"> <?php echo "$quants_cont";  ?></spam></a> </li>
                 
				
                  </ul>
                </li>
<?php } //FIN ASAMBLEAS ?>	              
                
                
                
               
<?php if($_SESSION['usuario_nivel']=="0") { //STG: Quitamos esta funcionalidad a otros administradores, de momento. ?>	
                 <!---->
                 
                 <?php if($_SESSION['usuario_nivel']<="2"){ ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Gestion administracion<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="../admin/usuarios.php">Gestion usuarios administracion</a></li>
					<li><a href="../admin/usuarios_gestion_mis.php" >Votaciones por usuario</a></li>
                    <li class="divider"></li>
                    <li><a href="../admin/gestion_provincias.php"  >Gestion notificaciones provincias</a></li>
                   <!-- <li><a href="../admin/paginas_list.php"  >Gestion  paginas</a></li>-->
                   <?php if($_SESSION['usuario_nivel']=="0"){ ?>
                    <li><a href="../admin/constantes.php"  >Datos de la configuración por defectos de la web</a></li>
                 <?php }?>
                  </ul>
                </li>    
                <?php }?>
<?php } //FIN DE OPCIÓN DE MENU ?>	


                <li> <a data-toggle="modal"  href="../admin/ayuda_admin.php" data-target="#ayuda_admin">Ayuda</a></li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
    
    <?php }?>