  function llenarGridFacturasAbonosPendientes(){
    var parametros = {};
    var url = "./php/abonos.php"; // the script where you handle the form input.
    parametros.categoria = "ACUMULADO_FACTURAS_ABONOS_PENDIENTES";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyFacturasAbonosPendientes").html(response.data.info);  
    }else{
      showMessageError(response.error);
    }
}

function llenarGridFacturasAbonosPendienteReporteRangosFechas(){
    var parametros = {};
    var url = "./php/abonos.php"; // the script where you handle the form input.
    parametros.categoria = "ACUMULADO_FACTURAS_ABONOS_PENDIENTES";
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
      $("#tbodyFacturasAbonosPendientes").html(response.data.info);  
      pageConstruirGridFacturasPendientesAbonos();
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