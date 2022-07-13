<?php session_start();
include_once("../core/functions.php");
$system = new System;
$system->db = $db;
$checkoutResult = '';
if(isset($_POST['setShipmentMethod']) && isset($_POST['totalWeight']) && isset($_POST['methodID'])){
	$getShipment = $db->query('SELECT * FROM `website-shipments` WHERE `ID`="'.$_POST['methodID'].'" LIMIT 1')->fetch_object();
	$totalWeight = $_POST['totalWeight'];
	if($totalWeight > 0 && $totalWeight <= 0.25){
		$price = $getShipment->Price250;
	}
	else if($totalWeight > 0.25 && $totalWeight <= 0.5){
		$price = $getShipment->Price500;
	}
	else if($totalWeight > 0.5 && $totalWeight <= 1){
		$price = $getShipment->Price1000;
	}
	if($getShipment->IsMondialRelay == 1){
		$isMondialRelay = 1;
	}
	else{
		$isMondialRelay = 0;
	}
	$totals = $price + $system->totalCart();
	if(isset($_SESSION['joemaDiscountCode']['code'])){
		$getDiscountCodes = $db->query('SELECT * FROM `discount-codes` WHERE `Code`="'.$_SESSION['joemaDiscountCode']['code'].'" AND `IsActive`="1"');
		if($getDiscountCodes->num_rows == 1){
			$getDiscountCode = $getDiscountCodes->fetch_object();
			if($totals >= $getDiscountCode->MinAmount){
				if(!empty($getDiscountCode->Amount)){
					$totals = ($totals - $getDiscountCode->Amount);
					$pageCartPrice .= '<li class="promocode">Code promo: "<small style="color:#A56400">'.$getDiscountCode->Title.'</small>"<span>-'.number_format($getDiscountCode->Amount, 2).'€  <a href="#" onclick="delDiscountCode();" style="color:#A56400"><i class="fa fa-close"></i></a></span></li>';
				}
				else if($getDiscountCode->FreeShipping == 1){
					$pageCartPrice .= '<li class="promocode">Code promo: <span style="color:#A56400">Frais de port offert <a href="#" onclick="delDiscountCode();" style="color:#A56400"><i class="fa fa-close"></i></a></span></li>';
				}
			}
			else{
				$pageCartPrice .= '<li class="promocode"><div style="color:#ff0000;font-size:10px;font-weight:bold">Vous ne remplissez pas les conditions pour utiliser ce code de réduction! <span><a href="#" style="color:#A56400" onclick="delDiscountCode();"><i class="fa fa-close"></i></a></span></div></li>';
			}
		}
		else{
			$pageCartPrice .= '<li class="promocode"><div style="color:#ff0000;font-size:12px;font-weight:bold">Le code de réduction saisi est invalide! <span><a href="#" onclick="delDiscountCode();" style="color:#A56400"><i class="fa fa-close"></i></a></span></div></li>';
		}
	}
	echo json_encode(array('checkoutResult' => number_format($totals, 2), 'isMondialRelay' => $isMondialRelay));
}

if(isset($_POST['setNewOrder']) && isset($_POST['deliveryAddress']) && isset($_POST['billingAddress']) && isset($_POST['shipmentMethod']) && isset($_POST['paymentMethod']) && isset($_POST['totalCart'])){
	$getPaymentMethods = $db->query('SELECT * FROM `website-payment-methods` WHERE `ID`="'.$_POST['paymentMethod'].'" LIMIT 1');
	if($getPaymentMethods->num_rows == 1){
		$setNewOrder = $db->query('INSERT INTO `customers_orders` (`CustomerID`,`DeliveryAddressID`,`BillingAddressID`,`ShipmentMethodID`,`PaymentMethodID`,`Date`,`IsPayed`,`IsSend`,`IsDelivery`) VALUES 
		("'.$_SESSION['web_joema']['session_user_id'].'","'.$_POST['deliveryAddress'].'","'.$_POST['billingAddress'].'","'.$_POST['shipmentMethod'].'","'.$_POST['paymentMethod'].'","'.time().'","0","0","0")');
		if($setNewOrder){
			$getOrders = $db->query('SELECT * FROM `customers_orders` WHERE `CustomerID`="'.$_SESSION['web_joema']['session_user_id'].'" ORDER BY `ID` DESC LIMIT 1');
			if($getOrders->num_rows == 1){
				$getOrder = $getOrders->fetch_object();
				$countItems = count($_SESSION['joemaCart']['productID']);
				$countDBSave = 0;
				if(!$countItems <= 0){
					for($i=0;$i<$countItems;$i++){
						if($_SESSION['joemaCart']['productID'][$i] == '999999999999'){
							$saveProducts = $db->query('INSERT INTO `customers_order_products` (`OrderID`,`CustomerID`,`ProductID`,`CategorieID`,`Reference`,`ProductName`,`Quantity`,`PayedPrice`,`Weight`) VALUES 
							("'.$getOrder->ID.'","'.$_SESSION['web_joema']['session_user_id'].'","'.$_SESSION['joemaCart']['productID'][$i].'","0","0","'.$_SESSION['joemaCart']['productTitle'][$i].'","'.$_SESSION['joemaCart']['productQuantity'][$i].'","'.$_SESSION['joemaCart']['productPrice'][$i].'","'.$getArticle->Weight.'")');
							if($saveProducts){
								$countDBSave++;
							}
						}
						else{
							$getArticle = $db->query('SELECT * FROM `articles` WHERE `ID`="'.$_SESSION['joemaCart']['productID'][$i].'" ORDER BY `ID` DESC LIMIT 1')->fetch_object();
							$price = $getArticle->NormalPrice;
							if($getArticle->ReducedPrice != ''){
								$price = $getArticle->ReducedPrice;
							}
							$saveProducts = $db->query('INSERT INTO `customers_order_products` (`OrderID`,`CustomerID`,`ProductID`,`CategorieID`,`Reference`,`ProductName`,`Quantity`,`PayedPrice`,`Weight`) VALUES 
							("'.$getOrder->ID.'","'.$_SESSION['web_joema']['session_user_id'].'","'.$_SESSION['joemaCart']['productID'][$i].'","'.$getArticle->CategorieID.'","'.$getArticle->Reference.'","'.$getArticle->Name.'","'.$_SESSION['joemaCart']['productQuantity'][$i].'","'.$price.'","'.$getArticle->Weight.'")');
							if($saveProducts){
								$countDBSave++;
							}
						}
					}
				}
				$totalCart = intval(strval($_POST['totalCart'] * 100));
				if($countDBSave == $countItems){
					$checkoutResult .= 'checkout_payment.php?orderID='.$getOrder->ID.'&deliveryAddress='.$getOrder->DeliveryAddressID.'&billingAddress='.$getOrder->BillingAddressID.'&shipmentMethod='.$_POST['shipmentMethod'].'&paymentMethod='.$getOrder->PaymentMethodID.'&totalCart='.$totalCart;
				}
			}
		}
		else{
			$checkoutResult .= 'error';
		}
	}
	else{
		$checkoutResult .= 'error';
	}
}

echo $checkoutResult;

?>