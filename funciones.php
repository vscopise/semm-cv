<?php

/*FUNCIONES LOGIN*/

//Comprueba usuario y clave, si es OK redirecciona a $archivo:
function Login ($usuario, $clave, $archivo) {
	if ( isset ( $_POST['Submit']) ) {
		if ( $_POST['usuario'] == $usuario AND $_POST['clave'] == $clave) {
			$_SESSION['login'] = TRUE;
			header ("Location: " . $archivo);
		}
	}
}

//Chequea si el usuario esta logeado, si no lo redirecciona a $archivo:
function checkLogin ($archivo) {
	if ( !isset ($_SESSION['login']) ) {
		header ("Location: " . $archivo);
		exit;
	}
}



/* FUNCIONES PARA INDENTIFICAR FOTOS QUE SE VAN CARGANDO*/

// Devuelve microtime actual en formato s{segundos}m{microsegundos}:
function micTime() {
    list ($fracciones, $segundos) = explode (" ", microtime());
	$fracciones = substr ($fracciones, 2);
	return "s" . $segundos . "m" . $fracciones;
}

/* Nombra la foto agregandole al nombre, el prefijo creado con micTime y el campo al cual corresponde.
Hay un solo campo, pero lo dejamos por si quieren agregar mas campos en el futuro. */
	function nombrarFoto ($campo, $nombre) {		
		if ($nombre <> "") {
			return $campo = micTime() . "_" . $campo . "_" . $nombre;
		} else { 
			return $campo = "";
		}
	}

// En caso que hubiera mas de una foto copia la foto en el servidor
	function copiarFoto ($campo, $nombre) {		

		if ($nombre <> "") {
			$destino = "imagenes_de_articulos/" . $nombre ; 
 	 		copy ($_FILES[$campo]['tmp_name'], $destino); 
		}
	
	}

/* FUNCIONES de BOTONERA DE IMAGENES */

//Variables que definen el ancho y largo máximo de las miniaturas

$ancho_miniatura = 128;
$alto_miniatura = 110;

// funcion que muestra ícono "agregar imagen" si no hay foto e íconos "sustitutir imagen" y "eliminar imagen" cuando no hay foto.
// en este caso solo hay una foto, entonces el "campo" siempre es "imagen"
function botoneraImagenes ($campo) {
	global $row_mostrar;
		if (empty ($row_mostrar[$campo]) ) {
		echo "<div align=\"center\" class=\"icono\"><a href=\"agregar_imagen.php?id_articulo=" . $row_mostrar['id_articulo'] . "&campo=" . $campo . "\"><img src=\"iconos/agregar.gif\" vspace=\"3\" hspace=\"3\" alt=\"Agregar\" width=\"14\" height=\"14\" border=\"0\" /></a></div>";
	} else {
		echo "<div align=\"center\" class=\"icono\"><a href=\"sustituir_imagen.php?id_articulo=" . $row_mostrar['id_articulo'] . "&campo=" . $campo . "\"><img src=\"iconos/sustituir.gif\" vspace=\"3\" hspace=\"3\" alt=\"Sustituir\" width=\"12\" height=\"10\" border=\"0\" /></a> <a href=\"eliminar_imagen.php?id_articulo=" . $row_mostrar['id_articulo'] . "&campo=" . $campo . "\"><img src=\"iconos/eliminar.gif\" vspace=\"3\" hspace=\"3\" alt=\"Eliminar\" width=\"14\" height=\"14\" border=\"0\" /></a></div>";
	}	
}


//funcion que devuelve la miniatura en caso de que haya foto y devuelve vacio en caso de que no lo haya.
function mostrarMiniatura ($campo) {
	global $row_mostrar;
	global $ancho_miniatura;
	global $alto_miniatura;
	if (empty ($row_mostrar[$campo]) ) {
		echo "<img src=\"../img/comodin.jpg\" 	 />";
	} else {
		echo "<div class='miniatura'><img src='includes/redimensiona_imagen.php?imagen_original=../imagenes_de_articulos/"
		. $row_mostrar[$campo] . "&ancho_disponible=" . $ancho_miniatura .  "&alto_disponible=" . $alto_miniatura . "' border='0' />
		</div>";
	}	
}


/*funcion que devuelve la miniatura en caso de que haya foto y devuelve vacio en caso de que no lo haya.
function mostrarMiniatura ($campo) {
	global $row_mostrar;
	global $ancho_miniatura;
	global $alto_miniatura;
	if (empty ($row_mostrar[$campo]) ) {
		echo "";
	} else {
		echo "<div class='miniatura'><img src='includes/redimensiona_imagen.php?imagen_original=../imagenes_de_articulos/"
		. $row_mostrar[$campo] ."&ancho_disponible=" . $ancho_miniatura .  "&alto_disponible=" . $alto_miniatura . "' border='0' />
		</div>";
	}	
}*/



