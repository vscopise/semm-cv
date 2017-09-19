<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}
$num_idiomas = $_POST["num_idiomas"];

$new_idioma = $num_idiomas+1;


$base = new connection;

$tr = '<tr class="idioma" id="idioma_'.$new_idioma.'">';

$tr .= '<td class="td1"><select class="nombre_idioma">';
$tr .= '<option value="Ninguno">Ninguno</option>';
$tr .= '<option value="Ingles">Ingles</option>';
$tr .= '<option value="Portugues">Portugues</option>';
$tr .= '<option value="Frances">Frances</option>';
$tr .= '<option value="Italiano">Italiano</option>';
$tr .= '<option value="Otro">Otro</option>';
$tr .= '</select></td>';

$tr .= '<td class="td2"><input type="text" class="field extra" disabled="disabled" /></td>';

$tr .= '<td class="td3">';
$tr .= '<input type="checkbox" class="habilidad1" value="1" disabled="disabled" /><span class="habilidad">Habla</span>';
$tr .= '<input type="checkbox" class="habilidad2" value="2" disabled="disabled" /><span class="habilidad">Lee</span>';
$tr .= '<input type="checkbox" class="habilidad3" value="4" disabled="disabled" /><span class="habilidad">Escribe</span>';
$tr .= '</td>';

$tr .= '<td class="sub"><a href="#" class="sub" id="sub_idioma_'.$new_idioma.'" title="Quitar Idioma">&nbsp;</a></td>';
$tr .= '</tr>';

echo $tr;

$base->close();
?>