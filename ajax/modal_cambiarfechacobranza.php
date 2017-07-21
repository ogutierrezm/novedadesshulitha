<!--script src="js/plugin/jquery-form/jquery-form.min.js"></script-->

<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
				<div>
					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body no-padding">
						<form action="" id="admon_asentamiento" class="smart-form" novalidate="novalidate">
								<header>
									<h3>Modificar d&iacute;a de cobranza</h3>
								</header>
								<fieldset>									 
									<div class="row">										
										<section class="col col-3">
											<label class="label"><sup>*</sup>Folio de pedido</label>
											<label class="input">
												<input type="text" id="idFolioPedido" name="idFolioPedido" placeholder="#1" onkeypress='isNumber(event); validaEnterConsultar(event,"idBuscarCteId");' disabled = "disabled">
											</label>
										</section>
										<section class="col col-3">
											<label class="label"><sup>*</sup>Fecha Inicio</label>			
											<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
												<input type="text" id="idFecha" name="idFecha" placeholder="Seleccionar" class="datepicker" data-dateformat='yy-mm-dd' onkeypress="return false;"  onfocus="this.select();" disabled = "disabled">
											</label>										
										</section>
										<section class="col col-3">
											<label class="label"><sup>*</sup>Fecha a Cobrar</label>			
											<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
												<input type="text" id="idFechaCobro" name="idFechaCobro" placeholder="Seleccionar" class="datepicker" data-dateformat='yy-mm-dd' onkeypress="return false;"  onfocus="this.select();">
											</label>										
										</section>
									</div>
								</fieldset>							
								<footer>
									<button type="button" class="btn btn-primary" onclick="return modificarFechaCobranza();">
										<i class="fa fa-save"></i>&nbsp;Guardar
									</button>
									<button type="button" class="btn btn-default" onclick="LimpiarModificacionFecha();">
										Cancelar
									</button>
								</footer>
							</form>
					</div>
				</div>
			</div>
		</article>
	</div>
</section>
<script src="js/plugin/jquery-form/jquery-form.min.js"></script>
<script type="text/javascript"> 
	CargarPlugins(pagefunction);
	
	
	function CargarPlugins(pagefunction){
		// load related plugins		
		loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
			loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
				loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
					loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
						loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
					});
				});
			});
		});
	}

	var foliopedido = "<?php echo isset($_GET['id'])?$_GET['id']:0; ?>";
	var fecha = "<?php echo isset($_GET['d'])?$_GET['d']:0; ?>";
	//var fechaHoy = "<?php echo date('Y-m-d'); ?>";
	
	// Date Range Picker
	$("#idFecha").datepicker({
		defaultDate: "w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		numberOfMonths: 1,
		prevText: '<i class="fa fa-chevron-left"></i>',
		nextText: '<i class="fa fa-chevron-right"></i>',
		onClose: function (selectedDate) {
			$("#idFecha").datepicker("option", "minDate", selectedDate);
		}

	});
	$("#idFechaCobro").datepicker({
		defaultDate: "w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		numberOfMonths: 1,
		prevText: '<i class="fa fa-chevron-left"></i>',
		nextText: '<i class="fa fa-chevron-right"></i>',
		onClose: function (selectedDate) {
			$("#idFechaCobro").datepicker("option", "minDate", fecha);
		}
	});
	
	

	$("#idFolioPedido").val(foliopedido);
	$("#idFecha").val(fecha);
	$("#idFechaCobro").val(fecha);
</script>