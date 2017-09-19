<?php

function __autoload($nombre_clase) {
    include 'clases/' . $nombre_clase . '.php';
}

$objeto = new test_autoload_class ();
echo $objeto->value;

?>
