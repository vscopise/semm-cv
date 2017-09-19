$(document).ready(function() {
	var id_aspirante = $('#id_aspirante').val();
	var tabla = 'postgrados';
	$.ajax({
		url: 'includes/load_aspirante.php',
		type: 'POST',
		data: { 
			id_aspirante: id_aspirante,
			tabla: tabla
			},
			success: function(response){
				$('#postgrados tr.last').before(response);
			}
	});
	var tabla = 'cursos';
	$.ajax({
		url: 'includes/load_aspirante.php',
		type: 'POST',
		data: { 
			id_aspirante: id_aspirante,
			tabla: tabla
			},
			success: function(response){
				$('#cursos tr.last').before(response);
			}
	});
	var tabla = 'exp_laboral';
	$.ajax({
		url: 'includes/load_aspirante.php',
		type: 'POST',
		data: { 
			id_aspirante: id_aspirante,
			tabla: tabla
			},
			success: function(response){
				$('#exp_laboral tr.last').before(response);
			}
	});
	var tabla = 'otros_cursos';
	$.ajax({
		url: 'includes/load_aspirante.php',
		type: 'POST',
		data: { 
			id_aspirante: id_aspirante,
			tabla: tabla
			},
			success: function(response){
				$('#otros_cursos tr.last').before(response);
			}
	});
	var tabla = 'congresos';
	$.ajax({
		url: 'includes/load_aspirante.php',
		type: 'POST',
		data: { 
			id_aspirante: id_aspirante,
			tabla: tabla
			},
			success: function(response){
				$('#congresos tr.last').before(response);
			}
	});
	var tabla = 'idiomas';
	$.ajax({
		url: 'includes/load_aspirante.php',
		type: 'POST',
		data: { 
			id_aspirante: id_aspirante,
			tabla: tabla
			},
			success: function(response){
				$('#idiomas tr.last').before(response);
			}
	});
	var tabla = 'meritos';
	$.ajax({
		url: 'includes/load_aspirante.php',
		type: 'POST',
		data: { 
			id_aspirante: id_aspirante,
			tabla: tabla
			},
			success: function(response){
				$('#meritos tr.last').before(response);
			}
	});
	var tabla = 'referencias';
	$.ajax({
		url: 'includes/load_aspirante.php',
		type: 'POST',
		data: { 
			id_aspirante: id_aspirante,
			tabla: tabla
			},
			success: function(response){
				$('#referencias tr.last').before(response);
			}
	});
	var tabla = 'imagenes';
	$.ajax({
		url: 'includes/load_aspirante.php',
		type: 'POST',
		data: { 
			id_aspirante: id_aspirante,
			tabla: tabla
			},
			success: function(response){
				$('#output').html(response);
			}
	});
	var tabla = 'adjuntos';
	$.ajax({
		url: 'includes/load_aspirante.php',
		type: 'POST',
		data: { 
			id_aspirante: id_aspirante,
			tabla: tabla
			},
			success: function(response){
				$('#adjuntos tr.last').before(response);
			}
	});
});