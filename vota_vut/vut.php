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
include('../inc_web/seguri.php'); ?>

   <?php 

  
$Seats=$numero_opciones; ///numero de personas electas

//////// candidatos

//$conta = "SELECT id,nombre_usuario, id_vut FROM $tbn7 WHERE id_votacion = '$idvot' ORDER BY 'id'";

$conta = "SELECT id,nombre_usuario, id_vut,imagen_pequena FROM $tbn7 WHERE id_votacion = '$idvot' ORDER BY rand(" . time() . " * " . time() . ") ";

$result2=mysqli_query($con,$conta);
$quants=mysqli_num_rows($result2);



$Cands=$quants; /// nuemro de opciones existentes (sacar de la tabla candidatos
 
 
 $BigBallot=50; //seguramente sobra    above this, truncate lists and skip unranked in sort
$hrs=getdate(time());
mt_srand($hrs["hours"]);
$ThisFile="vut.php";


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
  
  <?php 
//// seguramente sobra
if (array_key_exists("bb",$_GET))
{ $barebones="true"; }
else
{ $barebones="false"; } 

if (array_key_exists("norot",$_GET))
{ $norot=true; }
else
{ $norot=false; }

$bbfile=$ThisFile;



if ((strpos($ThisFile,"?") ? strpos($ThisFile,"?")+1 : 0)!=0)
{ $bbfile.="&amp;bb=on"; } else { $bbfile.="?bb=on"; }

$InfoFile.="&amp;bt=ts";

$SkipCt=0;
for ($i=0; $i<$Cands; $i++)
{ if ($Excl[$i]) {$SkipCt++;} else {$Balrot[$i-$SkipCt]=$i; } } 
for ($i=0; $i<($Cands-$ExclCt); $i++)
{
 $temp=$Balrot[$i];
 $j=intval(($Cands-$ExclCt-$i)*(mt_rand(0,10000000)/10000000))+$i;
 if ($norot) { $j=$i; }
 $Balrot[$i]=$Balrot[$j];
 $Balrot[$j]=$temp;
 $invBalrot[$Balrot[$i]]=$i;
} 
$Cands2=$Cands-$ExclCt;
$ListLength=$Cands2;
if ($ListLength>$BigBallot) { $ListLength=$BigBallot; }

////hasta aqui

?>
<SCRIPT type="text/javascript" LANGUAGE="JavaScript"><!--
ns4dom=(document.layers)?1:0;
w3cdom=(document.getElementById)?1:0;
Cands=<?php echo $Cands2; ?>;
ListLength=<?php echo $ListLength; ?>;
oldmyval=0;
baddataflag=true;

function vote_check(theform)
{
 if (baddataflag)
 {
  hasarank=false;
  for (i0=0; i0<Cands; i0++)
  {
   if (w3cdom)
   {arank=document.getElementById("sel"+i0).selectedIndex;}
   else {arank=document.forms[0].elements[i0].selectedIndex;}
   if(arank>0) {hasarank=true;} else break;
   if (w3cdom)
   {document.getElementById("sel"+i0).selectedIndex=0;}
   else {document.forms[0].elements[i0].selectedIndex=0;}
  }
//  if (hasarank) {alert('Browser lost form data.  If you have not cast your vote, please try again.');}
  baddataflag=false;
 }
}

function testForEnter() 
{    
 if ((!<?php echo $barebones; ?>) && (w3cdom) && (event.keyCode == 13)) 
 {        
  event.cancelBubble = true;
  event.returnValue = false;
 }
} 

function newoldmyval(theval) { oldmyval=theval; }

