<?php require_once('includes/header.php');
if(isset($_SESSION['web_joema']['session_user_id'])){
	$accountAccount = 'Profil';
	$system->setSyncAccountCart();
	$getAccInfos = $db->query('SELECT * FROM `customers` WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'" LIMIT 1')->fetch_object();
	$getCityInfos = $db->query('SELECT * FROM `city_france` WHERE `ID`="'.$getAccInfos->cityID.'" LIMIT 1')->fetch_object();
}
else if(isset($_GET['register'])){
	$accountAccount = 'Inscription';
}
else{
	$accountAccount = 'Connexion';
}

?>
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="index.php">Accueil</a>
						<a href="account.php">Mon compte</a>
						<span><?=$accountAccount?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="container" id="logRegError"></div>
	<?php if(isset($_GET['modSuccess']) || isset($_GET['delSuccess'])){
		echo '<div  class="container"><div class="alert alert-success">Succès : Le compte a été mis à jour avec succès !</div></div>';
	}
	if(isset($_GET['loginRequired'])){
		echo '<div class="container mt-3"><div class="alert alert-warning"><i class="fa fa-warning"></i> Vous devez être inscrit ou connecté pour valider votre panier.</div></div>';
	}
	if(isset($_GET['mailSend'])){
		echo '<div class="container mt-3"><div class="alert alert-success"><i class="fa fa-warning"></i> Votre lien a été envoyé sur votre boîte mail.</div></div>';
	}
	if(isset($_GET['regKey']) && isset($_GET['regEmail'])){
		$getAccountInfo = $db->query('SELECT * FROM `customers` WHERE `email`="'.$_GET['regEmail'].'" LIMIT 1')->fetch_object();
		if($getAccountInfo->regKey == $_GET['regKey']){
			$isUpd = $db->query('UPDATE `customers` SET `isValided`="1" WHERE `email`="'.$_GET['regEmail'].'"');
			if($isUpd){
				echo '<div class="container mt-3"><div class="alert alert-success"><i class="fa fa-warning"></i> Votre compte à bien été validé.</div></div>';
			}
			else{
				echo '<div class="container mt-3"><div class="alert alert-danger"><i class="fa fa-warning"></i> Votre compte n\'est pas validé car la clé de vérification est inconnue.</div></div>';
			}
		}
	}
	
	if(isset($_SESSION['web_joema']['session_user_id'])){
		echo '<div class="container mt-3">
		<div class="main-body">
			  <div class="row gutters-sm">
				<div class="col-md-4 mb-3">
				  <div class="card">
					<div class="card-body">
					  <div class="d-flex flex-column align-items-center text-center">
						  <h4>'.ucfirst($getAccInfos->firstname).' '.ucfirst($getAccInfos->lastname).'</h4>
						  <p class="text-muted font-size-sm">'.$getAccInfos->Address.' '.$getAccInfos->postal.' '.$getCityInfos->Name.'</p>
						  <button class="btn btn-primary" id="sendDisconnect">Déconnexion</button>
					  </div>
					</div>
				  </div>
				  <div class="card mt-3">
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a href="#" class="active" id="getAccountInfoBtn">Mon compte</a>
						<a href="#" id="getWalletInfoBtn">Mon porte monnaie</a>
						<a href="#" id="getAddressInfoBtn">Mes adresses</a>
						<a href="#" id="getWishlistInfoBtn">Ma liste de souhaits</a>
						<a href="#" id="getOrdersInfoBtn">Mes commandes</a>
						<a href="#" id="getAccDisconnect">Me déconnecter</a>
						<a href="#" style="background:#DB0421;margin-top:20px;color:#fff" data-bs-toggle="modal" data-bs-target="#accountDeleteModal"><i class="fa fa-remove text-center mr-1"></i> Supprimer mon compte</a>
					</div>
				  </div>
				</div>
				<div class="col-md-8">
				  <div class="card mb-3">
					<div class="card-body" id="profileDatas">';
						if($getAccInfos->isValided == 0){
							echo '<div class="alert alert-warning"><i class="fa fa-warning"></i> Attention, votre compte n\'est pas encore validé. Pour commander, la validation de l\'adresse email est obligatoire !<button type="button" class="btn btn-warning btn-sm pull-right" onclick="sendConfirmMail();return false;">Renvoyer le mail</button></div>';
						}
						echo '
					  <div class="row">
						<div class="col-sm-3"><h6 class="mb-0">Email</h6></div>
						<div class="col-sm-9 text-secondary">'.$getAccInfos->email.'</div>
					  </div>
					  <hr>
					  <div class="row">
						<div class="col-sm-3"><h6 class="mb-0">Nom</h6></div>
						<div class="col-sm-9 text-secondary">'.ucfirst($getAccInfos->firstname).'</div>
					  </div>
					  <hr>
					  <div class="row">
						<div class="col-sm-3"><h6 class="mb-0">Prénom</h6></div>
						<div class="col-sm-9 text-secondary">'.ucfirst($getAccInfos->lastname).'</div>
					  </div>
					  <hr>
					  <div class="row">
						<div class="col-sm-3"><h6 class="mb-0">Adresse</h6></div>
						<div class="col-sm-9 text-secondary">'.ucfirst($getAccInfos->address).'</div>
					  </div>
					  <hr>
					  <div class="row">
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
						<div class="col-sm-9 text-secondary">'.$getAccInfos->phone.'</div>
					  </div>
					  <hr>
					  <div class="row">
						<div class="col-sm-12">
						  <a class="btn btn-info" href="#" onclick="editProfile();return false;">Editer</a>
						</div>
					  </div>
					</div>
				  </div>

				</div>
			  </div>
			</div>
		</div>';
	}
	else if(isset($_GET['register']) && !isset($_SESSION['web_joema']['session_user_id'])){
		echo '<div class="register-login-section spad">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 offset-lg-3">
						<div class="login-form">
							<h2>Inscription</h2>
							<form action="#" id="register-form">
								<div class="group-input">
									<label for="regEmail">Adresse Email*</label>
									<input type="text" id="regEmail" name="regEmail">
								</div>
								<div class="group-input">
									<label for="pass">Votre Nom *</label>
									<input type="text" id="regLastname" name="regLastname">
								</div>
								<div class="group-input">
									<label for="pass">Votre Prénom *</label>
									<input type="text" id="regFirstname" name="regFirstname">
								</div>
								<button type="submit" class="site-btn login-btn" id="btn-submit-register">M\'inscrire</button>
							</form>
							<div class="switch-login">
								<a href="account.php" class="or-login">Ou me connecter</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>';
	}
	else if(!isset($_SESSION['web_joema']['session_user_id'])){
		echo '<div class="register-login-section spad">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 offset-lg-3">
						<div class="login-form">
							<h2>Connexion</h2>
							<div id="login-form">
								<div class="mb-3">
									<label for="logEmail">Adresse Email*</label>
									<input type="email" class="form-control" id="logEmail" name="logEmail" autofocus>
								</div>
								<div class="mb-3">
									<label for="pass">Mot de passe *</label>
									<input type="password" class="form-control" id="logPassword" name="logPassword">
								</div>
								<div class="mb-3 gi-check">
									<div class="gi-more">
										<a href="#" class="forget-pass" data-bs-toggle="modal" data-bs-target="#forgotPassModal">Mot de passe oublié</a>
									</div>
								</div>
								<button type="button" class="site-btn login-btn" id="btn-submit-login" onclick="sendLoginFromCheckout(); return false;">Me connecter</button>
							</div>
							<div class="switch-login">
								<a href="account.php?register=true" class="or-login">Ou créer un compte</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>';
	}
	require_once('includes/footer.php');
?>