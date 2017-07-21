<?php
	error_reporting(0);
	session_start();
	if(ISSET($_SESSION)){
		$sPermisos = (ISSET($_SESSION['permisos'])?$_SESSION['permisos']:'');
		$nombreUsuario = (ISSET($_SESSION['nombreUsuario'])?$_SESSION['nombreUsuario']:'');
		//print_r($sPermisos);
		$arregloPermisos = explode(",",$sPermisos);
	}

//CONFIGURATION for SmartAdmin UI

//ribbon breadcrumbs config
//array("Display Name" => "URL");
$breadcrumbs = array(
	"Home" => APP_URL
);

//print_r($arregloPermisos);
$arregloSalida = array();
foreach ($arregloPermisos as $valor) {
	$arreglo = array();
    if($valor == 1){
		//Permisos para la agenda
		$arregloSalida = array("dashboard" => array("title" => "Agenda","url" => "ajax/dashboard.php","icon" => "fa-calendar"));
		$arregloSalida = array_merge($arregloSalida,array("capturar" => array("title" => "Facturar","url" => "ajax/capturar_pedido.php","icon" => "fa-pencil")));
		$arregloSalida = array_merge( $arregloSalida,array('abonos' => array('title' => "Abonos",'icon'=>'fa fa-usd','url'=>'ajax/abonos.php')));
	}else if($valor == 2){
		$arregloSalida = array_merge($arregloSalida,array("administracion" => array("title" => "Administraci&oacute;n","icon" => "fa-cogs","sub" => 
										array("Colonias" => 
												array("title" => "Colonias",
																"icon" => "fa fa-bullseye",
																"url" => "ajax/colonias.php"),
											  "Clientes" => 
											  	array("title" => "Clientes",
											  			"url" => "ajax/clientes.php",
											  			"icon" => "fa fa-list-alt"),
											  "Proveedores" => array(
											  							"title" => "Proveedores",
											  							"icon" => "fa fa-navicon",	
											  							"url" => "ajax/proveedores.php"
											  							),
											  "Concepto de Gastos" => array(
											  							"title" => "Concepto de gastos",
											  							"icon" => "fa fa-bank",	
											  							"url" => "ajax/concepto_gastos.php"
											  							),
											  "Usuarios" => array(
											  							"title" => "Usuarios",
											  							"icon" => "fa fa-user",	
											  							"url" => "ajax/usuarios.php"
											  							),																		
											  "Vendedores" => array(
											  							"title" => "Vendedores",
											  							"icon" => "fa fa-navicon",	
											  							"url" => "ajax/vendedores.php"
											  							),
											  "Zonas" => array(
																	"title" => "Zonas",
																	"icon" => "fa fa-bullseye",	
																	"url" => "ajax/zonas.php"
																	),
											  "Articulos" => array(
																	"title" => "Articulos",
																	"icon" => "ffa fa-cubes",	
																	"url" => "ajax/articulos.php"
																	)

											
											))));
		$arregloSalida = array_merge( $arregloSalida, array('recepcion' => array('title' => "Recepci&oacute;n", 'icon'=>'fa fa-book', 'sub'=>
											array('Facturas'=>
													array('title'=>'Facturas',
															'icon'=>'fa fa-cubes',
															'url'=>'ajax/inventario.php')
													,
													'Devoluciones'=>
														array('title'=>'Devoluciones',
															'icon'=>'fa fa-refresh',
															'url'=>'ajax/devoluciones.php')
													,
													'Cuentas Incobrables'=>
														array('title'=>'Cuentas Incobrables',
															'icon'=>'fa-bookmark-o',
															'url'=>'ajax/cuentas_incobrables.php')
													,'Mermas'=>
														array('title'=>'Mermas',
															'icon'=>'fa-exchange',
															'url'=>'ajax/mermas.php')
												) 
											)
								) 
		);
		
		$arregloSalida = array_merge($arregloSalida,array("Comisiones" => array("title" => "Comisiones","icon" => "fa-book","sub" =>
						 array('PagarComisiones' => array('title' => "Por Venta",'icon'=>'fa fa-check','url'=>'ajax/ver_comisionesporpagar.php'),
													array('title' => "Por Cobranza",'icon'=>'fa fa-check','url'=>'ajax/ver_comisionesporcobranza.php')
						))));
		$arregloSalida = array_merge($arregloSalida,array("Corte" => 
														array("title" => "Corte","icon" => "fa-book","sub" =>
						 									array('Realizar Corte Diario' => 
						 											array('title' => "Realizar Corte Diario",'icon'=>'fa fa-check','url'=>'ajax/corte.php'),
						 											array('title' => "Cortes Anteriores",'icon'=>'fa fa-check','url'=>'ajax/ver_corte_anteriores.php')
						))));
		
		$arregloSalida = array_merge($arregloSalida,array("Reportes" => array("title" => "Reportes Facturas","icon" => "fa-navicon","sub" =>
						 array('Reportes' => array('title' => "Facturados hoy",'icon'=>'fa fa-check','url'=>'ajax/ver_facturadoshoy.php'),
											 array('title' => "Cancelaci&oacute;n mes",'icon'=>'fa fa-remove','url'=>'ajax/ver_cancelacionesmes.php'),
											 array('title' => "Facturados periodo",'icon'=>'fa fa-check','url'=>'ajax/ver_facturadosperiodo.php'),
											 array('title' => "Cancelaci&oacute;n periodo",'icon'=>'fa fa-remove','url'=>'ajax/ver_cancelacionesperiodo.php')
						 ))));

				$arregloSalida = array_merge($arregloSalida,array("Reporte Compras" => array("title" => "Reporte Compras","icon" => "fa-navicon","sub" =>
						 array('Reportes' => 
						 					array('title' => "Compras proveedor diario",'icon'=>'fa fa-remove','url'=>'ajax/ver_inventarios.php'),
						 					array('title' => "Compras proveedor rango fecha",'icon'=>'fa fa-remove','url'=>'ajax/ver_inventarios.php?tipo=rango'),
											 array('title' => "Devoluciones a proveedor diario",'icon'=>'fa fa-remove','url'=>'ajax/ver_devoluciones.php'),
											 array('title' => "Devoluciones a proveedor Rango Fecha",'icon'=>'fa fa-check','url'=>'ajax/ver_devoluciones.php?tipo=rango')
											 ))));
				$arregloSalida = array_merge($arregloSalida,array("Reporte Gastos" => array("title" => "Reporte Gastos","icon" => "fa-navicon","sub" =>
						 array('Reportes' => 
											 array('title' => "Gastos diarios",'icon'=>'fa fa-remove','url'=>'ajax/ver_gastos.php'),
											 array('title' => "Gastos Rango Fecha",'icon'=>'fa fa-check','url'=>'ajax/ver_gastos.php?tipo=rango')
											 ))));
				$arregloSalida = array_merge($arregloSalida,array("Reporte Mermas" => array("title" => "Reporte Mermas","icon" => "fa-navicon","sub" =>
						 array('Reportes' => 
											 array('title' => "Mermas mensual",'icon'=>'fa fa-exchange','url'=>'ajax/ver_mermas.php'),
											 array('title' => "Mermas Rango Fecha",'icon'=>'fa fa-arrows-h','url'=>'ajax/ver_mermas.php?tipo=rango')
											 ))));
				$arregloSalida = array_merge($arregloSalida,array("Reportes Abonos" => array("title" => "Reportes Abonos","icon" => "fa-navicon","sub" =>
						 array('Reportes' => 

											 array('title' => "Abonos Diarios",'icon'=>'fa fa-remove','url'=>'ajax/ver_abonos_total.php'),
											 array('title' => "Abonos Rango Fecha",'icon'=>'fa fa-check','url'=>'ajax/ver_abonos_total.php?tipo=rango'),
											 array('title' => "Abonos Acumulados Diarios",'icon'=>'fa fa-remove','url'=>'ajax/ver_abonos.php'),
											 array('title' => "Abonos Acumulados Rango Fecha",'icon'=>'fa fa-check','url'=>'ajax/ver_abonos.php?tipo=rango')
											 ))));
		$arregloSalida = array_merge($arregloSalida,array("Reportes Comisiones" => array("title" => "Reportes Comisiones","icon" => "fa-navicon","sub" =>
						 array('ReportesComisiones' =>	array('title' => "Pagadas Hoy",'icon'=>'fa fa-check','url'=>'ajax/ver_comisionespagadashoy.php'),
													array('title' => "Pagadas Periodo",'icon'=>'fa fa-check','url'=>'ajax/ver_comisionespagadasperiodo.php'),
													array('title' => "Cobranza Pagadas Hoy",'icon'=>'fa fa-check','url'=>'ajax/ver_comisionescobranzapagadashoy.php'),
													array('title' => "Cobranza Pagadas Periodo",'icon'=>'fa fa-check','url'=>'ajax/ver_comisionescobranzapagadasperiodo.php')
						))));

		$arregloSalida = array_merge($arregloSalida,array("Reportes Acumulado" => array("title" => "Reportes Acumulado","icon" => "fa-navicon","sub" =>
						 array('ReportesAcumulado' =>	array('title' => "Acumulado Facturas pendientes liquidar vs Abonos",'icon'=>'fa fa-check','url'=>'ajax/ver_facturas_pendientes_abonos.php'),
						 	array('title' => "Acumulado Facturas pendientes liquidar vs Abonos Rango Fechas",'icon'=>'fa fa-check','url'=>'ajax/ver_facturas_pendientes_abonos.php?tipo=rango')
						
						))));
	}
}
$page_nav = $arregloSalida;

