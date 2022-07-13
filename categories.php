<?php require_once('includes/header.php');
$article_query = '';
	if(isset($_GET['s'])){
		$article_query .= 'SELECT * FROM `articles` WHERE `Name` LIKE "'.$_GET['s'].'%" OR  `Reference` LIKE "'.$_GET['s'].'%"';
	}
	else if(isset($_GET['categoryID'])){
		$article_query .= "SELECT * FROM `articles` WHERE `CategorieID`='".$_GET['categoryID']."' AND ";
		if(isset($_GET['s'])){
			$article_query .= '`Name` LIKE "'.$_GET['s'].'%" OR  `Reference` LIKE "'.$_GET['s'].'%"';
		}
		if(isset($_GET['subCategoryID'])){
			$article_query .= "`SubCategorieID`='".$_GET['subCategoryID']."' AND ";
		}
		if(isset($_GET['color']['0'])){
			$request = '';
			$colors = $_GET['color'];
			foreach ($colors AS $color)
			{
				if ($request != '')
					$request .= ' OR ';

				$request .= "`Colors` LIKE '%".$color."%'";
			}

			$article_query .= $request." AND ";
		}
		if(isset($_GET['artSize']['0'])){
			$request = '';
			$sizes = $_GET['artSize'];
			foreach ($sizes AS $size) {
				if ($request != '')
					$request .= ' OR ';

				$request .= "`Sizes` LIKE '%".$size."%'";
			}

			$article_query .= $request." AND ";
		}
		if(isset($_GET['minAmount'])){
			$article_query .= " `NormalPrice` >= ".$_GET['minAmount']." AND ";
		}
		if(isset($_GET['maxAmount'])){
			$article_query .= " `NormalPrice` <= ".$_GET['maxAmount']." AND ";
		}
		$article_query .= " IsActive='1'"; // end query with this !
		
		if(isset($_GET['sortBy'])){
			if($_GET['sortBy']=="all"){
				$article_query .= " ORDER BY `ID` DESC";
			}
			if($_GET['sortBy']=="priceAsc"){
				$article_query .= " ORDER BY `NormalPrice` ASC";
			}
			if($_GET['sortBy']=="priceDesc"){
				$article_query .= " ORDER BY `NormalPrice` DESC";
			}
		}
		else{
			$article_query .= " ORDER BY `ID` ASC";
		}
	}
	$per_page = 12;
	$articlesCount = $db->query($article_query)->num_rows;
	$last_page = ceil($articlesCount/$per_page);
	if(isset($_GET['page'])) { $p = $_GET['page']; } else { $p = 1; }
	if($p < 1) { $p = 1; } elseif($p > $last_page) { $p = $last_page; }
	$limit = 'LIMIT ' .($p - 1) * $per_page .',' .$per_page;
	$article_query .= " $limit";
	$queryResult = $db->query($article_query);
