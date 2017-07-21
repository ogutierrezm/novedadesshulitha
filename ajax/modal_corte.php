<script src="js/piscis/corte.js"></script>
<script type="text/javascript">
	var id = <?php  echo $_REQUEST['id'];?>;
	llenarGridCorteAnterioresDetalle(id);
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
						<!-- end widget edit box -->

						<!-- widget content -->
						<fieldset>
							<legend>Informaci&oacute;n detalle del Corte</legend>
							
						</fieldset>
								<div class="widget-body no-padding">
									<fieldset>
									<section class="col col-11">
											<div class="table-responsive">	
											<table id="dt_grid" class="table table-striped table-bordered table-hover" >
												<thead>
													<tr>
														<th>USUARIO</th>
														<th>TOTAL VENDIDO</th>
														<th>TOTAL ABONOS</th>
														<th>TOTAL DESCUENTOS</th>
														<th>TOTAL COMPRAS PROVEEDOR</th> 
														<th>TOTAL GASTOS</th> 
														<th>TOTAL DEVOLUCIONES PROVEEDOR</th>  
														<th>TOTAL CANCELACIONES VENTAS</th> 
													</tr>
												</thead>
												<tbody id="tbodyCorteDetalle"></tbody>
										</table>
										</div>
										</section>
									</fieldset>
								</div>	

						</div>
     					<div class="row">
							<section class="col col-12">
								<div class="table-responsive">	
									<section class="col col-10">
										<button type="button" class="btn btn-default btn-lg" id='btnCancelarModal' style="float:right" onclick="closeModal();">Cerrar</button>
									</section>
								</div>
							</section>
						</div>
					</div>
				</article>
					<!-- end widget content -->
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

			$('#dt_grid').dataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_grid'), breakpointDefinition);
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
	};	
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