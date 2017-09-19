<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//function __autoload($nombre_clase) {
    //include 'clases/' . $nombre_clase . '.php';
    //include_once 'clases/connection.php';
    include 'clases/connection.php';
//}
$base = new connection;
$id_aspirante = $_POST['id_aspirante'];
$tabla = $_POST['tabla'];

switch ($tabla) {
case 'postgrados':
$sql = "SELECT * FROM aspirantes_postgrados WHERE id_aspirante='".$id_aspirante."' ORDER BY id_aspirantes_postgrados";
$result1 = $base->safe_query($sql);
if ($base->NumFilas($result1)==0){
	//si no tengo postgrados agrego una fila en la tabla con la especialidad en blanco
	$postgrados  = '<tr class="postgrado" id="postgrado_1">';
	$postgrados .= '<td class="td2"><select class="especialidad">';
	//$postgrados .= '<option value=""></option>';
	$sql="SELECT * FROM especialidades";
	$result = $base->safe_query($sql);
	$select_especialidades = '';
	while($row = $base->f_array($result)) {
		$select_especialidades .= '<option value="'.$row['id_especialidades'].'">';
		$select_especialidades .= utf8_encode($row['nombre_especialidad']).'</option>';
	}
	$postgrados .= $select_especialidades;
	$postgrados .= '</select></td>';

	$sql="SELECT * FROM tipo_postgrado";
	$result = $base->safe_query($sql);

	$postgrados .= '<td class="td1"><select class="tipo_postgrado" disabled="disabled">';
	$tipo_postgrado = '';
	while($row = $base->f_array($result)) {
		$tipo_postgrado .= '<option value="'.$row['id_tipo_postgrado'].'">';
		$tipo_postgrado .= $row['tipo_postgrado_nombre'].'</option>';
	}
	$postgrados .= $tipo_postgrado;
	$postgrados .= '</select></td>';

	$postgrados .= '<td class="td1"><input class="inicio" type="text" maxlength="4" class="field" disabled="disabled"></td>';
	$postgrados .= '<td class="td0"><select class="cursa" disabled="disabled">';
	$postgrados .= '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>';
	$postgrados .= '</select></td>';
	$postgrados .= '<td class="td0"><select class="egresado" disabled="disabled"><option value="0">Si</option><option value="1">No</option></select></td>';
	$postgrados .= '<td class="td0"><input class="egreso" type="text" maxlength="4" class="field" disabled="disabled"></td>';
	$postgrados .= '<td><a href="#" class="sub" id="sub_postgrado_1" title="Quitar Postgrado">&nbsp;</a></td>';
	$postgrados .= '</tr>';
} else {
	//leo la tabla y muestro los postgrados
	$postgrados = '';
	while($aspirantes_postgrado = $base->f_array($result1)) {
		$id_aspirantes_postgrados = $aspirantes_postgrado['id_aspirantes_postgrados'];
		$id_especialidad = $aspirantes_postgrado['id_especialidad'];
		$id_tipo_postgrado = $aspirantes_postgrado['id_tipo_postgrado'];
		$inicio = $aspirantes_postgrado['inicio'];
		$cursa = $aspirantes_postgrado['cursa'];
		$egresado = $aspirantes_postgrado['egresado'];
		
		$sql = "SELECT * FROM especialidades WHERE id_especialidades='".$id_especialidad."'";
		$result2 = $base->safe_query($sql);
		$especialidad = $base->f_array($result2);
		$nombre_especialidad = $especialidad['nombre_especialidad'];
		$id_tipo_postgrado = $aspirantes_postgrado['id_tipo_postgrado'];
		$sql = "SELECT * FROM tipo_postgrado WHERE id_tipo_postgrado='".$id_tipo_postgrado."'";
		$result3 = $base->safe_query($sql);
		$tipo_postgrado = $base->f_array($result3);
		$tipo_postgrado_nombre = $tipo_postgrado['tipo_postgrado_nombre'];

		$postgrados .= '<tr class="postgrado" id="postgrado_'.$id_aspirantes_postgrados.'">';
		$postgrados .= '<td class="td2"><select class="especialidad">';
		$sql = "SELECT * FROM especialidades";
		$result4 = $base->safe_query($sql);
		while ($especialidad = $base->f_array($result4)){
			$selected = $especialidad['id_especialidades'] == $id_especialidad ? 'selected=selected' : '';
			$postgrados .= '<option value="'.$especialidad['id_especialidades'].'" '.$selected.'>';
			$postgrados .= $especialidad['nombre_especialidad'];
			$postgrados .= '</option>';
		}
		$postgrados .= '</select></td>';
                $disabled = $id_especialidad=='1' ? 'disabled="disabled"' : '';
		$postgrados .= '<td class="td1"><select class="tipo_postgrado" '.$disabled.'>';
		$sql = "SELECT * FROM tipo_postgrado";
		$result5 = $base->safe_query($sql);
		while($tipo_postgrado = $base->f_array($result5)){
			$selected = $tipo_postgrado['id_tipo_postgrado'] == $id_tipo_postgrado ? 'selected=selected' : '';
			$postgrados .= '<option value="'.$tipo_postgrado['id_tipo_postgrado'].'" '.$selected.'>';
			$postgrados .= $tipo_postgrado['tipo_postgrado_nombre'];
			$postgrados .= '</option>';
		}
		$postgrados .= '</select></td>';
		$postgrados .= '<td class="td1"><input class="inicio" type="text" value="'.$inicio.'" maxlength="4" '.$disabled.'></td>';
		$postgrados .= '<td class="td0"><select class="cursa" '.$disabled.'>';
		for ($j=1; $j<5; $j++){
			$selected = ($j==$cursa) ? 'selected=selected' : '';
			$postgrados .= '<option value="'.$j.'" '.$selected.'>'.$j.'</option>';
		}
		$postgrados .= '</select></td>';
                $disabled = $egresado=='1' ? 'disabled="disabled"' : '';
		$postgrados .= '<td class="td0"><select class="egresado">'.$egresado;
		$selected_si = $egresado==0 ? 'selected=selected' : '';
		$selected_no = $egresado==1 ? 'selected=selected' : '';
		$postgrados .= '<option value="0" '.$selected_si.'>Si</option>';
		$postgrados .= '<option value="1" '.$selected_no.'>No</option>';
		$postgrados .= '</select></td>';
                $egreso = $egresado==0 ? $aspirantes_postgrado['egreso'] : '';
		$postgrados .= '<td class="td0"><input class="egreso" type="text" value="'.$egreso.'" maxlength="4" '.$disabled.'></td>';
		$postgrados .= '<td><a href="#" class="sub" id="sub_postgrado_'.$id_aspirantes_postgrados.'" title="Quitar Postgrado">&nbsp;</a></td></tr>';
	}
}
echo $postgrados;
	break;
case 'cursos':
$sql = "SELECT * FROM aspirantes_cursos WHERE id_aspirante='".$id_aspirante."' ORDER BY id_aspirantes_cursos";
$result1 = $base->safe_query($sql);
if ($base->NumFilas($result1)==0){
	//si no tengo cursos agrego una fila en la tabla con el nombre del curso en blanco
	$cursos = '<tr class="curso" id="curso_1">';
	$cursos .= '<td><select class="nombre_curso">';
	//$cursos .= '<option value=""></option>';
	$sql="SELECT * FROM cursos ORDER BY id_curso";
	$result = $base->safe_query($sql);
	$select_cursos = '';
	while($row = $base->f_array($result)) {
		$select_cursos .= '<option value="'.$row['id_curso'].'">';
		$select_cursos .= utf8_encode($row['curso_nombre']).'</option>';
	}
	$cursos .= $select_cursos;
	$cursos .= '</select></td>';

	$cursos .= '<td><input type="text" class="field extra" disabled="disabled" /></td>';
	$cursos .= '<td><input type="text" maxlength="4" class="field vigencia" disabled="disabled" /></td>';
	$cursos .= '<td><input type="text" class="field lugar" disabled="disabled" /></td>';
	$cursos .= '<td><a href="#" class="sub" id="sub_curso_1" title="Quitar Curso">&nbsp;</a></td>';
	$cursos .= '</tr>';
} else {
	//leo la tabla y muestro los cursos
	$cursos = '';
	while($aspirantes_curso = $base->f_array($result1)) {
		$id_aspirantes_cursos = $aspirantes_curso['id_aspirantes_cursos'];
		$id_curso = $aspirantes_curso['id_curso'];
		$extra = $aspirantes_curso['extra'];
		$vigencia = $aspirantes_curso['vigencia'];
		$lugar = $aspirantes_curso['lugar'];
		$sql = "SELECT * FROM cursos WHERE id_curso='".$id_curso."'";
		$result2 = $base->safe_query($sql);
		$curso = $base->f_array($result2);
		$curso_nombre = $curso['curso_nombre'];

		$cursos .= '<tr class="curso" id="curso_'.$id_aspirantes_cursos.'">';
		$cursos .= '<td class="td1"><select class="nombre_curso">';
		$sql = "SELECT * FROM cursos ORDER BY id_curso";
		$result4 = $base->safe_query($sql);
		while ($curso = $base->f_array($result4)){
			$selected = $curso['id_curso'] == $id_curso ? 'selected=selected' : '';
			$cursos .= '<option value="'.$curso['id_curso'].'" '.$selected.'>';
			$cursos .= $curso['curso_nombre'];
			$cursos .= '</option>';
		}
		$cursos .= '</select></td>';
                $disabled = $curso_nombre=='No tengo' ? 'disabled="disabled"' : '';
		$cursos .= '<td class="td2"><input type="text" class="field extra" value="'.$extra.'" '.$disabled.' /></td>';
		$cursos .= '<td class="td1"><input type="text" maxlength="4" class="field vigencia" value="'.$vigencia.'" '.$disabled.' /></td>';
		$cursos .= '<td class="td2"><input type="text" class="field lugar" value="'.$lugar.'" '.$disabled.' /></td>';
		$cursos .= '<td><a href="#" class="sub" id="sub_curso_'.$id_aspirantes_cursos.'" title="Quitar Curso">&nbsp;</a></td></tr>';
	}
}
echo $cursos;
	break;
case 'exp_laboral':
$sql = "SELECT * FROM aspirantes_exp_laboral WHERE id_aspirante='".$id_aspirante."' ORDER BY id_aspirantes_exp_laboral";
$result1 = $base->safe_query($sql);
if ($base->NumFilas($result1)==0){
	//si no tengo experiencia laboral agrego una fila en la tabla con los datos en blanco
	$experiencia_laboral = '<tr class="exp_lab" id="exp_lab_1">';

	$experiencia_laboral .= '<td class="td2"><input type="text" class="field empresa" value="Ninguna"></td>';
	$experiencia_laboral .= '<td class="td2"><input type="text" class="field cargo" disabled="disabled" /></td>';

	$experiencia_laboral .= '<td class="td1"><input type="text" maxlength="4" class="field ingreso" disabled="disabled" /></td>';
	$experiencia_laboral .= '<td class="td1"><input type="text" maxlength="4" class="field cese" disabled="disabled" /></td>';

	$experiencia_laboral .= '<td><a href="#" class="sub" id="sub_curso_1" title="Quitar Experiencia">&nbsp;</a></td>';
	$experiencia_laboral .= '</tr>';
} else {
	//leo la tabla y muestro los registros
	$experiencia_laboral = '';
	$i = 0;
	while($exp_laboral = $base->f_array($result1)) {
            $id_aspirantes_exp_laboral = $exp_laboral['id_aspirantes_exp_laboral'];
            $empresa = $exp_laboral['empresa'];
            $cargo = $exp_laboral['cargo'];
            $ingreso = $exp_laboral['ingreso'];
            $cese = $exp_laboral['cese'];
            $disabled = $empresa=='Ninguna' ? 'disabled="disabled"' : '';
            $experiencia_laboral .= '<tr class="exp_lab" id="exp_lab_'.$id_aspirantes_exp_laboral.'">';
            $experiencia_laboral .= '<td class="td2"><input type="text" class="field empresa" value="'.$empresa.'" /></td>';
            $experiencia_laboral .= '<td class="td2"><input type="text" class="field cargo" value="'.$cargo.'" '.$disabled.' /></td>';
            $experiencia_laboral .= '<td class="td1"><input type="text" maxlength="4" class="field ingreso" value="'.$ingreso.'" '.$disabled.' /></td>';
            $experiencia_laboral .= '<td class="td1"><input type="text" maxlength="4" class="field cese" value="'.$cese.'" '.$disabled.' /></td>';
            $experiencia_laboral .= '<td><a href="#" class="sub" id="sub_curso_'.$id_aspirantes_exp_laboral.'" title="Quitar Experiencia">&nbsp;</a></td></tr>';
	}
}
echo $experiencia_laboral;
	break;
case 'otros_cursos':
$sql = "SELECT * FROM aspirantes_otros_cursos WHERE id_aspirante='".$id_aspirante."' ORDER BY id_aspirantes_otros_cursos";
$result1 = $base->safe_query($sql);
if ($base->NumFilas($result1)==0){
	//si no tengo otros cursos muestro una fila en blanco
	$otros_cursos = '<tr class="otro_curso" id="otro_curso_1">';

	$otros_cursos .= '<td><select class="tipo">';
	//$otros_cursos .= '<option value=""></option>';
	$sql="SELECT * FROM otros_cursos ORDER BY id_otros_cursos";
	$result = $base->safe_query($sql);
	$select_otros_cursos = '';
	while($row = $base->f_array($result)) {
		$select_otros_cursos .= '<option value="'.$row['id_otros_cursos'].'">';
		$select_otros_cursos .= utf8_encode($row['otros_cursos_nombre']).'</option>';
	}
	$otros_cursos .= $select_otros_cursos;
	$otros_cursos .= '</select></td>';


	$otros_cursos .= '<td><input type="text" maxlength="4" class="field inicio"></td>';

	$otros_cursos .= '<td><input type="text" class="field nombre"></td>';
	$otros_cursos .= '<td><input type="text" class="field lugar"></td>';

	$otros_cursos .= '<td><a href="#" class="sub" id="sub_curso_1" title="Quitar Curso">&nbsp;</a></td>';
	$otros_cursos .= '</tr>';
} else {
	//leo la tabla y muestro los registros
	$otros_cursos = '';
	while($aspirantes_otro_curso = $base->f_array($result1)) {
		$id_aspirantes_otros_cursos = $aspirantes_otro_curso['id_aspirantes_otros_cursos'];
		$id_otros_curso = $aspirantes_otro_curso['id_otros_cursos'];
		$inicio = $aspirantes_otro_curso['inicio'];
		$nombre = $aspirantes_otro_curso['nombre'];
		$lugar = $aspirantes_otro_curso['lugar'];
		$sql = "SELECT * FROM otros_cursos WHERE id_otros_cursos='".$id_aspirantes_otros_cursos."'";
		$result2 = $base->safe_query($sql);
		$otros_curso = $base->f_array($result2);
		$otros_cursos_nombre = $otros_curso['otros_cursos_nombre'];

		$otros_cursos .= '<tr class="otro_curso" id="otro_curso_'.$id_aspirantes_otros_cursos.'">';
		$otros_cursos .= '<td class="td1"><select class="tipo">';
		$sql = "SELECT * FROM otros_cursos";
		$result4 = $base->safe_query($sql);
		while ($otro_curso = $base->f_array($result4)){
			$selected = $otro_curso['id_otros_cursos'] == $id_otros_curso ? 'selected=selected' : '';
			$otros_cursos .= '<option value="'.$otro_curso['id_otros_cursos'].'" '.$selected.'>';
			$otros_cursos .= $otro_curso['otros_cursos_nombre'];
			$otros_cursos .= '</option>';
		}
		$otros_cursos .= '</select></td>';
		$otros_cursos .= '<td class="td1"><input type="text" maxlength="4" class="field inicio" value="'.$inicio.'"></td>';
		$otros_cursos .= '<td class="td2"><input type="text" class="field nombre" value="'.$nombre.'" ></td>';
		$otros_cursos .= '<td class="td2"><input type="text" class="field lugar" value="'.$lugar.'" ></td>';
		$otros_cursos .= '<td><a href="#" class="sub" id="sub_curso_'.$id_aspirantes_otros_cursos.'" title="Quitar Curso">&nbsp;</a></td></tr>';
	}
}
echo $otros_cursos;
	break;
case 'congresos':
$sql = "SELECT * FROM aspirantes_congresos WHERE id_aspirante='".$id_aspirante."' ORDER BY id_aspirantes_congresos";
$result1 = $base->safe_query($sql);
if ($base->NumFilas($result1)==0){
	//si no tengo congresos muestro una fila en blanco
	$congresos = '<tr class="congreso" id="congreso_1">';
	$congresos .= '<td><input type="text" class="field nombre" value=""  /></td>';
	$congresos .= '<td><input type="text" class="field tema"  /></td>';

	$congresos .= '<td><input type="text" maxlength="4" class="field fecha"></td>';

	$congresos .= '<td><select class="caracter">';
	$congresos .= '<option value="1">Autor</option><option value="2">Expositor</option>';
	$congresos .= '</select></td>';
	$congresos .= '<td><a href="#" class="sub" id="sub_congreso_1" title="Quitar Congreso">&nbsp;</a></td>';
	$congresos .= '</tr>';
} else {
	//leo la tabla y muestro los registros
	$congresos = '';
	while($aspirantes_congreso = $base->f_array($result1)) {
		$id_aspirantes_congresos = $aspirantes_congreso['id_aspirantes_congresos'];
		$nombre = $aspirantes_congreso['nombre'];
		$tema = $aspirantes_congreso['tema'];
		$fecha = $aspirantes_congreso['fecha'];
		$caracter = $aspirantes_congreso['caracter'];

		$congresos .= '<tr class="congreso" id="congreso_'.$id_aspirantes_congresos.'">';
		$congresos .= '<td class="td2"><input type="text" class="field nombre" value="'.$nombre.'"></td>';
		$congresos .= '<td class="td2"><input type="text" class="field tema" value="'.$tema.'"></td>';
		$congresos .= '<td class="td1"><input type="text" maxlength="4" class="field fecha" value="'.$fecha.'"></td>';
		$congresos .= '<td class="td1"><select class="caracter">';
		$selected1 = $caracter==1 ? 'selected=selected' : '';
		$selected2 = $caracter==2 ? 'selected=selected' : '';
		$congresos .= '<option value="1" '.$selected1.'>Autor</option>';
		$congresos .= '<option value="2" '.$selected2.'>Expositor</option>';
		
		$congresos .= '<td><a href="#" class="sub" id="sub_congreso_'.$id_aspirantes_congresos.'" title="Quitar Congreso">&nbsp;</a></td>';
		$congresos .= '</tr>';
	}
}
echo $congresos;
	break;
case 'idiomas':
$sql = "SELECT * FROM aspirantes_idiomas WHERE id_aspirante='".$id_aspirante."' ORDER BY id_aspirantes_idiomas";
$result1 = $base->safe_query($sql);
if ($base->NumFilas($result1)==0){
	//si no tengo idiomas muestro una fila en blanco
	$idiomas = '<tr class="idioma" id="idioma_1">';
        $idiomas .= '<td class="td1"><select class="nombre_idioma">';
	$idiomas .= '<option value="Ninguno">Ninguno</option>';
        $idiomas .= '<option value="Ingles">Ingles</option>';
        $idiomas .= '<option value="Portugues">Portugues</option>';
        $idiomas .= '<option value="Frances">Frances</option>';
        $idiomas .= '<option value="Italiano">Italiano</option>';
        $idiomas .= '<option value="Otro">Otro</option>';
        $idiomas .= '</select></td>';
	$idiomas .= '<td class="td2"><input type="text" class="field extra" disabled="disabled"></td>';
        $idiomas .= '<td class="td3">';
	$idiomas .= '<input type="checkbox" class="habilidad1" value="1" /><span class="habilidad">Habla</span>';
	$idiomas .= '<input type="checkbox" class="habilidad2" value="2" /><span class="habilidad">Lee</span>';
	$idiomas .= '<input type="checkbox" class="habilidad3" value="4" /><span class="habilidad">Escribe</span>';
	$idiomas .= '</td>';
	$idiomas .= '<td class="sub"><a href="#" class="sub" id="sub_idioma_1" title="Quitar Idioma">&nbsp;</a></td>';
	$idiomas .= '</tr>';
} else {
	//leo la tabla y muestro los registros
	$idiomas = '';
	while($aspirantes_idioma = $base->f_array($result1)) {
		$id_aspirantes_idiomas = $aspirantes_idioma['id_aspirantes_idiomas'];
		$idioma = $aspirantes_idioma['idioma'];
                $extra = isset($aspirantes_idioma['extra']) ? $aspirantes_idioma['extra']:'';
		$habilidad = $aspirantes_idioma['habilidad'];
		$idiomas .= '<tr class="idioma" id="idioma_'.$id_aspirantes_idiomas.'">';
                $idiomas .= '<td class="td1"><select class="nombre_idioma">';
                $idiomas .= '<option value="Ninguno">Ninguno</option>';
                $selected = $idioma == 'Ingles' ? 'selected="selected"' : '';
                $idiomas .= '<option value="Ingles" '.$selected.'>Ingles</option>';
                $selected = $idioma == 'Portugues' ? 'selected="selected"' : '';
                $idiomas .= '<option value="Portugues" '.$selected.'>Portugues</option>';
                $selected = $idioma == 'Frances' ? 'selected="selected"' : '';
                $idiomas .= '<option value="Frances" '.$selected.'>Frances</option>';
                $selected = $idioma == 'Italiano' ? 'selected="selected"' : '';
                $idiomas .= '<option value="Italiano" '.$selected.'>Italiano</option>';
                $selected = $idioma == 'Otro' ? 'selected="selected"' : '';
                $idiomas .= '<option value="Otro" '.$selected.'>Otro</option>';
                $idiomas .= '</select></td>';
                $idiomas .= '<td class="td2"><input type="text" class="field extra" value="'.$extra.'" disabled="disabled"></td>';
		//$idiomas .= '<td class="td3"><input type="text" class="field idioma" value="'.$idioma.'"></td>';
		$idiomas .= '<td class="td3">';
		$checked0 = ($habilidad==1 || $habilidad==3 || $habilidad==5 || $habilidad==7) ? 'checked=checked' : '';
		$checked1 = ($habilidad==2 || $habilidad==3 || $habilidad==6 || $habilidad==7) ? 'checked=checked' : '';
		$checked2 = ($habilidad==4 || $habilidad==5 || $habilidad==6 || $habilidad==7) ? 'checked=checked' : '';
		$idiomas .= '<input type="checkbox" class="habilidad1" value="1" '.$checked0.' /><span class="habilidad">Habla</span>';
		$idiomas .= '<input type="checkbox" class="habilidad2" value="2" '.$checked1.' /><span class="habilidad">Lee</span>';
		$idiomas .= '<input type="checkbox" class="habilidad3" value="4" '.$checked2.' /><span class="habilidad">Escribe</span>';
		$idiomas .= '</td>';
		$idiomas .= '<td class="sub"><a href="#" class="sub" id="sub_idioma_'.$id_aspirantes_idiomas.'" title="Quitar Idioma">&nbsp;</a></td></tr>';
	}
}
echo $idiomas;
	break;
case 'meritos':
$sql = "SELECT * FROM aspirantes_meritos WHERE id_aspirante='".$id_aspirante."' ORDER BY id_aspirantes_meritos";
$result1 = $base->safe_query($sql);
if ($base->NumFilas($result1)==0){
	//si no tengo meritos muestro una fila en blanco
	$meritos  = '<tr class="merito" id="merito_1">';
	$meritos .= '<td><input type="text" class="field merito" value="" /></td>';
	$meritos .= '<td><a href="#" class="sub" id="sub_merito_1" title="Quitar M&eacute;rito">&nbsp;</a></td>';
	$meritos .= '</tr>';
} else {
	//leo la tabla y muestro los registros
	$meritos = '';
	while($aspirantes_merito = $base->f_array($result1)) {
		$id_aspirantes_meritos = $aspirantes_merito['id_aspirantes_meritos'];
		$merito = $aspirantes_merito['merito'];
		$meritos .= '<tr class="merito" id="merito_'.$id_aspirantes_meritos.'">';
		$meritos .= '<td class="td4"><input type="text" class="field merito" value="'.$merito.'"></td>';
		$meritos .= '<td><a href="#" class="sub" id="sub_merito_'.$id_aspirantes_meritos.'" title="Quitar Merito">&nbsp;</a></td></tr>';
	}
}
echo $meritos;
	break;
case 'referencias':
$sql = "SELECT * FROM aspirantes_referencias WHERE id_aspirante='".$id_aspirante."' ORDER BY id_aspirantes_referencias";
$result1 = $base->safe_query($sql);
if ($base->NumFilas($result1)==0){
	//si no tengo referencias muestro una fila en blanco
	$referencias = '<tr class="referencia" id="referencia_1">';

	$referencias .= '<td><input type="text" class="field medico" value="Ninguna" /></td>';
	$referencias .= '<td><input type="text" class="field celular" disabled="disabled" /></td>';
	$referencias .= '<td><input type="text" class="field mail" disabled="disabled" /></td>';
	$referencias .= '<td><input type="text" class="field lugar_trabajo" disabled="disabled" />';
	$referencias .= '<td><select class="semm" disabled="disabled"><option value="0">Si</option><option value="1">No</option></select></td>';

	$referencias .= '<td><a href="#" class="sub" id="sub_referencia_1" title="Quitar Referencia">&nbsp;</a></td>';
	$referencias .= '</tr>';
} else {
	//leo la tabla y muestro los registros
	$referencias = '';
	while($aspirantes_referencia = $base->f_array($result1)) {
            $id_aspirantes_referencia = $aspirantes_referencia['id_aspirantes_referencias'];
            $medico = $aspirantes_referencia['medico'];
            $celular = $aspirantes_referencia['celular'];
            $mail = $aspirantes_referencia['mail'];
            $funcionario_semm = isset($aspirantes_referencia['funcionario_semm']) ? $aspirantes_referencia['funcionario_semm'] : '';
            $lugar = $aspirantes_referencia['lugar'];
            $disabled = $medico == 'Ninguna' ? 'disabled="disabled"' : '';
            $referencias .= '<tr class="referencia" id="referencia_'.$id_aspirantes_referencia.'">';
            $referencias .= '<td class="td2"><input type="text" class="field medico" value="'.$medico.'" ></td>';
            $referencias .= '<td class="td1"><input type="text" class="field celular" value="'.$celular.'" '.$disabled.' /></td>';
            $referencias .= '<td class="td1"><input type="text" class="field mail" value="'.$mail.'" '.$disabled.' /></td>';
            $referencias .= '<td class="td1"><input type="text" class="field lugar_trabajo" value="'.$lugar.'" '.$disabled.' /></td>';
            $selected_si = $funcionario_semm==0 ? 'selected=selected' : '';
            $selected_no = $funcionario_semm==1 ? 'selected=selected' : '';
            $referencias .= '<td class="td1"><select class="funcionario_semm">';
            $referencias .= '<option value="0" '.$selected_si.'>Si</option>';
            $referencias .= '<option value="1" '.$selected_no.'>No</option>';
            $referencias .= '';
            $referencias .= '</select></td>';
            $referencias .= '<td><a href="#" class="sub" id="sub_referencia_'.$id_aspirantes_referencia.'" title="Quitar Referencia">&nbsp;</a></td></tr>';	
	}
}
echo $referencias;
	break;
case 'imagenes';
$sql = "SELECT * FROM aspirantes WHERE id_aspirante='".$id_aspirante."'";
$result1 = $base->safe_query($sql);
$aspirante = $base->f_array($result1);
$imagen = $aspirante['imagen'];
$output  = '<img src="archivos_adjuntos/fotos/'.$imagen.'" width="150" height="150">';
$output .= '<input id="id_foto" type="hidden" value="'.$imagen.'">';
echo $output;
	break;
case 'adjuntos';
$sql = "SELECT * FROM aspirantes_adjuntos WHERE id_aspirante='".$id_aspirante."'";
$result1 = $base->safe_query($sql);
if ($base->NumFilas($result1)==0){
	//si no tengo adjuntos muestro una fila en blanco
	$adjuntos = '<tr class="adjunto" id="adjunto_1">';
	$adjuntos .= '<td><input type="text" class="field titulo" value="" /></td>';
	$adjuntos .= '<td class="filename">';
	$adjuntos .= '<form class="upload_file" method="post" enctype="multipart/form-data"  action="#">';
	$adjuntos .= '<div class="nombre_adjunto">';
	$adjuntos .= '<input type="file" class="file-input" name="fichero" />';
	$adjuntos .= '</div>';
	$adjuntos .= '</form>';
	$adjuntos .= '</td>';
	$adjuntos .= '<td><a href="#" class="sub" id="sub_adjunto_1" title="Quitar Adjunto">&nbsp;</a></td>';
	$adjuntos .= '</tr>';
} else {
	//leo la tabla y muestro los registros
	$adjuntos = '';
	while($adjunto = $base->f_array($result1)) {
		$id_aspirantes_adjuntos = $adjunto['id_aspirantes_adjuntos'];
		$titulo = $adjunto['titulo'];
		$filename = $adjunto['filename'];
		$adjuntos .= '<tr class="adjunto" id="adjunto_'.$id_aspirantes_adjuntos.'">';
		$adjuntos .= '<td class="td3"><input type="text" class="field titulo" value="'.$titulo.'" /></td>';
		$adjuntos .= '<td class="td3"><input type="text" class="field nombre" value="'.$filename.'" /></td>';
		$adjuntos .= '<td class="sub"><a href="#" class="sub" id="sub_adjunto_'.$id_aspirantes_adjuntos.'">&nbsp;</a></td>';
		$adjuntos .= '</tr>';
	}
}
echo $adjuntos;
	break;

}

$base->close();
?>