<?php
	
	$src 		= $_POST['src'];		// SOURCE <-- URL
	$src_info 	= pathinfo($src);
	$ext 		= strtolower($src_info['extension']);	// (.jpg .png .gif)

	
	// is (valid) IMAGE
	if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' ) { 
	
		session_start();
		$user_name = $_SESSION['mypage']; // <--- USER
	
		$filename = $user_name.'_'.md5($src_info['filename']).'.jpg';		// <-- (pk7_xxxx.jpg)
		
		
		

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
		$folder	 = 'img/image/'.$filename;		// <-- (after use)
		$folder_ = '../'.$folder; 						// <-- to SAVE (original/file.jpg)
		
		$return = imagejpeg($img,$folder_,90);
		
		imagedestroy($img);
		
		if (!$return)
			die ('Couldn\'t save the image in the server');
		
		

		
		
		

			/* DATABASE */ // <-- ARCHIVE
			try {
			include_once 'config.php';
			$collection = $database->covers;

			$query 	= array('image' => $filename,'url-name' => $user_name);
			$update = $query;
			
			// INSERT -- UPDATE
			$collection->update($query,$update,array('upsert'=>true));
			}
			catch(MongoCursorException $e){
				echo 'ERROR: We\'re dead! <br> There\'is some issues in our database!';
			}
			
			
			
			
			/* UPLOAD CROP */ // <-- 850px cover frame
			$frame_width  = 850;
			$frame_height = 400;
				

			// execute CROP 
			$x = -(int) $_POST['left'];						// POSITION X & Y
			$y = -(int) $_POST['top'];						// (crop)


			$img  	= imagecreatefromjpeg('../img/image/'.$filename);
			$img_ 	= imagecreatetruecolor($frame_width, $frame_height); 			
				
			imagecopyresampled($img_ , $img, 0,0, $x, $y, $frame_width, $frame_height, $frame_width, $frame_height);
			
			
			
			// execute BACKGROUND REPEAT
			$src_w	  = imagesx($img);
			$src_h	  = imagesy($img);
			$repeat_x = -($x - $src_w);
			$repeat_y = -($y - $src_h);

			$left_x = $repeat_x;
			$top_y  = $repeat_y;
			

			
			/* execute BACKGROUND REPEAT */
			// HORIZONTAL
			while($repeat_x <= $frame_width){
				imagecopyresampled($img_ , $img, $repeat_x, 0, 0, $y, $frame_width, $frame_height, $frame_width, $frame_height);
				$repeat_x += $src_w;
			}
			while($x <= 0){
				$x = $x + $src_w;
				imagecopyresampled($img_ , $img, -$x, 0, 0, $y, $src_w, $src_h, $src_w, $src_h);
			}
				
			// VERTICAL
			while($repeat_y <= $frame_height){
				imagecopyresampled($img_ , $img, 0, $repeat_y, $x, 0, $frame_width, $frame_height, $frame_width, $frame_height);
				$repeat_y += $src_h;
			}
			while($y <= 0){
				$y = $y + $src_h;
				imagecopyresampled($img_ , $img, 0, -$y, $x, 0, $src_w, $src_h, $src_w, $src_h);
			}
			
			
			
			header('Content-Type: image/jpeg');
			
			
			
			// save JPG (850px)
			$folder = '../img/cover/'.$filename; // <-- pk7_xxx.jpg
			$return = imagejpeg($img_,$folder,90);

			
			imagedestroy($img);
			imagedestroy($img_);
			
			
			if (!$return)
				die ('Couldn\'t save the image in the server');	
			
			
			
			
			/* DATABASE UPDATE COVER */
			$collection = $database->players;

			$query 	= array('url-name' => $user_name);
			$update = array('$set' => array('cover' => $filename));
			
			// INSERT -- UPDATE
			try {$collection->update($query,$update);}
			catch(MongoCursorException $e)
				{echo 'ERROR: We\'re dead! <br> There\'is some issues in our database!';}
			


	}// END -- valid image (.jpg .png .gif)
?>