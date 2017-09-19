$(function() {
	var $form_wrapper	= $('#form_wrapper'),
	$currentForm	= $form_wrapper.children('form.active'),
	$linkform		= $form_wrapper.find('.linkform');
	$form_wrapper.children('form').each(function(i){
		var $theForm	= $(this);
		if(!$theForm.hasClass('active'))
			$theForm.hide();
			$theForm.data({
				width	: $theForm.width(),
				height	: $theForm.height()
			});
		});
		setWrapperWidth();
		$linkform.bind('click',function(e){
			var $link	= $(this);
			var target	= $link.attr('rel');
			$currentForm.fadeOut(400,function(){
				$currentForm.removeClass('active');
				$currentForm= $form_wrapper.children('form.'+target);
				$form_wrapper.stop().animate({
					width	: $currentForm.data('width') + 'px',
					height	: $currentForm.data('height') + 'px'
				},500,function(){
					$currentForm.addClass('active');
					$currentForm.fadeIn(400);
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
				
		$("#register").click(function(){
			var name = $('#name').val();
			if (name==''){alert("Debe ingresar el nombre");$('#name').focus();return false;}
			var last_name = $('#last_name').val();
			if (last_name==''){alert("Debe ingresar el apellido");$('#last_name').focus();return false;}
			var born_date = $('#born_date').val();
			if (born_date==''){alert("Debe ingresar la fecha");$('#born_date').focus();return false;}
/*			var filter = /^([0-3]|)[\d]\/([0-1]|)[\d]\/[\d][\d][\d][\d]$/;*/
			var filter = /^(0?[1-9]|[12][0-9]|3[01])[\/\-\.](0?[1-9]|1[012])[\/\-\.](\d{4})$/;
			if(!filter.test(born_date)){alert("La fecha debe estar en el formato \"dd/mm/aaaa\" ");$("#born_date").focus();return false;}
					
			var ci_num = $('#ci_num').val();
			if (ci_num==''){alert("Debe ingresar la c\u00e9dula");$('#ci_num').focus();return false;}
					
			var filter = /^([\d]{4,8})$/;
			if (!filter.test(ci_num)){alert("La c\u00e9dula debe ser num\u00e9rica, sin puntos ni comas");$('#ci_num').focus();return false;}
					
			var cp_num = $('#cp_num').val();
			if (cp_num==''){alert("Debe ingresar el N\u00famero de Caja Profesional");$('#cp_num').focus();return false;}
			if ($.isNumeric(cp_num)== false){alert("El N\u00famero de Caja Profesional debe ser num\u00e9rico");$('#cp_num').focus();return false;}
			var tel_num = $('#tel_num').val();
			if (tel_num==''){alert("Debe ingresar el N\u00famero de Tel\u00e9fono");$('#tel_num').focus();return false;}
			if ($.isNumeric(tel_num)== false){alert("El N\u00famero de Tel\u00e9fono debe ser num\u00e9rico");$('#tel_num').focus();return false;}
			var cel_num = $('#cel_num').val();
			if (cel_num==''){alert("Debe ingresar el N\u00famero de Celular");$('#cel_num').focus();return false;}
			if ($.isNumeric(cel_num)== false){alert("El N\u00famero de Celular debe ser num\u00e9rico");$('#cel_num').focus();return false;}
			var email = $('#email').val();
			if (email==''){alert("Debe ingresar el correo electr\u00f3nico");$('#email').focus();return false;}
			var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
			if(!filter.test(email)){alert("El correo electr\u00f3nico no tiene el formato correcto");$("#email").focus();return false;}
			var pass = $('#pass').val();
			if (pass==''){alert("Debe ingresar la Contrase\u00f1a");$('#pass').focus();return false;}
			$.ajax({
		                    url: 'includes/register.php',
          		          type: 'POST',
                    		data: {
		                        name: name,
		                        last_name: last_name,
		                        born_date: born_date,
		                        ci_num: ci_num,
		                        cp_num: cp_num,
          		              tel_num: tel_num,
						    cel_num: cel_num,
						    email: email,
						    pass:pass
	               	     },
     	               	success: function(response){
							$currentForm.removeClass('active');
							$currentForm= $form_wrapper.children('form.login');
							$currentForm.fadeOut(400,function(){
							$form_wrapper.stop()
							.animate({
								width	: $currentForm.data('width') + 'px',
								height	: $currentForm.data('height') + 'px'
							},500,function(){
								$currentForm.addClass('active');
								$currentForm.fadeIn(400);
							});
							$('#message').html(response);
						});
							
							
							
							
							
				}
			});
		});
		$('#born_date').focus(function(){
			var born_date = $('#born_date').val();
			if (born_date=='dd/mm/yyyy'){
				$('#born_date').val('');
			}
		});
	});
        
$(document).ready(function() {
    $("#activate").click(function(e){
        e.preventDefault();
        var email_activation = $('#email_activation').val();
        if (email_activation==''){
            alert("Debe ingresar el correo electr\u00f3nico");
            $('#email_activation').focus();
            return false;
        }
        var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        if(!filter.test(email_activation)){
            alert("El correo electr\u00f3nico no tiene el formato correcto");
            $("#email_activation").focus();
            return false;
        }
        $.ajax({
            url: 'includes/register.php',
            type: 'POST',
            data: {
                action: 'activate',
                email_activation: email_activation
            },
            success: function(response){
                $('#message').html(response); 
            }
        });
    });
    $("#verificar_captcha").click(function(e){
        e.preventDefault();
        var captcha_code = $("input[name=captcha_code]").val();
        if(captcha_code != '') {
            $.ajax({
                url: 'includes/securimage/verificar_captcha.php',
                type: 'POST',
                data: {
                    captcha_code: captcha_code
                },
                success: function(response){
                    if(response==='ok') {
                        $("#verificar_captcha").html('Verifición correcta');
                        $("#activate").attr("disabled", false);
                    } else {
                        $("#verificar_captcha").html('error');
                    }
                }
            });
        }
    });
    $("input[name=captcha_code]").keyup(function(){
        $("#verificar_captcha").html('Verificar');
    });
});