<!DOCTYPE html>
<html>
	<head>
		<link href="css/style.css" rel="stylesheet" type="text/css">
	</head>
	<?php
	session_start();
	
	//echo  $_GET['type'];
	
	$page_content = 'content/getOrders_content.php';
	include('master.php');
	?>
</html>