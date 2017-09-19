<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}
$num_referencias = $_POST["num_referencias"];

$new_referencia = $num_referencias+1;

$base = new connection;

$tr = '<tr class="referencia" id="referencia_'.$new_referencia.'">';

$tr .= '<td><input type="text" class="field medico" value="Ninguna" /></td>';
$tr .= '<td><input type="text" class="field celular" disabled="disabled" /></td>';
$tr .= '<td><input type="text" class="field mail" disabled="disabled" /></td>';
$tr .= '<td><input type="text" class="field lugar_trabajo" disabled="disabled" />';
$tr .= '<td><select class="semm" disabled="disabled" ><option value="0">Si</option><option value="1">No</option></select></td>';

$tr .= '<td><a href="#" class="sub" id="sub_referencia_'.$new_referencia.'" title="Quitar Referencia">&nbsp;</a></td>';
$tr .= '</tr>';

echo $tr;

$base->close();
?>