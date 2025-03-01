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
include('../inc_web/seguri_nivel.php');
$nivel_acceso=1; if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}


/**
 * @author awan < http://www.nawa.me >
 * 
 */
 
 
/**
 * Function to build SQL /Importing SQL DATA
 *
 * @param string $args as the queries of sql data , yopu could use file get contents to read data args
 * @param string $dbhost database host
 * @param string $dbuser database user
 * @param string $dbpass database password
 * @param string $dbname database name
 *
 * @return string complete if complete
 */

function mysqli_import_sql( $args , $dbhost, $dbuser, $dbpass ,$dbname ) {

  // check mysqli extension installed
  if( ! function_exists('mysqli_connect') ) {
    die(' This scripts need mysql extension to be running properly ! please resolve!!');
  }

	$mysqli = @new mysqli( $dbhost, $dbuser, $dbpass, $dbname );
	
	 if( $mysqli->connect_error ) {
    print_r( $mysqli->connect_error );
    return false;
  }

    $querycount = 11;
    $queryerrors = '';
    $lines = (array) $args;
    if( is_string( $args ) ) {
      $lines =  array( $args ) ;
    }

    if ( ! $lines ) {
      return '' . 'cannot execute ' . $args;
    }

    $scriptfile = false;
    foreach ($lines as $line) {
      $line = trim( $line );
      // if have -- comments add enters
      if (substr( $line, 0, 2 ) == '--') {
          $line = "\n" . $line;
      }
      if (substr( $line, 0, 2 ) != '--') {
        $scriptfile .= ' ' . $line;
        continue;
      }
    }

    $queries = explode( ';', $scriptfile );
    foreach ($queries as $query) {
      $query = trim( $query );
      ++$querycount;

      if ( $query == '' ) {
        continue;
      }


      if ( ! $mysqli->query( $query ) ) {
        $queryerrors .= '' . 'Line ' . $querycount . ' - ' . $mysqli->error . '<br>';
        continue;
      }
    }


    if ( $queryerrors ) {
      return '' . 'There was an error on File: ' . $filename . '<br>' . $queryerrors;
    }
    
    if( $mysqli && ! $mysqli->error ) {
      @$mysqli->close();
    }   

    return 'complete dumping database !';
}

/**
 * MYSQL EXPORT TO GZIP 
 * exporting database to sql gzip compression data.
 * if directory writable will be make directory inside of directory if not exist, else wil be die
 *
 * @param string directory , as the directory to put file
 * @param $outname as file name just the name !, if file exist will be overide as numeric next ++ as name_1.sql.gz , name_2.sql.gz next ++
 *
 * @param string $dbhost database host
 * @param string $dbuser database user
 * @param string $dbpass database password
 * @param string $dbname database name
 *
 */
