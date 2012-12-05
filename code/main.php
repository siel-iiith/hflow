<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<style>
#jList li {float: left; margin-right: 10px; margin-left: 10px; padding: 5px;
}
</style>

<title>Hadoop Visual Workflows</title>
<link href="style_bak.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.min.js"></script>
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>
<!--<script type="text/javascript" src="js/jquery.jcarousel.min2.js"></script>
<script type="text/javascript" src="js/jquery.jcarousel.min3.js"></script>-->
<link rel="stylesheet" type="text/css" href="slide.css" />




<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
    	wrap: 'circular'
    });
});
</script>
<!--
<script>
	$(document).ready(function(){
	$("#box1").click(function(){
	$("#wrap").animate({width:'toggle'});
				    });
   });
</script>
-->
<!--
<style type="text/css"> 
	#panel,#flip
	{
		float:left;
		width:15px;
		padding:5px;
		text-align:center;
		background-color:#e5eecc;
		border:solid 1px #c3c3c3;
	}
	#panel
	{
		padding:50px;
		/*overflow : hidden;*/
		display:none;
	}
</style>
-->
<style type="text/css"> 
/*
#panel,#flip
{
float:left;
width:15px;
padding:5px;
text-align:center;
background-color:#e5eecc;
border:solid 1px #c3c3c3;      
}
#panel
{
padding:50px;
	overflow : hidden;
	display:none;
*/
</style>



</head>


<script> 
var listcnt = 0 ;
var joblist = new Array() ;
function addToList(data, cnt) {
	//      alert(cnt) ;
	joblist.push(data) ;
	tmp = "" ;
	for (i =0 ; i < listcnt ; i++) {
		tmp1= '<li><h3 style="color:#ffffff">' + joblist[i] +'</h3><br /><img src="images/arrow.png" width="100" height="100" /></li>';
		tmp += tmp1 ;
	}
	document.getElementById('jList').innerHTML = tmp ;
}
function selected(item) {
	alert($(item).attr("id")) ;
}
function allowedDrop(ev) {
	ev.preventDefault() ;
}
function drag(ev) {
	ev.dataTransfer.setData("Text", ev.target.id) ;
}
function drop(ev, cnt) {
	ev.preventDefault() ;
	var data=ev.dataTransfer.getData("Text") ;
	addToList(data, cnt) ;
	//      ev.target.appendChild(document.getElementById(data)) ; 
}
function drag_start(ev) {
	ev.dataTransfer.dropEffect="move" ;
	ev.dataTransfer.setData("Text", ev.target.id) ;
}
function delJobFn(){
	joblist.pop() ;
	if ( listcnt ==0) {
		return ;
	}
	tmp = "" ;
	listcnt-- ;
	for (i =0 ; i < listcnt ; i++) {
		tmp1= '<li><h3 style="color:#ffffff">'+ joblist[i] +'</h3><br /><img src="images/arrow.png" width="100" height="100" /></li>';
		tmp += tmp1 ;
	}
	document.getElementById('jList').innerHTML = tmp  ;
}

function playFn() {
	var list = document.getElementById('jList').innerHTML ;
	var tmp = list.split('<li><h3 style="color:#ffffff">') ;
	var sendJb = '<div style="color:#ffffff"><pre><xmp>' ; 
	for (var x = 1; x < tmp.length ; x++) 
	{
		var tmp1 = tmp[x].split("<") ;
		tmp1 = tmp1[0].split("/");
		tmp1 = tmp1[1].split(".");
		tmp[x] = tmp1[0];
		sendJb += tmp[x]+' ';
	}
	sendJb += '\n<workflow-app name="my_map-reduce" xmlns="uri:oozie:workflow:0.1">\n';
	sendJb += '\t<action name="' + tmp[1] + '">\n' + 
		'\t<map-reduce>\n' +
		'\t\t<job-tracker>foo:9001</job-tracker>\n' + 
		'\t\t<name-node>bar:9000</name-node>\n' + 
		'\t\t\t<configuration>\n' +
		'\t\t\t\t<property>\n' +
		'\t\t\t\t\t<name>mapred.mapper.class</name>\n' +
		'\t\t\t\t\t<value>org.apache.oozie.example.' + tmp[1] + '</value>\n' +
		'\t\t\t\t<property>\n' +
		'\t\t\t\t\t<name>mapred.input.dir</name>\n' +
		'\t\t\t\t\t<value>' + '/note' + '</value>\n' +
		'\t\t\t\t</property>\n' +
		'\t\t\t\t<property>\n' +
		'\t\t\t\t\t<name>mapred.output.dir</name>\n' +
		'\t\t\t\t\t<value>' + '/out/out1' +  '</value>\n' +
		'\t\t\t\t</property>\n' +
		'\t\t\t</configuration>\n' +
		'\t</map-reduce>\n' ;
		if(tmp.length - 1 < 2)
		{
			sendJb += '\n<ok to="end"/>\n\t<error to="fail"/>\n';
		}
		else
		{
			sendJb += '\n\t<ok to=' +tmp[2]+ '"/>\n\t<error to="fail"/>\n'; 
		}
		sendJb+= '\t</action>\n';
	var next,prev;
	for(var r=2;r<tmp.length;r++)
	{
		next = r+1;
		prev = r-1;
		sendJb += '\t<action name="' + tmp[r] + '">\n' + 
		'\t<map-reduce>\n' +
		'\t\t<job-tracker>foo:9001</job-tracker>\n' + 
		'\t\t<name-node>bar:9000</name-node>\n' + 
		'\t\t\t<configuration>\n' +
		'\t\t\t\t<property>\n' +
		'\t\t\t\t\t<name>mapred.mapper.class</name>\n' +
		'\t\t\t\t\t<value>org.apache.oozie.example.' + tmp[r] + '</value>\n' +
		'\t\t\t\t<property>\n' +
		'\t\t\t\t\t<name>mapred.input.dir</name>\n' +
		'\t\t\t\t\t<value>' + '/out/out' + prev + '/part-00000</value>\n' +
		'\t\t\t\t</property>\n' +
		'\t\t\t\t<property>\n' +
		'\t\t\t\t\t<name>mapred.output.dir</name>\n' +
		'\t\t\t\t\t<value>' + '/out/out' +r+  '</value>\n' +
		'\t\t\t\t</property>\n' +
		'\t\t\t</configuration>\n' +
		'\t</map-reduce>\n' ;
		if(next==tmp.length)
		{
			sendJb += '\n\t<ok to="end"/>\n\t<error to="fail"/>\n';
		}
		else
		{
			sendJb += '\n\t<ok to=' +tmp[next]+ '"/>\n\t<error to="fail"/>\n'; 
		}
		sendJb+= '\t</action>\n';
	}
	sendJb += '\t<kill name="fail">\n\t<message>Some error in execution</message>\n</kill>'+
		'\t<end name="end"/>';
	sendJb += '\n</workflow-app>';
	sendJb += '</xmp></pre></div>' ;
	document.getElementById("oozie-xml").innerHTML = sendJb ;
}


