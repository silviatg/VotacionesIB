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
include('../inc_web/seguri.php'); 
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
                     <?php 
   $NoEx=0; //Remove exhausted ballots from thresh calc (no=0, yes=1)
 
$Pollname=$idvot;

$Title[]= $nombre_votacion; ///nombre de la votacion
$Seats=$numero_opciones; ///numero de personas electas
$odep_dc_desc=$resumen;

// $odep_dc_ini="2005-12-12 00:00+0100" ; //fecha inicio votacion
// $odep_dc_fin="2006-01-20 00:00+0100"  ; //fecha fin de votacion
  
// $odep_dc_freg_max="2005-12-07 00:00+0100" ;  ////creo que no sirve con nuestra configuracion, la fecha en la que tiene que estar registrado el usuario para votar
//////// candidatos


 
//DemoChoice: A preference voting package for the web (C) 2001 Dave Robinson
//Results display script
//$FilePath="../data_vut/"; //eliminado el 6-6-2014



$rmax=getrandmax();
$Digits=0;
$ShowType="";
$TypeQuery="?type=";

if (array_key_exists("barmax",$_GET))
{ $BarMax=1*$_GET["barmax"]; }
else
{ $BarMax=300; }
 
if (array_key_exists("charmax",$_GET))
{ $CharMax=1*$_GET["charmax"]; }
else
{ $CharMax=55; } 

if (array_key_exists("barht",$_GET))
{ $BarHeight=1*$_GET["barht"]; }
else
{ $BarHeight=12; } 

if (array_key_exists("cellpad",$_GET))
{ $CellPad=1*$_GET["cellpad"]; }
else
{ $CellPad=1; } 

//$ThisFile="dcresults.php"; //ver si se puede quitar
$ThisFile="resultados.php"; //ver si se puede quitar
//require("dcconfigload.php");



//////// esta parte estaba en el archivo dcconfigload.php
$Hare=false;
$nodivs=false;
$ExclStr=NULL;
$ExclCt=0;
$Expired=false;
$ExpireTime=0;
$RegVoters=1;
$NoRunningTally=false;  ///necesario
//$BordColor="FFFFFF";
//$BalColor="FFFFFF";
$DoRecycle=true;


if ($Seats==1)
{
 $Hare=false;
 $NoEx=1;
 $DoRecycle=!$DoRecycle;
}
$InfoFile.="?nw=".$Seats;

for ($i=0; $i<=$Cands; $i++) { $Excl[$i]=false; }
if (strlen($ExclStr)>0)
{
 $ExclTemp=explode(",",$ExclStr);
 $ExclCt=0;

 foreach ($ExclTemp as $e)
 {
  $f=trim($e);
  if ((($f>0) or ($f=="0")) and ($f<$Cands))
  { $Excl[$f]=true; $ExclCt++; }
 }
}

////////////////////



$conta = "SELECT id,nombre_usuario,id_vut FROM $tbn7 WHERE id_votacion = '$idvot' ORDER BY 'id'";

$result2=mysqli_query($con,$conta);
$Cands=mysqli_num_rows($result2); /// nuemro de opciones existentes (sacar de la tabla candidatos


	
	while( $listrows2 = mysqli_fetch_array($result2) ){ 
	$nombre_usuario = $listrows2[nombre_usuario];
	$id_vut = $listrows2[id_vut];
	$orden_array=$id_vut;
	
	$Name[$orden_array]=$nombre_usuario;
}


//////////////////////
//$Name = array("1","2","3","4","5","6","nombre del  candidato 1","nombre del  candidato2","nombre del  candidato3", "nombre del  candidato4" );  //limpiar


$Name[$Cands]="Votos descartados";  //metemos en ultimo lugar del array 



require("dctallyload.php");

if ((strpos($ThisFile,"?") ? strpos($ThisFile,"?")+1 : 0)!=0)
{ $TypeQuery="&type="; } 

if (array_key_exists("type",$_GET))
{ $ShowType=$_GET["type"]; } 

