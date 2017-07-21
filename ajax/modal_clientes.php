<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');	
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$vCte = (isset($_GET['ct'])?utf8_encode($_GET['ct']):0);
	//$vKeyx = (isset($_GET['ke'])?utf8_encode($_GET['ke']):0);
	
	echo 	"<script> 	$('#numcliente').val(". $vCte.");
						ConsultarCteKeyx();
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
						<form action="" id="frm_cliente" class="smart-form" novalidate="novalidate">
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
									<section class="col col-4">
										<label class="label"># del INE</label>
										<label class="input"> <i class="icon-prepend fa fa-slack"></i>
											<input type="text" id="email" name="email" placeholder="#############" onkeypress="return isNumber(event);" maxlength="13" onfocus="this.select();" onblur="return validarCorreo();">
										</label>
									</section>
								</div>
							</fieldset>
							<!-- Datos de la entrega -->
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
							<footer>
								<button type="button" class="btn btn-primary" id="btnGrabarPedido" onclick="return grabarPedido();">
									<i class="fa fa-save"></i>&nbsp;Guardar
								</button>
								<button id="cancelarPedido" type="button" class="btn btn-default" onclick="LimpiarCapturaPedidoNuevo();">
									Cancelar
								</button>
								<!--button id="cancelarPedido" type="button" class="btn btn-primary" onClick ="window.history.back();">
									<i class="fa fa-arrow-left"></i>&nbsp;Regresar
								</button-->
							</footer>
						</form>
					</div>
				</div>
			</div>
		</article>
	</div>
</section>
<script type="text/javascript">	
	 
	pageSetUp();	
	
	// PAGE RELATED SCRIPTS 
	
	var pagefunction = function() { 		 

			var $registerForm = $("#actualiza_usuarios").validate({

			// Rules for form validation
			rules : {
				usuario : {
					required : true
				},				
				contrasena : {
					required : true,
					minlength : 3,
					maxlength : 20
				},
				confirmarcontrasena : {
					required : true,
					minlength : 3,
					maxlength : 20,
					equalTo : '#mdlPassword'
				},
				nombre : {
					required : true
				}
			},

			// Messages personalizados
			messages : {
				login : {
					required : '*Campo obligatorio.'
				}
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		}); 

	};
	$("input,select,textarea").bind("keyup", function (e) {

	  var keyCode = e.keyCode || e.which;
		   if(e.keyCode === 13) {
			e.preventDefault();
			$('input,select,textarea')[$('input,select,textarea').index(this)+1].focus();
			}
	});
	
	//$('#.ui-autocomplete { z-index:2147483647 !important;});
	
	var availableTags = [<?PHP echo $sRespuestaColonias['data'];?>];
	$(function() {
		$( "#Colonia" ).autocomplete({
		  source: availableTags
		});
	});
	
</script>





