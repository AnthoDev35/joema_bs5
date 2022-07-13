<?php
    // Database Configuration
    $_db['host'] = '127.0.0.1';
    $_db['user'] = 'root';
    $_db['pass'] = 'gogo2012';
    $_db['database'] = 'db_joema';
	
    /*$_db['host'] = 'localhost';
    $_db['user'] = 'axjc1919';
    $_db['pass'] = '4a2(*Pwv*$Ng';
    $_db['database'] = 'axjc1919_joema';*/
	
    /*$_db['host'] = '185.98.131.128';
    $_db['user'] = 'joema1732111';
    $_db['pass'] = 'cA1@CN!nE86D4aB';
    $_db['database'] = 'joema1732111';*/
		
    $db = new mysqli($_db['host'], $_db['user'], $_db['pass'], $_db['database']) or die('MySQL Error');

	/*###################### Configuration de la zone administrateur ######################*/
	$conn_mail['host'] = 'mail.joema.fr'; // mail.domain.fr
	$conn_mail['username'] = 'contact@joema.fr'; // contact@domain.fr
	$conn_mail['password'] = 'unk'; // password of contact@domain.fr
	$conn_mail['port'] = '587'; // always 587
	$contact_mail['from_name'] = 'joema.fr'; // domain.fr
	$contact_mail['from_email'] = 'contact@joema.fr'; // contact@domain.fr
	$contact_mail['from_domain'] = 'www.joema.fr'; // www.domain.fr
	$contact_mail['developper'] = 'a.cazier@soldicom.com'; // developper mail recever
		
    error_reporting(1);
?>