<?php
    session_start();
//function __autoload($nombre_clase) {
    //include 'includes/clases/' . $nombre_clase . '.php';
    include 'includes/clases/connection.php';
    //require( 'includes/clases/PHPMailerAutoload.php');
//}

function generate_password() {
    $strength = 9;
    $length = 9;
    $vowels = 'aeuy';
    $consonants = 'bdghjmnpqrstvz';
    if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
    }
    if ($strength & 2) {
            $vowels .= "AEUY";
    }
    if ($strength & 4) {
            $consonants .= '23456789';
    }
    if ($strength & 8) {
            $consonants .= '@#$%';
    }

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                    $password .= $consonants[(rand() % strlen($consonants))];
                    $alt = 0;
            } else {
                    $password .= $vowels[(rand() % strlen($vowels))];
                    $alt = 1;
            }
    }
    return $password;
}   

function home_base_url(){   
    $currentPath = $_SERVER['PHP_SELF']; 

    $hostName = $_SERVER['HTTP_HOST']; 
    
    $uri = $_SERVER['REQUEST_URI'];
    $exploded_uri = explode('/', $uri);
    $domain_name = $exploded_uri[1];

    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';

    return $protocol.$hostName."/".$domain_name."/";
}
    
//session_start();
if (!isset($_SESSION['connect'])) {
    $connection = new connection;
    if ( isset($_POST['email']) && isset($_POST['pass']) ) {
        $email = filter_input(INPUT_POST, 'email');
        $pass = filter_input(INPUT_POST, 'pass');
        
        $sql="SELECT * FROM aspirantes WHERE 
                email='".$email."' 
                AND pass='".md5($pass)."'";
        $result = $connection->safe_query($sql);
        if ($connection->NumFilas($result)==0){
                //header("location:index.php?validar=error&email=".$email);
                $message= 'Error en la contraseña ingresada';
        } else {
                $_SESSION['connect'] = 'conectado';
                $_SESSION['email'] = $email;
                header("location:index.php");
        }
        
        $activation_active = 'active';
        
    } else {
        $activation_active = 'active';
        
        $message = '';
        
        $action = filter_input(INPUT_GET, 'action');
        
        if ( $action == 'confirmar_usuario') {
            
            $email = filter_input(INPUT_GET, 'mail');
            $key = filter_input(INPUT_GET, 'key');
            
            
            $sql="SELECT * FROM aspirantes WHERE 
                    email='".$email."' 
                    AND pass='".$key."'";
            $result = $connection->safe_query($sql);
            if ( $connection->NumFilas($result) != 0 ) {
                //confirmar usuario
                //genera contraseña, actualiza la BD y manda un mail
                
                $pass = generate_password();
                
                $url =  home_base_url();
                
                $aspirante = $connection->f_array($result);
                $id_aspirante = $aspirante['id_aspirante'];
                
                $sql  = 'UPDATE aspirantes SET ';
                $sql .= 'estado=NULL, ';
                $sql .= 'pass="'.md5($pass).'" ';
                $sql .= 'WHERE id_aspirante='.$id_aspirante;
                
                $result = $connection->safe_query($sql);
                
                //mail de confirmación
                $subject = 'Semm - Usuario confirmado';
                $mail_message = '<html><head></head><body>';
                $mail_message .= '<div style="text-align: center;">';
                $mail_message .= '<img src="' . $url . 'includes/images/logo-semm.png" />';
                $mail_message .= '</div>';
                $mail_message .= '<h1 style="font-size: 2em; font-weight: bold; ">El usuario ha sido confirmado</h1>';
                $mail_message .= '<h2>Puede usar la siguiente contrase&ntilde;a para ingresar:</h2><br />';
                $mail_message .= '<h1 style="font-size: 2em; font-weight: bold; ">'.$pass.'</h1>';
                $mail_message .= '<p style="text-align: center;">';
                $mail_message .= 'Luego de haber ingresado al sistema, le recomendamos que actualice su contrase&ntilde;a.';
                $mail_message .= '</p>';
                $mail_message .= '</body></html>';

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

                $mail->AddAddress( $email );
                $mail->IsHTML(true);
                $mail->Subject = $subject; 
                $mail->Body = $mail_message; 

                $exito = $mail->Send(); 

                if($exito) {
                    $message = "Usuario confirmado, un mail con la contraseña fue enviado a su casilla de correo";
                } else {
                    $message = "Hubo un inconveniente. Contacta a un administrador.";
                }*/
                
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: SEMM - Recursos Humanos <rrhh@semm.com.uy>';


                mail($email, $subject, $mail_message, $headers);
                $message = "Usuario confirmado, un mail con la contraseña fue enviado a su casilla de correo";


//			$message = $password;

                $activation_active = 'active';
            } else {
                //no coincide la clave, usuario no confirmado
                $message = "Error de credenciales.";
                $activation_active = 'active';
            }
            

            
        } else {
            $user = filter_input(INPUT_POST, 'user');
            if ( isset($user) ) {
                $sql = 'SELECT * FROM aspirantes WHERE email="' . $user . '"';
                $result = $connection->safe_query($sql);
                if ( $connection->NumFilas($result)!=0 ){
                    $url =  home_base_url();
                
                    $aspirante = $connection->f_array($result);
                    
                    $pass = generate_password();
                
                    //$aspirante = $connection->f_array($result);
                    $id_aspirante = $aspirante['id_aspirante'];

                    $sql  = 'UPDATE aspirantes SET ';
                    $sql .= 'estado=NULL, ';
                    $sql .= 'pass="'.md5($pass).'" ';
                    $sql .= 'WHERE id_aspirante='.$id_aspirante;

                    $result = $connection->safe_query($sql);

                    //mail de confirmación
                    $subject = 'Semm - Cambio de contrase&ntilde;a';
                    $mail_message = '<html><head></head><body>';
                    $mail_message .= '<div style="text-align: center;">';
                    $mail_message .= '<img src="' . $url . 'includes/images/logo-semm.png" />';
                    $mail_message .= '</div>';
                    $mail_message .= '<h1 style="font-size: 2em; font-weight: bold; ">Modificaci&oacute;n de contrase&ntilde;a</h1>';
                    $mail_message .= '<h2>Una nueva contrase&ntilde;a ha sido generada:</h2><br />';
                    $mail_message .= '<h1 style="font-size: 2em; font-weight: bold; ">'.$pass.'</h1>';
                    $mail_message .= '<p style="text-align: center;">';
                    $mail_message .= 'Luego de haber ingresado al sistema, le recomendamos que actualice su contrase&ntilde;a.';
                    $mail_message .= '</p>';
                    $mail_message .= '</body></html>';
                    
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: SEMM - Recursos Humanos <rrhh@semm.com.uy>';


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

                    $mail->AddAddress( $user );
                    $mail->IsHTML(true);
                    $mail->Subject = $subject; 
                    $mail->Body = $mail_message; 

                    $exito = $mail->Send(); 

                    if($exito) {
                        $message = 'Un mail con la contraseña fue enviado a su casilla de correo';
                    } else {
                        $message = 'Hubo un inconveniente. Contacta a un administrador.';
                    }*/
                    
                    mail($user, $subject, $mail_message, $headers);

                    $message = "Un mail con la contraseÃ±a fue enviado a su casilla de correo";


                } else {
                    $message = "Mail no registrado en el sistema";
                }
                
            }
        }
        
    }
    $connection->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Semm - CV M&eacute;dicos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" type="text/css" href="includes/css/styles.css" />
	   <script type="text/javascript" src="includes/js/jquery-1.9.1.min.js"></script>

	   <script type="text/javascript" src="includes/js/login.js"></script>
           
           
	   
    </head>
    <body>
        <div class="wrap">
            <div class="inicio">
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>"></a>
                    <h1>Edici&oacute;n de CV</h1>
            </div>
            <div style="clear:both"></div>
            <div id="form_wrapper" class="form_wrapper">
                <?php if ( $activation_active == 'active' ) : ?>
                    <form class="activation" method="post">
                        <h3>Registro de Usuario</h3>
                        <div>
                                <label>Ingrese su Correo Electr&oacute;nico</label>
                                <input type="text" name="email_activation" id="email_activation" />
                                <img id="captcha" src="includes/securimage/securimage_show.php" alt="CAPTCHA Image" />
                                <div id="captcha_div">
                                    <input type="text" name="captcha_code" size="10" maxlength="6" />
                                    <a href="#" onclick="document.getElementById('captcha').src = 'includes/securimage/securimage_show.php?' + Math.random(); return false">
                                        Cambiar imagen
                                    </a>
                                    <span id="verificar_captcha">Verificar</span>
                                </div>
                        </div>
                        <div class="bottom">
                            <div id="message" class="message"><?php echo $message ?></div>
                            <input type="submit" value="Enviar" id="activate" disabled="disabled" />
                            <a href="index.php" rel="login" class="linkform">
                                ¿Ya est&aacute; registrado? Entre aqu&iacute;
                            </a>
                            <div class="clear"></div>
                        </div>
                    </form>
                    
                    <form class="login active" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <h3>Login</h3>
                            <div>
                                    <label>Correo Electr&oacute;nico:</label>
                                    <input type="text" name="email" value="" tabindex="1" />
                            </div>
                            <div>
                                    <label>Contrase&ntilde;a: 
                                            <a href="index.php" rel="forgot_password" class="forgot linkform">
                                            Olvid&oacute; su contrase&ntilde;a?
                                            </a>
                                    </label>
                                    <input type="password" name="pass" tabindex="2" />
                            </div>
                            <div class="bottom">
                                    <div id="message" class="message"><?php echo $message; ?></div>
                                    <input type="submit" value="Login" tabindex="3" />
                                    <a href="index.php" rel="activation" class="linkform">
                                            ¿No est&aacute; registrado? Entre aqu&iacute;
                                    </a>
                                    <div class="clear"></div>
                            </div>
                    </form>
                    <form class="forgot_password" method="post">
                            <h3>Olvid&oacute; su contrase&ntilde;a?</h3>
                            <div>
                                    <label>Nombre de usuario o Email:</label>
                                    <input type="text" name="user" />
                            </div>
                            <div class="bottom">
                                    <input type="submit" value="Enviar recordatorio"></input>
                                    <a href="index.php" rel="login" class="linkform">
                                            ¿Ya est&aacute; registrado? Entre aqu&iacute;
                                    </a>
                                    <div class="clear"></div>
                            </div>
                    </form>
                <?php else : ?>
                <form class="register active" method="post">
                    <h3>Registro de Aspirante</h3>
                    <div class="column">
                            <div>
                                    <label>Nombre:</label>
                                    <input type="text" name="name" id="name" />
                            </div>
                            <div>
                                    <label>Apellido:</label>
                                    <input type="text" name="last_name" id="last_name" />
                            </div>
                            <div>
                                    <label>Fecha de nacimiento:</label>
                                    <input type="text" name="born_date" id="born_date" value="dd/mm/yyyy" title="Entre la fecha en el formato indicado" />
                            </div>
                            <div>
                                    <label>C&eacute;dula de Identidad:</label>
                                    <input type="text" name="ci_num" id="ci_num" title="Entre la c&eacute;dula sin puntos ni comas" placeholder="######.#" />
                            </div>
                            <div>
                                    <label>N&uacute;mero de Caja Profesional:</label>
                                    <input type="text" name="cp_num" id="cp_num" />
                            </div>
                    </div>
                    <div class="column">
                            <div>
                                    <label>N&uacute;mero de Tel&eacute;fono:</label>
                                    <input type="text" name="tel_num" id="tel_num" />
                            </div>
                            <div>
                                    <label>N&uacute;mero de Celular:</label>
                                    <input type="text" name="cel_num" id="cel_num" />
                            </div>
                            <div>
                                    <label>Correo Electr&oacute;nico:</label>
                                    <input type="text" name="email" id="email" />
                            </div>
                            <div>
                                    <label>Password:</label>
                                    <input type="password" name="pass" id="pass" />
                            </div>
                    </div>
                    <div class="bottom">
                            <input type="button" value="Registrar" id="register" />
                            <a href="index.php" rel="login" class="linkform">
                                    ¿Ya est&aacute; registrado? Entre aqu&iacute;
                            </a>
                            <div class="clear"></div>
                    </div>
            </form>
	<?php endif; ?>
	
        </div>
    </div>
    </body>
</html>
<?php
} else {
//conectado
    include("includes/form.php");
}
?>