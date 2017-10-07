
<?php
// CSS <---------------->
echo 	'<style>';
include 'user-questions.css';
echo 	'</style>';

session_start();
$this_page 	= $_SESSION['this_page'];
$mypage	   	= $_SESSION['mypage'];
$logged		= $_SESSION['logged'];

	include 'config.php';
	$collection = $database->questions;
	
	$query 		= array('to' => $this_page);
	$document   = $collection->find($query)->sort(array('_id' => -1));



if ($logged){
echo '				<span>Ask me Anything </span>
					
							<!-- TEXT AREA (question) -->
							<form method="post" id="question">';
							
								
								if (!$mypage){
									echo '
									<div id="anonymous-checkbox" class="noSelect">
										<label for="as-anonymous">Post as anonymous</label>
										<input type="checkbox" name="as-anonymous" id="as-anonymous"/>
									</div>';
								}
								
								
echo '							<textarea name="question" placeholder="Type your question here..." maxlength="140" spellcheck="false"></textarea>
								<span>残り <data>140</data>...</span>
								<div class="hidden"><input type="submit" value="★ - ok"/></div>
							</form>
';
}
?>
	
	
			<!-- asking BOX -->
			<div id="asking-box">
					
					
<?php
					if ($document->count() != 0) {
						foreach($document as $stuff){
							$mongo_id 	= (isset($stuff['_id'])) 		? $stuff['_id'] 		: false;					
							$from 		= (isset($stuff['from'])) 		? $stuff['from'] 		: '&lt; anonymous &gt;';	// ●︿● 兎 ★ pk7-diego ♫
							$from_img 	= (isset($stuff['from_img'])) 	? $stuff['from_img'] 	: false;					// pk7_xxx.jpg (also url ?user=pk7)
							$question 	= (isset($stuff['question'])) 	? $stuff['question'] 	: false;
							$answer 	= (isset($stuff['answer'])) 	? $stuff['answer'] 		: false;
							
							$from_url = 'empty';
							$ahref = '#';
							if ($from != '&lt; anonymous &gt;') {
								$from_url	= explode('_',$from_img);
								$from_url	= $from_url[0];																	// url-name (pk7)
								
								$ahref = '?user='.$from_url;
							}
							
							/* ASK-BLOCK  - QUESTION */
							echo '
								<div class="ask-block">
									<div class="mongo_id">'.$mongo_id.'</div>
									<a href="'.$ahref.'"><img src="img/avatar/small/'.$from_img.'"></a>
									<div class="text">';
										// ANSWERED ★ 
										if ($answer) echo '
										<div class="half_star"></div>';
										
										
echo '									<a href="'.$ahref.'" class="name"><b>'.$from.'</b></a>
										<p>'.$question.'</p>
								
										<div class="nav">';
											// EDIT BUTTON
											if ($logged === $from_url && !$answer) echo '
												<a href="#" class="a-edit">	△ Edit</a>';
											
											// DELETE BUTTON
											if ($logged === $from_url || $mypage) echo'
												<a href="#" class="a-delete"> ✖ Delete</a>';
												
echo 									'</div>
									</div>	
									<br style="clear:both;">
								</div>';
							
							
							/* ASK-BLOCK - ANSWER */
							if ($answer) {
							echo '
								<div class="ask-block answer" style="border:none;">
									<data class="the-answer">
										<img src="">
										
										<div class="text">
											<p>'.$answer.'</p>
										</div>
										
										<div class="nav">';
										if ($mypage) echo'
											<a href="#" data-icon=""></a>
											<a href="#">x</a>';
											
echo '									</div>				
									</data>
									<br style="clear:both;">
								</div>';
							}
							
							/* ASK-BLOCK - TEXTAREA */
							elseif ($mypage) {
							echo '
								<div class="ask-block answer write">
									<data class="the-write">
										<form>
											<textarea placeholder="Write your answer here..." maxlength="140" spellcheck="false"></textarea>
											<span>残り <data>140</data>...</span>
											<div class="hidden"><input type="submit" value="ok"/></div>
											
										</form>
									</data>
									<br style="clear:both;">
								</div>';
							}
							
							
						} // end - foreach
					} // end ->count()
?>					
					
			
		</div>
		<!-- END // asking BOX -->
					
					
					
	<!-- NAVIGATION -->
	<div id="ask-navigation">
		<a href="#" data-to="ask" class="active">1</a>
		<a href="#" data-to="ask">2</a>
		<a href="#" data-to="ask">3</a>
		<a href="#" data-to="ask">4</a>
		<a href="#" data-to="ask">></a>
		
		<a href="#">★</a>
	</div>
	
	<div id="ask-options">
			<div>
				<label for="pg">page</label>
				<select id="pg" name="pg">
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
				</select>
				
			</div>
			<div>
				<label for="per">show</label>
				<select id="per">
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
				</select>
			</div>
			<div><label>close</label></div>
			<br style="clear:both;"/>
	</div>


<?php
// JAVASCRIPT <---------------->
echo 	'<script>';
include 'user-questions.js';
echo 	'</script>';
?>