<?php 
//DemoChoice: A preference voting package for the web (C) 2001 Dave Robinson
//Tally file loader
//Note: this will choke if there are > 200 candidates because the fgets call will
// truncate the array.  Just change the limit if this is a problem.



$TotalVotes=0;
$IncVotes=0;
$Thresh=0;
$Rnds=0;
for ($i=0; $i<$Cands; $i++) { $Elim[$i]=0; } 

function ParseTaggedLine(&$Entry)
{
 global $Cands;
 $Pipe=(strpos($Entry,"|") ? strpos($Entry,"|")+1 : 1);
 for ($i1=0; $i1<=$Cands; $i1++)
 {
  if ($Pipe>0)
  {
   $ArrayOut[$i1]=1.0*substr($Entry,0,$Pipe-1);
   $Entry=substr($Entry,$Pipe+1-1);
   $Pipe=(strpos($Entry,"|") ? strpos($Entry,"|")+1 : 1);
  } 
 }
 return $ArrayOut; 
}



/*echo "x $Ballotname";
 echo "$FilePath";
*/
//Read #ballots, Threshold, Vote Matrix, Transfer Matrix and Status



$fp=fopen($FilePath.$Pollname."_tally.txt",'r');
$Pipe=0;
while(!feof($fp))
{
 $Entry=fgets($fp,3000);
 if (!(($Pipe=strpos($Entry,"|"))===false))
 {
  $Tag=trim(substr($Entry,0,$Pipe));
  $Entry=substr($Entry,$Pipe+1);
  if ($Tag=="Ballots") { $TotalVotes=1.0*$Entry; } 
  if ($Tag=="IncVotes") { $IncVotes=1.0*$Entry; } 
  if ($Tag=="Threshold")
  {
   $Pipe=(strpos($Entry,"|") ? strpos($Entry,"|")+1 : 1);
   $Thresh=1.0*substr($Entry,0,$Pipe-1);
  } 
  if ($Tag=="Transfer")
  {
   $Rnds++;
   $XferMatrix[$Rnds-1]=ParseTaggedLine($Entry);
  } 
  if ($Tag=="Tally")
  {
   $VoteMatrix[$Rnds-1]=ParseTaggedLine($Entry);
   $Elim[$Rnds-1]=1.0*$Entry;
  } 
  if ($Tag=="Status") { $Status=ParseTaggedLine($Entry); } 
  if ($Tag=="Depth") { $Depth=ParseTaggedLine($Entry); }
  if ($Tag=="RankCt") { $RankCt=ParseTaggedLine($Entry); }
 } 
//Tag exists
} 

fclose($fp);
?>
