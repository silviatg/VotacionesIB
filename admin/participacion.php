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
$nivel_acceso=6; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
$idvot=$_GET['idvot'];
$result_vot=mysqli_query($con,"SELECT id_provincia,nombre_votacion,id_ccaa,id_grupo_trabajo,demarcacion  FROM $tbn1 where id=$idvot");
  $row_vot=mysqli_fetch_row($result_vot);

$id_provincia=$row_vot[0]; 

$nombre_votacion=$row_vot[1];

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
        <?php if($_SESSION['usuario_nivel']==0){?>      
          <h1>Participación de la votación <?php echo $nombre_votacion; ?></h1>
          
         
            <?php 
	
		$sql = "SELECT ID FROM $tbn2  WHERE id_votacion = '$idvot' ";  
		$result = mysqli_query($con,$sql);
		$numero = mysqli_num_rows($result); // obtenemos el número de filas
		
		if ($row = mysqli_fetch_array($result)){

		?>
           <p>  Numero de votantes <?php echo  "$numero" ?> </p> <br/ >
            <?php 
        }
         ?>  
            <?php /* esto si quisieramos saber cuantos votos hay de cada tipo de votante
		*/
		$sql = "SELECT tipo_votante, COUNT(tipo_votante) FROM $tbn2  WHERE id_votacion = '$idvot' GROUP BY tipo_votante   ";
		$result = mysqli_query($con, $sql);

?>
            
            
            <?php 
if ($row = mysqli_fetch_array($result)){
 ?>
          <p>Han votado </p>
          <table width=51% align="center" class="tabla_vut">
            <?php
mysqli_field_seek($result,0);

do {

 ?>
            
            
            <tr>    <td width=80%>
             
            <?php 

if($row[0]==1){ echo "Afiliados";
}elseif($row[0]==2){ echo "Simpatizantes verificados";
}elseif($row[0]==3){ echo "Simpatizantes";
}

?> </td><td width=20%> <?php echo $row[1];?>
   </td>     </tr>    
  <?php

}
while ($row = mysqli_fetch_array($result));


?>
 </table>         
            
          <p>
          <?php 
} else {


}


?>
            
        votación por provincias
        
        
           <?php /* esto si quisieramos saber cuantos votos hay de cada tipo de votante
		*/
		$sql = "SELECT a.tipo_votante, COUNT(a.tipo_votante),a.id_provincia,b.provincia FROM $tbn2 a, $tbn8 b WHERE (a.id_provincia=b.ID) and a.id_votacion = '$idvot' GROUP BY a.id_provincia,a.tipo_votante  ";
		$result = mysqli_query($con, $sql);

?>
            
            
            <?php 
if ($row = mysqli_fetch_array($result)){
 ?>
          </p>
          <p>Han votado </p>
          <table width=61% align="center" class="tabla_vut">
            <?php
mysqli_field_seek($result,0);

do {

 ?>
            
            
            <tr>    <td width=45%><?php echo utf8_encode($row[3]);?></td><td width=34%><?php 

if($row[0]==1){ echo "Afiliados";
}elseif($row[0]==2){ echo "Simpatizantes verificados";
}elseif($row[0]==3){ echo "Simpatizantes <br/><br/>";
}

?></td>
            <td width=21% align="right"><?php echo $row[1];?></td>
            </tr>    
  <?php

}
while ($row = mysqli_fetch_array($result));


?>
 </table>         
            
          <?php 
} else {


}


?>    
            
         
          <p>&nbsp;</p>
          <?php }?>           
                
    
                    
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