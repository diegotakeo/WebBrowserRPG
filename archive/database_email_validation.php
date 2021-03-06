<?php
if (!empty($_GET['email']) && !empty($_GET['random'])) {
	// $_GET
	$email  = $_GET['email'];
	$random = $_GET['random'];
	
	// CONNECT TO DATABASE
	include 'config.php';
	$collection = $database->players;
	$query		= array('email' => $email, 'random' => $random);
	$document	= $collection->find($query, array('random' => 1));	// <-- find USER with RANDOM

	// IF OK <-- user exists
	if ($document->count() != 0){
		$update = array('$unset' => array('random' => 1));
		$collection->update($query, $update);						// <-- remove RANDOM = validate account!
		
		// remove COOKIES (now useless)
		setcookie('email',  '', 1, '/');
		setcookie('random', '', 1, '/');
		
		header ('Location: ../index.php?#x=confirmed');
		exit;
	}
	else
		exit(header ('Location: ../index.php?#x=alreadyconfirmed'));
}

				
?>