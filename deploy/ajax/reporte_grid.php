<?php 
	//require_once('inc/init.php'); 
	//include('../calls/fn_generales.php');
	//include('../conx/conexiones.php');
	//session_start();
	
//	if (!ISSET($_SESSION['permisos'])) {
	//	echo '<script language="javascript">window.location= "login.php"</script>';
	//}else
		//echo '<script language="javascript">buscarPedidosTodos();</script>';

 $html = "<section id='widget-grid' class=''>
	<div class='row'>
		<article class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
			<div class='jarviswidget jarviswidget-color-blueDark' id='wid-id-19' data-widget-sortable='false' data-widget-colorbutton='false' data-widget-editbutton='false' data-widget-togglebutton='false' data-widget-deletebutton='false' >				 
				<header>
				</header>
				<div>
					<div class='widget-body no-padding'>

							<table id='datatable_tabletools' class='table table-striped table-bordered table-hover'  width='100%'  style='margin: 0px;padding:0;' border='0' cellspacing='0' cellpadding='0'>
								<thead>
									<tr>
										<th data-class='expand' style='text-align:left;'></th>
									</tr>
								</thead>
								<tbody id='tBodyRpt'>							
								</tbody>
							</table> 
					</div>
				</div>
			</div>
		</article>
	</div>
</section>
<script type='text/javascript'>



	/*Ejemplo */
	function Alerta(){

		var foo = []; 
		$('#idMonth :selected').each(function(i, selected){ 
		  foo[i] = $(selected).val(); 

		});

		alert('Mes(es): '+foo);
	}
	/* ------------------------- */

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
			'sDom': '<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>'+
					't'+
					'<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>',
			'autoWidth' : true,
			'preDrawCallback' : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_col_reorder) {
					responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
				}
			},
			'rowCallback' : function(nRow) {
				responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
			},
			'drawCallback' : function(oSettings) {
				responsiveHelper_datatable_col_reorder.respond();
			}			
		});
		
		/* END COLUMN SHOW - HIDE */
		
		/* TABLETOOLS */
		$('#datatable_tabletools').dataTable({

				'order': [],
	    		'columnDefs': [ {
	     		 'targets'  : 'no-sort',
	      		'orderable': false,
    		}],
			
			// Tabletools options: 
			//   https://datatables.net/extensions/tabletools/button_options
			'sDom': '<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>'+
					't'+
					'<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>',
	        'oTableTools': {
	        	 'aButtons': [
	             	{
                    	'sExtends': 'print',
                    	'sButtonText': '<i class='fa fa-print'></i>&nbsp;Imprimir',
                    	'sMessage': '<style>body{padding:15px;}@media print {.noMostrarPrint {display:none;}}</style><sup><span class='noMostrarPrint'>Para salir presione la tecla <b>Esc</b></span></sup><br><a href='javascript:void(window.print());'><i class='fa fa-print'></i><span class='noMostrarPrint'>&nbsp;Imprimir<span></a>'
                	}
	             ],
	            'sSwfPath': 'js/plugin/datatables/swf/copy_csv_xls_pdf.swf'
	        },
			'autoWidth' : false,
			'preDrawCallback' : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_tabletools) {
					responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
				}
			},
			'rowCallback' : function(nRow) {
				responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
			},
			'drawCallback' : function(oSettings) {
				responsiveHelper_datatable_tabletools.respond();
			}
		});
		
		/* END TABLETOOLS */
	};

	$('input,select,textarea').bind('keyup', function (e) {

	  var keyCode = e.keyCode || e.which;
		   if(e.keyCode === 13) {
			e.preventDefault();
			$('input,select,textarea')[$('input,select,textarea').index(this)+1].focus();
			}
	}); 

	// load related plugins
	
	loadScript('js/plugin/datatables/jquery.dataTables.min.js', function(){
		loadScript('js/plugin/datatables/dataTables.colVis.min.js', function(){
			loadScript('js/plugin/datatables/dataTables.tableTools.min.js', function(){
				loadScript('js/plugin/datatables/dataTables.bootstrap.min.js', function(){
					loadScript('js/plugin/datatable-responsive/datatables.responsive.min.js', pagefunction)
				});
			});
		});
	});
</script>";
	ECHO $html;
?>