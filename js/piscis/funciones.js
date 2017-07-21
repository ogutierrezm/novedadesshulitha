	// Login
	$(document).ready(function(){
		
		var vFolioCotiza =  '';
		$("#btnEntraSesion").click(function(){
			var bRespuesta = validarLoginUsr();
			if (bRespuesta){
				$.post("./lock.php",
				{
					email: $("#email").val(),
					password: $("#password").val()
				},
				function(data,status){
					obj = JSON.parse(data);
					if (!obj['success']){
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});
						LimpiaLogin();
						$("#email").focus();
						
					}else{
						window.location.assign(obj['data'])
					}
					
				});
			}
			return true;
		});
	});

		function validarLoginUsr(){
			if ($("#email").val() == ''){
				$("#email").focus();
				return false;
			}else if ($("#password").val() == ''){
				$("#password").focus();
				return false;
			}else{
				return true;
			}
		}


	function LimpiaLogin(){
		$("#email").val('');
		$("#password").val('')
		$("#mensajeFail").css("display",'none');
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////7FUNCIONES NUEVAS - TENEMOS QUE EXPORTARLAS A OTRO ARCHIVO 
///////////////7///////ESPEFICO DE FUNCIONES MUY COMUNES PARA TODO EL SITIO
	/**
	* Metodo para realizar todas las peticiones AJAX
	*/
	function callAjax(parametros, urlP){
		var response = null;
		$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				//url:"./php/inventario.php",
				url: urlP,
				dataType:'json',
				data: { parametros: JSON.stringify(parametros) }
				,success: function(data){
					response = data;
				}
			});
		return response;
	}
/*
*Metodo para obtener los valores del formularios junto con sus values del formulario
*/
function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}
/**
* Funcion para mostrar mensaje de success
*/
function showMessageSuccess(titulo, contenido){
	$('.modal').modal('hide');
	$.smallBox({
		title : titulo,
		content : "<i class='fa fa-clock-o'></i> <i>"+contenido+ "</i>",
		color : "#659265",
		iconSmall : "fa fa-check fa-2x fadeInRight animated",
		timeout : 4000
	});

	reloadPage();
}

/**
* Funcion para mostrar mensaje de error
*/
function showMessageError(contenido){
	$.smallBox({
		title : "Error",
		content : "<i class='fa fa-clock-o'></i> <i>"+contenido+ "</i>",
		color : "#C46A69",
		iconSmall : "fa fa-remove fa-2x fadeInRight animated",
		timeout : 4000
	});
}
/**
* Funcion para mostrar mensaje informatico
*/
function showMessageInformativo(contenido){
	$.smallBox({
		title : "Informativo",
		content : "<i class='fa fa-clock-o'></i> <i>"+contenido+ "</i>",
		color : "#C4AB39",
		iconSmall : "glyphicon glyphicon-warning-sign fa-2x fadeInRight animated",
		timeout : 4000
	});
}
/**
* Funcion para mostrar modal para eliminar un elemento del grid
*/
function modalDeleteItem(parametros, url){
		$.SmartMessageBox({
			title : "¿Esta seguro que desea dar de baja el elemento?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada a este elemento.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				var response = callAjax(parametros, url);
				if(response.success == true){
					showMessageSuccess('Eliminado','Elemento eliminado!!');
				}else{
					showMessageError(response.error);
				}
			}
			if (ButtonPressed === "No") {
				showMessageInformativo("Se cancelo la operaci&oacute;n...");
			}
		});
}
/**
* Funcion para mostrar modal para reactivar un elemento del grid
*/
function modalActiveItem(parametros, url){
		$.SmartMessageBox({
			title : "¿Esta seguro que desea reactivar el elemento?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada a este elemento.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				var response = callAjax(parametros, url);
				if(response.success == true){
					showMessageSuccess('Reactivado','Elemento reactivado!!');
				}else{
					showMessageError(response.error);
				}
			}
			if (ButtonPressed === "No") {
				showMessageInformativo("Se cancelo la operaci&oacute;n...");
			}
		});
}
/**
* Funcion para recargar la pagina de manera automatica
*/
function reloadPage(){
  setTimeout(function(){
    window.location.reload();
  }, 2000);
}
/*
*Funcion para cerrar los modales por medio del boton cancelar del modal
*todos los modales tendran que llamarse igual o tener una misma clase
*para usar algo mas generico
*/
function closeModal(){
  $('.modal').find('input:text').val('');
  $('.modal').modal('toggle');	
}

jQuery.validator.addMethod("soloNumeros", function (value, element) {
    return this.optional(element) || /^(\d+|\d+,\d{1,2})$/.test(value);
}, "*Solo acepta numeros.");

jQuery.validator.addMethod("soloNumerosFloat", function (value, element) {
    return this.optional(element) || /^\s*(\+|-)?((\d+(\.\d+)?)|(\.\d+))\s*$/.test(value);
}, "*Solo acepta numero con decimal");


function split( val ){
	return val.split( /,s*/ );
}

function extractLast( term ) {
	return split( term ).pop();
}

 $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '<Ant',
 nextText: 'Sig>',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'yy-mm-dd',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: '',
 changeYear: true,
 changeMonth: true,
 prevText: '<i class="fa fa-chevron-left"></i>',
 nextText: '<i class="fa fa-chevron-right"></i>'
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);