function backup_database( $directory, $outname , $dbhost, $dbuser, $dbpass ,$dbname ) {
  
  // check mysqli extension installed
  if( ! function_exists('mysqli_connect') ) {
    die(' This scripts need mysql extension to be running properly ! please resolve!!');
  }

	$mysqli = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	
	if( $mysqli->connect_error ) {
		print_r( $mysqli->connect_error );
		return false;
	}

  	$dir = $directory;
  	$result = '<p> Could not create backup directory on :'.$dir.' Please Please make sure you have set Directory on 755 or 777 for a while.</p>';  
  	$res = true;
  	if( ! is_dir( $dir ) ) {
  	  if( ! @mkdir( $dir, 755 )) {
  	    $res = false;
  	  }
  	}

  $n = 1;
  if( $res ) {

    $name     = $outname;
    # counts
    if( file_exists($dir.'/'.$name.'.sql.gz' ) ) {

      for($i=1;@count( file($dir.'/'.$name.'_'.$i.'.sql.gz') );$i++){
        $name = $name;
        if( ! file_exists( $dir.'/'.$name.'_'.$i.'.sql.gz') ) {
          $name = $name.'_'.$i;
          break;
        }
      }
    }

    $fullname = $dir.'/'.$name.'.sql.gz'; # full structures

    if( ! $mysqli->error ) {
      $sql = "SHOW TABLES";
      $show = $mysqli->query($sql);
      while ( $r = $show->fetch_array() ) {
        $tables[] = $r[0];
      }

      if( ! empty( $tables ) ) {

  //cycle through
  $return = '';
  foreach( $tables as $table )
  {
    $result     = $mysqli->query('SELECT * FROM '.$table);
    $num_fields = $result->field_count;
    $row2       = $mysqli->query('SHOW CREATE TABLE '.$table );

    $row2       = $row2->fetch_row();
    $return    .= 
"\n
-- ---------------------------------------------------------
--
-- Table structure for table : `{$table}`
--
-- ---------------------------------------------------------

".$row2[1].";\n";

    for ($i = 0; $i < $num_fields; $i++) 
    {

      $n = 1 ;
      while( $row = $result->fetch_row() )
      { 
        

        if( $n++ == 1 ) { # set the first statements
          $return .= 
"
--
-- Dumping data for table `{$table}`
--

";  
        /**
         * Get structural of fields each tables
         */
        $array_field = array(); #reset ! important to resetting when loop 
         while( $field = $result->fetch_field() ) # get field
        {
          $array_field[] = '`'.$field->name.'`';
          
        }
        $array_f[$table] = $array_field;
        // $array_f = $array_f;
        # endwhile
        $array_field = implode(', ', $array_f[$table]); #implode arrays

          $return .= "INSERT INTO `{$table}` ({$array_field}) VALUES\n(";
        } else {
          $return .= '(';
        }
        for($j=0; $j<$num_fields; $j++) 
        {
          
          $row[$j] = str_replace('\'','\'\'', preg_replace("/\n/","\\n", $row[$j] ) );
          if ( isset( $row[$j] ) ) { $return .= is_numeric( $row[$j] ) ? $row[$j] : '\''.$row[$j].'\'' ; } else { $return.= '\'\''; }
          if ($j<($num_fields-1)) { $return.= ', '; }
        }
          $return.= "),\n";
      }
      # check matching
      @preg_match("/\),\n/", $return, $match, false, -3); # check match
      if( isset( $match[0] ) )
      {
        $return = substr_replace( $return, ";\n", -2);
      }

    }
    
      $return .= "\n";

  }

$return = 
"-- ---------------------------------------------------------
-- 
-- Base de datos descargada:
-- 
--          ".$dbname ."
--
-- Host Connection Info: ".$mysqli->host_info."
-- Generation Time: ".date('F d, Y \a\t H:i A ( e )')."
-- Server version: ".mysql_get_server_info()."
-- PHP Version: ".PHP_VERSION."
--
-- ---------------------------------------------------------\n\n

SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET time_zone = \"+00:00\";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
".$return."
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";

# end values result

    @ini_set('zlib.output_compression','Off');
    $gzipoutput = gzencode( $return, 9);

 if(  @ file_put_contents( $fullname, $gzipoutput  ) ) { # 9 as compression levels
  
    $result = "<br/><div class=\"alert alert-info\"> Ha sido correctamente descargada una copia de la base de datos en el servidor:<br/> Si lo desea puede descargarlo mediante este enlace : <a href=\"".$directory."/". $name.".sql.gz\">".$directory."/". $name.".sql.gz </a> </div>"; # show the name
  
  } else { # if could not put file , automaticly you will get the file as downloadable

    $result = false;   
    // various headers, those with # are mandatory
    header('Content-Type: application/x-download');
    header("Content-Description: File Transfer");
    header('Content-Encoding: gzip'); #
    header('Content-Length: '.strlen( $gzipoutput ) ); #
    header('Content-Disposition: attachment; filename="'.$name.'.sql.gz'.'"');
    header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
    header('Connection: Keep-Alive');
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    header('Pragma: no-cache');
    
    echo $gzipoutput;

  }

       } else {

         $result = '<p>Error when executing database query to export.</p>'.$mysqli->error;
       
       }
     }

 } else {
      $result = '<p>Wrong mysqli input</p>';
 }
 
 if( $mysqli && ! $mysqli->error ) {
      @$mysqli->close();
 }

  return $result;

}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title><?php echo "$nombre_web"; ?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=" ">
    <meta name="author" content=" ">
    <link rel="icon"  type="image/png"  href="../temas/<?php echo "$tema_web"; ?>/imagenes/icono.png"> 
    
    
    
    <!—[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]—>
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../temas/<?php echo "$tema_web"; ?>/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
   
    <link href="../temas/<?php echo "$tema_web"; ?>/estilo.css" rel="stylesheet">
  
  </head>
  <body>
  <!-- NAVBAR
================================================== -->
 <?php  include("../admin/menu_admin.php"); ?>
    
<!-- END NAVBAR
================================================== -->

 <div class="container">
 
    <!-- cabecera
    ================================================== -->
      <div class="page-header">
      <img src="../temas/<?php echo "$tema_web"; ?>/imagenes/cabecera_votaciones.jpg" class="img-responsive" alt="Logo <?php echo "$nombre_web"; ?>">
	  </div>
      
    <!-- END cabecera
    ================================================== -->
      <?php  include("../votacion/caja_mensajes_1.php"); ?>

       <div class="row">
        

        
        
        <div class="col-md-2" >             
          
          <?php  include("../votacion/menu_nav.php"); ?>
            
        </div>
       
        
        
        <div class="col-md-10">
     
                   <!--Comiezo-->
                   <h1> Copia de la base de datos</h1>
               <?php     
                $fecha =date("Y-m-d_H_i_s");	
				//$path_bakup_bbdd="backup/";
				$name = "backup_".$dbn."_".$fecha." "; // name sql backup
				
				print_r( backup_database( $path_bakup_bbdd, $name, $host, $hostu, $hostp, $dbn) ); // execute
					
                   ?> 
                   <h2>Copias de la base de datos actual</h2>
                   
                   <?php 
				   function ScanDirectory($Directory){

  $MyDirectory = opendir($Directory) or die('Error');
	while($Entry = @readdir($MyDirectory)) {
		if(is_dir($Directory.'/'.$Entry)&& $Entry != '.' && $Entry != '..') {
                         echo '<ul>'.$Directory;
			ScanDirectory($Directory.'/'.$Entry);
                        echo '</ul>';
		}
		else {
			echo "<li><a href=\" ".$Directory."/".$Entry."\">".$Entry."</a></li>";
                }
	}
  closedir($MyDirectory);
}

ScanDirectory($path_bakup_bbdd);
				   ?>
  <!--Final-->
        </div>
        
         
      
  </div>
 

  <div id="footer" class="row">
    <!--
===========================  modal para apuntarse
-->
<div class="modal fade" id="apuntarme" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           
            <div class="modal-body"></div>
            
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

 <!--
===========================  FIN modal apuntarse
-->
   <?php  include("../votacion/ayuda.php"); ?>
  <?php  include("../temas/$tema_web/pie.php"); ?>
   </div>
 </div>  
   
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->    
<script src="../js/jquery-1.9.0.min.js"></script>
	<script src="../modulos/bootstrap-3.1.1/js/bootstrap.min.js"></script>
  
  </body>
</html>