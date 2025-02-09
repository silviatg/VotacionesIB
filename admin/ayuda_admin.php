<?php
###############################################################################################################################################################
###############################################################################################################################################################
###                                                                                                                                                         ###
###                                                         DEMOKRATIAN versión 2.01                                                                        ###
###                                                         http://demokratian.org                                                                          ###
###                                    Copyright (C) 2014 CARLOS SALGADO WERNER (http://carlos-salgado.es)                                                  ###
###                                         Este programa ha sido creado por Carlos Salgado Werner                                                          ###
###                                                                                                                                                         ###
### Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia Pública General de GNU según es publicada por la ###
### Free Software Foundation, bien de la versión 2 de dicha Licencia o bien de cualquier versión posterior.                                                 ###
### Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin la garantía MERCANTIL implícita o sin garantizar   ###
### la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la Licencia Pública General de GNU para más detalles.                                               ###
### Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así, puede encontrarla en                        ###
### http://www.gnu.org/licenses/gpl-3.0.html                                                                                                                ###
### Si quieres participar en la mejora de este software ,eres libre de hacerlo,                                                                             ###
### También puedes contactar con migo en el correo info@demokratian.org para trabajar en el desarrollo de forma colaborativa                                ###
###                                                                                                                                                         ###
###                                          Por favor, no elimines este aviso de licencia                                                                  ###
###                                                                                                                                                         ###
###############################################################################################################################################################
###############################################################################################################################################################
require_once("../inc_web/config.inc.php");?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Ayuda</title>  
</head>
<body>
  
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" >x</a>
                            <!--    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                               <h4 class="modal-title">Ayuda a la administración de la plataforma de votaciones</h4>
                 
            </div>            <!-- /modal-header -->
            <div class="modal-body">
             <h4>Introducción</h4>
  <p>Administradores</p>
  <ul>
    <li>Tipos de administradores</li>
    <li>Como gestionar los administradores</li>
    <li>Votaciones por usuario</li>
  </ul>
  <p>Las votaciones</p>
  <ul>
    <li>Como crear una votación</li>
    <ul>
      <li>Tipos de votaciones, Primarias ,VUT, Encuesta, Debate.</li>
      <li>Control-verificación (comprobación de voto e  interventores)</li>
    </ul>
    <li>Gestión/modificación de votaciones</li>
    <li> Gestión de  candidatos/ opciones.</li>
    <li> Buscador de  candidatos / opciones</li>
    <li> Resultados /  censos por votación</li>
  </ul>
  <p>Cómo gestionamos los usuarios.</p>
  <ul>
    <li>Buscar/modificar votantes</li>
    <li>Incluir un votante.</li>
    <li>Añadir votantes de forma masiva.</li>
    <li>Bloquear / desbloquear votantes</li>
    <li>Bajas de votantes de forma masiva</li>
   </ul>   
    <p>Qué son las asambleas y cómo se gestionan</p>
  
  <ul>
    <li> Crear asambleas</li>
    <li>Modificar Asambleas</li>
    <li>Gestionar usuarios.</li>
  </ul>
  <p> <br />
    Que votaciones tengo yo</p>
  <p>Notificaciones por correo</p>
  <p align="right"><strong>Por: Carlos Salgado </strong></p>
  <p><strong><u>Introducción</u></strong></p>
  <p>El  sistema de votaciones tiene dos zonas diferenciadas de actuación, una como  usuario, y otra como administrador.<br />
    A la  hora de diseñar la aplicación, se ha realizado pensando fundamentalmente en</p>
  <ul>
    <li>Una  fácil gestión de votantes en la que se pueda tramitar por parte del  administrador los censos de votantes y que además puedan votar, en función del  tipo de votación,, afiliados, simpatizantes verificados y simpatizantes</li>
    <li>Que  se puedan realizar varios tipos de votación</li>
    <li>Posibilidad  de múltiples tipos de circunscripciones</li>
    <li>No  trazabilidad del voto</li>
  </ul>
  <p>Si eres  administrador podrás ver un menú en la parte superior de la web, este menú se  distingue fácilmente ya que es de color negro.<br />
    El menú  del lateral izquierdo es como el de cualquier otro usuario, y mediante el  podrás ejercer tus derecho a voto y  participar como un usuario mas.<br />
    Existen  varios niveles de administrador y en función de estos niveles podremos realizar  unas acciones u otras</p>
  <p><strong><u>Tipos de administradores</u></strong></p>
  <p>Existen  los siguientes tipos de administradores </p>
  <ul>
    <li>Administrador</li>
    <li>Admin  CCAA</li>
    <li>Admin  Provincia</li>
    <li>Admin  Grupo Provincial</li>
    <li>Admin  Grupo Estatal</li>
  </ul>
  <p> <br />
    El sistema funciona como un sistema de cascada , de  forma que el usuario mas alto tiene permisos para su administración, así como  las de los niveles inferiores, de forma que los administradores estatales  podrán crear cualquier tipo de votación, los autonómicos, de su CCAA ,  votaciones las provincias de su CCAA, de los grupos provinciales. Tan solo se  sale de esta norma la administración de Grupos Estatales que sólo tendrán  acceso a ella , además de ese perfil, el perfil del administrador general.</p>
  <p>Además de estos niveles, tenemos un segundo grupo de  niveles &ldquo;numéricos&rdquo; que se cada administrador tendrá asignado y que permiten  según se tenga uno u otro asignado.:</p>
  <ul>
    <li>7  - Nivel minimo para poder añadir imágenes (no operativo aun) </li>
    <li>5  - Permite crear grupos locales </li>
    <li>2  - Permite crear administradores locales y modificar direccion de notificación  de correo </li>
    <li>1  - Permite modificar censos </li>
    <li>0  - Todos los permisos, incluido crear administradores generales </li>
  </ul>
  <p>nota<a href="#_ftn1" name="_ftnref1" title="" id="_ftnref1"> </a></p>
  <p>Los administradores de grupos sólo podrán  tener niveles superiores al 6.<br />
    De la misma forma que en el caso anterior, un  administrador tendra asignado los permisos de su número, así como los permisos  de todos los números superiores.</p>
  <p><strong><u>Como  gestionar los administradores</u></strong></p>
  <p>Si su usuario   tiene asignados permisos para gestionar   y crear administradores, en el menú de administración le aparecerá la  opción &ldquo;gestión administración&rdquo; y dentro del desplegable esta la opción  &ldquo;gestión usuarios administración&rdquo;. Al pinchar esta opcion le aparecerá una  pantalla en la que por motivos de seguridad, deberá volver a poner su usuario y  su clave de acceso. Al hacer click en entrar, accedera a un buscador que le  permitirá buscar al usuario al que quiere dar los permisos. El buscador nos  presentara un listado de usuario que se ajustan al criterio de búsqueda, en  cada usuario vemos varias opciones.</p>
  <p>
  
  <img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/Captura1.JPG" alt="002" width="650" height="297" /></p>
  <p>En el lado de la izquierda veremos una imagen como  de una ficha (1), al pinchar se nos abrirá una ventana con todos los  datos del usuario<br />
    Si el usuario es un administrador provincial, o de  grupo. tendremos en color morado una opcion que dice &ldquo;asignar….&rdquo;(2)  , al pinchar sobre el, se nos abrira una ventana que nos permitirá asignar  provincias y/o grupos en función del tipo de administrador que sea.<br />
    <img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/Captura2.JPG" alt="004" width="651" height="511" align="left" hspace="12" vspace="12" /><br />
    La ultima opción , en verde, (3)  nos da acceso a la pantalla para modificar el tipo de usuario y asignarle  tareas administrativas. Esta misma pantalla nos permitiria quitarle los  permisos a un administrador y convertirlo en votante.</p>
  <p><img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/captura3.png" alt="006" width="647" height="385" align="left" hspace="12" vspace="12" /><br />
    Asignele los permisos que le correspondan, (Si lo  desea puede hacer que el sistema notifique por correo los cambios al  usuario)  y haga click en actualizar. <br />
    Si el tipo de administrador que ha cogido es  provincial y/o de grupo, le aparecerá un mensaje en morado en la parte superior  para, si lo desea, asignarle provincias de su CCAA o grupos </p>
  <div id="ftn1">
    <h6><a href="#_ftnref1" name="_ftn1" title="" id="_ftn1"> </a> Los números que faltan se irán asignando en futuros  desarrollos según necesidades</h6>
  </div>
  <p><strong><u>Votaciones  por usuario</u></strong></p>
  <p>Para facilitar el control de administradores y de la  aplicación , si tiene permisos de super administrador, nivel &ldquo;0&rdquo;  en la pestaña de &ldquo;gestion de la administracion&rdquo;  le aparecera otra opcion, &ldquo;votaciones por usuario&rdquo; que le permitirá buscar  usuarios y acceder directamente a la gestión de sus votaciones. </p>
  <p><img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/Captura4.JPG" alt="008" width="624" height="144" /></p>
  <p>Existe también la posibilidad de realizar esta  gestión de todas las votaciones de su nivel de autorización mediante las  opciones &ldquo;gestión general de votaciones&rdquo; que se detalla <a href="#id.5ns8gpsn8gji">en otro  punto</a></p>
  <p><strong><u>Como  crear una votación </u></strong></p>
  <p>Crear una nueva votación es extremadamente fácil, en  el menú de administración , en el desplegable que aparece en la opción &ldquo;gestión  general de votaciones&rdquo;, la primera opción que le aparece es &ldquo;crear una  votación&rdquo;.<br />
    Al acceder le aparecerán una serie de opciones.</p>
  <ul>
    <li>Nombre de la  votación.Aquí, como su título indica, pondremos el nombre e la votación</li>
    <li> Demarcación;   ¡¡ATENCION!!  Este grupo de opciones variará según el nivel de administrador que tenga. Podrá elegir la zona o grupo en el que quiere crear  la votación. <strong> </strong>En función de la demarcación escogida, le aparecerá  un desplegable (salvo en demarcación estatal) donde podrá elegir la CCAA (si  tiene permisos para actuar en más de una), o provincias o grupos que tengan  asignados.Tenga en cuenta que en función de esta elección podrán votar unos  usuarios u otros  <img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/Captura5.JPG" alt="010" width="691" height="159" align="left" hspace="12" vspace="12" /><img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/Captura6.JPG" alt="012" width="248" height="193" align="left" hspace="12" vspace="12" /></li>
  </ul>
  <p><img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/Captura7.JPG" alt="014" width="413" height="164" align="left" hspace="12" vspace="12" /></p>
  <ul>
    <li>Fecha de inicio /  fecha final .Corresponde a las fechas entre las cuales el usuario podrá votar.  La votación se activará o desactivará automáticamente entre estas fechas.</li>
    <li>Tipo de votación. Este grupo de opciones no podrá  modificarse una vez creada la votación. Tenemos las siguientes opciones:  Primarias , VUT, Encuesta, Debate:</li>
  </ul>
  <ul>
    <ul>
      <li><strong>Primarias</strong> se podrá elegir las opciones   más votadas de una lista por cómputo  ponderado. El votante podrá ordenar una lista de opciones donde en función del  orden, el primero tendrá 1 punto, el segundo 0.5 el tercero 0.25 y  sucesivamente.</li>
      <li><strong>VUT </strong>(voto único transferible), sistema de recuento sobre  el que se puede encontrar información aquí, por ejemplo: <a href="http://equomunidad.org/es/el-voto-unico-transferible-%E2%80%93-un-sistema-electoral-para-equo">http://equomunidad.org/es/el-voto-unico-transferible-%E2%80%93-un-sistema-electoral-para-equo</a>)</li>
      <li><strong>Encuesta;</strong> permite elegir una opción -o más entre, varias. es un voto que no tiene ningún  tipo de ponderación.</li>
      <li><strong>El debate</strong>: Se trata un nuevo tipo de opción incluida en esta  nueva versión. , ahora se podrá abrir un DEBATE. Este nuevo tipo permite mandar  comentarios y debatir sobre un tema y si se necesita, votar una o varias  preguntas y este voto variarlo a medida que transcurre el debate si cambiamos  de opinión. Este sistema no asegura la no trazabilidad del voto, es decir, si  alguien accede a la bbdd podría llegar a ver que ha votado quien y tampoco  tiene el sistema de envío de correos a interventores.</li>
    </ul>
  </ul>
  <ul>
    <li>En &ldquo;Tipo de  votante&rdquo;, se seleccionan los votantes que pueden participar en esta elección:  &ldquo;Solo socios&rdquo; (en realidad debería decir afiliados, para no confundir con los  socios de la Fundación que, a efectos de votaciones, son simpatizantes),  &ldquo;Socios y simpatizantes verificados&rdquo; &ldquo;Socios y simpatizantes (verificados y no  verificados&rdquo; y  &ldquo;Abierta&rdquo;. Esta ultima  opcion no esta aun disponible y se implementará en futuras versiones.</li>
    <li>Estado Nos  permite dos opciones Activado - Desactivado e indica si la votación esta  &ldquo;visible&rdquo; para los votantes o no. ¡¡OJO!! esta opción &ldquo;puede&rdquo; a la fecha, de  tal forma que si esta desactivada, aunque este en fecha de votación no se verá,  y por tanto no se podrá votar.</li>
    <li>Seguridad de  control de voto. Se trata de un sistema de <strong>control-verificacion</strong> de lo votado. El sistema  sigue  manteniendo la casi imposible   trazabilidad del voto, es decir, el voto es secreto y aunque alguien  accediera a la base de datos seria muy difícil   conocer que ha votado quien.(imposible   decir &ldquo;imposible&rdquo;,  ya que hay  cracks que consigue hasta entrar en los bancos…. ).  tenemos las siguientes opciones. Estas  opciones no estaran disponibles si escoge una votacion tipo debate.</li>
    <ul>
      <li><strong>Sin trazabilidad ni interventores</strong> No activa ningn metodo.</li>
      <li><strong>Comprobación de voto </strong> (no funciona  en VUT). El sistema permite a los usuarios ver que se mantiene su voto en la  base de datos tal cual lo han emitido, este sistema no funciona con voto VUT  que se implementara más tarde.</li>
      <li><strong>Con interventores.</strong> El  sistema realiza el envío de  un correo anónimo con cada voto a los interventores que se designen, de esta  forma en caso de duda podrían recontar los votos, sería como tener una versión  voto en papel que tendrían varios interventores. IMPORTANTE Si se activa esta  opción tendrá, una vez creada la votación, que asignar los interventores.</li>
      <li><strong>Con comprobación de voto e interventores </strong>(no funciona en VUT) :Activaria ambas opciones.</li>
    </ul>
  </ul>
  <ul>
    <li>Numero de  opciones que se pueden votar. Indica el numero de opciones que se pueden votar  y debe de hacerse mediante un valor numérico. Si no hay limite ponga un  &quot;0&quot; .</li>
    <li>Resumen. Espacio  para incluir un pequeño resumen de lo que trata la votación. El votante lo  vera al principio de la página de la  votación, y en el desplegable del cuadro de votaciones. Se ha activado un  editor  WYSIWYG para que se pueda dar  formato a los textos, incluir imagenes, etc</li>
    <li>Texto Espacio  para incluir un texto sobre la votación, explicaciones, etc. El votante lo  vera al final de la página de la votación. Se  ha activado un editor  WYSIWYG para que  se pueda dar formato a los textos, incluir imágenes, etc</li>
  </ul>
  <p>Una vez que haya completado la información podrá  presionar el botón de crear una nueva votación, y su votación será creada. Al  crear la votación, en la parte superior de la página le aparecerá un mensaje si  la votación ha sido creada, así como una invitación mediante un enlace en color  morado que le indicara que para concluir la votación  puede en ese momento añadir los candidatos u  opciones de la votación (1). En caso de que haya elegido el sistema de  comprobación del voto mediante interventores, le aparecerá otro enlace  invitandole a incluir a los interventores de esa votación (2).  <img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/Captura8.JPG" alt="016" width="646" height="157" border="0" />En  caso de que decidiera no hacerlo en este momento, tanto los candidatos-opciones  , como los interventores podrán ser incluidos posteriormente (ver  incluir/modificar candidatos-opciones o incluir/modificar interventores) </p>
  <p><strong><u>Como realizar gestión general de votaciones</u></strong><img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/Captura9.JPG" alt="018" width="235" height="251" align="left" hspace="12" vspace="12" /></p>
  <p>En el desplegable del menú, en &ldquo;gestion general de  censos&rdquo; tenemos ademas de la opción para crear una nueva votación tenemos otras  opciones que nos permitirán realizar una gestión completa de las votaciones.  Todas estas opciones nos llevan a un buscador que nos permitirá buscar las  votación que queramos y el listado nos facilitará las opciones </p>
  <ul>
    <li><strong>Gestion/modificación de votaciones.</strong> Nos permitirá realizar las gestiones de  modificación de las votaciones, cambiar textos, modificar número de opciones a  votar, etc. Desde esta opción , también podremos activar o desactivar la  votación, activar o desactivar los resultados o borrar una votación. Laúltima  posibilidad que tenemos , es la de añadir/gestionar  interventores si es una votación que lo  requiera .<img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/Captura10.JPG" alt="020" width="650" height="146" border="0" /></li>
    <li><strong>Gestión de candidatos/ opciones.</strong> Desde esta opcion podremos acceder a los  candidatos/opciones  por votación para  modificarlos o borrarlos, además podremos crear un nuevo candidato u opción. </li>
    <li><strong>Buscador de candidatos / opciones</strong>. Nos permite acceder a un buscador de  candidatos/opciones</li>
    <li><strong>Resultados / censos por votación.</strong> Esta opción nos permite acceder al censo de los que  pueden votar en cada votación en concreto, Nos permite ver el censo completo,  quienes han votado ya, y quienes faltan por votar, de esta forma, si una  votación tiene la posibilidad de votar también presencialmente, en la mesa de  votaciones se podrá comprobar si ha votado o no, y una vez que realice el voto  presencial, marcar como que el usuario ha votado para que no pueda hacerlo  también virtualmente. Además, para el caso de congresos, asambleas, donde existe  la opción de votar presencialmente, se podrá realizar un bloqueo masivo de los  participantes para que estos voten solo en congreso/asamblea. <img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/Captura11.JPG" alt="022" width="650" height="141" border="0" /></li>
  </ul>
  <p><strong><u>Cómo  gestionamos los usuarios.</u></strong></p>
  <p>Una de las opciones más importantes de la aplicacion  es la gestión de usuarios. Esta aplicación está pensada para poder controlar  los censos de usuarios que pueden votar, es decir, salvo en las votaciones  abiertas, en el resto podran votar solo los usuarios que el administrador con  permisos para ello haya introduucido. De esta forma tenemos 3 grupos de  votantes, Los socios o afiliados, los simpatizantes verificados, y el  simpatizante.<img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/Captura12.JPG" alt="024" width="186" height="209" align="left" hspace="12" vspace="12" /><br />
    Solo podrán acceder a esta parte de la aplicación  los administradores con nivel 1, o los superadministradores. La base de gestión  de los censos es territorial, concretamente provincial.<br />
    Podrá acceder a las opciones de gestion de cesos  mediante el menú desplegable que se encuentra en &ldquo;gestión general de  censos&rdquo;  que tiene las siguientes  opciones.</p>
  <ul>
    <li><strong><u>Buscar/modificar votantes.</u></strong> Mediante esta opción se accedera a un buscador que  le permitirá encontrar al votante que desee para modificar o borrarlo. Además,  existe la posibilidad de bloquear un votante sin borrarlo.</li>
    <li><strong><u>Incluir un votante.</u></strong> Mediante esta opcion podra incluir un votante en el  censo general </li>
    <li><strong><u>Añadir votantes de forma masiva.</u></strong><u> </u>Mediante  esta opción podremos incluir múltiples votantes de una sola vez . Es importante  tener en cuenta que tienen que ser todos de una misma provincia, no se puede  por tanto mezclar provincias, y deben de ser todos del mismo tipo, Socios o  simpatizantes , etc . Para incluir  votantes de forma masiva, hay que hacerlo indicando la dirección de correo, el  nombre, y el NIF, todo ello separado por comas. Solo se puede poner un votante  por linea. Si un votante ya esta incluido en la base de datos, el sistema no lo  volverá a incluir, e indicará en rojo que no ha sido incluido.</li>
    <li><strong><u>Bloquear / desbloquear votantes</u></strong><u>.</u> Mediante un buscador, podrá encontrar el/los votantes que quiera para  bloquearlos para que no puedan votar.</li>
    <li><strong>B<u>ajas de votantes de forma masiva.</u></strong> Mediante un sistema similar al de la inclusión de votantes,  se podrán borrar múltiples votantes o cambiarlos de tipo. </li>
  </ul>
  <p><strong><u>Qué  son las asambleas y cómo se gestionan</u></strong></p>
  <p>Además de votaciones generales, autonómicas o  provinciales, se pueden crear &ldquo;asambleas&rdquo; o grupos de trabajo para realizar  votaciones en ese ámbito. Estos grupos también pueden ser generales,  autonómicos o provinciales, y una vez creados el votante podrá apuntarse si lo  desea, de forma que un usuario de la provincia de la coruña solo verá los  grupos de trabajo generales, los de la CCAA de Galicia, y los de su provincia.  Estos grupos pueden ser abiertos, es decir, cualquiera puede apuntarse, o  moderados, será necesaria la aprobación del administrador para que pueda  participar en el.<img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/Captura14.JPG" alt="026" width="172" height="122" align="left" hspace="12" vspace="12" /></p>
  <p>La gestión de estos grupos se hace mediante las  opciones que aparecen en el menú menú desplegable de &ldquo;Asambleas&rdquo; y son:</p>
  <ul>
    <li><strong>Crear asambleas.</strong> Esta opción solo estará disponible para administradores con el nivel 5  o superior. Los administradores autonómicos podrán crear grupos en su CCAA y  sus provincias, y los provinciales solo en las provincias que tengan asignadas.</li>
    <li><strong>Modificar Asambleas,</strong> Es una opcion similar a la anterior pero para  realizar modificaciones.</li>
    <li><strong>Gestionar usuarios. </strong>Esta opcion permite realizar la gestion de los  usuarios de los grupos de trabajo que tenga asignados, de forma que podra  autorizar el acceso al grupo de los votantes que lo hayan solicitado, o  bloquearlos.</li>
  </ul>
  <p><strong><u>Que  votaciones tengo yo</u></strong><br />
    <img src="../temas/<?php echo "$tema_web"; ?>/imagenes/imagenes_ayuda/Captura15.JPG" alt="028" width="185" height="160" align="left" hspace="12" vspace="12" /><br />
    Con el fin de facilitar la gestión de las  votaciones, sobre todo para los usuarios con niveles altos administrativos,  existen unas opciones del menú para ver y gestionar las votaciones que ha  creado uno mismo. Estas opciones se encuentran en el menú desplegable bajo el  epígrafe de &ldquo;mis votaciones&rdquo; y son las mismas opciones que se encuentran en  &ldquo;gestión general de votaciones, pero para sus votaciones.</p>
  <p><strong><u>Notificaciones  por correo</u></strong></p>
  <p>Existe la posibilidad de que se puedan notificar si  un votante  que tiene problemas para  acceder a la aplicación, directamente a una dirección de correo que se quiera,  esta notificación se hace por provincias y para cambiar las direcciones de  correo se puede hacer  en &ldquo;gestion  notificaciones provincias&rdquo;. Solo podra modificar la direccion de correo el  usuario con los permisos correspondientes y sólo para las provincias que tenga  asignadas. Si deja este campo vacío, las notificaciones se enviarán al correo  genérico de la aplicación </p>



		
                
                
    <!--
===========================  fin texto ayuda
-->             </div>            <!-- /modal-body -->
                       <!-- /modal-footer -->
        </div>         <!-- /modal-content -->
    
</body>
</html>