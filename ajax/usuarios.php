<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	
/*	$variable = obtenerVariableEmpresa(2,1);
	$variable = ISSET($variable['data']['valor'])?$variable['data']['valor']:300;
	echo '<script>var vTiempoSesion = '.$variable.';</script>';*/
?>
<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
				<div>
					<div class="jarviswidget-editbox">
					
					</div>
					<div class="widget-body no-padding">
						<fieldset>
								<section class="col col-12"> 
									<h3 class="alert alert-info">Cat&aacute;logo de usuarios</h3>										 									
								</section>	
								 						 
								<section class="col col-12">
								  <hr>								  							 
										<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
											<thead>
												<tr>
													<th></th>
													<th>ID</th>
													<th>Usuario</th>
													<th>Nombre</th>
													<th>Puesto</th>
													<th>Contraseña</th> 
												</tr>
											</thead>
											<tbody id="tbodyUsuarios">
												<!--?PHP
													$sRespuesta = LlenarGridUsuarios();
													echo $sRespuesta['data'];
												?-->									 						 
											</tbody>
										</table>									 
									</section> 							 
						</fieldset>
						<form action="" id="admon_usuarios" class="smart-form" novalidate="novalidate">
							<header>
								<h3>Agregar nuevo usuario</h3>
							</header>
							</fieldset>
							<fieldset>								 
								<div class="row">
									<section class="col col-4">
										<label class="label"><sup>*</sup> Usuario</label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="usuario" id="usuario" placeholder="Juan" onkeypress="return isAlphaNumeric(event);" maxlength="50">
											<span class="tooltip tooltip-bottom-right">Nombre identificador</span> </label>
										</label>
									</section>
									<section class="col col-4">
										<label class="label"><sup>*</sup>Puesto</label>
										<label class="select">
										<select name="empleados" id="empleados">
											<!--?PHP
												$sRespuesta = LlenarComboPuestos();
												echo $sRespuesta['data'];
											?-->
										</select> <i></i> 
										</label>
									</section>
								</div>								 
								<div class="row">
									<section class="col col-4">
										<label class="label"><sup>*</sup>Nombre (s)</label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="nombre" id="nombre" placeholder="Juan" onkeypress="return isLetter(event);" maxlength="50">
										</label>
									</section>
									<section class="col col-4">
										<label class="label"><sup>*</sup>Apellido(s)</label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="apellido" id="apellido" placeholder="Perez" onkeypress="return isLetter(event);" maxlength="50">
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-4">
										<label class="label"><sup>*</sup>Contraseña</label>
										<label class="input"> <i class="icon-prepend fa fa-lock"></i>
										<input type="password" name="contrasena"  placeholder="*********" id="password" onkeypress="return isAlphaNumeric(event);" maxlength="30">
										<b class="tooltip tooltip-bottom-right">Debe contener entre 3 y 20 caracteres.</b> </label>
									</section>
									<section class="col col-4">
										<label class="label"><sup>*</sup>Confirmar contraseña</label>
										<label class="input"> <i class="icon-prepend fa fa-lock"></i>
										<input type="password" name="confirmarcontrasena" id="confirmarcontrasena" placeholder="*********" onkeypress="return isAlphaNumeric(event);" maxlength="30">
										<b class="tooltip tooltip-bottom-right">Debe conicidir con la contraseña anterior.</b> </label>
									</section>									 
								</div>	
								<div class="col-sm-12">
									<p class="note">*Campo obligatorio.</p>
								</div>							
							</fieldset>

							<footer>
								<button type="button" id="btnGUser" class="btn btn-primary" onclick="CreateUsr();">
									<i class="fa fa-save"></i>&nbsp;Guardar
								</button>
								<button type="button" class="btn btn-default" onclick="LimpiaInsertUsr();">
									Cancelar
								</button>
							</footer>
						</form>
						<fieldset> 
							<div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content"></div></div>
								</div>						 
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</article>
		<!--div class="col col-4 pull-right">	 
			<fieldset> 
				<button class="btn btn-default" type="button" onClick ="window.location.reload();">
					&nbsp;	Recargar
				</button>		
				< !--button id="btnClienteNuevo" class="btn btn-primary" type="button" onClick ="return MensajeSmartCorteDescuentoAutomatico();">
					<i class="fa fa-plus-circle"></i>&nbsp;	Nuevo
				</button- ->
				<!--a href='ajax/modal_clientes.php?usr=' data-toggle='modal' data-target='#remoteModal' id='Nuevo' class='button btn btn-primary'><i class="fa fa-plus-circle"></i>&nbsp;	Nuevo</a-- >
				<a href='#ajax/modal_usuarios.php' id='Nuevo' class='button btn btn-primary'><i class="fa fa-plus-circle"></i>&nbsp;	Nuevo</a>
			</fieldset>
		</div-->
	</div>
</section>
<script src="js/plugin/jquery-form/jquery-form.min.js"></script>
<script type="text/javascript">	
	consultarUsuarios();
	consultarPerfiles();
	pageSetUp();	
	
	// PAGE RELATED SCRIPTS

	// pagefunction
	
	var pagefunction = function() {


		/* Tabla ;*/
			var responsiveHelper_dt_basic = undefined;			 
			
			var breakpointDefinition = {
				tablet : 1024,
				phone : 480
			};

			$('#dt_basic').dataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_dt_basic.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_dt_basic.respond();
				}
			});

			 
		/* END Tabla */

			var $registerForm = $("#admon_usuarios").validate({

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
					equalTo : '#password'
				},
				nombre : {
					required : true
				},
				apellido : {
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
	// load related plugins tabla	
	loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
		loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
			loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
				loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
					loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
				});
			});
		});
	}); 	
	
</script>



