<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
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
<title>GlycoNAVI:GlycoAbun</title>
</head>
<body>
<h1>GlycoNAVI: GlycoAbun</h1>
<?php
//header('Content-Type: text/plain;charset=UTF-8');
mb_internal_encoding("UTF-8");
ini_set('auto_detect_line_endings', 1);
ini_set('auto_detect_line_endings', 1);
date_default_timezone_set('Asia/Tokyo');
$timeHeader = date("Y-m-d_H-i-s");

//<!-- get ID -->
$id="RC_1";
if(isset($_REQUEST['id'])) {
    if ($_REQUEST["id"] != "") {
        $id = trim($_REQUEST["id"]);
    }
}



// Sample name
$php_sample = "GlycoAbun_sample.php?id=".$id;
printf("<iframe  id=\"newsframe\"
    onLoad=\"adjust_frame_css(this.id)\"
    style=\"border: 0; width: 420px; height: 100px; margin:0; padding: 0;\"
    scrolling=\"no\"
    frameborder=\"no\"
    src=\"".$php_sample."\"></iframe>");

echo '</br>';

// Protein
$php_protein = "GlycoAbun_protein.php?id=".$id;
printf("<iframe  id=\"newsframe\"
    onLoad=\"adjust_frame_css(this.id)\"
    style=\"border: 0; width: 420px; height: 100px; margin:0; padding: 0;\"
    scrolling=\"no\"
    frameborder=\"no\"
    src=\"".$php_protein."\"></iframe>");



?>
</body>
</html>