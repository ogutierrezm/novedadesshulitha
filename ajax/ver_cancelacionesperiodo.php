<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$fecAgenda = ISSET($_GET['fc'])?$_GET['fc']:'';
	
	if ($fecAgenda != ''){
		$fecAgenda = date('Y-m-d',strtotime($fecAgenda));
	}else{
		$fecAgenda = date('Y-m-d');
	}
	
	$variable = obtenerVariableEmpresa(2,1);
	$variable = ISSET($variable['data']['valor'])?$variable['data']['valor']:300;
	echo '<script>var vTiempoSesion = '.$variable.';</script>';
	/*include("../php/expire.php");  */

?>
<!--script src="js/piscis/ver_cancelaciones.js"></script-->
<section id="widget-grid" class="">
	<div class="row">
			<div class="col-sm-2 col-md-2">
				<fieldset>
					<div class="form-group">
						<div class="input-group">
							<input class="form-control" id="from" type="text" placeholder="Del">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
					</div>											 
				</fieldset>
			</div>
			<div class="col-sm-2 col-md-2">	 
				<fieldset>
					<div class="form-group">
						<div class="input-group">
							<input class="form-control" id="to" type="text" placeholder="Al">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
					</div>
				</fieldset>
			</div>
			<div class="col-sm-4 col-md-4 pull-right">	 
				<fieldset> 
					<button class="btn btn-default" type="button" onClick ="window.location.reload();">
						&nbsp;	Cancelar
					</button>		
					<button id="btnRptEficiencia" class="btn btn-primary" type="button" onClick ="return buscarCancelacionesPeriodo();">
						<i class="fa fa-refresh"></i>&nbsp;	Generar
					</button>												 
				</fieldset>
			</div>
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-12" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" >				 
				<header>					
					<span class="widget-icon"> <i class="fa fa-th-large"></i> </span>
					<h2>FACTURAS CANCELADAS <label id="idDel"></label><label id="idAl"></label></h2>
				</header>
				<div>
					<div class="widget-body no-padding">
						<table id="datatable_tabletools" class="table table-striped table-bordered table-hover" width="100%"  style="padding:0;" border="0" cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<th data-class="expand" style="font-family:Arial;font-size: 16px;text-align:center;"><strong>FACTURAS CANCELADAS <label id="idDelEnc"></label><label id="idAlEnc"></label></strong></th>
								</tr>
							</thead>
							<tbody id="tBodyRpt">								
								<!-- ?PHP
							         $sRespuesta = verFacturadosHoy();
							         echo $sRespuesta['data'];
						        ?-->
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
	
	function PaginarCancelacionesPeriodos(){
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
	
	var sUrlRedirected = "#ajax/dashboard.php";
	
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
