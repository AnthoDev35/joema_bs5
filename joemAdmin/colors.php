<?php require_once('includes/header.php');?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Gestion des couleurs d'article<button class="btn btn-primary btn-sm pull-right" onclick="getAddedColor(); return false;">Ajouter une couleur</button></h2>
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
                                                <th>Nom de l'article</th>
                                                <th>Stock</th>
                                                <th>Nom</th>
                                                <th>Couleur</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$numColorsPage = 10;
											$getAllColors = $db->query('SELECT * FROM `article-option-colors` ORDER BY `ArticleID` ASC');
											$numColors = $getAllColors->num_rows;
											$colorPages = ceil($numColors/$numColorsPage);
											$pageColorNb = 1;
											$adjacents = 2;
											$lpm1 = $colorPages - 1;
											if($_GET['colorPage'] != '' && $_GET['colorPage'] != 0){
												$pageColorNb = $_GET['colorPage'];
											}
											$start = ($pageColorNb * $numColorsPage) - $numColorsPage;
											if($numColors >= 1){
												$getColors = $db->query('SELECT * FROM `article-option-colors` ORDER BY `ArticleID` ASC LIMIT '.$start.', '.$numColorsPage);
												while($getColor = $getColors->fetch_object()){
													$getArticle = $db->query('SELECT * FROM `articles` WHERE `ID`="'.$getColor->ArticleID.'" LIMIT 1')->fetch_object();
													if($getColor->Stock >= 2){
														$stockColor = '#00D31C';
													}
													else{
														$stockColor = '#CC2800';
													}
													echo '<tr class="tr-shadow">
														<td class="sticky-col first-col">
															<div class="table-data-feature">
																<button class="item-primary" data-toggle="tooltip" data-placement="top" title="Editer"  onclick="getEditColor('.$getColor->ID.'); return false;"><i class="fa fa-pencil"></i></button>
																<button class="item-danger" data-toggle="tooltip" data-placement="top" title="Supprimer"  onclick="getDeleteColor('.$getColor->ID.'); return false;"><i class="fa fa-trash"></i></button>
															</div>
														</td>
														<td>'.$getArticle->Name.'</td>
														<td style="color:#fff; font-weight:bold; background: '.$stockColor.';">'.$getColor->Stock.'</td>
														<td>'.$getColor->Name.'</td>
														<td style="background-color:#'.$getColor->Color.'"></td>
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
										<?php if($colorPages > 1){   
											if ($colorPages < 7 + ($adjacents * 2)){   
												for ($i = 1; $i <= $colorPages; $i++){
													echo '<li class="page-item '; if($i == $pageColorNb) echo 'active'; echo '"><a class="page-link" href="colors.php?colorPage='.$i.'">'.$i.'</a></li>';
												}
											}
											elseif($colorPages > 5 + ($adjacents * 2)){
												if($pageColorNb < 1 + ($adjacents * 2)){
													for ($i = 1; $i < 4 + ($adjacents * 2); $i++){
														echo '<li class="page-item '; if($i == $pageColorNb) echo 'active'; echo '"><a class="page-link" href="colors.php?colorPage='.$i.'">'.$i.'</a></li>';
													}
													echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
													echo '<li class="page-item"><a class="page-link" href="colors.php?colorPage='.$lpm1.'">'.$lpm1.'</a></li>';
													echo '<li class="page-item"><a class="page-link" href="colors.php?colorPage='.$colorPages.'">'.$colorPages.'</a></li>';       
												}
												elseif($colorPages - ($adjacents * 2) > $pageColorNb && $pageColorNb > ($adjacents * 2)){
													echo '<li class="page-item"><a class="page-link" href="colors.php?colorPage=1">1</a></li>';
													echo '<li class="page-item"><a class="page-link" href="colors.php?colorPage=2">2</a></li>';
													echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
													for ($i = $pageColorNb - $adjacents; $i <= $pageColorNb + $adjacents; $i++){
														echo '<li class="page-item '; if($i == $pageColorNb) echo 'active'; echo '"><a class="page-link" href="colors.php?colorPage='.$i.'">'.$i.'</a></li>';      
													}
													echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
													echo '<li class="page-item"><a class="page-link" href="colors.php?colorPage='.$lpm1.'">'.$lpm1.'</a></li>';
													echo '<li class="page-item"><a class="page-link" href="colors.php?colorPage='.$colorPages.'">'.$colorPages.'</a></li>';       
												}
												else
												{
													echo '<li class="page-item"><a class="page-link" href="colors.php?colorPage=1">1</a></li>';
													echo '<li class="page-item"><a class="page-link" href="colors.php?colorPage=2">2</a></li>';
													echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
													for ($i = $colorPages - (2 + ($adjacents * 2)); $i <= $colorPages; $i++){
														echo '<li class="page-item '; if($i == $pageColorNb) echo 'active'; echo '"><a class="page-link" href="colors.php?colorPage='.$i.'">'.$i.'</a></li>';      
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
