<?php session_start();
	include_once("../core/functions.php");
	$system = new System;
	$system->db = $db;
	$response = '';

	if(isset($_POST['getAccountInfos'])){
		if(isset($_SESSION['web_joema']['session_user_id'])){
			$getAccountInfos = $db->query('SELECT * FROM `customers` WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'" LIMIT 1')->fetch_object();
			if($getAccountInfos->isValided == 0){
				$response .= '<div class="alert alert-warning"><i class="fa fa-warning"></i> Attention, votre compte n\'est pas encore validé. Pour commander, la validation de l\'adresse email est obligatoire ! <button type="button" class="btn btn-warning btn-sm pull-right" onclick="resendConfirmMail();return false;">Renvoyer le mail</button></div>';
			}
			$response .= '
			<div class="row">
				<div class="col-sm-3"><h6 class="mb-0">Email</h6></div>
				<div class="col-sm-9 text-secondary">'.$getAccountInfos->email.'</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-3"><h6 class="mb-0">Nom</h6></div>
				<div class="col-sm-9 text-secondary">'.ucfirst($getAccountInfos->firstname).'</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-3"><h6 class="mb-0">Prénom</h6></div>
				<div class="col-sm-9 text-secondary">'.ucfirst($getAccountInfos->lastname).'</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-3"><h6 class="mb-0">Adresse</h6></div>
				<div class="col-sm-9 text-secondary">'.ucfirst($getAccountInfos->address).'</div>
			</div>
			<hr>';
			$getCityInfos = $db->query('SELECT * FROM `city_france` WHERE `ID`="'.$getAccountInfos->cityID.'" LIMIT 1')->fetch_object();
			$response .= '<div class="row">
				<div class="col-sm-3"><h6 class="mb-0">Code postal</h6></div>
				<div class="col-sm-9 text-secondary">'.$getCityInfos->Postal.'</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-3"><h6 class="mb-0">Ville</h6></div>
				<div class="col-sm-9 text-secondary">'.ucfirst($getCityInfos->Name).'</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-3"><h6 class="mb-0">Téléphone</h6></div>
				<div class="col-sm-9 text-secondary">'.$getAccountInfos->phone.'</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-12">
					<a class="btn btn-info" href="#" onclick="editProfile();return false;">Editer</a>
				</div>
			</div>';
		}
	}
	
	/*get address*/
	if(isset($_POST['getWalletsInfos'])){
		if(isset($_SESSION['web_joema']['session_user_id'])){
			$walletAmount = '0';
			$getAccountInfos = $db->query('SELECT * FROM `customers` WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'" LIMIT 1')->fetch_object();
			if($getAccountInfos->isValided == 0){
				$response .= '<div class="alert alert-warning"><i class="fa fa-warning"></i> Attention, votre compte n\'est pas encore validé. Pour réserver, la validation de l\'adresse email est obligatoire !</div>';
			}
			$getCustomersWallets = $db->query('SELECT * FROM `customers_wallets` WHERE `customerID`="'.$_SESSION['web_joema']['session_user_id'].'" ORDER BY `ID` DESC');
			if($getCustomersWallets->num_rows == 1){
				$getCustomersWallet = $getCustomersWallets->fetch_object();
				if($getCustomersWallet->Amount != '' || $getCustomersWallet->Amount != '0'){
					$walletAmount = $getCustomersWallet->Amount;
				}
			}
			$response .= '<div id="account-booking" class="row">
				<div class="col-lg-12">
					<div class="card card-shadow mb-4">
						<div class="card-body p-4">
							<div class="col-lg-12">
								<div class="price-box my-3">
									<p>Montant de mon porte monnaie : <span class="wallet-amount">'.$walletAmount.' €</span></p>
									<div class="ml-auto mt-5">
										<button type="button" class="btn btn-info" onclick="">Créditer mon porte monnaie</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>';
		}
	}
	/*get address*/
	if(isset($_POST['getAddressInfos'])){
		if(isset($_SESSION['web_joema']['session_user_id'])){
			$getAccountInfos = $db->query('SELECT * FROM `customers` WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'" LIMIT 1')->fetch_object();
			if($getAccountInfos->isValided == 0){
				$response .= '<div class="alert alert-warning"><i class="fa fa-warning"></i> Attention, votre compte n\'est pas encore validé. Pour réserver, la validation de l\'adresse email est obligatoire !</div>';
			}
			$response .= '<div id="account-booking" class="row">';
			$getCustomerAddress = $db->query('SELECT * FROM `customers_address` WHERE `customerID`="'.$_SESSION['web_joema']['session_user_id'].'" ORDER BY `ID` DESC');
			if($getCustomerAddress->num_rows == 0){
				$updAccCityID = 0;
				if(!empty($getAccountInfos->firstname)){
					$updAccFirstname = $getAccountInfos->firstname;
				}
				if(!empty($getAccountInfos->lastname)){
					$updAccLastname = $getAccountInfos->lastname;
				}
				if(!empty($getAccountInfos->address)){
					$updAccAddress = $getAccountInfos->address;
				}
				if(!empty($getAccountInfos->postal)){
					$updAccPostal = $getAccountInfos->postal;
				}
				if(!empty($getAccountInfos->cityID)){
					$updAccCityID = $getAccountInfos->cityID;
				}
				if(!empty($getAccountInfos->phone)){
					$updAccPhone = $getAccountInfos->phone;
				}
				$updCustomerAddress = $db->query('INSERT INTO `customers_address` (`customerID`,`addressName`,`firstname`,`lastname`,`address`,`postal`,`cityID`,`phone`) VALUES
				("'.$getAccountInfos->ID.'", "Automatique", "'.$updAccFirstname.'","'.$updAccLastname.'","'.$updAccAddress.'","'.$updAccPostal.'","'.$updAccCityID.'","'.$updAccPhone.'")');
			}
			else{
				$getUpdCustomersAddress = $db->query('SELECT * FROM `customers_address` WHERE `customerID`="'.$_SESSION['web_joema']['session_user_id'].'" ORDER BY `ID` DESC');
				if($getUpdCustomersAddress->num_rows >= 1){
					while($getUpdCustomerAddress = $getUpdCustomersAddress->fetch_object()){
						$getCity = $db->query('SELECT * FROM `city_france` WHERE `ID`="'.$getUpdCustomerAddress->cityID.'" LIMIT 1')->fetch_object();
						$response .= '<div class="col-lg-12">
							<div class="card card-shadow mb-4">
								<div class="card-body p-4">
									<div class="d-flex align-items-center border-bottom pb-4">
										<h5 class="font-weight-medium mb-0">Adresse "<i>'.$getUpdCustomerAddress->addressName.'"</i></h5>
										<div class="ml-auto">';
											if($getUpdCustomerAddress->IsActive == 1){
												$response .= '<span class="badge badge-success font-weight-normal p-2">Confirmé</span></div>';
											}
											else{
												$response .= '<span class="badge badge-danger font-weight-normal p-2">Non-confirmé</span></div>';
											}
										$response .= '</div>
										<div class="col-lg-12">
											<div class="price-box my-3">
												<p>'.ucfirst($getUpdCustomerAddress->firstname).' '.ucfirst($getUpdCustomerAddress->lastname).'</p>
												<p>'.$getUpdCustomerAddress->address.'</p>
												<p>'.$getUpdCustomerAddress->postal.' '.ucfirst($getCity->Name).'</p>
												<p>Téléphone : '.$getUpdCustomerAddress->phone.'</p>
												<div class="ml-auto mt-5">
													<button type="button" class="btn '; if($getUpdCustomerAddress->IsActive == 1){ $response .= 'btn-secondary" disabled="disabled"'; }else{ $response .= 'btn-info" onclick="setValidateAddress('.$getUpdCustomerAddress->ID.'); return false;"'; } $response .= '>Confirmer cette adresse</button>
													<button type="button" class="btn btn-danger pull-right" onclick="setDeleteAddress('.$getUpdCustomerAddress->ID.'); return false;">Supprimer cette adresse</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>';
						}
					}
				}
			$response .= '</div>';
		}
	}
	
	/*validate postal address*/
	if(isset($_POST['setValidateAddress']) && isset($_POST['addressID'])){
		if(isset($_SESSION['web_joema']['session_user_id'])){
			$getCustomersAddress = $db->query('SELECT * FROM `customers_address` WHERE `customerID`="'.$_SESSION['web_joema']['session_user_id'].'" AND `ID`="'.$_POST['addressID'].'"');
			if($getCustomersAddress->num_rows == 1){
				$setValidateAddress = $db->query('UPDATE `customers_address` SET `IsActive`=1 WHERE `customerID`="'.$_SESSION['web_joema']['session_user_id'].'" AND `ID`="'.$_POST['addressID'].'"');
				if($setValidateAddress){
					$response .= 'success';
				}
				else{
					$response .= 'Une erreur c\'est produite, contactez l\'administrateur.';
				}
			}
		}
	}
	
	/*delete postal address*/
	if(isset($_POST['setDeleteAddress']) && isset($_POST['addressID'])){
		if(isset($_SESSION['web_joema']['session_user_id'])){
			$getCustomersAddress = $db->query('SELECT * FROM `customers_address` WHERE `customerID`="'.$_SESSION['web_joema']['session_user_id'].'" AND `ID`="'.$_POST['addressID'].'"');
			if($getCustomersAddress->num_rows == 1){
				$setDeleteAddress = $db->query('DELETE FROM `customers_address` WHERE `customerID`="'.$_SESSION['web_joema']['session_user_id'].'" AND `ID`="'.$_POST['addressID'].'"');
				if($setDeleteAddress){
					$response .= 'success';
				}
				else{
					$response .= 'Une erreur c\'est produite, contactez l\'administrateur.';
				}
			}
		}
	}
	
	/*get wishlist*/
	if(isset($_POST['getWishlistInfo'])){
		if(isset($_SESSION['web_joema']['session_user_id'])){
			$getWishlists = $db->query('SELECT * FROM `customers_wishlist` WHERE `CustomerID`="'.$_SESSION['web_joema']['session_user_id'].'"');
			if($getWishlists->num_rows >= 1){
				$response .= '<div id="account-wishlist" class="row">';
					while($getWishlist = $getWishlists->fetch_object()){
						$getProduct = $db->query('SELECT * FROM `articles` WHERE `ID`="'.$getWishlist->ProductID.'"')->fetch_object();
						$response .= '<div class="col-lg-6">
							<div class="product-item">
								<div class="pi-pic">
									<a href="product-details.php?categories=true&pId='.$getProduct->ID.'">
										<img src="'.$getProduct->Image1.'" alt="'.$getProduct->Name.'">
									</a>
									<div class="icon">
										<a href="#" onclick="delArtWishList('.$getProduct->ID.')"><i class="fa fa-close"></i></a>
									</div>
								</div>
								<div class="pi-text">
									<a href="product-details.php'.$urlBeforeArtDetail.'">
										<h5>'.$getProduct->Name.'</h5>
										<div class="product-price">';
										if($getProduct->ReducedPrice != '0' && $getProduct->ReducedPrice != ''){
											$response .= $getProduct->ReducedPrice.' € <span>'.$getProduct->NormalPrice.'€</span>';
										}
										else{
											$response .= $getProduct->NormalPrice.'€';
										}
										$response .= '</div>
									</a>
								</div>
							</div>
						</div>';
					}
				$response .= '</div>';
			}
			else{
				$response .= '<div class="alert alert-info"><i class="fa fa-heart"></i> Coup de coeur : Vous n\'avez pas encore de coup de coeur sur JOeMA !</div>';
			}
		}
	}
	
	/*get orders */
	if(isset($_POST['getOrdersInfos'])){
		if(isset($_SESSION['web_joema']['session_user_id'])){
			$getAccountInfos = $db->query('SELECT * FROM `customers` WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'" LIMIT 1')->fetch_object();
			if($getAccountInfos->isValided == 0){
				$response .= '<div class="alert alert-warning"><i class="fa fa-warning"></i> Attention, votre compte n\'est pas encore validé. Pour réserver, la validation de l\'adresse email est obligatoire !</div>';
			}
			$response .= '<div id="account-orders" class="row">';
			$getCustomerOrders = $db->query('SELECT * FROM `customers_orders` WHERE `CustomerID`="'.$_SESSION['web_joema']['session_user_id'].'" ORDER BY `ID` DESC');
			if($getCustomerOrders->num_rows >= 1){
				while($getCustomerOrder = $getCustomerOrders->fetch_object()){
					$response .= '<div class="col-lg-12">
						<div class="card card-shadow mb-4">
							<div class="card-body p-4">
								<div class="d-flex align-items-center border-bottom pb-4">
									<h5 class="font-weight-medium mb-0">Commande n° <i>JM-1000000-'.$getCustomerOrder->ID.'</i></h5>
									<div class="ml-auto">';
										if($getCustomerOrder->IsPayed == 1 && $getCustomerOrder->IsSend == 0){
											$response .= '<span class="badge badge-warning font-weight-normal p-2">Paiement confirmé</span></div>';
										}
										else if($getCustomerOrder->IsPayed == 1 && $getCustomerOrder->IsSend == 1 && $getCustomerOrder->IsDelivery == 0){
											$response .= '<span class="badge badge-info font-weight-normal p-2">Expédier</span></div>';
										}
										else if($getCustomerOrder->IsPayed == 1 && $getCustomerOrder->IsSend == 1 && $getCustomerOrder->IsDelivery == 1){
											$response .= '<span class="badge badge-success font-weight-normal p-2">Commande reçu</span></div>';
										}
										else{
											$response .= '<span class="badge badge-danger font-weight-normal p-2">Non-confirmé</span></div>';
										}
									$response .= '</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="order-box my-3">';
												$getOrderDetails = $db->query('SELECT * FROM `customers_order_products` WHERE `CustomerID`="'.$_SESSION['web_joema']['session_user_id'].'" AND `OrderID`="'.$getCustomerOrder->ID.'"');
												if($getOrderDetails->num_rows >= 1){
													$response .= '<table class="table">
														<thead>
														<tr class="text-center">
														  <th scope="col">Nom</th>
														  <th scope="col">Quantité</th>
														  <th scope="col">Prix Total TTC</th>
														</tr>
														</thead>
														<tbody>';
													while($getOrderDetail = $getOrderDetails->fetch_object()){
														$response .= '<tr class="text-center">
															<td>'.$getOrderDetail->ProductName.'</td>
															<td>'.$getOrderDetail->Quantity.'</td>
															<td>'.number_format($getOrderDetail->PayedPrice,2).' €</td>
														</tr>
														';
													}
													$response .= '
													  </tbody>
													</table>';
												}
												$response .= '<div class="ml-auto mt-5">
													<button type="button" class="btn '; if($getCustomerOrder->IsSend == 1){ $response .= 'btn-secondary" disabled="disabled"'; }else{ $response .= 'btn-info" onclick="setOrderDelivery('.$getCustomerOrder->ID.'); return false;"'; } $response .= '>Confirmer la récéption</button>
													<button type="button" class="btn btn-danger pull-right" onclick="getOrderRequest('.$getCustomerOrder->ID.'); return false;">Faire une réclamation</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					';
				}
			}
			else{
				$response .= '<div class="alert alert-info"><i class="fa fa-warning"></i> Commandes : Vous n\'avez pas encore effectué de commandes sur JOeMA !</div>';
			}
		}
	}
	
	// get Account City 
	if(isset($_POST['getAccountCity']) && isset($_POST['value'])){
		$getAllCities = $db->query('SELECT * FROM `city_france` WHERE `Postal` LIKE "'.$_POST['value'].'%" OR  `Name` LIKE "'.$_POST['value'].'%" ORDER BY `ID` ASC');
		$response .= '<span class="dropdown-item-text">Séléctionnez votre ville</span>';
		while($getAllCity = $getAllCities->fetch_object())	{
			$response .= '<a href="#" class="dropdown-item" onclick="setAccountModCityInput(\''.$getAllCity->ID.'\',\''.$getAllCity->Postal.'\',\''.$getAllCity->Name.'\');">'.$getAllCity->Postal.' - '.$getAllCity->Name.'</a>';
		}
	}
	
	// get address City 
	if(isset($_POST['getAddAddressCity']) && isset($_POST['value'])){
		$getAllCities = $db->query('SELECT * FROM `city_france` WHERE `Postal` LIKE "'.$_POST['value'].'%" OR  `Name` LIKE "'.$_POST['value'].'%" ORDER BY `ID` ASC');
		$response .= '<span class="dropdown-item-text">Séléctionnez votre ville</span>';
		while($getAllCity = $getAllCities->fetch_object())	{
			$response .= '<a href="#" class="dropdown-item" onclick="setAddressCityInput(\''.$getAllCity->ID.'\',\''.$getAllCity->Postal.'\',\''.$getAllCity->Name.'\');">'.$getAllCity->Postal.' - '.$getAllCity->Name.'</a>';
		}
	}
	
	// get address City 
	if(isset($_POST['getAddBilAddressCity']) && isset($_POST['value'])){
		$getAllCities = $db->query('SELECT * FROM `city_france` WHERE `Postal` LIKE "'.$_POST['value'].'%" OR  `Name` LIKE "'.$_POST['value'].'%" ORDER BY `ID` ASC');
		$response .= '<span class="dropdown-item-text">Séléctionnez votre ville</span>';
		while($getAllCity = $getAllCities->fetch_object())	{
			$response .= '<a href="#" class="dropdown-item" onclick="setBilAddressCityInput(\''.$getAllCity->ID.'\',\''.$getAllCity->Postal.'\',\''.$getAllCity->Name.'\');">'.$getAllCity->Postal.' - '.$getAllCity->Name.'</a>';
		}
	}
	
	if(isset($_POST['editProfile'])){
		if(isset($_SESSION['web_joema']['session_user_id'])){
			$getAccountInfos = $db->query('SELECT * FROM `customers` WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'" LIMIT 1')->fetch_object();
			$getCityInfos = $db->query('SELECT * FROM `city_france` WHERE `ID`="'.$getAccountInfos->cityID.'" LIMIT 1')->fetch_object();
			$response .= '
			<div class="row mb-3">
				<div class="col-sm-3"><h6 class="mt-2">Email</h6></div>
				<div class="col-sm-9 text-secondary"><input type="text" class="form-control" id="modAccEmail" value="'.$getAccountInfos->email.'"></div>
			</div>
			<div class="row mb-3">
				<div class="col-sm-3"><h6 class="mt-2">Nom</h6></div>
				<div class="col-sm-9 text-secondary"><input type="text" class="form-control" id="modAccFirstname" value="'.ucfirst($getAccountInfos->firstname).'"></div>
			</div>
			<div class="row mb-3">
				<div class="col-sm-3"><h6 class="mt-2">Prénom</h6></div>
				<div class="col-sm-9 text-secondary"><input type="text" class="form-control" id="modAccLastname" value="'.ucfirst($getAccountInfos->lastname).'"></div>
			</div>
			<div class="row mb-3">
				<div class="col-sm-3"><h6 class="mt-2">Adresse</h6></div>
				<div class="col-sm-9 text-secondary"><input type="text" class="form-control" id="modAccAddress" value="'.ucfirst($getAccountInfos->address).'"></div>
			</div>
			<input type="hidden" class="form-control" value="'.$getCityInfos->Postal.'" id="ModPostal">
			<input type="hidden" class="form-control" value="'.$getCityInfos->ID.'" id="ModCityID">
			<div class="row mb-3">
				<div class="col-sm-3"><h6 class="mt-2">Code postal / Ville</h6></div>
				<div class="col-sm-9 text-secondary"><input type="text" class="form-control" value="'.$getCityInfos->Postal.' '.ucfirst($getCityInfos->Name).'" id="ModCityInput" onkeyup="getModAccountCity(this.value); return false;"><div class="dropdown-menu" id="dropdownModSelectCity"></div></div>
			</div>
			<div class="row mb-3">
				<div class="col-sm-3"><h6 class="mt-2">Téléphone</h6></div>
				<div class="col-sm-9 text-secondary"><input type="text" class="form-control" id="modAccPhone" value="'.$getAccountInfos->phone.'"></div>
			</div>
			<div class="row mb-3">
				<div class="col-sm-3"><h6 class="mt-2">Mot de passe</h6></div>
				<div class="col-sm-9 text-secondary"><input type="password" class="form-control" id="modAccPassword" required><small>Renseignez votre mot de passe pour valider la modification</small></div>
			</div>
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 text-secondary">
					<button type="button" class="btn btn-primary pull-right" onclick="setAccountData();return false;">Enregistrer</button>
				</div>
			</div>';
		}
	}

	if(isset($_POST['editProfilDatas']) && isset($_POST['modAccEmail']) && isset($_POST['modAccFirstname']) && isset($_POST['modAccLastname']) && isset($_POST['modAccAddress']) && isset($_POST['modAccPostal']) && isset($_POST['modAccCityID']) && isset($_POST['modAccPhone']) && isset($_POST['modAccPassword'])){
		if(isset($_SESSION['web_joema']['session_user_id'])){
			$getAccountInfos = $db->query('SELECT * FROM `customers` WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'" LIMIT 1')->fetch_object();
			$encrypt_password = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256",strtoupper(hash("sha256", strtoupper($getAccountInfos->email)).":".strtoupper($_POST['modAccPassword']))))))));
			if($getAccountInfos->sha_pass_hash == $encrypt_password){
				$modCityId = 0;
				if($_POST['modAccCityID'] != '')
					$modCityId = $_POST['modAccCityID'];
				if($_POST['modAccEmail'] == $getAccountInfos->email){
					$setNewAccountData = $db->query('UPDATE `customers` SET `email`="'.$_POST['modAccEmail'].'",`firstname`="'.$_POST['modAccFirstname'].'",`lastname`="'.$_POST['modAccLastname'].'",`address`="'.$_POST['modAccAddress'].'",`postal`="'.$_POST['modAccPostal'].'",	`cityID`="'.$modCityId.'",`phone`="'.$_POST['modAccPhone'].'" WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'"');
					if($setNewAccountData){
						$response .= 'success';
					}
					else{
						$response .= 'Une erreur interne c\'est produite, contactez l\'administrateur si le problème persiste !';
					}
				}
				else{
					$encrypt_password = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256",strtoupper(hash("sha256", strtoupper($_POST['modAccEmail'])).":".strtoupper($_POST['modAccPassword']))))))));
					$setNewAccountData = $db->query('UPDATE `customers` SET `email`="'.$_POST['modAccEmail'].'",`firstname`="'.$_POST['modAccFirstname'].'",`lastname`="'.$_POST['modAccLastname'].'",`address`="'.$_POST['modAccAddress'].'",`postal`="'.$_POST['modAccPostal'].'",	`cityID`="'.$modCityId.'",`phone`="'.$_POST['modAccPhone'].'", `sha_pass_hash`="'.$encrypt_password.'" WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'"');
					if($setNewAccountData){
						$response .= 'success';
					}
					else{
						$response .= 'Une erreur interne c\'est produite, contactez l\'administrateur si le problème persiste !';
					}
				}
			}
			else{
				$response .= 'Le mot de passe saisi est incorrect, les modifications n\'ont pas étés enregistrées!';
			}
		}
		else{
			$response .= 'Vous devez être connecté pour modifier votre compte.';
		}
	}
	/*delete account*/
	if(isset($_POST['setAccountDelete']) && isset($_POST['delAccountPassword'])){
		if(isset($_SESSION['web_joema']['session_user_id'])){
			$getAccountInfos = $db->query('SELECT * FROM `customers` WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'" LIMIT 1');
			if($getAccountInfos->num_rows == 1){
				$getAccountInfo = $getAccountInfos->fetch_object();
				$encrypt_password = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256",strtoupper(hash("sha256", strtoupper($getAccountInfo->email)).":".strtoupper($_POST['delAccountPassword']))))))));
				if($getAccountInfo->sha_pass_hash == $encrypt_password){
					$getCustomersAddress = $db->query('SELECT * FROM `customers_address` WHERE `customerID`="'.$_SESSION['web_joema']['session_user_id'].'"');
					if($getCustomersAddress->num_rows >= 1){
						$setDeleteAddress = $db->query('DELETE FROM `customers_address` WHERE `customerID`="'.$_SESSION['web_joema']['session_user_id'].'"');
						if($setDeleteAddress){
							$setDeleteOrders = $db->query('DELETE FROM `customers_orders` WHERE `customerID`="'.$_SESSION['web_joema']['session_user_id'].'"');
							if($setDeleteOrders){
								$setDeleteWishlists = $db->query('DELETE FROM `customers_wishlist` WHERE `customerID`="'.$_SESSION['web_joema']['session_user_id'].'"');
								if($setDeleteWishlists){
									$setDeleteAccount = $db->query('DELETE FROM `customers` WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'"');
									if($setDeleteWishlists){
										session_start();
										session_destroy();
										if(isset($_SESSION['web_joema']['session_auth'])){
											$response .= 'success';
										}
										else{
											$response .= 'Une erreur c\'est produite pendant la déconnexion !';
										}
									}
									else{
										$response .= 'Une erreur c\'est produite, contactez l\'administrateur.';
									}
								}
								else{
									$response .= 'Une erreur c\'est produite, contactez l\'administrateur.';
								}
							}
							else{
								$response .= 'Une erreur c\'est produite, contactez l\'administrateur.';
							}
						}
						else{
							$response .= 'Une erreur c\'est produite, contactez l\'administrateur.';
						}
					}
				}
				else{
					$response .= 'Une erreur c\'est produite, le mot de passe est incorrect.';
				}
			}
			else{
				$response .= 'Une erreur c\'est produite, le compte est introuvable.';
			}
		}
		else{
			session_start();
			session_destroy();
			if(isset($_SESSION['web_joema']['session_auth'])){
				$response .= 'success';
			}
			else{
				echo 'Une erreur c\'est produite pendant la déconnexion !';
			}
		}
	}
	
	if(isset($_POST['addDeliveryAddress']) && isset($_POST['addAddressName']) && isset($_POST['addAddressFirstname']) && isset($_POST['addAddressLastname']) && isset($_POST['addAddressText']) && isset($_POST['addAddressPostal']) && isset($_POST['addAddressCity']) && isset($_POST['addAddressPhone'])){
		$setNewAddress = $db->query('INSERT INTO `customers_address` (`customerID`,`addressName`,`firstname`,`lastname`,`address`,`postal`,`cityID`,`phone`) VALUES ("'.$_SESSION['web_joema']['session_user_id'].'","'.$_POST['addAddressName'].'","'.$_POST['addAddressFirstname'].'","'.$_POST['addAddressLastname'].'","'.$_POST['addAddressText'].'","'.$_POST['addAddressPostal'].'","'.$_POST['addAddressCity'].'","'.$_POST['addAddressPhone'].'")');
		if($setNewAddress){
			$response .= 'success';
		}
	}
	
	if(isset($_POST['addBillingAddress']) && isset($_POST['addBilAddressName']) && isset($_POST['addBilAddressFirstname']) && isset($_POST['addBilAddressLastname']) && isset($_POST['addBilAddressText']) && isset($_POST['addBilAddressPostal']) && isset($_POST['addBilAddressCity']) && isset($_POST['addBilAddressPhone'])){
		$setNewAddress = $db->query('INSERT INTO `customers_address` (`customerID`,`addressName`,`firstname`,`lastname`,`address`,`postal`,`cityID`,`phone`) VALUES ("'.$_SESSION['web_joema']['session_user_id'].'","'.$_POST['addBilAddressName'].'","'.$_POST['addBilAddressFirstname'].'","'.$_POST['addBilAddressLastname'].'","'.$_POST['addBilAddressText'].'","'.$_POST['addBilAddressPostal'].'","'.$_POST['addBilAddressCity'].'","'.$_POST['addBilAddressPhone'].'")');
		if($setNewAddress){
			$response .= 'success';
		}
	}
	
	if(isset($_POST['getAddressDetail']) && isset($_POST['addressID'])){
		$getAddressInfos = $db->query('SELECT * FROM `customers_address` WHERE `ID`="'.$_POST['addressID'].'" AND `customerID`="'.$_SESSION['web_joema']['session_user_id'].'" LIMIT 1');
		if($getAddressInfos->num_rows == 1){
			$getAddressInfo = $getAddressInfos->fetch_object();
			$getCityInfo = $db->query('SELECT * FROM `city_france` WHERE `ID`="'.$getAddressInfo->cityID.'" LIMIT 1')->fetch_object();
			$response .= '<div class="card mt-3">
				<div class="col-md-12 m-2"><h6><strong>Adresse de livraison</strong></h6></div>
				<div class="col-md-12 m-3"><h6>'.ucfirst($getAddressInfo->firstname).' '.ucfirst($getAddressInfo->lastname).'</h6>
				<h6>'.$getAddressInfo->address.'</h6>
				<h6>'.$getCityInfo->Postal.' '.$getCityInfo->Name.'</h6>
				<h6>'.$getAddressInfo->phone.'</h6></div>
			</div>
			<input type="hidden" id="userPostal" value="'.$getCityInfo->Postal.'"/>';
		}
		else{
			$response .= 'L\'adresse séléctionnée est introuvable.';
		}
	}
	
	echo $response;
	
?>
