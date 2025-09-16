<?php
require_once "libs/database.php";
require_once "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class correo{
	public function sendMail($datos){
		//consulto los datos de la solicitud
		$sql = "SELECT
					ide.id,
					ide.titulo,
					usu.nombre,
					usu.registro,
					usu.correo,
					DATE_FORMAT(ide.fecha_creacion, '%d-%m-%Y') as fecha_creacion
				FROM
					ideas ide INNER JOIN usuarios usu ON ide.creado_por = usu.id
				WHERE
					ide.id = $datos[idea]";
		$db = new database();
       	$resultado = $db->ejecutarConsulta($sql);
       	if($resultado['ejecuto']){
       		$mail = new PHPMailer(true);
			try {
				$mail->isSMTP();
				$mail->Host = 'relay.emcali.com.co';
				$mail->Port = 25;
				//Recipients
				$mail->setFrom('no-replay@emcali.com.co', 'EmNOVA');
				$mail->addAddress($resultado['data'][0]['correo'], $resultado['data'][0]['nombre']);
				//$mail->addCC($datos['jefe']['correo']);
				//Content
				$mail->isHTML(true);
				$mail->Subject = "Nueva idea código # I-".str_pad($datos['idea'], 3, "0", STR_PAD_LEFT);
				$mail->Body = "Hola, <b>".$resultado['data'][0]['nombre']."</b>
								<br>
								<br>
								Se registro correctamente su idea con titulo <b>".$resultado['data'][0]['titulo']."</b> el código asignado es <b># I-".str_pad($datos['idea'], 3, "0", STR_PAD_LEFT)."</b>.
								<br>
								<br>								
								<b>Fecha de registro:</b> ".$resultado['data'][0]['fecha_creacion']."
								<br>
								<b>Proponente:</b> ".$resultado['data'][0]['nombre']."
								</br>
								<b>Registro:</b> ".$resultado['data'][0]['registro']."
								</br>
								</br>
								Pronto sera contactado por el equipo de innovación para iniciar el proceso.";
				$mail->CharSet = 'UTF-8';
				$mail->send();
				return [
					'ejecuto' => true,
					'mensaje' => 'Correo enviado correctamente'
				];
			} catch (Exception $e) {
				return [
					'ejecuto' => false,
					'mensaje' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
				];
			}
       	}
	}

	public function pruebaUnitaria($datos){
		$mail = new PHPMailer(true);
		try {
			$mail->isSMTP();
			$mail->Host = 'relay.emcali.com.co';
			$mail->Port = 25;
			//Recipients
			$mail->setFrom('no-replay@emcali.com.co', 'ASIMATI');
			$mail->addAddress("vhhernandez@emcali.com.co", "Víctor Hugo Hernández");
			//Content
			$mail->isHTML(true);
			$mail->Subject = "Correo de prueba";
			$mail->Body = "Hola, <b>Víctor Hugo Hernández</b>
							<br>
							<br>
							Luego de revisar la información registrada en la solicitud";
			$mail->CharSet = 'UTF-8';
			$mail->send();
			return [
				'ejecuto' => true,
				'mensaje' => 'Correo enviado correctamente'
			];
		} catch (Exception $e) {
			return [
				'ejecuto' => false,
				'mensaje' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
			];
		}
	}
}