<?php session_start();
	include_once("../core/functions.php");
	$system = new System;
	$system->db = $db;
	
	if(empty($_SESSION['adm_joema']['session_auth'])){
		header('Location:login.php?isLogged=no');
	}

	if(isset($_SESSION['adm_joema']['session_user_id'])){
		$accs = $db->query('SELECT * FROM `accounts` WHERE id="'.$_SESSION['adm_joema']['session_user_id'].'"');
		$acc = $accs->fetch_object();
	}
	else
		header("Location: login.php?isLogged=no");

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="ArcaniaFr">
    <title>JoeMa'Admin - Tableau de bord</title>
    <link href="assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="assets/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link href="assets/css/theme.css" rel="stylesheet" media="all">
    <link href="assets/css/bootstrap-multiselect.min.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.php">
                            <img src="assets/images/joemadmin-logo.png" alt="Joema tableau de bord" class="img-fluid" width="150px"/>
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
						<li><h4>Général</h4></li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active';?>"><a href="index.php"><i class="fa fa-tachometer-alt"></i>Tableau de bord</a></li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'users.php') echo 'active';?>"><a href="users.php"><i class="fa fa-user"></i>Gestion des utilisateurs</a></li>
                        <li class="has-sub <?php if(basename($_SERVER['PHP_SELF']) == 'orders.php') echo 'active';?>">
                            <a class="js-arrow has-dropdown" href="#"><i class="fa fa-tasks"></i>Commandes</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list" <?php if(basename($_SERVER['PHP_SELF']) == 'orders.php') echo 'style="display:block;"';?>>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'orders.php') echo 'class="active"';?>><a href="orders.php">Gérer les commandes</a></li>
                            </ul>
                        </li>
						<li><h4>Gestion du site</h4></li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'shipments.php') echo 'active';?>"><a href="shipments.php"><i class="fa fa-shipping-fast"></i>Gestion des transports</a></li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'category.php') echo 'active';?>"><a href="category.php"><i class="fa fa-file-text"></i>Gestion des catégories</a></li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'payment-methods.php') echo 'active';?>"><a href="payment-methods.php"><i class="fa fa-euro"></i>Gestion des moyens de paiement</a></li>
                                                
                        <li class="has-sub <?php if(basename($_SERVER['PHP_SELF']) == 'articles.php' || basename($_SERVER['PHP_SELF']) == 'add_article.php') echo 'active';?>">
                            <a class="js-arrow" href="#"><i class="fa fa-list-alt"></i>Gestion des articles</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list" <?php if(basename($_SERVER['PHP_SELF']) == 'articles.php' || basename($_SERVER['PHP_SELF']) == 'add_article.php') echo 'style="display:block;"';?>>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'articles.php') echo 'class="active"';?>><a href="articles.php">Gérer les articles</a></li>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'add_article.php') echo 'class="active"';?>><a href="add_article.php">Ajouter un article</a></li>
                            </ul>
                        </li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'colors.php') echo 'active';?>"><a href="colors.php"><i class="fa fa-tachometer-alt"></i>Gestion des couleurs</a></li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'sizes.php') echo 'active';?>"><a href="sizes.php"><i class="fa fa-tachometer-alt"></i>Gestion des tailles</a></li>
                        <li class="has-sub <?php if(basename($_SERVER['PHP_SELF']) == 'carrousels.php' || basename($_SERVER['PHP_SELF']) == 'add_carrousel.php' || basename($_SERVER['PHP_SELF']) == 'mod_carrousel.php') echo 'active';?>">
                            <a class="js-arrow" href="#"><i class="fa fa-list-alt"></i>Gestion des carrousels</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list" <?php if(basename($_SERVER['PHP_SELF']) == 'carrousels.php' || basename($_SERVER['PHP_SELF']) == 'add_carrousel.php' || basename($_SERVER['PHP_SELF']) == 'mod_carrousel.php') echo 'style="display:block;"';?>>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'carrousels.php') echo 'class="active"';?>><a href="carrousels.php">Gérer les carrousels</a></li>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'add_carrousels.php') echo 'class="active"';?>><a href="add_carrousels.php">Ajouter un carrousel</a></li>
                            </ul>
                        </li>
                        
						<li><h4>Service client</h4></li>
                        <li class="has-sub <?php if(basename($_SERVER['PHP_SELF']) == 'customers.php') echo 'active';?>">
                            <a class="js-arrow" href="#"><i class="fa fa-users"></i>Comptes clients</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list" <?php if(basename($_SERVER['PHP_SELF']) == 'customers.php') echo 'style="display:block;"';?>>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'customers.php') echo 'class="active"';?>><a href="customers.php">Gérer les comptes clients</a></li>
                            </ul>
                        </li>
                        
                        <li class="has-sub <?php if(basename($_SERVER['PHP_SELF']) == 'maillers.php' || basename($_SERVER['PHP_SELF']) == 'send_mail.php') echo 'active';?>">
                            <a class="js-arrow" href="#"><i class="fa fa-envelope"></i>Gestion des mails</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list" <?php if(basename($_SERVER['PHP_SELF']) == 'maillers.php' || basename($_SERVER['PHP_SELF']) == 'send_mail.php') echo 'style="display:block;"';?>>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'maillers.php') echo 'class="active"';?>><a href="maillers.php">Gérer les mails</a></li>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'send_mail.php') echo 'class="active"';?>><a href="send_mail.php">Écrire un mail</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <center><img src="assets/images/joemadmin-logo.png" alt="joemadmin" class="img-fluid" width="150px"/></center>
                </a>
            </div>
            <div class="menu-sidebar__content">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
						<li><h4>Général</h4></li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active';?>"><a href="index.php"><i class="fa fa-tachometer"></i>Tableau de bord</a></li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'users.php') echo 'active';?>"><a href="users.php"><i class="fa fa-user"></i>Gestion des utilisateurs</a></li>
                        <li class="has-sub <?php if(basename($_SERVER['PHP_SELF']) == 'orders.php') echo 'active';?>">
                            <a class="js-arrow " href="#"><i class="fa fa-tasks"></i>Commandes</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" <?php if(basename($_SERVER['PHP_SELF']) == 'orders.php') echo 'style="display:block;"';?>>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'orders.php') echo 'class="active"';?>><a href="orders.php">Gérer les commandes</a></li>
                            </ul>
                        </li>
						<li><h4>Gestion du site</h4></li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'shipments.php') echo 'active';?>"><a href="shipments.php"><i class="fa fa-id-card"></i>Gestion des transports</a></li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'category.php') echo 'active';?>"><a href="category.php"><i class="fa fa-file-text"></i>Gestion des catégories</a></li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'payment-methods.php') echo 'active';?>"><a href="payment-methods.php"><i class="fa fa-euro"></i>Gestion des moyens de paiement</a></li>
                        
                        <li class="has-sub <?php if(basename($_SERVER['PHP_SELF']) == 'articles.php' || basename($_SERVER['PHP_SELF']) == 'add_article.php') echo 'active';?>">
                            <a class="js-arrow" href="#"><i class="fa fa-list-alt"></i>Gestion des articles</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" <?php if(basename($_SERVER['PHP_SELF']) == 'articles.php' || basename($_SERVER['PHP_SELF']) == 'add_article.php') echo 'style="display:block;"';?>>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'articles.php') echo 'class="active"';?>><a href="articles.php">Gérer les articles</a></li>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'add_article.php') echo 'class="active"';?>><a href="add_article.php">Ajouter un article</a></li>
                            </ul>
                        </li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'colors.php') echo 'active';?>"><a href="colors.php"><i class="fa fa-tint"></i>Gestion des couleurs</a></li>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'sizes.php') echo 'active';?>"><a href="sizes.php"><i class="fa fa-tag"></i>Gestion des tailles</a></li>
                        <li class="has-sub <?php if(basename($_SERVER['PHP_SELF']) == 'carrousels.php' || basename($_SERVER['PHP_SELF']) == 'add_carrousel.php' || basename($_SERVER['PHP_SELF']) == 'mod_carrousel.php') echo 'active';?>">
                            <a class="js-arrow" href="#"><i class="fa fa-file-image-o"></i>Gestion des carrousels</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list" <?php if(basename($_SERVER['PHP_SELF']) == 'carrousels.php' || basename($_SERVER['PHP_SELF']) == 'add_carrousel.php' || basename($_SERVER['PHP_SELF']) == 'mod_carrousel.php') echo 'style="display:block;"';?>>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'carrousels.php') echo 'class="active"';?>><a href="carrousels.php">Gérer les carrousels</a></li>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'add_carrousels.php') echo 'class="active"';?>><a href="add_carrousel.php">Ajouter un carrousel</a></li>
                            </ul>
                        </li>
						<li><h4>Service client</h4></li>
                        <li class="has-sub <?php if(basename($_SERVER['PHP_SELF']) == 'customers.php') echo 'active';?>">
                            <a class="js-arrow" href="#"><i class="fa fa-users"></i>Comptes clients</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" <?php if(basename($_SERVER['PHP_SELF']) == 'customers.php') echo 'style="display:block;"';?>>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'customers.php') echo 'class="active"';?>><a href="customers.php">Gérer les comptes clients</a></li>
                            </ul>
                        </li>
                        
                        <li class="has-sub <?php if(basename($_SERVER['PHP_SELF']) == 'gift_certificates.php' || basename($_SERVER['PHP_SELF']) == 'add_gift_certificate.php') echo 'active';?>">
                            <a class="js-arrow" href="#"><i class="fa fa-users"></i>Chèques cadeaux</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" <?php if(basename($_SERVER['PHP_SELF']) == 'gift_certificates.php' || basename($_SERVER['PHP_SELF']) == 'add_gift_certificate.php') echo 'style="display:block;"';?>>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'gift_certificates.php') echo 'class="active"';?>><a href="gift_certificates.php">Gérer les chèques cadeaux</a></li>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'add_gift_certificate.php') echo 'class="active"';?>><a href="add_gift_certificate.php">Ajouter un chèque cadeau</a></li>
                            </ul>
                        </li>
                        
                        <li class="has-sub <?php if(basename($_SERVER['PHP_SELF']) == 'maillers.php' || basename($_SERVER['PHP_SELF']) == 'send_mail.php') echo 'active';?>">
                            <a class="js-arrow" href="#"><i class="fa fa-envelope"></i>Gestion des mails</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" <?php if(basename($_SERVER['PHP_SELF']) == 'maillers.php' || basename($_SERVER['PHP_SELF']) == 'send_mail.php') echo 'style="display:block;"';?>>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'maillers.php') echo 'class="active"';?>><a href="maillers.php">Gérer les mails</a></li>
                                <li <?php if(basename($_SERVER['PHP_SELF']) == 'send_mail.php') echo 'class="active"';?>><a href="send_mail.php">Écrire un mail</a></li>
                            </ul>
                        </li>
						<li><p>Copyright © 2022 Arcaniafr. All rights reserved.</p></li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <div class="header-button">
                                <div class="noti-wrap">
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-comment-more"></i>
                                        <!--<span class="quantity">1</span>-->
                                        <div class="mess-dropdown js-dropdown">
                                            <div class="mess__title">
                                                <p>You have 2 news message</p>
                                            </div>
                                            <div class="mess__item">
                                                <div class="image img-cir img-40">
                                                    <img src="assets/images/icon/avatar-06.jpg" alt="Michelle Moreno" />
                                                </div>
                                                <div class="content">
                                                    <h6>Michelle Moreno</h6>
                                                    <p>Have sent a photo</p>
                                                    <span class="time">3 min ago</span>
                                                </div>
                                            </div>
                                            <div class="mess__item">
                                                <div class="image img-cir img-40">
                                                    <img src="assets/images/icon/avatar-04.jpg" alt="Diane Myers" />
                                                </div>
                                                <div class="content">
                                                    <h6>Diane Myers</h6>
                                                    <p>You are now connected on message</p>
                                                    <span class="time">Yesterday</span>
                                                </div>
                                            </div>
                                            <div class="mess__footer">
                                                <a href="#">View all messages</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-email"></i>
                                        <!--<span class="quantity">1</span>-->
                                        <div class="email-dropdown js-dropdown">
                                            <div class="email__title">
                                                <p>You have 3 New Emails</p>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="assets/images/icon/avatar-06.jpg" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, 3 min ago</span>
                                                </div>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="assets/images/icon/avatar-05.jpg" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, Yesterday</span>
                                                </div>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="assets/images/icon/avatar-04.jpg" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, April 12,,2018</span>
                                                </div>
                                            </div>
                                            <div class="email__footer">
                                                <a href="#">See all emails</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-notifications"></i>
                                        <!--<span class="quantity">3</span>-->
                                        <div class="notifi-dropdown js-dropdown">
                                            <div class="notifi__title">
                                                <p>You have 3 Notifications</p>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c1 img-cir img-40">
                                                    <i class="zmdi zmdi-email-open"></i>
                                                </div>
                                                <div class="content">
                                                    <p>You got a email notification</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c2 img-cir img-40">
                                                    <i class="zmdi zmdi-account-box"></i>
                                                </div>
                                                <div class="content">
                                                    <p>Your account has been blocked</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c3 img-cir img-40">
                                                    <i class="zmdi zmdi-file-text"></i>
                                                </div>
                                                <div class="content">
                                                    <p>You got a new file</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__footer">
                                                <a href="#">All notifications</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <img src="assets/images/icon/avatar-01.jpg" alt="John Doe" />
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                        <img src="assets/images/icon/avatar-01.jpg" alt="John Doe" />
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#">john doe</a>
                                                    </h5>
                                                    <span class="email">johndoe@example.com</span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="#"><i class="fa fa-user"></i>Mon compte</a>
												</div>
                                                <div class="account-dropdown__item">
                                                    <a href="../index.php" target="_blank"><i class="fa fa-share"></i>Accéder au site</a>
												</div>
                                            </div>
                                            <div class="account-dropdown__footer"><a href="#" id="sendDisconnect"><i class="zmdi zmdi-power"></i>Déconnexion</a></div>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->
