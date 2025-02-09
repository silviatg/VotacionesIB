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

include("../basicos_php/basico.php") ;
//require_once("../basicos_php/class.inputfilter_clean.php");
//$ids_provincia = $_SESSION['localidad'];
 

$idvot=$_GET['idvot'];
      
$fecha_ver =date("d-m-Y ");
$fecha =date("Y-m-d h:i:s");	  
  
//$id_vot=$_GET['id_vot'];
if(ISSET($_POST["add_candidato"])){
	
	
$texto=fn_filtro_editor($con,$_POST['texto']);
$nombre_cand=fn_filtro($con,$_POST['nombre_cand']);
$provincia=$_POST['provincia'];
$sexo=$_POST['sexo'];
$id_votacion=$_POST['id_vot'];
$numero_id_vut=$_POST['numero_id_vut'];
$nombre_usuario=$_SESSION['ID'];
$URLVideo=fn_filtro($con,$_POST['URLVideo']); //STG: nuevo.


	$insql = "insert into $tbn7 (nombre_usuario, 	id_provincia, 	texto, sexo,id_votacion,anadido, fecha_anadido,id_vut, URLVideo) values (  \"$nombre_cand\",  \"$provincia\", \"$texto\", \"$sexo\", \"$id_votacion\", \"$nombre_usuario\", \"$fecha\", \"$numero_id_vut\", \"$URLVideo\")";
	$inres = @mysqli_query($con,$insql) or die ("<strong><font color=#FF0000 size=3>  Imposible añadir. Cambie los datos e intentelo de nuevo.</font></strong>");
	$idcat = mysqli_insert_id($con);
	$inmsg ="<div class=\"alert alert-success\"> Añadido opcion o candidato <br/>". $nombre_cand."<br/> a la base de datos <br/>
	<a href=\"candidatos_crop.php?idcat=".$idcat."&idvot=".$idvot." \"  >Si quiere puede añadir una imagen a ".$nombre_cand." </a><br/></div>
	<div class=\"alert alert-success\"><a data-toggle=\"modal\"  href=\"../votacion/perfil.php?idgr=$idcat\" data-target=\"#ayuda_contacta\" >Vista previa</a></div>";
	

}


  
   
  $result_vot=mysqli_query($con,"SELECT id_provincia, tipo, seguridad  FROM $tbn1  where id=$idvot");
  $row_vot=mysqli_fetch_row($result_vot);

 
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
                   
          
         
                    
       <a href="candidatos_busq1.php?idvot=<?php echo "$idvot"; ?>" class="btn btn-primary pull-right">Buscar en el directorio para modificar o borrar candiatos en esta encuesta</a>   
                    
        <?php if ($row_vot[2]==3 or $row_vot[2]==4 ){?> 
         <a href="interventor.php?idvot=<?php echo "$idvot"; ?>"  class="btn btn-primary pull-right"> Incluir  interventores</a>  
        <?php   }?>
      <p>&nbsp;</p>
                   
		  
		  <p>&nbsp;</p>
		  
                <h1>INCLUIR 
                    NUEVA OPCIÓN o CANDIDATO</h1>
            <p>&nbsp;</p>
			
            
             <?php echo "$inmsg";?> 
              
          <form action="<?php $_SERVER['PHP_SELF'] ?>" method=post name="frmDatos" id="frmDatos" class="well form-horizontal">
            
            
              <div class="form-group">       
             <label for="nombre" class="col-sm-3 control-label">Nombre </label>
             
            <div class="col-sm-9">
                      <input name="nombre_cand" type="text" id="nombre_cand" class="form-control" placeholder="Nombre de la opción" required autofocus data-validation-required-message="El nombre de la votación es un dato requerido">
                  </div>
                  </div>
                  
				  
				  
				  <?php  
				  /////miramos a ver si es de tipo vut para meterle el codigo de oreden vut				 
		 if($row_vot[1]==2){ ?>
             <div class="form-group">       
             <label for="VUT" class="col-sm-3 control-label"></label>    
            <div class="col-sm-9">
					   <?php ////tenemos que comprobar el ultimo numero que hemos metido para poner el siguiente 
					  $sql_vut = "SELECT id, id_vut FROM $tbn7 WHERE  id_votacion ='$idvot' ORDER BY id_vut DESC";

                 $result_vut = mysqli_query($con, $sql_vut);

				$row_vut=mysqli_fetch_row($result_vut);	 
				
				if ( $row_vut[1]!=""){
					$numero_id_vut=$row_vut[1]+1;
				}
				else{
					$numero_id_vut=0;
				}
					 echo  $numero_id_vut;
					 ///// si es de tipo vut generamos un campo oculto con el numero
					    ?>
                    | Orden VUT
                    <input name="numero_id_vut" type="hidden" id="numero_id_vut" value="<?php echo "$numero_id_vut";?>" />                  
				  </div>
                   </div>
				  <?php  }  ?>
                   
                   
                   
                   <div class="form-group">       
             <label for="Sexo" class="col-sm-3 control-label">Sexo</label>
             
            <div class="col-sm-9"><label>
                      <input name="sexo" type="radio" id="sexo_2" value="O" checked="checked" />
                      Neutro </label>
            (opción sin sexo)
                  <span class="label label-warning">¡¡¡ojo, SI ES UNA VOTACIÓN DE PRIMARIAS HAY QUE INDICAR SEXO!!!</span>
                      <br/>
                      <label>
                        
                        <input name="sexo" type="radio" id="sexo_0" value="H" />
                    Hombre</label>
                      <br />
                      <label>
                         <input type="radio" name="sexo" value="M" id="sexo_1" />
                        Mujer</label>
                      <br />
                    </div>
                    </div>								
					
			<div class="form-group">       
				<label for="URLVideo" class="col-sm-3 control-label">Vídeo del candidato<br/>(URL externa)</label>
				<div class="col-sm-9">
					<input type="text"  name="URLVideo" id="URLVideo" value=""  class="form-control" autofocus />
                </div>
            </div>
			
                    
                    <div class="form-group">   
               <div class="col-sm-12">         
             <label for="nombre" >Texto</label>
             
            
                  
   <script src="../modulos/ckeditor/ckeditor.js"></script>              
       
	<textarea cols="80" id="texto" name="texto" rows="10"><?php echo "$row[2]"; ?></textarea>
		<script>


			CKEDITOR.replace( 'texto', {
				toolbarGroups: [
	{ name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
	{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
    { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
	{ name: 'tools' },
	'/',
    { name: 'links' },
    { name: 'insert' },  
    { name: 'others' },  
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	'/',
    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
    { name: 'styles' },
    { name: 'colors' },
	],
    filebrowserBrowseUrl: '../modulos/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl: '../modulos/ckfinder/ckfinder.html?Type=Images',
    filebrowserFlashBrowseUrl: '../modulos/ckfinder/ckfinder.html?Type=Flash',
    filebrowserUploadUrl: '../modulos/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl: '../modulos/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl: '../modulos/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});

		</script>
                   
              <p>&nbsp;</p>      
                     
                      <input name="fecha" type="hidden" id="fecha" value="<?php echo"$fecha";?>" />
                      <input name="id_vot" type="hidden" id="id_vot" value="<?php echo"$idvot";?>">
                      <input name="add_candidato" type=submit  class="btn btn-primary pull-right" id="add_directorio" value="Insertar nuevo candidato">
                  
    </form>
            
            
      
      
      </div>
		</div>
	  
      
    
                    
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
                <!-- limpiamos la carga de modal para que no vuelva a cargar lo mismo -->
                $('#ayuda_contacta').on('hidden.bs.modal', function () {
                  $(this).removeData('bs.modal');
                });
       </script>
  </body>
</html>