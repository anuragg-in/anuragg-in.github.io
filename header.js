var x = document.getElementById("header");
var y = '<ul class = "menu-bar">\
  <li class = "dropdown-button-0">\
  <a href = "#" id = "menu-button">Menu</a>\
    <ul class = "dropdown-content-0">\
      <li class = "dropdown-button-1">\
      <a href = "index.html">About</a>\
      </li>\
      <li class = "dropdown-button-1">\
      <a href = "projects.html">Projects</a>\
        <ul class = "dropdown-content-1">';

          var projects = new Array('Shape formation using Kilobots','shape_formation_using_kilobots.html','Shared economy for battery storage','shared_economy_for_battery_storage.html','SVM using log barrier method','svm_log_barrier_method.html', 'Flyback converter','flyback_converter.html', 'Data acquisition system for Epstein tester','daq.html', 'Image stitching for arbitrary camera motion','image_stitching.html', 'Hysteresis loop modeling in grain oriented magnetic material','hysteresis_loop_modeling.html', 'Generalized Hough transform','hough_transform.html', 'Testing of digital circuits using Beaglebone Black','testing_of_digital_circuits.html', 'Pipeline RISC architecture on FPGA','pipeline_risc_architecture.html','More...','projects.html');
          for (i=0; i<projects.length; i=i+2)
          {
            y=y+'<li class = "dropdown-button-2"><a href = "'+projects[i+1]+'">'+projects[i]+'</a></li>';
          }

y=y+'</ul>\
      </li>\
      <li class = "dropdown-button-1">\
      <a href = "files/cv_anuragg.pdf">CV</a>\
      </li>\
      <li class = "dropdown-button-1">\
      <a href = "resources.html">Resources</a>\
      </li>\
      <li class = "dropdown-button-1">\
      <a href = "hobbies.html">Hobbies</a>\
        <ul class = "dropdown-content-1">\
          <li class = "dropdown-button-2">\
            <a href = "photography.html">Photography</a>\
            </li>\
            <li class = "dropdown-button-2 different">\
            <a href = "sketching.html">Sketching</a>\
          </li>\
          <li class = "dropdown-button-2">\
            <a href = "books.html">Reading books</a>\
          </li>\
          <li class = "dropdown-button-2 different">\
            <a href = "#">Musical instruments</a>\
          </li>\
          <li class = "dropdown-button-2">\
            <a href = "coins.html">Collecting coins</a>\
          </li>\
        </ul>\
      </li>\
      <li class = "dropdown-button-1">\
      <a href = "contact.html">Contact</a>\
      </li>\
    </ul>\
  </li>\
</ul>';
x.innerHTML = y;

var x2=document.getElementById('news');
x2.innerHTML = '<div class = "sub-column">\
<div class = "sub-col-1-wrap">\
<div class = "sub-col-1">\
	<div class = "heading">&#10219 Current activities</div>\
	<div class = "text unjustify">\
	<ul>\
		<li><a class="link" href= "https://calendar.google.com/calendar/embed?src=37sg0gj4utv7vbq0lcpi1p28vs%40group.calendar.google.com&ctz=Asia%2FCalcutta">Time table</a></li>\
		<li><a class="link" href="https://www.youtube.com/watch?v=SoDq9GQvNAE&list=PLrLf58z7_B2YXrVVW-VpH9E1gorevFOSn&index=6">Shape formation using Kilobots</a></li>\
	</ul>\
	</div>\
</div></div>\
<div class = "sub-col-2-wrap">\
<div class = "sub-col-2">\
	<div class = "heading">&#10219 Find me</div>\
	<div class = "text unjustify">\
	Location: Lucknow, India<br>\
	Email ID: anuragg.in@gmail.com<br>\
	Homepage: <a href = "http://www.anuragg.in">www.anuragg.in</a><br>\
	</div>\
</div></div>\
</div>';
document.title = 'Anurag Gupta | Electrical and Computer Engineering | Cornell University | Systems and Control Engineering | Electrical Engineering | Indian Insitute of Technology, Bombay';
