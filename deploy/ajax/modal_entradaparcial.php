<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');	
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$iFolioPedido = (isset($_GET['foliopedido'])?$_GET['foliopedido']:0);
	$Nota = ConsultarNotaAccesorios($iFolioPedido);
	$Nota = $Nota['data'];
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title"><img src="img/logo_scp-04.png" width="150" alt="logo"></h4>
</div>
<div class="modal-body no-padding">
		<form action="" id="entrada_parcial" class="smart-form" novalidate="novalidate">
			<header>
				<h2><i class="glyphicon glyphicon-retweet"></i>&nbsp;Entrada parcial</h2>								
			</header>
			<fieldset>
				<div class="row">										
					<section class="col col-3">
						<div class="well well-sm bg-color-darken txt-color-white text-left" id="folio">
							<h5>&nbsp;FOLIO #<?PHP echo $iFolioPedido;?></h5>										 
						</div>						 			  
					</section>
				</div>									 					
			</fieldset>	
			<fieldset>
				<div class="row">
					<section class="col col-3">						 
						<h5>Detalle del pedido</h5>
					</section>
					<section class="col col-5">	 
						<label class="label">accesorios pendientes</label>			
						<label class="textarea"><i class="icon-prepend fa fa-comment"></i>									
							<textarea rows="3" class="custom-scroll" id="idAccesorios" onfocus="this.select();" name="idAccesorios" placeholder="Microfonos" onkeypress="return isAlphaNumeric(event);" maxlength="120"><?PHP echo $Nota['retorno']?></textarea> 
						</label>
					</section>
					<section class="col col-11">								 	 
						<div class="table-responsive">								
							<table class="table table-bordered table-striped" id="tb_detallepedido">
								<thead>
									<tr>
										<th style="width:10%;">#</th>
										<th style="width:65%;">Art&iacute;culo</th>														 
										<th style="width:15%;">Cantidad</th>
										<th style="width:15%;">Cantidad</th>														 
									</tr>
								</thead> 
								<tbody style="overflow-y:scroll;" id="tbodyArticulosModal">
									<?PHP
										$sRespuesta = consultarArticulosParcialesUnPedidosPendienteModal($iFolioPedido);
										echo $sRespuesta['data'];
									?>
								</tbody>
							</table>
							<section class="pull-right">												 
								<i class="fa fa-caret-right"></i>
									<span class="font-xs">Total art&iacute;culos:&nbsp;													
									<span class="text-primary" id="totalarticulos" class="label">0</span>
								</span>													 
							</section>
					 
						</div>
					</section>
				</div>									 					
			</fieldset>	
				<div class="col col-6">
					<p class="note"><b>Nota:</b> Una entrada parcial corresponde a un parte de los articulos rentados.</p>
				</div>
			<footer>
				<!--button type="button" id="btnGEntradaParcial" class="btn btn-primary" onclick="return regresarDetalleInventario();"-->
				<button type="button" id="btnGEntradaParcial" class="btn btn-primary" onclick="return MensajeSmartregresarDetalleInventario();">
					<i class="fa fa-save"></i>&nbsp;Guardar
				</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Cancelar
				</button>
			</footer>
		</form> <!--     Termina formulario  -->
		<!-- mensajes de error -->						
		<fieldset>
			<section>
				<div class="alert alert-block alert-success" id="MsgExitoUsr" style="display:none">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ! &Eacute;xito !</h4>									
					<p>
						<div id="mensajeOk">
							Se actualizo el registro &eacute;xitosamente.
						</div>
					</p>									
				</div>
			</section>
			<section>
				<div class="alert alert-block alert-danger" id="MsgFallaUsr" style="display:none">
					<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading"><i class="fa fa-warning"></i> ! Ocurri&oacute; un error !</h4>
							<p>
								<div id="mensajeFail">
									Ocurri&oacute; un error al guardar.
								</div>
							</p>
				</div>
			</section>
		</fieldset>
</div>

<script type="text/javascript">	
	 
	pageSetUp();	
	
	// PAGE RELATED SCRIPTS

	function solo_numeros(ob) {
			 var invalidChars = /[^0-9]/gi
			 if(invalidChars.test(ob.value)) {
			            ob.value = ob.value.replace(invalidChars,"");
			 }
	} 
	
	var pagefunction = function() {  

			/* Validaciones */
		var $registerForm = $("#entrada_parcial").validate({
			// Rules for form validation
			rules : {
				cantidad : {
					required : true
				} 
			},
			// Messages for form validation
			messages : {
				
				cantidad : {
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
	
</script>





