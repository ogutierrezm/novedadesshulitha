<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');	
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	
	$id = (isset($_GET['id'])?utf8_encode($_GET['id']):0);
	$cp = (isset($_GET['cp'])?utf8_encode($_GET['cp']):'');	
	$colonia = (isset($_GET['colonia'])?utf8_encode($_GET['colonia']):'');
	$ciudad = (isset($_GET['ciudad'])?utf8_encode($_GET['ciudad']):'');
	$colonia = htmlentities(str_replace('%',' ',$colonia));
	$ciudad = htmlentities(str_replace('%',' ',$ciudad));
	
	$vCP = 0;
	$vCalle = '';
	$sRespuestaColonias = LlenarComboColoniasSepomex($vCP,$vCalle);
?>
<script type="text/javascript">	
	$("input,select,textarea").bind("keyup", function (e) {

	  var keyCode = e.keyCode || e.which;
		   if(e.keyCode === 13) {
			e.preventDefault();
			$('input,select,textarea')[$('input,select,textarea').index(this)+1].focus();
			}
	});
	LlenarComboZonasCapturadas();
	/*var parametros = getFormData($("#form_colonias"));
	var url = "./php/colonias.php";
	parametros.categoria = "COMBO_ZONAS_COLONIAS";
    var response = callAjax(parametros, url);
    if(response.success){
		$('#SelectZonaModal').append(response.data);
    }else{
      showMessageError(response.error);
    }*/
	var availableTags = [<?PHP echo $sRespuestaColonias['data'];?>];
	//alert(availableTags);
	$(function() {
		$( "#ColoniaModal" ).autocomplete({
		  source: availableTags
		});
	});
	
	$('#idModal').html('<?PHP echo $id;?>');
	$('#cpModal').val('<?PHP echo $cp;?>');
	$('#cpModal').change();
	$('#ColoniaModal').val('<?PHP echo $colonia;?>');
	$('#municipioModal').val('<?PHP echo $ciudad;?>');	
</script>
<script src="js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="js/plugin/jqgrid/grid.locale-en.min.js"></script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title"><img src="img/logo_scp-04.png" width="150" alt="logo"></h4>
</div>
<div class="modal-body no-padding">
	<form action="" id="form_colonias_modal" class="smart-form">
		<header>
			<h2><i class="glyphicon glyphicon-pencil"></i>&nbsp;Editar asignaci&oacute;n de colonia</h2>								
		</header>					 
		<fieldset>
			<div class="row">
				<section class="col col-2">
					<div class="well well-sm bg-color-darken txt-color-white text-left">
						<h5>&nbsp;ID #<label id="idModal"></label></h5>										 
					</div>
				</section>					 
			</div>									 
			<div class="row">								
				<section class="col col-2">											
					<label class="label">C&oacute;digo Postal</label>
					<label class="input"><i class="icon-prepend fa fa-tag"></i>
						<input type="text" id="cpModal" name="cpModal" placeholder="80000" data-mask="99999" disabled="disabled" readonly/>
					</label>
				</section>									 								
				<section class="col col-3">
				   <div class="form-group">
						<label class="label"><sup>*</sup> Colonia</label>
						<label class="input"><i class="icon-prepend fa fa-tag"></i>
							<input class="input" placeholder="Centro" type="text"  name="ColoniaModal" id="ColoniaModal" disabled="disabled" readonly>
							<!--input class="input" placeholder="Centro" type="text"  name="ColoniaModal" id="ColoniaModal" onchange="return ConsultarColonias();" onblur="return ConsultarColonias();" onkeypress="return limpiaDatosCpMnipio();" disabled="disabled" readonly-->
						</label>                  
					</div>
				</section>
				<section class="col col-2">
					<label class="label">Municipio</label>
					<label class="input"><i class="icon-prepend fa fa-map-marker"></i>
						<input type="text" id="municipioModal" name="municipioModal" placeholder="C&uacute;liacan" disabled="disabled" readonly/>
					</label>
				</section>	
				<section class="col col-4">
					<label class="label"><sup>*</sup>Zona</label>
					<label class="select">
						<select id="SelectZonaModal" name="SelectZonaModal">
						</select><i></i> </label>
				</section>								
			</div>												
		</fieldset>	

		<div class="col col-4">
			<p class="note">*Campo obligatorio.</p>
		</div>
		<footer>
			<button type="button" id="btnGModificarColoniaZona" class="btn btn-primary" onclick="return ActualizarZonaColonia(<?PHP echo $id;?>)">
				<i class="fa fa-save"></i>&nbsp;Guardar
			</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">
				Cancelar
			</button>
		</footer>
	</form>
</div>