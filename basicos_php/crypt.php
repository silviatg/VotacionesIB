<?php
function desencriptar ($string, $key) { 
	$result = ''; 
	$string = str_replace(array('-', '_'), array('+', '/'), $string);
	$string = base64_decode ($string); 
		for ($i=0; $i<strlen ($string); $i++) { 
			$char = substr ($string, $i, 1); 
			$keychar = substr ($key, ($i % strlen ($key))-1, 1); 
			$char = chr (ord ($char)-ord ($keychar)); 
			$result.=$char; 
		} 
	return $result; 
}

function encriptar ($string, $key) { 
	$result = ''; 
	for ($i=0; $i<strlen ($string); $i++) { 
		$char = substr ($string, $i, 1); 
		$keychar = substr ($key, ($i % strlen ($key))-1, 1); 
		$char = chr (ord ($char)+ord ($keychar)); 
		$result.=$char; 
	} 
	return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode ($result)); 
}
?>