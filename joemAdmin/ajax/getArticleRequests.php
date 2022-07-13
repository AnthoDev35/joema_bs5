<?php  session_start();
	include_once("../../core/functions.php");
	$system->db = $db;
	
	if(isset($_GET['getArticles']) && isset($_GET['getArticlePage'])){
		$numArticlesPage = 10;
		$getAllArticles = $db->query('SELECT * FROM `articles`');
		$numArticles = $getAllArticles->num_rows;
		$articlePages = ceil($numArticles/$numArticlesPage);
		$pageArticleNb = 1;
		$adjacents = 2;
		$lpm1 = $articlePages - 1;
		if($_GET['getArticlePage'] != '' && $_GET['getArticlePage'] != 0){
			$pageArticleNb = $_GET['getArticlePage'];
		}
		$start = ($pageArticleNb * $numArticlesPage) - $numArticlesPage;
		echo '<div class="table-responsive table-responsive-data2">
			<table class="table table-data2">
				<thead>
					<tr>
						<th class="sticky-col-head first-col">Action</th>
						<th>Dernière chance</th>
						<th>Image</th>
						<th>Référence</th>
						<th>Nom</th>
						<th>Catégorie</th>
						<th>Sous-catégorie</th>
						<th>Stock</th>
						<th>Prix normal</th>
						<th>Prix promotionnel</th>
					</tr>
				</thead>
				<tbody>';
				if($numArticles >= 1){
					$getArticles = $db->query('SELECT * FROM `articles` ORDER BY `ID` ASC LIMIT '.$start.', '.$numArticlesPage);
					while($getArticle =$getArticles->fetch_object()){
						$stockColor = '';
						$getCategorie = $db->query('SELECT * FROM `article-categories` WHERE ID="'.$getArticle->CategorieID.'" LIMIT 1')->fetch_object();
						$getSubCategorie = $db->query('SELECT * FROM `article-sub-categories` WHERE ID="'.$getArticle->SubCategorieID.'" LIMIT 1')->fetch_object();
						if($getArticle->Stock >= 2){
							$stockColor = '#00D31C';
						}
						else{
							$stockColor = '#CC2800';
						}
						echo '<tr class="tr-shadow">
							<td class="sticky-col first-col">
								<div class="table-data-feature">
									<a href="mod_article.php?articleID='.$getArticle->ID.'&page='.$pageArticleNb.'" class="item-primary" data-toggle="tooltip" data-placement="top" title="Editer"><i class="fa fa-pencil"></i></a>
									<a href="#" class="item-danger" data-toggle="tooltip" data-placement="top" onclick="getArticleDelete('.$getArticle->ID.');return false;" title="Supprimer"><i class="fa fa-trash"></i></a>';
									if($getArticle->LastChance == 0){
										echo '<a href="#" class="item-nochance" data-toggle="tooltip" data-placement="top" onclick="setArticleLastChance('.$getArticle->ID.',1);return false;" title="Activer la dernière chance"><i class="fa fa-eye"></i></a>';
									}
									else{
										echo '<a href="#" class="item-chance" data-toggle="tooltip" data-placement="top" onclick="setArticleLastChance('.$getArticle->ID.',0);return false;" title="Désactiver la dernière chance"><i class="fa fa-eye-slash"></i></a>';
									}
									if($getArticle->IsActive == 0){
										echo '<a href="#" class="item-isactive" data-toggle="tooltip" data-placement="top" onclick="setArticleIsActive('.$getArticle->ID.',1);return false;" title="Activer l\'article"><i class="fa fa-eye"></i></a>';
									}
									else{
										echo '<a href="#" class="item-isnoactive" data-toggle="tooltip" data-placement="top" onclick="setArticleIsActive('.$getArticle->ID.',0);return false;" title="Désactiver l\'article"><i class="fa fa-eye-slash"></i></a>';
									}
								echo '</div>
							</td>';
							if($getArticle->LastChance == 1)
								echo '<td><span class="status--process">Oui</span></td>';
							else
								echo '<td><span class="status--denied">Non</span></td>';
							echo '<td><img src="../'.$getArticle->Image1.'" class="img-fluid" width="50px"/></td>
							<td>'.$getArticle->Reference.'</td>
							<td>'.ucfirst($getArticle->Name).'</td>
							<td>'.ucfirst($getCategorie->Name).'</td>
							<td>'.ucfirst($getSubCategorie->Name).'</td>
							<td style="color:#fff; font-weight:bold; background: '.$stockColor.';">'.$getArticle->Stock.'</td>
							<td>'.$getArticle->NormalPrice.'€</td>';
							if($getArticle->ReducedPrice != '' || $getArticle->ReducedPrice != 0)
								$reducePrice = $getArticle->ReducedPrice.'€';
							else
								$reducePrice = '';
							echo '<td>'.$reducePrice.'</td>
						</tr>
						<tr class="spacer"></tr>';
					}
				}
				echo '</tbody>
			</table>
		</div>
		<div class="articles-pagination">
			<ul class="pagination">';
				if($articlePages > 1){   
					if ($articlePages < 7 + ($adjacents * 2)){   
						for ($i = 1; $i <= $articlePages; $i++){
							echo '<li class="page-item '; if($i == $pageArticleNb) echo 'active'; echo '"><a class="page-link" href="#" onclick="getArticlePages('.$i.'); return false;">'.$i.'</a></li>';
						}
					}
					elseif($articlePages > 5 + ($adjacents * 2)){
						if($pageArticleNb < 1 + ($adjacents * 2)){
							for ($i = 1; $i < 4 + ($adjacents * 2); $i++){
								echo '<li class="page-item '; if($i == $pageArticleNb) echo 'active'; echo '"><a class="page-link" href="#" onclick="getArticlePages('.$i.'); return false;">'.$i.'</a></li>';
							}
							echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
							echo '<li class="page-item"><a class="page-link" href="articles.php?page='.$lpm1.'">'.$lpm1.'</a></li>';
							echo '<li class="page-item"><a class="page-link" href="articles.php?page='.$articlePages.'">'.$articlePages.'</a></li>';       
						}
						elseif($articlePages - ($adjacents * 2) > $pageArticleNb && $pageArticleNb > ($adjacents * 2)){
							echo '<li class="page-item"><a class="page-link" href="articles.php?page=1">1</a></li>';
							echo '<li class="page-item"><a class="page-link" href="articles.php?page=2">2</a></li>';
							echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
							for ($i = $pageArticleNb - $adjacents; $i <= $pageArticleNb + $adjacents; $i++){
								echo '<li class="page-item '; if($i == $pageArticleNb) echo 'active'; echo '"><a class="page-link" href="#" onclick="getArticlePages('.$i.'); return false;">'.$i.'</a></li>';      
							}
							echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
							echo '<li class="page-item"><a class="page-link" href="articles.php?page='.$lpm1.'">'.$lpm1.'</a></li>';
							echo '<li class="page-item"><a class="page-link" href="articles.php?page='.$articlePages.'">'.$articlePages.'</a></li>';       
						}
						else
						{
							echo '<li class="page-item"><a class="page-link" href="articles.php?page=1">1</a></li>';
							echo '<li class="page-item"><a class="page-link" href="articles.php?page=2">2</a></li>';
							echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
							for ($i = $articlePages - (2 + ($adjacents * 2)); $i <= $articlePages; $i++){
								echo '<li class="page-item '; if($i == $pageArticleNb) echo 'active'; echo '"><a class="page-link" href="#" onclick="getArticlePages('.$i.'); return false;">'.$i.'</a></li>';      
							}
						}
					}
				}
			echo '</ul>
		</div>';
		
	}
	
	$artCategorie = '';
	$artSubCategorie = '';
	$artName = '';
	$artRef = '';
	$artDescription = '';
	$artStock = '';
	$artShipment = '';
	$artWeight = '';
	$artIsNew = '';
	$artColors = '';
	$artSizes = '';
	$isLastChance = '';
	$artIsActive = '';
	$artNormalPrice = '';
	$artReducePrice = '';
	
	if(isset($_POST['addArticle'])){
		if(isset($_POST['artCategorie']))
			$artCategorie = $_POST['artCategorie'];
		if(isset($_POST['artSubCategorie']))
			$artSubCategorie = $_POST['artSubCategorie'];
		if(isset($_POST['artName']))
			$artName = addslashes($_POST['artName']);
		if(isset($_POST['artRef']))
			$artRef = $_POST['artRef'];
		if(isset($_POST['artDescription']))
			$artDescription = addslashes($_POST['artDescription']);
		if(isset($_POST['artImageRenamed1']) && $_POST['artImageRenamed1'] != 'assets/img/products/')
			$artImage1 = $_POST['artImageRenamed1'];
		if(isset($_POST['artImageRenamed2']) && $_POST['artImageRenamed2'] != 'assets/img/products/')
			$artImage2 = $_POST['artImageRenamed2'];
		if(isset($_POST['artImageRenamed3']) && $_POST['artImageRenamed3'] != 'assets/img/products/')
			$artImage3 = $_POST['artImageRenamed3'];
		if(isset($_POST['artImageRenamed4']) && $_POST['artImageRenamed4'] != 'assets/img/products/')
			$artImage4 = $_POST['artImageRenamed4'];
		if(isset($_POST['artStockManager']))
			$artStockManager = $_POST['artStockManager'];
		if(isset($_POST['artStock']))
			$artStock = $_POST['artStock'];
		if(isset($_POST['artShipment']))
			$artShipment = $_POST['artShipment'];
		if(isset($_POST['artWeight']))
			$artWeight = $_POST['artWeight'];
		if(isset($_POST['artIsNew']))
			$artIsNew = $_POST['artIsNew'];
		if(isset($_POST['isLastChance']))
			$isLastChance = $_POST['isLastChance'];
		if(isset($_POST['artIsActive']))
			$artIsActive = $_POST['artIsActive'];
		if(isset($_POST['artNormalPrice']))
			$artNormalPrice = $_POST['artNormalPrice'];
		if(isset($_POST['artReducePrice']))
			$artReducePrice = $_POST['artReducePrice'];
		
		$setDatas = $db->query('INSERT INTO `articles` (`CategorieID`,`SubCategorieID`,`Name`,`Reference`,`Description`,`Image1`,`Image2`,`Image3`,`Image4`,`StockManagement`,`Stock`,`Shipment`,`Weight`,`LastChance`,`NormalPrice`,`ReducedPrice`,`IsNew`,`IsActive`) VALUES 
		("'.$artCategorie.'","'.$artSubCategorie.'","'.$artName.'","'.$artRef.'","'.$artDescription.'","'.$artImage1.'","'.$artImage2.'","'.$artImage3.'","'.$artImage4.'","'.$artStockManager.'","'.$artStock.'","'.$artShipment.'","'.$artWeight.'","'.$isLastChance.'","'.$artNormalPrice.'","'.$artReducePrice.'", "'.$artIsNew.'","'.$artIsActive.'");');
		if($setDatas){
			$getData = $db->query('SELECT * FROM `articles` WHERE `Name`="'.$artName.'" AND `Reference`="'.$artRef.'" ORDER BY `ID` DESC LIMIT 1')->fetch_object();
			if($artStockManager == 1){
				echo json_encode(array('success' => 1, 'manager' => 1, 'artID' => $getData->ID));
			}
			else if($artStockManager == 2){
				echo json_encode(array('success' => 1, 'manager' => 2, 'artID' => $getData->ID));
			}
			else if($artStockManager == 3){
				echo json_encode(array('success' => 1, 'manager' => 3, 'artID' => $getData->ID));
			}
			else{
				echo json_encode(array('success' => 1));
			}
		}
		else{
			echo json_encode(array('error' =>'Une erreur interne c\'est produite, contactez l\'administrateur si le problème persiste !'));
		}
	}
	
	if(isset($_POST['modArticle'])){
		if(isset($_POST['articleID']))
			$articleID = $_POST['articleID'];
		if(isset($_POST['artCategorie']))
			$artCategorie = $_POST['artCategorie'];
		if(isset($_POST['artSubCategorie']))
			$artSubCategorie = $_POST['artSubCategorie'];
		if(isset($_POST['artName']))
			$artName = addslashes($_POST['artName']);
		if(isset($_POST['artRef']))
			$artRef = $_POST['artRef'];
		if(isset($_POST['artDescription']))
			$artDescription = addslashes($_POST['artDescription']);
		if(isset($_POST['artImageRenamed1']) && $_POST['artImageRenamed1'] != 'assets/img/products/')
			$artImage1 = $_POST['artImageRenamed1'];
		if(isset($_POST['artImageRenamed2']) && $_POST['artImageRenamed2'] != 'assets/img/products/')
			$artImage2 = $_POST['artImageRenamed2'];
		if(isset($_POST['artImageRenamed3']) && $_POST['artImageRenamed3'] != 'assets/img/products/')
			$artImage3 = $_POST['artImageRenamed3'];
		if(isset($_POST['artImageRenamed4']) && $_POST['artImageRenamed4'] != 'assets/img/products/')
			$artImage4 = $_POST['artImageRenamed4'];
		if(isset($_POST['artStockManager']))
			$artStockManager = $_POST['artStockManager'];
		if(isset($_POST['artStock']))
			$artStock = $_POST['artStock'];
		if(isset($_POST['artShipment']))
			$artShipment = $_POST['artShipment'];
		if(isset($_POST['artWeight']))
			$artWeight = $_POST['artWeight'];
		if(isset($_POST['artIsNew']))
			$artIsNew = $_POST['artIsNew'];
		if(isset($_POST['isLastChance']))
			$isLastChance = $_POST['isLastChance'];
		if(isset($_POST['artIsActive']))
			$artIsActive = $_POST['artIsActive'];
		if(isset($_POST['artNormalPrice']))
			$artNormalPrice = $_POST['artNormalPrice'];
		if(isset($_POST['artReducePrice']))
			$artReducePrice = $_POST['artReducePrice'];
		if(isset($_POST['artPage']))
			$artPage = $_POST['artPage'];
		else{
			$artPage = '0';
		}
		if($artStockManager == '-1'){
			echo json_encode(array('error' => 'Vous devez séléctionner une méthode de gestion de stock!'));
			return false;
		}
		if($artStockManager != '0'){
			$artStock = '0';
		}
		$updDatas = $db->query('UPDATE `articles` SET `CategorieID`="'.$artCategorie.'",`SubCategorieID`="'.$artSubCategorie.'",`Name`="'.$artName.'",`Reference`="'.$artRef.'",`Description`="'.$artDescription.'",
		`Image1`="'.$artImage1.'",`Image2`="'.$artImage2.'",`Image3`="'.$artImage3.'",`Image4`="'.$artImage4.'",`StockManagement`="'.$artStockManager.'",`Stock`="'.$artStock.'",`Shipment`="'.$artShipment.'",`Weight`="'.$artWeight.'",
		`LastChance`="'.$isLastChance.'",`NormalPrice`="'.$artNormalPrice.'",`ReducedPrice`="'.$artReducePrice.'",`IsNew`="'.$artIsNew.'",`IsActive`="'.$artIsActive.'" WHERE `ID`="'.$articleID.'";');
		if($updDatas){
			if($artStockManager == 1){
				echo json_encode(array('success' => 1, 'page' => $artPage, 'manager' => 1, 'artID' => $articleID));
			}
			else if($artStockManager == 2){
				echo json_encode(array('success' => 1, 'page' => $artPage, 'manager' => 2, 'artID' => $articleID));
			}
			else if($artStockManager == 3){
				echo json_encode(array('success' => 1, 'page' => $artPage, 'manager' => 3, 'artID' => $articleID));
			}
			else{
				echo json_encode(array('success' => 1, 'page' => $artPage));
			}
		}
		else{
			echo json_encode(array('error' => 'Une erreur interne c\'est produite, contactez l\'administrateur si le problème persiste !'));
		}
	}
	
	if(isset($_GET['isDeleteArticle']) && isset($_GET['articleID'])){
		$getArticles = $db->query('SELECT * FROM `articles` WHERE `ID`="'.$_GET['articleID'].'" LIMIT 1');
		if($getArticles->num_rows >= 1){
			$getArticle = $getArticles->fetch_object();
			echo '<div class="modal-header">
				<h5 class="modal-title" id="smallmodalLabel">Suppression d\'un article</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4>Êtes-vous sûr de vouloir supprimer cet article?</h4></br>
				<div class="alert alert-warning"><i class="fa fa-warning"></i>La suppression de cet article est définitif !</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
				<button type="button" class="btn btn-primary" onclick="setArticleDelete('.$getArticle->ID.'); return false;">Supprimer</button>
			</div>';
		}
	}
	
	if(isset($_POST['setArticleDelete']) && isset($_POST['articleID'])){
		$delDatas = $db->query('DELETE FROM `articles` WHERE `ID`="'.$_POST['articleID'].'"');
		if($delDatas){
			echo json_encode(array('success' => 1));
		}
		else{
			echo json_encode(array('error' =>'Une erreur interne c\'est produite, contactez l\'administrateur si le problème persiste !'));
		}
	}
  
	if(isset($_POST['setArticleLastChance']) && isset($_POST['articleStatus']) && isset($_POST['articleID'])){
		$updLChance = $db->query('UPDATE `articles` SET `LastChance`="'.$_POST['articleStatus'].'" WHERE `ID`="'.$_POST['articleID'].'"');
		if($updLChance){
			echo json_encode(array('success' => 1));
		}
		else{
			echo json_encode(array('error' =>'Une erreur interne c\'est produite, contactez l\'administrateur si le problème persiste !'));
		}
	}
  
	if(isset($_POST['setArticleIsActive']) && isset($_POST['articleStatus']) && isset($_POST['articleID'])){
		$updActiveDatas = $db->query('UPDATE `articles` SET `IsActive`="'.$_POST['articleStatus'].'" WHERE `ID`="'.$_POST['articleID'].'"');
		if($updActiveDatas){
			echo json_encode(array('success' => 1));
		}
		else{
			echo json_encode(array('error' =>'Une erreur interne c\'est produite, contactez l\'administrateur si le problème persiste !'));
		}
	}
	if(isset($_POST['getArticleSearch']) && isset($_POST['searchText'])){
		$getDatas = $db->query('SELECT * FROM `articles` WHERE `Name` LIKE "'.$_POST['searchText'].'%" OR  `Reference` LIKE "'.$_POST['searchText'].'%"');
		if($getDatas->num_rows >= 1){
			while($getData = $getDatas->fetch_object()){
				echo '<a class="dropdown-item" href="mod_article.php?articleID='.$getData->ID.'">'.$getData->Name.' (<small>'.$getData->Reference.'</small>)</a>';
			}
		}
		else{
			echo 'Aucun article trouvé';
		}
	}
	
?>