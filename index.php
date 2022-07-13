<?php require_once('includes/header.php');
	$getCarrousels = $db->query('SELECT * FROM `carrousels` WHERE `IsActive`=1 ORDER BY `ID` DESC');
	if($getCarrousels->num_rows >= 1){
		echo '<section class="hero-section">
			<div class="hero-items owl-carousel">';
				while($getCarrousel = $getCarrousels->fetch_object()){
					$getCategories = $db->query('SELECT * FROM `article-categories` WHERE `ID`="'.$getCarrousel->CategorieID.'"')->fetch_object();
					echo '<div class="single-hero-items set-bg" data-setbg="'.$getCarrousel->Image.'">
						<div class="container">
							<div class="row">
								<div class="col-lg-12">
									<span>'.$getCategories->Name.'</span>
									<h1>'.$getCarrousel->Title.'</h1>
									<p>'.$getCarrousel->Description.'</p>
									<!--<a href="#" class="primary-btn">Afficher l\'article</a>-->
								</div>
							</div>';
							if($getCarrousel->DiscountPct != ''){
								echo '<div class="off-card">
									<h2><span>-'.$getCarrousel->DiscountPct.'%</span></h2>
								</div>';
							}
						echo '</div>
					</div>';
				}
			echo '</div>
		</section>';
	}
	
	$getCategoryBanners = $db->query('SELECT * FROM `article-categories` WHERE `Banner`=1 LIMIT 3');
	if($getCategoryBanners->num_rows >= 1){
		echo '<section id="catslide" class="catslide">
			<div class="container" data-aos="fade-up">
				<div class="section-title">
					<h2>Nos catégories</h2>
				</div>
				<div class="catslide-slider swiper" data-aos="fade-up" data-aos-delay="100">
					<div class="swiper-wrapper">';
						while($getCategoryBanner = $getCategoryBanners->fetch_object()){
							echo '<div class="swiper-slide">
								<div class="catslide-item">
								<a href="categories.php?categoryID='.$getCategoryBanner->ID.'">
									<img src="'.$getCategoryBanner->Image.'" class="img-fluid" alt="'.ucfirst($getCategoryBanner->Name).'"/>
									<div class="services-content">
										<h3>'.ucfirst($getCategoryBanner->Name).'</h3>
									</div>
									</a>
								</div>
							</div>';
						}
					echo '</div>
					<div class="swiper-pagination"></div>
				</div>
			</div>
		</section>';
	}
	
	$getNewArticles = $db->query('SELECT * FROM `articles` WHERE `isNew`="1"');
	if($getNewArticles->num_rows >= 1){
		echo '<section id="newArticles" class="newArticles">
			<div class="container" data-aos="fade-up">
				<div class="section-title">
					<h2>Nouveaux articles sur JOeMA</h2>
				</div>
				<div class="newArticles-slider swiper" data-aos="fade-up" data-aos-delay="100">
					<div class="swiper-wrapper">';
						while($getNewArticle = $getNewArticles->fetch_object()){
							$subCategoryID = '';
							$categoryID = '';
							if($getNewArticle->CategorieID != '-100' || $getNewArticle->CategorieID != ''){
								$categoryID = $getNewArticle->CategorieID;
							}
							if($getNewArticle->SubCategorieID != '-100' || $getNewArticle->SubCategorieID != ''){
								$subCategoryID = $getNewArticle->SubCategorieID;
							}
							echo '<div class="swiper-slide">
								<div class="newArticles-item">
									<a href="product-details.php?categories=true&categoryID='.$categoryID.'&subCategoryID='.$subCategoryID.'&pId='.$getNewArticle->ID.'">
										<img src="'.$getNewArticle->Image1.'" class="img-fluid" alt="'.ucfirst($getNewArticle->Name).'"/>
										<div class="services-content">
											<h3>'.ucfirst($getNewArticle->Name).'</h3>
											<h4>'.number_format($getNewArticle->NormalPrice,2).' €</h4>
											<a href="product-details.php?categories=true&categoryID='.$categoryID.'&subCategoryID='.$subCategoryID.'&pId='.$getNewArticle->ID.'" class="btn-get-newArticle mt-3">Voir l\'article</a>
										</div>
									</a>
								</div>
							</div>';
						}
					echo '</div>
					<div class="swiper-pagination"></div>
				</div>
			</div>
		</section>';
	}
	
	$getDiscountProducts = $db->query('SELECT * FROM `articles` WHERE `ReducedPrice`<=`NormalPrice` AND `ReducedPrice` != "";');
	if($getDiscountProducts->num_rows >= 1){
		echo '<section class="women-banner spad">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="product-slider owl-carousel">';
							while($getDiscountProduct = $getDiscountProducts->fetch_object()){
								$getCategorie = $db->query('SELECT * FROM `article-categories` WHERE `ID`="'.$getDiscountProduct->CategorieID.'" LIMIT 1')->fetch_object();
								echo '<div class="product-item">
									<a href="product-details.php?categories=true&categoryID='.$getDiscountProduct->CategorieID.'&pId='.$getDiscountProduct->ID.'">
										<div class="pi-pic">
											<img src="'.$getDiscountProduct->Image1.'" alt="JOeMA Boutique Rennes, Ille-et-Vilaine, 35, Bretagne, Vente de produits de maroquinerie">
											<div class="sale">Promo</div>
										</div>
										<div class="pi-text">
											<div class="catagory-name">'.ucfirst($getCategorie->Name).'</div>
											<a href="#">
												<h5>'.ucfirst($getDiscountProduct->Name).'</h5>
											</a>
											<div class="product-price">'.$getDiscountProduct->ReducedPrice.'€ <span>'.$getDiscountProduct->NormalPrice.'€</span>
											</div>
										</div>
									</a>
								</div>';
							}
						echo '</div>
					</div>
				</div>
			</div>
		</section>';
	}
	?>
    <section class="benefits">
        <div class="container">
            <div class="benefit-items">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="assets/img/icon-1.png" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Port offert</h6>
                                <p>Commandes supérieur à 100€</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="assets/img/icon-2.png" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Vous changez d'avis?</h6>
                                <p>14 jours pour changer d'avis</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="assets/img/icon-3.png" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Paiement sécurisé</h6>
                                <p>Paiement 100% sécurisé</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php require_once('includes/footer.php');?>