<?php 
if (isset($_POST['data'])){

	include 'config.php';
	$collection = $database->questions;

	
	session_start();
	$this_page = $_SESSION['this_page'];										// this page
	$mypage	   = (isset($_SESSION['mypage']))	? $_SESSION['mypage'] : false;	// my page?
	$this_user = (isset($_SESSION['logged']))	? $_SESSION['logged'] : false;	// the one logged
	

	if ($_POST['display_name'] == '< anonymous >')
	$_POST['display_name'] = htmlentities($_POST['display_name']);
	
	
	// SEARCH QUERY
	$query = array(
		'to' 	=> $this_page,
		'from' 	=> $_POST['display_name'],
		'_id' 	=> new MongoId($_POST['mongo_id'])
	);

		
	// TEXT
	$text = (empty($_POST['text'])) ? '' : $_POST['text'];
	$text = htmlentities($text,ENT_QUOTES,'UTF-8'); 
	$text = str_replace('&lt;br&gt;','<br>',$text);
	
	
	
	
	switch ($_POST['data']){
		case 'add_answer':
				$update = array('$set' => array('answer' => $text));
				$collection->update($query, $update);
				
				
				// ANSWER (to toggle with WRITE)
				echo'
					<data class="the-answer">
						<img src="'.$_POST['img'].'">
						<div class="text">
							<p>'.$text.'</p>
						</div>
						<div class="nav">
							<a href="#" data-icon="&#xe05d;"></a>
							<a href="#">x</a>
						</div>				
					</data>';
			break;
	
		// -------------------------- UPDATE
		// QUESTION 
		case 'edit_question':
				$update = array('$set' => array('question' => $text));
				$collection->update($query, $update);
				
				echo $text;
			break;
			
			
			
		// ANSWER
		case 'edit_answer':
				$update = array('$set' => array('answer' => $text));
				$collection->update($query, $update);
				
				echo $text;
			break;
	
	
	
	
		// -------------------------- REMOVE
		// QUESTION 
		case 'delete_question':
				$collection->remove($query);
			break;
			
			
		// ANSWER
		case 'delete_answer':
				$update = array('$unset' => array('answer' => 1));
				$collection->update($query, $update);
			break;
	
	}
	
}
?>