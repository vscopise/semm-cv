<?php
	if (isset($_SERVER['HTTP_X_FILENAME'])) {
                $path = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/includes'));
		file_put_contents(
			$_SERVER['DOCUMENT_ROOT'].$path.'/archivos_adjuntos/'.$_SERVER['HTTP_X_FILENAME'],
			//'images/'.$_SERVER['HTTP_X_FILENAME'],
			file_get_contents('php://input')
		);
	}
?>