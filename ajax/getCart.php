<?php session_start();
include_once("../core/functions.php");
$system = new System;
$system->db = $db;

if(isset($_POST['initCart'])){
	if(!isset($_SESSION['joemaCart'])){
		$_SESSION['joemaCart'] = array();
		$_SESSION['joemaCart']['productID'] = array();
		$_SESSION['joemaCart']['productImage'] = array();
		$_SESSION['joemaCart']['productTitle'] = array();
		$_SESSION['joemaCart']['productColor'] = array();
		$_SESSION['joemaCart']['productSize'] = array();
		$_SESSION['joemaCart']['productQuantity'] = array();
		$_SESSION['joemaCart']['productPrice'] = array();
		$_SESSION['joemaCart']['locked'] = false;
	}
	echo json_encode(array("success" => 1));
}

if(isset($_POST['updCartCounter'])){
	echo json_encode(array("data" => count($_SESSION['joemaCart']['productID'])));
}
if(isset($_POST['updHeaderCart'])){
	$headerCart = '';
	$nbItems = count($_SESSION['joemaCart']['productID']);
	if($nbItems >= 1){
		for($i=0;$i<$nbItems;$i++){
			$getArticles = $db->query('SELECT * FROM `articles` WHERE ID="'.$_SESSION['joemaCart']['productID'][$i].'" LIMIT 1');
			if($getArticles->num_rows == 1){
				$headerCart .= '<div class="nk-widget-post">
					<a href="product-details.php?categories=true&pId='.$_SESSION['joemaCart']['productID'][$i].'" class="nk-post-image">
						<img src="assets/images/'.htmlspecialchars($_SESSION['joemaCart']['productImage'][$i]).'" style="border:3px solid #fff;border-radius:20%">
					</a>
					<h3 class="nk-post-title">
						<a href="#" onclick="delProductCart('.$_SESSION['joemaCart']['productID'][$i].')" class="nk-cart-remove-item"><span class="fa fa-remove"></span></a>
						<a href="product-details.php?categories=true&pId='.$_SESSION['joemaCart']['productID'][$i].'">'.htmlspecialchars($_SESSION['joemaCart']['productTitle'][$i]).'</a>
					</h3>
					<div class="nk-product-price">'.number_format($_SESSION['joemaCart']['productPrice'][$i], 2).' <img src="assets/images/pts.png" width="30px"/></div>
				</div>';
			}
		}
		$headerCart .= '<div class="nk-gap-2"></div>
			<div class="text-center">
				<div class="subtotal-cart">Total: <img src="assets/images/jtn.png" width="30px"/>'.$system->totalCart().'</div></br>
				<button class="btn btn-theme" onclick="checkout();">Valider mon panier</button>
			</div>
		</div>';
	}
	else{
		$headerCart .= '<div>Votre panier est vide !</div>';
	}
	echo json_encode(array("data" => $headerCart));
}
if(isset($_POST['setDiscountCode']) && isset($_POST['discountcode'])){
	$return = $system->addDiscountCode($_POST['discountcode']);
	if($return == true){
		echo json_encode(array("success" => 1));
	}
	else{
		echo json_encode(array("error" => "Une erreur c'est produite lors de l'ajout du code de réduction!"));
	}
}

if(isset($_POST['delDiscountCode'])){
	$return = $system->delDiscountCode();
	if($return == true){
		echo json_encode(array("success" => 1));
	}
	else{
		echo json_encode(array("error" => "Une erreur c'est produite lors de l'ajout du code de réduction!"));
	}
}

