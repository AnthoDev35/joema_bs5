<?php require_once('includes/header.php');?>
            <div class="main-content">
                <div class="section__content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Gestion des tailles<button class="btn btn-primary pull-right" onclick="getAddedSize(); return false;">Ajouter une taille</button></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table-responsive-data2 mb-4">
                                    <table class="table table-data2">
                                        <thead>
                                            <tr>
                                                <th class="sticky-col-head first-col">Action</th>
                                                <th>Image</th>
                                                <th>Article</th>
                                                <th>Référence</th>
                                                <th>Stock</th>
                                                <th>Nom complet</th>
                                                <th>Nom court</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php $getAllSizes = $db->query('SELECT * FROM `article-option-sizes` ORDER BY `ArticleID` ASC');
											$numSizesPage = 10;
											$numSizes = $getAllSizes->num_rows;
											$sizePages = ceil($numSizes/$numSizesPage);
											$pageSizeNb = 1;
											$adjacents = 2;
											$lpm1 = $sizePages - 1;
											if($_GET['sizePage'] != '' && $_GET['sizePage'] != 0){
												$pageSizeNb = $_GET['sizePage'];
											}
											$start = ($pageSizeNb * $numSizesPage) - $numSizesPage;
											if($numSizes >= 1){
												$getSizes = $db->query('SELECT * FROM `article-option-sizes` ORDER BY `ArticleID` ASC LIMIT '.$start.', '.$numSizesPage);
												while($getSize = $getSizes->fetch_object()){
													$getArticle = $db->query('SELECT * FROM `articles` WHERE `ID`="'.$getSize->ArticleID.'" LIMIT 1')->fetch_object();
													if($getSize->Stock >= 2){
														$stockColor = '#00D31C';
													}
													else{
														$stockColor = '#CC2800';
													}
													echo '<tr class="tr-shadow">
														<td class="sticky-col first-col">
															<div class="table-data-feature">
																<button class="item-primary" data-toggle="tooltip" data-placement="top" title="Editer"  onclick="getEditSize('.$getSize->ID.'); return false;"><i class="fa fa-pencil"></i></button>
																<button class="item-danger" data-toggle="tooltip" data-placement="top" title="Supprimer"  onclick="getDeleteSize('.$getSize->ID.'); return false;"><i class="fa fa-trash"></i></button>
															</div>
														</td>
														<td><img src="../'.$getArticle->Image1.'" class="img-fluid" width="50px"/></td>
														<td>'.$getArticle->Name.'</td>
														<td>'.$getArticle->Reference.'</td>
														<td style="color:#fff; font-weight:bold; background: '.$stockColor.';">'.$getSize->Stock.'</td>
														<td>'.$getSize->Name.'</td>
														<td>'.$getSize->ShortName.'</td>
													</tr>
													<tr class="spacer"></tr>';
												}
											}
											?>
                                        </tbody>
                                    </table>
                                </div>
								<div class="articles-pagination">
									<ul class="pagination">
										<?php if($sizePages > 1){   
											if ($sizePages < 7 + ($adjacents * 2)){   
												for ($i = 1; $i <= $sizePages; $i++){
													echo '<li class="page-item '; if($i == $pageSizeNb) echo 'active'; echo '"><a class="page-link" href="sizes.php?sizePage='.$i.'">'.$i.'</a></li>';
												}
											}
											elseif($sizePages > 5 + ($adjacents * 2)){
												if($pageSizeNb < 1 + ($adjacents * 2)){
													for ($i = 1; $i < 4 + ($adjacents * 2); $i++){
														echo '<li class="page-item '; if($i == $pageSizeNb) echo 'active'; echo '"><a class="page-link" href="sizes.php?sizePage='.$i.'">'.$i.'</a></li>';
													}
													echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
													echo '<li class="page-item"><a class="page-link" href="sizes.php?sizePage='.$lpm1.'">'.$lpm1.'</a></li>';
													echo '<li class="page-item"><a class="page-link" href="sizes.php?sizePage='.$sizePages.'">'.$sizePages.'</a></li>';       
												}
												elseif($sizePages - ($adjacents * 2) > $pageSizeNb && $pageSizeNb > ($adjacents * 2)){
													echo '<li class="page-item"><a class="page-link" href="sizes.php?sizePage=1">1</a></li>';
													echo '<li class="page-item"><a class="page-link" href="sizes.php?sizePage=2">2</a></li>';
													echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
													for ($i = $pageSizeNb - $adjacents; $i <= $pageSizeNb + $adjacents; $i++){
														echo '<li class="page-item '; if($i == $pageSizeNb) echo 'active'; echo '"><a class="page-link" href="sizes.php?sizePage='.$i.'">'.$i.'</a></li>';      
													}
													echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
													echo '<li class="page-item"><a class="page-link" href="sizes.php?sizePage='.$lpm1.'">'.$lpm1.'</a></li>';
													echo '<li class="page-item"><a class="page-link" href="sizes.php?sizePage='.$sizePages.'">'.$sizePages.'</a></li>';       
												}
												else
												{
													echo '<li class="page-item"><a class="page-link" href="sizes.php?sizePage=1">1</a></li>';
													echo '<li class="page-item"><a class="page-link" href="sizes.php?sizePage=2">2</a></li>';
													echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
													for ($i = $sizePages - (2 + ($adjacents * 2)); $i <= $sizePages; $i++){
														echo '<li class="page-item '; if($i == $pageSizeNb) echo 'active'; echo '"><a class="page-link" href="sizes.php?sizePage='.$i.'">'.$i.'</a></li>';      
													}
												}
											}
										} ?>
									</ul>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once('includes/footer.php');?>