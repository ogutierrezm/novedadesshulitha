<?php 
session_start();
	
if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
?>

<!-- formulario de admnistracion de inventario -->
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
											<th>NOMBRE CORTO PROVEEDOR</th>
											<th>RAZON SOCIAL</th>
											<th>DIRECCI&Oacute;N</th>
											<th>RFC</th>
											<th>TELEFONO</th>
											<th>EMAIL</th>
											<th>ACTIVO</th>
											<th>Acciones</th> 
										</tr>
									</thead>
									<tbody id="tbodyProveedores">
																 						 
									</tbody>
								</table>	

								<fieldset> 
									<!-- MODAL PLACE HOLDER -->
									<div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content"></div>
										</div>
									</div>						 
								</fieldset>
						 
						</div>
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
				<a href='ajax/modal_proveedores.php?idProveedor=' data-toggle='modal' data-target='#remoteModal' id='editarProveedor' class="btn btn-primary btn-lg" style="float:right;">Nuevo</a>
			</div>
 			
		<!-- END COL -->

</section> <!-- seccion -->
<script src="js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="js/plugin/jqgrid/grid.locale-en.min.js"></script>
 
 <script src="js/piscis/proveedores.js" async/>

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
	
	var pagefunction = function() {

	/* Tabla ;*/
			var responsiveHelper_dt_basic = undefined;			 
			
			var breakpointDefinition = {
				tablet : 1024,
				phone : 480
			};

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

	
	llenarGridProveedores();

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