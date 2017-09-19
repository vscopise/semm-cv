<?php
//ini_set('display_errors', 1); 
//error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}

$id_del_aspirante = $_GET["id_del_aspirante"];
$estados = $_GET["estados"]=='' ? 'NULL' : '"'.implode ( ',', $_GET["estados"] ).'"';
//$estados = $estados == '' ? ' ': $estados;

$base = new connection;

$sql = "UPDATE aspirantes SET estado=".$estados." WHERE id_aspirante='".$id_del_aspirante."'";
$result = $base->safe_query($sql);

echo json_encode('Estados actualizados');
$base -> close();
?>