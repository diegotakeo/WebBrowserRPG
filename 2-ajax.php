<?php

if (isset($_GET['_escaped_fragment_'])){


	$data = $_GET['_escaped_fragment_'];
	
	switch ($data) {
		case 'inventory':
		case 'archive':
		case 'stalk-list':
		case 'config':
			echo '<img src="http://www.bahedgejobs.info/images/construction.gif" style="display:block; margin:150px auto 100px">';
			break;


	} // END switch
} // END if

?>