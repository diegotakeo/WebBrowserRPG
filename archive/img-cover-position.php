<?php

	$src = $_POST['src'];				// (cover/xxx.jpg)
	$src_name = pathinfo($src);
	$filename = $src_name['basename']; 	// (xxx.jpg)

				// 850px frame
				$frame_width  = 850;
				$frame_height = 400;
				

			$x = -(int) $_POST['left'];						// POSITION X & Y
			$y = -(int) $_POST['top'];						// (crop)


			$img  	= imagecreatefromjpeg('../img/image/'.$filename);
			$img_ 	= imagecreatetruecolor($frame_width, $frame_height); 			
				
	
			/* execute CROP */
			imagecopyresampled($img_ , $img, 0,0, $x, $y, $frame_width, $frame_height, $frame_width, $frame_height);
			
			
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
			
			
			
			// save JPG (200px)
			$folder = '../img/cover/'.$filename; // <-- asda53sbj12z3.jpg
			$return = imagejpeg($img_,$folder,90);

			
			imagedestroy($img);
			imagedestroy($img_);
			
			
			if (!$return)
				echo ('We sorry!: Couldn\'t save the image in the server');	


?>