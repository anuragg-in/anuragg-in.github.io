<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="index.css" rel="stylesheet" />
<style>
	.heading::before
	{
		/*content: '\2708\ ';*/
		content: '\276f\ ';
	}
	body
	{
		background: var(--color1);
	}
	.content
	{
		text-align: center;
		max-width: 60em;
		margin: auto;
		padding: 1em 4% 4em 4%;
	}
	.canvas
	{
		text-align: center;
		overflow: auto;
		border: 0.1em dotted;
	}
	canvas
	{
	}
	.column-1
	{
		display: inline-block;
		max-width: 100%;
	}
</style>
</head>
<body>
	<?php include "loading_overlay_old.php"?>
	<?php include "header.php"?>
	<div class = "content">
		<div class = "column-1">
			<div class = "heading">Total visitors count</div>
			<div class = "text">
				<?php
					$siteVisitor = fopen("siteVisitor.txt", "r") or die("Error: 1");
					$line = "";
					$lineNumber = 0;
					while(!feof($siteVisitor))
					{
						$line = fgets($siteVisitor);
						$lineNumber++;
					}
					$lineNumber--;
					fclose($siteVisitor);
					echo "Homepage: $lineNumber visits<br>";
				?>
			</div>
			<div id="output"></div>
			<div class = "heading">Daily visit</div>
			<div class = "subheading italic">Last updated: Now</div>
			<div class = "text" id = "scale-1">Scale X &#8658 1 unit = 1 Day</div>
			<div class = "canvas" id = "canvas-1">
				<canvas id = "graph-1" width = "100px" height = "200px">Canvas not supported</canvas>
			</div>
			<div class = "heading">Monthly visit</div>
			<div class = "subheading italic">Last updated: Now</div>
			<div class = "text" id = "scale-2">Scale X &#8658 1 unit = 1 Month</div>
			<div class = "canvas">
				<canvas id = "graph-2" width = "100px" height = "200px">Canvas not supported</canvas>
			</div>
			<div class = "heading">Yearly visit</div>
			<div class = "subheading italic">Last updated: Now</div>
			<div class = "text" id = "scale-3">Scale X &#8658 1 unit = 1 Year</div>
			<div class = "canvas">
				<canvas id = "graph-3" width = "100px" height = "200px">Canvas not supported</canvas>
			</div>
			<div class = "heading">Country wise visit</div>
			<div class = "subheading italic">Last updated: <?php echo date("d-m-Y, H:i:s", filemtime("processedSiteVisitor.txt"));?> IST (GMT+5:30)</div>
			<div class = "text" id = "scale-4">Scale X &#8658 1 unit = 1 Country</div>
			<div class = "canvas">
				<canvas id = "graph-4" width = "100px" height = "200px">Canvas not supported</canvas>
			</div>
			<div class = "heading">Region wise visit</div>
			<div class = "subheading italic">Last updated: <?php echo date("d-m-Y, H:i:s", filemtime("processedSiteVisitor.txt"));?> IST (GMT+5:30)</div>
			<div class = "text" id = "scale-5">Scale X &#8658 1 unit = 1 Region</div>
			<div class = "canvas">
				<canvas id = "graph-5" width = "100px" height = "200px">Canvas not supported</canvas>
			</div>
			<div class = "heading">City wise visit</div>
			<div class = "subheading italic">Last updated: <?php echo date("d-m-Y, H:i:s", filemtime("processedSiteVisitor.txt"));?> IST (GMT+5:30)</div>
			<div class = "text" id = "scale-6">Scale X &#8658 1 unit = 1 City</div>
			<div class = "canvas">
				<canvas id = "graph-6" width = "100px" height = "200px">Canvas not supported</canvas>
			</div>
		</div>
	</div>
<?php
	$file = fopen("siteVisitor.txt", "r") or die("Error: 2");
	while(!feof($file))
	{
	$line = fgetcsv($file);
	$visitDay[$line[0]] += 1;
	$dateExplode = explode("-", $line[0]);
	$visitMonth["{$dateExplode[1]}-{$dateExplode[2]}"] += 1;
	$visitYear["{$dateExplode[2]}"] += 1;
	}
