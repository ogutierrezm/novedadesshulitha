function llenarGridCorteAnteriores(){
    var parametros = {};
    var url = "./php/corte.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_CORTE_ANTERIORES";
    parametros.from = $("#from").val();
    parametros.to = $("#to").val();
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyCortesAnterioresReporte").html(response.data);

    }else{
      showMessageError(response.error);
    }
}
function llenarGridCorteAnterioresDetalle(id){
    var parametros = {};
    var url = "./php/corte.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_CORTE_ANTERIORES_DETALLE";
    parametros.id = id;
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyCorteDetalle").html(response.data);  
    }else{
      showMessageError(response.error);
    }
}

$('#from').datepicker({onSelect: function(selectedDate) {
        var min = $(this).datepicker('getDate') || new Date(); // Selected date or today if none
        var max = new Date(min.getTime());
        max.setMonth(max.getMonth() + 1); // Add one month
        $('#to').datepicker('option', {minDate: min, maxDate: max});
  }});
  $('#to').datepicker({onSelect: function(selectedDate) {
    var min = $(this).datepicker('getDate') || new Date(); // Selected date or today if none
        var max = new Date(min.getTime());
        max.setMonth(max.getMonth() + 1); // Add one month
        $('#from').datepicker('option', {maxDate: max});
  }});

  function llenarGridCorteAnterioresRango(){
    var parametros = {};
    var fecha_corte = $( "#fechasCorte option:selected" ).val();

    if(fecha_corte == '-1'){
      showMessageError('Seleccione una Fecha!!');
      return;
    }

    var url = "./php/corte.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_CORTE_ANTERIORES";
    parametros.fecha = fecha_corte;

    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyCortesAnterioresReporte").html(response.data);
      pageConstruirGridCortes();
      $("#btnRptEficiencia").attr("disabled","disabled");
    }else{
      showMessageError(response.error);
    }
}

function realizarPreCorte(){
    var parametros = {};
    var url = "./php/corte.php"; // the script where you handle the form input.
    parametros.categoria = "REALIZAR_PRE_CORTE";

    var response = callAjax(parametros, url);
    if( response.success == true ){
      if( response.data != ""){
        $("#tbodyPreCorte").html(response.data);
        cargarConfiguracionGridCorte();
        $("#btnRealizarCorte").show();
      }else{
        $("#btnRealizarCorte").hide();
      }
    }
}

function obtenerFechasCorte(){
    var parametros = {};
    var url = "./php/corte.php"; // the script where you handle the form input.
    parametros.categoria = "OBTENER_FECHAS_CORTE";
    var response = callAjax(parametros, url);
  if(response.success == true){
      var optionSelect = "<option value='-1' >SELECCIONE FECHA CORTE</option>";
      var optionsEach = response.data.info;
        for (var i in optionsEach) {
          for (var j in optionsEach[i]) {
           optionSelect += '<option value = "'+optionsEach[i][j]+'" >'+optionsEach[i][j]+'</option>' ;
          }
        }
        $("#fechasCorte").html(optionSelect);
    }else{
      showMessageError(response.error);
    }
}

function llenarGridPreCorte(){
    var parametros = {};
    var url = "./php/corte.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_PRE_CORTE";

    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyPreCorte").html(response.data);
      cargarConfiguracionGridCorte();
    }else{
      showMessageError(response.error);
    }
}

function realizarCorte(){
      var parametros = {};
    var url = "./php/corte.php"; // the script where you handle the form input.
    parametros.categoria = "REALIZAR_CORTE";

     $.SmartMessageBox({
      title : "<h3>¿Esta seguro que desea realziar un corte?</h3>",
      content : "",
      buttons : '[No][Si]'
    }, function(ButtonPressed) {
      if (ButtonPressed === "Si") {
        var response = callAjax(parametros, url);
        if(response.success == true){
            showMessageSuccess('Confirmacion','Corte Realizado satisfactoria!!');
          }else{
            showMessageError(response.error);
          }
      }
      if (ButtonPressed === "No") {
        showMessageInformativo("Se cancelo la operaci&oacute;n...");
      }
   });
}