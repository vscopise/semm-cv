			$(document).ready(function(){

				
				
			});
			
			$(function() { //$currentForm	=$('#form_wrapper').children('form.active')
					//the form wrapper (includes all forms)
				var $form_wrapper	= $('#form_wrapper'),
					//the current form is the one with class active
					$currentForm	= $form_wrapper.children('form.active'),
					//the change form links
					$linkform		= $form_wrapper.find('.linkform');
						
				//get width and height of each form and store them for later						
				$form_wrapper.children('form').each(function(i){
					var $theForm	= $(this);
					//solve the inline display none problem when using fadeIn fadeOut
					if(!$theForm.hasClass('active'))
						$theForm.hide();
					$theForm.data({
						width	: $theForm.width(),
						height	: $theForm.height()
					});
				});
				
				//set width and height of wrapper (same of current form)
				setWrapperWidth();
				
				/*
				clicking a link (change form event) in the form
				makes the current form hide.
				The wrapper animates its width and height to the 
				width and height of the new current form.
				After the animation, the new form is shown
				*/
				$linkform.bind('click',function(e){
					var $link	= $(this);
					var target	= $link.attr('rel');
					$currentForm.fadeOut(400,function(){
						//remove class active from current form
						$currentForm.removeClass('active');
						//new current form
						$currentForm= $form_wrapper.children('form.'+target);
						//animate the wrapper
						$form_wrapper.stop()
									 .animate({
										width	: $currentForm.data('width') + 'px',
										height	: $currentForm.data('height') + 'px'
									 },500,function(){
										//new form gets class active
										$currentForm.addClass('active');
										//show the new form
										$currentForm.fadeIn(400);
										if (target=='form1'){
											$currentForm.find('a[rel='+target+']').addClass('sel-first');
										} else if (target=='form11') {
											$currentForm.find('a[rel='+target+']').addClass('sel-last');
										} else {
											$currentForm.find('a[rel='+target+']').addClass('sel');
										}
									 });
					});
					e.preventDefault();
				});
				function setWrapperWidth(){
					$form_wrapper.css({
						width	: $currentForm.data('width') + 'px',
						height	: $currentForm.data('height') + 'px'
					});
				};				
				$('#add_postgrado').click(function(){
					if ($('#postgrados tr.postgrado').length>0) {
						var num_postgrados = $('#postgrados tr.postgrado:last').attr('id').substring(10);
					} else {
						var num_postgrados = 0;
					}
					var last_especialidad = $('#postgrados tr.postgrado:last').find('.especialidad option:selected').text();
					var last_inicio = $('#postgrados tr.postgrado:last').find('.inicio').val();
					var last_egreso = $('#postgrados tr.postgrado:last').find('.egreso').val();
					if (num_postgrados!=0 && (last_especialidad=='No tiene' || last_inicio=='' || last_egreso=='') ){
						alert('Para agregar otro postgrado debe completar el anterior');
					} else {
						$.ajax({
							url: 'includes/add_tr_postgrado.php',
							type: 'POST',
							data: {
								num_postgrados: num_postgrados
							},
							success: function(response){
								$('#postgrados tr.last').before(response);
								$('#postgrados tr.postgrado:even').addClass('even');
								$('#postgrados tr.postgrado:even').removeClass('odd');
								$('#postgrados tr.postgrado:odd').addClass('odd');
								$('#postgrados tr.postgrado:odd').removeClass('even');
							}
						});
					}
				});
				$('#postgrados').on('click','.sub',function(e) {
					var tr_selected = "postgrado_"+$(this).attr('id').substring(14);
					$('#'+tr_selected).remove();
				});
				$('#postgrados').on('change','.especialidad',function(e) {
                                    if ($(this).children('option:selected').text()=='No tiene'){
                                        $(this).parents('tr').find('.tipo_postgrado').attr('disabled', 'disabled');
                                        $(this).parents('tr').find('.inicio').attr('disabled', 'disabled');
                                        $(this).parents('tr').find('.cursa').attr('disabled', 'disabled');
                                        $(this).parents('tr').find('.egresado').attr('disabled', 'disabled');
                                    } else {
                                        $(this).parents('tr').find('.tipo_postgrado').removeAttr('disabled');
                                        $(this).parents('tr').find('.inicio').removeAttr('disabled');
                                        $(this).parents('tr').find('.cursa').removeAttr('disabled');
                                        $(this).parents('tr').find('.egresado').removeAttr('disabled');
                                    }
				});
                                $('#postgrados').on('change','.egresado',function(e) {
                                    if ($(this).val()=='1'){
                                        $(this).parents('tr').find('.egreso').attr('disabled', 'disabled');
                                        $(this).parents('tr').find('.egreso').val('');
                                    } else {
                                        $(this).parents('tr').find('.egreso').removeAttr('disabled');
                                    }
                                });
				$('#add_curso').click(function(){
					if ($('#cursos tr.curso').length>0) {
						var num_cursos = $('#cursos tr.curso:last').attr('id').substring(6);
					} else {
						var num_cursos = 0;
					}
					var last_curso = $('#cursos tr.curso:last').find('.nombre_curso option:selected').text();
					var vigencia = $('#cursos tr.curso:last').find('.vigencia').val();
					var lugar = $('#cursos tr.curso:last').find('.lugar').val();
					if (num_cursos!=0 && (last_curso=='No tengo' || vigencia=='' || lugar=='')){
						alert('Para agregar otro curso debe completar el anterior');
					} else {
						$.ajax({
							url: 'includes/add_tr_curso.php',
							type: 'POST',
							data: {
								num_cursos: num_cursos
							},
							success: function(response){
								$('#cursos tr.last').before(response);
								$('#cursos tr.curso:even').addClass('even');
								$('#cursos tr.curso:even').removeClass('odd')
								$('#cursos tr.curso:odd').addClass('odd');
								$('#cursos tr.curso:odd').removeClass('even');
							}
						});
					}
				});
				$('#cursos').on('change','.nombre_curso',function(e) {
                                    if ($(this).children('option:selected').text()=='Otros'){
                                        $(this).parents('tr').children().find('.extra').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.vigencia').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.lugar').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.extra').focus();
                                    } else if ($(this).children('option:selected').text()=='No tengo'){
                                        $(this).parents('tr').children().find('.extra').attr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.extra').val('');
                                        $(this).parents('tr').children().find('.vigencia').attr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.vigencia').val('');
                                        $(this).parents('tr').children().find('.lugar').attr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.lugar').val('');
                                    } else {
                                        $(this).parents('tr').children().find('.extra').attr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.extra').val('');
                                        $(this).parents('tr').children().find('.vigencia').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.lugar').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.vigencia').focus();
                                    };
				});
				$('#cursos').on('click','.sub',function(e) {
					var tr_selected = "curso_"+$(this).attr('id').substring(10);
					$('#'+tr_selected).remove();
				});
				$('#add_exp_lab').click(function(){
                                    if ($('#exp_laboral tr.exp_lab').length>0) {
                                        var num_exp_lab = $('#exp_laboral tr.exp_lab:last').attr('id').substring(8);
                                    } else {
                                        var num_exp_lab = 0;
                                    }
                                    var last_empresa = $('#exp_laboral tr.exp_lab:last').find('.empresa').val();
                                    var last_cargo = $('#exp_laboral tr.exp_lab:last').find('.cargo').val();
                                    var last_ingreso = $('#exp_laboral tr.exp_lab:last').find('.ingreso').val();
                                    var last_cese = $('#exp_laboral tr.exp_lab:last').find('.cese').val();
					if (num_exp_lab!=0 && (last_empresa=='Ninguna' || last_cargo=='' || last_ingreso=='' || last_cese=='')){
                                            alert('Para agregar otra experiencia debe completar la anterior');
					} else {
                                            $.ajax({
                                                url: 'includes/add_tr_exp.php',
                                                type: 'POST',
                                                data: {
                                                        num_exp_lab: num_exp_lab
                                                },
                                                success: function(response){
                                                    $('#exp_laboral tr.last').before(response);
                                                    /*$('#exp_laboral tr.exp_lab:even').addClass('even');
                                                    $('#exp_laboral tr.exp_lab:even').removeClass('odd');
                                                    $('#exp_laboral tr.exp_lab:odd').addClass('odd');
                                                    $('#exp_laboral tr.exp_lab:odd').removeClass('even');*/
                                                }
                                            });
					}
				});
                                $('#exp_laboral').on('change','.empresa',function(e) {
                                   if ($(this).text()=='Ninguna') {
                                       $(this).parents('tr').children().find('.cargo').attr('disabled', 'disabled');
                                       $(this).parents('tr').children().find('.ingreso').attr('disabled', 'disabled');
                                       $(this).parents('tr').children().find('.cese').attr('disabled', 'disabled');
                                   } else {
                                       $(this).parents('tr').children().find('.cargo').removeAttr('disabled', 'disabled');
                                       $(this).parents('tr').children().find('.ingreso').removeAttr('disabled', 'disabled');
                                       $(this).parents('tr').children().find('.cese').removeAttr('disabled', 'disabled');
                                   }
                                });
				$('#exp_laboral').on('click','.sub',function(e) {
					var tr_selected = "exp_lab_"+$(this).attr('id').substring(10);
					$('#'+tr_selected).remove();
				});
				$('#add_otro_curso').click(function(){
					if ($('#otros_cursos tr.otro_curso').length>0) {
						var num_otros_cursos = $('#otros_cursos tr.otro_curso:last').attr('id').substring(11);
					} else {
						var num_otros_cursos = 0;
					}
					var last_otro_curso_tipo = $('#otros_cursos tr.otro_curso:last').find('.nombre_curso option:selected').text();
					var last_otro_curso_inicio = $('#otros_cursos tr.otro_curso:last').find('.inicio').val();
					var last_otro_curso_nombre = $('#otros_cursos tr.otro_curso:last').find('.nombre').val();
					var last_otro_curso_lugar = $('#otros_cursos tr.otro_curso:last').find('.lugar').val();
					if (num_otros_cursos!=0 
					    && (last_otro_curso_tipo=='No tengo' || last_otro_curso_inicio=='' || last_otro_curso_nombre=='' || last_otro_curso_lugar=='')){
						alert('Para agregar otro curso debe completar la anterior');
					} else {
						$.ajax({
							url: 'includes/add_otro_curso.php',
							type: 'POST',
							data: {
								num_otros_cursos: num_otros_cursos
							},
							success: function(response){
								$('#otros_cursos tr.last').before(response);
								$('#otros_cursos tr.otro_curso:even').addClass('even');
								$('#otros_cursos tr.otro_curso:even').removeClass('odd');
								$('#otros_cursos tr.otro_curso:odd').addClass('odd');
								$('#otros_cursos tr.otro_curso:odd').removeClass('even');
							}
						});
					}
				});
				$('#otros_cursos').on('click','.sub',function(e) {
					var tr_selected = "otro_curso_"+$(this).attr('id').substring(10);
					$('#'+tr_selected).remove();
				});
                                $('#otros_cursos').on('change','.tipo',function(e) {
                                    if ($(this).children('option:selected').text()=='No tengo'){
                                        $(this).parents('tr').find('.inicio').attr('disabled', 'disabled');
                                        $(this).parents('tr').find('.nombre').attr('disabled', 'disabled');
                                        $(this).parents('tr').find('.lugar').attr('disabled', 'disabled');
                                    } else {
                                        $(this).parents('tr').find('.inicio').removeAttr('disabled');
                                        $(this).parents('tr').find('.nombre').removeAttr('disabled');
                                        $(this).parents('tr').find('.lugar').removeAttr('disabled');
                                        $(this).parents('tr').find('.inicio').focus();
                                    }
                                    
                                });
				$('#add_congreso').click(function(){
					if ($('#congresos tr.congreso').length>0) {
						var num_congresos = $('#congresos tr.congreso:last').attr('id').substring(9);
					} else {
						var num_congresos = 0;
					}
					var last_congreso_nombre = $('#congresos tr.congreso:last').find('.nombre').val();
					var last_congreso_tema = $('#congresos tr.congreso:last').find('.tema').val();
					var last_congreso_fecha = $('#congresos tr.congreso:last').find('.fecha').val();
					if (num_congresos!=0 && (last_congreso_nombre=='No tengo' || last_congreso_tema=='' || last_congreso_fecha=='')){
						alert('Para agregar otro congreso debe completar el anterior');
					} else {
						$.ajax({
							url: 'includes/add_tr_congreso.php',
							type: 'POST',
							data: {
								num_congresos: num_congresos
							},
							success: function(response){
								$('#congresos tr.last').before(response);
								$('#congresos tr.congreso:even').addClass('even');
								$('#congresos tr.congreso:even').removeClass('odd');
								$('#congresos tr.congreso:odd').addClass('odd');
								$('#congresos tr.congreso:odd').removeClass('even');
							}
						});
					}
				});
                                $('#congresos').on('change','.nombre',function(e){
                                    if ($(this).text()=='No tengo'){
                                        $(this).parents('tr').children().find('.tema').attr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.fecha').attr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.caracter').attr('disabled', 'disabled');
                                    } else {
                                        $(this).parents('tr').children().find('.tema').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.fecha').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.caracter').removeAttr('disabled', 'disabled');
                                    }
                                });
				$('#congresos').on('click','.sub',function(e) {
					var tr_selected = "congreso_"+$(this).attr('id').substring(13);
					$('#'+tr_selected).remove();
				});
				$('#add_idioma').click(function(){
					if ($('#idiomas tr.idioma').length>0) {
						var num_idiomas = $('#idiomas tr.idioma:last').attr('id').substring(7);
					} else {
						var num_idiomas = 0;
					}
					var last_idioma = $('#idiomas tr.idioma:last').find('.nombre_idioma').val();
					if (num_idiomas!=0 && (last_idioma=='Ninguno' || last_idioma=='')){
						alert('Para agregar otro Idioma debe completar el anterior');
					} else {
						$.ajax({
							url: 'includes/add_tr_idioma.php',
							type: 'POST',
							data: {
								num_idiomas: num_idiomas
							},
							success: function(response){
								$('#idiomas tr.last').before(response);
								$('#idiomas tr.idioma:even').addClass('even');
								$('#idiomas tr.idioma:even').removeClass('odd');
								$('#idiomas tr.idioma:odd').addClass('odd');
								$('#idiomas tr.idioma:odd').removeClass('even');
							}
						});
					}
				});
                                $('#idiomas').on('change','.nombre_idioma',function(e) {
                                    if ($(this).children('option:selected').text()=='Otro'){
                                        $(this).parents('tr').children().find('.extra').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.habilidad1').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.habilidad2').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.habilidad3').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.extra').focus();
                                    } else if ($(this).children('option:selected').text()=='Ninguno'){
                                        $(this).parents('tr').children().find('.extra').attr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.extra').val('');
                                        $(this).parents('tr').children().find('.habilidad1').attr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.habilidad2').attr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.habilidad3').attr('disabled', 'disabled');
                                    } else {
                                        $(this).parents('tr').children().find('.extra').attr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.extra').val('');
                                        $(this).parents('tr').children().find('.habilidad1').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.habilidad2').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.habilidad3').removeAttr('disabled', 'disabled');
                                    }
				});
				$('#idiomas').on('click','.sub',function(e) {
					/*var tr_selected = "idioma_"+$(this).attr('id').substring(11);
					$('#'+tr_selected).remove();*/
                                        $(this).parents('tr').remove();
				});
                                
				$('#add_merito').click(function(){
					if ($('#meritos tr.merito').length>0) {
						var num_meritos = $('#meritos tr.merito:last').attr('id').substring(7);
					} else {
						var num_meritos = 0;
					}
					var last_merito = $('#meritos tr.merito:last').find('.merito').val();
					if (num_meritos!=0 && (last_merito=='No tengo' || last_merito=='')){
						alert('Para agregar otro Merito debe completar el anterior');
					} else {
						$.ajax({
							url: 'includes/add_tr_merito.php',
							type: 'POST',
							data: {
								num_meritos: num_meritos
							},
							success: function(response){
								$('#meritos tr.last').before(response);
								$('#meritos tr.merito:even').addClass('even');
								$('#meritos tr.merito:even').removeClass('odd');
								$('#meritos tr.merito:odd').addClass('odd');
								$('#meritos tr.merito:odd').removeClass('even');
							}
						});
					}
				});
				$('#meritos').on('click','.sub',function(e) {
					var tr_selected = "merito_"+$(this).attr('id').substring(11);
					$('#'+tr_selected).remove();
				});
				$('#add_referencia').click(function(){
                                    if ($('#referencias tr.referencia').length>0) {
                                        var num_referencias = $('#referencias tr.referencia:last').attr('id').substring(11);
                                    } else {
                                        var num_referencias = 0;
                                    }
                                    var last_referencia_medico = $('#referencias tr.referencia:last').find('.medico').val();
                                    var last_referencia_celular = $('#referencias tr.referencia:last').find('.celular').val();
                                    var last_referencia_mail = $('#referencias tr.referencia:last').find('.mail').val();
                                    var last_referencia_lugar = $('#referencias tr.referencia:last').find('.lugar_trabajo').val();
                                    if (num_referencias!=0 && (last_referencia_medico=='Ninguna' || last_referencia_medico=='' || last_referencia_celular=='' || last_referencia_celular=='' || last_referencia_mail=='' || last_referencia_lugar=='')){
                                        alert('Para agregar otra Referencia debe completar el anterior');
                                    } else {
						$.ajax({
							url: 'includes/add_tr_referencia.php',
							type: 'POST',
							data: {
								num_referencias: num_referencias
							},
							success: function(response){
								$('#referencias tr.last').before(response);
								$('#referencias tr.referencia:even').addClass('even');
								$('#referencias tr.referencia:even').removeClass('odd');
								$('#referencias tr.referencia:odd').addClass('odd');
								$('#referencias tr.referencia:odd').removeClass('even');
							}
						});
					}
				});
                                $('#referencias').on('change','.medico',function(e){
                                    if ($(this).text()=='Ninguna'){
                                        $(this).parents('tr').children().find('.celular').attr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.mail').attr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.lugar_trabajo').attr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.semm').attr('disabled', 'disabled');
                                    } else {
                                        $(this).parents('tr').children().find('.celular').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.mail').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.lugar_trabajo').removeAttr('disabled', 'disabled');
                                        $(this).parents('tr').children().find('.semm').removeAttr('disabled', 'disabled');
                                    }
                                });
				$('#referencias').on('click','.sub',function(e) {
					var tr_selected = "referencia_"+$(this).attr('id').substring(15);
					$('#'+tr_selected).remove();
				});
				$('#uploadButton').click(function(){
					var id_aspirante = $('#id_aspirante').val();
					$("#output").html('<div style="padding:10px"><img src="includes/images/ajax-loader.gif" alt="Espere por favor"/> <span>Cargando...</span></div>');
					$('#FileUploader').ajaxForm({
						target: '#output',
						data: {
							id_aspirante: id_aspirante
						}
					}).submit();
				});
				
				
				$('#add_adjunto').click(function(){
					if ($('#adjuntos tr.adjunto').length>0) {
						var num_adjuntos = $('#adjuntos tr.adjunto:last').attr('id').substring(8);
					} else {
						var num_adjuntos = 0;
					}
					var last_titulo_adjunto = $('#adjuntos tr.adjunto:last').find('.titulo').val();
					var last_nombre_adjunto = $('#adjuntos tr.adjunto:last').find('.nombre').val();

					if ( $('#adjuntos tr').length > 9 ) {
						alert('No se permiten mas de 10 adjuntos');
					} else {
						if (num_adjuntos==0 || ( last_titulo_adjunto!='Ninguno' && last_nombre_adjunto!='' )){
							$.ajax({
								url: 'includes/add_tr_adjunto.php',
								type: 'POST',
								data: {
									num_adjuntos: num_adjuntos
								},
								success: function(response){
									$('#adjuntos tr.last').before(response);
								}
							});
						} else {
							alert('Para agregar otro Adjunto debe completar el anterior');
						}
					}
				});
				$('#adjuntos').on('click','.sub',function(e) {
                                        e.preventDefault();

                                        if ( typeof $(this).attr('id') != 'undefined' ) {
                                            var tr_selected = "adjunto_"+$(this).attr('id').substring(12);
                                            $('#'+tr_selected).remove();
                                            var filename = $(this).parents('tr').children().find('.nombre').val();
                                            $.ajax({
                                                 type: 'POST',
                                                 url: 'includes/del_adjunto.php',
                                                 data: {filename:filename},
                                                 context: this,
                                                 complete: function() {
                                                    $(this).data('requestRunning', false);
                                                }
                                            });
                                        }
				});
				
				
				/* Actualizaci�n de los datos del aspirante en la base de datos */
				$('.update').click(function(){
				/* Validación del formulario */
					/* Informacion general */
					var name = $('#name').val();
					if (name==''){
						alert("Debe ingresar el nombre");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#name').focus();
						return false;
					}
					var last_name = $('#last_name').val();
					if (last_name==''){
						alert("Debe ingresar el apellido");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#last_name').focus();
						return false;
					}
					var born_date = $('#born_date').val();
					if (born_date==''){
						alert("Debe ingresar la fecha");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#born_date').focus();
						return false;
					}
					var filter = /^[\d][\d]\/[\d][\d]\/[\d][\d][\d][\d]$/;
					if(!filter.test(born_date)){
						alert("La fecha debe estar en el formato \"dd/mm/aaaa\" ");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$("#born_date").focus();
						return false;
					}
					var ci_num = $('#ci_num').val();
					if (ci_num==''){
						alert("Debe ingresar la c\u00e9dula");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#ci_num').focus();
						return false;
					}
					var filter = /^([\d]{4,8})\-[\d]$/;
					if (!filter.test(ci_num)){
						alert("El formato de la c\u00e9dula no es correcto");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#ci_num').focus();
						return false;
					}
                                        
                                        var i = 0;
                                        var s = 0;
                                        var multiplicador = [2, 9, 8, 7, 6, 3, 4];
                                        while( i < 7 ) {
                                            s += multiplicador[i] * parseInt(ci_num.substr(i, 1));
                                            i++;
                                        }
                                        if ( (10 - s % 10) % 10 != parseInt( ci_num.substr(ci_num.length - 1,1) ) ) {
                                            alert("El digito validor no es correcto");
                                            if ($(this).parents('form:first').hasClass('form1') != true){
                                                    $('[rel=form1]').trigger('click');
                                            }
                                            $('#ci_num').focus();
                                            return false;
                                        }
                                        
					var cp_num = $('#cp_num').val();
					if (cp_num==''){
						alert("Debe ingresar el N\u00famero de Caja Profesional");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#cp_num').focus();
						return false;
					}
					if ($.isNumeric(cp_num)== false){
						alert("El N\u00famero de Caja Profesional debe ser num\u00e9rico");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#cp_num').focus();
						return false;
					}
                                        if (cp_num.length < 4){
						alert("El N\u00famero de Caja Profesional debe contener no menos de 4 d\u00edgitos");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#cp_num').focus();
						return false;
					}
					var tel_num = $('#tel_num').val();
					if (tel_num!='' && $.isNumeric(tel_num)== false){
						alert("El N\u00famero de Tel\u00e9fono debe ser num\u00e9rico");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#tel_num').focus();
						return false;
					}
					var cel_num = $('#cel_num').val();
					if (cel_num==''){
						alert("Debe ingresar el N\u00famero de Celular");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#cel_num').focus();
						return false;}
					if ($.isNumeric(cel_num)== false){
						alert("El N\u00famero de Celular debe ser num\u00e9rico");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#cel_num').focus();
						return false;
					}
					var egreso_facultad = $('#egreso_facultad').val();
					if (egreso_facultad==''){
						alert("Debe ingresar el A\u00f1o de Egreso de Facultad");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#egreso_facultad').focus();
						return false;}
					if ($.isNumeric(cel_num)== false){
						alert("El N\u00famero de Celular debe ser num\u00e9rico");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#cel_num').focus();
						return false;
					}
					var email = $('#email').val();
					if (email==''){
						alert("Debe ingresar el correo electr\u00f3nico");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$('#email').focus();
						return false;
					}
					var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
					if(!filter.test(email)){
						alert("El correo electr\u00f3nico no tiene el formato correcto");
						if ($(this).parents('form:first').hasClass('form1') != true){
							$('[rel=form1]').trigger('click');
						}
						$("#email").focus();
						return false;
					}
					/* El password no es obligatorio que se modifique */
					var pass = $('#pass').val();
				

					/* Postgrados */
					var num_postgrados = $('#postgrados tr.postgrado').length;
					if (num_postgrados==0){
                                            alert("Debe ingresar al menos un postgrado");
                                            if ($(this).parents('form:first').hasClass('form2') != true){
                                                $('[rel=form2]').trigger('click');
                                            }
                                            return false;
					} else if (($('#postgrados tr.postgrado:last').find('.especialidad option:selected').text()=='No tiene')
                                            && num_postgrados>1 ) {
                                            alert("El ultimo postgrado debe ser completado");
                                            if ($(this).parents('form:first').hasClass('form2') != true){
                                                $('[rel=form2]').trigger('click');
                                            }
                                            return false;
					} else {
                                            var error = '';
                                            var postgrado = new Array();
                                            var postgrados = new Array();
                                            $('#postgrados tr.postgrado').each(function(){
                                                var especialidad = $(this).find('.especialidad option:selected').val();
                                                var tipo_postgrado = $(this).find('.tipo_postgrado option:selected').val();
                                                var inicio = $(this).find('.inicio').val();
                                                var cursa = $(this).find('.cursa option:selected').val();
                                                var egresado = $(this).find('.egresado option:selected').val();
                                                var egreso = $(this).find('.egreso').val();
                                                var filter = /^[\d][\d][\d][\d]$/;
                                                if (especialidad!=1 && num_postgrados>0 ){
                                                    if (filter.test(inicio)){
                                                        if (cursa=='0' && !filter.test(egreso)){
                                                            error = 'error';
                                                        } else {
                                                            postgrado = [especialidad, tipo_postgrado, inicio, cursa, egresado, egreso];
                                                            postgrados.push(postgrado);
                                                        }
                                                    } else {
                                                        error = 'error';
                                                    }
                                                } else {
                                                    postgrado = [especialidad, tipo_postgrado, inicio, cursa, egresado, egreso];
                                                    postgrados.push(postgrado);
                                                }						
                                            });
                                            if (error=='error'){
                                                alert("Debe completar los datos del postgrado");
                                                if ($(this).parents('form:first').hasClass('form2') != true){
                                                    $('[rel=form2]').trigger('click');
                                                }
                                                return false;
                                            }
					}
					
					/* Cursos de apoyo extrahospitalario */
					var num_cursos = $('#cursos tr.curso').length;
					if (num_cursos==0){
                                            alert("Debe ingresar al menos un curso de apoyo");
                                            if ($(this).parents('form:first').hasClass('form3') != true){
                                                $('[rel=form3]').trigger('click');
                                            }
                                            return false;
                                        } else if (($('#cursos tr.curso:last').find('.nombre_curso option:selected').text()=='No tengo')
						&& num_cursos>1 ) {
						alert("El ultimo Cursos de apoyo debe ser completado");
						if ($(this).parents('form:first').hasClass('form3') != true){
							$('[rel=form3]').trigger('click');
						}
						return false;
					} else {
						var error = '';
						var curso = new Array();
						var cursos = new Array();
						$('#cursos tr.curso').each(function(){
                                                    var nombre_curso = $(this).find('.nombre_curso option:selected').val();
                                                    var extra = $(this).find('.extra').val();
                                                    var vigencia = $(this).find('.vigencia').val();

                                                    var filter = /^[\d][\d][\d][\d]$/;
                                                    var lugar = $(this).find('.lugar').val();
                                                    if(!filter.test(vigencia) && num_cursos>0 && nombre_curso!='1'){
                                                        if ($(this).parents('form:first').hasClass('form3') != true){
                                                            $('[rel=form3]').trigger('click');
                                                        }
                                                        error='vigencia'; 
                                                    } else if (nombre_curso=='1' && num_cursos>1 
                                                        || nombre_curso!='1' && (vigencia=='' || lugar=='')){
                                                            error='error';
                                                    } else {
                                                            curso = [nombre_curso, extra, vigencia, lugar];
                                                            cursos.push(curso);
                                                    }
						});
						if (error=='vigencia'){
							alert("El valor puesto en vigencia no es v\u00e1lido");
							if ($(this).parents('form:first').hasClass('form3') != true){
								$('[rel=form3]').trigger('click');
							}
							return false;
						} else if (error=='error'){
							alert("Los cursos de apoyo no estan completados");
							if ($(this).parents('form:first').hasClass('form3') != true){
								$('[rel=form3]').trigger('click');
							}
							return false;
						}
					}
					
					/* Experiencia laboral */
					var num_exp_laboral = $('#exp_laboral tr.exp_lab').length;
					if (num_exp_laboral==0){
                                            alert("Debe ingresar al menos una experiencia laboral");
                                            if ($(this).parents('form:first').hasClass('form4') != true){
                                                $('[rel=form4]').trigger('click');
                                            }
                                            return false;
					} else if (($('#exp_laboral tr.exp_lab:last').find('.empresa').val()=='Ninguna')
						&& num_exp_laboral>1){
						alert('La ultima experiencia laboral debe ser completada');
						if ($(this).parents('form:first').hasClass('form4') != true){
							$('[rel=form4]').trigger('click');
						}
						return false;
					} else {
						var exp_laboral = new Array();
						var exp_laborales = new Array();
						$('#exp_laboral tr.exp_lab').each(function(){
							var empresa = $(this).find('.empresa').val();
							var cargo = $(this).find('.cargo').val();
							var ingreso = $(this).find('.ingreso').val();
							var cese = $(this).find('.cese').val();
                                                        var filter = /^[\d][\d][\d][\d]$/;
							if (empresa!='Ninguna' && num_exp_laboral>0 && (cargo=='' || !filter.test(ingreso) || !filter.test(cese))){
								error = 'error';
							} else{
								exp_laboral = [empresa, cargo, ingreso, cese];
								exp_laborales.push(exp_laboral);
							}
						});
						if (error=='error'){
							alert("La experiencia laboral no esta correctamente completada");
							if ($(this).parents('form:first').hasClass('form4') != true){
								$('[rel=form4]').trigger('click');
							}
							return false;
						}
					}
					
					/* Otros cursos */
					var num_otros_cursos = $('#otros_cursos tr.otro_curso').length;
					if (num_otros_cursos==0){
						alert("Debe ingresar al menos algun curso complementario");
						if ($(this).parents('form:first').hasClass('form5') != true){
							$('[rel=form5]').trigger('click');
						}
						return false;
					} else if (($('#otros_cursos tr.otro_curso:last').find('.nombre_curso').val()=='No tengo')
						&& num_otros_cursos>1){
						alert('El ultimo curso debe ser completada');
						if ($(this).parents('form:first').hasClass('form5') != true){
							$('[rel=form5]').trigger('click');
						}
						return false;
					} else {
						var otro_curso = new Array();
						var otros_cursos = new Array();
						$('#otros_cursos tr.otro_curso').each(function(){
							var tipo = $(this).find('.tipo option:selected').val();
							var inicio = $(this).find('.inicio').val();
							var nombre = $(this).find('.nombre').val();
							var lugar = $(this).find('.lugar').val();
							if (tipo=='1' && num_otros_cursos>1 
							    || tipo!='1' && (inicio=='' || nombre=='' || lugar=='')){
								error = 'error';
							} else {
								otro_curso = [tipo, inicio, nombre, lugar];
								otros_cursos.push(otro_curso);
							}
						});
						if (error=='error'){
							alert("El curso no esta correctamente completada");
							if ($(this).parents('form:first').hasClass('form5') != true){
								$('[rel=form5]').trigger('click');
							}
							return false;
						}
					}
					
					/* Participacion en Congresos, Jornadas, etc */
					var num_congresos = $('#congresos tr.congreso').length;
					if (num_congresos==0){
						alert("Debe ingresar al menos un congreso");
						if ($(this).parents('form:first').hasClass('form6') != true){
							$('[rel=form6]').trigger('click');
						}
						return false;
					} else if (($('#congresos tr.congreso:last').find('.nombre').val()=='No tengo')
						&& num_congresos>1){
						alert('El ultimo congreso debe ser completado');
						if ($(this).parents('form:first').hasClass('form6') != true){
							$('[rel=form6]').trigger('click');
						}
						return false;
					} else {
						var congreso = new Array();
						var congresos = new Array();
						$('#congresos tr.congreso').each(function(){
							var nombre = $(this).find('.nombre').val();
							var tema = $(this).find('.tema').val();
							var fecha = $(this).find('.fecha').val();
                                                        var filter = /^[\d][\d][\d][\d]$/;
							var caracter = $(this).find('.caracter').val();
							if (nombre!='No tengo' && num_congresos>0 && ( tema=='' || !filter.test(fecha))){
								error = 'error';
							} else {
								congreso = [nombre, tema, fecha, caracter];
								congresos.push(congreso);
							}
						});
						if (error=='error'){
							alert("El congreso no fue correctamente completado");
							if ($(this).parents('form:first').hasClass('form6') != true){
								$('[rel=form6]').trigger('click');
							}
							return false;
						}
					}
					
					/* Idiomas */
					var num_idiomas = $('#idiomas tr.idioma').length;
					if (num_idiomas==0){
						alert("Debe ingresar al menos un idioma");
						if ($(this).parents('form:first').hasClass('form7') != true){
							$('[rel=form7]').trigger('click');
						}
						return false;
					} else if (($('#idiomas tr.idioma:last').find('.nombre_idioma').val()=='Ninguno')
						&& num_idiomas>1){
						alert('El ultimo idioma debe ser completado');
						if ($(this).parents('form:first').hasClass('form7') != true){
							$('[rel=form7]').trigger('click');
						}
						return false;
					}
					var idioma = new Array();
					var idiomas = new Array();
					$('#idiomas tr.idioma').each(function(){
						var nombre_idioma = $(this).find('.nombre_idioma').val();
                                                var extra_idioma = $(this).find('.extra').val();
						var habilidad1 = $(this).find('.habilidad1').is(':checked') ? 1 : 0;
                                                var habilidad2 = $(this).find('.habilidad2').is(':checked') ? 2 : 0;
                                                var habilidad3 = $(this).find('.habilidad3').is(':checked') ? 4 : 0;
                                                var habilidad = habilidad1 + habilidad2 + habilidad3;
						idioma = [nombre_idioma, extra_idioma, habilidad];
						idiomas.push(idioma);
					});
					
					/* Otros meritos */
					var num_meritos = $('#meritos tr.merito').length;
					if (num_meritos==0){
						alert("Debe ingresar al menos un merito");
						if ($(this).parents('form:first').hasClass('form8') != true){
							$('[rel=form8]').trigger('click');
						}
						return false;
					} else if (($('#meritos tr.merito:last').find('.merito').val()=='No tengo')
						&& num_meritos>1){
						alert('El ultimo Merito debe ser completado');
						if ($(this).parents('form:first').hasClass('form8') != true){
							$('[rel=form8]').trigger('click');
						}
						return false;
					}
					var meritos = new Array();
					$('#meritos tr.merito').each(function(){
						var merito = $(this).find('.merito').val();
						meritos.push(merito);
					});
					
					/* Referencias */
					var num_referencias = $('#referencias tr.referencia').length;
					if (num_referencias==0){
						alert("Debe ingresar al menos una referencia laboral");
						if ($(this).parents('form:first').hasClass('form9') != true){
							$('[rel=form9]').trigger('click');
						}
						return false;
					} else if (($('#referencias tr.referencia:last').find('.medico').val()=='Ninguna')
						&& num_referencias>1){
						alert('La ultima referencia laboral debe ser completada');
						if ($(this).parents('form:first').hasClass('form9') != true){
							$('[rel=form9]').trigger('click');
						}
						return false;
					} else {
						var error = '';
						var referencia = new Array();
						var referencias = new Array();
						$('#referencias tr.referencia').each(function(){
							var medico = $(this).find('.medico').val();
							var celular = $(this).find('.celular').val();
							var mail = $(this).find('.mail').val();
							var lugar_trabajo = $(this).find('.lugar_trabajo').val();
							var funcionario_semm = $(this).find('.funcionario_semm option:selected').val();
                                                        var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
                                                        if(medico!='Ninguna' && !filter.test(mail)){
                                                                error = 'mail';
                                                        } else if (medico!='Ninguna' && num_referencias>0 && (celular=='' || mail=='' || lugar_trabajo=='')){
								error = 'error';
							} else {
								referencia = [medico, celular, mail, lugar_trabajo, funcionario_semm];
								referencias.push(referencia);
							}
						});
                                                if (error=='mail'){
                                                        alert("El correo electr\u00f3nico no tiene el formato correcto");
							if ($(this).parents('form:first').hasClass('form9') != true){
								$('[rel=form9]').trigger('click');
							}
							return false;
						} else if (error=='error'){
							alert("La referencia laboral no esta correctamente completada");
							if ($(this).parents('form:first').hasClass('form9') != true){
								$('[rel=form9]').trigger('click');
							}
							return false;
						}
					}
					
					/* Imagen */
					var id_foto = $('#output').children('input:hidden').val();
					if (typeof id_foto==='undefined'){
						alert("Debe cargar una fotografia");
						if ($(this).parents('form:first').hasClass('form10') != true){
							$('[rel=form10]').trigger('click');
						}
						return false;
					}
					
					/* Los archivos adjuntos no son obligatorios as� que no necesito validar*/
					var adjunto = new Array;
					var adjuntos = new Array();
					$('#adjuntos tr.adjunto').each(function(){
						var titulo_adjunto = $(this).find('.titulo').val();
						var filename_adjunto = $(this).find('.nombre').val();
						adjunto = [titulo_adjunto, filename_adjunto];
						adjuntos.push(adjunto);
					});
					
					/* todo validado, grabar valores en la base de datos*/
					if (pass){
					var encoded_pass = $().crypt({
						method: 'md5',
						source: pass
						});
					}
					$.ajax({
						url: 'includes/update_cv.php',
						type: 'POST',
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
							pass: encoded_pass,
							postgrados: postgrados,
							cursos: cursos,
							exp_laborales: exp_laborales,
							otros_cursos: otros_cursos,
							congresos: congresos,
							idiomas: idiomas,
							meritos: meritos,
							referencias: referencias,
							id_foto: id_foto,
							adjuntos: adjuntos
						},
						success: function(response){
							$currentForm = $('#form_wrapper').children('form.active');
							$currentForm.fadeOut(400,function(){
							$currentForm.removeClass('active');
							$currentForm= $form_wrapper.children('form.form12');
							$form_wrapper.stop()
									 .animate({
										width	: $currentForm.data('width') + 'px',
										height	: $currentForm.data('height') + 'px'
									 },500,function(){
										$currentForm.addClass('active');
										$currentForm.fadeIn(400);
									 });
							});


						}
					});
				});
				
				/* Finalizar sesion */
				$('#end_session').click(function(){
					$.ajax({
							url: 'includes/end_session.php',
							type: 'POST',
							data: {

							},
							success: function(response){
								window.location = 'index.php';

							}
						});
				});
				$('#born_date').focus(function(){
					var born_date = $('#born_date').val();
					if (born_date=='dd/mm/yyyy'){
						$('#born_date').val('');
					}
				});
				
				//subida de adjuntos al servidor
				$('#adjuntos').on('change','input.file-input',function(e){
					var file = e.target.files[0];
					if ((file.type == 'image/jpeg') || (file.type == 'application/pdf')) {
						if (file.size < 4000000){
							var nombre_adjunto = $(this).parent();
							nombre_adjunto.html('<img src="includes/images/ajax-loader.gif" />');
							$.ajax ({
				                    beforeSend: function(xhr) {
               		               	xhr.setRequestHeader("X_FILENAME", file.name);
                    		    		},
                        				type: 'POST',
                        				url: 'includes/upload_file.php',
		                        		processData: false,
     		                   		data: file,
								success: function(response){
									/* var adjunto_filename = '<input type="hidden" class="filename" value="'+file.name+'" />'; 
									nombre_adjunto.html('Archivo correctamente subido'+adjunto_filename); */
									var adjunto_filename = '<input type="text" class="nombre" value="'+file.name+'" disabled="disabled" />';
									nombre_adjunto.html(adjunto_filename);
								}
     	               		});
						} else {
							alert('Solo se admiten archivos menores a 4Mb');
						}
					} else {
						alert('Solo se admiten archivos jpg o pdf');
					}
				});
			});