//funcion para mostrar las imagenes en el front.
function presentarFoto ($campo) {
	global $row_articulo;

	if (empty ($row_articulo[$campo]) ) {
		echo "<img src=\"img/comodin.jpg\" 	 />";
	} else {
		echo "
		
		<img src=\"admin/includes/redimensiona_imagen.php?imagen_original=../imagenes_de_articulos/" . $row_articulo[$campo] . "&ancho_disponible=140&alto_disponible=105\"	 />	";
	}	
}

//funcion para mostrar las imagenes en el front.
function presentarFoto2 ($campo) {

	if (empty ($campo) ) {
		echo "<img src=\"img/comodin.jpg\" 	 />";
	} else {
		echo "
		
		<img src=\"admin/includes/redimensiona_imagen.php?imagen_original=../imagenes_de_articulos/" . $campo . "&ancho_disponible=140&alto_disponible=105\"	 />	";
	}	
}

/* En HTML se escribe así:

<div class="miniatura"><img src="includes/redimensiona_imagen.php?imagen_original=../imagenes_de_articulos/<?php echo $row_mostrar['foto_02']; ?>&ancho_disponible=<?php echo $ancho_miniatura ?>&alto_disponible=<?php echo $alto_miniatura ?>" border="0" /></div>*/

/* FUNCIONES RELACIONADAS CON FECHA */

// Funcion seleccionar año

function selectAnio () {

 $nro_argumentos = func_num_args();
 
 if ($nro_argumentos == 0) {
  $anio_pasado = date("Y");
 }
 if ($nro_argumentos == 1) { 
  $argumentos = func_get_args();
  $fecha = $argumentos[0];  
  $fecha = explode ("-", $fecha);
  $anio_pasado = $fecha[0]; 
 } 

 echo "<select name='anio' id='anio'>\n"; 
 for ($anio = $anio_pasado - 2; $anio <= $anio_pasado + 2; $anio++) {
  if ($anio == $anio_pasado) {
   echo "<option value=$anio selected='selected'>$anio</option><br>\n"; 
  } else {
   echo "<option value=$anio>$anio</option><br>\n";
  }
 }
}

//echo comboFecha("2012-01-09");


//funcion seleccionar mes

function selectMes () {

 $nro_argumentos = func_num_args();
 
 if ($nro_argumentos == 0) {
  $mes_pasado = date("m");
 }
 if ($nro_argumentos == 1) { 
  $argumentos = func_get_args();
  $fecha = $argumentos[0];  
  $fecha = explode ("-", $fecha);
  $mes_pasado = $fecha[1]; 
 } 

 $mes_nombre = array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
 $i = 0; 
 echo "<select name='mes' id='mes'>\n"; 
  for ($mes = 1; $mes <= 12; $mes ++) { 
   if ($mes < 10) {
    $mes = 0 . $mes;
   } 
   if ($mes == $mes_pasado) {
    echo "<option value=$mes selected='selected'>$mes_nombre[$i]</option><br>\n"; 
   } else {
    echo "<option value=$mes>$mes_nombre[$i]</option><br>\n";
   }
   $i++;    
  } 
 echo '</select>';
}



//funcion seleccionar dia

function selectDia () {

 $nro_argumentos = func_num_args();
 
 if ($nro_argumentos == 0) {
  $dia_pasado = date("d");
 }
 if ($nro_argumentos == 1) { 
  $argumentos = func_get_args();
  $fecha = $argumentos[0];  
  $fecha = explode ("-", $fecha);
  $dia_pasado = $fecha[2]; 
 } 
 
 echo "<select name='dia' id='dia'>\n"; 
 for ($dia = 1; $dia <= 31; $dia ++) { 
  if ($dia < 10) {
   $dia = 0 . $dia;
  } 
  if ($dia == $dia_pasado) {
   echo "<option value=$dia selected='selected'>$dia</option><br>\n"; 
  } else {
   echo "<option value=$dia>$dia</option><br>\n";
  }    
 } 
 echo '</select>';
}



//echo comboFecha();

//echo comboFecha();
// funcion muestra fecha para mysql

function componerFecha ($dia, $mes, $anio) {
 return $anio . "-" . $mes . "-" . $dia;
}

//funcion muestra fecha "12 de 6 de 2011"

function comboFecha() {

 $nro_argumentos = func_num_args();

 if ($nro_argumentos == 0) {
  selectDia(); 
	echo " de ";
  selectMes(); 
	echo " de ";
  selectAnio();
 }
 
 if ($nro_argumentos == 1) { 
  $argumentos = func_get_args();
  $fecha = $argumentos[0];  
  selectDia ($fecha); 
	echo " de ";
  selectMes ($fecha); 
	echo " de ";
  selectAnio ($fecha);  
 } 
}


