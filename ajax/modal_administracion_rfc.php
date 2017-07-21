<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');	
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$vCte = (isset($_GET['keyx'])?utf8_encode($_GET['keyx']):'');
	
	$datosCte = consultaCtePorKeyx($vCte);
	$vCteNombres = ISSET($datosCte['data']['nombres'])?$datosCte['data']['nombres']:'';
	$vCteApellidos = ISSET($datosCte['data']['apellidos'])?$datosCte['data']['apellidos']:'';
	$vCteName = $vCteNombres . ' '. $vCteApellidos;
	//print_r($datosCte);die();
	//$vCte = ISSET($datosCte['data']['keyx'])?$datosCte['data']['keyx']:0;
	$datos = consultarDatosFiscalesCte($vCte);	
	
	$vCP = 0;
	$vCalle = '';
	$sRespuestaColonias = LlenarComboColoniasSepomex($vCP,$vCalle);
?>
<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
				<div>
					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body no-padding">
						<form action="" id="admon_asentamiento" class="smart-form" novalidate="novalidate">
								<header>
									<h3>Asignaci&oacute;n de datos fiscales a #cliente</h3>
								</header>
								<fieldset>									 
									<div class="row">
										<section class="col col-1">											
											<label class="label"><sup>*</sup># Cliente</label>
											<label class="input">
												<input type="NUMERIC" id="iCliente" name="iCliente" placeholder="#" value='<?PHP echo $vCte;?>' readonly>
											</label>
										</section>									 								
										<section class="col col-3">
								           <div class="form-group">
												<label class="label"><sup>*</sup> Nombre del cliente</label>
												<label class="input">
													<input class="text" placeholder="JESUS LORENZO BASURTO LOAIZA" name="tCliente" id="tCliente" value='<?PHP echo $vCteName;?>' readonly>
												</label>                  
											</div>
								        </section>
										<section class="col col-2">											
											<label class="label"><sup>*</sup>RFC</label>
											<label class="input">
												<input type="text" id="iRFC" name="iRFC" placeholder="BLAJ860320999" maxlength="13" onkeypress="return isAlphaNumeric(event);">
											</label>
										</section>									 								
										<section class="col col-3">
								           <div class="form-group">
												<label class="label"><sup>*</sup> Raz&oacute;n Social</label>
												<label class="input">
													<input class="text" placeholder="NOMBRE DE LA EMPRESA" name="tRazon" id="tRazon" onkeypress="return isAlphaNumeric(event);">
												</label>                  
											</div>
								        </section>
									</div>
								</fieldset>
								<fieldset>									 
									<div class="row">								
										<section class="col col-3">											
											<label class="label"><sup>*</sup> Calle</label>
											<label class="input">
												<input type="text" id="Calle" name="Calle" placeholder="AV ALVARO OBREGON" onkeypress="return isAlphaNumeric(event);">
											</label>
										</section>
										<section class="col col-2">
											<label class="label"># Exterior</label>
											<label class="input">
												<input type="text" id="nExterior" name="nExterior" placeholder="####" onkeypress="return isAlphaNumeric(event);">
											</label>
										</section>																	
										<section class="col col-2">
								           <div class="form-group">
												<label class="label"><sup>*</sup>Email</label>
												<label class="input">
													<input class="input" placeholder="ejemplo@dominio.com" type="text"  name="nInterior" id="nInterior" onkeypress="return isAlphaNumeric(event);">
												</label>                  
											</div>
								        </section>
									</div>
								</fieldset>								
								<fieldset>									 
									<div class="row">								
										<section class="col col-2">											
											<label class="label"><sup>*</sup>C&oacute;digo Postal</label>
											<label class="input">
												<input type="text" id="tCodigoPostal" name="tCodigoPostal" placeholder="80000" onkeyup="return isNumber(event);" onblur="return blurConsultarCalleSepomex();">
											</label>
										</section>									 								
										<section class="col col-3">
								           <div class="form-group">
												<label class="label"><sup>*</sup> Colonia</label>
												<label class="input">
													<input class="input" placeholder="Centro" type="text"  name="Colonia" id="Colonia" onchange="return ConsultarColonias();" onblur="return ConsultarColonias();" onkeypress="return limpiaDatosCpMnipio();" >
												</label>                  
											</div>
								        </section>
										<section class="col col-2">
											<label class="label"><sup>*</sup> Municipio</label>
											<label class="input">
												<input type="text" id="tMunicipio" name="tMunicipio" placeholder="C&uacute;liacan" onkeypress="return isAlphaNumeric(event);">
											</label>
										</section>	
										<section class="col col-2">
											<label class="label"><sup>*</sup> Estado</label>
											<label class="input">
												<input type="text" id="tEstado" name="tEstado" placeholder="SINALOA" onkeypress="return isAlphaNumeric(event);">
											</label>
										</section>							
									</div>
									<div class="col-sm-12">
										<p class="note">*Campo obligatorio.</p>
									</div>					
								</fieldset>							
								<footer>
									<button type="button" class="btn btn-primary" onclick="return grabarDatosFiscales();">
										<i class="fa fa-save"></i>&nbsp;Guardar
									</button>
									<button type="button" class="btn btn-default" onclick="LimpiarDatosFiscales();">
										Cancelar
									</button>
								</footer>
							</form>
					</div>
				</div>
			</div>
		</article>
	</div>
</section>
<script src="js/plugin/jquery-form/jquery-form.min.js"></script>

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
	
	$(function() {
		var availableTags = [<?PHP echo $sRespuestaColonias['data'];?>
		/*"ActionScript",
		  "AppleScript",
		  "Asp"*/
		];
		$( "#Colonia" ).autocomplete({
		  source: availableTags
		});
	});
	
	$('#iRFC').focus();
</script>
