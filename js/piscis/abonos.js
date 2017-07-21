var responseCobradorAutoComplete = variableAutoCompleteCobrador();

jQuery("#cobrador").autocomplete({
    source: function (request, respond) {
      respond(
        $.ui.autocomplete.filter(
          responseCobradorAutoComplete.data.info,
          extractLast(request.term)
        )
        );
    },
    minLength: 3,
    open: function() {  },
    change: function(event, ui){
      if (ui.item == null) {
          $(this).val('');
          $("#id_cobrador").val("");
        } else {
            $(this).val(ui.item.value);
            $("#id_cobrador").val(ui.item.id);
        }
    },
    close : function() {   
        if ($("#cobrador").val()==""){
            $(this).val('');
            $("#id_cobrador").val("");
          }
    },    focus: function(event,ui) {},
    select: function(event, ui) {
      $("#cobrador").val(ui.item.value);
      $("#id_cobrador").val(ui.item.id);
    }
});

function variableAutoCompleteCobrador(){
  var parametros = {};
  parametros.categoria = 'AUTOCOMPLETE_PUESTO_COBRADOR';
  parametros.term = '';
  var url = './php/abonos.php'
  return callAjax(parametros, url);
}


function llenarGridAbonos(id){
    var parametros = {};
    var url = "./php/abonos.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_ABONOS";
    parametros.id=id;
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyFacturaAbonos").html(response.data.html);  
    }else{
      showMessageError(response.error);
    }
}

function llenarGridFactuasPendientes(){
    var parametros = {};
    var url = "./php/abonos.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_FACTURAS_PENDIENTES";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyAbonos").html(response.data.html);  
    }else{
      showMessageError(response.error);
    }
}

function editAbonos(id){
    var parametros = {};
    var url = "./php/abonos.php"; // the script where you handle the form input.
    parametros.id = id;
    parametros.categoria = "CONSULTA_INFO_ABONOS";
    var response = callAjax(parametros, url);

  if(response.success == true){
    var info = response.data.info[0];

      $("#desc_plazo").val(info.desc_plazo);
      $("#desc_periodo").val(info.desc_periodo);
      $("#total_abonos").val(info.total_abonos);
      $("#total_pagar").val(info.total_pagar);
      $("#total_pronto_pago").val(info.pronto_pago);
      $("#abono_propuesto").val(info.propuesta_abono);
      $("#cobrador").val("");
      
      var header = "Factura: "+id+" | Num. Contrato: "+info.num_contrato+ " | Num. Papeleta: "+info.num_papeleta;
      $("#headerModal").html(header);
    }else{
      showMessageError(response.error);
    }
}

$("#form-abono").validate({

      // Rules for form validation
      rules : {
        abono_propuesto : {
          required : true,
          soloNumerosFloat: true
        },
        cobrador:{
        	required: true
        }
      },

      // Messages personalizados
      messages : {
        abono_propuesto : {
          required : '*Abono obligatorio.'
        },
        cobrador:{
        	required: '*Cobrador obligatorio.'
        }
      },

      // Do not change code below
      errorPlacement : function(error, element) {
        error.insertAfter(element.parent());
      }
    });

$("#form-abono").submit(function(e) {
  if($(this).valid()) {

    e.preventDefault();

    var parametros = getFormData($("#form-abono"));
    parametros.pago_completo = 0;

    var id = parametros.idFolioPedido;
    //VALIDO SI ABONO PROPUESTO ES MAYOR AL TOTAL LIQUIDAR O TOTAL PRONTO PAGO
    if( ( parseFloat( $("#abono_propuesto").val() ) > parseFloat( $("#total_pagar").val() ) ) 
      //|| ( parseFloat( $("#abono_propuesto").val() ) > parseFloat( $("#total_pronto_pago").val() ) ) 
      ){
      showMessageError("El abono debe ser menor o igual a total liquidar!!");
      return;
    }
    if( (parseFloat($("#abono_propuesto").val()) == parseFloat($("#total_pagar").val())) 
      //|| (parseFloat($("#abono_propuesto").val()) == parseFloat($("#total_pagar").val()) )
      ){
      parametros.pago_completo = 1;
    }
    var url = "./php/abonos.php";    

    parametros.categoria = "ALTA_ABONOS";
    var response = callAjax(parametros, url);
    if(response.success == true && parametros.pago_completo == 1){
        showMessageSuccess('Confirmacion','Alta de abonos satisfactoria!!');
    }else if(response.success == true && parametros.pago_completo == 0){

      $.smallBox({
        title : 'Confirmacion',
        content : "<i class='fa fa-clock-o'></i> <i>Abono realizado satisfactoriamente!!</i>",
        color : "#659265",
        iconSmall : "fa fa-check fa-2x fadeInRight animated",
        timeout : 4000
      });
      editAbonos(id);
      llenarGridAbonos(id);
      llenarGridFactuasPendientes();
    }else{
      showMessageError(response.error);
    }
  }
});

function cancelarAbonos(id){
    var url = "./php/abonos.php"; // the script where you handle the form input.
    var parametros = {};
    parametros.idAbono = id;
    parametros.categoria = "CANCELAR_ABONO";
    var response = callAjax(parametros, url);
    if(response.success == true){
      var idFolioPedido = $("#idFolioPedido").val();
      editAbonos(idFolioPedido);
      llenarGridAbonos(idFolioPedido);
      $.smallBox({
        title : 'Confirmacion',
        content : "<i class='fa fa-clock-o'></i> <i>Abono cancelado satisfactoriamente!!</i>",
        color : "#659265",
        iconSmall : "fa fa-check fa-2x fadeInRight animated",
        timeout : 4000
      });


    }else{
      showMessageError(response.error);
    }
}

function llenarGridAbonosReporte(){
    var parametros = {};
    var url = "./php/abonos.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_ABONOS_REPORTE";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyAbonosReporte").html(response.data.html);  
      var total = "$"+response.data.total_abonado;
      $("#lblTotal").html(total);
    }else{
      showMessageError(response.error);
    }
}

function llenarGridAbonosReporte_2(){
    var parametros = {};
    var url = "./php/abonos.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_ABONOS_REPORTE_2";
    var response = callAjax(parametros, url);
  if(response.success == true){
      $("#tbodyAbonosReporte").html(response.data.html);
      var total = "$"+response.data.total_abonado;
      $("#lblTotal").html(total);
    }else{
      showMessageError(response.error);
    }
}


function llenarGridAbonosReporteRangosFechas(){
    var parametros = {};
    var url = "./php/abonos.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_ABONOS_REPORTE";
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
      $("#tbodyAbonosReporte").html(response.data.html);  
      var total = "$"+response.data.total_abonado;
      $("#lblTotal").html(total);
      pageConstruirGridAbonos();
      $("#btnRptEficiencia").attr("disabled","disabled");
    }else{
      showMessageError(response.error);
    }
}

function llenarGridAbonosReporteRangosFechas_2(){
    var parametros = {};
    var url = "./php/abonos.php"; // the script where you handle the form input.
    parametros.categoria = "LLENAR_GRID_ABONOS_REPORTE_2";
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
      $("#tbodyAbonosReporte").html(response.data.html);  
      var total = "$"+response.data.total_abonado;
      $("#lblTotal").html(total);
      pageConstruirGridAbonos();
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
