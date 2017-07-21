function llenarGridDevoluciones(){
    var parametros = {};
    var url = "./php/devoluciones.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_DEVOLUCIONES";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyDevolucioneS").html(response.data.html);  
    }else{
      showMessageError(response.error);
    }
}

function realizarDevolucion(id, factura){
      $.SmartMessageBox({
      title : "¿Desea realziar devolucion de la factura: "+factura+"?",
      content : "",
      buttons : '[No][Si]'
    }, function(ButtonPressed) {
      if (ButtonPressed === "Si") {
        var url = "./php/devoluciones.php"; // the script where you handle the form input.
        var parametros = {};
        parametros.id = id;
        parametros.categoria = 'REALIZAR_DEVOLUCION';
        var response = callAjax(parametros, url);
        if(response.success == true){
            var codigos = response.data.info[0].codigos;
            if(codigos == ''){
              showMessageSuccess('Devolucion', 'Se aplico la devolucion correctamente!!');
            }else{
              var codigosSinPoderDevolver = codigos.split(' |');
              var contenido = 'El articulo siguiente no tiene existencia:\n\n';
              if(codigosSinPoderDevolver.length > 1){
                  contenido = 'Los articulos siguiente no tienen existencia:\n\n';
              }
              contenido = contenido+codigos.replace(' |',', ');
              contenido = contenido.substring(0, contenido.length-2);

              showMessageError(contenido);
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

function llenarGridDevolucionesReporte(){
    var parametros = {};
    var url = "./php/devoluciones.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_DEVOLUCIONES_REPORTE";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyDevolucionesReporte").html(response.data.html);  
    }else{
      showMessageError(response.error);
    }
}

function llenarGridDevolucionesReporteRangosFechas(){
    var parametros = {};
    var url = "./php/devoluciones.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_DEVOLUCIONES_REPORTE";
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
      $("#tbodyDevolucionesReporte").html(response.data.html); 
      pageConstruirGridDevolucion();
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
  