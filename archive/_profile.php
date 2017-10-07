<!------------------------------------------------------------------------------------------------------------------------------------>	
<!-- HP, EXP e MONEY -->

		<div id="profile" class="conteudo">
		
			<!-- LEFT_SIDE -->
			<div class="left-side">
				<!-- user HP, EXP & ¥yen -->
				<div id="user-info" class="hasLine">
					<!-- NAME -->
					<h1><?php echo $name; ?></h1>
					
					<div id="hover-hp"></div>
					<div id="hover-exp"></div>
					
					<!-- HP -->
					<div id="hp" data-icon="">	<div class="bar">	
						<div class="progress" style="width:<?php echo $percent_hp; ?>%;"></div>
						<div class="first"></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
					</div></div>
						<div class="progress-num"><?php echo $hp.'/'.$max_hp; ?></div>
					
					<!-- EXP -->
					<div id="exp">	<div class="bar">
						<div class="progress" style="width:<?php echo $percent_exp; ?>%;"></div>
						<div class="first"></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
					</div></div>
						<div class="progress-num"><?php echo $exp.'/'.$max_exp; ?></div>
					
					
					<!-- MONEY -->
					<div id="money"><span>¥ <?php echo $money;?></span></div>
				</div>
	

<!------------------------------------------------------------------------------------------------------------------------------------>	
<!-- SOCIAL LINKS e STALKER -->	
	
				<!-- user SOCIAL LINKS 
				<div id="user-links"> 
					<a href="https://twitter.com/pk7_diego" 	title="twitter" 	target="_blank">	<div data-icon="&#xe08f;"></div></a>
					<a href="http://diego-pk.deviantart.com/" 	title="deviantART" 	target="_blank">	<div data-icon="&#xe002;"></div></a>
					<a href="http://pinterest.com/pk7diego/" 	title="pinterest" 	target="_blank">	<div data-icon="&#xe007;"></div></a>
					<a href="http://dribbble.com/pk7_diego" 	title="Dribbble" 	target="_blank">	<div data-icon="&#xe005;"></div></a>
					<a href="https://github.com/pk7" 			title="github" 		target="_blank">	<div data-icon="&#xe008;"></div></a>
					<a href="https://plus.google.com/" 			title="google+" 	target="_blank">	<div data-icon="&#xe000;"></div></a>
					<a href="http://www.facebook.com/diego.t.pk"title="facebook" 	target="_blank">	<div data-icon="&#xe08e;"></div></a>
					<a href="http://pixiv.me/diego_pk7" 		title="pixiv" 		target="_blank">	<div data-icon="&#xe08d;"></div></a>
				</div>
				-->
				
			
				
				<div id="user-information">
				</div>

			</div>
			
			

<!------------------------------------------------------------------------------------------------------------------------------------>	
<!-- STATUS BAR -->

			<!-- RIGHT_SIDE --> 
			<div class="right-side">
				<!-- user STATUS-->
				<div id="user-status" class="ajax-box hasLine" style="background: #fff url(img/loader_bb.gif) center no-repeat;">
				
					<a href="#status-a.php" 						  id="status-a" data-to="user-status" class="active"><div></div></a>
					<a href="#status-b.php?user=<?php echo $user; ?>" id="status-b" data-to="user-status"><div></div></a>
					<span id="level">Level <?php echo $lv; ?></span>
						
							<!-- status A -->
							<div id="status-a" class="conteudo noSelect" onselectstart="return false;">

							</div>
							<!-- end // status-A -->
						
						<span id="attr">point(s) = <data id="count"><?php echo $attr; ?></data></span>
						
						<?php if ($mypage) echo '
						<!-- STATUS hidden FORM -->
						<form method="post">
							<input type="hidden" name="str" value="0">
							<input type="hidden" name="def" value="0">
							<input type="hidden" name="wis" value="0">
							<input type="hidden" name="agi" value="0">
							<input type="hidden" name="vit" value="0">
						
							<input type="submit" id="attr-submit" value="ok"/>
						</form>'; ?>

				</div><!-- END // STATUS -->
				
				
				
				<!-- user QUESTIONS -->
				<div id="user-questions">

				</div>

				
<!------------------------------------------------------------------------------------------------------------------------------------>					

			</div> <!-- END // RIGHT_SIDE -->
			
			
			
		</div> <!-- END // profile -->