<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}

$num_postgrados = $_POST["num_postgrados"];

$new_postgrado_num = $num_postgrados+1;

$base = new connection;

$tr = '<tr class="postgrado" id="postgrado_'.$new_postgrado_num.'">';

$tr .= '<td class="td2"><select class="especialidad">';

$sql="SELECT * FROM especialidades";
$result = $base->safe_query($sql);
$select_especialidades = '';
while($row = $base->f_array($result)) {
	$select_especialidades .= '<option value="'.$row['id_especialidades'].'">';
	//$select_especialidades .= htmlentities($row['nombre_especialidad']).'</option>';
        $select_especialidades .= $row['nombre_especialidad'].'</option>';
}
$tr .= $select_especialidades;
$tr .= '</select></td>';

$sql="SELECT * FROM tipo_postgrado";
$result = $base->safe_query($sql);

$tr .= '<td class="td1"><select class="tipo_postgrado" disabled="disabled">';
$tipo_postgrado = '';
while($row = $base->f_array($result)) {
	$tipo_postgrado .= '<option value="'.$row['id_tipo_postgrado'].'">';
	$tipo_postgrado .= $row['tipo_postgrado_nombre'].'</option>';
}
$tr .= $tipo_postgrado;
$tr .= '</select></td>';

$tr .= '<td class="td1"><input class="inicio" type="text" maxlength="4" class="field" disabled="disabled"></td>';
$tr .= '<td class="td0"><select class="cursa" disabled="disabled">';
$tr .= '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>';
$tr .= '</select></td>';
$tr .= '<td class="td0"><select class="egresado" disabled="disabled"><option value="0">Si</option><option value="1" selected="selected">No</option></select></td>';
$tr .= '<td class="td0"><input class="egreso" type="text" maxlength="4" class="field" disabled="disabled"></td>';
$tr .= '<td><a href="#" class="sub" id="sub_postgrado_'.$new_postgrado_num.'" title="Quitar Postgrado">&nbsp;</a></td>';
$tr .= '</tr>';

echo $tr;

$base->close();
?>