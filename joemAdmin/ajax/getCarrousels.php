<?php  session_start();
	include_once("../../core/functions.php");
	$system->db = $db;
	$response = '';
	if(isset($_POST['getModCarrousel']) && isset($_POST['carrouselID']) && isset($_POST['carCategorie']) && isset($_POST['carTitle']) && isset($_POST['carPercentDiscount']) && isset($_POST['carDescription']) && isset($_POST['carImageName']) && isset($_POST['carIsActive'])){
		$setDatas = $db->query('UPDATE `carrousels` SET `CategorieID`="'.$_POST['carCategorie'].'",`Title`="'.$_POST['carTitle'].'",`DiscountPct`="'.$_POST['carPercentDiscount'].'",`Description`="'.$_POST['carDescription'].'",`Image`="'.$_POST['carImageName'].'",`IsActive`="'.$_POST['carIsActive'].'" WHERE `ID`="'.$_POST['carrouselID'].'";');
		if($setDatas){
			$response .= 'success';
		}
		else{
			$response .= 'Une erreur interne c\'est produite, contactez l\'administrateur si le problème persiste !';
		}
	}
	if(isset($_POST['getAddCarrousel']) && isset($_POST['carCategorie']) && isset($_POST['carTitle']) && isset($_POST['carPercentDiscount']) && isset($_POST['carDescription']) && isset($_POST['carImageName']) && isset($_POST['carIsActive'])){
		$setDatas = $db->query('INSERT INTO `carrousels` (`CategorieID`, `Title`, `DiscountPct`, `Description`, `Image`, `IsActive`) VALUES ("'.$_POST['carCategorie'].'", "'.$_POST['carTitle'].'", "'.$_POST['carPercentDiscount'].'", "'.$_POST['carDescription'].'", "'.$_POST['carImageName'].'", "'.$_POST['carIsActive'].'");');
		if($setDatas){
			$response .= 'success';
		}
		else{
			$response .= 'Une erreur interne c\'est produite, contactez l\'administrateur si le problème persiste !';
		}
	}

	if(isset($_POST['setCarrouselActive']) && isset($_POST['carrouselID']) && isset($_POST['carrousselIsActive'])){
		$setDatas = $db->query('UPDATE `carrousels` SET `IsActive`="'.$_POST['carrousselIsActive'].'" WHERE `ID`="'.$_POST['carrouselID'].'";');
		if($setDatas){
			$response .= 'success';
		}
		else{
			$response .= 'Une erreur interne c\'est produite, contactez l\'administrateur si le problème persiste !';
		}
	}
	if(isset($_POST['setCarrouselDelete']) && isset($_POST['carrouselID'])){
		$setDatas = $db->query('DELETE FROM `carrousels` WHERE `ID`="'.$_POST['carrouselID'].'";');
		if($setDatas){
			$response .= 'success';
		}
		else{
			$response .= 'Une erreur interne c\'est produite, contactez l\'administrateur si le problème persiste !';
		}
	}
	echo $response;
?>
