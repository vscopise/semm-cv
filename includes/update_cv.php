<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
    require( 'clases/PHPMailerAutoload.php');
//}

$name = $_POST["name"];
$last_name = $_POST["last_name"];
//$date = mysql_real_escape_string($_POST['born_date']);
$born_date = date('Y-d-m', strtotime($_POST["born_date"]));
//str_replace('-', '/', $_POST["born_date"])
$ci_num = str_replace('-','',$_POST["ci_num"]);
$cp_num = $_POST["cp_num"];
$tel_num = $_POST["tel_num"];
$cel_num = $_POST["cel_num"];
$egreso_facultad = $_POST["egreso_facultad"];
$email = $_POST["email"];
$pass = $_POST["pass"];

$postgrados = $_POST["postgrados"];
$cursos = $_POST["cursos"];
$exp_laborales = $_POST["exp_laborales"];
$otros_cursos = $_POST["otros_cursos"];
$congresos =  $_POST["congresos"];
$idiomas = $_POST["idiomas"];
$meritos = $_POST["meritos"];
$referencias = $_POST["referencias"];
$imagen = $_POST["id_foto"];
$adjuntos = $_POST["adjuntos"];
$fecha_actualizacion_cv = date('Y-m-d H:i:s');

$base = new connection;

//Actualizo la informacion personal
$sql = 'UPDATE aspirantes SET ';
//$sql .= 'estado=0, ';
$sql .= 'name="'.$name.'", ';
$sql .= 'last_name="'.$last_name.'", ';
$sql .= 'born_date="'.$born_date.'", ';
$sql .= 'ci_num="'.$ci_num.'", ';
$sql .= 'cp_num="'.$cp_num.'", ';
$sql .= 'tel_num="'.$tel_num.'", ';
$sql .= 'cel_num="'.$cel_num.'", ';
$sql .= 'egreso_facultad="'.$egreso_facultad.'", ';
$sql .= 'imagen="'.$imagen.'", ';
$sql .= 'fecha_actualizacion_cv="'.$fecha_actualizacion_cv.'" ';
//actualizar la contrase�a solo si se agrego algo
if ( $pass != '' ) {
	$sql .= ', pass="'.$pass.'" ';
}
$sql .= 'WHERE email="'.$email.'";';
$result = $base->safe_query($sql);

$sql = 'SELECT id_aspirante FROM aspirantes WHERE email="'.$email.'"';
$result = $base->safe_query($sql);
$row = $base->f_array($result);
$id_aspirante = $row['id_aspirante'];

//Borro todos los postgrados que tenia el aspirante y agrego los nuevos
$sql = 'SELECT * FROM aspirantes_postgrados WHERE id_aspirante="'.$id_aspirante.'"';
$result = $base->safe_query($sql);
if ($base->NumFilas($result)){
	$sql = 'DELETE FROM aspirantes_postgrados WHERE id_aspirante='.$id_aspirante;
	$result = $base->safe_query($sql);
}
foreach($postgrados as $postgrado){
	$id_especialidad = $postgrado[0];
	$id_tipo_postgrado = $postgrado[1];
	$inicio = $postgrado[2];
	$cursa = $postgrado[3];
	$egresado = $postgrado[4];
	$egreso = $postgrado[5];
	$sql  = 'INSERT INTO aspirantes_postgrados ';
	$sql .= '(id_aspirante, id_especialidad, ';
	$sql .= 'id_tipo_postgrado, inicio, cursa, egresado, egreso) ';
	$sql .= 'VALUES ("'.$id_aspirante.'", "'.$id_especialidad.'", ';
	$sql .= '"'.$id_tipo_postgrado.'", "'.$inicio.'", "'.$cursa.'", "'.$egresado.'", "'.$egreso.'")';
	$result = $base->safe_query($sql);
}

//Borro todos los cursos que tenia el aspirante y agrego los nuevos
$sql = 'SELECT * FROM aspirantes_cursos WHERE id_aspirante="'.$id_aspirante.'"';
$result = $base->safe_query($sql);
if ($base->NumFilas($result)){
	$sql = 'DELETE FROM aspirantes_cursos WHERE id_aspirante='.$id_aspirante;
	$result = $base->safe_query($sql);
}
foreach($cursos as $curso){
	$id_curso = $curso[0];
	$extra = htmlentities($curso[1], ENT_QUOTES, "UTF-8");
	$vigencia = $curso[2];
	$lugar = htmlentities($curso[3], ENT_QUOTES, "UTF-8");
	$sql  = 'INSERT INTO aspirantes_cursos ';
	$sql .= '(id_aspirante, id_curso, extra, vigencia, lugar) ';
	$sql .= 'VALUES ("'.$id_aspirante.'", "'.$id_curso.'", "'.$extra.'", "'.$vigencia.'", "'.$lugar.'")';
	$result = $base->safe_query($sql);
}

