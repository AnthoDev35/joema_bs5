<?php require_once('includes/header.php');
	$getAllCustomers = $db->query('SELECT * FROM `customers` ORDER BY `ID` DESC');

?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Gestion des clients</h2>
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
                                                <th>Prénom</th>
                                                <th>Email</th>
                                                <th>Commandes</th>
                                                <th>Inscrit le</th>
                                                <th>Dernière visite</th>
                                                <th>Dernière IP</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php if($getAllCustomers >= 1){
												while($getAllCustomer = $getAllCustomers->fetch_object()){
													$getOrderCount = $db->query('SELECT * FROM `customers_orders` WHERE `CustomerID`="'.$getAllCustomer->ID.'"')->num_rows;
													echo '<tr class="tr-shadow">
														<td class="sticky-col first-col">
															<div class="table-data-feature">
																<button class="item-primary" data-toggle="tooltip" data-placement="top" title="Edit">
																	<i class="fa fa-pencil"></i>
																</button>
																<button class="item-danger" data-toggle="tooltip" data-placement="top" title="Delete">
																	<i class="fa fa-trash"></i>
																</button>
																<button class="item-info" data-toggle="tooltip" data-placement="top" title="More">
																	<i class="fa fa-info"></i>
																</button>
															</div>
														</td>
														<td>'.$getAllCustomer->ID.'</td>
														<td>'; if($getAllCustomer->lastname != ''){ echo ucfirst($getAllCustomer->lastname);} else{ echo 'Inconnu'; } echo '</td>
														<td>'; if($getAllCustomer->firstname != ''){ echo ucfirst($getAllCustomer->firstname);} else{ echo 'Inconnu'; } echo '</td>
														<td>'; if($getAllCustomer->email != ''){ echo ucfirst($getAllCustomer->email);} else{ echo 'Inconnu'; } echo '</td>
														<td>'.$getOrderCount.'</td>
														<td>'.date('d/m/Y', $getAllCustomer->regDate).'</td>
														<td>'.date('d/m/Y', $getAllCustomer->last_login).'</td>
														<td>'; if($getAllCustomer->lastIP != ''){ echo ucfirst($getAllCustomer->lastIP);} else{ echo 'Inconnu'; } echo '</td>
														<td>';
														if($getAllCustomer->isValided == 1){
															echo '<span class="status--process">Confirmé</span>';
														}
														else{
															echo '<span class="status--denied">Non-confirmé</span>';
														}
														echo '</td>
													</tr>';
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