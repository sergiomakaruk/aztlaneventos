<?php

include "../../../php/HX_Fmwk/load.php";
error_reporting(0);
class Index extends AppSerializableController {

  public function onLoad() {

  	//PARAMS:------->
	  		//params
		  	//camp
  	ob_clean();
  	if($this->data->params->eventSelect)
  	{
  		$evento = GET_eventos::getEvento($this->data->params->eventSelect);
  	}else
  	{
  		$evento = GET_eventos::getEvento($this->data->evento);
  	}
			
	$owner = GET_camp::getOwner($this->data->owner);
	$source = GET_camp::getSource($this->data->source);
	
  	$isReserva = ($evento->tipo == 1) ? true:false;
  	$usuario = SET_camp::setUsuario($evento,$owner,$source,$this->data->params);
  	
  	if($isReserva) {
  		SET_camp::setReserva($evento,$owner,$source,$this->data->params,$usuario->idUsuario);
  		parent::addToSend(GET_camp::getReserva($this->data->evento,$usuario->idUsuario),'reserva');  		
  	}
  	else SET_camp::setConsulta($this->data->params,$usuario->idUsuario);

	parent::addToSend($usuario,'usuario');
	
	/*
	
	if($isReserva){
		parent::send();
		return;
	}
	
	*/
	
  	$fecha = new Fecha();

	// PREPARE THE BODY OF THE MESSAGE
	$message .= '';
	//$message .= '<html>';
	$message .= '<body style="font-family:Tahoma, Geneva, sans-serif;">';
	$message .= '<div style="background: #1b1b1b;width:800px;margin:0 auto;">';
	$message .= '<div style="color:black;background: #F9FAF7;width:800px;text-align:center">';	
	$message .= '<h3 style="margin:0px;padding-top:20px;">CONSULTAS DESDE LA WEB</h3>';
	$message .= '<h2 style="margin:0px;padding-top:20px;"> '. $evento->titulo .'</h2>';
	$message .= '<h2 style="margin:0px;padding-top:20px;"> '. $evento->subtitulo .'</h2>';
	$message .= '<h2 style="margin:0px;padding-top:20px;"> '. $evento->fechaStr .'</h2>';
	$message .= '<h3 style="margin:0px;padding:20px 0px">FORMULARIO '.$fecha.'</h3>';
	$message .= '</div>';
	$message .= '<table rules="all" style="background: white;border-color: #666;" cellpadding="10" width="800">';

  	foreach ($this->data->params as $key => $valor)
		{
			if(ucfirst(strtolower($key)) != "G-recaptcha-response")
			{
				$message .= '<tr><td><strong>'.ucfirst(strtolower($key)).'</strong> </td><td>' . strip_tags($valor) . '</td></tr>';
			}			
		}
	$message .= '<tr><td><strong>'.$owner->nombre .'</strong> </td><td>' . $source->nombre . '</td></tr>';
	$message .= '</table>';
	$message .= '</div>';
	$message .= "</body>";
	//$message .= '</html>';

	//echo $message;return;



	$mail = new PHPMailer;

	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail

	$emailserver = 'formularios@aztlan.com.ar';

	//DESCOMENTAR ESTOS PARA CORREO PRIVADO

	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465;
	$mail->Username = $emailserver;
	$mail->Password = 'aztlanforms';


	$mail->From = $emailserver;
	$mail->FromName = 'Form Web Psico';
	$mail->addAddress($owner->email);
	$mail->addReplyTo($emailserver, 'Respuesta de formulario web');
	//$mail->addBCC('cristianoaltamirano@gmail.com');
	$mail->addBCC('nicolas.nardi@aztlan.org.ar');
	$mail->addBCC('secretaria@aztlan.com.ar');
	$mail->addBCC('secretaria@aztlan.org.ar');

	$mail->addBCC('maximo.aztlan@gmail.com');
	$mail->addBCC('cristian.aztlan@gmail.com');
	$mail->addBCC('alejandra.aztlan@gmail.com');
	/*$mail->addBCC('malejandraiglesias@gmail.com');
	$mail->addBCC('luciapocosgnich@gmail.com');
	$mail->addBCC('rosbochgerman@gmail.com');
	$mail->addBCC('pablogaut@gmail.com');
	$mail->addBCC('lorenagrodriguez4@gmail.com');
	$mail->addBCC('valeria.andersen73@gmail.com');
	$mail->addBCC('milena_m1989@hotmail.com');*/

	$mail->isHTML(true);                                  // Set email format to HTML

	if($isReserva) $mail->Subject = 'Reserva - ' .$usuario->idUsuario ;
	else $mail->Subject = 'Consulta - ' .$usuario->idUsuario ;
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
//ALTER TABLE  `owners` ADD  `email` VARCHAR( 300 ) NOT NULL AFTER  `nombre` ;
?>

