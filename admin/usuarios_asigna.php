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

$nivel_acceso=6; 
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
include ('../basicos_php/basico.php');

$id=fn_filtro_numerico($con,$_GET['id']);
  $result=mysqli_query($con,"SELECT ID, id_provincia, nombre_usuario, id_ccaa,nivel_usuario FROM $tbn9 where id=$id");
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
                               <h4 class="modal-title">Usuario <?php echo $row[2];?></h4>
                 
            </div>            <!-- /modal-header -->
            <div class="modal-body">

	<div class="alert alert-info">	El Usuario es 
    <?php   if($row[4]=="3"){
			  echo " Administrador CCAA"; 
			  } else if($row[4]=="4"){
			  echo " Administrador provincial"; 
		    }else if($row[4]=="6"){
			  echo " Administrador de Grupos estatales"; 
		    }else if($row[4]=="5"){
			  echo " Administrador de grupos provinciales"; 
			  }else if($row[4]=="7"){
			  echo " Administrador de grupos autonomicos"; 
			 
		  }
		  
		   ?> </div>
           
    <div id="success2"></div>
      		
  <?php 
  if($row[4]=="4" or $row[4]=="5" ){
  $options = "select DISTINCT id, provincia from $tbn8 where especial=0 and id_ccaa=$row[3] order by ID";
	$resulta = mysqli_query($con, $options) or die("error: ".mysqli_error($con));
  $quantos=mysqli_num_rows($resulta);
  
	if ($quantos!=1){
  ?>          
            
			<h3>Asignar o Actualizar provincias al usuario </h3><h3><?php echo $row[2];?></h3>
			
			<!---->

            <form action="" method="post" name="myForm" id="myForm">
              <?php 
	
	while( $listrows = mysqli_fetch_array($resulta) ){ 
	$id_pro = $listrows[id];
	$name1= utf8_encode($listrows[provincia]);
	
	$options_usu = "select  ID from $tbn5 where id_provincia=$id_pro and id_usuario=$id order by ID";
	$result_cont=mysqli_query($con,$options_usu);
    $quants=mysqli_num_rows($result_cont);
	if ($quants!=""){
		$chequed="checked=\"checked\"";
	}
	else{
		$chequed="";
	}
	
	$lista1 .="    <label><input type=\"checkbox\" name=\"myCheckboxes[]\" value=\"$id_pro\" id=\"myCheckboxes\" $chequed /> $name1</label> <br/>";
	
}
							 ?>
                    
     			<?php echo "$lista1";?>
     
                    
                    
                  
                    <input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
                    <input name="tipo" type="hidden" id="tipo" value="provincias">
                    <br>
              <input name="add_candidato" type=submit class="btn btn-primary pull-right" id="add_directorio" value="Asigna provincias" onclick="submitForm()">                  </td>
               
               
		</form>  <p>&nbsp;</p>
          <?php 
				}
				}
		  
		  ////////////// fin del listado de provincias
		  ?> 
		  <!---->		  
	 <p>&nbsp;</p>
      
      <h3>Asignar o actualizar grupos de trabajo al usuario </h3><h3><?php echo $row[2];?></h3>
			
			<!---->
			
           
           
                 <?php 
				  
			
if($row[4]=="6"){
	//3 es el tyipo estatal
	$options_sub = "select DISTINCT id, subgrupo from $tbn4 where  tipo=3 order by ID";

}
else if($row[4]=="7"){
	
	//grupo de trabajo autonomicos y provincial
	$options_sub = "select DISTINCT id, subgrupo, id_provincia,id_ccaa,tipo from $tbn4 where  id_ccaa=$row[3] order by ID";
	
	
  }
