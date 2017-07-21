<script src="js/piscis/cuenta_incobrable.js"></script>

<script>
	var id = <?php echo isset($_REQUEST['id'])?$_REQUEST['id']:0; ?>;
	obtenerJustificacion(id);
</script>
<section id="widget-grid-cancelacion" class="">
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

						<div class="widget-body no-padding">
								<form action="" id="form-cuenta-incobrable-justificacion" class="smart-form">
									<header>
										<h3 id='headerModal'>Motivo Cuenta Incobrable</h3>
									</header>
									<!-- cabecero --><!-- -->
										
									<!-- begin row-->
										<div class="row">
											<section class="col col-xs-12 col-12">
												<div class="table-responsive" >
													<section class="col col-12" >	
														<label class="label"></label>
															<label class="input">
																<textarea rows="6" cols="80" 
																	id="justificacion" 
																	name=justificacion"
																	class="form-control" disabled="disabled">
																</textarea>						
															</label>
													</section>
											</section>
									</div>
			     					<div class="row">
										<section class="col col-12">
											<div class="table-responsive">	
												<section class="col col-12">
													<button type="button" class="btn btn-primary btn-lg" id='btnCancelarModal' onclick="closeModal();">Cerrar</button>
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