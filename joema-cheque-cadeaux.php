<?php require_once('includes/header.php'); 

?>
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="index.php">Accueil</a>
						<span>Générer un chèque cadeaux</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-pic-zoom">
								<?php if(file_exists('assets/img/Joema-boutique-cheques-cadeaux-specimen.png')){
									echo '<a href="assets/img/Joema-boutique-cheques-cadeaux-specimen.png" class="venobox img-choice" title="Générateur de chèque cadeaux JOeMA">
										<img class="product-big-img" src="assets/img/Joema-boutique-cheques-cadeaux-specimen.png" alt="JOeMA Boutique Rennes, articles de mode et accessoires générateur de chèque cadeaux JOeMA">
									</a>';
								}
								else{
									echo '<a href="assets/img/default-image.png" class="venobox img-choice" title="générateur de chèque cadeaux JOeMA">
										<img class="product-big-img" src="assets/img/default-image.png" alt="générateur de chèque cadeaux JOeMA">
									</a>';
								}
									
								?>
                            </div>
                            <div class="product-thumbs">
                                <div class="product-thumbs-track ps-slider owl-carousel">
								<?php if(file_exists('assets/img/Joema-boutique-cheques-cadeaux-specimen.png')){
									echo '<div class="pt active" data-gall="productGallery" data-imgbigurl="assets/img/Joema-boutique-cheques-cadeaux-specimen.png">
										<img src="assets/img/Joema-boutique-cheques-cadeaux-specimen.png" alt="JOeMA Boutique Rennes, articles de mode et accessoires assets/img/Joema-boutique-cheques-cadeaux-specimen.jpg">
									</div>';
								}?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="product-details">
                                <div class="pd-title mb-5">
                                    <h3>Chèque cadeaux JOeMA</h3>
                                </div>
                                <div class="pd-desc">
                                    <p>Générez vous-même votre chèque cadeaux valable dans toute la boutique en ligne "JOeMA".</br>Les chèques cadeaux sont valables 6 mois à partir de la date d'achat.</br>
									Fixez vous-même le montant et recevez-le directement par email après le paiement.</br>Vous pouvez aussi choisir une autre adresse email pour l'offrir à vos proches.</p>
                                    <h4>À partir de 20€</h4>
                                </div>
									<label>Montant du chèque cadeaux</label> 
								<div class="input-group mb-3">
									<input type="text" class="form-control" placeholder="20" id="giftCertAmount" name="giftCertAmount">
									<div class="input-group-append">
										<button class="btn secondary-btn" type="button" onclick="addGiftCertificateToCard(''); return false;">Ajouter au panier</button><!--@TODO CHEQUE CADEAU -->
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->

    <!-- Related Products Section End -->
    <div class="related-products spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Ces articles pourraient vous intéresser</h2>
                    </div>
                </div>
            </div>
            <div class="row">
			<?php $getDiscountProducts = $db->query('SELECT * FROM `articles` WHERE `ReducedPrice`<=`NormalPrice` AND `ReducedPrice` != "";');
			if($getDiscountProducts->num_rows >= 1){
				while($getDiscountProduct = $getDiscountProducts->fetch_object()){
					$getCategorie = $db->query('SELECT * FROM `article-categories` WHERE `ID`="'.$getDiscountProduct->CategorieID.'" LIMIT 1')->fetch_object();
					echo '<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<div class="pi-pic">
								<a href="product-details.php?categories=true&categoryID='.$getDiscountProduct->CategorieID.'&pId='.$getDiscountProduct->ID.'">
									<img src="'.$getDiscountProduct->Image1.'" alt="JOeMA Boutique Rennes, Produits de mode et accessoires ">
								</a>
							</div>
							<div class="pi-text">
								<div class="catagory-name">'.ucfirst($getCategorie->Name).'</div>
								<a href="#">
									<h5>'.ucfirst($getDiscountProduct->Name).'</h5>
								</a>
								<div class="product-price">'.$getDiscountProduct->ReducedPrice.'€ <span>'.$getDiscountProduct->NormalPrice.'€</span>
								</div>
							</div>
						</div>
					</div>';
				}
			}
			?>
            </div>
        </div>
    </div>
    <!-- Related Products Section End -->

<?php
	require_once('includes/footer.php');
?>