<?php require_once('includes/header.php');
	if(isset($_GET['carrouselID'])){
		$response = '';
		$getCarrousels = $db->query('SELECT * FROM `carrousels` WHERE `ID`="'.$_GET['carrouselID'].'"');
		if($getCarrousels->num_rows >= 1){
			while($getCarrousel = $getCarrousels->fetch_object()){
				$response .= '<div class="row">
					<input type="hidden" id="carrouselID" value="'.$getCarrousel->ID.'"/>
					<div class="col-md-12">
						<div class="form-group">
							<label class="my-auto">Séléctionnez une catégorie</label>
							<select class="form-control" id="setCarrouselCategorieID">
								<option value="-1">Séléctionnez une catégorie</option>';
								$getCarrouselCategories = $db->query('SELECT * FROM `article-categories`');
								if($getCarrouselCategories->num_rows >= 1){
									while($getCarrouselCategorie = $getCarrouselCategories->fetch_object()){
										$response .= '<option value="'.$getCarrouselCategorie->ID.'"'; if($getCarrouselCategorie->ID == $getCarrousel->ID){$response .= 'selected="selected"';} $response .= '>'.$getCarrouselCategorie->Name.'</option>';
									}
								}
								else{
									$response .= '<option value="0">Vous devez créer une catégorie et insérer des articles avant de créer un carrousel !</option>';
								}
							$response .= '</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="my-auto">Titre</label>
							<input type="text" class="form-control" id="setCarrouselTitle" value="'.$getCarrousel->Title.'" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="my-auto">Pourcentage de réduction</label> <small>(exemple : "20" pour "-20%")</small>
							<input type="text" class="form-control" id="setCarrouselReduction" value="'.$getCarrousel->DiscountPct.'" />
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="my-auto">Description</label>
							<textarea  class="form-control" value="" rows="5" id="setCarrouselDescription">'.$getCarrousel->Description.'</textarea>
						</div>
					</div>
					<div class="col-md-12">
						<!-- show error-->
						<div id="setResultImgCarrousel" style="display:none"></div>
						<!-- show preview-->
						<div id="setCarrouselImagePreview" '; if($getCarrousel->Image == '' || $getCarrouselCategorie->Image == 'assets/img/carrousels/'){ $response .= 'style="display:none"';} $response .= '><img class="img-fluid" src="../'.$getCarrousel->Image.'" width="200px"/></div><button class="btn btn-danger btn-xs pull-right" title="Supprimer l\'image" id="btn-del-carrousel-image" onclick="setCarrouselImgDelete(); return false;" '; if($getCarrousel->Image == '' || $getCarrousel->Image == 'assets/img/carrousels/'){ $response .= 'style="display:none"';} $response .= '><i class="fa fa-remove"></i></button>
						<div class="form-group files" id="setCarrouselImageUpload">
							<label class="my-auto">Ajouter une image</label>
							<input type="file" class="form-control" id="setCarrouselImage" onchange="setCarrouselImg(); return false;" '; if($getCarrousel->Image != '' || $getCarrousel->Image != 'assets/img/carrousels/'){ $response .= 'style="display:none"';} $response .= '/>
							<input type="hidden" id="setCarrouselImageRenamed" value="'.$getCarrousel->Image.'"/>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="my-auto">Activer le carrousel</label>
							<select class="form-control" id="setIsActive">
								<option value="0"'; if($getCarrousel->IsActive == 0){$response .= 'selected="selected"';} $response .= '>Désactivé</option>
								<option value="1"'; if($getCarrousel->IsActive == 1){$response .= 'selected="selected"';} $response .= '>Activé</option>
							</select>
						</div>
					</div>
				</div>';
			}
		}
		else{
			$response .= '<div class="row">
				<div class="col-md-12">
					<div class="alert alert-warning">Le carrousel séléctionné n\'existe pas ou a été supprimés!</div>
				</div>
			</div>';
		}
	}
	else{
		$response .= '<div class="row">
			<div class="col-md-12"><div class="alert alert-danger">Vous devez séléctionner un carrousel !</div></div>
		</div>';
	}
?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-3">Modifier un carrousel</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
									<form method="POST" id="submit-mod-carrousel">
										<div class="card-header">Modification du carrousel ""</div>
										<div class="card-body card-block"><?=$response?></div>
										<div class="card-footer">
											<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Annuler</button>
											<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-dot-circle-o"></i> Enregistrer</button>
										</div>
									</form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php require_once('includes/footer.php');?>
<script>
	if(document.querySelector('#setCarrouselDescription') !== null ){
		CKEDITOR.replace( 'setCarrouselDescription' );
	}
</script>