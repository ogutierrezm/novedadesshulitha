ForceNumericOnly($("#folio_factura"));

function buscarInfoFacturaCtaIncobrable(){
	if($("#folio_factura").val() == ""){
		showMessageError("N&uacute;mero Factura obligatorio!!");
	}else{
		var parametros = {};
		var url = "./php/cuenta_incobrables.php"; // the script where you handle the form input.
		parametros.categoria = "BUSQUEDA_INFO_CUENTA_INCOBRABLE";
		parametros.folio_factura = $("#folio_factura").val();
		var response = callAjax(parametros, url);
		if(response.success == true){
			var resp = response.data;
			if(resp.length > 0){
				resp = resp[0];
				$("#btnGrabarCuentaIncobrable").removeAttr("disabled");
				$("#nombre_cliente").val(resp.cliente);
				$("#tipo_pago").val(resp.tipo_pago);
				$("#plazo").val(resp.forma_pago);
				$("#total_facturado").val(resp.total_facturado);
				$("#fecha_venta").val(resp.fecha_venta);
				$("#folio_factura").attr("readonly", "readonly");
			}else{
				$("#nombre_cliente").val('');
				$("#tipo_pago").val('');
				$("#plazo").val('');
				$("#total_facturado").val('');
				$("#fecha_venta").val('');
				$("#justificacion").val('');
				showMessageInformativo('Puede que la Factura ya sea una cuenta incobrable y/o no exista!!');	
			}
		}else{
			showMessageError(response.error);
		}
	}
}

function limpiarInformacionCuentaIncobrables(){
	$("#nombre_cliente").val('');
	$("#tipo_pago").val('');
	$("#plazo").val('');
	$("#total_facturado").val('');
	$("#fecha_venta").val('');
	$("#folio_factura").val('').removeAttr("readonly");
	$("#justificacion").val('');
}
function ForceNumericOnly($input)
{
    return $input.each(function()
    {
        $($input).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
    });
};

function grabarCuentaIncobrable(){
		if($("#justificacion").val() ==''){
			showMessageError("Necesario proporcionar un a justificacion!!");
			return;
		}
		$.SmartMessageBox({
			title : "¿Esta seguro que desea convertir a cuenta incobrable?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada a este elemento.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				var url = './php/cuenta_incobrables.php'
				var parametros = {};
				parametros.folio_factura = $("#folio_factura").val();
				parametros.justificacion = $("#justificacion").val();
				parametros.categoria='CREAR_CUENTA_INCOBRABLE';
				var response = callAjax(parametros, url);
				if(response.success == true){
					showMessageSuccess('Confirmacion','Se realizo una cuenta incobrable!!');
				}else{
					showMessageError(response.error);
				}
			}
			if (ButtonPressed === "No") {
				showMessageInformativo("Se cancelo la operaci&oacute;n...");
			}
		});
}

function llenarGridCuentasIncobrables(){
    var parametros = {};
    var url = "./php/cuenta_incobrables.php"; // the script where you handle the form input.
    parametros.categoria = "GRID_CUENTAS_INCOBRABLES";
    var response = callAjax(parametros, url);
  if( response.success == true ){
      $("#tbodyCuentasIncobrables").html(response.data.info);
    } else {
      showMessageError(response.error);
    }
}

function obtenerJustificacion(factura){
	var parametros = {};
	var url = "./php/cuenta_incobrables.php"; // the script where you handle the form input.
	parametros.categoria = 'OBTENER_JUSTIFICACION';
	parametros.factura = factura;
	var response = callAjax(parametros, url);

  	if( response.success == true ){
		$("#justificacion").val(response.data.info);
    } else {
      showMessageError(response.error);
    }
}