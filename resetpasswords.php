<?php
require 'wp-blog-header.php';

$success_number = 0;
$error_number = 0;

$args = array(
	'exclude' => array('1')
);
$users = get_users($args);

foreach ($users as $user) {
	$password = wp_generate_password( 8, true ); //Genera un password aleatorio de 8 caracteres
	wp_set_password( $password, $user->ID ); //Setea el password generado al usuario

	$to = $user->user_email;
	$subject = 'Actualiza tu contraseña'; //Asunto del mensaje
	/**
	 * Mensaje formateado
	 */
	$message = sprintf(
		'Tu información de acceso fue actualizada:<br />
		<br />
		Nombre de usuario: %1$s<br />
		Contraseña: %2$s<br />
		Link de ingreso: <a href="http://foo.bar</a><br />
		<br />'
	,
	$user->user_login,
	$password
	);
	$headers[] = 'From: Foo <foo@bar>'; //Remitente
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
 	
 	/**
 	 * Envia mensaje, registra número de envios y captura errores
 	 */
	if( wp_mail( $to, $subject, $message, $headers ) ) {
		echo 'Email enviado exitosamente a: '.$user->user_login.' : '.$user->user_email;
		echo "\n";
		$success_number++;
	} else {
		echo 'Error al enviar a: '.$user->user_login;
		echo "\n";
		$error_number++;
	}
}

echo 'TOTAL DE ENVIOS EXITOSOS: '.$success_number;
echo "\n";
echo 'TOTAL DE ENVIOS ERRONEOS: '.$error_number;
?>