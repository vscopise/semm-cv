<?php
//ini_set('display_errors', 1); 
//error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}

$name = filter_input(INPUT_POST, 'name');
$last_name = filter_input(INPUT_POST, 'last_name');
$born_date = filter_input(INPUT_POST, 'born_date')=='' ? '' : date('Y-d-m', strtotime( filter_input(INPUT_POST, 'born_date') ));
$ci_num = filter_input(INPUT_POST, 'ci_num');
$cp_num = filter_input(INPUT_POST, 'cp_num');
$tel_num = filter_input(INPUT_POST, 'tel_num');
$cel_num = filter_input(INPUT_POST, 'cel_num');
$egreso_facultad = filter_input(INPUT_POST, 'egreso_facultad');
$email = filter_input(INPUT_POST, 'email');
$array_estados = filter_input(INPUT_POST, 'estados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
//$estados = $array_estados == '' ? ' is NULL' : ' LIKE "'.implode ( ',', $array_estados ).'"';

$especialidades = filter_input(INPUT_POST, 'especialidades');
$cursos = filter_input(INPUT_POST, 'cursos');
$otros_cursos = filter_input(INPUT_POST, 'otros_cursos');
$experiencia = filter_input(INPUT_POST, 'experiencia');
$congresos = filter_input(INPUT_POST, 'congresos');
$idiomas = filter_input(INPUT_POST, 'idiomas');
$meritos = filter_input(INPUT_POST, 'meritos');
$referencias = filter_input(INPUT_POST, 'referencias');

$base = new connection;
$sql1 = 'SELECT * FROM estados';
$result1 = $base->safe_query($sql1);
$num_estados = $base->NumFilas($result1);

$sql  = 'SELECT DISTINCT aspirantes.* FROM aspirantes';
//$sql  = 'FROM aspirantes, aspirantes_postgrados, aspirantes_cursos, aspirantes_otros_cursos, aspirantes_exp_laboral, aspirantes_congresos, aspirantes_idiomas, aspirantes_meritos, aspirantes_referencias WHERE ';
if ($especialidades!='null' || $cursos!='null' || $otros_cursos!='null' || $experiencia!='' || $congresos!='' || $idiomas!='' || $meritos!='' || $referencias!=''){
    $sql .= ($especialidades != 'null') ? ', aspirantes_postgrados' : '';
    $sql .= ($cursos != 'null') ? ', aspirantes_cursos' : '';
    $sql .= ($otros_cursos != 'null') ? ', aspirantes_otros_cursos' : '';
    $sql .= ($experiencia != '') ? ', aspirantes_exp_laboral' : '';
    $sql .= ($congresos != '') ? ', aspirantes_congresos' : '';
    $sql .= ($idiomas != '') ? ', aspirantes_idiomas' : '';
    $sql .= ($meritos != '') ? ', aspirantes_meritos' : '';
    $sql .= ($referencias != '') ? ', aspirantes_referencias' : '';
}

$sql .= ' WHERE';

if ($name!='' || $last_name!='' || $born_date!='' || $ci_num!='' || $cp_num!='' || $tel_num!='' || $cel_num!='' || $egreso_facultad!='' || $email!=''){
    $sql .= ($name!='') ? ' name LIKE "%'.$name.'%" AND ' : '';
    $sql .= ($last_name!='') ? ' last_name LIKE "%'.$last_name.'%" AND ' : '';
    $sql .= ($born_date!='') ? ' born_date LIKE "%'.$born_date.'%" AND ' : '';
    $sql .= ($ci_num!='') ? ' ci_num LIKE "%'.$ci_num.'%" AND ' : '';
    $sql .= ($cp_num!='') ? ' cp_num LIKE "%'.$cp_num.'%" AND ' : '';
    $sql .= ($tel_num!='') ? ' tel_num LIKE "%'.$tel_num.'%" AND ' : '';
    $sql .= ($cel_num!='') ? ' cel_num LIKE "%'.$cel_num.'%" AND ' : '';
    $sql .= ($egreso_facultad!='') ? ' egreso_facultad LIKE "%'.$egreso_facultad.'%" AND ' : '';
    $sql .= ($email!='') ? ' email LIKE "%'.$email.'%" AND ' : '';
    //$estado = $leido - 1;
    //$sql .= ($leido!='0') ? ' estado="'.$estado.'" AND ' : '';
    
    //$sql = substr($sql, 0, strlen($sql)-5);
}

if ($especialidades != 'null') {
    $sql .= ' aspirantes.id_aspirante=aspirantes_postgrados.id_aspirante AND (';
    $especialidades = json_decode($especialidades);
    foreach ($especialidades as $especialidad) {
        $sql .= ' aspirantes_postgrados.id_especialidad="'.$especialidad.'" OR';
    }
    $sql = substr($sql,0,strlen($sql)-2);
    $sql .= ') AND ';
}

if ($cursos != 'null') {
    $sql .= ' aspirantes.id_aspirante=aspirantes_cursos.id_aspirante AND (';
    $cursos = json_decode($cursos);
    foreach ($cursos as $curso) {
        $sql .= ' aspirantes_cursos.id_curso="'.$curso.'" OR';
    }
    $sql = substr($sql,0,strlen($sql)-2);
    $sql .= ') AND ';
}

if ($otros_cursos != 'null') {
    $sql .= ' aspirantes.id_aspirante=aspirantes_otros_cursos.id_aspirante AND (';
    $otros_cursos = json_decode($otros_cursos);
    foreach ($otros_cursos as $otro_curso) {
        $sql .= ' aspirantes_otros_cursos.id_otros_cursos="'.$otro_curso.'" OR';
    }
    $sql = substr($sql,0,strlen($sql)-2);
    $sql .= ') AND ';
}

if ($experiencia != '') {
	$sql .= ' aspirantes.id_aspirante=aspirantes_exp_laboral.id_aspirante';
	$sql .= ' AND aspirantes_exp_laboral.empresa LIKE "%'.$experiencia.'%" AND ';
}

if ($congresos != '') {
	$sql .= ' aspirantes.id_aspirante=aspirantes_congresos.id_aspirante';
	$sql .= ' AND aspirantes_congresos.nombre LIKE "%'.$congresos.'%" AND ';
}

if ($idiomas != '') {
	$sql .= ' aspirantes.id_aspirante=aspirantes_idiomas.id_aspirante';
	$sql .= ' AND aspirantes_idiomas.idioma	LIKE "%'.$idiomas.'%" AND';
}

if ($meritos != '') {
	$sql .= ' aspirantes.id_aspirante=aspirantes_meritos.id_aspirante';
	$sql .= ' AND aspirantes_meritos.merito LIKE "%'.$meritos.'%" AND ';
}

if ($referencias != ''){
	$sql .= ' aspirantes.id_aspirante=aspirantes_referencias.id_aspirante';
	$sql .= ' AND aspirantes_referencias.medico LIKE "%'.$referencias.'%" AND ';
}


/*if ( ($name!='' || $last_name!='' || $born_date!='' || $ci_num!='' || $cp_num!='' || $tel_num!='' || $cel_num!='' || $egreso_facultad!='' || $email!='')
    && ($especialidades=='null' && $cursos=='null' && $otros_cursos=='null' && $experiencia=='' && $congresos=='' && $idiomas=='' && $meritos=='' && $referencias=='') ){
    $sql = substr($sql, 0, strlen($sql)-5);
}*/

//mail('vscopise@gmail.com', 'Consulta sql SEMM', $sql);
//mail('gfernandez@lared.com.uy', 'Consulta sql SEMM', $sql);
//echo 'sql --'.$sql;
/*$estado = 0;
foreach ( json_decode($estados) as $key => $value ) {
    $estado += ($value==true) ? pow( 2, $key ): 0;
}
$sql .= ' LPAD(RIGHT(BIN(estado),'.$num_estados.'),'.$num_estados.', "0") = '.decbin($estado);
//$sql .= ' bin(estado) XOR NOT '.$estado;*/
//$estados = ($estados == NULL) ? '' : $estados;
if ( $array_estados == '' ) {
    //$estados = ' estado is NULL';
    //$estados = ' estado LIKE "%" OR estado is NULL';
    $estados = '';
    $sql = substr($sql, 0, strlen($sql)-5);
} else {
    $estados = ' ';
    foreach ($array_estados as $element_estado) {
        $estados .= 'estado LIKE "%' . $element_estado . '%" OR ';
    }
    $estados = substr($estados, 0, strlen($estados)-3);
}
//$estados = filter_input(INPUT_POST, 'estados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY)=='' ? ' is NULL' : '="'.implode ( ',', filter_input(INPUT_POST, 'estados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) ).'"';
if ($especialidades=='null' && $cursos=='null' && $otros_cursos=='null' && $experiencia=='' && $congresos=='' && $idiomas=='' && $meritos=='' && $referencias=='' && $array_estados=='null'){
    //$sql = substr($sql, 0, strlen($sql)-5);
}
$sql .= $estados;
/*/*if ($estados) {
    $sql .= $estados;
    
} else {
    $sql = substr($sql, 0, strlen($sql)-4);
}*/
//$sql .= ' estado'.$estados;
if ($estados=='' && $name=='' && $last_name=='' && $born_date=='' && $ci_num=='' && $cp_num=='' && $tel_num=='' && $cel_num=='' && $egreso_facultad=='' && $email=='' 
    && $especialidades=='null' && $cursos=='null' && $otros_cursos=='null' && $experiencia=='' && $congresos=='' && $idiomas=='' && $meritos=='' && $referencias=='') {
    //$sql = substr($sql, 0, strlen($sql)-6);
    //$sql .= ' 1=1';
}
//echo 'sql - '.$sql;



$result = $base->safe_query($sql);

$output  = '<table class="admin-result">';
$i=0;
$row = array();
while($row = $base->f_array($result)) {
//	$class= $i%2==0 ? 'odd' : 'even';
//	$output .= '<tr class="'.$class.'">';
    
	$output .= '<tr>';
	$output .= '<input type="hidden" id="id_aspirante" value="'.$row['id_aspirante'].'"/>';
	$output .= '<td style="width: 250px">'.$row['name'].' '.$row['last_name'].'</td>';
	$output .= '<td style="width: 100px">'.$row['tel_num'].'</td>';
        $estado = $row['estado'];
        $estados = '';
        $array_estados = explode(',', $row['estado']);
        foreach ($array_estados as $id_estado) {
            $sql2 = 'SELECT * FROM estados';
            $result2 = $base->safe_query($sql2);
            while ( $row2 = $base->f_array($result2) ) {
                if ($id_estado==$row2['id_estado']) {
                    $estados .= $row2['nombre_estado'] . ', ';
                }
            }
            
        }
        $estados = substr($estados, 0, strlen($estados) - 2);
        //$class = ($row['estado']==0) ? 'no_leido' : '';
	$output .= '<td style="width: 300px">'.$estados.'</td>';
	$output .= '<td style="width: 250px">'.$row['email'].'</td>';
	$output .= '</tr>';
	$i++;
}
$output .= '</table>';
$output .= '<input type="hidden" id="aspirante" value="" />';
$output .= '<div style="clear:both"></div>';
//$output .= '<input type="button" value="M&aacute;s detalles" class="detalles" disabled="disabled" />';
$output .= '<div style="clear:both">';


echo $output;

$base->close();
?>