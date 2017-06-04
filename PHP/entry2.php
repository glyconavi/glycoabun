<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="index.css" />
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
echo '<h2>Sample name</h2>';
$php_sample = "GlycoAbun_sample.php?id=".$id;
printf("<iframe id=\"myFrame1\" class=\"frame\" src=\"".$php_sample."\"></iframe>");

echo '</br>';

// Protein
echo '<h2>Protein Information</h2>';
$php_protein = "GlycoAbun_protein.php?id=".$id;
printf("<iframe id=\"myFrame2\" class=\"frame\" src=\"".$php_protein."\"></iframe>");

// Glycan
echo '<h2>Glycan Information</h2>';
$php_glycan = "GlycoAbun_glycan.php?id=".$id;
printf("<iframe id=\"myFrame3\" class=\"frame\" src=\"".$php_glycan."\"></iframe>");


?>
</body>
</html>