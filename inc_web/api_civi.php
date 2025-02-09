<?php 

//$apikey="1511a13b203cb3986c19000ea6801aa9";  //dato de mi instalacion local
$apikey="648f9d38e9845ee068afcedeb1fa9e1f";
$contactxml = simplexml_load_file("https://pruebas.partidoequo.es/civicrm/sites/all/modules/civicrm/extern/rest.php?entity=contact&action=get&key=EQ_csalgadow245ac4&api_key=$apikey&email=4rlosalonsos@gmail.com&return=contact_type,country,city");
foreach ($contactxml->children() as $contact) 
{
	    $display = $contact->display_name;
}

echo $display ;


//localhost/CIVICRM_drupal-7.23/civicrm/ajax/rest?json=1&debug=on&entity=contact&action=get&email=csyuei@gsye.es&return=display_name,email,phone


/* 
$contactxml = simplexml_load_file("https://<your site>/sites/all/modules/civicrm/extern/rest.php?entity=contact&action=get&key=<site key>&api_key=$apikey&last_name=Koot");
foreach ($contactxml->children() as $contact) 
{
	    $display = $contact->display_name;
}

 */
?>