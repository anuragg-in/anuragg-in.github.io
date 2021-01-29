<?php include "top.php"?>
<div class="image"><img src="/images/anurag.png"></img></div>
<div class="vertical-space"></div>
<hr>
<div class = "title">Anurag Gupta</div><hr>
<!--<div class = "heading">About</div>
<div class = "text">I belong from the city of Lucknow which is nationwide renowned as the city of 'Nawabs'. I enjoy visiting unexplored places manageable on foot. Walking all the way down to Ladakh is one of the challenge on my wager list.</div>-->

<div class = "text">I am currently pursuing my Masters degree from the Department of <a class="link" href="http://www.sc.iitb.ac.in">Systems and Control</a> at <a class="link" href="http://www.iitb.ac.in">Indian Institute of Technology, Bombay</a>.
<div class="vertical-space"></div>
I am an <a class="link" href="https://www.ee.iitb.ac.in/web">Electrical Engineering</a> graduate from <a class="link" href="http://www.iitb.ac.in">Indian Institute of Technology, Bombay</a>. My B.Tech project entitled "Design of flyback converter" was supervised by <a class="link" href="https://www.ee.iitb.ac.in/~mukul/">Prof. Mukul C. Chandorkar</a>. I have Major with Honors in <a class="link" href="https://www.ee.iitb.ac.in/web">Electrical Engineering</a> and Minor in <a class="link" href="http://www.idc.iitb.ac.in/">Industrial Design</a>. My studio project requirement at Industrial Design Centre was guided by <a class="link" href="http://www.idc.iitb.ac.in/sumant/">Prof. Sumant M. Rao</a>. I am also a recipient of <a class="link" href="http://www.iitb.ac.in/newacadhome/urop.jsp">Undergraduate Research Award</a> for my contribution in the field of Computational Electromagnetics.
<div class="vertical-space"></div>
I have collaborated with <a class="link" href="https://www.tcd.ie/research/profiles/?profile=jboland">Prof. John Boland</a> as a summer intern at <a class="link" href="http://www.crann.tcd.ie/">CRANN institute</a>, <a class="link" href="https://www.tcd.ie/">Trinity College, Dublin</a> for the period encompassing May 2015 to July 2015 under <a class="link" href="http://ec.europa.eu/programmes/erasmus-plus/">Erasmus</a> programme. Morever, I was a Research Scientist at <a class="link" href="http://www.systemantics.com/">Systemantics India Pvt. Ltd.</a> for the period beginning from November 2014 to December 2014. My project was supervised by <a class="link" href="https://in.linkedin.com/in/jagannathraju">Dr. Jagannath Raju</a>.</div>
<hr>

<div class="heading">Experience</div>
<div class="text">During October 2016 to March 2017, I worked as a Research and Development Engineer at <a class="link" href="http://www.worksap.com/asean/">Works Application, Singapore</a> wherein I was invloved in developing intelligent ERP (Enterprise Resource Planning) solutions for supply chain management.</div>
<div class="vertical-space"></div>
<div class="text">After 6 months of corporate life, I decided to pursue my own project aimed at innovating an easy to access framework for bicycle pooling inside universities campus and tech parks. While my 10 months as a co-founder of <a class="link" href="http://www.elegane.com">Elegane Bikes</a>, the project received recognitions from Andhra Pradesh government, <a class="link" href="http://www.ficci.in">FICCI</a> and was shortlisted for 4 months startup accelerator program organized by <a class="link" href="http://www.xlr8ap.com/">XLR8AP</a> and <a class="link" href="http://ic2.utexas.edu/">IC2 institute</a>, <a class="link" href="https://www.utexas.edu/">University of Texas, Austin</a>. We were also supported by <a class="link" href="https://www.in2korea.org/">In2Korea</a> and were invited to commercialize our technology in Seoul, South Korea.</div>
<hr>
<!--
<div class = "heading"><a href = "/php/research_interest.php">Research Interest</a></div>
<div class = "text">My research interest lies in the domain of power electronics, microprocessors, embedded systems and digital design. Further, I have worked on projects related to image processing and computer vision for industrial based applications and remote sensing. <a href = "/php/research_interest.php">(Read more...)</a></div>
<div class = "heading"> Parallel World</div>
<div class = "text">In an alternative world, where engineering was not the major focus, I would have chosen either the profession of a musician or a badminton player. My bragging rights includes my ability to play piano, congo, guitar, flute, and harmonica. I am not a professional instrumentalist because I never planned on being one.</div>
-->

<!--
<div class="heading">Scholastic Achievements</div>
<hr>
-->

<div class = "heading"> Hobby</div>
<div class = "text unjustify">
Sports: Badminton, cricket, table tennis.
<br>
Instruments: Piano, guitar, harmonica, flute, congo, dholak.
<br>
Miscellaneous: Collecting outdated coins, reading books, sketching.
</div>
<hr>
<?php include "bottom.php"?>
<?php
#			$siteVisitor = fopen("siteVisitor.txt", "r") or die("Error: 1");
#			$line = "";
#			$lineNumber = 0;
#			while(!feof($siteVisitor))
#			{
#				$line = fgets($siteVisitor);
#				$lineNumber++;
#			}
#			fclose($siteVisitor);
#			echo "Vistor number: $lineNumber";
	$siteVisitor = fopen("siteVisitor.txt", "a") or die("Error: 1");
	fwrite($siteVisitor, date("d-m-Y").",".date("H:i:s").",".$_SERVER["REMOTE_ADDR"].",".$_SERVER["REMOTE_PORT"].",".$_SERVER["HTTP_REFERER"].",".$_SERVER["HTTP_USER_AGENT"]."\n");
	fclose($siteVisitor);
	$siteVisitor = fopen("siteVisitorNew.txt", "a") or die("Error: 1");
	fwrite($siteVisitor, date("d-m-Y").",".date("H:i:s").",".$_SERVER["REMOTE_ADDR"].",".$_SERVER["REMOTE_PORT"].",".$_SERVER["HTTP_REFERER"].",".$_SERVER["HTTP_USER_AGENT"]."\n");
	fclose($siteVisitor);
?>
