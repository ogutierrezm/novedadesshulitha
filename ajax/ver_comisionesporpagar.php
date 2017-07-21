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
<!--script src="js/piscis/ver_cancelaciones.js"></script-->
<section id="widget-grid" class="">
	<div class="row">		
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-12" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" >				 
				<header>					
					<span class="widget-icon"> <i class="fa fa-th-large"></i> </span>
					<h2>COMISIONES POR PAGAR<?PHP echo $fecAgenda;?></h2>
				</header>
				<div>
					<div class="widget-body no-padding">
						<table id="datatable_tabletools" class="table table-striped table-bordered table-hover" width="100%"  style="padding:0;" border="0" cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<th data-class="expand" style="font-family:Arial;font-size: 16px;text-align:center;"><strong>SELECCIONAR</strong></th>
									<th data-class="expand" style="font-family:Arial;font-size: 16px;text-align:center;"><strong>COMISIONES PENDIENTES DE PAGO A VENDEDORES</strong></th>
								</tr>
							</thead>
							<tbody id="tBodyRpt">
								<?PHP
							         $sRespuesta = verComisionesPorPagar();
							         echo $sRespuesta['data'];
						        ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</article>
		<div class="col col-4 pull-right">	 
			<fieldset> 
				<button class="btn btn-default" type="button" onClick ="window.location.reload();">
					&nbsp;	Recargar
				</button>		
				<button id="btnRptEficiencia" class="btn btn-primary" type="button" onClick ="return MensajeSmartCorteDescartarPagarComisiones();">
					<i class="fa fa-refresh"></i>&nbsp;	Descartar
				</button>												 
			</fieldset>
		</div>	
	</div>
</section>
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
		
		/*$('#datatable_tabletools tbody tr').on( 'click', function () {
			
			$('#datatable_tabletools tbody tr td table tbody tr td[name=controles]').css('display','none');	
			
			var codigo = $(this).attr("title");
			$('#controles_'+codigo).css('display','block')
		} );*/
		
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

	function PagarComisiones(){
		var vConsecutivo = $("#tBodyRpt tr td input").length -1;
		var ControlCheck = null;
		var bRespuesta = false;
		var vFolioPedido = null;

		for (var i = 0; i <= vConsecutivo ; i++) {
			
			ControlCheck = $("#tBodyRpt tr td input")[i];
			vFolioPedido = parseInt(ControlCheck.id.replace('check_',''));
			if (ControlCheck.checked == true && vFolioPedido > 0) {
				bRespuesta = PagarComisionVenta(vFolioPedido);
				//bRespuesta = false;
			}else{
				continue;
			}
			
			if(!bRespuesta){break;}
			//console.log('articulo: '+vArticulo + ' Cantidad: '+ vCantidad + ' Folio: '+ vFolioPedido);
		}
		if(bRespuesta){
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Folios descartados exitosamente!.</i>",
				color : "#659265",
				iconSmall : "fa fa-check fa-2x fadeInRight animated",
				timeout : 4000
			});
			setTimeout(function(){ 
				window.location.reload();
			}, 1500);
		}else{
			$.smallBox({
				title : "Aviso",
				content : "<i class='fa fa-clock-o'></i> <i>Ocurri&oacute; un error al descartar los folios!.</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 4000
			});
		}
	}
	var sUrlRedirected = "#ajax/dashboard.php";
</script>
