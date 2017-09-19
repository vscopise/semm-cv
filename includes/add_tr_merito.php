<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}
$num_meritos = $_POST["num_meritos"];

$new_merito = $num_meritos+1;

$base = new connection;

$tr = '<tr class="merito" id="merito_'.$new_merito.'">';



$tr .= '<td><input type="text" class="field merito" value="No tengo" /></td>';


$tr .= '<td><a href="#" class="sub" id="sub_merito_'.$new_merito.'" title="Quitar M&eacute;rito">&nbsp;</a></td>';
$tr .= '</tr>';

echo $tr;

$base->close();
?>