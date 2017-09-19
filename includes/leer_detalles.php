<?php
//ini_set('display_errors', 1); 
//error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}

$id_aspirante = $_GET["id_aspirante"];

$base = new connection;
/*$sql = "SET character_set_results=utf8";
$result = $base->consulta($sql);*/

$sql  = 'SELECT * FROM aspirantes WHERE ';
$sql .= 'id_aspirante = "'.$id_aspirante.'" ';

$result = $base->safe_query($sql);
$row = $base->f_array($result);

$id_aspirante = $row['id_aspirante'];
$estado = $row['estado'];
$nombre_completo = $row['name'].' '.$row['last_name'];
$fecha_nacimiento = date('j/n/Y', strtotime($row['born_date']) );
$ced_identidad = $row['ci_num'];
$caja_profesional = $row['cp_num'];
$tel_num = $row['tel_num'];
$cel_num = $row['cel_num'];
$mail = $row['email'];
$fecha_ingreso = date('j/n/Y', strtotime($row['create_cv_date']) );
//$fecha_actualizacion = date('d/m/Y', strtotime($row['fecha_actualizacion_cv']) );
//$fecha_actualizacion = $row['fecha_actualizacion_cv'];
$fecha_actualizacion = date('j/n/Y', strtotime($row['fecha_actualizacion_cv']) );
$imagen = '<img src="../archivos_adjuntos/fotos/'.$row['imagen'].'" />';

//actualizo el estado
//$sql = 'UPDATE aspirantes SET estado=1 WHERE id_aspirante="'.$id_aspirante.'"';
//$result = $base->safe_query($sql);

$sql  = 'SELECT * FROM aspirantes_postgrados, tipo_postgrado, especialidades WHERE ';
$sql .= 'aspirantes_postgrados.id_especialidad=especialidades.id_especialidades ';
$sql .= 'AND aspirantes_postgrados.id_tipo_postgrado=tipo_postgrado.id_tipo_postgrado ';
$sql .= 'AND id_aspirante="'.$id_aspirante.'" ';
$result = $base->safe_query($sql);

$aspirantes_postgrados = '';
while ( $row = $base->f_array($result) ) {
	$aspirantes_postgrados .= '<tr>';
	$aspirantes_postgrados .= '<td style="width: 200px">'.$row['nombre_especialidad'].'</td>';
	$aspirantes_postgrados .= '<td style="width: 150px">'.$row['tipo_postgrado_nombre'].'</td>';
	$aspirantes_postgrados .= '<td style="width: 75px; text-align: center;">'.$row['inicio'].'</td>';
	$aspirantes_postgrados .= '<td style="width: 75px; text-align: center;">'.$row['cursa'].'</td>';
	$egresado = ( $row['egresado'] == '0' ) ? 'SI' : 'NO';
	$aspirantes_postgrados .= '<td style="width: 75px; text-align: center;">'.$egresado.'</td>';
	$aspirantes_postgrados .= '<td style="width: 75px; text-align: center;">'.$row['egreso'].'</td>';
	$aspirantes_postgrados .= '</tr>';
}

$sql  = 'SELECT * FROM aspirantes_cursos, cursos WHERE ';
$sql .= 'aspirantes_cursos.id_curso=cursos.id_curso ';
$sql .= 'AND aspirantes_cursos.id_aspirante="'.$id_aspirante.'" ';
$result = $base->safe_query($sql);

$aspirantes_cursos = '';
while ( $row = $base->f_array($result) ) {
	$aspirantes_cursos .= '<tr>';
	$aspirantes_cursos .= '<td style="width: 100px">'.$row['curso_nombre'].'</td>';
	$aspirantes_cursos .= '<td style="width: 400px">'.$row['extra'].'</td>';
	$aspirantes_cursos .= '<td style="width: 75px; text-align: center;">'.$row['vigencia'].'</td>';
	$aspirantes_cursos .= '<td style="width: 200px">'.$row['lugar'].'</td>';
	$aspirantes_cursos .= '</tr>';
}

$sql  = 'SELECT * FROM aspirantes_otros_cursos, otros_cursos WHERE ';
$sql .= 'aspirantes_otros_cursos.id_otros_cursos=otros_cursos.id_otros_cursos ';
$sql .= 'AND aspirantes_otros_cursos.id_aspirante="'.$id_aspirante.'" ';
$result = $base->safe_query($sql);

$aspirantes_otros_cursos = '';
while ( $row = $base->f_array($result) ) {
	$aspirantes_otros_cursos .= '<tr>';
	$aspirantes_otros_cursos .= '<td style="width: 50px">'.$row['otros_cursos_nombre'].'</td>';
	$aspirantes_otros_cursos .= '<td style="width: 400px">'.$row['nombre'].'</td>';
	$aspirantes_otros_cursos .= '<td style="width: 100px; text-align: center;">'.$row['lugar'].'</td>';
	$aspirantes_otros_cursos .= '<td style="width: 75px; text-align: center;">'.$row['inicio'].'</td>';
	$aspirantes_otros_cursos .= '</tr>';
}

$sql  = 'SELECT * FROM aspirantes_exp_laboral WHERE ';
$sql .= 'id_aspirante="'.$id_aspirante.'" ';
$result = $base->safe_query($sql);

