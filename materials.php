<?php include "top.php"?>
<style>
	.col-1 a::before
	{
		content: '\27a0\ ';
		color: black;
	}
</style>
<div class = "heading">Materials for projects</div>
<div class = "text">
	<?php
	$materials = array('OHP sheets'=>'It is a plain transparent thick sheet that can be used for drawing. It was conventionally used to make presentation slides for overhead projectors','Fluorescent paper/sheets'=>"",'Translucent paper'=>"Popular known as tracing paper.",'Corrugated plastic sheets'=>"Ideal for usage in aeromodeling projects",'Polyethylene sheet'=>"",'Acrylic sheet'=>"Ideal for building chassis of robots",'PE foam nylon'=>"It is used in packaging as shock absorbant, vibration damper and loose filler.",'Balsa wood'=>"Often used for making light weight RC aeroplanes",'Biofoam'=>"It is used in packaging application for filling spaces and abosorbing shocks.");
	foreach ($materials as $materialName=>$description) 
	{
		echo $materialName."<br>".$description."<br><hr>";
	}
	?>
<?php include "bottom.php"?>
