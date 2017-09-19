<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}

$num_adjuntos = $_POST["num_adjuntos"];

$new_adjunto = $num_adjuntos+1;

$base = new connection;

$tr = '<tr class="adjunto" id="adjunto_'.$new_adjunto.'">';

$tr .= '<td><input type="text" class="field titulo" value="Ninguno" /></td>';
$tr .= '<td class="filename">';
$tr .= '<form class="upload_file" method="post" enctype="multipart/form-data"  action="#">';
$tr .= '<div class="nombre_adjunto">';
$tr .= '<input type="file" class="file-input" name="fichero" />';
$tr .= '</div>';
$tr .= '</form>';
$tr .= '</td>';

$tr .= '<td><a href="#" class="sub" id="sub_adjunto_'.$new_adjunto.'" title="Quitar Adjunto">&nbsp;</a></td>';
$tr .= '</tr>';

echo $tr;

$base->close();
?>