//Borro toda la experiencia laboral que tenia el aspirante y agrego la nueva
$sql = 'SELECT * FROM aspirantes_exp_laboral WHERE id_aspirante="'.$id_aspirante.'"';
$result = $base->safe_query($sql);
if ($base->NumFilas($result)){
	$sql = 'DELETE FROM aspirantes_exp_laboral WHERE id_aspirante='.$id_aspirante;
	$result = $base->safe_query($sql);
}
foreach($exp_laborales as $exp_laboral){
	$empresa = htmlentities($exp_laboral[0], ENT_QUOTES, "UTF-8");
	$cargo = htmlentities($exp_laboral[1], ENT_QUOTES, "UTF-8");
	$ingreso = $exp_laboral[2];
	$cese = $exp_laboral[3];
	$sql  = 'INSERT INTO aspirantes_exp_laboral ';
	$sql .= '(id_aspirante, empresa, cargo, ingreso, cese) ';
	$sql .= 'VALUES ("'.$id_aspirante.'", "'.$empresa.'", "'.$cargo.'", "'.$ingreso.'", "'.$cese.'")';
	$result = $base->safe_query($sql);
}

//Borro todos los cursos extra que tenia el aspirante y agrego los nuevos
$sql = 'SELECT * FROM aspirantes_otros_cursos WHERE id_aspirante="'.$id_aspirante.'"';
$result = $base->safe_query($sql);
if ($base->NumFilas($result)){
	$sql = 'DELETE FROM aspirantes_otros_cursos WHERE id_aspirante='.$id_aspirante;
	$result = $base->safe_query($sql);
}
foreach($otros_cursos as $otros_curso){
	$id_otros_cursos = $otros_curso[0];
	$inicio = htmlentities($otros_curso[1], ENT_QUOTES, "UTF-8");
	$nombre = $otros_curso[2];
	$lugar = $otros_curso[3];
	$sql  = 'INSERT INTO aspirantes_otros_cursos ';
	$sql .= '(id_aspirante, id_otros_cursos, inicio, nombre, lugar) ';
	$sql .= 'VALUES ("'.$id_aspirante.'", "'.$id_otros_cursos.'", "'.$inicio.'", "'.$nombre.'", "'.$lugar.'")';
	$result = $base->safe_query($sql);
}

//Borro todos los congresos y jornadas que tenia el aspirante y agrego los nuevos
$sql = 'SELECT * FROM aspirantes_congresos WHERE id_aspirante="'.$id_aspirante.'"';
$result = $base->safe_query($sql);
if ($base->NumFilas($result)){
	$sql = 'DELETE FROM aspirantes_congresos WHERE id_aspirante='.$id_aspirante;
	$result = $base->safe_query($sql);
}
foreach($congresos as $congreso){
	$nombre = htmlentities($congreso[0], ENT_QUOTES, "UTF-8");
	$tema = htmlentities($congreso[1], ENT_QUOTES, "UTF-8");
	$fecha = $congreso[2];
	$caracter = $congreso[3];
	$sql  = 'INSERT INTO aspirantes_congresos ';
	$sql .= '(id_aspirante, nombre, tema, fecha, caracter) ';
	$sql .= 'VALUES ("'.$id_aspirante.'", "'.$nombre.'", "'.$tema.'", "'.$fecha.'", "'.$caracter.'")';
	$result = $base->safe_query($sql);
}

//Borro todos los idiomas que tenia el aspirante y agrego los nuevos
$sql = 'SELECT * FROM aspirantes_idiomas WHERE id_aspirante="'.$id_aspirante.'"';
$result = $base->safe_query($sql);
if ($base->NumFilas($result)){
	$sql = 'DELETE FROM aspirantes_idiomas WHERE id_aspirante='.$id_aspirante;
	$result = $base->safe_query($sql);
}
foreach($idiomas as $idioma){
	$idioma_nombre = htmlentities($idioma[0], ENT_QUOTES, "UTF-8");
        $extra = $idioma[1];
	$habilidad = $idioma[2];
	$sql  = 'INSERT INTO aspirantes_idiomas ';
	$sql .= '(id_aspirante, idioma, extra, habilidad) ';
	$sql .= 'VALUES ("'.$id_aspirante.'", "'.$idioma_nombre.'", "'.$extra.'", "'.$habilidad.'")';
	$result = $base->safe_query($sql);
}

//Borro todos los meritos que tenia el aspirante y agrego los nuevos
$sql = 'SELECT * FROM aspirantes_meritos WHERE id_aspirante="'.$id_aspirante.'"';
$result = $base->safe_query($sql);
if ($base->NumFilas($result)){
	$sql = 'DELETE FROM aspirantes_meritos WHERE id_aspirante='.$id_aspirante;
	$result = $base->safe_query($sql);
}
foreach($meritos as $merito){
	$texto_merito = htmlentities($merito, ENT_QUOTES, "UTF-8");
	$sql  = 'INSERT INTO aspirantes_meritos ';
	$sql .= '(id_aspirante, merito) ';
	$sql .= 'VALUES ("'.$id_aspirante.'", "'.$texto_merito.'")';
	$result = $base->safe_query($sql);
}

