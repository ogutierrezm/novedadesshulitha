var responseAutoCompleteArticulo = variableAutoCompleteArticulos();

$("#form-inventario_detalle").validate({

      // Rules for form validation
      rules : {
        nombre_articulo : {
          required : function(element){
          	return !$("#idArticulo").val();
          }
        },
        costo_compra:{
        	required: true,
        	soloNumerosFloat:true
        },
        iva:{
        	required:true,
        	soloNumerosFloat:true
        },
        cantidad:{
        	required:true,
        	soloNumeros:true
        }
      },

      // Messages personalizados
      messages : {
        nombre_articulo : {
          required : '*Seleccione un articulo.'
        },
        costo_compra:{
        	required:'*Costo de compra obligatorio.'
        },
        cantidad:{
        	required:'*Total articulos obligatorio.'
        }
      },

      // Do not change code below
      errorPlacement : function(error, element) {
        error.insertAfter(element.parent());
      }
    });

$("#form-inventario_detalle").submit(function(e) {
  if($(this).valid()) {
    e.preventDefault();
    var url = "./php/inventario_detalle.php"; // the script where you handle the form input.
    var parametros = getFormData($("#form-inventario_detalle"));

    parametros.categoria = "ALTA_INVENTARIO_DETALLE";
    var response = callAjax(parametros, url);
    
    if(response.success == true){

		$.smallBox({
			title : 'Confirmacion',
			content : "<i class='fa fa-clock-o'></i> <i>Articulo dado de alta correctamente!!</i>",
			color : "#659265",
			iconSmall : "fa fa-check fa-2x fadeInRight animated",
			timeout : 4000
		});
		llenarGridInventarioDetalle(parametros.idInventario, 0);
		llenarGridInventario();

        $('#form-inventario_detalle').find('input:text').val('');
        $('#form-inventario_detalle #idArticulo').val('');
    }else{
      showMessageError(response.error);
    }
  }
});

function variableAutoCompleteArticulos(){
	var parametros = {};
	parametros.categoria = 'AUTOCOMPLETE_ARTICULOS';
	parametros.term = '';
	var url = './php/inventario_detalle.php'
	return callAjax(parametros, url);
}
$("#nombre_articulo").autocomplete({
    source: function (request, respond) {
	    respond(
	    	$.ui.autocomplete.filter(
					responseAutoCompleteArticulo.data.info,
					extractLast(request.term)
				)
	    	);
    },
    minLength: 3,
    open: function() {  },
    change: function(event, ui){
      if (ui.item == null) {
          $(this).val('');
          $("#idArticulo").val("");
        } else {
            $(this).val(ui.item.value);
            $("#idArticulo").val(ui.item.id);
        }
    },
    close : function() {   
        if ($("#idArticulo").val()==""){
            $(this).val('');
            $("#idArticulo").val("");
          }
    },
    focus: function(event,ui) {},
    select: function(event, ui) {
    	$(this).val(ui.item.value);
    	$("#idArticulo").val(ui.item.id);
    }
});

function llenarGridInventarioDetalle(id, idDetalle){
    var parametros = {};
    var url = "./php/inventario_detalle.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_INVENTARIO_DETALLE";
    parametros.id = id;
    parametros.idInventarioDetalle = idDetalle;
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyInventarioDetalle").html(response.data.html);  
    }else{
      showMessageError(response.error);
    }
}

function editarArticulo(idInventario, idInventarioDetalle){
	var parametros = {};
    var url = "./php/inventario_detalle.php"; // the script where you handle the form input.
    parametros.categoria = "CONSULTA_INFO_INVENTARIO_DETALLE";
    parametros.id = id;
    parametros.idInventarioDetalle = idInventarioDetalle;
    var response = callAjax(parametros, url);
    if(response.success == true){
    	var info = response.data.info[0];
    	$("#idInventario").val(info.id_inventario);
    	$("#idInventarioDetalle").val(info.id_inventario_detalle);
    	$("#idArticulo").val(info.id_articulo);
    	$("#nombre_articulo").val(info.articulo);
    	$("#costo_compra").val(info.costo_compra);
    	$("#cantidad").val(info.cantidad);
    	$("#fechaCompra").val(info.fecha_compra);

    }
}

function eliminadoLogicoInventarioDetalle(idInventario, idInventarioDetalle, bActivo){
  var parametros = {}
  parametros.idInventario = idInventario;
  parametros.idInventarioDetalle = idInventarioDetalle;
  parametros.activo = bActivo;
  parametros.categoria = 'ELIMINADO_LOGICO_INVENTARIO_DETALLE';
  var url = "./php/inventario_detalle.php";

  		$.SmartMessageBox({
			title : "¿Esta seguro que desea dar de baja el elemento?",
			content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada a este elemento.",
			buttons : '[No][Si]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Si") {
				var response = callAjax(parametros, url);
				if(response.success == true){
					$.smallBox({
						title : 'Eliminado',
						content : "<i class='fa fa-clock-o'></i> <i>Elemento eliminado!!</i>",
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
					llenarGridInventarioDetalle(idInventario, 0);
					llenarGridInventario();
				}else{
					showMessageError(response.error);
				}
			}
			if (ButtonPressed === "No") {
				showMessageInformativo("Se cancelo la operaci&oacute;n...");
			}
		});
}