#	print_r($visitDay);
#	echo "<br>";
#	print_r($visitMonth);
#	echo "<br>";
#	print_r($visitYear);
	fclose($file);
	$totalDay = sizeof($visitDay)-1;
	$visitDayMax = max($visitDay);
	$visitDayKeys = array_keys($visitDay);
	$totalMonth = sizeof($visitMonth)-1;
	$visitMonthMax = max($visitMonth);
	$visitMonthKeys = array_keys($visitMonth);
	$totalYear = sizeof($visitYear)-1;
	$visitYearMax = max($visitYear);
	$visitYearKeys = array_keys($visitYear);
	$dateStartExplode = explode("-", $visitDayKeys[0]);
	$dateEndExplode = explode("-", $visitDayKeys[$totalDay-1]);
	$day = $dateStartExplode[0];
	$month = $dateStartExplode[1];
	$year = $dateStartExplode[2];
	$countDay = 0;
	$countMonth = 0;
	$countYear = 0;
	for($i = $dateStartExplode[2]; $i<=$dateEndExplode[2]; $i++)
	{
		$keysYear[$countYear++] = "$year";
		if(!(in_array("$year", $visitYearKeys)))
		{
			$visitYear[$keysYear[$countYear-1]] = 0;
		}
		while(true)
		{
			$month = sprintf("%02d", $month);
			$keysMonth[$countMonth++] = "$month-$year";
			if(!(in_array("$month-$year", $visitMonthKeys)))
			{
				$visitMonth[$keysMonth[$countMonth-1]] = 0;
			}
			while(true)
			{
				$day = sprintf("%02d", $day);
#				echo "$day, $month, $year <br>";
				$keysDay[$countDay++] = "$day-$month-$year";
				if(!(in_array("$day-$month-$year", $visitDayKeys)))
				{
					$visitDay[$keysDay[$countDay-1]] = 0;
#					echo "$day-$month-$year<br>yeah<br>";
				}
				if($day<31)
				{
					if($year!=$dateEndExplode[2])
					{
						if(($day==30 && in_array($month, array('4','6','9','11'))) || ($day==28 && $month==2 && $year%4!=0) || ($day==29 && $month==2 && $year%4==0))
						{
							$day = 1;
							break;
						}
						else
						{
							$day++;
						}
					}
					else if($month!=$dateEndExplode[1])
					{
						if(($day==30 && in_array($month, array('04','06','09','11'))) || ($day==28 && $month==2 && $year%4!=0) || ($day==29 && $month==2 && $year%4==0))
						{
							$day = 1;
							break;
						}
						else
						{
							$day++;
						}
					}
					else if($day<$dateEndExplode[0])
					{
						$day++;
					}
					else
					{
						break;
					}
				}
				else
				{
					$day = 1;
					break;
				}
			}
			if($month<12)
			{
				if($year!=$dateEndExplode[2])
				{
					$month++;
				}
				else if($month<$dateEndExplode[1])
				{
					$month++;
				}
				else
				{
					break;
				}
			}
			else
			{
				$month = 1;
				break;
			}
		}
		$year++;
	}
	$totalDay = sizeof($visitDay)-1;
	$visitDayMax = max($visitDay);
	$visitDayKeys = $keysDay;
	$totalMonth = sizeof($visitMonth)-1;
	$visitMonthMax = max($visitMonth);
	$visitMonthKeys = $keysMonth;
	$totalYear = sizeof($visitYear)-1;
	$visitYearMax = max($visitYear);
	$visitYearKeys = $keysYear;
	$plotData[0] = $visitDay;
	$totalPlotData[0] = $totalDay;
	$plotDataMax[0] = $visitDayMax;
	$plotDataKeys[0] = $visitDayKeys;
	$plotName[0] = 'graph-1';
	$plotType[0] = 'line';
	$plotScale[0] = 'scale-1';
	$plotXLabel[0] = 'Date';
	$plotYLabel[0] = 'Visits';
	$plotData[1] = $visitMonth;
	$totalPlotData[1] = $totalMonth;
	$plotDataMax[1] = $visitMonthMax;
	$plotDataKeys[1] = $visitMonthKeys;
	$plotName[1] = 'graph-2';
	$plotType[1] = 'bar';
	$plotScale[1] = 'scale-2';
	$plotXLabel[1] = 'Month-Year';
	$plotYLabel[1] = 'Visits';
	$plotData[2] = $visitYear;
	$totalPlotData[2] = $totalYear;
	$plotDataMax[2] = $visitYearMax;
	$plotDataKeys[2] = $visitYearKeys;
	$plotName[2] = 'graph-3';
	$plotType[2] = 'bar';
	$plotScale[2] = 'scale-3';
	$plotXLabel[2] = 'Year';
	$plotYLabel[2] = 'Visits';

	// GEOLOCATION INFO
	$file = fopen("processedSiteVisitor.txt", "r");
	while(!feof($file))
	{
		$line = fgetcsv($file);
		$visitCountry[$line[2]] += 1;
		$visitRegion[$line[4]] += 1;
		$visitCity[$line[5]] += 1;
	}
	$index = 3;
	$plotData[$index] = $visitCountry;
	$totalPlotData[$index] = sizeof($plotData[$index])-1;
	$plotDataMax[$index] = max($plotData[$index]);
	$plotDataKeys[$index] = array_keys($plotData[$index]);
	$plotName[$index] = 'graph-'.($index+1);
	$plotType[$index] = 'bar';
	$plotScale[$index] = 'scale-'.($index+1);
	$plotXLabel[$index] = 'Country';
	$plotYLabel[$index] = 'Visits';

	$index = 4;
	$plotData[$index] = $visitRegion;
	$totalPlotData[$index] = sizeof($plotData[$index])-1;
	$plotDataMax[$index] = max($plotData[$index]);
	$plotDataKeys[$index] = array_keys($plotData[$index]);
	$plotName[$index] = 'graph-'.($index+1);
	$plotType[$index] = 'bar';
	$plotScale[$index] = 'scale-'.($index+1);
	$plotXLabel[$index] = 'Region';
	$plotYLabel[$index] = 'Visits';

	$index = 5;
	$plotData[$index] = $visitCity;
	$totalPlotData[$index] = sizeof($plotData[$index])-1;
	$plotDataMax[$index] = max($plotData[$index]);
	$plotDataKeys[$index] = array_keys($plotData[$index]);
	$plotName[$index] = 'graph-'.($index+1);
	$plotType[$index] = 'bar';
	$plotScale[$index] = 'scale-'.($index+1);
	$plotXLabel[$index] = 'Region';
	$plotYLabel[$index] = 'Visits';

	echo "<script>";
	for($counter = 0; $counter<6; $counter++)
	{
		echo "canvas = document.getElementById('{$plotName[$counter]}');
		ctx = canvas.getContext('2d');
		axisXLengthExtra = 20;
		axisYLengthExtra = 20;
		yMarkerLabelMargin = 10;
		xMarkerLabelMargin = 10;
		xLabelMargin = 20;
		yLabelMargin = 10;
		arrowSize = 6;
		markerLabelColor = '#000';
		markerLabelFontSize = '16px';
		labelSize = 18;
		labelFontSize = labelSize+'px';
		ctx.font = markerLabelFontSize+' Arial';
		maxWidth = 0;";
		for($i=0; $i<$totalPlotData[$counter]; $i++)
		{
			echo
			"if(maxWidth < ctx.measureText('{$plotDataKeys[$counter][$i]}').width)
			{
				maxWidth = ctx.measureText('{$plotDataKeys[$counter][$i]}').width;
			}";
		}
		echo "marginBottom = 20+maxWidth+labelSize+xLabelMargin;
		marginTop = 20;
		marginRight = 20;
		axisLineWidth = 2.5;
		stepX = 40;
		canvas.height = 450;
		height = canvas.height;
		numMarkerX = Math.max({$totalPlotData[$counter]},4);
		stepY = 45;
		numMarkerY = 6;
		canvas.height = marginBottom+marginTop+numMarkerY*stepY+axisYLengthExtra;
		height = canvas.height;";
		// Y-AXIS MARKER LABEL
		echo "maxYMarkerLabelWidth = 0;

		for(x=0; x<numMarkerY; x++)
		{
			if({$plotDataMax[$counter]}*(x+1)/numMarkerY == Math.round({$plotDataMax[$counter]}*(x+1)/numMarkerY))
			{
				text = ({$plotDataMax[$counter]}*(x+1)/numMarkerY).toString();
			}
			else
			{
				text = ({$plotDataMax[$counter]}*(x+1))+'/'+numMarkerY;
			}
			ctx.font = markerLabelFontSize+' Arial';
			if(ctx.measureText(text).width>maxYMarkerLabelWidth)
			{
				maxYMarkerLabelWidth = ctx.measureText(text).width;
			}
		}
		marginLeft = 20+labelSize+maxYMarkerLabelWidth+yMarkerLabelMargin+yLabelMargin;
		canvas.width = (numMarkerX)*stepX+marginLeft+marginRight+axisXLengthExtra;
		width = canvas.width;";
		echo "for(x=0; x<numMarkerY; x++)
		{
			if({$plotDataMax[$counter]}*(x+1)/numMarkerY == Math.round({$plotDataMax[$counter]}*(x+1)/numMarkerY))
			{
				text = ({$plotDataMax[$counter]}*(x+1)/numMarkerY).toString();
			}
			else
			{
				text = ({$plotDataMax[$counter]}*(x+1))+'/'+numMarkerY;
			}
			ctx.fillStyle = markerLabelColor;
			ctx.font = markerLabelFontSize+' Arial';
			ctx.textBaseline = 'middle';
			ctx.textAlign = 'right';
			ctx.fillText(text, marginLeft-xMarkerLabelMargin, height-marginBottom-(x+1)*stepY);
		}";
		echo "if({$plotDataMax[$counter]}/numMarkerY == Math.round({$plotDataMax[$counter]}/numMarkerY))
		{
			scaleY = {$plotDataMax[$counter]}/numMarkerY;
		}
		else
		{
			scaleY = {$plotDataMax[$counter]}+'/'+numMarkerY;
		}
		document.getElementById('{$plotScale[$counter]}').innerHTML += ', Scale Y &#8658 1 unit = ' + scaleY + ' day';
		if({$plotDataMax[$counter]}/numMarkerY>1)
		{
			document.getElementById('{$plotScale[$counter]}').innerHTML += 's';
		}";
		echo "ctx.beginPath();
		// Y-AXIS
		ctx.moveTo(marginLeft, marginTop);
		ctx.lineTo(marginLeft, height-marginBottom);
		// X-AXIS
		ctx.lineTo(width-marginRight, height-marginBottom);
		// Y-AXIS LABEL
		ctx.font = labelFontSize+' Arial';
		ctx.textBaseline = 'middle';
		ctx.textAlign = 'center';
		coordX = xLabelMargin;
		coordY = (marginTop+height-marginBottom)/2;
		ctx.translate(coordX, coordY);
		ctx.rotate(-90*Math.PI/180);
		ctx.fillStyle = markerLabelColor;
		ctx.fillText('{$plotYLabel[$counter]}', 0,0);
		ctx.rotate(+90*Math.PI/180);
		ctx.translate(-coordX, -coordY);";
		// X-AXIS LABEL
		echo "coordX = (marginLeft+width-marginRight)/2;
		coordY = height-xLabelMargin;
		ctx.fillStyle = markerLabelColor;
		ctx.fillText('{$plotXLabel[$counter]}', coordX, coordY);
		// Y-AXIS ARROW
		ctx.moveTo(marginLeft-arrowSize, marginTop+arrowSize);
		ctx.lineTo(marginLeft, marginTop);
		ctx.lineTo(marginLeft+arrowSize, marginTop+arrowSize);";
		// X-AXIS ARROW
		echo "ctx.moveTo(width-marginRight-arrowSize, height-marginBottom-arrowSize);
		ctx.lineTo(width-marginRight, height-marginBottom);
		ctx.lineTo(width-marginRight-arrowSize, height-marginBottom+arrowSize);
		ctx.lineWidth = axisLineWidth;
		ctx.strokeStyle = '#000';
		ctx.stroke();
		ctx.beginPath();
		// X-AXIS GRID
		for(i=0; i<numMarkerX; i++)
		{
			ctx.moveTo(marginLeft+(i+1)*stepX, height-marginBottom-numMarkerY*stepY);
			ctx.lineTo(marginLeft+(i+1)*stepX, height-marginBottom-axisLineWidth/2);
		}
		// Y-AXIS GRID
		for(i=0; i<numMarkerY; i++)
		{
			ctx.moveTo(marginLeft+numMarkerX*stepX, height-marginBottom-(i+1)*stepY);
			ctx.lineTo(marginLeft+axisLineWidth/2, height-marginBottom-(i+1)*stepY);
		}
		ctx.lineWidth = 1;
		ctx.strokeStyle = '#ddd';
		ctx.stroke();";
		echo "canvas = document.getElementById('{$plotName[$counter]}');
		ctx = canvas.getContext('2d');
		ctx.beginPath();";
		if($plotType[$counter] == "line")
		{
			echo "ctx.moveTo(marginLeft, height-marginBottom);";
		}
		else if($plotType[$counter] == "bar")
		{
			echo "ctx.moveTo(marginLeft+axisLineWidth, height-marginBottom-axisLineWidth/2);";
		}
		// PLOTTING DATA
		for($i=0; $i<$totalPlotData[$counter]; $i++)
		{
			echo "ctx.font = markerLabelFontSize+' Arial';
			ctx.fillStyle = markerLabelColor;
			ctx.textBaseline = 'middle';
			ctx.textAlign = 'right';";
			if($plotType[$counter] == "line")
			{
				echo "ctx.lineTo(marginLeft + ($i+1)*stepX, height-marginBottom-{$plotData[$counter][$plotDataKeys[$counter][$i]]}/{$plotDataMax[$counter]}*numMarkerY*stepY);
				ctx.translate(marginLeft + ($i+1)*stepX, height-marginBottom+yMarkerLabelMargin);
				ctx.rotate(-90*Math.PI/180);
				ctx.fillText('{$plotDataKeys[$counter][$i]}', 0,0);
				ctx.rotate(+90*Math.PI/180);
				ctx.translate(-(marginLeft + ($i+1)*stepX), -(height-marginBottom+yMarkerLabelMargin));";
			}
			else if($plotType[$counter] == "bar")
			{
				if($plotData[$counter][$plotDataKeys[$counter][$i]]>0)
				{
					echo "ctx.moveTo(marginLeft +($i)*stepX+axisLineWidth, height-marginBottom-axisLineWidth/2);
					ctx.lineTo(marginLeft + ($i)*stepX+axisLineWidth, height-marginBottom-{$plotData[$counter][$plotDataKeys[$counter][$i]]}/{$plotDataMax[$counter]}*numMarkerY*stepY);
					ctx.lineTo(marginLeft + ($i+1)*stepX, height-marginBottom-{$plotData[$counter][$plotDataKeys[$counter][$i]]}/{$plotDataMax[$counter]}*numMarkerY*stepY);
					ctx.lineTo(marginLeft + ($i+1)*stepX, height-marginBottom-axisLineWidth/2);";
				}
				echo "ctx.translate(marginLeft + ($i+0.5)*stepX, height-marginBottom+yMarkerLabelMargin);
				ctx.rotate(-90*Math.PI/180);
				ctx.fillText('{$plotDataKeys[$counter][$i]}', 0,0);
				ctx.rotate(+90*Math.PI/180);
				ctx.translate(-(marginLeft + ($i+0.5)*stepX), -(height-marginBottom+yMarkerLabelMargin));";
			}
		}
		if($plotType[$counter] == "line")
		{
			echo "ctx.lineWidth = 2;
			ctx.strokeStyle = '#700';
			ctx.stroke();";
		}
		else if($plotType[$counter] == "bar")
		{
			echo "ctx.fillStyle = '#700';
			ctx.fill();
			// REDRAWING AXIS FOR BAR GRAPH
			for(i=0; i<numMarkerX; i++)
			{
				ctx.moveTo(marginLeft+(i+1)*stepX, height-marginBottom-numMarkerY*stepY);
				ctx.lineTo(marginLeft+(i+1)*stepX, height-marginBottom-axisLineWidth/2);
			}
			for(i=0; i<numMarkerY; i++)
			{
				ctx.moveTo(marginLeft+numMarkerX*stepX, height-marginBottom-(i+1)*stepY);
				ctx.lineTo(marginLeft+axisLineWidth/2, height-marginBottom-(i+1)*stepY);
			}
			ctx.lineWidth = 1;
			ctx.strokeStyle = 'rgba(221, 221, 221, 0.4)';
			ctx.stroke();";
		}
	}
	echo "</script>";
?>
#<script>
#	document.getElementById("canvas-1").scrollLeft=document.getElementById("canvas-1").scrollWidth;
#</script>
</body>
</html>
