<?php session_start();

	define('TARGET', '../assets/img/products/');
	$tabExt = array('jpg','gif','png','jpeg');
	$extension = '';
	$nomImage = '';
	$fichier_date = date("ymdhis");
	 
	/*if(!empty($_FILES['setArtImage1']['name'])){
		$extension  = pathinfo($_FILES['setArtImage1']['name'], PATHINFO_EXTENSION);
		if(in_array(strtolower($extension),$tabExt)){
			$nomImage = 'Joema-boutique-maroquinerie-'.$fichier_date.'.'. $extension;
			if(compressedImage($_FILES['setArtImage1']['tmp_name'], TARGET.$nomImage, 60)){
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
	elseif(!empty($_FILES['setArtImage2']['name'])){
		$extension  = pathinfo($_FILES['setArtImage2']['name'], PATHINFO_EXTENSION);
		if(in_array(strtolower($extension),$tabExt)){
			$nomImage = 'Joema-boutique-maroquinerie-'.$fichier_date.'.'. $extension;
			if(compressedImage($_FILES['setArtImage2']['tmp_name'], TARGET.$nomImage, 60)){
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
	elseif(!empty($_FILES['setArtImage3']['name'])){
		$extension  = pathinfo($_FILES['setArtImage3']['name'], PATHINFO_EXTENSION);
		if(in_array(strtolower($extension),$tabExt)){
			$nomImage = 'Joema-boutique-maroquinerie-'.$fichier_date.'.'. $extension;
			if(compressedImage($_FILES['setArtImage3']['tmp_name'], TARGET.$nomImage, 60)){
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
	elseif(!empty($_FILES['setArtImage4']['name'])){
		$extension  = pathinfo($_FILES['setArtImage4']['name'], PATHINFO_EXTENSION);
		if(in_array(strtolower($extension),$tabExt)){
			$nomImage = 'Joema-boutique-maroquinerie-'.$fichier_date.'.'. $extension;
			if(compressedImage($_FILES['setArtImage4']['tmp_name'], TARGET.$nomImage, 60)){
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
	
	
    function compressedImage($source, $path, $quality) {

            $info = getimagesize($source);

            if ($info['mime'] == 'image/jpeg') 
                $image = imagecreatefromjpeg($source);

            elseif ($info['mime'] == 'image/gif') 
                $image = imagecreatefromgif($source);

            elseif ($info['mime'] == 'image/png') 
                $image = imagecreatefrompng($source);

            imagejpeg($image, $path, $quality);

    }*/
	
	if(!empty($_FILES['setArtImage1']['name'])){
		$extension  = pathinfo($_FILES['setArtImage1']['name'], PATHINFO_EXTENSION);
		if(in_array(strtolower($extension),$tabExt)){
			$nomImage = 'Joema-boutique-maroquinerie-'.$fichier_date.'.'. $extension;
			if(move_uploaded_file($_FILES['setArtImage1']['tmp_name'], TARGET.$nomImage)){
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
	elseif(!empty($_FILES['setArtImage2']['name'])){
		$extension  = pathinfo($_FILES['setArtImage2']['name'], PATHINFO_EXTENSION);
		if(in_array(strtolower($extension),$tabExt)){
			$nomImage = 'Joema-boutique-maroquinerie-'.$fichier_date.'.'. $extension;
			if(move_uploaded_file($_FILES['setArtImage2']['tmp_name'], TARGET.$nomImage)){
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
	elseif(!empty($_FILES['setArtImage3']['name'])){
		$extension  = pathinfo($_FILES['setArtImage3']['name'], PATHINFO_EXTENSION);
		if(in_array(strtolower($extension),$tabExt)){
			$nomImage = 'Joema-boutique-maroquinerie-'.$fichier_date.'.'. $extension;
			if(move_uploaded_file($_FILES['setArtImage3']['tmp_name'], TARGET.$nomImage)){
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
	elseif(!empty($_FILES['setArtImage4']['name'])){
		$extension  = pathinfo($_FILES['setArtImage4']['name'], PATHINFO_EXTENSION);
		if(in_array(strtolower($extension),$tabExt)){
			$nomImage = 'Joema-boutique-maroquinerie-'.$fichier_date.'.'. $extension;
			if(move_uploaded_file($_FILES['setArtImage4']['tmp_name'], TARGET.$nomImage)){
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