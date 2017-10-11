<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="index.css" />

<style type="text/css">
table.TwoWayBack {
	border-collapse: collapse;
	text-align: left;
	line-height: 1.5;
	border-top: 1px solid #ccc;
	border-bottom: 1px solid #ccc;
}
table.TwoWayBack thead th {
	width: 150px;
	padding: 10px;
	font-weight: bold;
	vertical-align: top;
	color: #fff;
	background: #04162e;
}
table.TwoWayBack td {
	width: 350px;
	padding: 10px;
	vertical-align: middle;
	text-align: center;
}
table.TwoWayBack .even {
	background: #f3f6f7;
}
table.TwoWayBack img {
	width:300px;
}

body h1, h2, h3, h4, iframe, footer {
	text-align: center;
}


iframe {
	border: 1px darkgreen solid;
}

.green-bord {
	background-color: #bde9ba;
	color: #008000;
}
</style>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<script type="text/javascript">
function adjust_frame_css(F){
  if(document.getElementById(F)) {
	var myF = document.getElementById(F);
	var myC = myF.contentWindow.document.documentElement;
	var myH = 100;
    if(document.all) {
      myH  = myC.scrollHeight;
    } else {
      myH = myC.offsetHeight;
    }
    myF.style.height = myH+"px";
  }
}
</script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#parent-iframe", window.parent.document).height(document.body.scrollHeight);
});
</script> 

<title>GlycoNAVI:GlycoAbun</title>
</head>
<?php


?>