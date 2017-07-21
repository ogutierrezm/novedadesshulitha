<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<style type="text/css">
	.ui-autocomplete { z-index:2147483647 !important;}
</style>
<script src="js/piscis/vendedores.js"></script>

<script>
	var id_vendedor = <?php echo isset($_REQUEST['id_vendedor'])?$_REQUEST['id_vendedor']:0; ?>;

	if(id_vendedor > 0){
		$("#headerModal").html('Modificar Vendedores');
		editVendedor(id_vendedor);
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
								<form action="" id="form-vendedores" class="smart-form">
									<header>
										<h3 id='headerModal'>Alta Vendedores</h3>
									</header>
									<!-- cabecero --><!-- -->								 
									<!-- Alta de vendedores -->
									<fieldset>									
									<!-- begin row-->
										<div class="row">
											<input type="hidden" id = "id_vendedor" name = "id_vendedor"/>
											<input type="hidden" id = "id_puesto" name = "id_puesto"/>
											<section class="col col-11" style="width:100%">
												<div class="table-responsive" >
													<section class="col col-20"	 style="width:50%">	
														<label class="label">Nombre Completo</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		
																<input type = "text" id = "nombre" name = "nombre"/>
															</label>
													</section>
													<section class="col col-11" style="width:50%">	
														<label class="label">Puesto</label>
															<label class="input">
																<input type = "text" id = "puesto" name = "puesto"/>								
															</label>
													</section>
												</div>
											</section>
										</div>
										<div class="row">
											<section class="col " style="width:100%">
												<div class="table-responsive">
													<section class="col col-20" style="width:50%">	
														<label class="label">Domicilio</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		
																<input type = "text" id = "domicilio" name = "domicilio"/>
															</label>
													</section>
												<section class="col col-20" style="width:50%">	
														<label class="label">Fecha Nac.</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		
																<input type = "text" id = "fecha_nacimiento" name = "fecha_nacimiento"/>
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