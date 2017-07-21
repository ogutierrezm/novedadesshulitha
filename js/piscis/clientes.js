// this is the id of the form
$("#frm_cliente").submit(function(e) {
  if($(this).valid()) {
    e.preventDefault();
    var url = "./php/colonias.php"; // the script where you handle the form input.
    var parametros = getFormData($("#frm_cliente"));
	
	console.log(parametros);

    parametros.categoria = "ALTA_COLONIAS";
    var response = callAjax(parametros, url);
    
    if(response.data.code == 'SUCCESS'){
        showMessageSuccess('Confirmacion','Alta proveedor satisfactoria!!');
        $('#frm_cliente').find('input:text').val('');
        $('.modal').modal('hide');
        
    }else{
      showMessageError(response.error);
    }
  }
});

function editProveedor(idProveedor){
    var parametros = {};
    var url = "./php/proveedores.php"; // the script where you handle the form input.
    parametros.idProveedor = idProveedor;
    parametros.categoria = "CONSULTA_INFO_PROVEEDORES";
    var response = callAjax(parametros, url);
  if(response.data.code == 'SUCCESS'){
    var info = response.data.info[0];
      
      $("#iduProveedor").val(info.idproveedor);
      $("#claveProveedor").val(info.clave_proveedor);
      $("#nombreProveedor").val(info.nombre_proveedore);
      $("#razonSocialProveedor").val(info.razon_social);
      $("#direccionProveedor").val(info.direccion);
      $("#rfcProveedor").val(info.rfc);
      $("#telefonoProveedor").val(info.telefono);
      $("#emailProveedor").val(info.email);
    }
}

function llenarGridProveedores(){
    var parametros = {};
    var url = "./php/proveedores.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_PROVEEDORES";
    var response = callAjax(parametros, url);
  if(response.data.code == 'SUCCESS'){
      $("#tbodyProveedores").html(response.data.html);  
    }else{
      showMessageError(response.error);
    }
}

function eliminadoLogicoProveedores(idProveedor){
  var parametros = {}
  parametros.idProveedor = idProveedor;
  parametros.categoria = 'ELIMINADO_LOGICO_PROVEEDORES';
  var url = "./php/proveedores.php";
  modalDeleteItem(parametros, url);
}

    $("#frm_cliente").validate({

      // Rules for form validation
      rules : {
        cpModal : {
          required : true
        },
        coloniaModal:{
          required: true
        },
        municipioModal:{
          required:true
        },
        SelectZonaModal:{
          required:true
        }

      },

      // Messages personalizados
      messages : {
        cpModal : {
          required : '*Codigo postal obligatorio.'
        },
        coloniaModal:{
          required: '*Colonia obligatoria'
        },
        municipioModal:{
          required: '*Municipio obligatorio'
        },
        SelectZonaModal:{
          required: 'Elija una zona obligatorio'
        }
      },

      // Do not change code below
      errorPlacement : function(error, element) {
        error.insertAfter(element.parent());
      }
    });
	
	
	/*var parametros = getFormData($("#frm_cliente"));
	var url = "./php/cliente.php";
	parametros.categoria = "CONSULTAR_CLIENTES";
    var response = callAjax(parametros, url);
    console.log(response);
    if(response.success){
		$('#tbodyClientes').append(response.data);
    }else{
      showMessageError(response.error);
    }*/