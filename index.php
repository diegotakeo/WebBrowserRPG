<?php
	$user = (empty($_GET['user'])) ? '' : $_GET['user'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>usagi RPG - Web Browser Game</title>
	<link rel="shortcut icon" href="img/favicon.ico" />
	<link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon.png" />
	<link rel="canonical" href="http://usagi-rpg.com" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximun-scale=1, user-scalator=no"> 
	<meta http-equiv="content-language" content="en-US" />
	<meta name="keywords" content="Web Browser Game, usagi RPG, Anime Manga Light Novel, new Social Media, just like Facebook" />
	<meta name="description" content="usagi RPG is a Web Browser Game made by pk7 where you can enjoy the best of the RPG system and have the sweet experience of chatting in an Durarara!! like chatroom with other players. Of course, Level, PVP, Dungeons, NPC, and other RPG stuffs are present in this homemade webgame." />
	<meta name="Author" content="pk7" />
	
	<meta property="og:url"   content="http://usagi-rpg.com" />
	<meta property="og:title" content="兎RPG - Web Browser Game - うさぎ / usagi RPG" /> 
	<meta property="og:image" content="" />
	
	<meta charset='utf-8'>
	
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
	<script src="js/jquery-1.11.0.min.js"></script>
	<script src="js/jquery.ba-bbq.min.js"></script>

	
	<!-- temp STYLE (icomoons) 
	<link rel="stylesheet" href="http://i.icomoon.io/public/temp/29292392e4/UntitledProject1/style.css">-->
	
	<?php 
	if ($user)
		echo '<link rel="stylesheet" type="text/css"  href="2-style.css">';
	else
		echo '<link rel="stylesheet" type="text/css"  href="1-style.css">';
	?>
	
</head>
<body>
<?php
if ($user) 		include('2-index.php');
else			include('1-index.php');
?>



</body>
</html>