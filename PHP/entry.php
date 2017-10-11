<?php
include("../head.php");
?>

<body>
<div class="green-bord"><img src="http://www.glyconavi.org/logo/GlycoNAVI.png"><h1>GlycoAbun</h1></div>
<?php
//header('Content-Type: text/plain;charset=UTF-8');
mb_internal_encoding("UTF-8");
ini_set('auto_detect_line_endings', 1);
ini_set('auto_detect_line_endings', 1);
date_default_timezone_set('Asia/Tokyo');
$timeHeader = date("Y-m-d_H-i-s");

$id="RC_1";
if(isset($_REQUEST['id'])) {
    if ($_REQUEST["id"] != "") {
        $id = trim($_REQUEST["id"]);
    }
}

?>
<div><h2><?php echo "Entry ID: GlycoNAVI:".$id; ?></h2></div>
<?php
$spqrqldata = "http://rdf.glyconavi.org:8890/sparql?default-graph-uri=&query=PREFIX+rdf%3A+%3Chttp%3A%2F%2Fwww.w3.org%2F1999%2F02%2F22-rdf-syntax-ns%23%3E%0D%0APREFIX+rdfs%3A+%3Chttp%3A%2F%2Fwww.w3.org%2F2000%2F01%2Frdf-schema%23%3E%0D%0APREFIX+dcterms%3A+%3Chttp%3A%2F%2Fpurl.org%2Fdc%2Fterms%2F%3E%0D%0APREFIX+glycan%3A+%3Chttp%3A%2F%2Fpurl.jp%2Fbio%2F12%2Fglyco%2Fglycan%23%3E%0D%0APREFIX+sio%3A+%3Chttp%3A%2F%2Fsemanticscience.org%2Fresource%2F%3E%0D%0APREFIX+gs%3A+%3Chttp%3A%2F%2Fglyconavi.org%2Fglycosample%2F%3E%0D%0APREFIX+ga%3A+%3Chttp%3A%2F%2Fglyconavi.org%2Fglyabun%2F%3E%0D%0APREFIX+exterms%3A+%3Chttp%3A%2F%2Fwww.example.org%2Fterms%2F%3E%0D%0APREFIX+chebi%3A+%3Chttp%3A%2F%2Fbio2rdf.org%2Fchebi%3A%3E%0D%0APREFIX+faldo%3A+%3Chttp%3A%2F%2Fbiohackathon.org%2Fresource%2Ffaldo%23%3E%0D%0APREFIX+up%3A+%3Chttp%3A%2F%2Fpurl.uniprot.org%2Fcore%2F%3E%0D%0A%0D%0ASELECT+%3Fgs_id%0D%0AFROM+%3Chttp%3A%2F%2Fglyconavi.org%2Fdatabase%2Fglycoabun%3E%0D%0AWHERE+%7B%0D%0A%0D%0A%23+glycosample%0D%0A%3Fgs+gs%3Aglycosample_id+%3Fgs_id+.%0D%0A%3Fgs+glycan%3Ahas_resource_entry+%3Fbr+.%0D%0A%0D%0A%23+%3Fbr%3A+bioresource%0D%0A%3Fbr+sio%3Ahas-component-part+%3Frc+.%0D%0A%3Frc+ga%3Aid+%3Frc_id+.%0D%0AVALUES+%3Frc_id+%7B+%22".$id."%22+%7D%0D%0A%0D%0A%7D&should-sponge=&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on";
$getdata = file_get_contents($spqrqldata);

