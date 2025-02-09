		<!--
===========================  Texto ayuda
-->
<div class="modal fade" id="ayuda">
        <div class="modal-dialog">
                <div class="modal-content">
                        
                        
              <div class="modal-body">   </div>  
         </div>
     </div>
</div>
   <!--
===========================  fin texto ayuda
-->

<?php if($_SESSION['nivel_usu']!="1"){	//Si es administrador, podra ver el menu de admin ?>

<!-- Modal -->
<div class="modal fade" id="ayuda_admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           
            <div class="modal-body"></div>
            
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->


<?php }?>

  <!--
===========================  ayuda para contactar
-->
<div class="modal fade" id="ayuda_contacta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           
            <div class="modal-body"></div>
            
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

 <!--
===========================  FIN ayuda para contactar
-->
