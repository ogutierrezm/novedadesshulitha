<script src="js/piscis/articulo_precio.js"></script>

<script>
	var id = <?php echo isset($_REQUEST['id'])?$_REQUEST['id']:0; ?>;

	if(id > 0){
		editArticuloPrecio(id);
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
								<form action="" id="form-articulo_precio" class="smart-form">
									<header>
										<h3 id='headerModal'>Modificar precios de articulos</h3>
									</header>
									<!-- cabecero --><!-- -->								 
									<!-- Alta de Proveedores -->
									<fieldset>									
									<!-- begin row-->
										<div class="row">
											<input type="hidden" id = "idArticulo" name = "idArticulo"/>
											<input type="hidden" id = "idPrecio" name = "idPrecio"/>
											<section class="col col-xs-11 col-11">
												<div class="table-responsive" >
													<section class="col col-8" >	
														<label class="label">Descripci&oacute;n Articulo</label>
															<label class="input">
																<input type = "text" id = "nombre_articulo" name = "nombre_articulo" disabled />								
															</label>
													</section>
													<section class="col col-4" >	
														<label class="label">Costo Unitario Compra</label>
															<label class="input">
																<input type = "text" id = "costo_unitario_compra" name = "costo_unitario_compra" readonly />
															</label>
													</section>
												</div>
											</section>
										</div>
										<div class="row">
											<section class="col col-xs-11 col-11">
												<div class="table-responsive" >
													<section class="col col-4" >	
														<label class="label">Veces Ganancia</label>
															<label class="input">
																<input id="spinner" name="veces_ganancia" id ="veces_ganancia" readonly value = "3.5">
															</label>
													</section>
													<section class="col col-2">
														<label class="label">&nbsp;
															<label class="input">
																	<button type="button" class="btn btn-xs btn-success" id="btnRecalcularCostoVenta">
																	  <span class="glyphicon glyphicon-search" title="Recalcular Costo Venta"></span>
																	</button>
															</label>
														</label>
													</section>
													<section class="col col-5" >	
														<label class="label">Costo de Venta</label>
															<label class="input">
																<input name="costo_venta" id ="costo_venta" readonly>
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