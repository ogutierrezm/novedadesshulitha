var responseProveedoresAutoComplete = variableAutoCompleteProveedores();
var responseConceptoGastosAutoComplete = variableAutoCompleteConceptoGastos();
var responseAutoComplete = null;

$("#form-inventario").validate({

      // Rules for form validation
      rules : {
        factura : {
          required : true,
          soloNumeros: true
        },
        subtotal:{
        	required: true,
        	soloNumerosFloat:true
        },
        iva:{
        	required:true,
        	soloNumerosFloat:true
        },
        montototal:{
        	required:true,
        	soloNumerosFloat:true
        },
        tipo:{
        	required: function(element) {
				        return !$("#id_tipo").val();
				      }
        },
        fecha_compra:{
        	required:true
        }
      },

      // Messages personalizados
      messages : {
        factura : {
          required : '*Numero factura obligatorio.'
        },
        subtotal:{
        	required:'*Sub-Total obligatorio.'
        },
        iva:{
        	required:'*Iva obligatorio.'
        },
        montototal: {
        	required:'*Monto Total obligatorio.'
        },
        tipo:{
        	required: '*Seleccione un valor real.'
        },
        fecha_compra:{
        	required : '*Fecha Compra obligatorio.'
        }
      },

      // Do not change code below
      errorPlacement : function(error, element) {
        error.insertAfter(element.parent());
      }
    });
 var today = new Date();  //Get today's date
 $( "#fecha_compra" ).datepicker({ dateFormat: 'yy-mm-dd' });
 $("#fecha_compra").datepicker("option", "maxDate", today);

 // this is the id of the form
$("#form-inventario").submit(function(e) {
  if($(this).valid()) {
    e.preventDefault();
    var url = "./php/inventario.php"; // the script where you handle the form input.
    var parametros = getFormData($("#form-inventario"));

    parametros.categoria = "ALTA_INVENTARIO";
    var response = callAjax(parametros, url);

    if(response.success == true){
        showMessageSuccess('Confirmacion','Alta del inventario se correctamente!!');
        $('#form-inventario').find('input:text').val('');
    }else{
      showMessageError(response.error);
    }
  }
});

function llenarGridInventario(){
    var parametros = {};
    var url = "./php/inventario.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_INVENTARIO";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyInventario").html(response.data.html);  
    }else{
      showMessageError(response.error);
    }
}

function editInventario(id){
    var parametros = {};
    var url = "./php/inventario.php"; // the script where you handle the form input.
    parametros.id = id;
    parametros.categoria = "CONSULTA_INFO_INVENTARIO";
    var response = callAjax(parametros, url);
  if(response.success == true){
  	$("#tipoFactura").hide();
    var info = response.data.info[0];
      $("#idInventario").val(info.id_inventario);
      $("#factura").val(info.folio_factura);
      $("#subtotal").val(info.subtotal);
      $("#iva").val(info.monto_iva);
      $("#montototal").val(info.monto_total);
      var idTipo = (info.id_concepto_gasto == 0) ? info.id_proveedor : info.id_concepto_gasto;
      var tipo = (info.id_concepto_gasto == 0) ? info.nombre_proveedor : info.nombre_concepto;

      if(info.id_concepto_gasto == 0){
      	$("#chk_proveedor").attr('checked',true);
      	mostrar_tipo('Proveedor', 'PROVEEDOR');
		    responseAutoComplete = responseProveedoresAutoComplete;
      }else{
      	$("#chk_concepto_gastos").attr('checked',true);
      	mostrar_tipo('Concepto de Gasto', 'CONCEPTO_GASTOS');
		    responseAutoComplete = responseConceptoGastosAutoComplete;
      }

      $("#id_tipo").val(idTipo);
      $("#tipo").val(tipo);
      $("#fecha_compra").val(info.fecha_compra);
    }else{
    	showMessageError(response.error);
    }
}

$("#chk_proveedor").click(function(){
	if( $(this).is(':checked')){
		$('#chk_concepto_gastos').removeAttr('checked');
		$(this).attr('checked',true);
		mostrar_tipo('Proveedor', 'PROVEEDOR');
		responseAutoComplete = responseProveedoresAutoComplete;

	}else{
		$(".mostrar_form").hide();
		responseAutoComplete = null;
	}
});

