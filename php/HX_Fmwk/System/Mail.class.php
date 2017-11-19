<?php
class Mail {

	private $_vPara = array ();
	private $_from;
	private $_fromName;
	private $_asunto;
	private $_body;
	private $_isHtml = true;

	public function __construct() {
	}

	public function clearRecipients() {
		$this->_vPara = array ();
	}

	public function addRecipient($mail, $nombre = "") {

		if ($nombre == "") {
			$this->_vPara[] = "$mail";
		} else {
			$this->_vPara[] = "$nombre <$mail>";
		}

	}
	public function from($mail, $nombre = "") {
		$this->_from = "<" . $mail . ">";
		$this->_fromName = $nombre;
	}

	public function subject($asunto) {
		$this->_asunto = $asunto;
	}
	public function body($body) {
		$this->_body = $body;
	}
	public function isHtml($hmtl) {
		$this->_isHtml = $hmtl;
	}

	public function send() {

		$from = $this->_fromName . " " . $this->_from;

		foreach ($this->_vPara as $para) {

			$cabeceras = "MIME-Version: 1.0 \r\n";
			if (!$this->_isHtml) {
				$cabeceras .= "Content-type: text/plain; charset=iso-8859-1 \r\n";
			} else {
				$cabeceras .= "Content-type: text/html; charset=iso-8859-1 \r\n";
			}
			$cabeceras .= "From: $from \r\n";

			mail($para, $this->_asunto, $this->_body, $cabeceras, "-f ".$this->_from);

		}

	}

}
?>