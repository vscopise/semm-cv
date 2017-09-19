$(document).ready(function(){
	$('.buscar').click(function(){
		$('#resultados').html('<div style="padding:10px"><img src="../includes/images/ajax-loader.gif" /> <span>Buscando...</span></div>');
		var name = $('#name').val();
		var last_name = $('#last_name').val();
		var born_date = $('#born_date').val();
		var ci_num = $('#ci_num').val();
		var cp_num = $('#cp_num').val();
		var tel_num = $('#tel_num').val();
		var cel_num = $('#cel_num').val();
		var egreso_facultad = $('#egreso_facultad').val();
		var email = $('#email').val();
                var estados = [];
                $('#buscar_estados input.estado:checked').each(function(){
                    //estado[i] = e.checked;
                    estados.push($(this).attr('id'));
                });
		var especialidades = JSON.stringify($('#especialidades').val());
		var cursos = JSON.stringify($('#cursos').val());
          var otros_cursos = JSON.stringify($('#otros_cursos').val());
		var experiencia = $('#experiencia').val();
		var congresos = $('#congresos').val();
		var idiomas = $('#idiomas').val();
		var meritos = $('#meritos').val();
		var referencias = $('#referencias').val();
                //var estados = JSON.stringify(estado);
		$.ajax({
			url: '../includes/buscar_aspirantes.php',
			type: 'POST',
                        datatype: 'json',
			data: {
				name: name,
				last_name: last_name,
				born_date: born_date,
				ci_num: ci_num,
				cp_num: cp_num,
				tel_num: tel_num,
				cel_num: cel_num,
				egreso_facultad: egreso_facultad,
				email: email,
				estados: estados,
				especialidades: especialidades,
                                cursos: cursos,
                                otros_cursos: otros_cursos,
				experiencia: experiencia,
				congresos: congresos,
				idiomas: idiomas,
				meritos: meritos,
				referencias: referencias
			},
			success: function(response){
				$('#resultados').html(response);
			}
		});
		$('#tab_resultados').click();
		$('#bajar_excel').prop('disabled', false);

	});
	$('#resultados').on('click','tr',function(e) {

		$(this).parent().find('tr').removeClass('selected');

		$(this).addClass('selected');;
		$('.detalles').removeAttr('disabled');
		var id_aspirante = $(this).find('#id_aspirante').val();
		var resultados = $(this).parents('#resultados');
		resultados.find('#aspirante').val(id_aspirante);
                
                $('#aspirante').val(id_aspirante);
		
		$.ajax({
			url: '../includes/leer_detalles.php',
			type: 'GET',
                        data: 'id_aspirante='+id_aspirante,
                        datatype: 'json',
			success: function(response){
                            response = $.parseJSON(response);
				$('#id_del_aspirante').val(response[0]);
				$('#nombre_completo').text(response[1]);
				$('#fecha_nacimiento').text(response[2]);
				$('#ced_identidad').text(response[3]);
				$('#caja_profesional').text(response[4]);
				$('#num_telefono').text(response[5]);
				$('#num_celular').text(response[6]);
				$('#mail').text(response[7]);
				$('#fecha_ingreso').text(response[8]);
				$('#fecha_actualizacion').text(response[9]);
				$('#imagen').html(response[10]);
				$('#tabla_aspirantes_postgrados').html(response[11]);
				$('#tabla_aspirantes_cursos').html(response[12]);
				$('#tabla_aspirantes_otros_cursos').html(response[13]);
				$('#tabla_aspirantes_exp_laboral').html(response[14]);
				$('#tabla_aspirantes_congresos').html(response[15]);
				$('#tabla_idiomas').html(response[16]);
				$('#tabla_meritos').html(response[17]);
				$('#tabla_aspirantes_referencias').html(response[18]);
				$('#tabla_aspirantes_adjuntos').html(response[19]);
                                $('#estados_aspirante li input.estado').each(function(){
                                    if ( response[20].indexOf($(this).attr('id')) !== -1 ) {
                                        $(this).prop('checked', true);
                                    } else {
                                        $(this).prop('checked', false);
                                    }
                                });
			}
		});
                $('#resultado_estado').html('');
		$('#tab_detalles').click();
		
	});

	$('.borrar1').click(function(){
		$('#name').val('');
		$('#last_name').val('');
		$('#born_date').val('');
		$('#ci_num').val('');
		$('#cp_num').val('');
		$('#tel_num').val('');
		$('#cel_num').val('');
		$('#egreso_facultad').val('');
		$('#email').val('');
		$('#resultados').html('');
                $('input:checkbox').removeAttr('checked');
	});
	$('.borrar2').click(function(){
		$('#especialidades').attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
		$('#cursos').attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
		$('#otros_cursos').attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
		$('#experiencia').val('');
		$('#congresos').val('');
		$('#idiomas').val('');
		$('#meritos').val('');
		$('#referencias').val('');
		$('#resultados').html('');
                $('input:checkbox').removeAttr('checked');
	});
        
        $('#actualizar_estados').click(function(){
            $('#resultado_estado').html('...');
            var estados = [];
            $('#estados_aspirante li input.estado:checked').each(function(){
                estados.push($(this).attr('id'));
            });
            var id_del_aspirante = $('#id_del_aspirante').val();
            $.ajax({
			url: '../includes/guardar_estados.php',
			type: 'GET',
                        dataType: 'json',
                        data: {
                            id_del_aspirante: id_del_aspirante,
                            estados: estados
                        }
            })
            .done(function(data){
                $('#resultado_estado').html(data);
            })
            .fail(function(data){
                $('#resultado_estado').html('Estados actualizados');
            });
            //$('#leido').prop("checked", true);
        });
        $('#tabla_estados').on('click', 'td.nombre_estado', function(){
            var nombre_estado = $(this).text();
            var id_estado = $(this).parent().children().find('.id_estado').text();
            $('input[name=id_estado]').val(id_estado);
            $('input[name=nombre_estado]').val(nombre_estado);
        });
        $('#bajar_excel').click(function(){
            var cabezal = '<tr><td>Nombre</td><td>Teléfono</td><td>Estado</td><td>Email</td></tr>';
            $('#resultados .admin-result > tbody:first').prepend( cabezal );
            var d = new Date();
            var yy = d.getFullYear();
            var mm = (0+(d.getMonth()+1).toString()).slice(-2);
            var dd =  d.getDate();
            var date =  yy + '-' + mm  + '-' + dd;
            $("#resultados").table2excel({
                exclude: ".noExl",
                name: "Semm - Resultado de búsqueda",
                filename: "Resultados-consulta-Semm-" + date //do not include extension
            });
            $('#resultados .admin-result > tbody > tr:first-child   ').remove(); 
        });
        $('#tabla_usuarios').on('click','tr',function(e) {
            var id_aspirante = $(this).children().first().text();
            $.ajax({
			url: '../includes/leer_administrador.php',
			type: 'GET',
                        data: 'id_aspirante='+id_aspirante,
                        datatype: 'json',
			success: function(response){
                            response = $.parseJSON(response);
				$('#id_aspirante').val(response.id_aspirante);
				$('#name_aspirante').text(response.name);
                                $('.mensaje').html('');
			}
		});
		$('#tab_perfil').click();
            
        });
        $('#accordion h3').click(function(){
            $('p.mensaje').html('');
        });
        $('#borrar_usuario').click(function(){
            $(this).parent().children('input[type=submit]').attr("disabled", !this.checked);
        })
});