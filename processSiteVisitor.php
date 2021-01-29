<?php
	$readFileName = "siteVisitorNew.txt";
	$fileR = fopen($readFileName, "r") or die("Error");
	$fileW = fopen("processedSiteVisitor.txt", "a");
	while(!feof($fileR))
	{
		$line = fgetcsv($fileR);
		print_r($line);
		if($line[0] != "")
		{
			$a=(file_get_contents("https://freegeoip.net/json/{$line[2]}"));
			$a=json_decode($a ,true);
			print_r($a);
			fwrite($fileW, "{$a['ip']},{$a['country_code']},{$a['country_name']},{$a['region_code']},{$a['region_name']},{$a['city']},{$a['time_zone']},{$a['latitude']},{$a['longitude']}\n");	
	#			echo $a["country_name"];
		}
	}
	fclose($fileR);
	fclose($fileW);
	fclose(fopen($readFileName,"w"));
	echo "success";
?>
