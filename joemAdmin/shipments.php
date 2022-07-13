<?php require_once('includes/header.php');?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Gestion des transports<button class="btn btn-primary pull-right" onclick="getAddedShipment(); return false;">Ajouter un transporteur</button></h2>
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
                                                <th>Nom</th>
                                                <th>Délais</th>
                                                <th>Prix</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php $getShipments = $db->query('SELECT * FROM `website-shipments`');
											if($getShipments->num_rows >= 1){
												while($getShipment = $getShipments->fetch_object()){
													echo '<tr class="tr-shadow">
														<td class="sticky-col first-col">
															<div class="table-data-feature">
																<button class="item-primary" data-toggle="tooltip" data-placement="top" title="Editer"  onclick="getEditShipment('.$getShipment->ID.'); return false;"><i class="fa fa-pencil"></i></button>
																<button class="item-danger" data-toggle="tooltip" data-placement="top" title="Supprimer"  onclick="getDeleteShipment('.$getShipment->ID.'); return false;"><i class="fa fa-trash"></i></button>
															</div>
														</td>
														<td>'.$getShipment->ID.'</td>
														<td>'.$getShipment->Name.'</td>
														<td>'.$getShipment->TimeLimit.'</td>
														<td>'.$getShipment->Price250.'</td>';
														if($getShipment->IsActive == 1)
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
