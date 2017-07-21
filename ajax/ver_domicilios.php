<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');	
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$vTel = (isset($_GET['tel'])?utf8_encode($_GET['tel']):'');
	$vCel = (isset($_GET['cel'])?utf8_encode($_GET['cel']):'');
	if ($vTel != ''){ 
		$datosCte = consultaCtePorTelefono($vTel);
	}else if ($vCel != ''){ 
		$datosCte = consultaCtePorTelefono($vCel);
	}
	$vCte = ISSET($datosCte['data']['keyx'])?$datosCte['data']['keyx']:0;
	$datos = consultarDomicilioPorCte($vCte);	
	//print_r();die();
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title"><img src="img/logo_scp-04.png" width="150px" alt="logo"></h4>
</div>

<!--form action="" id="actualiza_usuarios" class="smart-form" novalidate="novalidate"-->	
<section id="widget-grid" class="">
	
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-21" data-widget-sortable="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false">				 
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>DOMICILIOS REGISTRADOS PARA EL CLIENTE</h2>
					<div class="widget-toolbar">
						<a href="javascript:redirectModificarRFC(<?PHP echo $vCte;?>);" class="btn btn-primary" id="imprime"><i class="fa-fw fa fa-plus"></i> Agregar</a>
					</div>
				</header>
				</div>
					<div class="jarviswidget-editbox">
					</div>
						
					<div class="row">
						<div class="table-responsive">
							<div class="PrintArea area1 all" id="Retain">								
								<table cellspacing="0" cellpadding="0" class="table table-bordered table-striped" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;">
									<thead style="text-align:left">
										<tr>
											<!--th>ID</th-->
											<th>DOMICILIOS REGISTRADOS</th> 
											<th style="text-align:center;">ELIMINAR</th>
											<!--th style="text-align:center;">EDITAR</th-->
										</tr>
									</thead>
									<tbody>
										<?PHP
											$sRespuesta = VerDatosDelCte($datos['data'],$vCte);
											echo $sRespuesta['data'];
										?>
									</tbody>
								</table>
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
			</div>
		</article>
	
	<div class="row">
		<div class="col-sm-12">
		</div>
	</div>
</section>							
	<fieldset> 
	<!-- MODAL PLACE HOLDER -->
		<div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content"></div>
			</div>
		</div>						 
	</fieldset>
<!--/form--> 
<input id="numcliente" name="numcliente" type="hidden" value=0 />
<script src="js/plugin/jquery-form/jquery-form.min.js"></script>
<!-- SCRIPTS ON PAGE EVENT -->

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