if ($Seats>1)
 {
  if ($ShowType=="table")
  { $Digits=2; }
  else
  { $Digits=1; } 
 } 

if (array_key_exists("digits",$_GET))
{ $Digits=$_GET["digits"]; }

for ($i=0; $i<=$Cands; $i=$i+1)
{ $Continuing[$i]=true; } 

$MaxVote=0;
for ($RndNum=0; $RndNum<$Rnds; $RndNum++)
{
 for ($CndNum=0; $CndNum<$Cands; $CndNum++)
 {
  if ($VoteMatrix[$RndNum][$CndNum]>$MaxVote)
  { $MaxVote=$VoteMatrix[$RndNum][$CndNum]; } 
 } 
} 
if ($Thresh>$MaxVote)
{ $MaxVote=$Thresh; } 

//Sort according to first round votes (leave exhausted at end)
if ($TotalVotes>0)
{
 for ($i0=0; $i0<=$Cands; $i0++)
 { $Sort[$i0]=$i0; } 

 for ($i0=1; $i0<$Cands; $i0++)
 {
  $Sortme=$Sort[$i0];
  $i1=$i0;
  while($VoteMatrix[0][$Sort[$i1-1]]<$VoteMatrix[0][$Sortme])
  {
   $Sort[$i1]=$Sort[$i1-1];
   $i1=$i1-1;
   if ($i1<=0) {break;} 
  }
  $Sort[$i1]=$Sortme;
 } 

 $VotesCounted=0;
 $DepthMax=0;
 $DepthSum=0;
 for ($i=0; $i<$Cands; $i++)
 {
  if ($Status[$i]>0)
  { $VotesCounted+=$VoteMatrix[$Rnds-1][$i]; } 
  if ($Depth[$i]>$DepthMax)
  { $DepthMax=$Depth[$i]; }
  $DepthSum+=$Depth[$i];  
 } 

 $PluralCounted=0;
 for ($i=0; $i<$Seats; $i++)
 { $PluralCounted+=$VoteMatrix[0][$Sort[$i]]; } 
} // $TotalVotes > 0

function Dither($dithval)
{
 global $rmax;
 $dithint=intval($dithval);
 $dithfrac=$dithval-$dithint;
 if ((rand()/$rmax)<$dithfrac)
 { $dithfrac=1; }
 else
 { $dithfrac=0; } 
 return $dithint+$dithfrac;
} 

srand(1);
for ($i0=0; $i0<=$Cands; $i0++)
{
 $ColorStr[$i0]="#";
 for ($i1=1; $i1<=3; $i1++)
 { $ColorStr[$i0]=$ColorStr[$i0].dechex(intval((rand()/$rmax)*16))."0"; } 
} 

function PrintTitle($saltar=1)
{
 global $TitleLines, $Title, $Seats, $TotalVotes;
 
 
 echo "<font class=peq>$Seats"; 
 if ($Seats>1)
 { 
   echo " opciones saldrán elegidas";
 } 
 else
 {
   echo " opción saldrá elegida";
 }
 echo "</font>";
 
 if ($saltar) {echo "<br>";}
}

//--------------------------------------------Start of output

/*include("custom_util.php");
echo layoutHeaderCustom ();
echo layoutBodyCustom   ();
*/
echo "<h2>" , join(" ", $Title) , "</h2>";
echo $odep_dc_desc , "<br/>";


