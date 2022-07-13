<?php require_once('includes/header.php');?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content">
                    <div class="container-fluid">
						<?php if(isset($_GET['addNewGift']) && $_GET['addNewGift'] == 'success'){
							echo '<div class="row">
								<div class="col-md-12 mb-1">
									<div class="alert alert-success">Le chèque cadeau à bien été enregistré!</div>
								</div>
							</div>';
						}
						if(isset($_GET['addNewMailGift']) && $_GET['addNewMailGift'] == 'success'){
							echo '<div class="row">
								<div class="col-md-12 mb-1">
									<div class="alert alert-success">Le chèque cadeau à bien été enregistré et envoyé par email à son bénéficiaire!</div>
								</div>
							</div>';
						}
						if(isset($_GET['modGift']) && $_GET['modGift'] == 'success'){
							echo '<div class="row">
								<div class="col-md-12 mb-1">
									<div class="alert alert-success">Le chèque cadeau à bien été modifié!</div>
								</div>
							</div>';
						}
						if(isset($_GET['deleteGift']) && $_GET['deleteGift'] == 'success'){
							echo '<div class="row">
								<div class="col-md-12 mb-1">
									<div class="alert alert-success">Le chèque cadeau à bien été supprimé!</div>
								</div>
							</div>';
						}
						if(isset($_GET['updateGift']) && $_GET['updateGift'] == 'success'){
							echo '<div class="row">
								<div class="col-md-12 mb-1">
									<div class="alert alert-success">Le chèque cadeau à bien été mis à jour!</div>
								</div>
							</div>';
						}
						?>
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-3">Gestion des chèques cadeaux</h2>
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
                                                <th>Référence</th>
                                                <th>Montant total</th>
                                                <th>Montant utilisé</th>
                                                <th>Date d'achat</th>
                                                <th>Date limite</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php $getGiftCertificates = $db->query('SELECT * FROM `gift-certificates`');
											if($getGiftCertificates->num_rows >= 1){
												while($getGiftCertificate = $getGiftCertificates->fetch_object()){
													echo '<tr class="tr-shadow">
														<td class="sticky-col first-col">
															<div class="table-data-feature">
																<a class="item-info" data-toggle="tooltip" data-placement="top" title="Modifier" href="mod_gift_certificate.php?giftCertificateID='.$getGiftCertificate->ID.'"><i class="fa fa-edit"></i></a>
																<button class="item" data-toggle="tooltip" data-placement="top" title="Supprimer" onclick="getDeleteGiftCertificate('.$getGiftCertificate->ID.'); return false;"><i class="fa fa-trash"></i></button>';
																if($getCarrousel->IsActive == 0){
																	echo '<button class="item-success" data-toggle="tooltip" data-placement="top" title="Activer" onclick="setGiftCertificateStatus('.$getGiftCertificate->ID.',1); return false;"><i class="fa fa-check"></i></button>';
																}
																else{
																	echo '<button class="item-danger" data-toggle="tooltip" data-placement="top" title="Désactiver" onclick="setGiftCertificateStatus('.$getGiftCertificate->ID.',0); return false;"><i class="fa fa-remove"></i></button>';
																}
															echo '</div>
														</td>
														<td>'.$getGiftCertificate->Reference.'</td>
														<td>'.number_format($getGiftCertificate->TotalAmount, 2).'€</td>
														<td>'.number_format($getGiftCertificate->UsedAmount, 2).'€</td>
														<td>'.date('d/m/Y', $getGiftCertificate->BuyDate).'</td>
														<td>'.date('d/m/Y', $getGiftCertificate->LimitDate).'</td>';
														if($getGiftCertificate->IsActive == 1)
															$isActive = '<span class="status--process">Actif</span>';
														else
															$isActive = '<span class="status--denied">Inactif</span>';
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