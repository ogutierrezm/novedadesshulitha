  var spinner = $( "#spinner" ).spinner({
	min: 2,
  	max: 3.5,
  	step: 0.1,
  	icons: { down: "ui-icon-carat-1-w", up: "custom-up-icon" },
  	change: function(event,ui){
    	$(this).attr("value",$(this).val());
	}
  });
 
    $( "#disable" ).click(function() {
      if ( spinner.spinner( "option", "disabled" ) ) {
        spinner.spinner( "enable" );
      } else {
        spinner.spinner( "disable" );
      }
    });
    $( "#destroy" ).click(function() {
      if ( spinner.spinner( "instance" ) ) {
        spinner.spinner( "destroy" );
      } else {
        spinner.spinner();
      }
    });

$("#form-articulo_precio").validate({

      // Rules for form validation
      rules : {
        costo_unitario_compra : {
          required: true,
          min: 1
				    
        },
        veces_ganancia:{
        	required: true,
        	soloNumerosFloat:true
        },
        costo_venta:{
          required: true,
          min: 1
        }
      },

      // Messages personalizados
      messages : {
        costo_unitario_compra : {
          required : '*Costo unitario de Compra obligatorio.',
          min:'*Valor mayor a cero.'
        },
        veces_ganancia:{
        	required:'*Veces Ganancia obligatorio.'
        },
        costo_venta:{
        	required: '*Costo de Venta debe ser mayor a 0.',
        	min:'*Valor mayor a cero.'
        }
      },

      // Do not change code below
      errorPlacement : function(error, element) {
        error.insertAfter(element.parent());
      }
    });

$("#form-articulo_precio").submit(function(e) {
  if($(this).valid()) {
    e.preventDefault();
    var url = "./php/articulos_precio.php"; // the script where you handle the form input.
    var parametros = getFormData($("#form-articulo_precio"));
    parametros.categoria = "GRABAR_PRECIOS_ARTICULOS";
    var response = callAjax(parametros, url);
    
    if(response.success == true){
        showMessageSuccess('Confirmacion','El cambio precio se realizo correctamente!!');
        $('#form-articulo_precio').find('input:text').val('');
    }else{
      showMessageError(response.error);
    }
    
  }
});

function editArticuloPrecio(id){
    var parametros = {};
    var url = "./php/articulos_precio.php"; // the script where you handle the form input.
    parametros.id = id;
    parametros.categoria = "CONSULTA_ARTICULOS_PRECIO";
    var response = callAjax(parametros, url);
  if(response.success == true){
  	$("#tipoFactura").hide();
      var info = response.data.info[0];

      $("#idArticulo").val(info.id_articulo);
	    $("#idPrecio").val(info.id_precio);
      $("#nombre_articulo").val(info.descripcion_articulo);
      $("#costo_unitario_compra").val(info.costo_unitario_compra);
      
      spinner.spinner( "value", info.veces_ganancia );
      $("#costo_venta").val(info.costo_venta);

    }else{
    	showMessageError(response.error);
    }
}

$("#btnRecalcularCostoVenta").click(function(){
	var costo_unitario_compra = $("#costo_unitario_compra").val();
	var veces_ganancia = spinner.spinner( "value" );
	$("#costo_venta").val(  costo_unitario_compra * veces_ganancia );
});