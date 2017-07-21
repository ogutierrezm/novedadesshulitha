ForceNumericOnly($(".solonumero"));
var url = "./php/mermas.php"; // the script where you handle the form input.

function llenarGridMermas(){
	var parametros = {};
    parametros.categoria = "LLENAR_GRID_MERMAS";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyMermas").html(response.data.info);  
    }else{
      showMessageError(response.error);
    }
}

function consultaInformacionArticulosMermas(){
	if( $("#foliofactura").val() == "" ){
		$("#foliofactura").focus();
		showMessageError("Es necesario proporcioar N&uacute;mero de Factura!!");
	}else{
		$("#foliopedido").attr("readonly", true);
		var parametros = {};
		parametros.categoria = "CONSULTA_INFORMACION_ARTICULOS_MERMA";
		parametros.id = $("#foliofactura").val();
		var response = callAjax(parametros, url);
		var detalleMermaOnClick = "";
	    if(response.success == true){
	    	var infoFactura = response.data.info;

			var title = "";
			var body = "";
			var bodyFull = "";
			var mostrarInformacion = "";
			var styleAncla = "cursor:default;color:red;";
			var informacionMerma = " - Articulo no puede convertir a merma.";
			$.each(infoFactura, function(key, value){
				  
			      if(value.esmerma == 0){
			      	mostrarInformacion = "#collapse"+value.keyx;
			      	styleAncla = "cursor:pointer;";
			      	informacionMerma = "";
			      body = 
			      		'<div id="collapse'+value.keyx+'" class="panel-collapse collapse accordion_'+value.keyx+'" style="overflow:hidden;">'+
			      			'<div class="panel-body"> '+
				      			'<div class="row">'+
									'<section class="col col-xs-11 col-11">'+
										'<div class="table-responsive" >'+
											'<section class="col col-8" >	'+
												'<label class="label">Descripci&oacute;n Articulo</label>'+
													'<label class="input">'+
														'<input type = "text" id = "nombre_articulo" name = "nombre_articulo" value = "'+value.descripcion+'" disabled />'+
													'</label>'+
											'</section>'+
											'<section class="col col-4" >'+
												'<label class="label">Costo Unitario Compra</label>'+
													'<label class="input">'+
														'<input type = "text" id = "costo_unitario_compra_'+value.id_articulo+'" name = "costo_unitario_compra" class="solonumero"/>'+
													'</label>'+
											'</section>'+
										'</div>'+
									'</section>'+
								'</div>'+
								'<div class="row">'+
									'<section class="col col-xs-11 col-11">'+
										'<div class="table-responsive" >'+
											'<section class="col col-4" >'+
												'<label class="label">Veces Ganancia</label>'+
													'<label class="input">'+
														'<input class = "spinner" name="veces_ganancia" id ="veces_ganancia_'+value.id_articulo+'" readonly value = "3.5">'+
													'</label>'+
											'</section>'+
											'<section class="col col-2">'+
												'<label class="label">&nbsp;'+
													'<label class="input">'+
															'<button type="button" class="btn btn-xs btn-success" id="btnRecalcularCostoVenta" onClick="recalcularCostoVenta('+value.id_articulo+');">'+
															  '<span class="glyphicon glyphicon-random" title="Recalcular Costo Venta"></span>'+
															'</button>'+
													'</label>'+
												'</label>'+
											'</section>'+
											'<section class="col col-5" >'+
												'<label class="label">Costo de Venta</label>'+
													'<label class="input">'+
														'<input name="costo_venta_'+value.id_articulo+'" id ="costo_venta_'+value.id_articulo+'" readonly class="solonumero">'+
													'</label>'+
											'</section>'+
										'</div>'+
									'</section>'+
								'</div>'+
								'<div class="row">'+
									'<section class="col col-xs-11 col-11">'+
										'<div class="table-responsive" >'+
											'<section class="col col-11" >'+
												'<button class="btn btn-primary btn-md" style="float:right;" '+
												' onClick="crearArticuloMerma('+value.id_articulo+', '+value.cantidad+', '+value.keyx+');">'+
												'Grabar Articulo Merma</button>'+
											'</section>'+
										'</div>'+
									'</section>'+
								'</div>'+
							'</div>'+
						'</div>';
				}
				title ='<h4 class="panel-title accordion_'+value.keyx+'" >'+
			        '<a data-toggle="collapse"  data-parent="#accordion" href="'+mostrarInformacion+'" style = "padding-left:3px; margin-bottom: 3px;'+styleAncla+'">'+value.descripcion+" - Cantidad: "+ value.cantidad + " "+informacionMerma+'</a>'+
			      '</h4>';
						bodyFull += 
								  '<div class="panel panel-default">'+
			    					'<div class="panel-heading" style="overflow: hidden;">'+
			    						title +
			    					'</div>'+
			    					body+
			  					'</div>';
			});
			if( title == "" ){
				showMessageError("N&uacute;mero de Factura sin informaci&oacute;n y/o no valida!!");
				$("#foliofactura").val("").focus();
				return;
			}
			var html = '<div class="panel-group" id="accordion">'+
				bodyFull +
			'</div>';

			$("#informacionArticulosMermas").html(html);
			ForceNumericOnly($(".solonumero"));
			var spinner = $( ".spinner" ).spinner({
							min: 2,
						  	max: 3.5,
						  	step: 0.1,
						  	icons: { down: "ui-icon-carat-1-w", up: "custom-up-icon" },
						  	change: function(event,ui){
						    	$(this).attr("value",$(this).val());
							}
						  });
		}else{
	      showMessageError(response.error);
	    }
		
	}
}

