<?php session_start();
include_once("../core/functions.php");
$system = new System;
$system->db = $db;

if(isset($_POST['addWishlistItem']) && isset($_POST['wishlistItemID'])){
	$getItems = $db->query('SELECT * FROM `articles` WHERE `ID`="'.$_POST['wishlistItemID'].'" LIMIT 1');
	if($getItems->num_rows == 1){
		$getItem = $getItems->fetch_object();
		if(isset($_SESSION['web_joema']['session_user_id'])){
			if($system->addAccountWishlist($getItem->ID)){
				echo json_encode(array('success' => 1));
			}
			else{
				echo json_encode(array('error' => "Erreur: Impossible d'ajouter cet article dans vos 'coup-de-coeur'!"));
			}
		}
		else{
			echo json_encode(array('error' => "Erreur: Vous devez être connecté pour utiliser la liste de souhait!"));
		}
	}
	else{
		echo json_encode(array('error' => "Erreur: L'article n'existe pas!"));
	}
}

if(isset($_POST['delWishlistItem']) && isset($_POST['wishlistItemID'])){
	$getItems = $db->query('SELECT * FROM `articles` WHERE `ID`="'.$_POST['wishlistItemID'].'" LIMIT 1');
	if($getItems->num_rows == 1){
		if(isset($_SESSION['web_joema']['session_user_id'])){
			if($system->delAccountWishlist($_POST['wishlistItemID']) == 'success'){
				echo json_encode(array('success' => 1));
			}
			else{
				echo json_encode(array('error' => "Erreur : Impossible de supprimer l'article de vos 'coup-de-coeur'!"));
			}
		}
		else{
			if($system->delArtWishlist($_POST['wishlistItemID'])){
				echo json_encode(array('success' => 1));
			}
			else{
				echo json_encode(array('error' => "Erreur : Impossible de supprimer l'article de vos 'coup-de-coeur'!"));
			}
		}
	}
	else{
		echo json_encode(array('error' => "Erreur : L'article n'existe pas!"));
	}
}

if(isset($_POST['getAllWishListItems'])){
	$wishlist = '';
	if(isset($_SESSION['web_joema']['session_user_id'])){
		$getWishlists = $db->query('SELECT * FROM `customers_wishlist` WHERE `CustomerID`="'.$_SESSION['web_joema']['session_user_id'].'"');
		if($getWishlists->num_rows == 0){
			$wishlist .= '<div class="select-items"><table><tbody><tr><td colspan="6"><center>Votre liste de coup de coeur est vide ! </center></td></tr>';
		}
		else{
			$wishlist .= '<div class="select-items"><table><tbody>';
			while($getWishlist = $getWishlists->fetch_object()){
				$getArticles = $db->query('SELECT * FROM `articles` WHERE `ID`="'.$getWishlist->ProductID.'"');
				$getArticle = $getArticles->fetch_object();
				$wishlist .= '<tr>
					<td class="si-pic"><a href="product-details.php?categories=true&pId='.$getArticle->ID.'"><img src="'.$getArticle->Image1.'" alt="" width="50px"></a></td>
					<td class="si-text">
						<div class="product-selected">
							<h6><a href="product-details.php?categories=true&pId='.$getArticle->ID.'">'.$getArticle->Name.'</a></h6>
							<p>'.number_format($getArticle->NormalPrice, 2).'€</p>
						</div>
					</td>
					<td class="si-close">
						<a href="#" onclick="delArtWishList('.$getArticle->ID.')"><i class="ti-close"></i></a>
					</td>
				</tr>';
			}
			$wishlist .= '</tbody></table></div>
			<div class="select-button">
				<a href="account.php" class="primary-btn view-card">Voir ma liste</a>
			</div>';
		}
	}
	else{
		$wishlist .= '<div class="select-items"><table><tbody><tr><td colspan="6"><center>Vous devez être connecté pour utiliser la liste de coup de coeur ! </center></td></tr>';
	}
	echo json_encode(array('data' => $wishlist));
}

if(isset($_POST['getCountWishlistItems'])){
	if(isset($_SESSION['web_joema']['session_user_id'])){
		$getWishlists = $db->query('SELECT * FROM `customers_wishlist` WHERE `CustomerID`="'.$_SESSION['web_joema']['session_user_id'].'"');
		if($getWishlists->num_rows <= 0)
			echo '0';
		else
			echo $getWishlists->num_rows;
	}
	else{
		echo '0';
	}
}

?>