<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
class ContactFormExternalFormBlockController extends BlockController {
	
	public function action_submit_form() {
		
		$e = Loader::helper('validation/error');
		$ip = Loader::helper('validation/ip');		
		$txt = Loader::helper('text');
		$vals = Loader::helper('validation/strings');
		$captcha = Loader::helper('validation/captcha');

		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
		$to = "matthis@do-smile.de";
		$subject = "Kontaktformular";
		$wait_time = 60; // Wait time (s) between form re-submissions
		$_SESSION['stamp'] = $_POST['stamp'];
		
		$time = date("H:i:s T O");
		$day = date("l, j F Y");
		$proxy_name = "";
		$proxy_ip = "";
		$host_ip = "";

		// Extract domain names to be banned from email address
		$domainrange = array("YOUR_DOMAIN_NAMES");
		$emailspan = strcspn($email,"@");
		$domain = substr_replace($email,"",0,$emailspan+1);
		$domainspan = strcspn($domain,".");
		$domaincore = substr($domain,0,$domainspan);
		
		// Get sender's IP address and Host Name
		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$proxy_name = getenv('HTTP_VIA');
			$proxy_ip = getenv('REMOTE_ADDR');
			$host_ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		else {
			$host_ip = getenv('REMOTE_ADDR');
		}
		$host = isset($REMOTE_HOST) ? $REMOTE_HOST : @gethostbyaddr($host_ip);
		if($host == $host_ip) {
			$host = getenv('REMOTE_ADDR');
		}
		
		// clean input
		$delete_bcc = array("cc:", "Cc:", "cC:", "bcc:", "Bcc:", "BCc:", "BCC:", "bCc:", "bCC:");
		$name = trim($name);
		$name = preg_replace("/ +/", " ", $name);
		$name = str_replace($delete_bcc, "", $name);
		$email = trim($email);
		$email = preg_replace("/ +/", " ", $email);
		$email = str_replace($delete_bcc, "", $email);
		$message = trim($message);
		$message = preg_replace("/ +/", " ", $message);
		$message = wordwrap($message);
		$message_html = str_replace("\r","<br />",$message);
		
		// Build text part of email
		$txt_message = "Datum: $time $day\r\n";
		$txt_message .= "Host IP: $host_ip\r\n";
		$txt_message .= "Host Name: $host\r\n";
		$txt_message .= "Proxy IP: $proxy_ip\r\n";
		$txt_message .= "Proxy Name: $proxy_name\r\n\r\n";
		$txt_message .= "Name: $name\r\n";
		$txt_message .= "E-Mail: $email\r\n";
		$txt_message .= "Betreff: $subject\r\n\r\n";
		$txt_message .= "Nachricht:\r\n\r\n";
		$txt_message .= $message;
  
		// Build html part of email
		$html_message = "<html><body>";
		$html_message .= "<font color=\"red\">";
		$html_message .= "Datum: $time $day<br />";
		$html_message .= "Host IP: $host_ip<br />";
		$html_message .= "Host Name: $host<br />";
		$html_message .= "Proxy IP: $proxy_ip<br />";
		$html_message .= "Proxy Name: $proxy_name<br /><br />";
		$html_message .= "</font>";
		$html_message .= "<font color=\"blue\">";
		$html_message .= "Name: $name<br />";
		$html_message .= "E-Mail: $email<br />";
		$html_message .= "Betreff: $subject<br /><br />";
		$html_message .= "</font>";
		$html_message .= "<font color=\"navy\">";
		$html_message .= "<u>Nachricht:</u><br /><br />";
		$html_message .= $message_html;
		$html_message .= "</font>";
		$html_message .= "</body></html>";

		$error_msg = '<div id="error_msg">Wenn Sie Probleme haben uns eine Nachricht zu senden, schreiben Sie uns bitte mit Ihrem E-Mail Programm an <b>'.$to.'</b>. Vielen Dank!</div><hr />';
		$no_error_msg = '<div id="noerror">Danke für Ihre Anfrage. Sie erhalten in kürze eine Bestätigungsmail</div><hr />';
		
		if (!$ip->check()) {
			$e->add($ip->getErrorMessage());
		}		
		
		if (!$captcha->check()) {
			$e->add(t('Offenbar haben Sie einen falschen Sicherheitscode eingegeben.<br /> Bitte sehen Sie sich das Bild genau an und versuchen Sie es noch einmal!'));
			$_REQUEST['ccmCaptchaCode']='';
		}
		
		if (strlen($name) < 2) {
			$e->add(t('Ihr Name muss aus mindestens %s Zeichen bestehen.', 2));
		}
	
		if (strlen($name) > 70) {
			$e->add(t('Ihr Name kann aus technischen Gründen nicht länger als %s Zeichen sein.<br /> Falls doch benutzen Sie bitte eine Kurzform.', 70));
		}
		
		if (!$vals->email($email)) {
			$e->add(t('Sie haben offenbar eine ungültige E-Mail Adresse angegeben.'));
		}
		
		if (strlen($message) < 2) {
			$e->add(t('Schreiben Sie uns bitte eine Nachricht mit mehr Inhalt. %s Zeichen sind leider das Minimum.', 2));
		}
	
		if (strlen($message) > 3000) {
			$e->add(t('Ihre Nachricht darf aus Sicherheitsgründen hier nicht mehr als %s Zeichen lang sein.<br /> Senden Sie uns doch einfach eine Mail an '.$to.', oder kommen Sie zu einem persönlichen Gespräch vorbei. Danke!', 3000));
		}
		
		// Prevent hijackers from using your own domain name
		if (in_array($domaincore, $domainrange)) {
			$e->add(t('Um uns vor Spam und Injection-Attacken zu Schützen ist die Domain '.$domain.' nicht erlaubt.'));
		}
		
		// Prevent multiple automatic form submissions
		$submit_time = time(); // Get time stamp
		if ($submit_time < (trim($_SESSION['stamp']) + $wait_time)) {
			$e->add(t('Wie es aussieht, wurde dieses Formular erst vor kurzem an uns versendet - wir haben Ihre Nachricht also erhalten.<br /> Falls dies nicht der Fall sein sollte warte Sie bitte einen Augenblick und versuchen es dann erneut.'));
		}
		// Check if given domain name exists
		if (!checkdnsrr("$domain","MX")) {
			$e->add(t($domain.' scheint keine gültige Domain zu sein.'));
		}

		if (!$e->has()) {
			Loader::library('3rdparty/Zend/Mail');
			$zm = new Zend_Mail(APP_CHARSET);
			$zm->setSubject($subject);
			$zm->setBodyText($txt_message);
			$zm->setBodyHtml($html_message);
			$zm->addTo($to);
			$zm->setFrom($email);
			$zm->send();
			$_SESSION['stamp'] = time();
			$this->set('no_error_msg', $no_error_msg);
			
			$um = new Zend_Mail(APP_CHARSET);
			$um->setSubject("Ihre Anfrage wird bearbeitet.");
			$um->setBodyText("Vielen Dank für Ihre Anfrage beim Automobilzentrum Ohms. \nWir werden uns schnellstmöglich um die Bearbeitung bemühen und melden uns wieder bei Ihnen.\n\n Ihr Ohms Team.");
			$um->addTo($email);
			$um->setFrom($to);
			$um->send();
			$_SESSION['stamp'] = time();
			$this->set('no_error_msg', $no_error_msg);
			
			return true;
		} else {
			$errors = $e->getList(); 
			$this->set('errors', $errors);
			$this->set('error_msg', $error_msg);
		}
		
	}

}