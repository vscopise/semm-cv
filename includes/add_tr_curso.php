<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}
$num_cursos = $_POST["num_cursos"];

$new_curso_num = $num_cursos+1;


$base = new connection;

$tr = '<tr class="curso" id="curso_'.$new_curso_num.'">';

$tr .= '<td><select class="nombre_curso">';

$sql="SELECT * FROM cursos ORDER BY id_curso";
$result = $base->safe_query($sql);
$select_cursos = '';
while($row = $base->f_array($result)) {
	$select_cursos .= '<option value="'.$row['id_curso'].'">';
	$select_cursos .= utf8_encode($row['curso_nombre']).'</option>';
}
$tr .= $select_cursos;
$tr .= '</select></td>';


$tr .= '<td><input type="text" class="field extra" disabled="disabled" /></td>';
$tr .= '<td><input type="text" maxlength="10" class="field vigencia" disabled="disabled" /></td>';
$tr .= '<td><input type="text" class="field lugar" disabled="disabled" /></td>';



$tr .= '<td><a href="#" class="sub" id="sub_curso_'.$new_curso_num.'" title="Quitar Curso">&nbsp;</a></td>';
$tr .= '</tr>';

echo $tr;

$base->close();
?>