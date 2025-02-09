// JavaScript Document
/*
  Jquery Validation using jqBootstrapValidation
   example is taken from jqBootstrapValidation docs 
  */
 // $('#contenido').on('submit','#formulario',function(event){ 
$(function() {
	$("#contactForm").find("input,hidden").jqBootstrapValidation(  // este seria con un formulario con class="form-horizontal"
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
       var name = $("input#name").val();  
       var pass = $("input#pass").val(); 
       var pass2 = $("input#pass2").val();
	    var email = $("input#email").val();
		var nif = $("input#nif").val(); //STG
		var tfno = $("input#tfno").val(); //STG
		var idrec = $("#idrec").val();
		var npdr = $("#npdr").val();
        var firstName = name; // For Success/Failure Message
           // Check for white space in name for Success/Fail message
        if (firstName.indexOf(' ') >= 0) {
	   firstName = name.split(' ').slice(0, -1).join(' ');
         }        
	 $.ajax({
                url: "basicos_php/procesar_rec_contr.php",
            	type: "POST",
            	data: {name: name, email: email, pass: pass, pass2: pass2,npdr:npdr,idrec:idrec,nif:nif,tfno:tfno},
            	cache: false,
            	success: function(data) {  

            	   $('#success').html(" " + data +" ");
				   //$('#caja_contrasena').hide("slow"); //STG: NO oculto todos los campos, para ver los datos introducidos.
				   //clear all fields
 		 		   //$('#contactForm').trigger("reset"); //STG: NO reseteo todos los campos, para ver los datos introducidos.
				  
 	      		  },
 	  	 		error: function() {		
 				// Fail message
 		 			$('#success').html("<div class='alert alert-danger'>");
            		$('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            	      .append( "</button>");
            		$('#success > .alert-danger').append("<strong>Sorry "+firstName+" ¡uppps! el servidor no está respondiendo...</strong> Inténtelo más tarde. ¡Perdone por las molestias!");
 	       		     $('#success > .alert-danger').append('</div>');
					//clear all fields
 					//$('#contactForm').trigger("reset"); //STG: NO reseteo todos los campos, para ver los datos introducidos.
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