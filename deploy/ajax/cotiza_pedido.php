<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');	
	include('../conx/constant.php');
	date_default_timezone_set('America/Mazatlan');
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$fecAgendaTitle = '';
	$fecAgendaMasUnDia = '';
	
	$fecAgenda = '';
	$sPermisos = ISSET($_SESSION['permisos'])?$_SESSION['permisos']:'';
	$fecAgenda = ISSET($_GET['fc'])?$_GET['fc']:'';
	$nombreUsuario = ISSET($_SESSION['nombreUsuario'])?$_SESSION['nombreUsuario']:'';
	$vUser= ISSET($_SESSION['keyx'])?$_SESSION['keyx']:0;
	if ($fecAgenda != ''){
		$fecAgenda = date('Y-m-d',strtotime($fecAgenda));
		$fecAgendaMasUnDia = date('Y-m-d',strtotime($fecAgenda."+1 day "));
		$fecAgendaTitle = 'Cotizaci&oacute;n fecha: '.$fecAgenda;
		echo "<script> $('#fechaentrega').attr('disabled','disabled'); </script>";
		//echo "<script> $('#fecharecolectar').attr('disabled','disabled'); </script>";
	}else{
		echo "<script> $('#fechaentrega').removeAttr('disabled'); </script>";
		//echo "<script> $('#fecharecolectar').removeAttr('disabled'); </script>";
	}
	
	if ($vUser > 0){ 
		$datos = consultaUnUsuario($vUser);
		//print_r($datos);
	}
	echo 	"<script> 	var vId_puesto = ". $datos['data']['id_puesto'].";
						var vKeyx = ". $datos['data']['keyx'].";
						$('#empleado').val(vId_puesto);
			</script>";
			
	$vCP = 0;
	$vCalle = '';
	$sRespuestaColonias = LlenarComboColoniasSepomex($vCP,$vCalle);

	$sRFolio = obtenerFolioCotizacion();
	$sRFolio = $sRFolio['data']['retorno'];
	
	$Valores = obtenerVariableEmpresa(1,1);
	$Valores = $Valores['data'];
	
	$variable = obtenerVariableEmpresa(2,1);
	$variable = ISSET($variable['data']['valor'])?$variable['data']['valor']:300;
	echo '<script>var vTiempoSesion = '.$variable.';</script>';
	/*include("../php/expire.php");  */  
?>
<!--div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			<i class="fa fa-edit "></i> 
				Captura de pedido			
		</h1>
	</div>
