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
			<i class="fa fa-list fa-fw "></i> 
				Reportes
			<span>> 
				Inventario
			</span>
		</h1>
	</div>
</div-->
<!-- widget grid -->
<section id="widget-grid" class="">
	<!-- row -->
	<div class="row">
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<!--<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false">-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-10" data-widget-sortable="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" >				 
				<header>					
					<span class="widget-icon"> <i class="fa fa-file-text-o"></i> </span>
					<h2>Actualizado al d&iacute;a&nbsp;<?php date_default_timezone_set ("America/Mazatlan"); echo date("d-m-Y"); ?></h2>
					
					<!--
					<div class="widget-toolbar">
						<a href="javascript:void(0);" class="btn btn-primary">Btn</a>
					</div>
					-->
				</header>
				<!-- widget div-->
				<div> 

					<!-- widget content -->
					<div class="widget-body no-padding">

						<table id="datatable_tabletools" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th data-hide="phone">SKU</th>
									<th data-class="expand">Art&iacute;culo</th>
									<th data-hide="phone">Cantidad</th>
									<th>Precio Renta</th>
									<th data-hide="phone,tablet">Art&iacute;culo Especial</th>
									<th data-hide="phone,tablet">Horas Renta</th>
									 
								</tr>
							</thead>
							<tbody>
								<?PHP
									$esRenta = (ARTICULORENTADO == 1)?ARTICULORENTADO:0;
									$esRenta = 0;
									$sRespuesta = LlenarGridArticulos($esRenta);
									echo $sRespuesta['data'];
								?>								
							</tbody>
						</table>
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
			</div>
			<!-- end widget -->
		</article>
		<!-- WIDGET END -->
	</div> 

</section>
<!-- end widget grid -->
<script type="text/javascript"> 

	pageSetUp();	 
	
	// PAGE RELATED SCRIPTS
	
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
		});
		
		/* END COLUMN SHOW - HIDE */
		//var fecha = new Date();
		//var fechaactual = fecha.getDate() + "/" +  fecha.getMonth() + "/" + fecha.getFullYear() ;
		var fechaactual = '<?php date_default_timezone_set ("America/Mazatlan"); echo date("d-m-Y"); ?>' ;
		/* TABLETOOLS */
		$('#datatable_tabletools').dataTable({
			
			// Tabletools options: 
			//   https://datatables.net/extensions/tabletools/button_options
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
	        "oTableTools": {
	        	 "aButtons": [
	             //"copy",
	             //"csv",
	             //"xls",
	             	{
                    	"sExtends": "collection",
                    	"sButtonText": "<i class='fa fa-save'></i>&nbsp;Guardar",
                    	"aButtons": ["csv","xls"]                	},
	                {
	                    "sExtends": "pdf",
	                    "sButtonText": "<i class='fa fa-file-pdf-o'></i>&nbsp;PDF",
	                    "sTitle": "Diversiones Piscis - Reporte_Inventario",
	                    "sPdfMessage": "Reporte de inventario al día "+fechaactual+".",
	                    "sPdfSize": "letter"
	                },
	             	{
                    	"sExtends": "print",
                    	"sButtonText": "<i class='fa fa-print'></i>&nbsp;Imprimir",
                    	"sMessage": "<style>body{padding:15px;}@media print {.noMostrarPrint {display:none;}}</style> Reporte de Inventario - Diversiones Piscis</i><p><sup>Calculado al d&iacute;a: "+fechaactual+"</sup><br/><sup><span class='noMostrarPrint'>Para salir presione la tecla <b>Esc</b></span></sup><br><a href='javascript:void(window.print());'><i class='fa fa-print'></i><span class='noMostrarPrint'>&nbsp;Imprimir<span></a>"
                	}
	             ],
	            "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
	        },
			"autoWidth" : true,
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
		});
		
		/* END TABLETOOLS */
	};

	$("input,select,textarea").bind("keyup", function (e) {

	  var keyCode = e.keyCode || e.which;
		   if(e.keyCode === 13) {
			e.preventDefault();
			$('input,select,textarea')[$('input,select,textarea').index(this)+1].focus();
			}
	});

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
</script>
