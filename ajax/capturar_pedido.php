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
	
	$fecAgenda = date('Y-m-d');
	$sPermisos = ISSET($_SESSION['permisos'])?$_SESSION['permisos']:'';
	$nombreUsuario = ISSET($_SESSION['nombreUsuario'])?$_SESSION['nombreUsuario']:'';
	$vUser= ISSET($_SESSION['keyx'])?$_SESSION['keyx']:0;
	
	$diasSumarPrimerCobro = variables_select(3,1);
	$diasSumarPrimerCobro = $diasSumarPrimerCobro['data']['valor'];
	
	//print_r($vUser);
	//die();
	if ($fecAgenda != ''){
		$fecAgendaMasUnDia = date('Y-m-d',strtotime($fecAgenda."+ ".$diasSumarPrimerCobro." day "));
		$fecAgendaTitle = 'Pedido Nuevo: '.$fecAgenda;
	}else{
		echo "<script> $('#fechaentrega').removeAttr('disabled'); </script>";
	}
	
	echo 	"<script> 
				var vDiasProximoCobro = ".$diasSumarPrimerCobro."
				$('#fechaentrega').val('".$fecAgenda."'); 
				$('#fecharecolectar').val('".$fecAgendaMasUnDia."'); 
				$('#fechavence').attr('disabled','disabled'); 
				$('#fechaentrega').attr('disabled','disabled'); 
				$('#fecharecolectar').attr('disabled','disabled'); 
				var uUser = ".$vUser.";
				console.log(uUser);
			</script>";
	
	
	$vCP = 0;
	$vCalle = '';
	$sRespuestaColonias = LlenarComboColoniasSepomex($vCP,$vCalle);
	
?>