else{
	
	//tipo 1 son los provinciales 
	$options_sub = "select DISTINCT id, subgrupo, id_provincia,tipo from $tbn4 where  id_ccaa=$row[3] and tipo=1 order by ID";
	
}
	$resulta_sub = mysqli_query($con, $options_sub) or die("error: ".mysqli_error($con));
	$quantos_gr=mysqli_num_rows($resulta_sub);
	
	while( $listrows_sub = mysqli_fetch_array($resulta_sub) ){ 
	$id_sub = $listrows_sub[id];
	$name_sub= utf8_encode($listrows_sub[subgrupo]);
	$id_prov = $listrows_sub[id_provincia];
	$id_ccaa = $listrows_sub[id_ccaa];
	
	$tipo = $listrows_sub[tipo];
	if($tipo==2){
		$tipos="Autonomico";
		// $optiones=mysqli_query("SELECT  ccaa FROM $tbn3 where ID=$id_ccaa",$con);
    // $row_prov=mysqli_fetch_row($optiones);
		
	}else if($tipo==1){
		$tipos="Provincia de ";
		
	$optiones=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$id_prov");
     $row_prov=mysqli_fetch_row($optiones);
	}
	
	
	$options_usu = "select  ID from $tbn6 where  id_grupo_trabajo=$id_sub and id_usuario=$id order by ID";
	$result_cont=mysqli_query($con,$options_usu);
    $quants=mysqli_num_rows($result_cont);
	if ($quants!=""){
		$chequed="checked=\"checked\"";
	}
	else{
		$chequed="";
	}
	
	 
	$lista_sub .="    <label><input type=\"checkbox\" name=\"myCheckboxes[]\" value=\"$id_sub\" id=\"myCheckboxes\" $chequed /> $name_sub - $tipos ". utf8_encode($row_prov[0])."</label> <br/>";
	
}
  ?>
      <?php 
	  if($quantos_gr!=""){
	  
	  ?>     
  <form action="" method="post" name="myForm" id="myForm">
        
                 
     <?php echo "$lista_sub";?>
     
                 
     <input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
     <input name="tipo" type="hidden" id="tipo" value="grupos">
     <input name="add_sub" type=submit  id="add_directorio" class="btn btn-primary pull-right" value="Asigna GRUPO DE TRABAJO O ASAMBLEA" onclick="submitForm()"/>                  </td>
             
              
        </form> 
  <p>&nbsp;</p>

    <?php }
		   else{
			echo "No hay grupos de trabajo o asambleas";   
			   
		   }?>
    <!---->	
    
  
  <div id="loading_usuarios_asigna"><img src="../temas/<?php echo "$tema_web"; ?>/imagenes/cargando.gif" /></div>
        
      </div>		
        
</div>
<script src="../js/jquery-1.9.0.min.js"></script>
    <script src="../js/jqBootstrapValidation.js"></script>
   <script type="text/javascript">
	function submitForm() {
		$(document).ready(function() {
		$("form#myForm").submit(function() {
		var tipo = $("#tipo").val();
		var id = $("#id").val();
        var myCheckboxes = new Array();
        $("input:checked").each(function() {
           myCheckboxes.push($(this).val());
        });
		
		//Si empieza el ajax muestro el loading
		  $("#loading_usuarios_asigna").ajaxStart(function(){
			 $("#loading_usuarios_asigna").show();
		  });
		  
		  //Cuando termina el ajax oculta el loading
		  $("#loading_usuarios_asigna").ajaxStop(function(){
			 $("#loading_usuarios_asigna").hide();
		  });
		
        $.ajax({
            type: "POST",
            url: "usuarios_asigna_procesa.php",
            dataType: 'html',
            data: { id:$("#id").val(),
					tipo:$("#tipo").val(),
                    myCheckboxes:myCheckboxes },
            error: function() {		
 				// Fail message
 		 			$('#success2').html("<div class='alert alert-danger'>");
            		$('#success2 > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            	      .append( "</button>");
            		$('#success2 > .alert-danger').append("<strong>Sorry "+ data +" uppps! el servidor no esta respondiendo...</strong> Intetelo despues. Perdone por las molestias!");
 	       		    $('#success2 > .alert-danger').append('</div>');
 		//clear all fields
 					$('#contactForm').trigger("reset");
 	   			 },
			success: function(data){
                
				$('#success2').html(" " + data +" ");
            }
        });
        return false;
});
});
  };
</script>
    
 <!--
===========================  fin texto ayuda
-->             </div>            <!-- /modal-body -->
                       <!-- /modal-footer -->
        </div>         <!-- /modal-content -->
    
</body>
</html>
