<script src="js/piscis/concepto_gastos.js"></script>

<script>
	var idConcepto = <?php echo isset($_REQUEST['idConcepto'])?$_REQUEST['idConcepto']:0; ?>;

	if(idConcepto > 0){
		$("#headerModal").html('Modificar Conceptos de Gastos');
		editConceptoGastos(idConcepto);
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
								<form action="" id="form-concepto" class="smart-form">
									<header>
										<h3 id='headerModal'>Alta Conceptos de Gastos</h3>
									</header>
									<!-- cabecero --><!-- -->								 
									<!-- Alta de Proveedores -->
									<fieldset>									
									<!-- begin row-->
										<div class="row">
											<input type="hidden" id = "idConcepto" name = "idConcepto"/>
											<section class="col " style="width:100%">
												<div class="table-responsive" style="width:100%">
													<section class="col col-20" style="width:100%">	
														<label class="label">Concepto de Gastos</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		<input type = "text" id = "concepto_gasto" name = "concepto_gasto"/>								
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