// JavaScript Document
/*
  Jquery Validation using jqBootstrapValidation
   example is taken from jqBootstrapValidation docs 
  */
 // $('#contenido').on('submit','#formulario',function(event){ 
$(function() { 
 $("#formulario_Contacto").find("input,radio,textarea,hidden").jqBootstrapValidation(  // este seria con un formulario con class="form-horizontal"
 //$("input#name,input#email,select#provincia").jqBootstrapValidation(  //  ver que ese texarea sera un select

    {
		
     preventSubmit: true,
     submitError: function($form, event, errors) {
		// alert("alerta 1");
      // something to have when submit produces an error ?
      // Not decided if I need it yet
     },
     submitSuccess: function($form, event) {
		 var name = $("#nombre2").val();  
       var email = $("#email2").val(); 
       var provincia = $("#provincia2").val();
	   
      event.preventDefault(); // prevent default submit behaviour
       // get values from FORM
      // var name = $("hidden#nombre2").val();  
      // var email = $("hidden#email2").val(); 
       //var provincia = $("hidden#provincia2").val();
	   var asunto = $("input#asunto").val(); 
	   var contacto_0 = $("#contacto_0").val(); 
	     var contacto_1 = $("#contacto_1").val();
	    var texto = $("textarea#texto").val();
    
		//alert("Hello! I am an alert box!!");
           // Check for white space in name for Success/Fail message
              
	 $.ajax({
		 
		 
                url: "../basicos_php/procesar_contacta_error.php",
            	type: "POST",
            	data: {name: name, email: email, provincia: provincia, texto: texto, asunto: asunto, contacto_0: contacto_0, contacto_1: contacto_1},
            	cache: false,
            	success: function(data) {  
            	// Success message
            	   $('#success2').html(" " + data +" ");
            	   //$('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
//            		.append( "</button>");
//            	   $('#success > .alert-success')
//            		.append("<strong>Le hemos enviado un correo electronico con instrucciones para finalizar el proceso." + data +"  </strong>");
// 		  		   $('#success > .alert-success')
// 					.append('</div>');
 						    
 		 			 //clear all fields
 		 		   $('#formulario_Contacto').trigger("reset");
 	      		  },
 	  	 		error: function() {		
 				// Fail message
 		 			$('#success2').html("<div class='alert alert-danger'>");
            		$('#success2 > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            	      .append( "</button>");
            		$('#success2 > .alert-danger').append("<strong>Sorry "+firstName+" uppps! el servidor no esta respondiendo...</strong> Intetelo despues. Perdone por las molestias!");
 	       		    $('#success2 > .alert-danger').append('</div>');
 		//clear all fields
 					$('#formularioContacto').trigger("reset");
 	   			 },
             })
         },
         filter: function() {
                   return $(this).is(":visible");
         },
       });

      $("a[data-toggle=\"tab\"]").click(function(e) {
                    e.preventDefault();
                    $(this).tab("show");
        });
  });
 

/*When clicking on Full hide fail/success boxes */ 
$('#name').focus(function() {
     $('#success2').html('');
  });