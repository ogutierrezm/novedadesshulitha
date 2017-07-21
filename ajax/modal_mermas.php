<script src="js/piscis/merma.js"></script>

<section id="widget-grid" class="">
	<!-- START ROW -->
	<div class="row">
		
		<!-- NEW COL START -->
		<article class="col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-4" 
				data-widget-colorbutton="false" 
				data-widget-editbutton="false" 
				data-widget-custombutton="false">
				
				<!-- widget div-->
					<div>

						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->

						</div>
						<!-- end widget edit box -->

						<!-- widget content -->
						<div class="widget-body no-padding">
								<form action="" id="form-merma" class="smart-form">
									<header>
										<h3 id='headerModal'>Merma</h3>
									</header>
									<!-- cabecero --><!-- -->								 
									<!-- Alta de Proveedores -->
									<fieldset>									
									<!-- begin row-->
										<div class="row">
											<section class="col col-xs-11 col-5">
												<div class="table-responsive" >
													<label class="label">N&uacute;mero de Factura:</label>
														<label class="input">
															<input type = "text" id = "foliofactura" name = "foliofactura" class = "solonumero"/>
													</label>
												</div>
											</section>
											<section class="col col-3">
												<label class="label">&nbsp;<!-- Llenar datos del cliente --></label>
												<ul class="demo-btns">
													<li>
														<a id="" class="btn btn-primary btn-circle" 
															onclick="consultaInformacionArticulosMermas();">
															<i class="fa fa-fw fa-md fa-search"></i>
														</a>
													</li>
													<li>
														<label class="label">Buscar informaci&oacute;n</label>
													</li>
												</ul>
											</section>
										</div>
										<div class = "row"> 
											<section class="col col-xs-11 col-11">
												<div class="table-responsive" >
													<div id="informacionArticulosMermas"></div>
												</div>
											</section>
											
										</div>
									<!-- end row -->
									</fieldset>
								</form>
								'<div class="row" style="margin-bottom: 3px;">
									<section class="col col-xs-11 col-11">
										<div class="table-responsive" >
											<section class="col col-11" >
												<button class="btn btn-primary btn-lg" style="float:right;" onclick="closeModal();">
												Cerrar</button>
											</section>
										</div>
									</section>
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