<?php
	/* get USER INFORMATIONS */
	include 'archive/config.php';
	$query		= array('url-name' => $user);
	$projection = array(
		'_id'			=> 0,
		'email' 		=> 1,
		'display-name' 	=> 1,
		'lv'			=> 1,
		'exp'			=> 1, 
		'hp' 			=> 1, 
		'max-hp' 		=> 1, 
		'vit'			=> 1,
		'health'		=> 1,
		'money' 		=> 1, 
		'attr_points' 	=> 1, 
		'img' 			=> 1, 
		'cover' 		=> 1
	);
	
	$collection = $database->players;
	$documents	= $collection->find($query, $projection);	

	// SET VARIABLES
	if ($documents->count() === 1) {
		foreach($documents as $document){
			$email	 = $document['email'];
			$name 	 = $document['display-name'];
			$lv		 = $document['lv'];
			$exp	 = $document['exp'];
			$hp		 = $document['hp'];
			$max_hp	 = $document['max-hp'];
			$vit	 = $document['vit'];
			$health  = $document['health'];
			$money	 = $document['money'];
			$attr	 = $document['attr_points'];
			$img	 = $document['img'];
			$cover	 = (empty($document['cover'])) ? false : $document['cover'];
		}
		
		// LV e EXP
		$max_exp	 = ($lv*100);
		$percent_exp = ($exp * 100)/$max_exp;				// <-- (percent) EXP
		$lv			 = str_pad($lv, 2, '0', STR_PAD_LEFT); // <-- add 0, like LV 01
		
		// HP e MONEY
		$max_hp		 = $max_hp+$health+($vit*10)+($lv*10);	// <-- MAX_HP
		$percent_hp  = ($hp*100)/$max_hp;
		$money 		 =  number_format($money, 2, '.', '.');
	}
	else
		header('Location: index.php');

// -------------------------------------------------------------------------------//	
session_start();
$_SESSION['money']	   	= $money;
$_SESSION['this_page'] 	= $user; //$_GET['user']; 
$_SESSION['mypage']    	= false;
$_SESSION['logged']	   	= false;
$mypage				   			= false;
$logged 			   				= false;

	/* ONLINE USER */ // <-- has COOKIE
	if (isset($_COOKIE['login'])) {

		// validate cookie 
		$query 		= array('login' => $_COOKIE['login']);
		$collection = $database->cookies;
		$return 	= $collection->find($query);
		
		// OK  <-- valid COOKIE
		if ($return->count() === 1) {
			$url_name_cookie = explode(';',$_COOKIE['login']);
		
			$_SESSION['logged'] = $url_name_cookie[0];				// <-- LOGGED $url_name
			$logged = true; // to not repeat $_SESSION

			/* IT'S MY PAGE? */
			if ($url_name_cookie[0] === $user) {
				$_SESSION['mypage'] = $user;						// <-- MYPAGE $_GET['user']
				$mypage = $user; // to not repeat $_SESSION
			}
		}
		// WRONG <-- such a COOKIE doens't exists on DATABASE
		else {
			setcookie('login', '', 1, '/');
			unset($_SESSION['logged']);
		} // someone else logged in your account!
		
	}
// -------------------------------------------------------------------------------//
/* CUSTOM STYLE */ // <-- CSS files	
echo '<link rel="stylesheet" href="';
	if ($logged)  	echo 'archive/style_log.css';
	if (!$logged) 	echo 'archive/style_not-log.css';
echo '">';

echo '<link rel="stylesheet" href="';	
	if ($mypage) 	echo 'archive/style_mine.css';
	if (!$mypage) 	echo 'archive/style_not-mine.css';
echo '">';


	
// -------------------------------------------------------------------------------//	
// end --> PHP		
?>

<!--------------------- RPG MENU (navigation) -->
		<nav class="rpg_menu">
			<a href="#" class="menu_trigger"><span>Menu</span></a>
			<ul>
				<li><a href="#" data-icon="">Hospital</a></li>
				<li><a href="#" data-icon="">Convenience</a></li>
				<li><a href="#" data-icon="¥">Market</a></li>
				<li><a href="#" data-icon="">Tavern</a></li>
				<li><a href="#" data-icon="">Freelance</a></li>
				<li><a href="#" data-icon="">Reinforcement</a></li>
				<li><a href="#" data-icon="">VS Battle</a></li>
				<li><a href="#" data-icon="">Dungeon</a></li>
				
				<div class="NPC">
					<img src="img/NPC/1.png" id="_2" />
					<!-- <img src="img/NPC/14.png" id="_3"/> -->
					<div class="npc_talk hasArrow">
						<span class="npc_name">NPC プリニー</span>
						<p></p>
						 
						<div class="npc_exp" data-icon="">
							<span>Relationship</span>
							<span style="right:0;">Lv. 01</span>
							<div style="position:absolute; background-color:#6b97e6; height:18px; opacity:0.5; width:50%;"></div>
							<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
						</div>
					</div>
				</div>
			</ul>

			<div class="menu_overlay"></div>
		</nav>
<!------------------------------------------------------------------------------------------------------------------------------------------>

	<!-- MESSAGE LOG -->
	<div id="message-log" class="box-shadow-LV2">
		<div>X</div>
		<b></b> 
		<p></p>
	</div>

	<!-- MODAL WINDOW -->
	<div id="mascara"></div>
	<div id="drop-mask"></div>
	<div id="window" class="ajax-box box-shadow-LV2">
	
	</div>

<!-- CONTAINER -->
<div id="container">