function listsort(me,myval) {

// initialize arrays
var newstate = new Array(
<?php for ($i0=0; $i0<=$Cands2; $i0++)
{ 
 echo 0;
 if ($i0!=$Cands2) { echo chr(44); }
}
?> );
var changedit = new Array(
<?php for ($i0=0; $i0<=$Cands2; $i0++)
{ 
 echo 0;
 if ($i0!=$Cands2) { echo chr(44); }
}
?> );
var rankedit = new Array(
<?php for ($i0=0; $i0<=$ListLength; $i0++)
{ 
 echo 0;
 if ($i0!=$ListLength) { echo chr(44); }
}
?> );
changedit[me]=1;
baddataflag=false;

if ((!<?php echo $barebones; ?>) && (w3cdom || ns4dom)) {

// load form data
Lorank=0;
for (i0=0; i0<Cands; i0++)
{
 if (w3cdom) 
 {newstate[i0]=document.getElementById("sel"+i0).selectedIndex;}
 else {newstate[i0]=document.forms[0].elements[i0].selectedIndex;}
 rankedit[newstate[i0]]++;
 if(newstate[i0]>Lorank) {Lorank=newstate[i0];}
}

// determine button action
if (myval<0)
{
 if (w3cdom)  
 {oldmyval=document.getElementById("sel"+me).selectedIndex;}
 else {oldmyval=document.forms[0].elements[me].selectedIndex;}
 if (oldmyval!=0) { myval=0; }
 else if (Lorank==ListLength) { myval = Lorank; }
 else { Lorank++; myval=Lorank; }
 newstate[me]=myval;
 rankedit[oldmyval]--;
 rankedit[myval]++;
}

// process duplicate rankings 
if ((rankedit[myval]>1) && (myval!=0))
{
 // find first gap in rankings above and below myval 
 higap=myval;
 while((higap>0) && (rankedit[higap]>0)) { higap--; }
 logap=myval;
 while((logap<=ListLength) && (rankedit[logap]>0)) { logap++; }

 // lots of conditions in case browser trashes oldmyval somehow
 goup=false;
 godown=false;
 if (myval>oldmyval)
{ if (higap>0) { goup=true; } else if (logap<=ListLength) { godown=true; } }
 else if (myval<oldmyval) 
{ if (logap<=ListLength) { godown=true; } else if (higap>0) { godown=true; } }
 else 
{ if (higap>0) { goup=true; } else if (logap<=ListLength) { godown=true; } }

 if (goup)
 {
  for(i0=0; i0<Cands; i0++)
  {
   si=newstate[i0];
   if ((si>higap) && (si<=myval))
   { newstate[i0]--; changedit[i0]=1; }
  }
  newstate[me]=myval;
 }

 if (godown)
 { 
  for(i0=0; i0<Cands; i0++)
  {
   si=newstate[i0];
   if ((si<logap) && (si>=myval))
   {
    if (si!=ListLength)
    { newstate[i0]++; changedit[i0]=1; }
    else { newstate[i0]=0; changedit[i0]=1; }
   }
  }
  newstate[me]=myval;
 } 
} // end duplicate elimination

// remove gap if candidate is unranked
if (myval==0)
{
 higap=Lorank;
 while((higap>0) && (rankedit[higap]>0)) { higap--; }
 if (higap>0)
 {
  for(i0=0; i0<Cands; i0++)
  {
   if (newstate[i0]>higap) { newstate[i0]--; changedit[i0]=1; }
  }
 }
}

// bubble sort
if (w3cdom) {
 for(i0=1; i0<Cands; i0++)  
 { 
  Sortrank=newstate[i0];
  if (Sortrank==0) { Sortrank=Cands+1; }
  i1=i0;
  Tryrank=newstate[i1-1];
  if (Tryrank==0) { Tryrank=Cands+1; }
  unrankskip=0;
  movedit=false;
  while(Tryrank>Sortrank)
  {
   if (!movedit)
   {
    movedit=true;
    Sortname=document.getElementById("sel"+i0).getAttribute('name');
    Sorthtml=document.getElementById("label"+i0).innerHTML;
   }
   if (Tryrank==Cands+1)
   {
    // skip over unranked, if possible
    if ((Cands><?php echo $BigBallot; ?>) && (i1>1))
    {
     if (newstate[i1-2]==0)
     { i1--; unrankskip++; continue; }
    } 
    Tryrank=0;
   }
   Tryname=document.getElementById("sel"+(i1-1)).getAttribute('name');
   Tryhtml=document.getElementById("label"+(i1-1)).innerHTML;
   newstate[i1+unrankskip]=Tryrank; changedit[i1+unrankskip]=1;
   document.getElementById("sel"+(i1+unrankskip)).setAttribute('name',Tryname);
   document.getElementById("label"+(i1+unrankskip)).innerHTML=Tryhtml;
   i1--; unrankskip=0;
   if (i1<=0) { break; }
  Tryrank=newstate[i1-1];   
  if (Tryrank==0) { Tryrank=Cands+1; }
  }   
  if (Sortrank==Cands+1) { Sortrank=0; }
  if (movedit)
  {
   newstate[i1]=Sortrank; changedit[i1]=1;
   document.getElementById("sel"+i1).setAttribute('name',Sortname);
   document.getElementById("label"+i1).innerHTML=Sorthtml;
  }
 }
} // if w3cdom
notfoundyet=true;
for (i0=0; i0<Cands; i0++)
{
 if (changedit[i0]==1)
 {
  if (w3cdom) {document.getElementById("sel"+i0).selectedIndex=newstate[i0];}
  else {document.forms[0].elements[i0].selectedIndex=newstate[i0];}
 }
 if ((w3cdom) && (notfoundyet) && (newstate[i0]==myval))
 { document.getElementById("sel"+i0).focus(); notfoundyet=false; }
}
} // if either dom
oldmyval=myval;
}
//--></SCRIPT>
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
        <div class="col-md-7"><!--Comiezo--><h1><?php echo "$nombre_votacion" ; ?></h1>

<?php echo "$resumen"; ?>
<?php 

echo"$row[3]";  //¿sobra?

////////////////////// ojo, muy importante no enviar en el post nada antes de los datos de los votantes, cualquier otro dato despues del submit

?>

