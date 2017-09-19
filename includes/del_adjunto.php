<?php
if ( isset($_POST['filename']) ){
        $path = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/includes'));
        $file_path = $_SERVER['DOCUMENT_ROOT'].$path.'/archivos_adjuntos/';
	$filename = $file_path.$_POST['filename'];
	unlink(''.$filename);
}
?>