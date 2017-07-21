<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');	
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$vUser = (isset($_GET['usr'])?utf8_encode($_GET['usr']):0);
	//echo $vUser;
	//die();
	if ($vUser > 0){ 
		$datos = consultaUnUsuario($vUser);
		//print_r($datos);
	}
	echo 	"<script> 	var vId_puesto = ". $datos['data']['id_puesto'].";
						var vKeyx = ". $datos['data']['keyx'].";
						$('#mdlEmpleados').val(vKeyx);
			</script>"
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title"><img src="img/logo_scp-04.png" width="150" alt="logo"></h4>
</div>
<div class="modal-body no-padding">
		<form action="" id="actualiza_usuarios" class="smart-form" novalidate="novalidate">
							<header>
								<h2><i class="glyphicon glyphicon-user"></i>&nbsp;Editar usuario</h2>								
							</header>

							<!-- cabecero --><!-- -->
							<!-- datos del usuario -->
							<fieldset>
							<div class="row">
								<section class="col col-2">
									<div class="well well-sm bg-color-darken txt-color-white text-left" id="mdlNumUsr">
										<h5>&nbsp;ID #<?PHP echo $datos['data']['id_puesto'];?></h5>										 
									</div>
								</section>					 
								<!--<h4 class="row-seperator-header">ID: 123</h4>-->
							</div>								 
								<div class="row">
									<section class="col col-4">
										<label class="label"><sup>*</sup> Usuario</label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="mdlUsuario" id="mdlUsuario" placeholder="Juan" value="<?PHP echo $datos['data']['usuario'];?>" onkeypress="return isAlphaNumeric(event);" maxlength="50" onfocus="this.select();">
											<span class="tooltip tooltip-bottom-right">Nombre identificador</span> </label>
										</label>
									</section>
									<section class="col col-4">
										<label class="label"><sup>*</sup>Puesto</label>
										<label class="select">
										<select name="mdlEmpleados" id="mdlEmpleados">
											<?PHP
												$sRespuesta = LlenarComboPuestos();
												echo $sRespuesta['data'];
											?>
										</select> <i></i> 
										</label>
									</section>
								</div>								 
								<div class="row">
									<section class="col col-4">
										<label class="label"><sup>*</sup>Nombre (s)</label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="mdlNombre" id="mdlNombre" placeholder="Juan" value="<?PHP echo $datos['data']['nombre'];?>" onkeypress="return isLetter(event);" maxlength="100" onfocus="this.select();">
										</label>
									</section>
								</div>							 							
								<div class="row">
									<section class="col col-4">
										<label class="label"><sup>*</sup>Contraseña</label>
										<label class="input"> <i class="icon-prepend fa fa-lock"></i>
										<input type="password" name="mdlPassword"  placeholder="*********" id="mdlPassword" onkeypress="return isAlphaNumeric(event);" maxlength="30">
										<b class="tooltip tooltip-bottom-right">Debe contener entre 3 y 20 caracteres.</b> </label>
									</section>
									<section class="col col-4">
										<label class="label"><sup>*</sup>Confirmar contraseña</label>
										<label class="input"> <i class="icon-prepend fa fa-lock"></i>
										<input type="password" name="mdlPasswordConf" id="mdlPasswordConf" placeholder="*********" onkeypress="return isAlphaNumeric(event);" maxlength="30">
										<b class="tooltip tooltip-bottom-right">Debe conicidir con la contraseña anterior.</b> </label>
									</section>									 
								</div>								
							</fieldset>
							<div class="col col-4">
								<p class="note">*Campo obligatorio.</p>
							</div>
							<footer>
								<button type="button" id="btnGUpdateUser" class="btn btn-primary" onclick="return MensajeSmartUsuarios(null,4);">
									<i class="fa fa-save"></i>&nbsp;Guardar
								</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">
									Cancelar
								</button>
							</footer>
		</form> <!--     Termina formulario  -->						
						<fieldset>
							<section>
								<div class="alert alert-block alert-success" id="MsgExitoUsr" style="display:none">
									<a class="close" data-dismiss="alert" href="#">×</a>
									<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ! &Eacute;xito !</h4>									
									<p>
										<div id="mensajeOk">
											El nuevo usuario se dio de alta  &eacute;xitosamente.
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
</script>