if(isset($_POST['setGiftCertificateCode']) && isset($_POST['giftCertificateCode'])){
	$return = $system->addGiftCertificateCode($_POST['giftCertificateCode']);
	if($return == true){
		echo json_encode(array("success" => 1));
	}
	else{
		echo json_encode(array("error" => "Une erreur c'est produite lors de l'ajout du code de réduction!"));
	}
}
if(isset($_POST['getPageCart'])){
	$pageCart = '';
	$nbItems = count($_SESSION['joemaCart']['productID']);
	if($nbItems >= 1){
		$pageCart .= '<div class="cart_page table-responsive">
			<table>
				<thead>
					<tr>
						<th class="product_remove">Supprimer</th>
						<th class="product_name">Article</th>
						<th class="product_options">Options</th>
						<th class="product-price">Prix u.</th>
						<th class="product_quantity">Quantité</th>
						<th class="product_total">Prix total</th>
					</tr>
				</thead>
				<tbody>';
					for($i=0;$i<$nbItems;$i++){
						$getArticles = $db->query('SELECT * FROM `articles` WHERE ID="'.$_SESSION['joemaCart']['productID'][$i].'" LIMIT 1');
						if($getArticles->num_rows == 1){
							$getArticle = $getArticles->fetch_object();
							$stockManagement = $getArticle->StockManagement;
							if($stockManagement === 0){
								$stockArticle = $getArticle->Stock;
							}
							else{
								$stockArticle = 0;
							}
							$pageCart .= '<input type="hidden" id="buyMaxQty_'.$_SESSION['joemaCart']['productID'][$i].'" value="'.$stockArticle.'"/>';
							$pageCart .= '<tr>
								<td class="product_remove"><a href="#" onclick="delProductCart('.rawurlencode($_SESSION['joemaCart']['productID'][$i]).')"><i class="fa fa-trash-o"></i></a></td>
								<td class="product_name"><a href="product-details.php?categories=true&pId='.$_SESSION['joemaCart']['productID'][$i].'">'.htmlspecialchars($_SESSION['joemaCart']['productTitle'][$i]).'</a></td>
								<td class="product-options">';
									if($stockManagement === '0'){
										$pageCart .= 'Aucune';
									}
									else if($stockManagement === '1'){
										$getStockColorManagers = $db->query('SELECT * FROM `article-option-colors` WHERE `ID`="'.$_SESSION['joemaCart']['productColor'][$i].'"');
										if($getStockColorManagers->num_rows >= 1){
											$getStockColorManager = $getStockColorManagers->fetch_object();
											$pageCart .= '<div class="cc-item">
												<label ><span style="background-color: #'.$getStockColorManager->Color.'" title="Taille : '.$getStockColorManager->Name.'"></span></label>
											</div>';
										}
									}
									else if($stockManagement === '2'){
										$getStockSizeManagers = $db->query('SELECT * FROM `article-option-sizes` WHERE `ID`="'.$_SESSION['joemaCart']['productSize'][$i].'"');
										if($getStockSizeManagers->num_rows >= 1){
											$getStockSizeManager = $getStockSizeManagers->fetch_object();
											$pageCart .= '<div class="sc-item">
												<label><span title="Taille : '.$getStockSizeManager->ShortName.'">'.$getStockSizeManager->ShortName.'</span></label>
											</div>';
										}
									}
									else if($stockManagement === '3'){
										$getStockColorAndSizeManagers = $db->query('SELECT * FROM `article-option-colors-and-sizes` WHERE `ArticleID`="'.$_SESSION['joemaCart']['productID'][$i].'" AND `SizeShortName`="'.$_SESSION['joemaCart']['productSize'][$i].'" AND `Color`="'.$_SESSION['joemaCart']['productColor'][$i].'"');
										if($getStockColorAndSizeManagers->num_rows >= 1){
											$getStockColorAndSizeManager = $getStockColorAndSizeManagers->fetch_object();
											$pageCart .= '<div class="s-management"><div class="cc-item">
												<label ><span style="background-color: #'.$_SESSION['joemaCart']['productColor'][$i].'" title="Couleur : '.$getStockColorAndSizeManager->ColorName.'"></span></label>
											</div>
											<div class="sc-item">
												<label><span title="Taille : '.$getStockColorAndSizeManager->SizeName.'">'.$_SESSION['joemaCart']['productSize'][$i].'</span></label>
											</div></div>';
										}
									}
								$pageCart .= '</td>
								<td class="product-price">'.number_format($_SESSION['joemaCart']['productPrice'][$i], 2).'€</td>
								<td class="product_quantity"><input min="0" max="100" value="'.$_SESSION['joemaCart']['productQuantity'][$i].'" type="number" id="buyArtQty_'.rawurlencode($_SESSION['joemaCart']['productID'][$i]).'"> <a href="" class="artQty" onclick="updateCartQty('.rawurlencode($_SESSION['joemaCart']['productID'][$i]).')"><i class="fa fa-refresh"></i></a></td>
								<td class="product_total">'.number_format($_SESSION['joemaCart']['productPrice'][$i]*$_SESSION['joemaCart']['productQuantity'][$i], 2).'€</td>
							</tr>';
						}
						elseif($_SESSION['joemaCart']['productID'][$i] == '999999999999'){
							$pageCart .= '<input type="hidden" id="artID" value="'.$_SESSION['joemaCart']['productID'][$i].'"/><input type="hidden" id="buyMaxQty" value="1"/>';
							$pageCart .= '<tr>
								<td class="product_remove"><a href="#" onclick="delProductCart('.rawurlencode($_SESSION['joemaCart']['productID'][$i]).')"><i class="fa fa-trash-o"></i></a></td>
								<td class="product_name"><a href="product-details.php?categories=true&pId='.$_SESSION['joemaCart']['productID'][$i].'">'.htmlspecialchars($_SESSION['joemaCart']['productTitle'][$i]).'</a></td>
								<td class="product-options">Aucune</td>
								<td class="product-price">'.number_format($_SESSION['joemaCart']['productPrice'][$i], 2).'€</td>
								<td class="product_quantity"><input min="1" max="1" value="'.$_SESSION['joemaCart']['productQuantity'][$i].'" type="number" readonly></td>
								<td class="product_total">'.number_format($_SESSION['joemaCart']['productPrice'][$i]*$_SESSION['joemaCart']['productQuantity'][$i], 2).'€</td>
							</tr>';
						}
					}
				$pageCart .= '</tbody>
			</table>
		</div>';
	}
	else{
		$pageCart .= '<div class="text-center mt-3 mb-3">Votre panier est vide !</div>';
	}
	echo json_encode(array("data" => $pageCart));
}

