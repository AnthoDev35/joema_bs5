<?php require_once('includes/header.php');?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-3">Ajouter un article</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">Ajout d'un article</div>
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal" id="setAddArticleForm">
										<div class="card-body card-block">
                                            <div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="select" class=" form-control-label">Séléctionnez une catégorie :</label><button type="button" class="btn btn-sm btn-primary pull-right" onclick="getAddDataModal('categorie')">Ajouter</button>
														<select name="selectArtCategorie" class="form-control" id="setArtCategorie" onchange="getSubCategorieDatas(this.value); return false;">
															<option value="-1">Séléctionnez une catégorie</option>
															<?php $getCategories = $db->query('SELECT * FROM `article-categories`');
															if($getCategories->num_rows >= 1){
																while($getCategorie = $getCategories->fetch_object()){
																	echo '<option value="'.$getCategorie->ID.'">'.$getCategorie->Name.'</option>';
																}
															} ?>
														</select>
														<small class="form-text text-muted">.</small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="select" class=" form-control-label">Séléctionnez une sous-catégorie :</label><button type="button" class="btn btn-sm btn-primary pull-right" onclick="getAddDataModal('subCategorie')">Ajouter</button>
														<select name="selectArtSubCategorie" class="form-control" id="setArtSubCategorie">
															<option value="-1">Séléctionnez une catégorie</option>
														</select>
														<small class="form-text text-muted">.</small>
													</div>
												</div>
                                            </div>
                                            <div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="text-input" class=" form-control-label">Nom de l'article :</label>
														<input type="text" id="setArticleName" name="setArticleName" placeholder="Nom de l'article" class="form-control">
														<small class="form-text text-muted">Nom de votre article.</small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="text-input" class=" form-control-label">Référence de l'article :</label>
														<input type="text" id="setArtRef" name="setArtRef" placeholder="Référence de l'article" class="form-control">
														<small class="form-text text-muted">Référence de l'article.</small>
													</div>
												</div>
											</div>
                                            <div class="form-group">
												<label for="text-input" class=" form-control-label">Description de l'article :</label>
												<textarea type="text" id="setArtDescription" name="setArtDescription" placeholder="Text" class="form-control" rows="5"></textarea>
												<small class="form-text text-muted">.</small>
											</div>
                                            <div class="row">
												<div class="col-md-6">
													<!-- show error-->
													<div id="setResultImgUpload1" style="display:none"></div>
													<!-- show preview-->
													<div id="setArtImagePreview1" style="display:none"></div><button class="btn btn-danger btn-xs pull-right" title="Supprimer l'image" id="btn-del-image1" onclick="setImageDelete('1'); return false;" style="display:none;"><i class="fa fa-remove"></i></button>
													<div class="form-group files" id="setArtImageUpload1">
														<label class="my-auto">Ajouter une image 1</label>
														<input type="file" class="form-control" accept="image/*" id="setArtImage1" onchange="setArticleImage('1'); return false;"/>
														<input type="hidden" id="setArtImageRenamed1" value="assets/img/products/"/>
													</div>
												</div>
												<div class="col-md-6">
													<div id="setResultImgUpload2" style="display:none"></div>
													<div id="setArtImagePreview2" style="display:none"></div><button class="btn btn-danger btn-xs pull-right" title="Supprimer l'image" id="btn-del-image2" onclick="setImageDelete('2'); return false;" style="display:none;"><i class="fa fa-remove"></i></button>
													<div class="form-group files" id="setArtImageUpload2">
														<label class="my-auto">Ajouter une image 2</label>
														<input type="file" class="form-control" accept="image/*" id="setArtImage2" onchange="setArticleImage('2'); return false;"/>
														<input type="hidden" id="setArtImageRenamed2" value="assets/img/products/"/>
													</div>
												</div>
												<div class="col-md-6">
													<div id="setResultImgUpload3" style="display:none"></div>
													<div id="setArtImagePreview3" style="display:none"></div><button class="btn btn-danger btn-xs pull-right" title="Supprimer l'image" id="btn-del-image3" onclick="setImageDelete('3'); return false;" style="display:none;"><i class="fa fa-remove"></i></button>
													<div class="form-group files" id="setArtImageUpload3">
														<label class="my-auto">Ajouter une image 3</label>
														<input type="file" class="form-control" accept="image/*" id="setArtImage3" onchange="setArticleImage('3'); return false;"/>
														<input type="hidden" id="setArtImageRenamed3" value="assets/img/products/"/>
													</div>
												</div>
												<div class="col-md-6">
													<div id="setResultImgUpload4" style="display:none"></div>
													<div id="setArtImagePreview4" style="display:none"></div><button class="btn btn-danger btn-xs pull-right" title="Supprimer l'image" id="btn-del-image4" onclick="setImageDelete('4'); return false;" style="display:none;"><i class="fa fa-remove"></i></button>
													<div class="form-group files" id="setArtImageUpload4">
														<label class="my-auto">Ajouter une image 4</label>
														<input type="file" class="form-control" accept="image/*" id="setArtImage4" onchange="setArticleImage('4'); return false;"/>
														<input type="hidden" id="setArtImageRenamed4" value="assets/img/products/"/>
													</div>
												</div>
											</div>
                                            <div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="setArtWeight" class="form-control-label">Poid en kg : <small>Exemple : 200grammes = 0.2</small></label>
														<input name="setArtWeight" id="setArtWeight" class="form-control" placeholder="0.2 ou 0.8 ou 1.0 ou 1.8">
														<small class="form-text text-muted">.</small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="setArtIsNew" class="form-control-label">Afficher dans la bannière "nouveaux articles"</label>
														<select name="setArtIsNew" id="setArtIsNew" class="form-control">
															<option value="0" selected="selected">Non</option>
															<option value="1">Oui</option>
														</select>
														<small class="form-text text-muted">.</small>
													</div>
												</div>
                                            </div>
                                            <div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label for="select" class=" form-control-label">Séléctionnez la méthode de gestion de stock :</label>
														<select id="artStockManager" class="form-control" onchange="getStockManager(this.value); return false;">
															<option value="-1">Séléctionnez la gestion du stock</option>
															<option value="0">Gestion de stock normal</option>
															<option value="1">Gestion de stock par couleur</option>
															<option value="2">Gestion de stock par taille</option>
															<option value="3">Gestion de stock par taille et par couleur</option>
														</select>
														<small class="form-text text-muted">.</small>
													</div>
												</div>
											</div>
                                            <div class="row" id="stockNormalManager" style="display:none;">
												<div class="col-md-6" id="stockNormalQuantity">
													<div class="form-group">
														<label for="setArtStock" class=" form-control-label">Quantité en stock :</label>
														<select name="setArtStock" id="setArtStock" class="form-control">
															<option value="-1">Séléctionnez le stock</option>
															<?php for($i=0; $i <= 30; $i++){
																echo '<option value="'.$i.'">'.$i.'</option>';
															}?>
														</select>
														<small class="form-text text-muted">.</small>
													</div>
												</div>
												<div class="" id="stockNormalShipment">
													<div class="form-group">
														<label for="setArtShipment" class=" form-control-label">Délai d'expédition :</label>
														<select name="setArtShipment" id="setArtShipment" class="form-control">
															<option value="-1">Séléctionnez le délai d'expédition</option>
															<option value="0">Immédiatement</option>
															<option value="1">1 jours</option>
															<option value="2">2 jours</option>
															<option value="3">3 jours</option>
															<option value="4">4 jours</option>
															<option value="5">5 jours</option>
															<option value="10">> 5 jours</option>
														</select>
														<small class="form-text text-muted">.</small>
													</div>
												</div>
                                            </div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="setArtNormalPrice" class=" form-control-label">Prix :</label>
														<input type="text" id="setArtNormalPrice" name="setArtNormalPrice" placeholder="20.00" class="form-control">
														<small class="form-text text-muted">Prix de votre article HT.</small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="setArtReducePrice" class=" form-control-label">Prix remisé :</label>
														<input type="text" id="setArtReducePrice" name="setArtReducePrice" placeholder="10.00" class="form-control">
														<small class="form-text text-muted">Prix remisé de votre article HT.</small>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="select" class=" form-control-label">Dernière chance :</label></br>
														<div class="form-check">
															<div class="radio">
																<label for="setArtLastChance" class="form-check-label">
																	<input type="radio" name="setArtLastChance" value="1" class="form-check-input">Oui
																</label>
															</div>
															<div class="radio">
																<label for="setArtLastChance" class="form-check-label ">
																	<input type="radio" name="setArtLastChance" value="0" class="form-check-input" checked="checked">Non
																</label>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="setArtIsActive" class=" form-control-label">Activer l'article :</label>
														<div class="form-check">
															<div class="radio">
																<label for="setArtIsActive" class="form-check-label">
																	<input type="radio" name="setArtIsActive" value="1" class="form-check-input">Oui
																</label>
															</div>
															<div class="radio">
																<label for="setArtIsActive" class="form-check-label ">
																	<input type="radio" name="setArtIsActive" value="0" class="form-check-input" checked="checked">Non
																</label>
															</div>
														</div>
														<small class="form-text text-muted">.</small>
													</div>
												</div>
											</div>
										</div>
										<div class="card-footer">
											<a href="articles.php" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Annuler</a>
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
	if(document.querySelector('#setArtDescription') !== null ){
		CKEDITOR.replace( 'setArtDescription' );
	}
	$('#setMultiColors').multiselect({
		buttonContainer: '<div class="btn-group w-100" />',
		nonSelectedText:"Séléctionnez une option",
		nSelectedText:"selectionné(s)",
		allSelectedText:"Tous selectionnés",
		resetButtonText:"Réinitialisé",
		enableHTML: true
	});
	$('#setMultiSizes').multiselect({
		buttonContainer: '<div class="btn-group w-100" />',
		nonSelectedText:"Séléctionnez une option",
		nSelectedText:"selectionné(s)",
		allSelectedText:"Tous selectionnés",
		resetButtonText:"Réinitialisé",
		enableHTML: true
	});
</script>