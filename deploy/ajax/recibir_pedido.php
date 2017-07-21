<?php 
	require_once("inc/init.php"); 
	
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');	
	
	date_default_timezone_set ("America/Mazatlan");
	$fecha = date('Y-m-d');
	
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	
	$sPermisos = ISSET($_SESSION['permisos'])?$_SESSION['permisos']:'';
	$nombreUsuario = ISSET($_SESSION['nombreUsuario'])?utf8_encode($_SESSION['nombreUsuario']):'';
	$vUser= ISSET($_SESSION['keyx'])?$_SESSION['keyx']:0;
	if ($vUser > 0){ 
		$datos = consultaUnUsuario($vUser);
	}
	echo 	"<script> 	var vId_puesto = ". $datos['data']['id_puesto'].";
						var vKeyx = ". $datos['data']['keyx'].";
						$('#empleado').val(vId_puesto);
			</script>";
			
	$folio = ISSET($_GET['folio'])?$_GET['folio']:'';
	if ($folio != ''){
		echo 	"<script> 
					$('#folio').val($folio);			
					ConsultarFolioPedido();
				 </script>";
	}
	
	$variable = obtenerVariableEmpresa(2,1);
	$variable = ISSET($variable['data']['valor'])?$variable['data']['valor']:300;
	echo '<script>var vTiempoSesion = '.$variable.';</script>';
	/*include("../php/expire.php");  */  
?>
<!--div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			<i class="fa fa-list-alt"></i> 
				Recibir pedido			
		</h1>
	</div>
