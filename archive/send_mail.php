<?php
	$email 	= (empty($_COOKIE['email']))  ? '' : urldecode($_COOKIE['email']);
	$random = (empty($_COOKIE['random'])) ? '' : $_COOKIE['random'];

	if($email != '' && $random != '') {
	
		include 'config.php';
		$collection = $database->players;
		$query		= array('email' => $email, 'random' => $random);
		$document	= $collection->find($query, array('random' => 1));	// <-- find USER with RANDOM

		// IF OK <-- user exists
		if ($document->count() != 0){
		
			require 'phpmailer/class.phpmailer.php';
			$mail = new PHPMailer;

			$mail->CharSet = 'UTF-8';
			$mail->IsHTML(true);
			$mail->WordWrap = 50;

			$mail->IsSMTP();
			
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 465;
			
			$mail->Username = 'pk7.usagi.rpg@gmail.com';	// <-- FROM
			$mail->Password = 'pzv5ce8hpzv5ce8h';

			$mail->FromName = '兔-RPG';				
			$mail->AddAddress($email);						// <-- TO
			$mail->Subject	= 'Account Confirmation';		// <-- SUBJECT

			ob_start();
			include('mail.php');
			$mail->Body = ob_get_clean();					// <-- BODY
			
			if ($mail->Send())
				echo 'EMAIL SENT!: You should receive it in a few minutes';
			else
				echo 'ERROR: Something is wrong!';
		}
		else
			echo 'ERROR: Something is wrong <br> Invalid cookies!';
	}
	else
		echo 'ERROR: Something is wrong! <br> Any cookies';
?>