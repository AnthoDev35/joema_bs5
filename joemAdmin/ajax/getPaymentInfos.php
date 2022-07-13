<?php  session_start();
	include_once("../../core/functions.php");
	$system->db = $db;
	
	if(isset($_GET['isPaymentMethod']) && isset($_GET['addPaymentMethod']) ){
		echo '<div class="modal-header">
			<h5 class="modal-title" id="smallmodalLabel">Ajouter un moyen de paiement</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Nom du moyen de paiement :</label>
				<input type="text" id="addPaymentName" name="addPaymentName" placeholder="Virement" class="form-control">
			</div>
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Délais de traitement de la commande en jours:</label>
						<input type="text" id="addPaymentOrderDelais" name="addPaymentOrderDelais" placeholder="5 jours" class="form-control" value="">
					</div>
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Activer le moyen de paiement :</label>
				<select name="IsActiveAddPayment" class="form-control" id="IsActiveAddPayment">
					<option value="-1">Séléctionnez une option</option>
					<option value="0">Désactiver</option>
					<option value="1">Activer</option>
				</select>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
			<button type="button" class="btn btn-primary" onclick="setAddedPayment(); return false;">Ajouter</button>
		</div>';
	}
	
	if(isset($_POST['addPayment']) && isset($_POST['addPaymentName']) && isset($_POST['addPaymentOrderDelais']) && isset($_POST['IsActiveAddPayment'])){
		$getPaymentInfos = $db->query('SELECT * FROM `website-payment-methods` WHERE `Name`="'.$_POST['addPaymentName'].'"');
		if($getPaymentInfos->num_rows == 0){
			$setNewPayment = $db->query('INSERT INTO `website-payment-methods` (`Name`, `OrderDelais`, `IsActive`) VALUES ("'.$_POST['addPaymentName'].'", "'.$_POST['addPaymentOrderDelais'].'", "'.$_POST['IsActiveAddPayment'].'")');
			if($setNewPayment){
				echo 'success';
			}
		}
		else{
			echo 'Une sous-catégorie du même nom est déjà lié à cette catégorie !';
		}
	}
	
	if(isset($_GET['isPayment']) && isset($_GET['editPayment']) && isset($_GET['paymentID']) ){
		$getPayments = $db->query('SELECT * FROM `website-payment-methods` WHERE `ID`="'.$_GET['paymentID'].'"');
		if($getPayments->num_rows >= 1){
			while($getPayment = $getPayments->fetch_object()){
				echo '<div class="modal-header">
					<h5 class="modal-title" id="smallmodalLabel">Editer un moyen de paiement</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Nom du moyen de paiement :</label>
						<input type="text" id="editPaymentName" name="editPaymentName" placeholder="Moyen de paiement" class="form-control" value="'.$getPayment->Name.'">
					</div>
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Délais de traitement de la commande en jours:</label>
						<input type="text" id="editPaymentOrderDelais" name="editPaymentOrderDelais" placeholder="5 jours" class="form-control" value="'.$getPayment->OrderDelais.'">
					</div>
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Activer le moyen de paiement :</label>
						<select name="IsActiveEditPayment" class="form-control" id="IsActiveEditPayment">
							<option value="-1"'; if($getPayment->IsActive == -1) echo 'selected="selected"'; echo '>Séléctionnez une option</option>
							<option value="0"'; if($getPayment->IsActive == 0) echo 'selected="selected"'; echo '>Désactiver</option>
							<option value="1"'; if($getPayment->IsActive == 1) echo 'selected="selected"'; echo '>Activer</option>
						</select>
					</div>
				</div>
				<input type="hidden" id="editPaymentID" value="'.$getPayment->ID.'"/>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					<button type="button" class="btn btn-primary" onclick="setEditPayment('.$getPayment->ID.'); return false;">Valider</button>
				</div>';
			}
		}
		else{
			echo 'error';
		}
	}

	if(isset($_POST['editPayment']) && isset($_POST['editPaymentID']) && isset($_POST['editPaymentName']) && isset($_POST['editPaymentOrderDelais']) && isset($_POST['IsActiveEditPayment'])){
		$getPayments = $db->query('SELECT * FROM `website-payment-methods` WHERE `ID`="'.$_POST['editPaymentID'].'"');
		if($getPayments->num_rows == 1){
			$updatePayments = $db->query('UPDATE `website-payment-methods` SET `Name`="'.$_POST['editPaymentName'].'", `OrderDelais`="'.$_POST['editPaymentOrderDelais'].'", `IsActive`="'.$_POST['IsActiveEditPayment'].'" WHERE `ID`="'.$_POST['editPaymentID'].'"');
			if($updatePayments){
				echo 'success';
			}
		}
		else{
			echo 'Se moyen de paiement n\'existe pas !';
		}
	}
	
	if(isset($_GET['isPayment']) && isset($_GET['deletePayment']) && isset($_GET['paymentID'])){
		$getPayments = $db->query('SELECT * FROM `website-payment-methods` WHERE `ID`="'.$_GET['paymentID'].'"');
		if($getPayments->num_rows >= 1){
			while($getPayment = $getPayments->fetch_object()){
				echo '<div class="modal-header">
					<h5 class="modal-title" id="smallmodalLabel">Suppression d\'un moyen de paiement</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h4>Êtes-vous sûr de vouloir supprimer ce moyen de paiement?</h4></br>
					<div class="alert alert-warning"><i class="fa fa-warning"></i>Cette suppression est définitive!</div>
				</div>
				<input type="hidden" id="deletePaymentID" value="'.$getPayment->ID.'"/>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					<button type="button" class="btn btn-primary" onclick="setDeletePayment('.$getPayment->ID.'); return false;">Supprimer</button>
				</div>';
			}
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_POST['delPayment']) && isset($_POST['deletePaymentID'])){
		$getPayments = $db->query('SELECT * FROM `website-payment-methods` WHERE `ID`="'.$_POST['deletePaymentID'].'"');
		if($getPayments->num_rows >= 1){
			$delPayment = $db->query('DELETE FROM `website-payment-methods` WHERE `ID`="'.$_POST['deletePaymentID'].'"');
			if($delPayment){
				echo 'success';
			}
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_POST['setPaymentIsActive']) && isset($_POST['paymentStatus']) && isset($_POST['paymentID'])){
		$updActiveDatas = $db->query('UPDATE `website-payment-methods` SET `IsActive`="'.$_POST['paymentStatus'].'" WHERE `ID`="'.$_POST['paymentID'].'"');
		if($updActiveDatas){
			echo 'success';
		}
		else{
			echo 'Une erreur interne c\'est produite, contactez l\'administrateur si le problème persiste !';
		}
	}
	
?>

