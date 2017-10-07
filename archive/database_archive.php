<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

session_start();
$user_name = $_SESSION['mypage'];

	if (isset($_GET['data'])){
		/* GET AVATAR */ // <--- current_
		try {
		include_once 'config.php';
		$collection = $database->archive;
	
		$query 		= array('url-name' => $user_name, '$exists' => array('image' => 1));
		$projection = array('id_' => 0, 'image' => 1));
		
		// INSERT -- UPDATE
		$collection->find($query,$projection);
		
		
		}
		catch(MongoCursorException $e) {
			echo 'ERROR: We\'re dead! <br> There\'is some issues in our database';
		}
	}
}
?>