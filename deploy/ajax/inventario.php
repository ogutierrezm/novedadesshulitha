<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');
	include('../conx/constant.php');
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
			<i class="fa fa-cubes"></i> 
				Administraci&oacute;n de Inventario			
		</h1>
	</div>
</div-->		
<!-- formulario de admnistracion de inventario -->
<section id="widget-grid" class="">
	<!-- START ROW -->
	<div class="row">
		
		<!-- NEW COL START -->
		<article class="col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-4" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
				
				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">

							<form action="" id="admon_inventario" class="smart-form">
								<header>
									<h3>Agregar nuevo art&iacute;culo</h3>
								</header>
								<!-- cabecero --><!-- -->								 
								<!-- Alta de inventario -->
								<fieldset>									
									<div class="row">										
											<section class="col col-2">											
											<label class="label">SKU</label>
											<label class="input"><i class="icon-prepend fa fa-barcode" ></i>
												<input type="text" name="sku" id="sku" placeholder="802344" disabled = "disabled" 
												value="<?PHP 
															$sRespuesta = obtenerSKU();
															$sRespuesta = $sRespuesta['data']['retorno'];
															echo $sRespuesta;
														?>" >
											</label>
										</section>
									</div>
									<div class="row">
										<section class="col col-5">
											<label class="label"><sup>*</sup> Nombre del art&iacute;culo</label>
											<label class="input"> <i class="icon-prepend fa fa-cube"></i>
												<input type="text" placeholder="Ejemplo: Silla" name="articulo" id="articulo" onkeypress="return isAlphaNumeric(event);" maxlength="50" onfocus="this.select();">
												<b class="tooltip tooltip-top-right">
													<i class="fa fa-warning txt-color-teal"></i> 
													Nombre breve del art&iacute;culo que se mostrar&aacute;.</b> 
											</label>
										</section>
										<section class="col col-2">
											<label class="label"><sup>*</sup> Inventario inicial</label>											 
											<input class="form-control spinner spinner-left" id="spinner-currency" name="cantidad" value="1" type="text" onkeypress="return isNumber(event);" maxlength="10">
										</section>
									</div>	
									<div class="row">									 
										<section class="col col-2">
											<label class="label"><sup>*</sup> Precio de renta</label>
											<label class="input"><i class="icon-prepend fa fa-usd"></i>
												<input type="text" placeholder="1.00" name="precio" id="precio" onkeypress="return isNumber(event);" maxlength="10" onfocus="this.select();">
												<b class="tooltip tooltip-bottom-right">Precio de renta del art&iacute;culo.</b> </label>

											</label>										 
										</section>
										<section class="col col-3">
											<label class="label">&nbsp;</label>
											<div class="input-group">
													<input class="form-control"  value="¿Es un artículo especial ? " style="text-align:center" disabled="disabled" id="st3f"  >
													<span class="input-group-addon">
														<span class="onoffswitch">
															<input type="checkbox" name="start_interval" class="onoffswitch-checkbox" id="st3" onchange="cambioEspecialArticulo();" value="0" >
															<label class="onoffswitch-label" for="st3" id="st3flag"> 
																<span class="onoffswitch-inner" data-swchon-text="SI" data-swchoff-text="NO" id="txtFlag"></span> 
																<span class="onoffswitch-switch" id="txtFlagSpan"></span> 
															</label> 
														</span>
													</span>
												</div>												
										</section>
										<section class="col col-2" id="dvHorasArticuloEspecial" style="display:none">
											<label class="label"><sup>*</sup> Horas de renta</label>
											<label class="input"><i class="icon-prepend fa fa-clock-o"></i>
												<input type="text" placeholder="1" name="horas" id="horas" value="0" onkeypress="return isNumber(event);" maxlength="3" >
												<b class="tooltip tooltip-top-right">
													<i class="fa fa-warning txt-color-teal"></i> 
													Cantidad de horas para rentar este art&iacute;culo</b> 

											</label>										 
										</section>												
									</div>		
									<div class="row">
										<section class="col col-3">
											<label class="label"> Ligar a grupo de inventario</label>
												<div class="form-group">									
													<select style="width:100%" class="select2" id="idGpoInvent">
														<?PHP
															$sRespuesta = LlenarComboGrupoInventario();
															echo $sRespuesta['data'];
														?>
													</select>
												</div>
										</section>
									</div>				 
								<!--Form Inventario -->
								</fieldset>								
								<footer>
									<p class="note">*Campo obligatorio.</p>
									</br>
									<span class="note">
										<i class="fa-fw fa fa-arrow-circle-right"></i> Un art&iacute;culo especial solamente podr&aacute; ser rentado por determinado n&uacute;mero de horas al d&iacute;a.
									</span>
										<button type="button" class="btn btn-primary" onclick="AgregarInventario();">
											<i class="fa fa-save"></i>&nbsp;Guardar
										</button>
										<button type="button" class="btn btn-default" onclick="LimpiarInventarioNuevo();">
											Cancelar
										</button>
									</footer>
							</form> <!--     Termina formulario  -->
							<fieldset>
							<!-- Catalogo de Inventario -->
									<section class="col col-12"> 
										<h3 class="alert alert-info">Cat&aacute;logo de Inventario</h3>										 									
									</section>									 						 
									<section class="col col-12">
									  <hr>								  							 
										<!-- <section class="col col-10"> -->
											<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
												<thead>
													<tr>
														<th></th>
														<th>SKU</th>
														<th>Art&iacute;culo</th>
														<th>Cantidad</th>
														<th>Precio Renta</th>
														<th>Especial</th>
														<th>Horas Renta</th>  
														<th>Grupo Inventario</th>  
													</tr>
												</thead>
												<tbody id="tbodyInventario">
													<?PHP
														$esRenta = (ARTICULORENTADO == 1)?ARTICULORENTADO:0;
														$sRespuesta = LlenarGridArticulosInventario($esRenta);
														echo $sRespuesta['data'];
													?>
													<!-- Ejemplo 
													<tr>
														<td class="text-center">
															<a href="javascript:void(0);" id="smart-mod-eg1"><i class="fa fa-minus-square-o" rel="tooltip" data-placement="top" data-original-title="Eliminar"></i></a>&nbsp;
															<a href="ajax/modal_inventario.php" data-toggle="modal" data-target="#remoteModal">
																<i class="fa fa-pencil-square-o" rel="tooltip" data-placement="top" data-original-title="Editar"></i>
															</a>
														</td>
														<td>78923</td>
														<td>Mesa</td>
														<td>$123</td>
														<td>3</td>
														<td>Si</td>	
														<td>3</td>														 
													</tr>-->								 						 
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
<script src="js/plugin/jqgrid/grid.locale-en.min.js"></script>
 
<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript"> 

	pageSetUp();		
	// PAGE RELATED SCRIPTS

	// valida caracteres de entrada
	function valida_entrada(ob) {
	  var invalidChars = /[^0-9]/gi
	  if(invalidChars.test(ob.value)) {
	            ob.value = ob.value.replace(invalidChars,"");
	      }
	}
	
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

	var $registerForm = $("#admon_inventario").validate({
			// Rules for form validation
			rules : {
				articulo : {
					required : true
				},
				cantidad : {
					required : true
				},
				precio : {
					required : true,
					minlength : 1
				},
				horas : {
					required : true
				}
			},
			// Messages for form validation
			messages : {
				
				articulo : {
					required : '*Campo obligatorio.'
				} 
			},
			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
		
		// Spinners			
		$("#spinner-currency").spinner({
		    min: 1,
		    max: 5000,
		    step: 1,
		    start: 1,
		    numberFormat: "C"
		});	
	};
	// Load form valisation dependency 
	
	var pagedestroy = function(){
		 
		// destroy spinner
		$( ".spinner" ).spinner("destroy");
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