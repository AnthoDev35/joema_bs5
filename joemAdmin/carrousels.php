<?php require_once('includes/header.php');?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-3">Gestion des carrousels</h2>
									<small> (bandeaux de promotion en page d'accueil)</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table-responsive-data2 m-b-40">
                                    <table class="table table-data2">
                                        <thead>
                                            <tr>
                                                <th class="sticky-col-head first-col">Action</th>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Catégorie</th>
                                                <th>Titre</th>
                                                <th>Description</th>
                                                <th>Promotion</th>
                                                <th>Active</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php $getCarrousels = $db->query('SELECT * FROM `carrousels`');
											if($getCarrousels->num_rows >= 1){
												while($getCarrousel = $getCarrousels->fetch_object()){
													echo '<tr class="tr-shadow">
														<td class="sticky-col first-col">
															<div class="table-data-feature">
																<a href="mod_carrousel.php?carrouselID='.$getCarrousel->ID.'" class="item-primary" data-toggle="tooltip" data-placement="top" title="Editer"><i class="fa fa-edit"></i></a>
																<button class="item" data-toggle="tooltip" data-placement="top" title="Supprimer" onclick="setCarrouselDelete('.$getCarrousel->ID.'); return false;"><i class="fa fa-trash"></i></button>
																<button class="item-info" data-toggle="tooltip" data-placement="top" title="Afficher"><i class="fa fa-info"></i></button>';
																if($getCarrousel->IsActive == 0){
																	echo '<button class="item-success" data-toggle="tooltip" data-placement="top" title="Activer" onclick="setCarrouselStatus('.$getCarrousel->ID.',1); return false;"><i class="fa fa-check"></i></button>';
																}
																else{
																	echo '<button class="item-danger" data-toggle="tooltip" data-placement="top" title="Désactiver" onclick="setCarrouselStatus('.$getCarrousel->ID.',0); return false;"><i class="fa fa-remove"></i></button>';
																}
															echo '</div>
														</td>
														<td>'.$getCarrousel->ID.'</td>';
														if($getCarrousel->Image != ''){
															echo '<td><img src="../'.$getCarrousel->Image.'" class="img-fluid"/></td>';
														}
														else{
															echo '<td>Inconnu</td>';
														}
														$getCategories = $db->query('SELECT * FROM `article-categories` WHERE `ID`="'.$getCarrousel->CategorieID.'"');
														if($getCategories->num_rows >= 1){
															$getCategorie = $getCategories->fetch_object();
															echo '<td>'.$getCategorie->Name.'</td>';
														}
														echo '<td>'.$getCarrousel->Title.'</td>
														<td>'.$getCarrousel->Description.'</td>
														<td>-'.$getCarrousel->DiscountPct.'</td>';
														if($getCarrousel->IsActive == 1)
															$isActive = '<span class="status--process">Oui</span>';
														else
															$isActive = '<span class="status--denied">Non</span>';
														echo '<td>'.$isActive.'</td>
													</tr>
													<tr class="spacer"></tr>';
												}
											} ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php require_once('includes/footer.php');?>