$("#form-concepto").validate({

      // Rules for form validation
      rules : {
        concepto_gasto : {
          required : true
        }
      },

      // Messages personalizados
      messages : {
        concepto_gasto : {
          required : '*Concepto de gastos obligatorio.'
        }
      },

      // Do not change code below
      errorPlacement : function(error, element) {
        error.insertAfter(element.parent());
      }
    });

$("#form-concepto").submit(function(e) {
  if($(this).valid()) {
    e.preventDefault();
    var url = "./php/concepto_gastos.php"; // the script where you handle the form input.
    var parametros = getFormData($("#form-concepto"));

    parametros.categoria = "ALTA_CONCEPTO_GASTOS";
    var response = callAjax(parametros, url);
    if(response.success == true){
        showMessageSuccess('Confirmacion','Alta de concepto de gastos satisfactoria!!');
        $('#form-concepto').find('input:text').val('');
        $('.modal').modal('hide');
        
    }else{
      showMessageError(response.error);
    }
  }
});

function llenarGridConceptoGastos(){
    var parametros = {};
    var url = "./php/concepto_gastos.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_CONCEPTO_GASTOS";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyConceptoGastos").html(response.data.html);  
    }else{
      showMessageError(response.error);
    }
}

function editConceptoGastos(idConcepto){
    var parametros = {};
    var url = "./php/concepto_gastos.php"; // the script where you handle the form input.
    parametros.idConcepto = idConcepto;
    parametros.categoria = "CONSULTA_INFO_CONCEPTO_GASTOS";
    var response = callAjax(parametros, url);

  if(response.success == true){
    var info = response.data.info[0];
      $("#idConcepto").val(info.idconcepto);
      $("#concepto_gasto").val(info.concepto);
    }else{
      showMessageError(response.error);
    }
}

function eliminadoLogicoConceptoGastos(idConcepto, bActivo){
  var parametros = {}
  parametros.idConcepto = idConcepto;
   parametros.activo = bActivo;
  parametros.categoria = 'ELIMINADO_LOGICO_CONCEPTO_GASTOS';
  var url = "./php/concepto_gastos.php";
  modalDeleteItem(parametros, url);
}

function reactivarItem(id, bActivo){
    var parametros = {}
  parametros.idConcepto = id;
  parametros.categoria = 'ELIMINADO_LOGICO_CONCEPTO_GASTOS';
  parametros.activo = bActivo;
  var url = "./php/concepto_gastos.php";
  modalActiveItem(parametros, url);
  
}

function llenarGridGastosReporteRangoFecha(){
    var parametros = {};
    var url = "./php/concepto_gastos.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_CONCEPTO_GASTOS_REPORTE";
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
      $("#tbodyGastos").html(response.data.html); 
      $("#totalGastos").html( "$"+response.data.total);
      pageConstruirGridGastos();
    }else{
      showMessageError(response.error);
    }
}

function llenarGridGastosReporte(){
    var parametros = {};
    var url = "./php/concepto_gastos.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_CONCEPTO_GASTOS_REPORTE";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyGastos").html(response.data.html);
      $("#totalGastos").html( "$"+response.data.total);
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