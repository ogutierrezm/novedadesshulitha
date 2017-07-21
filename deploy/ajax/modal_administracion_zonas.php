<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');	
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$region = (isset($_GET['region'])?$_GET['region']:0);
	$nombreregion = (isset($_GET['nombreregion'])?utf8_encode($_GET['nombreregion']):'');
	$descregion = (isset($_GET['descregion'])?utf8_encode($_GET['descregion']):'');
	$nombreregion = htmlentities(str_replace('%',' ',$nombreregion));
	$descregion = htmlentities(str_replace('%',' ',$descregion));
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title"><img src="img/logo_scp-04.png" width="150" alt="logo"></h4>
</div>
<div class="modal-body no-padding">
		<form action="" id="actualiza_zonas" class="smart-form" novalidate="novalidate">
							<header>
								<h2><i class="glyphicon glyphicon-pencil"></i>&nbsp;Editar zona &nbsp; <?PHP echo $region;?></h2>
							</header>
							<!-- cabecero --><!-- -->
							<!-- datos de la colonia -->							 
							<fieldset>
									<div class="row">										
										<section class="col col-3">
											<label class="label"><sup>*</sup>Nombre</label>
											<label class="input"><i class="icon-prepend fa fa-tag"></i>
												<input type="text" id="nombremodal" name="nombremodal" placeholder="Zona uno" value="<?PHP echo $nombreregion;?>" onkeypress="return isAlphaNumeric(event);" maxlength="80" onfocus="this.select();">
											</label>
										</section>
									</div>
									<div class="row">
										<section class="col col-6">
												<label class="label"><sup>*</sup>Descripci&oacute;n:</label>											
												<label class="textarea"><i class="icon-prepend fa fa-comment"></i>									
													<textarea rows="3" id="descripcionmodal" name="descripcionmodal" placeholder="Caracteristicas de la zona..." onkeypress="return isAlphaNumeric(event);" onfocus="this.select();" maxlength="120"><?PHP echo $descregion;?></textarea> 
												</label>
										</section>
									</div> 						
								</fieldset>	
							<div class="col col-4">
								<p class="note">*Campo obligatorio.</p>
							</div>
							<footer>
								<button type="button" id="btnGUpdateZona" class="btn btn-primary" onclick="return actulizarZona(<?PHP echo $region;?>);">
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
	
	var pagefunction = function() { 		 

			/* Validaciones */
		var $registerForm = $("#actualiza_zonas").validate({
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





