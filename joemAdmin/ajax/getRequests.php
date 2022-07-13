<?php  session_start();
	include_once("../../core/functions.php");
	$system->db = $db;
	
	if(isset($_GET['getDataModal']) && isset($_GET['data'])){
		if($_GET['data'] == 'color'){
			echo '<div class="modal-header header-custom">
				<h5 class="modal-title" id="smallmodalLabel">Ajouter une couleur</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="text-input" class=" form-control-label">Nom de la couleur :</label>
					<input type="text" id="colorName" name="colorName" placeholder="Couleur" class="form-control">
				</div>
				<div class="form-group">
					<label for="text-input" class=" form-control-label">Couleur affiché :</label>
					<input type="color" id="getEditColorHex" name="getEditColorHex" placeholder="#fff" class="form-control">
					<input type="hidden" id="setEditColorHex" name="setEditColorHex">
				</div>
				<div class="form-group">
					<label for="text-input" class=" form-control-label">Activer la catégorie :</label>
					<select name="IsActiveColor" class="form-control" id="IsActiveColor">
						<option value="-1">Séléctionnez une option</option>
						<option value="0">Désactiver</option>
						<option value="1">Activer</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
				<button type="button" class="btn btn-primary" onclick="setAddColor(); return false;">Ajouter</button>
			</div>';
		}
		else if($_GET['data'] == 'size'){
			echo '<div class="modal-header header-custom">
				<h5 class="modal-title" id="smallmodalLabel">Ajouter une taille</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="text-input" class=" form-control-label">Nom de la taille :</label>
					<input type="text" id="sizeName" name="sizeName" placeholder="Taille" class="form-control">
				</div>
				<div class="form-group">
					<label for="text-input" class=" form-control-label">Nom court :</label>
					<input type="text" id="sizeShortName" name="sizeShortName" placeholder="T" class="form-control">
				</div>
				<div class="form-group">
					<label for="text-input" class=" form-control-label">Activer la taille :</label>
					<select name="IsActiveSize" class="form-control" id="IsActiveSize">
						<option value="-1">Séléctionnez une option</option>
						<option value="0">Désactiver</option>
						<option value="1">Activer</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
				<button type="button" class="btn btn-primary" onclick="setAddSize(); return false;">Ajouter</button>
			</div>';
		}
		else if($_GET['data'] == 'categorie'){
			echo '<div class="modal-header header-custom">
				<h5 class="modal-title" id="smallmodalLabel">Ajouter une catégorie</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="text-input" class=" form-control-label">Nom de la catégorie :</label>
					<input type="text" id="categoryName" name="categoryName" placeholder="Catégorie" class="form-control">
				</div>
				<div class="form-group">
					<label for="text-input" class=" form-control-label">Activer la catégorie :</label>
					<select name="IsActiveCategorie" class="form-control" id="IsActiveCategorie">
						<option value="-1">Séléctionnez une option</option>
						<option value="0">Désactiver</option>
						<option value="1">Activer</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
				<button type="button" class="btn btn-primary" onclick="setAddCategorie(); return false;">Ajouter</button>
			</div>';
		}
		else if($_GET['data'] == 'subCategorie'){
			echo '<div class="modal-header header-custom">
				<h5 class="modal-title" id="smallmodalLabel">Ajouter une sous-catégorie</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="text-input" class=" form-control-label">Séléctionnez la catégorie parente :</label>
					<select name="selectArtCategorieID" class="form-control" id="selectArtCategorieID">
						<option value="-1">Séléctionnez une catégorie</option>';
						$getCategories = $db->query('SELECT * FROM `article-categories`');
						if($getCategories->num_rows >= 1){
							while($getCategorie = $getCategories->fetch_object()){
								echo '<option value="'.$getCategorie->ID.'">'.$getCategorie->Name.'</option>';
							}
						}
					echo '</select>
				</div>
				<div class="form-group">
					<label for="text-input" class=" form-control-label">Nom de la sous-catégorie :</label>
					<input type="text" id="subCategoryName" name="subCategoryName" placeholder="Sous-catégorie" class="form-control">
				</div>
				<div class="form-group">
					<label for="text-input" class=" form-control-label">Activer la sous-catégorie :</label>
					<select name="IsActiveSubCategorie" class="form-control" id="IsActiveSubCategorie">
						<option value="-1">Séléctionnez une option</option>
						<option value="0">Désactiver</option>
						<option value="1">Activer</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
				<button type="button" class="btn btn-primary" onclick="setAddSubCategorie(); return false;">Ajouter</button>
			</div>';
		}
		else {
			echo '<div class="modal-header header-custom">
				<h5 class="modal-title" id="smallmodalLabel">Erreur</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Une erreur c\'est produite</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
			</div>';
		}
	}
	
	if(isset($_GET['getQueryData'])){
		if(isset($_GET['data']) && $_GET['data'] == 'categorie'){
			echo '<option value="-1">Séléctionnez une catégorie</option>';
			$getCategories = $db->query('SELECT * FROM `article-categories`');
			if($getCategories->num_rows >= 1){
				while($getCategorie = $getCategories->fetch_object()){
					echo '<option value="'.$getCategorie->ID.'">'.$getCategorie->Name.'</option>';
				}
			}
		}
		elseif(isset($_GET['data']) && $_GET['data'] == 'subCategorie'){
			echo '<option value="-1">Séléctionnez une catégorie</option>';
			$getSubCategories = $db->query('SELECT * FROM `article-sub-categories`');
			if($getSubCategories->num_rows >= 1){
				while($getSubCategorie = $getSubCategories->fetch_object()){
					echo '<option value="'.$getSubCategorie->ID.'" disabled="disabled">'.$getSubCategorie->Name.'</option>';
				}
			}
		}
		elseif(isset($_GET['data']) && $_GET['data'] == 'colors'){
			$getColors = $db->query('SELECT * FROM `article-option-colors`');
			if($getColors->num_rows >= 1){
				while($getColor = $getColors->fetch_object()){
					echo '<div class="checkbox">
						<label for="checkbox1" class="form-check-label">
							<input type="checkbox" id="artColor_'.$getColor->ID.'" name="artColor_'.$getColor->ID.'" value="'.$getColor->ID.'" class="form-check-input">'.$getColor->Name.'
						</label>
					</div>';
				}
			}
		}
		elseif(isset($_GET['data']) && $_GET['data'] == 'sizes'){
			$getSizes = $db->query('SELECT * FROM `article-option-sizes`');
			if($getSizes->num_rows >= 1){
				while($getSize = $getSizes->fetch_object()){
					echo '<div class="checkbox">
						<label for="checkbox1" class="form-check-label">
							<input type="checkbox" id="artSize_'.$getSize->ID.'" name="artSize_'.$getSize->ID.'" value="'.$getSize->ID.'" class="form-check-input">'.$getSize->Name.'
						</label>
					</div>';
				}
			}
		}
		else{
			echo 0;
		}
	}
	
	if(isset($_GET['addedCategory'])){
		echo '<div class="modal-header header-custom">
			<h5 class="modal-title" id="smallmodalLabel">Ajouter une catégorie</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Nom de la catégorie :</label>
				<input type="text" id="categoryName" name="categoryName" placeholder="Catégorie" class="form-control">
			</div>
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Afficher dans la bannière d\'accueil :</label>
				<select name="IsActiveBanner" class="form-control" id="IsActiveBanner">
					<option value="0">Non</option>
					<option value="1">Oui</option>
				</select>
			</div>
			<div class="col-md-6">
				<!-- show error-->
				<div id="resultImgUpload" style="display:none"></div>
				<!-- show preview-->
				<div id="imagePreview" style="display:none"></div><button class="btn btn-danger btn-xs pull-right" title="Supprimer l\'image" id="btn-del-image-cat" onclick="setImageCategoryDelete(); return false;" style="display:none;"><i class="fa fa-remove"></i></button>
				<div class="form-group files" id="imageUpload">
					<label class="my-auto">Ajouter une image</label>
					<input type="file" class="form-control" id="setCatImage" onchange="setCategoryImage(); return false;"/>
					<input type="hidden" id="imageRenamed" value="assets/img/category/"/>
				</div>
			</div>
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Activer la catégorie :</label>
				<select name="IsActiveCategorie" class="form-control" id="IsActiveCategorie">
					<option value="0">Désactiver</option>
					<option value="1">Activer</option>
				</select>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
			<button type="button" class="btn btn-primary" onclick="setAddedCategorie(); return false;">Ajouter</button>
		</div>';
	}
	if(isset($_GET['addedSubCategory'])){
		echo '<div class="modal-header header-custom">
			<h5 class="modal-title" id="smallmodalLabel">Ajouter une sous-catégorie</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Séléctionnez la catégorie parente :</label>
				<select name="selectArtCategorieID" class="form-control" id="selectArtCategorieID">
					<option value="-1">Séléctionnez une catégorie</option>';
					$getCategories = $db->query('SELECT * FROM `article-categories`');
					if($getCategories->num_rows >= 1){
						while($getCategorie = $getCategories->fetch_object()){
							echo '<option value="'.$getCategorie->ID.'">'.$getCategorie->Name.'</option>';
						}
					}
				echo '</select>
			</div>
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Nom de la sous-catégorie :</label>
				<input type="text" id="subCategoryName" name="subCategoryName" placeholder="Sous-catégorie" class="form-control">
			</div>
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Activer la sous-catégorie :</label>
				<select name="IsActiveSubCategorie" class="form-control" id="IsActiveSubCategorie">
					<option value="0">Désactiver</option>
					<option value="1">Activer</option>
				</select>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
			<button type="button" class="btn btn-primary" onclick="setAddedSubCategorie(); return false;">Ajouter</button>
		</div>';
	}
	
	if(isset($_POST['setQueryData']) && isset($_POST['datas'])){
		if($_POST['datas'] == 'categorie'){
			if(isset($_POST['name']) && isset($_POST['image']) && isset($_POST['isBanner']) && isset($_POST['isActive'])){
				$getCategories = $db->query('SELECT * FROM `article-categories` WHERE `Name`="'.$_POST['name'].'"');
				if($getCategories->num_rows == 0){
					$getCategorieBanners = $db->query('SELECT * FROM `article-categories` WHERE `Banner`=1');
					$isBanner = $_POST['isBanner'];
					if($getCategorieBanners->num_rows >= 3){
						$isBanner = 0;
					}
					$setNewCategorie = $db->query('INSERT INTO `article-categories` (`Name`, `Image`, `Banner`, `IsActive`) VALUES ("'.$_POST['name'].'", "'.$_POST['image'].'", "'.$isBanner.'", "'.$_POST['isActive'].'")');
					echo 'success';
				}
				else{
					echo 'Une catégorie du même nom existe déjà !';
				}
			}
		}
		elseif($_POST['datas'] == 'subCategorie'){ /*name  /*categorieID / isActive*/
			if(isset($_POST['name']) && isset($_POST['categorieID']) && isset($_POST['isActive'])){
				$getSubCategories = $db->query('SELECT * FROM `article-sub-categories` WHERE `Name`="'.$_POST['name'].'" AND `CategorieID`="'.$_POST['categorieID'].'"');
				if($getSubCategories->num_rows == 0){
					$setNewSubCategorie = $db->query('INSERT INTO `article-sub-categories` (`Name`, `CategorieID`, `IsActive`) VALUES ("'.$_POST['name'].'", "'.$_POST['categorieID'].'", "'.$_POST['isActive'].'")');
					echo 'success';
				}
				else{
					echo 'Une sous-catégorie du même nom est déjà lié à cette catégorie !';
				}
			}
		}
		elseif($_POST['datas'] == 'colors'){ /*artID / name / colorHex / qtyStock*/
			if(isset($_POST['artID']) && isset($_POST['name']) && isset($_POST['colorHex']) && isset($_POST['qtyStock'])){
				$getColors = $db->query('SELECT * FROM `article-option-colors` WHERE `ArticleID`="'.$_POST['artID'].'" AND `Name`="'.$_POST['name'].'"');
				if($getColors->num_rows == 0){
					$setNewColor = $db->query('INSERT INTO `article-option-colors` (`ArticleID`, `Name`, `Color`,  `Stock`) VALUES ("'.$_POST['artID'].'", "'.$_POST['name'].'", "'.$_POST['colorHex'].'", "'.$_POST['qtyStock'].'")');
					if($setNewColor){
						echo json_encode(array('success' => 1));
					}
					else{
						echo json_encode(array('error' => 'Une erreur c\'est produite pendant l\'ajout de la nouvelle couleur !'));
					}
				}
				else{
					echo json_encode(array('error' => 'Une couleur du même nom existe déjà !'));
				}
			}
		}
		elseif($_POST['datas'] == 'sizes'){ /*artID / name / shortName / qtyStock*/
			if(isset($_POST['artID'],$_POST['name'],$_POST['shortName'],$_POST['shortName'],$_POST['qtyStock'])){
				$getSizes = $db->query('SELECT * FROM `article-option-sizes` WHERE `ArticleID`="'.$_POST['artID'].'" AND `Name`="'.$_POST['name'].'"');
				if($getSizes->num_rows == 0){
					$setNewSize = $db->query('INSERT INTO `article-option-sizes` (`ArticleID`, `Name`, `ShortName`, `Stock`) VALUES ("'.$_POST['artID'].'", "'.$_POST['name'].'", "'.$_POST['shortName'].'", "'.$_POST['qtyStock'].'")');
					echo json_encode(array('success' => 1));
				}
				else{
					echo json_encode(array('error' => 'Une taille du même nom existe déjà !'));
				}
			}
		}
		else{
			echo 'Les données reçus sont incorrects!';
		}
	}
	
	if(isset($_GET['getSubCategorieData']) && isset($_GET['categorieID'])){
		$getSubCategories = $db->query('SELECT * FROM `article-sub-categories` WHERE `CategorieID`="'.$_GET['categorieID'].'"');
		if($getSubCategories->num_rows >= 1){
			echo '<option value="-1">Séléctionnez une sous-catégorie</option>';
			while($getSubCategorie = $getSubCategories->fetch_object()){
				echo '<option value="'.$getSubCategorie->ID.'">'.$getSubCategorie->Name.'</option>';
			}
		}
		else{
			echo '<option value="-100">Aucunes sous-catégorie n\'est liée à cette catégorie !</option>';
		}
	}
	
	if(isset($_GET['setImageDelete']) && isset($_GET['ImageName'])){
		if(file_exists('../assets/img/products/'.$_GET['ImageName'])){
			$isDeleted = unlink('../assets/img/products/'.$_GET['ImageName']);
			if($isDeleted){
				echo 'success';
			}
			else 
				echo '../assets/img/products/'.$_GET['ImageName'];
		}
		else
			echo 'unknown';
	}
	
	if(isset($_GET['setImageCategoryDelete']) && isset($_GET['ImageName'])){
		if(file_exists('../assets/img/products/'.$_GET['ImageName'])){
			$isDeleted = unlink('../assets/img/products/'.$_GET['ImageName']);
			if($isDeleted){
				echo 'success';
			}
			else 
				echo '../assets/img/products/'.$_GET['ImageName'];
		}
		else
			echo 'unknown';
	}
	
	if(isset($_GET['isCategorie']) && isset($_GET['editCategorie']) && isset($_GET['categorieID'])){
		$getCategories = $db->query('SELECT * FROM `article-categories` WHERE `ID`="'.$_GET['categorieID'].'"');
		if($getCategories->num_rows >= 1){
			while($getCategorie = $getCategories->fetch_object()){
				echo '<div class="modal-header header-custom">
					<h5 class="modal-title" id="smallmodalLabel">Modification d\'une catégorie</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Nom de la catégorie :</label>
						<input type="text" id="editCategoryName" name="editCategoryName" placeholder="Catégorie" class="form-control" value="'.$getCategorie->Name.'">
					</div>
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Afficher dans la bannière d\'accueil :</label>
						<select name="IsActiveBanner" class="form-control" id="IsActiveBanner">
							<option value="0""'; if($getCategorie->Banner == 0) echo 'selected="selected"'; echo '>Non</option>
							<option value="1""'; if($getCategorie->Banner == 0) echo 'selected="selected"'; echo '>Oui</option>
						</select>
					</div>
					<div class="col-md-6">
						<!-- show error-->
						<div id="resultImgUpload" style="display:none"></div>
						<!-- show preview-->
						<div id="imagePreview"><img class="img-fluid" src="../'.$getCategorie->Image.'" width="200px"/></div><button class="btn btn-danger btn-xs pull-right" title="Supprimer l\'image" id="btn-del-image-cat" onclick="setImageCategoryDelete(); return false;"><i class="fa fa-remove"></i></button>
						<div class="form-group files" id="imageUpload" style="display:none">
							<label class="my-auto">Ajouter une image</label>
							<input type="file" class="form-control" id="setCatImage" onchange="setCategoryImage(); return false;"/>
							<input type="hidden" id="imageRenamed" value="'.$getCategorie->Image.'"/>
						</div>
					</div>
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Activer la catégorie :</label>
						<select name="IsActiveEditCategorie" class="form-control" id="IsActiveEditCategorie">
							<option value="0"'; if($getCategorie->IsActive == 0) echo 'selected="selected"'; echo '>Désactiver</option>
							<option value="1"'; if($getCategorie->IsActive == 1) echo 'selected="selected"'; echo '>Activer</option>
						</select>
					</div>
				</div>
				<input type="hidden" id="editCategorieID" value="'.$getCategorie->ID.'"/>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					<button type="button" class="btn btn-primary" onclick="setEditCategorie(); return false;">Ajouter</button>
				</div>';
			}
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_GET['isCategorie']) && isset($_GET['deleteCategorie']) && isset($_GET['categorieID'])){
		$getCategories = $db->query('SELECT * FROM `article-categories` WHERE `ID`="'.$_GET['categorieID'].'"');
		if($getCategories->num_rows >= 1){
			while($getCategorie = $getCategories->fetch_object()){
				echo '<div class="modal-header header-custom">
					<h5 class="modal-title" id="smallmodalLabel">Suppression d\'une catégorie</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h4>Êtes-vous sûr de vouloir supprimer cette catégorie?</h4></br>
					<div class="alert alert-warning"><i class="fa fa-warning"></i>La suppression de cette catégorie entrainera la désactivation des articles liés à cette catégorie et la suppression des sous-catégories liés !</div>
				</div>
				<input type="hidden" id="deleteSubCategorieID" value="'.$getCategorie->ID.'"/>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					<button type="button" class="btn btn-primary" onclick="setDeleteCategorie('.$getCategorie->ID.'); return false;">Supprimer</button>
				</div>';
			}
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_GET['isSubCategorie']) && isset($_GET['editSubCategorie']) && isset($_GET['subCategorieID'])){
		$getSubCategories = $db->query('SELECT * FROM `article-sub-categories` WHERE `ID`="'.$_GET['subCategorieID'].'"');
		if($getSubCategories->num_rows >= 1){
			while($getSubCategorie = $getSubCategories->fetch_object()){
				echo '<div class="modal-header header-custom">
					<h5 class="modal-title" id="smallmodalLabel">Modification d\'une catégorie</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Séléctionnez la catégorie parente :</label>
						<select name="editSubCategoryCategoryID" class="form-control" id="editSubCategoryCategoryID">
							<option value="-1">Séléctionnez une catégorie</option>';
							$getCategories = $db->query('SELECT * FROM `article-categories`');
							if($getCategories->num_rows >= 1){
								while($getCategorie = $getCategories->fetch_object()){
									echo '<option value="'.$getCategorie->ID.'"'; if($getCategorie->ID == $getSubCategorie->CategorieID) echo 'selected="selected"'; echo '>'.$getCategorie->Name.'</option>';
								}
							}
						echo '</select>
					</div>
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Nom de la sous-catégorie :</label>
						<input type="text" id="editSubCategoryName" name="editSubCategoryName" placeholder="Sous-catégorie" class="form-control" value="'.$getSubCategorie->Name.'">
					</div>
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Activer la sous-catégorie :</label>
						<select name="IsActiveEditSubCategorie" class="form-control" id="IsActiveEditSubCategorie">
							<option value="-1"'; if($getSubCategorie->IsActive == -1) echo 'selected="selected"'; echo '>Séléctionnez une option</option>
							<option value="0"'; if($getSubCategorie->IsActive == 0) echo 'selected="selected"'; echo '>Désactiver</option>
							<option value="1"'; if($getSubCategorie->IsActive == 1) echo 'selected="selected"'; echo '>Activer</option>
						</select>
					</div>
				</div>
				<input type="hidden" id="editSubCategorieID" value="'.$getSubCategorie->ID.'"/>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					<button type="button" class="btn btn-primary" onclick="setEditSubCategorie(); return false;">Ajouter</button>
				</div>';
			}
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_GET['isSubCategorie']) && isset($_GET['deleteSubCategorie']) && isset($_GET['subCategorieID'])){
		$getSubCategories = $db->query('SELECT * FROM `article-sub-categories` WHERE `ID`="'.$_GET['subCategorieID'].'"');
		if($getSubCategories->num_rows >= 1){
			while($getSubCategorie = $getSubCategories->fetch_object()){
				echo '<div class="modal-header header-custom">
					<h5 class="modal-title" id="smallmodalLabel">Suppression d\'une sous-catégorie</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h4>Êtes-vous sûr de vouloir supprimer cette sous-catégorie?</h4></br>
					<div class="alert alert-warning"><i class="fa fa-warning"></i>La suppression de cette sous-catégorie entrainera la désactivation des articles liés à cette sous-catégorie !</div>
				</div>
				<input type="hidden" id="deleteSubCategorieID" value="'.$getSubCategorie->ID.'"/>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					<button type="button" class="btn btn-primary" onclick="setDeleteSubCategorie('.$getSubCategorie->ID.'); return false;">Supprimer</button>
				</div>';
			}
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_POST['delCategorie']) && isset($_POST['deleteCategorieID'])){
		$getCategories = $db->query('SELECT * FROM `article-categories` WHERE `ID`="'.$_POST['deleteCategorieID'].'"');
		if($getCategories->num_rows >= 1){
			$setInactiveArticle = $db->query('UPDATE `articles` SET `IsActive`=0 WHERE `CategorieID`="'.$_POST['deleteCategorieID'].'"');
			if($setInactiveArticle){
				$setDelSubCategorie = $db->query('DELETE FROM `article-sub-categories` WHERE `CategorieID`="'.$_POST['deleteCategorieID'].'"');
				if($setDelSubCategorie){
					$delCategorie = $db->query('DELETE FROM `article-categories` WHERE `ID`="'.$_POST['deleteCategorieID'].'"');
					if($delCategorie){
						echo 'success';
					}
				}
			}
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_POST['editCategorie']) && isset($_POST['editCategorieID']) && isset($_POST['editCategorieName']) && isset($_POST['editBanner']) && isset($_POST['editImage']) && isset($_POST['editCategorieIsActive'])){
		$getCategories = $db->query('SELECT * FROM `article-categories` WHERE `ID`="'.$_POST['editCategorieID'].'"');
		if($getCategories->num_rows == 1){
			$getCategorieBanners = $db->query('SELECT * FROM `article-categories` WHERE `Banner`=1');
			$isBanner = $_POST['editBanner'];
			if($getCategorieBanners->num_rows >= 3){
				$isBanner = 0;
			}
			$updateCategorie = $db->query('UPDATE `article-categories` SET `Name`="'.$_POST['editCategorieName'].'", `Banner`="'.$isBanner.'", `Image`="'.$_POST['editImage'].'", `IsActive`="'.$_POST['editCategorieIsActive'].'" WHERE `ID`="'.$_POST['editCategorieID'].'"');
			if($updateCategorie){
				echo 'success';
			}
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_POST['delSubCategorie']) && isset($_POST['deleteSubCategorieID'])){
		$getSubCategories = $db->query('SELECT * FROM `article-sub-categories` WHERE `ID`="'.$_POST['deleteSubCategorieID'].'"');
		if($getSubCategories->num_rows >= 1){
			$setInactiveArticle = $db->query('UPDATE `articles` SET `IsActive`=0 WHERE `SubCategorieID`="'.$_POST['deleteSubCategorieID'].'"');
			if($setInactiveArticle){
				$delSubCategorie = $db->query('DELETE FROM `article-sub-categories` WHERE `ID`="'.$_POST['deleteSubCategorieID'].'"');
				if($delSubCategorie){
					echo 'success';
				}
			}
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_POST['editSubCategorie']) && isset($_POST['editSubCategorieID']) && isset($_POST['editSubCategorieCategorieID']) && isset($_POST['editSubCategorieName']) && isset($_POST['editSubCategorieIsActive'])){
		$getSubCategories = $db->query('SELECT * FROM `article-sub-categories` WHERE `ID`="'.$_POST['editSubCategorieID'].'"');
		if($getSubCategories->num_rows >= 1){
			$updateSubCategorie = $db->query('UPDATE `article-sub-categories` SET `CategorieID`="'.$_POST['editSubCategorieCategorieID'].'", `Name`="'.$_POST['editSubCategorieName'].'", `IsActive`="'.$_POST['editSubCategorieIsActive'].'" WHERE `ID`="'.$_POST['editSubCategorieID'].'"');
			if($updateSubCategorie){
				echo 'success';
			}
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_POST['editColor']) && isset($_POST['editColorID']) && isset($_POST['editColorName']) && isset($_POST['editColorHex']) && isset($_POST['IsActiveEditColor']) ){
		$getColors = $db->query('SELECT * FROM `article-option-colors` WHERE `ID`="'.$_POST['editColorID'].'"');
		if($getColors->num_rows == 1){
			$updateColors = $db->query('UPDATE `article-option-colors` SET `Name`="'.$_POST['editColorName'].'", `Color`="'.$_POST['editColorHex'].'", `IsActive`="'.$_POST['IsActiveEditColor'].'" WHERE `ID`="'.$_POST['editColorID'].'"');
			if($updateColors){
				echo 'success';
			}
		}
		else{
			echo 'Une couleur du même nom existe déjà !';
		}
	}
	
	if(isset($_GET['isColor']) && isset($_GET['addColor']) && isset($_GET['artID'])){
		echo '<div class="modal-header header-custom">
			<h5 class="modal-title" id="smallmodalLabel">Ajout d\'une couleur</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">';
			if(empty($_GET['artID']) OR $_GET['artID'] == 0){
				echo '<div class="form-group">
					<label for="text-input" class=" form-control-label">Rechercher un article :</label>
					<input type="hidden" name="colorArtID" id="colorArtID">
					<input type="text" id="searchColorArtID" name="searchColorArtID" placeholder="ID" class="form-control search-color-artID">
					<div class="dropdown-menu" id="dropdownSearchColorArticle">
					</div>
				</div>';
			}
			else{
				echo '<div class="form-group">
					<label for="text-input" class=" form-control-label">ID de l\'article :</label>
					<input type="text" id="colorArtID" name="colorArtID" placeholder="ID" class="form-control" value="'.$_GET['artID'].'" readonly>
				</div>';
			}
			
			echo '<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Nom de la couleur :</label>
						<input type="text" id="colorName" name="colorName" placeholder="Marron" class="form-control" value="">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Séléctionnez la couleur :</label>
						<input type="color" id="getEditColorHex" name="getEditColorHex" class="form-control" value="" onchange="setDataColor(this.value);">
						<input type="hidden" id="setEditColorHex" value="000"/>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Quantité en stock de cette couleur :</label>
						<select id="qtyStock" name="qtyStock" class="form-control">';
							for($i=0;$i<=20;$i++){
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						echo '</select>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Ajouter une autre couleur à cet article :</label>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="isLastColor" value="1" checked>
							<label class="form-check-label" for="isLastColor">Oui</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="isLastColor" value="2">
							<label class="form-check-label" for="isLastColor">Non</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Terminer</button>
			<button type="button" class="btn btn-primary" onclick="setAddedColor(); return false;">Ajouter</button>
		</div>';
	}
	
	if(isset($_POST['setArtColorSearch'], $_POST['searchArtText'])){
		$artResponse = '';
		$getArticles = $db->query('SELECT * FROM `articles` WHERE `Name` LIKE "'.$_POST['searchArtText'].'%" OR `Reference` LIKE "'.$_POST['searchArtText'].'%" AND (`StockManagement`="1" OR `StockManagement`="3")');
		if($getArticles->num_rows >= 1){
			while($getArticle = $getArticles->fetch_object()){
				$artResponse .= '<a class="dropdown-item" href="#" onclick="setArticleColor('.$getArticle->ID.', \''.addslashes($getArticle->Name).' '.$getArticle->Reference.'\');"><img src="../'.$getArticle->Image1.'" width="80px"/> '.ucfirst($getArticle->Name).' ('.$getArticle->Reference.')</a>';
			}
		}
		echo json_encode(array('datas' => $artResponse));
	}
	
	if(isset($_POST['setArtSizeSearch'], $_POST['searchArtText'])){
		$artResponse = '';
		$getArticles = $db->query('SELECT * FROM `articles` WHERE `Name` LIKE "'.$_POST['searchArtText'].'%" OR `Reference` LIKE "'.$_POST['searchArtText'].'%" AND (`StockManagement`="2" OR `StockManagement`="3")');
		if($getArticles->num_rows >= 1){
			while($getArticle = $getArticles->fetch_object()){
				$artResponse .= '<a class="dropdown-item" href="#" onclick="setArticleSize('.$getArticle->ID.', \''.$getArticle->Name.' '.$getArticle->Reference.'\');"><img src="../'.$getArticle->Image1.'" width="80px"/> '.ucfirst($getArticle->Name).' ('.$getArticle->Reference.')</a>';
			}
		}
		echo json_encode(array('datas' => $artResponse));
	}
	
	if(isset($_GET['isSize']) && isset($_GET['addSize']) && isset($_GET['artID'])){
		echo '<div class="modal-header header-custom">
			<h5 class="modal-title" id="smallmodalLabel">Ajouter une taille</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-lg-12">';
			if(empty($_GET['artID']) OR $_GET['artID'] == 0){
				echo '<div class="form-group">
					<label for="text-input" class=" form-control-label">Rechercher un article :</label>
					<input type="hidden" name="sizeArtID" id="sizeArtID">
					<input type="text" id="searchSizeArtID" name="searchSizeArtID" placeholder="ID" class="form-control search-size-artID">
					<div class="dropdown-menu" id="dropdownSearchSizeArticle">
					</div>
				</div>';
			}
			else{
				echo '<div class="form-group">
					<label for="text-input" class=" form-control-label">ID de l\'article :</label>
					<input type="text" id="sizeArtID" name="sizeArtID" placeholder="ID" class="form-control" value="'.$_GET['artID'].'" readonly>
				</div>';
			}
			
			echo '</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Nom de la taille :</label>
						<input type="text" id="sizeName" name="sizeName" placeholder="Taille" class="form-control">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Nom court :</label>
						<input type="text" id="sizeShortName" name="sizeShortName" placeholder="Taille" class="form-control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Quantité en stock de cette taille :</label>
						<select id="qtyStock" name="qtyStock" class="form-control">';
							for($i=0;$i<=20;$i++){
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						echo '</select>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Ajouter une autre taille à cet article :</label>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="isLastSize" value="1" checked>
							<label class="form-check-label" for="inlineRadio1">Oui</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="isLastSize" value="2">
							<label class="form-check-label" for="isLastSize">Non</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Terminer</button>
			<button type="button" class="btn btn-primary" onclick="setAddedSize(); return false;">Ajouter</button>
		</div>';
	}
	if(isset($_GET['isColorAndSize']) && isset($_GET['addColorSize']) && isset($_GET['artID']) ){
		echo '<div class="modal-header header-custom">
			<h5 class="modal-title" id="smallmodalLabel">Ajouter une taille</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<label for="text-input" class=" form-control-label">ID de l\'article <small>(L\'article doit avoir le gestionnaire de stock par couleur actif)</small> :</label>
				<input type="text" id="artID" name="artID" placeholder="ID" class="form-control" value="'.$_GET['artID'].'" readonly>
			</div>
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Nom de la taille :</label>
				<input type="text" id="sizeName" name="sizeName" placeholder="Taille" class="form-control">
			</div>
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Nom court :</label>
				<input type="text" id="sizeShortName" name="sizeShortName" placeholder="Taille" class="form-control">
			</div>
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Activer la taille :</label>
				<select name="IsActiveSize" class="form-control" id="IsActiveSize">
					<option value="-1">Séléctionnez une option</option>
					<option value="0">Désactiver</option>
					<option value="1">Activer</option>
				</select>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Terminer</button>
			<button type="button" class="btn btn-primary" onclick="setAddedSize(); return false;">Ajouter</button>
		</div>';
	}
	
	if(isset($_GET['isColor']) && isset($_GET['editColor']) && isset($_GET['colorID']) ){
		$getColors = $db->query('SELECT * FROM `article-option-colors` WHERE `ID`="'.$_GET['colorID'].'"');
		if($getColors->num_rows >= 1){
			while($getColor = $getColors->fetch_object()){
				echo '<div class="modal-header header-custom">
					<h5 class="modal-title" id="smallmodalLabel">Editer une couleur</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Nom de la couleur :</label>
						<input type="text" id="editColorName" name="editColorName" placeholder="Sous-catégorie" class="form-control" value="'.$getColor->Name.'">
					</div>
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Séléctionnez la couleur :</label>
						<input type="color" id="getEditColorHex" name="getEditColorHex" class="form-control" value="'.$getColor->Color.'" onchange="setDataColor(this.value);">
						<input type="hidden" id="setEditColorHex" value="'.$getColor->Color.'"/>
					</div>
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Activer la couleur :</label>
						<select name="IsActiveEditColor" class="form-control" id="IsActiveEditColor">
							<option value="-1"'; if($getColor->IsActive == -1) echo 'selected="selected"'; echo '>Séléctionnez une option</option>
							<option value="0"'; if($getColor->IsActive == 0) echo 'selected="selected"'; echo '>Désactiver</option>
							<option value="1"'; if($getColor->IsActive == 1) echo 'selected="selected"'; echo '>Activer</option>
						</select>
					</div>
				</div>
				<input type="hidden" id="editColorID" value="'.$getColor->ID.'"/>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					<button type="button" class="btn btn-primary" onclick="setEditColor('.$getColor->ID.'); return false;">Valider</button>
				</div>';
			}
		}
		else{
			echo '0';
		}
	}
	if(isset($_GET['isColor']) && isset($_GET['deleteColor']) && isset($_GET['colorID'])){
		$getColors = $db->query('SELECT * FROM `article-option-colors` WHERE `ID`="'.$_GET['colorID'].'"');
		if($getColors->num_rows == 1){
			$datas = '';
			$getColor = $getColors->fetch_object();
			$datas .= '<div class="modal-header header-custom">
				<h5 class="modal-title" id="smallmodalLabel">Suppression d\'une taille</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4>Êtes-vous sûr de vouloir supprimer cette couleur?</h4></br>
				<div class="alert alert-warning"><i class="fa fa-warning"></i>Cette suppression est définitive!</div>
			</div>
			<input type="hidden" id="deleteColorID" value="'.$getColor->ID.'"/>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
				<button type="button" class="btn btn-primary" onclick="setDeleteColor('.$getColor->ID.'); return false;">Supprimer</button>
			</div>';
				
			echo json_encode(array('datas' => $datas));
		}
		else{
			echo json_encode(array('error' => 'L\'article n\'existe pas!'));
		}
	}
	
	if(isset($_POST['delColor']) && isset($_POST['deleteColorID'])){
		$getColors = $db->query('SELECT * FROM `article-option-colors` WHERE `ID`="'.$_POST['deleteColorID'].'"');
		if($getColors->num_rows >= 1){
			$delColor = $db->query('DELETE FROM `article-option-colors` WHERE `ID`="'.$_POST['deleteColorID'].'"');
			if($delColor){
				echo 'success';
			}
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_GET['isSize']) && isset($_GET['editSize']) && isset($_GET['sizeID']) ){
		$getSizes = $db->query('SELECT * FROM `article-option-sizes` WHERE `ID`="'.$_GET['sizeID'].'"');
		if($getSizes->num_rows >= 1){
			while($getSize = $getSizes->fetch_object()){
				echo '<div class="modal-header header-custom">
					<h5 class="modal-title" id="smallmodalLabel">Suppression d\'une sous-catégorie</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Nom de la taille :</label>
						<input type="text" id="editSizeName" name="editSizeName" placeholder="Taille" class="form-control" value="'.$getSize->Name.'">
					</div>
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Nom court :</label>
						<input type="text" id="editShortSizeName" name="editShortSizeName" placeholder="T" class="form-control" value="'.$getSize->ShortName.'">
					</div>
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Activer la taille :</label>
						<select name="IsActiveEditSize" class="form-control" id="IsActiveEditSize">
							<option value="-1"'; if($getSize->IsActive == -1) echo 'selected="selected"'; echo '>Séléctionnez une option</option>
							<option value="0"'; if($getSize->IsActive == 0) echo 'selected="selected"'; echo '>Désactiver</option>
							<option value="1"'; if($getSize->IsActive == 1) echo 'selected="selected"'; echo '>Activer</option>
						</select>
					</div>
				</div>
				<input type="hidden" id="editSizeID" value="'.$getSize->ID.'"/>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					<button type="button" class="btn btn-primary" onclick="setEditSize('.$getSize->ID.'); return false;">Valider</button>
				</div>';
			}
		}
		else{
			echo '0';
		}
	}
	
	if(isset($_POST['editSize']) && isset($_POST['editSizeID']) && isset($_POST['editSizeName']) && isset($_POST['editShortSizeName']) && isset($_POST['IsActiveEditSize']) ){
		$getSizes = $db->query('SELECT * FROM `article-option-sizes` WHERE `ID`="'.$_POST['editSizeID'].'"');
		if($getSizes->num_rows == 1){
			$updateSizes = $db->query('UPDATE `article-option-sizes` SET `Name`="'.$_POST['editSizeName'].'", `ShortName`="'.$_POST['editShortSizeName'].'", `IsActive`="'.$_POST['IsActiveEditSize'].'" WHERE `ID`="'.$_POST['editSizeID'].'"');
			if($updateSizes){
				echo 'success';
			}
		}
		else{
			echo 'Cette taille n\'existe pas !';
		}
	}
	
	if(isset($_GET['isSize']) && isset($_GET['deleteSize']) && isset($_GET['sizeID'])){
		$getSizes = $db->query('SELECT * FROM `article-option-sizes` WHERE `ID`="'.$_GET['sizeID'].'"');
		if($getSizes->num_rows >= 1){
			while($getSize = $getSizes->fetch_object()){
				echo '<div class="modal-header header-custom">
					<h5 class="modal-title" id="smallmodalLabel">Suppression d\'une taille</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h4>Êtes-vous sûr de vouloir supprimer cette taille?</h4></br>
					<div class="alert alert-warning"><i class="fa fa-warning"></i>Cette suppression est définitive!</div>
				</div>
				<input type="hidden" id="deleteSizeID" value="'.$getSize->ID.'"/>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					<button type="button" class="btn btn-primary" onclick="setDeleteSize('.$getSize->ID.'); return false;">Supprimer</button>
				</div>';
			}
		}
		else{
			echo '0';
		}
	}
	
	if(isset($_POST['delSize']) && isset($_POST['deleteSizeID'])){
		$getSizes = $db->query('SELECT * FROM `article-option-sizes` WHERE `ID`="'.$_POST['deleteSizeID'].'"');
		if($getSizes->num_rows >= 1){
			$delSize = $db->query('DELETE FROM `article-option-sizes` WHERE `ID`="'.$_POST['deleteSizeID'].'"');
			if($delSize){
				echo 'success';
			}
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_POST['setAddGiftCertificate']) && isset($_POST['setAddReference']) && isset($_POST['setAddTotalAmount']) && isset($_POST['setAddLimitAmount']) && isset($_POST['setAddBuyDate']) && isset($_POST['setAddLimitDate']) && isset($_POST['setAddStatus'])){
		$getGiftCertificates = $db->query('SELECT * FROM `gift-certificates` WHERE `Reference`="'.$_POST['setAddReference'].'"');
		if($getGiftCertificates->num_rows == 0){
			$setGiftCertificate = $db->query('INSERT INTO `gift-certificates` (`Reference`,`TotalAmount`,`UsedAmount`,`BuyDate`,`LimitDate`,`IsActive`) VALUES
			("'.$_POST['setAddReference'].'","'.$_POST['setAddTotalAmount'].'","'.$_POST['setAddLimitAmount'].'","'.strtotime($_POST['setAddBuyDate']).'","'.strtotime($_POST['setAddLimitDate']).'","'.$_POST['setAddStatus'].'")');
			if($setGiftCertificate){
				echo 'success';
			}
			else{
				echo 'Erreur : La carte cadeau n\'a pas pu être éditée.INSERT INTO `gift-certificates` (`Reference`,`TotalAmount`,`UsedAmount`,`BuyDate`,`LimitDate`,`IsActive`) VALUES
			("'.$_POST['setAddReference'].'","'.$_POST['setAddTotalAmount'].'","'.$_POST['setAddLimitAmount'].'","'.strtotime($_POST['setAddBuyDate']).'","'.strtotime($_POST['setAddLimitDate']).'","'.$_POST['setAddStatus'].'")';
			}
		}
		else{
			echo 'Cette référence est déjà existante.';
		}
	}
	
	if(isset($_POST['setModGiftCertificate']) && isset($_POST['setModGiftCertificateID']) && isset($_POST['setAddReference']) && isset($_POST['setAddTotalAmount']) && isset($_POST['setAddLimitAmount']) && isset($_POST['setAddStatus'])){
		$getGiftCertificates = $db->query('SELECT * FROM `gift-certificates` WHERE `Reference`="'.$_POST['setAddReference'].'"');
		if($getGiftCertificates->num_rows == 1){
			$modGiftCertificate = $db->query('UPDATE `gift-certificates` SET `Reference`="'.$_POST['setAddReference'].'",`TotalAmount`="'.$_POST['setAddTotalAmount'].'",`UsedAmount`="'.$_POST['setAddLimitAmount'].'",`IsActive`="'.$_POST['setAddStatus'].'" WHERE `ID`="'.$_POST['setModGiftCertificateID'].'"');
			if($modGiftCertificate){
				echo 'success';
			}
			else{
				echo 'Erreur : La carte cadeau n\'a pas pu être mise à jour.';
			}
		}
		else{
			echo 'Cette référence n\'existe pas.';
		}
	}
	
	if(isset($_GET['isGiftCertificate']) && isset($_GET['deleteGiftCertificate']) && isset($_GET['giftCertificateID'])){
		$getGiftCertificates = $db->query('SELECT * FROM `gift-certificates` WHERE `ID`="'.$_GET['giftCertificateID'].'"');
		if($getGiftCertificates->num_rows == 1){
			$getGiftCertificate = $getGiftCertificates->fetch_object();
			echo '<div class="modal-header header-custom">
				<h5 class="modal-title" id="smallmodalLabel">Suppression d\'un chèque cadeau</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4>Êtes-vous sûr de vouloir supprimer ce moyen de chèque cadeau?</h4></br>
				<div class="alert alert-warning"><i class="fa fa-warning"></i>Cette suppression est définitive!</div>
			</div>
			<input type="hidden" id="deletePaymentID" value="'.$getGiftCertificate->ID.'"/>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
				<button type="button" class="btn btn-primary" onclick="setDeleteGiftCertificate('.$getGiftCertificate->ID.'); return false;">Supprimer</button>
			</div>';
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_POST['setDelGiftCertificate']) && isset($_POST['giftCertificateID'])){
		$getGiftCertificates = $db->query('SELECT * FROM `gift-certificates` WHERE `ID`="'.$_POST['giftCertificateID'].'"');
		if($getGiftCertificates->num_rows == 1){
			$delGiftCertificate = $db->query('DELETE FROM `gift-certificates` WHERE `ID`="'.$_POST['giftCertificateID'].'"');
			if($delGiftCertificate){
				echo 'success';
			}
		}
		else{
			echo 'Ce chèque cadeau n\'existe pas.';
		}
	}
	
	if(isset($_POST['setGiftCertificateStatus']) && isset($_POST['giftCertificateStatus']) && isset($_POST['giftCertificateID'])){
		$getGiftCertificates = $db->query('SELECT * FROM `gift-certificates` WHERE `ID`="'.$_POST['giftCertificateID'].'"');
		if($getGiftCertificates->num_rows == 1){
			$updGiftCertificate = $db->query('UPDATE `gift-certificates` SET `IsActive`="'.$_POST['giftCertificateStatus'].'" WHERE `ID`="'.$_POST['giftCertificateID'].'"');
			if($updGiftCertificate){
				echo 'success';
			}
			else{
				echo 'Une erreur interne c\'est produite, contactez l\'administrateur si le problème persiste !';
			}
		}
		else{
			echo 'Ce chèque cadeau n\'existe pas.';
		}
	}
	
?>