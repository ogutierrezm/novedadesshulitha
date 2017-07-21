<?php  
	require_once("inc/init.php"); 
	require_once("../calls/fn_generales.php");
	require_once('../conx/conexiones.php');	
	date_default_timezone_set('America/Mazatlan');
	session_start();
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$folio = ISSET($_GET['f'])?$_GET['f']:'';
	$sResultado = consultarUnaCotizacionparaEmail($folio);
	$sResultado = $sResultado['data'];
	$iIva = ISSET($sResultado['iva'])?$sResultado['iva']:0;
	
	$variable = obtenerVariableEmpresa(2,1);
	$variable = ISSET($variable['data']['valor'])?$variable['data']['valor']:300;
	echo '<script>var vTiempoSesion = '.$variable.';</script>';
	/*include("../php/expire.php");  */  
?>


<script type="text/javascript" src="js/plugin/printarea/jquery.PrintArea.js"></script>
        <link type="text/css" rel=""           href="empty.css" />
        <link type="text/css" rel="noPrint"    href="noPrint.css" />
        <link type="text/css"                  href="no_rel.css"     media="print" />
        <link type="text/css"                  href="no_rel_no_media.css"          />


<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
	</div>	
</div> 
<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">				 
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-16" data-widget-colorbutton="false" data-widget-editbutton="false"	data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-collapsed="flase" data-widget-sortable="false" >				 
				<header>
					<span class="widget-icon"> <i class="fa fa-print"></i> </span>
					<h2>Impresi&oacute;n de cotizaci&oacute;n #<?PHP echo $folio ; ?></h2>
				</header>
				<div>					
					<div class="jarviswidget-editbox">
						<input class="form-control" type="text">	
					</div>
					<div class="widget-body">
						<div class="widget-body-toolbar">
								<div class="row">
									<div class="col-sm-4"></div>
									<div class="col-sm-8 text-align-right">
										<div class="btn-group">											
											<a href="javascript:void(0)" id="imprime" class="btn btn-sm btn-primary" > <i class="fa fa-print"></i> Imprimir </a>
										</div> 
									</div>
								</div>
						</div>
						<div class="table-responsive">						 
							<div class="PrintArea area1 all" id="Retain">
								<table class="table bordered" width="100%" style="border: solid 2px #999fff; float: left; padding: 4px; margin-bottom: 5px; text-align:center;">								 
									<tbody>

										<tr>
											<td class="text-center" width="50px"> <img src="img/vertical_line.png" height="170" alt="logo"> </td>
											<td class="text-center" width="660px">
												<h1 class="font-400">Diversiones Piscis</h1>
												<p style="text-align:center;font-size: 15px;"><span class="font-lg">Alquiler de mobiliario, rockolas karaoke, brincolines, acu&aacute;ticos, carpas, toros mec&aacute;nicos y manteler&iacute;a fina.</span></p>
												<span style="text-align:center;font-size:11px;">Blvd. Parque Lineal de los Agricultores #3095 Col. Amistad. Culiac&aacute;n, Sin.</span>
												<br>
												<span style="text-align:center;font-size:11px;">Tel. 762-23-48, 762-20-00, Cel. (71)90-00-17, (72)-04-03-33</span>
											</td>
											<td class="text-center" width="120px">
												<h3>Cotizaci&oacute;n No.<br><span class="txt-color-blue"><?PHP echo $folio ; ?></span></h3>
												<br>
												<h4>Fecha cotizaci&oacute;n:<br><span class="txt-color-blue"><?php date_default_timezone_set ("America/Mazatlan"); echo date("Y-m-d"); ?></span></h4>
											</td>										 
										</tr> 
									</tbody>
								</table>
							</div>
							<div class="PrintArea area2 all" id="Retain">
								<table class="table table-hover" width="100%"  style="border: solid 1px #999fff; float: left; padding: 2px; margin-bottom: 2px;">								 
									<tbody style="text-align:left;font-size: 12px;">
										<tr>
											<td class="text-left" style="width:220px"><strong>Cliente:</strong>&nbsp;<?PHP echo $sResultado['nombrecte'] . ' ' .$sResultado['apellidocte'] ; ?></td>
											<td class="text-left" style="width:130px"><strong>Tel&eacute;fono:</strong>&nbsp;<?PHP echo $sResultado['telefonocasa'] ; ?></td>
											<td class="text-left" style="width:170px"><strong>Celular:</strong>&nbsp;<?PHP echo $sResultado['telefonocelular'] ; ?></td>
											<td class="text-left" style="width:130px"><strong>Cobro adicional:</strong>&nbsp;$<?PHP echo $sResultado['flete'] ; ?></td>				 
										</tr>
										<tr>
											<td class="text-left"><strong>Hora:</strong>&nbsp;<?PHP echo $sResultado['notahoraentrega'] .' '. $sResultado['notahorarecoger']  ; ?></td>
											<td class="text-left"><strong>Color:</strong>&nbsp;<?PHP echo $sResultado['manteleria'] ; ?></td>
											<td class="text-left"><strong>Elabor&oacute; cotizaci&oacute;n:</strong>&nbsp;<?PHP echo $sResultado['empleado'] ; ?></td>
											<td class="text-left"><strong>Fecha:</strong>&nbsp;<?PHP echo $sResultado['fechapedido'] ; ?></td>										 
										</tr>
									</tbody>
								</table>
							</div>
							<div class="PrintArea area3 all" id="Retain">						 
								<table class="table table-bordered table-hover" width="100%"  style="border: solid 1px #999fff; float: left; padding: 5px; margin-bottom: 5px; text-align:center;">								 
									<tbody style="font-size: 13px;">
									<thead>
										<tr>
											<th class="text-center" width="15%" style="border: solid 1px #F0F1F7;">Sku</th>
											<th class="text-center" style="border: solid 1px #F0F1F7;">Art&iacute;culo</th>
											<th class="text-center" width="15%" style="border: solid 1px #F0F1F7;">Cantidad</th>
											<th class="text-center" width="15%" style="border: solid 1px #F0F1F7;">Subtotal</th>
										</tr>
									</thead>
										<?PHP 	$sArticulos = consultarArticulosUnaCotizacion($folio);
												$sArticulos = $sArticulos['data'];
												echo $sArticulos; 
										?>
									</tbody>
								</table>
							</div>
							<div class="PrintArea area4 all" id="Retain">
								<table class="table table-condensed" width="100%" style="border: solid 1px #999fff; float: left; padding: 5px; margin-bottom: 5px;">								 
									<tbody>
										<tr>										
										<td class="text-left" rowspan="7" width="76%" >
											<p class="note" style="text-align:justify;font-size:10px;color:gray;">
												<strong>Importante</strong>: Los precios no incluyen I.V.A 50% de anticipo al autorizar el pedido. Liquidar en su totalidad el pedido un d&iacute;a antes del evento, de lo contrario la mercancia no se entregara. En casos exclusivos se requiere el 20% de deposito. No se regresan anticipos.
												<br>
												El alquiler es solo por el d&iacute;a que se estipula al contratar el servicio. El cliente queda obligado a pagar la compostura del (o los) muebles que hayan deteriorados. En caso de perdida del (o los) art&iacute;culo(s), el cliente pagar&aacute; el valor integro.
											</p>
											<p class="note" style="text-align:justify;font-size: 10px;color:gray;">
												Debo y pagare incondicionalmente a la orden de <strong>DIVERSIONES PISCIS</strong>. 
												En esta ciudad el d&iacute;a <u><?php date_default_timezone_set ("America/Mazatlan"); echo date("d"); ?></u>  del mes <u><?php date_default_timezone_set ("America/Mazatlan"); echo date("m"); ?></u> de <u><?php date_default_timezone_set ("America/Mazatlan"); echo date("Y"); ?></u> la cantidad de $ __ valor recibido de mercancia y servicios a mi entera satisfacci&oacute;n. 
												Este pagar&eacute; es mercantil y esta regido por la Ley General de T&iacute;tulos y Operaciones de cr&eacute;dito en sus art&iacute;culos 172 y 173 parte final por no ser pagar&eacute; domiciliado y art&iacute;culos correlativos, si no es pagado a su vencimiento causar&aacute; intereses del ___ % mensual.
											</p>
										</td>																 
										</tr>							
										<tr>
											<?PHP 
												$TotalNeto =INTVAL($sResultado['total']) - INTVAL($sResultado['flete']);
												$ImporteFlete = INTVAL($sResultado['flete']);
												if($iIva == 1){
													$vValorIVA = ROUND($sResultado['total'] - ($sResultado['total'] /1.16));
												}else{
													$vValorIVA =0;
												}
												$TotalSinIVA = $TotalNeto - $vValorIVA;
												$ImporteDescto = ROUND(($TotalSinIVA /((100-$sResultado['cantidaddescuento'])/100))- $TotalSinIVA);
												$subTotal = ROUND($TotalSinIVA + $ImporteDescto);
												$Deposito = $sResultado['garantia'];
												$TotalGral = INTVAL($sResultado['total']) + $Deposito;
												ECHO '<td class="text-right" style="text-align:right;"><strong>(+) Subtotal:</strong>&nbsp;$'. $subTotal.'</td>';
											?>
										</tr>
										<tr>
											<?PHP 
												ECHO '<td class="text-right" style="text-align:right;"><strong>(-) Descuento:</strong>&nbsp;$'. $ImporteDescto.'</td>';
											?>
										</tr>
										<tr>
											<?PHP 
												ECHO '<td class="text-right" style="text-align:right;"><strong>(+) Adicional:</strong>&nbsp;$'. $ImporteFlete .'</td>';
											?>
										</tr>
										<tr> 
											<?PHP 
												ECHO '<td class="text-right" style="text-align:right;"><strong>(+) IVA:</strong>&nbsp;$'.$vValorIVA.'</td>';
											?>
										</tr>
										<tr>										
											<td class="text-right" style="text-align:right;"><strong>(+) Dep&oacute;sito:</strong>&nbsp;$<?PHP echo $Deposito;?></td>
										</tr>
										<tr>
											<?PHP 
												ECHO '<td class="text-right" style="text-align:right;"><strong>(=) Total:</strong>&nbsp;$'.$TotalGral.'</td>';
											?>
										</tr>
										
									</tbody>
								</table>							
							</div>						
							<div class="PrintArea area5 all" id="Retain">
								<table class="table table-condensed" width="100%" style="border: solid 1px #999fff; float: left; padding: 5px; margin-bottom: 5px;">								 
									<tbody>
										<tr>										
											<td class="text-center" style="text-align:center;font-size: 11px;"><strong>LOS PRECIOS MENCIONADOS ESTAN SUJETOS A CAMBIOS SIN PREVIO AVISO</strong></td>
										</tr>									 				
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

	
		loadMockJax();
		
		function loadMockJax() {
		    loadScript("js/plugin/x-editable/jquery.mockjax.min.js", loadXeditable);
		}
	
		function loadXeditable() {
		    loadScript("js/plugin/x-editable/x-editable.min.js", loadTypeHead);
		}
	
		function loadTypeHead() {
		    loadScript("js/plugin/typeahead/typeahead.min.js", loadTypeaheadjs);
		}
	
		function loadTypeaheadjs() {
		    loadScript("js/plugin/typeahead/typeaheadjs.min.js", runXEditDemo);
		}
	
		function runXEditDemo() {
	
		     
		    //ajax mocks
		    $.mockjaxSettings.responseTime = 500;
	
		    $.mockjax({
		        url: '/post',
		        response: function (settings) {
		            //log(settings, this);
		        }
		    });
	
		    $.mockjax({
		        url: '/error',
		        status: 400,
		        statusText: 'Bad Request',
		        response: function (settings) {
		            this.responseText = 'Please input correct value';
		            //log(settings, this);
		        }
		    });
	
		    $.mockjax({
		        url: '/status',
		        status: 500,
		        response: function (settings) {
		            this.responseText = 'Internal Server Error';
		           // log(settings, this);
		        }
		    });
	
		    $.mockjax({
		        url: '/groups',
		        response: function (settings) {
		            this.responseText = [{
		                value: 0,
		                text: 'Guest'
		            }, {
		                value: 1,
		                text: 'Service'
		            }, {
		                value: 2,
		                text: 'Customer'
		            }, {
		                value: 3,
		                text: 'Operator'
		            }, {
		                value: 4,
		                text: 'Support'
		            }, {
		                value: 5,
		                text: 'Admin'
		            }];
		           // log(settings, this);
		        }
		    });
	
		    	
		    //defaults
		    //$.fn.editable.defaults.url = '/post';
		    //$.fn.editable.defaults.mode = 'inline'; use this to edit inline
	
		    //enable / disable
		    $('#enable').click(function () {
		        $('#user .editable').editable('toggleDisabled');
		    });
	
		    //editables
		    /*
		    $('#username').editable({
		        url: '/post',
		        type: 'text',
		        pk: 1,
		        name: 'username',
		        title: 'Enter username'
		    });
			*/
	
		    $('#ife').editable({
		    	emptytext: '________________________',
		    	placement: 'top',
		    	validate: function (value) {
		            if ($.trim(value) == '')
		                return '*Campo obligatorio';
		        }
		    });	 
		    $('#acepto').editable({
		    	emptytext: '________________________',
		    	placement: 'top',
		    	validate: function (value) {
		            if ($.trim(value) == '')
		                return '*Campo obligatorio';
		        }
		    });	  
		    $('#entrego').editable({
		    	emptytext: '________________________',
		    	placement: 'top',
		    	validate: function (value) {
		            if ($.trim(value) == '')
		                return '*Campo obligatorio';
		        }
		    });	     
	 
	
		}


	}; 
	
	// end pagefunction

	// destroy generated instances 
	// pagedestroy is called automatically before loading a new page
	// only usable in AJAX version!

	var pagedestroy = function(){
		
		/*
		Example below:

		$("#calednar").fullCalendar( 'destroy' );
		if (debugState){
			root.console.log("✔ Calendar destroyed");
		} 

		For common instances, such as Jarviswidgets, Google maps, and Datatables, are automatically destroyed through the app.js loadURL mechanic

		*/ 
	    
	    //destroy xeditable
	    $('#ife').editable("destroy");
	    $('#acepto').editable("destroy");
	    $('#entrego').editable("destroy"); 
	    
	}

	// end destroy
	
	// run pagefunction
	
	pagefunction();
	
</script>

