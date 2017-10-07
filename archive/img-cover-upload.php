<?php
	
	$src 	= $_FILES['file'];//$_POST['url'];		// SOURCE
	$ext 	= $src['type'];							// (.jpg .png .gif)

	
	// is (valid) IMAGE
	if ($ext == 'image/jpg' || $ext == 'image/jpeg' || $ext == 'image/png' || $ext == 'image/gif' ) { 
	
		session_start();
		$user_name = $_SESSION['mypage']; // <--- USER

	
		$src_name = pathinfo($src['name']);
		$filename = $user_name.'_'.md5($src_name['filename']).'.jpg';		// <-- (pk7_xxx.jpg)

	
		
	
		/* UPLOAD ORIGINAL FILE */  // <--- full-sized img
		$tmp_name = $src['tmp_name'];
		
		if ($ext == 'image/jpg' || $ext == 'image/jpeg') 
								  $img  = imagecreatefromjpeg($tmp_name);
		if ($ext == 'image/png')  $img  = imagecreatefrompng ($tmp_name);
		if ($ext == 'image/gif')  $img  = imagecreatefromgif ($tmp_name);
		
		$folder = '../img/image/'.$filename; 		// <-- (original/pk7_xxx.jpg)
		
		if (!imagejpeg($img,$folder,90))
			die ('Couldn\'t save the image in the server');
		
		imagedestroy($img);

		
		
		

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
				
				
			
			
			
			/* DATABASE UPDATE AVATAR */
			try {
				$collection = $database->players;

				$query 	= array('url-name' => $user_name);
				$update = array('$set' => array('cover' => $filename));
				
				// INSERT -- UPDATE
				$collection->update($query,$update);
			}
			catch(MongoCursorException $e)
				{echo 'ERROR: We\'re dead! <br> There\'is some issues in our database!';}
			


	}// END -- valid image (.jpg .png .gif)
?>