//print_r($page_nav);

/*navigation array config

ex:
"dashboard" => array(
	"title" => "Display Title",
	"url" => "http://yoururl.com",
	"url_target" => "_blank",
	"icon" => "fa-home",
	"label_htm" => "<span>Add your custom label/badge html here</span>",
	"sub" => array() //contains array of sub items with the same format as the parent
)




$page_nav = array(
	"dashboard" => array(
		"title" => "Agenda",
		"url" => "ajax/dashboard.php",
		"icon" => "fa-home"
	),
	"capturar" => array(
		"title" => "Capturar pedido",
		"url" => "ajax/capturar_pedido.php",
		"icon" => "fa-pencil-square-o"
	),
	"recibir" => array(
		"title" => "Recibir pedido",
		"url" => "ajax/recibir_pedido.php",
		"icon" => "fa fa-list-alt"
	),	
	"reportes" => array(
		"title" => "Reportes",
		"icon" => "fa-clipboard",
		"sub" => array(
			"rinventario" => array(
				"title" => "Inventario",
				"icon" => "fa fa-dedent ",
				"url" => "ajax/reportes_inventario.php"
			),
			"pedidopendiente" => array(
				"title" => "Pedidos pendientes",
				"icon" => "fa fa-pencil-square-o",
				"url" => "ajax/reportes_pedidos.php"
			) 			 
		)
	),
	"inventario" => array(
		"title" => "Inventario",
		"url" => "ajax/inventario.php",
		"icon" => "fa fa-cubes"
	),
	"administracion" => array(
		"title" => "Administraci&oacute;n",
		"icon" => "fa-cogs",
		"sub" => array(
			"usuarios" => array(
				"title" => "Usuarios",
				"icon" => "fa fa-group",
				"url" => "ajax/administracion_usuarios.php"
			),
			"zonas" => array(
				"title" => "Zonas",
				"icon" => "fa fa-crosshairs",
				"url" => "ajax/admnistracion_zonas.php"
			) 			 
		)
	)

);
echo "<pre>";
print_r($page_nav);
die();
*/
//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>