<form id="balform" action="vutconfirm.php?idvot=<?php echo $idvot; ?>" method="post"  class="well">

 <?php  if ($Seats>1)
{
	$plural_1= "n";
	$plural_2= "s";
	$plural_3= "es";
	}

?>
 Sera<?php echo $plural_1;?>  elegida<?php echo $plural_2;?>  <?php echo $Seats." opcion".$plural_3;?> en esta elección, pero puede ordenar toda la lista segun sus preferencias <br/><br/></td></tr>
<!-- google_ad_section_start -->
<div class="table-responsive">
<table class="table">

<?php //for ($i0=0; $i0<$Cands2; $i0++){ ?>

<?php 
$i0=0;
 while ($row = mysqli_fetch_assoc($result2)) {
  
?>
<tr>
<td nowrap>
<div class="col-sm-2">

<?php

////// esta parte es del boton accesorio para subir-bajar

 if ($barebones=="false") {
?>
<img src="../temas/<?php echo "$tema_web"; ?>/imagenes/botona.png"
alt="Añadir o Borrar" width="72" height="35" 
style="vertical-align: top;" title="Añadir o Borrar]"
onmousedown="this.src='../temas/<?php echo "$tema_web"; ?>/imagenes/botonb.png';"
onmouseup="this.src='../temas/<?php echo "$tema_web"; ?>/imagenes/botonb.png'; listsort(<?php echo $i0; ?>,-1);"
onmouseover="vote_check();" 
onmouseout="this.src='../temas/<?php echo "$tema_web"; ?>/imagenes/botona.png';"
>
<?php } 

/////hasta aqui
?>
</div>
<div class="col-sm-3">


<select name="cand__<?php  echo  $row[id_vut]; ?>" id="sel<?php echo $i0; ?>"
 onmouseover="newoldmyval(this.selectedIndex); vote_check;"
 onfocus="newoldmyval(this.selectedIndex); vote_check;"
 onChange="listsort(<?php echo $i0; ?>,this.selectedIndex);"
class="form-control" style="vertical-align: baseline;">
 <option selected> --
<?php for ($i1=1; $i1<=$ListLength; $i1++)
  {
   echo "<option value=".$i1.">".$i1;
   $Suffixnum=$i1%10;
   if (($i1>10) && ($i1<14)) { $Suffixnum=0; }
   if ($Suffixnum==1) { echo " ro"; }
   if ($Suffixnum==2) { echo " do"; }
   if ($Suffixnum==3) { echo " ro"; }
   if (($Suffixnum==4) || ($Suffixnum==5) || ($Suffixnum==6)) { echo " to"; }
   if ($Suffixnum==7) { echo " mo"; }
   if ($Suffixnum==8) { echo " vo"; }
   if ($Suffixnum==9) { echo " no"; }
   if (($Suffixnum==10) || ($Suffixnum==11) || ($Suffixnum==12)) { echo " mo"; }
    if ($Suffixnum>13) { echo " "; }
   echo "</option>";
  }
  ?></select>
  </div>
  <div class="col-sm-7">
<span id="label<?php echo $i0; ?>" >
<?php if($row[imagen_pequena]=="" ){?><?php }else{?><img src="<?php echo $upload_cat; ?>/<?php echo $row['imagen_pequena'] ;?>" alt="<?php echo $row['nombre_usuario'];?> " width="70" height="70"  /> <?php }?>
<?php
echo $row['nombre_usuario']; ?>   | 



<a data-toggle="modal"  href="../votacion/perfil.php?idgr=<?php echo $row['id']; ?>" data-target="#ayuda_contacta" title="<?php
echo $row['nombre_usuario']; ?>"  >más información</a>


</span>
</div></td></tr>
<?php 
++$i0;
} 



/////////  seguramente esta parte sobra
$whotemp="";
if (array_key_exists("who",$_GET))
{
 $whotemp=rawurlencode($_GET['who']);
 $whotemp=str_replace("%40","@",$whotemp);
 echo "<input type=hidden name=email value=";
 echo substr($whotemp,0,40);                           
 echo ">";
 
}   

////hasta aqui

?>

</table>
</div>
<?php require('../basicos_php/control_voto.php'); // sistema para incluir internventores o clave voto seguro ?>

<input type="submit" name="submit" id="castvote"  class="btn btn-lg btn-primary pull-right"
value="Votar" onmouseover="vote_check();" onfocus="vote_check();">

<input type="reset" name="reset" value="Borrar datos" id="clear"  class="btn btn-small">
<input name="id_vot" type="hidden" id="id_vot" value="<?php echo $idvot;?>" />
<input name="Cands" type="hidden" id="Cands" value="<?php echo $Cands;?>" />



</form>


<!--<a href="<?php echo $ResultFile."#Round1"; ?>">ver resultados</a>-->

<?php echo "$texto"; ?>	
                   
                   <!--Final-->
        
  
        </div>
        
          <div class="col-md-3">
         
		<?php  // include("lateral_derecho.php"); ?>              
        </div>
      
  </div>
 

  <div id="footer" class="row">
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