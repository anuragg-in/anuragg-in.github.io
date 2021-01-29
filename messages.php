<?php include "top.php"?>
<div class = "heading">Messages</div>
<div class = "text">
<?php
	$file = fopen("message.txt", "r");
	while(!feof($file))
	{
		echo fgets($file)."<br>";
	}
	fclose($file);
?>
</div>
<?php include "bottom.php"?>