</div-->													
<!-- formulario de reciba de pedido -->
<section id="widget-grid" class="">
	<!-- START ROW -->
	<div class="row">
		<!-- NEW COL START -->
		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-5" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
				<!-- widget div-->
				<div>
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->
					</div>
					<!-- end widget edit box -->
					<!-- widget content -->
					<div class="widget-body no-padding">
						<input class="form-control input-md" type="text" id="empleado" style="display:none">
						<form action="" id="recibir_pedido" class="smart-form" novalidate="novalidate">
							<!--header>
								<h1>&nbsp;</h1>
							</header-->
							<!-- cabecero -->
							<fieldset>							
								<div class="row">
									<section class="col col-4">
								       	<div class="well well-sm">
											<div class="input-group">
												<span class="input-group-addon font-md">FOLIO&nbsp;</span>
												<input class="form-control input-md" type="text" id="folio" placeholder="" onkeypress="return isNumber(event);"  maxlength="10">
												<span class="input-group-addon"><a href="javascript:ConsultarFolioPedido();">Buscar <i  class="fa fa-fw fa-md fa-search"></i></a></span>
											</div>											
										</div>
										<p class="note"><strong>Nota:&nbsp;</strong>Ingresa el folio del pedido.</p>									
									</section>
									<section class="col col-5  pull-left">
										<label class="control-label pull-right"><h5 class="text-primary"><strong>RECIBE:</strong>&nbsp;<label id="idEmpleado"><?PHP echo strtoupper($nombreUsuario) ?></label></h5></label>
									</section>	
									<section class="col col-2 pull-right">
										<button id="btnRptEficiencia" class="btn btn-primary" type="button" onClick ="window.history.back();">
											<i class="fa fa-arrow-left"></i>&nbsp;	Regresar
										</button>
									</section>	
								</div>
							</fieldset>
							<!--fieldset>
								<div class="row"> 									
									<section class="col col-4">
								       	<div class="well well-sm">
											<div class="input-group">
												<span class="input-group-addon font-md">FOLIO&nbsp;</span>
												<input class="form-control input-md" type="text" id="folio" placeholder="" onkeypress="return isNumber(event);"  maxlength="10">
												<span class="input-group-addon"><a href="javascript:ConsultarFolioPedido();">Buscar <i  class="fa fa-fw fa-md fa-search"></i></a></span>
											</div>											
										</div>
										<p class="note"><strong>Nota:&nbsp;</strong>Ingresa el folio del pedido.</p>									
									</section>
								</div>
							</fieldset>
							<!-- datos del cliente -->
							<fieldset>
								<div class="row">
									<section class="col col-3">
										<label class="label"><h5>Datos del cliente:</h5></label>										 									
									</section>	
								</div>		
								 				 
								<div class="row">
									<section class="col col-4">
										<label class="label">Nombre(s)</label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" id="nombre" name="nombre" placeholder="Juan Perez" disabled="disabled" readonly>
										</label>
									</section>
									<section class="col col-3" style ="disabled:disabled">
										<label class="label">Requiere IVA</label>	
										<label class="checkbox">
											<input type="checkbox" name="check_IVA" id="check_IVA" value="0" onchange="return cambiarValorIVA(this.value);">
											<i></i><span id="lblIva">No incluir</span>
										</label>							
									</section>
								</div>
							</fieldset>
							<!-- datos de la entrega -->
							<fieldset>		
								<div class="row">
									<section class="col col-3">
										<label class="label"><h5>Domicilio:</h5></label>										 									
									</section>	
								</div>								
								<div class="row">
									<section class="col col-5">
										<label class="label">Calle</label>
										<label class="input"> <i class="icon-prepend fa fa-road"></i>
											<input type="text" id="calle" name="calle" placeholder="Morelos" disabled="disabled" readonly>
										</label>
									</section>
									<section class="col col-2">
										<label class="label">N&uacute;mero Ext.</label>
										<label class="input"> <i class="icon-prepend fa fa-slack"></i>
											<input type="text" id="numext" name="numext" placeholder="123" disabled="disabled" readonly>
										</label>
									</section>
									<section class="col col-2">
										<label class="label">N&uacute;mero Int.</label>
										<label class="input"> <i class="icon-prepend fa fa-slack"></i>
											<input type="text" id="numint" name="numint" placeholder="123" disabled="disabled" readonly>
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-2">
										<label class="label">C&oacute;digo Postal</label>
										<label class="input"><i class="icon-prepend fa fa-tag"></i>
											<input type="text" name="CodigoPostal" id="CodigoPostal" placeholder="80000" data-mask="99999" onkeypress="return ConsultarCalleSepomex();" disabled="disabled" readonly>
										</label>
									</section>
									<section class="col col-3">
										<label class="label">Colonia</label>
										<label class="input"><i class="icon-prepend fa fa-tag"></i>
											<input type="text" id="colonia" name="colonia" id="CodigoPostal" placeholder="Centro" disabled="disabled" readonly>
										</label>
									</section>
									<section class="col col-2">
										<label class="label">Municipio</label>
										<label class="input"><i class="icon-prepend fa fa-map-marker"></i>
											<input type="text" name="municipio" id="municipio" placeholder="C&uacute;liacan" disabled="disabled" readonly>
										</label>
									</section>									
								</div>								 
							</fieldset>	
							<!-- detalle del pedido -->
							<fieldset>	
								<div class="row">
									<section class="col col-3">
										<label class="label"><h5>Fecha de entrega y recolecci&oacute;n:</h5></label>										 									
									</section>	
								</div>						
								<div class="row">									
									<section class="col col-3">
										<label class="label">Del:</label>			
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" id="fechaentrega" name="fechaentrega" placeholder="Seleccionar" class="datepicker" data-dateformat='dd/mm/yy' disabled="disabled" readonly>
										</label>										
									</section>
									<section class="col col-3">
										<label class="label">Al :</label>			
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" id="fecharecolectar" name="fecharecolectar" placeholder="Seleccionar" class="datepicker" data-dateformat='dd/mm/yy' disabled="disabled" readonly>
										</label>										
									</section>
									<section class="col col-2">
										<label class="label">Hora Entrega:</label>
										<label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
											<input type="text" id="hora1" name="hora1" placeholder="8:00am" disabled="disabled" readonly>
										</label>
									</section>
									<section class="col col-2">
										<label class="label">Hora Recibir:</label>
										<label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
											<input type="text" id="hora2" name="hora2" placeholder="8:00am" disabled="disabled" readonly>
										</label>
									</section>
								</div>
							</fieldset>
							<fieldset>
								<div class="row">
									<section class="col col-3">
										<label class="label"><h5>Detalle del pedido:</h5></label>										 									
									</section>	
								</div>		
								<div class="row">
									<section class="col col-10">								 	 
										<div class="table-responsive">								
											<table class="table table-bordered table-striped" id="tb_detallepedido">
												<thead>
													<tr>
														<th style="width:15px">#</th>
														<th>Art&iacute;culo</th>
														<th>Cantidad</th>
														<th>Subtotal</th>
													</tr>
												</thead>												
												<tbody id="tbodyRecibirPedido">
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
													</tr>
												</tbody>												 
											</table>											
											</br>
										</div><!-- fin tabla -->
										<section class="pull-right">
										<div class="table-responsive">
											<table class="table table-condensed">
												<tr>
													<td style="text-align:right;">
														<i class="fa fa-caret-right"></i>
														<span class="font-md">Importe total:$&nbsp;													
															<span class="text-primary" id="total" class="label">0</span>
														</span>	 
													</td>												
												</tr>
												<tr>
													<td style="text-align:right;">
														<i class="fa fa-minus"></i>
														<span class="font-md">Abono:$&nbsp;													
															<span class="txt-color-redLight" id="abono" class="label">0</span>
														</span>	 
													</td>												
												</tr>
											</table>
										<div>
										</section>									 
									</section>	 
								</div>
							</fieldset>
							<fieldset>
								<div class ="row">
									<section class="col col-12">
										<div class="well">
											<div class="btn-group btn-group-justified" id="actividadPedido">
												<a href="ajax/modal_liquidarpedido.php" id="liquidaPedido" data-toggle="modal" data-target="#modalLiquidar" class="btn btn-primary btn-sm"><i class="fa fa-caret-square-o-right"></i>&nbsp;Liquidar pedido</a>
												<a href="ajax/modal_recibirabono.php" id="recibirAbono" data-toggle="modal" data-target="#modalAbono" class="btn bg-color-blueDark txt-color-white btn-sm"><i class="fa fa-usd"></i>&nbsp;Recibir abono</a>
												<a href="ajax/modal_entradaparcial.php" id="entradaParcial" data-toggle="modal" data-target="#modalEntrada" class="btn btn-primary btn-sm"><i class="fa fa-reply-all"></i>&nbsp;Entrada parcial</a>
												<a href="ajax/modal_devolverdeposito.php" id="devolverdeposito" data-toggle="modal" data-target="#modalDeposito" class="btn bg-color-blueDark txt-color-white btn-sm"><i class="fa fa-usd"></i>&nbsp;Regresar dep&oacute;sito</a>
											</div>
										</div>
										<p class="note"><i class="fa-fw fa fa-question-circle"></i>&nbsp;<a href="javascript:void(0);" id="nota"><small>Notas</small></a></p>
									</section>
								</div>
							</fieldset>							
							<fieldset>
								<div class="alert alert-block alert-info" id="bloque_info" style="display:none;">
									<a class="close" data-dismiss="alert" href="#">×</a>
									<h5 class="alert-heading"><i class="fa fa-pencil-square-o"></i>&nbsp;Nota:</h5>
									<p>
										<strong>Liquidar pedido</strong>: Recibir el total de la mercancia rentada y liquidar el total del importe de la renta.
									</p>
									<p>
										<strong>Recibir abono</strong>: Recibir un abono que se descontara del total del importe de la renta.
									</p>
									<p>
										<strong>Entrada parcial</strong>: Recibir de manera parcial la mercancia rentada.
									</p>
									
								</div>
								<section>
									<div class="alert alert-block alert-success" style="display:none">
										<a class="close" data-dismiss="alert" href="#">×</a>
										<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ! &Eacute;xito !</h4>
										<p>
											El pedido se ha guardado &eacute;xitosamente.
										</p>
									</div>
								</section>
								<section >
									<div class="alert alert-block alert-danger" style="display:none">
										<a class="close" data-dismiss="alert" href="#">×</a>
										<h4 class="alert-heading"><i class="fa fa-warning"></i> ! Ocurri&oacute; un error !</h4>
										<p>
											Ocurri&oacute; un error al guardar el pedido.
										</p>
									</div>
								</section>
							</fieldset>
						</form> <!-- Termina formulario  -->
						
						<!-- MODAL -->
						<fieldset> 
								<!-- MODAL LIQUIDAR PEDIDO-->
								<div class="modal fade" id="modalLiquidar" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content"></div></div>
									</div>						 
								</div>
						</fieldset>	
						<fieldset> 
								<!-- MODAL ABONO-->
								<div class="modal fade" id="modalAbono" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content"></div></div>
									</div>						 
								</div>
						</fieldset>	
						<fieldset> 
								<!-- MODAL ENTRADA PARCIAL-->
								<div class="modal fade" id="modalEntrada" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content"></div></div>
									</div>						 
								</div>
						</fieldset>	
						<fieldset> 
								<!-- MODAL ENTRADA PARCIAL-->
								<div class="modal fade" id="modalDeposito" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content"></div></div>
									</div>						 
								</div>
						</fieldset>
						<!-- FIN MODAL -->	
						
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
			</div>
 
		</article>
		<!-- END COL -->
	</div>

