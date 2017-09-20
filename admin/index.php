<?php
session_start();

include '../includes/clases/connection.php';
$base = new connection;

if (!isset($_SESSION['conectado'])) :
//}
        $administrador = filter_input( INPUT_POST, 'administrador' );
        $clave = md5(filter_input( INPUT_POST, 'clave' ));

	//si no está conectado hay que chequear nombre/contraseña
	if ( isset( $administrador ) ) :
                //la contraseña del administrador está grabada enla base de datos
		//si no existe se crea con los valores por defecto
                $result = $base->safe_query( "SELECT * FROM aspirantes WHERE estado='administrador'" );
                if ( ! $base->NumFilas($result) ) :
                    $date = date('Y-m-d H:i:s');
                    $clave = md5(admin);
                    $result = $base->safe_query( 
                            "INSERT INTO aspirantes "
                            . "(estado, name, last_name, born_date, ci_num, cp_num, tel_num, cel_num, email, pass, egreso_facultad, imagen, create_cv_date, fecha_actualizacion_cv) "
                            . "VALUES ('administrador', 'admin', '', '$date', 0, 0, '', '', '', '$clave', 0, '', '$date', '$date');"
                    );
                endif;
                $result = $base->safe_query("SELECT * FROM aspirantes WHERE name='$administrador' AND pass='$clave' AND estado='administrador'");
                if ( $base->NumFilas($result) ) :
                    $usuario = $base->f_array($result);
                    $_SESSION['conectado'] = 'conectado';
                    $_SESSION['id_aspirante'] = $usuario['id_aspirante'];
                    include('../includes/cms.php');
                else :    
                    header("location:index.php?validar=error");
                endif;
                $base->close();
		/*if ( $_POST['administrador'] == $nombre && md5( $_POST['clave'] ) == $clave ){
                    
                    $_SESSION['conectado'] = 'conectado';
			include('../includes/cms.php');
		} else {
			header("location:index.php?validar=error");
		}*/
	
	else :
		//si no está conectado y no se pasa el nombre del administrador hay que pedir nombre/contraseÃ±a
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <script language="javascript">
            function validar(form) {
                if (form.administrador.value=='') {
                        alert('Por favor ingrese el nombre');
                        form.administrador.focus();
                        return (false);
                }
                if (form.clave.value=='') {
                        alert('Por favor ingrese la contrase\u00f1a');
                        form.clave.focus();
                        return (false);
                }
            }
            window.onload = function() {
              document.getElementById("administrador").focus();
            }
        </script>
        <style type="text/css">
            *{ font-family:Arial, Helvetica, sans-serif; margin:0; padding:0;}
            .wrap{margin:0 auto; width:990px; padding:10px; text-align:center;}
            p{margin-top:20px;}
            p.tit {font-weight:bold;margin-top:50px;}
            input[type="submit"]{ font-size:20px; padding:3px 20px; display:block; margin:50px auto 0;}
        </style>
    </head>
    <body>
        <div class="wrap">
            <img src="../includes/images/logo-semm.png" />
            <h1>Buscador de CV</h1>
            <p class="tit">LOGIN</p>
            <form id="form1" name="form1" method="post" target="_top" action="<?php echo $_SERVER['PHP_SELF']; ?>" onSubmit="return validar(this)">
                <p>Administrador</p>
                <input name="administrador" type="text" id="administrador" />
                <p>Contrase&ntilde;a</p>
                <input name="clave" type="password" id="clave" />
                <?php if (isset($_GET['validar'])&&($_GET['validar']=='error')) : ?>
                    <p style="color: #ff0000; font-size: 14px;">Error, contrase&ntilde;a incorrecta</p>
                <?php endif; ?>
                <input type="submit" name="Submit" value="Acceder" />
            </form>
        </div>
    </body>
</html>
<?php 
	endif; 
else :
	include('../includes/cms.php');
endif;
?>