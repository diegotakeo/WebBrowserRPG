<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$email  	= (empty($_POST['mail'])) 	? '' : $_POST['mail'];
	$password 	= (empty($_POST['pass'])) 	? '' : $_POST['pass'];
	$repass 	= (empty($_POST['repass'])) ? '' : $_POST['repass'];
	$name 		= (empty($_POST['name']))  	? '' : $_POST['name'];
	$url		= (empty($_POST['url']))  	? '' : $_POST['url'];

	$valid_url = preg_match('/^[a-z0-9\-\_]+$/i',$url);
	
	mb_internal_encoding('UTF-8'); // string.length (UTF-8 fix)
	$name = html_entity_decode($name, ENT_QUOTES, "UTF-8");

	
	/* reCAPTCHA issues */
	//require_once('recaptcha/recaptchalib.php');
	//	$privatekey = "your_private_key";
	//	$resp = recaptcha_check_answer ($privatekey,
	//									$_SERVER["REMOTE_ADDR"],
	//									$_POST["recaptcha_challenge_field"],
	//									$_POST["recaptcha_response_field"]);

	//if ($resp->is_valid) {	
	
		/* IF ANY ISSUES */
		if ($email != '' && $password != '' && $name != '' && $url != '' && $password == $repass && 
			$valid_url && strlen($url) <= 30 && mb_strlen($name) <= 23 && strlen($password) <= 72 ) {
			
			
			$url   = strtolower($url);
			$email = strtolower($email);
		
		
			include 'config.php';				// Connect to usagiRPG database
			$collection = $database->players;	// Get the 'players' collection
			
			/* check if EMAIL already  exists */
			$query = array('$or'  => array(
				array('email'	  => $email),
				array('url-name'  => $url)
			));
			$exist = $collection->find($query,array('email'=>true));
			
			
			
			/* email OK */ // <-- DON'T EXISTS ANY
			if($exist->count() == 0){
					// PHPASS - bcrypt --> for $random e $password
					require_once ('phpass/PasswordHash.php');
					$hasher = new PasswordHash(8, false);
					
			
				//[...] //
				$random = $hasher->HashPassword(uniqid(rand(), true));
				
				
				/* SEND MAIL */
				require 'phpmailer/class.phpmailer.php';
				$mail = new PHPMailer;
				
				$mail->CharSet = 'UTF-8';
				$mail->IsHTML(true);
				$mail->WordWrap = 50;
				
				$mail->SMTPAuth = true;
				$mail->IsSMTP();

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
				$mail->Body 	= ob_get_clean();				// <-- BODY


				
				if ($mail->Send()) {							// <-- SEND MAIL!
					/* 2 - bcrypt PASSWORD with PHPASS */
					$hash 	= $hasher->HashPassword($password);
					if (strlen($hash) >= 20){
					
					
						/* 1 - COOKIES for <delete> & <mail> option */
						setcookie('email',  $email,  time()+864000*7, '/');
						setcookie('random', $random, time()+864000*7, '/');
					
					
						/* 3 - new player document */
						$array = array(
							'email'			=> $email,
							'password'		=> $hash,
							'img'			=> rand(1,12).'.jpg',
							'display-name'	=> htmlentities($name,ENT_QUOTES,'UTF-8'),
							'url-name'		=> $url,
							'lv'			=> 1,
							'exp'			=> 40,
							'money'			=> 100.00,
							'attr_points'	=> 10,
							'str'			=> 0,
							'def'			=> 0,
							'wis'			=> 0,
							'agi'			=> 0,
							'vit'			=> 0,
							'attack'		=> 10,
							'm_attack'		=> 10,
							'resistence'	=> 10,
							'speed'			=> 10,
							'health'		=> 10,
							'max-hp'		=> 140,
							'hp'			=> 150,
							'random'		=> $random	// <-- LOCKER for <email validation> e <delete>
						);

						/* INSERT on 'players' COLLECTION */
						$collection->insert($array);
						
						echo 'SUCCESS!: New Account saved in our database!';
					}
					else
						echo 'ERROR: Something went wrong! <br> We sorry...';
				}
				else
					echo 'ERROR:'.$mail->ErrorInfo;				
			}
			else
				echo "ERROR: Couldn't create new account. <br> Email or URL-name already in use ●︿●";
		}
		else
			echo "ERROR: Couldn't create new account. <br> Something is wrong!";
	//}
	//else
	//	echo 'ERROR: Wrong Captcha! <br>'.$resp->error;
}
?>