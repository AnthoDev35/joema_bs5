<?php require_once('includes/header.php');?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Gestion des catégories<button class="btn btn-primary pull-right" onclick="getAddedCategorie(); return false;">Ajouter une catégorie</button></h2>
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
                                                <th>Image</th>
                                                <th>Nom</th>
                                                <th>Bannière</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php $getCategories = $db->query('SELECT * FROM `article-categories`');
											if($getCategories->num_rows >= 1){
												while($getCategorie = $getCategories->fetch_object()){
													echo '<tr class="tr-shadow">
														<input type="hidden" id="getCategorieID" value ="'.$getCategorie->ID.'"/>
														<td class="sticky-col first-col">
															<div class="table-data-feature">
																<button class="item-primary" data-toggle="tooltip" data-placement="top" title="Editer"  onclick="getEditCategorie('.$getCategorie->ID.'); return false;"><i class="fa fa-pencil"></i></button>
																<button class="item-danger" data-toggle="tooltip" data-placement="top" title="Supprimer"  onclick="getDeleteCategorie('.$getCategorie->ID.'); return false;"><i class="fa fa-trash"></i></button>
															</div>
														</td>
														<td><img src="../'.$getCategorie->Image.'" class="img-fluid" width="100px"/></td>
														<td>'.ucfirst($getCategorie->Name).'</td>';
														if($getCategorie->Banner == 1)
															echo '<td><span class="status--process" title="Affiché dans la bannière de la page d\'accueil">Oui</span></td>';
														else
															echo '<td><span class="status--denied" title="N\'est pas affiché dans la bannière de la page d\'accueil">Non</span></td>';
														if($getCategorie->IsActive == 1)
															echo '<td><span class="status--process">Activé</span></td>';
														else
															echo '<td><span class="status--denied">Désactivé</span></td>';
													echo '</tr>
													<tr class="spacer"></tr>';
												}
											}
											?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Gestion des sous-catégories<button class="btn btn-primary pull-right" onclick="getAddedSubCategorie(); return false;">Ajouter une sous-catégorie</button></h2>
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
                                                <th>Catégorie</th>
                                                <th>Nom</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php $getSubCategories = $db->query('SELECT * FROM `article-sub-categories`');
											if($getSubCategories->num_rows >= 1){
												while($getSubCategorie = $getSubCategories->fetch_object()){
													echo '<tr class="tr-shadow">
														<td class="sticky-col first-col">
															<div class="table-data-feature">
																<button class="item-primary" data-toggle="tooltip" data-placement="top" title="Editer" onclick="getEditSubCategorie('.$getSubCategorie->ID.'); return false;"><i class="fa fa-pencil"></i></button>
																<button class="item-danger" data-toggle="tooltip" data-placement="top" title="Supprimer" onclick="getDeleteSubCategorie('.$getSubCategorie->ID.'); return false;"><i class="fa fa-trash"></i></button>
															</div>
														</td>
														<td>'.$getSubCategorie->ID.'</td>';
														$getCategories = $db->query('SELECT * FROM `article-categories` WHERE ID="'.$getSubCategorie->CategorieID.'" LIMIT 1');
														$getCategorie = $getCategories->fetch_object();
														echo '<td>'.$getCategorie->Name.'</td>
														<td>'.$getSubCategorie->Name.'</td>';
														if($getSubCategorie->IsActive == 1)
															echo '<td><span class="status--process">Activé</span></td>';
														else
															echo '<td><span class="status--denied">Désactivé</span></td>';
													echo '</tr>
													<tr class="spacer"></tr>';
												}
											}
											?>
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