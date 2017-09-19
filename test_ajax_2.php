<?php
    include 'includes/clases/connection.php';
    $id_aspirante = $_POST['id_aspirante'];
    $sql  = 'SELECT * FROM aspirantes WHERE ';
    $sql .= 'id_aspirante = "'.$id_aspirante.'" ';
    
    $base = new connection;
    
    $result = $base->safe_query($sql);
    $row = $base->f_array($result);

    $nombre_completo = $row['name'].' '.$row['last_name'];
    $fecha_nacimiento = date('j/n/Y', strtotime($row['born_date']) );
    $ced_identidad = $row['ci_num'];
    $caja_profesional = $row['cp_num'];
    $tel_num = $row['tel_num'];
    $cel_num = $row['cel_num'];
    $mail = $row['email'];
    $fecha_ingreso = date('j/n/Y', strtotime($row['create_cv_date']) );
    $fecha_actualizacion = date('j/n/Y', strtotime($row['fecha_actualizacion_cv']) );
    
    $response =  '<tr><td>'.$nombre_completo.'</td><td>'.$fecha_nacimiento.'</td><td>'.$ced_identidad.'</td><td>'.$caja_profesional.'</td><td>'.$tel_num;
    $response .= '</td><td>'.$cel_num.'</td><td>'.$mail.'</td><td>'.$fecha_ingreso.'</td><td>'.$fecha_actualizacion.'</td></tr>';
    echo $response;
?>