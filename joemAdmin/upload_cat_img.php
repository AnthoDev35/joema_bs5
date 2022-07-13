<?php session_start();

	define('TARGET', '../assets/img/category/');
	$tabExt = array('jpg','gif','png','jpeg');
	$extension = '';
	$nomImage = '';
	$fichier_date = date("ymdhis");
	 
	if(!empty($_FILES['setCatImage']['name'])){
		$extension  = pathinfo($_FILES['setCatImage']['name'], PATHINFO_EXTENSION);
		if(in_array(strtolower($extension),$tabExt)){
			$nomImage = 'Joema-boutique-maroquinerie-categorie-'.$fichier_date.'.'. $extension;
			if(move_uploaded_file($_FILES['setCatImage']['tmp_name'], TARGET.$nomImage)){
				echo htmlspecialchars(basename($nomImage));;
			}
			else{
				echo 0;
			}
		}
		else{
			echo 1;
		}
	}
	else{
		echo 2;
	}
?>