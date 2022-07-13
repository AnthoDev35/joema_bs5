<?php require_once('includes/header.php');
	$getGiftCertificates = $db->query('SELECT * FROM `gift-certificates` WHERE `ID`="'.$_GET['giftCertificateID'].'"');
	if($getGiftCertificates->num_rows == 1){
		$giftCertificate = $getGiftCertificates->fetch_object();
	}
?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
                                    <h2 class="title-3">Modifier un chèque cadeaux</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
								<form method="POST" id="submit-mod-gift-certificate">
									<input type="hidden" id="setGiftCertificateID" value="<?=$_GET['giftCertificateID']?>"/>
									<div class="card">
										<div class="card-header">Modification d'un chèque cadeaux</div>
										<div class="card-body card-block">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="my-auto">Référence</label>
														<input type="text" class="form-control" id="setGiftReference" name="setGiftReference" value="<?=$giftCertificate->Reference?>" readonly />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">Montant total</label> <small>(exemple : "20" pour "20€")</small>
														<input type="text" class="form-control" id="setTotalAmount" name="setTotalAmount" value="<?=$giftCertificate->TotalAmount?>" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">Montant utilisé</label> <small>(exemple : "10" pour "10€")</small>
														<input type="text" class="form-control" id="setLimitAmount" name="setLimitAmount" value="<?=$giftCertificate->UsedAmount?>" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">Date d'achat</label>
														<input type="date" class="form-control" id="setBuyDate" name="setBuyDate" value="<?=date('Y-m-d',$giftCertificate->BuyDate)?>" readonly />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="my-auto">Date limite</label>
														<input type="date" class="form-control" id="setLimitDate" name="setLimitDate" value="<?=date('Y-m-d',$giftCertificate->LimitDate)?>" readonly />
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label class="my-auto">Status du chèque cadeaux</label>
														<select class="form-control" id="setIsActive">
															<option value="0" <?php if($giftCertificate->IsActive == 0) echo 'selected="selected"';?>>Désactivé</option>
															<option value="1" <?php if($giftCertificate->IsActive == 1) echo 'selected="selected"';?>>Activé</option>
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