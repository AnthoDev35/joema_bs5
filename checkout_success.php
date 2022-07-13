<?php require_once('includes/header.php');?>
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="index.php"><i class="fa fa-home"></i> Accueil</a>
                        <span>Commander</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="resume-section spad">
        <div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="pre-resume-title">
						<h5>Votre commande a été enregistrée avec succès !</h5>
					</div>
				</div>
				<?php if(isset($_GET['paymentMethodID'])){ /*@TODO payment method validation*/
					if($_GET['paymentMethodID'] == ''){
						echo '<div class="col-lg-12">
							<div class="payment-title">
								<h5>Le paiement de votre commande</h5>
							</div>
							<div class="payment-message">
								<h5>Votre commande a été enregistrée avec succès !</h5>
							</div>
						</div>';
					}
				}?>
				<div class="col-lg-12 mt-3">
					<div class="resume-title">
						<h5>Récapitulatif de votre commande</h5>
					</div>
				</div>
			</div>
			<div class="row mt-5">
				<div class="col-lg-5">
					<h4>Adresse de livraison</h4>
					<?php $getCustomersAddress = $db->query('SELECT * FROM `customers_address` WHERE `ID`="'.$_GET['deliveryAddress'].'"');
					if($getCustomersAddress->num_rows == 1 ){
						$getCustomerAddress = $getCustomersAddress->fetch_object();
						$getCityInfo = $db->query('SELECT * FROM `city_france` WHERE `ID`="'.$getCustomerAddress->cityID.'" LIMIT 1')->fetch_object();
						echo '<div class="card mt-3">
							<div class="col-md-12">'.$getCustomerAddress->firstname.' '.$getCustomerAddress->lastname.'</div>
							<div class="col-md-12">'.$getCustomerAddress->address.'</div>
							<div class="col-md-12">'.$getCityInfo->Postal.' '.$getCityInfo->Name.'</div>
							<div class="col-md-12 mb-2">'.$getCustomerAddress->phone.'</div>
						</div>';
					}
					echo '<h4 class="mt-5">Adresse de facturation</h4>';
					$getBillingsAddress = $db->query('SELECT * FROM `customers_address` WHERE `ID`="'.$_GET['billingAddress'].'"');
					if($getBillingsAddress->num_rows == 1 ){
						$getBillingAddress = $getBillingsAddress->fetch_object();
						$getCityInfo = $db->query('SELECT * FROM `city_france` WHERE `ID`="'.$getBillingAddress->cityID.'" LIMIT 1')->fetch_object();
						echo '<div class="card mt-3">
							<div class="col-md-12">'.$getBillingAddress->firstname.' '.$getBillingAddress->lastname.'</div>
							<div class="col-md-12">'.$getBillingAddress->address.'</div>
							<div class="col-md-12">'.$getCityInfo->Postal.' '.$getCityInfo->Name.'</div>
							<div class="col-md-12 mb-2">'.$getBillingAddress->phone.'</div>
						</div>';
					}
					?>
				</div>
				<div class="col-lg-7">
					<div class="place-order">
						<h4>Votre commande</h4>
						<input type="hidden" id="totalCart" value="<?=$system->totalCart()?>"/>
						<div class="cart-table mt-3">
							<table>
								<thead >
									<tr>
										<th>Article</th>
										<th>Prix</th>
										<th>Quantité</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
								<?php $getOrderArticles = $db->query('SELECT * FROM `customers_order_products` WHERE `OrderID`="'.$_GET['orderID'].'" ORDER BY `ID` DESC');
								if($getOrderArticles->num_rows >= 1 ){
									while($getOrderArticle = $getOrderArticles->fetch_object()){
										$calcProductTotal = ($getOrderArticle->PayedPrice * $getOrderArticle->Quantity);
										echo '<tr>
											<td>'.htmlspecialchars($getOrderArticle->ProductName).'</td>
											<td>'.number_format($getOrderArticle->PayedPrice, 2).'€</td>
											<td>'.$getOrderArticle->Quantity.'</td>
											<td>'.number_format($calcProductTotal, 2).'€</td>
										</tr>';
									}
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
    </section>

<?php require_once('includes/footer.php');?>