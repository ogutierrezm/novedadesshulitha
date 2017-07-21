<script src="js/piscis/inventario.js"></script>
<style type="text/css">
	.ui-autocomplete { z-index:2147483647 !important;}
</style>
<script>
	var id = <?php echo isset($_REQUEST['id'])?$_REQUEST['id']:0; ?>;

	if(id > 0){
		$("#headerModal").html('Modificar Inventario');
		editInventario(id);
	}
</script>
<style>
	.mostrar_form{
		display: none;
	}
</style>
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
								<form action="" id="form-inventario" class="smart-form">
									<header>
										<h3 id='headerModal'>Alta Inventario</h3>
									</header>
									<!-- cabecero --><!-- -->								 
									<!-- Alta de Proveedores -->
									<fieldset>									
									<!-- begin row-->
										<div class="row">
											<fieldset >
												<section class="col col-xs-11 col-11" id = "tipoFactura">
													<div class="table-responsive" style="font-size:14px" >
														<section class="col col-5">	
															<input id="chk_proveedor" type="checkbox" style='margin-left:3px'/>
															<label for ='chk_proveedor'>Proveedor</label>
														</section>
														<section class="col col-5">	
															<input id="chk_concepto_gastos" type="checkbox" style='margin-left:3px' />
															<label for ='chk_concepto_gastos'>Concepto de gastos</label>
														</section>
													</div>
												</section>
											</fieldset>
										</div>
										<div class="row mostrar_form">
											<input type="hidden" id = "idInventario" name = "idInventario"/>
											<input type="hidden" id = "id_tipo" name = "id_tipo" value = ""/>
											<input type="hidden" id = "tipoInventario" name = "tipoInventario"/>
											<section class="col col-xs-11 col-11">
												<div class="table-responsive" >
													<section class="col col-5" >	
														<label class="label">N&uacute;mero Factura</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		<input type = "text" id = "factura" name = "factura" class="soloNumeros"/>								
															</label>
													</section>
													<section class="col col-3">	
														<label class="label">Sub-Total</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		<input type = "text" id = "subtotal" 
																name = "subtotal" class="soloNumerosFloat" onkeyup="return setearValorMontoTotal();"/>	
															</label>
													</section>
												<section class="col col-3">	
														<label class="label">Iva</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		<input type = "text" id = "iva" 
																name = "iva" class="soloNumerosFloat" onkeyup="return setearValorMontoTotal();"/>	
															</label>
													</section>
											</div>
											</section>
											<section class="col col-xs-11 col-11">
												<div class="table-responsive" >
													<section class="col col-5">	
														<label class="label">Monto Total</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		<input type = "text" id = "montototal" 
																name = "montototal" class="float" readonly/>	
															</label>
													</section>
													<section class="col col-5" id="mostrar_tipo">	
														<label class="label" id="descripcion"></label>
															<label class="input">
																<input type = "text" id = "tipo" 
																name = "tipo"/>
															</label>
													</section>
											</div>
											</section>
											<section class="col col-xs-11 col-11">
												<div class="table-responsive" >
													<section class="col col-6">	
														<label class="label">Fecha Compra</label>
															<label class="input">
																<i class="icon-prepend fa fa-comment"></i>		<input type = "text" id = "fecha_compra" 
																name = "fecha_compra"/>	
															</label>
													</section>
												</div>
											</section>	
											</div>
			     					<div class="row mostrar_form">
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