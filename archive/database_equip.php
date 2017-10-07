<?php
	session_start();
	$mypage   = $_SESSION['mypage'];
	$mongo_id = $_POST['id'];
	$slot_num = $_POST['slot_num'];
	
	/* DATABASE STUFF */
	include 'config.php';
	$collection = $database->backpack;
	$query 		= array('_id' => $mongo_id, 'url-name' => $mypage);
	$update   	= array('$set' => array('equip' => $slot_num));
	$documents  = $collection->update($query,$update);
?>