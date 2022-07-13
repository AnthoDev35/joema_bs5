<?php require_once('includes/header.php');?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-3">Ajouter un carrousel</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
								<form method="POST" id="submit-add-carrousel">
									<div class="card">
										<div class="card-header">Ajout d'un carrousel</div>
										<div class="card-body card-block">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="my-auto">Séléctionnez une catégorie</label>
														<select class="form-control" id="setCarrouselCategorieID">
															<option value="-1">Séléctionnez une catégorie</option>
															<?php $getCarrouselCategories = $db->query('SELECT * FROM `article-categories`');
															if($getCarrouselCategories->num_rows >= 1){
																while($getCarrouselCategorie = $getCarrouselCategories->fetch_object()){
																	echo '<option value="'.$getCarrouselCategorie->ID.'">'.utf8_encode($getCarrouselCategorie->Name).'</option>';
																}
															}
															else{
																echo '<option value="0">Vous devez créer une catégorie et insérer des articles avant de créer un carrousel !</option>';
															}?>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">Titre</label>
														<input type="text" class="form-control" id="setCarrouselTitle" value="" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">Pourcentage de réduction</label> <small>(exemple : "20" pour "-20%")</small>
														<input type="text" class="form-control" id="setCarrouselReduction" value="" />
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label class="my-auto">Description</label>
														<textarea  class="form-control" value="" rows="5" id="setCarrouselDescription"></textarea>
													</div>
												</div>
												<div class="col-md-12">
													<!-- show error-->
													<div id="setResultImgCarrousel" style="display:none"></div>
													<!-- show preview-->
													<div id="setCarrouselImagePreview" style="display:none"></div><button class="btn btn-danger btn-xs pull-right" title="Supprimer l'image" id="btn-del-carrousel-image" onclick="setCarrouselImgDelete(); return false;" style="display:none"><i class="fa fa-remove"></i></button>
													<div class="form-group files" id="setCarrouselImageUpload">
														<label class="my-auto">Ajouter une image</label>
														<input type="file" class="form-control" id="setCarrouselImage" onchange="setCarrouselImg(); return false;"/>
														<input type="hidden" id="setCarrouselImageRenamed" value=""/>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label class="my-auto">Activer le carrousel</label>
														<select class="form-control" id="setIsActive">
															<option value="0">Désactivé</option>
															<option value="1" selected="selected">Activé</option>
														</select>
													</div>
												</div>
											</div>
											<div class="card-footer">
												<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Annuler</button>
												<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-dot-circle-o"></i> Enregistrer</button>
											</div>
										</div>
									</div>
								</form>
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