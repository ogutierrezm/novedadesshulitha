<?php 
session_start();
	
if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
?>
<script src="js/piscis/corte.js"/>

<!-- formulario de admnistracion de inventario -->
<section id="widget-grid" class="">
<?php if(true){ ?>
	<div class="row">
			<div class="col-sm-2 col-md-2">
				<label class="select">
					<select id='fechasCorte' class="input-sm"></select>
				</label>
			</div>
			<div class="col-sm-4 col-md-4 pull-right">	 
				<fieldset> 
					<button class="btn btn-default" type="button" onClick ="window.location.reload();">
						&nbsp;	Cancelar
					</button>		
					<button id="btnRptEficiencia" class="btn btn-primary" type="button" onClick ="return llenarGridCorteAnterioresRango();">
						<i class="fa fa-refresh"></i>&nbsp;	Generar
					</button>												 
				</fieldset>
			</div>
		</div>
	<?php } ?>
	<!-- START ROW -->
	<div class="row">
	
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
								<table id="dt_basic" class="table table-striped table-bordered table-hover table-condensed" >
									<thead>
										<tr>
											<th>TOTAL VENDIDO</th>
											<th>TOTAL ABONOS</th>
											<th>TOTAL DESCUENTOS</th>
											<th>TOTAL COMPRAS PROV</th>
											<th>TOTAL GASTOS</th>
											<th>TOTAL DEV. PROV</th>
											<th>TOTAL CANC. VTAS</th>
											<th>FECHA CORTE</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody id="tbodyCortesAnterioresReporte">
																 						 
									</tbody>
								</table>
						</div>
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
									<!-- MODAL PLACE HOLDER -->
				<fieldset>
					<div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content"></div>
						</div>
					</div>						 
				</fieldset>
			</div>
		<!-- END COL -->

</section> <!-- seccion -->
<script src="js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="js/plugin/jqgrid/grid.locale-en.min.js"></script>
 
<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript"> 

	obtenerFechasCorte();
	pageSetUp();		
	// PAGE RELATED SCRIPTS
	function pageConstruirGridCortes(){
		var pagefunction = function() {

		/* Tabla ;*/
				var responsiveHelper_dt_basic = undefined;			 
				
				var breakpointDefinition = {
					tablet : 1024,
					phone : 480
				};


		$('#dt_basic').dataTable({

						"order": [],
						"columnDefs": [ {
						 "targets"  : 'no-sort',
						"orderable": false,
					}],
					
					// Tabletools options: 
					//   https://datatables.net/extensions/tabletools/button_options
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
							"t"+
							"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
					"oTableTools": {
						 "aButtons": [
							{
								"sExtends": "print",
								"sButtonText": "<i class='fa fa-print'></i>&nbsp;Imprimir",
								"sMessage": "<style>body{padding:15px;}@media print {.noMostrarPrint {display:none;}}</style><sup><span class='noMostrarPrint'>Para salir presione la tecla <b>Esc</b></span></sup><br><a href='javascript:void(window.print());'><i class='fa fa-print'></i><span class='noMostrarPrint'>&nbsp;Imprimir<span></a>"
							}
						 ],
						"sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
					},
					"autoWidth" : false,
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
					//,"destroy": true
				//	,"bFilter":true
				});//.fnDestroy();	 
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
						loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction);
					});
				});
			});
		});
	}
</script>