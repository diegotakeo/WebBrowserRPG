<?php 
		$page = $_GET['page'];
		
		include 'config.php';
		session_start();
		$user 		= $_SESSION['mypage'];
		$query		= array('url-name' => $user);
		$projection = array('_id' => 0,'image' => 1);
		
		$collection = $database->covers;
		$documents	= $collection->find($query, $projection)->skip($page * 8)->limit(8);
		
		// SET IMAGES
		$i = 0;
		foreach($documents as $document){
			$i++;
			$image	 = $document['image'];
			if ($i == 7) {
				echo '<img src="img/cover/'.$image.'"  style="margin-left:245px;"/>';
				$i = 0;
			}
			else
				echo '<img src="img/cover/'.$image.'"/>';
		}
?>