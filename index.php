<?php

	require "class/element_iot.inc.php";
	// For more Informations see Documentation!
	$element_iot = new element_iot("1d08cbb43a64c62e7358be4404e2d578", "ssl://iot.stadtwerke-karlsruhe.de");//__construct($api_key, $domain)

	
	$data = $element_iot->get(["devices", "interfaces"]);//Konfigriert darauf, die letzten 5 Messwerte zu holen
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<h1>ELEMENT IoT in PHP</h1>
		<p>Return:</p>
		<p><?php echo var_dump($data);?></p>
	</body>
</html>