<!------------------------------------------------------------------------------------------------------------------------------------>	
<!-- TOP --> <!-- LOGIN, LOG-OUT, NOTIFICATIONS, SEARCH -->


	<div id="top">
	
		<!-- 兎RPG (title) -->
		<a href="index.php?" id="home" style="float:left; width:170px;"><h1 style="font-size:41pt;">兎RPG</h1></a>
	

	
		<div id="top-right" dropdown-id="x">
		
	
			<!-- TOP-LINKS -->
			<a href="#" id="log" <?php if($logged) echo 'class="logged"'; ?>
												data-to="dropdown"><div data-icon=""></div>	</a>
			<?php if ($logged)
			echo '
			<a href="#" id="info-chat" 			data-to="dropdown"><div data-icon=""></div>	</a>
			<a href="#" id="notifications" 		data-to="dropdown"><div data-icon=""></div>	</a>';
			?>
			
			<!-- TOP-DROPDOWN  -->
			<div id="x" class="dropdown hasArrow box-shadow-LV2 noSelect">
					<?php if($logged) echo ' 
					<div id="option-volume">	
						<div class="icon" data-icon=""></div> 
						<div id="volume"></div>	
					</div>
					
					<a href="archive/logout.php">
					<div id="option-logout">	
						<div class="icon" data-icon=""></div> 
						<span>Log out</span>		
					</div>
					</a>';
					// LOG IN (formulário)
					else echo'
					<form id="login">
						<input type="text" id="email" value="your e-mail" string="your e-mail" autocomplete="off" spellcheck="false"/> <br/>
						<label for="email" data-icon=""></label>
						
						<input type="text" value="password" string="password" id="fakepassword" />
						<input type="password" value="" id="password" style="display:none;"/>
						<label for="password" data-icon=""></label>
						
						<input type="submit" id="submit" value="log-in">
					</form>
					';?>
			</div>	
		</div>

		
		
		<!-- search BAR -->
		<div style="width:330px; float:right; margin-right:10px;  position:relative;">
			<input class="with-ico" type="text" name="search" id="search" value="search for someone..." string="search for someone..."/>
			<label for="search" class="icon" data-icon="" style="margin:-80px 5px;"></label>
		</div>
		
	</div>
	<!-- END // top -->
	<div style="clear:both"/>
	
	
	
<!------------------------------------------------------------------------------------------------------------------------------------>		
<!-- COVER e AVATAR -->


	<!-- HEADER -->
	<div id="header" class="box-shadow-LV2">
	
	
		<!-- cover -->
		<div id="cover" <?php if($cover) echo 'data-file="'.$cover.'"'; ?>>

			<?php if ($mypage) echo '
			<a href="#img-cover.php" id="change" data-to="change-cover">	
				<div class="change" data-icon="">	<span>change cover</span>	</div>	
			</a>
			
			<div class="ajax-box" id="change-cover"></div>'; // <-- #change-cover (container)
			?>
			
		</div>
		
		
		
		<!-- avatar -->
		<div id="avatar">
			<a href="index.php?user=<?php echo $user; ?>"> 
				<img src="img/avatar/<?php echo $img.'" alt="'.$user; ?>">
			</a>

			<?php if ($mypage) echo '
			<a href="#img-avatar.php" id="change" data-to="window">
				<div class="change" data-icon="">	<span>change avatar</span>	</div>
			</a>'; // change link
			?>
			
		</div>
		
<!------------------------------------------------------------------------------------------------------------------------------------>	
<!-- NAVIGATION -->

			<!-- main links -->
			<div id="navigation" >
				<a href="#!_profile.php"	id="profile"	data-to="main-wrapper"><div data-icon=""></div>	</a>
				<a href="#!_inventory.php"	id="inventory" 	data-to="main-wrapper"><div data-icon=""></div>	</a>
				<a href="#!_archive.php"	id="archive" 	data-to="main-wrapper"><div data-icon=""></div>	</a>
				<a href="#!_stalk-list.php"	id="stalk-list" data-to="main-wrapper"><div data-icon=""></div>	</a>
				
				<?php
				if ($mypage){	// <-- configuration
					echo ' <a href="#!_config.php" id="config" data-to="main-wrapper"><div data-icon=""> </div>	</a>';
				}
				elseif ($logged){	// <-- stalking
					echo '
					<a href="#" id="stalk" style="display:none;"> <div data-icon="+"></div>	</a>
					
					<!-- stalked-dropdown-->
					<div dropdown-id="y">
		
						<a href="#" id="stalked" data-to="dropdown"><div data-icon=""></div></a>
						
						<div id="y" class="dropdown hasArrow box-shadow-LV2 noSelect">
								<div id="option-notification">	<div class="icon" data-icon=""></div><span>receive notifications	</span>	</div>
								<div id="option-chatroom">		<div class="icon" data-icon=""></div> <span>chatroom notifications</span></div>
								<div id="option-stop">			<div data-icon=""><span>stop stalking</span></div></div>
						</div>
					</div>
					';
				}
				?>

				
			</div>
			
			
			
			
	</div>
	<!-- END // header -->
	
	
	
<!------------------------------------------------------------------------------------------------------------------------------------>	
	<!-- CONTENT-WRAPPER -->
	<div id="main-wrapper" class="ajax-box">
		<?php 
		if (isset($_GET['_escaped_fragment_']))
			include('2-ajax.php'); 
		else 
			include('archive/_profile.php');
		?>	
	</div><!-- END // main-wrapper -->
</div> <!-- END // 850px container -->

	
	<!-- OTHER THINGS -->
	<div class="loading"></div>
	<div class="hidden_mask"></div>
	
<script src="2-script.js"></script>

<script>
<?php 
/* CUSTOM JAVASCRIPT */
	if (!$logged) 	include 'archive/script_not-log.js';
	if ($mypage) 	include 'archive/script_mine.js';
?>
</script>