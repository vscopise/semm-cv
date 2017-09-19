<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}

$id_aspirante = $_GET["id_aspirante"];

$base = new connection;
/*$sql = "SET character_set_results=utf8";
$result = $base->consulta($sql);*/

$sql  = 'SELECT * FROM aspirantes WHERE ';
$sql .= 'id_aspirante = "'.$id_aspirante.'" ';

$result = $base->safe_query($sql);
$row = $base->f_array($result);

$sql = 'UPDATE aspirantes SET estado=0 WHERE id_aspirante="'.$id_aspirante.'"';
$result = $base->safe_query($sql);

$base -> close();
?>