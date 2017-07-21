<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}else{
		$Valores = obtenerVariableEmpresa(1,1);
		$Valores = $Valores['data'];
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
				Descuentos
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
						<form action="" id="admon_desctos" class="smart-form">
							<header>
								<h3>Administrar variables</h3>
							</header>
							<!-- cabecero --><!-- -->								 
							<!-- datos de la zona -->
							<fieldset>
								<div class="row">										
									<section class="col col-3">
										<label class="label"><sup>*</sup>Descuento M&aacute;ximo</label>
										<label class="input"><i class="icon-prepend fa fa-tag"></i>
											<input id="Descuento" name="Descuento" placeholder="%10"  onkeyup="return isCorrectNumber(event,this);" onkeypress="return isCorrectNumber(event,this);" onblur="return SetValores(this);" maxlength="2" min="1" max="30" type="number" VALUE="<?PHP echo $Valores['valor'];?>">
										</label>											
										<div class="col-sm-12">
											<p class="note">*Campo obligatorio.</p>
										</div>
									</section>
								</div>
								
								<div class="row">										
									<section class="col col-3">
										<label class="label"><sup>*</sup>Tiempo m&aacute;ximo de inactividad</label>
										<label class="input"><i class="icon-prepend fa fa-tag"></i>
											<input id="Inactividad" name="Inactividad" placeholder="10"  onkeyup="return isCorrectNumber(event,this);" onkeypress="return isCorrectNumber(event,this);" onblur="return SetValores(this);" maxlength="3" min="1" max="60" type="number" VALUE="<?PHP echo ISSET($variable)?$variable/60:0;?>">
										</label>
										<div class="col-sm-12">
											<p class="note">*Campo obligatorio.</p>
										</div>
									</section>
								</div>
							</fieldset>
							<footer>
									<button type="button" class="btn btn-primary" onclick="return ModificarVariables();">
										<i class="fa fa-save"></i>&nbsp;Guardar
									</button>
									<button type="button" class="btn btn-default" onclick=" $('#Descuento').val(<?PHP echo $Valores['valor'];?>)">
										Cancelar
									</button>
								</footer>
						</form>
					</div>
				</div>
			</div>
		</article>
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
	var $registerForm = $("#admon_desctos").validate({
			// Rules for form validation
			rules : {
				Descuento : {
					required : true
				}
			},
			// Messages for form validation
			messages : {
				
				Descuento : {
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
