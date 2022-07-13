<?php require_once('includes/header.php');
$totalCart = $system->totalCart();
?>
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="./index.php"><i class="fa fa-home"></i> Accueil</a>
                        <span>Paiement</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="checkout-section spad">
        <div class="container">
			<div id="logRegError"></div>
            <form action="#" class="checkout-form">
				<!--progress bar-->
				<div class="row">
					<div class="col-lg-12 ml-auto mr-auto mb-4">
						<div class="multisteps-form__progress">
							<button type="button" class="multisteps-form__progress-btn js-active" title="Adresse" id="progress-step-1">Connexion</button>
							<button type="button" class="multisteps-form__progress-btn <?php if(isset($_SESSION['web_joema']['session_user_id'])){ echo 'js-active'; } ?>" title="Adresse" id="progress-step-2">Adresse</button>
							<button type="button" class="multisteps-form__progress-btn" title="Récapitulatif" id="progress-step-3">Récapitulatif</button>
							<button type="button" class="multisteps-form__progress-btn" title="Paiement" id="progress-step-4">Paiement</button>
							<button type="button" class="multisteps-form__progress-btn <?php if(isset($_GET['paymentResult']) && $_GET['paymentResult'] == 'success'){ echo ' js-active'; }?>" title="Terminé">Terminé</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-5">
						<h4>Informations de contact</h4>
						<div class="row mt-3">
							<div class="col-lg-12">
								<label for="street">Adresse email<span>*</span></label>
								<input type="text" id="addEmail" class="form-control"/>
							</div>
							<div class="col-lg-12">
								<label for="phone">Téléphone<span>*</span></label>
								<input type="text" id="addBilAddressPhone" class="form-control">
							</div>
						</div>
						<h4>Adresse de facturation</h4>
						<div class="row mt-2">
							<div class="col-lg-12">
								<label for="pro">Société</label>
								<input type="text" id="addBilProName" class="form-control">
							</div>
							<div class="col-lg-6">
								<label for="fir">Nom<span>*</span></label>
								<input type="text" id="addBilAddressFirstname" class="form-control">
							</div>
							<div class="col-lg-6">
								<label for="last">Prénom<span>*</span></label>
								<input type="text" id="addBilAddressLastname" class="form-control">
							</div>
							<div class="col-lg-12 mb-4">
								<label for="street">Adresse<span>*</span></label>
								<textarea id="addBilAddressText" class="form-control"></textarea>
							</div>
							<div class="col-lg-12">
								<input type="hidden" id="addBilAddressCityID"/>
								<input type="hidden" id="addBilAddressPostal"/>
								<label for="zip">Code postal / Ville<span>*</span></label>
								<input type="text" id="setBilAddressCityName" class="form-control" onkeyup="getAddBillingAddressCity(this.value); return false;">
								<div class="dropdown-menu" id="BillingAddAddressCity" style="margin-top:-10px"></div>
							</div>
						</div>
						<h4>Adresse de livraison</h4>
						<div class="row mt-2">
							<div class="col-lg-12">
								<label for="pro">Société</label>
								<input type="text" id="addBilProName" class="form-control">
							</div>
							<div class="col-lg-6">
								<label for="fir">Nom<span>*</span></label>
								<input type="text" id="addAddressFirstname" class="form-control">
							</div>
							<div class="col-lg-6">
								<label for="last">Prénom<span>*</span></label>
								<input type="text" id="addAddressLastname" class="form-control">
							</div>
							<div class="col-lg-12 mb-4">
								<label for="street">Adresse<span>*</span></label>
								<textarea id="addAddressText" class="form-control"></textarea>
							</div>
							<div class="col-lg-12">
								<input type="hidden" id="addAddressCityID"/>
								<input type="hidden" id="addAddressPostal"/>
								<label for="zip">Code postal / Ville<span>*</span></label>
								<input type="text" id="setAddressCityName" class="form-control" onkeyup="getAddAddressCity(this.value); return false;">
								<div class="dropdown-menu" id="dropdownAddAddressCity" style="margin-top:-10px"></div>
							</div>
							<div class="col-lg-12">
								<label for="phone">Téléphone<span>*</span></label>
								<input type="text" id="addAddressPhone" class="form-control">
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<div class="place-order">
							<h4>Votre commande</h4>
							<div class="order-total">
								<ul class="order-table">
									<?php $totalWeight = 0;
									$nbItems = count($_SESSION['joemaCart']['productID']);
									if($nbItems >= 1){
										echo '<li>Articles <span>Total</span></li>';
										for($i=0;$i<$nbItems;$i++){
											$getArticleDetails = $db->query('SELECT * FROM `articles` WHERE `ID`="'.$_SESSION['joemaCart']['productID'][$i].'"');
											if($getArticleDetails->num_rows == 1){
												$getArticleDetail = $getArticleDetails->fetch_object();
												echo '<li class="fw-normal">'.$getArticleDetail->Name.' x '.$_SESSION['joemaCart']['productQuantity'][$i].' <span>';if($getArticleDetail->ReducedPrice != ''){ echo number_format(($getArticleDetail->ReducedPrice*$_SESSION['joemaCart']['productQuantity'][$i]),2);} else { echo number_format(($getArticleDetail->NormalPrice*$_SESSION['joemaCart']['productQuantity'][$i]),2); } echo ' €</span></li>';
												$totalWeight += $getArticleDetail->Weight;
											}
											else if($_SESSION['joemaCart']['productID'][$i] == '999999999999'){
												echo '<li class="fw-normal">Chèque cadeau JOeMA x 1 <span>'.number_format($_SESSION['joemaCart']['productPrice'][$i], 2).' €</span></li>';
											}
										}
									}
									if(isset($_SESSION['joemaDiscountCode']['code'])){
										$getDiscountCodes = $db->query('SELECT * FROM `discount-codes` WHERE `Code`="'.$_SESSION['joemaDiscountCode']['code'].'" AND `IsActive`="1"');
										if($getDiscountCodes->num_rows == 1){
											$getDiscountCode = $getDiscountCodes->fetch_object();
											if($totalCart >= $getDiscountCode->MinAmount){
												if(!empty($getDiscountCode->Amount)){
													$totalCart = ($totalCart - $getDiscountCode->Amount);
													echo '<li class="fw-normal">Code promo: "<small style="color:#A56400">'.$getDiscountCode->Title.'</small>" <span>-'.number_format($getDiscountCode->Amount, 2).'€</span></li>';
												}
												else if($getDiscountCode->FreeShipping == 1){
													echo '<li class="fw-normal">Code promo: <span style="color:#A56400">Frais de port offert</span></li>';
												}
											}
											else{
												echo '<li class="fw-normal"><div style="color:#ff0000;font-size:10px;font-weight:bold">Vous ne remplissez pas les conditions pour utiliser ce code de réduction!</div></li>';
											}
										}
										else{
											echo '<li class="fw-normal"><div style="color:#ff0000;font-size:12px;font-weight:bold">Le code de réduction saisi est invalide!</div></li>';
										}
									}
									if($totalCart != 0){
										if(isset($_SESSION['joemaGiftCertificate']['code'])){
											$getGiftCertificates = $db->query('SELECT * FROM `gift-certificates` WHERE `Reference`="'.$_SESSION['joemaGiftCertificate']['code'].'"');
											if($getGiftCertificates->num_rows == 1){
												$getGiftCertificate = $getGiftCertificates->fetch_object();
												if($getGiftCertificate->TotalAmount >= $getGiftCertificate->UsedAmount){
													$amountGiftCertificate = ($getGiftCertificate->TotalAmount - $getGiftCertificate->UsedAmount);
													if($totalCart > $amountGiftCertificate){
														$totalCart = ($totalCart - $amountGiftCertificate);
														$calcAmountLast = $amountGiftCertificate - $totalCart;
														$calcAmountDiscount = $amountGiftCertificate - $calcAmountLast;
													}
													else{
														$calcAmountLast = $amountGiftCertificate - $totalCart;
														$calcAmountDiscount = $amountGiftCertificate - $calcAmountLast;
														$totalCart = '0';
													}
													echo '<li class="fw-normal">Chèque cadeau JOeMA "<small style="color:#A56400;font-size:12px">'.$getGiftCertificate->Reference.'</small>" <span>-'.number_format($calcAmountDiscount, 2).'€</span><div style="font-size:10px">Montant restant : <span>'.number_format($calcAmountLast, 2).'€</span></div></li>';
												}
											}
										}
									}
									echo '
										<li class="fw-normal">Sous-total <span>'.number_format($totalCart,2).' €</span></li>
										<li style="border-bottom:none">
											<select class="form-select" id="selectShipmentMethod" name="selectShipmentMethod" onchange="setShipmentMethod(this.value,'.$totalWeight.');return false;">
												<option value="0">Séléctionnez un transporteur</option>';
												$getShipments = $db->query('SELECT * FROM `website-shipments` WHERE `IsActive`="1"');
												if($getShipments->num_rows >= 1){
													while($getShipment = $getShipments->fetch_object()){
														
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
														echo '<option value="'.$getShipment->ID.'">'.$getShipment->Name.' ('; if($price == 0){ echo 'Gratuit'; } else{echo number_format($price, 2).' €';} echo ')</option>';
													}
												}
											echo '</select>
										</li>
										<input type="hidden" id="totalCart" value="'.number_format($totalCart, 2).'"/>
										<li class="total-price">Total <span id="chekoutTotalPrice">'.number_format($totalCart, 2).' €</span></li>';?>
								</ul>
								<div class="payment-check">
									<select class="form-select" id="selectPaymentMethod" name="selectPaymentMethod">
										<option value="0">Séléctionnez un moyen de paiement</option>
										<?php $getPayments = $db->query('SELECT * FROM `website-payment-methods` WHERE `IsActive`="1"');
										if($getPayments->num_rows >= 1){
											while($getPayment = $getPayments->fetch_object()){
												echo '<option value="'.$getPayment->ID.'">'.$getPayment->Name.' ('.$getPayment->OrderDelais.')</option>';
											}
										} ?>
									</select>
								</div>
								<input type="hidden" class="form-control" id="mondialRelayID"/>
								<div class="order-btn">
									<button class="site-btn place-btn" onclick="setNewOrder();return false;">Commander</button>
								</div>
							</div>
						</div>
					</div>
				</div>
            </form>
        </div>
    </section>

<?php require_once('includes/footer.php');?><!-- Widget MR -->
    <script src="https://widget.mondialrelay.com/parcelshop-picker/jquery.plugin.mondialrelay.parcelshoppicker.min.js"></script>