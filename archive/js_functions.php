<?php
$data = (isset($_GET['js'])) ? $_GET['js'] : '';

if (!empty($data)){
	switch ($data) {
		case '':
			echo '';
		break;
	}
}
?>