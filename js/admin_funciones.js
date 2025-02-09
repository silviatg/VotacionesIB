
// JavaScript Document

function habilita_estatal(){
  document.getElementById('autonomico').style.display='none';
  document.getElementById('provincial').style.display='none';
  document.getElementById('local').style.display='none';  
  document.getElementById('g_trabajo').style.display='none';  	
  document.getElementById('g_trabajo_general').style.display='none';	
  document.getElementById('g_municipal').style.display='none'; 
}

function habilita_autonomico(){
  document.getElementById('autonomico').style.display='block';
  document.getElementById('provincial').style.display='none';
  document.getElementById('local').style.display='none';  
  document.getElementById('g_trabajo').style.display='none';  	
  document.getElementById('g_trabajo_general').style.display='none';	
  document.getElementById('g_municipal').style.display='none'; 
}

function habilita_provincial(){
  document.getElementById('autonomico').style.display='none';
  document.getElementById('provincial').style.display='block';
  document.getElementById('local').style.display='none';  
  document.getElementById('g_trabajo').style.display='none';  	
  document.getElementById('g_trabajo_general').style.display='none';	
  document.getElementById('g_municipal').style.display='none'; 
}

function habilita_local(){
  document.getElementById('autonomico').style.display='none';
  document.getElementById('provincial').style.display='none';
  document.getElementById('local').style.display='block';  
  document.getElementById('g_trabajo').style.display='none';  	
  document.getElementById('g_trabajo_general').style.display='none';	
  document.getElementById('g_municipal').style.display='none'; 
}
function habilita_g_trabajo(){
  document.getElementById('autonomico').style.display='none';
  document.getElementById('provincial').style.display='none';
  document.getElementById('local').style.display='none';  
  document.getElementById('g_trabajo').style.display='block'; 	
  document.getElementById('g_trabajo_general').style.display='none';
  document.getElementById('g_municipal').style.display='none'; 
}
function habilita_g_trabajo_general(){
  document.getElementById('autonomico').style.display='none';
  document.getElementById('provincial').style.display='none';
  document.getElementById('local').style.display='none'; 
  document.getElementById('g_trabajo').style.display='none';
  document.getElementById('g_trabajo_general').style.display='block'; 	
  document.getElementById('g_municipal').style.display='none'; 
}
function habilita_municipal(){
  document.getElementById('autonomico').style.display='none';
  document.getElementById('provincial').style.display='none';
  document.getElementById('local').style.display='none'; 
  document.getElementById('g_trabajo').style.display='none';
  document.getElementById('g_trabajo_general').style.display='none'; 
  document.getElementById('g_municipal').style.display='block'; 		
}

////////////////////////////////////////////
function quita_opciones(){
  document.getElementById('accion_opciones').style.display='none';
  document.getElementById('recuento').style.display='none';
}
function pon_opciones(){

  document.getElementById('accion_opciones').style.display='block'; 
  document.getElementById('recuento').style.display='none';	
}
function pon_opciones1(){

  document.getElementById('accion_opciones').style.display='block';
  document.getElementById('recuento').style.display='block'; 	
}

////////////////////////////////////////////

