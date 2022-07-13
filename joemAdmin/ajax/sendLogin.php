<?php session_start();
include_once("../../core/functions.php");
$system = new System;
$system->db = $db;

if(isset($_POST['logUsername']) && isset($_POST['logPassword'])){
	if(!empty($_POST['logUsername'])){
		if(!empty($_POST['logPassword'])){
			$getAccountInfos = $db->query('SELECT * FROM `accounts` WHERE `username`="'.$_POST['logUsername'].'" OR `email`="'.$_POST['logUsername'].'"');
			if($getAccountInfos->num_rows == 1){
				$getAccountInfo = $getAccountInfos->fetch_object();
				$encrypt_password = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256",strtoupper(hash("sha256", strtoupper($getAccountInfo->username)).":".strtoupper($_POST['logPassword']))))))));
				if($encrypt_password == $getAccountInfo->password){
					$_SESSION['adm_joema']['session_auth'] = true;
					$_SESSION['adm_joema']['session_username'] = $getAccountInfo->username;
					$_SESSION['adm_joema']['session_user_id'] = $getAccountInfo->ID;
					echo 1;
				}
				else{
					echo 'Les données de connexions sont incorrects !';
				}
			}
			else{
				echo 'Les données de connexions sont incorrects !';
			}
		}
		else{
			echo 'Le mot de passe est obligatoire !';
		}
	}
	else{
		echo 'Le nom d\'utilisateur est obligatoire !';
	}
}



?>