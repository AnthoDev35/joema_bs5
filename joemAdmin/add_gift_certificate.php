<?php require_once('includes/header.php');
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$giftCertificate =  'JOeMA-'.substr(str_shuffle($alphabet), 0, 12);
?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-3">Ajouter un chèque cadeaux</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
								<form method="POST" id="submit-add-gift-certificate">
									<div class="card">
										<div class="card-header">Ajout d'un chèque cadeaux</div>
										<div class="card-body card-block">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="my-auto">Référence</label>
														<input type="text" class="form-control" id="setGiftReference" name="setGiftReference" value="<?=$giftCertificate?>" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">Montant total</label> <small>(exemple : "20" pour "20€")</small>
														<input type="text" class="form-control" id="setTotalAmount" name="setTotalAmount" value="" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">Montant utilisé</label> <small>(exemple : "10" pour "10€")</small>
														<input type="text" class="form-control" id="setLimitAmount" name="setLimitAmount" value="" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">Date d'achat</label>
														<input type="date" class="form-control" id="setBuyDate" name="setBuyDate" value="<?=date('Y-m-d')?>" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">Date limite</label>
														<input type="date" class="form-control" id="setLimitDate" name="setLimitDate" value="<?=date('Y-m-d', strtotime('+6 months'))?>" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">De la part de <small>(Nom & Prénom de l'acheteur)</small></label>
														<input type="text" class="form-control" id="setBuyerName" name="setBuyerName"/>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">Pour <small>(Nom & Prénom du bénéficiaire)</small></label>
														<input type="text" class="form-control" id="setCustomerName" name="setCustomerName"/>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">Envoyer le chèque par mail</label>
														<select class="form-control" id="setSendToMail" name="setSendToMail">
															<option value="0">Non</option>
															<option value="1" selected="selected">Oui</option>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">Renseignez l'adresse mail du bénéficiaire</label>
														<input type="text" class="form-control" id="setCustomerMail" name="setCustomerMail"/>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label class="my-auto">Status du chèque cadeaux</label>
														<select class="form-control" id="setIsActive" name="setIsActive">
															<option value="0">Désactivé</option>
															<option value="1" selected="selected">Activé</option>
														</select>
													</div>
												</div>
											</div>
											<div class="card-footer">
												<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Annuler</button>
												<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-dot-circle-o"></i> Enregistrer</button>
											</div>
										</div>
									</div>
								</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php require_once('includes/footer.php');?>
<script>
	if(document.querySelector('#setCarrouselDescription') !== null ){
		CKEDITOR.replace( 'setCarrouselDescription' );
	}
</script>