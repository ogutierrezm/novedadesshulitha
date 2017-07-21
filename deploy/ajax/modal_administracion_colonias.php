<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');	
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$id = (isset($_GET['id'])?utf8_encode($_GET['id']):0);
	$cp = (isset($_GET['cp'])?utf8_encode($_GET['cp']):'');	
	$colonia = (isset($_GET['colonia'])?utf8_encode($_GET['colonia']):'');
	$ciudad = (isset($_GET['ciudad'])?utf8_encode($_GET['ciudad']):'');
	$colonia = htmlentities(str_replace('%',' ',$colonia));
	$ciudad = htmlentities(str_replace('%',' ',$ciudad));
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title"><img src="img/logo_scp-04.png" width="150" alt="logo"></h4>
</div>
<div class="modal-body no-padding">
		<form action="" id="actualiza_colonias" class="smart-form" novalidate="novalidate">
							<header>
								<h2><i class="glyphicon glyphicon-pencil"></i>&nbsp;Editar asignaci&oacute;n de colonia</h2>								
							</header>
							<!-- cabecero --><!-- -->
							<!-- datos de la colonia -->							 
							<fieldset>
									<div class="row">
										<section class="col col-2">
											<div class="well well-sm bg-color-darken txt-color-white text-left">
												<h5>&nbsp;ID #<label id="idModal"><?PHP echo $id;?></label></h5>										 
											</div>
										</section>					 
										<!--<h4 class="row-seperator-header">ID: 123</h4>-->
									</div>									 
									<div class="row">								
										<section class="col col-2">											
											<label class="label">C&oacute;digo Postal</label>
											<label class="input"><i class="icon-prepend fa fa-tag"></i>
												<input type="text" id="cpModal" name="cpModal" placeholder="80000" data-mask="99999" disabled="disabled" readonly value="<?PHP echo $cp;?>">
											</label>
										</section>									 								
										<section class="col col-4">
								           <label class="label">Colonia</label>
								          <label class="input"><i class="icon-prepend fa fa-tag"></i>
												<input type="text" id="coloniaModal" name="coloniaModal" placeholder="Centro" disabled="disabled" readonly value="<?PHP echo $colonia;?>">
											</label>
								        </section>
										<section class="col col-2">
											<label class="label">Municipio</label>
											<label class="input"><i class="icon-prepend fa fa-map-marker"></i>
												<input type="text" id="municipioModal" name="municipioModal" placeholder="C&uacute;liacan" disabled="disabled" readonly value="<?PHP echo $ciudad;?>">
											</label>
										</section>	
										<section class="col col-4">
											<label class="label"><sup>*</sup>Zona</label>
											<label class="select">
												<select id="SelectZonaModal" name="SelectZonaModal";>
													<?PHP
														$sRespuesta = LlenarComboZonasCapturadas();
														echo $sRespuesta['data'];
													?>
												</select><i></i> </label>
										</section>								
									</div>												
								</fieldset>	

							<div class="col col-4">
								<p class="note">*Campo obligatorio.</p>
							</div>
							<footer>
								<button type="button" id="btnGModificarColoniaZona" class="btn btn-primary" onclick="return ActualizarZonaColonia(<?PHP echo $id;?>)">
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

			var $registerForm = $("#actualiza_colonias").validate({

			// Rules for form validation
			rules : {
				 
				zona : {
					required : true
				}
			},

			// Mensajes personalizados
			messages : {
				
				zona : {
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