$aspirantes_exp_laboral = '';
while ( $row = $base->f_array($result) ) {
	$aspirantes_exp_laboral .= '<tr>';
	$aspirantes_exp_laboral .= '<td style="width: 150px">'.$row['empresa'].'</td>';
	$aspirantes_exp_laboral .= '<td style="width: 300px">'.$row['cargo'].'</td>';
	$aspirantes_exp_laboral .= '<td style="width: 75px; text-align: center;">'.$row['ingreso'].'</td>';
	$aspirantes_exp_laboral .= '<td style="width: 75px; text-align: center;">'.$row['cese'].'</td>';
	$aspirantes_exp_laboral .= '</tr>';
}

$sql  = 'SELECT * FROM aspirantes_congresos WHERE ';
$sql .= 'id_aspirante="'.$id_aspirante.'" ';
$result = $base->safe_query($sql);

$aspirantes_congresos = '';
while ( $row = $base->f_array($result) ) {
	$aspirantes_congresos .= '<tr>';
	$aspirantes_congresos .= '<td style="width: 400px;">'.$row['nombre'].'</td>';
	$aspirantes_congresos .= '<td style="width: 200px;">'.$row['tema'].'</td>';
	$aspirantes_congresos .= '<td style="width: 75px; text-align: center;">'.$row['fecha'].'</td>';
	$caracter = $row['caracter']==1 ? 'autor' : 'expositor';
	$aspirantes_congresos .= '<td style="width: 75px; text-align: center;">'.$caracter.'</td>';
	$aspirantes_congresos .= '</tr>';
}

$sql  = 'SELECT * FROM aspirantes_idiomas WHERE ';
$sql .= 'id_aspirante="'.$id_aspirante.'" ';
$result = $base->safe_query($sql);

$aspirantes_idiomas = '';
while ( $row = $base->f_array($result) ) {
	$aspirantes_idiomas .= '<tr>';
	$aspirantes_idiomas .= '<td style="width: 100px;">'.$row['idioma'].'</td>';
	if ($row['habilidad']==1){
		$habilidad ='Habla';
	} elseif ($row['habilidad']==2){
		$habilidad ='Lee';
	} elseif ($row['habilidad']==3){
		$habilidad ='Habla y Lee';
	} elseif ($row['habilidad']==4){
		$habilidad ='Escribe';
	} elseif ($row['habilidad']==5){
		$habilidad ='Habla y Escribe';
	} elseif ($row['habilidad']==6){
		$habilidad ='Lee y Escribe';
	} elseif ($row['habilidad']==7){
		$habilidad ='Habla, Lee y Escribe';
	} else {
		$habilidad ='Ambos';
	}
	$aspirantes_idiomas .= '<td style="width: 150px; text-align: center;">'.$habilidad.'</td>';
	$aspirantes_idiomas .= '</tr>';
}

$sql  = 'SELECT * FROM aspirantes_meritos WHERE ';
$sql .= 'id_aspirante="'.$id_aspirante.'" ';
$result = $base->safe_query($sql);
$aspirantes_meritos = '';

while ( $row = $base->f_array($result) ) {
	$aspirantes_meritos .= '<tr>';
	$aspirantes_meritos .= '<td style="width: 500px;">'.$row['merito'].'</td>';
	$aspirantes_meritos .= '</tr>';
}

$sql  = 'SELECT * FROM aspirantes_referencias WHERE ';
$sql .= 'id_aspirante="'.$id_aspirante.'" ';
$result = $base->safe_query($sql);

$aspirantes_referencias = '';
while ( $row = $base->f_array($result) ) {
	$aspirantes_referencias .= '<tr>';
	$aspirantes_referencias .= '<td style="width: 200px;">'.$row['medico'].'</td>';
	$aspirantes_referencias .= '<td style="width: 75px; text-align: center;">'.$row['celular'].'</td>';
	$aspirantes_referencias .= '<td style="width: 150px; text-align: center;">'.$row['mail'].'</td>';
	$funcionario_semm = $row['funcionario_semm']==1 ? 'Si' : 'No';
	$aspirantes_referencias .= '<td style="width: 75px; text-align: center;">'.$funcionario_semm.'</td>';
	$aspirantes_referencias .= '<td style="width: 100px;">'.$row['lugar'].'</td>';
	$aspirantes_referencias .= '</tr>';
}


$sql  = 'SELECT * FROM aspirantes_adjuntos WHERE ';
$sql .= 'id_aspirante="'.$id_aspirante.'" ';
$result = $base->safe_query($sql);

$aspirantes_adjuntos = '';
while ( $row = $base->f_array($result) ) {
	$aspirantes_adjuntos .= '<tr>';
	$aspirantes_adjuntos .= '<td style="width: 100px;">'.$row['titulo'].'</td>';
	$aspirantes_adjuntos .= '<td style="width: 100px;">';
	$aspirantes_adjuntos .= '<a href="../archivos_adjuntos/'.$row['filename'].'" target="_blank">'.$row['filename'].'</a>';
	$aspirantes_adjuntos .= '</td>';
	$aspirantes_adjuntos .= '</tr>';
}

$output = array(
    $id_aspirante,
    $nombre_completo,
    $fecha_nacimiento,
    $ced_identidad,
    $caja_profesional,
    $tel_num,
    $cel_num,
    $mail,
    $fecha_ingreso,
    $fecha_actualizacion,
    $imagen,
    $aspirantes_postgrados,
    $aspirantes_cursos,
    $aspirantes_otros_cursos,
    $aspirantes_exp_laboral,
    $aspirantes_congresos,
    $aspirantes_idiomas,
    $aspirantes_meritos,
    $aspirantes_referencias,
    $aspirantes_adjuntos,
    $estado
);
//echo $output;
echo json_encode($output);
$base->close();
?>