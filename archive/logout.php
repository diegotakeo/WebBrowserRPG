<?php
	session_start();
	setcookie('login', '', 1, '/');
	unset($_SESSION['logged']);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
?>