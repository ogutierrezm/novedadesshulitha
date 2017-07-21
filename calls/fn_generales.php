<?php
	function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}

		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}

	function arrayToObject($d) {
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return (object) array_map(__FUNCTION__, $d);
		}
		else {
			// Return object
			return $d;
		}
	}
	
	
				
	
			
	/*
	function obtenerSKU(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No existe consecutivo");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT (CASE WHEN Last_value = 1 THEN (SELECT COUNT (1) FROM ctl_inventario) ELSE Last_value END)::BIGINT + 1 AS retorno FROM  ctl_inventario_id_articulo_seq;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				
				$arreglo['success'] = true;
				$arreglo['data'] = $sRetorno;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	function grabarArticuloNew($horas,$st3,$precio,$cantidad,$articulo,$contenido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No existe consecutivo");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_invent_insert('$articulo',$cantidad,'$precio',$st3,$horas,'$contenido') AS retorno;");
			//print_r($rs);
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
				$arreglo['data'] = 'Error al intentar grabar el art&iacute;culo';
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute; exitosamente el art&iacute;culo!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se guard&oacute; la informaci&oacute;n, favor de verificar el registro ya existe!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Actualiza el articulo del inventario
	function actualizarArticuloInventario($id_articulo,$articulo,$cantidad,$precio,$st3,$horas,$tContenido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No existe consecutivo");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_invent_update($id_articulo,'$articulo',$cantidad,'$precio',$st3,$horas,'$tContenido') AS retorno;");
			//print_r($rs);
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
				$arreglo['data'] = "";
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute; exitosamente el art&iacute;culo!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se guard&oacute; la informaci&oacute;n, favor de verificar el registro ya existe!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consulta de articulos
	function LlenarGridArticulos($esRenta){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			if ($esRenta == 0){
			$rs = $db->query("select * from fn_invent_select() ORDER BY id_articulo;");
			}else{
				$rs = $db->query("select * from fn_invent_select($esRenta::SMALLINT) ORDER BY id_articulo;");
			}
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .= "<tr id='row_'".$valor['id_articulo'].">";
					$opcion .= '<td  id="sku_'.$valor['id_articulo'].'">'.$valor['id_articulo'].'</td>';
					$opcion .= '<td  id="desc_'.$valor['id_articulo'].'">'.$valor['descripcion'].'</td>';
					$opcion .= '<td  id="cant_'.$valor['id_articulo'].'">'.$valor['cantidad'].'</td>';
					$opcion .= '<td  id="prec_'.$valor['id_articulo'].'">'.$valor['precio'].'</td>';
					$opcion .= '<td  id="flag_'.$valor['id_articulo'].'">'.(($valor['flag_especial'] == 0)?'</i>':'<i class="fa fa-check txt-color-gray hidden-md hidden-sm hidden-xs"><span id="palomitaEspecial_'.$valor['id_articulo'].'" style="display:none">Si</span></i>').'</td>';	
					$opcion .= '<td  id="hora_'.$valor['id_articulo'].'">'.$valor['horasrenta'].'</td>';
					$opcion .= '<td  id="contenido_'.$valor['desc_contenido'].'">'.$valor['desc_contenido'].'</td>';
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Combo de articulos Captura de pedido
	function articulosConsultarPorKeyx($bId_Articulo,$esRenta,$date,$vFoliopedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			if ($esRenta == 0){
			$rs = $db->query("select * from fn_invent_select($bId_Articulo:: BIGINT);");
			}else{
				if ($date == '' && $vFoliopedido <0){
					$rs = $db->query("select * from fn_inventrentado_select($bId_Articulo:: BIGINT,$esRenta::INTEGER);");
				}else{
					if ($vFoliopedido >0 ){
						$rs = $db->query("select * from fn_inventrentadopordia_select($bId_Articulo:: BIGINT,$esRenta::INTEGER,'$date'::DATE,$vFoliopedido);");
					}else{
						$rs = $db->query("select * from fn_inventrentadopordia_select($bId_Articulo:: BIGINT,$esRenta::INTEGER,'$date'::DATE);");
					}
				}
			}
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno[0];
					$arreglo['error'] = 'Se consult&oacute; exitosamente el art&iacute;culo!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No hay informaci&oacute;n del art&iacute;culo!.';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Registro de pedido modificado.
	function modificarpedidoGrabarPedido($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2,$empleado,$vManteleria,$flete,$iIva,$flag_descuento,$porcentajedescuento,$iGarantia){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$flag_entregamismodia = ($fechaentrega == $fecharecolecta) ? 1:0;
			$rs = $db->query("select * from fn_pedidosmodificados_insert($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,'$fechaentrega'::DATE,'$fecharecolecta'::DATE,$flag_entregamismodia,'$hora1','$hora2',1,$empleado,'$vManteleria',$flete,$iIva,$flag_descuento,$porcentajedescuento,$iGarantia) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "El pedido ya se encontraba registrado!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Borrar detalle de folio por modificacion.
	function modificarpedidoDetalleAnterior($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_articulosxmodificacion_delete($iFolioPedido) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "El pedido ya se encontraba registrado!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
				
	//Consulta de articulos
	function LlenarGridArticulosInventario($esRenta){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			if ($esRenta == 0){
			$rs = $db->query("select * from fn_invent_select() ORDER BY id_articulo;");
			}else{
				$rs = $db->query("select * from fn_invent_select($esRenta::SMALLINT) ORDER BY id_articulo;");
			}
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$name = str_replace(' ','_',$valor['descripcion']);
					$contenido = str_replace(' ','_',$valor['desc_contenido']);
					$NombreGrupo = str_replace(' ','_',$valor['nom_grupo']);
					$opcion .="<tr id='tabla_".$valor['id_articulo']."'><td id='row_".$valor['id_articulo']."'>";
					$opcion .="<a name='eliminar_".$valor['id_articulo']."' href='javascript:void(0);' id='smart-mod-eg1' onclick= 'MensajeSmartInventarioDelete(this.name)'; ><i class='fa fa-minus-square-o' rel='tooltip' data-placement='top' data-original-title='Eliminar'></i></a>&nbsp;";
					$opcion .="<a href='ajax/modal_inventario.php?sku=".$valor['id_articulo']."&name=".$name."&cant=".$valor['cantidad']."&prec=".$valor['precio']."&flag=".$valor['flag_especial']."&hr=".$valor['horasrenta']."&con=".$contenido."&gr=".$NombreGrupo."' data-toggle='modal' data-target='#remoteModal' id='editar_".$valor['id_articulo']."'>";
					$opcion .="<i class='fa fa-pencil-square-o' rel='tooltip' data-placement='top' data-original-title='Editar'></i>";
					$opcion .="</a></td>";
					$opcion .= '<td  id="sku_'.$valor['id_articulo'].'">'.$valor['id_articulo'].'</td>';
					$opcion .= '<td  id="desc_'.$valor['id_articulo'].'">'.$valor['descripcion'].'</td>';
					$opcion .= '<td  id="cant_'.$valor['id_articulo'].'">'.$valor['cantidad'].'</td>';
					$opcion .= '<td  id="prec_'.$valor['id_articulo'].'">'.$valor['precio'].'</td>';
					$opcion .= '<td  id="flag_'.$valor['id_articulo'].'">'.(($valor['flag_especial'] == 0)?'</i>':'<i class="fa fa-check txt-color-gray hidden-md hidden-sm hidden-xs"><span id="palomitaEspecial_'.$valor['id_articulo'].'" style="display:none">Si</span></i>').'</td>';	
					$opcion .= '<td  id="hora_'.$valor['id_articulo'].'">'.$valor['horasrenta'].'</td>';
					$opcion .= '<td  id="grupo_'.$valor['id_articulo'].'">'.$valor['nom_grupo'].'</td>';
					$opcion .= '<td  id="grupo_'.$valor['desc_contenido'].'">'.$valor['desc_contenido'].'</td>';
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Combo de articulos especial en captura de pedido
	function articulosEspecialConsultarPorKeyx($bId_Articulo,$vFecha){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			if ($vFecha == ''){
				$rs = $db->query("select * from fn_inventespecial_select($bId_Articulo:: BIGINT);");
			}else{
				$rs = $db->query("select * from fn_inventespecial_select($bId_Articulo:: BIGINT,'$vFecha'::DATE);");
			}
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = 'El art&iacute;culo se encuentra rentado, en los siguientes horarios:<br/>';
				foreach ($rs AS $valor) {
					$opcion .= $valor['horasrenta'].'<br/>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
		
	//Generar reporte de pedidos pendientes
	function generarReportePendidosPendientes($i,$paginaActual){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros","registro"=>0,"pagina"=>0);
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidospendientes_select() WHERE fechapedido::DATE < NOW()::DATE AND TRIM(detallepedido) != '' ORDER BY fechapedido DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
						$opcion .= '<tr><td style=" font-family:Arial;font-size: 16px;text-align:center;"><strong><br/>PEDIDOS DE D&Iacute;AS ANTERIORES</strong></td></tr>';
					}
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr id="'.$valor['foliopedido'].'" title="'.$valor['foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
					if($valor['descuento'] !== 1){
						if ($vTotal > $valor['abono']){
							if ($valor['abono'] > 0){
								$folioConsulta = $valor['foliopedido'];
								$vRecibio = '';
								$vRecibio = quienAbonoXFolio($folioConsulta);
								$vRecibio = $vRecibio['data'];
								if ($vRecibio != ''){
									$vRecibio = ' POR:'.$vRecibio;
								}
								$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
							}else{
								$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
							}
						}else{
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}	
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
						}
						
					}else{
						$opcion .= 'TOTAL:&nbsp;$NO COBRAR';
					}
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['foliopedido'].'" style="display:none"><div class="btn-group-vertical"><a id="actualizapedido" title="Modifica el pedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
					$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div></td>';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					//$opcion .= 'row'.$i;
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de pedidos pendientes de cobro solamente
	function generarReportePedidosPorCobrar(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			//$rs = $db->query("select * from fn_pedidospendientes_select() WHERE fechapedido::DATE <= NOW()::DATE AND (total > abono OR foliopedido NOT IN (SELECT foliopedido FROM ctl_cortegarantias) AND garantia > 0)  ORDER BY fechapedido,region DESC;");
			$rs = $db->query("select * from fn_pedidospendientescobro_select() WHERE fechapedido::DATE <= NOW()::DATE ORDER BY fechapedido DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
						//$opcion .= '<tr><td style=" font-family:Arial;font-size: 16px;text-align:center;"><strong><br/>PEDIDOS DE D&Iacute;AS ANTERIORES</strong></td></tr>';
					}
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr id="'.$valor['foliopedido'].'" title="'.$valor['foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
					//if($valor['descuento'] !== 1){
					if ($vTotal > $valor['abono']){
						if ($valor['abono'] > 0){
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
						}else{
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
						}
					}else{
						$folioConsulta = $valor['foliopedido'];
						$vRecibio = '';
						$vRecibio = quienAbonoXFolio($folioConsulta);
						$vRecibio = $vRecibio['data'];
						if ($vRecibio != ''){
							$vRecibio = ' POR:'.$vRecibio;
						}	
						$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
					}
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" name="controles"	id="controles_'.$valor['foliopedido'].'" style="display:none"><div class="btn-group-vertical"><a id="actualizapedido" title="Modifica el pedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
					$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div></td>';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					//$opcion .= 'row'.$i;
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/><br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}


	
	//Generar reporte de pedidos pendientes
	function generarReportePendidosPendientesDelDia($i,$paginaActual){

		$fecha = obtenerfechaactual();										 
		//echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1];
		
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros","registro"=>0,"pagina"=>0);
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidospendientes_select() WHERE fechapedido::DATE = NOW()::DATE AND TRIM(detallepedido) != '' ORDER BY fechapedido,region DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					if ($i == 0){
						$opcion .= '<div class="table-responsive"></tr>';
						$opcion .= '<tr><td style="font-family:Arial;font-size: 16px;text-align:center;"><strong>PEDIDOS DEL D&Iacute;A '.$fecha.' </strong></td></tr>';
					}
					$i++;
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					/* Modificacion solicitada */
					/*
					$opcion .= '<tr><td><table border="0" cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;font-size: 12px;margin: 0px;padding:0;"><tr>';
					$opcion .= '<td name="detalle"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >.TOTAL:&nbsp;$<label id="importe_total">'.$valor['total'].'</label></span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label>';
					$opcion .= '&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$valor['colonia'].'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'</td>';
					$opcion .= '<td class="text-right" width="120px"><span style="font-size: 14px;">&nbsp;<strong>FOLIO:</strong>&nbsp;<label id="folio">'.$valor['foliopedido'].'</label></span><!--<br><i class="fa fa-calendar"></i>&nbsp;<strong>Fecha:&nbsp;</strong><label id="fechapedido">'.$valor['fechapedido'].'</label>--></td></tr>';
					$opcion .= '<hr style="margin: 0px;padding:0;"></table></td></tr>';
					* /

					/* 2da Modificacion solicitada * /
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr id="'.$valor['foliopedido'].'" title="'.$valor['foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
					//$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label></span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label>';
					if($valor['descuento'] !== 1){
						if ($vTotal > $valor['abono']){
							if ($valor['abono'] > 0){
								$folioConsulta = $valor['foliopedido'];
								$vRecibio = '';
								$vRecibio = quienAbonoXFolio($folioConsulta);
								$vRecibio = $vRecibio['data'];
								if ($vRecibio != ''){
									$vRecibio = ' POR:'.$vRecibio;
								}							
								$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
							}else{
								$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
							}
						}else{
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}	
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
						}
					}else{
						$opcion .= 'TOTAL:&nbsp;$NO COBRAR';
					}
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					
					if($valor['empleado'] != ''){
						$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['foliopedido'].'" style="display:none"><div class="btn-group-vertical"><a id="actualizapedido" title="Modifica el pedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
					$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div></td>';
					$opcion .= '</tr>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"/></table></td></tr></div>';
					//$opcion .= "row :".$i ;
					if($i == 19){
						$i = 0;
						$opcion .= '<br/><br/>';
					}

				}
				$opcion .= '</tr>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Generar reporte de pedidos pendientes
	function generarReportePendidosPendientesPorFecha($Fecha){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidospendientes_select() WHERE fechapedido::DATE = '$Fecha'::DATE ORDER BY region DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					/* Modificacion solicitada * /
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr>';
					$opcion .= '<td><table class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr><td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label>';
					$opcion .= '&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'</td>';
					$opcion .= '<td class="text-right" width="150px"><span style="font-size: 14px;">&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label></span><br><i class="fa fa-calendar"></i>&nbsp;|&nbsp;Fecha:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table></td></tr>';

					
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Consultar un pedidos pendiente
	function consultarUnPedidosPendiente($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidospendientes_select() WHERE foliopedido = $iFolioPedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno[0];
					$arreglo['error'] = 'Se consult&oacute exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "El pedido no se encuentra registrado o con estatus pendiente!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Consultar reporte de un pedidos pendiente
	function consultarArticulosUnPedidosPendiente($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_articulospedidos_select($iFolioPedido);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .="<tr id='tabla_".$valor['id_articulo']."'>";
					$opcion .= '<td  id="sku_'.$valor['id_articulo'].'">'.$valor['id_articulo'].'</td>';
					$opcion .= '<td  id="desc_'.$valor['id_articulo'].'">'.$valor['descripcion'].'</td>';
					$opcion .= '<td  id="cant_'.$valor['id_articulo'].'">'.$valor['cantidad'].'</td>';
					$opcion .= '<td  id="prec_'.$valor['id_articulo'].'">'.$valor['precio'].'</td>';
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consultar reporte de un pedidos pendiente
	function ArticulosUnPedidosPendienteFolio($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_articulospedidos_select($iFolioPedido);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se consulto el folio exitosamente!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No hay inventario para ese folio!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar modal de pedido pendiente
	function generaModalUnPedidosPendienteARecibir($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidospendientes_select() WHERE foliopedido = $iFolioPedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					//$opcion .= '<tr><td>'.$valor['region'].'</td><td><table style="width:100%;"><tr><td name="nombre"><label id="nombre" class="semi-bold">'.$valor['nombrecte'].'</label></td>';
					/*
					$opcion .= '<tr><td><table style="width:100%;"><tr><td name="nombre"><label id="nombre" class="semi-bold">'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label></td>';
					$opcion .= '<td class="text-right" width="200px"><h1 class="font-300">FOLIO:&nbsp;<label id="foliomodal">'.$valor['foliopedido'].'</label></h1></td></tr></td></tr>';
					$opcion .= '<tr><td name="domicilio"><label id="calle"><strong>'.$valor['calle'].'</strong></label>,&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label><br>';
					$opcion .= '<label id="colonia"><strong>'.$valor['colonia'].'</strong></label>,&nbsp;CP. <label id="cp">'.$valor['codigopostal'].'</label><br><label id="ciudad">'.$valor['ciudad'].'</label>,&nbsp;<label id="estado">'.$valor['estado'].'</label></td></tr>';
					$opcion .= '<tr><td name="telefono"><strong> </strong><label id="ciudad">'.$valor['telefonocasa'].'/'.$valor['telefonocelular'].'</label>&nbsp;</td><td name="fecha" width="200px"><i class="fa fa-calendar"></i><strong>Fecha:&nbsp;';
					$opcion .= '</strong><label id="importe_abono">'.$valor['fechapedido'].'</label></td></tr>';
					$opcion .= '<tr><td name="referencias"><strong>Referencias:&nbsp;</strong><label id="referencias">'.$valor['referencias'].'</label>&nbsp;';
					$opcion .= '</td><td name ="abono" width="200px"><i class="fa fa-money"></i><strong>ABONO:</strong>&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label></td></tr>';
					$opcion .= '<tr><td name="detalle"><h5 class="semi-bold"></h5><label id="detalle">'.$valor['detallepedido'].'</label></td>';
					$opcion .= '<td name="total" class="text-center" width="200px"><div class="well well-sm  bg-color-darken txt-color-white no-border"><div class="fa-lg">TOTAL:&nbsp;$<label id="importe_total">'.$valor['total'].'</label></div></div></td></tr>';
					$opcion .= '</table><hr></td></tr>';
					* /
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = '<i class="fa"></i>&nbsp;Dep&oacute;sito:&nbsp;$<label id="importe_abono">&nbsp;'.$vDeposito.'</label></br>';
					else
						$vDeposito = '';
					
					$opcion .='<tr>
						<td name="nombre" width="80%">
							<label id="nombre" class="semi-bold">'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>
						</td>';
					$opcion .='<td class="text-right" width="20%"><h2>FOLIO:&nbsp;<label id="foliomodal">'.$valor['foliopedido'].'</label></h2>
						</td>
					</tr>';  
					$opcion .='<tr>
						<td name="domicilio">
							<label id="calle">'.$valor['calle'].'</label>,&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>
							<br>';
					$opcion .='<label id="colonia"><strong>'.$vColonia.'</strong></label>,&nbsp;CP. <label id="cp">'.$valor['codigopostal'].'</label><br><label id="ciudad">'.$valor['ciudad'].'</label>,&nbsp;<label id="estado">'.$valor['estado'].'</label></td></tr>';
					$opcion .='<tr>
						<td name="telefono">
							 <label id="ciudad">'.$valor['telefonocasa'].'/'.$valor['telefonocelular'].'</label>&nbsp;
						</td>
						<td name="fecha" class="text-right"><i class="fa fa-calendar"></i><strong>&nbsp;Fecha:&nbsp;';
							$opcion .= '</strong><label id="fecha_pedido">&nbsp;'.$valor['fechapedido'].'</label>
						</td>
					</tr>';
					$opcion .='<tr>
						<td name="referencias">
							 Observaciones:&nbsp;</strong><label id="referencias">'.$valor['referencias'].'</label>&nbsp;</td>';
						
					$opcion .='<td name ="abono" class="text-right">
							'.$vDeposito.'
							<i class="fa fa-minus"></i>&nbsp;Abono:&nbsp;$<label id="importe_deposito">&nbsp;'.$valor['abono'].'</label>
							</br>
							<i class="fa fa-plus"></i>&nbsp;Total:&nbsp;$<label id="importe_subtotal">&nbsp;'.$vTotal.'</label>
						</td>
					</tr>';
					$opcion .='<tr>
						<td name="detalle">
							<h5 class="semi-bold"></h5><label id="detalle">'.$valor['detallepedido'].'</label>
						</td>';
					$opcion .='<td name="total" class="text-center">
							<div class="well well-sm  bg-color-darken txt-color-white no-border">&nbsp;Total a pagar:&nbsp;$&nbsp;<label id="importe_total">'.(($valor['total'])-($valor['abono'])).'</label></div>
						</td>
					</tr>';


				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Traspasar articulos a historial y regresar  inventario.
	function regresarArticulosAInventarioFolio($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_articulospedidoshist_insert($iFolioPedido) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno[0];
					$arreglo['error'] = 'Se liber&oacute; el inventario para el folio!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No hay inventario para liberar!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Realizar abono a un pedido.
	function abonarAUnFolio($iFolioPedido,$iMonto,$vRecibio,$iEmpleado){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_abonospagos_insert($iFolioPedido,$iMonto,'$vRecibio',$iEmpleado) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 0){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se abon&oacute; exitosamente al pedido!.';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consultar reporte de un pedidos pendiente
	function consultarArticulosParcialesUnPedidosPendiente($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_articulospedidos_select($iFolioPedido);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .="<tr id='tabla_".$valor['id_articulo']."'>";
					$opcion .= '<td  id="sku_'.$valor['id_articulo'].'">'.$valor['id_articulo'].'</td>';
					$opcion .= '<td  id="desc_'.$valor['id_articulo'].'">'.$valor['descripcion'].'</td>';
					$opcion .= '<td  id="cant_'.$valor['id_articulo'].'">'.$valor['cantidad'].'</td>';
					$opcion .= '<td  id="prec_'.$valor['id_articulo'].'">'.$valor['precio'].'</td>';
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consultar reporte de un pedidos pendiente
	function consultarArticulosParcialesUnPedidosPendienteModal($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_articulospedidos_select($iFolioPedido);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				$i = 1;
				foreach ($rs AS $valor) {
					$opcion .="<tr id='tabla_".$valor['id_articulo']."'>";
					$opcion .= '<td><label id="skumodal_'.$i.'">'.$valor['id_articulo'].'</label></td>';
					$opcion .= '<td  id="descmodal_'.$i.'">'.$valor['descripcion'].'</td>';
					$opcion .= '<td  id="cantmodal_'.$i.'">'.$valor['cantidad'].'</td>';
					$opcion .= '<td class="text-center"><input class="form-control input-md"  type="number" id="recibirmodal_'.$i.'" value="'.$valor['cantidad'].'" max="'.$valor['cantidad'].'" min="0" onkeyup="return isCorrectNumber(event,this)" onblur="return validarInt(this)"></td>';
					$opcion .= "</tr>";
					$i++;
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Devuelve el articulo de un folio al inventario.
	function devolverArticuloaInventario($vFoliopedido,$vId_articulo,$vCantidad){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_unarticulopedidohist_insert($vFoliopedido,$vId_articulo,$vCantidad) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se actualiz&oacute; exitosamente la informaci&oacute;n de la zona y colonia!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "La zona no se encuentra registrada o bien ocurrio un problema al actualizar!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Obtener importe de pedido.
	function obtenerImportePedido($vFoliopedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_importepedido_select($vFoliopedido) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se actualiz&oacute; exitosamente la informaci&oacute;n de la zona y colonia!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "La zona no se encuentra registrada o bien ocurrio un problema al actualizar!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de todos los pedidos
	function generarReporteTodosLosPedidos($fechaMes,$fechaAnio){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidostodos_select() WHERE estatuspedido !=99 AND extract(month from fechapedido) IN (".
							  $fechaMes.") AND extract(YEAR from fechapedido) IN (".$fechaAnio.") ORDER BY fechapedido,foliopedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
				
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					if ($i == 0){
						$opcion .= '<tr><td style=" font-family:Arial;font-size: 16px;text-align:left;"><strong><br/>PEDIDOS DEL MES '. $meses[$fechaMes-1].'</strong></td></tr>';
						$i++;
					}					
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
				
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label>';
					$opcion .= '&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					//$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td></tr>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" name="controles"	id="controles_'.$valor['foliopedido'].'" style="display:block">';
					//$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					//$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div></td>';
					$opcion .= '</tr>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table></td></tr>';
				}
				
			if ($i == 0){
					$arreglo['error'] = 'No se encontr&oacute; informaci&oacute;n de la consulta!.';
				}else{
					$arreglo['error'] = '';
				}
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Generar reporte de todos los pedidos
	function generarReportePedidosPorEmpleadoFecha($iEmpleado,$dFecha1,$dFecha2){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			//$rs = $db->query("select * from fn_pedidosporempleado_select($iEmpleado) WHERE estatuspedido = 4 AND (fechapedido::DATE BETWEEN '$dFecha1'::DATE AND '$dFecha2'::DATE OR foliopedido IN (SELECT foliopedido FROM ctl_abonospagos WHERE fechaabono::DATE BETWEEN '$dFecha1'::DATE AND '$dFecha2'::DATE)) ORDER BY fechapedido,foliopedido;");
			$rs = $db->query("select * from fn_pedidosporempleado_select($iEmpleado) AS ped WHERE ped.estatuspedido = 4 AND EXISTS(SELECT 1 FROM ctl_abonospagos AS pago WHERE pago.foliopedido = ped.foliopedido  AND pago.fechaabono::DATE BETWEEN '$dFecha1'::DATE AND '$dFecha2'::DATE ) ORDER BY fechapedido,foliopedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					if ($i == 0){
						if($valor['empleado'] != ''){
							//$opcion .= '<tr><td style=" font-family:Arial;font-size: 16px;text-align:center;"><strong>'.$valor['empleado'].'</strong></td></tr>';
						}
						$dataEmployed = totalesEmpleadoPorPeriodoEncabezado($iEmpleado,$dFecha1,$dFecha2);
						$opcion .= '<tr><td style=" font-family:Arial;font-size: 16px;text-align:center;"><strong>PEDIDOS DE D&Iacute;AS '.$dFecha1. ' al '.$dFecha2.'</strong></td></tr>';
						$opcion .= $dataEmployed['data'];
						$i++;
					}
					
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
				
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr>';
					
					if ($vTotal < $valor['abono']){
						$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label>';
						$opcion .= '&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
					}else{
						$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO&nbsp;';
					}
					
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td></tr>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table></td></tr>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Total de pedidos por empleado en periodo.
	function totalesEmpleadoPorPeriodo($iEmpleado,$dFecha1,$dFecha2){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select ped.empleado,SUM(total) AS ntotal ,COUNT(1) AS npedidos from fn_pedidosporempleado_select($iEmpleado) AS ped WHERE ped.estatuspedido = 4 AND EXISTS(SELECT 1 FROM ctl_abonospagos AS pago WHERE pago.foliopedido = ped.foliopedido  AND pago.fechaabono::DATE BETWEEN '$dFecha1'::DATE AND '$dFecha2'::DATE ) GROUP BY ped.empleado ;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				foreach ($rs AS $valor) {
					$opcion = '<tr><td>'.$valor['empleado'].'</td> ';
					$opcion .= '<td>'.$valor['npedidos'].'</td>';
					$opcion .= '<td>$'.$valor['ntotal'].'</td></tr>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Total de pedidos para el encabezado entre un periodo.
	function totalesEmpleadoPorPeriodoEncabezado($iEmpleado,$dFecha1,$dFecha2){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query(	"select ped.empleado,SUM(total) AS ntotal ,COUNT(1) AS npedidos from fn_pedidosporempleado_select($iEmpleado) AS ped WHERE ped.estatuspedido = 4 AND EXISTS(SELECT 1 FROM ctl_abonospagos AS pago WHERE pago.foliopedido = ped.foliopedido  AND pago.fechaabono::DATE BETWEEN '$dFecha1'::DATE AND '$dFecha2'::DATE ) GROUP BY ped.empleado;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				foreach ($rs AS $valor) {
					$opcion = '<td style=" font-family:Arial;font-size: 16px;text-align:center;"><label id = "lblempleado">EMPLEADO: '.$valor['empleado'].'</label>&nbsp;';
					$opcion .= '<label id = "lblnpedidos"> PEDIDOS: '.$valor['npedidos'].'</label>&nbsp;';
					$opcion .= '<label id = "lblntotal"> TOTAL: $'.$valor['ntotal'].'</label></td>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de todos los pedidos
	function generarReporteAbonosXFolio($Folio){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_abonospagosdetalle_select($Folio) ORDER BY fechaabono ASC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				// Poner lo nuevo de abonos
				$i = 0;
				$opcion = '';
				$monto = 0;
				foreach ($rs AS $valor) {
					$i++;
					$opcion .= '<tr><td>'.$i.'</td>';
					$opcion .= '<td>'.$valor['fechaabono'].'</td>';
					$opcion .= '<td>$'.$valor['monto'].'</td>';
					$opcion .= '<td>'.$valor['usuario'].'</td>';
					$opcion .= '<td>'.$valor['recibio'].'</td>';
					$opcion .= '<td><a href="#ajax/reimprimir_notaabono.php?n='.$valor['monto'].'&f='.$valor['foliopedido'].'&i='.$monto.'">Ver abono</a></td></tr>';
					$monto = $monto + $valor['monto'];
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Saber quien dio abonos.
	function quienAbonoXFolio($Folio){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select recibio,sum(monto)as monto from fn_abonospagosdetalle_select(".$Folio.") GROUP BY recibio;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$row_count = $rs->rowCount();
				// Poner lo nuevo de abonos
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					$i++;
					if ($row_count < 2) {
						if ($valor['recibio'] !=''){
							$opcion .= ' '.$valor['recibio'].',';
						}
					}else{
						if ($valor['recibio'] !=''){
							$opcion .= ' '.$valor['recibio'].' $'.$valor['monto'].',';
						}
					}
				}
				$opcion = substr($opcion,0,-1);
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	function AniadirNotaAccesorios($iFolioPedido,$vNota){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosnota_update($iFolioPedido,'$vNota') AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($rs_final != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se actualiz&oacute; la informaci&oacute;n de la variable!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se actualiz&oacute; la informaci&oacute;n de la variable!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	function ConsultarNotaAccesorios($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosnota_select($iFolioPedido) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($rs_final != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se actualiz&oacute; la informaci&oacute;n de la variable!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se actualiz&oacute; la informaci&oacute;n de la variable!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de abonos para corte
	function abonosPagosResumeDetalleEmpleados(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_abonospagosresumedetalleempleados_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					if ($i == 0){
						//$opcion .= '<tr style="font-family:Arial;font-size:11px;"><td>HOLA</td></tr>';
					}
					$i++;
					$iEmpleado = $valor['empleado'];
					$restDia = reportePedidosDepositosAlDia($iEmpleado);
					$restDia =$restDia['data'];
					$restRecibidoDia = reportePedidosDepositosRecibidosAlDia($iEmpleado);
					$restRecibidoDia =$restRecibidoDia['data'];
					if ($valor['monto'] == 0 && $restRecibidoDia['monto'] == 0  && $restDia['monto'] == 0){
						CONTINUE;
					}
					$opcion .= '<tr style="font-family:Arial;font-size:11px;margin-left:2px;">';
					$opcion .= '<td><label id="nom_empleado">'.strtoupper($valor['nom_empleado']).'</label></td>';
					$opcion .= '<td><label id="numeroabonos">'.$valor['numeroabonos'].'</label></td>';
					$opcion .= '<td><label id="monto">$'.$valor['monto'].'</label></td>';
					$opcion .= '<td style="font-family:Arial;font-size:9px;"><label id="folios">'.$valor['folios'].'</label></td>';
					$diferencia = ($valor['monto'] + $restRecibidoDia['monto'] ) - $restDia['monto'];
					//print_r($diferencia);
					$opcion .= '<td><label id="DepositosRecibidos">$'.$restRecibidoDia['monto'].'</label></td>';
					$opcion .= '<td><label id="devolucionDepositos">$'.$restDia['monto'].'</label></td>';
					$opcion .= '<td style="font-family:Arial;font-size:9px;"><label id="folioDeposito">'.$restDia['folios'].'</label></td>';
					$opcion .= '<td><label id="ImporteDiferencia">$'.$diferencia.'</label></td>';
					$opcion .= '<hr id="holamundo" style="margin:0px 0px 0px 0px;padding:0px;">';
					$opcion .= '</tr>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Generar corte de abonos
	function generarCortedeAbonos(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_abonospagosgenerarcorte_update() AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el corte de los abonos, es necesario el imprimir!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten del corte de abonos!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Generar reporte de anticipos para corte
	function reportePedidosAnticiposGarantias(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosanticiposgarantias_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .= '<tr style="font-family:Arial;font-size:11px;">';
					$opcion .= '<td><label id="nom_empleado">'.$valor['nom_empleado'].'</label></td>';
					$opcion .= '<td><label id="monto">$'.$valor['monto'].'</label></td>';
					$opcion .= '<td style="font-family:Arial;font-size:8px;"><label id="folios">'.$valor['folios'].'</label></td>';
					$opcion .= '</tr>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Generar reporte de depositos
	function reportePedidosDepositosAlDia($iEmpleado){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosdepositodevueltos_select() WHERE empleado = $iEmpleado;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				//print_r($rs_final);
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno[0];
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el corte de los abonos, es necesario el imprimir!.';
				}else{
					$sRetorno = array("monto"=>0,"empleado"=>$iEmpleado,""=>"","nom_empleado"=>"","folios"=>"");
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten del corte de abonos!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de depositos
	function reportePedidosDepositosRecibidosAlDia($iEmpleado){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_depositosresumedetalleempleados_select($iEmpleado);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				//print_r($rs_final);
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno[0];
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el corte de los abonos, es necesario el imprimir!.';
				}else{
					$sRetorno = array("monto"=>0,"empleado"=>$iEmpleado,""=>"","nom_empleado"=>"","folios"=>"");
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten del corte de abonos!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Generar corte de abonos
	function generarCortedeAnticipos($iEmpleado){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosanticiposgarantiascorte_insert($iEmpleado) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el corte de los anticipos!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten del corte de anticipos!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Generar reporte de pedidos borrados
	function generarReportePedidosBorrados(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidostodos_select() WHERE estatuspedido =99 AND foliopedido NOT IN (SELECT foliopedido FROM ctl_descartarborrados) ORDER BY fechapedido,region DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
				
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					$opcion .= '<tr id=row_'.$valor['foliopedido'].'><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;">';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';

					if ($vTotal > $valor['abono']){
						if ($valor['abono'] > 0){
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
						}else{
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
						}
					}else{
						$folioConsulta = $valor['foliopedido'];
						$vRecibio = '';
						$vRecibio = quienAbonoXFolio($folioConsulta);
						$vRecibio = $vRecibio['data'];
						if ($vRecibio != ''){
							$vRecibio = ' POR:'.$vRecibio;
						}	
						$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
					}						
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table></td></tr>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de pedidos borrados para administrador
	function generarReportePedidosBorradosAdmin(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidostodos_select() WHERE estatuspedido =99 AND foliopedido NOT IN (SELECT foliopedido FROM ctl_descartarborrados) ORDER BY fechapedido,region DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
				
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					$opcion .= '<tr id=row_'.$valor['foliopedido'].'><td class="noMostrarPrint"><input id=check_'.$valor['foliopedido'].' type="checkbox" class="selPA" value="area1" checked/></td><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';

					if ($vTotal > $valor['abono']){
						if ($valor['abono'] > 0){
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
						}else{
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
						}
					}else{
						$folioConsulta = $valor['foliopedido'];
						$vRecibio = '';
						$vRecibio = quienAbonoXFolio($folioConsulta);
						$vRecibio = $vRecibio['data'];
						if ($vRecibio != ''){
							$vRecibio = ' POR:'.$vRecibio;
						}	
						$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
					}						
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical"><button type="button" title="Restaurar" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartRestaurar('.$valor['foliopedido'].');"><i class="fa fa-refresh">&nbsp;</i>Restaurar</button></div></td>';
					$opcion .= '</tr>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table></td></tr>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Descartar pedidos borrados 
	function descartarBorrado($iFolioPedido,$iEmpleado){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosdescartaborrado_insert($iFolioPedido,$iEmpleado) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el descarte de los pedidos borrados!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten de los pedidos borrados!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Descartar pedidos modificados 
	function descartarModificado($iFolioPedido,$iEmpleado){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosdescartamodificado_delete($iFolioPedido,$iEmpleado) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] = 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el descarte de los pedidos modificado!.';
				}else if ($sRetorno['retorno'] > 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se encontr&oacute; el registro del pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten de los pedidos modificado!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Generar Cotizacion
	function consultarCotizacionFecha($Fecha){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cotizacion_select() WHERE fechapedido::DATE = '$Fecha'::DATE ORDER BY fechapedido,region DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr id="'.$valor['foliopedido'].'" title="'.$valor['foliopedido'].'">';
					$opcion .= '<td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr><td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label>';
					$opcion .= '&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO COTIZACI&Oacute;N:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['foliopedido'].'" style="display:none"><div class="btn-group-vertical"><a id="actualizacotizacion" title="Modificar la cotizaci&oacute;n" href="#ajax/modificar_cotizacion.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
					$opcion .= '<button type="button" title="Borra el Cotizaci&oacute;n" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModCotizaciones('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modificar_pedido.php?fc='.$valor['foliopedido'].'" title="Convierte la cotizaci&oacute;n a pedido" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Convertir</a></div></td>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table></td></tr>';

   				
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//obtiene el folio de la cotizacion.
	function obtenerFolioCotizacion(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No existe consecutivo");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_cotizacionfolio_select() AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				
				$arreglo['success'] = true;
				$arreglo['data'] = $sRetorno;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Captura de registro de la cotizacion del cliente.
	function cotizacionGrabarCliente($vNombres,$vApellidos,$vTelefonoCasa,$vTelefonoCelular){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cte_insert('$vNombres','$vApellidos','$vTelefonoCasa','$vTelefonoCelular') AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente al cliente!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "El cliente ya se encontraba registrado!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Registro de articulos grabados a cotizaciones.
	function cotizacionGrabarArticulo($iFolioPedido,$iId_articulo,$iCantidad,$vHorarioRenta,$esRenta){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			if($esRenta == 0){
			$rs = $db->query("select * from fn_articuloscotizacion_insert($iFolioPedido::BIGINT,$iId_articulo::BIGINT,$iCantidad::INTEGER,'$vHorarioRenta') AS retorno;");
			}else{
				$rs = $db->query("select * from fn_articuloscotizacionrentado_insert($iFolioPedido::BIGINT,$iId_articulo::BIGINT,$iCantidad::INTEGER,'$vHorarioRenta',$esRenta::INTEGER) AS retorno;");
			}
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente el sku!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "El sku ya se encontraba registrado!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Registro de articulos del pedido del cliente.
	function cotizacionGrabarPedido($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2,$empleado,$vManteleria,$flete,$iIva,$flag_descuento,$porcentajedescuento,$iGarantia){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$flag_entregamismodia = ($fechaentrega == $fecharecolecta) ? 1:0;
			$rs = $db->query("select * from fn_cotizacion_insert($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,'$fechaentrega'::DATE,'$fecharecolecta'::DATE,$flag_entregamismodia,'$hora1','$hora2',1,$empleado,'$vManteleria',$flete,$iIva,$flag_descuento,$porcentajedescuento,$iGarantia) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "El pedido ya se encontraba registrado!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Elimina el folio de una cotizacion.
	function borrarCotizacion($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cotizacion_delete($iFolioPedido::BIGINT) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se elimin&oacute; exitosamente el cotizaci&oacute;n!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No fue posible eliminar el cotizaci&oacute;n!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consultar una cotizacion a enviar por email
	function consultarUnaCotizacionparaEmail($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cotizacionpendientes_select($iFolioPedido);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se consult&oacute exitosamente la cotizaci&oacute;n!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "La cotizaci&oacute;n no se encuentra registrado o con estatus pendiente!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	//Consultar un pedido a enviar por email
	function consultarUnPedidoparaEmail($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidospendientes_select() WHERE foliopedido = $iFolioPedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se consult&oacute exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "La pedido no se encuentra registrado o con estatus pendiente!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consultar los articulos de una cotizacion.
	function consultarArticulosUnaCotizacion($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_articuloscotizacion_select($iFolioPedido);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .="<tr id='tabla_".$valor['id_articulo']."'>";
					$opcion .= '<td  id="sku_'.$valor['id_articulo'].'">'.$valor['id_articulo'].'</td>';
					$opcion .= '<td  id="desc_'.$valor['id_articulo'].'">'.$valor['descripcion'].'</td>';
					$opcion .= '<td  id="cant_'.$valor['id_articulo'].'">'.$valor['cantidad'].'</td>';
					$opcion .= '<td  id="prec_'.$valor['id_articulo'].'">'.$valor['precio'].'</td>';
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consultar articulos de una cotizacion
	function ArticulosUnaCotizacion($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_articuloscotizacion_select($iFolioPedido);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se consulto el folio exitosamente!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No hay inventario para ese folio!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Borrar detalle de la cotizacion por modificacion.
	function modificarCotizacionDetalleAnterior($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_articulosxmodificacioncotizacion_delete($iFolioPedido) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "El pedido ya se encontraba registrado!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Registro de cotizacion modificada.
	function modificarCotizacionGrabarCotizacion($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2,$empleado,$vManteleria,$flete,$iIva,$flag_descuento,$porcentajedescuento,$iGarantia){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$flag_entregamismodia = ($fechaentrega == $fecharecolecta) ? 1:0;
			$rs = $db->query("select * from fn_cotizacionmodificados_insert($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,'$fechaentrega'::DATE,'$fecharecolecta'::DATE,$flag_entregamismodia,'$hora1','$hora2',1,$empleado,'$vManteleria',$flete,$iIva,$flag_descuento,$porcentajedescuento,$iGarantia) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					//$arreglo['error'] = "El pedido ya se encontraba registrado!.";
					$arreglo['error'] = "select * from fn_cotizacionmodificados_insert($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,'$fechaentrega'::DATE,'$fecharecolecta'::DATE,$flag_entregamismodia,'$hora1','$hora2',1,$empleado,'$vManteleria',$flete,$iIva,$flag_descuento,$porcentajedescuento,$iGarantia) AS retorno;";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Finaliza el folio de una cotizacion.
	function actualizaCotizacion($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cotizacion_update($iFolioPedido::BIGINT,4) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se actualiz&oacute; exitosamente la cotizaci&oacute;n!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No fue posible actualizar la cotizaci&oacute;n!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Elimina el articulo siempre y cuando no este asignado a un pedido, mayor o igual a la fecha.
	function deleteInventarioArticulo($bId_Articulo){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_invent_delete($bId_Articulo:: BIGINT) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se elimin&oacute; exitosamente del inventario!.';
				}else if ($sRetorno['retorno'] == 2){
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'El art&iacute;culo se encuentra asignado a un folio, favor de verificar!';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se elimin&oacute; la informaci&oacute;n, favor de verificar!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Devuelve el anticipo al cliente.
	function devolverDeposito($iFolioPedido,$iAbono,$vEmpleado){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosdepositodevueltos_insert($iFolioPedido,$iAbono,$vEmpleado) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se devolvio el dep&oacute;sito exitosamente!.';
				}else if ($sRetorno['retorno'] == 2){
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se encontr&oacute; informaci&oacute;n del dep&oacute;sito o bien ya fue recibido, favor de verificar!';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se logr&oacute; devolver el dep&oacute;sito, favor de verificar!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Generar reporte de pedidos modificados para administrador
	function generarReportePedidosModificadosAdmin(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidostodosmodificados_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
				
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					$opcion .= '<tr id=row_'.$valor['foliopedido'].'><td class="noMostrarPrint"><input id=check-'.$valor['foliopedido'].'-'. $valor['secuenciamodificacion'] .' type="checkbox" class="selPA" value="area1" checked/></td><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';

					if ($vTotal > $valor['abono']){
						if ($valor['abono'] > 0){
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
						}else{
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
						}
					}else{
						$folioConsulta = $valor['foliopedido'];
						$vRecibio = '';
						$vRecibio = quienAbonoXFolio($folioConsulta);
						$vRecibio = $vRecibio['data'];
						if ($vRecibio != ''){
							$vRecibio = ' POR:'.$vRecibio;
						}	
						$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
					}						
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					//$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>';
					}
					$opcion .= '&nbsp;|&nbsp;SECUENCIA:&nbsp;<label id="secuenciamodificacion">'.$valor['secuenciamodificacion'].'</label></td></tr>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table></td></tr>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Generar reporte de pedidos borrados
	function generarReportePedidosModificados(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidostodosmodificados_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
				
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					$opcion .= '<tr id=row_'.$valor['foliopedido'].'><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;">';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';

					if ($vTotal > $valor['abono']){
						if ($valor['abono'] > 0){
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
						}else{
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
						}
					}else{
						$folioConsulta = $valor['foliopedido'];
						$vRecibio = '';
						$vRecibio = quienAbonoXFolio($folioConsulta);
						$vRecibio = $vRecibio['data'];
						if ($vRecibio != ''){
							$vRecibio = ' POR:'.$vRecibio;
						}	
						$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
					}						
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					//$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>';
					}
					$opcion .= '&nbsp;|&nbsp;SECUENCIA:&nbsp;<label id="secuenciamodificacion">'.$valor['secuenciamodificacion'].'</label></td>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table></td></tr>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Elimina el folio de un pedido.
	function RestaurarPedidoBorrado($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosdevolverborrado_update($iFolioPedido::BIGINT,3) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se Regres&oacute; exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No fue posible regresar el pedido!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consulta grupos de inventario.
	function LlenarGridGrupoInventario(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cat_grupoinventario_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$zonaName = str_replace(' ','%',$valor['nombregrupo']);
					$descRegion = str_replace(' ','%',$valor['descgrupo']);
					$opcion .="<tr id='tabla_".$valor['id_grupo']."'><td id='row_".$valor['id_grupo']."'>";
					$opcion .="<a name='eliminar_".$valor['id_grupo']."' href='javascript:void(0);' id='smart-mod-eg1' onclick= 'MensajeSmartGrupoInventario(".$valor['id_grupo'].",2)'; ><i class='fa fa-minus-square-o' rel='tooltip' data-placement='top' data-original-title='Eliminar'></i></a>&nbsp;";
					$opcion .="<a href=ajax/modal_administracion_grupoinventario.php?region=".$valor['id_grupo']."&nombreregion=".$zonaName."&descregion=".$descRegion." data-toggle='modal' data-target='#remoteModal' id='editar_".$valor['id_grupo']."'>";
					$opcion .="<i class='fa fa-pencil-square-o' rel='tooltip' data-placement='top' data-original-title='Editar'></i>";
					$opcion .="</a></td>";
					$opcion .="<td id = 'id_region_".$valor['id_grupo']."'>".$valor['id_grupo']."</td>";
					$opcion .="<td id = 'nombre_".$valor['id_grupo']."'>".$valor['nombregrupo']."</td>";
					$opcion .="<td id = 'desc_".$valor['id_grupo']."'>".$valor['descgrupo']."</td>";
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consulta grupos de inventario.
	function LlenarComboGrupoInventario(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cat_grupoinventario_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '<option value="0">Sin grupo asignado</option>';
				foreach ($rs AS $valor) {
					$opcion .= '<option value="'.$valor['id_grupo'].'">'.$valor['nombregrupo'].'</option>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	function GrabarNvoGrupoInventario($cNombreGrupo,$cDescGrupo){
		$arreglo = array("success"=>"false","data"=>"","error"=>"Verificar los datos de las zonas");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cat_grupoinventario_insert('$cNombreGrupo','$cDescGrupo') AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute; exitosamente el grupo de inventario!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se guard&oacute; la informaci&oacute;n, favor de verificar!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Eliminar la region y quita la liga de los grupos de inventario.
	function eliminarGrupoInventario($iGrupo){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cat_grupoinventario_delete($iGrupo) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente la informaci&oacute;n de la zona!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "La zona no se encuentra registrada o bien ocurrio un problema al eliminar!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Modifica la region ligado al grupo de inventario.
	function actualizarGrupoInventario($iGrupo,$vNombreGrupo,$vDescGrupo){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cat_grupoinventario_update($iGrupo,'$vNombreGrupo','$vDescGrupo') AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se actualiz&oacute; exitosamente la informaci&oacute;n del grupo de inventario!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "El grupo de inventario no se encuentra registrada o bien ocurrio un problema al actualizar!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Generar reporte de depositos pendientes por devolver
	function PedidosPendientesDevolverDeposito(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidospendientesdevolverdeposito_select() ORDER BY fechapedido,region DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
					//if($valor['descuento'] !== 1){
					if ($vTotal > $valor['abono']){
						if ($valor['abono'] > 0){
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
						}else{
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
						}
					}else{
						$folioConsulta = $valor['foliopedido'];
						$vRecibio = '';
						$vRecibio = quienAbonoXFolio($folioConsulta);
						$vRecibio = $vRecibio['data'];
						if ($vRecibio != ''){
							$vRecibio = ' POR:'.$vRecibio;
						}	
						$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
					}
						
					/*}else{
						$opcion .= 'TOTAL:&nbsp;$NO COBRAR';
					}* /
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical">';
					$opcion .= '<a title="Devolver dep&oacute;sito" class="btn btn-info btn-xs noMostrarPrint" id="devolverdeposito'.$valor['foliopedido'].'" href="ajax/modal_devolverdeposito.php?foliopedido='.$valor['foliopedido'].'&importe_total='.$valor['garantia'].'" data-toggle="modal" data-target="#modalDeposito'.$valor['foliopedido'].'" class="btn bg-color-blueDark txt-color-white btn-sm"><i class="fa fa-money">&nbsp;</i>Devolver Dep&oacute;sito</a>';
					$opcion .= '<fieldset><div class="modal fade" id="modalDeposito'.$valor['foliopedido'].'" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"></div></div></div></div></fieldset>';
					
					//$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a></div></td>';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					//$opcion .= 'row'.$i;
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/><br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de pedidos proximos a atender
	function generarReportePendidosPendientesProximos(){

		$fecha = obtenerfechaactual();										 
		//echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1];
		
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidospendientes_select() WHERE fechapedido::DATE > NOW()::DATE ORDER BY fechapedido ASC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
						//$opcion .= '<tr><td style=" font-family:Arial;font-size: 16px;text-align:center;"><strong><br/>PEDIDOS DE D&Iacute;AS ANTERIORES</strong></td></tr>';
					}
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr id="'.$valor['foliopedido'].'" title="'.$valor['foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
						if ($vTotal > $valor['abono']){
							if ($valor['abono'] > 0){
								$folioConsulta = $valor['foliopedido'];
								$vRecibio = '';
								$vRecibio = quienAbonoXFolio($folioConsulta);
								$vRecibio = $vRecibio['data'];
								if ($vRecibio != ''){
									$vRecibio = ' POR:'.$vRecibio;
								}
								$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
							}else{
								$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
							}
						}else{
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}	
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
						}
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['foliopedido'].'" style="display:none"><div class="btn-group-vertical"><a id="actualizapedido" title="Modifica el pedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
					$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div></td>';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					//$opcion .= 'row'.$i;
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					/*$opcion .= '</td></tr>';
					if( $i == $pagina1){
						$i = 0;
						$opcion .= '<br/>';
					}* /
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Consultar si un folio de ya se regreso el deposito.
	function consultardepositodevuelto($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_depositodevuelto_select($iFolioPedido::BIGINT) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 0){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Disponible para devolver el deposito!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No es posible devolver el dep&oacute;sito, ya fue devuelto!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Actualiza o Inserta el articulo del inventario y el grupo
	function ligarInventarioaGrupo($id_articulo,$id_grupo){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No existe consecutivo");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_ctl_grupoinventario_insert($id_articulo::BIGINT,$id_grupo::BIGINT) AS retorno;");
			//print_r($rs);
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
				$arreglo['data'] = "";
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute; exitosamente el art&iacute;culo!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se guard&oacute; la informaci&oacute;n, favor de verificar el registro ya existe!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de grupos de inventario en un periodo.
	function articulosdegrupoinventario($dFecha1,$dFecha2){		
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_articulosdegrupoinventario_select('$dFecha1'::DATE,'$dFecha2'::DATE) ORDER BY foliopedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$iEncabezado = 0;
				$i = 0;
				$opcion = '';	
				$opcion .= '<div class="table-responsive">';
				foreach ($rs AS $valor) {
					
					
					$opcion .= '<tr><td><table border="0" cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;font-size: 12px;margin: 0px;padding:0;">';
					$opcion .= '<td ><span style="font-size: 14px;">&nbsp;<strong>PEDIDO:</strong>&nbsp;<label id="folio">'.$valor['descripcion'].'</label></span><br/>';
					$opcion .= '&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label></br>';
					$opcion .= '&nbsp;CLIENTE:&nbsp;<label id="folio">'.$valor['cliente'].'</label></br>';
					$vArrayColonia = explode('-',$valor['colonia']);
					$vColonia = ISSET($vArrayColonia[1])? $vArrayColonia[1] :'';
					$opcion .= '&nbsp;COLONIA:&nbsp;<label id="folio">'.strtoupper($vColonia).'</label>';
					$opcion .= '</td>';
					$opcion .= '<hr style="margin: 0px;padding:0;"></table></td></tr>';
				}
				$opcion .= '</div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Generar reporte de pedidos pendientes
	function pedidosPendientesCapturadosHoyParaHoy(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidospendientescapturadoshoyparahoy_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$opcion = '';
				$pagina1 = 18;
				foreach ($rs AS $valor) {
					$i++;
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					$opcion .= '<tr id=row_'.$valor['foliopedido'].' title="'.$valor['foliopedido'].'"><td class="noMostrarPrint"><input id=check_'.$valor['foliopedido'].' type="checkbox" class="selPA" value="area1"/></td><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
					if ($vTotal > $valor['abono']){
						if ($valor['abono'] > 0){
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}							
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
						}else{
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
						}
					}else{
						$folioConsulta = $valor['foliopedido'];
						$vRecibio = '';
						$vRecibio = quienAbonoXFolio($folioConsulta);
						$vRecibio = $vRecibio['data'];
						if ($vRecibio != ''){
							$vRecibio = ' POR:'.$vRecibio;
						}	
						$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
					}
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['foliopedido'].'" style="display:none"><div class="btn-group-vertical"><a id="actualizapedido" title="Modifica el pedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
					$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div></td>';
					$opcion .= '</table><hr style="margin:1px 1px 1px 1px;padding:2px;color:black"/></td></tr>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Contar si el pedido se capturo hoy y se envia  hoy.
	function validarSiElPedidoEnviaHoy($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select COUNT(foliopedido) AS retorno from fn_pedidospendientescapturadoshoyparahoy_select() WHERE foliopedido = $iFolioPedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] > 0){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute; el folio y se requiere enviar hoy mismo!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'El folio grabado no se requiere enviar hoy mismo!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de pedidos finalizados a revertir
	function PedidosPendientesFinalizadosaRevertir(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosarevertirfinalizados_select() ORDER BY foliopedido DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
					if ($vTotal > $valor['abono']){
						if ($valor['abono'] > 0){
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
						}else{
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
						}
					}else{
						$folioConsulta = $valor['foliopedido'];
						$vRecibio = '';
						$vRecibio = quienAbonoXFolio($folioConsulta);
						$vRecibio = $vRecibio['data'];
						if ($vRecibio != ''){
							$vRecibio = ' POR:'.$vRecibio;
						}	
						$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
					}
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical">';
					$opcion .= '<button type="button" title="Revertir pedido finalizado" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartRevertirFolioLiberado('.$valor['foliopedido'].',2);"><i class="fa fa-refresh">&nbsp;</i>Revertir</button>';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
				
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	
	//Elimina los movimientos de  abono, entrega de mercancia y folios de un pedido.
	function RevertirFolioLiberado($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosarevertirfinalizados_delete($iFolioPedido::BIGINT) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se Regres&oacute; exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No fue posible regresar el pedido!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de pedidos finalizados a revertir
	function PedidosAbonadosaRevertir(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosarevertirabonados_select() ORDER BY foliopedido DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
					if ($vTotal > $valor['abono']){
						if ($valor['abono'] > 0){
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
						}else{
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
						}
					}else{
						$folioConsulta = $valor['foliopedido'];
						$vRecibio = '';
						$vRecibio = quienAbonoXFolio($folioConsulta);
						$vRecibio = $vRecibio['data'];
						if ($vRecibio != ''){
							$vRecibio = ' POR:'.$vRecibio;
						}	
						$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
					}
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical">';
					$opcion .= '<button type="button" title="Revertir lo abonado el dia de hoy" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartRevertirAbonoaFolio('.$valor['foliopedido'].',2);"><i class="fa fa-refresh">&nbsp;</i>Revertir</button>';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
				
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Elimina los movimientos de  abono, entrega de mercancia y folios de un pedido.
	function RevertirAbonoaFolio($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosarevertirabonodiahoy_delete($iFolioPedido::BIGINT) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se quit&oacute; el abon&oacute; exitosamente al pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No fue posible revertir el abono del pedido!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Consulta de articulos
	function LlenarGridListadoPrecios($esRenta){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			if ($esRenta == 0){
			$rs = $db->query("select * from fn_invent_select() ORDER BY descripcion;");
			}else{
				$rs = $db->query("select * from fn_invent_select($esRenta::SMALLINT) ORDER BY descripcion;");
			}
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				$i = 1;
				foreach ($rs AS $valor) {
					if ($i == 1){
						$opcion .= "<tr id='row_'".$valor['id_articulo'].">";
					}
					$opcion .= '<td  id="sku_'.$valor['id_articulo'].'">'.$valor['id_articulo'].'</td>';
					$opcion .= '<td  id="desc_'.$valor['id_articulo'].'">'.$valor['descripcion'].'</td>';
					$opcion .= '<td  id="prec_'.$valor['id_articulo'].'">'.$valor['precio'].'</td>';
					if ($i == 2){
						$opcion .= "</tr>";
						$i =1;
					}else{$i++;}
					
				}
				if ($i == 2){
					$opcion .= '<td  id="sku_"></td>';
					$opcion .= '<td  id="desc_"></td>';
					$opcion .= '<td  id="prec_"></td>';
				}
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de pedidos finalizados a revertir
	function PedidosFinalizadosAFacturar(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_pedidosfinalizadosafacturar_select() WHERE fechapedido >= NOW()::DATE - 30 ORDER BY fechapedido DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr id=row_'.$valor['foliopedido'].'><td class="noMostrarPrint"><input id=check_'.$valor['foliopedido'].' type="checkbox" class="selPA" value="area1"/></td><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr>';
					//$opcion .= '<tr><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
					if ($vTotal > $valor['abono']){
						if ($valor['abono'] > 0){
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
						}else{
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
						}
					}else{
						$folioConsulta = $valor['foliopedido'];
						$vRecibio = '';
						$vRecibio = quienAbonoXFolio($folioConsulta);
						$vRecibio = $vRecibio['data'];
						if ($vRecibio != ''){
							$vRecibio = ' POR:'.$vRecibio;
						}	
						$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
					}
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical">';
					//$opcion .= '<button type="button" title="Ver datos de facturaci&oacute;n" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartRevertirAbonoaFolio('.$valor['foliopedido'].',2);"><i class="fa fa-pencil-square-o">&nbsp;</i>ver RFC</button>';
					$opcion .= '<td width="10%"><a href="ajax/catalogos/modal/modal_ver_rfc.php?tel='.$valor['telefonocasa'].'&cel='.$valor['telefonocelular'].'" title="Ver datos de facturaci&oacute;n" class="btn btn-info btn-xs noMostrarPrint" data-toggle="modal" data-target="#remoteModal" id="editar_271">Ver RFC</a></td>';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consulta los datos fiscales de un cliente
	function consultarDatosFiscalesCte($vCte){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_datosfiscales_select($vCte::bigint) ORDER BY keyx DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se consult&oacute; exitosamente los datos fiscales del cliente!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No hay informaci&oacute;n de los datos fiscales del cliente!.';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	// Grabar datos fiscales
	function grabarDatosFiscales($vNum_cliente,$vRazonsocial,$vRfc,$vCalle,$vNuminterior,$vNumexterior,$vColonia,$vCodigopostal,$vEstado,$vCiudad){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No existe consecutivo");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_datosfiscales_insert($vNum_cliente::BIGINT,'$vRazonsocial'::VARCHAR,'$vRfc'::VARCHAR,'$vCalle'::VARCHAR,'$vNuminterior'::VARCHAR,'$vNumexterior'::VARCHAR,'$vColonia'::VARCHAR,$vCodigopostal::INTEGER,'$vEstado'::VARCHAR,'$vCiudad'::VARCHAR) AS retorno;");
			//print_r($rs);
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute; exitosamente los datos fiscales del cliente!.';
				}elseif ($sRetorno['retorno'] == 2){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se actualiz&oacute; exitosamente los datos fiscales del cliente!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se guard&oacute; la informaci&oacute;n, favor de verificar!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Eliminar datos fiscales del cliente.
	function eliminarDatosFiscales($iClientekeyx,$iDireccionpedidokeyx){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_datosfiscales_delete($iClientekeyx,$iDireccionpedidokeyx) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se elimin&oacute; el domicilio exitosamente!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se logr&oacute; eliminar el domicilio, favor de verificar!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Descartar pedidos facturados 
	function descartarFacturado($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosdescartafacturados_insert($iFolioPedido) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el descarte de los pedidos borrados!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten de los pedidos borrados!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Descartar pedidos entregados hoy 
	function descartarEntregados($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosdescartaentregados_insert($iFolioPedido) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el descarte de los pedidos borrados!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten de los pedidos borrados!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Aplica descuento de forma automatica.
	function aplicarDescuentoAutomatico($iClientekeyx,$iFlagDesctoAutomatico){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			//$rs = $db->query("select * from fn_datosfiscales_delete($iClientekeyx,$iFlagDesctoAutomatico) AS retorno;");
			$rs = $db->query("select * from fn_aplicadescuentoautomatico_update($iClientekeyx,$iFlagDesctoAutomatico) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se aplico el descuento automatico exitosamente!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se logr&oacute; aplicar descuento automatico, favor de verificar!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Generar reporte de pedidos atendidos 3 meses atras
	function generarReportePedidos3mesesatras_ANT(){
		set_time_limit(0);
		$fecha = obtenerfechaactual();										 
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidostodos_select() WHERE estatuspedido !=99 AND fechapedido::DATE < NOW()::DATE - 1 AND fechapedido::DATE > NOW()::DATE - 90 ORDER BY fechapedido DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
						if ($vTotal > $valor['abono']){
							if ($valor['abono'] > 0){
								$folioConsulta = $valor['foliopedido'];
								$vRecibio = '';
								$vRecibio = quienAbonoXFolio($folioConsulta);
								$vRecibio = $vRecibio['data'];
								if ($vRecibio != ''){
									$vRecibio = ' POR:'.$vRecibio;
								}
								$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
							}else{
								$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
							}
						}else{
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}	
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
						}
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical"><a id="actualizapedido" title="Modifica el pedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
					$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a></div></td>';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Generar reporte de pedidos manteleria
	function generarReportePendidosManteleria(){

		$fecha = obtenerfechaactual();										 
		//echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1];
		
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidospendientesmanteleria_select() WHERE fechapedido::DATE = NOW()::DATE + 1;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
						//$opcion .= '<tr><td style=" font-family:Arial;font-size: 16px;text-align:center;"><strong><br/>PEDIDOS DE D&Iacute;AS ANTERIORES</strong></td></tr>';
					}
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr id="'.$valor['foliopedido'].'" title="'.$valor['foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
						if ($vTotal > $valor['abono']){
							if ($valor['abono'] > 0){
								$folioConsulta = $valor['foliopedido'];
								$vRecibio = '';
								$vRecibio = quienAbonoXFolio($folioConsulta);
								$vRecibio = $vRecibio['data'];
								if ($vRecibio != ''){
									$vRecibio = ' POR:'.$vRecibio;
								}
								$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
							}else{
								$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
							}
						}else{
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}	
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
						}
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['foliopedido'].'" style="display:none"><div class="btn-group-vertical"><a id="actualizapedido" title="Modifica el pedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
					$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div></td>';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consultar un pedido a enviar por email
	function consultarUnPedidoparaEmailFinalizado($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidostodos_select() WHERE foliopedido = $iFolioPedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se consult&oacute exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "La pedido no se encuentra registrado o con estatus pendiente!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Generar reporte de todos los pedidos
	function generarReportePedidos3mesesatras(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidostodos_select() WHERE estatuspedido !=99 AND fechapedido::DATE < NOW()::DATE AND fechapedido::DATE > NOW()::DATE - 180 ORDER BY foliopedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
				
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					if ($i == 0){
						$opcion .= '<tr><td style=" font-family:Arial;font-size: 16px;text-align:left;"><strong><br/>PEDIDOS DEL MES </strong></td></tr>';
						$i++;
					}					
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
				
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label>';
					$opcion .= '&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					//$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td></tr>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['foliopedido'].'" style="display:block">';
					//$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					//$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div></td>';
					$opcion .= '</tr>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table></td></tr>';
				}
				
			if ($i == 0){
					$arreglo['error'] = 'No se encontr&oacute; informaci&oacute;n de la consulta!.';
				}else{
					$arreglo['error'] = '';
				}
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Eliminar la comision
	function eliminarComision($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_marcarcomision_delete($iFolioPedido) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el grabado de la comision!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten de la comision!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consulta la comision
	function consultaComisiones($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_marcarcomision_select($iFolioPedido);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];				
				$arreglo['success'] = true;
				$arreglo['data'] = $sRetorno;
				$arreglo['error'] = 'Se realiz&oacute; exitosamente el grabado de la comision!.';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Generar reporte de pedidos de comision pagada
	function pedidosFinalizadosPagadoComision(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosfinalizadosacomision_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$opcion = '';
				$pagina1 = 18;
				foreach ($rs AS $valor) {
					$i++;
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					$opcion .= '<tr id=row_'.$valor['foliopedido'].' title="'.$valor['foliopedido'].'"><td class="noMostrarPrint"><input id=check_'.$valor['foliopedido'].' type="checkbox" class="selPA" value="area1"/></td><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
					if ($vTotal > $valor['abono']){
						if ($valor['abono'] > 0){
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}							
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
						}else{
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
						}
					}else{
						$folioConsulta = $valor['foliopedido'];
						$vRecibio = '';
						$vRecibio = quienAbonoXFolio($folioConsulta);
						$vRecibio = $vRecibio['data'];
						if ($vRecibio != ''){
							$vRecibio = ' POR:'.$vRecibio;
						}	
						$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
					}
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					$opcion .= '<td class="pull-right" id="Clientes_'.$valor['foliopedido'].'" ><div class="btn-group-vertical"><label id="num_clientecomision" class="semi-bold"># CLIENTE:&nbsp;'.$valor['num_clientecomision'].'</label></br>';
					$opcion .= '<label id="nom_clientecomision" class="bold">NOMBRE:&nbsp;'.$valor['nom_clientecomision'].'</label></br>';
					$Comsion = (INTVAL(ISSET($valor['porcentajecomision'])) > 0) ? $valor['porcentajecomision'] : 0;
					if ($Comsion > 0){
						$totalComision = $vTotal *($Comsion/100);
					}else { $totalComision = 0;}
					$opcion .= '<label id="total_comision" class="semi-bold">COMISI&Oacute;N:&nbsp;$'.$totalComision.'</label></br>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div></td-->';
					$opcion .= '</table><hr style="margin:1px 1px 1px 1px;padding:2px;color:black"/></td></tr>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Paga la comision
	function pagarComision($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_marcarcomision_update($iFolioPedido) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el grabado de la comision!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten de la comision!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Mercancia de pedidos a revertir.
	function PedidosMercanciaRecibidaARevertir(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosmercaciarecibidaarevertir_select() ORDER BY foliopedido DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					$Horario = '';
					if ($valor['notahoraentrega'] != '') {
						$Horario = '|&nbsp;<label id="notahoraentrega">HORA: '.$valor['notahoraentrega'].'</label>&nbsp;';
					}
					if ($valor['notahorarecoger'] != ''){
						$Horario .='|&nbsp;<label id="notahorarecoger"><strong>RECOGER: '.$valor['notahorarecoger'].'</strong></label>&nbsp;';
					}
					if ($valor['manteleria'] != ''){
						$Horario .='|&nbsp;<label id="manteleria">MANTEL: '.$valor['manteleria'].'</label>';
					}
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$vDeposito = $valor['garantia'];
					
					if ($vDeposito >0)
						$vDeposito = ' +  DEP&Oacute;SITO: $' . $vDeposito;
					else
						$vDeposito = '';
					
					$opcion .= '<tr><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
					if ($vTotal > $valor['abono']){
						if ($valor['abono'] > 0){
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
						}else{
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
						}
					}else{
						$folioConsulta = $valor['foliopedido'];
						$vRecibio = '';
						$vRecibio = quienAbonoXFolio($folioConsulta);
						$vRecibio = $vRecibio['data'];
						if ($vRecibio != ''){
							$vRecibio = ' POR:'.$vRecibio;
						}	
						$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
					}
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical">';
					$opcion .= '<button type="button" title="Revertir mercancia recibida" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartRevertirMercanciaRecibida('.$valor['foliopedido'].');"><i class="fa fa-refresh">&nbsp;</i>Revertir</button>';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
				
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Elimina los movimientos de  entrega de mercancia de un pedido.
	function RevertirMercanciaRecibida($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosarevertirfinalizados_delete($iFolioPedido::BIGINT) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se Regres&oacute; exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No fue posible regresar el pedido!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function ValidaSesion($email,$password){
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_user_select('$email','$password', 1);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
			}
		} else {
			$sRetorno =$db->getError();
		}
		closeConexion($db);
		return $sRetorno;
			}
	
	function LlenarComboEmpleados(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"Verificar los datos de usuarios");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_user_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '<option value="0">Seleccione un empleado</option>';
				foreach ($rs AS $valor) {
					$opcion .= '<option value="'.$valor['id_puesto'].'">'.$valor['nombre'].'</option>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	function jsonConsultaEmpleados(){
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_user_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
			}
		} else {
			$sRetorno =$db->getError();
	
		}
		closeConexion($db);
		return json_encode($sRetorno);
	}
	
	function LlenarComboPuestos(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"Verificar los datos de usuarios");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cat_user_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '<option value="0">Seleccione un puesto</option>';
				foreach ($rs AS $valor) {
					$opcion .= '<option value="'.$valor['id_puesto'].'">'.$valor['puesto'].'</option>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	function GrabarUsuarioNuevo($iId_puesto,$cUser,$cPwd,$cNombre){
		$arreglo = array("success"=>"false","data"=>"","error"=>"Verificar los datos de usuarios");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_user_insert($iId_puesto,'$cUser','$cPwd','$cNombre') AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se grab&oacute; exitosamente el usuario!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se guard&oacute; la informaci&oacute;n, favor de verificar!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	function GrabarNvaZona($cNombreZona,$cDescZona){
		$arreglo = array("success"=>"false","data"=>"","error"=>"Verificar los datos de las zonas");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cat_regiones_insert('$cNombreZona','$cDescZona') AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute; exitosamente la zona!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se guard&oacute; la informaci&oacute;n, favor de verificar!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	function LlenarComboZonasCapturadas(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"Verificar los datos de zonas, no hay capturadas");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cat_regiones_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '<option value="0">Seleccione una zona</option>';
				foreach ($rs AS $valor) {
					$opcion .= '<option value="'.$valor['id_region'].'">'.$valor['nombreregion'].'</option>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return json_encode($arreglo);
	}
	
	function LlenarComboColoniasSepomex($iCodigo,$vCalle){
		$arreglo = array("success"=>"false","data"=>"","error"=>"Verificar los datos de zonas, no hay capturadas");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_dir_select($iCodigo,'$vCalle') WHERE UPPER(d_mnpio) IN ('CULIACAN','NO ESPECIFICADO') ORDER BY d_asenta;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				//$opcion = '<option value="0">Seleccione una zona</option>';
				foreach ($rs AS $valor) {
					//$opcion .= '<option value="'.$valor['keyx'].'">'.$valor['d_asenta'].'</option>';
					$opcion .= '"'.$valor['keyx'].' - '.$valor['d_asenta'].' -  '.$valor['d_mnpio'].'",';
				}
				$opcion = substr($opcion,0,-1);
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	function LlenarComboColoniasSepomex2($iCodigo,$iKeyx){
		$arreglo = array("success"=>"false","data"=>"","error"=>"Verificar los datos de zonas, no hay capturadas");
		$db = getConexionTda();
		$sRetorno ='';
		//print_r($db);
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_dir_select($iCodigo,$iKeyx::bigint);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				
				$arreglo['success'] = true;
				$arreglo['data'] = $sRetorno[0];
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	// Grabar relacion de zona con domicilio
	function grabarRegionColonia($iRegion,$iKeyxDir){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No existe consecutivo");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_ctl_regiones_insert($iRegion::BIGINT,$iKeyxDir::BIGINT) AS retorno;");
			//print_r($rs);
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute; exitosamente la regi&oacute;n!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se guard&oacute; la informaci&oacute;n, favor de verificar el registro ya existe!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consulta de usuarios
	function LlenarGridUsuarios(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_user_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .="<tr id='tabla_".$valor['id_puesto']."'><td id='row_".$valor['id_puesto']."'>";
					$opcion .="<a name='eliminar_".$valor['id_puesto']."' href='javascript:void(0);' id='smart-mod-eg1' onclick= 'MensajeSmartUsuarios(this.name,2)'; ><i class='fa fa-minus-square-o' rel='tooltip' data-placement='top' data-original-title='Eliminar'></i></a>&nbsp;";
					$opcion .="<a href='ajax/modal_usuarios.php?usr=".$valor['id_puesto']."' data-toggle='modal' data-target='#remoteModal' id='editar_".$valor['id_puesto']."'>";
					$opcion .="<i class='fa fa-pencil-square-o' rel='tooltip' data-placement='top' data-original-title='Editar'></i>";
					$opcion .="</a></td>";
					$opcion .="<td id = 'emp_".$valor['id_puesto']."'>".$valor['id_puesto']."</td>";
					$opcion .="<td id = 'usr_".$valor['id_puesto']."'>".$valor['usuario']."</td>";
					$opcion .="<td id = 'nom_".$valor['id_puesto']."'>".$valor['nombre']."</td>";
					$opcion .="<td id = 'desc_".$valor['id_puesto']."'>".$valor['descripcionempleado']."</td>";
					$opcion .="<td id = 'pwd_".$valor['id_puesto']."'>".$valor['pwd']."</td>";
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Eliminar usuario
	function eliminarUsuario($iKeyxDir){
		$arreglo = array("success"=>"false","data"=>"","error"=>"Ocurrio un problema favor de verificar.");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_user_delete($iKeyxDir::INTEGER) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se elimin&oacute; exitosamente al usuario!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se guard&oacute; la informaci&oacute;n, favor de verificar la existencia del registro!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Consulta de un usuarios
	function consultaUnUsuario($Usuario){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_user_select($Usuario);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];				
				$arreglo['success'] = true;
				$arreglo['data'] = $sRetorno;
				$arreglo['error'] = 'Se consult&oacute; exitosamente al usuario!.';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Actualizar usuario
	function actualizarUsuario($iKeyx,$iId_puesto,$cUser,$cPwd,$cNombre){
		$arreglo = array("success"=>"false","data"=>"","error"=>"Verificar los datos de usuarios");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_user_update($iKeyx,$iId_puesto,'$cUser','$cPwd','$cNombre') AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se encontr&oacute;  el registro!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consulta de un usuarios
	function consultaCtePorTelefono($vTelefono){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cte_select('$vTelefono'::bpchar);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno[0];
					$arreglo['error'] = 'Se consult&oacute; exitosamente al cliente!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No hay informaci&oacute;n del cliente!.';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Consulta de clientes por keyx
	function consultaCtePorKeyx($vKeyx){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cte_select($vKeyx::BIGINT);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno[0];
					$arreglo['error'] = 'Se consult&oacute; exitosamente al cliente!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No hay informaci&oacute;n del cliente!.';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Consulta domicilio por cliente
	function consultarDomicilioPorCte($vCte){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_direccionpedidoscliente_select($vCte::bigint);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se consult&oacute; exitosamente al cliente!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No hay informaci&oacute;n del cliente!.';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Registro del domicilio del cliente.
	function pedidoGrabarDomicilio($calle,$numext,$numint,$CodigoPostal,$Colonia,$municipio,$referencias,$clientekeyx){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_direccionpedidos_insert('$calle'::VARCHAR,'$numint'::VARCHAR,'$numext'::VARCHAR,'$Colonia'::VARCHAR,$CodigoPostal::INTEGER,''::VARCHAR,'$referencias'::VARCHAR,'SINALOA'::VARCHAR,'$municipio'::VARCHAR,$clientekeyx::BIGINT) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente el domicilio!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "El domicilio ya se encontraba registrado!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consulta de regiones capturadas
	function LlenarGridZonas(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cat_regiones_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$zonaName = str_replace(' ','%',$valor['nombreregion']);
					$descRegion = str_replace(' ','%',$valor['descregion']);
					$opcion .="<tr id='tabla_".$valor['id_region']."'><td id='row_".$valor['id_region']."'>";
					$opcion .="<a name='eliminar_".$valor['id_region']."' href='javascript:void(0);' id='smart-mod-eg1' onclick= 'MensajeSmartZonas(".$valor['id_region'].",2)'; ><i class='fa fa-minus-square-o' rel='tooltip' data-placement='top' data-original-title='Eliminar'></i></a>&nbsp;";
					$opcion .="<a href=ajax/modal_administracion_zonas.php?region=".$valor['id_region']."&nombreregion=".$zonaName."&descregion=".$descRegion." data-toggle='modal' data-target='#remoteModal' id='editar_".$valor['id_region']."'>";
					$opcion .="<i class='fa fa-pencil-square-o' rel='tooltip' data-placement='top' data-original-title='Editar'></i>";
					$opcion .="</a></td>";
					$opcion .="<td id = 'id_region_".$valor['id_region']."'>".$valor['id_region']."</td>";
					$opcion .="<td id = 'nombre_".$valor['id_region']."'>".$valor['nombreregion']."</td>";
					$opcion .="<td id = 'desc_".$valor['id_region']."'>".$valor['descregion']."</td>";
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Consulta de colonias y zonas ligadas
	function LlenarGridZonasNColonias(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_ctl_regiones_select();");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$colonia = str_replace(' ','%',$valor['d_asenta']);
					$ciudad = str_replace(' ','%',$valor['d_mnpio']);
					$opcion .="<tr id='tabla_".$valor['keyx']."'><td id='row_".$valor['keyx']."'>";
					$opcion .="<a name='eliminar_".$valor['keyx']."' href='javascript:void(0);' id='smart-mod-eg1' onclick= 'MensajeSmartColonias(".$valor['keyx'].",2)'; ><i class='fa fa-minus-square-o' rel='tooltip' data-placement='top' data-original-title='Eliminar'></i></a>&nbsp;";
					$opcion .="<a href='ajax/modal_administracion_colonias.php?id=".$valor['keyx']."&cp=".$valor['d_codigo']."&colonia=".$colonia."&ciudad=".$ciudad."' data-toggle='modal' data-target='#remoteModal' id='editar_".$valor['id_region']."'>";
					$opcion .="<i class='fa fa-pencil-square-o' rel='tooltip' data-placement='top' data-original-title='Editar'></i>";
					$opcion .="</a></td>";
					$opcion .="<td id = 'keyx_".$valor['keyx']."'>".$valor['keyx']."</td>";
					$opcion .="<td id = 'CodigoPostal_".$valor['keyx']."'>".$valor['d_codigo']."</td>";
					$opcion .="<td id = 'Asenta_".$valor['keyx']."'>".$valor['d_asenta']."</td>";
					$opcion .="<td id = 'Municipio_".$valor['keyx']."'>".$valor['d_mnpio']."</td>";
					$opcion .="<td id = 'Nameregion_".$valor['keyx']."'>".$valor['nombreregion']."</td>";
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	function obtenerfechaactual(){

		date_default_timezone_set ("America/Mazatlan");
		setlocale(LC_ALL,"es_ES");  
		$dias = array("DOMINGO","LUNES","MARTES","MIERCOLES","JUEVES","VIERNES","SABADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");											 
		return $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]; 										
	}
	
	function obtenerfechDDDIANOMBREMES($fecha){

		date_default_timezone_set ("America/Mazatlan");
		setlocale(LC_ALL,"es_ES");  
		$dias = array("DOMINGO","LUNES","MARTES","MIERCOLES","JUEVES","VIERNES","SABADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");											 
		//return $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]; 										
		return $dias[date('w',strtotime($fecha))]." ".date('d',strtotime($fecha))." DE ".$meses[date('n',strtotime($fecha))-1]; 										
	}
	
	
	//Eliminar la region y quita la liga de las zonas.
	function eliminarColoniaZona($iRegion){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_ctl_regiones_delete($iRegion) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente la informaci&oacute;n de la zona!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "La zona no se encuentra registrada o bien ocurrio un problema al eliminar!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Eliminar la region y quita la liga de las zonas.
	function eliminarRegion($iRegion){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cat_regiones_delete($iRegion) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente la informaci&oacute;n de la zona!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "La zona no se encuentra registrada o bien ocurrio un problema al eliminar!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Modifica la region ligada a la zona.
	function actualizarZonaRegion($iKeyx,$iRegion){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_ctl_regiones_update($iKeyx,$iRegion) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se actualiz&oacute; exitosamente la informaci&oacute;n de la zona y colonia!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "La zona no se encuentra registrada o bien ocurrio un problema al actualizar!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	function obtenerVariableEmpresa($Keyx,$sEmpresa){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_variables_select($Keyx,$sEmpresa) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($rs_final != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se encontr&oacute; la informaci&oacute;n de la variable!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se encontr&oacute; la informaci&oacute;n de la variable!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	function ModificarVariableEmpresa($Keyx,$sEmpresa,$valor){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_variables_update($Keyx,$sEmpresa,$valor) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($rs_final != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se actualiz&oacute; la informaci&oacute;n de la variable';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se actualiz&oacute; la informaci&oacute;n de la variable!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Eliminar el domicilio del cliente.
	function eliminarDomicilio($iClientekeyx,$iDireccionpedidokeyx){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosdomiciliocliente_delete($iClientekeyx,$iDireccionpedidokeyx) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se elimin&oacute; el domicilio exitosamente!.';
				}else if ($sRetorno['retorno'] == 2){
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Ya se encontr&oacute; eliminado el domicilio, favor de verificar!';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No se logr&oacute; eliminar el domicilio, favor de verificar!';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Consultar clientes.
	function consultarClientes(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_cte_select() ORDER BY nombres,apellidos;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .="<tr id='row_".$valor['keyx']."'>";
					$opcion .= '<td  id="keyx_'.$valor['keyx'].'">'.$valor['keyx'].'</td>';
					$opcion .= '<td  id="desc_'.$valor['nombres'].'">'.$valor['nombres'].' '. $valor['apellidos']. '</td>';
					$opcion .= '<td width="15%" id="cel_'.$valor['telcelular'].'">'.$valor['telcelular'].'</td>';
					$opcion .= '<td width="15%" id="casa_'.$valor['telcasa'].'">'.$valor['telcasa'].'</td>';
					$opcion .= '<td width="10%"><a href="ajax/modal_administracion_direcciones.php?keyx='.$valor['keyx'].'" data-toggle="modal" data-target="#remoteModal" id="editar_'.$valor['keyx'].'">Ver domicilios</a></td>';
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Consultar clientes.
	function VerDomiciliosEliminar($rs,$vClienteKeyx){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		/*if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_cte_select() ORDER BY nombres,apellidos;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{*/
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .="<tr id='row_".$valor['keyx']."'>";
					$opcion .= '<td>'.$valor['keyx'].'</td>';
					$opcion .= '<td><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numexterior'].'</label>&nbsp;<label id="numero_int">'.$valor['numinterior'].'</label>,&nbsp;';
					$opcion .= '</br><label id="colonia"><strong>&nbsp;'.$valor['colonia'].'</strong></label>';
					$opcion .= '</br><span style="font-size: 9px;"> (&nbsp;<label id="referencias">'.$valor['observaciones'].'&nbsp;).</span></label>';
					$opcion .= '</td>';
					$opcion .= '<td><a href="javascript:MensajeSmartEliminarDomicilioCte('.$vClienteKeyx.','.$valor['keyx'].');" id="editar_'.$valor['keyx'].'">Eliminar</a></td>';
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			/*}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);*/
		return $arreglo;
	}
	
	//Generar reporte de cortes
	function fn_cortetda_select_paso1($fecha){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cortetda_select(1,'$fecha'::DATE);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .= '<tr style="font-family:Arial;font-size:11px;">';
					$opcion .= '<td><label id="nom_empleado">'.strtoupper($valor['nom_empleado']).'</label></td>';
					$opcion .= '<td><label id="numeroabonos">'.$valor['numeroabonos'].'</label></td>';
					$opcion .= '<td><label id="monto">$'.$valor['monto'].'</label></td>';
					$opcion .= '<td style="font-family:Arial;font-size:9px;"><label id="folios">'.$valor['folios'].'</label></td>';
					$iEmpleado = $valor['empleado'];
					$restDia = fn_cortetda_select_paso2($fecha,$iEmpleado);
					$restDia =$restDia['data'];
					$restRecibidoDia = fn_cortetda_select_paso3($fecha,$iEmpleado);
					$restRecibidoDia =$restRecibidoDia['data'];
					$diferencia = ($valor['monto'] + $restRecibidoDia['monto'] ) - $restDia['monto'];
					//print_r($diferencia);
					$opcion .= '<td><label id="DepositosRecibidos">$'.$restRecibidoDia['monto'].'</label></td>';
					$opcion .= '<td><label id="devolucionDepositos">$'.$restDia['monto'].'</label></td>';
					$opcion .= '<td style="font-family:Arial;font-size:9px;"><label id="folioDeposito">'.$restDia['folios'].'</label></td>';
					$opcion .= '<td><label id="ImporteDiferencia">$'.$diferencia.'</label></td>';
					$opcion .= '</tr>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de cortes paso 2
	function fn_cortetda_select_paso2($fecha,$iEmpleado){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cortetda_select(2,'$fecha'::DATE) WHERE empleado = $iEmpleado;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				//print_r($rs_final);
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno[0];
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el corte de los abonos, es necesario el imprimir!.';
				}else{
					$sRetorno = array("numeroabonos"=>0, "monto"=>0,"empleado"=>0,""=>"","nom_empleado"=>"","folios"=>"");
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten del corte de abonos!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Generar reporte de cortes paso 3
	function fn_cortetda_select_paso3($fecha,$iEmpleado){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cortetda_select(3,'$fecha'::DATE) WHERE empleado = $iEmpleado;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				//print_r($rs_final);
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno[0];
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el corte de los abonos, es necesario el imprimir!.';
				}else{
					$sRetorno = array("numeroabonos"=>0, "monto"=>0,"empleado"=>0,""=>"","nom_empleado"=>"","folios"=>"");
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten del corte de abonos!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	// Fechas de cortes
	function LlenarComboFechasCorteTDA(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"Verificar los datos de usuarios");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_fechascortetda_select()ORDER BY fecha_corte DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '<option value="0">Seleccione una fecha de corte</option>';
				foreach ($rs AS $valor) {
					$opcion .= '<option value="'.$valor['fecha_corte'].'">'.$valor['fecha_corte'].'</option>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	function sumarDiasaFecha($iDia,$Fecha){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$arreglo['success'] = true;
		$arreglo['data'] = date('Y-m-d',strtotime($Fecha."+".$iDia." day "));
		$arreglo['error'] = 'Se calculo la fecha $Fecha + los $iDia!.';
		
		return $arreglo;
	}
	
	function ValidarSiLaFechaEsHoy($Fecha1,$Fecha2){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$arreglo['success'] = true;
		$FechaHoy = date('Y-m-d',strtotime($Fecha1));
		$FechaPedido = date('Y-m-d',strtotime($Fecha2));
		
		$arreglo['data'] = ( $FechaHoy == $FechaPedido)?true:false;
		$arreglo['error'] = 'Se calculo la fecha '. $FechaHoy .' vs la fecha '. $FechaPedido.'!.';
		
		return $arreglo;
	}
	
	function actualizarRegion($iRegion,$vNombre,$vDescRegion){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cat_regiones_update($iRegion,'$vNombre','$vDescRegion') AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente la informaci&oacute;n de la zona!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "La zona no se encuentra registrada o bien ocurrio un problema al actualizar!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
		
	//Consulta los datos fiscales de un cliente por keyx para modificar
	function consultarDatosCteKeyx($vCte,$vKeyx){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_datosfiscales_select($vCte::bigint,$vKeyx::bigint);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se consult&oacute; exitosamente los datos fiscales del cliente!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'No hay informaci&oacute;n de los datos fiscales del cliente!.';
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Obtener folios del mes en curso.
	function foliosMesEnCurso(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			//$rs = $db->query("select * from fn_pedidospendientesmes_select() WHERE fechapedido::DATE >= NOW()::DATE;");
			$rs = $db->query("SELECT COUNT(1) AS cantidad,fechacobro FROM (SELECT * FROM fn_pedidospendientesmes_select() WHERE fechacobro::DATE >= NOW()::DATE GROUP BY num_foliopedido,fechacobro)AS tb GROUP BY fechacobro ORDER BY fechacobro;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = array();
				foreach ($rs AS $valor) {
					//$opcion1 = array("title"=>"Pendientes: ".$valor['cantidad'],"start"=>$valor['fechapedido']);
					$opcion1 = array("title"=>$valor['cantidad'],"start"=>$valor['fechacobro'],"allDay"=> "true");
					array_push($opcion,$opcion1);
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	function insertProveedores($request){
		$arreglo = array("success"=>"false","data"=>"","error"=>"Verificar los datos de proveedores");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			//PRINT_R($request);
			$idProveedor = ($request['iduProveedor'] == ''?0:$request['iduProveedor']);
			
			$query = "select * from fn_proveedor_insert(".$idProveedor."::bigint, '".$request['claveProveedor']."':: VARCHAR,
					'".$request['razonSocialProveedor']."':: VARCHAR, '".$request['razonSocialProveedor']."'::varchar,
					'".$request['direccionProveedor']."'::VARCHAR, '".$request['rfcProveedor']."'::varchar, 
					'".$request['telefonoProveedor']."'::VARCHAR, '".$request['emailProveedor']."'::VARCHAR);";
			$rs = $db->query($query);
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{			
				$arreglo['success'] = true;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return json_encode($arreglo);	
	}
	
	function llenarGridProveedores(){
		$arreglo = array("success"=>"false","data"=>array('code' => 'ERROR'),"error"=>"");
		$db = getConexionTda();
		if($db->getError() == ''){
			$query = "select *from fn_cat_proveedores_select();";
			$rs = $db->query($query);
			if($db->getError() == ''){
				$html = '';
				foreach ($rs AS $valor) {
					$idProveedor = $valor['idproveedor'];
					$html .= '<tr id="row_'.$idProveedor.'">';
					//$html .= '<td id="id_proveedor_'.$idProveedor.'">'.$idProveedor.'</td>';
					$html .= '<td id="claveProveedor_'.$idProveedor.'">'.$valor['clave_proveedor'].'</td>';
					$html .= '<td  id="nombreProveedor_'.$idProveedor.'">'.$valor['razon_social'].'</td>';
					$html .= '<td>'.$valor['direccion'].'</td>';
					$html .= '<td>'.$valor['rfc'].'</td>';
					$html .= '<td>'.$valor['telefono'].'</td>';
					$html .= '<td>'.$valor['email'].'</td>';
					$html .= '<td>'.$valor['activo'].'</td>';
					$html .= '<td  id="accion_'.$idProveedor.'"><a href="ajax/modal_proveedores.php?idProveedor='.$idProveedor.'" class="fa fa fa-edit txt-color-gray hidden-md hidden-sm hidden-xs" data-toggle="modal" data-target="#remoteModal" id="editarProveedor" title="Editar" style="font-size:1.5em;"></a>';
					if($valor['activo'] != 'NO_ACTIVO'){
						$html .= 	'&nbsp;&nbsp;<a onclick="eliminadoLogicoProveedores('.$idProveedor.',0)" class="glyphicon glyphicon-remove" style = "cursor:pointer;font-size:1.5em;" title="Eliminar" ></a></td>';
					}else{
						$html .= '&nbsp;&nbsp;<a onclick="reactivarItem('.$idProveedor.', 1)" class="glyphicon glyphicon-ok" style = "cursor:pointer;font-size:1.5em;" title="Reactvar" ></a></td>';	
					}
					$html .= '</tr>';
				}
				$arreglo['success']=true;
				$arreglo['data'] = array('html'=>$html);
			}else{
				$arreglo['error'] = $db->getError();	
			}
		}else{
			$arreglo['error'] = $db->getError();
		}
		closeConexion($db);
		return json_encode($arreglo);
	}
	
	function consultarInfoProveedor($idProveedor){
			$arreglo = array("success"=>"false","data"=>array('code' => 'ERROR'),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select * from fn_cat_proveedores_select_id(".$idProveedor."::bigint);";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					$arreglo['success']=true;
					$arreglo['data'] = array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
				}else{
					$arreglo['error'] = $db->getError();
				}
				
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);
		}

		function eliminarProveedor($id, $bActivo){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
			if($bActivo == 0){ $bActivo = 'false';}else{$bActivo='true';}
				$query = "select * from fn_cat_proveedores_eliminado_logico(".$id."::bigint,".$bActivo."::boolean);";
				//echo $query;
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					$arreglo['success']=true;
				}else{
					$arreglo['error'] = $db->getError();
				}
				
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);
		}

		function insertConceptosGastos($request){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"Verificar los datos de concepto de gastos");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$idConcepto = ($request['idConcepto'] == ''? 0 : $request['idConcepto']);
				$query = "select * from fn_conceptogasto_insert(".$idConcepto."::bigint,'".$request['concepto_gasto']."':: VARCHAR);";
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$sRetorno =$db->getError();
					$arreglo['success'] = false;
					$arreglo['error'] = $sRetorno;
				}else{			
					$arreglo['success'] = true;
					$arreglo['error'] = '';
				}
			} else {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}
			closeConexion($db);
			echo json_encode($arreglo);	
		}


		function llenarGridConceptoGastos(){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select *from fn_cat_concepto_gastos_select();";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					foreach ($rs AS $valor) {
						$idConcepto = $valor['idconcepto'];
						$html .= '<tr id="row_'.$idConcepto.'">';
						$html .= '<td id="concepto_'.$idConcepto.'">'.$valor['concepto'].'</td>';
						$html .= '<td id="concepto_'.$idConcepto.'">'.$valor['activo'].'</td>';
						
						$html .= '<td  id="accion_'.$idConcepto.'"><a href="ajax/modal_concepto_gastos.php?idConcepto='.$idConcepto.'" class="fa fa fa-edit txt-color-gray hidden-md hidden-sm hidden-xs" data-toggle="modal" data-target="#remoteModal" id="editarProveedor" title="Editar" style="font-size:1.5em;"></a>';
						if($valor['activo'] != 'NO_ACTIVO'){
							$html .= '&nbsp;&nbsp;<a onclick="eliminadoLogicoConceptoGastos('.$idConcepto.',0)" class="glyphicon glyphicon-remove" style = "cursor:pointer;font-size:1.5em;" title="Eliminar" ></a></td>';
						}else{
						$html .= '&nbsp;&nbsp;<a onclick="reactivarItem('.$idConcepto.', 1)" class="glyphicon glyphicon-ok" style = "cursor:pointer;font-size:1.5em;" title="Reactvar" ></a></td>';	
						}
						$html .= '</tr>';
					}
					$arreglo['success']=true;
					$arreglo['data'] = array('html'=>$html);
				}else{
					$arreglo['error'] = $db->getError();	
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);
		}

		function consultarInfoConceptoGastos($idConcepto){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select * from fn_cat_concepto_gastos_select_id(".$idConcepto."::bigint);";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					$arreglo['success']=true;
					$arreglo['data'] = array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
				}else{
					$arreglo['error'] = $db->getError();
				}
				
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);
		}

		function eliminarConceptoGastos($request){
			$bActivo = null;
			if($request['activo'] == 0){ $bActivo = 'false';}else{$bActivo='true';}
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select * from fn_cat_concepto_gastos_eliminado_logico(".$request['idConcepto']."::bigint, ".$bActivo."::boolean);";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					$arreglo['success']=true;
				}else{
					$arreglo['error'] = $db->getError();
				}
				
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);
		}

		function llenarGridVendedores(){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select *from fn_cat_vendedor_select();";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					foreach ($rs AS $valor) {
						$id_vendedor = $valor['id_vendedor'];
						$html .= '<tr id="row_'.$id_vendedor.'">';
						//$html .= '<td id="row_'.$id_vendedor.'">'.$id_vendedor.'</td>';
						$html .= '<td id="vendedor_'.$id_vendedor.'">'.$valor['nombre'].'</td>';
						$html .= '<td id="puesto_'.$id_vendedor.'">'.$valor['puesto'].'</td>';
						$html .= '<td id="puesto_'.$id_vendedor.'">'.$valor['domicilio'].'</td>';
						$html .= '<td id="puesto_'.$id_vendedor.'">'.$valor['fecha_nacimiento'].'</td>';
						$html .= '<td id="puesto_'.$id_vendedor.'">'.$valor['activo'].'</td>';
						
						$html .= '<td  id="accion_'.$id_vendedor.'"><a href="ajax/modal_vendedores.php?id_vendedor='.$id_vendedor.'" class="fa fa fa-edit txt-color-gray hidden-md hidden-sm hidden-xs" data-toggle="modal" data-target="#remoteModal" id="editarProveedor" title="Editar" style="font-size:1.5em;"></a>';
						if($valor['activo'] == 'ACTIVO'){
							$html .= '&nbsp;&nbsp;<a onclick="eliminadoLogicoVendedores('.$id_vendedor.', 0)" class="glyphicon glyphicon-remove" 
							style = "cursor:pointer;font-size:1.5em;" title="Eliminar" ></a></td>';	
						}else{
							$html .= '&nbsp;&nbsp;<a onclick="reactivarItem('.$id_vendedor.', 1)" class="glyphicon glyphicon-ok	" 
							style = "cursor:pointer;font-size:1.5em;" title="Reactvar" ></a></td>';	
						}
						$html .= '</tr>';
					}
					$arreglo['success']=true;
					$arreglo['data'] = array('html'=>$html);
				}else{
					$arreglo['error'] = $db->getError();	
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);
		}


		function insertVendedores($request){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"Verificar los datos de concepto de gastos");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$id = ($request['id_vendedor'] == ''? 0 : $request['id_vendedor']);
				$id_puesto = ($request['id_puesto'] == ''? 0 : $request['id_puesto']);
				$query = "select * from fn_vendedor_insert(".$id."::bigint,'".$id_puesto."':: bigint,'".$request['nombre']."'::varchar, '".$request['fecha_nacimiento']."'::timestamp, '".$request['domicilio']."'::varchar);";
				$db->query($query);
				if ($db->getError() != "") {
					$arreglo['error'] = $db->getError();
				}else{			
					$arreglo['success'] = true;
					$arreglo['error'] = '';
				}
			} else {
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);	
		}

		function consultaPuestos($term){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"Verificar los datos de concepto de gastos");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$query = "select id_puesto as id, puesto as value, puesto as label from fn_cat_puesto_select() where puesto like '%".strtoupper($term['term'])."%';";
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$arreglo['error'] = $db->getError();
				}else{			
					$arreglo['success'] = true;
					$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
					$arreglo['error'] = '';
				}
			} else {
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);	
		}

		function consultarInfoVendedores($id){
			$arreglo = array("success"=>false,"data"=>array(),"error"=>"Verificar los datos de concepto de gastos");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$query = "select * from fn_cat_vendedor_select_id(".$id."::bigint);";
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$arreglo['error'] = $db->getError();
				}else{			
					$arreglo['success'] = true;
					$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
					$arreglo['error'] = '';
				}
			} else {
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);	
		}

		function eliminarVendedor($id, $bActivo){
			if($bActivo == 0){ $bActivo = 'false';}else{$bActivo='true';}
			$arreglo = array("success"=>false,"data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select * from fn_cat_vendedor_eliminado_logico(".$id."::bigint, ".$bActivo."::boolean);";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					$arreglo['success']=true;
				}else{
					$arreglo['error'] = $db->getError();
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);
		}

		function insertInventario($request){		
			
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"Verificar los datos de inventario");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$idProveedor = ($request['tipoInventario'] == 'PROVEEDOR' ? $request['id_tipo'] : 0);
				$idConcepto = ($request['tipoInventario'] == 'CONCEPTO_GASTOS' ? $request['id_tipo'] : 0);
				$idInventario = ($request['idInventario'] == ''? 0 : $request['idInventario']);
				$query = "select * from fn_inventario_insert(".$idInventario."::bigint,".$request['factura']."::bigint, ".$request['subtotal']."::float, ".$request['iva']."::float,".$request['montototal']."::float, ".$idProveedor."::bigint, ".$idConcepto."::bigint,'".$request['fecha_compra']."'::timestamp, ".$_SESSION['keyx']."::bigint, '".$request['tipoInventario']."'::varchar);";
				//echo $query;
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$arreglo['success'] = false;
					$arreglo['error'] = $db->getError();
				}else{			
					$arreglo['success'] = true;
					$arreglo['error'] = '';
				}
			} else {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}
			closeConexion($db);
			echo json_encode($arreglo);	
		}

		function llenarGridIventario(){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select * from fn_cat_inventario_select() WHERE status != 'DEVOLUCION';";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					foreach ($rs AS $valor) {
						$id_inventario = $valor['id_inventario'];
						$style = '';
						$btnCheckIn = '';
						if($valor['tienedetalle'] == '0' && $valor['id_proveedor'] > 0 ){
							$style = ' style = "background-color: #ED426A" '; 
						}
						if($valor['id_proveedor'] == 0){
							$tipo = $valor['nombre_concepto'];
						}else{
							$tipo = $valor['nombre_proveedor']; 
						}

						$html .= '<tr id="row_'.$id_inventario.'" '.$style.'>';

						$html .= '<td >'.$valor['folio_factura'].'</td>';
						$html .= '<td >'.$valor['subtotal'].'</td>';
						$html .= '<td >'.$valor['monto_iva'].'</td>';
						$html .= '<td >'.$valor['monto_total'].'</td>';
						$html .= '<td >'.$tipo.'</td>';
						$html .= '<td >'.$valor['fecha_compra'].'</td>';
						$html .= '<td >'.$valor['status'].'</td>';
						
						$html .= '<td  id="accion_'.$id_inventario.'">';

						$btnConfirmarProveedor = '&nbsp;&nbsp;<a onclick="revisarTotales('.$id_inventario.')" class="glyphicon glyphicon-thumbs-up	" style = "cursor:pointer;font-size:1.5em;" title="Confirmar Factura" ></a>';						

						if($valor['status'] != 'CONFIRMADO'){
							if($valor['mostrar'] =='EDITAR' ){
								$html .= '<a href="ajax/modal_inventario.php?id='.$id_inventario.'" class="fa fa fa-edit txt-color-gray hidden-md hidden-sm hidden-xs" data-toggle="modal" data-target="#remoteModal" id="editarProveedor" title="Editar" style="font-size:1.5em;"></a>';
							}
							if($valor['nombre_proveedor'] != ''){
								$html .= '&nbsp;&nbsp;<a href="ajax/modal_inventario_detalle.php?id='.$id_inventario.'" class="glyphicon glyphicon-plus	" 
								style = "cursor:pointer;font-size:1.5em;"data-toggle="modal" data-target="#remoteModal" title="Agregar Articulos" ></a>';
								$html.=($style == '' ? $btnConfirmarProveedor:'');
							}
						}
						$html.='</td>';

						$html .= '</tr>';
					}
					$arreglo['success']=true;
					$arreglo['data'] = array('html'=>$html);
				}else{
					$arreglo['error'] = $db->getError();	
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);
		}
	function consultarInfoInventario($id){
			$arreglo = array("success"=>false,"data"=>array(),"error"=>"Verificar los datos de inventario");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$query = "select * from fn_cat_inventario_select_id(".$id."::bigint);";
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$arreglo['error'] = $db->getError();
				}else{			
					$arreglo['success'] = true;
					$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
					$arreglo['error'] = '';
				}
			} else {
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);	
	}
		function consultaProveedores($term){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"Verificar los datos de proveedores");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$query = "select idproveedor as id, nombre_proveedor as value, nombre_proveedor as label from fn_cat_proveedores_select() where activo = 'ACTIVO' and nombre_proveedor like '%".strtoupper($term['term'])."%';";
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$arreglo['error'] = $db->getError();
				}else{			
					$arreglo['success'] = true;
					$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
					$arreglo['error'] = '';
				}
			} else {
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);	
		}
		function consultaConceptoGastos($term){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"Verificar los datos de concepto gastos");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$query = "select idconcepto as id, concepto as value, concepto as label from fn_cat_concepto_gastos_select() where concepto like '%".strtoupper($term['term'])."%';";
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$arreglo['error'] = $db->getError();
				}else{			
					$arreglo['success'] = true;
					$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
					$arreglo['error'] = '';
				}
			} else {
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);	
		}

		function insertInventarioDetalle($request){		
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"Verificar los datos de inventario");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$id = ($request['idInventarioDetalle'] == ''? 0 : $request['idInventarioDetalle']);

				$query = "select * from fn_inventario_detalle_insert(".$id."::bigint,".$request['idInventario']."::bigint, ".$request['idArticulo']."::bigint, ".$request['cantidad']."::integer,".$request['costo_compra']."::float,'1900-01-01'::timestamp);";
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$arreglo['success'] = false;
					$arreglo['error'] = $db->getError();
				}else{			
					$arreglo['success'] = true;
					$arreglo['error'] = '';
				}
			} else {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}
			closeConexion($db);
			echo json_encode($arreglo);	
		}

		function consultaArticulos($term){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"Verificar los datos de los articulos");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$query = "select id_articulo as id, descripcion as value, descripcion as label from fn_cat_articulos_select() where descripcion like '%".strtoupper($term['term'])."%';";
				
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$arreglo['error'] = $db->getError();
				}else{			
					$arreglo['success'] = true;
					$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
					$arreglo['error'] = '';
				}
			} else {
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);	
		}


		function llenarGridIventarioDetalle($request){

			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select * from fn_cat_inventario_detalle_select_id(".$request['id']."::bigint, ".$request['idInventarioDetalle']."::bigint);";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					foreach ($rs AS $valor) {
						$idInventarioDetalle = $valor['id_inventario_detalle'];
						$html .= '<tr id="row_'.$idInventarioDetalle.'">';
						//$html .= '<td id="row_'.$id_vendedor.'">'.$id_vendedor.'</td>';
						$html .= '<td >'.$valor['id_articulo'].'</td>';
						$html .= '<td >'.$valor['articulo'].'</td>';
						$html .= '<td >'.$valor['cantidad'].'</td>';
						$html .= '<td >'.$valor['costo_compra'].'</td>';
						$html .= '<td >'.$valor['costo_unitario_compra'].'</td>';
						$html .= '<td >'.$valor['activo'].'</td>';
						
						$html .= '<td  id="accion_'.$idInventarioDetalle.'">';

						if($valor['activo'] != 'NO_ACTIVO'){
							$html .= '<a onclick="editarArticulo('.$valor['id_inventario'].', '.$valor['id_inventario_detalle'].');" class="glyphicon glyphicon glyphicon-edit	" 
							style = "cursor:pointer;font-size:1.5em;" title="Editar Articulos" ></a>';
							$html.='&nbsp;&nbsp;<a onclick="eliminadoLogicoInventarioDetalle('.$valor['id_inventario'].', '.$valor['id_inventario_detalle'].',0)" class="glyphicon glyphicon-remove" 
							style = "cursor:pointer;font-size:1.5em;" title="Eliminar" ></a></td>';	
						}
						$html .= '</tr>';
					}
					$arreglo['success']=true;
					$arreglo['data'] = array('html'=>$html);
				}else{
					$arreglo['error'] = $db->getError();	
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);
		}

		function consultarInfoInventarioDetalle($id, $idDetalle){
			$arreglo = array("success"=>false,"data"=>array(),"error"=>"Verificar los datos de concepto de gastos");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$query = "select * from fn_cat_inventario_detalle_select_id(".$id."::bigint,".$idDetalle."::bigint);";
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$arreglo['error'] = $db->getError();
				}else{			
					$arreglo['success'] = true;
					$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
					$arreglo['error'] = '';
				}
			} else {
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);	
		}


		function eliminarInventarioDetalle($request){
			$bActivo = null;
			if($request['activo'] == 0){ $bActivo = 'false';}else{$bActivo='true';}
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select * from fn_cat_inventario_detalle_eliminado_logico(".$request['idInventario']."::bigint, ".$request['idInventarioDetalle']."::bigint, ".$bActivo."::boolean);";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					$arreglo['success']=true;
				}else{
					$arreglo['error'] = $db->getError();
				}
				
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);
		}
		
	//Ver datos fiscales del clientes.
	function VerDatosDelCte($rs,$vClienteKeyx){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		$opcion = '';
		foreach ($rs AS $valor) {
			$vColonia ='';
			if ($valor['colonia'] !=''){
				$vColoniaArray = explode( ' - ', $valor['colonia']);
				$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
			}
			$opcion .="<tr id='row_".$valor['keyx']."'>";
			$opcion .= '<td>CALLE: <label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_int">'.$valor['numexterior'].'</label>&nbsp;<label id="numero_ext">'.$valor['numinterior'].'</label>&nbsp;';
			$opcion .= '</br>COLONIA: <label id="colonia">'.$vColonia.'</label>&nbsp; CP: <label id="codigopostal">'.$valor['codigopostal'].'</label>';
			$opcion .= '</br>REFERENCIAS: <span style="font-size: 9px;"> (&nbsp;<label id="referencias">'.$valor['observaciones'].'&nbsp;).</span></label>';
			$opcion .= '</td>';
			$opcion .= '<td style="text-align:center;"><a onclick="MensajeSmartEliminarDatosFiscales('. $valor['cliente'].','.$valor['keyx'].');" class="glyphicon glyphicon-remove" style = "cursor:pointer;font-size:1.5em;" title="Eliminar" ></td>';
			//$opcion .= '<td style="text-align:center;"><a onclick="redirectModificarRFC('. $valor['cliente'].','.$valor['keyx'].');" class="glyphicon glyphicon-pencil" style = "cursor:pointer;font-size:1.5em;" title="Modificar" ></td>';
			$opcion .= "</tr>";
		}
		
		$arreglo['success'] = true;
		$arreglo['data'] = $opcion;
		$arreglo['error'] = '';
		return $arreglo;
	}
	
	function consultarClientesRFC(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_cte_select() ORDER BY nombres,apellidos;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .="<tr id='row_".$valor['keyx']."'>";
					$opcion .= '<td  id="keyx_'.$valor['keyx'].'">'.$valor['keyx'].'</td>';
					$opcion .= '<td  id="desc_'.$valor['nombres'].'">'.$valor['nombres'].' '. $valor['apellidos']. '</td>';
					$opcion .= '<td width="15%" id="cel_'.$valor['telcelular'].'">'.$valor['telcelular'].'</td>';
					$opcion .= '<td width="15%" id="casa_'.$valor['telcasa'].'">'.$valor['telcasa'].'</td>';
					$opcion .= '<td width="10%" style="text-align: center;"><a href="ajax/ver_domicilios.php?tel='.$valor['telcasa'].'&cel='.$valor['telcelular'].'" title="Ver domicilios del cliente" data-toggle="modal" data-target="#remoteModal" id="editar" style="text-align:center;"><i class="fa fa-eye">&nbsp;</i>Ver</a></td>';
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return json_encode($arreglo);
	}
		
	//Captura de registro del cliente.
	function pedidoGrabarCliente($vNombres,$vApellidos,$vTelefonoCasa,$vTelefonoCelular){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cte_insert('$vNombres','$vApellidos','$vTelefonoCasa','$vTelefonoCelular') AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente al cliente!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "El cliente ya se encontraba registrado!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}

	function fn_revisarTotalesInventarios($id){
			$arreglo = array("success"=>false,"data"=>array(),"error"=>"");
			$db = getConexionTda();

			if ($db->getError() == '') {
				$query = "select * from fn_revisarTotalesInventarios(".$id."::integer);";
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$arreglo['error'] = $db->getError();
				}else{			
					$arreglo['success'] = true;
					$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
					$arreglo['error'] = '';
				}
			} else {
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);
	}

	function insertArticulos($request){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"Verificar del articulos");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$idArticulo = ($request['idArticulo'] == ''? 0 : $request['idArticulo']);
				$query = "select * from fn_articulo_insert(".$idArticulo."::bigint,'".$request['nombre_articulo']."':: VARCHAR, ".$request['costo_venta_articulo']."::float);";
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$sRetorno =$db->getError();
					$arreglo['success'] = false;
					$arreglo['error'] = $sRetorno;
				}else{
					$arreglo['success'] = true;
					$arreglo['error'] = '';
				}
			} else {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}
			closeConexion($db);
			echo json_encode($arreglo);	
	}

		function llenarGridArticulos(){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$query = "select * from fn_cat_articulos_select();";
				
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$arreglo['error'] = $db->getError();
				}else{

					$html = '';
					foreach ($rs AS $valor) {
						$id_articulo = $valor['id_articulo'];
						$html .= '<tr id="row_'.$id_articulo.'">';
						$html .= '<td >'.$valor['descripcion'].'</td>';
						$html .= '<td >'.$valor['costo_unitario_venta'].'</td>';
						$html .= '<td >'.$valor['existencia'].'</td>';
						$html .= '<td >'.$valor['activo'].'</td>';
						
						$html .= '<td  id="accion_'.$id_articulo.'">';

						if($valor['activo'] != 'NO_ACTIVO'){
							$html .= '<a href="ajax/modal_articulo.php?id='.$id_articulo.'"  class="glyphicon glyphicon-edit	" 
							style = "cursor:pointer;font-size:1.5em;" data-toggle="modal" data-target="#remoteModal"  title="Editar Articulos" ></a>';
							$html .= '&nbsp;&nbsp;<a href="ajax/modal_articulo_precios.php?id='.$id_articulo.'"  class="glyphicon glyphicon-list-alt" style = "cursor:pointer;font-size:1.5em;" data-toggle="modal" data-target="#remoteModal"  title="Editar Precios Articulos" ></a>';
							$html.='&nbsp;&nbsp;<a onclick="eliminadoLogicoArticulos('.$id_articulo.',0)" class="glyphicon glyphicon-remove" 
							style = "cursor:pointer;font-size:1.5em;" title="Eliminar" ></a>';	
						}else{
							$html.='<a onclick="reactivarArticulo('.$id_articulo.',1)" class="glyphicon glyphicon-ok-sign" 
							style = "cursor:pointer;font-size:1.5em;" title="Eliminar" ></a>';	
						}
						$html .= '</td></tr>';
					}
					$arreglo['success']=true;
					$arreglo['data'] = array('html'=>$html);
				}
			} else {
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);	
		}

		function consultarInfoArticulo($id){
			$arreglo = array("success"=>false,"data"=>array(),"error"=>"");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$query = "select * from fn_cat_articulos_select_id(".$id."::bigint);";
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$arreglo['error'] = $db->getError();
				}else{			
					$arreglo['success'] = true;
					$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
				}
			} else {
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);	
		}

		function eliminarArticulo($id, $bActivo){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				if($bActivo == 0){ $bActivo = 'false';}else{$bActivo='true';}
				$query = "select fn_articulos_eliminado_logico as valida
						  from fn_articulos_eliminado_logico(".$id."::bigint,".$bActivo."::boolean);";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					$arreglo['success']=true;
					$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
				}else{
					$arreglo['error'] = $db->getError();
				}
				
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);
		}

		function fn_confirmarInventario($id, $idUsuario){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
			//if($bActivo == 0){ $bActivo = 'false';}else{$bActivo='true';}
				$query = "select * from fn_agregar_existencia(".$id."::bigint,".$idUsuario."::bigint);";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					$arreglo['success']=true;
				}else{
					$arreglo['error'] = $db->getError();
				}
				
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);
		}

		function consultarInfoArticuloPrecio($id){
			$arreglo = array("success"=>false,"data"=>array(),"error"=>"");
			$db = getConexionTda();

			$sRetorno ='';
			if ($db->getError() == '') {
				$query = "select * from fn_articulos_precios_select_id(".$id."::bigint);";
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$arreglo['error'] = $db->getError();
				}else{			
					$arreglo['success'] = true;
					$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
				}
			} else {
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);	
		}

		function fn_articulos_precio($request){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "Select * from fn_articulos_precio(".$request['idArticulo']."::bigint, ".$request['veces_ganancia']."::float);";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					$arreglo['success']=true;
				}else{
					$arreglo['error'] = $db->getError();
				}
				
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);
		}

	function llenarGridAbonos($id){
		$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
		$db = getConexionTda();
		if($db->getError() == ''){
			$query = "select 
						id_abonos, folio_factura, id_usuario, nombre, abono,cobrador,flag_corte, fecha_corte,
						to_timestamp(fecha_registro::varchar, 'yyyy-mm-dd HH24:MI:SS') as fecha_registro
						from fn_ctl_abonos_select_id($id::bigint) order by fecha_registro desc;";
			
			$rs = $db->query($query);
			if($db->getError() == ''){
				$html = '';
				foreach ($rs AS $valor) {
					$id = $valor['id_abonos'];
					$html .= '<tr>';
					$html .= '	<td >'.$valor['nombre'].'</td>';
					$html .= '	<td>'.$valor['abono'].'</td>';
					$html .= '	<td>'.$valor['cobrador'].'</td>';
					$html .= '	<td>'.$valor['fecha_registro'].'</td>';
					$html .= '<td >';
					$html .= '	<a style = "font-size:1.5em;cursor:pointer;" 
									class="glyphicon glyphicon-remove" 
									onClick="cancelarAbonos('.$id.');"								
									title="Cancelar Abono" >
								</a>
							  </td>';
					$html .= '</tr>';
				}
				$arreglo['success']=true;
				$arreglo['data'] = array('html'=>$html);
			}else{
				$arreglo['error'] = $db->getError();
			}
		}else{
			$arreglo['error'] = $db->getError();
		}
			closeConexion($db);
			return json_encode($arreglo);
		}
		
		//obtiene el folio de la orden.
		function obtenerFolioOrden(){
			$arreglo = array("success"=>"false","data"=>"","error"=>"No existe consecutivo");
			$db = getConexionTda();
			$sRetorno ='';
			if ($db->getError() == '') {
				$rs = $db->query("SELECT * FROM fn_pedidosfolio_select() AS retorno;");
				if ($db->getError() != "") {
					$sRetorno =$db->getError();
					$arreglo['success'] = false;
					$arreglo['error'] = $sRetorno;
				}else{
					$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
					$sRetorno =$rs_final[0];
					
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = '';
				}
			} else {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}
			closeConexion($db);
			return $arreglo;
		}
		
	//Combo de existencia
	function cmbArticulosExistencia(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_invent_select() ORDER BY descripcion;");
						
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '<option value="0">Seleccione un art&iacute;culo</option>';
				foreach ($rs AS $valor) {
					$opcion .= '<option value="'.$valor['id_articulo'].'">'.$valor['descripcion'].'</option>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Combo de tipos de pago
	function cmbTipoPago(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_tipopago_select() ORDER BY descripcion;");
						
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				//$opcion = '<option value="0">Formas de pago</option>';
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .= '<option value="'.$valor['id_pago'].'">'.$valor['descripcion'].'</option>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Combo de plazo en meses
	function cmbPlazo($vTipoPago){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_plazospago_select($vTipoPago) ORDER BY id_plazo;");
						
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				//$opcion = '<option value="0">Formas de pago</option>';
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .= '<option value="'.$valor['id_plazo'].'">'.$valor['descripcion'].'</option>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Combo de periodo de cobro
	function cmbPeriodoCobro($vTipoPago){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_periodocobro_select($vTipoPago) ORDER BY id_periodo;");
						
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				//$opcion = '<option value="0">Formas de pago</option>';
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .= '<option value="'.$valor['id_periodo'].'">'.$valor['descripcion'].'</option>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Combo de periodo de cobro
	function variables_select($Keyx,$vEmpresa){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_variables_select($Keyx,$vEmpresa);");
						
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
			
				$arreglo['success'] = true;
				$arreglo['data'] = $sRetorno;
				$arreglo['error'] = 'Se registr&oacute; exitosamente el art&iacute;culo!.';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Combo de existencia
	function consultarArticuloElegido($bArticulo){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_invent_select($bArticulo::BIGINT);");
						
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
			
				$arreglo['success'] = true;
				$arreglo['data'] = $sRetorno;
				$arreglo['error'] = 'Se registr&oacute; exitosamente el art&iacute;culo!.';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Datos de plazo
	function itemPlazo($iTipoPago,$iPlazo,$bKeyx){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select (NOW()::DATE + $bKeyx + num_dias) AS fechavence from fn_plazospago_select($iTipoPago) WHERE id_plazo= $iPlazo;");
						
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
			
				$arreglo['success'] = true;
				$arreglo['data'] = $sRetorno;
				$arreglo['error'] = 'Se consulto exitosamente la fecha del plazo!.';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Grabar datos de referencias
	function grabadoReferenciasPedido($bFolioPedido,$iNumReferencia,$vNombre,$vTelefono,$Domicilio){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_ctl_referencias_insert($bFolioPedido::BIGINT,$iNumReferencia::INTEGER,'$vNombre'::VARCHAR,'$vTelefono'::VARCHAR,'$Domicilio'::VARCHAR);");
						
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
			
				$arreglo['success'] = true;
				$arreglo['data'] = $sRetorno;
				$arreglo['error'] = 'Se consulto exitosamente la fecha del plazo!.';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}

	function consultarInfoAbonos($id){
		$arreglo = array("success"=>false,"data"=>array(),"error"=>"");
		$db = getConexionTda();

		$sRetorno ='';
		if ($db->getError() == '') {
			$query = "select * from fn_ctl_abonos_select_id(".$id."::bigint);";
			$rs = $db->query($query);
			if ($db->getError() != "") {
				$arreglo['error'] = $db->getError();
			}else{			
				$arreglo['success'] = true;
				$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
			}
		} else {
			$arreglo['error'] = $db->getError();
		}
		closeConexion($db);
		return json_encode($arreglo);	
	}

	function insertAbonos($request){
		$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
		$db = getConexionTda();
		if( $db->getError() == '' ) {
			$query = "select * from fn_ctl_abonos_insert(".$request['idFolioPedido']."::bigint,".$_SESSION['keyx']."::bigint,".$request['abono_propuesto']."::float,'".$request['id_cobrador']."'::varchar,".$request['pago_completo']."::smallint);";
			$rs = $db->query( $query );
			if ( $db->getError() != "" ) {
				$arreglo['success'] = false;
				$arreglo['error'] = $db->getError();
			} else {
				$arreglo['success'] = true;
				$arreglo['error'] = '';
			}
		} else {
			$arreglo['success'] = false;
			$arreglo['error'] = $db->getError();
		}
		closeConexion($db);
		echo json_encode($arreglo);	
	}

	function cancelarAbonos($request){
		$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
		$db = getConexionTda();
		if ($db->getError() == '') {
			$query = "select *from fn_his_cancelaciones_abono_insert(".$request['idAbono']."::bigint,".$_SESSION['keyx']."::bigint,''::varchar);";
			$rs = $db->query($query);
			if ($db->getError() != "") {
				$arreglo['success'] = false;
				$arreglo['error'] = $db->getError();
			}else{			
				$arreglo['success'] = true;
				$arreglo['error'] = '';
			}
		} else {
			$arreglo['success'] = false;
			$arreglo['error'] = $db->getError();
		}
		closeConexion($db);
		echo json_encode($arreglo);	
	}
	
	
	//Registro de articulos del pedido del cliente.
	function pedidoGrabarArticuloDePedidoNuevo($iFolioPedido,$iId_articulo,$iCantidad,$vHorarioRenta,$esRenta,$descuento){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_articulospedidosrentado_insert($iFolioPedido::BIGINT,$iId_articulo::BIGINT,$iCantidad::INTEGER,'',0::INTEGER,$descuento::NUMERIC) AS retorno;");
			
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente el sku!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "El sku ya se encontraba registrado!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Registro de articulos del pedido del cliente.
	function pedidoGrabarPedido($bFolioPedido,$iClientekeyx,$iDireccionpedidokeyx,$bNumReferencias,$tFechaVenta,$dFechaPrimerCobro,$dFechaVencimiento,$iPlazo,$iPeriodoCobro,$iTipoPago,$bEmpleado,$bSupervisor,$bGerente,$bNumContrato,$bNumPapeleta,$bNum_descuento){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			//$flag_entregamismodia = ($fechaentrega == $fecharecolecta) ? 1:0;
			//$rs = $db->query("select * from fn_pedidos_insert($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,'$fechaentrega'::DATE,'$fecharecolecta'::DATE,$flag_entregamismodia,'$hora1','$hora2',1,$empleado,'$vManteleria',$flete,$iIva,$flag_descuento,$porcentajedescuento,$iGarantia) AS retorno;");	
			$rs = $db->query("select * from fn_pedidos_insert($bFolioPedido,$iClientekeyx,$iDireccionpedidokeyx,$bNumReferencias,'$tFechaVenta','$dFechaPrimerCobro','$dFechaVencimiento',$iPlazo,$iPeriodoCobro,$iTipoPago,$bEmpleado,$bSupervisor,$bGerente,$bNumContrato,$bNumPapeleta,$bNum_descuento) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se registr&oacute exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "El pedido ya se encontraba registrado!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Combo carga el combo de los vendedores
	function cmbVendedor(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_cat_vendedor_select() WHERE id_puesto = 2 AND UPPER(activo) = 'ACTIVO';");
						
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '<option value="0">N/A</option>';
				foreach ($rs AS $valor) {
					$opcion .= '<option value="'.$valor['id_vendedor'].'">'.$valor['nombre'].'</option>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Combo carga el combo de los vendedores
	function cmbSupervisor(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_cat_vendedor_select() WHERE id_puesto = 1 AND UPPER(activo) = 'ACTIVO';");
						
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '<option value="0">N/A</option>';
				foreach ($rs AS $valor) {
					$opcion .= '<option value="'.$valor['id_vendedor'].'">'.$valor['nombre'].'</option>';
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Generar reporte de pedidos pendientes
	function verPedidosDelDia($Fecha){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosacredito_select('$Fecha'::DATE) ORDER BY region DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$opcion .= '<tr id="'.$valor['num_foliopedido'].'" title="'.$valor['num_foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><strong>ARTICULOS:</strong>&nbsp;<label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
					/*if($valor['descuento'] !== 1){
						if ($vTotal > $valor['abono']){
							if ($valor['abono'] > 0){
								//$folioConsulta = $valor['foliopedido'];
								$vRecibio = '';
								$vRecibio = quienAbonoXFolio($folioConsulta);
								$vRecibio = $vRecibio['data'];
								if ($vRecibio != ''){
									$vRecibio = ' POR:'.$vRecibio;
								}
								$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].$vRecibio.'</label>&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
							}else{
								$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;';
							}
						}else{
							$folioConsulta = $valor['foliopedido'];
							$vRecibio = '';
							$vRecibio = quienAbonoXFolio($folioConsulta);
							$vRecibio = $vRecibio['data'];
							if ($vRecibio != ''){
								$vRecibio = ' POR:'.$vRecibio;
							}	
							$opcion .= 'TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;PAGADO '.$vRecibio.'&nbsp;';
						}
						
					}else{
						$opcion .= 'TOTAL:&nbsp;$NO COBRAR';
					}*/
					$opcion .= '</br><label id="calle"><strong>DOMICILIO:</strong>&nbsp;'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold"><strong>CLIENTE:</strong>&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['num_foliopedido'].'</label>';	
					$opcion .= '</br><strong>FECHA:</strong>&nbsp;<label id="fecha_venta">'.$valor['fecha_venta'].'</label>&nbsp;|&nbsp;<strong>TIPO PAGO:</strong>&nbsp;<label id="tipopago">'.$valor['nom_tipopago'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>PLAZO:</strong>&nbsp;<label id="plazo">'.$valor['nom_plazo'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>COBRO:</strong>&nbsp;<label id="plazo">'.$valor['nom_periodocobro'].'</label>';
					$opcion .= '</br><strong>VENDEDOR:</strong>&nbsp;<label id="nom_ejecutivo">'.$valor['nom_ejecutivo'].'</label>';
					$opcion .= '|&nbsp;<strong>SUPERVISOR:</strong>&nbsp;<label id="nom_supervisor">'.$valor['nom_supervisor'].'</label>';
					$opcion .= '|&nbsp;<strong>JEFE GPO:</strong>&nbsp;<label id="nom_jefegpo">'.$valor['nom_jefegpo'].'</label>';
					$opcion .='</td>';
					
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['num_foliopedido'].'" style="display:none"><div class="btn-group-vertical">';
					$opcion .= '<button type="button" title="Cancelar el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['num_foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Cancelar</button><br/>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['num_foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a><br/>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button><br/>';
					
					$opcion .= '<a id="modificarcobranza" href="#ajax/modal_cambiarfechacobranza.php?id='.$valor['num_foliopedido'].'&d='.$Fecha.'" title="Modificar la cobranza" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Modificar dia cobranza</a><br/></div>	';
					//$opcion .= '<button type="button" title="Modificar cobranza" class="btn btn-info btn-xs noMostrarPrint" name=cobro"'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/modal_cambiarfechacobranza.php?f='.$valor['num_foliopedido'].'&d='.$Fecha.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Modificar cobranza</button></div></td>';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Elimina el folio de un pedido.
	function CancelarPedido($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidos_delete($iFolioPedido::BIGINT) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se cancel&oacute; exitosamente la factura!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No fue posible cancelar la factura!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de pedidos cancelados en el mes
	function verCancelaciones(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("	SELECT * FROM fn_pedidosacreditocancelados_select()
								WHERE EXTRACT(MONTH FROM fecha_venta::DATE) = EXTRACT(MONTH FROM NOW()::DATE) 
								AND EXTRACT(YEAR FROM fecha_venta::DATE) = EXTRACT(YEAR FROM NOW()::DATE)
								ORDER BY num_foliopedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$opcion .= '<tr id="'.$valor['num_foliopedido'].'" title="'.$valor['num_foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><strong>ARTICULOS:</strong>&nbsp;<label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
					$opcion .= '</br><label id="calle"><strong>DOMICILIO:</strong>&nbsp;'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold"><strong>CLIENTE:</strong>&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['num_foliopedido'].'</label>';	
					$opcion .= '</br><strong>FECHA:</strong>&nbsp;<label id="fecha_venta">'.$valor['fecha_venta'].'</label>&nbsp;|&nbsp;<strong>TIPO PAGO:</strong>&nbsp;<label id="tipopago">'.$valor['nom_tipopago'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>PLAZO:</strong>&nbsp;<label id="plazo">'.$valor['nom_plazo'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>COBRO:</strong>&nbsp;<label id="plazo">'.$valor['nom_periodocobro'].'</label>';
					$opcion .= '</br><strong>VENDEDOR:</strong>&nbsp;<label id="nom_ejecutivo">'.$valor['nom_ejecutivo'].'</label>';
					$opcion .= '|&nbsp;<strong>SUPERVISOR:</strong>&nbsp;<label id="nom_supervisor">'.$valor['nom_supervisor'].'</label>';
					$opcion .= '|&nbsp;<strong>JEFE GPO:</strong>&nbsp;<label id="nom_jefegpo">'.$valor['nom_jefegpo'].'</label>';
					$opcion .='</td>';
					
					$opcion .= '<!--td class="pull-right" name="controles" id="controles_'.$valor['num_foliopedido'].'" style="display:none"><div class="btn-group-vertical">';
					$opcion .= '<button type="button" title="Cancelar el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['num_foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Cancelar</button><br/>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['num_foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a><br/>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div></td-->';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de pedidos facturados hoy
	function verFacturadosHoy(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_pedidosfacturados_select() WHERE fecha_venta::DATE = NOW()::DATE ORDER BY num_foliopedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$opcion .= '<tr id="'.$valor['num_foliopedido'].'" title="'.$valor['num_foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;">';
					$opcion .= '<strong>FOLIO:</strong>&nbsp;<label id="folio">'.$valor['num_foliopedido'].'</label>|&nbsp;<strong>CONTRATO:</strong>&nbsp;<label id="folio">'.$valor['num_contrato'].'</label>|&nbsp;<strong>PAPELETA:</strong>&nbsp;<label id="folio">'.$valor['num_papeleta'].'</label>';
					$opcion .= '</br><strong>ARTICULOS:</strong>&nbsp;<label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span>.';
					$opcion .= '</br><label id="calle"><strong>DOMICILIO:</strong>&nbsp;'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold"><strong>CLIENTE:</strong>&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>';
					$opcion .= '</br><strong>FECHA:</strong>&nbsp;<label id="fecha_venta">'.$valor['fecha_venta'].'</label>&nbsp;|&nbsp;<strong>TIPO PAGO:</strong>&nbsp;<label id="tipopago">'.$valor['nom_tipopago'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>PLAZO:</strong>&nbsp;<label id="plazo">'.$valor['nom_plazo'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>COBRO:</strong>&nbsp;<label id="plazo">'.$valor['nom_periodocobro'].'</label>';
					$opcion .= '</br><strong>VENDEDOR:</strong>&nbsp;<label id="nom_ejecutivo">'.$valor['nom_ejecutivo'].'</label>';
					$opcion .= '|&nbsp;<strong>SUPERVISOR:</strong>&nbsp;<label id="nom_supervisor">'.$valor['nom_supervisor'].'</label>';
					$opcion .= '|&nbsp;<strong>JEFE GPO:</strong>&nbsp;<label id="nom_jefegpo">'.$valor['nom_jefegpo'].'</label>';
					$opcion .='</td>';
						$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['num_foliopedido'].'" style="display:none"><div class="btn-group-vertical">';
					if ($valor['num_tipopago'] > 1){
						$opcion .= '<button type="button" title="Cancelar el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['num_foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Cancelar</button><br/>';
						$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['num_foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a><br/>';
					}
						$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div></td>';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de pedidos facturados hoy
	function verFacturadosPeriodo($vFechaInicio,$vFechaFin){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_pedidosfacturados_select() WHERE fecha_venta::DATE BETWEEN '$vFechaInicio'::DATE AND '$vFechaFin'::DATE ORDER BY num_foliopedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$opcion .= '<tr id="'.$valor['num_foliopedido'].'" title="'.$valor['num_foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;">';
					$opcion .= '<strong>FOLIO:</strong>&nbsp;<label id="folio">'.$valor['num_foliopedido'].'</label>|&nbsp;<strong>CONTRATO:</strong>&nbsp;<label id="folio">'.$valor['num_contrato'].'</label>|&nbsp;<strong>PAPELETA:</strong>&nbsp;<label id="folio">'.$valor['num_papeleta'].'</label>';
					$opcion .= '</br><strong>ARTICULOS:</strong>&nbsp;<label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span>.';
					$opcion .= '</br><label id="calle"><strong>DOMICILIO:</strong>&nbsp;'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold"><strong>CLIENTE:</strong>&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['num_foliopedido'].'</label>';	
					$opcion .= '</br><strong>FECHA:</strong>&nbsp;<label id="fecha_venta">'.$valor['fecha_venta'].'</label>&nbsp;|&nbsp;<strong>TIPO PAGO:</strong>&nbsp;<label id="tipopago">'.$valor['nom_tipopago'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>PLAZO:</strong>&nbsp;<label id="plazo">'.$valor['nom_plazo'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>COBRO:</strong>&nbsp;<label id="plazo">'.$valor['nom_periodocobro'].'</label>';
					$opcion .= '</br><strong>VENDEDOR:</strong>&nbsp;<label id="nom_ejecutivo">'.$valor['nom_ejecutivo'].'</label>';
					$opcion .= '|&nbsp;<strong>SUPERVISOR:</strong>&nbsp;<label id="nom_supervisor">'.$valor['nom_supervisor'].'</label>';
					$opcion .= '|&nbsp;<strong>JEFE GPO:</strong>&nbsp;<label id="nom_jefegpo">'.$valor['nom_jefegpo'].'</label>';
					$opcion .='</td>';
					
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['num_foliopedido'].'" style="display:none"><div class="btn-group-vertical">';
					if ($valor['num_tipopago'] > 1){
						$opcion .= '<button type="button" title="Cancelar el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['num_foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Cancelar</button><br/>';
						$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['num_foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a><br/>';
					}
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div></td>';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Generar reporte de pedidos cancelados en el mes
	function verCancelacionesPeriodo($vFechaInicio,$vFechaFin){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("	SELECT * FROM fn_pedidosacreditocancelados_select() WHERE fecha_venta::DATE BETWEEN '$vFechaInicio'::DATE AND '$vFechaFin'::DATE ORDER BY num_foliopedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$opcion .= '<tr id="'.$valor['num_foliopedido'].'" title="'.$valor['num_foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><strong>ARTICULOS:</strong>&nbsp;<label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. ';
					$opcion .= '</br><label id="calle"><strong>DOMICILIO:</strong>&nbsp;'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold"><strong>CLIENTE:</strong>&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['num_foliopedido'].'</label>';	
					$opcion .= '</br><strong>FECHA:</strong>&nbsp;<label id="fecha_venta">'.$valor['fecha_venta'].'</label>&nbsp;|&nbsp;<strong>TIPO PAGO:</strong>&nbsp;<label id="tipopago">'.$valor['nom_tipopago'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>PLAZO:</strong>&nbsp;<label id="plazo">'.$valor['nom_plazo'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>COBRO:</strong>&nbsp;<label id="plazo">'.$valor['nom_periodocobro'].'</label>';
					$opcion .= '</br><strong>VENDEDOR:</strong>&nbsp;<label id="nom_ejecutivo">'.$valor['nom_ejecutivo'].'</label>';
					$opcion .= '|&nbsp;<strong>SUPERVISOR:</strong>&nbsp;<label id="nom_supervisor">'.$valor['nom_supervisor'].'</label>';
					$opcion .= '|&nbsp;<strong>JEFE GPO:</strong>&nbsp;<label id="nom_jefegpo">'.$valor['nom_jefegpo'].'</label>';
					$opcion .='</td>';
					
					$opcion .= '<!--td class="pull-right" name="controles" id="controles_'.$valor['num_foliopedido'].'" style="display:none"><div class="btn-group-vertical">';
					$opcion .= '<button type="button" title="Cancelar el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['num_foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Cancelar</button><br/>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['num_foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a><br/>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div></td-->';
					$opcion .= '<tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	//Generar reporte de comisiones por pagar.
	function verComisionesPorPagar(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_comisionesporventas_select() WHERE fecha_venta::DATE <=  NOW()::DATE - 7 ORDER BY num_ejecutivo;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$opcion .= '<tr id=row_'.$valor['num_foliopedido'].'><td class="noMostrarPrint" style="text-align:center"><input id=check_'.$valor['num_foliopedido'].' type="checkbox" class="selPA" value="area1" style="text-align:center"/></td><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></tr><tr>';
					//$opcion .= '<tr id="'.$valor['num_foliopedido'].'" title="'.$valor['num_foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><span><strong>ARTICULOS:</strong>&nbsp;<label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;</span>.&nbsp; TOTAL $<label id="detalle">'.$valor['total'].'</label>';
					$opcion .= '</br><label id="calle"><strong>DOMICILIO:</strong>&nbsp;'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold"><strong>CLIENTE:</strong>&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['num_foliopedido'].'</label>';	
					$opcion .= '</br><strong>FECHA:</strong>&nbsp;<label id="fecha_venta">'.$valor['fecha_venta'].'</label>&nbsp;|&nbsp;<strong>TIPO PAGO:</strong>&nbsp;<label id="tipopago">'.$valor['nom_tipopago'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>PLAZO:</strong>&nbsp;<label id="plazo">'.$valor['nom_plazo'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>COBRO:</strong>&nbsp;<label id="plazo">'.$valor['nom_periodocobro'].'</label>';
					$opcion .= '</br><strong>VENDEDOR:</strong>&nbsp;<label id="nom_ejecutivo">'.$valor['nom_ejecutivo'].'</label>';
					$opcion .= '|&nbsp;<strong>SUPERVISOR:</strong>&nbsp;<label id="nom_supervisor">'.$valor['nom_supervisor'].'</label>';
					$opcion .= '|&nbsp;<strong>JEFE GPO:</strong>&nbsp;<label id="nom_jefegpo">'.$valor['nom_jefegpo'].'</label>';
					$opcion .='</td>';
					
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['num_foliopedido'].'" ><div class="btn-group-vertical">';
					$opcion .= '<label id="num_clientecomision" class="bold" style="display:none">'.$valor['num_ejecutivo'].'</label><br>';
					$opcion .= 'VENDEDOR:<label id="nom_clientecomision" class="bold">'.$valor['nom_ejecutivo'].'</label><br>';
					$opcion .= 'COMISIÓN:$<label id="total_comision" class="semi-bold">'.$valor['comision'].'</label><br>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Factura</button>';
					/*$opcion .= '<button type="button" title="Cancelar el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['num_foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Cancelar</button><br/>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['num_foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a><br/>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div>';*/
					
					$opcion .= '</td><tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Generar reporte de comisiones para cobrador.
	function verComisionesPorCobrador(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_comisionesporcobranza_select() ORDER BY nom_ejecutivo;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$opcion .= '<tr id=row_'.$valor['num_foliopedido'].'><td class="noMostrarPrint" style="text-align:center"><input id=check_'.$valor['num_foliopedido'].' type="checkbox" class="selPA" value="area1" style="text-align:center"/></td><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></tr><tr>';
					//$opcion .= '<tr id="'.$valor['num_foliopedido'].'" title="'.$valor['num_foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><span><strong>ARTICULOS:</strong>&nbsp;<label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;</span>.&nbsp; ABONO $<label id="detalle">'.$valor['abono'].'</label>';
					$opcion .= '</br><label id="calle"><strong>DOMICILIO:</strong>&nbsp;'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold"><strong>CLIENTE:</strong>&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['num_foliopedido'].'</label>';	
					$opcion .= '</br><strong>FECHA:</strong>&nbsp;<label id="fecha_venta">'.$valor['fecha_venta'].'</label>&nbsp;|&nbsp;<strong>TIPO PAGO:</strong>&nbsp;<label id="tipopago">'.$valor['nom_tipopago'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>PLAZO:</strong>&nbsp;<label id="plazo">'.$valor['nom_plazo'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>COBRO:</strong>&nbsp;<label id="plazo">'.$valor['nom_periodocobro'].'</label>';
					$opcion .= '</br><strong>COBRADOR:</strong>&nbsp;<label id="nom_ejecutivo">'.$valor['nom_ejecutivo'].'</label>';
					$opcion .= '|&nbsp;<strong>SUPERVISOR:</strong>&nbsp;<label id="nom_supervisor">'.$valor['nom_supervisor'].'</label>';
					$opcion .= '|&nbsp;<strong>JEFE GPO:</strong>&nbsp;<label id="nom_jefegpo">'.$valor['nom_jefegpo'].'</label>';
					$opcion .='</td>';
					
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['num_foliopedido'].'" ><div class="btn-group-vertical">';
					$opcion .= '<label id="num_clientecomision" class="bold" style="display:none">'.$valor['num_ejecutivo'].'</label><br>';
					$opcion .= 'COBRADOR:<label id="nom_clientecomision" class="bold">'.$valor['nom_ejecutivo'].'</label><br>';
					$opcion .= 'COMISIÓN:$<label id="total_comision" class="semi-bold">'.$valor['comision'].'</label><br>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Factura</button>';
					/*$opcion .= '<button type="button" title="Cancelar el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['num_foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Cancelar</button><br/>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['num_foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a><br/>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div>';*/
					
					$opcion .= '</td><tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}

function llenarGridFacturasPendientesPagar(){
		$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
		$db = getConexionTda();
		if($db->getError() == ''){
			$query = "select * from fn_facturas_pendientes_pagar() order by nombre_cliente;";
			$rs = $db->query($query);
			if($db->getError() == ''){
				$html = '';
				foreach ($rs AS $valor) {
					$id = $valor['num_foliopedido'];
					$html .= '<tr >';
					$html .= '<td >'.$valor['nombre_cliente'].'</td>';
					$html .= '<td  >'.$valor['num_foliopedido'].'</td>';
					$html .= '<td  >'.$valor['num_contrato'].'</td>';
					$html .= '<td  >'.$valor['num_papeleta'].'</td>';
					$html .= '<td  >'.$valor['total_facturado'].'</td>';
					$html .= '<td  >'.$valor['total_abonado'].'</td>';
					$html .= '<td>'.$valor['fecha_venta'].'</td>';
					$html .= '<td >
								<a href="ajax/modal_abonos.php?id='.$id.'" class="fa fa-money txt-color-gray hidden-md hidden-sm hidden-xs" data-toggle="modal" data-target="#remoteModal" id="editarProveedor" title="Agregar Abonos" style="font-size:1.5em;"></a>';
					$html .= '</td>';					
					$html .= '</tr>';
				}
				$arreglo['success']=true;
				$arreglo['data'] = array('html'=>$html);
			}else{
				$arreglo['error'] = $db->getError();	
			}
		}else{
			$arreglo['error'] = $db->getError();
		}
		closeConexion($db);
		return json_encode($arreglo);
	}


	function fn_informacion_facturas_pagar($id){
		$arreglo = array("success"=>false,"data"=>array(),"error"=>"");
		$db = getConexionTda();

		$sRetorno ='';
		if ($db->getError() == '') {
			$query = "select * from fn_informacion_facturas_pagar(".$id."::bigint);";
			$rs = $db->query($query);
			if ($db->getError() != "") {
				$arreglo['error'] = $db->getError();
			}else{			
				$arreglo['success'] = true;
				$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
			}
		} else {
			$arreglo['error'] = $db->getError();
		}
		closeConexion($db);
		return json_encode($arreglo);	
	}
	
	
	//Graba las comisiones
	function PagarComisionVenta($iFolioPedido,$bCliente,$dComision){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_entregarcomision_insert($iFolioPedido,$bCliente,$dComision) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el grabado de la comision!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten de la comision!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	//Graba las comisiones
	function PagarComisionCobranza($iFolioPedido,$bCliente,$dComision){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_entregarcomisioncobranza_insert($iFolioPedido,$bCliente,$dComision) AS retorno;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] >= 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se realiz&oacute; exitosamente el grabado de la comision!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se afect&oacute; la informaci&oacuten de la comision!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Generar reporte de comisiones pagadas hoy.
	function verComisionesPagadasHoy(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_comisionespagadasporventas_select(NOW()::DATE,NOW()::DATE) ORDER BY num_ejecutivo;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$opcion .= '<tr id=row_'.$valor['num_foliopedido'].'><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr>';
					//$opcion .= '<tr id="'.$valor['num_foliopedido'].'" title="'.$valor['num_foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><span><strong>ARTICULOS:</strong>&nbsp;<label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;</span>.&nbsp; TOTAL $<label id="detalle">'.$valor['total'].'</label>';
					$opcion .= '</br><label id="calle"><strong>DOMICILIO:</strong>&nbsp;'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold"><strong>CLIENTE:</strong>&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['num_foliopedido'].'</label>';	
					$opcion .= '</br><strong>FECHA:</strong>&nbsp;<label id="fecha_venta">'.$valor['fecha_venta'].'</label>&nbsp;|&nbsp;<strong>TIPO PAGO:</strong>&nbsp;<label id="tipopago">'.$valor['nom_tipopago'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>PLAZO:</strong>&nbsp;<label id="plazo">'.$valor['nom_plazo'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>COBRO:</strong>&nbsp;<label id="plazo">'.$valor['nom_periodocobro'].'</label>';
					$opcion .= '</br><strong>VENDEDOR:</strong>&nbsp;<label id="nom_ejecutivo">'.$valor['nom_ejecutivo'].'</label>';
					$opcion .= '|&nbsp;<strong>SUPERVISOR:</strong>&nbsp;<label id="nom_supervisor">'.$valor['nom_supervisor'].'</label>';
					$opcion .= '|&nbsp;<strong>JEFE GPO:</strong>&nbsp;<label id="nom_jefegpo">'.$valor['nom_jefegpo'].'</label>';
					$opcion .='</td>';
					
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['num_foliopedido'].'" ><div class="btn-group-vertical">';
					$opcion .= '<label id="num_clientecomision" class="bold" style="display:none">'.$valor['num_ejecutivo'].'</label><br>';
					$opcion .= 'VENDEDOR:<label id="nom_clientecomision" class="bold">'.$valor['nom_ejecutivo'].'</label><br>';
					$opcion .= 'COMISIÓN:$<label id="total_comision" class="semi-bold">'.$valor['comision'].'</label><br>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Factura</button>';
					/*$opcion .= '<button type="button" title="Cancelar el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['num_foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Cancelar</button><br/>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['num_foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a><br/>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div>';*/
					
					$opcion .= '</td><tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Generar reporte de comisiones pagadas hoy.
	function verComisionesCobranzaPagadasHoy(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_comisionespagadasporcobranza_select(NOW()::DATE,NOW()::DATE) ORDER BY num_ejecutivo;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					
					$vTotal = $valor['total'];
					$opcion .= '<tr id=row_'.$valor['num_foliopedido'].'><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr>';
					//$opcion .= '<tr id="'.$valor['num_foliopedido'].'" title="'.$valor['num_foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><span><strong>ARTICULOS:</strong>&nbsp;<label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;</span>.&nbsp; ABONO $<label id="detalle">'.$valor['abono'].'</label>';
					$opcion .= '</br><label id="calle"><strong>DOMICILIO:</strong>&nbsp;'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold"><strong>CLIENTE:</strong>&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['num_foliopedido'].'</label>';	
					$opcion .= '</br><strong>FECHA:</strong>&nbsp;<label id="fecha_venta">'.$valor['fecha_venta'].'</label>&nbsp;|&nbsp;<strong>TIPO PAGO:</strong>&nbsp;<label id="tipopago">'.$valor['nom_tipopago'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>PLAZO:</strong>&nbsp;<label id="plazo">'.$valor['nom_plazo'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>COBRO:</strong>&nbsp;<label id="plazo">'.$valor['nom_periodocobro'].'</label>';
					$opcion .= '</br><strong>VENDEDOR:</strong>&nbsp;<label id="nom_ejecutivo">'.$valor['nom_ejecutivo'].'</label>';
					$opcion .= '|&nbsp;<strong>SUPERVISOR:</strong>&nbsp;<label id="nom_supervisor">'.$valor['nom_supervisor'].'</label>';
					$opcion .= '|&nbsp;<strong>JEFE GPO:</strong>&nbsp;<label id="nom_jefegpo">'.$valor['nom_jefegpo'].'</label>';
					$opcion .='</td>';
					
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['num_foliopedido'].'" ><div class="btn-group-vertical">';
					$opcion .= '<label id="num_clientecomision" class="bold" style="display:none">'.$valor['num_ejecutivo'].'</label><br>';
					$opcion .= 'VENDEDOR:<label id="nom_clientecomision" class="bold">'.$valor['nom_ejecutivo'].'</label><br>';
					$opcion .= 'COMISIÓN:$<label id="total_comision" class="semi-bold">'.$valor['comision'].'</label><br>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Factura</button>';
					/*$opcion .= '<button type="button" title="Cancelar el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['num_foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Cancelar</button><br/>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['num_foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a><br/>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div>';*/
					
					$opcion .= '</td><tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Generar reporte de comisiones pagadas periodo fecha.
	function verComisionesPagadasPeriodo($Inicio,$Fin){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_comisionespagadasporventas_select('$Inicio'::DATE,'$Fin'::DATE) ORDER BY num_ejecutivo;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$opcion .= '<tr id=row_'.$valor['num_foliopedido'].'><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr>';
					//$opcion .= '<tr id="'.$valor['num_foliopedido'].'" title="'.$valor['num_foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><span><strong>ARTICULOS:</strong>&nbsp;<label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;</span>.&nbsp; TOTAL $<label id="detalle">'.$valor['total'].'</label>';
					$opcion .= '</br><label id="calle"><strong>DOMICILIO:</strong>&nbsp;'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold"><strong>CLIENTE:</strong>&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['num_foliopedido'].'</label>';	
					$opcion .= '</br><strong>FECHA:</strong>&nbsp;<label id="fecha_venta">'.$valor['fecha_venta'].'</label>&nbsp;|&nbsp;<strong>TIPO PAGO:</strong>&nbsp;<label id="tipopago">'.$valor['nom_tipopago'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>PLAZO:</strong>&nbsp;<label id="plazo">'.$valor['nom_plazo'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>COBRO:</strong>&nbsp;<label id="plazo">'.$valor['nom_periodocobro'].'</label>';
					$opcion .= '</br><strong>VENDEDOR:</strong>&nbsp;<label id="nom_ejecutivo">'.$valor['nom_ejecutivo'].'</label>';
					$opcion .= '|&nbsp;<strong>SUPERVISOR:</strong>&nbsp;<label id="nom_supervisor">'.$valor['nom_supervisor'].'</label>';
					$opcion .= '|&nbsp;<strong>JEFE GPO:</strong>&nbsp;<label id="nom_jefegpo">'.$valor['nom_jefegpo'].'</label>';
					$opcion .='</td>';
					
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['num_foliopedido'].'" ><div class="btn-group-vertical">';
					$opcion .= '<label id="num_clientecomision" class="bold" style="display:none">'.$valor['num_ejecutivo'].'</label><br>';
					$opcion .= 'VENDEDOR:<label id="nom_clientecomision" class="bold">'.$valor['nom_ejecutivo'].'</label><br>';
					$opcion .= 'COMISIÓN:$<label id="total_comision" class="semi-bold">'.$valor['comision'].'</label><br>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Factura</button>';
					/*$opcion .= '<button type="button" title="Cancelar el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['num_foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Cancelar</button><br/>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['num_foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a><br/>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div>';*/
					
					$opcion .= '</td><tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}
	
	
	
	//Generar reporte de comisiones pagadas periodo fecha.
	function verComisionesCobranzaPagadasPeriodo($Inicio,$Fin){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_comisionespagadasporcobranza_select('$Inicio'::DATE,'$Fin'::DATE) ORDER BY num_ejecutivo;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$iEncabezado = 0;
				$opcion = '';
				$pagina1 = 19;
				foreach ($rs AS $valor) {
					if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive"></tr>';
					}
					
					$vColonia ='';
					if ($valor['colonia'] !=''){
						$vColoniaArray = explode( ' - ', $valor['colonia']);
						$vColonia = ISSET($vColoniaArray[1])?$vColoniaArray[1]:'';
					}
					$vTotal = $valor['total'];
					$opcion .= '<tr id=row_'.$valor['num_foliopedido'].'><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr>';
					//$opcion .= '<tr id="'.$valor['num_foliopedido'].'" title="'.$valor['num_foliopedido'].'"><td><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"></td><tr>';
					$opcion .= '<td name="detalle" style="font-family:Arial;font-size:11px;"><span><strong>ARTICULOS:</strong>&nbsp;<label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;</span>.&nbsp; TOTAL $<label id="detalle">'.$valor['total'].'</label>';
					$opcion .= '</br><label id="calle"><strong>DOMICILIO:</strong>&nbsp;'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold"><strong>CLIENTE:</strong>&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['num_foliopedido'].'</label>';	
					$opcion .= '</br><strong>FECHA:</strong>&nbsp;<label id="fecha_venta">'.$valor['fecha_venta'].'</label>&nbsp;|&nbsp;<strong>TIPO PAGO:</strong>&nbsp;<label id="tipopago">'.$valor['nom_tipopago'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>PLAZO:</strong>&nbsp;<label id="plazo">'.$valor['nom_plazo'].'</label>';
					$opcion .= '&nbsp;|&nbsp;<strong>COBRO:</strong>&nbsp;<label id="plazo">'.$valor['nom_periodocobro'].'</label>';
					$opcion .= '</br><strong>VENDEDOR:</strong>&nbsp;<label id="nom_ejecutivo">'.$valor['nom_ejecutivo'].'</label>';
					$opcion .= '|&nbsp;<strong>SUPERVISOR:</strong>&nbsp;<label id="nom_supervisor">'.$valor['nom_supervisor'].'</label>';
					$opcion .= '|&nbsp;<strong>JEFE GPO:</strong>&nbsp;<label id="nom_jefegpo">'.$valor['nom_jefegpo'].'</label>';
					$opcion .='</td>';
					
					$opcion .= '<td class="pull-right" name="controles" id="controles_'.$valor['num_foliopedido'].'" ><div class="btn-group-vertical">';
					$opcion .= '<label id="num_clientecomision" class="bold" style="display:none">'.$valor['num_ejecutivo'].'</label><br>';
					$opcion .= 'VENDEDOR:<label id="nom_clientecomision" class="bold">'.$valor['nom_ejecutivo'].'</label><br>';
					$opcion .= 'COMISIÓN:$<label id="total_comision" class="semi-bold">'.$valor['comision'].'</label><br>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Factura</button>';
					/*$opcion .= '<button type="button" title="Cancelar el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['num_foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Cancelar</button><br/>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modal_abonos.php?id='.$valor['num_foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a><br/>';
					$opcion .= '<button type="button" title="Imprimir comprobante" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['num_foliopedido'].'" onclick=RedirectPage("#ajax/imprimir_comprobantepedido.php?f='.$valor['num_foliopedido'].'&n='.$vTotal.'"); id="smart-mod-eg1"><i class="fa fa-edit">&nbsp;</i>Comprobante</button></div>';*/
					
					$opcion .= '</td><tr/>';
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table>';
					if ($i == $pagina1){
						$pagina1 = 21;
						$i = 0;
						$opcion .= '<br/><br/>';
					}
					$i++;
				}
				$opcion .= '</tr></div>';
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}

function llenarGridIDevoluciones(){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select * from fn_cat_inventario_devoluciones_select() order by 1;";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					foreach ($rs AS $valor) {
						$id_inventario = $valor['id_inventario'];

						if($valor['id_proveedor'] == 0){
							$tipo = $valor['nombre_concepto'];
						}else{
							$tipo = $valor['nombre_proveedor']; 
						}

						$html .= '<tr >';
						//$html .= '<td id="row_'.$id_vendedor.'">'.$id_vendedor.'</td>';
						$html .= '<td >'.$valor['folio_factura'].'</td>';
						$html .= '<td >'.$valor['subtotal'].'</td>';
						$html .= '<td >'.$valor['monto_iva'].'</td>';
						$html .= '<td >'.$valor['monto_total'].'</td>';
						$html .= '<td >'.$tipo.'</td>';
						$html .= '<td >'.$valor['fecha_compra'].'</td>';
						
						$html .= '<td >';

							$html .= '<a onclick="realizarDevolucion('.$id_inventario.', '.$valor['folio_factura'].')" class="glyphicon glyphicon-thumbs-up	" style = "cursor:pointer;font-size:1.5em;" title="Confirmar Devolucion" ></a>';

						$html.='</td>';

						$html .= '</tr>';
					}
					$arreglo['success']=true;
					$arreglo['data'] = array('html'=>$html);
				}else{
					$arreglo['error'] = $db->getError();	
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);
		}

	function realizarDevolucion($id){
		$arreglo = array("success"=>false,"data"=>array(),"error"=>"");
		$db = getConexionTda();

		$sRetorno ='';
		if ($db->getError() == '') {
			$query = "select fn_ctl_facturas_devolucion_insert as codigos from fn_ctl_facturas_devolucion_insert(".$id."::bigint,".$_SESSION['keyx']."::bigint);";
			$rs = $db->query($query);
			if ($db->getError() != "") {
				$arreglo['error'] = $db->getError();
			}else{			
				$arreglo['success'] = true;
				$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
			}
		} else {
			$arreglo['error'] = $db->getError();
		}
		closeConexion($db);
		return json_encode($arreglo);	
	}

function llenarGridIDevolucionesReporte($request){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				if( isset($request['from']) &&  isset($request['to']) ){
					$where =" where fecha_devolucion::date between '".$request['from']."' and '".$request['to']."' ";
				}else{
					$where =" where fecha_devolucion::date = now()::date";
    			}
				$query = "select * from fn_reporte_devoluciones_select() ".$where.";";
				//echo $query ;
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					foreach ($rs AS $valor) {
						$html .= '<tr >';
						//$html .= '<td id="row_'.$id_vendedor.'">'.$id_vendedor.'</td>';
						$html .= '<td >'.$valor['folio_factura'].'</td>';
						$html .= '<td >'.$valor['nombre_proveedor'].'</td>';
						$html .= '<td >'.$valor['quien_realizo_devolucion'].'</td>';
						$html .= '<td >$'.$valor['monto_total'].'</td>';
						$html .= '<td >'.$valor['fecha_compra'].'</td>';
						$html .= '<td >'.$valor['fecha_devolucion'].'</td>';

						$html .= '</tr>';
					}
					$arreglo['success']=true;
					$arreglo['data'] = array('html'=>$html);
				}else{
					$arreglo['error'] = $db->getError();	
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);
		}

function llenarGridIAbonosReporte_2($request){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				if( isset($request['from']) &&  isset($request['to']) ){
					$where =" where ultimo_abono::date between '".$request['from']."' and '".$request['to']."' ";
				}else{
					$where =" where ultimo_abono::date = now()::Date";
    			}
				$query = "select nombre_cliente, folio_factura, 
									total_abonos, ultimo_abono::date
								from fn_reporte_abonos_select() ".$where." order by 1, 4;";
				//echo $query ;
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					$total_abonos = 0;
					foreach ($rs AS $valor) {
						$html .= '<tr >';
						$html .= '<td >'.$valor['nombre_cliente'].'</td>';
						$html .= '<td >'.$valor['folio_factura'].'</td>';
						$html .= '<td >'.$valor['total_abonos'].'</td>';
						$html .= '<td >'.$valor['ultimo_abono'].'</td>';
						$html .= '</tr>';
						$total_abonos += $valor['total_abonos'];
					}
					$arreglo['success']=true;
					$arreglo['data'] = array('html'=>$html, "total_abonado" => $total_abonos);
				}else{
					$arreglo['error'] = $db->getError();	
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);
		}

function llenarGridIAbonosReporte($request){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				if( isset($request['from']) &&  isset($request['to']) ){
					$where =" where ultimo_abono::date between '".$request['from']."' and '".$request['to']."' ";

				}else{
					$where =" where ultimo_abono::date = now()::Date";
    			}
    									$query = "select 
								sum(total_abonos) as total_abonos, ultimo_abono::date 
						  from fn_reporte_abonos_select() ".$where." 
						  group by ultimo_abono::date order by 1;";
			
				//echo $query ;
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					$total_abonos = 0;
					foreach ($rs AS $valor) {
						$html .= '<tr >';
						//$html .= '<td >'.$valor['nombre_cliente'].'</td>';
						//$html .= '<td >'.$valor['folio_factura'].'</td>';
						$html .= '<td >'.$valor['total_abonos'].'</td>';
						$html .= '<td >'.$valor['ultimo_abono'].'</td>';
						$html .= '</tr>';
						$total_abonos += $valor['total_abonos'];
					}
					$arreglo['success']=true;
					$arreglo['data'] = array('html'=>$html, "total_abonado" => $total_abonos);
				}else{
					$arreglo['error'] = $db->getError();	
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);
		}
		
		
		//Consultar un pedidos pendiente
	function consultarUnPedidos($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidoscomprobante_select() WHERE num_foliopedido = $iFolioPedido;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final;
				if ($sRetorno != array()){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno[0];
					$arreglo['error'] = 'Se consult&oacute exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "El pedido no se encuentra registrado o con estatus pendiente!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}

	//Consultar reporte de un pedidos pendiente
	function consultarArticulosUnPedidosSinImportarEstatus($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_articulospedidossinestatus_select($iFolioPedido);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .="<tr id='tabla_".$valor['id_articulo']."'>";
					$opcion .= '<td  id="sku_'.$valor['id_articulo'].'">'.$valor['id_articulo'].'</td>';
					$opcion .= '<td  id="desc_'.$valor['id_articulo'].'">'.$valor['descripcion'].'</td>';
					$opcion .= '<td  id="cant_'.$valor['id_articulo'].'">'.$valor['cantidad'].'</td>';
					$opcion .= '<td  id="prec_'.$valor['id_articulo'].'">'.$valor['precio'].'</td>';
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}

	function llenarGridCortesAnteriores($request){
		$arreglo = array("success"=>"false","data"=>array(),"error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
				$where =" where fecha_registro = '".$request['fecha']."'";

    			$sql = "select * from fn_corte_select() ".$where." order by fecha_registro;";
			$rs = $db->query($sql);
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$id_corte = $valor['id_corte'];
					$opcion .="<tr >";
					$opcion .= '<td  >'.$valor['total_vendido'].'</td>';
					$opcion .= '<td  >'.$valor['total_abonos'].'</td>';
					$opcion .= '<td  >'.$valor['total_liquidadas'].'</td>';
					$opcion .= '<td  >'.$valor['total_compras_proveedor'].'</td>';
					$opcion .= '<td  >'.$valor['total_conceptos_gastos'].'</td>';
					$opcion .= '<td  >'.$valor['total_devoluciones_proveedor'].'</td>';
					$opcion .= '<td  >'.$valor['total_cancelaciones_compras'].'</td>';
					$opcion .= '<td  >'.$valor['fecha_registro'].'</td>';
					$opcion .= '<td  >
					<a href="ajax/modal_corte.php?id='.$id_corte.'" class="fa fa fa-eye txt-color-gray hidden-md hidden-sm hidden-xs" data-toggle="modal" data-target="#remoteModal" id="editarProveedor" title="Ver Detalle Corte" style="font-size:1.5em;"></a>
					</td>';
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return json_encode($arreglo);
	}

	function llenarGridCortesAnterioresDetalle($request){
		$arreglo = array("success"=>"false","data"=>array(),"error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
    			$sql = "select * from fn_corte_detalle_select(".$request['id']."::bigint) ";
			$rs = $db->query($sql);
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					$opcion .="<tr >";
					$opcion .= '<td  >'.$valor['nombre_usuario'].'</td>';
					$opcion .= '<td  >'.$valor['total_vendido'].'</td>';
					$opcion .= '<td  >'.$valor['total_abonos'].'</td>';
					$opcion .= '<td  >'.$valor['total_liquidadas'].'</td>';
					$opcion .= '<td  >'.$valor['total_compras_proveedor'].'</td>';
					$opcion .= '<td  >'.$valor['total_conceptos_gastos'].'</td>';
					$opcion .= '<td  >'.$valor['total_devoluciones_proveedor'].'</td>';
					$opcion .= '<td  >'.$valor['total_cancelaciones_compras'].'</td>';

					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return json_encode($arreglo);
	}

	function realizar_corte(){
		$arreglo = array("success"=>"false","data"=>array(),"error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
    			$sql = "select * from fn_generar_corte(); ";
			$rs = $db->query($sql);
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{				
				$arreglo['success'] = true;
				$arreglo['data'] = '';
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return json_encode($arreglo);
	}

	function obtenerFechasCorte(){
		$arreglo = array("success"=>false,"data"=>array(),"error"=>"");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$query = "select fecha_corte from fn_fechas_corte() order by fecha_corte desc;";
			$rs = $db->query($query);
			if ($db->getError() != "") {
				$arreglo['error'] = $db->getError();
			}else{
				$arreglo['success'] = true;
				$arreglo['data'] =  array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
			}
		} else {
			$arreglo['error'] = $db->getError();
		}
		closeConexion($db);
		return json_encode($arreglo);	
	}

	function llenarGridPreCorte(){
		$arreglo = array("success"=>"false","data"=>array(),"error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
    		
    		$sql = "select * from fn_pre_generar_corte();";
			$rs = $db->query($sql);

			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					
					$opcion .="<tr >";
					$opcion .= '<td  >'.$valor['nombre_usuario'].'</td>';
					$opcion .= '<td  >'.$valor['total_vendido'].'</td>';
					$opcion .= '<td  >'.$valor['total_abonos'].'</td>';
					$opcion .= '<td  >'.$valor['total_liquidacion'].'</td>';
					$opcion .= '<td  >'.$valor['total_compras_proveedor'].'</td>';
					$opcion .= '<td  >'.$valor['total_conceptos_gastos'].'</td>';
					$opcion .= '<td  >'.$valor['total_devoluciones_proveedor'].'</td>';
					$opcion .= '<td  >'.$valor['total_cancelaciones_compras'].'</td>';
					
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		
		return json_encode($arreglo);
	}
	function llenarGridConceptoGastosReporte($request){
		$arreglo = array("success"=>"false","data"=>array(),"error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			if( isset($request['from']) &&  isset($request['to']) ){
				$where =" where fecha_compra::date between '".$request['from']."' and '".$request['to']."' ;";
			}else{
				$where =" where fecha_compra::date = now()::date;";
			}  		
    		$sql = "select * from fn_consultar_gastos() ".$where;
    		//echo $sql;
			$rs = $db->query($sql);

			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				$total = 0;
				foreach ($rs AS $valor) {
					
					$opcion .="<tr >";
					$opcion .= '<td  >'.$valor['folio_gasto'].'</td>';
					$opcion .= '<td  >'.$valor['concepto_gasto'].'</td>';
					$opcion .= '<td  >'.$valor['total'].'</td>';
					$opcion .= '<td  >'.$valor['fecha_compra'].'</td>';
					$opcion .= "</tr>";
					$total = $total + $valor['total'];
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = array("html" => $opcion, "total" => $total);
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		
		return json_encode($arreglo);
	}

	function llenarGridInventarioReporte($request){
		$arreglo = array("success"=>"false","data"=>array(),"error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			if( isset($request['from']) &&  isset($request['to']) ){
				$where =" where fecha_compra::date between '".$request['from']."' and '".$request['to']."' ;";
			}else{
				$where =" where fecha_compra::date = now()::date;";
			}  		
    		$sql = "select * from fn_reporte_inventario() ".$where;

			$rs = $db->query($sql);

			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = '';
				foreach ($rs AS $valor) {
					
					$opcion .="<tr >";
					$opcion .= '<td  >'.$valor['folio_factura'].'</td>';
					$opcion .= '<td  >'.$valor['subtotal'].'</td>';
					$opcion .= '<td  >'.$valor['monto_iva'].'</td>';
					$opcion .= '<td  >'.$valor['proveedor'].'</td>';
					$opcion .= '<td  >'.$valor['fecha_compra'].'</td>';
					$opcion .= "</tr>";
				}
				
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		
		return json_encode($arreglo);
	}

	function fn_liquida_facturas_contado($request){
		$arreglo = array("success"=>false,"data"=>array(),"error"=>"");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {

			$query = "select * from fn_liquida_facturas_contado(".$request['idFolioPedido']."::bigint,".$_SESSION['keyx']."::bigint,".$request['abono_propuesto']."::float,'".$request['cobrador']."'::varchar,".$request['descuento']."::float);";
			$rs = $db->query($query);
			if ($db->getError() != "") {
				$arreglo['error'] = $db->getError();
			}else{
				$arreglo['success'] = true;
			}
		} else {
			$arreglo['error'] = $db->getError();
		}
		closeConexion($db);
		return json_encode($arreglo);	
	} 

	function fn_autocomplete_cobrador($term){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select idu_cobrador as id, nombre_cobrador as value, 
					nombre_cobrador as label from fn_consulta_cobrador_select() 
					where nombre_cobrador like '%".strtoupper($term['term'])."%'; ";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$arreglo['success']=true;
					$arreglo['data'] = array('info'=>objectToArray($rs->fetchAll(PDO::FETCH_OBJ)) );
				}else{
					$arreglo['error'] = $db->getError();
				}
				
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);		
	}

	function fn_acumulado_facturas_abonos_pendientes($request){
	$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				if( isset($request['from']) &&  isset($request['to']) ){
					$where =" where fecha_registro between '".$request['from']."' and '".$request['to']."' ";
				}else{
					$where =" where fecha_registro = now()::date ";
    			}
				$query = "select COALESCE(sum(total),0) as total from fn_consulta_total_facturado_pendiente_liquidar() ".$where;
				$rs = $db->query($query);

				if($db->getError() == ''){
					$arreglo['success']=true;
					$totalFacturadoPendienteLiquidar = 0;
					foreach ($rs as $value) {
						$totalFacturadoPendienteLiquidar  = $value['total'];
					}

					$query = "select COALESCE(sum(total),0) as total from fn_consulta_total_abonos_facturas_pendiente_liquidar() ".$where;
					$rs = $db->query($query);
					$totalAbonosFacturasPendienteLiquidar = 0;
					foreach ($rs as $value) {
						$totalAbonosFacturasPendienteLiquidar  = $value['total'];
					}

					 $total = ($totalFacturadoPendienteLiquidar - $totalAbonosFacturasPendienteLiquidar);
					$total = ($total < 0 ) ? $total * -1 : $total;
					
					$html = '<tr >';
						$html .= '<td >'.$totalFacturadoPendienteLiquidar.'</td>';
						$html .= '<td >'.$totalAbonosFacturasPendienteLiquidar.'</td>';
						$html .= '<td >'.$total.'</td>';
					$html .= '</tr>';

					$arreglo['data'] = array('info'=> $html );
				}else{
					$arreglo['error'] = $db->getError();
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);
	}
	
	function modificarFechaCobranza($iFolioPedido,$vFechaMes,$vFechaAnio){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_ctl_cambiofechacobranza_update($iFolioPedido,'$vFechaMes'::DATE,'$vFechaAnio'::DATE) AS retorno; ");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$sRetorno =$rs_final[0];
				if ($sRetorno['retorno'] == 1){
					$arreglo['success'] = true;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = 'Se grab&oacute; exitosamente el cambio de fecha!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No se grab&oacute; el cambio de fecha!.";
				}
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return $arreglo;
	}

	function busqueda_info_cuenta_incobrable($request){
					$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cuenta_incobrables_id(".$request['folio_factura']."::bigint);");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
				$arreglo["data"] = $rs_final;
				$arreglo['success'] = true;
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);
		return json_encode($arreglo);
	}

	function crear_cuenta_incobrable($request){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if ($db->getError() == '') {

				$query = "select * from fn_crear_cuenta_incobrables(".$request['folio_factura']."::bigint, '".$request['justificacion']."'::character varying);";
				//echo $query;
				$rs = $db->query($query);
				if ($db->getError() != "") {
					$sRetorno =$db->getError();
					$arreglo['success'] = false;
					$arreglo['error'] = $sRetorno;
				}else{
					$arreglo['success'] = true;
				}
			} else {
				$sRetorno =$db->getError();
				$arreglo['error'] = $sRetorno;
			}
		closeConexion($db);
		return json_encode($arreglo);
	}

	function llenarGridCuentasIncobrables(){
	$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select * from fn_cuenta_incobrables();";
				$rs = $db->query($query);

				if($db->getError() == ''){
					$arreglo['success']=true;
					$html = "";
					foreach ($rs as $value) {
						$factura = $value['factura'];
						$html .= '<tr >';
							$html .= '<td >'.$factura.'</td>';
							$html .= '<td >'.$value['cliente'].'</td>';
							$html .= '<td >'.$value['total_facturado'].'</td>';
							$html .= '<td >'.$value['tipo_pago'].'</td>';
							$html .= '<td >'.$value['forma_pago'].'</td>';
							$html .= '<td >'.$value['fecha_venta'].'</td>';
							$html .= '<td width="10%" style="text-align: center;"><a href="ajax/modal_cuenta_incobrable_justificacion.php?id='.$factura.'" title="Ver justificacion" data-toggle="modal" data-target="#remoteModal" id="editar" style="text-align:center;"><i class="fa fa-eye">&nbsp;</i>Ver</a></td>';

						$html .= '</tr>';
					}

					$arreglo['data'] = array('info'=> $html );
				}else{
					$arreglo['error'] = $db->getError();
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);
	}

function verJustificacionCtaIncobrables($request){
	$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			$justificacion= "";
			if($db->getError() == ''){
				$query = "select fn_consultar_justificacion_ctas_incobrables as justificacion
						 from fn_consultar_justificacion_ctas_incobrables(".$request['factura'].");";
				$rs = $db->query($query);

				if($db->getError() == ''){
					$arreglo['success']=true;
					
					foreach ($rs as $value) {
						$justificacion = $value['justificacion'];
					}
					$arreglo['success'] = true;
					$arreglo['data'] = array('info'=> $justificacion );
				}else{
					$arreglo['error'] = $db->getError();
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);
	}

function llenarGridMermas(){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select descripcion, costo_unitario_venta, existencia,fecha_registro::date as fecha_registro
				  from fn_mermas_select();";
				$rs = $db->query($query);

				if($db->getError() == ''){
					$arreglo['success']=true;
					$html = "";
					foreach ($rs as $value) {
						
						$html .= '<tr >';
							$html .= '<td >'.$value['descripcion'].'</td>';
							$html .= '<td >'.$value['costo_unitario_venta'].'</td>';
							$html .= '<td >'.$value['existencia'].'</td>';
							$html .= '<td >'.$value['fecha_registro'].'</td>';
						$html .= '</tr>';
					}

					$arreglo['data'] = array('info'=> $html );
				}else{
					$arreglo['error'] = $db->getError();
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);	
}

function consultaInformacionArticulosMermas($request){
				$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select * from fn_consulta_informacion_articulos_mermas(".$request['id']."::bigint);";
				$rs = $db->query($query);

				if($db->getError() == ''){
					$arreglo['success']=true;
					$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
					$arreglo['data'] = array('info'=> $rs_final);
				}else{
					$arreglo['error'] = $db->getError();
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);	
}

function crearArticuloMerma($request){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				$query = "select * from fn_articulo_merma(
						".$request['idArticulo']."::bigint, ".$request['cantidad']."::integer,
						".$request['veces_ganancia']."::float, ".$request['costo_unitario_compra']."::float, 
						".$request['costo_unitario_venta']."::float, ".$request['foliopedido']."::bigint);";
//					echo $query;
				$rs = $db->query($query);

				if($db->getError() == ''){
					$arreglo['success']=true;
				}else{
					$arreglo['error'] = $db->getError();
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			return json_encode($arreglo);	

}

function llenarGridMermaReporte($request){
			$arreglo = array("success"=>"false","data"=>array(),"error"=>"");
			$db = getConexionTda();
			if($db->getError() == ''){
				if( isset($request['from']) &&  isset($request['to']) ){
					$where =" where fecha_registro::date between '".$request['from']."' and '".$request['to']."' ";
				}else{
					$where =" where fecha_registro::date >= cast(date_trunc('month', current_date) as date)";
    			}
				$query = "select * from fn_consulta_merma_reporte() ".$where.";";
				$rs = $db->query($query);
				if($db->getError() == ''){
					$html = '';
					foreach ($rs AS $valor) {
						$html .= '<tr >';
						//$html .= '<td >'.$valor['id_articulo'].'</td>';
						$html .= '<td >'.$valor['descripcion'].'</td>';
						$html .= '<td >'.$valor['existencia'].'</td>';
						$html .= '<td >'.$valor['fecha_registro'].'</td>';
						$html .= '</tr>';
					}
					$arreglo['success']=true;
					$arreglo['data'] = array('html'=>$html);
				}else{
					$arreglo['error'] = $db->getError();	
				}
			}else{
				$arreglo['error'] = $db->getError();
			}
			closeConexion($db);
			echo json_encode($arreglo);
		}
?>