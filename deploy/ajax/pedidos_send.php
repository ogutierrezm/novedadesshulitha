<?php  
	require_once("inc/init.php"); 
	require_once("../calls/fn_generales.php");
	require_once('../conx/conexiones.php');	
	date_default_timezone_set('America/Mazatlan');
	session_start();
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	
	$folio = $iFolioPedido;	
	$nota = $iFolioPedido;
	$sResultado = $sResultado['data'];
	$iIva = ISSET($sResultado['iva'])?$sResultado['iva']:0;
	$sNumeroCasa = $sResultado['numext'].(($sResultado['numint'] != '')?' - '.$sResultado['numint']:'');
	$aColonia = explode(" - ", $sResultado['colonia']);
	$sColonia = (ISSET($aColonia[1]) ? $aColonia[1] : '' );

$html = '
<script type="text/javascript" src="js/plugin/printarea/jquery.PrintArea.js"></script>
        <link type="text/css" rel=""           href="empty.css" />                    <!-- N : rel is not stylesheet -->
        <link type="text/css" rel="noPrint"    href="noPrint.css" />                  <!-- N : rel is not stylesheet -->
        <link type="text/css"                  href="no_rel.css"     media="print" /> <!-- N : no rel attribute -->
        <link type="text/css"                  href="no_rel_no_media.css"          /> <!-- N : no rel, no media attributes -->


<div class="row">
	<!-- col -->
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
	<!--	
		<h1 class="page-title txt-color-blueDark">			
			<!-- PAGE HEADER 
			<i class="fa-fw fa fa-home"></i> 
				Nota de abono
			<span> </span>
		</h1> 
	-->
	</div>	
	<!-- end col  -->
