<?php 
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$sku = (isset($_GET['sku'])?$_GET['sku']:0);
	$name = (isset($_GET['name'])?utf8_encode($_GET['name']):'');
	$cant = (isset($_GET['cant'])?$_GET['cant']:'');
	$prec = (isset($_GET['prec'])?$_GET['prec']:'');
	$flag = (isset($_GET['flag'])?$_GET['flag']:'');
	$hr = (isset($_GET['hr'])?$_GET['hr']:0);
	$gr = (isset($_GET['gr'])?$_GET['gr']:0);
	$name = htmlentities(str_replace('_',' ',$name));
	$Grupo = htmlentities(str_replace('_',' ',$gr));
	/*
	print_r($gr);
	print_r($Grupo);
	*/
	echo '<script type="text/javascript">
		var buscaGrupo = $("#idGrupoInventario").find('."'option:contains(".'"'. $Grupo.'"'.")');".'
		if (buscaGrupo.length >= 1)
			$("#idGrupoInventario").val(buscaGrupo.val());
			//console.log(buscaGrupo);
	</script>';
	
?>


<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title"><img src="img/logo.png" width="150" alt="SmartAdmin"></h4>
</div>
<div class="modal-body no-padding">
<form action="" id="actualiza_articulos" class="smart-form" novalidate="novalidate">
	<header>
		<h2><i class="glyphicon glyphicon-barcode"></i>&nbsp;Editar art&iacute;culo</h2>								
	</header>
	<!-- cabecero --><!-- -->
	<!-- datos de la colonia -->							 
	<fieldset>
			<div class="row">										
					<section class="col col-2">											
					<label class="label">SKU</label>
					<label class="input"><i class="icon-prepend fa fa-barcode" ></i>
						<input type="text" name="skuModal" id="skuModal" placeholder="802344" disabled = "disabled" value="<?PHP echo $sku;?>" >
					</label>
				</section>
			</div>
			<div class="row">
				<section class="col col-5">
					<label class="label"><sup>*</sup>Nombre del art&iacute;culo</label>
					<label class="input"> <i class="icon-prepend fa fa-cube"></i>
						<input type="text" placeholder="Ejemplo: Silla" name="articuloModal" id="articuloModal" onkeypress="return isAlphaNumeric(event);" maxlength="50" onfocus="this.select();" value="<?PHP echo $name;?>">
						<b class="tooltip tooltip-top-right">
							<i class="fa fa-warning txt-color-teal"></i> 
							Nombre breve del art&iacute;culo que se mostrar&aacute;.</b> 
					</label>
				</section>
				<section class="col col-2">
					<label class="label"><sup>*</sup>Inventario</label>
					<input class="form-control spinner spinner-left" id="spinner-currencyModal" name="cantidadModal" type="text" onkeypress="return isNumber(event);" value="<?PHP echo $cant;?>" maxlength="10" onfocus="this.select();">
				</section>
			</div>
			<div class="row">									 
				<section class="col col-3">
					<label class="label"><sup>*</sup>Precio de renta</label>
					<label class="input"><i class="icon-prepend fa fa-usd"></i>
						<input type="text" placeholder="1.00" maxlength="8" name="precioModal" id="precioModal" onkeypress="return isNumber(event);" value="<?PHP echo $prec;?>" maxlength="10" onfocus="this.select();">
					</label>										 
				</section>
				<section class="col col-4">
					<label class="label">&nbsp;</label>
					<div class="input-group">
							<input class="form-control"  value="¿Es un artículo especial ? " style="text-align:center" readonly="true" id="st3fx">
							<span class="input-group-addon">
								<span class="onoffswitch">
									<input type="checkbox" name="start_interval" class="onoffswitch-checkbox" id="st3Modal" onchange="cambioEspecialModalArticulo();" value="0">
									<label class="onoffswitch-label" for="st3Modal" id="st3flag"> 
										<span class="onoffswitch-inner" data-swchon-text="SI" data-swchoff-text="NO" id="txtFlag"></span> 
										<span class="onoffswitch-switch" id="txtFlagSpan"></span> 
									</label> 
								</span>
							</span>
						</div>
				</section>
				<section class="col col-2" id="dvHorasArticuloEspecialModal" style="display:none">
					<label class="label"><sup>*</sup> Horas de renta</label>
					<label class="input"><i class="icon-prepend fa fa-clock-o"></i>
						<input type="text" placeholder="1"  name="horas" id="horasModal" value="<?PHP echo $hr;?>" onkeypress="return isNumber(event);" maxlength="3" onfocus="this.select();">
					</label>										 
				</section>											
			</div>		
			<div class="row">
				<section class="col col-3">
					<label class="label"> Ligar a grupo de inventario</label>
						<div class="form-group">									
							<select style="width:100%" class="select2" id="idGrupoInventario">
								<?PHP
									$sRespuesta = LlenarComboGrupoInventario();
									echo $sRespuesta['data'];
								?>
							</select>
						</div>
				</section>
			</div>
	</fieldset>	

	<div class="col col-4">
		<p class="note">*Campo obligatorio.</p>
	</div>
	<footer>
		<button type="button" id="btnGUpdateInventario" class="btn btn-primary" onclick="return ActualizarInventario();">
			<i class="fa fa-save"></i>&nbsp;Guardar
		</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">
			Cancelar
		</button>
	</footer>
</form> <!--     Termina formulario  -->
		<!-- mensajes de error -- >						
						<fieldset>
							<section>
								<div class="alert alert-block alert-success" id="MsgExitoUsr" style="display:none">
									<a class="close" data-dismiss="alert" href="#">×</a>
									<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ! &Eacute;xito !</h4>									
									<p>
										<div id="mensajeOk">
											Se actualizo el registro &eacute;xitosamente.
										</div>
									</p>									
								</div>
							</section>
							<section>
								<div class="alert alert-block alert-danger" id="MsgFallaUsr" style="display:none">
									<a class="close" data-dismiss="alert" href="#">×</a>
									<h4 class="alert-heading"><i class="fa fa-warning"></i> ! Ocurri&oacute; un error !</h4>
									<p>
										<div id="mensajeFail">
												Ocurri&oacute; un error al guardar.
										</div>
									</p>
								</div>
							</section>
						</fieldset-->
</div>
<script src="js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="js/plugin/jqgrid/grid.locale-en.min.js"></script>
 
<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript"> 
	var flag = "<?PHP echo $flag;?>"; 
	if(flag != 0){
		$("#st3Modal").change();
		$("#st3Modal").val(flag);
		$("#horasModal").val("<?PHP echo $hr;?>");
		
	}
	
	pageSetUp();		
	// PAGE RELATED SCRIPTS

	// valida caracteres de entrada
	function valida_entrada(ob) {
	  var invalidChars = /[^0-9]/gi
	  if(invalidChars.test(ob.value)) {
	            ob.value = ob.value.replace(invalidChars,"");
	      }
	}
	
	var pagefunction = function() {

	 
	var $registerForm = $("#actualiza_articulos").validate({
			// Rules for form validation
			rules : {
				articulo : {
					required : true
				},
				cantidad : {
					required : true
				},
				precio : {
					required : true
				},
				horas : {
					required : true
				}
			},
			// Messages for form validation
			messages : {
				
				articulo : {
					required : '*Campo obligatorio.'
				} 
			},
			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	};
	
	$("input,select,textarea").bind("keyup", function (e) {

	  var keyCode = e.keyCode || e.which;
		   if(e.keyCode === 13) {
			e.preventDefault();
			$('input,select,textarea')[$('input,select,textarea').index(this)+1].focus();
			}
	});
	 
</script>