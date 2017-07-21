<?php
$html ='
<link rel="stylesheet" type="text/css" href="http://flwebsites.biz/jAlert/src/jAlert-v3.css">
<script src="http://flwebsites.biz/jAlert/src/jAlert-v3.js" type="text/javascript"></script>
<script src="js/piscis/jTimeout-v2.0.js" type="text/javascript"></script>
<script>
	
	$(function(){
		var vCurrentTime;
		var timer,
			setTimer = function(){
				timer = window.setInterval(function(){
					vCurrentTime = window.localStorage.timeoutCountdown ;
					//console.log(vCurrentTime);
				}, 1000);
			};
		
		setTimer();
	});
	
	$( document ).on( "mousemove", function( event ) {
		//console.log("reset del tiempo "+ window.localStorage.timeoutCountdown + " tiempo " + vTiempoSesion);
		$.jTimeout.reset(vTiempoSesion);
		//console.log("reset exitoso tiempo:" + vTiempoSesion + " timer :" + window.localStorage.timeoutCountdown);
	});
	
$.jTimeout();
	
</script>';
echo $html;
$YaInstanciado = 1;
?>