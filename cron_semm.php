<?php
	//esta funcion selecciona todos los aspirantes 
	//cuyo curriculum fue actualizado exactamente hace 1 año
	// y les envia un mail invitandolos a actualizar el mismo
        // también chequea todos los aspirantes cuyo registro esté "PENDIENTE"
        // y elimina los registros que tengan al menos 24 horas
        // sin haber sido confirmados.
	// Este cron debe ser creado con una frecuencia diaria 
	//para que todos los aspirantes puedan ser verificados

	function __autoload($nombre_clase) {
		include 'includes/clases/' . $nombre_clase . '.php';
	}
	
	$time = strtotime("-1 year", time());
	$date = date('Y-m-d', $time);

	$base = new connection;
	
	$sql = 'SELECT * FROM aspirantes WHERE fecha_actualizacion_cv = '.$date;
	
	$result = $base->safe_query($sql);
	while($row = $base->f_array($result)) {
		$mail = $row['email'];
		
		$subject = 'SUBJECT';
		$mail_message = 'MAIL MESAGE';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: SEMM - Recursos Humanos <rhh@semm.com.uy>';

		//mail($mail, $subject, $mail_message, $headers);
	}
        
        $sql = 'SELECT * FROM aspirantes WHERE estado = "PENDIENTE"';
        $result = $base->safe_query($sql);
	while($row = $base->f_array($result)) {
            $id_aspirante = $row['id_aspirante'];
		
            $create_cv_date = $row['create_cv_date'];
            $date = date('Y-m-d H:i:s');
                
            $diff_time = strtotime($date) - strtotime($create_cv_date);
            if ( $diff_time > 24 * 60 * 60 ) {
                $sql = 'DELETE FROM aspirantes WHERE id_aspirante=' . $id_aspirante;
                $result = $base->safe_query($sql);
            }
	}
	
	$base->close();
?>