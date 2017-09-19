<?php
	$email = $_SESSION['email'];
	$aspirantes = new connection;
	
	$sql = "SELECT * FROM aspirantes WHERE email='".$email."'";
	$result = $aspirantes->safe_query($sql);

	$row = $aspirantes->f_array($result);
	
	$id_aspirante = $row['id_aspirante'];
	$name = $row['name'];
	$last_name = $row['last_name'];
	$born_date = date('d/m/Y', strtotime($row['born_date']));
	$ci_num = substr( $row['ci_num'], 0, strlen($row['ci_num'])-1).'-'. substr( $row['ci_num'], strlen($row['ci_num'])-1, 1);
	$egreso_facultad = $row['egreso_facultad'];
	$cp_num = $row['cp_num'];
	$tel_num = $row['tel_num'];
	$cel_num = $row['cel_num'];
	
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <title>Semm - CV M&eacute;dicos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" type="text/css" href="includes/css/styles.css" />
	   <script type="text/javascript" src="includes/js/jquery-1.9.1.min.js"></script>

	   <script type="text/javascript" src="includes/js/form.js"></script>
	   <script type="text/javascript" src="includes/js/load_aspirante.js"></script>
	   <script type="text/javascript" src="includes/js/jquery.form.js"></script>
	   <script type="text/javascript" src="includes/js/jquery.crypt.js"></script>
    </head>

<body>
<div class="wrap">
<div class="inicio">
	<a href="<?php echo $_SERVER['PHP_SELF']; ?>"></a>
	<h1>Edici&oacute;n de CV</h1>
