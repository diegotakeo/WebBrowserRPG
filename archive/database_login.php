<?php
/* LOGIN VERIFICATION */
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		$email  	= (empty($_POST['email'])) 		? '' : $_POST['email'];
		$password  	= (empty($_POST['password'])) 	? '' : $_POST['password'];

		// not empty
		if ($email != '' && $password != ''){
		
			$email = strtolower($email);
	
			/* find USER on DATABASE */
			include 'config.php';
			$collection = $database->players;	
			
			$query 		= array('email' => $email, 'random' => array('$exists' => false));	// <-- valid EMAIL && NOT LOCKED (random)
			$projection = array('password' => 1, 'url-name' => 1);
			
			$return 	= $collection->find($query, $projection);
			
			
			/* EMAIL OK */
			if ($return->count() != 0){
				foreach($return as $value) {
					$stored_hash = $value['password']; 	// <-- PASSWORD from database
					$url_name 	 = $value['url-name'];	// <-- URL-name from database
				}
			
			
				// PASSWORD validation --> with PHPASS
				require ('phpass/PasswordHash.php');
				$hasher = new PasswordHash(8, false);
				$check  = $hasher->CheckPassword($password, $stored_hash);			// <-- ANY MATCH?
				
				
				/* PASSWORD OK */
				if ($check) {

				
					/* 1 --> CREATE $_COOKIE */
					$random = uniqid(rand(), true);				
					$cookie = $url_name.';'.$random;						// url_name ; random value
					setcookie('login', $cookie, time()+864000*70 ,'/'); 	// <-- setcookie on $_COOKIE

					
					/* 3 --> GO to MY PAGE */
					session_start();
					$_SESSION['logged'] = $url_name; // <-- logged $_SESSION
					echo 'SUCCESS:'.$url_name;
					
					
					/* 2 --> COOKIE on DATABASE */
					$collection = $database->cookies;
					$query 		= array('url-name' => $url_name);
					$update 	= array('$set' => array('login'  => $cookie));
					$collection->update($query, $update, array('upsert'=>true));	// <-- setcookie on DATABASE
					

				}
				else
					echo 'ERROR: Your password is wrong!';
			}
			else
				echo 'ERROR: That wasn\'t a valid e-mail';
		}
		else
			echo 'ERROR: You forgot to type something!';
}
?>