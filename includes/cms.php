<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    //include 'clases/connection.php';
//}


//$base = new connection;
//global $base;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Semm - Buscador de CV</title>
<link rel="stylesheet" type="text/css" href="../includes/css/styles.css" />
<link rel="stylesheet" type="text/css" href="../includes/js/jquery-ui.min.css" />
<link rel="stylesheet" type="text/css" href="../includes/js/jquery.ui.accordion.min.css" />
<script type="text/javascript" src="../includes/js/jquery-1.9.1.min.js"></script>

<script type="text/javascript" src="../includes/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../includes/js/accordion.js"></script>
<script type="text/javascript" src="../includes/js/buscador.js"></script>
<script type="text/javascript" src="../includes/js/jquery.table2excel.min.js"></script>
<script type="text/javascript">
  $(function() {
    $( "#tabs" ).tabs();
  });
</script>
</head>

<body>
<div class="wrap">
    <div class="form_wrap">
	<div class="inicio">
            <a class="home" href="<?php echo $_SERVER['PHP_SELF']; ?>"></a>
            <h1>Buscador de CV</h1>
            <div class="admin_menu">
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Postulantes</a> |
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=USR">Administradores</a> |
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=END">Cerrar sesi&oacute;n</a>
            </div>
	</div>
	<div style="clear:both;"></div>
        <?php 
            $action = filter_input( INPUT_GET, 'action' );
            $id = filter_input( INPUT_GET, 'ID' );
            $nombre_estado = filter_input( INPUT_POST, 'nombre_estado' );
            $id_estado = filter_input( INPUT_POST, 'id_estado' );
            
            $submit = filter_input( INPUT_POST, 'submit' );
            
            $old_pwd = filter_input( INPUT_POST, 'old_pwd' );
            $new_pwd1 = filter_input( INPUT_POST, 'new_pwd1' );
            $new_pwd2 = filter_input( INPUT_POST, 'new_pwd2' );
            $mensaje = '';
            $class = 'normal';
        ?>
        
        <?php if ( isset( $action ) && $action == 'USR' ) : ?>
        
        <?php 
            $old_pwd = filter_input( INPUT_POST, 'old_pwd' );
            $new_pwd1 = filter_input( INPUT_POST, 'new_pwd1' );
            $new_pwd2 = filter_input( INPUT_POST, 'new_pwd2' );
            $id_aspirante = filter_input( INPUT_POST, 'id_aspirante' );
            $submit = filter_input( INPUT_POST, 'submit' );
            $name = filter_input( INPUT_POST, 'name' );
            $email = filter_input( INPUT_POST, 'email', FILTER_VALIDATE_EMAIL );
            $show = 1;
            
            if ( $submit == 'Modificar' ) :
                if ( $email == '' || $new_pwd1 == '' || $new_pwd2 == '' ) :
                    $mensaje = 'Debe completar todos los datos';
                    $class = 'error';
                elseif ( ! $email ):
                    $mensaje = 'Email incorrecto';
                    $class = 'error';
                else :
                    $result = $base->safe_query("SELECT * FROM aspirantes WHERE id_aspirante='$id_aspirante' AND estado='administrador'");
                    $usuario = $base->f_array($result);
                    if( $base->NumFilas($result) != 0 ) :
                        if ( $new_pwd1 != $new_pwd2 ) :
                            $mensaje = 'La confirmaci&oacute;n no coincide';
                            $class = 'error';
                        else :
                            $pass = md5( $new_pwd1 );
                            $result = $base->safe_query("UPDATE aspirantes SET email='$email', pass='$pass' WHERE id_aspirante='$id_aspirante' AND estado='administrador'");

                            $mensaje = 'El usuario fue correctamente actualizado';
                            $class = 'normal';
                        endif;
                    endif;
                endif;
            elseif ( $submit == 'Agregar' ) :
                if ( $name == '' || $new_pwd1 == '' || $new_pwd2 == '' ) :
                    $mensaje = 'Debe completar todos los datos';
                    $class = 'error';
                elseif ( ! $email ):
                    $mensaje = 'Email incorrecto';
                    $class = 'error';
                else :
                    $result = $base->safe_query("SELECT * FROM aspirantes WHERE name='$name'");
                    $usuario = $base->f_array($result);
                    if( $base->NumFilas($result) == 0 ) :
                        if ( $new_pwd1 != $new_pwd2 ) :
                            $mensaje = 'La confirmaci&oacute;n no coincide';
                            $class = 'error';
                        else :
                            $pass = md5( $new_pwd1 );
                            $date = date('Y-m-d H:i:s');
                            $result = $base->safe_query( 
                                    "INSERT INTO aspirantes "
                                    . "(estado, name, last_name, born_date, ci_num, cp_num, tel_num, cel_num, email, pass, egreso_facultad, imagen, create_cv_date, fecha_actualizacion_cv) "
                                    . "VALUES ('administrador', '$name', '', '$date', 0, 0, '', '', '$email', '$pass', 0, '', '$date', '$date');"
                            );

                            $mensaje = 'El administrador fue ingresado correctamente';
                            $class = 'normal';
                        endif;
                        
                    else :
                        $mensaje = 'El nombre ya est&aacute; registrado';
                        $class = 'error';
                    endif;
                endif;
            elseif ( $submit == 'Borrar' ) :
                $result = $base->safe_query("DELETE FROM aspirantes WHERE id_aspirante='$id_aspirante' AND estado='administrador'");
                $mensaje = 'El usuario fue correctamente eliminado';
                $class = 'normal';
            endif;
            
        ?>
        
        <div id="accordion">
            <h3>Listado de Administradores</h3>
            <div>
            <?php 
            $result = $base->safe_query( "SELECT * FROM aspirantes WHERE estado='administrador'" );
            ?>
                <table class="admin-data">
                    <tr class="header">
                        <td style="width: 100px;">id</td>
                        <td style="width: 800px;">nombre</td>
                    </tr>
                </table>
                <table class="admin-result" id="tabla_usuarios" style="width: 100%">
                <?php while($row = $base->f_array($result)) : ?>
                    <tr>
                        <td style="width: 100px;"><?php echo $row['id_aspirante']?></td>
                        <td style="width: 800px;"><?php echo $row['name']?></td>
                    </tr>

                <?php endwhile; ?>
                </table>
            </div>
            <h3 id="tab_perfil">Perfil</h3>
            <?php 
            $id_aspirante = $_SESSION['id_aspirante'];
            $result = $base->safe_query( "SELECT * FROM aspirantes WHERE id_aspirante=$id_aspirante AND estado='administrador'" );
            $row = $base->f_array($result);
            $name = $row['name'];
            $email = $row['email'];
            ?>
            <div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?action=USR" class="mod_pwd">
                    <input type="hidden" id="id_aspirante" name="id_aspirante" value="<?php echo $_SESSION['id_aspirante'] ?>" />
                    <table style="border-collapse: collapse; ">
                        <tr style="border:none;">
                            <td>Nombre:</td>
                            <td id="name_aspirante"><?php echo $name ?></td>
                        </tr>
                        <tr style="border:none;">
                            <td>Email:</td>
                            <td><input type="text" name="email" value="<?php echo $email ?>" /></td>
                        </tr>
                        
                        <tr style="border:none;">
                            <td>Contrase&ntilde;a:</td>
                            <td><input type="password" name="new_pwd1" /></td>
                        </tr>
                        <tr style="border:none;">
                            <td>Confirmar Contrase&ntilde;a:</td>
                            <td><input type="password" name="new_pwd2" /></td>
                        </tr>
                    </table>
                    
                    <p style="text-align: right;">
                        <input type="submit" name="submit" value="Modificar" />
                    </p>
                    
                    <p style="text-align: right; border-top: 1px solid #ccc; margin-top: 15px; padding-top: 15px;">
                        <input type="checkbox" id="borrar_usuario" />
                        <input type="submit" name="submit" value="Borrar" disabled="disabled" />
                    </p>
                </form>
            </div>
            <h3>Agregar Administrador</h3>
            <div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?action=USR" class="mod_pwd">
                    <table style="border-collapse: collapse; ">
                        <tr style="border:none;">
                            <td>Nombre:</td>
                            <td><input type="text" name="name" /></td>
                        </tr>
                        <tr style="border:none;">
                            <td>Email:</td>
                            <td><input type="text" name="email" /></td>
                        </tr>
                        
                        <tr style="border:none;">
                            <td>Contrase&ntilde;a:</td>
                            <td><input type="password" name="new_pwd1" /></td>
                        </tr>
                        <tr style="border:none;">
                            <td>Confirmar Contrase&ntilde;a:</td>
                            <td><input type="password" name="new_pwd2" /></td>
                        </tr>
                    </table>
                    
                    <p><input type="submit" name="submit" value="Agregar"  style="float: right;" /></p>
                </form>
            </div>
        </div>
        <p class=" mensaje <?php echo $class ?>"><?php echo $mensaje ?></p>
        <?php else : ?>
        <?php 
        if ( isset( $action ) && $action == 'ESTADO' ) : 
            if( isset( $nombre_estado ) && $nombre_estado != '' ) :
                if( isset( $id_estado ) && $id_estado != '' ) :
                    $result = $base->safe_query( "UPDATE estados SET nombre_estado='$nombre_estado' WHERE id_estado='$id_estado'" );
                else :
                    $result = $base->safe_query( "INSERT INTO estados (nombre_estado) VALUES ('$nombre_estado')" );
                endif;
            endif;
        elseif ( isset( $action ) && ( $action == 'BORRAR_ESTADO' ) && ( $id != '') ) :
            $result = $base->safe_query( "DELETE FROM  estados WHERE id_estado = $id" );
            $result = $base->safe_query( "SELECT * FROM aspirantes WHERE estado REGEXP '$id$|$id,'" );
            while($row = $base->f_array($result)) :
                $estado = $row['estado'];
                $id_aspirante = $row['id_aspirante'];
                $nuevo_estado = str_replace($id, '', $estado);
                if (strlen($nuevo_estado)>0) :
                    $nuevo_estado = str_replace(',,', ',', $nuevo_estado);
                    $nuevo_estado = rtrim($nuevo_estado, ',');
                    $nuevo_estado = ltrim($nuevo_estado, ',');
                    /*if( substr ( $nuevo_estado, -1 ) == ',' ) {

                    }*/
                endif;
                $result2 = $base->safe_query( "UPDATE aspirantes SET estado='$nuevo_estado' WHERE id_aspirante='$id_aspirante'" );
            endwhile;

        elseif ( isset( $action ) && $action == 'END' ) :
            session_start();    
            session_destroy();
            header('location:index.php');
            //exit();
        endif;
        ?>
        
	<div id="accordion">
            <h3>Informaci&oacute;n General</h3>
            <div>
  		<div class="column2">
	  		<label class="label">Nombre:</label><input type="text" class="text1" id="name" />
			<label class="label">Apellido:</label><input type="text" class="text1" id="last_name" />
			<label class="label">Fecha nacimiento:</label><input type="text" class="text1" id="born_date" 
			title="Entre la fecha con el formato dd/mm/yyyy" />
			<label class="label">C&eacute;dula de Identidad:</label><input type="text" class="text1" id="ci_num" />
		</div>
  		<div class="column2">
                    <label class="label">N&uacute;mero de Caja Profesional:</label><input type="text" class="text1" id="cp_num" />
                    <label class="label">Tel&eacute;fono:</label><input type="text" class="text1" id="tel_num" />
                    <label class="label">Celular:</label><input type="text" class="text1" id="cel_num" />
                    <label class="label">A&ntilde;o egreso Fac. Medicina:</label><input type="text" class="text1" id="egreso_facultad" />
		</div>
  		<div class="column2">
			<label class="label">Correo Electr&oacute;nico:</label><input type="text" class="text1" id="email" /><br />
                        
                        <div style=" width: 100%; height:70px; overflow-y: auto;">
                            <?php 
                                $sql = 'SELECT * FROM estados ORDER BY id_estado';
                                $result = $base->safe_query($sql);
                            ?>
                            <?php if ( $base->NumFilas($result) != 0 ) : ?>
                            <ul class="estados" id="buscar_estados">
                                <?php while ($row = $base->f_array($result)): ?>
                                <li><?php echo $row['nombre_estado'] ?><input class="estado" type="checkbox" id="<?php echo $row['id_estado']?>" /></li>
                                <?php  endwhile; ?>
                            </ul>
                            <?php endif;?>
                        </div>
			<input type="button" value="Borrar formulario" class="button2 borrar1" />
			<input type="button" value="Buscar" class="button buscar" />
		</div>
            </div>
            <h3>Formaci&oacute;n de Postgrado / Cursos de Apoyo Extrahospitalario / Otros Cursos / Experiencia Laboral</h3>
            <div>
		<div class="column2">
                    <label class="label">Especialidades:</label>
                    <select multiple="multiple" name="especialidades" id="especialidades" class="select">
                        <?php $result = $base->safe_query( 'SELECT * FROM especialidades ORDER BY especialidades.nombre_especialidad ASC' ); ?>
                        <?php while( $row = $base->f_array($result) ) : ?>
                            <option value="<?php echo $row['id_especialidades'] ?>"><?php echo $row['nombre_especialidad'] ?></option>
                        <?php endwhile; ?>
                    </select>
	  	</div>
		<div class="column2">
                    <label class="label">Cursos de Apoyo:</label>
                    <select multiple="multiple" name="cursos" id="cursos" class="select">
                        <?php $result = $base->safe_query( 'SELECT * FROM cursos ORDER BY id_curso' ); ?>
                        <?php while( $row = $base->f_array($result) ) : ?>
                            <option value="<?php echo $row['id_curso'] ?>"><?php echo $row['curso_nombre'] ?></option>
                        <?php endwhile; ?>
                    </select>
		</div>
		<div class="column2">
                    <label class="label">Otros Cursos:</label>
                    <select multiple="multiple" name="cursos" id="otros_cursos" class="select">
                        <?php $result = $base->safe_query('SELECT * FROM otros_cursos ORDER BY id_otros_cursos'); ?>
                        <?php while ($row = $base->f_array($result)) : ?>
                            <option value="<?php echo $row['id_otros_cursos'] ?>"><?php echo $row['otros_cursos_nombre'] ?></option>
                        <?php endwhile; ?>
                    </select>
		</div>
		<div class="column2">
                    <label class="label">Experiencia laboral:</label>
                    <input name="experiencia" id="experiencia" type="text" class="text2" />
                    <label class="label">Participaci&oacute;n en Congresos:</label>
                    <input name="congresos" id="congresos" type="text" class="text2" />
                    <label class="label">Idiomas:</label>
                    <input name="idiomas" id="idiomas" type="text" class="text2" />
                    <label class="label">Otros m&eacute;ritos:</label>
                    <input name="meritos" id="meritos" type="text" class="text2" />
		</div>
		<div class="column2">
                    <label class="label">Referencias:</label>
                    <input type="text" name="referencias" id="referencias"  class="text2" />
                    <input type="button" value="Borrar formulario" class="button2 borrar2" />
                    <input type="button" value="Buscar" class="button buscar" />
		</div>
            </div>
            <h3 id="tab_resultados">Resultados</h3>
            <div id="data">
		<table class="admin-data">
                    <tr class="header">
                        <td style="width: 250px">Nombre</td>
                        <td style="width: 100px">Telefono</td>
                        <td style="width: 300px">Estado</td>
                        <td style="width: 250px">Email</td>
                    </tr>
		</table>
		<div id="resultados"></div>
                <button class="button3" id="bajar_excel" disabled="disabled">Bajar a Excel</button>
            </div>
            <h3 id="tab_detalles">Detalles</h3>
            <div id="tabs">
		<ul>
			<li><a href="#tab-1">Informaci&oacute;n personal</a></li>
			<li><a href="#tab-2">Postgrados / Cursos</a></li>
			<li><a href="#tab-3">Otros cursos / Exp. Laboral</a></li>
			<li><a href="#tab-4">Congresos / Idiomas</a></li>
			<li><a href="#tab-5">M&eacute;ritos / Referencias / Adjuntos</a></li>
		</ul>
		<div id="tab-1">
                    <div class="column">
                        <input type="hidden" id="id_del_aspirante" value="" />
                        Nombre completo: <span class="data" id="nombre_completo"></span><br />
                        Fecha de nacimiento: <span class="data" id="fecha_nacimiento"></span><br />
                        C&eacute;dula de identidad: <span class="data" id="ced_identidad"></span><br />
                        Caja profesional: <span class="data" id="caja_profesional"></span><br />
                        N&uacute;mero de tel&eacute;fono: <span class="data" id="num_telefono"></span><br />
                        Celular: <span class="data" id="num_celular"></span><br />
                        Mail: <span class="data" id="mail"></span><br />
                    </div>
                    <div class="column">
                        Fecha de ingreso del CV: <span class="data" id="fecha_ingreso"></span><br />
                        Fecha de actualizaci&oacute;n del CV: <span class="data" id="fecha_actualizacion"></span><br /><br />
                        <div style="height: 70px; overflow-y: auto;">
                            <?php $result = $base->safe_query( 'SELECT * FROM estados ORDER BY id_estado' ); ?>
                            <?php if ( $base->NumFilas($result) != 0 ) : ?>
                            <ul class="estados" id="estados_aspirante">
                                <?php while ($row = $base->f_array($result)) : ?>
                                <li><?php echo $row['nombre_estado'] ?><input class="estado" type="checkbox" id="<?php echo $row['id_estado'] ?>" /></li>
                                <?php endwhile; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                        <input type="button" value="Actualizar estados" style="margin-top:10px; padding: 0 20px;" id="actualizar_estados" /><span id="resultado_estado"></span>
                    </div>
                    <div class="column last" id="imagen"></div>
                    <div style="clear:both; border:0;"></div>
                </div>
                <div id="tab-2">
                    <div style="border:0; margin-right:10px; margin-bottom: 10px;">
                        <h3>Formaci&oacute;n de Postgrado:</h3>
                        <table class="tabs">
                            <tr class="header">
                                <td style="width: 200px">Especialidad</td>
                                <td style="width: 150px">Tipo de Postgrado</td>
                                <td style="width: 75px">A&ntilde;o de inicio</td>
                                <td style="width: 75px">A&ntilde;o que cursa</td>
                                <td style="width: 75px">Egresado?</td>
                                <td style="width: 75px">A&ntilde;o de egreso</td>
                            </tr>
                        </table>
                        <table class="tabs" id="tabla_aspirantes_postgrados"></table>
                    </div>
                    <div style="float:left; border:0;">
                        <h3>Cursos de apoyo extrahospitalario:</h3>
                        <table class="tabs">
                            <tr class="header">
                                <td style="width: 100px">Nombre Curso</td>
                                <td style="width: 400px"></td>
                                <td style="width: 75px">Vigente hasta</td>
                                <td style="width: 200px">Lugar donde fue realizado</td>
                            </tr>
                        </table>
                        <table class="tabs" id="tabla_aspirantes_cursos"></table>
                    </div>
                    <div style="clear:both; border:0;"></div>
                </div>
                <div id="tab-3">
                    <div style="border:0; margin-right:10px; margin-bottom: 10px;">
                        <h3>Otros cursos:</h3>
                        <table class="tabs">
                            <tr class="header">
                                <td style="width: 50px">Tipo</td>
                                <td style="width: 400px">Nombre</td>
                                <td style="width: 100px">Lugar</td>
                                <td style="width: 75px">A&ntilde;o</td>
                            </tr>
                        </table>
                        <table class="tabs" id="tabla_aspirantes_otros_cursos"></table>
                    </div>
                    <div style="border:0;">
                        <h3>Experiencia laboral:</h3>
                        <table class="tabs">
                            <tr class="header">
                                <td style="width: 150px">Empresa</td>
                                <td style="width: 300px">Cargo</td>
                                <td style="width: 75px">Ingreso</td>
                                <td style="width: 75px">Cese</td>
                            </tr>
                        </table>
                        <table class="tabs" id="tabla_aspirantes_exp_laboral"></table>
                    </div>
                </div>
                <div id="tab-4">
                    <div style="border:0; margin-bottom: 10px">
                        <h3>Participaci&oacute;n en Congresos / Jornadas:</h3>
                        <table class="tabs">
                            <tr class="header">
                                <td style="width: 400px;">Nombre</td>
                                <td style="width: 200px;">Tema</td>
                                <td style="width: 75px;">Fecha</td>
                                <td style="width: 75px;">Car&aacute;cter</td>
                            </tr>
                        </table>
                        <table class="tabs" id="tabla_aspirantes_congresos"></table>
                    </div>
                    <div style="border:0; width:400px;">
                        <h3>Idiomas:</h3>
                        <table class="tabs">
                            <tr class="header">
                                <td style="width: 100px;">Idioma</td>
                                <td style="width: 150px;">Habilidad</td>
                            </tr>
                        </table>
                        <table class="tabs" id="tabla_idiomas"></table>
                    </div>
                </div>
                <div id="tab-5">
                    <div style="border:0; margin-bottom: 10px;">
                        <h3>M&eacute;ritos:</h3>
                        <table class="tabs">
                            <tr class="header">
                                <td style="width: 500px;">M&eacute;rito</td>
                            </tr>
                        </table>
                        <table class="tabs" id="tabla_meritos"></table>
                    </div>
                    <div style="border:0; margin-bottom: 10px;">
                        <h3>Referencias:</h3>
                        <table class="tabs">
                            <tr class="header">
                                <td style="width: 200px;">M&eacute;dico</td>
                                <td style="width: 75px;">Celular</td>
                                <td style="width: 150px;">Mail</td>
                                <td style="width: 75px;">Funcionario SEMM</td>
                                <td style="width: 100px;">Lugar</td>
                            </tr>
                        </table>
                        <table class="tabs" id="tabla_aspirantes_referencias"></table>
                    </div>
                    <div style="border:0;">
                        <h3>Archivos adjuntos:</h3>
                        <table class="tabs">
                            <tr class="header">
                                <td style="width: 100px;">Titulo</td>
                                <td style="width: 100px;">Nombre</td>
                            </tr>
                        </table>
                        <table class="tabs" id="tabla_aspirantes_adjuntos"></table>
                    </div>
                    <div style="clear:both; border:0;"></div>
                </div>
            </div>
            <h3>Administraci&oacute;n de Estados</h3>
            <div>
                <h4>Estados</h4>
                <table class="admin-data" id="tabla_estados" style="height:220px; width: 591px; overflow-y: auto; float: left;">
                    <tr class="header"><td class="td2" colspan="2">Estado</td></tr>
                    <?php $result = $base->safe_query( 'SELECT * FROM estados ORDER BY id_estado' ); ?>
                    <?php if ( $base->NumFilas($result) == 0 ) : ?>
                    <tr><td colspan="2">No hay estados definidos</td></tr>
                    <?php else : ?>
                    <?php while ($row = $base->f_array($result)) : ?>
                    <tr>
                        <td class="td2 nombre_estado"><?php echo $row['nombre_estado']?></td>
                        <?php $link_eliminar_estado = $_SERVER['PHP_SELF'] . '?action=BORRAR_ESTADO&ID=' . $row['id_estado'] ?>
                        <td class="td0">
                            <span style="display: none" class="id_estado"><?php echo $row['id_estado']?></span>
                            <a href="<?php echo $link_eliminar_estado ?>">Eliminar estado</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php endif; ?>
                </table>
                <div class="column2" style="float: left; margin-left: 20px;">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?action=ESTADO">
                        <p>
                            <label class="label">Nombre del estado:</label><input type="text" class="text1" name="nombre_estado" value="" />
                            <input type="hidden" name="id_estado" />
                        </p>
                        <p>
                            <input type="submit" value="Guardar" style="float: right; padding: 0 20px; font: 16px normal Arial, Helvetica, sans-serif;"/>
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php //$base->close(); ?>