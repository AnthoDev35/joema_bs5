<?php 
if(isset($_GET['isDisconnect'])){
	session_start();
	session_destroy();
	if(isset($_SESSION['adm_joema']['session_auth'])){
		echo 1;
	}
	else{
		echo 'Une erreur c\'est produite pendant la déconnexion !';
	}
}



?>