<?php

include "../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  	//PARAMS:------->
	  		//nombre
		  	//email
		  	//consulta
		  	//telefono
		  	//newsletter

  	$nombre = escape($this->data->nombre);
  	$tel = escape($this->data->telefono);
  	$email = escape($this->data->email);
  	$dni = escape($this->data->dni);
  	$consulta = escape($this->data->consulta);
  	$facebook = escape($this->data->facebook);
  	$newsletter = $this->data->newsletter;
  	$fecha = new Fecha();

	$cid = SET_consulta::setConsulta($this->data);
	parent::addToSend($cid,'consulta');

	// PREPARE THE BODY OF THE MESSAGE
	$message .= '';
	//$message .= '<html>';
	$message .= '<body style="font-family:Tahoma, Geneva, sans-serif;">';
	$message .= '<div style="background: #1b1b1b;width:800px;margin:0 auto;">';	
	$message .= '<div style="color:black;background: #F9FAF7;width:800px;text-align:center">';
	if($newsletter==1)$message .= '<h2 style="margin:0px;padding-top:20px;">SUSCRIPCION AL NEWSLETTER DE PSICOLOGÍA</h2>';
	else $message .= '<h2 style="margin:0px;padding-top:20px;">CONSULTAS DESDE LA WEB DE PSICOLOGÍA</h2>';
	//$message .= '<img style="margin-bottom:0px;" src="http://www.kyk-impo.com.ar/email/images/separacion_rayas.jpg" alt="www.kyk-impo.com.ar" />';
	$message .= '<h3 style="margin:0px;padding:20px 0px">FORMULARIO</h3>';
	$message .= '</div>';
	//$message .= '<br/><br/>';
	$message .= '<table rules="all" style="background: white;border-color: #666;" cellpadding="10" width="800">';
	$message .= '<tr><td><strong>Nombre:</strong> </td><td>' . strip_tags($nombre) . '</td></tr>';
	$message .= '<tr><td><strong>Teléfono:</strong></td><td>' . strip_tags($tel) . '</td></tr>';
	$message .= '<tr><td><strong>Email:</strong></td><td>' . strip_tags($email)  . '</td></tr>';
	$message .= '<tr><td><strong>DNI:</strong></td><td>' . strip_tags($dni)  . '</td></tr>';
	$message .= '<tr><td><strong>Facebook:</strong></td><td>' . strip_tags($facebook)  . '</td></tr>';
	$message .= '<tr><td><strong>Consulta:</strong> </td><td>' . strip_tags($consulta) . '</td></tr>';
	$message .= '<tr><td><strong>Fecha:</strong> </td><td>' . strip_tags($fecha) . '</td></tr>';
	$message .= '</table>';
	$message .= '</div>';
	$message .= "</body>";
			
	//$message .= '</html>';

	//echo $message;return;



	$mail = new PHPMailer;

	//$mail->isSMTP();                                      // Set mailer to use SMTP
	//$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup server
	//$mail->SMTPAuth = true;                               // Enable SMTP authentication
	//$mail->Username = 'jswan';                            // SMTP username
	//$mail->Password = 'secret';                           // SMTP password
	//$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

	$mail->CharSet = 'UTF-8';
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail

	$emailserver = 'info@cgjung.com.ar';
	$emailserver = 'formularios@aztlan.com.ar';

	//DESCOMENTAR ESTOS PARA CORREO PRIVADO
	//$mail->Host = "localhost";
	//$mail->Port = 25;
	$mail->Host = 'smtp.gmail.com';
	//$mail->Port = 587;//465
	$mail->Port = 465;
	$mail->Username = $emailserver;
	$mail->Password = 'Acuario1936';
	$mail->Password = 'aztlanforms';


	$mail->From = $emailserver;
	$mail->FromName = 'Form Web Psico';
	//$mail->addAddress($this->data->email,$this->data->nombre);               // Name is optional
	$mail->addAddress('florencia.santoni@aztlan.com.ar');
	$mail->addReplyTo($emailserver, 'Respuesta de formulario web');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('sergio@aztlan.com.ar');
	//$mail->addBCC('cristianoaltamirano@gmail.com');
	$mail->addBCC('nicolas.nardi@aztlan.org.ar');
	$mail->addBCC('secretaria@aztlan.com.ar');
	$mail->addBCC('secretaria@aztlan.org.ar');

	$mail->addBCC('maximo.aztlan@gmail.com');
	$mail->addBCC('cristian.aztlan@gmail.com');

	//$mail->addAttachment('../../email/firmas/firma-sergio-itic.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Formulario Web Psicología - n° ' . $cid ;
	$mail->Body    = $message;
	//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	$serviceMsg = '';
	if(!$mail->send()) {
		$serviceMsg.= 'Message could not be sent.';
		$serviceMsg.= '\n' . 'Mailer Error: ' . $mail->ErrorInfo;
		//TWROW EXEPTION;
	}else 	$serviceMsg.= 'Message has been sent';

	parent::addToSend($serviceMsg,"email");

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>