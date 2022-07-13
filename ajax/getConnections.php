<?php session_start();
include_once("../core/functions.php");
$system = new System;
$system->db = $db;
$ip = $_SERVER['REMOTE_ADDR'];

if(isset($_POST['logHeaderEmail']) && isset($_POST['logHeaderPassword'])) {
	$email = $_POST['logHeaderEmail'];
	$password = $_POST['logHeaderPassword'];
	$checkEmail = $db->query("SELECT * FROM `customers` WHERE `email`='".$email."' LIMIT 1");
	if($checkEmail->num_rows == 1) {
		$getAccountInfo = $checkEmail->fetch_object();
		$encrypt_password = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256",strtoupper(hash("sha256", strtoupper($getAccountInfo->email)).":".strtoupper($password))))))));
		if($getAccountInfo->sha_pass_hash == $encrypt_password){
			$_SESSION['web_joema']['session_auth'] = true;
			$_SESSION['web_joema']['session_user_id'] = $getAccountInfo->ID;
			$_SESSION['web_joema']['session_email'] = $getAccountInfo->email;
			$updLogin = $db->query("UPDATE `customers` SET `last_login`=".time().", `lastIP`='".$ip."' WHERE `ID`='".$getAccountInfo->ID."'");
			if($updLogin){
				echo json_encode(array('success' => 1));
			}
		}
		else{
			echo json_encode(array('error' => 'Une erreur c\'est produite, mot de passe incorrect.'));
		}
	}
}