</div-->													
<!-- formulario de captura de pedido -->
<section id="widget-grid" class="">


	<!-- START ROW -->
	<div class="row">

		<!-- NEW COL START -->
		<article class="col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
				<!-- widget div-->
				<div>
					<!-- widget content -->
					<div class="widget-body no-padding">

						<form action="" id="registrar_pedido" class="smart-form" novalidate="novalidate">
							<!--header>
								<h1>&nbsp;</h1>
							</header-->
							<!-- cabecero -->
							<fieldset>							
									<div class="row">
										<section class="col col-4 pull-left">
											<h2 class="page-title txt-color-blueDark">
												<?PHP echo $fecAgendaTitle; ?>
											</h2>
										</section>
										<section class="col col-2 pull-right">
											<label class="input">
												<input  id="folio" name="folio" type="text" placeholder="12345" disabled = "disabled" 
												value="<?PHP echo $sRFolio;?>" >
											</label>
										</section>
										<label class="control-label pull-right"><h2>Folio:</h2></label>	
										<section class="col col-3 pull-right">
											<label class="select">
												<select name="empleado" id="empleado">
													<?PHP
														$sRespuesta = LlenarComboEmpleados();
														echo $sRespuesta['data'];
													?>
											</select> <i></i> 
											</label>		
										</section>
										<label class="control-label pull-right"> <h2>Empleado:</h2> </label>																			
									</div>
							</fieldset>
							<fieldset>
								<div class="row">
									<section class="col col-3">
										<label class="label"><h5>Detalle del pedido:</h5></label>										 									
									</section>
								</div>		
								<div class="row">
									<section class="col col-11">
										<div class="table-responsive">								
											<table class="table table-bordered" id="tb_detallepedido">
												<thead>
													<tr>			
													    <th style="width:15px;"></th>										 
														<th>Art&iacute;culo</th>
														<th>Precio</th>
														<th>Cantidad</th>
														<th>Subtotal</th>
														<th>Nota art&iacute;culo especial</th>
													</tr>
												</thead>
												<tbody id="tabla">
													<tr id="row_1">
														<td class='eliminar'><a  class='txt-color-red'><i class='fa fa-times'></i></a></td>
														<td>
														<select class="form-control input-md" id="cmbarticulos_1" name="cmbarticulos" onchange="return consultarArticuloElegido(this.value,1)" >
															<?PHP
															  //die('muere');
															  $esRenta = (ARTICULORENTADO == 1)?ARTICULORENTADO:0;
															  $vCP = 0;
															  $vCalle = '';
															  $sArtCapturado = articulosaCapturarPedidos($esRenta);
															  echo $sArtCapturado['data'];
															 ?> 												
														</select>													 
										                </td>
														<td ><input id="precio_1" name="precio" class="form-control input-md" placeholder="$0.00" type="text" disabled="disabled" readonly ></td>													
														<td ><input id="cantidad_1" name="cantidad" class="form-control input-md" placeholder="1" type="text" onkeyup="return ReCalcularSaldoPedido(1);" onkeydown='isNumber(event); validaEnter(event,1); ReCalcularSaldoPedido(1);' onblur='return  validaBlur(1);' onkeypress="return isNumber(event);" onfocus="this.select();"></td>
														<td ><input id="subtotal_1" name="subtotal" class="form-control input-md" placeholder="$0.00" type="text" disabled="disabled" readonly></td>
														<td >
															<input id="notaEspecial_1" name="subtotal" class="form-control input-md" placeholder="8 PM a 10 PM" type="text" disabled="disabled" readonly onkeypress="isAlphaNumeric(event); validaEnter(event,1);" maxlength="25" onfocus="this.select();">
															<input id="hidespecial_1" name="subtotal" class="form-control input-md" type="hidden" disabled="disabled" readonly>
															<input id="hidcantidad_1" name="subtotal" class="form-control input-md" type="hidden" disabled="disabled" readonly>
														</td>
													</tr>	
												</tbody>
											</table><!--/br-->
											<section class="col col-3">
												</br>
												<ul class="demo-btns">
													<li>
														<a  id="agregar_fila" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-plus"></i></a>
													</li>
													<li>
														<label class="label">Añadir m&aacute;s art&iacute;culos</label>
													</li>
												</ul>
											</section>
										</div>
									</section>								 
								</div>
								<div class="row">
									<section class="col col-11">
										<div class="table-responsive">	
											<section class="col col-3">	 
												<label class="label">Manteler&iacute;a</label>			
												<!--
												<label class="input"> <i class="icon-prepend fa fa-money"></i>
													<input id="idManteleria" name="idManteleria" type="text" onfocus="this.select();" placeholder="Mantel rosa" value="" onkeypress="return isAlphaNumeric(event);">
												</label>
												-->
												<label class="textarea textarea-expandable"><i class="icon-prepend fa fa-comment"></i>									
													<textarea rows="3" class="custom-scroll" id="idManteleria" onfocus="this.select();" name="idManteleria" placeholder="Mantel Azul" onkeypress="return isAlphaNumeric(event);" maxlength="120"></textarea> 
												</label>
											</section>
											<section class="col col-2">	 
												<label class="label">Adicional</label>			
												<label class="input"> <i class="icon-prepend fa fa-money"></i>
													<input id="idcargoFlete" name="idcargoFlete" type="text" placeholder="$150" value="0" onkeyup="return ReCalcularSaldoPedido(1);" onkeypress="return isNumber(event);" onfocus="this.select();" maxlength="8" onblur="return SetValoresDefault(this,1);">	
												</label>
											</section>
											<section class="col col-2" style="display:none">	 
												<label class="label">Abon&oacute;</label>			
												<label class="input"> <i class="icon-prepend fa fa-money"></i>
													<input id="importe_totalmodal" name="importe_totalmodal" type="text" placeholder="$100" value="0" onkeyup="return ReCalcularSaldoPedido(1);" onkeypress="return isNumber(event);" onfocus="this.select();" maxlength="8" onblur="return SetValoresDefault(this,1);">	
												</label>
											</section>											
											<section class="pull-right">
												<!--/br-->
												<i class="fa fa-caret-right"></i>
												<span class="font-md">Subtotal:$&nbsp;													
													<span class="text-primary" id="subtotal" class="label">0</span>
												</span>
												</br>
												<i class="fa fa-caret-right"></i>
												<span class="font-md">IVA:$&nbsp;													
													<span class="text-primary" id="idIVA" class="label">0</span>
												</span>												
												</br>
												<i class="fa fa-caret-right"></i>
												<span class="font-md">Abon&oacute:$&nbsp;													
													<span class="text-primary" id="abono" class="label">0</span>
												</span>
												</br>
												<i class="fa fa-caret-right"></i>
												<span class="font-md">Descuento:$&nbsp;													
													<span class="text-primary" id="Descto" class="label">0</span>
												</span>												
												</br>
												<i class="fa fa-caret-right"></i>
												<span class="font-md">Total:$&nbsp;													
													<span class="text-primary" id="total" class="label">0</span>
												</span>	
											</section>
										</div>
										<div class="table-responsive">
											<section class="col col-3">
												<label class="label">Requiere IVA</label>	
												<label class="checkbox">
													<input type="checkbox" name="check_IVA" id="check_IVA" value="0" onchange="return cambiarValorIVA(this.value,0);">
													<i></i><span id="lblIva">No incluir</span>
												</label>							
											</section>
											<section class="col col-2">	
												<label class="label">Mostrar Precio</label>	
												<label class="checkbox">
													<input type="checkbox" name="check_Descto" id="check_Descto" value="0" onchange="return cambiarValorDescto(this.value,0);">
													<i></i><span id="lblDescto">Incluir</span>
												</label>							
											</section>
											<section class="col col-2" id="sectionDesctos" style="display:block">	 
												<label class="label">Porcentaje</label>			
												<label class="input"> <i class="icon-prepend fa fa-money"></i>
													<input id="PorcentajeDescuento" name="PorcentajeDescuento" type="number" placeholder="10" value="0" onkeyup="isCorrectNumber(event,this); valorMaxMin(this,0); ReCalcularSaldoPedido(1);" onchange="valorMaxMin(this,0); ReCalcularSaldoPedido(1);" onkeypress="ReCalcularSaldoPedido(1);" onkeydown ="return ReCalcularSaldoPedido(1);" onblur="SetValores(this); ReCalcularSaldoPedido(1);" onfocus="this.select();"> 	
												</label>
											</section>
											<section class="col col-2">	 
												<label class="label">Dep&oacute;sito</label>			
												<label class="input"> <i class="icon-prepend fa fa-money"></i>
													<input id="importe_garantia" name="importe_garantia" type="text" placeholder="$100" value="0" onkeyup="return ReCalcularSaldoPedido(1);" onkeypress="return isNumber(event);" onfocus="this.select();" maxlength="8" onblur="return SetValoresDefault(this,1);">	
												</label>
											</section>
										</div>
									</section>
								</div>
							</fieldset>
							<!--fieldset-->
								<div class="row">	
									<section class="col col-11">
										<!--div class="table-responsive"-->	
											
										<!--/div-->
									</section>
								</div>
							<!--/fieldset-->
							
							<!-- Datos del cliente -->
							<fieldset>
								<div class="row">
									<section class="col col-3">
										<label class="label"><h5>Datos del cliente:</h5></label>										 									
									</section>	
								</div>
								<div class="row">
									<section class="col col-4">
										<label class="label"> Id cliente </label>
										<label class="input"> <i class="icon-prepend fa fa-phone"></i>
											<input type="tel" id="numcliente" name="numcliente" onfocus="this.select();" placeholder="#1" onkeypress='isNumber(event); validaEnterConsultar(event,"idBuscarCteId");' maxlength="10">
										</label>
									</section>
									<section class="col col-3">
										<label class="label">&nbsp;<!-- Llenar datos del cliente --></label>
										<ul class="demo-btns">
											<li>
												<a  id="idBuscarCteId" class="btn btn-primary btn-circle" href="javascript:ConsultarCteKeyx();"><i  class="fa fa-fw fa-md fa-search"></i></i></a>
											</li>
											<li>
												<label class="label">Buscar cliente</label>
											</li>
										</ul>
									</section>
								</div>	
								<div class="row">
									<section class="col col-4">
										<label class="label"><sup>*</sup> Tel&eacute;fono Celular </label>
										<label class="input"> <i class="icon-prepend fa fa-phone"></i>
											<input type="tel" id="telefonocelular" name="telefonocelular" onfocus="this.select();" placeholder="(667) 123-4567" onkeydown="return ConsultarTelefonoCelularCte();" onblur="return ConsultarTelefonoCelularCte();" onkeypress="return isNumber(event);" maxlength="10">
										</label>
									</section>
									<section class="col col-4">
										<label class="label"><sup>*</sup> Tel&eacute;fono fijo </label>
										<label class="input"> <i class="icon-prepend fa fa-phone"></i>
											<input type="tel" id="telefonocasa" name="telefonocasa" onfocus="this.select();" placeholder="(667) 723-4567" onkeydown="return ConsultarTelefonoCasaCte();" onblur="return ConsultarTelefonoCasaCte();" onkeypress="return isNumber(event);" maxlength="10">
										</label>
									</section>										 
									<section class="col col-3">
										<label class="label">&nbsp;<!-- Llenar datos del cliente --></label>
										<ul class="demo-btns">
											<li>
												<a  id="idBuscarCte" class="btn btn-primary btn-circle" href="javascript:ConsultarTelefonos();"><i  class="fa fa-fw fa-md fa-search"></i></i></a>
											</li>
											<li>
												<label class="label">Buscar cliente</label>
											</li>
										</ul>
									</section>
								</div>								 
								<div class="row">
									<section class="col col-4">
										<label class="label"><sup>*</sup> Nombre(s)</label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" id="nombre" name="nombre" placeholder="Juan" onkeypress="return isLetter(event);" maxlength="35" onfocus="this.select();">
										</label>
									</section>
									<section class="col col-4">
										<label class="label"><sup>*</sup> Apellido(s)</label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" id="apellido" name="apellido" placeholder="Perez" onkeypress="return isLetter(event);" maxlength="50" onfocus="this.select();">
										</label>
									</section>
									<section class="col col-3" id="secLimpiarCte" >
										<label class="label txt-color-blue">Este cliente no es</label>										
										<button type="button" class="btn btn-info btn-sm" data-toggle="#jobInfo" id="idLimpiarCliente" onclick="return limpiarCliente();">
											<i class="fa fa-plus-circle"></i>&nbsp;Limpiar secci&oacute;n
										</button>
									</section>
								</div>
								<div class="row">
									<section class="col col-4">
										<label class="label">Email</label>
										<label class="input"> <i class="icon-prepend fa fa-envelope-o"></i>
											<input type="text" id="email" name="email" placeholder="Juan@dominio.com" onkeypress="return isEmail(event);" maxlength="50" onfocus="this.select();" onblur="return validarCorreo();">
										</label>
									</section>
								</div>
							</fieldset>
							<!-- Datos de la entrega -->
							<!--fieldset>		
								<div class="row">
									<section class="col col-3">
										<label class="label"><h5>Domicilio:</h5></label>										 									
									</section>	
								</div>								
								<div class="row">
									<section class="col col-4">
										<label class="label"><sup>*</sup> Calle</label>
										<label class="input"> <i class="icon-prepend fa fa-road"></i>
											<input type="text" id="calle" name="calle" placeholder="Morelos" onkeypress="return isAlphaNumeric(event);" maxlength="50" onfocus="this.select();">
										</label>
									</section>
									<section class="col col-2">
										<label class="label"><sup>*</sup> N&uacute;mero Ext.</label>
										<label class="input"> <i class="icon-prepend fa fa-slack"></i>
											<input type="text" id="numext" name="numext" placeholder="123" onkeypress="return isNumber(event);" maxlength="8" onfocus="this.select();">
										</label>
									</section>
									<section class="col col-2">
										<label class="label">N&uacute;mero Int.</label>
										<label class="input"> <i class="icon-prepend fa fa-building"></i>
											<input type="text" id="numint" name="numint" placeholder="A" onkeypress="return isAlphaNumeric(event);" maxlength="8" onfocus="this.select();">
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-2">
										<label class="label">C&oacute;digo Postal</label>
										<label class="input"><i class="icon-prepend fa fa-tag"></i>
											<input type="text" name="CodigoPostal" id="CodigoPostal" placeholder="80000" data-mask="99999" onkeypress="return ConsultarCalleSepomex();" onkeyup="return isNumber(event);" onblur="return blurConsultarCalleSepomex();" onfocus="this.select();" readonly>
										</label>
									</section>
									<section class="col col-4">
									<div class="form-group">
										<label class="label"><sup>*</sup> Colonia</label>
										<label class="input"><i class="icon-prepend fa fa-tag"></i>
											<input class="input" placeholder="Centro" type="text"  name="Colonia" id="Colonia" onchange="return ConsultarColonias();" onblur="return ConsultarColonias();" onkeypress="return limpiaDatosCpMnipio();">
										</label>										                    
									</div>
									</section>
									<section class="col col-2">
										<label class="label">Municipio</label>
										<label class="input"><i class="icon-prepend fa fa-map-marker"></i>
											<input type="text" name="municipio" id="municipio" placeholder="C&uacute;liacan" readonly>
										</label>
									</section>									
								</div>
								<div class="row">
									<section class="col col-6">
											<label class="label">Referencias:</label>											
											<label class="textarea"><i class="icon-prepend fa fa-comment"></i>									
												<textarea rows="3" id="referencias" name="referencias" placeholder="Indica como llegar al domicilio: Entre calles, referencias, etc..." onkeypress="return isAlphaNumeric(event);" maxlength="120" onfocus="this.select();"></textarea> 
											</label>
									</section>
									<section class="col col-2" id="secTengoMasDomicilios" style="display:none">
										<label class="label txt-color-blue">M&aacute;s domicilios</label>
										<button type="button" class="btn btn-info btn-sm" data-toggle="#jobInfo" id="idcambiarDomicilio" onclick="return cambiarDomicilio();">
											<i class="fa fa-chevron-circle-right"></i>&nbsp;Ir al siguiente
										</button>
									</section>
									<section class="col col-2" id="secLimpiarDomicilios" >
										<label class="label txt-color-blue">Capturar nuevo domicilio</label>										
										<button type="button" class="btn btn-info btn-sm" data-toggle="#jobInfo" id="idLimpiarDomicilio" onclick="return limpiarDomicilio();">
											<i class="fa fa-plus-circle"></i>&nbsp;Limpiar secci&oacute;n
										</button>
									</section>
								</div>
							</fieldset-->	
							<!-- detalle del pedido -->
							<fieldset>	
								<div class="row">
									<section class="col col-4">
										<label class="label"><h5>Fecha de entrega y recolecci&oacute;n:</h5></label>										 									
									</section>	
								</div>						
								<div class="row">									
									<section class="col col-3">
										<label class="label"><sup>*</sup>Del:</label>			
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" id="fechaentrega" name="fechaentrega" placeholder="Seleccionar" class="datepicker" data-dateformat='yy-mm-dd' onkeypress="return false;" value="<?PHP echo $fecAgenda;?>" onfocus="this.select();">
										</label>										
									</section>
									<section class="col col-3">
										<label class="label"><sup>*</sup>Al :</label>			
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" id="fecharecolectar" name="fecharecolectar" placeholder="Seleccionar" class="datepicker" data-dateformat='yy-mm-dd' onkeypress="return false;" value="<?PHP echo $fecAgendaMasUnDia;?>" onfocus="this.select();">
										</label>										
									</section>
									<section class="col col-2">
										<label class="label"><sup>*</sup>Hora:</label>
										<label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
											<input type="text" id="hora1" name="hora1" placeholder="8:00am" onkeypress="return isAlphaNumeric(event);" maxlength="30" onfocus="this.select();">
										</label>
									</section>	
								</div>
								<div class="row">
									<section class="col col-3">
										<label class="checkbox">
											<input type="checkbox" name="check_recoger" id="check_recoger" value="0" onchange="return cambiarValor(this.value);">
											<i></i>Recoger  el mismo d&iacute;a.
										</label>							

									</section>
									<section class="col col-3" style="display:none;" id="time2">										 
										<label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
											<input type="text" id="hora2" name="hora2" placeholder="Hora" onkeypress="return isAlphaNumeric(event);" maxlength="30" onfocus="this.select();">
										</label>
									</section>	
								</div>
								<div class="row">
									<section class="col col-10" id="msg1">
										<div class="alert adjusted alert-info fade in">
											<button class="close" data-dismiss="alert">×</button>
											<i class="fa-fw fa-lg fa fa-exclamation"></i>
											Selecciona esta opci&oacute;n para pedidos que contengan <strong>art&iacute;culos especiales o que se recoger&aacute;n el mismo d&iacute;a de la entrega.</strong> 
										</div>
									</section>									
								</div>
							</fieldset>
							<footer>
								<button type="button" class="btn btn-primary" id="btnGrabarCotizacion" onclick="return grabarCotizacion();">
									<i class="fa fa-save"></i>&nbsp;Guardar
								</button>
								<button id="cancelarPedido" type="button" class="btn btn-default" onclick="LimpiarCapturaPedidoNuevo();">
									Cancelar
								</button>
								<button id="cancelarPedido" type="button" class="btn btn-primary" onClick ="window.history.back();">
									<i class="fa fa-arrow-left"></i>&nbsp;Regresar
								</button>
							</footer>
						</form> <!-- Termina formulario  -->						
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
			</div>
		</article>
		<!-- END COL -->
	</div>
