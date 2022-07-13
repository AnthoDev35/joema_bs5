<?php session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="ArcaniaFr">
    <title>JOeMA'Admin</title>
    <link href="assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
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
</head>
<body class="animsition">
    <div class="page-wrapper-login">
        <div class="page-content--bge5">
            <div class="container">
				<div class="login-logo">
					<a href="#">
						<img src="assets/images/joemadmin-logo.png" alt="JOeMA'Admin">
					</a>
				</div>
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-form">
							<?php if(isset($_GET['isLogged']) && $_GET['isLogged'] == 'no') echo '<div class="alert alert-danger"><center><h6><i class="fa fa-warning"></i> Vous devez être authentifié pour accéder à cette zone.</h6></center></div>'; 
							 if(isset($_GET['errorData'])) echo '<div class="alert alert-danger"><center><h6>'.$_GET['errorData'].'</h6></center></div>'; ?>
                            <form id="adm-login-form" method="post">
                                <div class="form-group">
                                    <label>Identifiant</label>
                                    <input class="au-input au-input--full" type="text" name="logUsername" placeholder="Identifiant" autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Mot de passe</label>
                                    <input class="au-input au-input--full" type="password" name="logPassword" placeholder="Mot de passe">
                                </div>
                                <div class="login-checkbox">
                                    <label>
                                        <a href="forget-pass.php">Mot de passe oublié?</a>
                                    </label>
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Connexion</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body"><center><div class="modalLoader"></div><h6>Chargement...<h6></center></div>
			</div>
		</div>
	</div>
    <script src="assets/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="assets/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <script src="assets/vendor/slick/slick.min.js"></script>
    <script src="assets/vendor/wow/wow.min.js"></script>
    <script src="assets/vendor/animsition/animsition.min.js"></script>
    <script src="assets/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="assets/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="assets/vendor/counter-up/jquery.counterup.min.js"></script>
    <script src="assets/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="assets/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="assets/vendor/select2/select2.min.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>
<!-- end document-->