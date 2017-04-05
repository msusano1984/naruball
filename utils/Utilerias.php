<?php

function envia_mail($to, $titulo, $mensaje, $from = "yo@msusano.com"  ){
	$headers = array(
	  'From: "The Sending Name" <yo@msusano.com>' ,
	  'Reply-To: "The Reply To Name" <yo@msusano.com>' ,
	  'X-Mailer: PHP/' . phpversion() ,
	  'MIME-Version: 1.0' ,
	  'Content-Type: text/html; charset=UTF-8' 
	);
	$headers = implode( "\r\n" , $headers );
	mail ( $to , $titulo, $mensaje, $headers, "-f ".$from);
	return "OK";

}

?>
