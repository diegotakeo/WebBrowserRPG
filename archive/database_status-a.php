<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$str = (isset($_POST['str'])) ? $_POST['str'] : 0;
	$def = (isset($_POST['def'])) ? $_POST['def'] : 0;
	$wis = (isset($_POST['wis'])) ? $_POST['wis'] : 0;
	$agi = (isset($_POST['agi'])) ? $_POST['agi'] : 0;
	$vit = (isset($_POST['vit'])) ? $_POST['vit'] : 0;

	
	$count = $str+$def+$wis+$agi+$vit;
	
	if ($count != 0) { // <-- NOT EMPTY
		session_start();
		$url_name = $_SESSION['mypage'];
		
		if ($url_name){	// <-- AUTHORIZED USER
			include 'config.php';
			$collection = $database->players;

			// ATTR + COUNT (from database)
			$query 		= array('url-name'=> $url_name);
			$projection = array('attr_points' => 1, 'str' => 1, 'def' => 1, 'wis' => 1, 'agi' => 1, 'vit' => 1);
			$document 	= $collection->find($query,$projection);			
			
			foreach($document as $stuff){
				$db_count = $stuff['attr_points'];
				$db_str   = $stuff['str'] + $str;
				$db_def   = $stuff['def'] + $def;
				$db_wis   = $stuff['wis'] + $wis;
				$db_agi   = $stuff['agi'] + $agi;
				$db_vit   = $stuff['vit'] + $vit;
			}
			
			if ($db_count != 0){
				if($count <= $db_count) {
					// --- UPDATE DATABASE
					$db_count = $db_count - $count;  
					$update   = array('$set' => array(
						'attr_points' => $db_count, 
						'str' 		  => $db_str, 
						'def' 		  => $db_def, 
						'wis' 		  => $db_wis, 
						'agi' 		  => $db_agi, 
						'vit' 		  => $db_vit
					));
					
					try { 
					$collection->update($query,$update);
					}
					catch(MongoCursorException $e)
						{echo 'ERROR: There\'is some issues in our database!';}
				}
				else
					echo 'ERROR: You\'re doing it wrong...';
			}
			else
				echo 'ERROR: Something is wrong! <br> There\'s no avaible points to share...';
		}
		else
			echo 'ERROR: Something is wrong! <br> You\'re not authorized to do this ';
	}
	else
		echo 'ERROR: Something is wrong!'; ;
}
?>