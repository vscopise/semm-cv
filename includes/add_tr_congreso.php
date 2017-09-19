<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}
$num_congresos = $_POST["num_congresos"];

$new_num_congreso = $num_congresos+1;

$base = new connection;

$tr = '<tr class="congreso" id="congreso_'.$new_num_congreso.'">';



$tr .= '<td><input type="text" class="field nombre" value="No tengo"  /></td>';
$tr .= '<td><input type="text" class="field tema" disabled="disabled" /></td>';

$tr .= '<td><input type="text" maxlength="4" class="field fecha" disabled="disabled" /></td>';

$tr .= '<td><select class="caracter" disabled="disabled">';
$tr .= '<option value="1">Autor</option><option value="2">Expositor</option>';
$tr .= '</select></td>';
$tr .= '<td><a href="#" class="sub" id="sub_congreso_'.$new_num_congreso.'" title="Quitar Congreso">&nbsp;</a></td>';
$tr .= '</tr>';

echo $tr;

$base->close();
?>