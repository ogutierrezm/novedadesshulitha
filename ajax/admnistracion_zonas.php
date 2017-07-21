<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	
	$variable = obtenerVariableEmpresa(2,1);
	$variable = ISSET($variable['data']['valor'])?$variable['data']['valor']:300;
	echo '<script>var vTiempoSesion = '.$variable.';</script>';
	/*include("../php/expire.php");  */  
?>
<!--div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			<i class="fa fa-cogs"></i> 
				Administraci&oacute;n
			<span>> 
				Zonas
			</span>
		</h1>
	</div>
</div-->
<!-- formulario de admnistracion de zonas y colonias -->
<section id="widget-grid" class="">


	<!-- START ROW -->
	<div class="row">
		
		<!-- NEW COL START -->
		<article class="col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
				 
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">

							<form action="" id="admon_zonas" class="smart-form">
								<header>
									<h3>Agregar nueva zona</h3>
								</header>
								<!-- cabecero --><!-- -->								 
								<!-- datos de la zona -->
								<fieldset>
									<div class="row">										
										<section class="col col-3">
											<label class="label"><sup>*</sup>Nombre</label>
											<label class="input"><i class="icon-prepend fa fa-tag"></i>
												<input type="text" id="nombre" name="nombre" placeholder="Zona uno"  onkeypress="return isAlphaNumeric(event);" maxlength="80">
											</label>
										</section>
									</div>
									<div class="row">
										<section class="col col-6">
												<label class="label"><sup>*</sup>Descripci&oacute;n:</label>											
												<label class="textarea"><i class="icon-prepend fa fa-comment"></i>									
													<textarea rows="3" id="descripcion" name="descripcion" placeholder="Caracteristicas de la zona..." onkeypress="return isAlphaNumeric(event);" maxlength="120"></textarea> 
												</label>
										</section>
									</div> 
									<div class="col-sm-12">
										<p class="note">*Campo obligatorio.</p>
									</div>
								</fieldset>
								<footer>
										<button type="button" class="btn btn-primary" onclick="CreateNvaZona();">
											<i class="fa fa-save"></i>&nbsp;Guardar
										</button>
										<button type="button" class="btn btn-default" onclick="LimpiaNvaZona();">
											Cancelar
										</button>
									</footer>
							</form> <!--     Termina formulario  --> 							
							<fieldset>
								<!-- Catalogo de zonas -->
									<section class="col col-12"> 
										<h3 class="alert alert-info">Cat&aacute;logo de Zonas</h3>										 									
									</section>	
									 						 
									<section class="col col-12">
									  <hr>								  							 
										<!-- <section class="col col-10"> -->
											<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
												<thead>
													<tr>
														<th></th>
														<th>ID</th>
														<th>Zona</th>
														<th>Descripci&oacute;n</th>														
													</tr>
												</thead>
												<tbody id="tbodyZonas">
													<?PHP
														$sRespuesta =LlenarGridZonas();
														echo $sRespuesta['data'];
													?> 
												</tbody>
											</table>									 
										</section> 							 
							<!-- end row -->								
							</fieldset>
							<fieldset> 
								<!-- MODAL PLACE HOLDER -->
								<div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content"></div></div>
									</div>						 
								</div>
							</fieldset>								
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
			</div>
 
		</article>
		<!-- END COL -->
	</div>

</section> <!-- seccion -->
<script src="js/plugin/jquery-form/jquery-form.min.js"></script>
<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">
 

	pageSetUp();		
	// PAGE RELATED SCRIPTS
	
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
	/* Validaciones */
	var $registerForm = $("#admon_zonas").validate({
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
