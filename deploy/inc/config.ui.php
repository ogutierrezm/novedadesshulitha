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
						$arregloSalida = array("catalogos" => array("title" => "Catalogos","icon" => "fa-list","sub" => 
										array(	
												"proveedores" => array("title" => "Proveedores","icon" => "fa fa-pencil-square-o",	"url" => "ajax/catalogos/proveedores.php")
											)));
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