function playTest() {
	var list = document.getElementById("jList").innerHTML ;
	var tmp = list.split('<li><h3 style="color:#ffffff">') ;
	var jobar = new Array() ;
	var sendJob = "" ; 
	for (var i = 1; i < tmp.length ; i++) {
		var tmp1 = tmp[i].split("<") ;
		jobar.push(tmp1[0]) ; 
		sendJob += tmp1[0] ; 
		sendJob += " " ;
	}
	alert("Job Started") ;
	var xmlhttp = new XMLHttpRequest ();
	xmlhttp.open("GET" , "job.php?job=" + sendJob , false ) ; 
	xmlhttp.send() ;
}



</script>




<body>
	<div id = "header">
		<div id="page">
			<h1 style = "color:#ffffff"> HADOOP VISUAL WORKFLOW </h1>
		</div>
	</div>
	<div id = "box1">

	</div>
<? $homeDir = "http://localhost/cloud/" ;?>
<div id="wrap" >

  <ul id="mycarousel" class="jcarousel-skin-tango" style="margin-top : 10px;">
  <?php 
  $tmp = file_get_contents($homeDir . "maps") ;
  $redcount = preg_match_all('/<td><a href="([^"]+)">[^<]*<\/a><\/td>/i', $tmp ,  $redList) ;
  for($i = 1; $i < $redcount ; ++$i){
	  	?><li><img src="images/M.jpeg" width="75" height="75" id="maps/<?echo $redList[1][$i];?>"  draggable="true" ondragstart="drag_start(event)"/></li><li> <p style="border:solid 0.2px "> <?
					echo $redList[1][$i] ;
			?></p></li><?
  }


?>
<?php 
  $tmp = file_get_contents($homeDir . "reds") ;
  $redcount = preg_match_all('/<td><a href="([^"]+)">[^<]*<\/a><\/td>/i', $tmp ,  $redList) ;
  for($i = 1; $i < $redcount ; ++$i){
	  	?><li><img src="images/R.jpeg" width="75" height="75" id="reds/<?echo $redList[1][$i];?>"  draggable="true" ondragstart="drag_start(event)"/> </li><li><p style="border:solid 0.2px "><?
					echo $redList[1][$i] ;
			?></p></li><?
  }


?>
<?php 
  $tmp = file_get_contents($homeDir . "mapred") ;
  $redcount = preg_match_all('/<td><a href="([^"]+)">[^<]*<\/a><\/td>/i', $tmp ,  $redList) ;
  for($i = 1; $i < $redcount ; ++$i){
	  	?><li><img src="images/complete.png" width="75" height="75" id="mapred/<?echo $redList[1][$i];?>"  draggable="true" ondragstart="drag_start(event)"/> </li><li><?
					echo $redList[1][$i] ;
			?></li><?
  }


?>


  </ul>


</div>
<div id="middle" style ="height:200px;width:100%">
	<div id = "input_form" style = "color:#ffffff;width:450px;float:left;margin-left:100px;margin-top:40px">
	<h3> Please Enter the JAR FILE here </h3>
	<div id ="form_image" style="margin-top:2px; ">
		<form name="input" action="http://localhost/cloud/submit.php" method="post" enctype="multipart/form-data">
		<input type="radio" name="dir" value="maps" >Map<br>
		<input type="radio" name="dir" value="reds">Reduce<br>
		<input type="radio" name="dir" value="mapreds" checked="checked" >Map-Reduce<br>
		<input type="file" name="file" id="file"/>
		<input type="submit" value="Submit">
		</form>
	</div>
</div>

<div id = "basket1" style = "width:200px;float:left;margin-top:10px;margin-left:50px">
<img id="basket"  src="images/dropcrop3.png" width="190" height="190" ondragover="allowedDrop(event)" ondrop="drop(event, listcnt++) "  >
</div>
</div>

<div id = "list_code" style = "width:100%;height:200px">
	
	<ul id="jList" ></ul><br /><br /><br />

</div>

<div id = "functions_play" style ="margin-top:10px;margin-left:550px">
<button id="delJobs" onclick="delJobFn()" > <img src="images/delete.jpg" height="100" width="100" />  </button> 
<button id="play" onclick="playFn()" > <img src="images/xml.png" height="100" width="100" /></button>
<button id="play" onclick="playTest()" > <img src="images/play.png" height="100" width="100" /></button>
</div>

<br /><br /><div id="oozie-xml" ></div>




</body>
</html>
