<?php
require_once('pdo_cnn_class/pdo_database_v2.class.php');
require_once('constant.php');

function getConexionTda(){
	$cnn = new wArLeY_DBMS(BD_TYPE_TDA, BD_HOST_TDA, BD_TDA, BD_USER_TDA, BD_PASSWORD_TDA, BD_PORT_TDA);
	$dbObj = $cnn->Cnxn();
	return $cnn;
}

function closeConexion($cnn){
	if(GrabarLog == "1"){
		setLogData($cnn->sqlOut);
		if($cnn->err_msgOut != ''){
			setLogData($cnn->err_msgOut);
		}
	}
	$cnn->disconnect();
}

function setLogData($data_text){
	date_default_timezone_set('America/Mazatlan');
	$data_text = date("Y-m-d h:i:sa").'  -  '.$data_text.PHP_EOL;
	file_put_contents( "log.txt" , $data_text , FILE_APPEND | LOCK_EX );
}
?>

