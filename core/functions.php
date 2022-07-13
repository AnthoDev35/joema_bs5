<?php require_once 'config.php';

class Auth{

}

class System {
	
	public $db;
	
	public function addDiscountCode($discountCode){
		$getDiscountCode = $this->db->query('SELECT * FROM `discount-codes` WHERE `Code`="'.$discountCode.'"');
		if($getDiscountCode->num_rows == 1){
			$_SESSION['joemaDiscountCode']['code'] = $discountCode;
			if(isset($_SESSION['joemaDiscountCode']['code']) && $_SESSION['joemaDiscountCode']['code'] == $discountCode){
				return true;
			}
			else
				return false;
		}
		else
			return false;
	}

	public function delDiscountCode(){
		unset($_SESSION['joemaDiscountCode']['code']);
		if(isset($_SESSION['joemaDiscountCode']['code'])){
			return false;
		}
		else{
			return true;
		}
	}

	public function addGiftCertificateCode($giftCertificateCode){
		$getGiftCertificateCode = $this->db->query('SELECT * FROM `gift-certificates` WHERE `Reference`="'.$giftCertificateCode.'"');
		if($getGiftCertificateCode->num_rows == 1){
			$_SESSION['joemaGiftCertificate']['code'] = $giftCertificateCode;
			if(isset($_SESSION['joemaGiftCertificate']['code']) && $_SESSION['joemaGiftCertificate']['code'] == $giftCertificateCode){
				return true;
			}
			else
				return false;
		}
		else
			return false;
	}

	public function addItemCart($productID,$productImage,$productTitle,$productQuantity,$productColor,$productSize,$productPrice){
		if(isset($_SESSION['joemaCart']['productID'])){
			//Si le produit existe déjà on ajoute seulement la quantité
			$getPositionProduit = array_search($productID, $_SESSION['joemaCart']['productID']);

			if ($getPositionProduit == true){
				$_SESSION['joemaCart']['productQuantity'][$positionProduit] += $productQuantity ;
				return 'true';
			}
			else{
				//Sinon on ajoute le produit
				array_push($_SESSION['joemaCart']['productID'],$productID);
				array_push($_SESSION['joemaCart']['productImage'],$productImage);
				array_push($_SESSION['joemaCart']['productTitle'],$productTitle);
				array_push($_SESSION['joemaCart']['productQuantity'],$productQuantity);
				array_push($_SESSION['joemaCart']['productColor'],$productColor);
				array_push($_SESSION['joemaCart']['productSize'],$productSize);
				array_push($_SESSION['joemaCart']['productPrice'],$productPrice);
				return 'true';
			}
		}
		else
			return 'false';
	}

	function delProductCart($productID){
		$tmp=array();
		$tmp['productID'] = array();
		$tmp['productImage'] = array();
		$tmp['productTitle'] = array();
		$tmp['productQuantity'] = array();
		$tmp['productColor'] = array();
		$tmp['productSize'] = array();
		$tmp['productPrice'] = array();

		for($i = 0; $i < count($_SESSION['joemaCart']['productID']); $i++){
			if ($_SESSION['joemaCart']['productID'][$i] != $productID){
				array_push($tmp['productID'],$_SESSION['joemaCart']['productID'][$i]);
				array_push($tmp['productImage'],$_SESSION['joemaCart']['productImage'][$i]);
				array_push($tmp['productTitle'],$_SESSION['joemaCart']['productTitle'][$i]);
				array_push($tmp['productQuantity'],$_SESSION['joemaCart']['productQuantity'][$i]);
				array_push($tmp['productColor'],$_SESSION['joemaCart']['productColor'][$i]);
				array_push($tmp['productSize'],$_SESSION['joemaCart']['productSize'][$i]);
				array_push($tmp['productPrice'],$_SESSION['joemaCart']['productPrice'][$i]);
			}
		}
		//On remplace le panier en session par notre panier temporaire à jour
		$_SESSION['joemaCart'] =  $tmp;
		//On efface notre panier temporaire
		unset($tmp);
		return true;
	}
	
