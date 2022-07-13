<?php require_once('includes/header.php');
	$getAllOrders = $db->query('SELECT * FROM `customers_orders` ORDER BY `ID` DESC');
	$getAllPendingOrders = $db->query('SELECT * FROM `customers_orders` WHERE `IsPayed`="1" AND `IsSend`="0"');
	$getAllPayedOrders = $db->query('SELECT * FROM `customers_orders` WHERE `IsPayed`="1"');
	$getAllCompletedOrders = $db->query('SELECT * FROM `customers_orders` WHERE `IsPayed`="1" AND `IsSend`="1"');
	$countAllOrders = $getAllOrders->num_rows;
	$countAllPendingOrders = $getAllPendingOrders->num_rows;
	$countAllCompletedOrders = $getAllCompletedOrders->num_rows;
?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="overview-wrap">
                                    <h2 class="title-3">Gestion des commandes</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-lg-4">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                                            <div class="text">
                                                <h2><?=$countAllOrders?></h2>
                                                <span>Commandes</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                                            <div class="text">
                                                <h2><?=$countAllPendingOrders?></h2>
                                                <span>Commandes en attente</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                                            <div class="text">
                                                <h2><?=$countAllCompletedOrders?></h2>
                                                <span>Commandes finalisées</span>
                                            </div>
                                        </div>
                                    </div>
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
                                                <th>Nom du client</th>
                                                <th>Email</th>
                                                <th>Date</th>
                                                <th>Prix Total</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php if($countAllOrders >= 1){
												while($getAllOrder = $getAllOrders->fetch_object()){
													$getCustomerInfos = $db->query('SELECT * FROM `customers` WHERE `ID`="'.$getAllOrder->CustomerID.'" ORDER BY `ID` DESC');
													$getCustomerInfo = $getCustomerInfos->fetch_object();
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
														<td>'.$getCustomerInfo->ID.'</td>
														<td>'.ucfirst($getCustomerInfo->lastname).' '.ucfirst($getCustomerInfo->firstname).'</td>
														<td>'.$getCustomerInfo->email.'</td>
														<td>'.date('d/m/Y', $getAllOrder->Date).'</td>
														<td>'.number_format($getAllOrder->TotalCart, 2).' €</td>
														<td>';
														if($getAllOrder->IsPayed == 1 && $getAllOrder->IsSend == 1){
															echo '<span class="status--process">Envoyée</span>';
															
														}
														else if($getAllOrder->IsPayed == 1 && $getAllOrder->IsSend == 0){
															echo '<span class="status--warning">Payée</span>';
															
														}
														else if($getAllOrder->IsPayed == 1 && $getAllOrder->IsSend == 1 && $getAllOrder->IsDelivery == 1){
															echo '<span class="status--process">Términée</span>';
															
														}
														else if($getAllOrder->IsPayed == 0){
															echo '<span class="status--denied">Annulée</span>';
															
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