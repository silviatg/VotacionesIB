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
		 function fn_donde_estoy($donde){
		 $miUrl= $_SERVER['REQUEST_URI'];
		 $url=explode("?",$miUrl);
		 $url1=explode("/",$url[0]);
		 $len=count($url1);
		 $laUrel= $url1[$len-1];

			 if ($laUrel==$donde){
			 return "class=\"active\" "; 
			 }
		 }
		 
		 ?>   
            
            
<!--class="glyphicon glyphicon-user"-->

<div class="sidebar-nav">
              <div class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <span class="visible-xs navbar-brand">Menu</span>
                </div>
                
                <div class="navbar-collapse collapse sidebar-navbar-collapse">
                  <ul class="nav navbar-nav">
                  <li>  <?php  include("../votacion/caja_usuario.php"); ?> </li>
                    <li <?php echo fn_donde_estoy("inicio.php"); ?> ><a href="../votacion/inicio.php" class="list-group-item ">Lista de votaciones</a></li>
					<?php if ($mostrar_todas_opciones=="S") { ?>
						<li <?php echo fn_donde_estoy("buscar_votaciones.php"); ?>><a href="../votacion/buscar_votaciones.php" class="list-group-item ">Buscar votaciones</a></li>			
						<li <?php echo fn_donde_estoy("mis_grupos.php"); ?>><a href="../votacion/mis_grupos.php" class="list-group-item">Mis grupos de trabajo </a></li>
						<li <?php echo fn_donde_estoy("grupos_tabla.php"); ?>><a href="../votacion/grupos_tabla.php" class="list-group-item">Grupos de trabajo</a></li>
					<?php } ?>
                    <li><a data-toggle="modal" href="../votacion/ayuda_user.php" data-target="#ayuda" class="list-group-item">Ayuda</a></li>
                    <li><a data-toggle="modal"  href="../votacion/notificar.php" data-target="#ayuda_contacta"  class="list-group-item">Notificar un problema</a></li>
         		    <li <?php echo fn_donde_estoy("user.php"); ?>><a href="../votacion/user.php" class="list-group-item "> Modificar datos personales</a></li>
          		    <li><a href="../log_out.php" class="list-group-item">Desconexión</a></li>
                  
                  </ul>
                </div><!--/.nav-collapse -->
              </div>
            </div>