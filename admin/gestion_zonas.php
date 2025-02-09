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
$nivel_acceso=11; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
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
<h2>Buscar VOTACIONES para GESTIONAR o MODIFICAR</h2>

     <?php if ($_SESSION['nivel_usu']==2){?>
      
   <div  class="well">     
       
 <h4> <a href="gestion_votaciones.php">Todas las Votaciones Estatales</a></h4>
    
    </div>
    
   
    
    <form id="formulario1" name="formulario1" method="post" action="gestion_votaciones.php"  class="well">   
    
    <h4> Buscar Votaciones por CCAA</h4>   
       
     <?php 
	 $options1 = "select DISTINCT ID, ccaa from $tbn3 order by ID";
	$resulta1 = mysqli_query($con,$options1) or die("error: ".mysqli_error());
	
	while( $listrows1 = mysqli_fetch_array($resulta1) ){ 
	$id_pro1 = $listrows1[ID];
	$name1 =utf8_encode($listrows1[ccaa]);
	$lista1 .="<option value=\"$id_pro1\"> $name1</option>"; 
	
}
							 ?>
     <select name="id_ccaa"  id="id_ccaa"  class="form-control">
        <?php echo "$lista1";?>
     </select>
     <input type="submit" name="buscar_ccaa" id="buscar_ccaa" value="Buscar" class="btn btn-primary " />
           
    </form>
  
  
       <?php   }
	  if ($_SESSION['nivel_usu']==3){?>
      
           <div  class="well">
          <a href="<?php echo "$url_gestion_votaciones"; ?>?id=<?php echo $_SESSION['id_ccaa_usu']; ?>">  <?php echo $_SESSION['ccaa']; ?>
          </a>
        </div>
        
        <?php }
		
		 if ($_SESSION['nivel_usu']<=3){
 if ($_SESSION['nivel_usu']==2){
  $options2 = "select DISTINCT id, provincia from $tbn8 where especial=0 order by ID";
 }else{
	 $options2 = "select DISTINCT id, provincia from $tbn8 where id_ccaa = ".$_SESSION['id_ccaa_usu']." order by ID";
	
 }

	$resulta2 = mysqli_query( $con,$options2) or die("error: ".mysqli_error());		
	
	while( $listrows2 = mysqli_fetch_array($resulta2) ){ 
	$id_pro2 = $listrows2[id];
	$name2= utf8_encode($listrows2[provincia]);
	
	$lista2 .="<option value=\"$id_pro2\"> $name2</option>"; 
	//$lista1 .="    <label><input type=\"checkbox\" name=\"tipo_$id_pro\" value=\"$id_pro\" id=\"tipo_$id_pro\" $chequed /> $name1</label> <br/>";
	
}
							 ?>
              
        <form id="form1" name="form1" method="post" action="gestion_votaciones.php"  class="well">
         
         <h4>Buscar Votaciones por provincias</h4>     
                     <select name="id_provincia"  class="form-control" id="id_provincia" >
  					   <?php echo "$lista2";?>
    			</select> 
      <input type="submit" name="buscar_prov" id="buscar_prov" value="Buscar" class="btn btn-primary "  />
           
        </form>
         
        
    <?php }            
               if ($_SESSION['nivel_usu']==4){
			//// lista las provincias que tienen los administradores provinciales
$result2=mysqli_query($con, "SELECT id_provincia FROM $tbn5 where id_usuario=".$_SESSION['ID']);
$quants2=mysqli_num_rows($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	
	$name2= utf8_encode($listrows2[id_provincia]);
	 $optiones=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$name2");
     $row_prov=mysqli_fetch_row($optiones);
	 
    $lista2 .="<option value=\"$name2\">". utf8_encode($row_prov[0])."</option>"; 
	 }
			?> 
                      
         <form id="form1" name="form1" method="post" action="gestion_votaciones.php"  class="well">
         
         <h4>Buscar Votaciones por provincias</h4>
			
			     <select name="id_provincia"  class="form-control" id="id_provincia" >
  					   <?php echo "$lista2";?>
    			</select> 
                <p>selecciona municipio </p>
      <select name="municipio" id="municipio" class="form-control" > </select>
     <input type="submit" name="buscar_prov" id="buscar_prov" value="Buscar"class="btn btn-primary "  />          
        </form>
        </div>
			<?php 	
}
 else{
echo " No tiene asignadas provincias";	
}
 }
 /**/
 
  if ($_SESSION['nivel_usu']<=3){
 if ($_SESSION['nivel_usu']==2){
  $options2 = "select DISTINCT id, provincia from $tbn8 where especial=0 order by ID";
 }else{
	 $options2 = "select DISTINCT id, provincia from $tbn8 where id_ccaa = ".$_SESSION['id_ccaa_usu']." order by ID";
	
 }

	$resulta2 = mysqli_query( $con,$options2) or die("error: ".mysqli_error());		
	
	while( $listrows2 = mysqli_fetch_array($resulta2) ){ 
	$id_pro2 = $listrows2[id];
	$name2= utf8_encode($listrows2[provincia]);
	
	$lista2 .="<option value=\"$id_pro2\"> $name2</option>"; 
	//$lista1 .="    <label><input type=\"checkbox\" name=\"tipo_$id_pro\" value=\"$id_pro\" id=\"tipo_$id_pro\" $chequed /> $name1</label> <br/>";
	
}
							 ?>
              
        <form id="form1" name="form1" method="post" action="gestion_votaciones.php"  class="well">
         
         <h4>Buscar Votaciones por Municipios</h4>     
                     <select name="id_provincia2"  class="form-control" id="id_provincia2" >
  					   <?php echo "$lista2";?>
    			</select> 
                <p>selecciona municipio </p>
                 <select name="municipio" id="municipio" class="form-control" > </select>
      <input type="submit" name="buscar_municipio" id="buscar_municipio" value="Buscar" class="btn btn-primary "  />
           
        </form>
         
        
    <?php }            
               if ($_SESSION['nivel_usu']==4){
			//// lista las provincias que tienen los administradores provinciales
$result2=mysqli_query($con, "SELECT id_provincia FROM $tbn5 where id_usuario=".$_SESSION['ID']);
$quants2=mysqli_num_rows($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	
	$name2= utf8_encode($listrows2[id_provincia]);
	 $optiones=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$name2");
     $row_prov=mysqli_fetch_row($optiones);
	 
    $lista2 .="<option value=\"$name2\">". utf8_encode($row_prov[0])."</option>"; 
	 }
			?> 
                      
         <form id="form1" name="form1" method="post" action="gestion_votaciones.php"  class="well">
         
         <h4>Buscar Votaciones por municipios</h4>
			
			     <select name="id_provincia2"  class="form-control" id="id_provincia2" >
  					   <?php echo "$lista2";?>
    			</select> 
     
     <input type="submit" name="buscar_municipio" id="buscar_municipio" value="Buscar"class="btn btn-primary "  />          
        </form>
        </div>
			<?php 	
}
 else{
echo " No tiene asignadas provincias";	
}
 }
 
 /**/

 
 if ($_SESSION['nivel_usu']<=3){
  if ($_SESSION['nivel_usu']==2){
 $options_sub = "select DISTINCT id, subgrupo , tipo,id_provincia,id_ccaa from $tbn4  order by tipo";
  }
   else{
 $options_sub = "select DISTINCT id, subgrupo , tipo,id_provincia,id_ccaa from $tbn4 where  id_ccaa=".$_SESSION['id_ccaa_usu']."
  order by tipo";
   }
$resulta_sub = mysqli_query( $con, $options_sub) or die("error: ".mysql_error());
	$quantos_gr=mysqli_num_rows($resulta_sub);
	
	while( $listrows_sub = mysqli_fetch_array($resulta_sub) ){ 
	$id_sub = $listrows_sub[id];
	$name_sub= utf8_encode($listrows_sub[subgrupo]);
	$id_prov = $listrows_sub[id_provincia];
	$id_ccaa = $listrows_sub[id_ccaa];
	$id_tipo = $listrows_sub[tipo];
	
	$tipo = $listrows_sub[tipo];
	if($tipo==2){
		$tipos="AUTONOMICO";		
	$optiones_ccaa=mysqli_query($con,"SELECT  ccaa FROM $tbn3 where ID=$id_ccaa");
     $row_ccaa=mysqli_fetch_row($optiones_ccaa);
	$ccaaprov=utf8_encode($row_ccaa[0]);
	
	}if($tipo==1){
	$tipos="Provincia de ";
		
	$optiones=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$id_prov");
     $row_prov=mysqli_fetch_row($optiones);
	$ccaaprov=utf8_encode($row_prov[0]);
	 
	}
	if($tipo==3){
	$tipos=" ESTATAL ";
	$ccaaprov="";
	}
	$lista_sub .="   <option value=\"$id_sub\">$name_sub - $tipos $ccaaprov </option>";
	
}

		  
 ?>
 
    
          
         <form id="form1" name="form1" method="post" action="gestion_votaciones.php"  class="well">
       <h4> Grupos de trabajo o asambleas locales</h4>
          <select name="id_sub"  class="form-control" id="id_sub" >
  			  <?php echo "$lista_sub";?>
    		 </select>
           <input name="buscar_sub" type=submit  id="buscar_sub" value="Buscar" class="btn btn-primary " >                  </td>
         </form>
        
<?php }
	 
	  if ($_SESSION['nivel_usu']==4 or $_SESSION['nivel_usu']==5 or $_SESSION['nivel_usu']==6  or $_SESSION['nivel_usu']==7){
		  
?>		 

 <form id="form1" name="form1" method="post" action="gestion_votaciones.php"  class="well">
<h4>Grupos de trabajo</h4>
 
<?php 
		  $result2=mysqli_query($con,"SELECT a.ID ,a.subgrupo,a.tipo_votante, a.id_provincia, a.tipo FROM $tbn4 a,$tbn6 b where (a.ID= b.id_grupo_trabajo) and b.id_usuario=".$_SESSION['ID']." order by a.tipo");
$quants2=mysqli_num_rows($result2);
//$row2=mysql_fetch_row($result2);

if($quants2!=0){	
 
 while( $listrows2 = mysqli_fetch_array($result2) ){ 
	$id_grupo= $listrows2[ID];	
	
	$id_prov= $listrows2[id_provincia];
	$subgrupo= $listrows2[subgrupo];
	
	 $optiones=mysqli_query($con,"SELECT  provincia FROM $tbn8 where ID=$id_prov");
     $row_prov=mysqli_fetch_row($optiones);
   // $lista2 .="    <label><input  type=\"radio\" name=\"grupo_trabajo_prov\" value=\"$id_grupo\"  checked=\"checked\"  id=\"grupo_trabajo_prov\" /> ".$subgrupo." - ". utf8_encode($row_prov[0])."</label> <br/>";
	?> 
   
     
    <label>
    					<?php  if($listrows2[tipo]==1){echo "Asamblea/grupo provincial    &nbsp;&nbsp;";}
						else if($listrows2[tipo]==2)  {echo "Asamblea/grupo autonomico ";}
						else if($listrows2[tipo]==3)  {echo "Asamblea/grupo estatal    ";} ?>
    <input  type="radio"  name="id_sub"  value="<?php echo "$id_grupo"; ?>" class="buttons" id="id_sub_<?php echo "$id_grupo"; ?>" > <?php echo utf8_encode($subgrupo); ?>  </label>
	
         <!-- <a href="<?php echo "$url_gestion_votaciones"; ?>?id_grupo=<?php echo "$id_grupo"; ?>">  <?php echo "$subgrupo ". utf8_encode($row_prov[0]).""; ?>
          </a>--><br/>
       
	
	<?php
	
	 }
	 ?>
	<input name="buscar_sub" type="submit" id="buscar_sub" value="Buscar" class="btn btn-primary " />
	<?php			 
} else{
echo " No tiene asignados Grupos";	
}
		  ?>
          </form>
 
	<?php   }
?>
                    
                
    
                    
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
  
      <script type="text/javascript">
			$(document).ready(function(){
				$('#id_provincia2').change(function(){
					
				var id_provincia=$('#id_provincia2').val();
				$('#municipio').load('../basicos_php/genera_select.php?id_provincia='+id_provincia);
				$("#municipio").html(data);
				});
			});		
	   </script>
       
      
       
			 <?php  if ($_SESSION['nivel_usu']<=4){?>
             <script type="text/javascript">
              function loadPoblacion(){
    
                 $('#municipio').load('../basicos_php/genera_select.php?id_provincia=1');
                 $("#municipio").html(data);
              }
              
            
                $(document).ready(function(){  
                 loadPoblacion(); 
                });
             </script>
         
        	 <?php }else {?>
       			  <script type="text/javascript">
					  function loadPoblacion(){
			
						 $('#municipio').load('../basicos_php/genera_select.php?id_provincia=<?php echo $name2;?>');
						 $("#municipio").html(data);
					  }
					  
					
						$(document).ready(function(){  
						 loadPoblacion(); 
						});
					 </script>
         
        	 <?php }?>
       
    
  </body>
</html>