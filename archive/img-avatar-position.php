<?php

	$src = $_POST['src'];				// (original/xxx.jpg)
	$src_name = pathinfo($src);
	$filename = $src_name['basename']; 	// (xxx.jpg)

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



			$img  	= imagecreatefromjpeg('../'.$src);
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


?>