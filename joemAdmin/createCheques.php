<?php session_start();
	include_once("../core/functions.php");
	$system->db = $db;
	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	require 'assets/PHPMailer/src/Exception.php';
	require 'assets/PHPMailer/src/PHPMailer.php';
	require 'assets/PHPMailer/src/SMTP.php';

	function writeToImage($fromName, $toName, $amount, $chequeNber, $date){
		if(file_exists('assets/images/empty-gift.png')){
			$im = @imagecreatefrompng('assets/images/empty-gift.png');
			$black = imagecolorallocate($im, 0, 0, 0);
			$joemaColor = imagecolorallocate($im, 196, 101, 0);
			$font = 'assets/fonts/Chapaza.ttf';
			if($amount <= 99){
				imagettftext($im, 100, 0, 610, 167, $joemaColor, $font, $amount);
			}
			else{
				imagettftext($im, 100, 0, 570, 167, $joemaColor, $font, $amount);
			}
			imagettftext($im, 20, 0, 260, 280, $joemaColor, $font, $fromName);
			imagettftext($im, 20, 0, 130, 360, $joemaColor, $font, $toName);
			imagettftext($im, 20, 0, 870, 460, $joemaColor, $font, $chequeNber);
			imagettftext($im, 20, 0, 1025, 544, $black, $font, $date);
		}
		else{
			echo 'Le fichier temporaire est introuvable';
		}
		return $im;
	}
	
	/*setAddGiftCertificate: true,
	setAddReference:addReference,
	setAddTotalAmount:addTotalAmount,
	setAddLimitAmount:addLimitAmount,
	setAddBuyDate:addBuyDate,
	setAddLimitDate:addLimitDate,
	setAddBuyerName:addBuyerName,
	setAddCustomerName:addCustomerName,
	setAddSendToMail:addSendToMail,
	setAddCustomerMail:addCustomerMail,
	setAddStatus
	
	if(isset($_POST['setAddGiftCertificate']) && isset($_POST['setAddReference']) && isset($_POST['setAddTotalAmount']) && isset($_POST['setAddLimitAmount']) && isset($_POST['setAddBuyDate'])
	&& isset($_POST['setAddLimitDate']) && isset($_POST['setAddBuyerName']) && isset($_POST['setAddCustomerName']) && isset($_POST['setAddSendToMail']) && isset($_POST['setAddCustomerMail']) && isset($_POST['setAddStatus'])){
		$getGiftCertificates = $db->query('SELECT * FROM `gift-certificates` WHERE `Reference`="'.$_POST['setAddReference'].'"');
		if($getGiftCertificates->num_rows == 0){
			$setGiftCertificate = $db->query('INSERT INTO `gift-certificates` (`Reference`,`TotalAmount`,`UsedAmount`,`BuyDate`,`LimitDate`,`IsActive`) VALUES
			("'.$_POST['setAddReference'].'","'.$_POST['setAddTotalAmount'].'","'.$_POST['setAddLimitAmount'].'","'.strtotime($_POST['setAddBuyDate']).'","'.strtotime($_POST['setAddLimitDate']).'","'.$_POST['setAddStatus'].'")');
			if($setGiftCertificate){
				echo 'success';
			}
			else{
				echo 'Erreur : La carte cadeau n\'a pas pu être éditée.INSERT INTO `gift-certificates` (`Reference`,`TotalAmount`,`UsedAmount`,`BuyDate`,`LimitDate`,`IsActive`) VALUES
			("'.$_POST['setAddReference'].'","'.$_POST['setAddTotalAmount'].'","'.$_POST['setAddLimitAmount'].'","'.strtotime($_POST['setAddBuyDate']).'","'.strtotime($_POST['setAddLimitDate']).'","'.$_POST['setAddStatus'].'")';
			}
		}
		else{
			echo 'Cette référence est déjà existante.';
		}
	}
	*/
	
	
	if(isset($_POST['setAddGiftCertificate']) && isset($_POST['setAddReference']) && isset($_POST['setAddTotalAmount']) && isset($_POST['setAddLimitAmount']) && isset($_POST['setAddBuyDate'])
	&& isset($_POST['setAddLimitDate']) && isset($_POST['setAddBuyerName']) && isset($_POST['setAddCustomerName']) && isset($_POST['setAddSendToMail']) && isset($_POST['setAddCustomerMail'])
	&& isset($_POST['setAddStatus'])){
		$getGiftCertificates = $db->query('SELECT * FROM `gift-certificates` WHERE `Reference`="'.$_POST['setAddReference'].'"');
		if($getGiftCertificates->num_rows == 0){
			$setGiftCertificate = $db->query('INSERT INTO `gift-certificates` (`Reference`,`TotalAmount`,`UsedAmount`,`BuyDate`,`LimitDate`,`IsActive`) VALUES
			("'.$_POST['setAddReference'].'","'.$_POST['setAddTotalAmount'].'","'.$_POST['setAddLimitAmount'].'","'.strtotime($_POST['setAddBuyDate']).'","'.strtotime($_POST['setAddLimitDate']).'","'.$_POST['setAddStatus'].'")');
			if($setGiftCertificate){
				$sendToMail = false;
				if($_POST['setAddSendToMail'] == 1){
					$sendToMail = true;
				}
				$mailTo 	= $_POST['setAddCustomerMail'];
				$date 		= date('d/m/Y', strtotime($_POST['setAddLimitDate']));
				$fromName 	= $_POST['setAddBuyerName'];
				$toName 	= $_POST['setAddCustomerName'];
				$amount 	= $_POST['setAddTotalAmount'];
				$chequeNber = $_POST['setAddReference'];
		
				header("Content-type: image/png");
				$chqCado = writeToImage($fromName, $toName, $amount, $chequeNber, $date);
				$repository = 'assets/checkCados/'. time().'-'.strtolower($chequeNber) .'.png';
				
				if(imagepng($chqCado, $repository)){
					if($sendToMail == true && $mailTo != ''){
						$mail = new PHPMailer(true);
						if($mail){
							date_default_timezone_set('Etc/UTC');
							$mail = new PHPMailer(true);
							$mail->setLanguage('fr', 'assets/PHPMailer/language/');

							$mail->isSMTP();
							$mail->CharSet 		= "utf-8";
							$mail->SMTPAuth		= true;
							$mail->SMTPSecure	= 'tls';
							$mail->Host       	= 'mail50.lwspanel.com';
							$mail->Username   	= 'no-reply@joema.fr';
							$mail->Password   	= 'aP9$v!rFmeTgTjX';
							$mail->Port 		= 587;
							$mail->SMTPOptions 	= array(
								'ssl' => array(
									'verify_peer' => false,
									'verify_peer_name' => false,
									'allow_self_signed' => true
								)
							);
							$mail->isHTML(true);// Set email format to HTML

							$mail->setFrom('no-reply@joema.fr', 'No-Reply JOeMA Boutique');
							$mail->addAddress($mailTo);

							$bodytext 			= "Vous avez reçu un chèque cadeaux à dépenser sur https://www.joema.fr/ .";
							$mail->Subject		= "JOeMA Boutique - Votre chèque cadeaux";
							$mail->Body			= $bodytext;
							
							if($repository != ''){
								$mail->AddAttachment($repository, 'JOeMA-cheque-cadeaux-'.time().'.png');
							}
							if($mail->Send()){
								echo 'mail-success';
							}
							else{
								echo 'mail-error';
							}
						}
					}
					else{
						echo 'nomail-success';
					}
				}
				else{
					echo 'nomail-error';
				}
			}
			else{
				echo 'Erreur : La carte cadeau n\'a pas pu être éditée.INSERT INTO `gift-certificates` (`Reference`,`TotalAmount`,`UsedAmount`,`BuyDate`,`LimitDate`,`IsActive`) VALUES
			("'.$_POST['setAddReference'].'","'.$_POST['setAddTotalAmount'].'","'.$_POST['setAddLimitAmount'].'","'.strtotime($_POST['setAddBuyDate']).'","'.strtotime($_POST['setAddLimitDate']).'","'.$_POST['setAddStatus'].'")';
			}
		}
		else{
			echo 'Cette référence est déjà existante.';
		}
	}
?>
