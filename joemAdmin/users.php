<?php require_once('includes/header.php');?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Gestion des utilisateurs<button class="btn btn-primary pull-right" onclick="getAddedUser(); return false;">Ajouter un utilisateur</button></h2>
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
                                                <th>Identifiant</th>
                                                <th>Email</th>
                                                <th>Niveau</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php $getAccounts = $db->query('SELECT * FROM `accounts`');
											if($getAccounts->num_rows >= 1){
												while($getAccount = $getAccounts->fetch_object()){
													echo '<tr class="tr-shadow">
														<td class="sticky-col first-col">
															<div class="table-data-feature">
																<button class="item-primary" data-toggle="tooltip" data-placement="top" title="Editer"  onclick="getEditUser('.$getAccount->ID.'); return false;"><i class="fa fa-pencil"></i></button>
																<button class="item-danger" data-toggle="tooltip" data-placement="top" title="Supprimer"  onclick="getDeleteUser('.$getAccount->ID.'); return false;"><i class="fa fa-trash"></i></button>
															</div>
														</td>
														<td>'.$getAccount->username.'</td>
														<td>'.$getAccount->email.'</td>';
														if($getAccount->isAdmin == 10)
															echo '<td><span class="status--process">Admin</span></td>';
														else
															echo '<td><span class="status--denied">Non-Admin</span></td>';
														if(getAccount)
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
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

<?php require_once('includes/footer.php');?>
