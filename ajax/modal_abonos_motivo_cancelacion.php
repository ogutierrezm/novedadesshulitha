<script src="js/piscis/abonos.js"></script>

<script>
	var id = <?php echo isset($_REQUEST['id'])?$_REQUEST['id']:0; ?>;
	$("#idAbono").val(id);
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

						<!-- widget content -->
						<div class="widget-body no-padding">
								<form action="" id="form-abono-cancelacion" class="smart-form">
									<header>
										<h3 id='headerModal'>Motivo de cancelaci&oacute;n</h3>
									</header>
									<!-- cabecero --><!-- -->
									<fieldset>									
									<!-- begin row-->
										<div class="row">
											<input type="hidden" id = "idAbono" name = "idAbono"/>
											<section class="col col-xs-12 col-12">
												<div class="table-responsive" >
													<section class="col col-12" >	
														<label class="label"></label>
															<label class="input">
																<textarea rows="6" cols="80" 
																	id="motivo_cancelacion" 
																	name="motivo_cancelacion"
																	class="form-control">
																</textarea>						
															</label>
													</section>
											</section>
									</div>
			     					<div class="row">
										<section class="col col-12">
											<div class="table-responsive">	
												<section class="col col-12">
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