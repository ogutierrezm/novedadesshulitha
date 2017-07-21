$("#form-articulo").validate({

      // Rules for form validation
      rules : {
        nombre_articulo : {
          required : true
        }
      },

      // Messages personalizados
      messages : {
        nombre_articulo : {
          required : '*Descripci&oacute;n articulo obligatorio.'
        }
      },

      // Do not change code below
      errorPlacement : function(error, element) {
        error.insertAfter(element.parent());
      }
    });

$("#form-articulo").submit(function(e) {
  if($(this).valid()) {
    e.preventDefault();
    var url = "./php/articulos.php"; // the script where you handle the form input.
    var parametros = getFormData($("#form-articulo"));

    parametros.categoria = "ALTA_ARTICULOS";
    var response = callAjax(parametros, url);
    if(response.success == true){
        showMessageSuccess('Confirmacion','Alta de articulos satisfactoria!!');
    }else{
      showMessageError(response.error);
    }
  }
});

function llenarGridArticulos(){
    var parametros = {};
    var url = "./php/articulos.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_ARTICULOS";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyArticulos").html(response.data.html);  
    }else{
      showMessageError(response.error);
    }
}

function editArticulo(id){
    var parametros = {};
    var url = "./php/articulos.php"; // the script where you handle the form input.
    parametros.id = id;
    parametros.categoria = "CONSULTA_INFO_ARTICULO";
    var response = callAjax(parametros, url);

  if(response.success == true){
    var info = response.data.info[0];
      $("#idArticulo").val(info.id_articulo);
      $("#nombre_articulo").val(info.descripcion);
      $("#costo_venta_articulo	").val(info.costo_unitario_venta);
    }else{
      showMessageError(response.error);
    }
}

function eliminadoLogicoArticulos(id, bActivo){
  var parametros = {}
  parametros.id = id;
   parametros.activo = bActivo;
  parametros.categoria = 'ELIMINADO_LOGICO_ARTICULOS';
  var url = "./php/articulos.php";

    $.SmartMessageBox({
      title : "¿Esta seguro que desea dar de baja el elemento?",
      content : "Al realizar la operaci&oacute;n podria afectar informaci&oacute;n relacionada a este elemento.",
      buttons : '[No][Si]'
    }, function(ButtonPressed) {
      if (ButtonPressed === "Si") {
        var response = callAjax(parametros, url);
        if(response.success == true){
          var info = response.data.info[0];
          var mensaje = "";
          if(info.valida == 1){
            mensaje = "Articulo tiene inventario asignado!!"
            showMessageInformativo(mensaje);
          }else{
            mensaje = "Articulo eliminado!!";
            showMessageSuccess('Eliminado', mensaje);
          }
        }else{
          showMessageError(response.error);
        }
      }
      if (ButtonPressed === "No") {
        showMessageInformativo("Se cancelo la operaci&oacute;n...");
      }
    });
  }

  function reactivarArticulo(id, bActivo){
    var parametros={}
    parametros.id=id;
    parametros.activo = bActivo;
    parametros.categoria = 'ELIMINADO_LOGICO_ARTICULOS';
    modalActiveItem(parametros, './php/articulos.php');
  }