if(isset($_POST['getPageCartPrice'])){
	$pageCartPrice = '';
	$totals=0;
	for($i = 0; $i < count($_SESSION['joemaCart']['productID']); $i++){
		$totals += $_SESSION['joemaCart']['productQuantity'][$i] * $_SESSION['joemaCart']['productPrice'][$i];
	}
	
	if($totals != 0){
		$pageCartPrice .= '<div class="cart_resume right">
			<div class="total_cart">';
				if(isset($_SESSION['joemaDiscountCode']['code'])){
					$getDiscountCodes = $db->query('SELECT * FROM `discount-codes` WHERE `Code`="'.$_SESSION['joemaDiscountCode']['code'].'" AND `IsActive`="1"');
					if($getDiscountCodes->num_rows == 1){
						$getDiscountCode = $getDiscountCodes->fetch_object();
						if($totals >= $getDiscountCode->MinAmount){
							if(!empty($getDiscountCode->Amount)){
								$totals = ($totals - $getDiscountCode->Amount);
								$pageCartPrice .= '<div class="promocode">Code promo: "<small style="color:#A56400">'.$getDiscountCode->Title.'</small>"<span>-'.number_format($getDiscountCode->Amount, 2).'€ <a href="#" onclick="delDiscountCode();" style="color:#A56400"><i class="fa fa-close"></i></a></span> </div>';
							}
							else if($getDiscountCode->FreeShipping == 1){
								$pageCartPrice .= '<div class="promocode">Code promo: <span style="color:#A56400">Frais de port offert <a href="#" onclick="delDiscountCode();" style="color:#A56400"><i class="fa fa-close"></i></a></span></div>';
							}
						}
						else{
							$pageCartPrice .= '<div class="promocode"><div style="color:#ff0000;font-size:10px;font-weight:bold">Vous ne remplissez pas les conditions pour utiliser ce code de réduction! <span><a href="#" style="color:#A56400" onclick="delDiscountCode();"><i class="fa fa-close"></i></a></span></div></div>';
						}
					}
					else{
						$pageCartPrice .= '<div class="promocode"><div style="color:#ff0000;font-size:12px;font-weight:bold">Le code de réduction saisi est invalide! <span><a href="#" onclick="delDiscountCode();" style="color:#A56400"><i class="fa fa-close"></i></a></span></div></div>';
					}
				}
				if($totals != 0){
					if(isset($_SESSION['joemaGiftCertificate']['code'])){
						$getGiftCertificates = $db->query('SELECT * FROM `gift-certificates` WHERE `Reference`="'.$_SESSION['joemaGiftCertificate']['code'].'"');
						if($getGiftCertificates->num_rows == 1){
							$getGiftCertificate = $getGiftCertificates->fetch_object();
							if($getGiftCertificate->TotalAmount >= $getGiftCertificate->UsedAmount){
								$amountGiftCertificate = ($getGiftCertificate->TotalAmount - $getGiftCertificate->UsedAmount);
								if($totals > $amountGiftCertificate){
									$totals = ($totals - $amountGiftCertificate);
									$calcAmountLast = $amountGiftCertificate - $totals;
									$calcAmountDiscount = $amountGiftCertificate - $calcAmountLast;
								}
								else{
									$calcAmountLast = $amountGiftCertificate - $totals;
									$calcAmountDiscount = $amountGiftCertificate - $calcAmountLast;
									$totals = '0';
								}
								$pageCartPrice .= '<div class="promocode">Chèque cadeau JOeMA "<small style="color:#A56400;font-size:12px">'.$getGiftCertificate->Reference.'</small>" <span>-'.number_format($calcAmountDiscount, 2).'€</span><div style="font-size:10px">Montant restant : <span>'.number_format($calcAmountLast, 2).'€</span></div></div>';
							}
						}
					}
				}
				$pageCartPrice .= '<div class="cart_subtotal"><p>Sous-total</p><p class="cart_amount">'.number_format($totals, 2).'€</p></div>
			</ul>
			<div class="checkout_btn">
				<a href="checkout.php">Commander</a>
			</div>
		</div>
		</div>';
	}
	else{
		$pageCartPrice .= '<div class="proceed-checkout">
			<ul>
				<li class="subtotal">Sous-Total <span>0.00€</span></li>
			</ul>
			<a href="checkout.php" class="proceed-btn">Commander</a>
		</div>';
	}
	echo json_encode(array("data" => $pageCartPrice));
}

