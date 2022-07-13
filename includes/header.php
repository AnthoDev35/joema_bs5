<?php session_start();
	include_once("core/functions.php");
	$system = new System;
	$system->db = $db;
	
	if(basename($_SERVER['PHP_SELF']) == "account.php"){
		$joemaWebsiteTitle = "JOeMA - Mon compte JOeMA";
		if(isset($_SESSION['web_joema']['session_user_id'])){
			$getAccountInfos = $db->query('SELECT * FROM `customers` WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'" LIMIT 1');
			if($getAccountInfos->num_rows == 1){
				$getAccountInfo = $getAccountInfos->fetch_object();
				if($getAccountInfo->firstConnect == 1){
					echo '<input type="hidden" id="isFirstConnect" value="1"/>';
				}
				else{
					echo '<input type="hidden" id="isFirstConnect" value="0"/>';
				}
			}
		}
	}
	else if(basename($_SERVER['PHP_SELF']) == "joema-cheque-cadeaux.php"){
		$joemaWebsiteTitle = "JOeMA - Générateur de chèques cadeaux JOeMA";
	}
	else if(basename($_SERVER['PHP_SELF']) == "product-details.php"){
		if(isset($_GET['pId'])){
			$getProductNames = $db->query('SELECT * FROM `articles` WHERE `ID`="'.$_GET['pId'].'"');
			if($getProductNames->num_rows == 1){
				$getProductName = $getProductNames->fetch_object();
				$getCategorieNames = $db->query('SELECT * FROM `article-categories` WHERE `ID`="'.$_GET['categoryID'].'"');
				if($getCategorieNames->num_rows == 1){
					$getCategorieName = $getCategorieNames->fetch_object();
					$joemaWebsiteTitle = "JOeMA Boutique - Catégorie ".$getCategorieName->Name." / ".$getProductName->Name;
				}
			}
		}
	}
	else if(basename($_SERVER['PHP_SELF']) == "categories.php"){
		if(isset($_GET['categoryID'])){
			$getCategorieNames = $db->query('SELECT * FROM `article-categories` WHERE `ID`="'.$_GET['categoryID'].'"');
			if($getCategorieNames->num_rows == 1){
				$getCategorieName = $getCategorieNames->fetch_object();
				$joemaWebsiteTitle = "JOeMA Boutique - Catégorie ".$getCategorieName->Name;
			}
		}
	}
	else if(basename($_SERVER['PHP_SELF']) == "checkout.php"){
		$joemaWebsiteTitle = "JOeMA - Commander chez JOeMA Boutique";
		if(isset($_SESSION['web_joema']['session_user_id'])){
			$getAccountInfos = $db->query('SELECT * FROM `customers` WHERE `ID`="'.$_SESSION['web_joema']['session_user_id'].'" LIMIT 1');
			if($getAccountInfos->num_rows == 1){
				$getAccountInfo = $getAccountInfos->fetch_object();
				if($getAccountInfo->firstConnect == 1){
					echo '<input type="hidden" id="isFirstConnect" value="1"/>';
				}
				else{
					echo '<input type="hidden" id="isFirstConnect" value="0"/>';
				}
			}
		}
	}
	else if(basename($_SERVER['PHP_SELF']) == "cart.php"){
		$joemaWebsiteTitle = "JOeMA - Mon panier JOeMA Boutique";
	}
	else{
		$joemaWebsiteTitle = "JOeMA Boutique - E-boutique d’accessoires de mode choisis pour finaliser vos tenues et affirmer votre style, peu importe les occasions.";
	}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$joemaWebsiteTitle?></title>
	<meta name="description" content="JOeMA Boutique vous propose des articles de maroquinerie et accessoires de mode minutieusement choisis pour finaliser vos tenues et affirmer votre style. Des sacs à mains, des bijoux, des chaussures pour les petits budgets vous sont proposés tout au long de l'année à Rennes en Ille-et-Vilaine">
	<meta property="og:site_name" content="JOeMA™">
	<meta property="og:url" content="https://www.joema.fr/">
	<meta property="og:title" content="JOeMA | Maroquinerie & accessoires de mode">
	<meta property="og:type" content="website">
	<meta property="og:description" content="JOeMA Boutique vous propose des articles de maroquinerie et accessoires de mode minutieusement choisis pour finaliser vos tenues et affirmer votre style. Des sacs à mains, des bijoux, des chaussures pour les petits budgets vous sont proposés tout au long de l'année à Rennes en Ille-et-Vilaine">
    <link rel="icon" type="image/png" href="assets/img/favico.png">
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favico.ico">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="assets/vendor/venobox/venobox.css" type="text/css">
    <link rel="stylesheet" href="assets/vendor/swiper/swiper-bundle.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
	<link rel="stylesheet" href="assets/css/new_header.css" type="text/css">
</head>

<body onload="initWebsite();">
    <!-- Page Preloader 
    <div id="preloder">
        <div class="loader"></div>
    </div>-->
	<div id="cartToast" class="toast fade ">
		<div class="toast-header">
		  <strong class="mr-auto">Panier</strong>
		</div>
		<div class="toast-body" id="cartToastText">Article ajouté à votre panier!</div>
	  </div>
    <!-- Header Section Begin -->
    
    <div class="Offcanvas_menu">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="canvas_open">
                        <a href="javascript:void(0)"><i class="fa fa-bars"></i></a>
                    </div>
                    <div class="Offcanvas_menu_wrapper">
                        <div class="canvas_close">
                              <a href="javascript:void(0)"><i class="fa fa-close"></i></a>  
                        </div>
                        <div class="home_logo">
							<img src="assets/img/joema-vente-accessoire-de-mode.png" class="img-fluid"/>
                        </div>
                        <div id="menu" class="text-left ">
                            <ul class="offcanvas_main_menu">
								<li <?php if(basename($_SERVER['REQUEST_URI']) == 'index.php'){ echo 'class="menu-item-has-children active"';} else{'class="menu-item-has-children"';}?>><a href="index.php">Accueil</a></li>
								<?php $getCategories = $db->query('SELECT * FROM `article-categories`');
								if($getCategories->num_rows >= 1){
									while($getCategorie = $getCategories->fetch_object()){
										$getArticles = $db->query('SELECT * FROM `articles` WHERE `CategorieID`="'.$getCategorie->ID.'"');
										if($getArticles->num_rows >= 1){
											echo '<li '; if(basename($_SERVER['REQUEST_URI']) == 'categories.php?categoryID='.$getCategorie->ID || isset($_GET['categoryID']) && $_GET['categoryID'] == $getCategorie->ID){ echo 'class="menu-item-has-children active"'; } else { echo 'class="menu-item-has-children"'; } echo '><a href="categories.php?categoryID='.$getCategorie->ID.'">'.ucfirst($getCategorie->Name).'</a>';
												$getSubCategories = $db->query('SELECT * FROM `article-sub-categories` WHERE CategorieID = "'.$getCategorie->ID.'"');
												if($getSubCategories->num_rows >= 1){
													echo '<ul class="sub-menu">';
														while($getSubCategorie = $getSubCategories->fetch_object()){
															echo '<li><a href="categories.php?categoryID='.$getCategorie->ID.'&subCategoryID='.$getSubCategorie->ID.'">'.ucfirst($getSubCategorie->Name).'</a></li>';
														}
													echo '</ul>';
												}
											echo '</li>';
										}
									}
								}
								?>
								<li <?php if(basename($_SERVER['REQUEST_URI']) == 'joema-cheque-cadeaux.php') echo 'class="active"';?>><a href="joema-cheque-cadeaux.php">Chèques cadeaux</a></li>
								<li><a href="#" class="show-searchbar" onclick="showSearchBar();"><i class="fa fa-search"></i></a></li>
                            </ul>
                        </div>
                        <div class="Offcanvas_footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Offcanvas menu area end-->
    
     <!--header area start-->
    <header class="header_area">
        <!--header middel start-->
        <div class="header_middel">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-4">
                        <div class="home_logo">
                            <a href="index.php"><img src="assets/img/joema-vente-accessoire-de-mode.png" alt=""></a>
                        </div>
						<div class="home_subtitle">
							E-boutique d’accessoires de mode minutieusement choisis pour finaliser vos tenues et affirmer votre style, peu importe les occasions.
						</div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="middel_right">
                            <div class="account_link">
                                <a href="#"><i class="fa fa-user"></i></a>
                                <!--mini account-->
                                 <div class="mini_account">
									<div class="logo_header">
										<a href="index.php"><img src="assets/img/joema-vente-accessoire-de-mode.png" alt=""></a>
									</div>
                                    <div class="account_close">
                                        <div class="account_text">
                                            <h3>Mon compte</h3>
                                        </div>
                                        <div class="mini_account_close">
                                            <a href="javascript:void(0)"><i class="fa fa-close"></i></a>
                                        </div>
                                    </div>
									<div class="headAccount">
										<?php if(isset($_SESSION['web_joema']['session_user_id'])){
											echo '<div class="col-12">
												<ul>
													<li><a href="account.php?Mon-Compte-JOeMA=true">Mon compte</a></li>
													<li><a href="account.php?Carnet-Adresses-JOeMA=true">Mes adresses</a></li>
													<li><a href="account.php?Porte-Monnaie-JOeMA=true">Mon porte monnaie</a></li>
													<li><a href="account.php?Mes-Commandes-JOeMA=true">Mes commandes</a></li>
													<li><a href="account.php?Mes-Coup-De-Coeurs-JOeMA=true">Mes coup-de-coeurs</a></li>
													<li><a href="#" id="sendHeaderDisconnect">Me déconnecter</a></li>
												</ul>
											</div>';
										}
										else{
											echo '<div class="col-12 active" id="showLoginForm">
												<form id="form-login" method="post">
													<div class="mt-3 mb-3">
														<label for="logEmail" class="form-label">Adresse email</label>
														<input type="email" class="form-control" name="logHeaderEmail" id="logHeaderEmail" placeholder="contact@exemple.com">
													</div>
													<div class="mb-3">
														<label for="logPassword" class="form-label">Mot de passe</label>
														<input type="password" class="form-control" name="logHeaderPassword" id="logHeaderPassword" placeholder="Mot de passe">
													</div>
													<div class="mb-3">
														<button type="button" class="btn btn-secondary" id="showHeaderRegister">Inscription</button>
														<button type="submit" class="btn secondary-btn" id="logHeadBtn">Connexion</button>
													</div>
												</form>
											</div>
											<div class="col-12" id="showRegisterForm">
												<form id="form-register" method="post">
													<div class="mt-3 mb-3">
														<label for="logEmail" class="form-label">Adresse email</label>
														<input type="email" class="form-control" name="regHeaderEmail" id="regHeaderEmail" placeholder="contact@exemple.com">
													</div>
													<div class="mt-3 mb-3">
														<label for="logEmail" class="form-label">Votre Nom</label>
														<input type="text" class="form-control" name="regHeaderLastname" id="regHeaderLastname" placeholder="Votre Nom">
													</div>
													<div class="mb-3">
														<label for="logPassword" class="form-label">Votre Prénom</label>
														<input type="text" class="form-control" name="regHeaderFirstname" id="regHeaderFirstname" placeholder="Votre Prénom">
													</div>
													<div class="mb-3">
														<button type="button" class="btn btn-secondary" id="showHeaderLogin">Connexion</button>
														<button type="submit" class="btn secondary-btn" >M\'inscrire</button>
													</div>
												</form>
											</div>';
										}?>
									</div>
                                    
                                </div>
                                <!--mini account end-->
                            </div>
                            <div class="heart_link">
                                <a href="#"><i class="fa fa-heart"></i></a>
                                <span class="heart_quantity count-wishlist-items">0</span>
                                <!--mini wishlist-->
                                 <div class="mini_heart">
									<div class="logo_header">
										<a href="index.php"><img src="assets/img/joema-vente-accessoire-de-mode.png" alt=""></a>
									</div>
                                    <div class="heart_close">
                                        <div class="heart_text">
                                            <h3>Mes coup-de-coeurs</h3>
                                        </div>
                                        <div class="mini_heart_close">
                                            <a href="javascript:void(0)"><i class="fa fa-close"></i></a>
                                        </div>
                                    </div>
									<div class="headWishlist">
									</div>
                                    <div class="mini_heart_footer">
                                       <div class="heart_button view_heart">
                                            <a href="cart.php">Mes coup-de-coeurs</a>
                                        </div>
                                    </div>
                                    
                                </div>
                                <!--mini cart end-->
                            </div>
                            <div class="cart_link">
                                <a href="#"><i class="fa fa-shopping-cart"></i> <span class="cart_text_quantity"></span><span class="header-cart-price"><?=$system->totalCart();?> €</span></a>
                                <span class="cart_quantity count-cart-items">0</span>
                                <!--mini cart-->
                                 <div class="mini_cart">
									<div class="logo_header">
										<a href="index.php"><img src="assets/img/joema-vente-accessoire-de-mode.png" alt=""></a>
									</div>
                                    <div class="cart_close">
                                        <div class="cart_text">
                                            <h3>Mon panier</h3>
                                        </div>
                                        <div class="mini_cart_close">
                                            <a href="javascript:void(0)"><i class="fa fa-close"></i></a>
                                        </div>
                                    </div>
									<div class="headArticleCart">
										<div class="cart_total">
											<span>Sous-total:</span>
											<span class="header-cart-price"><?=$system->totalCart();?>€</span>
										</div>
									</div>
                                    <div class="mini_cart_footer">
                                       <div class="cart_button view_cart">
                                            <a href="cart.php">Voir mon panier</a>
                                        </div>
                                        <div class="cart_button checkout">
                                            <a href="checkout.php">Commander</a>
                                        </div>
                                    </div>
                                    
                                </div>
                                <!--mini cart end-->
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <!--header middel end-->

        <!--header bottom satrt-->
        <div class="header_bottom sticky-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="main_menu_inner">
                           <div class="logo_sticky">
                               <a href="index.php"><img src="assets/img/joema-vente-accessoire-de-mode.png" alt=""></a>
                           </div>
                            <div class="main_menu">
                                <nav>  
                                    <ul>
										<li class="depart-btn">
											<i class="ti-menu"></i>
											<span>Dernière Chance</span>
											<ul class="depart-hover">
												<!-- Récupère les catégories ou sous-catégorie si il y a, des produits qui sont marqués comme dernière chance en db -->
												<?php $getProducts = $db->query('SELECT * FROM `articles` WHERE `LastChance`=1');
												if($getProducts->num_rows >= 1){
													while($getProduct = $getProducts->fetch_object()){
														echo '<li '; if(isset($_GET['pID']) && $_GET['pID'] == $getProduct->ID){ echo 'class="active"';} echo '><a href="product-details.php?categories=true&categoryID='.$getProduct->CategorieID.'&pId='.$getProduct->ID.'"><img src="'.$getProduct->Image1.'" class="img-fluid chance-img" width="80px"/><h6>'.ucfirst($getProduct->Name).'</h6><small>'; if($getProduct->ReducedPrice == ''){ echo $getProduct->NormalPrice;} else{  echo $getProduct->ReducedPrice;} echo ' €</small></a></li>';
													}
												}
												else{
													echo '<li class="active">Aucun produits pour le moment</li>';
												}
												?>
											</ul>
										</li>
										<li <?php if(basename($_SERVER['REQUEST_URI']) == 'index.php') echo 'class="active"';?>><a href="index.php">Accueil</a></li>
										<?php $getCategories = $db->query('SELECT * FROM `article-categories`');
										if($getCategories->num_rows >= 1){
											while($getCategorie = $getCategories->fetch_object()){
												$getArticles = $db->query('SELECT * FROM `articles` WHERE `CategorieID`="'.$getCategorie->ID.'"');
												if($getArticles->num_rows >= 1){
													echo '<li '; if(basename($_SERVER['REQUEST_URI']) == 'categories.php?categoryID='.$getCategorie->ID || isset($_GET['categoryID']) && $_GET['categoryID'] == $getCategorie->ID) echo 'class="active"'; echo '><a href="categories.php?categoryID='.$getCategorie->ID.'">'.ucfirst($getCategorie->Name).'</a>';
														$getSubCategories = $db->query('SELECT * FROM `article-sub-categories` WHERE CategorieID = "'.$getCategorie->ID.'"');
														if($getSubCategories->num_rows >= 1){
															echo '<ul class="sub_menu">';
															while($getSubCategorie = $getSubCategories->fetch_object()){
																echo '<li '; if(basename($_SERVER['REQUEST_URI']) == 'categories.php?categoryID='.$getCategorie->ID.'&subCategoryID='.$getSubCategorie->ID) echo 'class="active"'; echo '><a href="categories.php?categoryID='.$getCategorie->ID.'&subCategoryID='.$getSubCategorie->ID.'">'.ucfirst($getSubCategorie->Name).'</a></li>';
															}
															echo '</ul>';
														}
													echo '</li>';
												}
											}
										}
										?>
										<li <?php if(basename($_SERVER['REQUEST_URI']) == 'joema-cheque-cadeaux.php') echo 'class="active"';?>><a href="joema-cheque-cadeaux.php">Chèques cadeaux</a></li>
										<li><a href="#" class="show-searchbar" onclick="showSearchBar();"><i class="fa fa-search"></i></a></li>
                                    </ul>  
                                </nav> 
                            </div>
                        </div> 
                    </div>
                   
                </div>
            </div>
        </div>
        <!--header bottom end-->
    </header>
    <!-- Header End -->
	<div class="searchbar" id="searchbar" style="display:none;">
		<div class="container">
			<form action="categories.php" method="GET">
				<div class="input-group">
					<input type="text" class="form-control head-search-text" name="s" placeholder="Recherchez par Nom ou référence"/>
					<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
				</div>
			</form>
			<div class="search-result" style="visibility:hidden;">
				<div class="select-search">
					<ul>
					</ul>
				</div>
			</div>
		</div>
		
	</div>
	<div class="marquee">
		<span>Frais de port offert à partir de 80 euros d'achats sur JOeMA Boutique avec le code : "joema-shipping".</span>
	</div>