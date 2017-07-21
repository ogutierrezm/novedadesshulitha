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
	}
	
	$variable = obtenerVariableEmpresa(2,1);
	$variable = ISSET($variable['data']['valor'])?$variable['data']['valor']:300;
	echo '<script>var vTiempoSesion = '.$variable.';</script>';
	/*include("../php/expire.php");  */
?>
<!--div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			<i class="fa fa-pencil-square-o fa-fw "></i> 
				Modificar pedidos y Cotizaciones
			<span>
				&nbsp;
			</span>
		</h1>
	</div>	
</div-->
<!--div class="row">
	</br>
</div-->
<!-- Seccion de captura de pedido -->
<section id="widget-grid" class="">
	<!-- row -->
	<div class="row">		
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-12" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" >				 
				<header>					
					<span class="widget-icon"> <i class="fa fa-th-large"></i> </span>
					<h2>Pedidos capturados para el <?PHP echo $fecAgenda;?></h2>					
					<div class="widget-toolbar">
						<a href="javascript:void(0);" class="btn btn-sm btn-primary"  id="idNuevoPedido" title="Capturar un nuevo pedido para la fecha" onclick="window.location.href = '#ajax/capturar_pedido.php?fc=<?PHP echo $fecAgenda;?>'">
							<i class="btn btn-primary btn-circle bg-color-blue txt-color-white" ><i class="glyphicon glyphicon-plus"></i></i>&nbsp;Capturar nuevo pedido para el d&iacute;a <?PHP echo $fecAgenda;?>
						</a>
					</div>
					<!--div class="widget-toolbar">
						<a href="javascript:void(0);" class="btn btn-sm btn-primary"  id="idCotizaPedido" title="Cotiza pedido para la fecha" onclick="window.location.href = '#ajax/cotiza_pedido.php?fc=<?PHP echo $fecAgenda;?>'">
							<i class="btn btn-primary btn-circle bg-color-blue txt-color-white" ><i class="glyphicon glyphicon-plus"></i></i>&nbsp;Cotiza pedido para el d&iacute;a <?PHP echo $fecAgenda;?>
						</a>
					</div-->
				</header>
				<!-- widget div-->
				<div>
					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools" class="table table-striped table-bordered table-hover" width="100%"  style="padding:0;" border="0" cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<th data-class="expand" style="font-family:Arial;font-size: 16px;text-align:center;"><strong>PEDIDOS DEL D&Iacute;A <?PHP echo obtenerfechDDDIANOMBREMES($fecAgenda);?></strong></th>
								</tr>
							</thead>
							<tbody id="tBodyRpt">								
								<?PHP
							         $sRespuesta = actualizarPedidosPorFecha($fecAgenda);
							         echo $sRespuesta['data'];
						        ?>
							</tbody>
						</table><!-- fin tabla externa-->
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
<!-- Seccion de cotizaciones -->
<section id="widget-grid" class="">
	<!-- row -->
	<div class="row">		
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-12" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" >				 
				<header>					
					<span class="widget-icon"> <i class="fa fa-th-large"></i> </span>
					<h2>Cotizaciones capturadas para el <?PHP echo $fecAgenda;?></h2>					
					<!--div class="widget-toolbar">
						<a href="javascript:void(0);" class="btn btn-sm btn-primary"  id="idNuevoPedido" title="Capturar un nuevo pedido para la fecha" onclick="window.location.href = '#ajax/capturar_pedido.php?fc=<?PHP echo $fecAgenda;?>'">
							<i class="btn btn-primary btn-circle bg-color-blue txt-color-white" ><i class="glyphicon glyphicon-plus"></i></i>&nbsp;Capturar nuevo pedido para el d&iacute;a <?PHP echo $fecAgenda;?>
						</a>
					</div-->
					<div class="widget-toolbar">
						<a href="javascript:void(0);" class="btn btn-sm btn-primary"  id="idCotizaPedido" title="Cotiza pedido para la fecha" onclick="window.location.href = '#ajax/cotiza_pedido.php?fc=<?PHP echo $fecAgenda;?>'">
							<i class="btn btn-primary btn-circle bg-color-blue txt-color-white" ><i class="glyphicon glyphicon-plus"></i></i>&nbsp;Cotiza pedido para el d&iacute;a <?PHP echo $fecAgenda;?>
						</a>
					</div>
				</header>
				<!-- widget div-->
				<div>
					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletoolscotiza" class="table table-striped table-bordered table-hover" width="100%"  style="padding:0;" border="0" cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<th data-class="expand" style="font-family:Arial;font-size: 16px;text-align:center;"><strong>COTIZACIONES DEL D&Iacute;A <?PHP echo obtenerfechDDDIANOMBREMES($fecAgenda);?></strong></th>
								</tr>
							</thead>
							<tbody id="tBodyRptCotizaciones">								
								<?PHP
							         $sRespuesta = consultarCotizacionFecha($fecAgenda);
							         echo $sRespuesta['data'];
						        ?>
							</tbody>
						</table><!-- fin tabla externa-->
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
		//var fechaa = '<?PHP echo $fecAgenda;?>' ;
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
		});

		$('.imprimir').click(function(){
			    window.print();
			    return false;
		});
		
		/* END TABLETOOLS */
	};
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
	
	var pagefunction2 = function() {				 

		/*Widget Tabla busqueda  ;*/			 
			 
			var responsiveHelper_datatable_col_reordercotiza = undefined;
			var responsiveHelper_datatable_tabletoolscotiza = undefined;
			
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
				if (!responsiveHelper_datatable_col_reordercotiza) {
					responsiveHelper_datatable_col_reordercotiza = new ResponsiveDatatablesHelper($('#datatable_col_reordercotiza'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_datatable_col_reordercotiza.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_datatable_col_reordercotiza.respond();
			}			
		});
		
		/* END COLUMN SHOW - HIDE */
		//var fechaa = '<?PHP echo $fecAgenda;?>' ;
		/* TABLETOOLS */
		$('#datatable_tabletoolscotiza').dataTable({

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
				/*if (!responsiveHelper_datatable_tabletoolscotiza) {
					responsiveHelper_datatable_tabletoolscotiza = new ResponsiveDatatablesHelper($('#datatable_tabletoolscotiza'), breakpointDefinition);
				}*/
			},
			"rowCallback" : function(nRow) {
				//responsiveHelper_datatable_tabletoolscotiza.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				//responsiveHelper_datatable_tabletoolscotiza.respond();
			}
		});

		$('.imprimir').click(function(){
			    window.print();
			    return false;
		});
		
		/* END TABLETOOLS */
	};
	// load related plugins
	
	loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
		loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
			loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
				loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
					loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction2)
				});
			});
		});
	});
	
	var sUrlRedirected = "#ajax/dashboard.php";
</script>