if (($TotalVotes>0) && !$NoRunningTally)
{
if ($ShowType=="table")
{
//---------------------------Begin Table


?>


<h3>Datos de la votacion en Formato Tabla </h3>
<a href="<?php echo $ThisFile."?idvot=".$idvot ; ?>">&gt;&gt;&gt;&gt;&gt; Ver en fomato de Gráfica &lt;&lt;&lt;&lt;&lt;</a>
<p>&nbsp;</p>
<?php 

PrintTitle();

?>
<p id=vota2 style="td{padding: 5px;}">
<div class="table-responsive">
<table cellspacing=1 cellpadding=0 class="table table-bordered table-striped">
<thead>
<tr>
<th>Resultados con <?php echo number_format($TotalVotes,0); ?> votos emitidos</th>
<?php 


for ($i1=0; $i1<=$Cands; $i1++)
{
if (!$Excl[$Sort[$i1]])
{ 
if ($i1 < $Cands)
{
echo "<th>" . $Name[$Sort[$i1]] . "</th>";
}
else
{
echo "<th>" . $Name[$Sort[$i1]] . "</th>";
}
}
} 
echo "</tr></thead>";
$ZeroSkip=0;
for ($i0=0; $i0<$Rnds; $i0++)
{
if ($Elim[$i0]<0)
{
if ($VoteMatrix[$i0][abs($Elim[$i0])-1]>0)
{ $SkipZero=false; }
else
{ $SkipZero=true; } 
}
else
{ $SkipZero=false; } 

if ($SkipZero)
{ $ZeroSkip=$ZeroSkip+1; }
else
{
echo "<tbody><tr><td>Ronda " . ($i0+1-$ZeroSkip) . "</td>";
for ($i1=0; $i1<=$Cands; $i1++)
{
if (!$Excl[$Sort[$i1]])
{ 
if ($i1 < $Cands)
{
echo "<td align=middle>" . 
    round($VoteMatrix[$i0][$Sort[$i1]],$Digits) .  "</td>";
}
else
{
echo "<td align=middle>" . 
    round($VoteMatrix[$i0][$Sort[$i1]],$Digits) .  "</td>";
}
}
}
echo "</tr>";
if ($i0<$Rnds-1)
{
echo "<tr><td>Transferidos de <i>".$Name[abs($Elim[$i0])-1]."</i></td>";
for ($i1=0; $i1<=$Cands; $i1++)
{
if (!$Excl[$Sort[$i1]])
{
if ($XferMatrix[$i0+1][$Sort[$i1]]>0)
{ echo "<td align=middle >".round($XferMatrix[$i0+1][$Sort[$i1]],$Digits)."</td>"; }
else
{ ?><td>&nbsp;</td><?php }
}
} //i1
echo "</tr>";
} //i0 < Rnds-1
} //zero skip
} //i0
echo "<tr><td>Estado</td>";
for ($i2=0; $i2<$Cands; $i2++)
{
if (!$Excl[$Sort[$i2]])
{
echo "<td align=middle>";
if ($Status[$Sort[$i2]]<1)
{ echo "descartado"; }
else
{ echo "<b>elegido</b>"; } 
echo "</td>";
}
}
?>
<td>&nbsp;</td></tr>
</tbody>
</table>
</div>
</p>



<?php
// echo "Ballots cast: ".round($TotalVotes,$Digits);
// if ($Invite) { echo " (".round((100.0*$TotalVotes/$RegVoters),1)."% turnout)"; }
// echo "<br>";
echo "Umbral ganador";
if ($Hare) { echo " (Hare)"; } 
echo ": ".round($Thresh*(1-$NoEx*$VoteMatrix[$Rnds-1][$Cands]/$TotalVotes),$Digits)." &nbsp; (".round(100.0*$Thresh/$TotalVotes,1)."%";
if ($NoEx) { echo " de los votos en la ronda final"; }
echo ")<br>";
}



else
{
//----------------------------------End Table / begin charts
$ZeroSkip=0;
$PrevRnd=1;
for ($RndNum=0; $RndNum<$Rnds; $RndNum++)
{
$ThreshSize=Dither($Thresh*(1-$NoEx*$VoteMatrix[$RndNum][$Cands]/$TotalVotes)*$BarMax/$MaxVote);
$CThreshSize=Dither($Thresh*(1-$NoEx*$VoteMatrix[$RndNum][$Cands]/$TotalVotes)*$CharMax/$MaxVote);

if ($Elim[$RndNum]<0)
{
if ($VoteMatrix[$RndNum][abs($Elim[$RndNum])-1]==0)
{ $SkipZero=true; }
else
{ $SkipZero=false; } 
}
else
{ $SkipZero=false; } 

if ($SkipZero)
{ 
?><a name=Round<?php echo $RndNum+1; ?>></a><?php
$ZeroSkip++;
}
else
{


if ($RndNum+1-$ZeroSkip == 1)
{

?>
<h3>Resultado de la votacion en Formato Gráficas </h3>
<a href="<?php echo $ThisFile."?idvot=".$idvot."&type=table"; ?>">&gt;&gt;&gt;&gt;&gt; Ver en formato Tabla &lt;&lt;&lt;&lt;&lt;</a>
<p>&nbsp;</p>
<?php

}

?>

<div class="caja_rondas">
Rondas:

<?php
for ($nron=1; $nron < ($Rnds+1-$ZeroSkip); $nron++)
{
if ($nron == ($RndNum+1-$ZeroSkip))
{
echo "$nron ";
}
else
{
echo "<a href=#Round" , $nron+$ZeroSkip , ">$nron</a> ";
}
}

?>
| <a href="#depth">Profundidad</a>
<a name=Round<?php echo $RndNum+1; ?>>&nbsp;</a>
<br><br>

<?php PrintTitle(); ?>

<p id=vota2>
<table width="90%" border=0 cellpadding=0 cellspacing=0>
<tr> <td colspan=100 class=cab>Ronda 
<?php

echo $RndNum+1-$ZeroSkip; 
if ($RndNum+1 == $Rnds) {echo " (última)";}

?>
</td> </tr>

<tr>
<td width=25% class=izq>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>
<table cellspacing=0 cellpadding=0 style="border: 0px;">
<tr>
<td><?php
$CharStr="";
for ($ichar=1; $ichar<=$CThreshSize; $ichar++)
{ $CharStr.="-"; } 
?><img border=0 height=<?php echo $BarHeight; ?> width=<?php echo max(1,$ThreshSize-10); ?>
src=shim.gif alt="<?php echo $CharStr; ?>"></td>
<td><?php echo round(100.0*$Thresh/$TotalVotes,1); ?>%</td>
</tr>
</table>
</td>
</tr>
<?php 
for ($CndNum=0; $CndNum<=$Cands; $CndNum++)
{
if ($Continuing[$Sort[$CndNum]] && ($VoteMatrix[$RndNum][$Sort[$CndNum]]>0))
{
$BarSize=Dither($VoteMatrix[$RndNum][$Sort[$CndNum]]*$BarMax/$MaxVote);
$CharSize=Dither($VoteMatrix[$RndNum][$Sort[$CndNum]]*$CharMax/$MaxVote);
?>
<tr>
<td class=izq><?php echo $Name[$Sort[$CndNum]]; ?>&nbsp;</td>
<td align=right><?php echo number_format($VoteMatrix[$RndNum][$Sort[$CndNum]],$Digits)."&nbsp;"; ?></td>
<td align=right><?php
if (!($NoEx && $Sort[$CndNum]==$Cands))
{
echo "(".number_format($VoteMatrix[$RndNum][$Sort[$CndNum]]*100.0/($TotalVotes-$NoEx*$VoteMatrix[$RndNum][$Cands]),1)."%)&nbsp;";
}
else { echo "&nbsp;"; }
?></td>
<td>
<table height=<?php echo $BarHeight; ?> cellspacing=0 cellpadding=0 style="border: 0px;">
<tr>
<td bgcolor=<?php echo $ColorStr[$Sort[$CndNum]].">";
if ($BarSize<$ThreshSize)
{ 
$CharStr="";
for ($ichar=1; $ichar<=$CharSize; $ichar++)
{ $CharStr.=chr(65+$Sort[$CndNum]); }
?><img border=0 height=<?php echo $BarHeight; ?> width=<?php echo $BarSize; ?>
src=shim.gif alt="<?php echo $CharStr; ?>"></td>
<td><?php 
$CharStr="";
for ($ichar=1; $ichar<=($CThreshSize-$CharSize); $ichar++) { $CharStr.=chr(95); } 
?><img border=0 height=<?php echo $BarHeight; ?> width=<?php echo $ThreshSize-$BarSize; ?> src=shim.gif 
alt="<?php echo $CharStr; ?>"></td>
<td><?php
if ($CndNum<$Cands)
{ ?><img border=0 height=<?php echo $BarHeight; ?> src=dotline.gif alt=":"><?php }
else
{ ?><img border=0 width=1 height=<?php echo $BarHeight; ?> src=shim.gif alt=" "><?php }
?></td>
<td><img border=0 height=<?php echo $BarHeight; ?> width=<?php echo $BarMax-$ThreshSize; ?> src=../imagenes/shim.gif alt=" "><?php

//************************
}
else
{ 
$CharStr="";
for ($ichar=1; $ichar<=$CThreshSize; $ichar++)
{ $CharStr.=chr(65+$Sort[$CndNum]); } 
?><img border=0 width=<?php echo $ThreshSize; ?> src=shim.gif alt="<?php echo $CharStr; ?>"></td>
<td bgcolor=<?php echo $ColorStr[$Sort[$CndNum]].">"; 
if ($CndNum<$Cands)
{ ?><img border=0 height=<?php echo $BarHeight; ?> src=dotline.gif alt=":"><?php }
else
{ ?><img border=0 width=1 height=<?php echo $BarHeight; ?> src=shim.gif alt=" "><?php }
echo "</td><td bgcolor=".$ColorStr[$Sort[$CndNum]].">"; 
$CharStr="";
for ($ichar=1; $ichar<=($CharSize-$CThreshSize); $ichar++) { $CharStr.=chr(65+$Sort[$CndNum]); } 
?><img border=0 height=<?php echo $BarHeight; ?> width=<?php echo $BarSize-$ThreshSize; ?>
src=shim.gif alt="<?php echo $CharStr; ?>"></td>
<td><img border=0 height=<?php echo $BarHeight; ?> width=<?php echo $BarMax-$BarSize; ?> src=shim.gif alt=" "><?php
}
?></td>
</tr>
</table>
</td>
</tr>
<?php 
} 
} 
//CndNum

?><tr>
<td class=izq>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td><img border=0 height=10 width=<?php echo $BarMax; ?> src=shim.gif alt=" "></td>
</tr>
<?php 
if ($RndNum<$Rnds-1)
{
//Do XferMatrix
?>
<tr>
<td bgcolor="#C4FF48" class=cat>Resultados</td>
<td class=cat colspan=2>&nbsp;</td>
<?php
if ($VoteMatrix[$RndNum+1][abs($Elim[$RndNum])-1]!=$VoteMatrix[$RndNum][abs($Elim[$RndNum])-1])
{ ?><td class=cat>Votos transferidos (a estos colores)</td><?php }
else
{ ?><td class=cat>&nbsp;</td><?php }
?>
</tr>
<tr>
<td bgcolor="#C4FF48" class=izq><?php echo $Name[abs($Elim[$RndNum])-1]; ?></td>
<?php 
if ($Elim[$RndNum]<0) { $Continuing[abs($Elim[$RndNum])-1]=false; } 
if ($Status[abs($Elim[$RndNum])-1]<1)
{ echo "<td colspan=2>descartado</td>"; }
else
{ echo "<td colspan=2>elegido</td>"; } 
?>
<td align="center">
<table height=<?php echo $BarHeight; ?> cellspacing=0 cellpadding=0 style="border: 0px;">
<tr><?php 
for ($i0=0; $i0<=$Cands; $i0++)
{
if ($XferMatrix[$RndNum+1][$i0]>0)
{
$BarSize=Dither($XferMatrix[$RndNum+1][$i0]*$BarMax/$MaxVote);
$CharSize=Dither($XferMatrix[$RndNum+1][$i0]*$CharMax/$MaxVote);
$CharStr="";
for ($ichar=1; $ichar<=$CharSize; $ichar++) { $CharStr.=chr(65+$i0); } 
?>

<!--aqui se general las barras de los colores a los que se transfiere-->
<td bgcolor=<?php echo $ColorStr[$i0]; ?>><img border=0 height=<?php echo $BarHeight; ?> 
width=<?php echo $BarSize; ?> src=shim.gif alt="<?php echo $CharStr; ?>"></td>
<?php 
} 
} 
?>
</tr>
</table>
</td>
</tr>
<?php 
}



else
{
//if final round
?>
<tr>
<td bgcolor="#C4FF48" class=cat>Resultados</td>
<td class=cat colspan=3>&nbsp;</td>
</tr>
<?php 
for ($i0=0; $i0<$Cands; $i0++)
{
if ($VoteMatrix[$RndNum][$i0]>0.000000001)
{
?><tr><td bgcolor="#C4FF48" class=izq><?php echo $Name[$i0]; ?></td><td colspan=2 align="center"><?php 
if ($Status[$i0]<1)
{ echo "descartado"; }
else
{ echo "<b>elegido</b>"; } 
?></td><td>&nbsp;</td></tr><?php 
} //Votematrix > 0
} //i0
} //final round
//------------------------Chart captions
?>
</table>
</p> 
Información: (ronda <?php echo $RndNum+1-$ZeroSkip ?>)<br> 

<p>
<ul>
<li>La línea punteada representa el número de votos que garantizan ganar
(<?php echo round(100.0*$Thresh/$TotalVotes,1); ?>%).
<?php 
if ($RndNum==0)
{ 
?><li>En la primera ronda, se cuentan las primeras selecciones de cada voto.<?php } 
if ($Elim[$RndNum]==0)
{
?>
<li>Aquí el número de candidatos restantes es igual al número de asientos restantes, por tanto los candidatos restantes se declaran elegidos.
<?php 
}
else
{
if ($Elim[$RndNum]<0)
{
?>
<li>Ningún candidato tiene el número de votos necesarios para ganar, por tanto se descarta el candidato en úlimo lugar (<?php
echo trim(strip_tags($Name[abs($Elim[$RndNum])-1]));
?>).  Los votos para ese candidato se cuentan tomando el siguiente candidato en cada voto.
<?php 
} 
if ($Elim[$RndNum]>0)
{
echo "<li>La opción <i>" . strip_tags($Name[$Elim[$RndNum]-1]);
?></i> tiene suficientes votos y es declarada ganadora.<?php 
if (($Seats>1) && ($RndNum<$Rnds-1))
{
?>
<li>Para asegurar que todos los votos cuentan por igual, los votos que exceden el umbral se cuentan tomando su siguiente candidato, si es posible. Esto se realiza contando una fracción de los votos mas recientemente contados para la oprción ganadora.

<?php 
} //Seats > 1

} //someone won
} //Elim isn't empty

if (($RndNum<$Rnds-1))
{
//---Show new colors
$NoNewColors=true;
for ($i=0; $i<=$Cands; $i++)
{
if (($VoteMatrix[$RndNum][$i]==0) && ($XferMatrix[$RndNum+1][$i]>0))
{
if ($NoNewColors)
{ echo "<li><table border=0><tr><td>Nuevos colores: </td>"; }
else
{ echo "</tr><tr><td>&nbsp;</td>"; }
?>
<td>
<table border=0 height=<?php echo $BarHeight; ?> cellspacing=0 cellpadding=0>
<tr> 
<td bgcolor=<?php echo $ColorStr[$i]; ?>><img border=0 height=<?php echo $BarHeight; ?>
 width=<?php echo $BarHeight; ?> src=shim.gif alt="<?php echo chr(65+$Cands); ?> "></td>
</tr>
</table>

</td>
<?php
echo "<td> ".$Name[$i]."</td>";
$NoNewColors=false;
} 
} 

if (!$NoNewColors)
{ echo "</tr></table>"; } 
}
else
{
//In last round
?>
<li>Finalmente un <?php echo round(100*($VotesCounted/($TotalVotes-$NoEx*$VoteMatrix[$RndNum][$Cands])),1); ?>%
de los votos contaron para la opción ganadora.
<?php if ($Rnds>1)
{
echo "<li>Comparar eso con el ".round(100*($PluralCounted/$TotalVotes),1)."% ";
echo "que hubiera resultado si sólo se hubiera usado la <a href='#Round1'>primera ronda</a> de votos.";
}


if ($Seats>1)
{
?>
<li>Observar que las opciones ganadoras tienen mayor igualdad en la ronda final que en la primera.
<?php 
} //Seats > 1

?>
<li>En la gráfica de 
<a href="#depth">Profundidad de voto</a> puedes ver cómo han contribuido al recuento las opciones menos preferidas por los votantes.<p>
<?php 
} //whether in last round
?>
</ul>
</p>
</div>

<br><br><br><br><?php
$PrevRnd=$RndNum+1;
} //zero skip
} //round loop




// Profundidad de voto.
?> 
Rondas:
<?php

for ($nron=1; $nron < ($Rnds+1-$ZeroSkip); $nron++)
{
// if ($nron == ($RndNum+1-$ZeroSkip))
// {
//   echo "$nron ";
// }
// else
// {
echo "<a href=#Round" , $nron+$ZeroSkip , ">$nron</a> ";
// }
}

?>
| Profundidad
<a name=depth>&nbsp;</a>
<br><br>
<?php

PrintTitle();

?>
<p id=vota2>
<table border=0 cellspacing=0 cellpadding=0>
<tr><td class=cab colspan=100>Profundidad de voto</td></tr>

<tr>
<td class=cat width=5%>Pref.&nbsp;&nbsp;</td>
<td class=cat colspan=2>Fracción de votos para ganador<?php if ($Seats>1) { echo "es"; } ?></td>
</tr> 
<?php
$SkipCt=0;
if ($DepthMax==0) {$DepthMax=1;}
for ($i0=0; $i0<($Cands-$Seats-$ExclCt); $i0++)
{
$BarSize=Dither($Depth[$i0]*$BarMax/$DepthMax);
$CharSize=Dither($Depth[$i0]*$CharMax/$DepthMax);
$CharStr="";
for ($ichar=1; $ichar<=$CharSize; $ichar++) { $CharStr.=chr(88); } 
if (($Depth[$i0]/$DepthMax)>=0.0005)
{
echo "<tr><td class=izq>".($i0+1);
$Suffixnum=($i0+1)%10;
if ((($i0+1)>10) && (($i0+1)<14)) { $Suffixnum=0; } 
if ($Suffixnum==1) {echo "st";} 
if ($Suffixnum==2) {echo "nd";} 
if ($Suffixnum==3) {echo "rd";} 
if (($Suffixnum>3) || ($Suffixnum==0)) {echo "th";} 
echo "&nbsp;</td><td width=5% align=right>".number_format($Depth[$i0]*100.0/$DepthSum,1)."%&nbsp;</td><td>";
if ($Depth[$i0]>0)
{
?>
<table height=<?php echo $BarHeight; ?> cellspacing=0 cellpadding=0 style="border: 0px;">
<tr>
<td bgcolor=<?php echo $ColorStr[$i0]; ?>><img border=0 height=<?php echo $BarHeight; ?> 
width=<?php echo $BarSize; ?> src=shim.gif alt="<?php echo $CharStr; ?>"></td>
</tr>
</table>
<?php 
}
else
{ echo "&nbsp;"; } 
echo "</td></tr>"; 
}
} 
?>
</table>
</p>

Esta gráfica muestra cuánto contribuyen las preferencias mas bajas a las opciones ganadoras.

<br><br><br>

<?php 
} //table or chart
}
else
{
//no votes
PrintTitle();
if ($NoRunningTally)
{
echo "<p><hr><p><center>Results are not available until polling is over on ";
echo date("F d, Y",$ExpireTime).".</center>";
}
else
{ echo "<p><p><center>Ningún voto se he emitido aún.</center>"; }
?>   <?php
} 
?>
<p>
                   
                   
                   <!--Final-->
        
  
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
   
  </body>
</html>