function recalcularCostoVenta(id_articulo){
	var costo_unitario_compra = $("#costo_unitario_compra_"+id_articulo).val();
	var veces_ganancia = $("#veces_ganancia_"+id_articulo).spinner( "value" );
	$("#costo_venta_"+id_articulo).val(  costo_unitario_compra * veces_ganancia );
}

function resetControlesMermas(){

}

function crearArticuloMerma(id_articulo, cantidad, keyx){

	if( $.trim( $("#costo_unitario_compra_"+id_articulo).val() ) == "" ){
		showMessageError("Obligatorio costo Unitario compra!!");
		return;
	}else if( $("costo_venta_"+id_articulo).val() == ""){
		showMessageError("Obligatorio costo venta!!");
		return;
	}else{
		var parametros = {};
		parametros.categoria = 'CREAR_ARTICULO_MERMA';
		parametros.idArticulo = id_articulo;
		parametros.cantidad = cantidad;
		parametros.veces_ganancia = $("#veces_ganancia_"+id_articulo).spinner( "value" );
		parametros.costo_unitario_compra = $("#costo_unitario_compra_"+id_articulo).val();
		parametros.costo_unitario_venta = $("#costo_venta_"+id_articulo).val();
		parametros.foliopedido = $("#foliofactura").val();

		var response = callAjax(parametros, url);
		if(response.success == true){
			$(".accordion_"+keyx).remove();
		}else{
			showMessageError("Error al realizar transpaso de mermas!!");
		}
	}

}

$("#form-merma").submit(function(e) {
  if($(this).valid()) {

    e.preventDefault();
    
  }
});

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

function llenarGridMermasReporte(){
	var parametros = {};
    parametros.categoria = "LLENAR_GRID_MERMAS_REPORTE";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyMermaReporte").html(response.data.html);  
    }else{
      showMessageError(response.error);
    }
}


function llenarGridMermaReporteRangosFechas(){
    var parametros = {};
    parametros.categoria = "LLENAR_GRID_MERMAS_REPORTE";
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
      $("#btnRptEficiencia").attr("disabled","disabled");
      $("#tbodyMermaReporte").html(response.data.html); 
      pageConstruirGridMermas();
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