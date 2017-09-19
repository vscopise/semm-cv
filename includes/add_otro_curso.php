<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}
$num_otros_cursos = $_POST["num_otros_cursos"];

$new_num_otros_curso = $num_otros_cursos+1;


$base = new connection;

$tr = '<tr class="otro_curso" id="otro_curso_'.$new_num_otros_curso.'">';

$tr .= '<td><select class="tipo">';

$sql="SELECT * FROM otros_cursos ORDER BY id_otros_cursos";
$result = $base->safe_query($sql);
$select_otros_cursos = '';
while($row = $base->f_array($result)) {
	$select_otros_cursos .= '<option value="'.$row['id_otros_cursos'].'">';
	$select_otros_cursos .= utf8_encode($row['otros_cursos_nombre']).'</option>';
}
$tr .= $select_otros_cursos;
$tr .= '</select></td>';


$tr .= '<td><input type="text" maxlength="4" class="field inicio" disabled="disabled"></td>';

$tr .= '<td><input type="text" class="field nombre" disabled="disabled"></td>';
$tr .= '<td><input type="text" class="field lugar" disabled="disabled"></td>';

$tr .= '<td><a href="#" class="sub" id="sub_curso_'.$new_num_otros_curso.'" title="Quitar Curso">&nbsp;</a></td>';
$tr .= '</tr>';

echo $tr;

$base->close();
?>