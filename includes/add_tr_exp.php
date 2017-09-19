<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}
$num_exp_lab = $_POST["num_exp_lab"];

$new_num_exp_lab = $num_exp_lab+1;

$base = new connection;

$tr = '<tr class="exp_lab" id="exp_lab_'.$new_num_exp_lab.'">';

$tr .= '<td class="td2"><input type="text" class="field empresa" value="Ninguna"></td>';
$tr .= '<td class="td2"><input type="text" class="field cargo" disabled="disabled" /></td>';

$tr .= '<td class="td1"><input type="text" maxlength="4" class="field ingreso" disabled="disabled" /></td>';
$tr .= '<td class="td1"><input type="text" maxlength="4" class="field cese" disabled="disabled" /></td>';

$tr .= '<td><a href="#" class="sub" id="sub_curso_'.$new_num_exp_lab.'" title="Quitar Experiencia">&nbsp;</a></td>';
$tr .= '</tr>';

echo $tr;

$base->close();
?>