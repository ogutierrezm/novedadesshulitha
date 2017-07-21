<script src="js/piscis/proveedores.js"></script>

<script type="text/javascript">
	var idProveedor = <?php echo ( isset($_REQUEST['idProveedor']) && $_REQUEST['idProveedor'] != '')?$_REQUEST['idProveedor']:0; ?>;

	if(idProveedor > 0){
		$("#headerModalProveedor").html('Modificar Proveedor');
		editProveedor(idProveedor);
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

								<form action="" id="form-proveedores" class="smart-form">
									<header>
										<h3 id='headerModalProveedor'>Alta Proveedor</h3>
									</header>
									<!-- cabecero --><!-- -->								 
									<!-- Alta de Proveedores -->
									<fieldset>									
									<!-- begin row-->
										<div class="row">
											<input type="hidden" id = "iduProveedor" name = "iduProveedor"/>
											<section class="col col-11">
												<div class="table-responsive">
													<section class="col col-11">	
														<label class="label">CLAVE</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		<input type = "text" id = "claveProveedor" name = "claveProveedor"/>								
															</label>
													</section>
													<section class="col col-11">	
														<label class="label">Raz&oacute;n Social</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		<input type = "text" id = "razonSocialProveedor"  
																name = "razonSocialProveedor"/>
															</label>
													</section>
												<section class="col col-11">	
													<label class="label">RFC</label>
														<label class="input">
															<i class="icon-prepend fa fa-comment"></i>		
															<input type = "text" id = "rfcProveedor" 
															name = "rfcProveedor" />
														</label>
												</section>
											</div>
											</section>
											</div>
										<div class="row">
											<section class="col col-11" style="width: 100% !important;">
												<div class="table-responsive">
													<section class="col col-11" style="width: 100% !important;">	
														<label class="label">Direcci&oacute;n</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		<input type = "text" id = "direccionProveedor" 
																name = "direccionProveedor" />
															</label>
													</section>
													</div>
												</section>
										</div>
									<div class="row">
										<section class="col col-11">
											<div class="table-responsive">	

												<section class="col col-11">	
													<label class="label">Telefono</label>
														<label class="input">
															<i class="icon-prepend fa fa-comment"></i>		
															<input type = "text" id = "telefonoProveedor"
															name = "telefonoProveedor" />
														</label>
												</section>
												<section class="col col-11">	
													<label class="label">Email</label>
														<label class="input">
															<i class="icon-prepend fa fa-comment"></i>		
															<input type = "text" id = "emailProveedor" 
															name = "emailProveedor" />
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