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
	
	$sPermisos = ISSET($_SESSION['permisos'])?$_SESSION['permisos']:'';
	$nombreUsuario = ISSET($_SESSION['nombreUsuario'])?utf8_encode($_SESSION['nombreUsuario']):'';
	$vUser= ISSET($_SESSION['keyx'])?$_SESSION['keyx']:0;
	if ($vUser > 0){ 
		$datos = consultaUnUsuario($vUser);
	}
	
	date_default_timezone_set ("America/Mazatlan");
	$fecha = date('Y-m-d');
?>
<script type="text/javascript" src="js/plugin/printarea/jquery.PrintArea.js"></script>
        <link type="text/css" rel=""           href="empty.css" />                    <!-- N : rel is not stylesheet -->
        <link type="text/css" rel="noPrint"    href="noPrint.css" />                  <!-- N : rel is not stylesheet -->
        <link type="text/css"                  href="no_rel.css"     media="print" /> <!-- N : no rel attribute -->
        <link type="text/css"                  href="no_rel_no_media.css"          /> <!-- N : no rel, no media attributes -->

<section id="widget-grid" class="">
	<div class="row">
		<div class="col-sm-4 col-md-3">	 
			<fieldset>
				<div class="form-group">									
					<select style="width:100%" class="select2" id="fechaCorte">
						<?PHP
							$sRespuesta = LlenarComboFechasCorteTDA();
							echo $sRespuesta['data'];
						?>
					</select>
				</div>
			</fieldset>
		</div>
		<div class="col-sm-4 col-md-4 pull-right">	 
				<fieldset> 
					<button class="btn btn-default" type="button" onClick ="window.location.reload();">
						&nbsp;	Cancelar
					</button>		
					<button id="btnRptEficiencia" class="btn btn-primary" type="button" onClick ="return fn_cortetda_select_paso1();">
						<i class="fa fa-refresh"></i>&nbsp;	Generar
					</button>												 
				</fieldset>
			</div>
		</div>
	</div>
</section>
<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-20" data-widget-sortable="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" >				 
				<header>
				</header>
				<div>
					<div class="widget-body no-padding">
							<!--table id="datatable_tabletools" class="table table-striped table-bordered table-hover"  width="100%"  style="margin: 0px;padding:0;" border="0" cellspacing="0" cellpadding="0"-->
							<table id="datatable_tabletools" class="table table-striped table-bordered table-hover cell-border"  width="100%"  style="margin: 0px;padding:0;" border="1px" cellspacing="0" cellpadding="0">
								<thead>
									<tr style="text-aling:center">
										<th colspan="8">CORTE DE CAJA GLOBAL</th>
									</tr>
									<tr>
										<th>Empleado</th>
										<th>Numero abonos</th>
										<th>Total abonos</th>
										<th>Detalle de folios</th>
										<th>Total Dep&oacute;sito Recibido</th>
										<th>Total Dep&oacute;sito Devueltos</th>
										<th>Detalle de folios Dep&oacute;sito</th>
										<th>Total</th>
									</tr>
								</thead>
								<!--tfoot style="text-aling:center">
									<tr>
										<th colspan="8">< ?PHP echo 'IMPRESO POR: ' . $datos['data']['nombre'] .', FECHA: '. obtenerfechDDDIANOMBREMES($fecha).' DE ' . date('Y',strtotime($fecha)).' A LAS '. date('H:i:s');?></th>
									</tr>
								</tfoot-->
								<tbody id="tbRptCortes">							
								</tbody>
							</table> 
					</div>
				</div>
			</div>
		</article>
	</div>
</section>
<script type="text/javascript">
	pageSetUp();	 
	//PaginaEficiencia();
	// PAGE RELATED SCRIPTS
	
	function PaginaCortes(){
		// pagefunction	
		var pagefunction = function() {

			/*Widget Tabla busqueda  ;*/			 
				 
				var responsiveHelper_datatable_col_reorder = undefined;
				var responsiveHelper_datatable_tabletools = undefined;
				
				var breakpointDefinition = {
					tablet : 1024,
					phone : 480
				};
				 
			/* END BASIC */
			
			/* COLUMN SHOW - HIDE */
			$('#datatable_col_reorder').dataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_datatable_col_reorder) {
						responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_datatable_col_reorder.respond();
				}
				,"bDestroy": true
			}).fnDestroy();
			
			/* END COLUMN SHOW - HIDE */
			
			/* TABLETOOLS */
			
			$('#datatable_tabletools').dataTable({

					"order": [],
					"columnDefs": [ {
					 "targets"  : 'no-sort',
					"orderable": false,
				}],
				
				// Tabletools options: 
				//   https://datatables.net/extensions/tabletools/button_options
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
				"oTableTools": {
					 "aButtons": [
						{
							"sExtends": "print",
							"sButtonText": "<i class='fa fa-print'></i>&nbsp;Imprimir",
							"sMessage": "<style>body{padding:15px;}@media print {.noMostrarPrint {display:none;}}</style><sup><span class='noMostrarPrint'>Para salir presione la tecla <b>Esc</b></span></sup><br><a href='javascript:void(window.print());'><i class='fa fa-print'></i><span class='noMostrarPrint'>&nbsp;Imprimir<span></a>"
						}
					 ],
					"sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
				},
				"autoWidth" : false,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_datatable_tabletools) {
						responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_datatable_tabletools.respond();
				}
				//,"destroy": true
			//	,"bFilter":true
			});//.fnDestroy();
			/* END TABLETOOLS */
		};
		CargarPlugins(pagefunction);
	}
	
	function CargarPlugins(pagefunction){
		// load related plugins		
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
	
	
	$("input,select,textarea").bind("keyup", function (e) {

	  var keyCode = e.keyCode || e.which;
		   if(e.keyCode === 13) {
			e.preventDefault();
			$('input,select,textarea')[$('input,select,textarea').index(this)+1].focus();
			}
	}); 
	
	// Date Range Picker
	$("#from").datepicker({
		defaultDate: "w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		numberOfMonths: 1,
		prevText: '<i class="fa fa-chevron-left"></i>',
		nextText: '<i class="fa fa-chevron-right"></i>',
		onClose: function (selectedDate) {
			$("#to").datepicker("option", "minDate", selectedDate);
		}

	});
	$("#to").datepicker({
		defaultDate: "w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		numberOfMonths: 1,
		prevText: '<i class="fa fa-chevron-left"></i>',
		nextText: '<i class="fa fa-chevron-right"></i>',
		onClose: function (selectedDate) {
			$("#from").datepicker("option", "maxDate", selectedDate);
		}
	});
</script>

