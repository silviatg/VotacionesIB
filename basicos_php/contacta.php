
<div class="modal fade" id="contacta">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                        <a class="close" data-dismiss="modal" >x</a>
                            <!--    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                               <h4 class="modal-title">Contactar</h4>
                        </div>
                        
              <div class="modal-body">
				<p> Si quieres contactar, completa este formulario y en breve te contestaremos</p>
                <p> Asegurate de que escribes bien tu direcci&oacute;n de correo </p> 
				
                 <form name="enviaMessage" class="well" id="formularioContacto" >
	       <!--<legend>Contact me</legend>-->
		 <div class="control-group">
                    <div class="controls">
			<label for="nombre2" class="col-sm-4 control-label">Nombre y Apellidos:</label>
			<input type="text" class="form-control" placeholder="Su nombre" id="nombre2" required data-validation-required-message="Por favor, indique su nombre y apellidos" />
			  <p class="help-block"></p>
		   </div>
	         </div> 	
                <div class="control-group">
                  <div class="controls">
			<label for="email2" class="col-sm-4 control-label">Correo electr&oacute;nico:</label>
			<input type="email" class="form-control" placeholder="Su correo electr&oacute;nico" id="email2" required  data-validation-required-message="Por favor, indique su correo electr&oacute;nico" />
		</div>
	    </div> 	
		
				<!-- ============  STG: Añadimos móvil y NIF  ============ -->
		<div class="control-group">
            <div class="controls">
				<label for="nif2" class="col-sm-4 control-label">NIF:</label>
				<input type="text" class="form-control" placeholder="Su NIF/NIE" id="nif2" maxlength=9 minlength=9 required data-validation-minlength-message="Indique las 9 cifras y letras de su NIF/NIE seguidas (sin guiones ni espacios)" data-validation-required-message="Por favor, indique su NIF/NIE"/>
			</div>
	    </div>
		 <div class="control-group">
            <div class="controls">
				<label for="tfno2" class="col-sm-4 control-label">M&oacute;vil:</label>
				<input type="number" class="form-control" placeholder="Su tel&eacute;fono m&oacute;vil" id="tfno2" maxlength=9 minlength=9 required data-validation-minlength-message="Indique las 9 cifras seguidas (sin espacios) de su tel&eacute;fono m&oacute;vil" data-validation-number-message="Indique las 9 cifras seguidas (sin espacios) de su tel&eacute;fono m&oacute;vil" data-validation-required-message="Por favor, indique su tel&eacute;fono m&oacute;vil"/>
			</div>
	    </div> 
		<div class="alert alert-danger">                          
					Aseg&uacute;rese de <b>introducir sus datos corr&eacute;ctamente</b>, o no podr&aacute; realizar su votaci&oacute;n por internet.<br>
			</div>
		<!-- ============================== -->		
        
          <div class="control-group">
                <span class="help-block">Soy de la provincia:</span>
                          
                    
	  <div class="form-group">
                    <select class="form-control"  name="provincia2" id="provincia2" >
                     <!-- <option value=""> Escoje una provincia</option>-->
         				 <?php echo "$lista";?>
                    </select>
                 </div>
                                
                
               </div> 		 
        
        
		<div class="control-group">
                 <div class="controls">
				 <textarea rows="10" cols="100" class="form-control" 
                       placeholder="Cuentanos el problema" id="texto" required
		       data-validation-required-message="Cuentanos el problema" minlength="5" 
                       data-validation-minlength-message="Min 5 characteres" 
                        maxlength="999" style="resize:none"></textarea>
		</div>
               </div> 
               	 
	     <div id="success2"> </div> <!-- mensajes -->
	    <button type="submit" class="btn btn-primary pull-right">Enviar</button><br />
          </form>
                
                
			</div>
            
			
             
             </div>
        </div>
</div>