if(isset($_POST['addItem']) && isset($_POST['itemID']) && isset($_POST['itemQty']) && isset($_POST['itemColor']) && isset($_POST['itemSize'])){
	$items = $db->query('SELECT * FROM `articles` WHERE `ID`="'.$_POST['itemID'].'" LIMIT 1');
	if($items->num_rows == 1){
		$item = $items->fetch_object();
		if($item->StockManagement == 0){
			$return = $system->addItemCart($item->ID,$item->Image1,$item->Name,$_POST['itemQty'],0,0,$item->NormalPrice);
			if($return == true){
				echo json_encode(array("success" => 1));
			}
			else{
				echo json_encode(array("error" => "Une erreur c'est produite lors de l'ajout de l'article dans le panier!"));
			}
		}
		else if($item->StockManagement == 1){
			$return = $system->addItemCart($item->ID,$item->Image1,$item->Name,$_POST['itemQty'],$_POST['itemColor'],0,$item->NormalPrice);
			if($return == true){
				echo json_encode(array("success" => 1));
			}
			else{
				echo json_encode(array("error" => "Une erreur c'est produite lors de l'ajout de l'article dans le panier!"));
			}
		}
		else if($item->StockManagement == 2){
			$return = $system->addItemCart($item->ID,$item->Image1,$item->Name,$_POST['itemQty'],0,$_POST['itemSize'],$item->NormalPrice);
			if($return == true){
				echo json_encode(array("success" => 1));
			}
			else{
				echo json_encode(array("error" => "Une erreur c'est produite lors de l'ajout de l'article dans le panier!"));
			}
		}
		else if($item->StockManagement == 3){
			$return = $system->addItemCart($item->ID,$item->Image1,$item->Name,$_POST['itemQty'],$_POST['itemColor'],$_POST['itemSize'],$item->NormalPrice);
			if($return == true){
				echo json_encode(array("success" => 1));
			}
			else{
				echo json_encode(array("error" => "Une erreur c'est produite lors de l'ajout de l'article dans le panier!"));
			}
		}
		else{
			echo json_encode(array("error" => "Vous devez séléctionner une taille/couleur avant d'ajouter l'article dans le panier!"));
		}
	}
	else{
		echo json_encode(array("error" => "L'article sléctionné n'existe pas!"));
	}
}

