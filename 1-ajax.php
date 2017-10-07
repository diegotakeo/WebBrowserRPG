<?php


if (isset($_GET['_escaped_fragment_'])){


	$data = $_GET['_escaped_fragment_'];

	switch ($data) {
		/* INDEX */
		case 'index':
			//echo '
			//	<div class="hasLine" id="sketch-gallery">
			//		<div> <img src="img/illustrations/20676705.jpg"></div>
			//	</div>
			//	<p>--> Random image from Pixiv</p>
			//';	
			break;
		
		/* GALLERY */
		case 'gallery':
			echo '
					<div class="slider">
						<a href="#" class="slidesjs-next slidesjs-navigation"> 			<div data-icon="<"></div> </a>
						<a href="#" class="slidesjs-previous slidesjs-navigation">  	<div data-icon=">"></div> </a>
						
						<div> <img src="img/others/white_sketch_d.png"></div>
						<div> <img src="img/others/white_sketch_c.png"></div>
						<div> <img src="img/others/white_sketch_b.png"></div>
						<div> <img src="img/others/white_sketch_a.png"></div>
						<div> <img src="img/others/white_sketch_e.png"></div>
					
					</div>	
					
					
					
					<script src="js/jquery.slides.min.js"></script>
					<script>
					$(function(){
						$(".slider").slidesjs({
							width: 500,
							height: 500,
							effect: {slide: {speed:300}},
							navigation: {active: false},
							pagination: {active: false}
						});		
			
					});
					</script>
		';
		break;
		
			
		/* VIDEOS */
		case 'videos':
			$say = file('js/videos.txt');
			$random_say = $say[rand(0, count($say) -1)];
			echo $random_say.'<b style="position:absolute; top:-40px;">--> Random AMV/MAD from YouTube</b>';
			break;
			
			
		/* DOCUMENTATION */
		case 'doc':	
			echo '
					<div class="hasLine box-shadow-LV2" id="doc-documentation">
						<span style="display:block; margin:-60px -20px; color:#BFBFBF; position:absolute; font-size:28pt;">What is it?</span>
						<span>This is my homework. </span><br><br>
						

						<a href="#" data-to="y" onclick="
							$(\'.doc-nav p\').text(\'+\');
							$(\'a .doc-nav\').removeClass(\'active\');
							$(\'#y\').removeClass(\'display-block\');
							return false"
						>	
						<div class="close">X</div>
						</a>
					</div>		
					
					<!-- links -->
					<div class="hasLine doc-section">
						<a href="#"><div id="down-pdf">	download pdf		<span style="float:right; font-size:16px;">3,90 MB</span></div></a>
						<a href="#"><div id="read-it">	read it online		</div></a>	
					</div>
			';
			break;

		/* ABOUT PK7 */
		case 'about':	
			echo '
					<div class="box-shadow-LV2" id="doc-documentation" style="margin-top:80px;">
							<img src="img/avatar/yatogami_22659f4570cbccafdee7ac3d1854918b.jpg" style="
								width:160px;
								float:left;
								margin:-70px -20px;
								border: 1px solid #333;
							">
							<div style="margin-left:40px; float:left;"> 
								<h1>pk7<br> 
								<div style="margin-top:15px;">18 years old</div></h1>	
							</div>
						<br><br><br>
						<p>
						Made in 2015 @ Brazil, Jaboticabal-SP<br>
						 
						<a href="index.php?user=pk7" target="_blank" style="color:#3851d8; font-size:13pt;">usagi-rpg.com?user=pk7</a><br> and 
						<a href="https://www.facebook.com/pk7.usagi" target="_blank" style="color:#3851d8; font-size:13pt;">Facebook</a><br> and
						<a href="https://www.facebook.com/pk7.usagi" target="_blank" style="color:#3851d8; font-size:13pt;">Artstation</a> (￣▽￣)ノ  
						
						</p>
					
						<a href="#" data-to="y" onclick="
							$(\'.doc-nav p\').text(\'+\');
							$(\'a .doc-nav\').removeClass(\'active\');
							$(\'#y\').removeClass(\'display-block\');
							return false"
						>	
						<div class="close">X</div>
						</a>
					</div>
			';
			break;		
		
		/* confirmed EMAIL */
		case 'confirmed':	
			echo '
				<div id="mail-confirmed">
					<span data-icon="&#xe0af;">✖ Successfully Confirmed Email</span>
					<p>You may login right now...</p>
				</div>
			';
			break;
		
		// ALREADY confimed EMAIL
		case 'alreadyconfirmed':	
			echo '
				<div id="mail-confirmed">
					<span data-icon="&#xe0af;">✖ Already Confirmed Email</span>
					<p>Or maybe nonexistent account....</p>
				</div>
			';
			break;
			
		/* DELETED account */
		case 'deleted':
			echo '
				<div id="mail-confirmed">
					<span data-icon="&#xe02b;">✖ Account Deleted</span>
					<p>You really did it...</p>
				</div>
			';
			break;
			
		// COULDN'T DELETE account
		case 'notdeleted':
			echo '
				<div id="mail-confirmed">
					<span data-icon="&#xe0af;">✖ Couldn\'t Delete</span>
					<p>This account was already been <br>deteled or validated...</p>
				</div>
			';
			break;
			
		/* signup STEPS */
		case 'signup':
			include('archive/signup-form.php');
			break;
		
		case 'step-2':
			include('archive/signup-step-2.php');
			break;
		
		case 'step-3':
			include('archive/signup-step-3.php');
			break;
		
		/* SIGN UP validation */
		case 'database-validation':
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			
				$email  	= (empty($_POST['email'])) 	? '' : $_POST['email'];
				$url		= (empty($_POST['url']))  	? '' : $_POST['url'];
				
				include 'archive/config.php';
				
				if ($email !=  '')	$query = array('email' 	  => $email);
				if ($url   !=  '')	$query = array('url-name' => $url);
				
				$collection = $database->players;
				$exists 	= $collection->find($query,array('email' => true));
				
				if ($exists->count() != 0)
					echo 'already in use!';
			}
			break;
		
		/* DELETE account */
		case 'database-delete':
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				include 'archive/config.php';
				
				if (isset($_COOKIE['email']) && isset($_COOKIE['random'])) {
					$query = array(
						'email'  => $_COOKIE['email'],
						'random' => $_COOKIE['random']
					);
					
					$collection = $database->players;
					$find		= $collection->find($query, array('random' => 1));
					
					// not VALIDATED users ONLY
					if ($find->count() != 0) {
						$collection->remove($query);
						
						echo '✖ Deleted <br>:'.$_COOKIE['email'];
						
						setcookie('email',	'', 1, '/');
						setcookie('random', '', 1, '/');
					}
					else
						echo 'ERROR <br>: Already validated account';
				}
				else
					echo "ERROR <br>: Couldn't delete account";
			}
		break;
	} // END switch
} // END if

 ?>