<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

	session_start();
	$user 		= $_SESSION['mypage'];	// <-- url-name
	
	// DATABASE config
	try{
		include 'config.php';
		$collection = $database->info;
		$query		= array('url-name' => $user);

		// UPDATE array
		$update 	= array('url-name' => $user);
		
		
// --------------------------------------------------------------------------------------------------------- //		
		
		// IF DESCRIPTION
		if (isset($_POST['description'])){ 
			$text = $_POST['description'];
			mb_internal_encoding('UTF-8'); // string.length (UTF-8 fix)
			$text = html_entity_decode($text, ENT_QUOTES, "UTF-8");
			
			// max.length = 500
			if  (mb_strlen($text) <= 500){
				$string 	  		   = htmlentities($text,ENT_QUOTES,'UTF-8');	 // html not allowed
				$update['description'] = str_replace('&lt;br&gt;', '<br>', $string); // <br> allowed
			}
			else
				die ('ERROR: max length = 500');
		}
		
// --------------------------------------------------------------------------------------------------------- //				
		// IF INFO (inputs)
		else {
			foreach ($_POST as $key => $value){
				$update[$key] = htmlentities($value,ENT_QUOTES,'UTF-8');
			}
		}
// --------------------------------------------------------------------------------------------------------- //	
		
		
		
		$collection->update($query, array('$set' => $update), array('upsert' => true));
	}
	catch(MongoCursorException $e)
		{echo 'ERROR: We\'re dead! <br> There\'is some issues in our database!';}
	

}
?>