$json = mb_convert_encoding($getdata, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$arr = json_decode($json,true);
if ($arr === NULL) {
    return;
}
else{
    $resarray = array();
    $arr = $arr["results"]["bindings"];
    foreach ($arr as $ressouce) {
        $GSID = $ressouce["gs_id"]["value"];
        //echo "GSID:".$GSID."<br>";
        break;
    }
}

// http://bio.glyconavi.org/GlycoSample/GlycoSample-json-table.php?id=GS_3
$url = "../GlycoSample/entry.php?id=".$GSID;

?>

<div class="green-bord-black"><h2>Sample Information</h2></div>
<?php

echo '<h3><a href="'.$url.'" target="_blank" >see GlycoSample entry (GlycoNAVI:'.$GSID.')</a></h3>';



$protein_sparql = "http://rdf.glyconavi.org:8890/sparql?default-graph-uri=&query=PREFIX+rdf%3A+%3Chttp%3A%2F%2Fwww.w3.org%2F1999%2F02%2F22-rdf-syntax-ns%23%3E%0D%0APREFIX+rdfs%3A+%3Chttp%3A%2F%2Fwww.w3.org%2F2000%2F01%2Frdf-schema%23%3E%0D%0APREFIX+dcterms%3A+%3Chttp%3A%2F%2Fpurl.org%2Fdc%2Fterms%2F%3E%0D%0APREFIX+glycan%3A+%3Chttp%3A%2F%2Fpurl.jp%2Fbio%2F12%2Fglyco%2Fglycan%23%3E%0D%0APREFIX+sio%3A+%3Chttp%3A%2F%2Fsemanticscience.org%2Fresource%2F%3E%0D%0APREFIX+gs%3A+%3Chttp%3A%2F%2Fglyconavi.org%2Fglycosample%2F%3E%0D%0APREFIX+ga%3A+%3Chttp%3A%2F%2Fglyconavi.org%2Fglyabun%2F%3E%0D%0APREFIX+exterms%3A+%3Chttp%3A%2F%2Fwww.example.org%2Fterms%2F%3E%0D%0APREFIX+chebi%3A+%3Chttp%3A%2F%2Fbio2rdf.org%2Fchebi%3A%3E%0D%0APREFIX+faldo%3A+%3Chttp%3A%2F%2Fbiohackathon.org%2Fresource%2Ffaldo%23%3E%0D%0APREFIX+up%3A+%3Chttp%3A%2F%2Fpurl.uniprot.org%2Fcore%2F%3E%0D%0A%0D%0ASELECT+%3Famino_acid_length+%3Fprotein_sequence+%3Funiprot_id%0D%0AFROM+%3Chttp%3A%2F%2Fglyconavi.org%2Fdatabase%2Fglycoabun%3E%0D%0AWHERE+%7B%0D%0A%0D%0A%23+glycosample%0D%0A%3Fgs+gs%3Aglycosample_id+%3Fgs_id+.%0D%0A%3Fgs+glycan%3Ahas_resource_entry+%3Fbr+.%0D%0A%0D%0A%23+%3Fbr%3A+bioresource%0D%0A%3Fbr+sio%3Ahas-component-part+%3Frc+.%0D%0A%3Frc+ga%3Aid+%3Frc_id+.%0D%0AVALUES+%3Frc_id+%7B+%22".$id."%22%7D%0D%0A%0D%0A%23+resource+component%0D%0A%3Frc+sio%3Ahas-component-part+%3Fpc+.%0D%0A%3Fpc+ga%3Aaa_sequence+%3Fprotein_sequence+.%0D%0A%3Fpc+ga%3Aaa_length+%3Famino_acid_length+.%0D%0A%3Fpc+chebi%3A32854+%3Funiprot+.%0D%0A%3Funiprot+rdf%3Atype+up%3AProtein+.%0D%0A%3Fpc+dcterms%3Aidentifier+%3Funiprot_id+.%0D%0A%0D%0A%7D&should-sponge=&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on";
$getdata = file_get_contents($protein_sparql);

$json = mb_convert_encoding($getdata, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$arr = json_decode($json,true);
if ($arr === NULL) {
    return;
}
else{
    $resarray = array();
    $arr = $arr["results"]["bindings"];
    foreach ($arr as $ressouce) {
        $AASEQ = $ressouce["protein_sequence"]["value"];
        //echo "GSID:".$GSID."<br>";
        break;
    }
}
if ($arr != NULL) {
?>
<div class="green-bord-black"><h2>Protein Information</h2></div>
<?php

// http://bio.glyconavi.org/GlycoAbun/GlycoAbun_protein-name_table.php?id=RC_1
$url = "./GlycoAbun_protein-name_table.php?id=".$id;
printf("<div>");
printf("<iframe id=\"protein-name-iframe\" class=\"proteinNameFrame\" src=\"".$url."\" width=\"1300\" height=\"250\"></iframe>");
printf("</div>");
printf("<SCRIPT>jQuery('iframe.proteinFrame').iframeAutoHeight();</SCRIPT>");

// http://bio.glyconavi.org/GlycoAbun/GlycoAbun_protein_table.php?id=RC_1
$url = "./GlycoAbun_protein_table.php?id=".$id;
printf("<div>");
printf("<iframe id=\"protein-iframe\" class=\"proteinFrame\" src=\"".$url."\" width=\"1300\" height=\"250\"></iframe>");
printf("</div>");
printf("<SCRIPT>jQuery('iframe.proteinFrame').iframeAutoHeight();</SCRIPT>");

}
?>

<hr>
<div class="green-bord-black"><h2>Glycan Information</h2></div>
<?php

$url = "./GlycoAbun_glycan_table.php?id=".$id;
printf("<div>");
printf("<iframe ID=\"parent-iframe\" width=\"1300\" class=\"glycanframe\" src=\"".$url."\"></iframe>");
printf("</div>");
printf("<SCRIPT>jQuery('iframe.glycanframe').iframeAutoHeight();</SCRIPT>");

include("../footer.php");
?>
