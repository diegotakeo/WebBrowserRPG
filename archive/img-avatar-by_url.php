<?php
	
	$src 		= $_POST['src'];		// SOURCE <-- URL
	$src_info 	= pathinfo($src);
	$ext 		= strtolower($src_info['extension']);	// (.jpg .png .gif)

	
	// is (valid) IMAGE
	if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' ) { 
	
		session_start();
		$user_name = $_SESSION['mypage']; // <--- USER
	
		$filename = $user_name.'_'.md5($src_info['filename']).'.jpg';		// <-- (filename)
		
		
		

		/* GET from it's URL */
		$u = explode('/',$src);
		$referer = $u[0].'//'.$u[2];
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $src); // <-- $src
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, false);
		curl_setopt($ch, CURLOPT_REFERER, $referer); // <-- referer
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$raw = curl_exec($ch);
		curl_close($ch);		
		
		//$raw  = file_get_contents($src);
		$img  = imagecreatefromstring($raw);

		
		
		/* UPLOAD ORIGINAL FILE */  // <--- full-sized img
		$folder	 = 'img/image/'.$filename;	// <-- (after use)
		$folder_ = '../'.$folder; 			// <-- to SAVE (original/file.jpg)
		
		$return = imagejpeg($img,$folder_,90);
		
		imagedestroy($img);
		
		if (!$return)
			die ('Couldn\'t save the image in the server');
		
		

		
		
		

			/* DATABASE */ // <-- AVATAR
			try {
				include_once 'config.php';
				$collection = $database->avatar;

				$query 	= array('image' => $filename,'url-name' => $user_name);
				$update = $query;
				
				// INSERT -- UPDATE
				$collection->update($query,$update,array('upsert'=>true));
			}
			catch(MongoCursorException $e){
				echo 'ERROR: We\'re dead! <br> There\'is some issues in our database!';
			}
			
			
			
			
			/* RESIZE-CROP */ // <--  (200px.jpg) & (small.jpg)

				// 200px avatar
				$frame_width  = 190;
				$frame_height = 190;
				
				// 80px avatar
				$small_width  = 80;
				$small_height = 80;
				
				
			
			// 300 = 100%
			$resize_width  = ((int) $_POST['width']);		// WIDTH & HEIGHT
			$resize_height = $resize_width;					// (resize)
			
			$x = (int) $_POST['left'];						// POSITION X & Y
			$y = (int) $_POST['top'];						// (crop)



			$img  	= imagecreatefromjpeg($folder_);
			$img_ 	= imagecreatetruecolor($frame_width, $frame_height); 			
			$img_80 = imagecreatetruecolor($small_width, $small_height); 
				
			// execute RESIZE & CROP
			imagecopyresampled($img_  , $img, 0, 0, $x, $y, $frame_width, $frame_height, $resize_width, $resize_height);
			imagecopyresampled($img_80, $img, 0, 0, $x, $y, $small_width, $small_height, $resize_width, $resize_height);
			
			header('Content-Type: image/jpeg');
			
			
			
			// save JPG (200px)
			$folder = '../img/avatar/'.$filename; // <-- (200px).jpg
			$return = imagejpeg($img_,$folder,90);
			
			// save JPG (80px)
			$folder = '../img/avatar/small/'.$filename; // <-- (small/80px).jpg
			$return = imagejpeg($img_80,$folder,90);
			
			imagedestroy($img);
			imagedestroy($img_);
			imagedestroy($img_80);
			
			if (!$return)
				die ('Couldn\'t save the image in the server');
			
			
			
			
			/* DATABASE UPDATE AVATAR */
			$collection = $database->players;

			$query 	= array('url-name' => $user_name);
			$update = array('$set' => array('img' => $filename));
			
			// INSERT -- UPDATE
			try {$collection->update($query,$update);}
			catch(MongoCursorException $e)
				{echo 'ERROR: We\'re dead! <br> There\'is some issues in our database!';}
			


	} // END -- valid image (.jpg .png .gif)
?>