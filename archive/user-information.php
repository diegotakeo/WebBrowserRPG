<?php 
session_start();
$mypage = $_SESSION['mypage'];		// <-- edit
$user   = $_SESSION['this_page'];	// <-- get info


	/* get USER INFORMATIONS */ // <-- from DATABASE
	include 'config.php';
	$query		= array('url-name' => $user);
	
	$collection = $database->info;
	$document	= $collection->find($query);	
	$count 		= $document->count();
	
	
		if (!$mypage && $count == 0)
		exit;
	
	
	if ($count === 1) {
		foreach($document as $stuff){
			$age 		 = (isset($stuff['Age'])) 		 		 ? $stuff['Age'] 		 	 	: false;
			$occup 		 = (isset($stuff['Occupation'])) 		 ? $stuff['Occupation'] 	  	: false;
			$gender 	 = (isset($stuff['Gender'])) 	 		 ? $stuff['Gender'] 	  		: false;
			$relation 	 = (isset($stuff['Relationship'])) 		 ? $stuff['Relationship'] 	  	: false;
			$birth 		 = (isset($stuff['Birthday'])) 	 		 ? $stuff['Birthday'] 	  		: false;
			$location 	 = (isset($stuff['Location'])) 	 		 ? $stuff['Location'] 		  	: false;
			$mail 		 = (isset($stuff['E-mail'])) 		 	 ? $stuff['E-mail'] 		  	: false;
			
			$listening 	 = (isset($stuff['Listening_to']))   	 ? $stuff['Listening_to']   	: false;
			$watching 	 = (isset($stuff['Watching'])) 	  		 ? $stuff['Watching'] 	  		: false;
			$reading 	 = (isset($stuff['Reading'])) 	  		 ? $stuff['Reading'] 	  		: false;
			$playing 	 = (isset($stuff['Playing'])) 	  		 ? $stuff['Playing'] 	  		: false;
			$fav_art 	 = (isset($stuff['Favorite_Artist'])) 	 ? $stuff['Favorite_Artist'] 	: false;
			$fav_char 	 = (isset($stuff['Favorite_Character'])) ? $stuff['Favorite_Character'] : false;
			$description = (isset($stuff['description'])) 		 ? $stuff['description'] 		: false;
		}
		
		// info PART ONE
		if ($age || $occup || $gender || $relation || $birth || $location || $mail)
			 $_info = true;
		else $_info = false;
		
		// info PART TWO
		if ($listening || $watching || $reading || $playing || $fav_art || $fav_char)
			 $__info = true;
		else $__info = false;
		
		if ($_info || $__info)  $display = '';
		else					$display = 'style="display:none;"';
		
		
		if ($_info && $__info)	
			 $_br = true;
		else $_br = false;
	}
	else 
		$display = 'style="display:none;"';
		
		
// --------------------------------------------------------------------------------------------------------- //		
if ($mypage && $display) // <-- if NO INFO 
	echo '<a href="#" class="no-info" id="_info"><span data-icon="">Write about you</span></a>';
	// <add button>
	

		
				/* user INFORMATIONS */
echo '			<div id="user-personal" class="user_info" '.$display.'>
					<span>Personal Information</span>
					

					
					
					<div class="info">';

if (!empty($age)) 		echo '	<p>	<b>Age:</b> 				'.$age			.'</p>';
if (!empty($occup))  	echo '	<p>	<b>Occupation:</b> 			'.$occup		.'</p>';
if (!empty($gender))  	echo '	<p>	<b>Gender:</b> 				'.$gender		.'</p>';
if (!empty($relation))  echo '	<p>	<b>Relationship:</b> 		'.$relation		.'</p>'; 
if (!empty($birth))  	echo '	<p>	<b>Birthday:</b> 			'.$birth		.'</p>';
if (!empty($location))  echo '	<p>	<b>Location:</b> 			'.$location		.'</p>';
if (!empty($mail))  	echo '	<p>	<b>E-mail:</b> 				'.$mail			.'</p>';

if (isset($_br))
echo '<br>';


if (!empty($listening)) echo '	<p>	<b>Listening to:</b> 		'.$listening	.'</p>';
if (!empty($watching))  echo '	<p>	<b>Watching:</b> 			'.$watching		.'</p>';
if (!empty($reading))  	echo '	<p>	<b>Reading:</b> 			'.$reading		.'</p>';
if (!empty($playing))  	echo '	<p>	<b>Playing:</b> 			'.$playing		.'</p>';
if (!empty($fav_art))  	echo '	<p>	<b>Favorite Artist:</b> 	'.$fav_art		.'</p>';
if (!empty($fav_char)) 	echo '	<p>	<b>Favorite Character:</b> 	'.$fav_char		.'</p>';

echo '				</div>';
					
					
					if ($mypage){
						echo '
						<div class="inputs"></div>
						<a href="#"><div data-icon=""></div></a>'; // edit button
					}
					
echo '			</div>';
				// END - INFORMATION

		
		
// --------------------------------------------------------------------------------------------------------- //	
$description = (isset($description)) ? $description : '';
		
if ($mypage && !$description) // <-- if NO INFO 
	echo '<a href="#" class="no-info" id="_description"><span data-icon="+">Add description</span></a>';
	// <add button>
	
if (!$description)
	$display_ = 'style="display:none;"';
else
	$display_ = '';
	
	
	
			/* user DESCRIPTION */
				echo '
				<div id="user-description" class="user_info hasLine" '.$display_.'>
					<span>Description</span>
					
					<div class="info">
						<p>'.$description.'</p>					
					</div>';
					
					
					// input
					if ($mypage) echo '
					<div class="inputs"></div>
					<a href="#"><div  data-icon=""></div></a>'; // edit button
					
				echo 
				'</div>';
			
			// END - DESCRIPTION	
		

			
			
			
			


	

?>

<script>
// useless fix
if (!$('#user-personal').is(':visible'))
	$('#user-description').removeClass('hasLine');

	
<?php
if ($mypage)
	include 'user-information.js';	// <-- <edit button> && <add button>
?>

</script>