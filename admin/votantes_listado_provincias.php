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
$sql = "select DISTINCT id, provincia from $tbn8   where especial =0 order by ID ";
$result = mysqli_query($con, $sql);
if ($row = mysqli_fetch_array($result)){
?>
        
 <li class="divider"></li>
 <li>Provincias
      <ul class="nav navbar-nav">
        <?php

mysqli_field_seek($result,0);

do {

 ?>
 <li>
  <a href="votantes_listado_multi.php?idvot=<?php echo  "$idvot" ?>&id_nprov=<?php echo  $row[id]; ?>&cen=<?php echo $_GET['cen']; ?>&lit=<?php echo $_GET['lit']; ?>" > <?php echo utf8_encode($row[provincia]);?> </a>
 
 </li>
 
 
        
        <?php
}
while ($row = mysqli_fetch_array($result));

?></ul>
    </li>
      <?php 
} else {

echo " ¡No se ha encontrado nada! ";


}


?>
