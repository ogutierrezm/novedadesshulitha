<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$vCP = 0;
	$vCalle = '';
	$sRespuestaColonias = LlenarComboColoniasSepomex2($vCP,$vCalle);

?>
<!--script src="js/piscis/colonias.js"/-->
<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
				<div>
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->
					</div>
					<div class="widget-body no-padding">
						<fieldset>
							<section class="col col-12"> 
							<h3 class="alert alert-info">Cat&aacute;logo de colonias</h3>										 									
							</section>	
												 
							<section class="col col-12">
							<hr>								  							 
							<!-- <section class="col col-10"> -->
								<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th></th>
											<th>ID</th>
											<th>C&oacute;digo Postal</th>
											<th>Colonia</th>
											<th>Municipio</th>
											<th>Zona</th> 
										</tr>
									</thead>
									<tbody id="tbodyColonias">
									</tbody>
								</table>									 
							</section> 							 
						</fieldset>
						<form action="" id="admon_asentamiento" class="smart-form" novalidate="novalidate">
							<header>
								<h3>Asignaci&oacute;n de colonias</h3>
							</header>
							<fieldset>									 
									<div class="row">								
										<section class="col col-2">											
											<label class="label"><sup>*</sup>C&oacute;digo Postal</label>
											<label class="input"><i class="icon-prepend fa fa-tag"></i>
												<input type="text" id="CodigoPostal" name="cp" placeholder="80000" data-mask="99999" onkeypress="return ConsultarCalleSepomex();" onkeyup="return isNumber(event);" onblur="return blurConsultarCalleSepomex();" readonly>
											</label>
										</section>									 								
										<section class="col col-3">
								           <div class="form-group">
												<label class="label"><sup>*</sup> Colonia</label>
												<label class="input"><i class="icon-prepend fa fa-tag"></i>
													<input class="input" placeholder="Centro" type="text"  name="Colonia" id="Colonia" onchange="return ConsultarColonias();" onblur="return ConsultarColonias();" onkeypress="return limpiaDatosCpMnipio();">
												</label>                  
											</div>
								        </section>
										<section class="col col-2">
											<label class="label">Municipio</label>
											<label class="input"><i class="icon-prepend fa fa-map-marker"></i>
												<input type="text" id="municipio" name="municipio" placeholder="C&uacute;liacan" readonly>
											</label>
										</section>	
										<section class="col col-3">
											<label class="label"><sup>*</sup>Zona</label>
											<label class="select">
												<select id="SelectZona" name="SelectZona";>
													<!--?PHP
														$sRespuesta = LlenarComboZonasCapturadas();
														echo $sRespuesta['data'];
													?-->
												</select><i></i> </label>
										</section>								
									</div>
									<div class="col-sm-12">
										<p class="note">*Campo obligatorio.</p>
									</div>					
								</fieldset>							
							<footer>
								<button type="button" class="btn btn-primary" onclick="return grabarRegionColonia();">
									<i class="fa fa-save"></i>&nbsp;Guardar
								</button>
								<button type="button" class="btn btn-default" onclick="LimpiarZonasCancelar();">
									Cancelar
								</button>
							</footer>
						</form>
						<fieldset> 
							<!-- MODAL PLACE HOLDER -->
							<div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content"></div></div>
							</div>						 
						</fieldset>
					</div>
				</div>
			</div>
		</article>
	</div>
</section> <!-- seccion -->
<script src="js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="js/plugin/jqgrid/grid.locale-en.min.js"></script>
<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">
	consultarColoniasZonas();

	pageSetUp();		
	// PAGE RELATED SCRIPTS
	
	function CargaColonias(){
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

			var $registerForm = $("#admon_asentamiento").validate({

			// Rules for form validation
			rules : {
				cp : {
					required : true
				},
				colonia : {
					required : true
				},
				zona : {
					required : true
				}
			},

			// Mensajes personalizados
			messages : {
				
				cp : {
					required : '*Campo obligatorio.'
				},
				colonia : {
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
	}
	var availableTags = [<?PHP echo $sRespuestaColonias['data'];?>];
	//alert(availableTags);
	$(function() {
		$( "#Colonia" ).autocomplete({
		  source: availableTags
		});
	});
	
	//$( "#Colonia" ).ui-autocomplete { z-index:2147483647 !important;}
	
</script>