//Borro todas las referencias que tenia el aspirante y agrego las nuevas
$sql = 'SELECT * FROM aspirantes_referencias WHERE id_aspirante="'.$id_aspirante.'"';
$result = $base->safe_query($sql);
if ($base->NumFilas($result)){
	$sql = 'DELETE FROM aspirantes_referencias WHERE id_aspirante='.$id_aspirante;
	$result = $base->safe_query($sql);
}
foreach($referencias as $referencia){
	$medico = htmlentities($referencia[0], ENT_QUOTES, "UTF-8");
	$celular = htmlentities($referencia[1], ENT_QUOTES, "UTF-8");
	$mail = htmlentities($referencia[2], ENT_QUOTES, "UTF-8");
	$lugar = htmlentities($referencia[3], ENT_QUOTES, "UTF-8");
	$funcionario_semm = $referencia[4];
	$sql  = 'INSERT INTO aspirantes_referencias ';
	$sql .= '(id_aspirante, medico, celular, mail, funcionario_semm, lugar) ';
	$sql .= 'VALUES ("'.$id_aspirante.'", "'.$medico.'", "'.$celular.'", "'.$mail.'", "'.$funcionario_semm.'", "'.$lugar.'")';
	$result = $base->safe_query($sql);
//echo $sql;
}

//Borro todos los adjuntos que tenia el aspirante y agrego los nuevos
$sql = 'SELECT * FROM aspirantes_adjuntos WHERE id_aspirante="'.$id_aspirante.'"';
$result = $base->safe_query($sql);
if ($base->NumFilas($result)){
	$sql = 'DELETE FROM aspirantes_adjuntos WHERE id_aspirante='.$id_aspirante;
	$result = $base->safe_query($sql);
}
foreach($adjuntos as $adjunto){
	$titulo_adjunto = htmlentities($adjunto[0], ENT_QUOTES, "UTF-8");
	$filename_adjunto = $adjunto[1];
	$sql  = 'INSERT INTO aspirantes_adjuntos ';
	$sql .= '(id_aspirante, titulo, filename) ';
	$sql .= 'VALUES ("'.$id_aspirante.'", "'.$titulo_adjunto.'", "'.$filename_adjunto.'")';
	$result = $base->safe_query($sql);
}

//datos mail
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: SEMM - Recursos Humanos <rrhh@semm.com.uy>';

$subject = 'SEMM - ACTUALIZACION DE CV';

$url =  home_base_url();

//mail a los administradores
$mail_message  = '<html>';
$mail_message .= '<body>';
$mail_message .= '<div style="text-align: center;">';
$mail_message .= '<img src="' . $url . 'includes/images/logo-semm.png" />';
$mail_message .= '</div>';
$mail_message .= '<div style="margin: 20px 0; padding: 20px; border= 1px solid #ccc; border-radius: 5px;">';
$mail_message .= '<p style="text-align: center;">';
$mail_message .= 'El usuario ' . $name . ' (' . $email . ') ha actualizado su CV';
$mail_message .= '</p>';
$mail_message .= '</body>';
$mail_message .= '</div>';
$mail_message .= '</html>';

$subject = 'SEMM - ACTUALIZACION DE CV';
            
$result = $base->safe_query( "SELECT * FROM aspirantes WHERE estado='administrador'" );
while($row = $base->f_array($result)) :
    mail( $row['email'], $subject, $mail_message, $headers );
endwhile;

//mail al usuario
$mail_message  = '<html>';
$mail_message .= '<body>';
$mail_message .= '<div style="text-align: center;">';
$mail_message .= '<img src="' . $url . 'includes/images/logo-semm.png" />';
$mail_message .= '</div>';
$mail_message .= '<div style="margin: 20px 0; padding: 20px; border= 1px solid #ccc; border-radius: 5px;">';
$mail_message .= '<p style="text-align: center;">';
$mail_message .= $name . ' ' . $last_name . ', su CV fue actualizado correctamente';
$mail_message .= '</p>';
$mail_message .= '</body>';
$mail_message .= '</div>';
$mail_message .= '</html>';



mail( $email, $subject, $mail_message, $headers );

$base->close();

function home_base_url(){   
    $currentPath = $_SERVER['PHP_SELF']; 

    $hostName = $_SERVER['HTTP_HOST']; 
    
    $uri = $_SERVER['REQUEST_URI'];
    $exploded_uri = explode('/', $uri);
    $domain_name = $exploded_uri[1];

    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';

    return $protocol.$hostName."/".$domain_name."/";
}
?>