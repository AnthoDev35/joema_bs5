<?php session_start();
	include_once("../../core/functions.php");
	$system = new System;
	$system->db = $db;
	$response = '';
	
if(isset($_POST['getMails'])){
	$mailbox = "{mail50.lwspanel.com:993/imap/ssl}INBOX";
	$username = "contact@joema.fr";
	$password = "bY2-mXFCB1h7CPq";

	$imapResource = imap_open($mailbox, $username, $password);
	if($imapResource === false){
		throw new Exception(imap_last_error());
	}

	$emails = imap_search($imapResource, 'ALL', SE_UID, 'ISO-8859-1');
	$response .= '<div class="row mb-5">
		<div class="col-lg-12">
			<div class="overview-wrap mb-3">
				<h2 class="title-1">Boîte Mail "Contact"
				<a href="#" class="btn btn-primary btn-sm pull-right" id="getRefreshMails" onclick="getRefreshMails()" title="Actualiser les mails"><i class="fa fa-refresh"></i></a></h2>
			</div>
			<div class="table-responsive table-responsive-data2">
				<table class="table table-data2">
					<thead>
						<tr>
							<th class="sticky-col-head first-col">Action</th>
							<th style="width:20%;">Contact</th>
							<th style="width:20%;">Date</th>
							<th style="width:20%;">Sujet</th>
							<th style="width:20%;">Message</th>
						</tr>
					</thead>
					<tbody id="reloadMails">';
						if(!empty($emails)){
							foreach($emails as $email_number) 
							{
								$header=imap_headerinfo($imapResource,$email_number);

								$from = $header->from[0]->mailbox . "@" . $header->from[0]->host;
								$datetime=date("d/m/Y",$header->udate);
								$subject=$header->subject;

								//get message body
								$message = quoted_printable_decode(imap_fetchbody($imapResource,$email_number,1.1)); 
								if($message == ''){
									$message = quoted_printable_decode(imap_fetchbody($imapResource,$email_number,1));
								}
								$response .= '<tr class="tr-shadow">
									<td class="sticky-col first-col">
										<div class="table-data-feature">
											<a href="#" class="item-primary" data-toggle="tooltip" data-placement="top" title="Afficher"><i class="fa fa-eye"></i></a>
											<a href="#" class="item-info" data-toggle="tooltip" data-placement="top" title="Répondre"><i class="fa fa-reply"></i></a>
											<a href="#" class="item-danger" data-toggle="tooltip" data-placement="top" title="Supprimer"><i class="fa fa-trash"></i></a>
										</div>
									</td>
									<td>'.$header->from[0]->mailbox.' '.$from.'</td>
									<td>'.$datetime.'</td>
									<td>'.$subject.'</td>
									<td>'.htmlentities(substr($message,0,100)).'</td>
								</tr>';
							}
						}
						else {
							$response .= '<tr><td>Aucuns emails trouvés!</td></tr>';
						}
					$response .= '</tbody>
				</table>
			</div>
		</div>
	</div>';
	
}
echo $response;
?>