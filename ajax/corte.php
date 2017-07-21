<?php 
session_start();
	
if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
?>
<script type="text/javascript" src ="js/piscis/corte.js"></script>

	<div class="row">
			<div class="col-sm-12 col-md-12">
				<fieldset>
					<legend style="padding-left:3%">
						Generar Corte
					</legend>
				</fieldset>
			</div>
	</div>
	<div class="row" style = "padding-bottom: 10px">
		<div class="col-sm-12 col-md-12" style="padding-left:4%">
			<button id="btnRealizarCorte" class="btn btn-primary" type="button" onClick ="realizarCorte()">
				<i class="fa fa-refresh"></i>&nbsp;	Realizar Corte
			</button>
		</div>
	</div>
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
								<table id="dt_basic" class="table table-striped table-bordered table-hover" >
									<thead>
										<tr>
											<!--th>ID</th-->
											<th>NOMBRE USUARIO</th>
											<th>TOTAL VENDIDO</th>
											<th>TOTAL ABONOS</th>
											<th>TOTAL DESCUENTOS</th>
											<th>TOTAL COMPRAS PROVEEDOR</th>
											<th>TOTAL GASTOS</th>
											<th>TOTAL DEVOLUCIONES PROVEEDOR</th>
											<th>TOTAL CANCELACIONES COMPRAS</th>
										</tr>
									</thead>
									<tbody id="tbodyPreCorte"></tbody>
								</table>
						</div>
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
			</div>
		<!-- END COL -->

</section> <!-- seccion -->
<script src="js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="js/plugin/jqgrid/grid.locale-en.min.js"></script>
 
<!-- SCRIPTS ON PAGE EVENT -->
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
	function cargarConfiguracionGridCorte(){
		var pagefunction = function() {

		/* Tabla ;*/
				var responsiveHelper_dt_basic = undefined;			 
				
				var breakpointDefinition = {
					tablet : 1024,
					phone : 480
				};
				$('#dt_basic').dataTable().fnDestroy();

				$('#dt_basic').dataTable({
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"autoWidth" : true,
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
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
	}

	realizarPreCorte();
	cargarConfiguracionGridCorte();
</script>