<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$iFolioPedido = (isset($_GET['foliopedido'])?$_GET['foliopedido']:0);
	$iTotal = (isset($_GET['importe_total'])?$_GET['importe_total']:0);
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title"><img src="img/logo_scp-04.png" width="150" alt="logo"></h4>
</div>
<div class="modal-body no-padding">
		<form action="" id="recibir_abono" class="smart-form" novalidate="novalidate">
			<header>
				<h2><i class="glyphicon glyphicon-usd"></i>&nbsp;Recibir abono</h2>								
			</header>
			<fieldset>
				<div class="row">										
					<section class="col col-3">
						<div class="well well-sm bg-color-darken txt-color-white text-left" id="folio">
							<h5 >&nbsp;FOLIO #&nbsp;<label id="foliomodal"><?PHP echo $iFolioPedido; ?></label></h5>										 
						</div>						 			  
					</section>
				</div>									 					
			</fieldset>	
			<fieldset>
				<div class="row row-seperator-header">										
					<section class="col col-3">
						<label class="label">Importe total:</label>
								<label class="input"> <i class="icon-prepend fa fa-chevron-circle-right"></i>
								<input type="text" id="totalmodal" name="totalmodal" placeholder="" value="<?PHP echo $iTotal; ?>" readonly="readonly" disabled="disabled">
						</label>					 			  
					</section>
					<section class="col col-4">
						<label class="label">Cantidad a abonar:</label>
								<label class="input"> <i class="icon-prepend fa fa-chevron-circle-right"></i>
								<input type="text" name="importe_totalmodal" id="importe_totalmodal" maxlength="10"  class="solo_numeros" onkeyup="solo_numeros(this)">

						</label>					 			  
					</section>
					<section class="col col-4">
						<label class="label">Recibi&oacute;:</label>
								<label class="input"> <i class="icon-prepend fa fa-chevron-circle-right"></i>
								<input type="text" name="idRecibed" id="idRecibed" maxlength="20"  onkeyup="return isAlphaNumeric(event);">

						</label>					 			  
					</section>
				</div>									 					
			</fieldset>	
				<div class="col col-6">
					<p class="note"><b>Nota:</b> Un abono es el total o parcial del precio correspondiente a la renta de los articulos.</p>
				</div>
			<footer>
				<button type="button" id="btnGAbonar" class="btn btn-primary" onclick="return MensajeSmartAbonoPedido(<?PHP echo $iFolioPedido; ?>);">
					<i class="fa fa-save"></i>&nbsp;Abonar
				</button>
				<button type="button" id="btnSalirAbono" class="btn btn-default" data-dismiss="modal" onclick="javascript:void(0);">
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
		var $registerForm = $("#form").validate({
			// Rules for form validation
			rules : {
				importe_abono : {
					required : true
				} 
			},
			// Messages for form validation
			messages : {
				
				importe_abono : {
					required : '*Campo obligatorio.'
				} 
			},
			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});

	}; 
	
</script>





