<?php
	
	$src 	= $_FILES['file'];//$_POST['url'];		// SOURCE
	$ext 	= $src['type'];							// (.jpg .png .gif)

	
	// is (valid) IMAGE
	if ($ext == 'image/jpg' || $ext == 'image/jpeg' || $ext == 'image/png' || $ext == 'image/gif' ) { 
	
		session_start();
		$user_name = $_SESSION['mypage']; // <--- USER

	
		$src_name = pathinfo($src['name']);
		$filename = $user_name.'_'.md5($src_name['filename']).'.jpg';		// <-- (filename)

	
		
	
		/* UPLOAD ORIGINAL FILE */  // <--- full-sized img
		$tmp_name = $src['tmp_name'];
		
		if ($ext == 'image/jpg' || $ext == 'image/jpeg') 
								  $img  = imagecreatefromjpeg($tmp_name);
		if ($ext == 'image/png')  $img  = imagecreatefrompng ($tmp_name);
		if ($ext == 'image/gif')  $img  = imagecreatefromgif ($tmp_name);
		
		$folder = '../img/image/'.$filename; 	// <-- (original/file.jpg)
		
		if (!imagejpeg($img,$folder,90))
			die ('Couldn\'t save the image in the server');
		
		imagedestroy($img);

		
		
		

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
			$src = '../img/image/'.$filename;
		
			
		
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



			$img  	= imagecreatefromjpeg($src);
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
			


	}// END -- valid image (.jpg .png .gif)
?>