// Toma la fecha en formato 2011-03-20 y lo devuelve como "Domingo 20 de Marzo del 2001":
function presentarFecha ($fecha) {
	$dias = array ("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	$meses = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre");
	list ($anio, $mes, $dia) = explode ("-", $fecha);
	$segundos = mktime (0, 0, 0, $mes, $dia, $anio);
	$dia = $dias [date ("w", $segundos)];
	$mes = $meses [date ("n", $segundos)];
	return $dia . " " . date("d", $segundos) . " de " . $mes . " del " . date("Y", $segundos);
}


/* FUNCIONES PARA INSERTAR Y ELIMINAR NOTIICAS */

function insertarNoticias () {
	for ($i = 1; $i <= 10; $i ++) {
		for ($v = 1; $v <= 5; $v ++) {
			echo $query = "INSERT INTO noticias (fecha, titulo) VALUES ('" . fechaDiasAtras($i) . "', 'Titulo " . $i . $v . "')";
			br();
			$result = mysql_query ($query)
				or die ("La consulta falló: " . mysql_error());
		}
	}
}

// funcion eliminar imagen

function eliminarImagen ($campo) {
	global $row;
	global $ruta;
	global $servidor_ftp;
	global $ftp_usuario;
	global $ftp_pass;

	if ($row[$campo]) {

		//nombre de la imagen que se va a eliminar:
		$archivo = $ruta . $row[$campo];
		
		// establecer conexion ftp
		$id_con = ftp_connect($servidor_ftp);
		
		// iniciar sesion con nombre de usuario y pass
		$resultado_login = ftp_login ($id_con, $ftp_usuario, $ftp_pass);
		
		//elimina archivo
		ftp_delete($id_con, $archivo);
		
		ftp_quit($id_con);
		
	}
}


// Devuelve la fecha en en formato yyyy-mm-dd de "n" dias atras:
function fechaDiasAtras ($dias = 10) {
	$segundos = $dias * 24 * 60 * 60;
    return date ("Y-m-d", time() - $segundos);

}



function eliminarNoticiasPasadas () {
	$query = "DELETE FROM noticias WHERE fecha < '" . fechaDiasAtras() . "'";
	$result = mysql_query ($query)
		or die ("La consulta falló: " . mysql_error());
}

/* FUNCIONES CODIFICAR Y DECODIFICAR ETIQUETAS HTML EN LOS TEXT AREA */

function codificarHTML($mensaje) {
	$mensaje = nl2br($mensaje);
	$mensaje = str_replace ("[n]", "<strong>", $mensaje);
	$mensaje = str_replace ("[/n]", "</strong>", $mensaje);
	
	$mensaje = str_replace ("[destacado]", "<b class=\"naranja\">", $mensaje);
	$mensaje = str_replace ("[/destacado]", "</b>", $mensaje);	
	
	$mensaje = str_replace ("[link:]", "<a href=\"", $mensaje);
	$mensaje = str_replace ("[:link]", "\" class=\"naranja\">", $mensaje);
	$mensaje = str_replace ("[/link]", "</a>", $mensaje);	
	
	$mensaje = str_replace ("[lista]", "<ul>" , $mensaje);
	$mensaje = str_replace ("[l]", "<li>" , $mensaje);
	$mensaje = str_replace ("[/l]", "</li>" , $mensaje);
	$mensaje = str_replace ("[/lista]", "</ul>" , $mensaje);
	
	return $mensaje;
}

function decodificarHTML($mensaje) {
	$mensaje = str_replace ("<strong>", "[n]", $mensaje);
	$mensaje = str_replace ("</strong>", "[/n]", $mensaje);

	$mensaje = str_replace ("<b class=\"naranja\">", "[destacado]", $mensaje);
	$mensaje = str_replace ("</b>", "[/destacado]", $mensaje);	
	
	$mensaje = str_replace ("<a href=\"", "[link:]", $mensaje);
	$mensaje = str_replace ("\" class=\"naranja\">", "[:link]", $mensaje);
	$mensaje = str_replace ("</a>", "[/link]", $mensaje);	
	
	$mensaje = str_replace ( "<ul>" , "[lista]",  $mensaje);
	$mensaje = str_replace ( "<li>" ,"[l]",  $mensaje);
	$mensaje = str_replace ( "</li>" , "[/l]", $mensaje);
	$mensaje = str_replace ( "</ul>" , "[/lista]", $mensaje);
	
	$mensaje = strip_tags ($mensaje);
	
	return $mensaje;
}



/* FUNCIONES DE FORMULARIO DE ENVIO */

/* controla que la extension sea doc, docx o pdf */

function checkExtension ($archivo) {
	$extensiones = array ("doc", "docx", "pdf");	
	$archivo = strtolower ($archivo);
	$partes_archivo = explode (".", $archivo);
	$extension = end ($partes_archivo);
	foreach ($extensiones as $ext) {
		if ($ext == $extension) {
			return TRUE;
		}
	}
}





/* OTRAS FUNCIONES PRACTICAS */

// Devuelve "n" cantidad de "<br>";
function br($n = 1) {
    for ($i = 1; $i <= $n; $i ++) {
    	echo "<br>";
    }
}

echo comboFecha();



?>