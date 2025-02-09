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
require_once("../inc_web/config.inc.php");
include('seguri_inter.php'); ?>



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
 
 <div class="container">
 
    <!-- cabecera
    ================================================== -->
      <div class="page-header">
      <img src="../temas/<?php echo "$tema_web"; ?>/imagenes/cabecera_votaciones.jpg" class="img-responsive" alt="Logo <?php echo "$nombre_web"; ?>">
	  </div>
      
    <!-- END cabecera
    ================================================== -->
     

       <div class="row">
        

        
        
        <div class="col-md-2" >             
          
            <a href="log_out.php">SALIR</a> <br/>
            <a href="vut.php?idvot=<?php echo $idvot; ?>">Incluir otro</a><br/>
          <a href="datos_incluidos_vut.php?idvot=<?php echo $idvot; ?>">Ver los datos incluidos manualmente</a><br/>
      		 
            
            
        </div>
       
        
        
        <div class="col-md-10">
     
                   <!--Comiezo-->
                   <?php 
				   
				  // $sql = "SELECT a.ID, a.nombre_usuario ,  b.fecha, b.forma_votacion, a.tipo_votante FROM $tbn9 a,  $tbn2 b where (a.id=b.id_votante) and a.id_provincia = '$id_provincia' and a.tipo_votante <='$tipo_votante' and b.id_votacion=$idvot ";
				    
					$tipo_voto="presencial";
					 $sql = "SELECT a.ID, a.nombre_usuario ,  b.fecha, b.forma_votacion, a.tipo_votante FROM $tbn9 a,  $tbn2 b where (a.id=b.id_votante) and b.id_votacion=$idvot and forma_votacion='$tipo_voto' ";
				 	 $result = mysqli_query($con, $sql);
					 ?>
                
     <table width="100%"  cellspacing="0" id="tabla1" >
				<thead>
					<tr>
                        <th width="5%">nº</th>
						<th width="75%">NOMBRE</th>
                        <th width="10%">FECHA</th>
						<th width="10%">TIPO</th>
						
                     
					</tr>
				</thead>

				<tbody>
        <?php

mysqli_field_seek($result,0);
do {
 ?>
        <tr>
          <td><?php echo  $u++; ?></td>
          <td><?php echo  "$row[1]"; ?></td>
          <td><?php echo  "$row[2]" ?></td>
          <td><?php if($row[4]==1){
			  echo"socios";
		  }
		  else if($row[3]==2){
			  echo"simpatizante verificado";
		  }else if($row[3]==3){
			  echo"simpatizante";
		  }
		  else if($row[3]==5){
			  echo "Aqui hay un error";
		  }
		  
		  ?></td>
                  </tr>
        <?php
}
while ($row = mysqli_fetch_array($result));



?>

      </tbody>
</table>
                    
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
  
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
<script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
  
  </body>
</html>