//////////////////////////////////////////////////////////////////////////////////////////////////////
	//Usuario nuevo
	function CreateUsr(){
		var vFuncion = 1;
		var bRespuesta = validarCreateUsr();
		if (bRespuesta){
			$.post("./php/usuarios.php",
			{
				funcion:vFuncion,
				usuario: $("#usuario").val(),
				puesto: $("#empleados").val(),
				nombre: $("#nombre").val(),
				apellido: $("#apellido").val(),
				password: $("#password").val(),
				confirmarcontrasena: $("#confirmarcontrasena").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					setTimeout(function(){
						window.location.reload();
					}, 2000);
				}else{
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
					LimpiaInsertUsr();
				}
			});
		}
		return true;
	}
	
	function LimpiaInsertUsr(){
		$("#usuario").val('');
		$("#empleados").val(0);
		$("#nombre").val('');
		$("#apellido").val('');
		$("#password").val('');
		$("#confirmarcontrasena").val('');
		$("#MsgExitoUsr").css("display",'none');
		$("#MsgFallaUsr").css("display",'none');
	}
	
	function validarCreateUsr(){
		if ($("#usuario").val() == ''){
			$("#usuario").focus();
			return false;
		}else if ($("#empleados").val() == 0){
			$("#empleados").focus();
			return false;
		}else if ($("#nombre").val() == ''){
			$("#nombre").focus();
			return false;
		}else if ($("#apellido").val() == ''){
			$("#apellido").focus();
			return false;
		}else if ($("#password").val() == ''){
			$("#password").focus();
			return false;
		}else if ($("#confirmarcontrasena").val() == ''){
			$("#confirmarcontrasena").focus();
			return false;
		}else if ($("#confirmarcontrasena").val() !== $("#password").val()){
			$("#confirmarcontrasena").focus();
			return false;
		}else{
			return true;
		}
	}
	
	// Registro de zonas nuevas
	function CreateNvaZona(){
	
		var bRespuesta = validarNvaZona();
		var vFuncion = 1;
		if (bRespuesta){
			$.post("./php/zonas.php",
			{
				funcion: vFuncion,
				nombrezona: $("#nombre").val(),
				desczona: $("#descripcion").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					setTimeout(function(){
						window.location.reload();
					}, 2000);
					$("#nombre").focus();
					
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});					
					$("#nombre").focus();
				}
			});
		}
		return true;
	}
	
	function validarNvaZona(){
		if ($("#nombre").val() == ''){
			$("#nombre").focus();
			return false;
		}else if ($("#descripcion").val() == ''){
			$("#descripcion").focus();
			return false;
		}else{
			return true;
		}
	}
	
	function LimpiaNvaZona(){
		$("#nombre").val('');
		$("#descripcion").val('')
		$("#MsgFallaUsr").css("display",'none');
		$("#MsgExitoUsr").css("display",'none');
		return true;
	}
	
	// Consultar calles
	function blurConsultarCalleSepomex(){
		var vFuncion = 2;
		$.post("./php/zonas.php",
		{
			funcion: vFuncion,
			CodigoPostal: parseInt(($("#CodigoPostal").val()).replace("XXXXX",""))?parseInt(($("#CodigoPostal").val()).replace("XXXXX","")):0,
			Colonia: ""
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$("#Colonia option").remove();
				$("#Colonia").append(obj['data']);
				$("#Colonia").focus();
			}else{
				$("#Colonia").focus();
			}
		});
		return true;
	}
	
	
	// Consultar calles
	function ConsultarCalleSepomex(){
		var bRespuesta = validarCalleSepomex();
		var keycode = 0;
		try {
			keycode = (event.keyCode ? event.keyCode : event.which);
		}catch(err){
			keycode = 0;
		}
		
		if((keycode == 0||keycode == '13') && (parseInt(($("#CodigoPostal").val()).replace("XXXXX",""))?parseInt(($("#CodigoPostal").val()).replace("XXXXX","")):0) >= 4){
			var vFuncion = 2;
			if (bRespuesta){
				$.post("./php/zonas.php",
				{
					funcion: vFuncion,
					CodigoPostal: parseInt(($("#CodigoPostal").val()).replace("XXXXX",""))?parseInt(($("#CodigoPostal").val()).replace("XXXXX","")):0,
					Colonia: ""
				},
				function(data,status){
					obj = JSON.parse(data);
					if (obj['success'] == true){
						$("#Colonia option").remove();
						$("#Colonia").append(obj['data']);
						$("#Colonia").focus();
					}else{
						$("#Colonia").focus();
					}
				});
			}
			keyCode = 0;
			return true;
		}else{
			return false;
		}
	}
	
	function validarCalleSepomex(){
		if ($("#CodigoPostal").val() == ''){
			$("#CodigoPostal").focus();
			return false;
		}else if ($("#Colonia").val() == ''){
			$("#Colonia").focus();
			return false;
		}else{
			return true;
		}
	}
	
	
	// Agregar articulo a inventario.
	function AgregarInventario(){
	
		var bRespuesta = validarInventarioNuevo();
		
		var vFuncion = 2;
		if (bRespuesta){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/inventario.php",
				data: {
						funcion: vFuncion,
						horas:$("#horas").val(),
						st3:($("#st3").val()== 0)? 0:1,
						precio:$("#precio").val(),
						cantidad:$("#spinner-currency").val(),
						articulo:$("#articulo").val()
						},
				success: function(data){
					obj = JSON.parse(data);
					if (obj['success'] == true){
						//Exito
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						grabarGrupoInventario();
						
						setTimeout(function(){
							window.location.reload();
						}, 2000);
					}else{
						//Falla
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});
						$("#articulo").focus();
					}
				}
			});
		}
		return true;
	}
		
	function validarInventarioNuevo(){
		if ($("#articulo").val() == ''){
			$("#articulo").focus();
			return false;
		}else if ($("#spinner-currency").val() == '' || $("#spinner-currency").val() <= 0){
			$("#spinner-currency").focus();
			return false;
		}else if ($("#precio").val() == '' || $("#precio").val() <= 0){
			$("#precio").focus();
			return false;
		}else if ($("#st3").val() == ''){
			$("#st3").focus();
			return false;
		}else if ($("#horas").val() == '' || $("#horas").val() == ''){
			$("#horas").focus();
			return false;
		}else{
			return true;
		}
	}
		
	function LimpiarInventarioNuevo(){
		$("#articulo").val('');
		$("#spinner-currency").val(0);
		$("#precio").val('');
		$("#st3").val(0);
		$("#horas").val(0);
		$("#MsgFallaUsr").css("display",'none');
		$("#MsgExitoUsr").css("display",'none');
		return true;
	}
	
	// Agregar articulo a inventario.
	function ActualizarInventario(){
		var bRespuesta = validarInventarioActualizar();
		var vFuncion = 3;
		if (bRespuesta){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/inventario.php",
				data: {
						funcion: vFuncion,
						horas:$("#horasModal").val(),
						st3:($("#st3Modal").val()== 0)? 0:1,
						precio:$("#precioModal").val(),
						cantidad:$("#spinner-currencyModal").val(),
						articulo:$("#articuloModal").val(),
						sku:$("#skuModal").val()
						},
				success: function(data){
					obj = JSON.parse(data);
					if (obj['success'] == true){
						//Exito
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						grabarGrupoInventarioModal();
						
						setTimeout(function(){
							window.location.reload();
						}, 2000);
					}else{
						//Falla
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});
						$("#articuloModal").focus();
					}
				}
			});
		}
		
		return true;
	}
	
	function validarInventarioActualizar(){
		if ($("#skuModal").val() == ''){
			$("#skuModal").focus();
			return false;
		}else if ($("#articuloModal").val() == ''){
			$("#articuloModal").focus();
			return false;
		}else if ($("#spinner-currencyModal").val() == '' || $("#spinner-currencyModal").val() < 0 ){
			$("#spinner-currencyModal").focus();
			return false;
		}else if ($("#precioModal").val() == '' || $("#precioModal").val() <= 0){
			$("#precioModal").focus();
			return false;
		}else if ($("#st3Modal").val() == ''){
			$("#st3Modal").focus();
			return false;
		}else if ($("#horasModal").val() == '' || $("#horasModal").val() == ''){
			$("#horasModal").focus();
			return false;
		}else{
			return true;
		}
	}
	
	function cambioEspecialArticulo(){
		if ($("#st3").val() == 0){
			$("#horas").val(0);
			$("#st3").val(1);
			$("#dvHorasArticuloEspecial").css("display",'block');
		}else{
			$("#horas").val(0);
			$("#st3").val(0);
			$("#dvHorasArticuloEspecial").css("display",'none');
		}
	}
	
	function cambioEspecialModalArticulo(){
		if ($("#st3Modal").val() == 0){
			$("#horasModal").val(0);
			$("#st3Modal").val(1);
			$("#dvHorasArticuloEspecialModal").css("display",'block');
		}else{
			$("#horasModal").val(0);
			$("#st3Modal").val(0);
			$("#dvHorasArticuloEspecialModal").css("display",'none');
		}
	}

	// Consultar calles
	function obtenerSKU(){
		
		var vFuncion = 1;
		$.post("./php/inventario.php",
		{
			funcion: vFuncion
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$("#sku").val(obj['data']['retorno']);
			}
		});
		}
		
	// Consultar colonias
	function ConsultarColonias(){
		var vNumColonia = $("#Colonia").val().split(' - ');
		var bRespuesta = validarConsultarColonias(vNumColonia);
		
		var vFuncion = 3;
		if (bRespuesta){
			$.post("./php/zonas.php",
			{
				funcion: vFuncion,
				CodigoPostal:($("#CodigoPostal").val()=='')?0:$("#CodigoPostal").val(),
				Colonia:parseInt(vNumColonia[0])
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					var objeto = obj['data'];
					$("#CodigoPostal").val(objeto['d_codigo']);
					$("#municipio").val(objeto['d_mnpio']);
				}else{
					$("#CodigoPostal").val('');
					$("#municipio").val('');
				}
			});
		}
		
		return true;
	}
	
	//limpia la caja de texto de cp y municipio.
	function limpiaDatosCpMnipio(){
		$("#CodigoPostal").val('');
		$("#municipio").val('');
		return true;
	}
	
	function validarConsultarColonias(vNumColonia){
		if(vNumColonia.length <=0){
			limpiaDatosCpMnipio();
			return false;
		}else{
			return true;
		}
	}
	
	function grabarRegionColonia(){
		var vNumColonia = $("#Colonia").val().split(' - ');
		var bRespuesta = validarConsultarColonias2(vNumColonia);
		
		var vFuncion = 4;
		if (bRespuesta){
			$.post("./php/zonas.php",
			{
				funcion: vFuncion,
				iKeyxDir:parseInt(vNumColonia[0]),
				iRegion:($("#SelectZona").val()=='')?0:$("#SelectZona").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					setTimeout(function(){
						window.location.reload();
					}, 2000);
					$("#CodigoPostal").focus();
					
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
					setTimeout(function(){
						window.location.reload();
					}, 2000);
					$("#CodigoPostal").focus();
				}
			});
		}
		
		return true;
	}
	
		
	function validarConsultarColonias2(vNumColonia){
		if(vNumColonia.length < 2){
			limpiaDatosCpMnipio();
			return false;
		}if ($("#CodigoPostal").val() == '' && $("#Colonia").val() == ''){
			limpiaDatosCpMnipio();
			return false;
		}else{
			return true;
		}
	}
	
	function LimpiarRegistroZona(){
		$("#Colonia").val('');
		$("#SelectZona").val(0);
		$("#CodigoPostal").val('');
		$("#municipio").val('');
		$("#MsgFallaUsr").css("display",'none');
		$("#MsgExitoUsr").css("display",'none');
		return true;
	}
	
	function eliminarUsuario(vNombre){
		var vFuncion = 2;
		var vNom = vNombre.replace('eliminar_','');
		
		$.post("./php/usuarios.php",
		{
			funcion: vFuncion,
			puesto:(vNom =='')?0:vNom
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){
					window.location.reload();
				}, 2000);
			}else{
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
		return true;
	}
	
	//Aviso de confirmacion para eliminar un usuario
	function MensajeSmartUsuarios(vName,vOperacion) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada a este usuario.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				if(vOperacion == 2){
					eliminarUsuario(vName);
				}else if(vOperacion == 4){
					ActualizarUsr();
				}
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}

		});
		return true;
	}

	function MensajeSmartModPedidos(vFolio,vOperacion) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada a este pedido.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				
				if(vOperacion == 2){
					CancelarPedido(vFolio);
				}
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}

		});
		return true;
	}
	
	//Baja de pedido
	function CancelarPedido(vFolio){
		var vFuncion = 11;
		
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			foliopedido:((parseInt(vFolio) >0)?vFolio:0)
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){
					//window.location.href = sUrlRedirected;
					window.location.reload();
				}, 2000);
				
				
			}else{
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
		return true;
	}
	
	
	function consultarUsuarios(){
		var vFuncion = 3;
		
		$.post("./php/usuarios.php",
		{
			funcion: vFuncion
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$("#tbodyUsuarios").html('');
				$("#tbodyUsuarios").append(obj['data']);
			}
		});
		return true;
	}
	
	function consultarUsuariosId(vKeyx){
		var vFuncion = 5;
		
		$.post("./php/usuarios.php",
		{
			funcion: vFuncion,
			keyx:vKeyx
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$("#tbodyUsuarios").html('');
				$("#tbodyUsuarios").append(obj['data']);
			}
		});
		return true;
	}
	
	//Usuario actualizar
	function ActualizarUsr(){
		var vFuncion = 4;
		var bRespuesta = validarActualizarUsr();
		if (bRespuesta){
			$.post("./php/usuarios.php",
			{
				funcion:vFuncion,
				usuario: $("#mdlUsuario").val(),
				keyx: vId_puesto,
				puesto: $("#mdlEmpleados").val(),
				nombre: $("#mdlNombre").val().trim(),
				password: $("#mdlPassword").val(),
				confirmarcontrasena: $("#mdlPasswordConf").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					setTimeout(function(){
						window.location.reload();
					}, 2000);
				}else{
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			});
		}
		return true;
	}
	
	function validarActualizarUsr(){
		if ($("#mdlUsuario").val() == ''){
			$("#mdlUsuario").focus();
			return false;
		}else if ($("#mdlEmpleados").val() == 0){
			$("#mdlEmpleados").focus();
			return false;
		}else if ($("#mdlNombre").val() == ''){
			$("#mdlNombre").focus();
			return false;
		}else if ($("#mdlPassword").val() == ''){
			$("#mdlPassword").focus();
			return false;
		}else if ($("#mdlPasswordConf").val() == ''){
			$("#mdlPasswordConf").focus();
			return false;
		}else if ($("#mdlPasswordConf").val() !== $("#mdlPassword").val()){
			$("#mdlPasswordConf").focus();
			return false;
		}else{
			return true;
		}
	}
	
	function LimpiaActualizarUsr(){
		$("#mdlUsuario").val('');
		$("#mdlEmpleados").val(0);
		$("#mdlNombre").val('');
	}
	
	//Validar Telefono keyx
	function ConsultarCteKeyx(){
		var vFuncion = 12;
		if ($("#numcliente").val()> 0){
			$.post("./php/cliente.php",
			{
				funcion:vFuncion,
				clientekeyx: $("#numcliente").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						$('#clientekeyx').val(obj['data']['keyx']);
						$('#numcliente').val(obj['data']['keyx']);
						$('#telefonocasa').val(obj['data']['telcasa']);
						$('#telefonocelular').val(obj['data']['telcelular']);
						$('#nombre').val(obj['data']['nombres']);
						$('#apellido').val(obj['data']['apellidos']);
						ConsultarUltimosPedidosCte(obj['data']['keyx']);
						$("#nombre").focus();
					}else{
						$("#telefonocasa").focus()
					}
				}
			});
		}
		return true;
	}
	
	function ConsultarTelefonos(){
		var bRespuesta = ValidarTelefonosCliente();
		if ($("#telefonocelular").val() != ''){
			ConsultarTelefonoCelularCte();
		}else if($("#telefonocasa").val() != ''){
			ConsultarTelefonoCasaCte();
		}else{
		}
		
		return true;
	}
	
	//Validar Telefono celular del cliente
	function ConsultarTelefonoCelularCte(){
		var vFuncion = 1;
		var vTelefono =  QuitarMascara($("#telefonocelular").val());
		var bRespuesta = ValidarTelefonosCliente();
		if (bRespuesta){
			$.post("./php/cliente.php",
			{
				funcion:vFuncion,
				telefonocelular: vTelefono
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						$('#clientekeyx').val(obj['data']['keyx']);
						$('#numcliente').val(obj['data']['keyx']);
						if($('#telefonocasa').val() == ''){
							$('#telefonocasa').val(obj['data']['telcasa']);
						}
						$('#nombre').val(obj['data']['nombres']);
						$('#apellido').val(obj['data']['apellidos']);
						ConsultarUltimosPedidosCte(obj['data']['keyx']);
						$("#nombre").focus();
					}else{
						$("#telefonocasa").focus()
					}
				}
			});
		}
		return true;
	}
	
	//Validar Telefono fijo / casa del cliente
	function ConsultarTelefonoCasaCte(){
		var vFuncion = 2;
		var vTelefono =  QuitarMascara($("#telefonocasa").val());
		var bRespuesta = ValidarTelefonosCliente();
		if (bRespuesta){
			$.post("./php/cliente.php",
			{
				funcion:vFuncion,
				telefonocasa: vTelefono
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						$('#clientekeyx').val(obj['data']['keyx']);
						$('#numcliente').val(obj['data']['keyx']);
						if ($('#telefonocelular').val()){
							$('#telefonocelular').val(obj['data']['telcelular']);
						}
						$('#nombre').val(obj['data']['nombres']);
						$('#apellido').val(obj['data']['apellidos']);
						ConsultarUltimosPedidosCte(obj['data']['keyx']);
						$("#nombre").focus();
					}else{
						$("#telefonocasa").focus()
					}
				}
			});
		}
		return true;
	}
	
	function ValidarTelefonosCliente(){
		var keycode = 0;
		try {
			keycode = (event.keyCode ? event.keyCode : event.which);
		}catch(err){
			keycode = 0;
		}
		
		if((keycode == 0||keycode == '13') && ($("#telefonocelular").val().length >= 7||$("#telefonocasa").val().length >= 7)){
			return true;
		}else{
			return false;
		}
	}
	
	function QuitarMascara(vPhone){
		vPhone = vPhone.replace(/[^0-9\.]/g,'');
		return vPhone;
	}
	
	
	//Validar Telefono celular del cliente
	function ConsultarUltimosPedidosCte(vCte){
		domicilioSet = 0;
		domiciliosCliente = '';
		var vFuncion = 3;
		if (vCte > 0){
			$.post("./php/cliente.php",
			{
				funcion:vFuncion,
				cliente: vCte
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						if (obj['data'].length > 1){
							$("#secTengoMasDomicilios").css("display","block");
							domiciliosCliente = obj['data'];
						}
						$("#calle").val(obj['data'][0]['calle']);
						$("#numext").val(obj['data'][0]['numexterior']);
						$("#numint").val(obj['data'][0]['numinterior']);
						$("#CodigoPostal").val(obj['data'][0]['codigopostal']);
						$("#Colonia").val(obj['data'][0]['colonia']);
						$("#municipio").val(obj['data'][0]['ciudad']);
						$("#referencias").val(obj['data'][0]['observaciones']);
						domicilioSet = 0;
					}else{
						$("#secTengoMasDomicilios").css("display","none");
						$("#telefonocasa").focus()
					}
				}
			});
		}
		return true;
	}
	
	//
	function cambiarDomicilio(){
		if (domicilioSet == domiciliosCliente.length-1){
			domicilioSet = -1;
		}
		domicilioSet++;
		
		if (domiciliosCliente.length >= domicilioSet){
			$("#calle").val(domiciliosCliente[domicilioSet]['calle']);
			$("#numext").val(domiciliosCliente[domicilioSet]['numexterior']);
			$("#numint").val(domiciliosCliente[domicilioSet]['numinterior']);
			$("#CodigoPostal").val(domiciliosCliente[domicilioSet]['codigopostal']);
			$("#Colonia").val(domiciliosCliente[domicilioSet]['colonia']);
			$("#municipio").val(domiciliosCliente[domicilioSet]['ciudad']);
			$("#referencias").val(domiciliosCliente[domicilioSet]['observaciones']);
		}
		
		return true;
	}
	
	function CalcularSaldoPedido(){
		var vTotal = 0;
		var vPrecio = 0;
		var vCantidad = 0;
		var vDescuento = 0;
		var vMontoDescuento = parseFloat($("#idDescuento").val());
		var  vConsecutivo = $("#consecutivo").val();
		for (var i = 1; i <= vConsecutivo ; i++) {
			vPrecio = ($('#precio_'+i).val() != null)? $('#precio_'+i).val():0;
			if((parseInt($('#cantidad_'+i).val()) > parseInt($('#hidcantidad_'+i).val()))&& parseInt($('#hidespecial_'+i).val()) !== 1){
				$('#cantidad_'+i).val($('#hidcantidad_'+i).val());
			/*}else if (parseInt($('#hidespecial_'+vConsecutivo).val()) == 1){
				$('#notaEspecial_'+vConsecutivo).css("disabled",'false');
				$('#notaEspecial_'+vConsecutivo).css("readonly",'false');
				if(parseInt($('#cantidad_'+vConsecutivo).val()) > parseInt($('#hidcantidad_'+vConsecutivo).val())){
					$('#cantidad_'+vConsecutivo).val(1);
				}*/
			}
			vCantidad = ($('#cantidad_'+i).val() != null)? parseInt($('#cantidad_'+i).val()):1;	
			vPrecio = isNaN(vPrecio) ? 0:vPrecio;
			vCantidad = isNaN(vCantidad) ? 0:vCantidad;
			vTotal = parseInt((vTotal+(vPrecio * vCantidad)));
		}
		
		$('#subtotal').html(vTotal);
		//if ($('#idTipoPago').val() == 1 ){
		var vDineroDescuento = vTotal * vMontoDescuento;
		var vTotalDisplay = vTotal - (vDineroDescuento.toFixed(2)) ;
		$('#Descto').html(vDineroDescuento.toFixed(2));
		$('#total').html(vTotalDisplay.toFixed(2));
		/*}else{
			$('#Descto').html(0);
			$('#total').html(vTotal);
		}*/
		return true;
	}
	
	function ReCalcularSaldoPedido(vConsecutivo){
		var vTotal = 0;
		var vPrecio = 0;
		var vCantidad = 0;
		vPrecio = ($('#precio_'+vConsecutivo).val() != null)? $('#precio_'+vConsecutivo).val():0;
		if((parseInt($('#cantidad_'+vConsecutivo).val()) > parseInt($('#hidcantidad_'+vConsecutivo).val()))&& parseInt($('#hidespecial_'+vConsecutivo).val()) !== 1){
			$('#cantidad_'+vConsecutivo).val($('#hidcantidad_'+vConsecutivo).val());
		//}else if (parseInt($('#hidespecial_'+vConsecutivo).val()) == 1){
			//$('#notaEspecial_'+vConsecutivo).css("disabled",'false');
			//$('#notaEspecial_'+vConsecutivo).css("readonly",'false');
			if(parseInt($('#cantidad_'+vConsecutivo).val()) > parseInt($('#hidcantidad_'+vConsecutivo).val())){
				$('#cantidad_'+vConsecutivo).val(1);
			}
		}
		vCantidad = ($('#cantidad_'+vConsecutivo).val() != null)? $('#cantidad_'+vConsecutivo).val():0;
		
		//vFlete = ($('#idcargoFlete').val() != null)? parseInt($('#idcargoFlete').val()):0;
		vTotal = parseInt((vTotal+(vPrecio * vCantidad)));
		$('#subtotal_'+vConsecutivo).val(vTotal);

		CalcularSaldoPedido();
		
		return true;
	}
	
	//Consultar los articulos
	function consultarArticuloElegidoModifica(vKeyx,vConsecutivo){
		var vFuncion = 1;
		if (vKeyx > 0){
			$.post("./php/articulos.php",
			{
				funcion:vFuncion,
				keyx: vKeyx,
				fechaentrega: $("#fechaentrega").val(),
				foliopedido: $("#folio").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						$('#precio_'+vConsecutivo).val(obj['data']['precio']);
						$('#cantidad_'+vConsecutivo).val(1);
						var vFlag_especial = obj['data']['flag_especial'];
						$('#hidespecial_'+vConsecutivo).val(vFlag_especial);
						var hdEspecial = document.getElementById("hidespecial_"+vConsecutivo)
						$('#hidcantidad_'+vConsecutivo).val(obj['data']['cantidad']);
						if((parseInt($('#cantidad_'+vConsecutivo).val()) > hdEspecial.value)&& (hdEspecial !== 1)){
							$('#cantidad_'+vConsecutivo).val(1);
							$("#notaEspecial_"+vConsecutivo).attr('disabled','disabled');
							$("#notaEspecial_"+vConsecutivo).attr('readonly','true');
							$("#notaEspecial_"+vConsecutivo).val('');
						}
						if (parseInt($('#hidespecial_'+vConsecutivo).val()) == 1){
							$("#notaEspecial_"+vConsecutivo).removeAttr("disabled");
							$("#notaEspecial_"+vConsecutivo).removeAttr("readonly");
							if(parseInt($('#cantidad_'+vConsecutivo).val()) > parseInt($('#hidcantidad_'+vConsecutivo).val())){
								$('#cantidad_'+vConsecutivo).val(1);
								ConsultarArticuloHorariosEspecial(vKeyx);
							}
						}
						var subtotal = $('#cantidad_'+vConsecutivo).val() * $('#precio_'+vConsecutivo).val();
						$('#subtotal_'+vConsecutivo).val(subtotal);
						$('#cantidad_'+vConsecutivo).focus();
						CalcularSaldoPedidoModifica();
					}
				}
			});
		}
		return true;
	}
	
	
	function CalcularSaldoPedidoModifica(){
		var vTotal = 0;
		var vSubtotal = 0;
		var vPrecio = 0;
		var vCantidad = 0;
		var vTodo = 0;
		var vMontoDescuento = 0;
		var vMontoGarantia = 0;
		var  vConsecutivo = $("#consecutivo").val();
		for (var i = 1; i <= vConsecutivo ; i++) {
			vPrecio = ($('#precio_'+i).val() != null)? $('#precio_'+i).val():0;
			if((parseInt($('#cantidad_'+i).val()) > parseInt($('#hidcantidad_'+i).val()))&& parseInt($('#hidespecial_'+i).val()) !== 1){
				$('#cantidad_'+i).val($('#hidcantidad_'+i).val());
			}else if (parseInt($('#hidespecial_'+vConsecutivo).val()) == 1){
				$('#notaEspecial_'+vConsecutivo).css("disabled",'false');
				$('#notaEspecial_'+vConsecutivo).css("readonly",'false');
				if(parseInt($('#cantidad_'+vConsecutivo).val()) > parseInt($('#hidcantidad_'+vConsecutivo).val())){
					$('#cantidad_'+vConsecutivo).val(1);
				}
			}
			vCantidad = ($('#cantidad_'+i).val() != null)? parseInt($('#cantidad_'+i).val()):0;
			vPrecio = isNaN(vPrecio) ? 0:vPrecio;
			vCantidad = isNaN(vCantidad) ? 0:vCantidad;
			vTotal = parseInt((vTotal+(vPrecio * vCantidad)));
		}
		vTotal = (vTotal > 0 ? parseInt(vTotal):0);
		vTotalgral = parseInt(vTotal);
		$("#subtotal").html(vTotal); 
		
		return true;
	}
	
	function ReCalcularSaldoPedidoModifica(vConsecutivo){
		var vTotal = 0;
		var vPrecio = 0;
		var vCantidad = 0;
		vPrecio = ($('#precio_'+vConsecutivo).val() != null)? $('#precio_'+vConsecutivo).val():0;
		if((parseInt($('#cantidad_'+vConsecutivo).val()) > parseInt($('#hidcantidad_'+vConsecutivo).val()))&& parseInt($('#hidespecial_'+vConsecutivo).val()) !== 1){
			$('#cantidad_'+vConsecutivo).val($('#hidcantidad_'+vConsecutivo).val());
		}else if (parseInt($('#hidespecial_'+vConsecutivo).val()) == 1){
			$('#notaEspecial_'+vConsecutivo).css("disabled",'false');
			$('#notaEspecial_'+vConsecutivo).css("readonly",'false');
			if(parseInt($('#cantidad_'+vConsecutivo).val()) > parseInt($('#hidcantidad_'+vConsecutivo).val())){
				$('#cantidad_'+vConsecutivo).val(1);
			}
		}
		vCantidad = ($('#cantidad_'+vConsecutivo).val() != null)? $('#cantidad_'+vConsecutivo).val():0;
		
		vFlete = ($('#idcargoFlete').val() != null)? parseInt($('#idcargoFlete').val()):0;
		vTotal = parseInt((vTotal+(vPrecio * vCantidad)));
		$('#subtotal_'+vConsecutivo).val(vTotal);

		CalcularSaldoPedidoModifica();
		
		return true;
	}
	
	//Registrar clientes nuevos
	function pedidoGrabarCliente(){
		var vFuncion = 4;
		var ctekeyx = 0;
		var bRespuesta = validarCteNuevo();
		if (bRespuesta > 0){
			$.post("./php/cliente.php",
			{
				funcion:vFuncion,
				telefonocelular: QuitarMascara($('#telefonocelular').val()),
				telefonocasa: QuitarMascara($('#telefonocasa').val()),
				nombre: $('#nombre').val(),
				apellido: $('#apellido').val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						$('#clientekeyx').val(obj['data']['retorno']);
						$('#numcliente').val(obj['data']['retorno']);
						ctekeyx =obj['data']['retorno'];
						//Exito
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						pedidoGrabarDomicilio();
					}
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			});
		}else{
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i> Fall&oacute al registrar al cliente!. </i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
		}
		return true;
	}
	
	//Registrar clientes nuevos
	function modificarGrabarCliente(){
		var vFuncion = 4;
		var ctekeyx = 0;
		var bRespuesta = validarCteNuevo();
		if (bRespuesta > 0){
			$.post("./php/cliente.php",
			{
				funcion:vFuncion,
				telefonocelular: QuitarMascara($('#telefonocelular').val()),
				telefonocasa: QuitarMascara($('#telefonocasa').val()),
				nombre: $('#nombre').val(),
				apellido: $('#apellido').val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						$('#clientekeyx').val(obj['data']['retorno']);
						ctekeyx =obj['data']['retorno'];
						//Exito
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						modificarGrabarDomicilio();
					}
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			});
		}else{
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i> Fall&oacute al registrar al cliente!. </i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
		}
		return true;
	}
	
	//Registrar domicilios a pedidos modificados
	function modificarGrabarDomicilio(){
		var vFuncion = 5;
		var direckeyx = 0;
		
		var vCodigoPos = parseInt(($("#CodigoPostal").val()).replace("XXXXX",""))?parseInt(($("#CodigoPostal").val()).replace("XXXXX","")):0;
		var vMunicipio = $("#municipio").val();
		if (vCodigoPos == 0){
			vCodigoPos = 99999;
			$("#CodigoPostal").val(vCodigoPos);
		}
		if (vMunicipio == ''){
			vMunicipio = 'NO ASIGNADO';
			$("#municipio").val(vMunicipio);
		}
		if ($('#check_ColoniaNueva').val() == 0 && $("#Colonia").val().split("-").length == 1){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>La colonia que intenta registrar es nueva, debe de seleccionar una del listado</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}
		var vColonia = $("#Colonia").val();
		if($("#Colonia").val().split("-").length == 1){
			vColonia = 0 + ' - ' + $("#Colonia").val() + ' - ' + vMunicipio;
		}
		
		var bRespuesta = validarDomicilioNuevo();
		if (bRespuesta > 0){
			$.post("./php/cliente.php",
			{
				funcion:vFuncion,
				calle:$("#calle").val(),
				numext:$("#numext").val(),
				numint:$("#numint").val(),
				CodigoPostal:vCodigoPos,
				Colonia:vColonia,
				municipio:vMunicipio,
				referencias:$("#referencias").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						direckeyx = obj['data']['retorno'];
						$('#direccionkeyx').val( obj['data']['retorno']);
						//Exito
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						modificarpedidoGrabarDetalle();
						
					}
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});				
				}
			});
		}else{
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i> Fall&oacute al registrar el domicilio!. </i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
		}
		return true;
	}
	
	function modificarpedidoGrabarDetalle(){
		var vFuncion = 10;
		var vFolioPedido = $("#folio").val();
		var bRespuesta = validarPedidoNuevo();
		if (bRespuesta){
			$.post("./php/cliente.php",
			{
				funcion:vFuncion,
				foliopedido: vFolioPedido
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						var vArticulo = 0;
						var vCantidad = 0;
						var vConsecutivo = $("#consecutivo").val();
						var vFolioPedido = $("#folio").val();
						var vHorarioRenta = '';
						for (var i = 1; i <= vConsecutivo ; i++) {
							vArticulo = ($('#cmbarticulos_'+i).val() > 0)?$('#cmbarticulos_'+i).val():0;
							vCantidad = (parseInt($('#cantidad_'+i).val()) > 0)?parseInt($('#cantidad_'+i).val()):0;
							if (parseInt($('#hidespecial_'+i).val()) == 1){
								vHorarioRenta = ($('#notaEspecial_'+i).val() != '')?$('#notaEspecial_'+i).val():'';
							}else{
								vHorarioRenta = '';
							}
							pedidoGrabarArticuloDePedidoModificado(vArticulo,vCantidad,vHorarioRenta);
						}
						var ctekeyx = $("#clientekeyx").val();
						var direckeyx = $("#direccionkeyx").val();
						var bRespuesta = modifcarpedidoGrabarPedido(ctekeyx,direckeyx);
					}else{
						//Falla
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});					
					}
				}
			});
		}
		return true;
	}	

	
	//Registrar pedido modificado
	function modifcarpedidoGrabarPedido(vCtekeyx,vDireckeyx){
		var vMostrarNota = true;
		var vFuncion = 9;
		var vFolioPedido = $("#folio").val();
		var vEmpleado = $("#empleado option:selected").html();
		if ($("#empleado").val() == 0){
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Se requiere seleccionar un empleado a ligarlo a este pedido. </i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			$("#empleado").focus();
			return false;
		}
		
		var bRespuesta = validarPedidoNuevo();
		if (bRespuesta){
			$.post("./php/cliente.php",
			{
				funcion:vFuncion,
				foliopedido: vFolioPedido,
				fechaentrega: $("#fechaentrega").val(),
				fecharecolecta: $("#fecharecolectar").val(),
				hora1: $("#hora1").val(),
				hora2: $("#hora2").val(),
				flag_especial:  $("#check_recoger").val(),
				clientekeyx:  vCtekeyx,
				direccionkeyx:  vDireckeyx,
				empleado:$("#empleado").val(),
				mantel:$("#idManteleria").val(),
				flete:$("#idcargoFlete").val(),
				iva:$("#check_IVA").val(),
				flag_descuento:$("#check_Descto").val(),
				porcentajedescuento:$("#PorcentajeDescuento").val(),
				garantia:$("#importe_garantia").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						$("#btnGrabarPedido").attr("disabled","disabled");
						//Exito
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						var vFolioPedido = parseInt($("#folio").val());
						enviarMail(vFolioPedido);
						if ($("#importe_totalmodal").val() > 0){
							AbonarPedido(1,vFolioPedido,1,vMostrarNota,vEmpleado);
						}
						recordatorioEnvioMercancia($("#fechaentrega").val());
					}
				}else{
					$("#btnGrabarPedido").removeAttr("disabled");
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});					
				}
			});
		}else{
			$("#btnGrabarPedido").removeAttr("disabled");
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i> Fall&oacute al registrar el pedido!. </i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
		}
		return true;
	}
	
	//Registrar articulo nuevos a pedido
	function pedidoGrabarArticuloDePedidoModificado(vId_articulo,vCantidad,vHorarioRenta){
		var vFuncion = 6;
		var vFolioPedido = $("#folio").val();
		var bRespuesta = validarArticuloDePedidoNuevo(vFolioPedido,vId_articulo,vCantidad,vHorarioRenta);
		if (bRespuesta){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/cliente.php",
				data: {funcion:vFuncion,
					foliopedido: vFolioPedido,
					id_articulo: vId_articulo,
					cantidad: vCantidad,
					horariorenta: vHorarioRenta,
					num_descuento:$("#idDescuento").val()},
				success: function(data){
					objDetalle = JSON.parse(data);
					if (objDetalle['success'] == true){
						if (objDetalle['data'] != ''){
							
						}
					}
				}
			});
		}
		return true;
	}
	
	function cambiarValor(vValor){
		if (vValor == 0){
			$("#check_recoger").val(1);
			$("#fecharecolectar").val(obtenerFechaEntrega());
			$("#time2").css("display",'block');
			$("#hora2").css("display",'block');
		}else{
			
			$("#check_recoger").val(0);
			$("#fecharecolectar").val(obtenerFechaRecolecta());
			$("#time2").css("display",'none');
			$("#hora2").css("display",'none');
		}
		return true;
	}
	
	function cambiarValorIVA(vValor,vModifica){
		if (vValor == 0){
			$("#check_IVA").val(1);
			$("#lblIva").html('Incluir');
		}else{
			$("#check_IVA").val(0);
			$("#lblIva").html('No incluir');
		}
		
		if(vModifica == 0){
			CalcularSaldoPedido();			
		}else{
			CalcularSaldoPedidoModifica();
		}
		
		return true;
	}
	
	function registrarNuevaColonia(vValor){
		if (vValor == 0){
			$("#check_ColoniaNueva").val(1);
			$("#lbl_ColoniaNueva").html('No Incluir');
		}else{
			$("#check_ColoniaNueva").val(0);
			$("#lbl_ColoniaNueva").html('Incluir');
		}
		
		return true;
	}
	
	
	function cambiarValorDescto(vValor,vModifica){
		if (vValor == 0){
			$("#check_Descto").val(1);
			$("#lblDescto").html('No Incluir');
		}else{
			$("#check_Descto").val(0);
			$("#lblDescto").html('Incluir');
		}
		
		if(vModifica == 0){
			CalcularSaldoPedido();			
		}else{
			CalcularSaldoPedidoModifica();
		}
		
		return true;
	}
	
	function validarCteNuevo(){
		if ($("#telefonocelular").val() == '' &&  $("#telefonocasa").val() == ''){
			if ($("#telefonocelular").val() == ''){
				$("#telefonocelular").focus();
				return false;
			}else {
				$("#telefonocasa").focus();
				return false;
			}
		}else if ($("#nombre").val() == ''){
			$("#nombre").focus();
			return false;
		}else if ($("#apellido").val() == ''){
			$("#apellido").focus();
			return false;
		}else{
			return true;
		}
	}
	
	
	function grabarPedido(){
		var direckeyx = 0;
		var ctekeyx = 0;
		var bRespuesta = false;
		bRespuesta = pedidoGrabarCliente();
		return bRespuesta;
	}
	
	function modificarPedido(){
		var direckeyx = 0;
		var ctekeyx = 0;
		var bRespuesta = false;
		if (vFolioCotiza == ''){
			bRespuesta = modificarGrabarCliente();
		}else{
			bRespuesta = pedidoGrabarCliente();
		}
		return bRespuesta;
	}

	//Notificacion de informacion del sistema lacalizado en el footer
	function muestraInformacionSist() {
	
			$.bigBox({
				title : "Información del sistema",
				content : "<strong>Novedades Adrian</strong></br>Sistema de control de Inventario</br>Version: 1.0&nbsp;|&nbsp;Build: 1.2</br>Actualización: 05/07/2016",
				color : "#30618E",
				timeout: 7000,
				icon : "fa fa-cog swing animated"
				//,number : "1"
			});		 
	}
	
	
	//Registrar domicilios nuevos
	function pedidoGrabarDomicilio(){
		var vFuncion = 5;
		var direckeyx = 0;
		var vCodigoPos = parseInt(($("#CodigoPostal").val()).replace("XXXXX",""))?parseInt(($("#CodigoPostal").val()).replace("XXXXX","")):0;
		var vMunicipio = $("#municipio").val();
		if (vCodigoPos == 0){
			vCodigoPos = 99999;
			$("#CodigoPostal").val(vCodigoPos);
			vMunicipio = 'NO ASIGNADO';
			$("#municipio").val(vMunicipio);

			if ($('#check_ColoniaNueva').val() == 0 && $("#Colonia").val().split("-").length == 1){
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>La colonia que intenta registrar es nueva, debe de seleccionar una del listado</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
				$("#CodigoPostal").val(0);
				$("#municipio").val('');
				vCodigoPos = 0;
				vMunicipio = '';
				return false;
			}
		}
		var vColonia = $("#Colonia").val();
		if($("#Colonia").val().split("-").length == 1){
			vColonia = 0 + ' - ' + $("#Colonia").val() + ' - ' + vMunicipio;
		}
		
		var bRespuesta = validarDomicilioNuevo();
		if (bRespuesta > 0){
			$.post("./php/cliente.php",
			{
				funcion:vFuncion,
				calle:$("#calle").val(),
				numext:$("#numext").val(),
				numint:$("#numint").val(),
				CodigoPostal:vCodigoPos,
				Colonia:vColonia,
				municipio:vMunicipio,
				referencias:$("#referencias").val(),
				clientekeyx:$("#numcliente").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						direckeyx = obj['data']['retorno'];
						$('#direccionkeyx').val( obj['data']['retorno']);
						//Exito
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						pedidoGrabarReferencias();
						//pedidoGrabarEncabezado();
						pedidoGrabarDetalle();
						//window.location.reload();
						
						
					}
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});				
				}
			});
		}else{
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i> Fall&oacute al registrar el domicilio!. </i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
		}
		return true;
	}
	
	
	function validarDomicilioNuevo(){
		if ($("#calle").val() == ''){
			$("#calle").focus();
			return false;
		}else if ($("#numext").val() < 0 || $("#numext").val() == ''){
			$("#numext").focus();
			return false;
		}else if ($("#CodigoPostal").val() == '' || $("#CodigoPostal").val() == 0){
			$("#CodigoPostal").focus();
			return false;
		}else if ($("#Colonia").val() == ''){
			$("#Colonia").focus();
			return false;
		}else if ($("#municipio").val() == ''){
			$("#municipio").focus();
			return false;
		}else{
			return true;
		}
	}
	
	
	//Registrar articulo nuevos a pedido
	function pedidoGrabarArticuloDePedidoNuevo(vId_articulo,vCantidad){
		var vFuncion = 6;
		var vHorarioRenta = '';
		var vFolioPedido = $("#folio").val();
		var bRespuesta = validarArticuloDePedidoNuevo(vFolioPedido,vId_articulo,vCantidad,vHorarioRenta);
		if (bRespuesta){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/cliente.php",
				data: {funcion:vFuncion,
					foliopedido: vFolioPedido,
					id_articulo: vId_articulo,
					cantidad: vCantidad,
					horariorenta: vHorarioRenta,
					num_descuento:$("#idDescuento").val()},
				success: function(data){
					objDetalle = JSON.parse(data);
					if (objDetalle['success'] == true){
						if (objDetalle['data'] != ''){
							
						}
					}
				}
			});
		}
		return true;
	}
	
	
	function validarArticuloDePedidoNuevo(vFolioPedido,vId_articulo,vCantidad,vHorarioRenta){
		if (vFolioPedido <= 0){
			return false;
		}else if (vId_articulo <= 0){
			return false;
		}else if (vCantidad <= 0){
			return false;
		}else{
			return true;
		}
	}
	
	
	
	function validarPedidoNuevo(){
		if ($("#fechaentrega").val() == ''){
			return false;
		}else if ($("#fecharecolectar").val() == ''){
			return false;
		}else if ($("#fechavence").val() == ''){
			return false;
		}else{
			return true;
		}
	}
	
	function pedidoGrabarDetalle(){
		var vArticulo = 0;
		var vCantidad = 0;
		var vConsecutivo = $("#consecutivo").val();
		var vFolioPedido = $("#folio").val();
		for (var i = 1; i <= vConsecutivo ; i++) {
			vArticulo = ($('#cmbarticulos_'+i).val() > 0)?$('#cmbarticulos_'+i).val():0;
			vCantidad = (parseInt($('#cantidad_'+i).val()) > 0)?parseInt($('#cantidad_'+i).val()):0;
			pedidoGrabarArticuloDePedidoNuevo(vArticulo,vCantidad);
		}
		var ctekeyx = $("#clientekeyx").val();
		var direckeyx = $("#direccionkeyx").val();
		var bRespuesta = pedidoGrabarPedido(ctekeyx,direckeyx);
		return true;
	}
		
	
	function LimpiarCapturaPedidoNuevo(vFolioPedido){
		$("#consecutivo").val(1);
		$("#folio").val(vFolioPedido);
		$("#clientekeyx").val(0);
		$("#direccionkeyx").val(0);
		$("#numcliente").val('');
		$("#hora1").val('');
		$("#hora2").val('');
		$("#check_recoger").val(0);
		$("#time2").css("display",'none');
		$("#hora2").css("display",'none');
		$("#calle").val('');
		$("#numext").val('');
		$("#numint").val('');
		$("#CodigoPostal").val('');
		$("#Colonia").val('');
		$("#municipio").val('');
		$("#referencias").val('');
		$('#telefonocelular').val('');
		$('#telefonocasa').val('');
		$('#nombre').val('');
		$('#apellido').val('');
		$('#idManteleria').val('');
		$('#idcargoFlete').val(0);
		$('#importe_totalmodal').val(0);
		$("#total").html(0); 
		$('#tabla').html('');
		$('#telefonocelular').focus();
		$('#agregar_fila').click();
		
		return true;
	}
	
	
	function consultarZonas(){
		var vFuncion = 6;
		
		$.post("./php/zonas.php",
		{
			funcion: vFuncion
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$("#tbodyZonas").html('');
				$("#tbodyZonas").append(obj['data']);
			}
		});
		return true;
	}	
	
	function ConsultarArticuloHorariosEspecial(vKeyx){
		var vFuncion = 2;
		
		$.post("./php/articulos.php",
		{
			funcion: vFuncion,
			keyx:vKeyx,
			fechaentrega:$("#fechaentrega").val()
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				//console.log(obj['data']);
				var text = '';
				var x;
				//Exito
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['data']+ "</i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 10000
				});
			}
		});
		return true;
	}
	
	function ConsultarFolioPedido(){
		var vFuncion = 1;
		var bRespuesta = validarConsultarFolioPedido();
		if (bRespuesta){
			$.post("./php/pedidos.php",
			{
				funcion: vFuncion,
				foliopedido:$("#folio").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					$("#nombre").val(obj['data']['nombrecte']);
					$("#calle").val(obj['data']['calle']);
					$("#numext").val(obj['data']['numext']);
					$("#numint").val(obj['data']['numint']);
					$("#CodigoPostal").val(obj['data']['codigopostal']);
					$("#colonia").val(obj['data']['colonia']);
					$("#municipio").val(obj['data']['ciudad']);
					$("#fechaentrega").val(obj['data']['fechapedido']);
					$("#fecharecolectar").val(obj['data']['fechavueltapedido']);
					$("#hora1").val(obj['data']['notahoraentrega']);
					$("#hora2").val(obj['data']['notahorarecoger']);
					$("#total").html(obj['data']['total']); 
					$("#abono").html(obj['data']['abono']); 
					var importependiente = parseInt(parseInt($("#total").html()) - $("#abono").html());
					if (parseInt(obj['data']['iva']) == 1){
						$("#check_IVA").click();
					}
					$("#check_IVA").attr("disabled","disabled");
					$("#actividadPedido").attr('display','block');
					$("#liquidaPedido").removeAttr('href');
					$("#recibirAbono").removeAttr('href');
					$("#entradaParcial").removeAttr('href');
					
					$("#totalmodal").val(importependiente);
					$("#importe_total").val('');
					$("#importe_total").focus();
					MostrarRecibirYLiquidar($("#folio").val(),obj['data']['fechapedido']);
					
					$("#recibirAbono").attr('href','ajax/modal_recibirabono.php?foliopedido='+$("#folio").val()+'&importe_total='+importependiente);
					var importeGarantia = parseInt(obj['data']['garantia']);
					if (importeGarantia > 0){
						$("#devolverdeposito").attr('href','ajax/modal_devolverdeposito.php?foliopedido='+$("#folio").val()+'&importe_total='+importeGarantia);
					}else{
						$("#devolverdeposito").removeAttr('href');
						$("#devolverdeposito").css("display","none");
					}
					
					consultarPedidoaRecibir();
					//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 10000
					});
				}else{
					$("#actividadPedido").attr('display','none');
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});	
				}
			});
		}
		return true;
	}
	
	
	function validarConsultarFolioPedido(){
		if ($("#folio").val() == '' || $("#folio").val() <= 0){
			return false;
		}else{
			return true;
		}
	}
	
	function consultarPedidoaRecibirNormal(){
		var vFuncion = 2;
		
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			foliopedido:$("#folio").val()
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$("#tbodyRecibirPedido").html('');
				$("#tbodyRecibirPedido").append(obj['data']);
			}
		});
		return true;
	}	
		
	function AbonarPedido(vModal,ifolioPedido,iActualiza,vMostrarNota,vRecibed){
		var vFuncion = 4;
		var vAbono = 0;
		if (vModal != 1){
			vAbono = (parseInt($("#importe_total").html()) > 0 ?$("#importe_total").html():0);
		}else{
			vAbono = (parseInt($("#importe_totalmodal").val()) > 0 ?$("#importe_totalmodal").val():0);
		}
		vAbono = parseInt(vAbono);
		if (vAbono > 0){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/pedidos.php",
				data: {funcion: vFuncion,foliopedido:(parseInt($("#foliomodal").html()) > 0)?parseInt($("#foliomodal").html()):ifolioPedido,
						iabono:vAbono,recibio:vRecibed,empleado:$("#empleado").val()},
				success: function(data){
					obj = JSON.parse(data);
				if (obj['success'] == true){
						if (iActualiza != 1){
							$('#modalAbono').modal('toggle'); 
							setTimeout(function(){ 
								window.history.back();
							}, 1000);
							$.smallBox({
								title : "Aviso",
								content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
								color : "#659265",
								iconSmall : "fa fa-check fa-2x fadeInRight animated",
								timeout : 1000
							});
							
							return true;
						}else if (vMostrarNota) {
						//Exito
						

							var iIva = $("#check_IVA").val(); 
							var notaabono = vAbono; // Folio de la nota de abono
							var folioPedido = (parseInt($("#foliomodal").html()) > 0)?parseInt($("#foliomodal").html()):ifolioPedido;
							
							// Cerrar el modal
							$('#modalAbono').modal('toggle');  //$('#modalAbono').modal('hide');	

							//Abrir aviso de impresion de nota

							/*$.smallBox({
								title : "Se captur&oacute; la nota para el folio #" + ifolioPedido + ", por la cantidad de $" + vAbono + "." ,
								content : "<h4>¿ Desea imprimir el comprobante ?</h4><p class='text-align-left'><br><a  href='#ajax/nota_abono.php?n=" + notaabono + "&f="+folioPedido+"&i="+iIva+"' class='btn btn-primary btn-sm closeImpr'>&nbsp;Si&nbsp;</a> <a href='javascript:void(0);' class='btn btn-danger btn-sm closeImpr'>No</a></p>",
								color : "#296191",
								//timeout: 8000,
								icon : "fa fa-foursquare swing animated"
							});*/
							var urlAbono = "#ajax/nota_abono.php?n=" + notaabono + "&f="+folioPedido+"&i="+iIva;
							//window.location.href = urlAbono;
							sUrlRedirected = urlAbono;
						}
		 
					}else{
						//Falla
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 3000
						});	
					}
					
				}
			});
			
			
			/*
			$.post("./php/pedidos.php",
			{
				funcion: vFuncion,
				foliopedido:(parseInt($("#foliomodal").html()) > 0)?parseInt($("#foliomodal").html()):ifolioPedido,
				iabono:vAbono,
				recibio:vRecibed,
				empleado:$("#empleado").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
						if (iActualiza != 1){
							$('#modalAbono').modal('toggle'); 
							setTimeout(function(){ 
								window.history.back();
							}, 1000);
							$.smallBox({
								title : "Aviso",
								content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
								color : "#659265",
								iconSmall : "fa fa-check fa-2x fadeInRight animated",
								timeout : 1000
							});
							
							return true;
						}else if (vMostrarNota) {
						//Exito
						

							var iIva = $("#check_IVA").val(); 
							var notaabono = vAbono; // Folio de la nota de abono
							var folioPedido = (parseInt($("#foliomodal").html()) > 0)?parseInt($("#foliomodal").html()):ifolioPedido;
							
							// Cerrar el modal
							$('#modalAbono').modal('toggle');  //$('#modalAbono').modal('hide');	

							//Abrir aviso de impresion de nota

							/*$.smallBox({
								title : "Se captur&oacute; la nota para el folio #" + ifolioPedido + ", por la cantidad de $" + vAbono + "." ,
								content : "<h4>¿ Desea imprimir el comprobante ?</h4><p class='text-align-left'><br><a  href='#ajax/nota_abono.php?n=" + notaabono + "&f="+folioPedido+"&i="+iIva+"' class='btn btn-primary btn-sm closeImpr'>&nbsp;Si&nbsp;</a> <a href='javascript:void(0);' class='btn btn-danger btn-sm closeImpr'>No</a></p>",
								color : "#296191",
								//timeout: 8000,
								icon : "fa fa-foursquare swing animated"
							});* /
							var urlAbono = "#ajax/nota_abono.php?n=" + notaabono + "&f="+folioPedido+"&i="+iIva;
							//window.location.href = urlAbono;
							sUrlRedirected = urlAbono;
						}
		 
					}else{
						//Falla
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 3000
						});	
					}
				
			});*/
		}else{
			$("#importe_total").focus();
		}
		return true;
	}

	
	function consultarPedidoaRecibir(){
		var vFuncion = 5;
		
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			foliopedido:$("#folio").val()
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$("#tbodyRecibirPedido").html('');
				$("#tbodyRecibirPedido").append(obj['data']);
			}
		});
		return true;
	}
	
	function actulizarZona(vRegion){
		var vFuncion = 7;
		var bRespuesta = validarNvaZonaModal(vRegion);
		if (bRespuesta && vRegion > 0){
			$.post("./php/zonas.php",
			{
				funcion: vFuncion,
				iRegion:vRegion,
				nombrezona:$("#nombremodal").val(),
				desczona:$("#descripcionmodal").val()			
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
				//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 10000
					});
					setTimeout(function(){
						window.location.reload();
					}, 2000);
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});	
				}
			});
		}else{
			$("#nombre").focus();
		}
		return true;
	}
	
	function eliminarZona(vRegion){
		var vFuncion = 8;
		if (vRegion > 0){
			$.post("./php/zonas.php",
			{
				funcion: vFuncion,
				iRegion:vRegion
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
				//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 10000
					});
					setTimeout(function(){
						window.location.reload();
					}, 2000);
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});	
				}
			});
		}else{
			$("#nombre").focus();
		}
		return true;
	}
	
	function eliminarColoniaZona(vRegion){
		var vFuncion = 10;
		if (vRegion > 0){
			$.post("./php/zonas.php",
			{
				funcion: vFuncion,
				iRegion:vRegion
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
				//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 10000
					});
					setTimeout(function(){
						window.location.reload();
					}, 2000);
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});	
					setTimeout(function(){
						window.location.reload();
					}, 2000);
				}
				
			});
		}else{
			$("#nombre").focus();
		}
		return true;
	}
	
	function validarNvaZonaModal(iRegion){
		if (iRegion <= 0){
			$("#nombremodal").focus();
			return false;
		}else if ($("#nombremodal").val() == ''){
			$("#nombremodal").focus();
			return false;
		}else if ($("#descripcionmodal").val() == ''){
			$("#descripcionmodal").focus();
			return false;
		}else{
			return true;
		}
	}
	
	
	//Aviso de confirmacion para eliminar o actualizar una zona
	function MensajeSmartZonas(vRegion,vOperacion) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada a este usuario.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				if(vOperacion == 2){
					eliminarZona(vRegion);
				}else if(vOperacion == 4){
					actulizarZona(vRegion)
				}
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}

		});
		return true;
	}
	
	//Aviso de confirmacion para eliminar o actualizar una  colonia
	function MensajeSmartColonias(vRegion,vOperacion) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada a esta colonia.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				if(vOperacion == 2){
					eliminarColoniaZona(vRegion);
				}else if(vOperacion == 4){
					ActualizarZonaColonia(vRegion);
				}
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
		return true;
	}
	
	function ActualizarZonaColonia(vKeyxDir){
		var vFuncion = 9;
		var vRegion = $("#SelectZonaModal").val();
		if (vKeyxDir > 0 && vRegion > 0){
			$.post("./php/zonas.php",
			{
				funcion: vFuncion,
				iKeyxDir:vKeyxDir,
				iRegion:vRegion
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
				//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 10000
					});
					setTimeout(function(){
						window.location.reload();
					}, 2000);
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});	
					setTimeout(function(){
						window.location.reload();
					}, 2000);
				}
			});
		}else{
			$("#nombre").focus();
		}
		return true;
	}
	
	function LimpiarCapturaPedidoLiberado(){
		$("#folio").val('');
		$('#nombre').val('');
		$("#calle").val('');
		$("#numext").val('');
		$("#numint").val('');
		$("#CodigoPostal").val('');
		$("#colonia").val('');
		$("#municipio").val('');
		$("#referencias").val('');
		$("#fechaentrega").val('');
		$("#fecharecolectar").val('');
		$("#hora1").val('');
		$("#hora2").val('');
		$("#check_recoger").val(0);
		$("#time2").css("display",'none');
		$("#hora2").css("display",'none');
		$("#abono").html(0); 
		$("#total").html(0); 
		$("#tbodyRecibirPedido").html('');
		$("#liquidaPedido").removeAttr('href');
		$("#recibirAbono").removeAttr('href');
		$("#entradaParcial").removeAttr('href');
		$('#folio').focus();
		return true;
	}
	
	function validarInt(obj){
		if (obj.value.length <= 0){
			obj.value = 0;
			obj.focus();
		}
		
		if (parseInt(obj.max) < parseInt(obj.value)){
			obj.value = parseInt(obj.max)
		}
		
		obj.value = parseInt(obj.value);
		return true;		
	}
	
	function isNumber(e) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = "1234567890";
		especiales = [8, 37, 46];

		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}

		if (key ==13){
			$(this).trigger({
				type: 'keypress',
				which: 9
			});
		}else if(letras.indexOf(tecla) == -1 && !tecla_especial)
			return false;
	}
	
	function isLetter(e) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = "áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ()";
		especiales = [8, 32, 37, 46];

		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}

		if (key ==13){
			$(this).trigger({
				type: 'keypress',
				which: 9
			});
		}else if(letras.indexOf(tecla) == -1 && !tecla_especial)
			return false;
	}
	
	function isCorrectNumber(e,obj) {
		var bRespuesta = false;
		var bRespuesta = isNumber(e);
	
		if (parseInt(obj.max) < parseInt(obj.value)){
			obj.value = obj.max;
		}
		return bRespuesta;
	}
	
	function isAlphaNumeric(e) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = "áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890-_,.:()/\[]";
		especiales = [8,32,37,46];

		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}

		if (key ==13){
			$(this).trigger({
				type: 'keypress',
				which: 9
			});
		}else if(letras.indexOf(tecla) == -1 && !tecla_especial){
			return false;
		}
		
	}
	
	function isEmail(e) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = "áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890-_,.@";
		especiales = [8,32,37,46];

		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}

		if (key ==13){
			$(this).trigger({
				type: 'keypress',
				which: 9
			});
		}else if(letras.indexOf(tecla) == -1 && !tecla_especial){
			return false;
		}
		
	}
	
	//Recorre el grid para regresar los articulos a inventario
	function regresarDetalleInventario(){
		var bRespuesta = false;
		var vArticulo = 0;
		var vCantidad = 0;
		var vConsecutivo = $("#tbodyArticulosModal tr").length;
		var vFolioPedido = $("#folio").val();
		GrabarNotaAccesorios();
		for (var i = 1; i <= vConsecutivo ; i++) {
			vArticulo = ($('#skumodal_'+i).html() > 0)?$('#skumodal_'+i).html():0;
			vCantidad = (parseInt($('#recibirmodal_'+i).val()) > 0)?parseInt($('#recibirmodal_'+i).val()):0;
			if (vCantidad > 0) {
				bRespuesta = regresarArticuloaInventario(vFolioPedido,vArticulo,vCantidad);
			}else{
				continue;
			}
			
			if(!bRespuesta){break;}
		}
		if(bRespuesta){
			
			// Cerrar el modal
				$('#modalEntrada').modal('toggle');  //$('#modalEntrada').modal('hide');	
			//Exito
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>"+"Se liber&oacute; correctamente los art&iacute;culos!."+ "</i>",
				color : "#659265",
				iconSmall : "fa fa-check fa-2x fadeInRight animated",
				timeout : 4000
			});
			setTimeout(function(){ 
				window.history.back();
			}, 1000);
		}else{
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>"+"Fall&oacute; al liberar los art&iacute;culos!."+ "</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});	
		}
		return bRespuesta;
	}
	
	function consultarPedidoaEntregarParcial(){
		var vFuncion = 6;
		
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			foliopedido:$("#folio").val()
		},
		function(data,status){
			objModal = JSON.parse(data);
			if (objModal['success'] == true){
				$("#tbodyArticulosModal").html('');
				$("#tbodyArticulosModal").append(objModal['data']);
			}
		});
		return true;
	}
	
	function validarArticuloDevolver(vFolioPedido,vId_articulo,vCantidad){
		if (vFolioPedido <= 0){
			return false;
		}else if (vId_articulo <= 0){
			return false;
		}else if (vCantidad <= 0){
			return false;
		}else{
			return true;
		}
	}
	
	//Consulta el inventario dado de alta o modificado recarga el grid
	function consultarInventarioModificado(){
		var vFuncion = 4;
		$.post("./php/inventario.php",
		{
			funcion:vFuncion
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$("#tbodyInventario").html('');
				$("#tbodyInventario").append(obj['data']);
			}
		});

		return true;
	}
	
	function limpiarDomicilio(){
		$("#calle").val('');
		$("#numext").val('');
		$("#numint").val('');
		$("#CodigoPostal").val('');
		$("#Colonia").val('');
		$("#municipio").val('');
		$("#referencias").val('');
		$("#calle").focus();
		return true;
	}
	
	function limpiarCliente(){
		$("#clientekeyx").val('0');
		$("#numcliente").val('');
		$("#telefonocelular").val('');
		$("#telefonocasa").val('');
		$("#nombre").val('');
		$("#apellido").val('');
		$("#telefonocelular").focus();
		return true;
	}
	
	function LimpiarZonasCancelar(){
		$("#SelectZona").val(0);
		$("#municipio").val('');
		$("#CodigoPostal").val('');
		$("#CodigoPostal").focus();
		$("#Colonia").val('');
		return true;
	}
	
	$("input,select").bind("keydown", function (e) {

	  var keyCode = e.keyCode || e.which;
		   if(e.keyCode === 13) {
			e.preventDefault();
			$('input,select,textarea')[$('input,select,textarea').index(this)+1].focus();
			}
	});
	
	
	function AbonarPedidoModal(vFolioPedido){
		if (parseInt($('#totalmodal').val()) > 0){
			var vRecibio = $('#idRecibed').val();
			AbonarPedido(1,vFolioPedido,0,true,vRecibio);
		}else{
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>No se puede abonar al folio, no hay saldo pendiente!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});			
		}
		return true;
	}
	
	
	//Consultar todos lo pedidos.
	function buscarPedidosTodos(){
		
		var vFuncion = 9;
		var vMes = []; 
		$('#idMonth :selected').each(function(i, selected){ 
		  vMes[i] = $(selected).val(); 
		});
		var vAnio = []; 
		$('#idYear :selected').each(function(i, selected){ 
		  vAnio[i] = $(selected).val(); 
		});
		
		if (vMes.length <= 0){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Capture un mes!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}
		if (vAnio.length <= 0){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Captura un a&ntilde;o</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}
		if (vMes.length > 0 && vAnio.length > 0){
			limpiarPedidosTodos();
			$.post("./php/pedidos.php",
			{
				funcion: vFuncion,
				fechames:vMes.toString(),
				fechaanio:vAnio.toString()
			},
			function(data,status){					
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'].length > 0){
						$("#tBodyRpt").html(obj['data']);
						Pagina();
						$("#btnBuscarPedidosTodos").attr("disabled","disabled");
					}else{
						$("#tBodyRpt").html(obj['data']);
						$("#tBodyRpt").html('');
						Pagina();
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});
					}
					
				}else{
					$("#tBodyRpt").html(obj['data']);
					$("#tBodyRpt").html('');
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			});
		}
		return true;
	}
	
	
	
	function limpiarPedidosTodos(){
		$("#tBodyRpt").html('');
		return true;
	}
	
	
	function limpiarPedidosEficiencia(){
		$("#tbTotalesrpt").html('');
		$("#tBodyRpt").html('');
		$("#from").val('');
		$("#to").val('');
		$("#selEmpleado").val(0);
		$("#select2-chosen-1").html('')
		return true;
	}
	
	//Consultar todos lo pedidos.
	function buscarTotalesEficiencia(){
		
		var vFuncion = 11;
		if ($("#selEmpleado").val() == 0){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Seleccione un empleado!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vEmpleado = $("#selEmpleado").val();
			
		}
		if ($("#from").val() == ''){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Capture una fecha inicio!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}
		if ($("#to").val() == ''){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Captura una fecha final!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}
		
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			empleado:vEmpleado,
			fechames:$("#from").val(),
			fechaanio:$("#to").val()
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				if (obj['data'].length > 0){
					$("#tbTotalesrpt").html(obj['data']);
					
				}			
			}else{
				$("#tbTotalesrpt").html('');
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
	
		return true;
	}
	
	
	//Consultar todos lo pedidos.
	function buscarAbonosPedidos(){
		
		var vFuncion = 12;
		if ($("#folio").val() == 0){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Seleccione un empleado!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vFolioPedido = $("#folio").val();
			
		}
		
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			foliopedido:vFolioPedido
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				if (obj['data'].length > 0){
					$("#tbAbonosrpt").html(obj['data']);
				}else{
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>No se encontr&oacute; informaci&oacute;n en los criterios seleccionados!.</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});					
				}
			}else{
				$("#tbAbonosrpt").html('');
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
	
		return true;
	}
	
	
	function LimpiarAbonosReporte(){
		$("#tbAbonosrpt").html('');
		return true;
	} 
	
	
	function SetValoresDefault(vCaja,vOpcion){
		if (vCaja.value == ''){
			vCaja.value= 0;
		}
		if (vOpcion == 1){
			CalcularSaldoPedido();
		}else{
			CalcularSaldoPedidoModifica();
		}
		return true;
	} 
	
	
	
	function ModificarVariables(){
		ModificarDescuento();
		ModificarTiempoSesion();
		setTimeout(function(){ 
			window.location.href = './#ajax/dashboard.php';
		}, 1000);
		return true;
	}
	
	function ModificarDescuento(){
		
		var vFuncion = 13;
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			keyx:1,
			empresa:1,
			valor:$("#Descuento").val()
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ " de descuento!. </i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
			}else{
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ " de descuento!.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
	
		return true;
	}
	
	
	function ModificarTiempoSesion(){
		
		var vTimeO = ($("#Inactividad").val()!= null?$("#Inactividad").val()*60:0);
		var vFuncion = 13;
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			keyx:2,
			empresa:1,
			valor:vTimeO
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ " de tiempo de inactividad!.</i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
			}else{
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "  de tiempo de inactividad!</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
	
		return true;
	}




	
	function SetValores(vCaja){
		if (vCaja.value == ''){
			vCaja.value= 0;
		}
		if (vCaja.value <= vCaja.min){
			vCaja.value= vCaja.min;
		}
		return true;
	}
	
	
	function GrabarNotaAccesorios(){
		vFolioPedido = $("#folio").val();
		var vFuncion = 14;
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			foliopedido:vFolioPedido,
			recibio:$("#idAccesorios").val()
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
			}else{
			}
		});
	
		return true;
	}
	
	
	function valorMaxMin(obj,minimo){
		if (obj.value > parseInt(valorMaximo)){
			obj.value = parseInt(valorMaximo);
		}
		if (obj.value < parseInt(minimo)){
			obj.value = parseInt(minimo);
		}
		return true;
	}
	
	
	//Aviso de confirmacion realizar el corte de abonos
	function MensajeSmartCorteAbonos() {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar, debiste de haber impreso el reporte?",
			content : "Al realizar la operaci&oacute;n no podrás imprimir el reporte nuevamente, en este día.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				generarCorteAbonos();
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n, no olvides imprimir el reporte.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){ 
					window.location.reload();
				}, 1000);
			}

		});
		return true;
	}
	
	//Genera el corte de abonos.
	function generarCorteAbonos(){
		
		var vFuncion = 15;
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){ 
					window.location.reload();
				}, 3000);
				
			}else{
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
	
		return true;
	}
	
	
	//Aviso de confirmacion realizar el corte de abonos
	function MensajeSmartCorteAnticipos() {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar, debiste de haber impreso el reporte?",
			content : "Al realizar la operaci&oacute;n no podrás imprimir el reporte nuevamente, en este día.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				generarCorteAnticipos();
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n, no olvides imprimir el reporte.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){ 
					window.location.reload();
				}, 1000);
			}

		});
		return true;
	}
	
	
	//Genera el corte de abonos.
	function generarCorteAnticipos(){
		
		var vFuncion = 16;
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			empleado:uUser
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){ 
					window.location.reload();
				}, 3000);
				
			}else{
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
	
		return true;
	}
	
	
	function PagarComisionVenta(ifolioPedido){
		
		var objVendedor = $("#controles_"+ifolioPedido+" label")[0];
		var objTotal = $("#controles_"+ifolioPedido+" label")[2];
		var vFuncion = 1;
		$.post("./php/comisiones.php",
		{
			funcion: vFuncion,
			foliopedido: ifolioPedido,
			cliente:objVendedor.innerHTML,
			monto: objTotal.innerHTML
			
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				return true;
			}else{
				return false;
			}
		});
	
		return true;
	}
	
	
	//Aviso de confirmacion realizar el corte de abonos
	function MensajeSmartCorteDescartarPagarComisiones() {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar, debiste de haber impreso el reporte?",
			content : "Al realizar la operaci&oacute;n no podrás imprimir el reporte.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				PagarComisiones();
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n, no olvides imprimir el reporte.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){ 
					window.location.reload();
				}, 1000);
			}

		});
		return true;
	}
	
	//Graba cotizaciones
	function grabarCotizacion(){
		var direckeyx = 0;
		var ctekeyx = 0;
		var bRespuesta = false;
		var vEmailAddress = $('#email').val();
		
		if (isValidEmailAddress(vEmailAddress) || vEmailAddress == '' ){
			bRespuesta = cotizacionGrabarCliente();
		}else{
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Revisa la direccion de correo!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			$('#email').focus();
		}
		return bRespuesta;
	}
	
	//Registrar clientes nuevos
	function cotizacionGrabarCliente(){
		var vFuncion = 1;
		var ctekeyx = 0;
		var bRespuesta = validarCteNuevo();
		if (bRespuesta > 0){
			$.post("./php/cotizacion.php",
			{
				funcion:vFuncion,
				telefonocelular: QuitarMascara($('#telefonocelular').val()),
				telefonocasa: QuitarMascara($('#telefonocasa').val()),
				nombre: $('#nombre').val(),
				apellido: $('#apellido').val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						$('#clientekeyx').val(obj['data']['retorno']);
						ctekeyx =obj['data']['retorno'];
						//Exito
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						cotizacionGrabarDetalle();
					}
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			});
		}else{
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i> Fall&oacute al registrar al cliente!. </i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
		}
		return true;
	}
	
	
	function cotizacionGrabarDetalle(){
		var vArticulo = 0;
		var vCantidad = 0;
		var vConsecutivo = $("#consecutivo").val();
		var vFolioPedido = $("#folio").val();
		var vHorarioRenta = '';
		for (var i = 1; i <= vConsecutivo ; i++) {
			vArticulo = ($('#cmbarticulos_'+i).val() > 0)?$('#cmbarticulos_'+i).val():0;
			vCantidad = (parseInt($('#cantidad_'+i).val()) > 0)?parseInt($('#cantidad_'+i).val()):0;
			if (parseInt($('#hidespecial_'+i).val()) == 1){
				vHorarioRenta = ($('#notaEspecial_'+i).val() != '')?$('#notaEspecial_'+i).val():'';
			}else{
				vHorarioRenta = '';
			}
			cotizacionGrabarArticulo(vArticulo,vCantidad,vHorarioRenta);
		}
		var ctekeyx = $("#clientekeyx").val();
		var direckeyx = 0;
		var bRespuesta = cotizacionGrabarPedido(ctekeyx,direckeyx);
		return true;
	}
	
	
	//Registrar articulo nuevos a pedido
	function cotizacionGrabarArticulo(vId_articulo,vCantidad,vHorarioRenta){
		var vFuncion = 2;
		var vFolioPedido = $("#folio").val();
		var bRespuesta = validarArticuloDePedidoNuevo(vFolioPedido,vId_articulo,vCantidad,vHorarioRenta);
		if (bRespuesta){
			$.post("./php/cotizacion.php",
			{
				funcion:vFuncion,
				foliopedido: vFolioPedido,
				id_articulo: vId_articulo,
				cantidad: vCantidad,
				horariorenta: vHorarioRenta
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						
					}
				}
			});
		}
		return true;
	}
	
	//Registrar pedido nuevo
	function cotizacionGrabarPedido(vCtekeyx,vDireckeyx){
		var vMostrarNota = true;
		var vFuncion = 3;
		var vFolioPedido = $("#folio").val();
		var vEmpleado = $("#empleado option:selected").html();
		var bRespuesta = validarPedidoNuevo();
		if (bRespuesta){
			$.post("./php/cotizacion.php",
			{
				funcion:vFuncion,
				foliopedido: vFolioPedido,
				fechaentrega: $("#fechaentrega").val(),
				fecharecolecta: $("#fecharecolectar").val(),
				hora1: $("#hora1").val(),
				hora2: $("#hora2").val(),
				flag_especial:  $("#check_recoger").val(),
				clientekeyx:  vCtekeyx,
				direccionkeyx:  vDireckeyx,
				empleado:$("#empleado").val(),
				mantel:$("#idManteleria").val(),
				flete:$("#idcargoFlete").val(),
				iva:$("#check_IVA").val(),
				flag_descuento:$("#check_Descto").val(),
				porcentajedescuento:$("#PorcentajeDescuento").val(),
				garantia:$("#importe_garantia").val()
				
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						//Exito
						$("#btnGrabarCotizacion").attr("disabled","disabled");
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						enviarMailCotizacion(vFolioPedido);
					}
				}else{
					//Falla
					$("#btnGrabarCotizacion").removeAttr("disabled");
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});					
				}
			});
		}else{
			//Falla
			$("#btnGrabarCotizacion").removeAttr("disabled");
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i> Fall&oacute al registrar el pedido!. </i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
		}
		return true;
	}
	
	function MensajeSmartModCotizaciones(vFolio,vOperacion) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada a este pedido.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				
				if(vOperacion == 2){
					borrarCotizacion(vFolio);
				}
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}

		});
		return true;
	}
	
	//Baja de cotizacion
	function borrarCotizacion(vFolio){
		var vFuncion = 4;
		
		$.post("./php/cotizacion.php",
		{
			funcion: vFuncion,
			foliopedido:((parseInt(vFolio) >0)?vFolio:0)
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){
					window.location.href = sUrlRedirected;
					window.location.reload();
				}, 2000);
				
				
			}else{
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
		return true;
	}
	
	function isValidEmailAddress(emailAddress) {
		var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
		return pattern.test(emailAddress);
	};
	
	
	//Enviar email de cotizacion
	function enviarMailCotizacion(vFolio){
		var vFuncion = 5;
		var vEmailAddress = $('#email').val();
		if (isValidEmailAddress(vEmailAddress) && vEmailAddress != ''){
			$.post("./php/cotizacion.php",
			{
				funcion: vFuncion,
				foliopedido:((parseInt(vFolio) >0)?vFolio:0),
				email:vEmailAddress
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['codigo'] == true){
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['mensaje']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					setTimeout(function(){
						window.location.href = sUrlRedirected + '?f='+ vFolio;
					}, 2000);
					
					
				}else{
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
					setTimeout(function(){
						window.location.href = sUrlRedirectedHome;
					}, 2000);
				}
			});
		}else{
			setTimeout(function(){
				window.location.href = sUrlRedirected + '?f='+ vFolio;
			}, 2000);
		}
		return true;
	}
	
	//Consultar Cotizacion
	function ConsultarCotizacionAModificar(vFolioPedido){
		var vFuncion = 6;
		vFolioPedido = (vFolioPedido !=null)?vFolioPedido:$("#folio").val();
		var bRespuesta = validarConsultarFolioPedido();
		if (bRespuesta){
			$.post("./php/cotizacion.php",
			{
				funcion: vFuncion,
				foliopedido:vFolioPedido
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					$("#nombre").val(obj['data']['nombrecte']);
					$("#apellido").val(obj['data']['apellidocte']);
					$("#telefonocasa").val(obj['data']['telefonocasa']);
					$("#telefonocelular").val(obj['data']['telefonocelular']);
					setTimeout(function(){
						ConsultarTelefonos();
					}, 500);
					$("#referencias").val(obj['data']['referencias']);
					$("#calle").val(obj['data']['calle']);
					$("#numext").val(obj['data']['numext']);
					$("#numint").val(obj['data']['numint']);
					$("#CodigoPostal").val(obj['data']['codigopostal']);
					$("#Colonia").val(obj['data']['colonia']);
					$("#idManteleria").val(obj['data']['manteleria']);
					$("#idcargoFlete").val(obj['data']['flete']);
					$("#municipio").val(obj['data']['ciudad']);
					$("#fechaentrega").val(obj['data']['fechapedido']);
					$("#fecharecolectar").val(obj['data']['fechavueltapedido']);
					$("#hora1").val(obj['data']['notahoraentrega']);
					$("#hora2").val(obj['data']['notahorarecoger']);
					var importependiente = parseInt(obj['data']['total']) + parseInt(obj['data']['abono']);
					$("#subtotal").html(importependiente); 
					vAbonoAnterior = parseInt(obj['data']['abono']); 
					$("#abono").html(parseInt(obj['data']['abono'])); 
					$("#importe_totalmodal").val(0); 
					$("#importe_garantia").val(obj['data']['garantia']); 
					if (parseInt(obj['data']['iva']) == 1){
						$("#check_IVA").click();		
					}
					if (parseInt(obj['data']['descuento']) == 1){
						$("#check_Descto").click();
					}
					$("#PorcentajeDescuento").val(obj['data']['cantidaddescuento']);
					if (obj['data']['fechapedido'] === obj['data']['fechavueltapedido']){
						$("#check_recoger").click();
					}
					$('#idTituloModCotizacion').html('Modificar Cotizaci&oacute;n ' + obj['data']['fechapedido']);
					$("#actividadPedido").attr('display','block');
					$("#liquidaPedido").removeAttr('href');
					$("#recibirAbono").removeAttr('href');
					$("#entradaParcial").removeAttr('href');
					if (obj['data']['empleado'] != ''){
						var buscaEmpleado = $("#empleado").find("option:contains('"+ obj['data']['empleado'] +"')");
						$("#empleado").val(buscaEmpleado.val());
					}
					$("#total").val(parseInt(obj['data']['total']));
					$("#importe_total").val('');
					$("#importe_total").focus();
					consultarPedidoaRecibir();
					
					
					//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 10000
					});
				}else{
					$("#actividadPedido").attr('display','none');
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});	
				}
			});
		}
		return true;
	}
	
	
	function modificarCotizacion(){
		var direckeyx = 0;
		var ctekeyx = 0;
		var bRespuesta = false;
		bRespuesta = modificarGrabarClienteCotizacion();
		return bRespuesta;
	}
	
	
	//Registrar clientes cotizaciones
	function modificarGrabarClienteCotizacion(){
		var vFuncion = 1;
		var ctekeyx = 0;
		var bRespuesta = validarCteNuevo();
		if (bRespuesta > 0){
			$.post("./php/cotizacion.php",
			{
				funcion:vFuncion,
				telefonocelular: QuitarMascara($('#telefonocelular').val()),
				telefonocasa: QuitarMascara($('#telefonocasa').val()),
				nombre: $('#nombre').val(),
				apellido: $('#apellido').val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						$('#clientekeyx').val(obj['data']['retorno']);
						ctekeyx =obj['data']['retorno'];
						//Exito
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						modificarCotizacionGrabarDetalle();
					}
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			});
		}else{
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i> Fall&oacute al registrar al cliente!. </i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
		}
		return true;
	}
	
	function modificarCotizacionGrabarDetalle(){
		var vFuncion = 7;
		var vFolioPedido = $("#folio").val();
		var bRespuesta = validarPedidoNuevo();
		if (bRespuesta){
			$.post("./php/cotizacion.php",
			{
				funcion:vFuncion,
				foliopedido: vFolioPedido
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						var vArticulo = 0;
						var vCantidad = 0;
						var vConsecutivo = $("#consecutivo").val();
						var vFolioPedido = $("#folio").val();
						var vHorarioRenta = '';
						for (var i = 1; i <= vConsecutivo ; i++) {
							vArticulo = ($('#cmbarticulos_'+i).val() > 0)?$('#cmbarticulos_'+i).val():0;
							vCantidad = (parseInt($('#cantidad_'+i).val()) > 0)?parseInt($('#cantidad_'+i).val()):0;
							if (parseInt($('#hidespecial_'+i).val()) == 1){
								vHorarioRenta = ($('#notaEspecial_'+i).val() != '')?$('#notaEspecial_'+i).val():'';
							}else{
								vHorarioRenta = '';
							}
							cotizacionGrabarArticuloDeCotizacionModificado(vArticulo,vCantidad,vHorarioRenta);
						}
						var ctekeyx = $("#clientekeyx").val();
						var direckeyx = $("#direccionkeyx").val();
						var bRespuesta = modifcarCotizacionGrabarCotizacion(ctekeyx,direckeyx);
					}else{
						//Falla
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});					
					}
				}
			});
		}
		return true;
	}
	
	
	//Registrar articulo nuevos a cotizacion
	function cotizacionGrabarArticuloDeCotizacionModificado(vId_articulo,vCantidad,vHorarioRenta){
		var vFuncion = 2;
		var vFolioPedido = $("#folio").val();
		var bRespuesta = validarArticuloDePedidoNuevo(vFolioPedido,vId_articulo,vCantidad,vHorarioRenta);
		if (bRespuesta){
			$.post("./php/cotizacion.php",
			{
				funcion:vFuncion,
				foliopedido: vFolioPedido,
				id_articulo: vId_articulo,
				cantidad: vCantidad,
				horariorenta: vHorarioRenta
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						
					}
				}
			});
		}
		return true;
	}
	
	
	//Registrar pedido modificado
	function modifcarCotizacionGrabarCotizacion(vCtekeyx,vDireckeyx){
		var vMostrarNota = true;
		var vFuncion = 8;
		var vFolioPedido = $("#folio").val();
		var vEmpleado = $("#idEmpleado").html();
		var bRespuesta = validarPedidoNuevo();
		if (bRespuesta){
			$.post("./php/cotizacion.php",
			{
				funcion:vFuncion,
				foliopedido: vFolioPedido,
				fechaentrega: $("#fechaentrega").val(),
				fecharecolecta: $("#fecharecolectar").val(),
				hora1: $("#hora1").val(),
				hora2: $("#hora2").val(),
				flag_especial:  $("#check_recoger").val(),
				clientekeyx:  vCtekeyx,
				direccionkeyx:  vDireckeyx,
				empleado:$("#empleado").val(),
				mantel:$("#idManteleria").val(),
				flete:$("#idcargoFlete").val(),
				iva:$("#check_IVA").val(),
				flag_descuento:$("#check_Descto").val(),
				porcentajedescuento:$("#PorcentajeDescuento").val(),
				garantia:$("#importe_garantia").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						//Exito
						$("#btnGrabarCotizacion").attr("disabled","disabled");
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						enviarMailCotizacion(vFolioPedido);
					}
				}else{
					//Falla
					$("#btnGrabarCotizacion").removeAttr("disabled");
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});					
				}
			});
		}else{
			//Falla
			$("#btnGrabarCotizacion").removeAttr("disabled");
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i> Fall&oacute al registrar el pedido!. </i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
		}
		return true;
	}
	
	
	//Baja de cotizacion
	function actualizaCotizacion(vFolio){
		var vFuncion = 9;
		
		$.post("./php/cotizacion.php",
		{
			funcion: vFuncion,
			foliopedido:((parseInt(vFolio) >0)?vFolio:0)
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){
					window.location.href = sUrlRedirected;
					window.location.reload();
				}, 2000);
				
				
			}else{
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
		return true;
	}
	
	//Aviso de confirmacion para liquidar el pedido.
	function MensajeSmartLiquidarPedido() {
		if ($("#check_Liquido").length > 0){
			if ($('#check_Liquido').val() == 0){
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Debe de  aprobar que se libere el folio, el pedido fue llevado hoy, tendra que haber recibido la mercancia en este momento</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 6000
				});
				return false;
			}			
		}
		
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada con el pedido." +
			"<br/>* Se requiere haber recibido el total del pedido y la mercancia.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				LiquidarPedido();
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}

		});
		return true;
	}
	
	//Aviso de confirmacion para recibir el abono.
	function MensajeSmartAbonoPedido(vFolioPedido) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada con el pedido." +
			"<br/>* Se requiere haber recibido el monto de abono, ya que el mismo ser&aacute; descontado del monto total del pedido.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				AbonarPedidoModal(vFolioPedido);
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}

		});
		return true;
	}
	
		//Aviso de confirmacion para liquidar el pedido.
	function MensajeSmartregresarDetalleInventario() {
		if ($("#check_Liquido").length > 0){
			if ($('#check_Liquido').val() == 0){
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Debe de aprobar que se recibe la mercancia, el pedido fue llevado hoy, tendra que haber recibido la mercancia en este momento</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 6000
				});
				return false;
			}			
		}
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada con el pedido." +
			"<br/>* Se requiere haber recibido la mercancia parcial o total.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				regresarDetalleInventario();
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}

		});
		return true;
	}
	
	//Aviso de eliminacion de articulos de inventario
	function MensajeSmartInventarioDelete(vName) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada al art&iacute;culo.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				deleteInventarioArticulo(vName);
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}

		});
		return true;
	}
	
	
	// Elimina un articulo del inventario.
	function deleteInventarioArticulo(vNombre){
		var vArticulo = vNombre.replace('eliminar_','');
		var bRespuesta = false;
		if (parseInt(vArticulo) > 0) {
			bRespuesta = true;
		}else{
			bRespuesta = false;
		}
		
		var vFuncion = 5;
		if (bRespuesta){
			$.post("./php/inventario.php",
			{
				funcion: vFuncion,
				sku:parseInt(vArticulo)
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					setTimeout(function(){
						window.location.reload();
					}, 2000);
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			});
		}
		
		return true;
	}
	
	
	//Aviso de confirmacion para recibir el abono.
	function MensajeSmartDevolverDeposito(vFolioPedido,vImporte) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada con el pedido." +
			"<br/>* Se requiere haber devuelto el monto del dep&oacute;sito.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				devolverDeposito(vFolioPedido,vImporte);
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}

		});
		return true;
	}
	
	//Devuelve el deposito.
	function devolverDeposito(vFolioPedido,vImporte){
		var vFuncion = 18;
		
		vEmpleado = $("#empleado").val();
		if (vImporte == 0){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>No hay dep&oacute;sito a devolver</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}
		
		
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			data: {funcion: vFuncion,empleado:vEmpleado,iabono:vImporte,foliopedido:vFolioPedido},
			success: function(data){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					//ConsultarFolioPedido();
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					
						if (vFlagReload == 1 ){
							$('#modalDeposito').modal('toggle');
							setTimeout(function(){ 
								window.location.reload();
							}, 2000);						
						}else{
							$('#modalDeposito').modal('toggle');
							setTimeout(function(){ 
								window.history.back();
							}, 2000);
						}
				}else{
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			}
		});
		return true;
	}
	
	
	
	//Aviso de confirmacion para recibir el abono.
	function MensajeSmartEliminarDomicilioCte(vClienteKeyx,vKeyxDir) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada con el domicilio del cliente." +
			"<br/>* Se marcará el domicilio para no considerarse.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				eliminarDomicilio(vClienteKeyx,vKeyxDir);
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}

		});
		return true;
	}
	
	//Devuelve el deposito.
	function eliminarDomicilio(vClienteKeyx,vKeyxDir){
		var vFuncion = 11;
		
		vEmpleado = $("#empleado").val();
	
		//limpiarPedidosTodos();
		$.post("./php/cliente.php",
		{
			funcion: vFuncion,
			clientekeyx:vClienteKeyx,
			direccionkeyx:vKeyxDir
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
				$('#remoteModal').modal('toggle'); 
			}else{
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
	
		return true;
	}
	
	//Valida el enter del grid
	function validaEnter(e,vConsecutivo) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = "1234567890";
		especiales = [8, 37, 46];

		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}
		
		var isDisbled =  $('#notaEspecial_' + vConsecutivo).attr('disabled');
		var vNota = $('#notaEspecial_' + vConsecutivo);
		
		if (key ==13){
			if ((isDisbled == null || isDisbled == false || isDisbled == undefined) && vNota.val() == '')
				vNota.focus();
			else
			{
				if (validaArticulosDuplicadosGrid() && $('#cmbarticulos_' + vConsecutivo).val() != 0)
					$("#agregar_fila").click();
				else
					return false;
			}
			return true;
		}else if(letras.indexOf(tecla) == -1 && !tecla_especial)
			return false;
	}
	
	
	//Validar articulos duplicados en el grid
	function validaArticulosDuplicadosGrid(){
		var bRespuesta = false;
		var vArticulo = 0;
		var vArticulosArray = [];
		var  vConsecutivo = $("#consecutivo").val();
		for (var i = 1; i <= vConsecutivo ; i++) {
				vArticulo = ($('#cmbarticulos_'+i).val() != null)? $('#cmbarticulos_'+i).val():0;
				if (vArticulo == 0){
					$('#cmbarticulos_'+i).focus();
					continue;
				}else if (vArticulosArray.indexOf(vArticulo) == -1 ){
					vArticulosArray [i] = vArticulo;
					bRespuesta = true;
				}else{
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>Art&iacute;culo duplicado, favor de elegir otro!</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
					$('#cmbarticulos_'+i).val(0);
					$('#precio_'+i).val(0);
					$('#cantidad_'+i).val(0);
					$('#subtotal_'+i).val(0);
					$('#notaEspecial_'+i).val(0);
					$('#cmbarticulos_'+i).focus();
					bRespuesta = false;
					break;
				}
					
			}
		return bRespuesta;
	}
	
	//Validar blur
	function validaBlur(vConsecutivo) {
		var isDisbled =  $('#notaEspecial_' + vConsecutivo).attr('disabled');
		var vNota = $('#notaEspecial_' + vConsecutivo);
		
		
		if ((isDisbled == null || isDisbled == false || isDisbled == undefined) && vNota.val() == '')
			vNota.focus();
		else
		{
			if (validaArticulosDuplicadosGrid() && $('#cmbarticulos_' + vConsecutivo).val() != 0)
				return true;
			else
				return false;
		}
		return true;
	}
	
	function getPositionByObjects(obj, key, val) {
		var posicion = -1;
		for(var i = 0; i < obj.length;i++){
			if (obj[i][key].toUpperCase() == val){
				posicion = i;
			}
		}
		return posicion;
	}
	
	
	//Comparacion de fechas.
	function compararFechasInicioMayor(vFechainicio,vFechafin){
		var vFuncion = 19;
		var bRespuesta = false;
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			data: {funcion: vFuncion,fechaanio:vFechainicio,fechames:vFechafin},
			success: function(data){
				objFechas = JSON.parse(data);
				bRespuesta = objFechas['retorno'];
			}
		});
		return bRespuesta;
	}
	
	
	
	//Valida el enter consulta
	function validaEnterConsultar(e,objconsultar) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = "1234567890";
		especiales = [8, 37, 46];

		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}
		
		if (key ==13){
			document.getElementById(objconsultar).click();
			return true;
		}else if(letras.indexOf(tecla) == -1 && !tecla_especial)
			return false;
	}
	
	
	//Aviso de confirmacion realizar el corte de abonos
	function MensajeSmartCorteDescartarModificados() {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar, debiste de haber impreso el reporte?",
			content : "Al realizar la operaci&oacute;n no podrás imprimir el reporte.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				noConsiderarModificados();
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n, no olvides imprimir el reporte.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){ 
					window.location.reload();
				}, 1000);
			}

		});
		return true;
	}
	
	
	function DescartarModificado(ifolioPedido,vSecuencia){
		
		var vFuncion = 20;
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			foliopedido: ifolioPedido,
			empleado:vSecuencia
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				return true;
			}else{
				return false;
			}
		});
	
		return true;
	}
	
	
	//Consultar todos lo pedidos.
	function fn_cortetda_select_paso1(){
		
		var vFuncion = 21;
		if ($("#fechaCorte").val() == 0){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Seleccione una fecha de corte!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vfechaCorte = $("#fechaCorte").val();
			
		}
		
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			data: {funcion:vFuncion,
			fechaanio:vfechaCorte},
			success: function(data){
				objCorte = JSON.parse(data);
				if (objCorte['success'] == true){
					if (objCorte['data'] != ''){
						$("#tbRptCortes").html(objCorte['data']);
						PaginaCortes();
						$("#btnRptEficiencia").attr("disabled","disabled");
					}
				}
			}
		});
		return true;
	}
	
	
	function LiquidarPedido(){
		var vMostrarNota = false;
		var vFuncion = 3;
		var vFolio = $("#foliomodal").html();
		var vEmpleado = $("#idEmpleado").html();
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			data: {funcion: vFuncion,
			foliopedido:$("#foliomodal").html()},
			success: function(data){
				objLiquidar = JSON.parse(data);
				if (objLiquidar['success'] == true){
					//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+objLiquidar['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 3000
					});
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+objLiquidar['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});	
				}
				AbonarPedido(null,vFolio,1,vMostrarNota,vEmpleado);
				LimpiarCapturaPedidoLiberado();
				$('#modalLiquidar').modal('toggle');
				setTimeout(function(){ 
					window.history.back();
				}, 1000);
			}
		});
		return true;
	}
	
	
	//Lanza la orden para regresar los articulos al inventario.
	function regresarArticuloaInventario(vFolioPedido,vId_articulo,vCantidad){
		var vFuncion = 3;
		var bRes = true;
		var bRespuesta = validarArticuloDevolver(vFolioPedido,vId_articulo,vCantidad);
		if (bRespuesta){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/articulos.php",
				data: {
					funcion:vFuncion,
					foliopedido: vFolioPedido,
					id_articulo: vId_articulo,
					cantidad: vCantidad
				},
				success: function(data){
					objLiberaInventario = JSON.parse(data);
					if (objLiberaInventario['success'] == true){
						bRes = true;
					}else{
						bRes = false;
					}
				}
			});
		}
		return bRes;
	}
	
	
	//Restaurar de pedido borrado
	function RestaurarPedidoBorrado(vFolio){
		var vFuncion = 22;
		
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			foliopedido:((parseInt(vFolio) >0)?vFolio:0)
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){
					window.location.href = sUrlRedirected;
					window.location.reload();
				}, 2000);
				
				
			}else{
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
		return true;
	}
	
	
	//Aviso de confirmacion realizar el corte de abonos
	function MensajeSmartRestaurar(vFolio) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar, el pedido se devolvera para se trabajado?",
			content : "Al realizar la operaci&oacute;n, podras volver a recibir abono y mercancia.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				RestaurarPedidoBorrado(vFolio);
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n, no olvides imprimir el reporte.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){ 
					window.location.reload();
				}, 1000);
			}

		});
		return true;
	}
	
	
	
	// Registro de grupos nuevos
	function CreateNvoGrupo(){
	
		var bRespuesta = validarNvaZona();
		var vFuncion = 1;
		if (bRespuesta){
			$.post("./php/gruposinventario.php",
			{
				funcion: vFuncion,
				nombrezona: $("#nombre").val(),
				desczona: $("#descripcion").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					setTimeout(function(){
						window.location.reload();
					}, 2000);
					$("#nombre").focus();
					
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});					
					$("#nombre").focus();
				}
			});
		}
		return true;
	}
	
	
	//Aviso de confirmacion para eliminar o actualizar una zona
	function MensajeSmartGrupoInventario(vGrupo,vOperacion) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada a este grupo de inventario.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				if(vOperacion == 2){
					eliminarGrupoInventario(vGrupo);
				}else if(vOperacion == 4){
					actualizarGrupoInventario(vGrupo)
				}
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}

		});
		return true;
	}
	
	
	
	function eliminarGrupoInventario(vRegion){
		var vFuncion = 2;
		if (vRegion > 0){
			$.post("./php/gruposinventario.php",
			{
				funcion: vFuncion,
				iRegion:vRegion
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
				//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 10000
					});
					setTimeout(function(){
						window.location.reload();
					}, 2000);
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});	
				}
			});
		}else{
			$("#nombre").focus();
		}
		return true;
	}
	
	
	function actualizarGrupoInventario(vRegion){
		var vFuncion = 3;
		var bRespuesta = validarNvaZonaModal(vRegion);
		if (bRespuesta && vRegion > 0){
			$.post("./php/gruposinventario.php",
			{
				funcion: vFuncion,
				iRegion:vRegion,
				nombrezona:$("#nombremodal").val(),
				desczona:$("#descripcionmodal").val()			
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
				//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 10000
					});
					setTimeout(function(){
						window.location.reload();
					}, 2000);
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});	
				}
			});
		}else{
			$("#nombre").focus();
		}
		return true;
	}
	
	
	function grabarGrupoInventarioModal(){
		var bRespuesta = validarInventarioActualizar();
		var vFuncion = 6;
		if (bRespuesta){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/inventario.php",
				data: {
						funcion: vFuncion,
						sku:$("#skuModal").val(),
						grupo:$("#idGrupoInventario").val()
						},
				success: function(data){
					
				}
			});
		}
		
		return true;
	}
	
	function grabarGrupoInventario(){
		var bRespuesta = validarInventarioActualizar();
		var vFuncion = 6;
		if (bRespuesta){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/inventario.php",
				data: {
						funcion: vFuncion,
						sku:$("#sku").val(),
						grupo:$("#idGpoInvent").val()
						},
				success: function(data){
					
				}
			});
		}
		
		return true;
	}
	
	
	
	
	//Consultar todos los articulos  ligados a un pedido asociado con un grupo de inventario.
	function buscarArticulosGrupoInventario(){
		var vFuncion = 4;
		var vMes = []; 
		if ($("#from").val() == ''){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Capture una fecha inicio!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vFechaInicio = $("#from").val();
		}
		if ($("#to").val() == ''){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Captura una fecha final!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vFechaFin = $("#to").val();
		}
		
		$.post("./php/gruposinventario.php",
		{
			funcion: vFuncion,
			//grupo:vGrupo,
			fecha1:vFechaInicio,
			fecha2:vFechaFin
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$("#tBodyRpt").html('');
				if (obj['data'].length > 0){
					$("#tBodyRpt").html(obj['data']);
					PaginaEficiencia();
					buscarTotalesEficiencia();
					$("#btnRptEficiencia").attr("disabled","disabled");
					
				}else{
					$("#btnRptEficiencia").attr("disabled","disabled");
					$("#tBodyRpt").html('');
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>No se encontr&oacute; informaci&oacute;n en los criterios seleccionados!.</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});					
				}
			}else{
				$("#btnRptEficiencia").attr("disabled","disabled");
				$("#tBodyRpt").html('');
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
	
		return true;
	}
	
	
	
	//Enviar email de pedido
	function enviarMail(vFolio){
		var vFuncion = 23;
		var vEmailAddress = $('#email').val();
		if (isValidEmailAddress(vEmailAddress) && vEmailAddress != ''){
			$.post("./php/pedidos.php",
			{
				funcion: vFuncion,
				foliopedido:((parseInt(vFolio) >0)?vFolio:0),
				email:vEmailAddress
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['codigo'] == true){
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['mensaje']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
				}else{
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}			
			});
		}
		return true;
	}
	
	
	function validarCorreo(){
		var bRespuesta = false;
		var vEmail = $('#email').val();
		if (!isValidEmailAddress(vEmail) && vEmail != ''){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>El email capturado no es v&aacute;lido por lo que requiere capturar uno correcto.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-check fa-2x fadeInRight animated",
				timeout : 4000
			});
			$("#email").focus();
			bRespuesta =true;
		}
		return bRespuesta;
	}
	
	function recordatorioEnvioMercancia(vFechaPedido){
		var bRespuesta = false;
		var vFolioPedido = $('#folio').val();
		var vFuncion = 24;
		if (vFolioPedido != ''){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/pedidos.php",
				data: {	funcion: vFuncion,
						foliopedido:((parseInt(vFolioPedido) >0)?vFolioPedido:0)
					},
				success: function(data){
					objEnviarHoy = JSON.parse(data);
					if (objEnviarHoy['success'] == true){					
						$.SmartMessageBox({
							title : "<h3>El folio #"+ vFolioPedido + " se debe enviar el d&iacute;a de hoy</h3>"  ,
							content : "<h4>¿Quieres ver el resto de folios capturados hoy con fecha de entrega hoy mismo?</h4><p class='text-align-left'>",
							buttons : '[Ver]'
						}, function(ButtonPressed) {
							if (ButtonPressed === "Ver") {
								window.location.href='#ajax/capturadoeneldiamismodia.php?fc=' + vFechaPedido;
								window.location.reload();
							}/*
							if (ButtonPressed === "No") {
								window.location.href = sUrlRedirected;
								window.location.reload();
							}*/
						});
					}else{
						//sUrlRedirected = urlAbono;
						window.location.href = sUrlRedirected;
						window.location.reload();						
					}
					bRespuesta =objEnviarHoy['success'];
				}
			});
		}		
		return bRespuesta;
	}
	
	
	function sumarDiasaFecha(vDias,vFechaPedido){
		var bRespuesta = '1900-01-01';
		var vFuncion = 25;
		if (vFechaPedido != '' && vDias > 0){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/pedidos.php",
				data: {	funcion: vFuncion,
						fechames: vDias,
						fechaanio:vFechaPedido
					},
				success: function(data){
					objFecha = JSON.parse(data);
					if (objFecha['success'] == true){
						if (objFecha['data'] != ''){
							bRespuesta = objFecha['data'];
						}
					}
					
				}
			});
		}
		return bRespuesta;
	}
	
	function cambiarFechaRecoleccion(){
		vFechaEntrega = $('#fechaentrega').val();
		vFechaSumada = sumarDiasaFecha(1,vFechaEntrega);
		$('#fecharecolectar').val(vFechaSumada);
		return true;
	}
	
	//Comparacion de fechas.
	function ValidarSiLaFechaEsHoy(vFechainicio,vFechafin){
		var vFuncion = 26;
		var bRespuesta = false;
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			data: {funcion: vFuncion,fechaanio:vFechainicio,fechames:vFechafin},
			success: function(data){
				objFechas = JSON.parse(data);
				bRespuesta = objFechas['data'];
			}
		});
		return bRespuesta;
	}
	
	
	function registrarVOBO(vValor){
		if (vValor == 0){
			$("#check_Liquido").val(1);
			$("#lbl_Liquido").html('No aprobar');
		}else{
			$("#check_Liquido").val(0);
			$("#lbl_Liquido").html('Aprobar');
		}
		
		return true;
	}
	
	
	
	//Aviso de confirmacion realizar el corte de abonos
	function MensajeSmartRevertirFolioLiberado(vFolio) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar, el pedido se revertir&aacute; a pendiente?",
			content : "Al realizar la operaci&oacute;n, podras volver a recibir abono y mercancia.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				RevertirPedidoFinalizado(vFolio);
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
		return true;
	}
	
	
	//Restaurar de pedido borrado
	function RevertirPedidoFinalizado(vFolio){
		var vFuncion = 27;
		
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			data: {funcion: vFuncion,foliopedido:((parseInt(vFolio) >0)?vFolio:0)},
			success: function(data){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					//ConsultarFolioPedido();
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					
					setTimeout(function(){ 
						window.location.reload();
					}, 2000);						
				}else{
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			}
		});
		return true;
	}
	
	
	//Restaurar abono de pedido
	function RevertirAbonoaFolio(vFolio){
		var vFuncion = 28;
		
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			data: {funcion: vFuncion,foliopedido:((parseInt(vFolio) >0)?vFolio:0)},
			success: function(data){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					//ConsultarFolioPedido();
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					
					setTimeout(function(){ 
						window.location.reload();
					}, 2000);						
				}else{
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			}
		});
		return true;
	}
	
	
	//Aviso de confirmacion realizar el corte de abonos
	function MensajeSmartRevertirAbonoaFolio(vFolio) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar, el pedido se revertir&aacute; a pendiente?",
			content : "Al realizar la operaci&oacute;n, podras volver a recibir abono y mercancia.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				RevertirAbonoaFolio(vFolio);
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
		return true;
	}
	
	
	//Enviar email de listado de precios
	function enviarMailListadoPrecios(){
		var vFuncion = 7;
		var vEmailAddress = $('#email').val();
		if (isValidEmailAddress(vEmailAddress) && vEmailAddress != ''){
			$('#btnEnviarPrecios').attr('disabled','disabled');
			$.post("./php/inventario.php",
			{
				funcion: vFuncion,
				//foliopedido:((parseInt(vFolio) >0)?vFolio:0),
				email:vEmailAddress
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['codigo'] == true){
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['mensaje']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					window.location.href = './#ajax/dashboard.php';
				}else{
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
					$('#btnEnviarPrecios').removeAttr('disabled');
					$('#email').focus();
				}			
			});
		}else{
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Correo no v&aacute;lido, favor de capturar uno nuevamente</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			$('#btnEnviarPrecios').removeAttr('disabled');
			$('#email').focus();
		}
		return true;
	}
	
		//Grabar datos fiscales de cliente.
	function grabarDatosFiscales(){
		var vColonia = '';
		var vNumColonia = $("#Colonia").val().split(' - ');
		var bRespuesta = validarConsultarColonias2(vNumColonia);
		if(vNumColonia[0] !== '' && vNumColonia.length == 1){
			$("#Colonia").focus();
			bRespuesta =true;
		}else if ($("#iCliente").val() == ''){
			$("#iCliente").focus();
			bRespuesta =false;
		}else if($("#tRazon").val()==''){
			$("#tRazon").focus();
			bRespuesta =false;
		}else if($("#iRFC").val() == ''){
			$("#iRFC").focus();
			bRespuesta =false;
		}else if($("#Calle").val()==''){
			$("#Calle").focus();
			bRespuesta =false;
		}else if($("#nExterior").val()==''){
			$("#nExterior").focus();
			bRespuesta =false;
		}else if($("#tCodigoPostal").val() ==''){
			$("#tCodigoPostal").focus();
			bRespuesta =false;
		}else if(vNumColonia[1] == '' && vNumColonia.length >= 2){
			$("#Colonia").focus();
			bRespuesta =false;
		}else if($("#tMunicipio").val()== ''){
			$("#tMunicipio").focus();
			bRespuesta =false;
		}else if($("#tEstado").val() == ''){
			$("#tEstado").focus();
			bRespuesta =false;
		}
		
		if (vNumColonia.length >= 2){
			vColonia = vNumColonia[1];
		}else if(vNumColonia.length == 1){
			vColonia = vNumColonia[0];
		}
		
		var vFuncion = 13;
		if (bRespuesta){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/cliente.php",
				data: {
						funcion: vFuncion,
						cliente:$("#iCliente").val(),
						razonsocial:$("#tRazon").val(),
						rfc:$("#iRFC").val(),
						calle:$("#Calle").val(),
						numext:$("#nExterior").val(),
						numint:$("#nInterior").val(),
						CodigoPostal:$("#tCodigoPostal").val(),
						Colonia:vColonia,
						municipio:$("#tMunicipio").val(),
						estado:$("#tEstado").val()
						},
				success: function(data){
					obj = JSON.parse(data);
					if (obj['success'] == true){
						//Exito
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						
						window.location.href = "#ajax/reportes_finalizadosafacturar.php";
					}else{
						//Falla
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});
						$("#iRFC").focus();
					}
				}
			});
		}else{
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Campos incompletos!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			$("#iRFC").focus();
		}
		return true;
	}
	
	
	function LimpiarDatosFiscales(){
		//$('#iCliente').val('');
		//$('#tCliente').val('');
		$('#iRFC').val('');
		$('#tRazon').val('');
		$('#Calle').val('');
		$('#nInterior').val('');
		$('#nExterior').val('');
		$('#tCodigoPostal').val('');
		$('#Colonia').val('');
		$('#tMunicipio').val('');
		$('#tEstado').val('');
		$('#iRFC').focus();
		return true;
	}
	
	
	//Aviso de confirmacion para recibir el abono.
	function MensajeSmartEliminarDatosFiscales(vCliente,vKeyx) {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada con datos fiscales del cliente." +
			"<br/>* Se eliminar&aacute; la informaci&oacute;n.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				eliminarDatosFiscales(vCliente,vKeyx);
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}

		});
		return true;
	}
	
	
	//Devuelve el deposito.
	function eliminarDatosFiscales(vCliente,vKeyx){
		var vFuncion = 14;
		var bRespuesta = false;
		if (vCliente <= 0 || vKeyx <= 0){
			bRespuesta = false;
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i> Error al eliminar los datos fiscales del cliente!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
		}else{bRespuesta = true;}
		
		
		if (bRespuesta){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/cliente.php",
				data: {
						funcion: vFuncion,
						cliente:vCliente,
						direccionkeyx:vKeyx
						},
				success: function(data){
					obj = JSON.parse(data);
					if (obj['success'] == true){
						//Exito
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						window.location.reload();
					}else{
						//Falla
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});
						$("#iRFC").focus();
					}
				}
			});
		}
	
		return true;
	}
	
	
	//Aviso de confirmacion facturados a descartar
	function MensajeSmartCorteDescartarFacturados() {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar, debiste de haber generado la factura de cada uno de ellos?",
			content : "Al realizar la operaci&oacute;n no aparecerá el pedido pendiente de factura.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				noConsiderarFacturados();
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n, no olvides imprimir el reporte.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){ 
					window.location.reload();
				}, 1000);
			}

		});
		return true;
	}
	
	
	function DescartarFacturado(ifolioPedido){
		
		var vFuncion = 29;
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			foliopedido: ifolioPedido
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				return true;
			}else{
				return false;
			}
		});
	
		return true;
	}
	
	
	//Aviso de confirmacion a entregados hoy descartar
	function MensajeSmartCorteDescartarEntregadosParaHoy() {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar, debiste de haber enviado el pedido?",
			content : "Al realizar la operaci&oacute;n no aparecerá como pedido pendiente de envío.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				noConsiderarEntregados();
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n, no olvides imprimir el reporte.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){ 
					window.location.reload();
				}, 1000);
			}

		});
		return true;
	}
	
	
	function DescartarEntregados(ifolioPedido){
		
		var vFuncion = 30;
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			foliopedido: ifolioPedido
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				return true;
			}else{
				return false;
			}
		});
	
		return true;
	}
	
	
	//Aviso de confirmacion a descuento automatico
	function MensajeSmartCorteDescuentoAutomatico() {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar, le aplicarás el descuento automático?",
			content : "Al realizar la operaci&oacute;n no preguntará y te dará el descuento máximo permitido.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				recorreGridDescuentoAutomatico();
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n, no olvides imprimir el reporte.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){ 
					window.location.reload();
				}, 1000);
			}

		});
		return true;
	}
	
	function AplicarlesDescuentoAutomatico(iCliente,iFlagDescuentoAutomatico){
		
		var vFuncion = 15;
		$.post("./php/cliente.php",
		{
			funcion: vFuncion,
			cliente: iCliente,
			flag_descuentoautomatico: iFlagDescuentoAutomatico
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				return true;
			}else{
				return false;
			}
		});
	
		return true;
	}
	
	
	function MoverMouse(event){
		/*var canvas = document.getElementById('folio');
		canvas.requestPointerLock = canvas.requestPointerLock || canvas.mozRequestPointerLock || canvas.webkitRequestPointerLock;
		canvas.requestPointerLock();	*/
	}
	
	
	//Consultar todos lo pedidos.
	function BuscarPedidos3MesesAtras(){
		$("#btnBuscarPedidos3MesesAtras").attr("disabled","disabled");
		var vFuncion = 31;	
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				if (obj['data'].length > 0){
					$("#tBodyRpt").html(obj['data']);
					Pagina();
					$("#btnBuscarPedidos3MesesAtras").attr("disabled","disabled");
				}else{
					$("#tBodyRpt").html(obj['data']);
					$("#tBodyRpt").html('');
					Pagina();
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
					$("#btnBuscarPedidos3MesesAtras").removeAttr("disabled");
				}
				
			}else{
				$("#tBodyRpt").html(obj['data']);
				$("#tBodyRpt").html('');
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
		});
	
		return true;
	}
	
	
	function redirectModificarRFC(vNumCte,vKeyx){
		$('#remoteModal').modal('toggle');
		setTimeout(function(){
			window.location.href="#ajax/modal_clientes.php?ct="+ vNumCte ;
		}, 1000);
		
		return true;
	}
	
	function RedirectPage(vPage){
		window.location.href=vPage;
		return true;
	}
	
	
	function ReenviarEmailPedido(vFolioPedido){
		
		var vFuncion = 32;
		var vEmailAddress = $('#email').val();
		if (isValidEmailAddress(vEmailAddress) && vEmailAddress != ''){
			$.post("./php/pedidos.php",
			{
				funcion: vFuncion,
				foliopedido:((parseInt(vFolioPedido) >0)?vFolioPedido:0),
				email:vEmailAddress
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['codigo'] == true){
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['mensaje']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					window.location.href = './#ajax/dashboard.php';
				}else{
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}			
			});
		}
		return true;
	}
	
	function cambiarValorComision(vValor,vModifica){
		if (vValor == 0){
			$("#check_Comision").val(1);
			$("#lblComision").html('Incluir');
			$("#PorcentajeDescuento").val('0');
			$("#PorcentajeDescuento").attr('disabled','disabled');
			$("#num_clientecomision").removeAttr('disabled');
			$("#nom_clientecomision").html('');
			$("#num_clientecomision").focus();
			
		}else{
			$("#check_Comision").val(0);
			$("#lblComision").html('No incluir');
			$("#PorcentajeDescuento").val('0');
			$("#PorcentajeDescuento").removeAttr('disabled');
			$("#num_clientecomision").val('0');
			$("#nom_clientecomision").html('');
			$("#num_clientecomision").attr('disabled','disabled');
			$("#PorcentajeDescuento").focus();
		}
		
		if(vModifica == 0){
			CalcularSaldoPedido();			
		}else{
			CalcularSaldoPedidoModifica();
		}
		
		return true;
	}
	
	
	//Validar Telefono keyx
	function ConsultarCteKeyxComision(){
		var vFuncion = 12;
		if ($("#num_clientecomision").val()> 0){
			$.post("./php/cliente.php",
			{
				funcion:vFuncion,
				clientekeyx: $("#num_clientecomision").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						$('#num_clientecomision').val(obj['data']['keyx']);
						$('#nom_clientecomision').html(obj['data']['nombres'] + ' ' + obj['data']['apellidos'] );
					}else{
						$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
						});
						$("#num_clientecomision").val('');
						$("#num_clientecomision").focus();
					}
				}else{
					$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
					});
					$("#num_clientecomision").val('');
					$("#num_clientecomision").focus();
				}
			});
		}else{
			$.smallBox({
			title : "Aviso",
			content : "<i class='fa fa-clock-o'></i> <i> Proporciona un n&uacute;mero de cliente.</i>",
			color : "#C46A69",
			iconSmall : "fa fa-times fa-2x fadeInRight animated",
			timeout : 4000
			});
			$("#num_clientecomision").val('');
			$("#num_clientecomision").focus();
		}
		return true;
	}
	
	
	
	function grabarComisiones(){
		var bRespuesta = false;
		var vFolioPedido = $('#folio').val();
		var vComision = $("#check_Comision").val();
		var vCliente = $("#num_clientecomision").val();
		
		
		if (vFolioPedido != '' && vComision == 1 && vCliente > 0){
			var vFuncion = 33;
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/pedidos.php",
				data: {	funcion: vFuncion,
						foliopedido:((parseInt(vFolioPedido) >0)?vFolioPedido:0),
						keyx:vCliente
					},
				success: function(data){
					objComision = JSON.parse(data);
					if (objComision['success'] == true){					
						console.log(objComision['data']);
					}else{
						console.log(objComision['data']);
					}
					bRespuesta =objComision['success'];
				}
			});
		}else{
			var vFuncion = 34;
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/pedidos.php",
				data: {	funcion: vFuncion,
						foliopedido:((parseInt(vFolioPedido) >0)?vFolioPedido:0)
					},
				success: function(data){
					objComision = JSON.parse(data);
					if (objComision['success'] == true){					
						console.log(objComision['data']);
					}else{
						console.log(objComision['data']);
					}
					bRespuesta =objComision['success'];
				}
			});
		}		
		return bRespuesta;
	}
	
	
	
	
	function consultaComisiones(){
		var bRespuesta = false;
		var vFolioPedido = $('#folio').val();	
		
		if (vFolioPedido != ''){
			var vFuncion = 35;
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/pedidos.php",
				data: {	funcion: vFuncion,
						foliopedido:((parseInt(vFolioPedido) >0)?vFolioPedido:0)
					},
				success: function(data){
					objComision = JSON.parse(data);
					if (objComision['success'] == true){					
						if (objComision['data'] !== ''){
							$("#check_Comision").click();
							$('#num_clientecomision').val(objComision['data']['num_clientecomision']);
							ConsultarCteKeyxComision();
						}
					}else{
						console.log(objComision['data']);
					}
					bRespuesta =objComision['success'];
				}
			});
		}
	}
	
	
	
	
	
	//Aviso de confirmacion a entregados hoy descartar
	function MensajeSmartComisionPagada() {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar, debiste de haber enviado pagado la comision del cliente?",
			content : "Al realizar la operaci&oacute;n no aparecerá como pedido pendiente de pago de comision",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				noConsiderarComisiones();
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n, no olvides imprimir el reporte.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){ 
					window.location.reload();
				}, 1000);
			}

		});
		return true;
	}
	
	
	
	function ComisionPagada(ifolioPedido){
		
		var vFuncion = 36;
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			foliopedido: ifolioPedido
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				return true;
			}else{
				return false;
			}
		});
	
		return true;
	}
	
	
	
	//Validar Telefono keyx
	function ConsultarListadoClientes(){
		var vFuncion = 16;
		$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/cliente.php",
				dataType:'json',
				data: { funcion:vFuncion }
				,success: function(data){
					obj = JSON.parse(data);
					if (obj['success'] == true){
						$('#tbodyClientes').html(obj['data']);
					}else{
						return false;
					}
				}
			});
		return true;
	}
	
	function consultarPerfiles(){
		var vFuncion = 6;
		
		$.post("./php/usuarios.php",
		{
			funcion: vFuncion
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$("#empleados").html('');
				$("#empleados").append(obj['data']);
			}
		});
		return true;
	}
	
	
	function obtenerFolioOrden(){
		var vFuncion = 1;
		$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/ventas.php",
				dataType:'json',
				data: { funcion:vFuncion }
				,success: function(data){
					//obj = JSON.parse(data);
					obj = data;
					if (obj['success'] == true){
						$('#folio').val(obj['data']['retorno']);
					}else{
						return false;
					}
				}
			});
		return true;
	}
	
	
	function consultaUnUsuario(vKeyx){
		var vFuncion = 5;
		$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/usuarios.php",
				dataType:'json',
				data: { funcion: vFuncion,keyx:vKeyx}
				,success: function(data){
					obj = data;
					if (obj['success'] == true){
						vId_puesto = data['data']['id_puesto'];
						vKeyx = data['data']['keyx'];
						$('#empleado').val(vId_puesto);
					}
				}
			});
		return true;
	}
	
	
	function consultarComboUsuarios(){
		var vFuncion = 7;
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/usuarios.php",
			dataType:'json',
			data: { funcion: vFuncion,keyx:vKeyx}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$("#empleado").html('');
					$("#empleado").append(obj['data']);
				}
			}
		});
		return true;
	}
	
	
	function cmbArticulosExistencia()
	{
		var vFuncion = 1;
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			dataType:'json',
			data: { funcion: vFuncion}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					listInventario = obj['data'];
					$("#cmbarticulos_1").html('');
					$("#cmbarticulos_1").append(obj['data']);
				}
			}
		});
		return true;
	}
	
	
	function cmbTipoPago()
	{
		var vFuncion = 2;
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			dataType:'json',
			data: { funcion: vFuncion}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$("#idTipoPago").html('');
					$("#idTipoPago").append(obj['data']);
					$("#idTipoPago").val(1);
					cmbPlazo(1);
					$("#idPlazo").change();
					cmbPeriodoCobro(1);
					$("#idCobrarCada").change();
				}
			}
		});
		return true;
	}
	
	function llenarcmbPlazoYCobro(vTipoPago)
	{
		cmbPlazo(vTipoPago);
		cmbPeriodoCobro(vTipoPago);
		modificarFechaVencimiento();
		return true;
	}
	
	
	function cmbPlazo(vTipoPago)
	{
		var vFuncion = 3;
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			dataType:'json',
			data: { funcion: vFuncion,tipopago:vTipoPago}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$("#idPlazo").html('');
					$("#idPlazo").append(obj['data']);
					$("#idPlazo").val(1);
				}
			}
		});
		modificarFechaVencimiento();
		return true;
	}
	
	
	function cmbPeriodoCobro(vTipoPago)
	{
		var vFuncion = 4;
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			dataType:'json',
			data: { funcion: vFuncion,tipopago:vTipoPago}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$("#idCobrarCada").html('');
					$("#idCobrarCada").append(obj['data']);
					$("#idCobrarCada").val(1);
				}
			}
		});
		return true;
	}
	
	
	function variables_select(vKeyx,vEmpresa)
	{
		var vRespuesta = '{}';
		var vFuncion = 5;
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			dataType:'json',
			data: { funcion: vFuncion,keyx:vKeyx,empresa:vEmpresa}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					vRespuesta = obj['data'];
				}
			}
		});
		return vRespuesta;
	}
	
	
	function modificarFechaVencimiento()
	{
		var vRespuesta = true;
		var vFuncion = 7;
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			dataType:'json',
			data: { funcion: vFuncion,tipopago:$('#idTipoPago').val(),plazo:$('#idPlazo').val(),keyx:vDiasProximoCobro}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$('#fechavence').val(obj['data']['fechavence']); 
				}
			}
		});
		return vRespuesta;
	}
	
	
	//Consultar los articulos del pedido y su stock
	function consultarArticuloElegido(vKeyx,vConsecutivo){
		var vFuncion = 6;
		if (vKeyx > 0){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/pedidos.php",
				dataType:'json',
				data: { funcion: vFuncion,keyx:vKeyx}
				,success: function(data){
					obj = data
					if (obj['success'] == true){
						if (obj['data'] != ''){
							$('#precio_'+vConsecutivo).val(obj['data']['costo_venta']);
							$('#hidcantidad_'+vConsecutivo).val(obj['data']['existencia']);
							if($('#precio_'+vConsecutivo).val() <= 0){
								$.smallBox({
									title : "Aviso",
									content : "<i class='fa fa-clock-o'></i> <i>Verificar el precio del articulo</i>",
									color : "#C46A69",
									iconSmall : "fa fa-times fa-2x fadeInRight animated",
									timeout : 4000
								});
								setTimeout(function(){ 
									$("#cmbarticulos_"+ vConsecutivo).select2('focus');
									$("#cmbarticulos_"+ vConsecutivo).focus();
									$("#cmbarticulos_"+ vConsecutivo).select2('open');								
								}, 50);
							}else if((parseInt($('#hidcantidad_'+vConsecutivo).val()) > 0)){
								$('#cantidad_'+vConsecutivo).val(1);
							}else{
								$.smallBox({
									title : "Aviso",
									content : "<i class='fa fa-clock-o'></i> <i>No cuenta con existencia, para la venta</i>",
									color : "#C46A69",
									iconSmall : "fa fa-times fa-2x fadeInRight animated",
									timeout : 4000
								});
								setTimeout(function(){ 
									$("#cmbarticulos_"+ vConsecutivo).select2('focus');
									$("#cmbarticulos_"+ vConsecutivo).select2('open');									
								}, 50);
								
							}
							var subtotal = $('#cantidad_'+vConsecutivo).val() * $('#precio_'+vConsecutivo).val();
							$('#subtotal_'+vConsecutivo).val(subtotal);
							$('#cantidad_'+vConsecutivo).focus();
						}
					}
				}
			});
		}
		return true;
	}
	
	
	function grabadoReferenciasPedido(bFolioPedido,iNumReferencia,vNombre,vTelefono,vDomicilio)
	{
		var vRespuesta = true;
		var vFuncion = 8;
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			dataType:'json',
			data: { funcion: vFuncion,foliopedido:bFolioPedido,numreferencia:iNumReferencia,nombre:vNombre,telefono:vTelefono,domicilio:vDomicilio}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){

				}
			}
		});
		return vRespuesta;
	}
	
	
	function pedidoGrabarReferencias(){
		var bFolioPedido = $('#folio').val()
		
		var vNombreEsposo 	= $('#idReferenciaEsposo').val();
		var vTelefonoEsposo = $('#idTelEsposo').val();
		var vDomicilioEsposo = $('#idDomicilioEsposo').val();
		grabadoReferenciasPedido(bFolioPedido,1,vNombreEsposo,vTelefonoEsposo,vDomicilioEsposo);
		
		var vNombreFamiliar 	= $('#idReferenciaFamiliar').val();
		var vTelefonoFamiliar = $('#idTelFamiliar').val();
		var vDomicilioFamiliar = $('#idDomicilioFamiliar').val();
		grabadoReferenciasPedido(bFolioPedido,2,vNombreFamiliar,vTelefonoFamiliar,vDomicilioFamiliar);
		
		var vNombreAval 	= $('#idReferenciaAval').val();
		var vTelefonoAval 	= $('#idTelAval').val();
		var vDomicilioAval 	= $('#idDomicilioAval').val();
		grabadoReferenciasPedido(bFolioPedido,3,vNombreAval,vTelefonoAval,vDomicilioAval);
		return true;
	}
	
	
	//Registrar pedido nuevo
	function pedidoGrabarPedido(vCtekeyx,vDireckeyx){
		var vMostrarNota = true;
		//var vFuncion = 7;
		var vFolioPedido = $("#folio").val();
		//var vEmpleado = $("#empleado option:selected").html();
		if ($("#empleado").val() == 0){
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Se requiere seleccionar un empleado a ligarlo a este pedido. </i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			$("#empleado").focus();
			return false;
		}
			
		var bRespuesta = validarPedidoNuevo();
			
		if (bRespuesta){
		var vFuncion = 7;
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/cliente.php",
				dataType:'json',
				data: {
					//foliopedido,tipopago, plazo, periodocobro, num_cliente, domicilio,empleado,supervisor,gerente,fechapedido,primercobro,fechavencimiento
					funcion:vFuncion,
					foliopedido: vFolioPedido,
					tipopago:$('#idTipoPago').val(),
					plazo:$('#idPlazo').val(),
					periodocobro:$('#idCobrarCada').val(),
					clientekeyx:  vCtekeyx,
					direccionkeyx:  vDireckeyx,
					empleado:$("#idVendedor").val(),
					supervisor:$("#idSupervisor").val(),
					gerente:$("#empleado").val(),
					fechaentrega: $("#fechaentrega").val(),
					fecharecolecta: $("#fecharecolectar").val(),
					fechavence: $("#fechavence").val(),
					numreferencias: vFolioPedido,
					num_contrato:$("#idContrato").val(),
					num_papeleta:$("#idPapeleta").val(),
					num_descuento:$("#idDescuento").val()

				},success: function(data){
					obj = data;
					if (obj['success'] == true){
						//if (obj['data'] != ''){
							//Exito
							$("#btnGrabarPedido").attr("disabled","disabled");
							$.smallBox({
								title : "Aviso",
								content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
								color : "#659265",
								iconSmall : "fa fa-check fa-2x fadeInRight animated",
								timeout : 4000
							});
							/*var vFolioPedido = parseInt($("#folio").val());
							enviarMail(vFolioPedido);*/
							
							abonarPagoContado();
							
							window.location.href = '#ajax/imprimir_comprobantepedido.php?f='+$("#folio").val() ;
					}else{
						$("#btnGrabarPedido").removeAttr("disabled");
						//Falla
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});					
					}
				
				}
			});
		}else{
			$("#btnGrabarPedido").removeAttr("disabled");
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i> Fall&oacute al registrar el pedido!. </i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
		}
		return bRespuesta;
	}
	
	function abonarPagoContado() {
		var parametros = {};
		if ($('#idTipoPago').val() == 1){
			parametros.pago_completo = 1;
		}else{
			//parametros.pago_completo = 0;
			return true;
		}
		parametros.idFolioPedido = $("#folio").val();
		var vMontoTotal = parseInt($("#total").html())* 0.5;
		var vMontoDescuento = parseInt($("#total").html()) * parseFloat($("#idDescuento").val());
		
		parametros.abono_propuesto = $("#total").html();
		parametros.descuento = $("#Descto").html();
		parametros.cobrador = $('#empleado option:selected').html();
		//$query = "select * from fn_ctl_abonos_insert(".$request['idFolioPedido']."::bigint,".$_SESSION['keyx']."::bigint,".$request['abono_propuesto']."::float,'".$request['cobrador']."'::varchar,".$request['pago_completo']."::smallint);";
		var url = "./php/abonos.php";    
		var response;
		parametros.categoria = "PAGO_CONTADO_FACTURA";
		response = callAjax(parametros, url);
		if(response.success == true && parametros.pago_completo == 1){
			showMessageSuccess('Confirmacion','Alta de abonos satisfactoria!!');
		}else if(response.success == true && parametros.pago_completo == 0){

		  $.smallBox({
			title : 'Confirmacion',
			content : "<i class='fa fa-clock-o'></i> <i>Abono realizado satisfactoriamente!!</i>",
			color : "#659265",
			iconSmall : "fa fa-check fa-2x fadeInRight animated",
			timeout : 4000
		  });
		  //editAbonos(id);
		  //llenarGridAbonos(id);
		  //llenarGridFactuasPendientes();
		}else{
		  showMessageError(response.error);
		}
	}
	
	function cmbVendedor()
	{
		var vRespuesta = true;
		var vFuncion = 9;
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			dataType:'json',
			data: { funcion: vFuncion}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$("#idVendedor").html('');
					$("#idVendedor").append(obj['data']);
					$("#idVendedor").val(0);
				}
			}
		});
		return vRespuesta;
	}
	
	function cmbSupervisor()
	{
		var vRespuesta = true;
		var vFuncion = 10;
		$.ajax(
		{
			async:false,
			cache:false,
			type:'POST',
			url:"./php/pedidos.php",
			dataType:'json',
			data: { funcion: vFuncion}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$("#idSupervisor").html('');
					$("#idSupervisor").append(obj['data']);
					$("#idSupervisor").val(0);
				}
			}
		});
		return vRespuesta;
	}
	
	
	
	function verFacturadosHoy()
	{
		var vRespuesta = true;
		var vFuncion = 1;
		$.ajax(
		{
			async:true,
			cache:false,
			type:'POST',
			url:"./php/reportes.php",
			dataType:'json',
			data: { funcion: vFuncion}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$("#tBodyRpt").append(obj['data']);
				}
			}
		});
		return vRespuesta;
	}
	
	function verCancelaciones()
	{
		var vRespuesta = true;
		var vFuncion = 2;
		$.ajax(
		{
			async:true,
			cache:false,
			type:'POST',
			url:"./php/reportes.php",
			dataType:'json',
			data: { funcion: vFuncion}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$("#tBodyRpt").append(obj['data']);
				}
			}
		});
		return vRespuesta;
	}
	
	//Consultar facturados periodo
	function buscarFacturadosPeriodo(){
		
		var vFuncion = 3;
			
		if ($("#from").val() == ''){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Capture una fecha inicio!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vFechaInicio = $("#from").val();
		}
		if ($("#to").val() == ''){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Captura una fecha final!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vFechaFin = $("#to").val();
		}
		
		$('#idDel').html('DEL ' + vFechaInicio);
		$('#idAl').html(' AL ' +vFechaFin);
		
		$('#idDelEnc').html('DEL ' + vFechaInicio);
		$('#idAlEnc').html(' AL ' +vFechaFin);
		
		$.ajax(
		{
			async:true,
			cache:false,
			type:'POST',
			url:"./php/reportes.php",
			dataType:'json',
			data: { 
				funcion: vFuncion,
				fechainicio:vFechaInicio,
				fechafin:vFechaFin
			}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$("#tBodyRpt").html('');
					if (obj['data'].length > 0){
						//pageSetUp();
						$("#tBodyRpt").html(obj['data']);
						PaginarFacturadosPeriodos();
						//buscarTotalesEficiencia();
						$("#btnRptEficiencia").attr("disabled","disabled");
						
					}else{
						$("#btnRptEficiencia").attr("disabled","disabled");
						$("#tBodyRpt").html('');
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>No se encontr&oacute; informaci&oacute;n en los criterios seleccionados!.</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});					
					}
				}else{
					$("#btnRptEficiencia").attr("disabled","disabled");
					$("#tBodyRpt").html('');
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			}
		});
		return true;
	}
	
	
	//Consultar facturados periodo
	function buscarCancelacionesPeriodo(){
		
		var vFuncion = 4;
			
		if ($("#from").val() == ''){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Capture una fecha inicio!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vFechaInicio = $("#from").val();
		}
		if ($("#to").val() == ''){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Captura una fecha final!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vFechaFin = $("#to").val();
		}
		
		$('#idDel').html('DEL ' + vFechaInicio);
		$('#idAl').html(' AL ' +vFechaFin);
		
		$('#idDelEnc').html('DEL ' + vFechaInicio);
		$('#idAlEnc').html(' AL ' +vFechaFin);
		
		$.ajax(
		{
			async:true,
			cache:false,
			type:'POST',
			url:"./php/reportes.php",
			dataType:'json',
			data: { 
				funcion: vFuncion,
				fechainicio:vFechaInicio,
				fechafin:vFechaFin
			}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$("#tBodyRpt").html('');
					if (obj['data'].length > 0){
						//pageSetUp();
						$("#tBodyRpt").html(obj['data']);
						PaginarCancelacionesPeriodos();
						//buscarTotalesEficiencia();
						$("#btnRptEficiencia").attr("disabled","disabled");
						
					}else{
						$("#btnRptEficiencia").attr("disabled","disabled");
						$("#tBodyRpt").html('');
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>No se encontr&oacute; informaci&oacute;n en los criterios seleccionados!.</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});					
					}
				}else{
					$("#btnRptEficiencia").attr("disabled","disabled");
					$("#tBodyRpt").html('');
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			}
		});
		return true;
	}
	
	
	
	//Consultar facturados periodo
	function buscarComisionesPagadasPeriodo(){
		
		var vFuncion = 5;
			
		if ($("#from").val() == ''){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Capture una fecha inicio!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vFechaInicio = $("#from").val();
		}
		if ($("#to").val() == ''){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Captura una fecha final!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vFechaFin = $("#to").val();
		}
		
		$('#idDel').html('DEL ' + vFechaInicio);
		$('#idAl').html(' AL ' +vFechaFin);
		
		$('#idDelEnc').html('DEL ' + vFechaInicio);
		$('#idAlEnc').html(' AL ' +vFechaFin);
		
		$.ajax(
		{
			async:true,
			cache:false,
			type:'POST',
			url:"./php/reportes.php",
			dataType:'json',
			data: { 
				funcion: vFuncion,
				fechainicio:vFechaInicio,
				fechafin:vFechaFin
			}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$("#tBodyRpt").html('');
					if (obj['data'].length > 0){
						//pageSetUp();
						$("#tBodyRpt").html(obj['data']);
						PaginarComisionesPagadasPeriodo();
						//buscarTotalesEficiencia();
						$("#btnRptEficiencia").attr("disabled","disabled");
						
					}else{
						$("#btnRptEficiencia").attr("disabled","disabled");
						$("#tBodyRpt").html('');
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>No se encontr&oacute; informaci&oacute;n en los criterios seleccionados!.</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});					
					}
				}else{
					$("#btnRptEficiencia").attr("disabled","disabled");
					$("#tBodyRpt").html('');
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			}
		});
		return true;
	}
	
	
	function consultarColoniasZonas(){
		var vFuncion = 5;
		
		$.ajax(
		{
			async:true,
			cache:false,
			type:'POST',
			url:"./php/zonas.php",
			dataType:'json',
			data: { funcion: vFuncion}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$("#tbodyColonias").append(obj['data']);
					CargaColonias();				
				}
			}
		});
		
		return true;
	}
	
	
	
	function LlenarComboZonasCapturadas(){
		var vFuncion = 11;
		
		$.ajax(
		{
			async:true,
			cache:false,
			type:'POST',
			url:"./php/zonas.php",
			dataType:'json',
			data: { funcion: vFuncion}
			,success: function(data){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					$('#SelectZonaModal').append(obj['data']);
				}
			}
		});
		
		return true;
	}
	
	
	
	//Cambiar la fecha de cobranza.
	function modificarFechaCobranza(){
		var bRespuesta = false;
		if($("#idFecha").val() == ''){
			$("#idFecha").focus();
			bRespuesta =false;
		}else if ($("#idFechaCobro").val() == ''){
			$("#idFechaCobro").focus();
			bRespuesta =false;
		}else if($("#idFolioPedido").val()==''){
			$("#idFolioPedido").focus();
			bRespuesta =false;
		}else{
			bRespuesta =true;
		}
		
		var vFuncion = 12;
		if (bRespuesta){
			$.ajax(
			{
				async:false,
				cache:false,
				type:'POST',
				url:"./php/pedidos.php",
				data: {
						funcion: vFuncion,
						fechames:$("#idFecha").val(),
						fechaanio:$("#idFechaCobro").val(),
						foliopedido:$("#idFolioPedido").val()
						},
				success: function(data){
					obj = JSON.parse(data);
					if (obj['success'] == true){
						//Exito
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						
						window.location.href = "#ajax/dashboard.php";
					}else{
						//Falla
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});
					}
				}
			});
		}else{
			//Falla
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Campos incompletos!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			$("#idFechaCobro").focus();
		}
		return true;
	}
	
	
	function LimpiarModificacionFecha(){
		$("#idFechaCobro").val(fecha);
		$('#idFechaCobro').focus();
		return true;
	}
	
	//Aviso de confirmacion realizar el corte de abonos
	function MensajeSmartCorteDescartarPagarComisionesCobranza() {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar, debiste de haber impreso el reporte?",
			content : "Al realizar la operaci&oacute;n no podrás imprimir el reporte.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				PagarComisionesCobranza();
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se cancelo la operaci&oacute;n, no olvides imprimir el reporte.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
				setTimeout(function(){ 
					window.location.reload();
				}, 1000);
			}

		});
		return true;
	}
	
	function PagarComisionPorCobranza(ifolioPedido){
		
		var objVendedor = $("#controles_"+ifolioPedido+" label")[0];
		var objTotal = $("#controles_"+ifolioPedido+" label")[2];
		var vFuncion = 2;
		$.post("./php/comisiones.php",
		{
			funcion: vFuncion,
			foliopedido: ifolioPedido,
			cliente:objVendedor.innerHTML,
			monto: objTotal.innerHTML
			
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				return true;
			}else{
				return false;
			}
		});
	
		return true;
	}
	
	
	
	//Consultar facturados periodo
	function buscarComisionesCobranzaPagadasPeriodo(){
		
		var vFuncion = 6;
			
		if ($("#from").val() == ''){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Capture una fecha inicio!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vFechaInicio = $("#from").val();
		}
		if ($("#to").val() == ''){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Captura una fecha final!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vFechaFin = $("#to").val();
		}
		
		$('#idDel').html('DEL ' + vFechaInicio);
		$('#idAl').html(' AL ' +vFechaFin);
		
		$('#idDelEnc').html('DEL ' + vFechaInicio);
		$('#idAlEnc').html(' AL ' +vFechaFin);
		
		$.ajax(
		{
			async:true,
			cache:false,
			type:'POST',
			url:"./php/reportes.php",
			dataType:'json',
			data: { 
				funcion: vFuncion,
				fechainicio:vFechaInicio,
				fechafin:vFechaFin
			}
			,success: function(data){
				obj = data;
				if (obj['success'] == true){
					$("#tBodyRpt").html('');
					if (obj['data'].length > 0){
						//pageSetUp();
						$("#tBodyRpt").html(obj['data']);
						PaginarComisionesPagadasPeriodo();
						//buscarTotalesEficiencia();
						$("#btnRptEficiencia").attr("disabled","disabled");
						
					}else{
						$("#btnRptEficiencia").attr("disabled","disabled");
						$("#tBodyRpt").html('');
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>No se encontr&oacute; informaci&oacute;n en los criterios seleccionados!.</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});					
					}
				}else{
					$("#btnRptEficiencia").attr("disabled","disabled");
					$("#tBodyRpt").html('');
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}
			}
		});
		return true;
	}