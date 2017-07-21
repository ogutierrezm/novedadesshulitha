<?php
if(!defined('ENVIROMENT_MODE')) define("ENVIROMENT_MODE", "TEST");

if(ENVIROMENT_MODE!="TEST" && ENVIROMENT_MODE!="PRODUCTION" && ENVIROMENT_MODE!="TEST_PRODUCTION") die("Error Fatal in ENVIROMENT_MODE, line 0");

if(!defined('TIEMPO_EXTRA')) define("TIEMPO_EXTRA", "01:00:00");

switch(ENVIROMENT_MODE){
	case "TEST":
		
		if(!defined('GrabarLog')) define("GrabarLog", "1");
		if(!defined('ARTICULORENTADO')) define("ARTICULORENTADO", "1");
		if(!defined('BACKUP_FILE')) define("BACKUP_FILE", "/backup.sql");
		if(!defined('BD_HOST_TDA')) define("BD_HOST_TDA", "localhost");
		if(!defined('BD_TDA')) define("BD_TDA", "postgres");
		if(!defined('BD_USER_TDA')) define("BD_USER_TDA", "postgres");
		if(!defined('BD_PASSWORD_TDA')) define("BD_PASSWORD_TDA", "empresa");
		if(!defined('BD_TYPE_TDA')) define("BD_TYPE_TDA", "pg");
		if(!defined('BD_PORT_TDA')) define("BD_PORT_TDA", "5432");
		
		break;
	case "TEST_PRODUCTION":
		//TDA
		if(!defined('GrabarLog')) define("GrabarLog", "1");
		if(!defined('ARTICULORENTADO')) define("ARTICULORENTADO", "1");
		if(!defined('BACKUP_FILE')) define("BACKUP_FILE", "/backup.sql");
		if(!defined('BD_HOST_TDA')) define("BD_HOST_TDA", "localhost");
		if(!defined('BD_TDA')) define("BD_TDA", "DiversionesPiscis");
		if(!defined('BD_USER_TDA')) define("BD_USER_TDA", "postgres");
		if(!defined('BD_PASSWORD_TDA')) define("BD_PASSWORD_TDA", "empresa");
		if(!defined('BD_TYPE_TDA')) define("BD_TYPE_TDA", "pg");
		if(!defined('BD_PORT_TDA')) define("BD_PORT_TDA", "5432");
		
		break;
	case "PRODUCTION":
		if(!defined('GrabarLog')) define("GrabarLog", "1");
		if(!defined('ARTICULORENTADO')) define("ARTICULORENTADO", "1");
		if(!defined('BACKUP_FILE')) define("BACKUP_FILE", "/backup.sql");
		if(!defined('BD_HOST_TDA')) define("BD_HOST_TDA", "localhost");
		if(!defined('BD_TDA')) define("BD_TDA", "DiversionesPiscis");
		if(!defined('BD_USER_TDA')) define("BD_USER_TDA", "postgres");
		if(!defined('BD_PASSWORD_TDA')) define("BD_PASSWORD_TDA", "empresa");
		if(!defined('BD_TYPE_TDA')) define("BD_TYPE_TDA", "pg");
		if(!defined('BD_PORT_TDA')) define("BD_PORT_TDA", "5432");
		
		break;
}
?>