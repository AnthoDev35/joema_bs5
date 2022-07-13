<?php  session_start();
	include_once("../../core/functions.php");
	$system->db = $db;
	
	if(isset($_GET['isShipment']) && isset($_GET['addShipment']) ){
		echo '<div class="modal-header">
			<h5 class="modal-title" id="smallmodalLabel">Ajouter un transporteur</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Nom du transporteur :</label>
				<input type="text" id="addShipmentName" name="addShipmentName" placeholder="La poste" class="form-control">
			</div>
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Délais :</label>
				<input type="text" id="addShipmentLimitTime" name="addShipmentLimitTime" placeholder="5 jours" class="form-control" value="">
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Prix pour 250g :</label>
						<input type="text" id="addShipmentPrice250" name="addShipmentPrice250" placeholder="9.00" class="form-control" value="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Prix pour 500g :</label>
						<input type="text" id="addShipmentPrice500" name="addShipmentPrice500" placeholder="9.00" class="form-control" value="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Prix pour 1kg :</label>
						<input type="text" id="addShipmentPrice1000" name="addShipmentPrice1000" placeholder="9.00" class="form-control" value="">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Prix pour 2kg :</label>
						<input type="text" id="addShipmentPrice2000" name="addShipmentPrice2000" placeholder="9.00" class="form-control" value="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Prix pour 5kg :</label>
						<input type="text" id="addShipmentPrice5000" name="addShipmentPrice5000" placeholder="9.00" class="form-control" value="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Prix pour 10kg :</label>
						<input type="text" id="addShipmentPrice10000" name="addShipmentPrice10000" placeholder="9.00" class="form-control" value="">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="text-input" class=" form-control-label">Activer le transporteur :</label>
				<select name="IsActiveAddShipment" class="form-control" id="IsActiveAddShipment">
					<option value="-1">Séléctionnez une option</option>
					<option value="0">Désactiver</option>
					<option value="1">Activer</option>
				</select>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
			<button type="button" class="btn btn-primary" onclick="setAddedShipment(); return false;">Ajouter</button>
		</div>';
	}
	
	if(isset($_POST['addShipment']) && isset($_POST['addShipmentName']) && isset($_POST['addShipmentPrice250']) && isset($_POST['addShipmentPrice500']) && isset($_POST['addShipmentPrice1000'])
	&& isset($_POST['addShipmentPrice2000']) && isset($_POST['addShipmentPrice5000']) && isset($_POST['addShipmentPrice10000']) && isset($_POST['addShipmentLimitTime']) && isset($_POST['IsActiveAddShipment'])){
		$getShipmentInfos = $db->query('SELECT * FROM `website-shipments` WHERE `Name`="'.$_POST['addShipmentName'].'"');
		if($getShipmentInfos->num_rows == 0){
			$setNewShipment = $db->query('INSERT INTO `website-shipments` (`Name`, `TimeLimit`, `Price250`, `Price500`, `Price1000`, `Price2000`, `Price5000`, `Price10000`, `IsActive`) VALUES
			("'.$_POST['addShipmentName'].'", "'.$_POST['addShipmentLimitTime'].'", "'.$_POST['addShipmentPrice250'].'", "'.$_POST['addShipmentPrice500'].'", "'.$_POST['addShipmentPrice1000'].'", "'.$_POST['addShipmentPrice2000'].'", "'.$_POST['addShipmentPrice5000'].'", "'.$_POST['addShipmentPrice10000'].'", "'.$_POST['IsActiveAddShipment'].'")');
			if($setNewShipment){
				echo 'success';
			}
		}
		else{
			echo 'Une sous-catégorie du même nom est déjà lié à cette catégorie !';
		}
	}
	
	if(isset($_GET['isShipment']) && isset($_GET['editShipment']) && isset($_GET['shipmentID']) ){
		$getShipments = $db->query('SELECT * FROM `website-shipments` WHERE `ID`="'.$_GET['shipmentID'].'"');
		if($getShipments->num_rows >= 1){
			while($getShipment = $getShipments->fetch_object()){
				echo '<div class="modal-header">
					<h5 class="modal-title" id="smallmodalLabel">Editer un transporteur</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Nom du transporteur :</label>
						<input type="text" id="editShipmentName" name="editShipmentName" placeholder="Transporteur" class="form-control" value="'.$getShipment->Name.'">
					</div>
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Délais :</label>
						<input type="text" id="editShipmentLimitTime" name="editShipmentLimitTime" placeholder="5 jours" class="form-control" value="'.$getShipment->TimeLimit.'">
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="text-input" class=" form-control-label">Prix pour 250g :</label>
								<input type="text" id="editShipmentPrice250" name="editShipmentPrice250" placeholder="9.00" class="form-control" value="'.$getShipment->Price250.'">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="text-input" class=" form-control-label">Prix pour 500g :</label>
								<input type="text" id="editShipmentPrice500" name="editShipmentPrice500" placeholder="9.00" class="form-control" value="'.$getShipment->Price500.'">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="text-input" class=" form-control-label">Prix pour 1kg :</label>
								<input type="text" id="editShipmentPrice1000" name="editShipmentPrice1000" placeholder="9.00" class="form-control" value="'.$getShipment->Price1000.'">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="text-input" class=" form-control-label">Prix pour 2kg :</label>
								<input type="text" id="editShipmentPrice2000" name="editShipmentPrice2000" placeholder="9.00" class="form-control" value="'.$getShipment->Price2000.'">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="text-input" class=" form-control-label">Prix pour 5kg :</label>
								<input type="text" id="editShipmentPrice5000" name="editShipmentPrice5000" placeholder="9.00" class="form-control" value="'.$getShipment->Price5000.'">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="text-input" class=" form-control-label">Prix pour 10kg :</label>
								<input type="text" id="editShipmentPrice10000" name="editShipmentPrice10000" placeholder="9.00" class="form-control" value="'.$getShipment->Price10000.'">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="text-input" class=" form-control-label">Activer le transporteur :</label>
						<select name="IsActiveEditShipment" class="form-control" id="IsActiveEditShipment">
							<option value="-1"'; if($getShipment->IsActive == -1) echo 'selected="selected"'; echo '>Séléctionnez une option</option>
							<option value="0"'; if($getShipment->IsActive == 0) echo 'selected="selected"'; echo '>Désactiver</option>
							<option value="1"'; if($getShipment->IsActive == 1) echo 'selected="selected"'; echo '>Activer</option>
						</select>
					</div>
				</div>
				<input type="hidden" id="editShipmentID" value="'.$getShipment->ID.'"/>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					<button type="button" class="btn btn-primary" onclick="setEditShipment('.$getShipment->ID.'); return false;">Valider</button>
				</div>';
			}
		}
		else{
			echo 'error';
		}
	}

	if(isset($_POST['editShipment']) && isset($_POST['editShipmentID']) && isset($_POST['editShipmentName'])&& isset($_POST['editShipmentPrice250']) && isset($_POST['editShipmentPrice500']) && isset($_POST['editShipmentPrice1000'])
	&& isset($_POST['editShipmentPrice2000']) && isset($_POST['editShipmentPrice5000']) && isset($_POST['editShipmentPrice10000']) && isset($_POST['editShipmentLimitTime']) && isset($_POST['IsActiveEditShipment'])){
		$getShipments = $db->query('SELECT * FROM `website-shipments` WHERE `ID`="'.$_POST['editShipmentID'].'"');
		if($getShipments->num_rows == 1){
			$updateShipments = $db->query('UPDATE `website-shipments` SET `Name`="'.$_POST['editShipmentName'].'", `TimeLimit`="'.$_POST['editShipmentLimitTime'].'",
			`Price250`="'.$_POST['editShipmentPrice250'].'", `Price500`="'.$_POST['editShipmentPrice500'].'", `Price1000`="'.$_POST['editShipmentPrice1000'].'", `Price2000`="'.$_POST['editShipmentPrice2000'].'",
			`Price5000`="'.$_POST['editShipmentPrice5000'].'",`Price10000`="'.$_POST['editShipmentPrice10000'].'", `IsActive`="'.$_POST['IsActiveEditShipment'].'" WHERE `ID`="'.$_POST['editShipmentID'].'"');
			if($updateShipments){
				echo 'success';
			}
		}
		else{
			echo 'Se transporteur n\'existe pas !';
		}
	}
	
	if(isset($_GET['isShipment']) && isset($_GET['deleteShipment']) && isset($_GET['shipmentID'])){
		$getShipments = $db->query('SELECT * FROM `website-shipments` WHERE `ID`="'.$_GET['shipmentID'].'"');
		if($getShipments->num_rows >= 1){
			while($getShipment = $getShipments->fetch_object()){
				echo '<div class="modal-header">
					<h5 class="modal-title" id="smallmodalLabel">Suppression d\'un transporteur</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h4>Êtes-vous sûr de vouloir supprimer ce transporteur?</h4></br>
					<div class="alert alert-warning"><i class="fa fa-warning"></i>Cette suppression est définitive!</div>
				</div>
				<input type="hidden" id="deleteShipmentID" value="'.$getShipment->ID.'"/>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					<button type="button" class="btn btn-primary" onclick="setDeleteShipment('.$getShipment->ID.'); return false;">Supprimer</button>
				</div>';
			}
		}
		else{
			echo 'error';
		}
	}
	
	if(isset($_POST['delShipment']) && isset($_POST['deleteShipmentID'])){
		$getShipments = $db->query('SELECT * FROM `website-shipments` WHERE `ID`="'.$_POST['deleteShipmentID'].'"');
		if($getShipments->num_rows >= 1){
			$delShipment = $db->query('DELETE FROM `website-shipments` WHERE `ID`="'.$_POST['deleteShipmentID'].'"');
			if($delShipment){
				echo 'success';
			}
		}
		else{
			echo 'error';
		}
	}
	
?>