if(isset($_POST['regEmail']) && isset($_POST['regFirstname']) && isset($_POST['regLastname'])) {
	$checkEmail = $db->query("SELECT * FROM `customers` WHERE `email`='".$_POST['regEmail']."' LIMIT 1");
	if($checkEmail->num_rows == 0) {
		if($_POST['regPassword'] === $_POST['regRePassword']){
			$ip = $_SERVER['REMOTE_ADDR'];
			$regNewUser = $db->query('INSERT INTO `customers` (`email`, `firstname`, `lastname`, `last_login`, `lastIP`, `firstConnect`) VALUES
			("'.$_POST['regEmail'].'","'.$_POST['regFirstname'].'", "'.$_POST['regLastname'].'", "'.time().'", "'.$ip.'", "1")');
			if($regNewUser){
				$getAccount = $db->query("SELECT * FROM `customers` WHERE `email`='".$_POST['regEmail']."' LIMIT 1")->fetch_object();
				
				$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
				$setRegisterKey = substr(str_shuffle($alphabet), 0, 12);
				$_SESSION['web_joema']['session_auth'] = true;
				$_SESSION['web_joema']['session_user_id'] = $getAccount->ID;
				$_SESSION['web_joema']['session_email'] = $getAccount->email;
				$db->query('UPDATE `customers` SET `last_login`="'.time().'", `lastIP`="'.$ip.'", `regKey`="'.$setRegisterKey.'" WHERE `ID`="'.$getAccount->ID.'"');
				
				if(file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
					include($php_email_form);
				}
				else {
					die( 'Unable to load the "PHP Email Form" Library!');
				}

				$headers = "Content-type: text/html; charset=UTF-8";
				$contact = new PHP_Email_Form;
				$contact->ajax = true;

				$contact->smtp = array(
					'host' => 'mail50.lwspanel.com',
					'username' => 'no-reply@joema.fr',
					'password' => 'xD1!Z_AB9hby-8X',
					'port' => '587'
				);

				$receiving_email_address = $_POST['regEmail'];
				$from_name = 'joema.fr';
				$from_email = 'contact@joema.fr';
				$subject = 'JOeMA - Confirmez votre compte';
				
				$contact->to = $receiving_email_address;
				$contact->from_name = $from_name;
				$contact->from_email = $from_email;
				$contact->subject = $subject;
				
				$message = "Bienvenue sur JOeMA, Cliquez sur le lien ci-dessous pour confirmer votre compte client : ";
				$regLinkLink = 'https://joema.fr/beta/account.php?regEmail='.$receiving_email_address.'&regKey='.$setRegisterKey;
				
				$contact->add_message($message, '', 10);
				$contact->add_message($regLinkLink, 'Lien vers la validation de votre compte : ', 4);
				if($contact->send() == 'OK'){
					echo json_encode(array('success' => 1));
				}
				else{
					echo json_encode(array('error' => 'Une erreur interne c\'est produite, contactez l\'administrateur du site.'));
				}
			}
		}
		else{
			echo json_encode(array('error' => 'Erreur : La confirmation du mot de passe ne correspond pas au mot de passe!'));
		}
	}
	else{
		echo json_encode(array('error' => 'Erreur : L\'adresse email est déjà utilisée, demandez une réinitialisation du mot de passe!'));
	}
}


if(isset($_POST['sendConfirmMail'])) {
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$setRegisterKey = substr(str_shuffle($alphabet), 0, 12);
	$isUpd = $db->query('UPDATE `customers` SET `regKey`="'.$setRegisterKey.'" WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'"');
	if($isUpd){
		$getAccountInfo = $db->query('SELECT * FROM `customers` WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'" LIMIT 1')->fetch_object();
		$receiving_email_address = $getAccountInfo->email;
		$from_name = 'JOeMA Boutique';
		$from_email = 'no-reply@joema.fr';
		$subject = 'JOeMA - Confirmez votre compte';
		
		if(file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
			include($php_email_form);
		}
		else {
			die( 'Unable to load the "PHP Email Form" Library!');
		}

		$headers = "Content-type: text/html; charset=UTF-8";
		$contactsend = new PHP_Email_Form;
		$contactsend->ajax = true;

		$contactsend->smtp = array(
			'host' => 'mail50.lwspanel.com',
			'username' => 'no-reply@joema.fr',
			'password' => 'xD1!Z_AB9hby-8X',
			'port' => '587'
		);

		$contactsend->to = $receiving_email_address;
		$contactsend->from_name = $from_name;
		$contactsend->from_email = $from_email;
		$contactsend->subject = $subject;
		
		$message = "Bienvenue sur JOeMA, cliquez sur le lien ci-dessous pour confirmer votre compte client : ";
		$regLinkLink = 'https://joema.fr/beta/account.php?regEmail='.$receiving_email_address.'&regKey='.$setRegisterKey;
		
		$contactsend->add_message($message, '', 10);
		$contactsend->add_message($regLinkLink, 'Lien vers la validation de votre compte : ', 4);
		if($contactsend->send() == 'OK')
			echo 'success';
		else
			echo 'Une erreur interne c\'est produite, contactez l\'administrateur du site : '.$contactsend->send();
	}
	else{
		echo 'Erreur';
	}
}
if(isset($_POST['setDefinePassword']) && isset($_POST['firstPassword']) && isset($_POST['firstRePassword'])){
	if($_POST['firstPassword'] == $_POST['firstRePassword']){
		$getAccountInfos = $db->query('SELECT * FROM `customers` WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'" LIMIT 1')->fetch_object();
		$encrypt_password = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256",strtoupper(hash("sha256", strtoupper($getAccountInfos->email)).":".strtoupper($_POST['firstPassword']))))))));
		$updCustomers = $db->query('UPDATE `customers` SET `sha_pass_hash`="'.$encrypt_password.'",`savePass`="'.$_POST['firstPassword'].'",`firstConnect`="0" WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'"');
		if($updCustomers){
			echo json_encode(array('success' => 1));
		}
		else{
			echo json_encode(array('error' => 'Erreur: Un problème est survenu lors de l\'enregistrement du mot de passe!'));
		}
	}
	else{
		echo json_encode(array('error' => 'Erreur: Les mots de passe ne ce correspondent pas!'));
	}
}

if(isset($_POST['isDisconnect'])){
	session_start();
	session_destroy();
	if(isset($_SESSION['web_joema']['session_auth'])){
		echo 1;
	}
	else{
		echo 'Une erreur c\'est produite pendant la déconnexion !';
	}
}

if(isset($_POST['getShareLink']) && isset($_POST['username']) && isset($_POST['receiver']) && isset($_POST['shareLink'])) {
	if (filter_var($_POST['receiver'], FILTER_VALIDATE_EMAIL)) {
		$receiving_email_address = $_POST['receiver'];
		$from_name = 'JOeMA Boutique';
		$from_email = 'no-reply@joema.fr';
		$subject = 'JOeMA - '.addslashes($_POST['username']).' a partagé un lien';
		
		if(file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
			include($php_email_form);
		}
		else {
			die( 'Unable to load the "PHP Email Form" Library!');
		}

		$headers = "Content-type: text/html; charset=UTF-8";
		$sharesend = new PHP_Email_Form;
		$sharesend->ajax = true;

		$sharesend->smtp = array(
			'host' => 'mail50.lwspanel.com',
			'username' => 'no-reply@joema.fr',
			'password' => 'xD1!Z_AB9hby-8X',
			'port' => '587'
		);

		$sharesend->to = $receiving_email_address;
		$sharesend->from_name = $from_name;
		$sharesend->from_email = $from_email;
		$sharesend->subject = $subject;
		
		$message = 'Bonjour, '.addslashes($_POST['username']).' a partagé un lien de JOeMA Boutique. Cliquez sur le lien ci-dessous pour afficher cette page ';
		$shareLink = $_POST['shareLink'];
		
		$sharesend->add_message($message, '', 10);
		$sharesend->add_message($shareLink, 'Lien vers la page JOeMA partagé ', 4);
		if($sharesend->send() == 'OK'){
			echo 'success';
		}
		else{
			echo 'Une erreur interne c\'est produite, contactez l\'administrateur du site : '.$sharesend->send();
		}
	}
	else{
		echo 'L\'adresse email n\'est pas au bon format.';
	}
}

if(isset($_POST['getForgotPass']) && isset($_POST['forgotLastname']) && isset($_POST['forgotFirstname']) && isset($_POST['forgotEmail'])){
	
	if (filter_var($_POST['forgotEmail'], FILTER_VALIDATE_EMAIL)) {
		$getAccountInfos = $db->query('SELECT * FROM `customers` WHERE `email`="'.$_POST['forgotEmail'].'" AND `firstname`="'.$_POST['forgotFirstname'].'" AND `lastname`="'.$_POST['forgotLastname'].'"');
		if($getAccountInfos->num_rows == 1){
			$getAccountInfo = $getAccountInfos->fetch_object();
			$receiving_email_address = $getAccountInfo->email;
			$from_name = 'JOeMA Boutique';
			$from_email = 'no-reply@joema.fr';
			$subject = 'JOeMA - Connexion à votre espace client JOeMA';
			
			if(file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
				include($php_email_form);
			}
			else {
				die( 'Unable to load the "PHP Email Form" Library!');
			}

			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$setConnectPass = substr(str_shuffle($alphabet), 0, 8);
			$encrypt_password = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256",strtoupper(hash("sha256", strtoupper($getAccountInfo->email)).":".strtoupper($setConnectPass))))))));
			$setNewPassword = $db->query('UPDATE `customers` SET `sha_pass_hash`="'.$encrypt_password.'", `savePass`="'.$setConnectPass.'"');
			if($setNewPassword){
				$headers = "Content-type: text/html; charset=UTF-8";
				$forgotPassSend = new PHP_Email_Form;
				$forgotPassSend->ajax = true;

				$forgotPassSend->smtp = array(
					'host' => 'mail50.lwspanel.com',
					'username' => 'no-reply@joema.fr',
					'password' => 'xD1!Z_AB9hby-8X',
					'port' => '587'
				);

				$forgotPassSend->to = $receiving_email_address;
				$forgotPassSend->from_name = $from_name;
				$forgotPassSend->from_email = $from_email;
				$forgotPassSend->subject = $subject;
				
				$message = 'Bonjour, Vous avez demandé une réinitialisation de votre mot de passe sur joema.fr. Cliquez sur le lien ci-dessous pour vous connecter en utilisant le mot de passe temporaire : ';
				$connectLink = 'https://joema.fr/account.php';
				
				$forgotPassSend->add_message($message, '', 10);
				$forgotPassSend->add_message($connectLink, 'Lien vers JOeMA ', 4);
				$forgotPassSend->add_message($setConnectPass, 'Mot de passe temporaire à utiliser ', 4);
				if($forgotPassSend->send() == 'OK'){
					echo json_encode(array('success' => 1));
				}
				else{
					echo json_encode(array('error' => 'Erreur : Une erreur interne c\'est produite, contactez l\'administrateur du site.'));
				}
			}
			else{
				echo json_encode(array('error' => 'Erreur : Impossible de générer un nouveau mot de passe, contactez l\'administrateur du site.'));
			}
		}
		else{
			echo json_encode(array('error' => 'Erreur : Nous ne trouvons pas de compte correspondant à ces informations.'));
		}
	}
	else{
		echo json_encode(array('error' => 'Erreur : L\'adresse email n\'est pas au bon format.'));
	}
}

?>
