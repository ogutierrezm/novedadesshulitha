<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<style type="text/css">
	.ui-autocomplete { z-index:2147483647 !important;}
</style>
<script src="js/piscis/cuenta_incobrable.js"></script>

<script>
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
								<form action="" id="form-cuenta-incobrable" class="smart-form">
									<header>
										<h3 id='headerModal'>CUENTAS INCOBRABLES</h3>
									</header>
									<!-- cabecero --><!-- -->								 
									<!-- Alta de Proveedores -->
									<fieldset>									
									<!-- begin row-->
									<div class="row">
										<section class="col col-3" style="">
											<label class="label">N&uacute;mero Factura</label>
												<label class="input">
												<i class="icon-prepend fa fa-search"></i>
													<input type = "text" id = "folio_factura" name = "folio_factura" />	
												</label>
										</section>
										<section class="col col-3">
											<label class="label">&nbsp;<!-- Llenar datos del cliente --></label>
											<ul class="demo-btns">
												<li>
													<a id="" class="btn btn-primary btn-circle" 
														onclick="buscarInfoFacturaCtaIncobrable();">
														<i class="fa fa-fw fa-md fa-search"></i>
													</a>
												</li>
												<li>
													<label class="label">Buscar cliente</label>
												</li>
											</ul>
									</section>
										<section class="col col-3">
											<label class="label">&nbsp;<!-- Llenar datos del cliente --></label>
											<ul class="demo-btns">
												<li>
													<a id="" class="btn btn-primary btn-circle" 
														onclick="limpiarInformacionCuentaIncobrables();">
														<i class="fa fa-fw fa-md fa-eraser"></i>
													</a>
												</li>
												<li>
													<label class="label">Limpiar informaci&oacute;n</label>
												</li>
											</ul>
									</section>
									</div>
									<div class="row">
										<section class="col col-3" style="">
											<label class="label">Cliente</label>
												<label class="input">
												<i class="icon-prepend fa fa-edit"></i>
													<input type = "text" id = "nombre_cliente" name = "nombre_cliente" readonly="readonly" />	
												</label>
										</section>
										<section class="col col-3" style="">
											<label class="label">Tipo Pago</label>
												<label class="input">
												<i class="icon-prepend fa fa-edit"></i>
													<input type = "text" id = "tipo_pago" name = "tipo_pago" readonly="readonly" />	
												</label>
										</section>
										<section class="col col-3" style="">
											<label class="label">Plazo</label>
												<label class="input">
												<i class="icon-prepend fa fa-edit"></i>
													<input type = "text" id = "plazo" name = "plazo" readonly="readonly" />	
												</label>
										</section>
									</div>
									<div class="row">
										<section class="col col-3" style="">
											<label class="label">Total Facturado</label>
												<label class="input">
												<i class="icon-prepend fa fa-edit"></i>
													<input type = "text" id = "total_facturado" name = "total_facturado" readonly="readonly" />	
												</label>
										</section>
										<section class="col col-3" style="">
											<label class="label">Fecha Venta</label>
												<label class="input">
												<i class="icon-prepend fa fa-edit"></i>
													<input type = "text" id = "fecha_venta" name = "fecha_venta" readonly="readonly" />	
												</label>
										</section>
									</div>
									<div class="row">
										<section class="col col-12" style="width:100%">
											<div class="table-responsive">	
												<section class="col col-12" style="width:100%;padding-left:0px;">
													  <label for="comment">Justificaci&oacute;n:</label>
													  <textarea class="form-control" rows="5" id="justificacion"></textarea>
												</section>                        
											</div>
										</section>
									</div>
			     					<div class="row" style="float:right;">
										<section class="col col-12">
											<div class="table-responsive">	
												<section class="col col-12">
													<button id='btnGrabarCuentaIncobrable' onclick="grabarCuentaIncobrable()" type="button" class="btn btn-primary btn-lg" disabled="disabled" >Grabar</button>
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
