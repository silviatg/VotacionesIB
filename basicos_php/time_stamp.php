<?php
if (@eregi("time_stamp.php", $_SERVER['SCRIPT_NAME'])) {
    Header("Location: ../index.php"); die();
}

function time_stamp($session_time) //Tiempo transcurrido
{ 
	$time_difference = time() - $session_time ; 
	$seconds = $time_difference ; 
	$minutes = round($time_difference / 60 );
	$hours = round($time_difference / 3600 ); 
	$days = round($time_difference / 86400 ); 
	$weeks = round($time_difference / 604800 ); 
	$months = round($time_difference / 2419200 ); 
	$years = round($time_difference / 29030400 ); 

	if($seconds <= 60)
	{
		echo"Hace $seconds segundos"; 
	}
	else if($minutes <=60)
		{
   		if($minutes==1)
   		{
     		echo"Hace un minuto"; 
   		}
   		else
   		{
   		echo"Hace $minutes minutos"; 
   		}
	}
	else if($hours <=24)
	{
  		if($hours==1)
   		{
   			echo"Hace una hora";
   			}
 			else
  			{
  			echo"Hace $hours horas";
  			}
		}
		else if($days <=7)
		{
  			if($days==1)
   			{
   				echo"Hace un d&iacutea";
   			}
  			else
  			{
 			 echo"Hace $days d&iacuteas";
  			}
	}
	else if($weeks <=4)
	{
  		if($weeks==1)
   		{
   			echo"Hace una semana";
   		}
  		else
  		{
  			echo"Hace $weeks semanas";
  		}
 	}
	else if($months <=12)
	{
   		if($months==1)
   		{
   			echo"Hace un mes";
   		}
  		else
  		{
  			echo"Hace $months meses";
  		} 
	}
	else
	{
		if($years==1)
   		{
   			echo"Hace un a&ntildeo";
   		}
  		else
  		{
  		echo"Hace $years a&ntildeos";
  		}
	}
 } 
 ?>