<?php
$age 			= (isset($_GET['Age'])) 				? $_GET['Age'] 				: '';
$occ 			= (isset($_GET['Occupation'])) 			? $_GET['Occupation'] 		: '';
$gender 		= (isset($_GET['Gender'])) 				? $_GET['Gender'] 			: '';
$relation 		= (isset($_GET['Relationship'])) 		? $_GET['Relationship'] 	: '';
$birth 			= (isset($_GET['Birthday'])) 			? $_GET['Birthday'] 		: '';
$loc 			= (isset($_GET['Location'])) 			? $_GET['Location'] 		: '';
$mail 			= (isset($_GET['E-mail'])) 				? $_GET['E-mail'] 			: '';

$listening 		= (isset($_GET['Listening_to'])) 		? $_GET['Listening_to'] 		: '';
$watching 		= (isset($_GET['Watching'])) 			? $_GET['Watching'] 			: '';
$reading 		= (isset($_GET['Reading'])) 			? $_GET['Reading'] 				: '';
$playing 		= (isset($_GET['Playing'])) 			? $_GET['Playing'] 				: '';
$fav_art 		= (isset($_GET['Favorite_Artist'])) 	? $_GET['Favorite_Artist'] 		: '';
$fav_char 		= (isset($_GET['Favorite_Character'])) 	? $_GET['Favorite_Character'] 	: '';

echo '

<input type="submit" value="ok">

<p>
<label for=" Age"> Age:</label>
<input type="text" name="Age" id=" Age" value="'.$age.'" autocomplete="off"></p>

<p>
<label for=" Occupation"> Occupation:</label>
<input type="text" name="Occupation" id=" Occupation" value="'.$occ.'" autocomplete="off"></p>

<p>
<label for=" Gender"> Gender:</label>
<input type="text" name=" Gender" id=" Gender" value="'.$gender.'" autocomplete="off"></p>

<p>
<label for=" Relationship"> Relationship:</label>
<input type="text" name=" Relationship" id=" Relationship" value="'.$relation.'" autocomplete="off"></p>

<p>
<label for=" Birthday"> Birthday:</label>
<input type="text" name=" Birthday" id=" Birthday" value="'.$birth.'" autocomplete="off"></p>

<p>
<label for=" Location"> Location:</label>
<input type="text" name=" Location" id=" Location" value="'.$loc.'" autocomplete="off"></p>

<p>
<label for=" E-mail"> E-mail:</label>
<input type="text" name=" E-mail" id=" E-mail" value="'.$mail.'" autocomplete="off"></p>


<br>


<p>
<label for=" Listening to"> Listening to:</label>
<input type="text" name=" Listening to" id=" Listening to" value="'.$listening.'" autocomplete="off"></p>

<p>
<label for=" Watching"> Watching:</label>
<input type="text" name=" Watching" id=" Watching" value="'.$watching.'" autocomplete="off"></p>

<p>
<label for=" Reading"> Reading:</label>
<input type="text" name=" Reading" id=" Reading" value="'.$reading.'" autocomplete="off"></p>

<p>
<label for=" Playing"> Playing:</label>
<input type="text" name=" Playing" id=" Playing" value="'.$playing.'" autocomplete="off"></p>

<p>
<label for=" Favorite Artist"> Favorite Artist:</label>
<input type="text" name=" Favorite Artist" id=" Favorite Artist" value="'.$fav_art.'" autocomplete="off"></p>

<p>
<label for=" Favorite Character"> Favorite Character:</label>
<input type="text" name=" Favorite Character" id=" Favorite Character" value="'.$fav_char.'" autocomplete="off"></p>


';
?>