<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
				<div>
					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body no-padding">
						<form action="" id="registrar_pedido" class="smart-form" novalidate="novalidate">
							<fieldset>							
									<div class="row">
										<section class="col col-4 pull-left">
											<h2 class="page-title txt-color-blueDark">
											</h2>
										</section>
										<section class="col col-2 pull-right">
											<label class="input">
												<input  id="folio" name="folio" type="text" placeholder="12345" disabled = "disabled" value="" >
											</label>
										</section>
										<label class="control-label pull-right"><h2>Folio:</h2></label>	
										<section class="col col-3 pull-right">
											<label class="select">
												<select name="empleado" id="empleado">
												</select> <i></i> 
											</label>		
										</section>
										<label class="control-label pull-right"> <h2>Empleado:</h2> </label>																			
									</div>
							</fieldset>
							<fieldset>							
									<div class="row">
										<section class="col col-2 pull-right">
											<label class="input">
												<input  id="idPapeleta" name="idPapeleta" type="number" placeholder="12345" value="0" onfocus="this.select();" onkeydown="ReCalcularSaldoPedido(1); isNumber(event); validaEnter(event,1);">
											</label>
										</section>
										<label class="control-label pull-right"><h2> Papeleta #:</h2></label>	
										<section class="col col-3 pull-right">
											<label class="input">
												<input  id="idContrato" name="idContrato" type="number" placeholder="12345" value="0" onfocus="this.select();" onkeydown="ReCalcularSaldoPedido(1); isNumber(event); validaEnter(event,1);">
											</label>		
										</section>
										<label class="control-label pull-right"> <h2>Contrato #:</h2> </label>																			
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
														<!--select class="form-control input-md" id="cmbarticulos_1" name="cmbarticulos" onchange="return consultarArticuloElegido(this.value,1)" -->
														<select class="select2" id="cmbarticulos_1" name="cmbarticulos" onchange="return consultarArticuloElegido(this.value,1)" style="min-width:200px;" >
														</select>													 
										                </td>
														<td ><input id="precio_1" name="precio" class="form-control input-md" placeholder="$0.00" type="text" disabled="disabled" readonly ></td>													
														<td ><input id="cantidad_1" name="cantidad" class="form-control input-md" placeholder="1" type="text" onkeyup="isNumber(event); ReCalcularSaldoPedido(1);" onkeydown="ReCalcularSaldoPedido(1); isNumber(event); validaEnter(event,1);" onkeypress="return isNumber(event);" onblur='validaBlur(1); ReCalcularSaldoPedido(1);' onfocus="this.select();"></td>
														<td ><input id="subtotal_1" name="subtotal" class="form-control input-md" placeholder="$0.00" type="text" disabled="disabled" readonly></td>
														<td >
															<input id="notaEspecial_1" name="subtotal" class="form-control input-md" placeholder="8 PM a 10 PM" type="text" disabled="disabled" readonly onkeypress="isAlphaNumeric(event); validaEnter(event,1);" maxlength="25" onfocus="this.select();">
															<input id="hidespecial_1" name="subtotal" class="form-control input-md" type="hidden" disabled="disabled" readonly>
															<input id="hidcantidad_1" name="subtotal" class="form-control input-md" type="hidden" disabled="disabled" readonly>
														</td>
													</tr>	
												</tbody>
											</table>
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
										<!--div class="table-responsive"-->	
											<section class="col col-4">	 
												<label class="label">Tipo de pago</label>
												<select class="form-control input-md" id="idTipoPago" name="idTipoPago" onchange="llenarcmbPlazoYCobro(this.value); CalcularSaldoPedido();"  width ="100%">
												</select>
											</section>
											<section class="col col-4">	 
												<label class="label">Plazo</label>
												<!--select class="select2" id="idPlazo" name="idPlazo" onchange="return consultarArticuloElegido(this.value,1)" -->
												<select class="form-control input-md" id="idPlazo" name="idPlazo" width ="100%" onchange="return modificarFechaVencimiento();">
												</select>
											</section>	
											<section class="col col-4">	 
												<label class="label">Periodo cobro</label>
												<select class="form-control input-md" id="idCobrarCada" name="idCobrarCada" width ="100%">
												</select>
											</section>
											<section class="col col-4">	 
												<label class="label">Vendedor</label>
												<select class="form-control input-md" id="idVendedor" name="idVendedor" width ="100%">
												</select>
											</section>
											<section class="col col-4">	 
												<label class="label">Supervisor</label>
												<select class="form-control input-md" id="idSupervisor" name="idSupervisor" width ="100%">
												</select>
											</section>
											<section class="col col-4">	 
												<label class="label">Descuento</label>
												<select class="form-control input-md" id="idDescuento" name="idDescuento" width ="100%" onblur="return ReCalcularSaldoPedido(1);">
												<option value = "0">0%</option>
												<option value = "0.5">5%</option>
												<option value = "0.10">10%</option>
												<option value = "0.15">15%</option>
												<option value = "0.20">20%</option>
												<option value = "0.25">25%</option>
												<option value = "0.30">30%</option>
												<option value = "0.35">35%</option>
												<option value = "0.40">40%</option>
												<option value = "0.45">45%</option>
												<option value = "0.50">50%</option>
												</select>
											</section>
									</section>
									<section class="pull-right">
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
							</fieldset>
								<div class="row">	
									<section class="col col-11">
									</section>
								</div>
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
							</fieldset>
							<fieldset>		
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
									<section class="col col-2" style="display:none">
										<label class="label">C&oacute;digo Postal</label>
										<label class="input"><i class="icon-prepend fa fa-tag"></i>
											<input type="text" name="CodigoPostal" id="CodigoPostal" placeholder="80000" data-mask="99999" onkeypress="return ConsultarCalleSepomex();" onkeyup="return isNumber(event);" onblur="return blurConsultarCalleSepomex();" onfocus="this.select();" readonly>
										</label>
									</section>
									<section class="col col-2">	
										<label class="label">Registrar colonia nueva</label>	
										<label class="checkbox">
											<input type="checkbox" name="check_ColoniaNueva" id="check_ColoniaNueva" value="0" onchange="return registrarNuevaColonia(this.value);">
											<i></i><span id="lbl_ColoniaNueva">Incluir</span>
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
									<section class="col col-2" style="display:none">
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
							</fieldset>
							<fieldset>		
								<div class="row">
									<section class="col col-5">
										<label class="label"><h5>Referencias familiares y no familiares:</h5></label>										 									
									</section>	
								</div>								
								<div class="row">
									<section class="col col-3">
										<label class="label"><sup>*</sup> Esposa (o)</label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" id="idReferenciaEsposo" name="idReferenciaEsposo" placeholder="JESUS PEREZ LOPEZ" onkeypress="return isAlphaNumeric(event);" maxlength="50" onfocus="this.select();">
										</label>
									</section>
									<section class="col col-2">
										<label class="label"><sup>*</sup> Tel&eacute;fono .</label>
										<label class="input"> <i class="icon-prepend fa fa-slack"></i>
											<input type="number" id="idTelEsposo" name="idTelEsposo" placeholder="6677777777" onkeypress="return isNumber(event);" maxlength="10" onfocus="this.select();">
										</label>
									</section>
									<section class="col col-4">
										<label class="label">Direcci&oacute;n.</label>
										<label class="input"> <i class="icon-prepend fa fa-building"></i>
											<input type="text" id="idDomicilioEsposo" name="idDomicilioEsposo" placeholder="EJEMPLO #123 COL. EJEMPLO" onkeypress="return isAlphaNumeric(event);" onfocus="this.select();">
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-3">
										<label class="label"><sup>*</sup> Referencia familiar</label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" id="idReferenciaFamiliar" name="idReferenciaFamiliar" placeholder="JESUS PEREZ LOPEZ" onkeypress="return isAlphaNumeric(event);" maxlength="50" onfocus="this.select();">
										</label>
									</section>
									<section class="col col-2">
										<label class="label"><sup>*</sup> Tel&eacute;fono .</label>
										<label class="input"> <i class="icon-prepend fa fa-slack"></i>
											<input type="number" id="idTelFamiliar" name="idTelFamiliar" placeholder="6677777777" onkeypress="return isNumber(event);" maxlength="10" onfocus="this.select();">
										</label>
									</section>
									<section class="col col-4">
										<label class="label">Direcci&oacute;n.</label>
										<label class="input"> <i class="icon-prepend fa fa-building"></i>
											<input type="text" id="idDomicilioFamiliar" name="idDomicilioFamiliar" placeholder="EJEMPLO #123 COL. EJEMPLO" onkeypress="return isAlphaNumeric(event);" onfocus="this.select();">
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-3">
										<label class="label"><sup>*</sup> Aval</label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" id="idReferenciaAval" name="idReferenciaAval" placeholder="JESUS PEREZ LOPEZ" onkeypress="return isAlphaNumeric(event);" maxlength="50" onfocus="this.select();">
										</label>
									</section>
									<section class="col col-2">
										<label class="label"><sup>*</sup> Tel&eacute;fono .</label>
										<label class="input"> <i class="icon-prepend fa fa-slack"></i>
											<input type="number" id="idTelAval" name="idTelAval" placeholder="6677777777" onkeypress="return isNumber(event);" maxlength="10" onfocus="this.select();">
										</label>
									</section>
									<section class="col col-4">
										<label class="label">Direcci&oacute;n.</label>
										<label class="input"> <i class="icon-prepend fa fa-building"></i>
											<input type="text" id="idDomicilioAval" name="idDomicilioAval" placeholder="EJEMPLO #123 COL. EJEMPLO" onkeypress="return isAlphaNumeric(event);" onfocus="this.select();">
										</label>
									</section>
								</div>
							</fieldset>
							<fieldset>	
								<div class="row">
									<section class="col col-4">
										<label class="label"><h5>Fechas del contrato de venta:</h5></label>										 									
									</section>	
								</div>						
								<div class="row">									
									<section class="col col-3">
										<label class="label"><sup>*</sup>Fecha pedido</label>			
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" id="fechaentrega" name="fechaentrega" placeholder="Seleccionar" class="datepicker" data-dateformat='yy-mm-dd' onkeypress="return false;" value="<?PHP echo $fecAgenda;?>" onfocus="this.select();" onchange="return cambiarFechaRecoleccion();">
										</label>										
									</section>
									<section class="col col-3">
										<label class="label"><sup>*</sup>Primer cobro</label>			
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" id="fecharecolectar" name="fecharecolectar" placeholder="Seleccionar" class="datepicker" data-dateformat='yy-mm-dd' onkeypress="return false;"  onfocus="this.select();">
										</label>										
									</section>
									<section class="col col-3">
										<label class="label"><sup>*</sup>Fecha vencimiento</label>			
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" id="fechavence" name="fechavence" placeholder="Seleccionar" class="datepicker" data-dateformat='yy-mm-dd' onkeypress="return false;"  onfocus="this.select();">
										</label>										
									</section>
								</div>
							</fieldset>
							<footer>
								<button type="button" class="btn btn-primary" id="btnGrabarPedido" onclick="return grabarPedido();">
									<i class="fa fa-save"></i>&nbsp;Guardar
								</button>
								<button id="cancelarPedido" type="button" class="btn btn-default" onclick="LimpiarCapturaPedidoNuevo();">
									Cancelar
								</button>
								<button id="cancelarPedido" type="button" class="btn btn-primary" onClick ="window.history.back();">
									<i class="fa fa-arrow-left"></i>&nbsp;Regresar
								</button>
							</footer>
						</form>
					</div>
				</div>
			</div>
		</article>
	</div>
