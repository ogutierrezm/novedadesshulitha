<?php
	if(ISSET($_SESSION)){
		session_destroy();
	}
	//initilize the page
	require_once("inc/init.php");

	//require UI configuration (nav, ribbon, etc.)
	require_once("inc/config.ui.php");

	/*---------------- PHP Custom Scripts ---------

	YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
	E.G. $page_title = "Custom Title" */

	$page_title = "Login";

	/* ---------------- END PHP Custom Scripts ------------- */

	//include header
	//you can add your custom css in $page_css array.
	//Note: all css files are inside css/ folder
	$page_css[] = "your_style.css";
	$no_main_header = true;
	$page_body_prop = array("id"=>"extr-page", "class"=>"animated fadeInDown");
	include("inc/header.php");
	include('lock.php');
	include("inc/scripts.php"); 
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
<header id="header">
	<!--<span id="logo"></span>-->
	<div id="logo-group">
		<span id="logo"> <img src="<?php echo ASSETS_URL; ?>/img/logo_scp-04.png" alt="logo"> </span>
		<!-- END AJAX-DROPDOWN -->
	</div>
</header>
<div id="main" role="main">
	<!-- MAIN CONTENT -->
	<div id="content" class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
				<!--<img src="<?php //echo ASSETS_URL; ?>/img/logo_png.png" alt="logo">-->
				<h1 class="txt-color-blue login-header-big">Sistema de control de pedidos e inventario</h1>
				<div class="hero">
					<div class="pull-left login-desc-box-l">
						<h4 > Panel de control para la gesti&oacute;n de pedidos y control de inventario.</h4>
						
						<!--<p style="text-align: justify;">Administra facilmente la entrada y salida de tu inventario, gestiona los pedidos e imprime los reportes para llevar el control de tu negocio.</p>-->
					</div>
					<img src="<?php echo ASSETS_URL; ?>/img/logo_png.png" alt="logo" class="pull-right" alt="SCP" >
					<!-- <img src="<?php //echo ASSETS_URL; ?>/img/logistic-tracking-system.png" class="pull-right display-image" alt="" style="width:210px"> -->
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
				<div class="well no-padding" style="box-shadow: -13px 11px 53px rgba(0,0,0,.1);">
					<!--form action="" id="login-form" class="smart-form client-form" method="post"-->
					<form id="login-form" class="smart-form client-form">
						<header>
							<h2 class="txt-color-blue text-center">Acceso al sistema</h2>
						</header>
						<fieldset>
							<section>
								<label class="label">Usuario</label>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="text" name="email" id="email" onkeypress="return isAlphaNumeric(event);">
									<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Por favor ingresa un usuario</b></label>
							</section>
							<section>
								<label class="label">Contraseña</label>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<input type="password" name="password" id="password" onkeypress="return isAlphaNumeric(event);">
									<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Por favor ingresa tu contraseña</b> </label>
								<div class="note">
								</div>
							</section>

							<section>
								<label class="checkbox">
							</section>
						</fieldset>
						<footer>
							<button type="button" class="btn btn-primary" id="btnEntraSesion">
								Entrar
							</button>
							<label class="label" id = "mensajeFail" name="mensajeFail" style="display:none;color:red;">Usuario</label>
						</footer>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->



<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->

<script type="text/javascript">
	runAllForms();

	$(function() {
		// Validation
		$("#login-form").validate({
			// Rules for form validation
			rules : {
				email : {
					required : true
				},
				password : {
					required : true,
					minlength : 3,
					maxlength : 20
				}
			},

			// Messages for form validation
			messages : {
				email : {
					required : '*Campo obligatorio'
				},
				password : {
					required : '*Campo obligatorio'
				}
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
	
	$("input,select").bind("keydown", function (e) {

	  var keyCode = e.keyCode || e.which;
		   if(e.keyCode === 13) {
			e.preventDefault();
			$('input,select,textarea,button')[$('input,select,textarea,button').index(this)+1].focus();
			}
	});
	$("#email").focus();
</script>