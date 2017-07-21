<?PHP 
	include('calls/fn_generales.php');
	include('conx/conexiones.php');
	print_r(json_encode(ValidarSiLaFechaEsHoy('2016-01-02','2016-01-01')));
?>