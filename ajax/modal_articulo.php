<script src="js/piscis/articulos.js"></script>

<script>
	var id = <?php echo isset($_REQUEST['id'])?$_REQUEST['id']:0; ?>;

	if(id > 0){
		$("#headerModal").html('Modificar Articulo');
		editArticulo(id);
	}
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
								<form action="" id="form-articulo" class="smart-form">
									<header>
										<h3 id='headerModal'>Alta de articulos</h3>
									</header>
									<!-- cabecero --><!-- -->								 
									<!-- Alta de Proveedores -->
									<fieldset>									
									<!-- begin row-->
										<div class="row">
											<input type="hidden" id = "idArticulo" name = "idArticulo"/>
											<section class="col col-xs-11 col-11">
												<div class="table-responsive" >
													<section class="col col-8" >	
														<label class="label">Descripci&oacute;n Articulo</label>
															<label class="input">
																<input type = "text" id = "nombre_articulo" name = "nombre_articulo"/>								
															</label>
													</section>
													<section class="col col-4" style="display:none;">	
														<label class="label">Costo Venta</label>
															<label class="input">
																<input type = "text" id = "costo_venta_articulo" name = "costo_venta_articulo" value="0"/>
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