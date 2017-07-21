var responsePuestoAjax = variableAutoCompletePuesto();

function llenarGridVendedores(){
    var parametros = {};
    var url = "./php/vendedores.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_VENDEDORES";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyVendedores").html(response.data.html);  
    }else{
      showMessageError(response.error);
    }
}

// this is the id of the form
$("#form-vendedores").submit(function(e) {
  if($(this).valid()) {
    e.preventDefault();
    var url = "./php/vendedores.php"; // the script where you handle the form input.
    var parametros = getFormData($("#form-vendedores"));

    parametros.categoria = "ALTA_VENDEDORES";
    var response = callAjax(parametros, url);
    
    if(response.success == true){
        showMessageSuccess('Confirmacion','Alta de vendedores satisfactoria!!');
        $('#form-vendedores').find('input:text').val('');
    }else{
      showMessageError(response.error);
    }
  }
});

function editVendedor(id){
    var parametros = {};
    var url = "./php/vendedores.php"; // the script where you handle the form input.
    parametros.id_vendedor = id;
    parametros.categoria = "CONSULTA_INFO_VENDEDORES";
    var response = callAjax(parametros, url);
  if(response.success == true){
    var info = response.data.info[0];
      $("#id_vendedor").val(info.id_vendedor);
      $("#id_puesto").val(info.id_puesto);
      $("#nombre").val(info.nombre);
      $("#puesto").val(info.puesto);
      $("#domicilio").val(info.domicilio);
      $("#fecha_nacimiento").val(info.fecha_nacimiento);
    }else{
      showMessageError(response.error);
    }
}


function eliminadoLogicoVendedores(id, bActivo){
  var parametros = {}
  parametros.id_vendedor = id;
  parametros.categoria = 'ELIMINADO_LOGICO_VENDEDORES';
  parametros.activo = bActivo;
  var url = "./php/vendedores.php";
  modalDeleteItem(parametros, url);
}
function reactivarItem(id, bActivo){
    var parametros = {}
  parametros.id_vendedor = id;
  parametros.categoria = 'ELIMINADO_LOGICO_VENDEDORES';
  parametros.activo = bActivo;
  var url = "./php/vendedores.php";
  modalActiveItem(parametros, url);
  
}

function variableAutoCompletePuesto(){
	var parametros = {};
	parametros.categoria = 'AUTOCOMPLETE_PUESTO_VENDEDOR';
	parametros.term = '';
	var url = './php/vendedores.php'
	return callAjax(parametros, url);
}

jQuery("#puesto").autocomplete({
    source: function (request, respond) {
	    respond(
	    	$.ui.autocomplete.filter(
					responsePuestoAjax.data.info,
					extractLast(request.term)
				)
	    	);
    },
    minLength: 3,
    open: function() {  },
    change: function(event, ui){
      if (ui.item == null) {
          $(this).val('');
          $("#id_puesto").val("");
        } else {
            $(this).val(ui.item.value);
            $("#id_puesto").val(ui.item.id);
        }
    },
    close : function(event, ui) { },    
    focus: function(event,ui) {
        if ( ui.item == null ){
            $(this).val('');
            $("#id_puesto").val("");
          }else{
            $(this).val(ui.item.value);
            $("#id_puesto").val(ui.item.id); 
          }
    },
    select: function(event, ui) {
    	$("#puesto").val(ui.item.value);
    	$("#id_puesto").val(ui.item.id);
    }
});

 
    $( "#fecha_nacimiento" ).datepicker({ dateFormat: 'yy-mm-dd' });


    $("#form-vendedores").validate({

      // Rules for form validation
      rules : {
        nombre : {
          required : true
        },
        puesto:{
          required: true
        },
        domicilio:{
          required:true
        },
        fecha_nacimiento:{
          required:true
        }
      },

      // Messages personalizados
      messages : {
        nombre : {
          required : '*Nombre vendedor obligatorio.'
        },
        puesto:{
          required: '*Puesto del vendedor obligatorio.'
        },
        domicilio:{
          required: '*Domicilio del vendedor obligatorio.'
        },
        fecha_nacimiento:{
          required: '*Fecha de nacimiento obligatorio.'
        }
      },

      // Do not change code below
      errorPlacement : function(error, element) {
        error.insertAfter(element.parent());
      }
    });