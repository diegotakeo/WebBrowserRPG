<?php	
	include 'config.php';
	session_start();
	$this_page = $_SESSION['this_page'];										// this page
	$mypage	   = (isset($_SESSION['mypage']))	? $_SESSION['mypage'] : false;	// my page?
	$this_user = (isset($_SESSION['logged']))	? $_SESSION['logged'] : false;	// the one logged
	
	
	
	$text = htmlentities($_POST['text'], ENT_QUOTES, 'UTF-8'); 
	$text = str_replace('&lt;br&gt;','<br>',$text);
					


		/* QUESTION (to append) */
			if ($this_user){
				// DATABASE CONNECTION --> player
				$collection = $database->players;
				
				$query 		= array('url-name' => $this_user);
				$projection = array('_id' => 0, 'display-name' => 1, 'img' => 1);
				$document 	= $collection->find($query,$projection);
				
				// get --> this_user INFO
				if ($document->count() === 1){
					foreach ($document as $stuff){
						$display_name = $stuff['display-name'];
						$img		  = $stuff['img'];
					}
				}
			}
			
			// NOT LOGGED --> anonymous
			else {
				$display_name = '&lt; anonymous &gt;';
				$img 		  = 'anonymous/'.rand(1,15).'.jpg';
			}
		
		
			
			$url_ = '?user='.$this_user; // <-- link
			
			
			// ANONYMOUS [x] :checked
			if (isset($_POST['anonymous'])) {
				$url_ 	  	  = '';
				$img		  = 'anonymous/'.rand(1,15).'.jpg';
				$display_name = '&lt; anonymous &gt;';
			}
			
		
			// INSERT ON DATABASE!!
			$collection = $database->questions;
			$insert   	= array(
				'to'		=> $this_page,
				'from' 		=> $display_name,
				'from_img'	=> $img,
				'question'	=> $text
			);
		
			$collection->insert($insert);
			

			// RETURN (for JavaScript append)
			echo '
			<div class="ask-block">
				<div class="mongo_id">'.$insert['_id'].'</div>
				<a href="'.$url_.'"><img src="img/avatar/small/'.$img.'"></a>
				<div class="text">
					<a href="'.$url_.'" class="name"><b>'.$display_name.'</b></a>
					<p>'.$text.'</p>

					<data></data>
					<div class="nav">
						<a href="#" class="a-edit">		△ Edit</a>
						<a href="#" class="a-delete">	✖ Delete</a>
					</div>
				</div>
				<br style="clear:both;">
			</div>';
			
			if ($mypage) {	// TEXTAREA to answer
				echo '
					<div class="ask-block answer write">
						<data class="the-write">
							<form method="post" >
								<textarea rows="5" placeholder="Write your answer here..." maxlength="140" spellcheck="false"></textarea>
								<span>残り <data>140</data>...</span>
								<div class="hidden"><input type="submit" value="ok"/></div>
								
							</form>
						</data>
						<br style="clear:both;">
					</div>';
			}