	function updCartQuantity($productID,$productQuantity){
		//Si la quantité est positive on modifie sinon on supprime l'article
		if($productQuantity > 0){
			for($i = 0; $i < count($_SESSION['joemaCart']['productID']); $i++){
				if($_SESSION['joemaCart']['productID'][$i] == $productID){
					$_SESSION['joemaCart']['productQuantity'][$i] = $productQuantity ;
				}
			}
		}
		else{
			$this->delProductCart($productID);
		}
	}
	
	public function totalCart(){
		$total=0;
		for($i = 0; $i < count($_SESSION['joemaCart']['productID']); $i++){
			$total += $_SESSION['joemaCart']['productQuantity'][$i] * $_SESSION['joemaCart']['productPrice'][$i];
		}
		return number_format($total, 2);
	}
	
	public function itemTotal($qty,$price){
		$total=0;
		if(count($_SESSION['joemaCart']['productID']) >= 1){
			$total = $qty * $price;
		}
		return $total;
	}
	
	public function addGiftCertificateCart($amount){
		if(isset($_SESSION['joemaCart']['productID'])){
			$getProduct = array_search('999999999999', $_SESSION['joemaCart']['productID']);
			if ($getProduct !== false){
				return 'false';
			}
			else{
				//Sinon on ajoute le produit
				array_push($_SESSION['joemaCart']['productID'], '999999999999');
				array_push($_SESSION['joemaCart']['productImage'], 'assets/img/Joema-boutique-cheques-cadeaux-specimen.png');
				array_push($_SESSION['joemaCart']['productTitle'], 'Chèque cadeaux JOeMA');
				array_push($_SESSION['joemaCart']['productQuantity'], '1');
				array_push($_SESSION['joemaCart']['productColor'], '0');
				array_push($_SESSION['joemaCart']['productSize'], '0');
				array_push($_SESSION['joemaCart']['productPrice'], $amount);
				return 'true';
			}
		}
		else
			return 'false';
	}

	/*Wishlist*/
	
	public function addAccountWishlist($productID){
		$getWishlist = $this->db->query('SELECT * FROM `customers_wishlist` WHERE `CustomerID`="'.$_SESSION['web_joema']['session_user_id'].'" AND `ProductID`="'.$productID.'"');
		if($getWishlist->num_rows == 0){
			$addWishlist = $this->db->query('INSERT INTO `customers_wishlist` (`CustomerID`,`ProductID`,`DateAdded`) VALUES ("'.$_SESSION['web_joema']['session_user_id'].'","'.$productID.'","'.time().'")');
			if($addWishlist){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return true;
		}
	}
	
	public function delAccountWishlist($productID){
		$getWishlist = $this->db->query('SELECT * FROM `customers_wishlist` WHERE `CustomerID`="'.$_SESSION['web_joema']['session_user_id'].'" AND `ProductID`="'.$productID.'"');
		if($getWishlist->num_rows == 1){
			$detWishlist = $this->db->query('DELETE FROM `customers_wishlist` WHERE `CustomerID`="'.$_SESSION['web_joema']['session_user_id'].'" AND `ProductID`="'.$productID.'"');
			if($detWishlist){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	public function setSyncAccountCart(){
		$nbArticles=count($_SESSION['joemaCart']['productID']);
		if($nbArticles >= 1){
			for($i=0;$i<$nbArticles;$i++){
				$getCart = $this->db->query('SELECT * FROM `customers_cart` WHERE `CustomerID`="'.$_SESSION['web_joema']['session_user_id'].'" AND `ProductID`="'.$_SESSION['joemaCart']['productID'][$i].'"');
				if($getCart->num_rows == 0){
					$setCart = $this->db->query('INSERT INTO `customers_cart` (`CustomerID`,`ProductID`,`DateAdded`) VALUES ("'.$_SESSION['web_joema']['session_user_id'].'","'.$_SESSION['joemaCart']['productID'][$i].'","'.time().'")');
				}
				if($i == $nbArticles){
					echo 'success';
				}
			}
		}
	}
}

?>

