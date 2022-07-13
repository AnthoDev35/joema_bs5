<?php session_start();
	include_once("../core/functions.php");
	$system = new System;
	$system->db = $db;
	$searchResult = '';
	
	if(isset($_POST['setSearch']) && isset($_POST['searchText'])){
		$getSearchs = $db->query('SELECT * FROM `articles` WHERE `Name` LIKE "'.$_POST['searchText'].'%" OR  `Reference` LIKE "'.$_POST['searchText'].'%" ORDER BY `NAME` ASC LIMIT 10');
		if($getSearchs->num_rows >= 1){
			while($getSearch = $getSearchs->fetch_object()){
				$searchResult .= '<li><a href="product-details.php?categories=true&categoryID='.$getSearch->CategorieID.'&pId='.$getSearch->ID.'"><img src="'.$getSearch->Image1.'" class="img-fluid"> '.ucfirst($getSearch->Name).'</a></li>.';
			}
			echo $searchResult;
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_POST['checkColorsAndSizes'],$_POST['artID'],$_POST['colorID'],$_POST['sizeID'])){
		$ColorsAndSizesDatas = '';
		$stockManagement = 0;
		$getStockManagements = $db->query('SELECT * FROM `articles` WHERE `ID`="'.$_POST['artID'].'"');
		if($getStockManagements->num_rows == 1){
			$getStockManagement = $getStockManagements->fetch_object();
			$stockManagement = $getStockManagement->StockManagement;
		}
		if($stockManagement == 0){
			$getStocks = $db->query('SELECT * FROM `articles` WHERE `ID`="'.$_POST['artID'].'"');
			if($getStocks->num_rows == 1){
				$getStock = $getStocks->fetch_object();
				$ColorsAndSizesDatas .= $getStock->Stock;
			}
			else{
				$ColorsAndSizesDatas = 'Indisponible';
			}
		}
		else if($stockManagement == 1){
			$getAvailableColors = $db->query('SELECT * FROM `article-option-colors` WHERE `ID`="'.$_POST['colorID'].'" AND `ArticleID`="'.$_POST['artID'].'"');
			if($getAvailableColors->num_rows == 1){
				$getAvailableColor = $getAvailableColors->fetch_object();
				$ColorsAndSizesDatas .= $getAvailableColor->Stock;
			}
			else{
				$ColorsAndSizesDatas = 'Indisponible';
			}
		}
		else if($stockManagement == 2){
			$getAvailableSizes = $db->query('SELECT * FROM `article-option-sizes` WHERE `ID`="'.$_POST['sizeID'].'" AND `ArticleID`="'.$_POST['artID'].'"');
			if($getAvailableSizes->num_rows == 1){
				$getAvailableSize = $getAvailableSizes->fetch_object();
				$ColorsAndSizesDatas .= $getAvailableSize->Stock;
			}
			else{
				$ColorsAndSizesDatas = 'Indisponible';
			}
		}
		else if($stockManagement == 3){
			if($_POST['colorID'] !== '0' && $_POST['sizeID'] !== '0'){
				$getAvailableColors = $db->query('SELECT * FROM `article-option-colors-and-sizes` WHERE `SizeName`="'.$_POST['sizeID'].'" AND `Color`="'.$_POST['colorID'].'" AND `ArticleID`="'.$_POST['artID'].'"');
				if($getAvailableColors->num_rows == 1){
					$getAvailableColor = $getAvailableColors->fetch_object();
					$ColorsAndSizesDatas .= $getAvailableColor->Stock;
				}
				else{
					$ColorsAndSizesDatas = 'Indisponible';
				}
			}
			if($_POST['colorID'] === '0' && $_POST['sizeID'] !== '0'){
				$ColorsAndSizesDatas = 'Choisissez une couleur';
			}
			else if($_POST['colorID'] !== '0' && $_POST['sizeID'] === '0'){
				$ColorsAndSizesDatas = 'Choisissez une taille';
			}
			
		}
		echo json_encode(array('datas' => $ColorsAndSizesDatas));
	}
	
	
?>