</section> <!-- seccion -->
<input id="consecutivo" name="consecutivo" type="hidden" value=1 />
<input id="clientekeyx" name="clientekeyx" type="hidden" value=0 />
<input id="direccionkeyx" name="direccionkeyx" type="hidden" value=0 />

<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">
	var valorMaximo =parseInt('<?PHP echo $Valores['valor'];?>');
	pageSetUp();
	
	// PAGE RELATED SCRIPTS

	// pagefunction
	
	var pagefunction = function() {
		var $checkoutForm = $('#registrar_pedido').validate({
		// Rules for form validation
			rules : {
				empleado : {
					required : true
				},
				telefonocelular : {
					required : true
				},
				telefonocasa : {
					required : true
				},
				nombre : {
					required : true
				},
				apellido : {
					required : true
				},
				calle : {
					required : true
				},
				numext : {
					required : true
				},
				numint : {
					required : false
				},
				CodigoPostal : {
					required : true
				},
				Colonia : {
					required : true
					//digits : true
				},
				fechaentrega : {
					required : true
				},
				fecharecolectar : {
					required : true
				},
				hora1 : {
					required : true
				}

			},
	
			// Personalizar mensajes 
			messages : {
				fname : {
					required : '*Campo obligatorio.'
				}
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	};
	//Agregar fila
	$("#agregar_fila").click(function(){
			$("#consecutivo").val(parseInt($("#consecutivo").val())+1);
			var  vConsecutivo = $("#consecutivo").val();
            var tds= $('tr:last td', $("#tb_detallepedido")).length;
            var nuevaFila="<tr id = 'row_"+ vConsecutivo +"'><td class='eliminar'><a  class='txt-color-red'><i class='fa fa-times'></i></a></td>";

			nuevaFila+="<td><select class='form-control input-md' id='cmbarticulos_"+ vConsecutivo +"' name='cmbarticulos_"+ vConsecutivo +"' onchange='return consultarArticuloElegido(this.value,"+vConsecutivo+")'>"+sOpciones+"</select></td>";
			nuevaFila+="<td><input class='form-control input-md' placeholder='$0.00' type='text' disabled='disabled' id='precio_"+ vConsecutivo +"' name='precio_"+ vConsecutivo +"';></td>";									
			nuevaFila+="<td><input class='form-control input-md' placeholder='1' type='text' id='cantidad_"+ vConsecutivo +"' name='cantidad_"+ vConsecutivo +"' onkeyup='return ReCalcularSaldoPedido("+ vConsecutivo +");' onfocus='this.select();' onkeydown='isNumber(event); validaEnter(event," + vConsecutivo +"); ReCalcularSaldoPedido("+ vConsecutivo +");' onblur='return  validaBlur(" + vConsecutivo + ");' onkeypress='return isNumber(event); '></td>";
			nuevaFila+="<td><input class='form-control input-md' placeholder='$0.00' type='text' disabled='disabled' id='subtotal_"+ vConsecutivo +"' name='subtotal_"+ vConsecutivo +"'></td>";
			nuevaFila+="<td><input id='notaEspecial_" + vConsecutivo + "' name='notaEspecial' class='form-control input-md' placeholder='8 PM a 10 PM' type='text' disabled='disabled' readonly onfocus='this.select();' onkeypress='isAlphaNumeric(event); validaEnter(event," + vConsecutivo +");'>"+
				"<input id='hidespecial_"+ vConsecutivo + "' name='hidespecial' class='form-control input-md' type='hidden' disabled='disabled' readonly>" +
				"<input id='hidcantidad_"+ vConsecutivo +"' name='hidcantidad' class='form-control input-md'  type='hidden' disabled='disabled' readonly></td>";
			
            nuevaFila+="</tr>";
            $("#tb_detallepedido").append(nuevaFila);
			CalcularSaldoPedido();
			$("#cmbarticulos_"+ vConsecutivo).focus();
        });

		// Eliminar fila

		$(document).on("click",".eliminar",function(){
			var parent = $(this).parents().get(0);
			$(parent).remove();
			CalcularSaldoPedido();
		});

		
		$('#check_recoger').click(function(){
          $("#hora2").toggle();
      	});
		
	// end pagefunction
	
	// Load form valisation dependency 
	loadScript("js/plugin/jquery-form/jquery-form.min.js", pagefunction);
	
	$("#cancelarPedido").click(function(){
		var vFolioPedido = ConsultarFolioSiguiente();
		LimpiarCapturaPedidoNuevo(vFolioPedido);
	});
	
	function ConsultarFolioSiguiente(){
		var vFolioPedido = '<?PHP echo $sRFolio;?>';
		return vFolioPedido;
	}
	
	/*function LimpiarGrid(){
		$("#tabla").remove();
	}*/
	
	var sOpciones = '<?PHP echo $sArtCapturado['data'];?>';
	var sDomiciliosArray = '';
	
	$(function() {
		var availableTags = [<?PHP echo $sRespuestaColonias['data'];?>
		/*"ActionScript",
		  "AppleScript",
		  "Asp"*/
		];
		$( "#Colonia" ).autocomplete({
		  source: availableTags
		});
	});
	
	$("input,select,textarea").bind("keyup", function (e) {

	  var keyCode = e.keyCode || e.which;
		   if(e.keyCode === 13) {
			e.preventDefault();
			$('input,select,textarea')[$('input,select,textarea').index(this)+1].focus();
			}
	});
	var domiciliosCliente;
	var domicilioSet;
	var sUrlRedirected = '<?PHP echo APP_URL."/#ajax/nota_cotizacion.php";?>';
	var sUrlRedirectedHome = '<?PHP echo APP_URL."/#ajax/dashboard.php";?>';
	
	function obtenerFechaEntrega(){
		return '<?PHP echo $fecAgenda;?>';
	}
	
	function obtenerFechaRecolecta(){
		return '<?PHP echo $fecAgendaMasUnDia;?>';
	}
	
	$("#cmbarticulos_1").focus();
</script>