?>
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="index.php">Accueil</a>
						<?php if(isset($_GET['categoryID'])){
							$getCategories = $db->query('SELECT * FROM `article-categories` WHERE ID="'.$_GET['categoryID'].'" LIMIT 1');
							if($getCategories->num_rows == 1){
								$getCategorie = $getCategories->fetch_object();
								if(isset($_GET['subCategoryID'])){
									$getSubCategories = $db->query('SELECT * FROM `article-sub-categories` WHERE ID="'.$_GET['subCategoryID'].'" LIMIT 1');
									if($getSubCategories->num_rows == 1){
										echo '<a href="categories.php?categoryID='.$getCategorie->ID.'">'.$getCategorie->Name.'</a>';
										$getSubCategorie = $getSubCategories->fetch_object();
										echo '<span>'.$getSubCategorie->Name.'</span>';
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
<?php

	$url = $_SERVER["PHP_SELF"];
	$url .= '?categories=true';
	
	if(isset($_GET['s'])){
		$url .= '&s='.$_GET['s'];
	}
	if(isset($_GET['categoryID'])){
		$url .= '&categoryID='.$_GET['categoryID'];
	}
	if(isset($_GET['subCategoryID'])){
		$url .= '&subCategoryID='.$_GET['subCategoryID'];
	}
	if(isset($_GET['colorID']['0'])){
		$url .= '&colorID%5B%5D='.$_GET['colorID']['0'];
	}
	if(isset($_GET['colorID']['1'])){
		$url .= '&colorID%5B%5D='.$_GET['colorID']['1'];
	}
	if(isset($_GET['colorID']['2'])){
		$url .= '&colorID%5B%5D='.$_GET['colorID']['2'];
	}
	if(isset($_GET['colorID']['3'])){
		$url .= '&colorID%5B%5D='.$_GET['colorID']['3'];
	}
	if(isset($_GET['colorID']['4'])){
		$url .= '&colorID%5B%5D='.$_GET['colorID']['4'];
	}
	if(isset($_GET['colorID']['5'])){
		$url .= '&colorID%5B%5D='.$_GET['colorID']['5'];
	}
	if(isset($_GET['colorID']['6'])){
		$url .= '&colorID%5B%5D='.$_GET['colorID']['6'];
	}
	if(isset($_GET['colorID']['7'])){
		$url .= '&colorID%5B%5D='.$_GET['colorID']['7'];
	}
	if(isset($_GET['colorID']['8'])){
		$url .= '&colorID%5B%5D='.$_GET['colorID']['8'];
	}
	if(isset($_GET['colorID']['9'])){
		$url .= '&colorID%5B%5D='.$_GET['colorID']['9'];
	}
	if(isset($_GET['minPrice'])){
		$url .= '&minPrice='.$_GET['minPrice'];
	}
	if(isset($_GET['maxPrice'])){
		$url .= '&maxPrice='.$_GET['maxPrice'];
	}
?>
    <!-- Product Shop Section Begin -->
    <section class="product-shop spad">
        <div class="">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
				<form method="get" action="categories.php">
				<?php if(isset($_GET['categoryID'])){ echo '<input type="hidden" name="categoryID" value="'.$_GET['categoryID'].'">';}
				 if(isset($_GET['subCategoryID'])){ echo '<input type="hidden" name="subCategoryID" value="'.$_GET['subCategoryID'].'">';}
				 if(isset($_GET['page'])){ echo '<input type="hidden" name="page" value="'.$_GET['page'].'">';}
				?>
                    <div class="filter-widget">
                        <h4 class="fw-title">Prix</h4>
                        <div class="filter-range-wrap">
                            <div class="range-slider">
                                <div class="price-input">
                                    <input type="text" id="minAmount" name="minAmount" value="<?php if(isset($_GET['minAmount'])) echo $_GET['minAmount'];?>">
                                    <input type="text" id="maxAmount" name="maxAmount" value="<?php if(isset($_GET['maxAmount'])) echo $_GET['maxAmount'];?>"> €
                                </div>
                            </div>
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="0" data-max="500">
                                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                <span tabindex="<?php if(isset($_GET['minAmount'])) echo $_GET['minAmount']; else echo '0';?>" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                <span tabindex="<?php if(isset($_GET['maxAmount'])) echo $_GET['maxAmount']; else echo '0';?>" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                            </div>
                        </div>
                    </div>
                    <div class="filter-widget">
                        <h4 class="fw-title">Couleurs</h4>
                        <div class="fw-color-choose">
							<select class="form-select" name="color[]">
								<option value="-1">Toutes les couleurs</option>
								<?php $getColors = $db->query('SELECT * FROM `article-option-colors`');
								if($getColors->num_rows >= 1){
									while($getColor = $getColors->fetch_object()){
										echo '<option value="'.$getColor->ID.'"'; if(isset($_GET['color%5B%5D']) && $_GET['color%5B%5D']==$getColor->ID) echo 'selected="selected"'; echo '>'.ucfirst($getColor->Name).'</option>';
									}
								}
								else{
									echo '<option value="0">Aucune couleur disponible</option>';
								}
								?>
							</select>
                        </div>
                    </div>
                    <div class="filter-widget">
                        <h4 class="fw-title">Tailles</h4>
                        <div class="fw-size-choose">
							<select class="form-select" name="artSize[]">
								<option value="-1">Toutes les tailles</option>
								<?php $getSizes = $db->query('SELECT * FROM `article-option-sizes`');
								if($getSizes->num_rows >= 1){
									while($getSize = $getSizes->fetch_object()){
										echo '<option value="'.$getSize->ID.'"'; if(isset($_GET['artSize%5B%5D']) && $_GET['artSize%5B%5D']==$getSize->ID) echo 'class="active"'; echo '>'.$getSize->ShortName.'</option>';
									}
								}
								else{
									echo '<option value="0">Aucune taille disponible</option>';
								}
								?>
							</select>
                        </div>
                    </div>
                    <a href="categories.php?<?php if(isset($_GET['categoryID'])){ echo 'categoryID='.$_GET['categoryID'];}
					if(isset($_GET['subCategoryID'])){ echo '&subCategoryID='.$_GET['subCategoryID'];}?>" class="btn btn-danger">Réinitialiser</a>
                    <button type="submit" class="btn btn-warning">Filtrer</button>
					</form>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="product-show-option">
                        <div class="row">
                            <div class="col-lg-7 col-md-7">
                                <div class="select-option">
								<div class="dropdown">
									<button class="btn btn-full dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" >
									<?php if(isset($_GET['sortBy']) && ($_GET['sortBy']=='all') || !isset($_GET['sortBy']))
										echo 'Tous les articles ';
									else if(isset($_GET['sortBy']) && ($_GET['sortBy']=='priceDesc'))
										echo 'Les moins chère ';
									else if(isset($_GET['sortBy']) && ($_GET['sortBy']=='priceAsc'))
										echo 'Les plus chère ';
									else
										echo 'Tous les articles ';
									
									echo '<span class="caret"></span></button>
										<ul class="dropdown-menu sortby" aria-labelledby="dropdownMenuButton">
											<li><a href="'.$url.'&sortBy=all"><i class="glyphicon ';if(isset($_GET['sortBy']) && ($_GET['sortBy']=='all') || !isset($_GET['sortBy'])) echo 'glyphicon-ok'; echo '"></i> Tous les articles</a></li>
											<li><a href="'.$url.'&sortBy=priceDesc"><i class="glyphicon ';if(isset($_GET['sortBy']) && ($_GET['sortBy']=='priceDesc')) echo 'glyphicon-ok'; echo '"></i> Les moins chère</a></li>
											<li><a href="'.$url.'&sortBy=priceAsc"><i class="glyphicon ';if(isset($_GET['sortBy']) && ($_GET['sortBy']=='priceAsc')) echo 'glyphicon-ok'; echo '"></i> Les plus chère</a></li>
											</ul>
									</div>';?>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex justify-content-end">
							<p><?=$articlesCount?> articles trouvés</p>
							</div>
                        </div>
                    </div>
                    <div class="product-list">
                        <div class="row">
							<?php if($articlesCount >= 1){
								while($getArticle = $queryResult->fetch_object()){
									$isWishList = false;
									if(isset($_SESSION['web_joema']['session_user_id'])){
										$getWishlists = $db->query('SELECT * FROM `customers_wishlist` WHERE `CustomerID`="'.$_SESSION['web_joema']['session_user_id'].'" AND ProductID="'.$getArticle->ID.'"');
										if($getWishlists->num_rows == 1){
											$isWishList = true;
										}
									}
									echo '<div class="col-lg-4">
										<div class="product-item">
											<div class="pi-pic">
												<a href="product-details.php';
													$urlBeforeArtDetail = '?categories=true';
													
													if(isset($_GET['s'])){
														$urlBeforeArtDetail .= '&s='.$_GET['s'];
													}
													if(isset($_GET['categoryID'])){
														$urlBeforeArtDetail .= '&categoryID='.$_GET['categoryID'];
													}
													if(isset($_GET['subCategoryID'])){
														$urlBeforeArtDetail .= '&subCategoryID='.$_GET['subCategoryID'];
													}
													if(isset($_GET['colorID']['0'])){
														$urlBeforeArtDetail .= '&colorID%5B%5D='.$_GET['colorID']['0'];
													}
													if(isset($_GET['colorID']['1'])){
														$urlBeforeArtDetail .= '&colorID%5B%5D='.$_GET['colorID']['1'];
													}
													if(isset($_GET['colorID']['2'])){
														$urlBeforeArtDetail .= '&colorID%5B%5D='.$_GET['colorID']['2'];
													}
													if(isset($_GET['colorID']['3'])){
														$urlBeforeArtDetail .= '&colorID%5B%5D='.$_GET['colorID']['3'];
													}
													if(isset($_GET['colorID']['4'])){
														$urlBeforeArtDetail .= '&colorID%5B%5D='.$_GET['colorID']['4'];
													}
													if(isset($_GET['colorID']['5'])){
														$urlBeforeArtDetail .= '&colorID%5B%5D='.$_GET['colorID']['5'];
													}
													if(isset($_GET['colorID']['6'])){
														$urlBeforeArtDetail .= '&colorID%5B%5D='.$_GET['colorID']['6'];
													}
													if(isset($_GET['colorID']['7'])){
														$urlBeforeArtDetail .= '&colorID%5B%5D='.$_GET['colorID']['7'];
													}
													if(isset($_GET['colorID']['8'])){
														$urlBeforeArtDetail .= '&colorID%5B%5D='.$_GET['colorID']['8'];
													}
													if(isset($_GET['colorID']['9'])){
														$urlBeforeArtDetail .= '&colorID%5B%5D='.$_GET['colorID']['9'];
													}
													if(isset($_GET['minPrice'])){
														$urlBeforeArtDetail .= '&minPrice='.$_GET['minPrice'];
													}
													if(isset($_GET['maxPrice'])){
														$urlBeforeArtDetail .= '&maxPrice='.$_GET['maxPrice'];
													}
													$urlBeforeArtDetail .= '&pId='.$getArticle->ID;
												echo $urlBeforeArtDetail.'">
													<img src="'.$getArticle->Image1.'" alt="'.$getArticle->Name.'">
												</a>';
												if($getArticle->ReducedPrice != ''){
													echo '<div class="sale pp-sale">Promo</div>';
												}
												echo '<div class="icon">';
												echo '<a href="#" class="mr-2" data-bs-toggle="modal" data-bs-target="#shareProductModal"><i class="fa fa-share-alt"></i></a>';
												if($isWishList == true){
													echo '<a href="#" onclick="delArtWishList('.$getArticle->ID.')"><i class="icon_heart active"></i></a>';
												}
												else{
													echo '<a href="#" onclick="addArtWishList('.$getArticle->ID.')"><i class="icon_heart_alt"></i></a>';
												}
												echo '</div>
											</div>
											<div class="pi-text">
												<a href="product-details.php'.$urlBeforeArtDetail.'">
													<h5>'.$getArticle->Name.'</h5>
													<div class="product-price">';
													if($getArticle->ReducedPrice != '0' && $getArticle->ReducedPrice != ''){
														echo $getArticle->ReducedPrice.' € <span>'.$getArticle->NormalPrice.'€</span>';
													}
													else{
														echo $getArticle->NormalPrice.'€';
													}
													echo '</div>
												</a>
											</div>
										</div>
									</div>';
								}
							}
							else{
								echo '<h6 style="text-align:center; font-weight:bold;">Aucun articles disponible.</h6>';
							}
							?>
                            
                        </div>
					
			<nav>
			  <ul class="pagination justify-content-center">
				<?php
				if(($last_page >= $p) && $last_page > 1) {
					for($i=1; $i<=$last_page; $i++) {
						$pagination = '';
						if($i == $p) {
							echo '<li class="page-item '; if(isset($_GET['page']) && $_GET['page'] == $i){ echo 'active';} else if(!isset($_GET['page']) && $i == 1){ echo 'active';} echo '"><a href="categories.php?categories=true';
							
							if(isset($_GET['s'])){
								$pagination .= '&s='.$_GET['s'];
							}
							if(isset($_GET['categoryID'])) {
								$pagination .= "&categoryID=".$_GET['categoryID'];
							}
							if(isset($_GET['subCategoryID'])) {
								$pagination .= "&subCategoryID=".$_GET['subCategoryID'];
							}
							if(isset($_GET['colorID']['0'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['0'];
							}
							if(isset($_GET['colorID']['1'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['1'];
							}
							if(isset($_GET['colorID']['2'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['2'];
							}
							if(isset($_GET['colorID']['3'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['3'];
							}
							if(isset($_GET['colorID']['4'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['4'];
							}
							if(isset($_GET['colorID']['5'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['5'];
							}
							if(isset($_GET['colorID']['6'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['6'];
							}
							if(isset($_GET['colorID']['7'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['7'];
							}
							if(isset($_GET['colorID']['8'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['8'];
							}
							if(isset($_GET['colorID']['9'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['9'];
							}
							if(isset($_GET['minPrice'])){
								$pagination .= '&minPrice='.$_GET['minPrice'];
							}
							if(isset($_GET['maxPrice'])){
								$pagination .= '&maxPrice='.$_GET['maxPrice'];
							}
							if(isset($_GET['sortBy'])){
								$pagination .= '&sortBy='.$_GET['sortBy'];
							}
							$pagination .= '&page='.$i.'" class="page-link" >'.$i.'</a></li>';
							echo $pagination;
						} else {
							echo '<li class="page-item '; if(isset($_GET['page']) && $_GET['page'] == $i){ echo 'active';} else if(!isset($_GET['page']) && $i == 1){ echo 'active';} echo '"><a href="categories.php?categories=true';
							
							if(isset($_GET['s'])){
								$pagination .= '&s='.$_GET['s'];
							}
							if(isset($_GET['categoryID'])) {
								$pagination .= "&categoryID=".$_GET['categoryID'];
							}
							if(isset($_GET['subCategoryID'])) {
								$pagination .= "&subCategoryID=".$_GET['subCategoryID'];
							}
							if(isset($_GET['colorID']['0'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['0'];
							}
							if(isset($_GET['colorID']['1'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['1'];
							}
							if(isset($_GET['colorID']['2'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['2'];
							}
							if(isset($_GET['colorID']['3'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['3'];
							}
							if(isset($_GET['colorID']['4'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['4'];
							}
							if(isset($_GET['colorID']['5'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['5'];
							}
							if(isset($_GET['colorID']['6'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['6'];
							}
							if(isset($_GET['colorID']['7'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['7'];
							}
							if(isset($_GET['colorID']['8'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['8'];
							}
							if(isset($_GET['colorID']['9'])){
								$pagination .= '&colorID%5B%5D='.$_GET['colorID']['9'];
							}
							if(isset($_GET['minPrice'])){
								$pagination .= '&minPrice='.$_GET['minPrice'];
							}
							if(isset($_GET['maxPrice'])){
								$pagination .= '&maxPrice='.$_GET['maxPrice'];
							}
							if(isset($_GET['sortBy'])){
								$pagination .= '&sortBy='.$_GET['sortBy'];
							}
							$pagination .= '&page='.$i.'" class="page-link" >'.$i.'</a></li>';
							echo $pagination;
						}
					}
				}
				?>
				</ul>
			</div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->

<?php

require_once('includes/footer.php');
	
?>