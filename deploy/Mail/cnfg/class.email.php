<?php
require("class.phpmailer.php");
///////////// FUNCION PARA ENVIAR CORREOS  //////////////////
function e_mail($email,$subject="",$contenido="",$copiaoculta=""){

	$mail = new PHPMailer(true); //New instance, with exceptions enabled

	$contenido             = preg_replace('/\\\\/','', $contenido); //Strip backslashes

	$mail->IsSMTP();                           		// tell the class to use SMTP
	$mail->SMTPAuth   = true;                 		// enable SMTP authentication
	$mail->SMTPDebug  = 0;                     		// enables SMTP debug information (for testing)
	//$mail->SMTPSecure = true;
	if($_SERVER['SERVER_NAME']=="10.44.1.79"||$_SERVER['SERVER_NAME']=="cf.coppel.com"){
		//$mail->Port       = 2525;		                    // set the SMTP server port
		//$mail->Host       = "10.0.31.103";			// SMTP server
		$mail->Port       = 25;		                    // set the SMTP server port
		$mail->Host       = "10.33.128.98";	
	}else{
		$mail->Port       = 25;		                    // set the SMTP server port
		$mail->Host       = "10.33.128.98";			// SMTP server
	}
	$mail->Username   = "tiendavirtual@coppel.com";     // SMTP server username
	$mail->Password   = "serendipiti";            			// SMTP server password

	$mail->SetFrom('informacion@int.coppel.com', 'Tiendas Coppel');
	$mail->Timeout=30;
	$mail->AddAddress($email);
	if(!empty($copiaoculta)){
		$mail->AddBCC($copiaoculta);
	}
	$mail->Subject  = $subject;

	$mail->AltBody    = "Para ver el mensaje correctamente debe contar con un visor de correo que soporte codigo HTML"; // optional, comment out and test
	$mail->WordWrap   = 80; // set word wrap

	$mail->MsgHTML($contenido);
	$mail->CharSet = 'UTF-8';

	//$mail->IsHTML(true); // send as HTML

	$exito = $mail->Send();
	$intentos=1;
	while((!$exito) && ($intentos < 5)){
		sleep(5);
		$exito = $mail->Send();
		$intentos++;
	}
	/*if(!$exito){
		echo "Problemas al enviar correo electronico a ".$email;
		echo "<br>".$mail->ErrorInfo;
	}
	else{
		echo "Correo enviado a ".$email;
	}*/
	return $exito;
}

/////////////  FUNCION PARA ENVIAR CORREOS CON ADJUNTOS //////////////////
function e_mail_adj($email,$subject="",$contenido="",$urladjunto1="",$urladjunto2="",$copiaoculta=""){

	$mail = new PHPMailer(true); //New instance, with exceptions enabled

	$contenido             = preg_replace('/\\\\/','', $contenido); //Strip backslashes

	$mail->IsSMTP();                           		// tell the class to use SMTP
	$mail->SMTPAuth   = true;                 		// enable SMTP authentication
	$mail->SMTPDebug  = 0;                     		// enables SMTP debug information (for testing)
	//$mail->SMTPSecure = true;
	if($_SERVER['SERVER_NAME']=="10.44.1.79"||$_SERVER['SERVER_NAME']=="cf.coppel.com"){
		//$mail->Port       = 2525;		                    // set the SMTP server port
		//$mail->Host       = "10.0.31.103";			// SMTP server
		$mail->Port       = 25;		                    // set the SMTP server port
		$mail->Host       = "10.33.128.98";	
	}else{
		$mail->Port       = 25;		                    // set the SMTP server port
		$mail->Host       = "10.33.128.98";			// SMTP server
	}
	$mail->Username   = "tiendavirtual@coppel.com";     // SMTP server username
	$mail->Password   = "serendipiti";            			// SMTP server password

	$mail->SetFrom('informacion@int.coppel.com', 'Tiendas Coppel');
	$mail->Timeout=30;
	$mail->AddAddress($email);
	if(!empty($copiaoculta)){
		$mail->AddBCC($copiaoculta);
	}
	$mail->Subject  = $subject;

	$mail->AltBody    = "Para ver el mensaje correctamente debe contar con un visor de correo que soporte codigo HTML"; // optional, comment out and test
	$mail->WordWrap   = 80; // set word wrap
	$mail->AddAttachment($urladjunto1);
	if(!empty($urladjunto2)){
		$mail->AddAttachment($urladjunto2);
	}
	$mail->MsgHTML($contenido);
	$mail->CharSet = 'UTF-8';

	//$mail->IsHTML(true); // send as HTML

	$exito = $mail->Send();
	$intentos=1;
	while((!$exito) && ($intentos < 5)){
		sleep(5);
		$exito = $mail->Send();
		$intentos++;
	}
	/*if(!$exito){
		echo "Problemas al enviar correo electronico a ".$email;
		echo "<br>".$mail->ErrorInfo;
	}
	else{
		echo "Correo enviado a ".$email;
	}*/
	return $exito;
}
?>