<?php
//ini_set('display_errors', 1); 
//error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    include 'clases/connection.php';
//}
    //require( 'clases/PHPMailerAutoload.php');

function home_base_url(){   
    $currentPath = $_SERVER['PHP_SELF']; 

    $hostName = $_SERVER['HTTP_HOST']; 
    
    $uri = $_SERVER['REQUEST_URI'];
    $exploded_uri = explode('/', $uri);
    $domain_name = $exploded_uri[1];

    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';

    return $protocol.$hostName."/".$domain_name."/";
}
    
    
$action = filter_input(INPUT_POST, 'action');

if ($action == 'activate') {
    $email_activation = filter_input(INPUT_POST, 'email_activation', FILTER_VALIDATE_EMAIL);
    
    if ( !$email_activation ) {
        $response = "Error de formato de mail";
    } else {
        
        $user_activation = new connection;

        $sql = "SELECT * FROM aspirantes WHERE email='".$email_activation."'";
        $result = $user_activation->safe_query($sql);

        if ($user_activation->NumFilas($result)!=0){
            $response = 'Error, el correo electrónico ya está registrado';
        } elseif( strlen($email_activation) > 254 ) {
            $response = 'El mail ingresado tiene un formato incorrecto';
        } else {
            $key = uniqid();
            $fecha_actual = date('Y-m-d H:i:s');
            $sql="INSERT INTO aspirantes SET 
                    email='".$email_activation."',
                    estado='PENDIENTE',  
                    create_cv_date='".$fecha_actual."',
                    pass='".$key."' ";
            $result = $user_activation->safe_query($sql);

            $url =  home_base_url();

            $keyLink = $url . "?action=confirmar_usuario&mail={$email_activation}&key={$key}";
            
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: SEMM - Recursos Humanos <rrhh@semm.com.uy>';

            
            $button_style = "width:60%; padding: 13px 100px; text-align:center; text-decoration: none; border-radius: 4px; color: #fff; background: #e96656; display: inline-block;";
            
            $mail_message  = '<html>';
            $mail_message .= '<body>';
            $mail_message .= '<div style="text-align: center;">';
            $mail_message .= '<img src="' . $url . 'includes/images/logo-semm.png" />';
            $mail_message .= '</div>';
            $mail_message .= '<div style="margin: 20px 0; padding: 20px; border= 1px solid #ccc; border-radius: 5px;">';
            $mail_message .= '<h1 style="font-size: 2em; font-weight: bold; ">Bienvenido</h1>';
            $mail_message .= '<h2>Tu registro est&aacute; casi completo</h2><br />';
            $mail_message .= '<p style="text-align: center;">';
            $mail_message .= '<a style="' . $button_style . '" href="' . $keyLink . '">';
            $mail_message .= 'ACTIVAR REGISTRO';
            $mail_message .= '</a>';
            $mail_message .= '</p>';
            $mail_message .= '</body>';
            $mail_message .= '</div>';
            $mail_message .= '</html>';
            
            $subject = 'SEMM - CONFIRMACIÓN DE REGISTRO';
            
            mail($email_activation, $subject, $mail_message, $headers);
            
            $response = 'Registro activado, ahora revise su e-mail';
            
            /*$mail = new PHPMailer();
            
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = "mail.semm.com.uy";
            $mail->Username = 'lared@semm.com.uy';
            $mail->Password = 'Iechaw8H!';
            $mail->Port = 587; 
            $mail->SMTPSecure = 'tls';

            $mail->From = "rrhh@semm.com.uy";
            $mail->FromName = "From: SEMM - Recursos Humanos";

            $mail->AddAddress( $email_activation );
            $mail->IsHTML(true);
            $mail->Subject = $subject; 
            $mail->Body = $mail_message; 
            
            $exito = $mail->Send(); 

            if($exito) {
                $response = 'Registro activado, ahora revise su e-mail';
            } else {
                $response = 'Hubo un inconveniente. Contacta a un administrador.';
            }*/
        }
        $user_activation->close();
    }
    
    echo $response;
    //die();
} else {

    $name = filter_input(INPUT_POST, 'name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    $born_date = filter_input(INPUT_POST, 'born_date');
    $ci_num = filter_input(INPUT_POST, 'ci_num');
    $cp_num = filter_input(INPUT_POST, 'cp_num');
    $tel_num = filter_input(INPUT_POST, 'tel_num');
    $cel_num = filter_input(INPUT_POST, 'cel_num');
    $email = filter_input(INPUT_POST, 'email');
    $pass = filter_input(INPUT_POST, 'pass');
    
    $aspirante = new connection;

    $sql="SELECT * FROM aspirantes
            WHERE email='".$email."'";
    $result = $aspirante->safe_query($sql);

    if ($aspirante->NumFilas($result)!=0){
//            echo "Ya existe un usuario registrado con ese correo electrónico, por favor elija otro...";
            $sql="UPDATE aspirantes SET 
                    name='".$name."', 
                    last_name='".$last_name."', 
                    born_date='".date("Y-m-d H:i:s", strtotime($born_date))."', 
                    ci_num='".$ci_num."', 
                    cp_num='".$cp_num."', 
                    tel_num='".$tel_num."',
                    cel_num='".$cel_num."',
                    email='".$email."',
                    pass='".md5($pass)."' ";
            $result = $aspirante->safe_query($sql);

            $subject = 'REGISTRO CORRECTO';
            $mail_message = 'El procedimiento se realizó correctamente, ahora puede ingresar para actualizar su CV.';

            $mail = new PHPMailer();
            
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = "mail.semm.com.uy";
            $mail->Username = 'lared@semm.com.uy';
            $mail->Password = 'Iechaw8H!';
            $mail->Port = 587; 
            $mail->SMTPSecure = 'tls';

            $mail->From = "rrhh@semm.com.uy";
            $mail->FromName = "From: SEMM - Recursos Humanos";

            $mail->AddAddress( $email );
            $mail->IsHTML(true);
            $mail->Subject = $subject; 
            $mail->Body = $mail_message; 
            
            $exito = $mail->Send(); 

            if($exito) {
                $response = 'Aspirante registrado correctamente';
            } else {
                $response = 'Hubo un inconveniente. Contacta a un administrador.';
            }
            
            echo $response;
            
    }


    $aspirante->close();
}



?>