</div>
<div style="clear:both;"></div>
<div id="form_wrapper" class="form_wrapper">
        <form class="form1 active" method="post">
            <h3>Informaci&oacute;n personal
                <span class="step">
                    <span>&nbsp;</span>
                    <a href="index.php" rel="form2" class="linkform">siguiente</a>
                </span>
            </h3>
            <div class="column">
                <div>
                    <label>Nombre:</label>
                    <input type="text" name="name" id="name" value="<?php echo $name; ?>" />
                </div>
                <div>
                    <label>Apellido:</label>
                    <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>" />
                </div>
                <div>
                    <label>Fecha de nacimiento:</label>
                    <input type="text" name="born_date" id="born_date" value="<?php echo $born_date; ?>" />
                </div>
                <div>
                    <label>C&eacute;dula de Identidad:</label>
                    <input type="text" name="ci_num" id="ci_num" value="<?php echo $ci_num; ?>" placeholder="######-#" />
                </div>
                <div>
                    <label>N&uacute;mero de Caja Profesional:</label>
                    <input type="text" name="cp_num" id="cp_num" value="<?php echo $cp_num; ?>" />
                </div>
            </div>
            <div class="column">
                <div>
                    <label>N&uacute;mero de Tel&eacute;fono:</label>
                    <input type="text" name="tel_num" id="tel_num" value="<?php echo $tel_num; ?>" />
                </div>
                <div>
                    <label>N&uacute;mero de Celular:</label>
                    <input type="text" name="cel_num" id="cel_num" value="<?php echo $cel_num; ?>" />
                </div>
                <div>
                    <label>A&ntilde;o egreso de Fac. Medicina:</label>
                    <input type="text" name="egreso_facultad" id="egreso_facultad" value="<?php echo $egreso_facultad; ?>" />
                </div>
                <div>
                    <label>Correo Electr&oacute;nico:</label>
                    <input type="text" name="email" id="email" value="<?php echo $email; ?>"  disabled="disabled"/>
                </div>
                <div>
                    <label>Password:</label>
                    <input type="password" name="pass" id="pass" />
                </div>
            </div>
            <div class="bottom">
                <input type="button" value="Actualizar CV" class="update"/>
                <div class="steps">
                    <ul>
                        <li><a href="index.php" rel="form1" class="linkform sel-first">1</a></li>
                        <li><a href="index.php" rel="form2" class="linkform">2</a></li>
                        <li><a href="index.php" rel="form3" class="linkform">3</a></li>
                        <li><a href="index.php" rel="form4" class="linkform">4</a></li>
                        <li><a href="index.php" rel="form5" class="linkform">5</a></li>
                        <li><a href="index.php" rel="form6" class="linkform">6</a></li>
                        <li><a href="index.php" rel="form7" class="linkform">7</a></li>
                        <li><a href="index.php" rel="form8" class="linkform">8</a></li>
                        <li><a href="index.php" rel="form9" class="linkform">9</a></li>
                        <li><a href="index.php" rel="form10" class="linkform">10</a></li>
                        <li><a href="index.php" rel="form11" class="linkform last">11</a></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <input type="hidden" name="id_aspirante" id="id_aspirante" value="<?php echo $id_aspirante; ?>" />
        </form>
        <form class="form2">
            <h3>Formaci&oacute;n de Postgrado
                <span class="step">
                    <a href="index.php" rel="form1" class="linkform">anterior</a>
                    <a href="index.php" rel="form3" class="linkform">siguiente</a>
                </span>
            </h3>
            <table class="header">
                <tr class="header">
                    <td class="td2">Especialidad</td>
                    <td class="td1">Tipo de Postgrado</td>
                    <td class="td1">Año inicio</td>
                    <td class="td0">A&ntilde;o que cursa</td>
                    <td class="td0">Egresado?</td>
                    <td class="td0">A&ntilde;o de egreso</td>
                    <td class="add"></td>
                </tr>
            </table>
            <table class="data" id="postgrados">
                <tr class="last">
                    <td class="td1"></td><td class="td1"></td><td class="td1"></td><td class="td1"></td><td class="td1"></td><td class="td1"></td><td class="add"><a href="#" class="add" id="add_postgrado" title="Agregar Postgrado"></a></td>
                </tr>
            </table>
            <div class="bottom">
                <input type="button" value="Actualizar CV" class="update" />
                <div class="steps">
                    <ul>
                        <li><a href="index.php" rel="form1" class="linkform first">1</a></li>
                        <li><a href="index.php" rel="form2" class="linkform">2</a></li>
                        <li><a href="index.php" rel="form3" class="linkform">3</a></li>
                        <li><a href="index.php" rel="form4" class="linkform">4</a></li>
                        <li><a href="index.php" rel="form5" class="linkform">5</a></li>
                        <li><a href="index.php" rel="form6" class="linkform">6</a></li>
                        <li><a href="index.php" rel="form7" class="linkform">7</a></li>
                        <li><a href="index.php" rel="form8" class="linkform">8</a></li>
                        <li><a href="index.php" rel="form9" class="linkform">9</a></li>
                        <li><a href="index.php" rel="form10" class="linkform">10</a></li>
                        <li><a href="index.php" rel="form11" class="linkform last">11</a></li>
                    </ul>
                </div>
            </div>
        </form>
        <form class="form3">
            <h3>Cursos de Apoyo Extrahospitalario
                <span class="step">
                    <a href="index.php" rel="form2" class="linkform">anterior</a>
                    <a href="index.php" rel="form4" class="linkform">siguiente</a>
                </span>
            </h3>
            <table class="header">
                    <tr class="header">
                        <td class="td1">Nombre Curso</td>
                        <td class="td2">(Otro Curso - Especificar)</td>
                        <td class="td1">Vigente hasta</td>
                        <td class="td2">Lugar donde lo realiz&oacute;</td>
                        <td class="add"></td>
                    </tr>
		</table>
            <table class="data" id="cursos">
                    <tr class="last">
                        <td class="td1"></td><td class="td2"></td><td class="td1"></td><td class="td2"></td>
                        <td class="add"><a href="#" class="add" id="add_curso" title="Agregar Curso"></a></td>
                    </tr>
		</table>
            <div class="bottom">
                <input type="button" value="Actualizar CV" class="update"/>
                <div class="steps">
                    <ul>
                        <li><a href="index.php" rel="form1" class="linkform first">1</a></li>
                        <li><a href="index.php" rel="form2" class="linkform">2</a></li>
                        <li><a href="index.php" rel="form3" class="linkform">3</a></li>
                        <li><a href="index.php" rel="form4" class="linkform">4</a></li>
                        <li><a href="index.php" rel="form5" class="linkform">5</a></li>
                        <li><a href="index.php" rel="form6" class="linkform">6</a></li>
                        <li><a href="index.php" rel="form7" class="linkform">7</a></li>
                        <li><a href="index.php" rel="form8" class="linkform">8</a></li>
                        <li><a href="index.php" rel="form9" class="linkform">9</a></li>
                        <li><a href="index.php" rel="form10" class="linkform">10</a></li>
                        <li><a href="index.php" rel="form11" class="linkform last">11</a></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
        </form>
        <form class="form4">
            <h3>Experiencia Laboral
                <span class="step">
                    <a href="index.php" rel="form3" class="linkform">anterior</a>
                    <a href="index.php" rel="form5" class="linkform">siguiente</a>
                </span>
            </h3>
            <table class="header">
                <tr class="header">
                    <td class="td2">Empresa</td>
                    <td class="td2">Cargo</td>
                    <td class="td1">A&ntilde;o de Ingreso</td>
                    <td class="td1">A&ntilde;o de cese/Actual</td>
                    <td class="add"></td>
                </tr>
            </table>
            <table class="data" id="exp_laboral">
                <tr class="last">
                    <td class="td2"></td><td class="td2"></td><td class="td1"></td><td class="td1"></td>
                    <td class="add"><a href="#" class="add" id="add_exp_lab" title="Agregar Experiencia Laboral"></a></td>
                </tr>
            </table>
            <div class="bottom">
                    <input type="button" value="Actualizar CV" class="update"/>
                    <div class="steps">
                        <ul>
                            <li><a href="index.php" rel="form1" class="linkform first">1</a></li>
                            <li><a href="index.php" rel="form2" class="linkform">2</a></li>
                            <li><a href="index.php" rel="form3" class="linkform">3</a></li>
                            <li><a href="index.php" rel="form4" class="linkform">4</a></li>
                            <li><a href="index.php" rel="form5" class="linkform">5</a></li>
                            <li><a href="index.php" rel="form6" class="linkform">6</a></li>
                            <li><a href="index.php" rel="form7" class="linkform">7</a></li>
                            <li><a href="index.php" rel="form8" class="linkform">8</a></li>
                            <li><a href="index.php" rel="form9" class="linkform">9</a></li>
                            <li><a href="index.php" rel="form10" class="linkform">10</a></li>
                            <li><a href="index.php" rel="form11" class="linkform last">11</a></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
		</div>
        </form>
        <form class="form5">
            <h3>Otros cursos
                <span class="step">
                    <a href="index.php" rel="form4" class="linkform">anterior</a>
                    <a href="index.php" rel="form6" class="linkform">siguiente</a>
                </span>
            </h3>
            <table class="header">
                    <tr class="header">
                        <td class="td1">Tipo</td>
                        <td class="td1">A&ntilde;o</td>
                        <td class="td2">Nombre</td>
                        <td class="td2">Lugar</td>
                        <td class="add"></td>
                    </tr>
		</table>
            <table class="data" id="otros_cursos">
                    <tr class="last">
                        <td class="td1"></td><td class="td1"></td><td class="td2"></td><td class="td2"></td><td class="add"><a href="#" class="add" id="add_otro_curso" title="Agregar otro Curso"></a></td>
                    </tr>
		</table>
            <div class="bottom">
                    <input type="button" value="Actualizar CV" class="update"/>
                    <div class="steps">
                        <ul>
                            <li><a href="index.php" rel="form1" class="linkform first">1</a></li>
                            <li><a href="index.php" rel="form2" class="linkform">2</a></li>
                            <li><a href="index.php" rel="form3" class="linkform">3</a></li>
                            <li><a href="index.php" rel="form4" class="linkform">4</a></li>
                            <li><a href="index.php" rel="form5" class="linkform">5</a></li>
                            <li><a href="index.php" rel="form6" class="linkform">6</a></li>
                            <li><a href="index.php" rel="form7" class="linkform">7</a></li>
                            <li><a href="index.php" rel="form8" class="linkform">8</a></li>
                            <li><a href="index.php" rel="form9" class="linkform">9</a></li>
                            <li><a href="index.php" rel="form10" class="linkform">10</a></li>
                            <li><a href="index.php" rel="form11" class="linkform last">11</a></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
		</div>
        </form>
        <form class="form6">
            <h3>Participaci&oacute;n en Congresos/Jornadas, etc.
                <span class="step">
                    <a href="index.php" rel="form5" class="linkform">anterior</a>
                    <a href="index.php" rel="form7" class="linkform">siguiente</a>
                </span>
            </h3>
            <table class="header">
                <tr class="header">
                    <td class="td2">Nombre</td>
                    <td class="td2">Tema</td>
                    <td class="td1">A&ntilde;o</td>
                    <td class="td1">Car&aacute;cter</td>
                    <td class="add"></td>
                </tr>
            </table>
            <table class="data" id="congresos">
                    <tr class="last">
                        <td class="td2"></td><td class="td2"></td><td class="td1"></td><td class="td1"></td><td class="add"><a href="#" class="add" id="add_congreso" title="Agregar otra Participaci&oacute;n"></a></td>
                    </tr>
            </table>
            <div class="bottom">
                <input type="button" value="Actualizar CV" class="update"/>
                <div class="steps">
                    <ul>
                            <li><a href="index.php" rel="form1" class="linkform first">1</a></li>
                            <li><a href="index.php" rel="form2" class="linkform">2</a></li>
                            <li><a href="index.php" rel="form3" class="linkform">3</a></li>
                            <li><a href="index.php" rel="form4" class="linkform">4</a></li>
                            <li><a href="index.php" rel="form5" class="linkform">5</a></li>
                            <li><a href="index.php" rel="form6" class="linkform">6</a></li>
                            <li><a href="index.php" rel="form7" class="linkform">7</a></li>
                            <li><a href="index.php" rel="form8" class="linkform">8</a></li>
                            <li><a href="index.php" rel="form9" class="linkform">9</a></li>
                            <li><a href="index.php" rel="form10" class="linkform">10</a></li>
                            <li><a href="index.php" rel="form11" class="linkform last">11</a></li>
                        </ul>
                </div>
                <div class="clear"></div>
            </div>
        </form>
        <form class="form7">
            <h3>Idiomas
                <span class="step">
                    <a href="index.php" rel="form6" class="linkform">anterior</a>
                    <a href="index.php" rel="form8" class="linkform">siguiente</a>
                </span>
            </h3>
            <table class="header">
                <tr class="header">
                    <td class="td1">Idioma</td>
                    <td class="td2">(Otro idioma - especificar)</td>
                    <td class="td3">Habilidad</td>
                    <td class="add"></td>
                </tr>
            </table>
            <table class="data" id="idiomas">
                <tr class="last">
                    <td class="td1"></td><td class="td2"></td><td class="td3"></td><td class="add"><a href="#" class="add" id="add_idioma" title="Agregar Idioma"></a></td>
                </tr>
            </table>
            <div class="bottom">
                    <input type="button" value="Actualizar CV" class="update"/>
                    <div class="steps">
                        <ul>
                            <li><a href="index.php" rel="form1" class="linkform first">1</a></li>
                            <li><a href="index.php" rel="form2" class="linkform">2</a></li>
                            <li><a href="index.php" rel="form3" class="linkform">3</a></li>
                            <li><a href="index.php" rel="form4" class="linkform">4</a></li>
                            <li><a href="index.php" rel="form5" class="linkform">5</a></li>
                            <li><a href="index.php" rel="form6" class="linkform">6</a></li>
                            <li><a href="index.php" rel="form7" class="linkform">7</a></li>
                            <li><a href="index.php" rel="form8" class="linkform">8</a></li>
                            <li><a href="index.php" rel="form9" class="linkform">9</a></li>
                            <li><a href="index.php" rel="form10" class="linkform">10</a></li>
                            <li><a href="index.php" rel="form11" class="linkform last">11</a></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
		</div>
        </form>
        <form class="form8">
            <h3>Otros m&eacute;ritos
                <span class="step">
                    <a href="index.php" rel="form7" class="linkform">anterior</a>
                    <a href="index.php" rel="form9" class="linkform">siguiente</a>
                </span>
            </h3>
            <table class="header">
                <tr class="header">
                    <td class="td4">M&eacute;rito</td>
                    <td class="add"></td>
                </tr>
            </table>
            <table class="data" id="meritos">
                <tr class="last">
                    <td class="td4"></td><td class="add"><a href="#" class="add" id="add_merito" title="Agregar otro M&eacute;rito"></a></td>
                </tr>
            </table>
            <div class="bottom">
                    <input type="button" value="Actualizar CV" class="update"/>
                    <div class="steps">
                        <ul>
                            <li><a href="index.php" rel="form1" class="linkform first">1</a></li>
                            <li><a href="index.php" rel="form2" class="linkform">2</a></li>
                            <li><a href="index.php" rel="form3" class="linkform">3</a></li>
                            <li><a href="index.php" rel="form4" class="linkform">4</a></li>
                            <li><a href="index.php" rel="form5" class="linkform">5</a></li>
                            <li><a href="index.php" rel="form6" class="linkform">6</a></li>
                            <li><a href="index.php" rel="form7" class="linkform">7</a></li>
                            <li><a href="index.php" rel="form8" class="linkform">8</a></li>
                            <li><a href="index.php" rel="form9" class="linkform">9</a></li>
                            <li><a href="index.php" rel="form10" class="linkform">10</a></li>
                            <li><a href="index.php" rel="form11" class="linkform last">11</a></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
		</div>
        </form>
        <form class="form9">
            <h3>Referencias
                <span class="step">
                        <a href="index.php" rel="form8" class="linkform">anterior</a>
                        <a href="index.php" rel="form10" class="linkform">siguiente</a>
                    </span>
            </h3>
            <table class="header">
                <tr class="header">
                    <td class="td2">Nombre del M&eacute;dico</td>
                    <td class="td1">Celular</td>
                    <td class="td1">Mail</td>
                    <td class="td1">Lugar de trabajo</td>
                    <td class="td1">Trabaja en SEMM</td>
                    <td class="add"></td>
                </tr>
            </table>
            <table class="data" id="referencias">
                <tr class="last">
                    <td class="td2"></td><td class="td1"></td><td class="td1"></td><td class="td1"></td><td class="td1"></td><td class="add"><a href="#" class="add" id="add_referencia" title="Agregar Referencia"></a></td>
                </tr>
            </table>
            <div class="bottom">
                    <input type="button" value="Actualizar CV" class="update"/>
                    <div class="steps">
                        <ul>
                            <li><a href="index.php" rel="form1" class="linkform first">1</a></li>
                            <li><a href="index.php" rel="form2" class="linkform">2</a></li>
                            <li><a href="index.php" rel="form3" class="linkform">3</a></li>
                            <li><a href="index.php" rel="form4" class="linkform">4</a></li>
                            <li><a href="index.php" rel="form5" class="linkform">5</a></li>
                            <li><a href="index.php" rel="form6" class="linkform">6</a></li>
                            <li><a href="index.php" rel="form7" class="linkform">7</a></li>
                            <li><a href="index.php" rel="form8" class="linkform">8</a></li>
                            <li><a href="index.php" rel="form9" class="linkform">9</a></li>
                            <li><a href="index.php" rel="form10" class="linkform">10</a></li>
                            <li><a href="index.php" rel="form11" class="linkform last">11</a></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
		</div>
        </form>
        <form action="includes/upload_image.php" id="FileUploader" enctype="multipart/form-data" method="post" class="form10">
            <h3>
                Im&aacute;genes
                <span class="step">
                    <span>&nbsp;</span>
                    <a href="index.php" rel="form9" class="linkform">anterior</a>
                    <a href="index.php" rel="form11" class="linkform">siguiente</a>
                </span>
            </h3>
		<div style="float:left; width:600px; height:402px; margin:5px 10px;">
		<p style="font:12px Arial, Helvetica, sans-serif; margin-bottom:10px;">
			Puedes cargar una foto en formato JPG, GIF o PNG <br />(tama&ntilde;o m&aacute;ximo de 4MB)
		</p>
		<input 
                    type="file" 
                    name="mFile" 
                    id="mFile" 
                    onchange="document.getElementById('uploadButton').disabled=false;" 
                />
		<br /><br /><br />
		<input type="button" id="uploadButton" value="Cargar foto" disabled="disabled" />
		</div>
		<div id="output" style="float:right; border:2px solid #ddd; width:150px; height:150px; margin:5px 10px;"></div>
		

		<div class="bottom">
			<input type="button" value="Actualizar CV" class="update"/>
			<div class="steps">
				<ul>
					<li><a href="index.php" rel="form1" class="linkform first">1</a></li>
					<li><a href="index.php" rel="form2" class="linkform">2</a></li>
					<li><a href="index.php" rel="form3" class="linkform">3</a></li>
					<li><a href="index.php" rel="form4" class="linkform">4</a></li>
					<li><a href="index.php" rel="form5" class="linkform">5</a></li>
					<li><a href="index.php" rel="form6" class="linkform">6</a></li>
					<li><a href="index.php" rel="form7" class="linkform">7</a></li>
					<li><a href="index.php" rel="form8" class="linkform">8</a></li>
					<li><a href="index.php" rel="form9" class="linkform">9</a></li>
					<li><a href="index.php" rel="form10" class="linkform">10</a></li>
					<li><a href="index.php" rel="form11" class="linkform last">11</a></li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		</form>
		<form class="form11">
		<h3>Agregar archivos adjuntos
			<span class="step">
				<a href="index.php" rel="form10" class="linkform">anterior</a>
			</span>
		</h3>
		<table class="header">
			<tr class="header">
				<td class="td3">T&iacute;tulo del Adjunto</td>
				<td class="td3">Nombre</td>
				<td class="add"></td>
			</tr>
		</table>
		<table class="data" id="adjuntos">
			<tr class="last">
				<td class="td3"></td><td class="td3"></td><td class="add"><a href="#" class="add" id="add_adjunto" title="Agregar Adjunto"></a></td>
			</tr>
		</table>
		<div class="bottom">
			<input type="button" value="Actualizar CV" class="update"/>
			<div class="steps">
				<ul>
					<li><a href="index.php" rel="form1" class="linkform first">1</a></li>
					<li><a href="index.php" rel="form2" class="linkform">2</a></li>
					<li><a href="index.php" rel="form3" class="linkform">3</a></li>
					<li><a href="index.php" rel="form4" class="linkform">4</a></li>
					<li><a href="index.php" rel="form5" class="linkform">5</a></li>
					<li><a href="index.php" rel="form6" class="linkform">6</a></li>
					<li><a href="index.php" rel="form7" class="linkform">7</a></li>
					<li><a href="index.php" rel="form8" class="linkform">8</a></li>
					<li><a href="index.php" rel="form9" class="linkform">9</a></li>
					<li><a href="index.php" rel="form10" class="linkform">10</a></li>
					<li><a href="index.php" rel="form11" class="linkform last">11</a></li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		</form>
		<form class="form12">
		<h3>Curriculum actualizado</h3>
		<div style="margin:10px;" id="mensaje_fin">
		<p>Los datos fueron correctamente enviados a la base de datos</p>
		</div>
		<div class="bottom" style="float:right; width:100%;">
			<input type="button" value="Cerrar Sesion" id="end_session"/>
			<div class="clear"></div>
		</div>
		</form>
	</div>
</div>
</body>
</html>
<?php
$aspirantes->close();
?>