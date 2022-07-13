<?php require_once('includes/header.php');
	require_once('payplug-lib/lib/init.php');
	
	/*@TODO Change URL after site isn't beta test*/
	
	// Loads your account's parameters that you've previously downloaded and saved
	Payplug\Payplug::init(array(
	  'secretKey' => 'sk_test_31RqhWoNEIJ0a0QKXmfEpB',
	  'apiVersion' => '2019-08-06',
	));
	
	$totalAmount = 0;
	$totalWeight = 0;
	$getOrderDatas = $db->query('SELECT * FROM `customers_order_products` WHERE `OrderID`="'.$_GET['orderID'].'"');
	if($getOrderDatas->num_rows >= 1){
		while($getOrderData = $getOrderDatas->fetch_object()){
			$artAmount = ($getOrderData->Quantity * $getOrderData->PayedPrice);
			$totalAmount += $artAmount;
			$totalWeight += $getOrderData->Weight;
		}
		if(isset($_SESSION['joemaDiscountCode']['code'])){
			$getDiscountCodes = $db->query('SELECT * FROM `discount-codes` WHERE `Code`="'.$_SESSION['joemaDiscountCode']['code'].'" AND `IsActive`="1"');
			if($getDiscountCodes->num_rows == 1){
				$getDiscountCode = $getDiscountCodes->fetch_object();
				if($totalAmount >= $getDiscountCode->MinAmount){
					if(!empty($getDiscountCode->Amount)){
						$totalAmount = ($totalAmount - $getDiscountCode->Amount);
					}
				}
			}
		}
		$getShipments = $db->query('SELECT * FROM `website-shipments` WHERE `ID`="'.$_GET['shipmentMethod'].'"');
		if($getShipments->num_rows == 1){
			while($getShipment = $getShipments->fetch_object()){
				$totalWeight;
				if($totalWeight > 0 && $totalWeight <= 0.25){
					$price = $getShipment->Price250;
				}
				else if($totalWeight > 0.25 && $totalWeight <= 0.5){
					$price = $getShipment->Price500;
				}
				else if($totalWeight > 0.5 && $totalWeight <= 1){
					$price = $getShipment->Price1000;
				}
				else if($totalWeight >= 1 && $totalWeight <= 2){
					$price = $getShipment->Price2000;
				}
				else if($totalWeight >= 2 && $totalWeight <= 5){
					$price = $getShipment->Price5000;
				}
				if(isset($_SESSION['joemaDiscountCode']['code'])){
					$getDiscountCodes = $db->query('SELECT * FROM `discount-codes` WHERE `Code`="'.$_SESSION['joemaDiscountCode']['code'].'" AND `IsActive`="1"');
					if($getDiscountCodes->num_rows == 1){
						$getDiscountCode = $getDiscountCodes->fetch_object();
						if($system->totalCart() >= $getDiscountCode->MinAmount){
							if($getDiscountCode->FreeShipping){
								if($getShipment->AvailableFreeShipping == "1"){
									$price = '0';
								}
							}
						}
					}
				}
			}
			$totalAmount += $price;
		}
		else{
			echo 'error : '.$getShipments->num_rows.' shID : '.$_GET['shipmentMethod'];
			return false;
		}
	
	}
	$email = 'arcaniafr@gmail.com';
	$customer_id = $_SESSION['web_joema']['session_user_id'];

	$payment = \Payplug\Payment::create(array(
		'amount'           => intval(strval($totalAmount * 100)),
		'currency'         => 'EUR',
		'billing'  => array(
			'title'        => 'mr',
			'first_name'   => 'Anthony',
			'last_name'    => 'Cazier',
			'email'        => $email,
			'address1'     => 'l\'hommelet',
			'postcode'     => '35640',
			'city'         => 'Martigné-Ferchaud',
			'country'      => 'FR',
			'language'     => 'fr'
		),
		'shipping'  => array(
			'title'         => 'mr',
			'first_name'    => 'Anthony',
			'last_name'     => 'Cazier',
			'email'         => $email,
			'address1'      => 'l\'hommelet',
			'postcode'      => '35640',
			'city'          => 'Martigné-Ferchaud',
			'country'       => 'FR',
			'language'      => 'fr',
			'delivery_type' => 'BILLING'
		),
		'hosted_payment'   => array(
		'return_url'     => 'https://joema.fr/beta/checkout_success.php?customerID='.$customer_id.'&orderID='.$orderID.'&paymentResult=success',
		'cancel_url'     => 'https://joema.fr/beta/checkout_canceled.php?customerID='.$customer_id.'&orderID='.$orderID
		),
		'notification_url' => 'https://joema.fr/beta/notification.php?customerID='.$customer_id.'&orderID='.$orderID,
		'metadata'         => array(
		'customer_id'    => $customer_id
		)
	));

	$payment_url = $payment->hosted_payment->payment_url;
	$payment_id = $payment->id;
	header('Location:' . $payment_url);

?>
<script type="text/javascript" src="https://api.payplug.com/js/1/form.latest.js"></script>
<?php if(isset($_GET['paymentMethod'])){
	if($_GET['paymentMethod'] == 2){ ?>
		<script type="text/javascript">
		  document.addEventListener('DOMContentLoaded', function(event) {
				var payplug_url = '<?=$payment->hosted_payment->payment_url?>';
				Payplug.showPayment(payplug_url);
				event.preventDefault();
		  })
		</script>
		<?php 
	}
}
?>
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="index.php"><i class="fa fa-home"></i> Accueil</a>
                        <a href="checkout.php"><i class="fa fa-home"></i> Commander</a>
                        <span>Paiement</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="resume-section spad">
        <div class="container">
			<div class="row">
				<?php if(isset($_GET['paymentMethod'])){
					if($_GET['paymentMethod'] != 2){
						echo '<div class="col-lg-12">
							<div class="payment-title">
								<h5>Paiement de votre commande</h5>
							</div>
							<div class="payment-message">
								<h5>Commande en attente de paiement</h5>
							</div>
						</div>';
					}
				}?>
			</div>
		</div>
    </section>

<?php require_once('includes/footer.php');?>