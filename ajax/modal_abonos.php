<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<style type="text/css">
	.ui-autocomplete { z-index:2147483647 !important;}
</style>
<script src="js/piscis/abonos.js"></script>

<script>
	var id = <?php echo isset($_REQUEST['id'])?$_REQUEST['id']:0; ?>;

		$("#idFolioPedido").val(id);
		
		editAbonos(id);
		//$("#headerModal").html('Abonos a la Factura: ' + id);

</script>
<section id="widget-grid" class="">
	<!-- START ROW -->
	<div class="row">
		
		<!-- NEW COL START -->
		<article class="col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-4" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
				
				<!-- widget div-->
					<div>

						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->

						</div>
						<!-- end widget edit box -->

						<!-- widget content -->
						<div class="widget-body no-padding">
								<form action="" id="form-abono" class="smart-form">
									<header>
										<h3 id='headerModal' style="color:black;"></h3>
									</header>
									<!-- cabecero --><!-- -->								 
									<!-- Alta de Proveedores -->
									<fieldset>									
									<!-- begin row-->
										<div class="row">
											<section class="col col-xs-12 col-12">
												<div class="table-responsive" >
													<section class="col col-2" >
														<label class="label">Plazo Cr&eacute;dito:</label>
															<label class="input">
																<input type = "text" id = "desc_plazo" name = "desc_plazo" readonly="readonly" />								
															</label>
													</section>
													<section class="col col-3" >
														<label class="label">Periodo de pago:</label>
															<label class="input">
																<input type = "text" id = "desc_periodo" name = "desc_periodo" readonly="readonly" />	
															</label>
													</section>
													<section class="col col-3" >
														<label class="label">Abonos realizados:</label>
															<label class="input">
																<i class="icon-prepend fa fa-dollar"></i>
																<input type = "text" id = "total_abonos" name = "total_abonos" readonly="readonly" />	
															</label>
													</section>
												</div>
											</section>
										</div>
										<div class="row">
											<input type="hidden" id = "idFolioPedido" name = "idFolioPedido"/>
											<section class="col col-xs-12 col-12">
												<div class="table-responsive" >
													<section class="col col-3" >
														<label class="label">Total liquidar:</label>
															<label class="input">
															<i class="icon-prepend fa fa-dollar"></i>
																<input type = "text" id = "total_pagar" name = "total_pagar" readonly="readonly" />	
															</label>
													</section>
													<section class="col col-3" style="display: none">
														<label class="label">Total Pronto pago:</label>
															<label class="input">
															<i class="icon-prepend fa fa-dollar"></i>
																<input type = "text" id = "total_pronto_pago" name = "total_pronto_pago" readonly="readonly" />	
															</label>
													</section>
												<section class="col col-3">	
														<label class="label">Abono</label>
															<label class="input">
																<i class="icon-prepend fa fa-dollar"></i>
																<input type = "text" id = "abono_propuesto" name = "abono_propuesto"/>
															</label>
													</section>
												</div>
											</section>
									</div>
									<div class="row">
											<section class="col col-xs-11 col-11" style="width:100% !important">
												<div class="table-responsive" >
													<section class="col col-11" style="width:100% !important">	
														<label class="label">Cobrador</label>
															<label class="input">
																<input type = "text" id = "cobrador" name = "cobrador"/>
																<input type = "hidden" id="id_cobrador" name="id_cobrador" />
															</label>
													</section>
												</div>
											</section>
										</div>
			     					<div class="row">
										<section class="col col-12">
											<div class="table-responsive">	
												<section class="col col-12">
													<button id='btnGrabar' type="submit" class="btn btn-primary btn-lg" >Grabar</button>
													<button type="button" class="btn btn-default btn-lg" id='btnCancelarModal' onclick="closeModal();">Cancelar</button>
												</section>                        
											</div>
										</section>
									</div>
									<!-- end row -->
									</fieldset>
								</form>
								<div >
									<fieldset>
									<section class="col col-11">
											<div class="table-responsive">	
											<table id="dt_basic_abonos_factura" class="table table-striped table-bordered table-hover" >
												<thead>
													<tr>
														<th>USUARIO ADMINISTRADOR</th>
														<th>ABONO</th>
														<th>COBRADOR</th>
														<th>FECHA ABONO</th>
														<th>Acciones</th> 
													</tr>
												</thead>
												<tbody id="tbodyFacturaAbonos"></tbody>
										</table>
										</div>
										</section>
									</fieldset>
								</div>	
						</div>
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
			</div>
 
		<!-- END COL -->

</section> <!-- seccion -->
<script src="js/plugin/jquery-form/jquery-form.min.js"></script>
<script type="text/javascript"> 

	pageSetUp();		
	// PAGE RELATED SCRIPTS

	// valida caracteres de entrada
	function valida_entrada(ob) {
	  var invalidChars = /[^0-9]/gi
	  if(invalidChars.test(ob.value)) {
	            ob.value = ob.value.replace(invalidChars,"");
	      }
	}
	
	var pagefunction = function() {

	/* Tabla ;*/
			var responsiveHelper_dt_basic = undefined;			 
			
			var breakpointDefinition = {
				tablet : 1024,
				phone : 480
			};

			$('#dt_basic_abonos_factura').dataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic_abonos_factura'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_dt_basic.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_dt_basic.respond();
				}
			});
			 
	/* END Tabla */

		
		// Spinners			
		$("#spinner-currency").spinner({
		    min: 1,
		    max: 5000,
		    step: 1,
		    start: 1,
		    numberFormat: "C"
		});	
	};
	// Load form valisation dependency 
	
	var pagedestroy = function(){
		 
		// destroy spinner
		$( ".spinner" ).spinner("destroy");
	};
	
	llenarGridAbonos(id);
	
	// load related plugins tabla	
	loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
		loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
			loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
				loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
					loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
				});
			});
		});
	});
</script>