<?php

	/* TEXTAREA */ // <-- to append
	echo '
		<data class="the-write">
			<form>
						<textarea 
								placeholder="Type your answer here..." 
								maxlength="140" 
								spellcheck="false">'.$_POST['text'].'</textarea>
						<span>残り <data>140</data>...</span>
						<div class="hidden"><input type="submit" value="ok"/></div>
			</form>
			<br style="clear:both;">
			
			<script>
				$("textarea").keyup();
			</script>
		</data>';
			

?>