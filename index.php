<?php

	require "class/element_iot.inc.php";
	// For more Informations see Documentation!
	$element_iot = new element_iot("your_api_key", "your_domain");//__construct($api_key, $domain)

	
	$data = $element_iot->get(["devices", "readings"], ["limit" => 1,"id" => "your_device_id_see_README!"]);//Konfigriert darauf, die letzten 5 Messwerte zu holen
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<?php if ($data["body"][0]["data"]["position"] == "zu") {echo '<meta http-equiv="refresh" content="3">';}?>
	</head>
	<body>
		<h1>ELEMENT IoT in PHP</h1>
		<div class="infobutton" id="<?php echo $data["body"][0]["data"]["position"];?>">
			<!--Das oben gibt auf oder zu zurück.
				Über CSS wird auf dieses DIV ein BG gesetzt
			-->
		</div>
		<h1><?php echo $data["body"][0]["data"]["position"];?></h1>
		<h2><?php echo var_dump($data["body"][0]);?></h2>
	</body>
</html>
