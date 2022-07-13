
    <!-- Footer Section Begin -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer-left">
                        <div class="footer-logo">
                            <a href="#"><img src="assets/img/joema-vente-accessoire-de-mode.png" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1">
                    <div class="footer-widget">
                        <h5>Information</h5>
                        <ul>
                            <li><a href="conditions.php">Conditions générales</a></li>
                            <li><a href="legals.php">Mentions légales</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-widget">
                        <h5>Mon compte</h5>
                        <ul>
                            <li><a href="account.php">Mon Account</a></li>
                            <li><a href="cart.php">Mon panier</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="newslatter-item">
                        <h5>Newsletters</h5>
                        <p>Recevez nos nouveautés et nos offres par email.</p>
                        <form action="#" class="subscribe-form">
                            <input type="text" placeholder="Email">
                            <button type="button">Souscrire</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-reserved">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright-text">
							Copyright &copy;<script>document.write(new Date().getFullYear());</script> JOeMA All rights reserved
                        </div>
                        <div class="payment-pic">
                            <img src="assets/img/payment-method.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->
	<div class="modal fade" id="passwordRequiredModal" tabindex="-1" role="dialog" aria-labelledby="passwordRequiredModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="passwordRequiredModalLabel">Mot de passe obligatoire</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner votre mot de passe !</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="site-btn login-btn" data-bs-dismiss="modal">Fermer</button>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="accountDeleteModal" tabindex="-1" role="dialog" aria-labelledby="accountDeleteModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header bg-modal-custom">
					<h5 class="modal-title" id="bookIndisponibleDateLabel">Suppression du compte</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<center>
						<h5>Êtes-vous sûr de vouloir supprimer votre compte ?</h5>
						
						<div class="col-md-6">
							<div class="form-group account-info-title">
								<label>Confirmez votre mot de passe</label>
								<input type="password" id="delAccPassword" name="delAccPassword" class="form-control" value="" autofocus>
								<small id="checkDelVerifyPassword" style="color:red; display:none;">Le mot de passe est obligatoire!</small>
							</div>
						</div>
					</center>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
					<button type="button" class="btn btn-danger" onclick="setAccountDelete()">Supprimer mon compte</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header bg-modal-custom">
					<h5 class="modal-title">Erreur</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="errorDetails">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
				</div>
			</div>
		</div>
	</div>
	<div id="notification" style="display:none">
		<div class="row">
			<div class="col-md-3 col-sm-12 button-fixed">
				<div class="p-3 pb-4 bg-custom text-white">
					<div class="row">
						<div class="col-10">
							<h2 id="notif-title">Panier d'achat</h2>
						</div>
					</div>
					<p id="notif-text"></p>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="forgotPassModal" tabindex="-1" role="dialog" aria-labelledby="forgotPassModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header bg-modal-custom">
					<h5 class="modal-title"><i class="fa fa-address-card"></i> Récupération de compte JOeMA</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="forgotpass-details">
					<div class="container">
						<div class="row mb-2">
							<div class="alert alert-warning">Un nouveau mot de passe vous sera envoyé par Email si les informations renseignées correspondent à un compte JOeMA.</div>
						</div>
						<div class="row mb-2">
							<div class="col-md-6">
								<label class="mb-0">Votre Nom</label>
								<input type="text" class="form-control" id="forgotLastname" name="forgotLastname" placeholder="Nom"/>
							</div>
							<div class="col-md-6">
								<label class="mb-0">Votre Prénom</label>
								<input type="email" class="form-control" id="forgotFirstname" name="forgotFirstname" placeholder="Prénom"/>
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-md-12">
								<label class="mb-0">Votre Email</label>
								<input type="email" class="form-control" id="forgotEmail" name="forgotEmail" placeholder="contact@exemple.com"/>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
					<button type="button" class="primary-btn" onclick="sendForgotPassMail();return false;">Envoyer</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="shareProductModal" tabindex="-1" role="dialog" aria-labelledby="shareProductModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header bg-modal-custom">
					<h5 class="modal-title"><i class="fa fa-share-alt"></i> Partagez la page par email</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="shareProductDetails">
					<div class="container">
						<div class="row">
							<label class="mb-0">Votre Nom & Prénom</label>
							<input type="text" class="form-control" id="shareEmailName" placeholder="Karine dupont"/>
						</div>
						<div class="row mt-3">
							<label class="mb-0">Email du destinataire</label>
							<input type="email" class="form-control" id="shareEmailReceiver" placeholder="contact@exemple.com"/>
						</div>
						<input type="hidden" id="shareEmailLink" value="https://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>"/>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
					<button type="button" class="primary-btn" onclick="sendShareMail();return false;">Envoyer</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="firstConnectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="firstConnectModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header bg-modal-custom">
					<h5 class="modal-title"><i class="fa fa-address-card"></i> Première connection sur votre expace client JOeMA</h5>
				</div>
				<div class="modal-body">
					<div class="container">
						<div class="row mb-2">
							<div  id="forgotPassDetails">
								<div class="alert alert-warning">Bienvenue sur JOeMA Boutique, veuillez renseigner un mot de passe pour continuer.</div>
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-md-6">
								<label class="mb-0">Mot de passe</label>
								<input type="password" class="form-control" id="firstPassword" name="firstPassword" placeholder="Mot de passe"/>
							</div>
							<div class="col-md-6">
								<label class="mb-0">Mot de passe (confirmation)</label>
								<input type="password" class="form-control" id="firstRePassword" name="firstRePassword" placeholder="Mot de passe"/>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="primary-btn" onclick="sendDefinePassword();return false;">Envoyer</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="addToCartModal" tabindex="-1" role="dialog" aria-labelledby="addToCartModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" id="addToCartDetails"></div>
		</div>
	</div>
	<div class="modal fade" id="getMondialRelayModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="getMondialRelayModalModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<div id="mondialRelayDetails"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="primary-btn" data-bs-dismiss="modal">Valider mon point relais</button>
				</div>
			</div>
		</div>
	</div>
	<a href="#" class="back-to-top"><i class="fa fa-arrow-up"></i></a>
    <!-- Js Plugins -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
	<script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/vendor/venobox/venobox.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
