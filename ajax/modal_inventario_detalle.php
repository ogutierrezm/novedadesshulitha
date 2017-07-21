<script src="js/piscis/inventario_detalle.js"></script>
<script src="js/piscis/inventario.js"></script>
<style type="text/css">
	.ui-autocomplete { z-index:2147483647 !important;}
	
	.autoModal.modal .modal-body{
    	max-height: 100%;
	}
	.modal-dialog { 
		width : 80% ;
	}
</style>
<script>
	var id = <?php echo isset($_REQUEST['id'])?$_REQUEST['id']:0; ?>;
	$("#idInventario").val(id);
	if(id > 0){
//		editInventario(id);
	}

$('.modal').on('show', function () {
       $(this).find('.modal-body').css({
              width:'auto', //probably not needed
              height:'auto', //probably not needed 
              'max-height':'100%'
       });
});
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
								<form action="" id="form-inventario_detalle" class="smart-form">
									<header>
										<h3 id='headerModal'>Agregar Articulos</h3>
									</header>
									<!-- cabecero --><!-- -->								 
									<!-- Alta de Proveedores -->
									<fieldset>									
									<!-- begin row-->
										<div class="row ">
											<input type="hidden" id = "idInventario" name = "idInventario"/>
											<input type="hidden" id = "idInventarioDetalle" name = "idInventarioDetalle"/>
											<input type="hidden" id = "idArticulo" name = "idArticulo" value = ""/>
											<section class="col col-xs-11 col-12">
												<div class="table-responsive" >
													<section class="col col-4" >	
														<label class="label">Articulo</label>
															<label class="input">
																<input type = "text" id = "nombre_articulo" name = "nombre_articulo"/>								
															</label>
													</section>
													<section class="col col-2">	
														<label class="label">Costo Compra</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		<input type = "text" id = "costo_compra" 
																name = "costo_compra" class="soloNumerosFloat"/>	
															</label>
													</section>
													<section class="col col-2">	
														<label class="label">Total articulos</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		<input type = "text" id = "cantidad" 
																name = "cantidad" />	
															</label>
													</section>
													<section class="col col-4" style="display:none">	
														<label class="label">Fecha Compra</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		<input type = "text" id = "fechaCompra" 
																name = "fechaCompra" value="1900-01-01"/>	
															</label>
													</section>
												</div>
											</section>
											</div>
			     					<div class="row">
										<section class="col col-11">
											<div class="table-responsive">	
												<section class="col col-11">
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
											<table id="dt_basic_detalle" class="table table-striped table-bordered table-hover" >
												<thead>
													<tr>
														<!--th>ID</th-->
														<th>SKU</th>
														<th>DESCRIPCI&Oacute;N ARTICULO</th>
														<th>CANTIDAD</th>
														<th>COSTO COMPRA</th>
														<th>COSTO UNITARIO COMPRA</th>
														<!--th>FECHA COMPRA</th-->
														<th>STATUS</th>
														<th>Acciones</th> 
													</tr>
												</thead>
												<tbody id="tbodyInventarioDetalle"></tbody>
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
	
	var pagefunction = function() {

	/* Tabla ;*/
			var responsiveHelper_dt_basic = undefined;			 
			
			var breakpointDefinition = {
				tablet : 1024,
				phone : 480
			};

			$('#dt_basic_detalle').dataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic_detalle'), breakpointDefinition);
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
	
	llenarGridInventarioDetalle(id, 0);
	
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