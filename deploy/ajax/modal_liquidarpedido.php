<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');	
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$iFolioPedido = (isset($_GET['foliopedido'])?$_GET['foliopedido']:0);
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title"><img src="img/logo_scp-04.png" width="150" alt="logo"></h4>
</div>
<div class="modal-body no-padding"> 


	<form action="" id="form" class="smart-form" novalidate="novalidate">
		<header>
			<h2><i class="glyphicon glyphicon-expand"></i>&nbsp;Liquidar Pedido</h2>								
		</header>
		<div class="jumbotron" style =" align-items: center;">
			<fieldset>
				<div class="row">										
					<section class="col col-12">
						 <table width="100%" class="table table-borderless table-condensed table-hover">
							<?PHP
								$sRespuesta = generaModalUnPedidosPendienteARecibir($iFolioPedido);
								echo $sRespuesta['data'];
							?>
						</table>
					</section>
				</div>									 					
			</fieldset>	
		</div>
		<div class="col col-6">
			<p class="note"><b>Nota:</b> Al liquidar el pedido estas recibiendo el total del importe y el total de los art&iacute;culos rentados.</p>
		</div>
		<footer>
			<button type="button" id="btnGLiquidar" class="btn btn-primary" onclick="return MensajeSmartLiquidarPedido();">
				<i class="fa fa-save"></i>&nbsp;Liquidar pedido
			</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">
				Cancelar
			</button>
		</footer>
	</form> 
</div>

<script type="text/javascript">	
	 
	pageSetUp();	
	
	// PAGE RELATED SCRIPTS 
	
	var pagefunction = function() { 		 

			/* Validaciones */
		var $registerForm = $("#form").validate({
			// Rules for form validation
			rules : {
				nombre : {
					required : true
				},
				descripcion : {
					required : true
				}
			},
			// Messages for form validation
			messages : {
				
				nombre : {
					required : '*Campo obligatorio.'
				},
				descripcion : {
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