</section> <!-- seccion -->

<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">

	pageSetUp();	
	
	// PAGE RELATED SCRIPTS

	// pagefunction
	
	var pagefunction = function() {

		var $checkoutForm = $('#recibir_pedido').validate({
		// Rules for form validation
			rules : {

				/*
				empleado : {
					required : true
				},
				telefono : {
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
				colonia : {
					required : true,
					digits : true
				},
				fechaentrega : {
					required : true
				},
				fecharecolectar : {
					required : true
				},
				hora : {
					required : true
				}
				*/

			},
	
			// Personalizar mensajes 
			messages : {
				/*campo : {
					required : '*Campo obligatorio.'
				}*/
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
			$('input,select,textarea,a')[$('input,select,textarea,a').index(this)+1].focus();
			}
	});
	 
		 
		// Notas
		$('#nota').click(function(){
          //$("#hora2").css("display", "block");
          $("#bloque_info").toggle();
      	});
		
	// end pagefunction
	
	// Load form valisation dependency 
	loadScript("js/plugin/jquery-form/jquery-form.min.js", pagefunction);
	
	function MostrarRecibirYLiquidar(vFolio,vFechaPedido){
		var vFechaHoy = '<?PHP echo $fecha;?>';
		var bRespuesta = compararFechasInicioMayor(vFechaPedido,vFechaHoy);
		
		//console.log(bRespuesta);
		if (bRespuesta){
			$("#liquidaPedido").attr('href','ajax/modal_liquidarpedido.php?foliopedido='+vFolio);
			$("#entradaParcial").attr('href','ajax/modal_entradaparcial.php?foliopedido='+vFolio);
		}else{
			$("#liquidaPedido").removeAttr('href');
			$("#entradaParcial").removeAttr('href');
			$("#liquidaPedido").css('display','none');
			$("#entradaParcial").css('display','none');
		}
			
		return true;
	}
	
	var vFlagReload =0;
</script>
<input id="consecutivo" name="consecutivo" type="hidden" value=1 />