</div> 
<!-- end row -->
<!-- widget grid -->
<section id="widget-grid" class="">
	<!-- row -->
	<div class="row">
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">				 
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-16" data-widget-colorbutton="false" data-widget-editbutton="false"	data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-collapsed="flase" data-widget-sortable="false" >				 
				<header>
					<!--span class="widget-icon"> <i class="fa fa-print"></i> </span-->
					<h2>Pedido folio #'.$folio.'</h2>
				</header>
				<!-- widget div-->
				<div>					
					<!-- widget content -->
					<div class="widget-body">
						<div class="table-responsive">						 
							<!-- Encabezado -->
							<div class="PrintArea area1 all" id="Retain">
								<table class="table bordered" width="100%" style="border: solid 2px #999fff; float: left; padding: 4px; margin-bottom: 5px; text-align:center;">								 
									<tbody>

										<tr>
											<td class="text-center" width="50px"> <!--img src="img/vertical_line.png" height="170" alt="logo"--> </td>
											<td class="text-center" width="660px">
												<h1 class="font-400">Diversiones Piscis</h1>
												<p style="text-align:center;font-size: 15px;"><span class="font-lg">Alquiler de mobiliario, rockolas karaoke, brincolines, acu&aacute;ticos, carpas, toros mec&aacute;nicos y manteler&iacute;a fina.</span></p>
												<span style="text-align:center;font-size:11px;">Blvd. Parque Lineal de los Agricultores #3095 Col. Amistad. Culiac&aacute;n, Sin.</span>
												<br>
												<span style="text-align:center;font-size:11px;">Tel. 762-23-48, 762-20-00, Cel. (71)90-00-17, (72)-04-03-33</span>
											</td>
											<td class="text-center" width="120px">
												<h3>Pedido No.<br><span class="txt-color-blue">'.$folio.'</span></h3>
												<br>
												<h4>Fecha del pedido:<br><span class="txt-color-blue">'. date("Y-m-d").'</span></h4>
											</td>										 
										</tr> 
									</tbody>
								</table>
							</div><!-- Zona que se imprimira -->
							<div class="PrintArea area2 all" id="Retain">
								<!-- Datos del cliente -->
								<table class="table table-hover" width="100%"  style="border: solid 1px #999fff; float: left; padding: 2px; margin-bottom: 2px;">								 
									<tbody style="text-align:left;font-size: 12px;">
										<tr>'; 
											$html .= '<td class="text-left" style="width:220px"><strong>Cliente:</strong>&nbsp;'. $sResultado['nombrecte'] . ' ' .$sResultado['apellidocte'].'</td>
											<td class="text-left" style="width:130px"><strong>Tel&eacute;fono:</strong>&nbsp;'. $sResultado['telefonocasa'] .'</td>
											<td class="text-left" style="width:170px"><strong>Celular:</strong>&nbsp;'. $sResultado['telefonocelular'] .'</td>
											<td class="text-left" style="width:130px"><strong>Cobro adicional:</strong>&nbsp;$'.$sResultado['flete'].'</td>				 
										</tr> 
										<tr>
											<td class="text-left"><strong>Calle:</strong>&nbsp;'.$sResultado['calle'].'</td>
											<td class="text-left"><strong>N&uacute;mero:</strong>&nbsp;'. $sNumeroCasa.'</td>
											<td class="text-left" colspan="2"><strong>Colonia:</strong>&nbsp;'. $sColonia .'</td>										 
										</tr>
										<tr>
											<td class="text-left"><strong>Hora:</strong>&nbsp;'. $sResultado['notahoraentrega'] .' '. $sResultado['notahorarecoger'].'</td>
											<td class="text-left"><strong>Color:</strong>&nbsp;'.$sResultado['manteleria'].'</td>
											<td class="text-left"><strong>Elabor&oacute; pedido:</strong>&nbsp;'. $sResultado['empleado'] .'</td>
											<td class="text-left"><strong>Fecha:</strong>&nbsp;'.$sResultado['fechapedido'].'</td>										 
										</tr>
									</tbody>
								</table>
							</div>
							<div class="PrintArea area3 all" id="Retain">						 
								<!-- Detalle -->
								<table class="table table-bordered table-hover" width="100%"  style="border: solid 1px #999fff; float: left; padding: 5px; margin-bottom: 5px; text-align:center;">								 
									<tbody style="font-size: 13px;">
									<thead>
										<tr>
											<th class="text-center" width="15%" style="border: solid 1px #F0F1F7;">Sku</th>
											<th class="text-center" style="border: solid 1px #F0F1F7;">Art&iacute;culo</th>
											<th class="text-center" width="15%" style="border: solid 1px #F0F1F7;">Cantidad</th>
											<th class="text-center" width="15%" style="border: solid 1px #F0F1F7;">Subtotal</th>
										</tr>
									</thead>';
											$sArticulos = consultarArticulosUnPedidosPendiente($folio);
											//$sArticulos = consultarArticulosUnaCotizacion($folio);
											$sArticulos = $sArticulos['data'];
											$html .= $sArticulos; 
										
										
									$html .='</tbody>
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
												En esta ciudad el d&iacute;a <u>'.date("d").'</u>  del mes <u>'.date("m").'</u> de <u>'. date("Y").'</u> la cantidad de $ __ valor recibido de mercancia y servicios a mi entera satisfacci&oacute;n. 
												Este pagar&eacute; es mercantil y esta regido por la Ley General de T&iacute;tulos y Operaciones de cr&eacute;dito en sus art&iacute;culos 172 y 173 parte final por no ser pagar&eacute; domiciliado y art&iacute;culos correlativos, si no es pagado a su vencimiento causar&aacute; intereses del ___ % mensual.
											</p>
										</td>																 
										</tr>							
										<tr>';
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
												$html .='<td class="text-right" style="text-align:right;"><strong>(+) Subtotal:</strong>&nbsp;$'. $subTotal.'</td>'
										.'</tr>';
											
										$html .='
										<tr>
											<td class="text-right" style="text-align:right;"><strong>(-) Descuento:</strong>&nbsp;$'. $ImporteDescto.'</td>	
										</tr> 
										<tr>										
											<td class="text-right" style="text-align:right;"><strong>(+) Adicional:</strong>&nbsp;$'. $ImporteFlete .'</td>
										</tr>
										<tr>										
											<td class="text-right" style="text-align:right;"><strong>(+) IVA:</strong>&nbsp;$'.$vValorIVA.'</td>
										</tr>
										<tr>										
											<td class="text-right" style="text-align:right;"><strong>(+) Dep&oacute;sito:</strong>&nbsp;'. $Deposito .'</td>
										</tr>
										<tr>										
											<td class="text-right" style="text-align:right;"><strong>(=) Total:</strong>&nbsp;$'.$TotalGral.'</td>
										</tr>
									</tbody>
								</table>							
								<!-- Footer -->
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
						</div> <!-- table responsive -->
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
			</div> 
			<!-- end jarviswidget -->
			<!-- end widget -->
		</article>
		<!-- WIDGET END -->
	</div> 
	<!-- end row -->
	<!-- row -->
	<div class="row">
		<!-- a blank row to get started -->
		<div class="col-sm-12">
			  <!-- out -->
		</div>
	</div>
	<!-- end row -->

</section>';
?>