$("#chk_concepto_gastos").click(function(){
	if( $(this).is(':checked')){
		$('#chk_proveedor').removeAttr('checked');
		$(this).attr('checked',true);
		mostrar_tipo('Concepto de Gasto', 'CONCEPTO_GASTOS');
		responseAutoComplete = responseConceptoGastosAutoComplete;
	}else{
		$(".mostrar_form").hide();
		responseAutoComplete = null;
	}
});

function mostrar_tipo(descripcion, tipoInventario){
	$(".mostrar_form").show();

	if($("#idInventario").val() == ''){
		$(".mostrar_form").find('input:text').val('');
	}
	
	$("#descripcion").html(descripcion);
	$("#tipoInventario").val(tipoInventario);
	$(".mostrar_form #id_tipo").val("");
	$(".mostrar_form #tipo").val("");
	
}

function variableAutoCompleteProveedores(){
	var parametros = {};
	parametros.categoria = 'AUTOCOMPLETE_PROVEEDORES';
	parametros.term = '';
	var url = './php/proveedores.php'
	return callAjax(parametros, url);
}

function variableAutoCompleteConceptoGastos(){
	var parametros = {};
	parametros.categoria = 'AUTOCOMPLETE_CONCEPTO_GASTOS';
	parametros.term = '';
	var url = './php/concepto_gastos.php'
	return callAjax(parametros, url);
}

$("#tipo").autocomplete({
    source: function (request, respond) {
	    respond(
	    	$.ui.autocomplete.filter(
					responseAutoComplete.data.info,
					extractLast(request.term)
				)
	    	);
    },
    minLength: 3,
    change: function(event, ui){
      if (ui.item == null) {
          $(this).val('');
          $("#id_tipo").val("");
        } else {
            $(this).val(ui.item.value);
            $("#id_tipo").val(ui.item.id);
        }
    },
    open: function() {  },
    close : function() {   
        if ($("#id_tipo").val()==""){
            $(this).val('');
            $("#id_tipo").val("");
          }
    },
    focus: function(event,ui) {},
    select: function(event, ui) {
    	$(this).val(ui.item.value);
    	$("#id_tipo").val(ui.item.id);
    }
});

function revisarTotales(id){
	var parametros = {};
	parametros.id = id;
	parametros.categoria = 'VALIDA_TOTALES';
	var url = './php/inventario.php'
	var response = callAjax(parametros, url);
	
	if(response.data.info[0].monto_total == response.data.info[0].monto_total_detalle ){
		parametros.categoria = 'CONFIRMAR_INVENTARIO';
    response = callAjax(parametros, url);

    if(response.success == true){
      showMessageSuccess('Confirmacion inventario','inventario confirmado correctamente!!');
    }
	}else{
    showMessageError("No es posible realizar Confirmacion, debido que los montos de factura y detalle de la factura no coinciden!!");
	}
}

function setearValorMontoTotal(){
  if( $("#subtotal").val() != '' && parseFloat($("#subtotal").val()) > 0 ){
    var fIva = $("#iva").val() ;
    if( fIva === NaN ){
      fIva = 0;
    }
    var subtotal = parseFloat($("#subtotal").val());
    var fMontoTotal =  (subtotal * fIva / subtotal) + subtotal;
    $("#montototal").val(fMontoTotal.toFixed(2));
  } else {
    $("#montototal").val("");
  }
}

function llenarGridInvetarioReporte(){
    var parametros = {};
    var url = "./php/inventario.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_INVENTARIO_REPORTE";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyInventarioReporte").html(response.data);  
    }else{
      showMessageError(response.error);
    }
}

function llenarGridInvetarioReporteRangosFechas(){
    var parametros = {};
    var url = "./php/inventario.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_INVENTARIO_REPORTE";
    parametros.from = $("#from").val();
    parametros.to = $("#to").val();
    if($("#from").val() == ''){
      showMessageError('Fecha Inicial obligatoria!!');
      return;
    }else if($("#to").val() == ''){
      showMessageError('Fecha Final obligatoria!!');
      return;
    }

    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyInventarioReporte").html(response.data);  
      pageConstruirGridInventarios();
      $("#btnRptEficiencia").attr("disabled","disabled");
    }else{
      showMessageError(response.error);
    }
} 

  $('#from').datepicker({onClose: function(selectedDate) {
      $("#to").datepicker("option", "minDate", selectedDate);
  }});
  $('#to').datepicker({onClose: function(selectedDate) {
        $("#from").datepicker("option", "maxDate", selectedDate);
  }});