// this is the id of the form
$("#form-proveedores").submit(function(e) {
  if($(this).valid()) {
    e.preventDefault();
    var url = "./php/proveedores.php"; // the script where you handle the form input.
    var parametros = getFormData($("#form-proveedores"));

    parametros.categoria = "ALTA_PROVEEDORES";
    var response = callAjax(parametros, url);
    
    if(response.success == true){
        showMessageSuccess('Confirmacion','Alta proveedor satisfactoria!!');
        $('#form-proveedores').find('input:text').val('');
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
  if(response.success == true){
    var info = response.data.info[0];

      $("#iduProveedor").val(info.idproveedor);
      $("#claveProveedor").val(info.clave_proveedor);
      $("#nombreProveedor").val(info.nombre_proveedor);
      $("#razonSocialProveedor").val(info.razon_social);
      $("#direccionProveedor").val(info.direccion);
      $("#rfcProveedor").val(info.rfc);
      $("#telefonoProveedor").val(info.telefono);
      $("#emailProveedor").val(info.email);
    }
}

function reactivarItem(id, bActivo){
  var parametros = {}
  parametros.idProveedor = id;
  parametros.categoria = 'ELIMINADO_LOGICO_PROVEEDORES';
  parametros.activo = bActivo;
  var url = "./php/proveedores.php";
  modalActiveItem(parametros, url);
  
}

function llenarGridProveedores(){
    var parametros = {};
    var url = "./php/proveedores.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_PROVEEDORES";
    var response = callAjax(parametros, url);
    if(response.success == true){
      $("#tbodyProveedores").html(response.data.html);  
    }else{
      showMessageError(response.error);
    }
}

function eliminadoLogicoProveedores(id, bActivo){
  var parametros = {}
  parametros.idProveedor = id;
  parametros.activo = bActivo;
  parametros.categoria = 'ELIMINADO_LOGICO_PROVEEDORES';
  var url = "./php/proveedores.php";
  modalDeleteItem(parametros, url);
}

    $("#form-proveedores").validate({

      // Rules for form validation
      rules : {
        claveProveedor : {
          required : true
        },
        razonSocialProveedor:{
          required:true
        },
        direccionProveedor:{
          required:true
        },
        rfcProveedor:{
          required:true
        }

      },

      // Messages personalizados
      messages : {
        claveProveedor : {
          required : '*Campo obligatorio.'
        },
        razonSocialProveedor:{
          required: 'Razon Social obligatorio'
        },
        direccionProveedor:{
          required: 'Direccion obligatorio'
        },
        rfcProveedor:{
          required:'RFC obligatorio'
        }
      },

      // Do not change code below
      errorPlacement : function(error, element) {
        error.insertAfter(element.parent());
      }
    });