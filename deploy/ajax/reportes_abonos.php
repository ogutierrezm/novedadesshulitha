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
<script type="text/javascript" src="js/plugin/printarea/jquery.PrintArea.js"></script>
        <link type="text/css" rel=""           href="empty.css" />
        <link type="text/css" rel="noPrint"    href="noPrint.css" />
        <link type="text/css"                  href="no_rel.css"     media="print" />
        <link type="text/css"                  href="no_rel_no_media.css"/>

<!--div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			<i class="fa fa-indent"></i> 
				Reportes
			<span>>  
				Consulta de abonos
			</span>
		</h1>
	</div>
</div-->
<div class="row">
	<div class="col-sm-12">		
		<div class="well">			 
			 <div class="row">
					<div class="col-sm-12 col-md-12">	
						<legend class="txt-color-blueDark">
							<span class="text-primary"><h4>Consulta de abonos por folio</h4></span>
						</legend> 
					</div>									
					<div class="col-sm-4 col-md-4">	 
						<fieldset>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">FOLIO&nbsp;</span>
									<input class="form-control input-md" type="text" id="folio" placeholder="" onkeypress="return isNumber(event);"  maxlength="10" onkeyup="return LimpiarAbonosReporte();" onfocus="this.select();">
									<span class="input-group-addon"><a href="javascript:buscarAbonosPedidos();">Buscar <i  class="fa fa-fw fa-md fa-search"></i></a></span>
								</div>													
								 
							</div>		
														 

						</fieldset>
					</div>					 
					 
			</div>
		</div>
		
	</div>
</div>

<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-21" data-widget-sortable="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false">				 
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Abonos realizados al pedido</h2>
					<div class="widget-toolbar">
						<a href="javascript:void(0);" class="btn btn-primary" id="imprime"><i class="fa-fw fa fa-print"></i> Imprimir</a>
					</div>
				</header>
				<div>
					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body no-padding">
						<div class="alert alert-info no-margin fade in">
							<button class="close" data-dismiss="alert">
								×
							</button>
							<i class="fa-fw fa fa-info"></i>
							Nota: 
						</div>
						<div class="table-responsive">

							<div class="PrintArea area1 all" id="Retain">								
								<table cellspacing="0" cellpadding="0" class="table table-bordered table-striped" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;">
									<thead style="text-align:left">
										<tr>
											<th> # </th>
											<th> Fecha </th>
											<th> Cantidad </th>
											<th> Recibio </th>
											<th> Entrego </th>
											<th> Nota abono </th>
										</tr>
									</thead>
									<tbody id = "tbAbonosrpt">
									</tbody>
								</table>
							</div>
						</div>
						<div class="settingVals">
				            <input type="checkbox" class="selPA" value="area1" checked style="display:none" /> 
				            <input type="checkbox" class="selPA" value="area2" checked style="display:none" />
				            <input type="checkbox" class="selPA" value="area3" checked style="display:none"/> 
				            <input type="checkbox" class="selPA" value="area4" checked style="display:none"/>
				            <input type="checkbox" class="selPA" value="area5" checked style="display:none"/>							            
				        </div>
				        <div class="settingVals">
				            <input type="checkbox" checked name="retainCss"   id="retainCss" class="chkAttr" value="class" style="display:none"/>
				            <input type="checkbox" checked name="retainId"    id="retainId"  class="chkAttr" value="id" style="display:none"/>
				            <input type="checkbox" checked name="retainStyle" id="retainId"  class="chkAttr" value="style" style="display:none"/> 
				        </div>			
					</div>
				</div>
			</div>
		</article>
	</div>
	<div class="row">
		<div class="col-sm-12">
		</div>
	</div>
</section>

<script type="text/javascript">
	
	 

	pageSetUp();
	
	 
	
	// pagefunction
	
	var pagefunction = function() {

		$("#imprime").click(function(){
			var print = "";
			$("input.selPA:checked").each(function(){
				print += (print.length > 0 ? "," : "") + "div.PrintArea." + $(this).val();
			});

			var keepAttr = [];
			$(".chkAttr").each(function(){
				if ($(this).is(":checked") == false )
					return;

				keepAttr.push( $(this).val() );
			});

			var options = { retainAttr : keepAttr };

			$( print ).printArea( options );
		});

	};
	
	// end pagefunction
	
	// run pagefunction
	pagefunction();
	
	$("input,select,textarea").bind("keyup", function (e) {

	  var keyCode = e.keyCode || e.which;
		   if(e.keyCode === 13) {
			e.preventDefault();
			$('input,select,textarea,a')[$('input,select,textarea,a').index(this)+1].focus();
			}
	});
	
</script>