if(isset($_POST['updCartQty']) && isset($_POST['itemID']) && isset($_POST['itemQty'])){
	if($_POST['itemQty'] != 0){
		for($i = 0; $i < count($_SESSION['joemaCart']['productID']); $i++){
			if($_SESSION['joemaCart']['productID'][$i] == $_POST['itemID']){
				$_SESSION['joemaCart']['productQuantity'][$i] = $_POST['itemQty'];
				echo json_encode(array("success" => 1));
			}
		}
	}
	else{
		$return = $system->delProductCart($productID);
		if($return == true){
			echo json_encode(array("success" => 1));
		}
		else{
			echo json_encode(array("error" => "Une erreur c\'est produite lors de la suppression de l\'article!"));
		}
	}
}
if(isset($_POST['delItem']) && isset($_POST['itemID'])){
	$return = $system->delProductCart($_POST['itemID']);
	if($return == true){
		echo json_encode(array("success" => 1));
	}
	else{
		echo json_encode(array("error" => "Une erreur c\'est produite lors de la suppression de l\'article!"));
	}
}

if(isset($_POST['getAllCartItems'])){
	$allCartItems = '';
	$nbArticles=count($_SESSION['joemaCart']['productID']);
	if($nbArticles == 0){
		$allCartItems .= '<div class="cart_empty"><center>Votre panier est vide ! </center></div>';
	}
	else{
		$allCartItems .= '<div class="select-items"><table><tbody>';
		for($i=0;$i<$nbArticles;$i++){
			if($_SESSION['joemaCart']['productID'][$i] == '999999999999'){
				$allCartItems .= '<div class="cart_item">
				   <div class="cart_img">
					   <a href="joema-cheque-cadeaux.php"><img src="'.$_SESSION['joemaCart']['productImage'][$i].'" alt=""></a>
				   </div>
					<div class="cart_info">
						<a href="joema-cheque-cadeaux.php">'.$_SESSION['joemaCart']['productTitle'][$i].'</a>
						<span class="quantity">Quantité: '.$_SESSION['joemaCart']['productQuantity'][$i].'</span>
						<span class="price_cart">'.number_format($_SESSION['joemaCart']['productPrice'][$i], 2).' €</span>
					</div>
					<div class="cart_remove">
						<a href="#" onclick="delProductCart('.$_SESSION['joemaCart']['productID'][$i].')"><i class="fa fa-close"></i></a>
					</div>
				</div>';
			}
			else{
				$getArticles = $db->query('SELECT * FROM `articles` WHERE ID="'.$_SESSION['joemaCart']['productID'][$i].'" LIMIT 1');
				if($getArticles->num_rows == 1){
					$getArticle = $getArticles->fetch_object();
					$allCartItems .= '<div class="cart_item">
						<div class="cart_img">
							<a href="product-details.php?categories=true&pId='.$_SESSION['joemaCart']['productID'][$i].'"><img src="'.$getArticle->Image1.'" alt=""></a>
						</div>
						<div class="cart_info">
							<a href="product-details.php?categories=true&pId='.$_SESSION['joemaCart']['productID'][$i].'">'.$getArticle->Name.'</a>
							<span class="quantity">Quantité: '.$_SESSION['joemaCart']['productQuantity'][$i].'</span>
							<span class="price_cart">'.number_format($_SESSION['joemaCart']['productPrice'][$i], 2).' €</span>
						</div>
						<div class="cart_remove">
							<a href="#" onclick="delProductCart('.$_SESSION['joemaCart']['productID'][$i].')"><i class="fa fa-close"></i></a>
						</div>
					</div>';
				}
			}
		}
		$allCartItems .= '<div class="cart_total">
			<span>Sous-total:</span>
			<span class="header-cart-price">'.$system->totalCart().' €</span>
		</div>';
	}
	echo json_encode(array("data" => $allCartItems));
}

