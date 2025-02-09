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
$correcto =""; 
 
if(empty($_GET['idgr'])){
		echo "Por favor no altere el fuente";
		exit;
	}
	$idgr=fn_filtro_numerico($con,$_GET['idgr']);
	$options_usu = "select  ID from $tbn6 where  id_grupo_trabajo=".$idgr." and id_usuario=".$_SESSION['ID']." ";
	$result_cont=mysqli_query($con,$options_usu);
	 
    $quants=mysqli_num_rows($result_cont);
	if ($quants!=""){
		 ?>
		     
                <div class="modal-content">
                        <div class="modal-header">
                        <a class="close" data-dismiss="modal" >x</a>
                            <!--    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                               <h4 class="modal-title"></h4>
                        </div>
                        
              <div class="modal-body">

   

		  <div class="alert alert-success">
    <strong>Ya te has apuntado a este grupo, <br/> en breve podras participar
	</div>

        
                
			</div>  
         </div>
    
		 
		 
		 <?php
	}else{
	
		$options_sub = sprintf("select ID, subgrupo,acceso 	 from $tbn4 where ID=%d",
			(int)$idgr);
  
	$per = mysqli_query($con,$options_sub);
	$num_rs_per = mysqli_num_rows($per);
			if ($num_rs_per==0){
				echo "No existen grupos con ese Identificador";
				exit;
			}
	$rs_per = mysqli_fetch_assoc($per);	
 ?>
 
     
                <div class="modal-content">
                        <div class="modal-header">
                        <a class="close" data-dismiss="modal" >x</a>
                            <!--    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                               <h4 class="modal-title">¿Estas seguro que quieres apuntarte este grupo de trabajo?</h4>
                        </div>
                        
              <div class="modal-body">

     

       
  <form action="javascript: fn_modificar();" method="post" id="frm_per" class="well">
	<input type="hidden" id="IDgr" name="IDgr" value="<?=$rs_per['ID']?>" />               
	<input type="hidden" id="ID_acceso" name="ID_acceso" value="<?=$rs_per['acceso']?>" />
				  
                  
                  <h2> <?php //echo "$name_sub";?> </h2>
                  <h3> <?php echo $rs_per['subgrupo']?></h3>
                    
                   
                    <div id="el_boton">
                      <input name="add_sub" type=submit class="btn btn-primary pull-right" id="add_directorio" value="Apuntarme a <?php echo $rs_per['subgrupo']?>">                  
                  </td>
   		</div>
        <br>
        </form>
      
		  <!---->

		  <div id="success2"> </div>

        
                
			</div>  
         </div>
     

        
		<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$("#frm_per").validate({
			submitHandler: function(form) {
				<!--var respuesta = confirm('\xBFDesea realmente apuntarte a este grupo?')-->
				<!--if (respuesta)-->
					form.submit();
			}
		});
	});
	
	function fn_modificar(){
		var str = $("#frm_per").serialize();
		$.ajax({
			url: 'grupos_modificar.php',
			data: str,
			type: 'post',
			success: function(data){
				//$('#el_boton').hide;
				//$("#el_boton").hide();
				//$("#submit").hide();
				$('#success2').html(" " + data +" ");
				//if(data != "")
				//alert(data);
				//fn_cerrar();
				//fn_buscar();
				$("#el_boton").hide();
				//$("h4").hide();
			},
			error: function() {		
 				// Fail message
 		 			$('#success2').html("<div class='alert alert-danger'>");
            		$('#success2 > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            	      .append( "</button>");
            		$('#success2 > .alert-danger').append("<strong>Sorry "+firstName+" uppps! el servidor no esta respondiendo...</strong> Intetelo despues. Perdone por las molestias!");
 	       		    $('#success2 > .alert-danger').append('</div>');
 		
 	   			 },
			
			
		});
	};
	
//	function fn_buscar(){
//	var str = $("#frm_buscar").serialize();
//	$.ajax({
//		url: 'grupos_listar.php',
//		type: 'get',
//		data: str,
//		success: function(data){
//			$("#div_listar").html(data);
//		}
//	});
//}



		//function fn_cerrar(){
//			$.unblockUI({ 
//			onUnblock: function(){
//			$("#div_oculto").html("");
//			}
//			}); 
//		};

</script>

<!--
   <script language="javascript" type="text/javascript" src="../js/tabla.js"></script>
 -->
<?php }?>