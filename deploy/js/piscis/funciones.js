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
					//consultarUsuarios();
					//LimpiaInsertUsr();
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
					//consultarZonas();
					//LimpiaNvaZona();
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
					//consultarZonas();
					//LimpiaNvaZona();
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
						//consultarInventarioModificado();
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
		/*
		if (bRespuesta){
			$.post("./php/inventario.php",
			{
				funcion: vFuncion,
				horas:$("#horas").val(),
				st3:($("#st3").val()== 0)? 0:1,
				precio:$("#precio").val(),
				cantidad:$("#spinner-currency").val(),
				articulo:$("#articulo").val()
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					//consultarInventarioModificado();
					//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					//LimpiarInventarioNuevo();
					setTimeout(function(){
						window.location.reload();
					}, 2000);
					$("#articulo").focus();
					obtenerSKU();
				}else{
					//Falla
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
					LimpiarInventarioNuevo();
					$("#articulo").focus();
				}
			});
		}
		*/
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
						//consultarInventarioModificado();
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
						//$("#articuloModal").focus();
						//obtenerSKU();
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
		}/*if ($("#CodigoPostal").val() == '' && $("#Colonia").val() == ''){
			limpiaDatosCpMnipio();
			return false;
		}*/else{
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
					//consultarColoniasZonas();
					//LimpiarRegistroZona();
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
					//consultarColoniasZonas();
					//LimpiarRegistroZona();
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
				//consultarUsuarios();
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
					borrarPedido(vFolio);
				}
					/*$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se elimino el folio "+vFolio+".</i>",
					color : "#659265",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});*/
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
	function borrarPedido(vFolio){
		var vFuncion = 7;
		
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
					//consultarUsuarios();
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
			//$("#telefonocelular").focus();
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
						//$('#telefonocelular').val(obj['data']['telcelular']);
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
						//$('#telefonocasa').val(obj['data']['telcasa']);
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
		//if($("#telefonocelular").val().length >= 10||$("#telefonocasa").val().length >= 10){
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
	
	//Consultar los articulos
	function consultarArticuloElegido(vKeyx,vConsecutivo){
		var vFuncion = 1;
		if (vKeyx > 0){
			$.post("./php/articulos.php",
			{
				funcion:vFuncion,
				keyx: vKeyx,
				fechaentrega: $("#fechaentrega").val(),
				foliopedido: 0
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					if (obj['data'] != ''){
						$('#precio_'+vConsecutivo).val(obj['data']['precio']);
						$('#cantidad_'+vConsecutivo).val(1);
						//console.log(obj['data']);
						var vFlag_especial = obj['data']['flag_especial'];
						$('#hidespecial_'+vConsecutivo).val(vFlag_especial);
						var hdEspecial = document.getElementById("hidespecial_"+vConsecutivo)
						$('#hidcantidad_'+vConsecutivo).val(obj['data']['cantidad']);
						if((parseInt($('#cantidad_'+vConsecutivo).val()) > hdEspecial.value)&& (hdEspecial !== 1)){
							//$('#cantidad_'+vConsecutivo).val($('#hidcantidad_'+vConsecutivo).val());
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
						CalcularSaldoPedido();
					}
				}
			});
		}
		return true;
	}
	
	function CalcularSaldoPedido(){
		var vTotal = 0;
		var vPrecio = 0;
		var vCantidad = 0;
		var vDescuento = 0;
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
			vCantidad = ($('#cantidad_'+i).val() != null)? parseInt($('#cantidad_'+i).val()):1;	
			vPrecio = isNaN(vPrecio) ? 0:vPrecio;
			vCantidad = isNaN(vCantidad) ? 0:vCantidad;
			vTotal = parseInt((vTotal+(vPrecio * vCantidad)));
		}
		vFlete = ($('#idcargoFlete').val() != null)? parseInt($('#idcargoFlete').val()):0;
		vAbono = ($('#importe_totalmodal').val() != null)? parseInt($('#importe_totalmodal').val()):0;
		vTotal = (vTotal > 0 ? parseInt(vTotal):0);
		vDescuento = ($('#PorcentajeDescuento').val() != null)? parseInt($('#PorcentajeDescuento').val()):0;
		vMontoDescuento = Math.round(parseInt((parseInt(vTotal))*(vDescuento/100)));
		$("#Descto").html(vMontoDescuento);
		$("#subtotal").html(vTotal);
		vTotal = (vTotal - vMontoDescuento);
		vTotal = (vTotal + vFlete);
		
		if ($("#check_IVA").val() > 0){
			$("#idIVA").html(Math.round(parseInt(parseInt(vTotal) * 0.16)));
		}
		
		objAbono = $('#importe_totalmodal').val();
		vMontoGarantia = ($("#importe_garantia").val()!=null)?parseInt($("#importe_garantia").val()):0;
		
		
		vTotalgral = vTotal - vAbono;
		
		
		$("#abono").html(vAbono); 
		
		if ($("#check_IVA").val() > 0){
			if (parseInt(parseInt(vTotal)*1.16) <= parseInt(objAbono)){
				$('#importe_totalmodal').val(Math.round(parseInt(vTotal)*1.16));
				vAbono = $('#importe_totalmodal').val();
			}
			objAbono.max = Math.round(parseInt(vTotal) * 1.16);
			//vTotalgral =  parseInt(vTotal)- parseInt(vMontoDescuento);
			//$("#idIVA").html(Math.round(parseInt(parseInt(vTotal) * 0.16)));
			//vTotalgral = Math.round(parseInt(vTotal)*1.16) - (vAbono + vMontoDescuento)	 ;
			vTotalgral = Math.round(parseInt(vTotal)*1.16) - (vAbono)	 ;
			$("#total").html(parseInt(vTotalgral)+ parseInt(vMontoGarantia));
		}else{
			if (parseInt(vTotal) < parseInt(objAbono)){
				$('#importe_totalmodal').val(parseInt(vTotal));
				vAbono = $('#importe_totalmodal').val();
			}
			objAbono.max = vTotal;
			$("#idIVA").html(0);
			$("#total").html(parseInt(vTotalgral) + parseInt(vMontoGarantia));
		}
		
		return true;
	}
	
	function ReCalcularSaldoPedido(vConsecutivo){
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
		//vAbono = ($('#importe_totalmodal').val() != null)? parseInt($('#importe_totalmodal').val()):0;
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
						//console.log(obj['data']);
						var vFlag_especial = obj['data']['flag_especial'];
						$('#hidespecial_'+vConsecutivo).val(vFlag_especial);
						var hdEspecial = document.getElementById("hidespecial_"+vConsecutivo)
						$('#hidcantidad_'+vConsecutivo).val(obj['data']['cantidad']);
						if((parseInt($('#cantidad_'+vConsecutivo).val()) > hdEspecial.value)&& (hdEspecial !== 1)){
							//$('#cantidad_'+vConsecutivo).val($('#hidcantidad_'+vConsecutivo).val());
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
		vFlete = ($('#idcargoFlete').val() != null)? parseInt($('#idcargoFlete').val()):0;
			vAbono = ($('#importe_totalmodal').val() != null)? parseInt($('#importe_totalmodal').val()):0;
		//if(vAbono <= 0){
			//vAbono = $('#abono').html();
		//}
		vTotal = (vTotal > 0 ? parseInt(vTotal):0);
		//vTotalgral = parseInt(vTotal) - parseInt(vAbono);
		vTotalgral = parseInt(vTotal);
		vDescuento = ($('#PorcentajeDescuento').val() != null)? parseInt($('#PorcentajeDescuento').val()):0;
		vMontoDescuento = Math.round(parseInt(vTotalgral*(vDescuento/100)));
		$("#Descto").html(vMontoDescuento);
		
		
		vSubtotal = (vTotal + vFlete);
		vTotal = (vTotal - vMontoDescuento);
		
		vTotal = (vTotal + vFlete);
		$("#subtotal").html(vSubtotal); 
		
		if ($("#check_IVA").val() > 0){
			$("#idIVA").html(Math.round(parseInt(parseInt(vTotal) * 0.16)));
		}
		objAbono = $('#importe_totalmodal').val();
		if (parseInt(vTotal) < parseInt(objAbono)){
			$('#importe_totalmodal').val(parseInt(vTotal));
			vAbono = $('#importe_totalmodal').val();
		}
		
		vAbonoAnterior = isNaN(vAbonoAnterior) ? 0:vAbonoAnterior;
		vAbono = isNaN(vAbono) ? 0:vAbono;
		vAbonado = (parseInt(vAbonoAnterior)+ parseInt(vAbono)); 
		$("#abono").html(parseInt(vAbonoAnterior)+ parseInt(vAbono)); 
		
		vMontoGarantia = ($("#importe_garantia").val()!=null)?parseInt($("#importe_garantia").val()):0;
		
		if ($("#check_IVA").val() > 0){
			if (parseInt(parseInt(vTotal)*1.16) <= parseInt(objAbono)){
				$('#importe_totalmodal').val(Math.round(parseInt(vTotal)*1.16));
				vAbono = $('#importe_totalmodal').val();
			}
			objAbono.max = Math.round(parseInt(vTotal) * 1.16);
			//$("#idIVA").html(Math.round(parseInt(parseInt(vTotal) * 0.16)));
			vTotalgral = Math.round(parseInt(vTotal)*1.16) - vAbonado;
			//vTotalgral =  parseInt(vTotalgral)- parseInt(vMontoDescuento);
		}else{
			objAbono.max = parseInt(vTotal) - (parseInt(vAbonado));
			$("#idIVA").html(0);
			vTotalgral = parseInt(parseInt(vTotal))-(parseInt(vAbonado));
			//vTotalgral =  parseInt(vTotalgral)- parseInt(vMontoDescuento);
		}
		$("#total").html(parseInt(vTotalgral)+ parseInt(vMontoGarantia));
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
		//vAbono = ($('#importe_totalmodal').val() != null)? parseInt($('#importe_totalmodal').val()):0;
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
						//pedidoGrabarDomicilio();
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
						//pedidoGrabarDetalle();
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
							//pedidoGrabarArticuloDePedidoNuevo(vArticulo,vCantidad,vHorarioRenta);
							pedidoGrabarArticuloDePedidoModificado(vArticulo,vCantidad,vHorarioRenta);
						}
						var ctekeyx = $("#clientekeyx").val();
						var direckeyx = $("#direccionkeyx").val();
						//var bRespuesta = pedidoGrabarPedido(ctekeyx,direckeyx);
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
		//console.log(vCtekeyx);
		//console.log(vDireckeyx);
		//ctekeyx = $('#clientekeyx').val();
		//direckeyx = $('#direccionkeyx').val();
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
						}else{
							setTimeout(function(){
								window.location.href = sUrlRedirected;
							}, 2000);
						}
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
					horariorenta: vHorarioRenta},
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
			//$("#sectionDesctos").css("display","block");
			//$("#PorcentajeDescuento").val(0);
			$("#lblDescto").html('No Incluir');
		}else{
			$("#check_Descto").val(0);
			$("#lblDescto").html('Incluir');
			//$("#sectionDesctos").css("display","none");
			//$("#PorcentajeDescuento").val(0);
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
				content : "<strong>Diversiones PISCIS</strong></br>Sistema de control de Pedidos e Inventario</br>Version: 1.2&nbsp;|&nbsp;Build: 1.2</br>Actualización: 18/01/2016",
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
						pedidoGrabarDetalle();
						
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
		}/*else if ($("#referencias").val() == ''){
			$("#referencias").focus();
			return false;
		}*/else{
			return true;
		}
	}
	
	
	//Registrar articulo nuevos a pedido
	function pedidoGrabarArticuloDePedidoNuevo(vId_articulo,vCantidad,vHorarioRenta){
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
					horariorenta: vHorarioRenta},
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
	
	//Registrar pedido nuevo
	function pedidoGrabarPedido(vCtekeyx,vDireckeyx){
		//console.log(vCtekeyx);
		//console.log(vDireckeyx);
		//ctekeyx = $('#clientekeyx').val();
		//direckeyx = $('#direccionkeyx').val();
		var vMostrarNota = true;
		var vFuncion = 7;
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
						//Exito
						$("#btnGrabarPedido").attr("disabled","disabled");
						$.smallBox({
							title : "Aviso",
							content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 4000
						});
						var vFolioPedido = parseInt($("#folio").val());
						enviarMail(vFolioPedido);
						try{
							if(vFolioCotiza != ''){
								actualizaCotizacion(vFolioCotiza);
							}
						}catch (err){
							//console.log('No esta set la variable ' + err);
						}
						
						if ($("#importe_totalmodal").val() > 0){
							AbonarPedido(1,vFolioPedido,1,vMostrarNota,vEmpleado);
						}else{
							setTimeout(function(){
								window.location.href = sUrlRedirected;
							}, 2000);
						}
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
	
	
	function validarPedidoNuevo(){
		if ($("#fechaentrega").val() == ''){
			return false;
		}else if ($("#fecharecolectar").val() == ''){
			return false;
		//}else if ($("#hora1").val() == ''){
		//	return false;
		//}else if ($("#check_recoger").val() == 1 && $("#hora2").val() == ''){
		//	return false;
		}else{
			return true;
		}
	}
	
	function pedidoGrabarDetalle(){
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
			pedidoGrabarArticuloDePedidoNuevo(vArticulo,vCantidad,vHorarioRenta);
		}
		var ctekeyx = $("#clientekeyx").val();
		var direckeyx = $("#direccionkeyx").val();
		var bRespuesta = pedidoGrabarPedido(ctekeyx,direckeyx);
		return true;
	}
	
	/*
	function cambiarValor(vValor){
		if (vValor == 0){
			$("#check_recoger").val(1);
			$("#time2").css("display",'block');
			$("#hora2").css("display",'block');
		}else{
			$("#check_recoger").val(0);
			$("#time2").css("display",'none');
			$("#hora2").css("display",'none');
		}
		return true;
	}*/
	
	
	function LimpiarCapturaPedidoNuevo(vFolioPedido){
		$("#consecutivo").val(1);
		//LimpiarGrid();
		$("#folio").val(vFolioPedido);
		$("#clientekeyx").val(0);
		$("#direccionkeyx").val(0);
		//$("#fechaentrega").val('');
		//$("#fecharecolectar").val('');
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
	
	function consultarColoniasZonas(){
		var vFuncion = 5;
		
		$.post("./php/zonas.php",
		{
			funcion: vFuncion
		},
		function(data,status){
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$("#tbodyColonias").html('');
				setTimeout(function(){
					$("#tbodyColonias").append(obj['data']);
				}, 2000);
				
			}
		});
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
	
	function ConsultarFolioPedidoAModificar(){
		var vFuncion = 1;
		var bRespuesta = validarConsultarFolioPedido();
		if (bRespuesta){
			$.post("./php/pedidos.php",
			{
				funcion: vFuncion,
				foliopedido:$("#folio").val()
			},
			function(data,status){
				objPedido = JSON.parse(data);
				if (objPedido['success'] == true){
					//console.log(objPedido['data']);
					$("#nombre").val(objPedido['data']['nombrecte']);
					$("#apellido").val(objPedido['data']['apellidocte']);
					$("#telefonocasa").val(objPedido['data']['telefonocasa']);
					$("#telefonocelular").val(objPedido['data']['telefonocelular']);
					setTimeout(function(){
						ConsultarTelefonos();
						consultarPedidoaRecibir();
						setTimeout(function(){
							domicilioSet = getPositionByObjects(domiciliosCliente,'colonia',objPedido['data']['colonia'].toUpperCase());
							$("#referencias").val(objPedido['data']['referencias']);
							$("#calle").val(objPedido['data']['calle']);
							$("#numext").val(objPedido['data']['numext']);
							$("#numint").val(objPedido['data']['numint']);
							$("#CodigoPostal").val(objPedido['data']['codigopostal']);
							$("#Colonia").val(objPedido['data']['colonia']);
							$("#municipio").val(objPedido['data']['ciudad']);
						}, 1500);
					}, 500);
					$("#idManteleria").val(objPedido['data']['manteleria']);
					$("#idcargoFlete").val(objPedido['data']['flete']);
					$("#fechaentrega").val(objPedido['data']['fechapedido']);
					$("#fecharecolectar").val(objPedido['data']['fechavueltapedido']);
					$("#hora1").val(objPedido['data']['notahoraentrega']);
					$("#hora2").val(objPedido['data']['notahorarecoger']);
					var importependiente = parseInt(objPedido['data']['total']) + parseInt(objPedido['data']['abono']);
					$("#subtotal").html(importependiente); 
					vAbonoAnterior = parseInt(objPedido['data']['abono']); 
					$("#abono").html(parseInt(objPedido['data']['abono'])); 
					$("#importe_totalmodal").val(0); 
					$("#importe_garantia").val(objPedido['data']['garantia']); 
					if (parseInt(objPedido['data']['iva']) == 1){
						$("#check_IVA").click();		
					}
					if (parseInt(objPedido['data']['descuento']) == 1){
						$("#check_Descto").click();
					}
					$("#PorcentajeDescuento").val(objPedido['data']['cantidaddescuento']);
					if (objPedido['data']['fechapedido'] === objPedido['data']['fechavueltapedido']){
						$("#check_recoger").click();
					}
					
					//$("#importe_totalmodal").val(objPedido['data']['abono']); 
					$("#actividadPedido").attr('display','block');
					$("#liquidaPedido").removeAttr('href');
					$("#recibirAbono").removeAttr('href');
					$("#entradaParcial").removeAttr('href');
					if (objPedido['data']['empleado'] != ''){
						var buscaEmpleado = $("#empleado").find("option:contains('"+ objPedido['data']['empleado'] +"')");
						$("#empleado").val(buscaEmpleado.val());
					}
					$("#total").val(parseInt(objPedido['data']['total']));
					$("#importe_total").val('');
					$("#importe_total").focus();
					/*$("#liquidaPedido").attr('href','ajax/modal_liquidarpedido.php?foliopedido='+$("#folio").val());
					$("#recibirAbono").attr('href','ajax/modal_recibirabono.php?foliopedido='+$("#folio").val()+'&importe_total='+importependiente);
					$("#entradaParcial").attr('href','ajax/modal_entradaparcial.php?foliopedido='+$("#folio").val());*/
					//ConsultarTelefonos();
					
					//Exito
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+objPedido['error']+ "</i>",
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
							//ConsultarFolioPedido();
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
							window.location.href = urlAbono;
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
				
			});
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
					//consultarZonas();
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
					//consultarZonas();
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
					//consultarColoniasZonas();
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
					//consultarColoniasZonas();
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
					//consultarColoniasZonas();
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
					//consultarColoniasZonas();
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
				//bRespuesta = false;
			}else{
				continue;
			}
			
			if(!bRespuesta){break;}
			//console.log('articulo: '+vArticulo + ' Cantidad: '+ vCantidad + ' Folio: '+ vFolioPedido);
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
		//LimpiarCapturaPedidoLiberado();
		/*ConsultarFolioPedido();
		setTimeout(function(){
			consultarPedidoaEntregarParcial();
		}, 2000);*/
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
						//pageSetUp();
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
	
	
	//Consultar todos lo pedidos.
	function buscarPedidosEficiencia(){
		
		var vFuncion = 10;
		var vMes = []; 
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
		
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			empleado:vEmpleado,
			fechames:vFechaInicio,
			fechaanio:vFechaFin
		},
		function(data,status){					
			obj = JSON.parse(data);
			if (obj['success'] == true){
				$("#tBodyRpt").html('');
				if (obj['data'].length > 0){
					//pageSetUp();
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
		
		//limpiarPedidosTodos();
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
				/*$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
				window.location.reload();*/
			}else{
				/*$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});*/
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
	
	
	function DescartarBorrado(ifolioPedido){
		
		var vFuncion = 17;
		$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			foliopedido: ifolioPedido,
			empleado:uUser
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
	function MensajeSmartCorteDescartarBorrados() {
		$.SmartMessageBox({
			title : "¿Esta seguro que desea continuar, debiste de haber impreso el reporte?",
			content : "Al realizar la operaci&oacute;n no podrás imprimir el reporte.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				noConsiderarBorrado();
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
		//var direckeyx = $("#direccionkeyx").val();
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
		//console.log(vCtekeyx);
		//console.log(vDireckeyx);
		//ctekeyx = $('#clientekeyx').val();
		//direckeyx = $('#direccionkeyx').val();
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
					/*$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>Se elimino el folio "+vFolio+".</i>",
					color : "#659265",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});*/
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
		if (isValidEmailAddress(vEmailAddress) && isValidEmailAddress != ''){
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
			if (isValidEmailAddress != ''){
				setTimeout(function(){
					window.location.href = sUrlRedirected + '?f='+ vFolio;
				}, 2000);
			}else{
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>El email capturado no es v&aacute;lido por lo que requiere capturar uno correcto.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
				$("#email").focus();
			}	
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
					//console.log(obj['data']);
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
					//$("#importe_totalmodal").val(obj['data']['abono']); 
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
					/*$("#liquidaPedido").attr('href','ajax/modal_liquidarpedido.php?foliopedido='+$("#folio").val());
					$("#recibirAbono").attr('href','ajax/modal_recibirabono.php?foliopedido='+$("#folio").val()+'&importe_total='+importependiente);
					$("#entradaParcial").attr('href','ajax/modal_entradaparcial.php?foliopedido='+$("#folio").val());*/
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
		//bRespuesta = modificarGrabarCliente();
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
						//modificarGrabarDomicilio();
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
							//pedidoGrabarArticuloDePedidoNuevo(vArticulo,vCantidad,vHorarioRenta);
							cotizacionGrabarArticuloDeCotizacionModificado(vArticulo,vCantidad,vHorarioRenta);
						}
						var ctekeyx = $("#clientekeyx").val();
						var direckeyx = $("#direccionkeyx").val();
						//var bRespuesta = pedidoGrabarPedido(ctekeyx,direckeyx);
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
	
		//limpiarPedidosTodos();
		/*$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			empleado:vEmpleado,
			iabono:vImporte,
			foliopedido:vFolioPedido
		},
		function(data,status){					
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
					window.history.back();
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
		});*/
	
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
		/*$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			fechaanio:vFechainicio,
			fechames:vFechafin
		},
		function(data,status){
			objFechas = JSON.parse(data);
			return objFechas;
		});
	
		return false;*/
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
		});/*,
		function(data,status){
			objFechas = JSON.parse(data);
			return objFechas;
		});*/
	
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
		
		/*
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
		});*/
	
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
		
		/*$.post("./php/pedidos.php",
		{
			funcion: vFuncion,
			foliopedido:$("#foliomodal").html()
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
					timeout : 3000
				});
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
		});*/
		
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
			
			/*
			$.post("./php/articulos.php",
			{
				funcion:vFuncion,
				foliopedido: vFolioPedido,
				id_articulo: vId_articulo,
				cantidad: vCantidad
			},
			function(data,status){
				obj = JSON.parse(data);
				if (obj['success'] == true){
					bRes = true;
				}else{
					bRes = false;
				}
			});*/
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
					//consultarZonas();
					//LimpiaNvaZona();
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
					//consultarZonas();
					//LimpiaNvaZona();
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
					//consultarZonas();
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
					//consultarZonas();
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
		/*if ($("#idGpoInventario").val() == 0){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Seleccione un grupo!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
			return false;
		}else{
			vGrupo = $("#idGpoInventario").val();
			
		}
		*/
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
					//pageSetUp();
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
		if (isValidEmailAddress(vEmailAddress) && isValidEmailAddress != ''){
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
					/*setTimeout(function(){
						window.history.back();
					}, 2000);*/
					
					
				}else{
					$.smallBox({
						title : "Aviso",
						content : "<i class='fa fa-clock-o'></i> <i>"+obj['error']+ "</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
					/*setTimeout(function(){
						window.history.back();
					}, 2000);*/
				}
			});
		}else{
			if (isValidEmailAddress != ''){
				setTimeout(function(){
					window.location.href = sUrlRedirected + '?f='+ vFolio;
				}, 2000);
			}else{
				$.smallBox({
					title : "Aviso",
					content : "<i class='fa fa-clock-o'></i> <i>El email capturado no es v&aacute;lido por lo que requiere capturar uno correcto.</i>",
					color : "#C46A69",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
				$("#email").focus();
			}	
		}
		return true;
	}
	
	
	function validarCorreo(){
		var bRespuesta = false;
		var vEmail = $('#email').val();
		if (!isValidEmailAddress(vEmail)){
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