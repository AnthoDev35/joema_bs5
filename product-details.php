<?php require_once('includes/header.php');

	if(isset($_GET['pId']) && $_GET['pId'] != ''){
		$getArticles = $db->query('SELECT * FROM `articles` WHERE ID="'.$_GET['pId'].'" LIMIT 1');
		$getArticle = $getArticles->fetch_object();
		echo '<input type="hidden" id="artID" value="'.$_GET['pId'].'"/>';
?>
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="index.php">Accueil</a>
						<?php if(isset($_GET['categoryID'])){
							$getCategories = $db->query('SELECT * FROM `article-categories` WHERE ID="'.$_GET['categoryID'].'" LIMIT 1');
							if($getCategories->num_rows == 1){
								$getCategorie = $getCategories->fetch_object();
								if(isset($_GET['subCategoryID'])){
									$getSubCategories = $db->query('SELECT * FROM `article-sub-categories` WHERE ID="'.$_GET['subCategoryID'].'" LIMIT 1');
									if($getSubCategories->num_rows == 1){
										$getSubCategorie = $getSubCategories->fetch_object();
										echo '<a href="categories.php?categoryID='.$getCategorie->ID.'">'.$getCategorie->Name.'</a>';
										if(isset($_GET['pId'])){
											if($getArticles->num_rows == 1){
												echo '<a href="categories.php?categoryID='.$getCategorie->ID.'&subCategoryID='.$getSubCategorie->ID.'">'.$getSubCategorie->Name.'</a>';
												echo '<span>'.$getArticle->Name.'</span>';
											}
											else{
												echo '<span>'.$getSubCategorie->Name.'</span>';
											}
										}
										else{
											echo '<span>'.$getSubCategorie->Name.'</span>';
										}
									}
								}
								else{
									echo '<span>'.$getCategorie->Name.'</span>';
								}
							}
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Product Shop Section Begin -->
    <article class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-pic-zoom">
								<?php if($getArticle->Image1 != '' || $getArticle->Image1 != 'assets/img/products/'){
									echo '<a href="'.$getArticle->Image1.'" class="venobox img-choice" title="'.$getArticle->Name.'">
										<img class="product-big-img" src="'.$getArticle->Image1.'" alt="JOeMA Boutique Rennes, Produits de mode et accessoires '.$getArticle->Name.'">
									</a>';
								}
								else{
									echo '<a href="assets/img/default-image.png" class="venobox img-choice" title="'.$getArticle->Name.'">
										<img class="product-big-img" src="assets/img/default-image.png" alt="'.$getArticle->Name.'">
									</a>';
								}
									
								?>
                            </div>
                            <div class="product-thumbs">
                                <div class="product-thumbs-track ps-slider owl-carousel">
								<?php if($getArticle->Image1 != '' && $getArticle->Image1 != 'assets/img/products/' && file_exists($getArticle->Image1)){
									echo '<div class="pt active" data-gall="productGallery" data-imgbigurl="'.$getArticle->Image1.'">
										<img src="'.$getArticle->Image1.'" class="img-fluid" alt="JOeMA Boutique Rennes, Produits de mode et accessoires '.$getArticle->Name.'">
									</div>';
								}
								if($getArticle->Image2 != '' && $getArticle->Image2 != 'assets/img/products/' && file_exists($getArticle->Image2)){
									echo '<div class="pt active" data-gall="productGallery" data-imgbigurl="'.$getArticle->Image2.'">
										<img src="'.$getArticle->Image2.'" class="img-fluid" alt="JOeMA Boutique Rennes, Produits de mode et accessoires '.$getArticle->Name.'">
									</div>';
								}
								if($getArticle->Image3 != '' && $getArticle->Image3 != 'assets/img/products/' && file_exists($getArticle->Image3)){
									echo '<div class="pt active" data-gall="productGallery" data-imgbigurl="'.$getArticle->Image3.'">
										<img src="'.$getArticle->Image3.'" class="img-fluid" alt="JOeMA Boutique Rennes, Produits de mode et accessoires '.$getArticle->Name.'">
									</div>';
								}
								if($getArticle->Image4 != '' && $getArticle->Image4 != 'assets/img/products/' && file_exists($getArticle->Image4)){
									echo '<div class="pt active" data-gall="productGallery" data-imgbigurl="'.$getArticle->Image4.'">
										<img src="'.$getArticle->Image4.'" class="img-fluid" alt="JOeMA Boutique Rennes, Produits de mode et accessoires '.$getArticle->Name.'">
									</div>';
								}
								if($getArticle->StockManagement == 0){
									if($getArticle->Stock >= 1){
										$stockArticle = $getArticle->Stock;
									}
									else{
										$stockArticle = 0;
									}
								}
								else{
									if($getArticle->StockManagement == 1){
										$stockArticle = 'Séléctionnez une couleur';
									}
									if($getArticle->StockManagement == 2){
										$stockArticle = 'Séléctionnez une taille';
									}
									if($getArticle->StockManagement == 3){
										$stockArticle = 'Séléctionnez une couleur et une taille';
									}
								}
								?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="product-details">
                                <div class="pd-title">
									<div class=" pull-right" >
										<button class="primary-btn m-1" data-bs-toggle="modal" data-bs-target="#shareProductModal"><i class="fa fa-share-alt"></i></button>
										<?php if(isset($_SESSION['web_joema']['session_user_id'])){
											$getWishlist = $db->query('SELECT * FROM `customers_wishlist` WHERE `CustomerID`="'.$_SESSION['web_joema']['session_user_id'].'" AND `ProductID`="'.$getArticle->ID.'"');
											if($getWishlist->num_rows == 1){
												echo '<button class="primary-btn m-1" style="color:#ff0000" onclick="delArtWishList('.$getArticle->ID.')"><i class="fa fa-heart"></i></button>';
											}
											else{
												echo '<button class="primary-btn m-1" onclick="addArtWishList('.$getArticle->ID.')"><i class="fa fa-heart"></i></button>';
											}
										}
										else{
											echo '<button class="primary-btn m-1" onclick="addArtWishList('.$getArticle->ID.')"><i class="fa fa-heart"></i></button>';
										}
										?> 
									</div>
                                    <h3><?=$getArticle->Name?></h3>
                                </div>
                                <div class="pd-desc">
                                    <p><?=UrlDecode($getArticle->Description)?></p>
                                    <h4><?php if($getArticle->ReducedPrice != '' && $getArticle->ReducedPrice != '0') echo $getArticle->ReducedPrice.'€ <span>'.$getArticle->NormalPrice.'€</span>'; else { echo $getArticle->NormalPrice.'€';}?></h4>
								</div>
								<?php if($getArticle->StockManagement == 1){
									$getStockColorManagers = $db->query('SELECT * FROM `article-option-colors` WHERE `ArticleID`="'.$_GET['pId'].'"');
									if($getStockColorManagers->num_rows >= 1){
										echo '<div class="pd-color">
										<h6>Couleur :</h6>
										<div class="pd-color-choose">';
											while($getStockColorManager = $getStockColorManagers->fetch_object()){
												echo '<div class="cc-item">
													<input type="hidden" id="size-0" name="size" value="0">
													<input type="hidden" id="setColorID" name="setColorID" value="0"/>
													<input type="radio" id="color-'.$getStockColorManager->ID.'" name="color" value="'.$getStockColorManager->ID.'" '; if($getStockColorManager->Stock == 0){ echo 'disabled'; } echo '>
													<label for="color-'.$getStockColorManager->ID.'"><span '; if($getStockColorManager->Stock == 0){ echo 'class="disabled"'; } echo ' style="background-color: #'.$getStockColorManager->Color.'"><i class="fa fa-check"></i></span></label>
												</div>';
											}
										echo '</div>
									</div>';
									}
								}
								else if($getArticle->StockManagement == 2){
									$getStockSizeManagers = $db->query('SELECT * FROM `article-option-sizes` WHERE `ArticleID`="'.$_GET['pId'].'"');
									if($getStockSizeManagers->num_rows >= 1){
										echo '<div class="pd-size">
											<div class="pd-size-choose">
												<h6>Taille :</h6>';
												while($getStockSizeManager = $getStockSizeManagers->fetch_object()){
													echo '<div class="sc-item">
														<input type="hidden" id="color-0" name="color" value="0">
														<input type="hidden" id="setSizeID" name="setSizeID" value="0"/>
														<input type="radio" id="size-'.$getStockSizeManager->ID.'" name="size" value="'.$getStockSizeManager->ID.'" '; if($getStockSizeManager->Stock == 0){ echo 'disabled'; } echo '>
														<label for="size-'.$getStockSizeManager->ID.'"><span '; if($getStockSizeManager->Stock == 0){ echo 'class="disabled"'; } echo '>'.$getStockSizeManager->ShortName.'</span></label>
													</div>';
												}
											echo '</div>
										</div>';
									}
								}
								else if($getArticle->StockManagement == 3){
									$getStockColorSizesGrpColors = $db->query('SELECT * FROM `article-option-colors-and-sizes` WHERE `ArticleID`="'.$_GET['pId'].'" GROUP BY `Color`');
									if($getStockColorSizesGrpColors->num_rows >= 1){
										$availableColors = '';
										while($getStockColorSizesGrpColor = $getStockColorSizesGrpColors->fetch_object()){
											$availableColors .= '<div class="cc-item">
												<input type="radio" id="color-'.$getStockColorSizesGrpColor->Color.'" name="color" value="'.$getStockColorSizesGrpColor->Color.'" '; if($getStockColorSizesGrpColor->Stock == 0){ $availableColors .= 'disabled'; } $availableColors .= '>
												<label for="color-'.$getStockColorSizesGrpColor->Color.'"><span '; if($getStockColorSizesGrpColor->Stock == 0){ $availableColors .= 'class="disabled"'; } $availableColors .= ' style="background-color: #'.$getStockColorSizesGrpColor->Color.'"><i class="fa fa-check"></i></span></label>
											</div>';
										}
									}
									$getStockColorSizesGrpSizes = $db->query('SELECT * FROM `article-option-colors-and-sizes` WHERE `ArticleID`="'.$_GET['pId'].'" GROUP BY `SizeName`');
									$availableSizes = '';
									if($getStockColorSizesGrpSizes->num_rows >= 1){
										$availableSizes = '';
										while($getStockColorSizesGrpSize = $getStockColorSizesGrpSizes->fetch_object()){
											$availableSizes .= '<div class="sc-item">
												<input type="radio" id="size-'.$getStockColorSizesGrpSize->SizeName.'" name="size" value="'.$getStockColorSizesGrpSize->SizeName.'" '; if($getStockColorSizesGrpSize->Stock == 0){ $availableSizes .= 'disabled'; } $availableSizes .= '>
												<label for="size-'.$getStockColorSizesGrpSize->SizeName.'"><span '; if($getStockColorSizesGrpSize->Stock == 0){ $availableSizes .= 'class="disabled"'; } $availableSizes .= '>'.$getStockColorSizesGrpSize->SizeShortName.'</span></label>
											</div>';
										}
									}
									echo '<div class="pd-color">
										<h6>Couleur :</h6>
										<input type="hidden" id="setColorID" name="setColorID" value="0"/>
										<div class="pd-color-choose">'.$availableColors.'</div>
									</div>
									<div class="pd-size">
										<h6>Taille :</h6>
										<input type="hidden" id="setSizeID" name="setSizeID" value="0"/>
										<div class="pd-size-choose">'.$availableSizes.'</div>
									</div>';
								} ?>
								<div class="mb-3">
                                    <h6>Stock disponible : <span class="badge badge-joema" id="stockArticle"><?=$stockArticle?></span></h6>
								</div>
								<div class="row d-flex align-item-center justify-content-center">
									<div class="col-4">
										<div class="input-group">
											<input type="hidden" id="buyMaxQty" value="<?=$stockArticle?>"/>
											<input type="number" min="1" id="buyArtQty" name="buyArtQty" class="form-control input-number" value="1">
										</div>
									</div>
									<div class="col-8">
										<button class="primary-btn pd-cart" onclick="addArticleToCart(<?=$getArticle->ID?>); return false;">Ajouter au panier</button>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
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
			<?php if(isset($_GET['categoryID'])){
				$artQuery = 'SELECT * FROM `articles` WHERE `CategorieID`= "'.$_GET['categoryID'].'" AND `ID` != "'.$getArticle->ID.'" LIMIT 8';
				if(isset($_GET['subCategoryID'])){
					$artQuery = 'SELECT * FROM `articles` WHERE `SubCategorieID`="'.$_GET['subCategoryID'].'" AND `CategorieID`= "'.$_GET['categoryID'].'" AND `ID` != "'.$getArticle->ID.'" LIMIT 8';
				}
				$getProductLinks = $db->query($artQuery);
				if($getProductLinks->num_rows >= 1){
					while($getProductLink = $getProductLinks->fetch_object()){
						echo '<div class="col-lg-3 col-sm-6">
							<div class="product-item">
								<div class="pi-pic">
									<a href="product-details.php?categories=true&categoryID='.$getProductLink->CategorieID.'&pId='.$getProductLink->ID.'">
										<img src="'.$getProductLink->Image1.'" alt="JOeMA Boutique, Articles de mode et accessoires - '.ucfirst($getProductLink->Name).'">
									</a>
								</div>
								<div class="pi-text">
									<a href="product-details.php?categories=true&categoryID='.$getProductLink->CategorieID.'&pId='.$getProductLink->ID.'">
										<h5>'.ucfirst($getProductLink->Name).'</h5>';
										if($getProductLink->ReducedPrice != ''){
											echo '<div class="product-price">'.$getProductLink->ReducedPrice.'€ <span>'.$getProductLink->NormalPrice.'€</span></div>';
										}
										else{
											echo '<div class="product-price">'.$getProductLink->NormalPrice.'€ </div>';
										}
									echo '</a>
								</div>
							</div>
						</div>';
					}
				}
			}
			?>
            </div>
        </div>
    </div>
    <!-- Related Products Section End -->

<?php }
	else{
			echo '<div class="container">
				<div class="row">
					<div class="col-lg-12" style=" text-align:center; padding:50px;">
						<h4>Article introuvable !</h4>
					</div>
				</div>
			</div>';
	}
	require_once('includes/footer.php');
?>