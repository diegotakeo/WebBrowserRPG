<?php
	/* HAS $_COOKIE */
	if (isset($_COOKIE['login'])) {
		include 'archive/config.php';
		
		/* validate cookie */
		$collection = $database->cookies;
		$query 		= array('login' => $_COOKIE['login']);
		$return 	= $collection->find($query);
		
		/* OK */ //<-- valid COOKIE
		if ($return->count() === 1) {
				$url_name = explode(';', urldecode($_COOKIE['login']));	// <-- split COOKIE (url_name + salt)

				/* go to MY PAGE */
				header('Location: index.php?user='.$url_name[0].'#');
			
		}
		/* WRONG */	// <-- such a COOKIE doens't exists on DATABASE
		else { // <-- someone else are logged in your account!
			setcookie('login', '', 1, '/');
			unset($_SESSION['logged']);
		}
	}
	
	
?>


<!-- facebook like -->
<div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
<!-- end // facebook like -->

		<!-- MODAL WINDOW -->
		<div id="mascara"></div>
		
		<div id="window">
			<a href="#" id="fechar">X</a>
			<div>
			</div>
		</div>
		
		<!-- MESSAGE LOG -->
		<div id="message-log" class="box-shadow-LV2">
			<div>x</div>
			<b></b> 
			<p></p>
		</div>		
	


<div id="container">


	<!-- LEFT SIDE -->
	<div id="lateral-left">
		<div id="usagi-logo"></div>
				
				
		<div class="ajax-box" id="x">		
			<?php 
				if (isset($_GET['_escaped_fragment_'])) 
				include('1-ajax.php'); 
			?>			
		</div>
	
	</div>

	<!-- END // LEFT SIDE-->
	
	
	<!-- RIGHT SIDE -->
	<div id="lateral-right">
		
		
		<!-- LOGIN FORM -->﻿
		<div class="box-shadow-LV2" id="login_block">
				
				<form>
					<input class="input" type="text" id="email" value="your e-mail" string="your e-mail" autocomplete="off" spellcheck="false"/> <br/>
					<div class="input_ico" id="login-ico" data-icon=""></div>
					
					<input class="input" type="text" 	 value="password" string="password" id="fakepassword" onfocus="pwdFocus()" />
					<input class="input" type="password" value="" id="password" onblur="pwdBlur()" style="display:none;"/>
					<div class="input_ico" id="password-ico" data-icon=""></div>
					
				
							<!-- SIGN UP & SOCIAL LOGIN -->
							<div class="form-nav">
								<a href="#!signup" data-to="x"><div id="signup">Create a new account</div></a>
								<a href="#"><div id="login-with"> or Login with your...</div></a>
								
								<div class="hasLine" id="social-login">	
									<a href="#"><div id="facebook"> Facebook 	</div></a>
									<a href="#"><div id="google">   Google+ 	</div></a>
									<a href="#"><div id="twitter" > Twitter		</div></a>
								</div>
							</div>
					
					<input type="submit" id="submit" value="Log in">
				</form>			
						
		</div>
		<!-- END // LOGIN FORM-->
		
		<!-- social-buttons -->
		<div id="social-buttons">
			<div> <div class="g-plusone" data-size="medium"></div></div>
			<div style="margin-left:-10px;"><a href="https://twitter.com/share" class="twitter-share-button" data-via="pk7_diego" data-lang="ja" data-hashtags="browsergame">ツイート</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>		
			<div style="margin-left:-20px;"><div class="fb-like" data-send="false" data-layout="button_count" data-show-faces="false" data-font="segoe ui"></div></div>
		</div>
		<!-- end // social-buttons -->
	
	
		<!-- NAVIGATION -->
		<div id="navigation-container">
			<a href="#!gallery"	data-to="x">		<div class="nav-block" id="gallery" data-icon="">  <span>sketches		</span>	</div></a>
			<a href="#!"		data-to="x">		<div class="nav-block" id="home" 	data-icon="">  <span>index			</span>	</div></a>
			<a href="#">							<div class="nav-block" id="videos" 	data-icon="">  <span>video			</span>	</div></a>
			<a href="#">							<div class="nav-block" id="doc"		data-icon="">  <span>documentation	</span>	</div></a>
		</div>
		<!-- END // NAVIGATION -->

		
		
		
		<!-- DEVELOPERS SECTION -->
		<div id="developers-section">
		
			<!-- nav -->		
			<div class="hasArrow doc-section">

				<a href="#!about"	data-to="y">	<div id="doc-author" class="doc-nav">	about developer		<p>+</p></div></a>
				<a href="#!doc"		data-to="y">	<div id="doc-down"	 class="doc-nav">	documentation		<p>+</p></div></a>
				
			</div>
			<!-- end // nav-->
			
			<!-- the doc CONTAINER -->
			<div class="ajax-box" id="y">
			</div>
			<!-- end // doc CONTAINER -->
			
		</div>
		<!-- end // DEVELOPERS SECTION -->	



		
	</div>
	<!-- END // RIGHT SIDE -->
	
	
	
	
	
	

</div>


	<!-- Back Top -->
	<a href="#" id="go_top">⇡</a>
	<div class="loading"></div>
	
	<script src="1-script.js"></script>
	
	


<!-- google +1 -->
<script type="text/javascript">
  window.___gcfg = {lang: 'ja'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<!-- end // google +1 -->