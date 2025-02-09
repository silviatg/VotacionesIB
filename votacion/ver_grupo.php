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
require ("../inc_web/verifica.php");

$nivel_acceso=11; 
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
include ('../basicos_php/basico.php');
			
if(empty($_GET['idgr'])){
		echo "Por favor no altere el fuente";
		exit;
	}			



$idgr=fn_filtro_numerico($con,$_GET['idgr']);

$sql = "SELECT a.ID,  a.nombre_usuario,  a.correo_usuario,  a.tipo_votante, a.usuario,a.apellido_usuario, a.imagen_pequena, a.perfil FROM $tbn9 a,$tbn6 b where (a.ID= b.id_usuario) and b.id_grupo_trabajo=".$idgr." and  b.estado = 1   order by a.nombre_usuario ";

$result = mysqli_query($con,$sql);

?>
 <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]—>
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="../modulos/DataTables-1.10.3/media/css/jquery.dataTables.css" rel="stylesheet">
    <link href="../temas/<?php echo "$tema_web"; ?>/estilo.css" rel="stylesheet">
    
    <div class="modal-content">
<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Miembros de este grupo</h4>
      </div>

<div class="modal-body">

          
	<?php

if ($row = mysqli_fetch_array($result)){

 ?>
      
     <table id="tabla1" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
                   		<th width="1%">&nbsp;</th>
						<th width="20%">Nombre</th>
                        <th width="20%">Nick</th>
						<th width="58%">&nbsp;</th>
						<th width="1%">&nbsp;</th>
						
					</tr>
				</thead>

				<tbody>
        <?php

mysqli_field_seek($result,0);

do {

 ?>
        <tr>
          <td rowspan="2"><?php if($row[6]=="peq_usuario.jpg" or $row[6]=="" ){?><img src="../temas/<?php echo "$tema_web"; ?>/imagenes/avatar_sin_imagen.jpg" width="70" height="70" /><?php }else{?><img src="<?php echo $upload_user; ?>/<?php echo"$row[6]";?>" alt="<?php echo"$row[1]";?> <?php echo"$row[4]";?>" width="70" height="70"  /> <?php }?></td>
          <td><?php echo  "$row[1]" ?> <?php echo  "$row[5]" ?></td>
          <td><?php echo  "$row[4]" ?></td>
          <td><?php echo  "$row[7]" ?> </td>
          <td><?php if($row[3]==1){
			  echo "Afiliado";
		  }else if ($row[3]==2){
			  echo "Simpatizante V";
		  }else if ($row[3]==3){
			  echo "Simpatizante ";
		  }?></td>
        </tr>
       
        <?php
}
while ($row = mysqli_fetch_array($result));


?>

  
        </tbody>
      </table>
		 
    <?php 
} else {

echo " ¡No se ha encontrado ningún votante! ";


}


?><!---->	


       
      </div>
      <div class="modal-footer"></div>
    </div><!-- /.modal-content -->
	
	<script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
    <script src="../modulos/DataTables-1.10.3/media/js/jquery.dataTables.min.js"></script>
  	<script type="text/javascript" language="javascript" class="init">
	
	$(document).ready(function() {
    $('#tabla1').dataTable( {
        "language": {
            "lengthMenu": "Ver _MENU_  resultados por pagina",
            "zeroRecords": "No se han encontrado resultados - perdone",
            "info": "Mostrando _PAGE_ de _PAGES_ paginas",
            "infoEmpty": "No se han encitrado resultados",
            "infoFiltered": "(filtered from _MAX_ total records)",
			"loadingRecords": "Cargando...",
    		 "processing":     "Procesando...",
   			 "search":         "Buscar:",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
			"aria": {
				"sortAscending":  ": activate to sort column ascending",
				"sortDescending": ": activate to sort column descending"
			}
       	 }
   	  } );
	} );
	</script>
    <script type="text/javascript">
			<!-- limpiamos la carga de modal para que no vuelva a cargar lo mismo -->
			$('#apuntarme').on('hidden.bs.modal', function () {
			  $(this).removeData('bs.modal');
			});
   </script>