<?php

	require "class/element_iot.inc.php";
	// For more Informations see Documentation!
	$element_iot = new element_iot("1d08cbb43a64c62e7358be4404e2d578", "ssl://iot.stadtwerke-karlsruhe.de");//__construct($api_key, $domain)

	
	$data = $element_iot->get(["devices", "readings"], ["limit" => 1,"id" => "f5261911-7f7b-4870-a5f5-7f4c7e9ff5e5"]);//Konfigriert darauf, die letzten 5 Messwerte zu holen
	
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
	</body>
</html>