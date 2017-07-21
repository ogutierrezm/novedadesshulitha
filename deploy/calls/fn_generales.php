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
		return $arreglo;
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
	
	
	function grabarArticuloNew($horas,$st3,$precio,$cantidad,$articulo){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No existe consecutivo");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_invent_insert('$articulo',$cantidad,'$precio',$st3,$horas) AS retorno;");
			//print_r($rs);
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
				$arreglo['data'] = "SELECT * FROM fn_invent_insert('$articulo',$cantidad,'$precio',$st3,$horas) AS retorno;";
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
	function actualizarArticuloInventario($id_articulo,$articulo,$cantidad,$precio,$st3,$horas){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No existe consecutivo");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("SELECT * FROM fn_invent_update($id_articulo,'$articulo',$cantidad,'$precio',$st3,$horas) AS retorno;");
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
					$opcion .="<a href='ajax/modal_administracion_usuarios.php?usr=".$valor['id_puesto']."' data-toggle='modal' data-target='#remoteModal' id='editar_".$valor['id_puesto']."'>";
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
			//$rs = $db->query("select * from fn_pedidos_select($vCte::bigint);");
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
	
	//Combo de articulos Captura de pedido
	function articulosaCapturarPedidos($esRenta){
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
	
	//Registro del domicilio del cliente.
	function pedidoGrabarDomicilio($calle,$numext,$numint,$CodigoPostal,$Colonia,$municipio,$referencias){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_direccionpedidos_insert('$calle'::VARCHAR,'$numint'::VARCHAR,'$numext'::VARCHAR,'$Colonia'::VARCHAR,$CodigoPostal::INTEGER,''::VARCHAR,'$referencias'::VARCHAR,'SINALOA'::VARCHAR,'$municipio'::VARCHAR) AS retorno;");
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
	
	//Registro de articulos del pedido del cliente.
	function pedidoGrabarArticuloDePedidoNuevo($iFolioPedido,$iId_articulo,$iCantidad,$vHorarioRenta,$esRenta){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			if($esRenta == 0){
			$rs = $db->query("select * from fn_articulospedidos_insert($iFolioPedido::BIGINT,$iId_articulo::BIGINT,$iCantidad::INTEGER,'$vHorarioRenta') AS retorno;");
			}else{
				$rs = $db->query("select * from fn_articulospedidosrentado_insert($iFolioPedido::BIGINT,$iId_articulo::BIGINT,$iCantidad::INTEGER,'$vHorarioRenta',$esRenta::INTEGER) AS retorno;");
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
	function pedidoGrabarPedido($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2,$empleado,$vManteleria,$flete,$iIva,$flag_descuento,$porcentajedescuento,$iGarantia){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$flag_entregamismodia = ($fechaentrega == $fecharecolecta) ? 1:0;
			$rs = $db->query("select * from fn_pedidos_insert($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,'$fechaentrega'::DATE,'$fecharecolecta'::DATE,$flag_entregamismodia,'$hora1','$hora2',1,$empleado,'$vManteleria',$flete,$iIva,$flag_descuento,$porcentajedescuento,$iGarantia) AS retorno;");
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
					$NombreGrupo = str_replace(' ','_',$valor['nom_grupo']);
					$opcion .="<tr id='tabla_".$valor['id_articulo']."'><td id='row_".$valor['id_articulo']."'>";
					$opcion .="<a name='eliminar_".$valor['id_articulo']."' href='javascript:void(0);' id='smart-mod-eg1' onclick= 'MensajeSmartInventarioDelete(this.name)'; ><i class='fa fa-minus-square-o' rel='tooltip' data-placement='top' data-original-title='Eliminar'></i></a>&nbsp;";
					$opcion .="<a href='ajax/modal_inventario.php?sku=".$valor['id_articulo']."&name=".$name."&cant=".$valor['cantidad']."&prec=".$valor['precio']."&flag=".$valor['flag_especial']."&hr=".$valor['horasrenta']."&gr=".$NombreGrupo."' data-toggle='modal' data-target='#remoteModal' id='editar_".$valor['id_articulo']."'>";
					$opcion .="<i class='fa fa-pencil-square-o' rel='tooltip' data-placement='top' data-original-title='Editar'></i>";
					$opcion .="</a></td>";
					$opcion .= '<td  id="sku_'.$valor['id_articulo'].'">'.$valor['id_articulo'].'</td>';
					$opcion .= '<td  id="desc_'.$valor['id_articulo'].'">'.$valor['descripcion'].'</td>';
					$opcion .= '<td  id="cant_'.$valor['id_articulo'].'">'.$valor['cantidad'].'</td>';
					$opcion .= '<td  id="prec_'.$valor['id_articulo'].'">'.$valor['precio'].'</td>';
					$opcion .= '<td  id="flag_'.$valor['id_articulo'].'">'.(($valor['flag_especial'] == 0)?'</i>':'<i class="fa fa-check txt-color-gray hidden-md hidden-sm hidden-xs"><span id="palomitaEspecial_'.$valor['id_articulo'].'" style="display:none">Si</span></i>').'</td>';	
					$opcion .= '<td  id="hora_'.$valor['id_articulo'].'">'.$valor['horasrenta'].'</td>';
					$opcion .= '<td  id="grupo_'.$valor['id_articulo'].'">'.$valor['nom_grupo'].'</td>';
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
	function generarReportePendidosPendientes(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidospendientes_select() WHERE fechapedido::DATE < NOW()::DATE AND TRIM(detallepedido) != '' ORDER BY fechapedido,region DESC;");
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
					
					/* 2da Modificacion solicidata */
					/*
					$opcion .= '<tr><td><table border="0" cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;font-size: 12px;margin: 0px;padding:0;"><tr>';
					$opcion .= '<td name="detalle"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >.TOTAL:&nbsp;$<label id="importe_total">'.$valor['total'].'</label></span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label>';				
					$opcion .= '&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$valor['colonia'].'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte']. ' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'</td>';
					$opcion .= '<td class="text-right" width="120px"><span style="font-size: 14px;">&nbsp;<strong>FOLIO:</strong>&nbsp;<label id="folio">'.$valor['foliopedido'].'</label></span><br><i class="fa fa-calendar"></i>&nbsp;<strong>Fecha:&nbsp;</strong><label id="fechapedido">'.$valor['fechapedido'].'</label></td></tr>';
					$opcion .= '<hr style="margin: 0px;padding:0;"></table></td></tr>';
					*/
					/* 2da Modificacion solicitada */
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
					$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical"><a id="actualizapedido" title="Modifica el pedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
					$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/recibir_pedido.php?folio='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a></div></td>';
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
					}*/
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
			$rs = $db->query("select * from fn_pedidospendientescobro_select() WHERE fechapedido::DATE <= NOW()::DATE ORDER BY fechapedido,region DESC;");
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
					}*/
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical"><!--a id="actualizapedido" title="Modifica el pedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a-->';
					$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/recibir_pedido.php?folio='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a></div></td>';
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
	
	//Generar reporte de pedidos pendientes
	function generarReportePendidosPendientesDelDia(){

		$fecha = obtenerfechaactual();										 
		//echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1];
		
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
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
					*/

					/* 2da Modificacion solicitada */
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
					$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical"><a id="actualizapedido" title="Modifica el pedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
					$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/recibir_pedido.php?folio='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a></div></td>';
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
					/* Modificacion solicitada */
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
	
	//Generar reporte de pedidos pendientes
	function actualizarPedidosPorFecha($Fecha){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidospendientes_select() WHERE fechapedido::DATE = '$Fecha'::DATE AND '$Fecha'::DATE >= NOW()::DATE  ORDER BY fechapedido,region DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$i = 0;
				$opcion = '';
				$pagina1 = 18;
				foreach ($rs AS $valor) {
					/*if ($i == 0){
						$opcion .= '<tr><td style="font-family:Arial;font-size: 16px;text-align:center;"><strong>PEDIDOS DEL D&Iacute;A '.$Fecha.' </strong></td></tr>';
					}*/
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
					$opcion .= '<tr>';
					$opcion .= '<td><table class="table-condensed" style="width:100%;font-size: 12px;"><tr><td name="detalle"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. TOTAL:&nbsp;$<label id="importe_total">'.$valor['total'].'</label></span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label>';
					$opcion .= '&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$valor['colonia'].'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'</td>';
					$opcion .= '<td class="pull-right" width="120px" ><span style="font-size: 14px;">&nbsp;<strong>FOLIO:</strong>&nbsp;<label id="folio">'.$valor['foliopedido'].'</label></span><br><i class="fa fa-calendar"></i>&nbsp;<strong>Fecha:&nbsp;</strong><label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					$opcion .= '<td class="pull-right"><div class="btn-group-vertical"><a id="actualizapedido"  href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a><button type="button" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button></div></td>';
					$opcion .= '<hr style="margin: 0px;"></table></td></tr>';
					*/
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
					//$opcion .= '<td  id="reporte"><table cellspacing="0" cellpadding="0" class="table-responsive" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr><td name="detalle" style="font-family:Arial;font-size:12px;"><label id="detalle">'.$i.'# 	'.$valor['detallepedido'].'</label>&nbsp;<span>';
					$opcion .= '<td  id="reporte"><table cellspacing="0" cellpadding="0" class="table-responsive" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr><td name="detalle" style="font-family:Arial;font-size:12px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span>';
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
					
					
					
					
					//$opcion .= '<span >. TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label>';
					//$opcion .= '&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					//$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical"><a id="actualizapedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a><button type="button" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button></div></td>';
					$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical"><a id="actualizapedido" title="Modifica el pedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
					$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/recibir_pedido.php?folio='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a></div></td>';
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
	
	//Consultar un pedidos pendiente
	function consultarUnPedidos($iFolioPedido){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidosabonado_select() WHERE foliopedido = $iFolioPedido;");
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
					*/
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
	
	//Obtener folios del mes en curso.
	function foliosMesEnCurso(){
		$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_pedidospendientesmes_select() WHERE fechapedido::DATE >= NOW()::DATE;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{
				$opcion = array();
				foreach ($rs AS $valor) {
					//$opcion1 = array("title"=>"Pendientes: ".$valor['cantidad'],"start"=>$valor['fechapedido']);
					$opcion1 = array("title"=>"Folio: ".$valor['cantidad'],"start"=>$valor['fechapedido'],"allDay"=> "true");
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
	
	//Elimina el folio de un pedido.
	function eliminarPedido($iFolioPedido){
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
					$arreglo['error'] = 'Se elimin&oacute; exitosamente el pedido!.';
				}else{
					$arreglo['success'] = false;
					$arreglo['data'] = $sRetorno;
					$arreglo['error'] = "No fue posible eliminar el pedido!.";
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
					$opcion .= '<tr style="font-family:Arial;font-size:11px;margin-left:2px;">';
					$opcion .= '<td><label id="nom_empleado">'.strtoupper($valor['nom_empleado']).'</label></td>';
					$opcion .= '<td><label id="numeroabonos">'.$valor['numeroabonos'].'</label></td>';
					$opcion .= '<td><label id="monto">$'.$valor['monto'].'</label></td>';
					$opcion .= '<td style="font-family:Arial;font-size:9px;"><label id="folios">'.$valor['folios'].'</label></td>';
					$iEmpleado = $valor['empleado'];
					$restDia = reportePedidosDepositosAlDia($iEmpleado);
					$restDia =$restDia['data'];
					$restRecibidoDia = reportePedidosDepositosRecibidosAlDia($iEmpleado);
					$restRecibidoDia =$restRecibidoDia['data'];
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
					/*if ($i == 0){
						$opcion .= '<tr><td style="font-family:Arial;font-size: 16px;text-align:center;"><strong>COTIZACIONES DEL D&Iacute;A '.$Fecha.' </strong></td></tr>';
						$i++;
					}*/
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
					
					$opcion .= '<tr>';
					$opcion .= '<td  id="reporte"><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr><td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label>';
					$opcion .= '&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
					// $opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO COTIZACI&Oacute;N:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical"><a id="actualizacotizacion" title="Modificar la cotizaci&oacute;n" href="#ajax/modificar_cotizacion.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
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
	
	
	//Generar Cotizacion plantilla presupuesto.
	/*function consultarPlantillaPresupuesto($rs){
		/ *$arreglo = array("success"=>"false","data"=>"","error"=>"No hay registros");
		$db = getConexionTda();
		$sRetorno ='';
		if ($db->getError() == '') {
			$rs = $db->query("select * from fn_cotizacion_select() WHERE fechapedido::DATE = '$Fecha'::DATE ORDER BY fechapedido,region DESC;");
			if ($db->getError() != "") {
				$sRetorno =$db->getError();
				$arreglo['success'] = false;
				$arreglo['error'] = $sRetorno;
			}else{* /
				$i = 0;
				$opcion = '';
				foreach ($rs AS $valor) {
					/*if ($i == 0){
						$opcion .= '<tr><td style="font-family:Arial;font-size: 16px;text-align:center;"><strong>COTIZACIONES DEL D&Iacute;A '.$Fecha.' </strong></td></tr>';
						$i++;
					}* /
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
					
					$opcion .= '<tr>';
					$opcion .= '<td  id="reporte"><table cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;margin: 0px 0px 0px 0px;padding:0px;border-spacing: 0px 0px;border: 0px;"><tr><td name="detalle" style="font-family:Arial;font-size:11px;"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >. TOTAL:&nbsp;$<label id="importe_total">'.$vTotal.'</label>'.$vDeposito.'</span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label>';
					$opcion .= '&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
					// $opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO COTIZACI&Oacute;N:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					/*$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical"><a id="actualizacotizacion" title="Modificar la cotizaci&oacute;n" href="#ajax/modificar_cotizacion.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
					$opcion .= '<button type="button" title="Borra el Cotizaci&oacute;n" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModCotizaciones('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" title="Convierte la cotizaci&oacute;n a pedido" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Convertir</a></div></td>';* /
					$opcion .= '<hr style="margin:0px 0px 0px 0px;padding:0px;"></table></td></tr>';

   				
				}
		/*		
				$arreglo['success'] = true;
				$arreglo['data'] = $opcion;
				$arreglo['error'] = '';
			}
		} else {
			$sRetorno =$db->getError();
			$arreglo['success'] = false;
			$arreglo['error'] = $sRetorno;
		}
		closeConexion($db);* /
		return $opcion;
	}*/
	
	
	
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
					}*/
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
					
					//$opcion .= '<a id="recibirpedido" href="#ajax/recibir_pedido.php?folio='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a></div></td>';
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
			$rs = $db->query("select * from fn_pedidospendientes_select() WHERE fechapedido::DATE > NOW()::DATE ORDER BY fechapedido,region DESC;");
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
					
					/* 2da Modificacion solicidata */
					/*
					$opcion .= '<tr><td><table border="0" cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;font-size: 12px;margin: 0px;padding:0;"><tr>';
					$opcion .= '<td name="detalle"><label id="detalle">'.$valor['detallepedido'].'</label>&nbsp;<span >.TOTAL:&nbsp;$<label id="importe_total">'.$valor['total'].'</label></span>&nbsp;ABONO:&nbsp;$<label id="importe_abono">'.$valor['abono'].'</label>';				
					$opcion .= '&nbsp;RESTAN:&nbsp;$<label id="importe_abono">'.(($vTotal) - ($valor['abono'])).'</label>';
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$valor['colonia'].'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte']. ' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'</td>';
					$opcion .= '<td class="text-right" width="120px"><span style="font-size: 14px;">&nbsp;<strong>FOLIO:</strong>&nbsp;<label id="folio">'.$valor['foliopedido'].'</label></span><br><i class="fa fa-calendar"></i>&nbsp;<strong>Fecha:&nbsp;</strong><label id="fechapedido">'.$valor['fechapedido'].'</label></td></tr>';
					$opcion .= '<hr style="margin: 0px;padding:0;"></table></td></tr>';
					*/
					/* 2da Modificacion solicitada */
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
					}*/
					$opcion .= '</br><label id="calle">'.$valor['calle'].'</label>&nbsp;<label id="numero_ext">'.$valor['numext'].'</label>&nbsp;<label id="numero_int">'.$valor['numint'].'</label>,&nbsp;<label id="colonia"><strong>&nbsp;'.$vColonia.'</strong></label><span style="font-size: 9px;"> <label id="referencias">'.$valor['referencias'].'.</span></label>&nbsp;';
					$opcion .= '</br><label id="nombre" class="semi-bold">CLIENTE:&nbsp;'.$valor['nombrecte'].' '.$valor['apellidocte'].'</label>&nbsp;|&nbsp;&nbsp;<label id="ciudad">'.$valor['telefonocasa'].'&nbsp;/&nbsp;'.$valor['telefonocelular'].'</label>&nbsp;'.$Horario.'&nbsp;|&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label>';
					if($valor['empleado'] != ''){
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label>&nbsp;|&nbsp;EMPLEADO:&nbsp;<label id="empleado">'.$valor['empleado'].'</label></td>';
					}else{
						$opcion .= '&nbsp;|&nbsp;FECHA:&nbsp;<label id="fechapedido">'.$valor['fechapedido'].'</label></td>';
					}
					$opcion .= '<td class="pull-right" id="reporte"><div class="btn-group-vertical"><a id="actualizapedido" title="Modifica el pedido" href="#ajax/modificar_pedido.php?folio='.$valor['foliopedido'].'" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Editar</a>';
					$opcion .= '<button type="button" title="Borra el pedido" class="btn btn-info btn-xs noMostrarPrint" name="'.$valor['foliopedido'].'" href="javascript:void(0);" id="smart-mod-eg1" onclick="MensajeSmartModPedidos('.$valor['foliopedido'].',2);"><i class="fa fa-trash-o">&nbsp;</i>Eliminar</button>';
					$opcion .= '<a id="recibirpedido" href="#ajax/recibir_pedido.php?folio='.$valor['foliopedido'].'" title="Recibe abonos y mercancias" type="button" class="btn btn-primary btn-xs noMostrarPrint"><i class="fa fa-edit">&nbsp;</i>Recibir</a></div></td>';
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
					}*/
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
					/*if ($iEncabezado == 0){
						$iEncabezado = 1;
						$i++;
						$opcion .= '<div class="table-responsive">';
						//$opcion .= '<tr><td style=" font-family:Arial;font-size: 16px;text-align:center;"><strong><br/>PEDIDOS DE D&Iacute;AS ANTERIORES</strong></td></tr>';
					}
					*/
					
					
					$opcion .= '<tr><td><table border="0" cellspacing="0" cellpadding="0" class="table-condensed" style="width:100%;font-size: 12px;margin: 0px;padding:0;">';
					$opcion .= '<td ><span style="font-size: 14px;">&nbsp;<strong>PEDIDO:</strong>&nbsp;<label id="folio">'.$valor['descripcion'].'</label></span><br/>';
					$opcion .= '&nbsp;FOLIO:&nbsp;<label id="folio">'.$valor['foliopedido'].'</label></td>';
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
?>