<?php
//ini_set('display_errors', 1); 
//error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}

$id_aspirante = $_GET["id_aspirante"];

$base = new connection;
/*$sql = "SET character_set_results=utf8";
$result = $base->consulta($sql);*/


$result = $base->safe_query( "SELECT id_aspirante, name FROM aspirantes WHERE id_aspirante='$id_aspirante' AND estado='administrador'" );
$row = $base->f_array($result);

//echo $output;
echo json_encode($row);
$base->close();
?>