if(isset($_POST['getCountCartItems'])){
	$countCartItems = '0';
	$nbArticles = count($_SESSION['joemaCart']['productID']);
	if($nbArticles >= 1){
		for($i=0;$i<$nbArticles;$i++){
			$getArticles = $db->query('SELECT * FROM `articles` WHERE ID="'.$_SESSION['joemaCart']['productID'][$i].'" LIMIT 1');
			if($getArticles->num_rows == 1){
				$countCartItems += 1;
			}
			else if($_SESSION['joemaCart']['productID'][$i] == '999999999999'){
				$countCartItems += 1;
			}
		}
	}
	echo json_encode(array('data' => $countCartItems));
}

if(isset($_POST['getHeaderCartPrice'])){
	echo json_encode(array("data" => $system->totalCart().'€'));
}

if(isset($_POST['addGiftCertificate']) && isset($_POST['amount'])){
	$return = $system->addGiftCertificateCart($_POST['amount']);
	if($return !== 'false'){
		echo json_encode(array("success" => 1));
	}
	else{
		echo json_encode(array("error" => "Une erreur c\'est produite lors de l\'ajout du chèque cadeau au panier!"));
	}
}

if(isset($_POST['getAddToCartModal']) && isset($_POST['articleID'])){
	$getArticles = $db->query('SELECT * FROM `articles` WHERE ID="'.$_POST['articleID'].'" LIMIT 1');
	if($getArticles->num_rows == 1){
		$getArticle = $getArticles->fetch_object();
		echo json_encode(array("datas" => '<div class="modal-header bg-modal-custom"><h5 class="modal-title"><i class="fa fa-shopping-cart"></i> Article ajouté au panier</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><div class="container"><div class="col-md-12">L\'article "'.ucfirst($getArticle->Name).'" à été ajouté au panier!</div></div></div><div class="modal-footer"><a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Continuer mes achats</a><a href="cart.php" class="primary-btn">Voir mon panier</a></div>'));
	}
	else if($_POST['articleID'] == '999999999999'){
		echo json_encode(array("datas" => '<div class="modal-header bg-modal-custom"><h5 class="modal-title"><i class="fa fa-shopping-cart"></i> Article ajouté au panier</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><div class="container"><div class="col-md-12">L\'article "Chèque cadeau JOeMA" à été ajouté au panier!</div></div></div><div class="modal-footer"><a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Continuer mes achats</a><a href="cart.php" class="primary-btn">Voir mon panier</a></div>'));
		
	}
}

?>