</section>
<input id="consecutivo" name="consecutivo" type="hidden" value=1 />
<input id="clientekeyx" name="clientekeyx" type="hidden" value=0 />
<input id="direccionkeyx" name="direccionkeyx" type="hidden" value=0 />
<input id="diasSumarPrimerCobro" name="diasSumarPrimerCobro" type="hidden" value=0 />

<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">
	$("input,select,textarea").bind("keyup", function (e) {

	  var keyCode = e.keyCode || e.which;
		   if(e.keyCode === 13) {
			e.preventDefault();
			$('input,select,textarea')[$('input,select,textarea').index(this)+1].focus();
			}
	});
	//var valorMaximo =parseInt('< ?PHP echo $Valores['valor'];?>');
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

			nuevaFila+="<td><select class='form-control input-md' id='cmbarticulos_"+ vConsecutivo +"' name='cmbarticulos_"+ vConsecutivo +"' onchange='return consultarArticuloElegido(this.value,"+vConsecutivo+");' style='min-width:200px;'>"+listInventario+"</select></td>";
			nuevaFila+="<td><input class='form-control input-md' placeholder='$0.00' type='text' disabled='disabled' id='precio_"+ vConsecutivo +"' name='precio_"+ vConsecutivo +"';></td>";									
			nuevaFila+="<td><input class='form-control input-md' placeholder='1' type='text' id='cantidad_"+ vConsecutivo +"' name='cantidad_"+ vConsecutivo +"' onkeyup='ReCalcularSaldoPedido("+ vConsecutivo +"); isNumber(event);' onfocus='this.select();' onkeydown='isNumber(event); ReCalcularSaldoPedido("+ vConsecutivo +"); validaEnter(event," + vConsecutivo + ");' onblur='validaBlur(" + vConsecutivo + "); ReCalcularSaldoPedido(" + vConsecutivo + ");' onkeypress='return isNumber(event);'></td>";
			nuevaFila+="<td><input class='form-control input-md' placeholder='$0.00' type='text' disabled='disabled' id='subtotal_"+ vConsecutivo +"' name='subtotal_"+ vConsecutivo +"'></td>";
			nuevaFila+="<td><input id='notaEspecial_" + vConsecutivo + "' name='notaEspecial' class='form-control input-md' placeholder='8 PM a 10 PM' type='text' disabled='disabled' readonly onfocus='this.select();' onkeypress='isAlphaNumeric(event); validaEnter(event," + vConsecutivo + ");'>"+
				"<input id='hidespecial_"+ vConsecutivo + "' name='hidespecial' class='form-control input-md' type='hidden' disabled='disabled' readonly>" +
				"<input id='hidcantidad_"+ vConsecutivo +"' name='hidcantidad' class='form-control input-md'  type='hidden' disabled='disabled' readonly></td>";
			
            nuevaFila+="</tr>";
            $("#tb_detallepedido").append(nuevaFila);
			$("#cmbarticulos_"+ vConsecutivo).select2();
			//CalcularSaldoPedido();
			$('html,body').animate({scrollTop:$("#agregar_fila").offset().top-60},'slow');
			setTimeout(function(){ 
				$("#cmbarticulos_"+ vConsecutivo).select2('focus');
				$("#cmbarticulos_"+ vConsecutivo).focus();
				$("#cmbarticulos_"+ vConsecutivo).select2('open');
				//$("#cmbarticulos_"+ vConsecutivo).select2('close');
			//	$('.select2').attr('min-width','350px');
			//	$('#idTab').animate({scrollLeft:'0px'},10);
				
			}, 50);
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
	
	/*function ConsultarFolioSiguiente(){
		var vFolioPedido = '< ? PHP echo $sRFolio;?>';
		return vFolioPedido;
	}*/
	
	/*function LimpiarGrid(){
		$("#tabla").remove();
	}*/
	
	var sDomiciliosArray = '';
	
	$(function() {
		var availableTags = [<?PHP echo $sRespuestaColonias['data'];?>];
		$( "#Colonia" ).autocomplete({
			source: availableTags
		});
	});

	var domiciliosCliente;
	var domicilioSet;
	var sUrlRedirected = '<?PHP echo APP_URL."/#ajax/dashboard.php";?>';
	
	function obtenerFechaEntrega(){
		return '<?PHP echo $fecAgenda;?>';
	}
	
	function obtenerFechaRecolecta(){
		return '<?PHP echo $fecAgendaMasUnDia;?>';
	}
	
	setTimeout(function(){ 
		$("#cmbarticulos_1").select2();
		$("#cmbarticulos_1").select2('focus');
		$("#cmbarticulos_1").select2('open');
		//$("#cmbarticulos_1").select2('close');
	}, 50);
</script>
<script src="js/piscis/captura_pedido.js"></script>
