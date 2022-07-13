<?php require_once('includes/header.php');?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Gestion des moyens de paiement<button class="btn btn-primary pull-right" onclick="getAddedPayment(); return false;">Ajouter un moyen de paiement</button></h2>
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
                                                <th>Nom</th>
                                                <th>Délais de traitement</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php $getPayments = $db->query('SELECT * FROM `website-payment-methods`');
											if($getPayments->num_rows >= 1){
												while($getPayment = $getPayments->fetch_object()){
													echo '<tr class="tr-shadow">
														<td class="sticky-col first-col">
															<div class="table-data-feature">
																<a href="#" class="item-primary" data-toggle="tooltip" data-placement="top" title="Editer le moyen de paiement" onclick="getEditPayment('.$getPayment->ID.'); return false;"><i class="fa fa-pencil"></i></a>
																<a href="#" class="item-danger" data-toggle="tooltip" data-placement="top" onclick="getDeletePayment('.$getPayment->ID.');return false;" title="Supprimer le moyen de paiement"><i class="fa fa-trash"></i></a>';
																if($getPayment->IsActive == 0){
																	echo '<a href="#" class="item-isactive" data-toggle="tooltip" data-placement="top" onclick="setPaymentIsActive('.$getPayment->ID.',1);return false;" title="Activer le moyen de paiement"><i class="fa fa-eye"></i></a>';
																}
																else{
																	echo '<a href="#" class="item-isnoactive" data-toggle="tooltip" data-placement="top" onclick="setPaymentIsActive('.$getPayment->ID.',0);return false;" title="Désactiver le moyen de paiement"><i class="fa fa-eye-slash"></i></a>';
																}
															echo '</div>
														</td>
														<td>'.$getPayment->Name.'</td>
														<td>'.$getPayment->OrderDelais.'</td>';
														if($getPayment->IsActive == 1)
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
