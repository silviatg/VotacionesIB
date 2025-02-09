// JavaScript Document
/*
  Jquery Validation using jqBootstrapValidation
   example is taken from jqBootstrapValidation docs 
  */
 // $('#contenido').on('submit','#formulario',function(event){ 
$(function() {
 $("#formularioContacto").find("input,select,textarea").jqBootstrapValidation(  // este seria con un formulario con class="form-horizontal"
 //$("input#name,input#email,select#provincia").jqBootstrapValidation(  //  ver que ese texarea sera un select
    {
     preventSubmit: true,
     submitError: function($form, event, errors) {
      // something to have when submit produces an error ?
      // Not decided if I need it yet
     },
     submitSuccess: function($form, event) {
      event.preventDefault(); // prevent default submit behaviour
       // get values from FORM
       var name = $("input#nombre2").val();  
       var email = $("input#email2").val(); 
       var provincia = $("select#provincia2").val();
	   var nif = $("input#nif2").val(); //STG: Nuevo
	   var tfno = $("input#tfno2").val(); //STG: Nuevo
	    var texto = $("textarea#texto").val();
        var firstName = name; // For Success/Failure Message
           // Check for white space in name for Success/Fail message
        if (firstName.indexOf(' ') >= 0) {
	   firstName = name.split(' ').slice(0, -1).join(' ');
         }        
	 $.ajax({
                url: "basicos_php/procesar_contactar.php",
            	type: "POST",
            	data: {name: name, email: email, provincia: provincia, texto: texto, nif: nif, tfno: tfno},
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
 		 		   $('#formularioContacto').trigger("reset");
 	      		  },
 	  	 		error: function() {		
 				// Fail message
 		 			$('#success2').html("<div class='alert alert-danger'>");
            		$('#success2 > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            	      .append( "</button>");
            		$('#success2 > .alert-danger').append("<strong>Sorry "+firstName+" uppps! el servidor no esta respondiendo...</strong> Intetelo despues. Perdone por las molestias!");
 	       		    $('#success2 > .alert-danger').append('</div>');
 		//clear all fields
 					$('#contactForm').trigger("reset");
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
     $('#success').html('');
  });
  